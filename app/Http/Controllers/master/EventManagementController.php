<?php

namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\EventManagement;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventManagementController extends Controller

{
    

    public function view(Request $request){
                $data =  EventManagement::with('ClassType') ->where('session_id',Session::get('session_id'))
		 ->where('branch_id',Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('master.event_management.view',['data'=>$data]);
    }    
    
    public function add(Request $request){
         if($request->isMethod('post')){
                 $request->validate([
            
           'class_type_id' => 'required',
            'student_name' => 'required',
            'event_name' => 'required',
           
         ]);

    
       
        $add = new EventManagement;//model name
        $add->user_id = Session::get('id');
        $add->session_id = Session::get('session_id');
        $add->branch_id = Session::get('branch_id');
		$add->class_type =$request->class_type_id;
		$add->student_name =$request->student_name;
		$add->event_name =$request->event_name;
			$add->save();

        return redirect::to('event_management_view')->with('message', 'EventManagement added Successfully.');
        }

        return view('master.event_management.add');
    } 

 public function delete(Request $request){
               $book = EventManagement::find($request->delete_id)->delete();
                return redirect::to('event_management_view')->with('message', 'EventManagement Deleted Successfully.');
    }


    public function edit(Request $request, $id){
         $data = EventManagement::find($id);
                if($request->isMethod('post')){
                 $request->validate([
            
            'class_type_id' => 'required',
            'student_name' => 'required',
            'event_name' => 'required',
           
         ]);

           
        $data->session_id = Session::get('session_id');
        $data->branch_id = Session::get('branch_id');    
		$data->class_type =$request->class_type_id;
		$data->student_name =$request->student_name;
		$data->event_name =$request->event_name;
	
		$data->save();

        return redirect::to('event_management_view')->with('message', 'EventManagement Updated Successfully.');
        }

        return view('master.event_management/edit',['data'=>$data]);
    } 


    
}
