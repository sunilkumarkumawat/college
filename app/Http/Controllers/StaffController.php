<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Teacher;
use App\Models\TeacherDocuments;
use App\Models\SalaryDocument;
use App\Models\BillCounter;
use App\Models\SmsSetting;
use App\Models\Setting;
use App\Models\WhatsappSetting;
use App\Models\PermissionManagement;
use App\Models\Master\MessageTemplate;
use App\Models\Master\Branch;
use Helper;
use Session;
use Hash;
use Str;
use PDF;
use Redirect;
use Auth;
use File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Spatie\DataUrl\DataUrl;

class StaffController extends Controller

{
            public function staffFile(){
                return view('staff/staff_dashboard');
            }
    
            public function add(Request $request){
                $BillCounter = BillCounter::where('type','Teacher')->where('branch_id',Session::get('branch_id'))->where('session_id',Session::get('session_id'))->get()->first();
                if($request->isMethod('post')){
                    $request->validate([
                        'UniqueId' => 'required',
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'gender_id' => 'required',
                        //'email' => 'required',
                        //'aadhaar' => 'required|unique:teachers,aadhaar',
                        'dob' => 'required',
                        'mobile' => 'required|unique:teachers,mobile',
                        'father_name' => 'required',
                        'qualification'  => 'required',
                        'userName'  => 'required|unique:users,userName',
                        'password' => 'required|min:4'
                    ]);
                    $photo = null;
                        if($request->file('photo')){
                        $image = $request->file('photo');
                        $path = $image->getRealPath();      
                        $photo =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                        $image->move($destinationPath, $photo);     
                    }
                    $experience_letter = null;
                        if($request->file('experience_letter')){
                        $image = $request->file('experience_letter');
                        $path = $image->getRealPath();      
                        $experience_letter =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/experience_letter';
                        $image->move($destinationPath, $experience_letter); 
                    }
                    $qualification_proof = null;
                        if($request->file('qualification_proof')){
                        $image = $request->file('qualification_proof');
                        $path = $image->getRealPath();      
                        $qualification_proof =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/qualification_proof';
                        $image->move($destinationPath, $qualification_proof);     
                    }
                    $id_proof = null;
                        if($request->file('id_proof')){
                        $image = $request->file('id_proof');
                        $path = $image->getRealPath();      
                        $id_proof =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/id_proof';
                        $image->move($destinationPath, $id_proof);     
                    }
                    $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0 ;
                    $BillCounter->counter = $counter + 1 ;
                    $BillCounter->save();
                    $teacher = new Teacher;//model name
                    $teacher->session_id = Session::get('session_id');
                    $teacher->branch_id = Session::get('branch_id');
                    $teacher->UniqueId = $request->UniqueId;
                    $teacher->userName = $request->userName;
                    $teacher->first_name = $request->first_name;
                    $teacher->last_name = $request->last_name;
                    $teacher->password = $request->password;
            		$teacher->gender_id =$request->gender_id;
            		$teacher->dob =$request->dob;
            		$teacher->joining_date =$request->joining_date;
            		$teacher->refer_name =$request->refer_name;
            		$teacher->refer_address =$request->refer_address;
            		$teacher->refer_mobile =$request->refer_mobile;
            		$teacher->father_name =$request->father_name;
            		$teacher->class_type_id=serialize($request->class_type_id);
            		$teacher->email =$request->email;
            		$teacher->mobile =$request->mobile;
            		$teacher->address =$request->address;
            		$teacher->qualification =$request->qualification;
            		$teacher->medical_leave =$request->medical_leave;
            		$teacher->casual_leave =$request->casual_leave;
            		$teacher->other_leave =$request->other_leave;
            		$teacher->aadhaar =$request->aadhaar;
            		$teacher->pan_no =$request->pan_card;
            		$teacher->bank_name =$request->bank;
            		$teacher->account_no =$request->account_no;
            		$teacher->ifsc_code =$request->ifsc_code;
            		$teacher->salary =$request->salary;
                    $teacher->save();
                    $teacher_id = $teacher->id;
                    $teacher_us = new User;//model name
                    $teacher_us->session_id = Session::get('session_id');
                    $teacher_us->branch_id = Session::get('branch_id');
                    $teacher_us->teacher_id = $teacher_id;
            		$teacher_us->first_name = $request->first_name;
            		$teacher_us->last_name = $request->last_name;
            		$teacher_us->email  = $request->email;
            		$teacher_us->mobile  = $request->mobile;
            		$teacher_us->role_id  = 2;
                    $teacher_us->dob = $request->dob;
                    $teacher_us->image = $photo;
                    $teacher_us->father_name = $request->father_name;
                    $teacher_us->address = $request->address;
                    $teacher_us->gender =$request->gender;
                    $teacher_us->status  = 1;
            	    $teacher_us->userName = $request->userName;
            		$teacher_us->password = Hash::make($request->password);
            		$teacher_us->confirm_password  = $request->password;
                    $teacher_us->save();
                    $user_id = $teacher_us->id;
                    $document_upl  = new TeacherDocuments;//model name
                    $document_upl->session_id = Session::get('session_id');
                    $document_upl->branch_id = Session::get('branch_id');
                    $document_upl->teacher_id = $teacher_id;
                    $document_upl->user_id = $user_id;
                    $document_upl->joining_date = $request->joining_date;
                    $document_upl->referral_name = $request->referral_name;
                    $document_upl->photo = $photo;
                    $document_upl->Id_proof_img = $id_proof;
                    $document_upl->qualification_proof_img = $qualification_proof;
                    $document_upl->experience_letter_img = $experience_letter;
                    $document_upl->save();
            	   // Helper::syncUserModulePermissions(
                //         $teacher_us,
                //         [1, 2, 3, 8, 9, 10, 12, 23],
                //         [],
                //         [5, 11, 12, 16, 17, 18, 19, 20, 21, 22, 23, 109, 111, 39, 41, 65, 66, 67, 68, 69],
                //         ['add' => 1, 'view' => 1, 'edit' => 1, 'deletes' => 1, 'download' => 1]
                //     );
                    $template =  MessageTemplate::Select('message_templates.*','message_types.slug')
                    ->leftjoin('message_types','message_types.id','message_templates.message_type_id')
                    ->where('message_types.status',1)->where('message_types.slug','teachers')->first();
                    $branch = Branch::find(Session::get('branch_id'));
                    $setting = Setting::where('branch_id',Session::get('branch_id'))->first();
                    $arrey1 = array(
                       '{#school_name#}',
                       '{#name#}',
                       '{#userName#}',
                       '{#father_name#}',
                       '{#support_mobile#}',
                       '{#dob#}',
                       '{#password#}',
                       '{#school_name#}');
                    $arrey2 = array(
                        $setting->name,
                        $request->first_name." ".$request->last_name,
                        $request->userName,
                        $request->father_name,
                        $setting->mobile,
                        date('d-m-Y', strtotime($request->dob)),
                        $request->password,
                        $setting->name);
                        if($template->status != 1){
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
                        $url = '/joining_letter_print/'.$teacher->id;
                    ?>
                        <script type="text/javascript">
                            window.open("<?=$url?>", "_blank");
                        </script>
                    <?php            
                      return redirect::to('teachers/index')->with('message', 'Teacher added Successfully.');
                }
                return view('staff.add_teachers.add',['BillCounter'=>$BillCounter]);
            }
    
            public function index(Request $request){
                $search['name'] = $request->name;
                $branch = Session::all();
                //  dd($branch);
                if($branch['role_id'] == 2){
                    $data = Teacher::select('teachers.*','doc.photo')
                    ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')
                    ->leftJoin('users as user','user.teacher_id','teachers.id')
                    ->where('user.id','=', $branch['id']);
                   
                } 
                else if($branch['role_id'] == 1){
                    $data = Teacher::select('teachers.*','doc.photo')
                    ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')
                    ->leftJoin('users as user','user.teacher_id','teachers.id')
                    ->where('user.status',1);
		            if($request->isMethod('post')){
		                $value = $request->name;
	                    if(!empty($request->name)){
                    		$data = $data->where(function($query) use ($value){
            		        $query->where('teachers.first_name', 'LIKE', '%'.$value.'%');
            		        $query->orWhere('teachers.last_name', 'LIKE', '%'.$value.'%');
            		        $query->orWhere('teachers.father_name', 'LIKE', '%'.$value.'%');
            		        $query->orWhere('teachers.mobile', 'LIKE', '%'.$value.'%');
            		        $query->orWhere('teachers.email', 'LIKE', '%'.$value.'%');
    		            });    
		            }
		        }
            }
            else{
                $data = Teacher::select('teachers.*','doc.photo')
                ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')
                 ->leftJoin('users as user','user.teacher_id','teachers.id')
                // ->where('teachers.class_type_id',Session::get('class_type_id'))
                ->whereNotNull('teachers.class_type_id')
                ->where('user.status',1);
            }
            $data = $data->where('teachers.branch_id', Session::get('branch_id'));
            // if (!empty(Session::get('admin_branch_id'))) {
                //$data = $data->where('branch_id', Session::get('branch_id'));
            //}
            if (Session::get('role_id') == 3) {
                 $tea = DB::table('teacher_subjects')
                ->select('teacher_subjects.teacher_id')
                ->leftJoin('teachers as teacher', 'teacher.id', '=', 'teacher_subjects.teacher_id')
                ->leftJoin('users as user', 'user.teacher_id', '=', 'teacher.id')
                ->where('teacher_subjects.branch_id', session('branch_id'))
                ->where('teacher_subjects.class_type_id', session('class_type_id'))
                ->where('user.status', 1)
                ->whereNull('teacher_subjects.deleted_at')
                ->groupBy('teacher_subjects.teacher_id')
                ->pluck('teacher_id');
                $explode = [];
                    if ($tea->isNotEmpty()) {
                        $explode = $tea->toArray(); 
                    }
                    if (!empty($explode)) {
                        $data = $data->whereIn('teachers.id', $explode);
                    }
                }
                $data = $data->orderBy('teachers.id', 'DESC')->get();
                return view('staff.add_teachers.index', ['data' => $data, 'search' => $search]);
            }
                
            public function edit(Request $request,$id){
                $teacher =Teacher::find($id);
                $data_user = User::where('teacher_id',$id)->where('branch_id',Session::get('branch_id'))->get()->first();
                //dd($data_user);
                $data_user_doc = TeacherDocuments::where('teacher_id',$id)->get()->first();
                if($request->isMethod('post')){
                    $request->validate([
                       'UniqueId' => 'required',
                       'first_name' => 'required',
                       'last_name' => 'required',
                       'gender_id' => 'required',
                       //'email' => 'required',
                       //'aadhaar' => 'required',
                       'dob' => 'required',
                       'mobile' => 'required',
                       'father_name' => 'required',
                       'qualification'  => 'required',
                       'userName'  => 'required',
                       'password' => 'required|min:4',
                    ]);
                    /*$photo = null;
                        if($request->file('photo')){
                            $image = $request->file('photo');
                            $path = $image->getRealPath();      
                            $photo =  time().uniqid().$image->getClientOriginalName();
                            $destinationPath = env('IMAGE_UPLOAD_PATH').'profile';
                            $image->move($destinationPath, $photo);
                            if(File::exists(env('IMAGE_UPLOAD_PATH').'profile/'.$data_user->image)){
                                File::delete(env('IMAGE_UPLOAD_PATH').'profile/'.$data_user->image);
                            }
                        $data_user->image = $photo;
                
                    }*/
                    $photo = null;
                        if ($request->file('photo')) {
                        $image = $request->file('photo');
                        $path = $image->getRealPath();
                        $photo = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile';
                        $image->move($destinationPath, $photo);
                        // if (File::exists(env('IMAGE_UPLOAD_PATH') . 'profile/' . $data_user->image)) {
                        //     File::delete(env('IMAGE_UPLOAD_PATH') . 'profile/' . $data_user->image);
                        // }
                        $data_user->image = $photo;
                        $data_user_doc->photo = $photo;
                    }
                    $experience_letter = null;
                        if($request->file('experience_letter')){
                            $image = $request->file('experience_letter');
                            $path = $image->getRealPath();      
                            $experience_letter =  time().uniqid().$image->getClientOriginalName();
                            $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/experience_letter';
                            $image->move($destinationPath, $experience_letter);
                            $data_user_doc->experience_letter_img =$experience_letter;
                        }
                    $qualification_proof = null;
                    if($request->file('qualification_proof')){
                        $image = $request->file('qualification_proof');
                        $path = $image->getRealPath();      
                        $qualification_proof =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/qualification_proof';
                        $image->move($destinationPath, $qualification_proof);
                        $data_user_doc->qualification_proof_img =$qualification_proof;
                    }
                    $id_proof = null;
                    if($request->file('id_proof')){
                        $image = $request->file('id_proof');
                        $path = $image->getRealPath();      
                        $id_proof =  time().uniqid().$image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$request->UniqueId.'/id_proof';
                        $image->move($destinationPath, $id_proof);
                        $data_user_doc->Id_proof_img =$id_proof;
                    }
                    $teacher->session_id = Session::get('session_id');
                    $teacher->branch_id = Session::get('branch_id');
                    $teacher->UniqueId = $request->UniqueId;
                    $teacher->userName = $request->userName;
            		$teacher->first_name =$request->first_name;
            		$teacher->last_name = $request->last_name;
            		$teacher->gender_id = $request->gender_id;
            		$teacher->password = $request->password;
            		$teacher->dob =$request->dob;
            		$teacher->father_name =$request->father_name;
            		$teacher->class_type_id=serialize($request->class_type_id);
            		$teacher->email =$request->email;
            		$teacher->mobile =$request->mobile;
            		$teacher->address =$request->address;
            		$teacher->qualification =$request->qualification;
            		$teacher->blood_group =$request->blood_group;
            		$teacher->teacher_categorie_id =$request->category_id;
            	    $teacher->casual_leave =$request->casual_leave;
            		$teacher->medical_leave =$request->medical_leave;
            		$teacher->other_leave =$request->other_leave;
            		$teacher->refer_name =$request->refer_name;
                    $teacher->refer_address =$request->refer_address;
                    $teacher->refer_mobile =$request->refer_mobile;
                    $teacher->pan_no =$request->pan_card;
            		$teacher->aadhaar =$request->aadhaar;
            		$teacher->bank_name =$request->bank;
            		$teacher->account_no =$request->account_no;
            		$teacher->ifsc_code =$request->ifsc_code;
            		$teacher->salary =$request->salary;
            		$teacher->teacher_update = $request->teacher_update; 
            		/*if(!empty($request->teacher_update)){
            		 	$teacher->teacher_update = $request->teacher_update;   
            		}else{
            		   	$teacher->teacher_update =1; 
            		}*/
                    $teacher->save();
                    $data_user->session_id = Session::get('session_id');
                    $data_user->branch_id = Session::get('branch_id');
                    $data_user->teacher_id = $id;
                    $data_user->userName = $request->userName;
                    $data_user->first_name = $request->first_name;
            		$data_user->last_name = $request->last_name;
            		$data_user->email  = $request->email;
            		$data_user->mobile  = $request->mobile;
            		$data_user->password = Hash::make($request->password);
            		$data_user->confirm_password = $request->password;
            		$data_user->role_id  = 2;
                    $data_user->dob = $request->dob;
                    $data_user->save();
                    $data_user_doc->teacher_id = $id;
                    $data_user_doc->session_id = Session::get('session_id');
                    $data_user_doc->branch_id = Session::get('branch_id');
                    $data_user_doc->joining_date =$request->joining_date;
                    $data_user_doc->referral_name =$request->referral_name;
                    $data_user_doc->save();
                    return redirect::to('teachers/index')->with('message', 'Staff Updated Successfully.');
                }         
                return view('staff.add_teachers.edit',['data'=>$teacher,'users'=>$data_user,'data_user_doc'=>$data_user_doc]);
            }
    
            public function delete(Request $request){
                $id = $request->delete_id;
                User::where('teacher_id',$id)->delete();
                $sss = Teacher::find($id);
                //if(File::exists(env('IMAGE_UPLOAD_PATH').'profile/'.$sss->image)){
                    // File::delete(env('IMAGE_UPLOAD_PATH').'profile/'.$sss->image);
                //} 
                // if(File::exists(env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$sss->id.'/experience_letter'.$sss->experience_letter)){
                    // File::delete(env('IMAGE_UPLOAD_PATH').'teacher/teacher_'.$sss->id.'/experience_letter'.$sss->experience_letter);
                // }  
                $sss->delete();
                return redirect::to('teachers/index')->with('message', 'Staff Data  Deleted Successfully.');
            }     
    
            public function dropTeacherPrint(Request $request,$id){
                $data = Teacher::find($id);
                $printPreview = Helper::printPreview('Teacher Drop');
                return view($printPreview, ['data' => $data]);
                //return view('print_file/staff_print/drop_teacher',['data'=>$data]);
            } 
    
            public function Dropindex(Request $request){
                /*  $data = Teacher::select('teachers.*','doc.photo')
                ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')
                ->where('teachers.drop_status',1);
                if(Session::get('role_id') > 1){
                  $data = $data->where('teachers.branch_id',Session::get('branch_id'));
                }  
                $data = $data->orderBy('teachers.id','DESC')->get();*/
                $data = User::where('branch_id',Session::get('branch_id'))->where('role_id',2)->where('status',2);
                if(Session::get('role_id') > 1){
                  $data = $data->where('branch_id',Session::get('branch_id'));
                }  
                $data = $data->orderBy('id','DESC')->get();
                return view('staff.all_drop_teachers.drop_index',['data'=>$data]);
            } 

            public function joiningLater(Request $request,$id){
                $data = Teacher::find($id);
                $printPreview =    Helper::printPreview('Teacher Joining Latter');
                //dd($printPreview);
                return view($printPreview, ['data' => $data]);
                //return view('staff/joining_letter_print',['data'=>$data]);
            } 
            
            public function teachersidCard(Request $request,$id){
                //$data = Teacher::find($id);
                $data = Teacher::select('teachers.*','doc.photo')
                ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')
                ->find($id);
                // $pdf = PDF::loadView('master.printFilePanel.StaffManagement.template05', ['data'=>$data]);
                //  $pdf->setPaper('A4', 'portrait');
                // return $pdf->download('StaffManagement.pdf');
                $printPreviewId = Helper::printPreview('Teacher Id Card');
                return view($printPreviewId, ['data' => $data]);
               // return view('master.printFilePanel.StaffManagement.template04',['data'=>$data]);
            } 
    
            public function teacherUpdateImg(Request $request){
                $data = Teacher::select('teachers.*','documents.photo','documents.Id_proof_img','documents.qualification_proof_img','documents.experience_letter_img')
                ->leftjoin('teacher_documents as documents','documents.teacher_id','teachers.id')
                ->leftjoin('users as user','user.teacher_id','teachers.id')
                ->where('user.status',1);
                if(Session::get('role_id') > 1){
                    $data = $data->where('teachers.branch_id',Session::get('branch_id'))->where('teachers.id',Session::get('teacher_id'));
                }   
                $data = $data->orderBy('id','DESC')->where('teachers.branch_id',Session::get('branch_id'))->get();
                return view('staff.teacher_image.index',['data'=>$data]);
            }
            
            public function checkClassTeacher(Request $request){
                $data = Teacher::select('teachers.*','doc.photo','class.name as class_name')
                ->leftJoin('teacher_documents as doc','doc.teacher_id','teachers.id')->leftJoin('class_types as class','teachers.class_type_id','class.id')
                ->where('teachers.class_type_id',$request->class_type_id)->first();
                if(!empty($data)){
                    return response()->json([
                        'teacher' =>  $data,
                    ]);
                }
                else{
                    return response()->json([
                        'teacher' =>  null,
                    ]);
                }
            }
            
            public function removeClassTeacher(Request $request){
                $data = Teacher::find($request->teacher_id);
                if(!empty($data)){
                    $data->class_type_id = null;
                    $data->save();
                    return response()->json([
                        'message' =>  'success',
                    ]);
                }
                else{
                    return response()->json([
                        'message' =>  'failed',
                    ]);
                }
            }
}
