<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Profile;
use App\Models\Admission;
use Helper;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller

{
    public function profileEdit(Request $request,$id){
      if(Session::get('role_id')==3){
          $data = Admission::find($id);
      }else{
          $data = User::find($id);
      }
        
            if($request->isMethod('post')){
                $request->validate([
                    'first_name' => 'required',
                    'mobile' => 'required',
                    'email' => 'required',
                    //'aadhaar' => 'required',
                    'gender_id' => 'required',
                    'dob' => 'required',
                    'father_name' => 'required',
                    'mother_name' => 'required',
                    //'father_mobile' => 'required',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city_id' => 'required',
                    //'address' => 'required',
                    //'pincode' => 'required',
                    
                ]);
                
                if(Session::get('role_id')==3){
                    if($request->file('photo')){
                    $image = $request->file('photo');
                    $path = $image->getRealPath();      
                    $student_image =  time().uniqid().$image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                    $image->move($destinationPath, $student_image); 
                    $data->image = $student_image;
                 }
                 
                    if($request->file('father_img')){
                     $image = $request->file('father_img');
                    $path = $image->getRealPath();      
                    $father_image =  time().uniqid().$image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH').'father_image';
                    $image->move($destinationPath, $father_image);    
                    $data->father_img = $father_image;
                 }
                 
                    if($request->file('mother_img')){
                     $image = $request->file('mother_img');
                    $path = $image->getRealPath();      
                    $mother_image =  time().uniqid().$image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH').'mother_image';
                    $image->move($destinationPath, $mother_image);  
                    $data->mother_img = $mother_image;
                 }                  
                 }
                 
                 else{
                    if($request->file('photo')){
                        $image = $request->file('photo');
                        $path = $image->getRealPath();      
                        $photo =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                        $image->move($destinationPath, $photo); 
                        $data->image = $photo;
                    }
                }           

            $data->session_id = Session::get('session_id');
            $data->branch_id = Session::get('branch_id');
            $data->first_name =$request->first_name;
            $data->last_name =$request->last_name;
            $data->dob= $request->dob;
            $data->email =$request->email;
            $data->id_number =$request->aadhaar;
            $data->mobile =$request->mobile;
            $data->father_name =$request->father_name;
            $data->father_mobile =$request->father_mobile;
            $data->mother_name =$request->mother_name;
            $data->mother_name =$request->mother_name;
            $data->father_mobile = $request->father_mobile;
            $data->city_id= $request->city_id;
        	$data->country_id= $request->country_id;
        	$data->state_id= $request->state_id;
    		$data->pincode= $request->pincode;
    		$data->address  = $request->address;
    		$data->student_profile_update  = 'yes';
            $data->save();
            
            return redirect::to('/')->with('message', 'Profile Updated Successfully.');
		
        }
        if(Session::get('role_id') == 3){
            return view('profile.student_profile',["data"=>$data]);
        }else{
            return view('profile.profile',["data"=>$data]);
        }
    }

}
















