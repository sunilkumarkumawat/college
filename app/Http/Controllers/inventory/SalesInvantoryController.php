<?php

namespace App\Http\Controllers\inventory;
use Illuminate\Validation\Validator;
use App\Models\User;
use App\Models\Setting;
use App\Models\Inventory;
use App\Models\Admission;
use App\Models\BillCounter;
use App\Models\InventoryItem;
use App\Models\InventoryDetail;
use App\Models\InventorySale;
use App\Models\InventorySaleDetail;
use App\Models\Master\MessageTemplate;
use App\Models\Master\MessageType;
use App\Models\Master\Branch;
use Illuminate\Support\Facades\DB;
use Session;
use Response;
use Hash;
use Helper;
use Redirect;
use Str;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesInvantoryController extends Controller
{
    public function SalesAddInvantory(Request $request)
    {
        // $session = Session::all();
        // dd($session);
        $BillCounter = BillCounter::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('type', 'StoreReceipt')->get()->first();
        if (!empty($BillCounter)) {
            $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0;
            $BillCounterNo = $counter + 1;
        }
        if ($request->isMethod("post")) {
            $request->validate([
               
            ]);
                
              //dd($request);  
                $addsale = new InventorySale(); //model name
                $addsale->branch_id = Session::get("branch_id");
                $addsale->session_id = Session::get("session_id");
                $addsale->user_id = Session::get("id");
                $addsale->invoice_no = $BillCounterNo;
                $addsale->date = $request->date;
                $addsale->admission_id = $request->admission_id;
                $addsale->mobile = $request->mobile;
                $addsale->gstin = $request->gstin;
                $addsale->total_qty = $request->total_qty;
                $addsale->total_amount = $request->net_amount;
                $addsale->save();
                $addinvantory_id = $addsale->id;

                if(!empty($request->inventory_item_id)){            
                    foreach($request->inventory_item_id as $key => $item_id){
                        $addDetai = new InventorySaleDetail(); //model name
                        $addDetai->branch_id = Session::get("branch_id");
                        $addDetai->session_id = Session::get("session_id");
                        $addDetai->user_id = Session::get("id");
                        $addDetai->inventory_item_id = $request->inventory_item_id[$key];
                        $addDetai->inventory_sale_id = $addinvantory_id;
                        $addDetai->admission_id = $request->admission_id;
                        $addDetai->qty = $request->qty[$key];
                        $addDetai->amount = $request->amount[$key];
                        $addDetai->date = $request->date;
                        $addDetai->save();
                        InventoryItem::where('id',$request->inventory_item_id[$key])->decrement('available_stock',$request->qty[$key]);
                    }
                }

                $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0;
                $BillCounter->counter = $counter + 1;
                $BillCounter->save();

                
                if(Session::get('role_id')==3){
                    return Response::json(array('status' => true, 'message' => 'Fee Collected Successfully', 'invoiceId' => $addinvantory_id));
                }
            return redirect::to("sale_inventory_view")->with("message",
                "Sales Invantory add Successfully."
            );
        }
        if (Session::get("role_id") == 3) {
            $admissionNo = Admission::findOrFail(Session::get('id'));
        }else{
            $admissionNo = Admission::select(
                'id',
                DB::raw("CONCAT(admissionNo, ' | ', first_name) AS display")
            )->pluck('display', 'id');
        }
        //dd($admissionNo);
        return view("invantory.sales_invantory.add",compact('admissionNo','BillCounterNo'));
    }

    public function SalesEditInvantory(Request $request, $id)
    {
        $data = InventorySale::select('inventory_sales.*','admissions.first_name','admissions.last_name')
                                           ->leftjoin('admissions','admissions.id','inventory_sales.admission_id')->where('inventory_sales.id',$id)->first();
        $dataDetail = InventorySaleDetail::select('inventory_sale_details.*','inventory_items.name as inventory_item_name','admissions.first_name','admissions.last_name')
                                           ->leftjoin('inventory_items','inventory_items.id','inventory_sale_details.inventory_item_id')
                                           ->leftjoin('admissions','admissions.id','inventory_sale_details.admission_id')->where('inventory_sale_id',$id)->get();
        if ($request->isMethod("post")) {
            $request->validate([
                
            ]);
            
                $data->branch_id = Session::get("branch_id");
                $data->session_id = Session::get("session_id");
                $data->user_id = Session::get("id");
                $data->invoice_no = $request->invoice_no;
                $data->date = $request->date;
                $data->admission_id = $request->admission_id;
                $data->mobile = $request->mobile;
                $data->gstin = $request->gstin;
                $data->total_qty = $request->total_qty;
                $data->total_amount = $request->net_amount;
                $data->save();
                $addinvantory_id = $data->id;

                if(!empty($request->inventory_item_id)){            
                    foreach($request->inventory_item_id as $key => $item_id){
                        if(isset($request->inventory_sale_detail_id[$key])){
                            $addDetai =  InventorySaleDetail::find($request->inventory_sale_detail_id[$key]);
                            
                               InventoryItem::where('id',$request->inventory_item_id[$key])->decrement('available_stock',$request->qty[$key]);
                            
                        }else{
                           $addDetai = new InventorySaleDetail(); //model name 
                           InventoryItem::where('id',$request->inventory_item_id[$key])->increment('available_stock',$request->qty[$key]);
                        }
                        
                        $addDetai->branch_id = Session::get("branch_id");
                        $addDetai->session_id = Session::get("session_id");
                        $addDetai->user_id = Session::get("id");
                        $addDetai->inventory_item_id = $request->inventory_item_id[$key];
                        $addDetai->inventory_sale_id = $addinvantory_id;
                        $addDetai->admission_id = $request->admission_id;
                        $addDetai->qty = $request->qty[$key];
                        $addDetai->amount = $request->amount[$key];
                        $addDetai->date = $request->date;
                        $addDetai->save();
                    }
                }


            return redirect::to("sale_inventory_view")->with(
                "message",
                "Invantory Sale Update Successfully."
            );
        }
        return view("invantory.sales_invantory.edit", ["data" => $data,"dataDetail"=>$dataDetail]);
    }

    public function SalesViewInvantory(Request $request)
    {
        $data = InventorySale::select('inventory_sales.*','admissions.first_name','admissions.last_name')
                                           ->leftjoin('admissions','admissions.id','inventory_sales.admission_id')
                                           ->where("inventory_sales.session_id",Session::get("session_id"));

        if (Session::get("role_id") > 1) {
            $invantoryItem = $data->where("inventory_sales.branch_id",Session::get("branch_id"));
        }

        $invantoryItem = $data->orderBy("inventory_sales.id", "DESC")->get();
        return view("invantory.sales_invantory.view", ["data" => $invantoryItem]);
    }
    
     public function getInvantoryItemQtyCheck(Request $request){
       $getitem = InventoryItem::find($request->inventory_item_id);
       
           if($getitem->available_stock > $request->qty){
            $response = 0;   
           }else{
            $response = 1;      
           }
    
       echo json_encode($response); 
   }
     public function getAutoCompleteStudent(Request $request){
       $getitem = Admission::where('first_name', 'LIKE','%'.$request->search. '%')->orwhere('last_name', 'LIKE','%'.$request->search. '%')->get(['id','last_name','first_name','mobile']);
         
            foreach($getitem as $data){
         
            $response[] = array("value"=>$data['name'],"label"=>$data['first_name'].' '.$data['last_name'],"id"=>$data['id'],"mobile"=>$data['mobile']);
           }
    
       echo json_encode($response);  
   }
   
   
   public function SalesDeleteInvantory(Request $request)
    {
        $id = $request->delete_id;
                InventorySaleDetail::where('inventory_sale_id',$id)->delete();
                InventorySale::find($id)->delete();

        return redirect::to("sale_inventory_view")->with(
            "message",
            "Invantory Sale  Delete Successfully."
        );
    }
    
    public function sale_inventory_print(Request $request, $id)
    {
        $data = InventorySale::select('inventory_sales.*','admissions.first_name','admissions.last_name','admissions.admissionNo')
                                           ->leftjoin('admissions','admissions.id','inventory_sales.admission_id')->where('inventory_sales.id',$id)->first();
        $dataDetail = InventorySaleDetail::select('inventory_sale_details.*','inventory_items.name as inventory_item_name','admissions.first_name','admissions.last_name')
                                           ->leftjoin('inventory_items','inventory_items.id','inventory_sale_details.inventory_item_id')
                                           ->leftjoin('admissions','admissions.id','inventory_sale_details.admission_id')->where('inventory_sale_id',$id)->orderBy('id', 'DESC')->get();

        return view("print_file.invantory.sales_invantory", ["data" => $data,"dataDetail"=>$dataDetail]);
    }

    public function getStudentData(Request $request){
        return Admission::findOrFail($request->stdID);
    }
}
