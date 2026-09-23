<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\Role;
use App\Models\PermissionManagement;
use App\Models\BillCounter;
use App\Models\SmsSetting;
use App\Models\AttendanceStatus;
use App\Models\Setting;
use App\Models\WhatsappSetting;
use App\Models\TeacherAttendance;
use App\Models\Master\MessageTemplate;
use App\Models\City;
use App\Models\Master\Branch;
use App\Models\Master\MessageContent;
use App\Jobs\Job;
use App\Models\Teacher;
use App\Models\TeacherDocuments;
use Session;
use Hash;
use Str;
use Helper;
use File;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller

{
            public function user_dashboard(){
                return view('user/usre_dashboard');
            }
        
            public function userAttendanceView(Request $request){
                $search['name'] = $request->name;
                $search['date'] = !empty($request->date) ? $request->date : date("m");
                $current_date = !empty($request->date) ? $request->date : date("m");
                $curr_yrs = date('Y');	
        		$curr_mnt = $current_date;	
        		$data['monthDate'] = date('t', mktime(0, 0, 0, $curr_mnt, 1, $curr_yrs));
        		$totel_month_day = $data['monthDate'];
    		    $all_teachers = User::where('status', 1)
                ->where('role_id', '!=', 2) // Exclude users with role_id of 2
                ->where('role_id', '!=', 1) // Exclude users with role_id of 2
                ->orderBy('first_name')      // Order by first name
                ->get()
                ->toArray();    
    		    if($request->isMethod('post')){
		            if(!empty($request->name)){
		                $value = $request->name;
        		    	$all_staff =  $all_staff->where(function($query) use ($value){
            	            $query->where("first_name", 'like', '%' .$value. '%');
                            $query->orWhere("last_name", 'like', '%' .$value. '%');
                            $query->orWhere("father_name", 'like', '%' .$value. '%');
                            $query->orWhere("mobile", 'like', '%' .$value. '%');
                            $query->orWhere("email", 'like', '%' .$value. '%');
        		    	}); 
    		        }
    	        }
    		    $atnrecord =array();
    		    if(!empty($all_teachers)){
        		    foreach ($all_teachers as $key => $staff_record) {
    			        $atnrecord[$staff_record['id']] = TeacherAttendance::where('teacher_attendance.staff_id',$staff_record['id'])->whereMonth('teacher_attendance.date',$curr_mnt)->whereYear('teacher_attendance.date',$curr_yrs)->groupby('teacher_attendance.date')->get(['date','staff_id','attendance_status_id'])->keyBy('date')->toArray();
    		        }
    		    }
    		    $AttStatus = AttendanceStatus::get()->keyBy('id')->toArray();
    		    return view('user/users/attendence',['data'=>$atnrecord,'all_teachers'=>$all_teachers,'AttStatus'=>$AttStatus,'curr_yrs'=>$curr_yrs,'curr_mnt'=>$curr_mnt,'totel_month_day'=>$totel_month_day, 'search'=>$search]);
    	    }
    
            public function addUser(Request $request){
                $BillCounter = BillCounter::where('type','Teacher')->where('branch_id',Session::get('branch_id'))
                ->where('session_id',Session::get('session_id'))->get()->first();
                $users = User::all();
                $total_user = count($users);
                $branch = Branch::all();
                if($request->isMethod('post')){
                    $request->validate([
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'mobile' => 'required',
                        'state' => 'required',
                        'city' => 'required',
                        'userName'  => 'required|unique:users,userName',
                        'password' => 'required|same:confirm_password|min:4',
                        'confirm_password' => 'required|same:password|min:4',
                        'role_id' => 'required',
                        'sidebar_id' => 'required',
                        'email' => 'required',
                        'address' => 'required',
                    ]);
                    $photo ='';
                    if($request->file('photo')){
                        $image = $request->file('photo');
                        $path = $image->getRealPath();      
                        $photo =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                        $image->move($destinationPath, $photo);     
                    }
                    if($request->role_id == 2){
                        $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0 ;
                        $BillCounter->counter = $counter + 1 ;
                        $BillCounter->save();
                        $teacher = new Teacher;
                        $teacher->user_id = Session::get('id');
                        $teacher->branch_id = Session::get('branch_id');
                        $teacher->session_id = Session::get('session_id');
                        $teacher->UniqueId = $counter + 1;
                        $teacher->userName = $request->userName;
                        $teacher->password = $request->password;
                        $teacher->first_name = $request->first_name;
                        $teacher->last_name = $request->last_name;
                		$teacher->mobile = $request->mobile;
                		$teacher->email = $request->email;
                		$teacher->dob = $request->dob;
                		$teacher->joining_date = date('Y-m-d');
                        $teacher->save();
                        $teacherId = $teacher->id;
                    }
                    else{
                        $teacherId = null;
                    }     
                    $add_user = new User;//model name
                    $add_user->session_id = Session::get('session_id');
                    if(!empty($request->branch_id)){
                        $add_user->branch_id =$request->branch_id;
                    }
                    else{
                        $add_user->branch_id = Session::get('branch_id');     
                    }
                    $add_user->teacher_id = $teacherId;
                    $add_user->userName =$request->userName;
            		$add_user->first_name =$request->first_name;
            		$add_user->last_name =$request->last_name;
            		$add_user->city_id= $request->city;
                	$add_user->country_id= $request->country_id;
                	$add_user->state_id= $request->state;
            		$add_user->mobile= $request->mobile;
            		$add_user->address  = $request->address;
            		$add_user->role_id  = $request->role_id;
            		$add_user->email  = $request->email;
            		$add_user->password  =  Hash::make($request->password);
            		$add_user->confirm_password  = $request->confirm_password;
            		$add_user->image = $photo;
            		$add_user->status  = 1;
            		$add_user->salary  = $request->salary;
            		$add_user->save();
                    $user_id = $add_user->id;
            		if($request->role_id == 2){
            	        $document_upl = new TeacherDocuments;//model name
                        $document_upl->session_id = Session::get('session_id');
                        $document_upl->branch_id = Session::get('branch_id');
                        $document_upl->teacher_id = $teacherId;
                        $document_upl->user_id = $user_id;
                        $document_upl->joining_date = date('Y-m-d');
                        $document_upl->photo = $photo;
                        $document_upl->Id_proof_img = null;
                        $document_upl->qualification_proof_img = null;
                        $document_upl->experience_letter_img = null;
                        $document_upl->save();
            		}
                    $sidebar_id = '';
            		if(!empty($request->sidebar_id)){
            		    if($request->role_id == 2){
            		        $sidebarIds = implode(',', $request->sidebar_id);
            		        $sidebar_id = $sidebarIds . ',' ."23";
            		    }
            		    else{
            		        $sidebar_id = implode(',', $request->sidebar_id);
            		    }
            		}
                    $sidebar_sub_id = null;
                    if(!empty($request->sidebar_sub_id)){
                        $sidebar_sub_id = implode(',', $request->sidebar_sub_id);
                    }
                    $add_pr = new PermissionManagement;
                    $add_pr->reg_user_id = $user_id;
            		$add_pr->sidebar_id = $sidebar_id;
            		$add_pr->sidebar_sub_id = $sidebar_sub_id;
            		$add_pr->edit  = $request->has('edit');
            		$add_pr->deletes  = $request->has('delete'); 
            		$add_pr->download  = $request->has('download');
            		$add_pr->save(); 
		            $template =  MessageTemplate::Select('message_templates.*','message_types.slug')
                    ->leftjoin('message_types','message_types.id','message_templates.message_type_id')
                    ->where('message_types.status',1)->where('message_types.slug','User')->first();
                    $branch = Branch::find(Session::get('branch_id'));
                    $setting = Setting::where('branch_id',Session::get('branch_id'))->first();
                    $role_name = Role::where('id',$request->role_id)->first();
                    $arrey1 =   array(
                        '{#name#}',
                        '{#user_name#}',
                        '{#password#}',
                        '{#email#}',
                        '{#role#}',
                        '{#address#}',
                        '{#mobile_no#}', 
                        '{#support_email#}',
                        '{#school_name#}',
                        '{#support_no#}');
                    $arrey2 = array(
                        $request->first_name.' '.$request->last_name,
                        $request->userName,
                        $request->password,
                        $request->email,
                        $role_name->name,
                        $request->address,
                        $request->mobile,
                        $setting->gmail,
                        $setting->name,
                        $setting->mobile);
                    if (!empty($template) && $template->status != 1) {
                        if($request->email != ""){
                            if($branch->email_srvc != 0){
                                if($template->email_status != 0){
                                    $message = str_replace($arrey1,$arrey2,$template->email_content);
                                    $emailData = ['email' => $request->email, 'data' => $message, 'subject' => $template->title];
                                    Helper::sendMail('email_print.template_print', $emailData);
                                } 
                            } 
                        }
                        if($branch->whatsapp_srvc != 0){
                            if ($request->mobile != ""){
                                if($template->whatsapp_status != 0){
                                    $whatsapp = str_replace($arrey1,$arrey2,$template->whatsapp_content);
                                    Helper::sendWhatsappMessage($request->mobile,$whatsapp);
                                }
                            }
                        }
                        if($branch->sms_srvc != 0){
                            if($request->mobile != ""){
                                if($template->sms_status != 0){
                                    $sms = str_replace($arrey1,$arrey2,$template->sms_content);
                                    Helper::SendMessage($request->mobile, $sms);
                                }
                            }
                        }    
                    }                
                     return redirect::to('viewUser')->with('message', 'User added Successfully.');
                }
                return view('user.users.add',['branch'=>$branch,'total_user'=>$total_user]);
            }
            public function viewUser(Request $request){
                $search['name'] = $request->name;
                $search['role_id'] = $request->role_id;
                //   $users =  User::with('roleName')->where('session_id', Session::get('session_id'));
                $users =  User::with('roleName');
                if(Session::get('role_id') > 1){
                    $users = $users->where('branch_id', Session::get('branch_id'));
                }
                if (!empty(Session::get('admin_branch_id'))) {
                    $users = $users->where('branch_id', Session::get('admin_branch_id'));
                }
		        if($request->isMethod('post')){
		            if(!empty($request->name)){
    	                $value = $request->name;
            		    $users->where(function($query) use ($value){
                		    $query->where('first_name', 'like', '%'.$value.'%');
                            $query->orWhere('last_name', 'like', '%'.$value.'%');
                            $query->orWhere('mobile', 'like', '%'.$value.'%');
                            $query->orWhere('email', 'like', '%'.$value.'%');
                            $query->orWhere('father_name', 'like', '%'.$value.'%');
                            $query->orWhere('address', 'like', '%'.$value.'%');
        		        });
		            }       
        		    if(!empty($request->role_id)){
        		        $users->where('role_id',$request->role_id);
        		    }
		        }
                $all_user = $users->orderBy('id','DESC')->get();
	            return view('user.users.view',['data'=>$all_user, 'search'=>$search]);
            }
    
            public function editUser(Request $request,$id){
                $branch = Branch::all();
                $data = User::find($id);
                $getcitie = City::where('state_id',$data['state_id'])->get();
                $add_pr = PermissionManagement::where('reg_user_id',$id)->get()->first();
                if($request->isMethod('post')){
                    $request->validate([
                      /*'usre_name'  => 'required|unique:users,userName,'.$id,
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'mobile' => 'required',
                        'state' => 'required',
                        'city' => 'required',
                        'password' => 'required|same:confirm_password|min:4',
                        'confirm_password' => 'required|same:password|min:4',
                        'role_id' => 'required',*/
                    ]);
                    if($request->file('photo')){
                        $image = $request->file('photo');
                        $path = $image->getRealPath();      
                        $photo =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                        $image->move($destinationPath, $photo);  
                        if(File::exists(env('IMAGE_UPLOAD_PATH').'profile/'.$data->image)){
                            File::delete(env('IMAGE_UPLOAD_PATH').'profile/'.$data->image);
                        }      
                        $data->image = $photo;
                    } 
                    $data->session_id = Session::get('session_id');
                    if(!empty($request->branch_id)){
                        $data->branch_id =$request->branch_id;
                    }else{
                        $data->branch_id = Session::get('branch_id');     
                    }            
                    $data->userName =$request->userName;
            		$data->first_name =$request->first_name;
            		$data->last_name =$request->last_name;
            		$data->city_id= $request->city;
                	$data->country_id= $request->country_id;
                	$data->state_id= $request->state;
            		$data->mobile= $request->mobile;
            		$data->address  = $request->address;
                    //$data->role_id  = $request->role_id;
            		$data->email  = $request->email;
            		$data->password  =  Hash::make($request->password);
            		$data->confirm_password  = $request->confirm_password;
            		$data->salary  = $request->salary;
            		$data->save();
		            $sidebar_id = '';
            		if(!empty($request->sidebar_id)){
        		        if($data->role_id == 2){
        		            $sidebarIds = implode(',', $request->sidebar_id);
        		            $sidebar_id = $sidebarIds . ',' ."23";
        		        }
        		        else{
        		            $sidebar_id = implode(',', $request->sidebar_id);
        		        }
            		}
                    $sidebar_sub_id= null;
                    if($data->role_id == 2){
                        $teacher = Teacher::find($data->teacher_id);
                        $teacher->userName = $request->userName;
                        $teacher->password = $request->password;
                        $teacher->first_name = $request->first_name;
                        $teacher->last_name = $request->last_name;
                		$teacher->mobile = $request->mobile;
                		$teacher->email = $request->email;
                        //$teacher->dob = $request->dob;
                        $teacher->save();
                        $teacherId = $teacher->id;
                    }
                    else{
                        $teacherId = null;
                    }
                    if(!empty($request->sidebar_sub_id)){
                        $sidebar_sub_id = implode(',', $request->sidebar_sub_id);
                    }
                    if($add_pr == Null ){
                        $add_pr = new PermissionManagement;//model name
                    }
                    $add_pr->reg_user_id = $id;
            		$add_pr->sidebar_id = $sidebar_id;
            		$add_pr->sidebar_sub_id = $sidebar_sub_id;
            		$add_pr->edit  = $request->has('edit');
            		$add_pr->deletes  = $request->has('delete'); 
            		$add_pr->download  = $request->has('download');
            		$add_pr->save(); 
                    return redirect::to('viewUser')->with('message', 'User Updated Successfully.');
                }
                return view('user.users.edit',['data'=>$data,'add_pr'=>$add_pr, 'branch'=>$branch,'getcitie'=>$getcitie]);
            }
    
            public function deleteUser(Request $request){
                $id = $request->delete_id;
                // TeacherDocuments::where('user_id',$id)->delete();
                $students = User::find($id);
                Teacher::where('id',$students->teacher_id)->delete();
                /*if(File::exists(env('IMAGE_UPLOAD_PATH').'profile/'.$students->image)){
                    File::delete(env('IMAGE_UPLOAD_PATH').'profile/'.$students->image);
                } */ 
                $students->delete();
                //PermissionManagement::where('reg_user_id',$id)->delete();
                return redirect::to('viewUser')->with('message', 'User Deleted Successfully.');
            }
    
            public function userStatus(Request $request){
                $data = User::where('id',$request->id)->update(['status'=> $request->status_id]);
                return redirect::to('viewUser')->with('message', 'Status Changed Successfully.');
            }
    
            public function userSidePer(Request $request){
                $sidebar_id = Role::where('id',$request->role_id)->pluck('sidebar_id')->first();
                echo $sidebar_id;
            }  
  
}    