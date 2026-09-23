<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\FeesDetail;
use App\Models\fees\FeesDetailsInvoices;
use App\Models\Master\MessageTemplate;
use App\Models\Master\MessageType;
use App\Models\Master\Branch;
use App\Models\Master\PaymentMode;
use App\Models\Setting;
use Helper;
use Session;
use PDF;
use App\Services\NotificationService;

class PayUMoneyController extends Controller
{
    public function __construct(private NotificationService $notif) {}


    public function payUSuccess(Request $request, $id)
    {
        $feesDetailInvoice = FeesDetailsInvoices::find($id);
        $feesDetailInvoice->status = 0;
        $feesDetailInvoice->remark = 'Online transaction successful.';
        $feesDetailInvoice->save();

        $feesDetailId = $feesDetailInvoice->fees_details_id;
        $feesDetailId = explode(',', $feesDetailId);
        $feesDetail = FeesDetail::whereIn('id', $feesDetailId)->update(['status' => 0, ]);

        $admission = Admission::find($feesDetailInvoice->admission_id);
        $branch = Branch::find($admission->branch_id);
        $setting = Setting::where('branch_id',$admission->branch_id)->first();
        $payment_mode = PaymentMode::find($feesDetailInvoice->payment_mode_id);
        $finalCollectedAmt = (float) ($feesDetailInvoice->amount ?? 0) + (float) ($feesDetailInvoice->total_fine ?? 0) + (float) ($feesDetailInvoice->discount ?? 0);
        $receiptDate = !empty($feesDetailInvoice->payment_date) ? date('d-m-Y', strtotime($feesDetailInvoice->payment_date)) : date('d-m-Y');

        // ✅ 11. WhatsApp notification
        if ($admission && $branch && $branch->whatsapp_srvc != 0 && !empty($admission->mobile)) {
            $studentName = trim($admission->first_name . ' ' . $admission->last_name);

            $template = MessageType::where('template_name','collect_fee')
                                    ->where('status',1)
                                    ->first();
            
            if($template){
                
                $receipt = url('/feesReceipt') . '/' . $feesDetailInvoice->invoice_no . '/' . $feesDetailInvoice->admission_id;
                            
                                    // 👇 Human readable message (DB के लिए)
                $variables = [
                    '{{1}}' => $studentName ?? '',
                    '{{2}}' => number_format($finalCollectedAmt,2),
                    '{{3}}' => $setting->name ?? '',
                    '{{4}}' => "Mode: ".($payment_mode->name ?? '') . ", Date: ".$receiptDate,
                    '{{5}}' => $setting->name ?? '',
                    '{{6}}' => $receipt ?? ''
                ];
        
                $content = str_replace(
                    array_keys($variables),
                    array_values($variables),
                    $template->template_content
                );

                $params = [
                    1 => $studentName ?? '',
                    2 => number_format($finalCollectedAmt,2),
                    3 => $setting->name ?? '',
                    4 => "Mode: ".($payment_mode->name ?? '') . ", Date: ".$receiptDate,
                    5 => $setting->name ?? '',
                    6 => $receipt ?? '',
                ];
            
                $this->notif->enqueue([
                    'user_id'    => Session::get('id'),
                    'branch_id'  => Session::get('branch_id'),
                    'session_id' => Session::get('session_id'),
                    'recipient'  => $admission->mobile,
                    'message'    => $content,
                    'media_link' => $receipt,
                    'event_type'  => 'fees_payment_successful',
                    'template_name' => 'collect_fee',
                    'channel'     => 'whatsapp',
                    'params'        => $params,
                ]);

            }
        }

                          

        return view('onlinePayment.payUSuccess');
    }

    public function payUSuccessUniversal(Request $request)
    {
        return view('onlinePayment.payUSuccess');
    }
    public function payUCancelUniversal(Request $request)
    {
       return view('onlinePayment.payUCancel');
    }

    public function payUCancel(Request $request, $id)
    {
        $feesDetailInvoice = FeesDetailsInvoices::find($id);
        $feesDetailInvoice->status = 2;
        $feesDetailInvoice->remark = 'Online transaction failed.';
        $feesDetailInvoice->save();

        $feesDetailId = $feesDetailInvoice->fees_details_id;
        $feesDetailId = explode(',', $feesDetailId);
        $feesDetail = FeesDetail::whereIn('id', $feesDetailId)->update(['status' => 2, ]);

        $admission  = Admission::find($feesDetailInvoice->admission_id);
        $branch     = Branch::find($admission->branch_id);
        $setting    = Setting::where('branch_id', $admission->branch_id)->first();
        

        // ✅ 11. WhatsApp notification
        if ($admission && $branch && $branch->whatsapp_srvc != 0 && !empty($admission->mobile)) {
            
            $studentName = trim($admission->first_name . ' ' . $admission->last_name);

            $template = MessageType::where('template_name','store_payment_unsuccessful')
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
                    'event_type'  => 'fees_payment_unsuccessful',
                    'template_name' => 'store_payment_unsuccessful',
                    'channel'     => 'whatsapp',
                    'params'        => $params,
                ]);
            }

        }

       return view('onlinePayment.payUCancel');
    }

    public function checkTransactionStatus(Request $request, $id){
        try {
            $feesDetailInvoice = FeesDetailsInvoices::find($id);
        
            if (!$feesDetailInvoice) {
                return response()->json(['status' => 404, 'message' => 'Invoice not found!']);
            }
        
            if ($feesDetailInvoice->status == 2) {
                return response()->json(['status' => 2, 'message' => 'Payment failed!']);
            } elseif ($feesDetailInvoice->status == 1) {
                return response()->json(['status' => 1, 'message' => 'Payment is pending!']);
            } elseif ($feesDetailInvoice->status == 0) {
                return response()->json(['status' => 0, 'message' => 'Payment is successful!']);
            } else {
                return response()->json(['status' => 99, 'message' => 'Unknown payment status!']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false, 
                'error' => 'Error in fetching transaction status',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function checkTransactionStatusUniversal(Request $request, $txnid){
        try {
            $response = Helper::checkPayUTxnStatus($txnid);
          
            // Convert response to array
            $result = json_decode($response, true);
           
            if (isset($result['status']) && $result['status'] === 1) {
                $transaction = $result['transaction_details'][$txnid] ?? null;

                if ($transaction) {
                    if($transaction['status'] == 'success'){
                        return response()->json([
                            'status'        => true, 
                            'message'       => 'Payment status fetched successfully!',
                            'payustatus'    => $transaction['status'],
                            'unmappedstatus'=> $transaction['unmappedstatus'],
                            'mode'          => $transaction['mode'],
                            'amount'        => $transaction['amt'],  // Use 'amt' or 'transaction_amount'
                            'bank_ref_no'   => $transaction['bank_ref_num'], // Can be null
                            'addedon'       => $transaction['addedon'],
                            'mihpayid'      => $transaction['mihpayid'],
                            'txnid'         => $transaction['txnid'],
                            'productinfo'   => $transaction['productinfo'],
                            'firstname'     => $transaction['firstname'],
                            'email'         => $transaction['email'] ?? null,
                        ]);
                    }else{
                        return response()->json([
                            'status'        => false, 
                            'message'       => 'Payment status fetched successfully!',
                            'payustatus'    => $transaction['status'],
                            'unmappedstatus'=> $transaction['unmappedstatus'],
                            'mode'          => $transaction['mode'],
                            'amount'        => $transaction['amt'],  // Use 'amt' or 'transaction_amount'
                            'bank_ref_no'   => $transaction['bank_ref_num'], // Can be null
                            'addedon'       => $transaction['addedon'],
                            'mihpayid'      => $transaction['mihpayid'],
                            'txnid'         => $transaction['txnid'],
                            'productinfo'   => $transaction['productinfo'],
                            'firstname'     => $transaction['firstname'],
                            'email'         => $transaction['email'] ?? null,
                        ]);
                    }
                    
                }else{
                    return response()->json(['status' => false, 'message' => 'Payment failed!']);
                }
            }else{
                return response()->json(['status' => false, 'message' => 'Payment failed!']);
            }

            return $result;
            //$responseData = json_decode($response['response'], true);
        } catch (Exception $e) {
            return response()->json([
                'status' => false, 
                'error' => 'Error in fetching transaction status',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function checkPayUTxnStatus(Request $request){
      
        try {
            
            $response = Helper::checkPayUTxnStatus($request->txnid);

            return response()->json([
                'status' => true,
                'message' => 'Transaction status fetched successfully.',
                'response' => $response
            ], 200);
           
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Error in finding result',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
}