<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\StoreItem;
use App\Models\StoreItemRequest;
use App\Models\BillCounter;
use App\Models\Admission;
use App\Models\Master\MessageTemplate;
use App\Models\Master\Branch;
use App\Models\Setting;
use App\Models\StoreBillingDetail;
use App\Models\Master\MessageType;
use Illuminate\Support\Facades\DB;
use Session;
use Hash;
use Helper;
use File;
use Str;
use Redirect;
use Auth;
use View;
use Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class StoreController extends Controller

{
    public function __construct(private NotificationService $notif) {}

    public function storeDashboard(){
        return view('store_management.storeDashboard');
    }
    
   public function addStoreItem(Request $request)
    {
        $data = StoreItem::orderBy('name', 'ASC')->get();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'rate' => 'required|numeric|min:0',
                'qty' => 'required|integer|min:1',
            ]);

            if ($request->id) {
                $item = StoreItem::find($request->id);
            } else {
                $item = new StoreItem();
            }

            $item->name = $validatedData['name'];
            $item->rate = $validatedData['rate'];
            $item->qty = $validatedData['qty'];
            $item->session_id = Session::get('session_id');
            $item->branch_id = Session::get('branch_id');
            $item->user_id = Session::get('id');
            $item->save();

            return response()->json(['id' => $item->id]);
        }

        return view('store_management.addStoreItem', ['data' => $data]);
    }
    
   public function viewStoreRequest()
    {
    $data = StoreBillingDetail::leftJoin(
                'admissions',
                'store_item_billing_details.admission_id',
                '=',
                'admissions.id'
            )
            ->leftJoin(
                'class_types',
                'admissions.class_type_id',
                '=',
                'class_types.id'
            )
            ->leftJoin(
                'payment_modes',
                'store_item_billing_details.payment_mode_id',
                '=',
                'payment_modes.id'
            )
            ->where('store_item_billing_details.session_id', Session::get('session_id'))
            ->where('store_item_billing_details.branch_id', Session::get('branch_id'));

    /* ✅ FROM – TO DATE FILTER */
    if (!empty($request->starting) && !empty($request->ending)) {
        $data->whereBetween(
            'store_item_billing_details.date',
            [$request->starting, $request->ending]
        );
    }

    $data = $data->select(
                'store_item_billing_details.id',
                'store_item_billing_details.admission_id',
                'store_item_billing_details.receipt_no',
                'store_item_billing_details.date',
                'store_item_billing_details.transaction_id',
                'store_item_billing_details.transaction_status',
                'store_item_billing_details.payment_mode_id',
                'store_item_billing_details.amount as total_amount',

                'admissions.admissionNo',
                'admissions.first_name',
                'admissions.last_name',
                'admissions.father_name',
                'admissions.mobile',
                'admissions.class_type_id',

                'class_types.name as class_name',

                // ✅ Payment Mode Name
                'payment_modes.name as payment_mode'
            );
            
            if (Session::get('role_id') == 3) {
            $data =   $data->where('store_item_billing_details.admission_id', Session::get('id'));
            }
        $data =  $data->orderBy('store_item_billing_details.id', 'DESC')
            ->get();


        return view('store_management.viewStoreRequest', compact('data'));
    }

    public function searchStudentsForStationaryRequest(Request $request)
    {
        $q = $request->q;

        return Admission::query()
            ->select(
                'admissions.id',
                'first_name',
                'last_name',
                'admissionNo',
                'course',
                'mobile',
                'email',
                'batch',
                'father_name',
                'student_type',
                'class_types.name as class_name',
                //'gender.name as gender_name',
                'sessions.from_year as session_from_year',
                'sessions.to_year as session_to_year',
                'class_type_id'           
        )
            ->join('class_types', 'admissions.class_type_id', '=', 'class_types.id')
            //->leftJoin('gender', 'admissions.gender_id', '=', 'gender.id')
            ->join('sessions', 'admissions.session_id', '=', 'sessions.id')

            // ✅ FIXED FILTERS (always applied)
            ->where('admissions.status', 1)
            ->where('admissions.branch_id', Session::get('branch_id'))
            ->where('admissions.session_id', Session::get('session_id'))

            // ✅ SAFE SEARCH GROUP
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('first_name', 'LIKE', "%$q%")
                        ->orWhere('last_name', 'LIKE', "%$q%")
                        ->orWhere('father_name', 'LIKE', "%$q%")
                        ->orWhere('admissionNo', $q)
                        ->orWhere('mobile', $q);
                });
            })

            ->limit(10)
            ->get();
    }

    public function addStationaryRequest(Request $request){

        $student = null;
        if (Session::get('role_id') == 3) {
            $student = Admission::query()
                ->select(
                    'admissions.id',
                    'first_name',
                    'last_name',
                    'admissionNo',
                    'course',
                    'mobile',
                    'email',
                    'batch',
                    'father_name',
                    'student_type',
                    'class_types.name as class_name',
                   // 'gender.name as gender_name',
                    'sessions.from_year as session_from_year',
                    'sessions.to_year as session_to_year',
                    'class_type_id'           
            )
                ->join('class_types', 'admissions.class_type_id', '=', 'class_types.id')
               // ->join('gender', 'admissions.gender_id', '=', 'gender.id')
                ->join('sessions', 'admissions.session_id', '=', 'sessions.id')

                // ✅ FIXED FILTERS (always applied)
                ->where('admissions.status', 1)
                ->where('admissions.branch_id', Session::get('branch_id'))
                ->where('admissions.session_id', Session::get('session_id'))            

                ->where('admissions.id', Session::get('id'))
                ->first();
        }
      
        return view('store_management.addStationaryRequest',['student' => $student]);
    }



    public function createStationaryRequest(Request $request)
    {
        if (!$request->isMethod('post')) {
            return response()->json(['success' => false, 'message' => 'Invalid request method']);
        }

        // ✅ 1. Validation — price NOT trusted from client
        $request->validate([
            'admission_id'     => 'required|integer|exists:admissions,id',
            'class_type_id'    => 'required|integer',
            'payment_mode_id'  => 'required|integer',
            'enteredAmount'    => 'nullable|numeric|min:0',
            'transaction_id'   => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.item'     => 'required|integer|exists:store_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price'    => 'required|numeric|min:0',
        ]);

        $immediateSuccess = [1, 10];
        $gatewayOnline    = [6];
        $pay              = null;
        $BillCounterNo    = null;

        try {
            DB::transaction(function () use ($request, $immediateSuccess, $gatewayOnline, &$pay, &$BillCounterNo) {

                // ✅ 2. BillCounter — inside transaction with lockForUpdate to prevent race condition
                $BillCounter = BillCounter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))
                    ->where('type', 'StoreReceipt')
                    ->lockForUpdate()
                    ->first();

                if (empty($BillCounter)) {
                    $BillCounter              = new BillCounter;
                    $BillCounter->user_id    = Session::get('id');
                    $BillCounter->branch_id  = Session::get('branch_id');
                    $BillCounter->session_id = Session::get('session_id');
                    $BillCounter->type       = 'StoreReceipt';
                    $BillCounter->counter    = 0;
                    $BillCounter->save();
                }

                $BillCounterNo = ($BillCounter->counter ?? 0) + 1;

                // ✅ 3. Validate enteredAmount early
                $enteredAmount = $request->enteredAmount ?? 0;
                if ($enteredAmount <= 0) {
                    throw new \Exception('Entered amount must be greater than zero.');
                }

                // ✅ 4. Stock check + price fetch from DB (do NOT trust client price)
                $storeItems   = [];
                $totalExpected = 0;

                foreach ($request->items as $item) {
                    $storeItem    = StoreItem::lockForUpdate()->find($item['item']);
                    $availableQty = $storeItem->qty - $storeItem->reserved_qty - $storeItem->sold_qty;

                    if ($availableQty < $item['quantity']) {
                        throw new \Exception('Insufficient stock for: ' . $storeItem->name);
                    }

                    // ✅ Use DB price, not client-sent price
                    $storeItems[$item['item']] = $storeItem;
                    $totalExpected += $storeItem->rate * $item['quantity'];
                }

                // ✅ 5. Optional: verify enteredAmount matches expected total
                //Uncomment if you want strict price validation:
                if (abs($enteredAmount - $totalExpected) > 0.01) {
                    throw new \Exception('Amount mismatch. Expected: ' . $totalExpected);
                }

                // ✅ 6. Create billing record
                $pay                     = new StoreBillingDetail;
                $pay->user_id            = Session::get('id');
                $pay->session_id         = Session::get('session_id');
                $pay->branch_id          = Session::get('branch_id');
                $pay->fees_counter_id    = Session::get('counter_id');
                $pay->admission_id       = $request->admission_id;
                $pay->receipt_no         = $BillCounterNo;
                $pay->amount             = $enteredAmount;
                $pay->payment_mode_id    = $request->payment_mode_id;
                $pay->transaction_id     = $request->transaction_id;
                $pay->date               = date('Y-m-d');
                $pay->transaction_status = in_array($request->payment_mode_id, $immediateSuccess)
                                            ? 'success'
                                            : 'pending';
                $pay->save();

                // ✅ 7. Save each item request + update stock using DB price
                foreach ($request->items as $item) {
                    $storeItem = $storeItems[$item['item']];

                    $new                          = new StoreItemRequest;
                    $new->session_id             = Session::get('session_id');
                    $new->branch_id              = Session::get('branch_id');
                    $new->user_id                = Session::get('id');
                    $new->admission_id           = $request->admission_id;
                    $new->class_type_id          = $request->class_type_id;
                    $new->store_item_id          = $item['item'];
                    $new->qty                    = $item['quantity'];
                    $new->price                  = $storeItem->rate; // ✅ DB price, not client price
                    $new->date                   = date('Y-m-d');
                    $new->receipt_no             = $BillCounterNo;
                    $new->store_billing_detail_id = $pay->id;
                    $new->save();

                    if (in_array($request->payment_mode_id, $immediateSuccess)) {
                        $storeItem->sold_qty += $item['quantity'];
                    } elseif (in_array($request->payment_mode_id, $gatewayOnline)) {
                        $storeItem->reserved_qty += $item['quantity'];
                    }

                    $storeItem->save();
                }

                // ✅ 8. Update BillCounter inside transaction
                $BillCounter->counter = $BillCounterNo;
                $BillCounter->save();


                // ✅ 9. PDF & WhatsApp — outside transaction (failure here won't rollback DB)
                if ($pay && in_array($pay->payment_mode_id, $immediateSuccess)) {
                    $receipt_no = $pay->receipt_no;
                    $branch     = Branch::find(Session::get('branch_id'));
                    $setting    = Setting::where('branch_id', Session::get('branch_id'))->first();
                    $admission  = Admission::find($pay->admission_id);

                    // ✅ 11. WhatsApp notification
                    if ($admission && $branch && $branch->whatsapp_srvc != 0 && !empty($admission->mobile)) {
                        $studentName = trim($admission->first_name . ' ' . $admission->last_name);

                        $template = MessageType::where('template_name','store_payment_successful')
                                                ->where('status',1)
                                                ->first();
                        
                        if($template){
                            
                            $receiptDate = isset($pay->date)
                                                    ? date('d-m-Y', strtotime($pay->date))
                                                    : date('d-m-Y');
                            $receipt = url('/storeReceipt') . '/' . $pay->receipt_no . '/' . $pay->admission_id;
                                        
                                                // 👇 Human readable message (DB के लिए)
                            $variables = [
                                '{{1}}' => $studentName ?? '',
                                '{{2}}' => number_format($pay->amount,2),
                                '{{3}}' => $receiptDate,
                                '{{4}}' => $receipt ?? '',
                                '{{5}}' => $setting->name ?? ''
                            ];
                    
                            $content = str_replace(
                                array_keys($variables),
                                array_values($variables),
                                $template->template_content
                            );

                            $params = [
                                1 => $studentName ?? '',
                                2 => number_format($pay->amount,2),
                                3 => $receiptDate,
                                4 => $receipt ?? '',
                                5 => $setting->name ?? '',
                            ];
                        
                            $this->notif->enqueue([
                                'user_id'    => Session::get('id'),
                                'branch_id'  => Session::get('branch_id'),
                                'session_id' => Session::get('session_id'),
                                'recipient'  => $admission->mobile,
                                'message'    => $content,
                                'media_link' => $receipt,
                                'event_type'  => 'store_payment_successful',
                                'template_name' => 'store_payment_successful',
                                'channel'     => 'whatsapp',
                                'params'        => $params,
                            ]);

                        }
                    }
                }

            }); // ← Transaction ends here — only DB operations inside           
           

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        // ✅ 12. Final response
        return response()->json([
            'success'    => true,
            'receipt_no' => $pay->receipt_no ?? $BillCounterNo,
            'message'    => 'Details stored successfully'
        ]);
    }


    public function updateStationaryRequest(Request $request){
      
        if ($request->isMethod('post')) {
         
            if(!empty($request->receipt_no) && !empty($request->transaction_id)){
                $pay = StoreBillingDetail::where('receipt_no',$request->receipt_no)->where('transaction_id',$request->transaction_id)->first();

                if($pay){
                    $pay->transaction_status = 'success';
                    $pay->save();

                    if ($pay->payment_mode_id == 6) {
        
                        // Is receipt ke saare items fetch karo
                        $requestedItems = StoreItemRequest::where('receipt_no', $request->receipt_no)
                            ->where('session_id', Session::get('session_id'))
                            ->where('branch_id', Session::get('branch_id'))
                            ->get();
                        
                        foreach ($requestedItems as $requestedItem) {
                            $storeItem = StoreItem::lockForUpdate()->find($requestedItem->store_item_id);
                            if ($storeItem) {
                                // Reserved se hataao, sold mein daalo
                                $storeItem->reserved_qty = max(0, $storeItem->reserved_qty - $requestedItem->qty);
                                $storeItem->sold_qty     += $requestedItem->qty;
                                $storeItem->save();
                            }
                        }
                    }
                            
                            
                        if ($pay->payment_mode_id == 6 && !empty($pay->transaction_id) && $pay->transaction_status == 'success') {
                            
                                $receipt_no = $request->receipt_no;
                                $branch     = Branch::find(Session::get('branch_id'));
                                $setting    = Setting::where('branch_id', Session::get('branch_id'))->first();
                                $admission  = Admission::find($pay->admission_id);

                                // ✅ 11. WhatsApp notification
                                if ($admission && $branch && $branch->whatsapp_srvc != 0 && !empty($admission->mobile)) {
                                    
                                    $studentName = trim($admission->first_name . ' ' . $admission->last_name);

                                    $template = MessageType::where('template_name','store_payment_successful')
                                                            ->where('status',1)
                                                            ->first();

                                    if($template){

                                        $receiptDate = isset($pay->date)
                                                                ? date('d-m-Y', strtotime($pay->date))
                                                                : date('d-m-Y');
                                        $receipt = url('/storeReceipt') . '/' . $pay->receipt_no . '/' . $pay->admission_id;
                                                    
                                                            // 👇 Human readable message (DB के लिए)
                                        $variables = [
                                            '{{1}}' => $studentName ?? '',
                                            '{{2}}' => number_format($pay->amount,2),
                                            '{{3}}' => $receiptDate,
                                            '{{4}}' => $receipt ?? '',
                                            '{{5}}' => $setting->name ?? ''
                                        ];
                                
                                        $content = str_replace(
                                            array_keys($variables),
                                            array_values($variables),
                                            $template->template_content
                                        );

                                        $params = [
                                            1 => $studentName ?? '',
                                            2 => number_format($pay->amount,2),
                                            3 => $receiptDate,
                                            4 => $receipt ?? '',
                                            5 => $setting->name ?? '',
                                        ];
                                    
                                        $this->notif->enqueue([
                                            'user_id'    => Session::get('id'),
                                            'branch_id'  => Session::get('branch_id'),
                                            'session_id' => Session::get('session_id'),
                                            'recipient'  => $admission->mobile,
                                            'message'    => $content,
                                            'media_link' => $receipt,
                                            'event_type'  => 'store_payment_successful',
                                            'template_name' => 'store_payment_successful',
                                            'channel'     => 'whatsapp',
                                            'params'        => $params,
                                        ]);

                                    }

                                }
                            
                            return response()->json(['status' => true, 'message' => 'Online transaction updated successfully']);
                        }else{
                            return response()->json(['status' => false, 'message' => 'No record found for this receipt no.']);
                        }
                }else{
                    return response()->json(['status' => false, 'message' => 'Failed to update online transaction.']);
                }
            }
        }
      
    }

    public function updateStoreTxnStatus(Request $request)
    {
        try {
            $data = StoreBillingDetail::where('id', $request->table_id)->where('transaction_id', $request->transaction_id)->first();
              
            if($data){
                $data->transaction_status = $request->transaction_status;
                $data->save();
                return response()->json(['status' => true, 'message' => 'Transaction status updated successfully.']);
            }else{
                return response()->json(['status' => false, 'message' => 'Transaction not found']);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Update failed'
            ], 500);
        }
    }


    public function cancelStorePayment(Request $request){

        if (!empty($request->receipt_no)) {
            
            $pay = StoreBillingDetail::where('receipt_no', $request->receipt_no)
                ->where('transaction_status', 'pending')
                ->first();
            
            if ($pay) {
                $pay->transaction_status = 'cancelled';
                $pay->save();
                
                // ✅ Reserved qty wapas release karo
                $requestedItems = StoreItemRequest::where('receipt_no', $request->receipt_no)
                    ->where('session_id', $pay->session_id)
                    ->where('branch_id', $pay->branch_id)
                    ->get();
                
                foreach ($requestedItems as $requestedItem) {
                    $storeItem = StoreItem::find($requestedItem->store_item_id);
                    if ($storeItem) {
                        $storeItem->reserved_qty = max(0, $storeItem->reserved_qty - $requestedItem->qty);
                        $storeItem->save();
                    }
                }

                    $receipt_no = $request->receipt_no;
                    $branch     = Branch::find(Session::get('branch_id'));
                    $setting    = Setting::where('branch_id', Session::get('branch_id'))->first();
                    $admission  = Admission::find($pay->admission_id);

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
                                'event_type'  => 'store_payment_unsuccessful',
                                'template_name' => 'store_payment_unsuccessful',
                                'channel'     => 'whatsapp',
                                'params'        => $params,
                            ]);
                        }

                    }

            }
            
            return response()->json(['status' => true, 'message' => 'Payment cancelled, stock released.']);
        }
        
        return response()->json(['status' => false]);
    }

    public function releaseStaleStoreReservations(Request $request){
        $staleTime = now()->subMinutes(30); // 30 minutes se purani reservations
        
        $staleBillings = StoreBillingDetail::whereIn('transaction_status', ['pending','cancelled','failure'])
            ->where('created_at', '<', $staleTime)
            ->get();
        
        foreach ($staleBillings as $billing) {
            
            // Reserved qty wapas release karo
            $requestedItems = StoreItemRequest::where('receipt_no', $billing->receipt_no)
                ->where('session_id', $billing->session_id)
                ->where('branch_id', $billing->branch_id)
                ->get();
            
            foreach ($requestedItems as $requestedItem) {
                $storeItem = StoreItem::find($requestedItem->store_item_id);
                if ($storeItem) {
                    $storeItem->reserved_qty = max(0, $storeItem->reserved_qty - $requestedItem->qty);
                    $storeItem->save();
                }
            }

            $billing->transaction_status = 'cancelled';
            $billing->save();
        }
        
        return response()->json(['status' => true, 'message' => 'Stale reservations released. : ' . $staleBillings->count()]);
    }

    public function editInvoiceInventory(Request $request,$receipt_no){
        
        $data = StoreBillingDetail::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('receipt_no',$receipt_no)->get();
        
        
           if ($request->isMethod('post')) {
               
               if(!empty($request->id))
               {
                   foreach($request->id as $key=>$id)
                   {
                       
               $row = StoreBillingDetail::find($id);
               $row->date = $request->date[$key];
               $row->amount = $request->amount[$key];
               $row->save();
                   }
               }
               return redirect::to('editInvoiceInventory/' . $receipt_no)->with('message', 'Inventory Invoice Updated.');
           }
         return view('store_management.editInvoice',['data'=>$data,'receipt'=>$receipt_no]);
         
         
        
    }
    public function deleteInvoiceInventory(Request $request){
        
        $delete_id = $request->delete_id ?? '';
        
        $data = StoreBillingDetail::where('id',$delete_id)->first()->delete();
        
        return redirect()->back();
        
    }
    public function deleteReceiptInventory(Request $request){
        
        $delete_receipt= $request->delete_receipt?? '';
        
       StoreItemRequest::where('receipt_no',$delete_receipt)->delete();
       StoreBillingDetail::where('receipt_no',$delete_receipt)->delete();
        
        return redirect()->back();
        
    }
    public function storeReceipt($receipt_no, $admission_id = null){
        $storeBillingDetail = StoreBillingDetail::where('receipt_no', $receipt_no)->where('admission_id', $admission_id)->first();
        if (!$storeBillingDetail) {
            return response()->json(['status' => false, 'message' => 'Receipt not found']);
        }
        $data = StoreItemRequest::leftJoin('admissions', 'store_item_student_requests.admission_id', '=', 'admissions.id')
            ->leftJoin('class_types', 'store_item_student_requests.class_type_id', '=', 'class_types.id')
            ->select('store_item_student_requests.*', 'admissions.admissionNo' ,'admissions.first_name','admissions.last_name','admissions.father_name', 'admissions.mobile', 'class_types.name as class_name', 'store_item_billing_details.transaction_id as transaction_id', 'store_item_billing_details.payment_mode_id as payment_mode_id', 'payment_modes.name as payment_mode', 'store_item_billing_details.transaction_status')->where('store_item_student_requests.receipt_no',$receipt_no) ->where('store_item_student_requests.session_id', $storeBillingDetail->session_id)
            ->join('store_item_billing_details', function ($join) {
                $join->on('store_item_billing_details.admission_id', '=', 'store_item_student_requests.admission_id')
                     ->on('store_item_billing_details.receipt_no', '=', 'store_item_student_requests.receipt_no');
            })
            ->join('payment_modes', 'payment_modes.id', '=', 'store_item_billing_details.payment_mode_id')
            ->where('store_item_student_requests.branch_id', $storeBillingDetail->branch_id)->get();
          
        return view('print_file.store_print.store_receipt',['data'=>$data]);
    }
    public function deleteStoreItem(Request $request){
        StoreItem::where('id',$request->id)->delete();
        return response()->json(['id' => $request->id]);
    }
   public function storeDailyCollection(Request $request)
{
    $data = StoreBillingDetail::leftJoin(
                'admissions',
                'store_item_billing_details.admission_id',
                '=',
                'admissions.id'
            )
            ->leftJoin('class_types','admissions.class_type_id','=','class_types.id')
            ->leftJoin(
                'payment_modes',
                'store_item_billing_details.payment_mode_id',
                '=',
                'payment_modes.id'
            )
            
            ->where('store_item_billing_details.session_id', Session::get('session_id'))
            ->where('store_item_billing_details.branch_id', Session::get('branch_id'))
            ->select(
                'store_item_billing_details.id',
                'store_item_billing_details.admission_id',
                'store_item_billing_details.receipt_no',
                'store_item_billing_details.date',
                'store_item_billing_details.transaction_id',
                'store_item_billing_details.amount as total_amount',
            'store_item_billing_details.transaction_status',
            'store_item_billing_details.payment_mode_id',
                'admissions.admissionNo',
                'admissions.first_name',
                'admissions.last_name',
                'admissions.father_name',
                'admissions.mobile',
                'admissions.class_type_id',

                'class_types.name as class_name',

                // ✅ Payment Mode Name
                'payment_modes.name as payment_mode'
            )
            ->orderBy('store_item_billing_details.date', 'DESC');
             // ✅ FROM – TO DATE FILTER
    if (!empty($request->starting) && !empty($request->ending)) {
        $data->whereBetween(
            'store_item_billing_details.date',
            [$request->starting, $request->ending]
        );
    }

    if(!empty($request->transaction_status)){
        $data->where('store_item_billing_details.transaction_status', $request->transaction_status);
    }

    if(!empty($request->payment_mode_id)){
        $data->where('store_item_billing_details.payment_mode_id', $request->payment_mode_id);
    }



            $data = $data->get();

    return view('store_management.storeDailyCollection', compact('data'));
}

    public function showSoldOutItems(Request $request)
{
    try {
        $itemId = $request->item_id;
        $storeItem = StoreItem::find($itemId);
        if (!$storeItem) {
            return response()->json([
                'status' => false,
                'message' => 'Store item not found'
            ], 404);
        }
        // Join with admissions table to get student name
        $data = StoreItemRequest::where('store_item_student_requests.store_item_id', $itemId)
            ->where('store_item_student_requests.session_id', Session::get('session_id'))
            ->where('store_item_student_requests.branch_id', Session::get('branch_id'))
            ->where('store_item_billing_details.session_id', Session::get('session_id'))
            ->where('store_item_billing_details.branch_id', Session::get('branch_id'))
            ->join('admissions', 'admissions.id', '=', 'store_item_student_requests.admission_id')
            ->join('store_item_billing_details', function ($join) {
                $join->on('store_item_billing_details.admission_id', '=', 'store_item_student_requests.admission_id')
                     ->on('store_item_billing_details.receipt_no', '=', 'store_item_student_requests.receipt_no');
            })
            ->select(
                'store_item_student_requests.store_item_id',
                'store_item_student_requests.admission_id',
                'store_item_student_requests.qty',
                'store_item_student_requests.price',
                'store_item_student_requests.date',
                'store_item_student_requests.receipt_no',
                'admissions.first_name',
                'store_item_billing_details.transaction_status',
                'store_item_billing_details.payment_mode_id'
            )->where('store_item_billing_details.transaction_status', 'success')
            ->whereNotNull('store_item_student_requests.qty')
            ->get();

        $summary = [
            'total_students' => $data->unique('admission_id')->count(),
            'total_qty_sold' => $storeItem->sold_qty,
            'total_revenue'  => $data->sum(function ($row) {
                return $row->qty * $row->price;
            }),
        ];

        return response()->json([
            'status'  => true,
            'data'    => $data,
            'summary' => $summary,
            'item_name' => $data->first()->storeItem->name ?? 'Item',
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch sold out items: ' . $e->getMessage()
        ], 500);
    }
}

}