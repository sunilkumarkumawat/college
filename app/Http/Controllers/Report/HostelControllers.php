<?php

namespace App\Http\Controllers\Report;
use Illuminate\Validation\Validator; 
use App\Models\Setting;
use App\Models\Admission;
use App\Models\FeesDetail;
use App\Models\fees\FeesAssign;
use App\Models\fees\FeesCollect;
use Session;
use Hash;
use Str;
use Redirect;
use Helper;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class HostelControllers extends Controller

{
 
    public function hostel_reporting(Request $request){
        $search['counter_id'] = $request->counter_id;
        $search['starting'] = $request->starting;
        $search['ending'] = $request->ending;
        $search['payment_mode_id'] = $request->payment_mode_id;
        $search['hostel_id'] = $request->hostel_id;
        $search['building_id'] = $request->building_id;
        $search['floor_id'] = $request->floor_id;
        $search['room_id'] = $request->room_id;
        $search['month_id'] = $request->month_id;
  
                            $data = FeesDetail::Select('fees_detail.*','admissions.first_name','admissions.last_name','admissions.admissionNo',
                            'admissions.father_name','admissions.id as admission_id','admissions.mobile as mobile'
                            ,'hostel_assign.hostel_fees')
                            ->leftjoin('fees_collect','fees_collect.id','fees_detail.fees_collect_id')
                            ->leftjoin('admissions','admissions.id','fees_detail.admission_id')
                            ->leftjoin('hostel_assign','hostel_assign.admission_id','admissions.id')->where('fees_detail.fees_type',1);

                      
            if ($request->isMethod('post')) {
             
               if (!empty($request->starting)) {
                    $data = $data->whereBetween('fees_detail.date', [$request->starting, $request->ending]);
                }
                         
               
               if (!empty($request->payment_mode_id)) {
                $data = $data->where('fees_detail.payment_mode_id', $request->payment_mode_id);
              }
              
              if (!empty($request->hostel_id)) {
                $data = $data->where('hostel_assign.hostel_id', $request->hostel_id);
              }
              if (!empty($request->building_id)) {
                $data = $data->where('hostel_assign.building_id', $request->building_id);
              }
              if (!empty($request->floor_id)) {
                $data = $data->where('hostel_assign.floor_id', $request->floor_id);
              }
              if (!empty($request->room_id)) {
                $data = $data->where('hostel_assign.room_id', $request->room_id);
              }
              if (!empty($request->month_id)) {
                $data = $data->where('fees_detail.month_id', $request->month_id);
              }
    
            
            
           
              
            
            if (!empty($request->pending_fees)) {
                
                        $data = Admission::Select('admissions.*','hostel_assign.hostel_fees')
                        ->leftjoin('fees_detail','fees_detail.admission_id','admissions.id')
                            ->leftjoin('fees_collect','fees_collect.id','fees_detail.fees_collect_id')
                            ->leftjoin('hostel_assign','hostel_assign.admission_id','admissions.id')
                            ->where('fees_detail.fees_type',1);                      
                            
                         if (!empty($request->starting)) {
                            $data = $data->whereBetween('fees_detail.date', [$request->starting, $request->ending]);
                            }
                                     
                           
                           if (!empty($request->payment_mode_id)) {
                            $data = $data->where('fees_detail.payment_mode_id', $request->payment_mode_id);
                          }
                          
                          if (!empty($request->hostel_id)) {
                            $data = $data->where('hostel_assign.hostel_id', $request->hostel_id);
                          }
                          if (!empty($request->building_id)) {
                            $data = $data->where('hostel_assign.building_id', $request->building_id);
                          }
                          if (!empty($request->floor_id)) {
                            $data = $data->where('hostel_assign.floor_id', $request->floor_id);
                          }
                          if (!empty($request->room_id)) {
                            $data = $data->where('hostel_assign.room_id', $request->room_id);
                          }
                          if (!empty($request->month_id)) {
                            $data = $data->where('fees_detail.month_id', $request->month_id);
                          }
       
                           $data =  $data->orderBy('admissions.id')->get();  
            return view('report/report/hostel/pending_fees',['search'=>$search,'data'=>$data]); 
                
            }
                
              
              
              
              
              
              
              
              
              
              
              
              
           
             
   
            }
    $data =  $data->orderBy('admissions.id', 'DESC')->get();
    
        return view('report/hostel/index',['search'=>$search,'data'=>$data]);
 
    }

 public function hostel_pending_fees(Request $request){
        $search['counter_id'] = $request->counter_id;
        $search['starting'] = $request->starting;
        $search['ending'] = $request->ending;
        $search['payment_mode_id'] = $request->payment_mode_id;
        $search['hostel_id'] = $request->hostel_id;
        $search['building_id'] = $request->building_id;
        $search['floor_id'] = $request->floor_id;
        $search['room_id'] = $request->room_id;
        $search['month_id'] = $request->month_id;
  
                
                        $data = Admission::Select('admissions.*','hostel_assign.hostel_fees')
                        ->leftjoin('fees_detail','fees_detail.admission_id','admissions.id')
                            ->leftjoin('fees_collect','fees_collect.id','fees_detail.fees_collect_id')
                            ->leftjoin('hostel_assign','hostel_assign.admission_id','admissions.id')
                            ->where('fees_detail.fees_type',1);                 
                        if ($request->isMethod('post')) {
             
   
                             
                            
                         if (!empty($request->starting)) {
                            $data = $data->whereBetween('fees_detail.date', [$request->starting, $request->ending]);
                            }
                                     
                           
                           if (!empty($request->payment_mode_id)) {
                            $data = $data->where('fees_detail.payment_mode_id', $request->payment_mode_id);
                          }
                          
                          if (!empty($request->hostel_id)) {
                            $data = $data->where('hostel_assign.hostel_id', $request->hostel_id);
                          }
                          if (!empty($request->building_id)) {
                            $data = $data->where('hostel_assign.building_id', $request->building_id);
                          }
                          if (!empty($request->floor_id)) {
                            $data = $data->where('hostel_assign.floor_id', $request->floor_id);
                          }
                          if (!empty($request->room_id)) {
                            $data = $data->where('hostel_assign.room_id', $request->room_id);
                          }
                          if (!empty($request->month_id)) {
                            $data = $data->where('fees_detail.month_id', $request->month_id);
                          }
       
                
            }else{
            $data = $data->where('fees_detail.month_id', date('m'));
                    $search['month_id'] = date('m');

            }
                
              
              
              
                                         $data =  $data->orderBy('admissions.id')->get();  

              
            //  dd($data);
              
              $admissions=[];
      foreach($data as $value){
       
            $admissions[] = $value['id'];
        }
              
              
              
              $data_old = Admission::Select('admissions.*','hostel_assign.hostel_fees')
                            ->leftjoin('hostel_assign','hostel_assign.admission_id','admissions.id')
                            ->where('admissions.hostel',1)->whereNotIn('admissions.id',$admissions)->get();
                      

                         return view('report/hostel/pending_fees',['search'=>$search,'data'=>$data,'data_old'=>$data_old]); 

   


    }

    
}