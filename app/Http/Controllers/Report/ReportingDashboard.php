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

class ReportingDashboard extends Controller

{
    public function reportingDashboard(){
   
        return view('report/index');
 
    }
    public function feesReporting(Request $request){
      $search['name'] = $request->name;
        $search['class_type_id'] = !empty($request->class_type_id) ? $request->class_type_id : 0;
        $search['section_id'] = !empty($request->section_id) ? $request->section_id : 0;
        $search['stream_id'] = !empty($request->stream_id) ? $request->stream_id : 0;
        $search['session_id'] = !empty($request->session_id) ? $request->session_id : 0;
        $search['counter_id'] = !empty($request->counter_id) ? $request->counter_id : 0;
          $allStudent =  Admission::Select('admissions.*','class_types.name as class_name')
                            ->leftjoin('class_types','class_types.id','admissions.class_type_id')->where('admissions.status',1)->orderBy('class_types.id','ASC')->get();
                            
                            $data = FeesDetail::Select('fees_detail.*','sessions.to_year as session_to_year','sessions.from_year as session_from_year','fees_assigns.net_amount as assign_amount','fees_collect.amount as total_collect','class_types.name as class_name','admissions.first_name','admissions.last_name','admissions.admissionNo','admissions.father_name','admissions.id as admission_id','admissions.mobile as mobile')
                            ->leftjoin('fees_collect','fees_collect.id','fees_detail.fees_collect_id')
                            ->leftjoin('fees_assigns','fees_assigns.id','fees_collect.fees_assign_id')
                            ->leftjoin('admissions','admissions.id','fees_detail.admission_id')
                            ->leftjoin('sessions','sessions.id','fees_collect.session_id')
                            ->leftjoin('class_types','class_types.id','admissions.class_type_id');
                           
                      
                            
                        
         if ($request->isMethod('post')) {
             
          
                 
              if ($request->button_value == 'Search') {
                 $request->validate([

                'session_id' => 'required',
            ]);
            
            if (!empty($request->name)) {
                $data = $data->where('first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->name . '%')
                    ->orWhere('mobile', 'like', '%' . $request->name . '%')
                    ->orWhere('aadhaar', 'like', '%' . $request->name . '%')
                    ->orWhere('email', 'like', '%' . $request->name . '%')
                    ->orWhere('father_name', 'like', '%' . $request->name . '%')
                    ->orWhere('mother_name', 'like', '%' . $request->name . '%')
                    ->orWhere('address', 'like', '%' . $request->name . '%');
                    
            }
                 if (!empty($request->class_type_id)) {
              
                $data = $data->where('admissions.class_type_id', $request->class_type_id);
               
            }
            if (!empty($request->session_id)) {
              
                $data = $data->where('fees_detail.session_id', $request->session_id);
               
            }
            
              $data =  $data->groupBy('fees_detail.admission_id')->get();
                 
            
                        return view('report/fees_reporting',['search'=>$search,'fees'=>$data,'allStudent'=>$allStudent]);
            
                  
              }
              
              
              
              
              
              if ($request->button_value == 'Counter Search') {
              
                      $request->validate([

              //  'session_id' => 'required',
            ]);
            
            
            if (!empty($request->counter_id)) {
              
                $data = $data->where('fees_detail.fees_counter_id', $request->counter_id);
               
            }
            if (!empty($request->session_id)) {
              
                $data = $data->where('fees_detail.session_id', $request->session_id);
               
            }
            
             $data =  $data->get();
                 
                        return view('report/fees_reporting',['search'=>$search,'fees'=>$data,'allStudent'=>$allStudent]);
              }
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              if ($request->button_value == 'Session') {
                  
                       
                       
              
                      $request->validate([

              //  'session_id' => 'required',
            ]);
                  
                  
                     if (!empty($request->name)) {
                $data = $data->where('first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->name . '%')
                    ->orWhere('mobile', 'like', '%' . $request->name . '%')
                    ->orWhere('aadhaar', 'like', '%' . $request->name . '%')
                    ->orWhere('email', 'like', '%' . $request->name . '%')
                    ->orWhere('father_name', 'like', '%' . $request->name . '%')
                    ->orWhere('mother_name', 'like', '%' . $request->name . '%')
                    ->orWhere('address', 'like', '%' . $request->name . '%');
                    
            }
            if (!empty($request->class_type_id)) {
              
                $data = $data->where('admissions.class_type_id', $request->class_type_id);
               
            }
            if (!empty($request->session_ids)) {
              
              
             
                $data = $data->where('fees_collect.session_id', $request->session_ids);
                
              
            }
            
            if (!empty($request->starting)) {
            $data = $data->whereBetween('date', [$request->starting, $request->ending]);
        }
                        
                       
                    $data1 = $data->groupBy('fees_collect.session_id')->get();
                
               
                    $data =  $data->groupBy('fees_detail.admission_id')->get();
                 
                        return view('report/session',['search'=>$search,'fees'=>$data,'session'=>$data1,'allStudent'=>$allStudent]);
                  
                  
              }
              
             
   
         }
    
        return view('report/fees_reporting',['search'=>$search,'allStudent'=>$allStudent]);
 
    }
    
    public function reporting(Request $request){
        $search['class_type_id'] = $request->class_type_id;
        $search['section_id'] = $request->section_id;
        $search['stream_id'] = $request->stream_id;
        $search['session_id'] =$request->session_id;
        $search['counter_id'] = $request->counter_id;
        $search['starting'] = $request->starting;
        $search['ending'] = $request->ending;
        $search['payment_mode_id'] = $request->payment_mode_id;
        $search['department_id'] = $request->department_id;
  
                            $data = FeesDetail::Select('fees_detail.*','class_types.name as class_name','admissions.first_name','admissions.last_name','admissions.admissionNo','admissions.father_name','admissions.id as admission_id','admissions.mobile as mobile')
                            ->leftjoin('fees_collect','fees_collect.id','fees_detail.fees_collect_id')
                            ->leftjoin('fees_assigns','fees_assigns.id','fees_collect.fees_assign_id')
                            ->leftjoin('admissions','admissions.id','fees_detail.admission_id')
                            ->leftjoin('sessions','sessions.id','fees_collect.session_id')
                            ->leftjoin('class_types','class_types.id','admissions.class_type_id');
                           
                      
            if ($request->isMethod('post')) {
             
               if (!empty($request->starting)) {
                    $data = $data->whereBetween('fees_detail.date', [$request->starting, $request->ending]);
                }
                         
                 if (!empty($request->class_type_id)) {
                    $data = $data->where("admissions.class_type_id", $request->class_type_id);
                }
                if (!empty($request->stream_id)) {
                    $data = $data->where("admissions.stream_id", $request->stream_id);
                }
              
               if (!empty($request->session_id)) {
                  $data = $data->where('fees_detail.session_id', $request->session_id);
               }
               if (!empty($request->payment_mode_id)) {
                $data = $data->where('fees_detail.payment_mode_id', $request->payment_mode_id);
              }
              
              if (!empty($request->department_id)) {
                  if($request->department_id == 'school'){
                      $data = $data->where('admissions.school',1);
                  }
                  if($request->department_id == 'hostel'){
                      $data = $data->where('admissions.hostel',1);
                  }
                  if($request->department_id == 'library'){
                      $data = $data->where('admissions.library',1);
                  }
                
              }
              
              
              
              
            
            
            
            if (!empty($request->PaymentMode)) {
              
            return view('report/report/PaymentMode',['search'=>$search]); 
                
            }
              
              
            
            if (!empty($request->pending_fees)) {
                
                $data1 = Admission::with('ClassTypes');
                        if (!empty($request->admissionNo)) {
                            $data1 = $data1->where("admissionNo", $request->admissionNo);
                        }
                        if (!empty($request->class_type_id)) {
                            $data1 = $data1->where("class_type_id", $request->class_type_id);
                        }
                        
                         if (!empty($request->department_id)) {
                              if($request->department_id == 'school'){
                                  $data1 = $data1->where('admissions.school',1);
                              }
                              if($request->department_id == 'hostel'){
                                  $data1 = $data1->where('admissions.hostel',1);
                              }
                              if($request->department_id == 'library'){
                                  $data1 = $data1->where('admissions.library',1);
                              }
                            
                          }
                           if (!empty($request->stream_id)) {
                                $data1 = $data1->where("admissions.stream_id", $request->stream_id);
                            }
                          
                           if (!empty($request->session_id)) {
                              $data1 = $data1->where('fees_detail.session_id', $request->session_id);
                           }
                           $data1 =  $data1->orderBy('admissions.id')->get();  
            return view('report/report/pending_fees',['search'=>$search,'data'=>$data1]); 
                
            }
                
              
              
              
              
              
              
              
              
              
              
              
              
           
             
   
            }
    $data =  $data->orderBy('admissions.id')->get();
    
        return view('report/report/index',['search'=>$search,'data'=>$data]);
 
    }

 

    
}