<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\SidebarSub;
use App\Models\User;
use App\Models\Dashboard;
use App\Models\FeesMaster;
use App\Models\TeacherAttendance;
use App\Models\StudentAttendance;
use App\Models\Teacher;
use App\Models\PermissionManagement;
use App\Models\Enquiry;
use App\Models\hostel\HostelAssign;
use App\Models\Admission;
use App\Models\FeesDiscount;
use App\Models\library\LibraryAssign;
use App\Helpers\helper;
use Session;
use Hash;
use Str;
use Redirect;
use Response;
use Auth;
use App\Models\FeesDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller

{
    
    public function dashboard(){

        
        
        //if(!Session::get('lastVisitDate') || Session::get('lastVisitDate') !== date('Y-m-d')){ return $this->showAuthentication(); }

        $current_date = date('Y-m-d');
        $result = array();
        $barnch =Session::all();
        if(!empty(Session::get('admin_branch_id'))) {
               $branch_id = Session::get('admin_branch_id');
            }else{
               $branch_id = Session::get('branch_id');
            }
        if($barnch['role_id'] == 1){
            $result['today_p_teacher'] = TeacherAttendance::where('branch_id' ,'=', $branch_id)->where('attendance_status_id',1)->where('date',$current_date)->count('id');
            $result['today_p_student'] = StudentAttendance::where('branch_id' ,'=', $branch_id)->where('attendance_status_id',1)->where('date',$current_date)->count('id');
            $result['teacher'] = Teacher::where('branch_id' ,'=', $branch_id)->count('id');
            $result['teacher'] = Enquiry::where('branch_id' ,'=', $branch_id)->count('id');
            return view('dashboard.admin_dashboard',['result'=>$result],['current_date'=>$current_date]);            
        }
        elseif($barnch['role_id'] == 2){
            return view('dashboard.teacher_dashboard',['result'=>$result]);
        } 
        elseif($barnch['role_id'] == 3){
            $hostelDeatils = HostelAssign::select('hostel_assign.*','hostel.name as hostel_name','building.name as building_name',
                        'floor.name as floor_name','room.name as room_name','bed.name as bed_name')
                        ->leftJoin('hostel','hostel.id','hostel_assign.hostel_id')
                        ->leftJoin('hostel_building as building','building.id','hostel_assign.building_id')
                        ->leftJoin('hostel_floor as floor','floor.id','hostel_assign.floor_id')
                        ->leftJoin('hostel_room as room','room.id','hostel_assign.room_id')
                        ->leftJoin('hostel_bed as bed','bed.id','hostel_assign.bed_id')
                        ->where('hostel_assign.id',$barnch['id'])
                        ->where('hostel_assign.branch_id',Session::get('branch_id'))
                        ->where('hostel_assign.session_id',Session::get('session_id'))
                        ->first();

            $result['feesDetail'] = FeesDetail::select('fees_detail.*')
                        ->leftJoin('admissions as admission','admission.id','fees_detail.admission_id')
                ->where('fees_detail.admission_id', $barnch['id'])->get(); 
                
                $class_type = Admission::where('id',$barnch['id'])->first();
                
             
                
            $result['school_fees'] = FeesMaster::select('fees_master.*','group.name as group_name')
                ->leftJoin('fees_group as group','group.id','fees_master.fees_group_id')
                ->where('fees_master.class_type_id', $class_type->class_type_id)->get(); 
            $result['hostel_fees'] = HostelAssign::where('admission_id', $barnch['id'])->get(); 
            $result['library_fees'] = LibraryAssign::where('admission_id', $barnch['id'])->get(); 
                
            
        if(empty($class_type->student_profile_update) || $class_type->student_profile_update == 'no'){
                    return redirect::to('profile/edit/'.$class_type->id)->with('error', 'Please Update Profile.');

        }
                    
              //  dd($result['assigned_fees']);
            
            return view('dashboard.student_dashboard',['result'=>$result,'hostelDeatils'=>$hostelDeatils]);
        }
        elseif($barnch['role_id'] == 4){
            return view('dashboard.libraryAdmin_dashboard',['result'=>$result]);
        }     
        elseif($barnch['role_id'] == 5){
            return view('dashboard.hostelAdmin_dashboard',['result'=>$result]);
        } 
        elseif($barnch['role_id'] == 6){
            return view('dashboard.admin_dashboard',['result'=>$result]);
        } 
        elseif($barnch['role_id'] == 7){
            return view('dashboard.transportAdmin_dashboard',['result'=>$result]);
        } 
        /*elseif($barnch['role_id'] == 8){
            return view('dashboard.libraryAdmin_dashboard',['result'=>$result]);
        }*/  
        elseif($barnch['role_id'] == 9){
            return view('dashboard.accountant_dashboard',['result'=>$result]);
        } 
        elseif($barnch['role_id'] == 10){
            return view('dashboard.otherSchoolStaff_dashboard',['result'=>$result]);
        }         
        else{
            return view('dashboard.else_dashboard',['result'=>$result]);
        }
     
      
    }

    public function sendAttendanceStatus(){
        
        //$dateTime = date('l jS \of F Y');
        $dateTime = date('l');
        $date = date('Y-m-d');
       /* $adminMail = User::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('role_id','1')->get()->first();*/    
        $staff = TeacherAttendance::with('Teacher')->where('session_id',5)->where('branch_id',1)->where('date',$date)->get();    
            
         

           if($dateTime !== 'Sunday'){
               
      
            $emailData = ['email' => 'skwork91@gmail.com','staff' => $staff,'dateTime' => $dateTime,'subject' => 'Today Staff Attendance.'];
            Helper::sendMail('email_print.admin.send_attendance_status', $emailData);

            $emailData = ['email' => 'veonkumawat@gmail.com','staff' => $staff,'dateTime' => $dateTime,'subject' => 'Today Staff Attendance.'];
            Helper::sendMail('email_print.admin.send_attendance_status', $emailData);
           } 
        return view('test',['staff'=>$staff,'dateTime'=>$dateTime]);
    }  

     public function discountdata(Request $request,$id){
         
        if(!empty($id)){
         
            $data = FeesDiscount::where('id',$id)->get()->first();
            
            $feesDiscount =$data['amount'];
    
           echo $feesDiscount;
            
           } 
    }
    
     public function duedate(Request $request,$id){
         
        if(!empty($id)){
         
            $data = FeesMaster::where('id',$id)->get()->first();
            
            $dueDate =$data['due_date'];
    
           echo $dueDate;
            
           } 
    }
    
    public function allStudentsSearch(Request $request){
        $value = $request->name;
        $data['Student'] = Admission::with('ClassTypes')->where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))
                ->where(function($query) use ($value){
    		        $query->where('first_name', 'like', '%' .$value. '%');
                    $query->orWhere('last_name', 'like', '%' .$value. '%');
                    $query->orWhere('mobile', 'like', '%' .$value. '%');
                    $query->orWhere('aadhaar', 'like', '%' .$value. '%');
                    $query->orWhere('email', 'like', '%' .$value. '%');
                    $query->orWhere('father_name', 'like', '%' .$value. '%');
                    $query->orWhere('mother_name', 'like', '%' .$value. '%');
                    $query->orWhere('address', 'like', '%' .$value. '%');
        		})->get();

        $data['Teacher'] = Teacher::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))
                ->where(function($query) use ($value){
    		        $query->where('first_name', 'like', '%' .$value. '%');
                    $query->orWhere('last_name', 'like', '%' .$value. '%');
                    $query->orWhere('mobile', 'like', '%' .$value. '%');
                    $query->orWhere('aadhaar', 'like', '%' .$value. '%');
                    $query->orWhere('email', 'like', '%' .$value. '%');
                    $query->orWhere('father_name', 'like', '%' .$value. '%');
                    $query->orWhere('address', 'like', '%' .$value. '%');
        		})->get();

        $data['User'] = User::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))
                ->where(function($query) use ($value){
    		        $query->where('first_name', 'like', '%' .$value. '%');
                    $query->orWhere('last_name', 'like', '%' .$value. '%');
                    $query->orWhere('mobile', 'like', '%' .$value. '%');
                    $query->orWhere('email', 'like', '%' .$value. '%');
                    $query->orWhere('father_name', 'like', '%' .$value. '%');
                    $query->orWhere('address', 'like', '%' .$value. '%');
        		})->get();
        		
        $data['SidebarSub'] = SidebarSub::where(function($query) use ($value){
    		        $query->where('sidebar_name', 'like', '%' .$value. '%');
                    $query->orWhere('name', 'like', '%' .$value. '%');
                    $query->orWhere('url', 'like', '%' .$value. '%');
        		})->get();
      return  view('dashboard.admin.all_students',['data'=>$data]);
    }   

    public function taskList(){
        return view('task_list');
    }

    
    public function studentDetail($id){
         $studentDetail = Admission::with('ClassTypes')->with('Section')->find($id);
         $feesDetail =  FeesDetail::with('PaymentMode')->with('FeesCollect')->with('FeesType')->where('admission_id', $id)->where('branch_id',Session::get('branch_id'))->get();
        return view('dashboard.admin.student_detail',['data'=>$studentDetail,'feesDetail'=>$feesDetail]);
    }

    public function stuStatus(Request $request){
        
       if($request->id >0){
        $uniqueId = Admission::findOrFail($request->id);
        $data = Admission::where('unique_system_id',$uniqueId->unique_system_id)->update(['status'=>$request->status]);
       if(!empty($data)){
       echo json_encode(1);
            }else{
                 echo json_encode(0);
            }
        }else{
        echo json_encode(2);
        }
        
    }       


    
    public function minidashboard(){
        return view('dashboard.minidashboard');
    }

    public function getModules(Request $request){
        if($request->isMethod('post')){
            $value = $request->name;
            
            $data = SidebarSub::where(function($query) use ($value){
		        $query->where('sidebar_name', 'like', '%' .$value. '%');
                $query->orWhere('name', 'like', '%' .$value. '%');
                $query->orWhere('url', 'like', '%' .$value. '%');
    		})->get();
    		
    		$sub_id = []; 
    		
    		foreach($data as $item){
    		    $sub_id[] = $item->id;
    		}
    		
    		$getModules = [];
    		
    		$find_permission = PermissionManagement::where('reg_user_id',Session::get('id'))->first();
    		foreach(explode(',', $find_permission->sidebar_sub_id) as $id){
    		    foreach($sub_id as $subId){
    		        if($id == $subId){
    		            $getModules[] = $subId;
    		        }
    		    }
    		}
    		
    		$modules = SidebarSub::whereIn('id',$getModules)->get();
    	//dd($modules);
    		   $html ='';
    		   
            foreach($modules as $item)
            {
                
               $html .= '<div class="col-md-2 info-box mb-3 bg-warning">';
                $html .= '<a href="'.htmlspecialchars(url($item->url), ENT_QUOTES, 'UTF-8') . '" class="d-flex">';
                $html .= '<span class="info-box-icon"><i class="fa '.htmlspecialchars($item->ican, ENT_QUOTES, 'UTF-8') . '"></i></span>';
                $html .= '<div class="info-box-content">';
                $html .= '<span class="info-box-text" style="font-size: 12px; white-space: break-spaces;">' . htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8') . '</span>';
                $html .= '<span class="info-box-number" style="font-size: 12px;">5,200</span>';
                $html .= '</div>';
                $html .= '</a>';
                $html .= '</div>';

               
                 
            }
           echo $html;
    		
    	
        }
    }

    public function test(Request $request){
        
        // $data = Admission::get();
        
        // foreach($data as $item){
        //     $admission = Admission::find($item->id);
        //     $admission->password = Hash::make($item->userName);
        //     $admission->save();
        // }
        dd('ok');
    }

	
}
