<?php

namespace App\Http\Controllers\student_login;
use App\Models\User;
use App\Models\State;
use App\Models\fees\FeesAssign;
use App\Models\FeesCollect;
use App\Models\Admission;
use App\Models\Master\Branch;
use App\Models\Master\Homework;
use Illuminate\Validation\Validator; 
use App\Models\Master\PaymentMode;
use App\Models\FeesDetail;
use App\Models\fees\FeesDetailsInvoices;
use App\Models\fees\FeesAssignDetail;
use App\Models\BillCounter;
use App\Models\Setting;
use App\Models\Sessions;
use App\Models\Master\MessageTemplate;
use App\Models\Master\MessageType;
use App\Services\NotificationService;
use Session;
use Hash;
use Str;
use PDF;
use Redirect;
use Response;
use Auth;
use Helper;
use Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesController extends Controller
{
    public function __construct(private NotificationService $notif) {}


               public function feesHistory(Request $request)
                   {
                  
                        $admission_id = Session::get('id');
                        $currentAdmission = Admission::find($admission_id);
                    
                        if (!$currentAdmission) {
                            return back()->withErrors(['error' => 'Admission record not found.']);
                        }
                    $ActiveSession_id = $request->session_id ?? Session::get('session_id');
                        $admissions = Admission::where('unique_system_id', $currentAdmission->unique_system_id)
                            ->get(['id', 'unique_system_id', 'session_id']);
                        $filteredAdmission = $admissions->Where('session_id',$ActiveSession_id)->first();
                                               // dd($filteredAdmission);
                        $getFees='';
                        $getPaidFees='';
                        if (!empty($filteredAdmission)) {
                             $getFees = FeesAssignDetail::select('fees_assign_details.*', 'fees_group.name as group_name')
                            ->join('fees_group', 'fees_group.id', '=', 'fees_assign_details.fees_group_id')
                            ->where('admission_id', $filteredAdmission->id)
                            ->get();
                    
                        $getPaidFees = FeesDetailsInvoices::select('fees_details_invoices.*', 'payment_modes.name as payment_mode')
                            ->join('payment_modes', 'payment_modes.id', '=', 'fees_details_invoices.payment_mode')
                            ->whereIn('status', [0, 1])
                            ->where('admission_id', $filteredAdmission->id)
                            ->get();
                        }
                    
                        $feesDetailInvoice =  FeesDetailsInvoices::select('fees_details_invoices.*')
                         ->where('fees_details_invoices.session_id', Session::get('session_id'))
                         ->where('fees_details_invoices.branch_id', Session::get('branch_id'))
                         ->where('fees_details_invoices.status', 1)
                         ->where('fees_details_invoices.admission_id', Session::get('id'))->get();
                       
                        $Sessions_id = Admission::where('unique_system_id', $currentAdmission->unique_system_id)->pluck('session_id'); 
                        $sessions = Sessions::whereIn('id', $Sessions_id)->orderBy('id', 'ASC')->get();

                        $BillCounter = BillCounter::where('session_id', Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('type','FeesSlip')->get()->first();

                        $paymentStatusPending = $feesDetailInvoice->count();
                        if($feesDetailInvoice){
                            foreach($feesDetailInvoice as $incompletePayment){
                                if($incompletePayment->payment_mode == 6){
                                    return redirect::to('payUCancel/' . $incompletePayment->id);
                                }
                            }
                        }
                      
                        return view('dashboard.student.fees.fees_history', [
                            'getFees' => $getFees,
                            'getPaidFees' => $getPaidFees,
                            'sessions' => $sessions,
                            'ActiveSession_id' => $ActiveSession_id,
                            'BillCounter' => $BillCounter,
                            'paymentStatusPending' => $paymentStatusPending,
                        ]);
                 }

                 
                 public function fees_check(Request $request)
                 {
                     // Get the current admission ID from the session
                     $admission_id = Session::get('id');
                 
                     // Retrieve admission details
                     $currentAdmission = Admission::find($admission_id);
                 
                     // Fetch assigned fees details for the student
                     $getAssign = FeesAssignDetail::select('fees_assign_details.*', 'fees_group.name as group_name', 'fees_group.id as group_id', 'fees_group.fees_partial as partial_fees')
                         ->join('fees_group', 'fees_group.id', '=', 'fees_assign_details.fees_group_id')
                         ->where('admission_id', $admission_id)
                         ->get();
                 
	                     // Current payment made by the student
	                     $courentPayFees = $request->amount;
	                     $hasPendingApproval = FeesDetail::where('admission_id', $admission_id)
	                         ->where('status', 1)
	                         ->whereIn('fees_group_id', $getAssign->pluck('fees_group_id'))
	                         ->exists();
	                 
	                     // Initialize the HTML table structure
	                     $html = '<table class="table">
	                         <thead>
	                             <tr class="sky_tr">
	                                 <th>Fees Type</th>
	                                
	                                 <th>Amount</th>
	                                 <th>Paid</th>
	                                 ' . ($hasPendingApproval ? '<th>Pending Approval</th>' : '') . '
	                                 <th>Balance</th>
	                                 <th>Status</th>
                             </tr>
                         </thead>
                         <tbody>';
                        // <th>Due Date</th>
                  //  <th>Fine</th>
	                     $total_paid = 0; 
	                     $total_pending = 0; 
	                     $total_pending_approval = 0;
                 
                     foreach ($getAssign as $head) {
                         $paidFees = FeesDetail::where('admission_id', $admission_id)
                             ->where('fees_group_id', $head->fees_group_id)
                             ->where('status', 0)
                             ->sum('total_amount');

                         $pendingApprovalFees = FeesDetail::where('admission_id', $admission_id)
                             ->where('fees_group_id', $head->fees_group_id)
                             ->where('status', 1)
                             ->sum('total_amount');
                         $total_pending_approval += $pendingApprovalFees;
	                 
                         $remainingAmount = (($head->fees_group_amount ?? 0) - ($head->discount ?? 0)) - ($paidFees ?? 0);
	                 
                         $fine = 0;
                         if (!empty($head->installment_due_date) && $head->installment_due_date < date('Y-m-d')) {
                             $fine = $remainingAmount * $head->installment_fine / 100;
                             $remainingAmount += $fine;
                         }

                         $payableAmount = max($remainingAmount - ($pendingApprovalFees ?? 0), 0);
                         $feeStatus = $pendingApprovalFees > 0 ? 'Pending Approval' : ($remainingAmount > 0 ? 'Unpaid' : 'Paid');

                         
                 
                         

                         if ($remainingAmount > 0) {
                             $pay = ($courentPayFees > $payableAmount) ? $payableAmount : $courentPayFees;
                            
                            
                            if (!empty($head->partial_fees) && $head->partial_fees == 1) {
                                if($pay == $head->fees_group_amount){
                                    $partial = ' &nbsp; <input type="checkbox" class="pointer partial_checkbox" style="width:17px; height:17px" id="partial_' . ($head->group_id ?? '') . '" data-pay="' . ($pay ?? '0') . '" data-id="' . ($head->group_id ?? '') . '"> <label for="partial_' . ($head->group_id ?? '') . '" class="pointer">Pay Partial (50%)</label>';
                                }else{
                                    $partial = '';
                                }
                                
                            }else{
                                $partial = '';
                            }

	                             if ($pay > 0) {
	                                 $html .= '<tr>
	                                     <td>' . ($head->group_name ?? '') . $partial . ' <input type="hidden" class="" name="selected_head[]" value="'. ($head->group_id ?? '0') .'" readonly>  <input type="hidden" id="selected_head_amount_' . ($head->group_id ?? '') . '" class="" name="selected_head_amount[]" value="'. ($pay ?? '0') .'" readonly></td>
	                                     <td>' . ($head->fees_group_amount ?? '0') . '</td>
	                                     <td>' . ($paidFees ?? '0') . '</td>
	                                     ' . ($hasPendingApproval ? '<td>' . ($pendingApprovalFees ?? '0') . '</td>' : '') . '
	                                     <td><span id="payable_partial_' . ($head->group_id ?? '') . '" ><span class="main-amount">' . ($pay + $pendingApprovalFees) . '</span></span></td>
	                                     <td>' . $feeStatus . '</td>
	                                 </tr>';
                               //  <td>' . (!empty($head->installment_due_date) ? date('d-M-Y', strtotime($head->installment_due_date)) : '') . '</td>
                                 //<td>' . ($fine ?? '0') . '</td>
                                 $total_paid += $pay;
                 
	                                 $courentPayFees -= $pay;
	                 
	                                 $total_pending += $remainingAmount;
	                             } elseif ($pendingApprovalFees > 0) {
	                                 $html .= '<tr>
	                                     <td>' . ($head->group_name ?? '') . '</td>
	                                     <td>' . ($head->fees_group_amount ?? '0') . '</td>
	                                     <td>' . ($paidFees ?? '0') . '</td>
	                                     ' . ($hasPendingApproval ? '<td>' . ($pendingApprovalFees ?? '0') . '</td>' : '') . '
	                                     <td>' . $pendingApprovalFees . '</td>
	                                     <td>' . $feeStatus . '</td>
	                                 </tr>';
	                             }
	                         }
	                     }
                 
                     if ($total_pending_approval > 0) {
                         $html .= '<tr>
                             <td colspan="' . ($hasPendingApproval ? 5 : 4) . '" style="text-align:right; font-weight:bold; color:#fd7e14;">Total Pending Approval:</td>
                             <td style="font-weight:bold; color:#fd7e14;">' . $total_pending_approval . '</td>
                         </tr>';
                     }
	                     // Add a summary row for total paid amount
		                     $html .= '<tr>
		                         <td colspan="' . ($hasPendingApproval ? 5 : 4) . '" style="text-align:right; font-weight:bold;">Total Payable:</td>
                         <td style="font-weight:bold;"><span id="total_payable">' . ($total_paid + $total_pending_approval) . '</span> <span id="total_payable_text"></span></td>
                     </tr>';
                 
                     // Close the table HTML
                     $html .= '</tbody></table>';
                
                     // Return JSON response with the generated HTML
                     return response()->json([
	                         'status' => 'success',
	                         'data' => $html,
	                         'remaining' => $total_paid > 0 ? $total_paid : $total_pending_approval,
	                         'payable' => $total_paid,
	                         'pending_approval' => $total_pending_approval,
	                     ]);
                 }
                 
                 
                public function studentSidePaySubmit(Request $request){
             
                    $transactionStarted = false;
                    try {
                        $cheque_image = '';
                        $session_id = $request->session_id ?? Session::get('session_id');
                        $FeesAssign = FeesAssign::where('admission_id',$request->admission_id)->get()->first();
                        $fees_details_invoice_id = '';
                        $fees_details_id =[];
                        $slip = "";

                        if ($request->isMethod('post')) {
                            
                            $admission_id = $request->admission_id;
                            $admission = Admission::where('id',$admission_id)->first();
                      
                            if (!empty($admission_id)) {
                                if (!empty($request->selected_head)) {

                                    DB::beginTransaction();
                                    $transactionStarted = true;

                                    $BillCounter = BillCounter::where('session_id',$session_id)->where('branch_id',Session::get('branch_id'))->where('type', 'FeesSlip')->lockForUpdate()->first();
                                    if (empty($BillCounter)) {
                                        throw new \Exception('Fees slip counter not found.');
                                    }

                                    $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0;
                                    $BillCounter->counter = $counter + 1;
                                    $BillCounter->save();
                                    foreach($request->selected_head as $key=> $head){
                                        if( ((int)$request->selected_head_amount[$key]) != 0){
                                            $payOld = FeesCollect::where('admission_id',$admission_id)->first();
                                            if(!empty($payOld)){
                                                $pay = $payOld;
                                                $amount = FeesCollect::where('admission_id', $admission_id)->increment('amount', $request->selected_head_amount[$key] ?? 0);
                                                $payDetail = new FeesDetail; //model name
                                                $payDetail->user_id = Session::get('id');
                                                $payDetail->session_id = $session_id;
                                                $payDetail->branch_id = Session::get('branch_id');
                                                $payDetail->fees_collect_id = $payOld->id;
                                                $payDetail->fees_group_id = $head;
                                                $payDetail->receipt_no  = $request->slip_no;
                                                $payDetail->admission_id = $admission_id; 
                                                $payDetail->paid_amount = $request->selected_head_amount[$key];
                                                $payDetail->payment_mode_id = $request->payment_mode_id;
                                                $payDetail->total_amount = $request->selected_head_amount[$key];
                                                $payDetail->status = $request->payment_status;
                                                $payDetail->date = date('Y-m-d');
                                                $payDetail->save();  
                                                $fees_details_id[]= $payDetail->id;
                                            }
                                            else{
                                                $pay = new FeesCollect;
                                                $pay->user_id = Session::get('id');
                                                $pay->session_id = $session_id;
                                                $pay->branch_id = Session::get('branch_id');
                                                $pay->admission_id = $request->admission_id;
                                                $pay->fees_assign_id = $FeesAssign->id;
                                                $pay->amount = $request->selected_head_amount[$key];
                                                $pay->save();
                                                $collect_id = $pay->id;
                                                $payDetail = new FeesDetail; //model name
                                                $payDetail->user_id = Session::get('id');
                                                $payDetail->session_id = $session_id;
                                                $payDetail->branch_id = Session::get('branch_id');
                                                $payDetail->fees_collect_id = $collect_id;
                                                $payDetail->fees_group_id = $head;
                                                $payDetail->receipt_no  = $request->slip_no;
                                                $payDetail->admission_id = $admission_id;
                                                $payDetail->paid_amount = $request->selected_head_amount[$key];
                                                $payDetail->total_amount = $request->selected_head_amount[$key];
                                                $payDetail->status = $request->payment_status;
                                                $payDetail->date = date('Y-m-d');
                                                $payDetail->payment_mode_id = $request->payment_mode_id;
                                                $payDetail->save();
                                                $fees_details_id[]= $payDetail->id;
                                            }
                                            
                                        }
                                    }
                                
                                        
                                        if(!empty($fees_details_id)){
                                            $transaction_slip = '';
                                            if ($request->file('payment_receipt')) {
                                                $image = $request->file('payment_receipt');
                                                $path = $image->getRealPath();
                                                $transaction_slip = 'Payment Receipt '. $request->transaction_id . '-' . time() . $image->getClientOriginalName();
                                                $destinationPath = env('IMAGE_UPLOAD_PATH') . 'payment_receipt';
                                                $image->move($destinationPath, $transaction_slip);
                                            }
                                            $invoice = new FeesDetailsInvoices();
                                            $invoice->user_id = Session::get('id');
                                            $invoice->session_id = $session_id;
                                            $invoice->branch_id = Session::get('branch_id');
                                            $invoice->fees_counter_id = Session::get('fees_counter_id');
                                            $invoice->admission_id = $admission_id;
                                            $invoice->fees_details_id = implode(',',$fees_details_id );
                                            $invoice->payment_date = date('Y-m-d');
                                            $invoice->payment_mode = $request->payment_mode_id;
                                            $invoice->transaction_id = $request->transaction_id;
                                            $invoice->account_holder = $request->account_holder;
                                            //$invoice->bank_name = $request->bank_name;
                                            $invoice->invoice_no = $request->slip_no;
                                            $invoice->status = $request->payment_status;
                                            //$invoice->cheque_number = $request->cheque_number;
                                            //$invoice->cheque_date = $request->cheque_date;
                                            $invoice->payment_receipt = $transaction_slip;  
                                            $invoice->amount = $request->amount;
                                            //$invoice->remark = $request->other_fee_remark;
                                            $invoice->save();
                                            $fees_details_invoice_id = $invoice->id;
                                            $slip = $invoice->invoice_no;
                
                                        }
                                        else {
                                            throw new \Exception('No valid fee amount selected.');
                                        }

                                        if($request->payment_mode_id != 6){
                                            $branch     = Branch::find(Session::get('branch_id'));
                                            $setting    = Setting::where('branch_id', Session::get('branch_id'))->first();

                                            // ✅ 11. WhatsApp notification
                                            if ($admission && $branch && $branch->whatsapp_srvc != 0 && !empty($admission->mobile)) {
                                                
                                                $studentName = trim($admission->first_name . ' ' . $admission->last_name);

                                                $template = MessageType::where('template_name','student_payment_pay')
                                                                        ->where('status',1)
                                                                        ->first();
                                                if($template){
                                                    $variables = [
                                                        '{{1}}' => $studentName ?? '',
                                                        '{{2}}' => $setting->name ?? ''
                                                    ];
                                            
                                                    $content = str_replace(
                                                        array_keys($variables),
                                                        array_values($variables),
                                                        $template->template_content
                                                    );

                                                    $params = [
                                                        1 => $studentName ?? '',
                                                        2 => $setting->name ?? '',
                                                    ];
                                                
                                                    $this->notif->enqueue([
                                                        'user_id'    => Session::get('id'),
                                                        'branch_id'  => Session::get('branch_id'),
                                                        'session_id' => Session::get('session_id'),
                                                        'recipient'  => $admission->mobile,
                                                        'message'    => $content,
                                                        'event_type'  => 'student_payment_pay_offline',
                                                        'template_name' => 'student_payment_pay',
                                                        'channel'     => 'whatsapp',
                                                        'params'        => $params,
                                                    ]);
                                                }

                                            }
                                        }

                                        DB::commit();
                                        $transactionStarted = false;


                                        return Response::json(array('status' => true, 'message' => 'Fee Collected Successfully', 'invoiceId' => $fees_details_invoice_id)); 
                                }
                            }
                            
                        }
                    
                    } catch (\Throwable $e) {
                            if ($transactionStarted) {
                                DB::rollBack();
                            }
                            return Response::json(array('status' => false, 'error' => 'Error in collecting fees'), 500); 
                    }
                    
                }
    
                                
    public function payuPaymentInitiate(Request $request){
       
        $response = Helper::payuPaymentInitiate($request);
        return $response;
        //$responseData = json_decode($response['response'], true);

    }

    public function payuPaymentInitiateUniversal(Request $request){
       
        $response = Helper::payuPaymentInitiateUniversal($request);
        return $response;
        //$responseData = json_decode($response['response'], true);

    }
    
    
    
}
