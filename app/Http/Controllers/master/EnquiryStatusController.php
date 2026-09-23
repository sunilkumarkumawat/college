<?php

namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\TeacherCategory;
use App\Models\Subject;
use App\Models\Master\SubjectStreams;
use App\Models\Master\EnquiryStatus;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnquiryStatusController extends Controller

{
    

    public function add(Request $request){
      
        if($request->isMethod('post')){
              $request->validate([
           
             'name'  => 'required',

         ]);
         
      
        $EnquiryStatus = new EnquiryStatus;//model name
        $EnquiryStatus->user_id = Session::get('id');
        $EnquiryStatus->session_id = Session::get('session_id');
        $EnquiryStatus->branch_id = Session::get('branch_id');
		$EnquiryStatus->name = $request->name;
        $EnquiryStatus->save();
     
            return redirect::to('enquiry_status_add')->with('message', 'Enquiry Status add Successfully.');
        }
           $data =  EnquiryStatus::whereNull('deleted_at')->get();  	
       
        return view('master.EnquiryStatus.add',['data'=>$data]);
    }    
    
 
    public function edit(Request $request,$id){
       
                $data = EnquiryStatus::find($id);
               
       
                   if($request->isMethod('post')){
                        $request->validate([
                     'name'  => 'required',

                 ]);  
             
                $data->session_id = Session::get('session_id');
                $data->branch_id = Session::get('branch_id');
                $data->name =$request->name;
                $data->save();
                
            return redirect::to('enquiry_status_add')->with('message', 'Enquiry Status Edited Successfully.');
        }
          return view('master.EnquiryStatus.edit',['data'=>$data]);
     }  
   
   
   
 
    public function delete(Request $request){
       
        $id = $request->delete_id;
      
        $sss = EnquiryStatus::find($id)->delete();
       
         return redirect::to('enquiry_status_add')->with('message', 'Enquiry Status  Deleted Successfully.');
    }
    
  
}
