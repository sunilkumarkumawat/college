<?php

namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\Role;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller

{
    

    public function add(Request $request){
        
        if($request->isMethod('post')){
                $request->validate([
             'role'  => 'required',

         ]);



            if(!empty($request->sidebar_id)){
             $sidebar_id = implode(',', $request->sidebar_id);
        }
        
        
        $class = new Role;//model name
        $class->user_id = Session::get('id');
        $class->session_id = Session::get('session_id');
        $class->branch_id = Session::get('branch_id');
		$class->name =$request->role;
        $class->save();
        return redirect::to('role_add')->with('message', 'Add Role add Successfully.');
        }    
        $data = Role::whereNull('deleted_at')->get();
        return view('master.role.add',['role'=>$data]);
    }    
    

     public function edit(Request $request,$id){
         
                $add_pr = Role::find($id);
        if($request->isMethod('post')){
            
             $request->validate([
                 'role'  => 'required',
                 ]);
                 
                $add_pr->user_id =Session::get('id');
                $add_pr->session_id = Session::get('session_id');
                $add_pr->branch_id = Session::get('branch_id');
                $add_pr->name =$request->role;
                $add_pr->save();                

                
            return redirect::to('role_add')->with('message', 'Edit Role  Successfully.');
        }
          return view('master.role.edit',['add_pr'=>$add_pr]);
     }     



     public function delete(Request $request){
       
        $id = $request->delete_id;
       
        $sss = Role::find($id)->delete();
         return redirect::to('role_add')->with('message', 'Role  Delete Successfully.');
    }
 
    
    
}
