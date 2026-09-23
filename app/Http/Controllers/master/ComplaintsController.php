<?php

namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\Complaint;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplaintsController extends Controller

{
    

    public function add(Request $request){
        
        $Complaints =  Complaint::where('session_id',Session::get('session_id'))
                             ->where('branch_id',Session::get('branch_id'))->orderBy('id', 'DESC')->get();
        return view('master.complaints.add',['data'=>$Complaints]);
    }    
    

    
    
}
