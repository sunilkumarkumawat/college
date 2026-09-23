<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator;
use App\Models\User;
use App\Models\Admission;
use App\Models\exam\Question;
use App\Models\exam\Exam;
use App\Models\StudentGrow;
use App\Models\Subject;
use App\Models\SmsSetting;
use App\Models\WhatsappSetting;
use App\Models\Setting;
use App\Models\ClassType;
use App\Models\Classs;
use App\Models\Student;
use App\Models\Master\MessageTemplate;
use App\Models\Master\MessageType;
use App\Models\Master\Branch;
use App\Models\AdmitCardNote;
use App\Models\ExaminationAdmitCard;
use App\Models\ExaminationSchedule;
use App\Models\ExaminationScheduleDetail;
use App\Models\exam\ExamResult;
use App\Models\exam\FillMinMaxMarks;
use App\Models\exam\FillMarks;
use App\Models\exam\ExamResultDetail;
use App\Models\exam\AssignQuestion;
use App\Models\exam\AssignExam;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Helper;
use Session;
use Hash;
use PDF;
use Str;
use Redirect;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExaminationController extends Controller

{
            public function marksheet1(){
                $data=User::where('id',Session::get('id'))->get()->first();
                return  view('print_file.exam.marksheet1',['data'=>$data]);
            }
    
            public function marksheet2(){
                return  view('print_file.exam.marksheet2');
            }
            
            public function marksheet3(){
                return  view('print_file.exam.marksheet3');
            }
    
            public function marksheet4(){
                return  view('print_file.exam.marksheet4');
            }
    
            public function marksheet5(){
                return  view('print_file.exam.marksheet5');
            }
   
            public function viewMarksheet1(){
                return  view('examination.exam.view_marksheet');
            }
    
            public function StudentReportCard(Request $request,$id){
                // $data=Student::find($id);
                $data = Admission::select('admissions.*','class_types.name as class_name','sessions.from_year','sessions.to_year')
                ->leftjoin('class_types','class_types.id','admissions.class_type_id')
                ->leftjoin('sessions','sessions.id','admissions.session_id')->find($id);
                return  view('examination.student_report_card',['data'=>$data]);
            }

            public function examinationDashboard(){
                return view('examination.examination_dashboard ');
            }
            
            public function download_marksheet(Request $request){
                $search['name'] = "";
                $search['class_type_id'] = $request->class_name;
                $search['exam_id'] = $request->exam_id ?? "";
                if($request->isMethod('post')){
                    // $data = Admission::where('class_type_id',$request->class_name)->where('section_id',$request->section)->get();
                    $data =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.father_name','admission.admissionNo')
    	            ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                	->where('fill_marks.exam_id',$request->exam_id)->where('fill_marks.class_type_id', $request->class_name)
                    ->where('fill_marks.session_id', Session::get('session_id'))->groupBy('fill_marks.admission_id')->get();
                    return view('examination.download_marksheet',['data'=>$data,'search'=>$search]);
                }
                return view('examination.download_marksheet',['search'=>$search]);
            }
    
            public function printReportCard(Request $request){
                if($request->isMethod('post')){
                    $data ='';
                    if($request->class_type_id >10){
                        $data =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.image','admission.dob','admission.gender_id','admission.father_name','admission.father_name','admission.mother_name','admission.id as sr_no','sessions.from_year','sessions.to_year',
                        'admission.admissionNo', 'admission.dob','type.name as class_name','subject.sub_name as subject_name')
                	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                	    ->leftjoin('sessions as sessions','sessions.id','fill_marks.session_id')
                	    ->leftjoin('class_types as type','type.id','fill_marks.class_type_id')
                	    ->where('fill_marks.exam_id',$request->exam_id)
                        ->where('fill_marks.admission_id',$request->student_id)
                        ->where('fill_marks.class_type_id', $request->class_type_id)
                        ->where('fill_marks.session_id', Session::get('session_id'))->get();
                    }
                    else{
                        $data =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.image','admission.dob','admission.gender_id','admission.father_name','admission.father_name','admission.mother_name','admission.id as sr_no','sessions.from_year','sessions.to_year',
                        'admission.admissionNo', 'admission.dob','type.name as class_name','subject.name as subject_name')
                	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                	    ->leftjoin('sessions as sessions','sessions.id','fill_marks.session_id')
                	    ->leftjoin('class_types as type','type.id','fill_marks.class_type_id')
                	    ->leftjoin('subject as subject','subject.id','fill_marks.subject_id')
                	    ->where('fill_marks.exam_id',$request->exam_id)
                        ->where('fill_marks.admission_id',$request->student_id)
                        ->where('fill_marks.class_type_id', $request->class_type_id)
                        ->where('fill_marks.session_id', Session::get('session_id'))->get();
                    }
                    if($request->class_type_id < 9){  
                        return view('examination.download_till_8_pdf',['data'=>$data]);
                    }
                    else{
                        return view('examination.download_pdf',['data'=>$data]);
                    }
                }
            }
    
            public function fillMarks(Request $request){
                $search['name'] = "";
                $search['class_type_id'] = $request->class_type_id;
                $search['class_type_id'] = $request->class_name;
                $search['exam_id'] = $request->exam_id ?? "";
                //  $search['class_type_id'] = $request->class_name ?? "";
                $data1='';
                $data2='';
                $marks='';
                if($request->isMethod('post')){
                    $request->validate([
                    ]);
                    if((Int)$request->class_name >10){
                        $data = FillMarks::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_name)->where('session_id', Session::get('session_id'))->first();
                    }
                    else{
                        $data = FillMarks::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_name)->where('session_id', Session::get('session_id'))->first();
                    }
                    $data_null = true;
                    if(empty($data)){
                        if((Int)$request->class_name >10){
                            $data2 = Admission::where('class_type_id',$request->class_name)->get();
                            $marks =  FillMarks::select('fill_marks.*','admission.name','admission.father_name','admission.admissionNo')
                	        ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                	        ->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->get();
                        }
                        else{
                            $data1 = Subject::where('class_type_id',$request->class_name)->orderBy('name','ASC')->get();
                            $data2 = Admission::where('class_type_id',$request->class_name)->get();
                            $marks =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.father_name','admission.admissionNo')
                    	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                    	    ->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->get();
                        }
                    }
                    else{
                        $data_null =false;
                        if((Int)$request->class_name >10){
                            $data1 =  FillMinMaxMarks::select('fill_min_max_marks.*','subjects.sub_name')
        	                ->where('fill_min_max_marks.exam_id',$request->exam_id)->where('fill_min_max_marks.class_type_id', $request->class_name)->where('fill_min_max_marks.session_id', Session::get('session_id'))->get();
        	                $marks =  FillMarks::select('fill_marks.*','admission.name','admission.father_name','admission.admissionNo')
                    	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                    	    ->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->get();
                    	    $data2 =  FillMarks::select('fill_marks.*','admission.name','admission.father_name','admission.admissionNo')
                    	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                    	    ->where('fill_marks.exam_id',$request->exam_id)->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->groupBy('admission.admissionNo')->get();
                        }
                        else{
                            $data1 =  FillMinMaxMarks::select('fill_min_max_marks.*','subjects.name')
                            ->leftjoin('subject as subjects','subjects.id','fill_min_max_marks.subject_id')
                            ->where('fill_min_max_marks.exam_id',$request->exam_id)->where('fill_min_max_marks.class_type_id', $request->class_name)->where('fill_min_max_marks.session_id', Session::get('session_id'))->get();
                            $marks =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.father_name','admission.admissionNo')
                            ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                    	    ->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->get();
                    	    $data2 =  FillMarks::select('fill_marks.*','admission.first_name','admission.last_name','admission.father_name','admission.admissionNo')
                    	    ->leftjoin('admissions as admission','admission.admissionNo','fill_marks.admission_id')
                    	    ->where('fill_marks.exam_id',$request->exam_id)->where('fill_marks.class_type_id', $request->class_name)->where('fill_marks.session_id', Session::get('session_id'))->groupBy('admission.admissionNo')->get();
                         
                        }
            	   }
                    $examlist =  AssignExam::select('assign_exams.*','exam.id as exam_id','exam.name as exam_name')
                    ->leftjoin('exams as exam','assign_exams.exam_id','exam.id')
                    ->where('assign_exams.class_type_id',$request->class_name)->get();
                    //  $section = Classs::with('Section')->where('class_id',$request->class_name)->get();
        		    return view('examination.fill_marks',['data1'=>$data1,'data2'=>$data2,'search'=>$search,'data_null'=>$data_null,'examlist'=>$examlist]);
                }
                return view('examination.fill_marks',['search'=>$search]);
            }
            
            public function fillMarksSubmit(Request $request){
                if($request->isMethod('post')){
                    $request->validate([
                        //   'name'  => 'required',
                        //   'exam_date'  => 'required',
                        // 'to_date'  => 'required',
                    ]);
                        $data='';
                        if((Int)$request->class_type_id >10){
                            $data = FillMarks::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->where('session_id', Session::get('session_id'))->first();
                        }
                        else{
                            $data = FillMarks::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->where('session_id', Session::get('session_id'))->first();
                        }
                        if(empty($data)){
                            if(!empty($request->subject_id)){
                                for($i=0; $i<count($request->subject_id); $i++){
                                    $add = new FillMinMaxMarks;//model name
    	                            $add->class_type_id = $request->class_type_id;
                            	    $add->exam_id = $request->exam_id;
                            	    $add->user_id = Session::get('id');
                            	    $add->session_id = Session::get('session_id');
                                    $add->branch_id = Session::get('branch_id');
                            		$add->subject_id =$request->subject_id[$i];
                            		$add->exam_minimum_marks =$request->exam_minimum_marks[$i];
                            		$add->exam_maximum_marks =$request->exam_maximum_marks[$i];
                            	    $add->save();
                                }
                            }
                                if(!empty($request->admission_id)){
                                    $count= 0;
                                    for($i=0; $i<count($request->admission_id); $i++){
                                        for($j=0; $j<count($request->subject_id); $j++){
                                            $add = new FillMarks;//model name
                                	        $add->exam_id = $request->exam_id;
                                	        $add->class_type_id = $request->class_type_id;
                                    	    $add->admission_id = $request->admission_id[$i];
                                    	    $add->user_id = Session::get('id');
                                    	    $add->session_id = Session::get('session_id');
                                            $add->branch_id = Session::get('branch_id');
                                    		$add->subject_id =$request->sub_id[$j];
                                    		$add->student_marks =$request->student_marks[$count];
        	                                $add->save();
        	                                $count++;
                                        }
                                    }
                                }
        		                return redirect::to('fill_marks')->with('message', 'Marks Updated Successfully.');
                            }
                            else{
                                if(!empty($request->fill_min_max_id))
                            {
                            for($i=0; $i<count($request->fill_min_max_id); $i++){
                                $update = FillMinMaxMarks::where('id',$request->fill_min_max_id[$i])->update(['exam_minimum_marks'=>$request->exam_minimum_marks[$i],'exam_maximum_marks'=>$request->exam_maximum_marks[$i]]);
                            }
                        }
                        if(!empty($request->fill_marks_id)){
                            for($i=0; $i<count($request->fill_marks_id); $i++){
                                $update = FillMarks::where('id',$request->fill_marks_id[$i])->update(['student_marks'=>$request->student_marks[$i]]);
                            }
                        }
                        return redirect::to('fill_marks')->with('message', 'Marks already submitted.');
                    }
                }
            }

            public function viewExamTeacher(Request $request,$id){
                if( Session::get('role_id') == 2){
                    $data =  ExamResult::select('exam_results.*','exam.name as exam_name','class.name as class_name','exam.exam_date as exam_date','student.first_name as student_fname','student.last_name as student_lname')
            	    ->leftjoin('admissions as student','student.admissionNo','exam_results.admission_id')
            	    ->leftjoin('exams as exam','exam.id','exam_results.exam_id')
            	    ->leftjoin('class_types as class','class.id','student.class_type_id')
    	            ->where('exam_results.exam_id',$id)->get();
    		        return view('examination.exam.teacherView ',['data'=>$data]);
                }
            }

            public function editExam(Request $request, $id){
                $data = Exam::find($id);
                if($request->isMethod('post')){
                    $request->validate([
                        'name'  => 'required',
                        'class_type_id'  => 'required',
                    ]);
            	    $data->user_id = Session::get('id');
                    $data->session_id = Session::get('session_id');
                    $data->branch_id = Session::get('branch_id');	     
            		$data->name =$request->name;
            		$data->class_type_id =$request->class_type_id;
            	    $data->save();
                    return redirect::to('view/exam')->with('message', 'Exam Updated Successfully.');
                }
                return view('examination.exam.edit',['data'=>$data]);
            } 

            public function deleteExam(Request $request){
                $question = Exam::find($request->delete_id)->delete();
                AssignExam::where('exam_id',$request->delete_id)->delete();
                return redirect::to('view/exam')->with('message', 'Exam Deleted Successfully.');
            }

            public function assignQuestion(Request $request){
                if($request->isMethod('post')){
                    if($request->submit_id=="0"){
                        $add = new AssignQuestion;//model name
                        $add->user_id = Session::get('id');
                        $add->session_id = Session::get('session_id');
                        $add->branch_id = Session::get('branch_id'); 
                        $add->exam_id = $request->exam_id;
                        $add->question_id = $request->question_id;
                        $add->subject_id = $request->subject_id;
                	    $add->save();
                    }
                    else{
                        $id=$request->post('question_id');
                        $data = AssignQuestion::where('question_id',$id)->delete();
                    } 
                }
            }

            public function searchkAssignedQuestion(Request $request){
                // dd($request);
        	    $question_type_id = $request->get('question_type_id');
        	    $subject_id = $request->get('subject_id');
                $data =  Question::with('Subject')->orderBy('id',"DESC");
                if(!empty($question_type_id)){
                  $data = $data ->where("question_type_id", $question_type_id);
                }           
                if(!empty($subject_id)){
                  $data = $data ->where("subject_id", $subject_id);
                } 
                $allquestions = $data->where('branch_id',Session::get('branch_id'))->where('session_id',Session::get('session_id'))->orderBy('id','DESC')->get();
                $assigned_questions = AssignQuestion::where('branch_id',Session::get('branch_id'))->where('session_id',Session::get('session_id'))->where('exam_id',$request->exam_id1)->pluck('question_id');
                return  view('examination.exam.search_assign_question',['data'=>$allquestions,'assigned_questions'=>$assigned_questions]);
            }
    
            public function searchkAlreadyAssignedQuestion(Request $request){
                $already_assigned = Question::select('questions.*','Exam.name as examName','Exam.duration as duration')
        	    ->leftjoin('assign_questions as assignQuestion','assignQuestion.question_id','questions.id')
        	    ->leftjoin('exams as Exam','assignQuestion.exam_id','Exam.id')
        	    ->where('assignQuestion.exam_id',$request->id)->get();
                return  view('examination.exam.search_already_assign_question',['data'=>$already_assigned]);
            }
    
            public function assignExam(Request $request, $id){
                $examId = $id;
                $data2 = Exam::where('id',$id)->first(['name','exam_date']);
                if($request->isMethod('post')){
                $request->validate([
                    'class_type_id'  => 'required',
                ]);
                $add = new AssignExam; //model name
        	    $add->user_id = Session::get('id');
        	    $add->session_id = Session::get('session_id');
                $add->branch_id = Session::get('branch_id');    
        		$add->class_type_id = $request->class_type_id;
        		$add->exam_id = $examId;
        	    $add->save();
	            $users = Admission::where('class_type_id',$request->class_type_id)->where('session_id',Session::get('session_id'))
	            ->where('branch_id',Session::get('branch_id'))->get();
	            $template = MessageTemplate::Select('message_templates.*','message_types.slug')
                ->leftjoin('message_types','message_types.id','message_templates.message_type_id')
                ->where('message_types.status',1)->where('message_types.slug','exam')->first();
                $branch = Branch::find(Session::get('branch_id'));
                $setting = Setting::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->first();
                for($count = 0; $count < count($users); $count++){
                    $arrey1 =   array(
                        '{#name#}',
                        '{#exam_name#}',
                        '{#exam_date#}',
                        '{#support_no#}',
                        '{#school_name#}');
                    $arrey2 = array(
                        $users[$count]->first_name." ".$users[$count]->last_name,
                        $data2->name,
                        date('d-m-Y',strtotime($data2->exam_date)),
                        $setting->mobile,
                        $setting->name);
                    
                    if($template->status != 1){
                            if($users[$count]->email != ""){
                                if($branch->email_srvc != 0){
                                    if($template->email_status != 0){
                                        $message = str_replace($arrey1,$arrey2,$template->email_content);
                                        $emailData = ['email' => $users[$count]->email, 'data' => $message, 'subject' => $template->title];
                                        Helper::sendMail('email_print.template_print', $emailData);
                                    } 
                                } 
                            }
                            if($branch->whatsapp_srvc != 0){
                                if ($users[$count]->mobile != ""){
                                    if($template->whatsapp_status != 0){
                                        $whatsapp = str_replace($arrey1,$arrey2,$template->whatsapp_content);
                                        Helper::sendWhatsappMessage($users[$count]->mobile,$whatsapp);
                                    }
                                }
                            }
                            if($branch->sms_srvc != 0){
                                if($users[$count]->mobile != ""){
                                    if($template->sms_status != 0){
                                        $sms = str_replace($arrey1,$arrey2,$template->sms_content);
                                        Helper::SendMessage($users[$count]->mobile, $sms);
                                    }
                                }
                            }    
                        }
                    }	
		            return redirect::to('view/exam')->with('message', 'Exam Assigned Successfully.');
                }
                return view('examination.exam.assign',['data'=>$examId,'data2'=>$data2]);
            } 
    
            public function assignExamEdit(Request $request, $id,$class_type){
                $examId = $id;
                $data2 = Exam::where('id',$id)->first('name');
                $oldData = AssignExam::where('exam_id', $examId)->where('class_type_id', $class_type)->first();
                if($request->isMethod('post')){
                    $request->validate([
                        'class_type_id'  => 'required',
                    ]);
                    if (!empty($oldData)) {
                        $new = AssignExam::where('id', $request->id)->update(['class_type_id'=>$request->class_type_id]);
                        return redirect::to('view/exam')->with('infor', 'Exam Reassigned successfully !');
                    } 
		            return redirect::to('view/exam')->with('message', 'Exam Assigned Successfully.');
                }
                return view('examination.exam.assign_edit',['data'=>$oldData,'data2'=>$data2]);
            } 

            public function onlineExam($id){
                /*$data = Question::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->orderBy('id', 'DESC')->get();*/
                $old_data = ExamResult::where('admission_id',Session::get('id'))->where('exam_id',$id)->first();
                if(empty($old_data)){
                    $add = new ExamResult;
	                $add->user_id = Session::get('id');
                    $add->session_id = Session::get('session_id');
                    $add->branch_id = Session::get('branch_id');	           
                    $add->admission_id = Session::get('id');	           
                    $add->exam_id = $id;
                    $add->save();
                }
                $data = Question::select('questions.*','Exam.name as examName','Exam.duration as duration')
        	    ->leftjoin('assign_questions as assignQuestion','assignQuestion.question_id','questions.id')
        	    ->leftjoin('exams as Exam','assignQuestion.exam_id','Exam.id')
        	    ->where('assignQuestion.exam_id',$id)->get();     
                $data1 = array();
                $data2= array();
			    foreach ($data as $item) {
    			    $data2[0] = $item->ans1 ;
                    $data2[1] = $item->ans2 ;
                    $data2[2] =$item->ans3  ;
                    $data2[3] = $item->ans4 ;
					$data1[] = array(
    					'title' => $item->name,
    			       	'choices' => $data2,
    					'correctAnswer' => $item->correct_ans,
    					'pointerEvents' => false,
    					'secondsLeft' => 30,
    					'AnsweredQue' => "",
    					'question_id' => $item->id,
    					'question_type_id' => $item->question_type_id,
    					'exam_id' => $id,
    					'duration' => $item->duration,
					);
			    }
                return view('examination.online_exam.view',['data'=>$data,'data1'=>$data1,'id'=>$id]);
            }
            
            public function addExamResult(Request $request){
                $adminMail = User::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('role_id','1')->get()->first();        $stu = Admission::where('id',Session::get('id'))->get()->first();
                $id = ExamResult::where('exam_id',$request->exam_id )->where('admission_id',Session::get('id') )->first();
                $add = ExamResult::where('exam_id',$request->exam_id )->where('admission_id',Session::get('id') )->update([
                    'total_ques'=>$request->total_que,
                    'correct_ans'=>$request->correct_ans,
                    'wrong_ans'=>$request->wrong_ans,
                    'skip_ques'=>$request->skip,
                    'percentage'=>($request->correct_ans/$request->total_que)*100,
                    'time'=>$request->timer,
                ]);
                //   $add = new ExamResult;
        	       //$add->user_id = Session::get('id');
                //   $add->session_id = Session::get('session_id');
                //   $add->branch_id = Session::get('branch_id');	           
                //   $add->admission_id = Session::get('id');	           
                //   $add->exam_id = $request->exam_id;
                //   $add->total_ques = $request->total_que;
                //   $add->correct_ans = $request->correct_ans;
                //   $add->wrong_ans = $request->wrong_ans;
                //   $add->skip_ques = $request->skip;
                //  $add->percentage = ($request->correct_ans/$request->total_que)*100;
                //   $add->time = $request->timer;
                //   $add->save();
                $resultId = $id->id;
                for ($count = 0; $count <= count($request->ques_name); $count++) {
                    if (isset($request->ques_name[$count])) {   
                        $detail = new ExamResultDetail;
        	            $detail->user_id = Session::get('id');
                        $detail->session_id = Session::get('session_id');
                        $detail->branch_id = Session::get('branch_id');	           
                        $detail->admission_id = Session::get('id');
                        $detail->exam_result_id = $resultId;
                        $detail->exam_id = $request->exam_id;
                        $detail->ques_id = $request->ques_id[$count];
                        $detail->ques_name = $request->ques_name[$count];
                        $detail->correct_ans = $request->ques_ans[$count];
                        $detail->submit_ans = $request->submit_ans[$count];                   
                        $detail->save();  
                    }
                } 
                /*if (!empty($adminMail['email'])) {
                    $emailData = ['email' => $adminMail['email'], 'first_name' => $stu['first_name'], 'last_name' => $stu['last_name'], 'father_name' => $stu['father_name'],
                    'total_ques' => $request->total_que,'correct_ans' => $request->correct_ans, 'skip_ques' => $request->skip_ans, 'percentage' => $request->percentage,
                    'time' => $add->time, 'dateTime' => date('l jS \of F Y h:i:s A'),'subject' => 'Today Exam Result'];
                    Helper::sendMail('email_print.exam_result_student', $emailData);
                }*/
                if (!empty($stu['email'])) {
                    $emailData = ['email' => $stu['email'], 'first_name' => $stu['first_name'], 'last_name' => $stu['last_name'], 'father_name' => $stu['father_name'],
                    'total_ques' => $request->total_que,'correct_ans' => $request->correct_ans, 'skip_ques' => $request->skip_ans, 'percentage' => $request->percentage,
                    'time' => $add->time, 'dateTime' => date('l jS \of F Y h:i:s A'),'subject' => 'Today Exam Result'];
                    Helper::sendMail('email_print.exam_result_student', $emailData);
                }            
                return redirect('view/exam')->with('message','Exam Submitted !');
                /*if(!empty($request->mobile)){
                    $SmsSetting = SmsSetting::where('category','otp')->get()->first();
                    $message = !empty($SmsSetting->message) ? $SmsSetting->message : '' ;
                    $message_otp = str_replace("{#var#}", '4595', $message);
                    Helper::SendMessage($request->mobile,$message_otp);
                }*/                
                /*if(!empty($request->mobile)){
                    $whatsApp = WhatsappSetting::where('category','otp')->get()->first();
                      $message = !empty($whatsApp->message) ? $whatsApp->message : '' ;
                     
                      $message_otp = str_replace("{#var#}", '4595', $message);
                      Helper::sendWhatsapp($request->mobile,$message_otp);
                }*/   
            }
     
            public function viewResult(Request $request){
                $search['name'] = $request->name;
                $data = ExamResult::select('exam_results.*')
        		->leftjoin('assign_exams as assignExam','assignExam.exam_id','exam_results.exam_id')
        		->leftjoin('exams as Exam','Exam.id','exam_results.exam_id')
        		->where('exam_results.session_id',Session::get('session_id'))->where('exam_results.branch_id',Session::get('branch_id'));
                if($request->isMethod('post')){
                    if (!empty($request->name)){
                        $data = $data->where("Exam.name",'like','%'.$request->name.'%')
                        ->orWhere("Exam.exam_date",'like','%'.$request->name.'%')
                        ->orWhere("Exam.description",'like','%'.$request->name.'%');
                    }
                }
                $data = $data->groupBy('exam_id')->orderBy('id','DESC')->get();
                return view('examination.result.view ',['data'=>$data,'search'=>$search]);
            }

            public function viewExamResult(Request $request, $id){
                $search['name'] = $request->name;
                $data = ExamResult::select('exam_results.*')
        		 ->leftjoin('admissions as Admission','Admission.id','exam_results.admission_id')
        		 ->leftjoin('exams as Exam','Exam.id','exam_results.exam_id')
        		 ->where('Admission.session_id',Session::get('session_id'))->where('Admission.branch_id',Session::get('branch_id'))
        		 ->where('exam_results.exam_id',$id);
                if($request->isMethod('post')){
                    if (!empty($request->name)){
                        $data = $data->where("Admission.first_name",'like','%'.$request->name.'%')
                        ->orWhere("Admission.last_name",'like','%'.$request->name.'%')
                        ->orWhere("Admission.father_name",'like','%'.$request->name.'%')
                        ->orWhere("Admission.mother_name",'like','%'.$request->name.'%')
                        ->orWhere("Admission.mobile",'like','%'.$request->name.'%')
                        ->orWhere("Admission.email",'like','%'.$request->name.'%')
                        ->orWhere("Admission.aadhaar",'like','%'.$request->name.'%');
                    }
                }
                $data = $data->orderBy('id','DESC')->get();
                return view('examination.result.view_result',['data'=>$data,'id'=>$id,'search'=>$search]);
            }
    
            public function viewExamResultEmail(Request $request){
                $emailData = ['email' => "skwork91@gmail.com",'subject' => 'Today Exam Result'];
                Helper::sendMail('email_print.admin.exam_result_email', $emailData);
                $emailData = ['email' => "kanak8856@gmail.com",'subject' => 'Today Exam Result'];
                Helper::sendMail('email_print.admin.exam_result_email', $emailData);
                return view('email_print.admin.exam_result_email');
            }

            public function downloadMarksheet(Request $request,$admission_id,$exam_id){
                $data = ExamResult::select('exam_results.*','Admission.first_name as first_name','ClassType.name as class')
        	    ->leftjoin('admissions as Admission','Admission.id','exam_results.admission_id')
        	    ->leftjoin('class_types as ClassType','ClassType.id','Admission.class_type_id')
        	    ->where('exam_results.admission_id',$admission_id)->where('exam_id',$exam_id)->get()->first(); 
        	   // dd($data);
                return view('print_file.exam.marksheet_download',['data'=>$data]);
            } 

            public function viewMarksheet(Request $request,$admission_id,$exam_id){
                $data = ExamResult::select('exam_results.*','Admission.first_name as first_name','ClassType.name as class')
        	    ->leftjoin('admissions as Admission','Admission.id','exam_results.admission_id')
        	    ->leftjoin('class_types as ClassType','ClassType.id','Admission.class_type_id')
        	    ->where('exam_results.admission_id',$admission_id)->where('exam_id',$exam_id)->get()->first(); 
        	   // dd($data);
                return view('print_file.exam.marksheet_print',['data'=>$data]);
            } 
    
            public function answerKey(Request $request,$id){
                $resultDetail = ExamResultDetail::with('Exam')->with('Question')->with('Admission')->where('exam_result_id',$id)->get();  
                $result = ExamResult::where('id',$id)->get()->first();  
                $skip_answer  = ExamResultDetail::with('Exam')->with('Question')->with('Admission')->where('exam_result_id',$id)->where('submit_ans',null)->count();  
        	   // dd($skip_answer);
                return view('examination.result.answer_key',['data'=>$resultDetail,'result'=>$result,'skip_answer'=>$skip_answer]);
            }  
    
            public function answerKeyTeacher(Request $request,$exam_id,$student_id){
                $resultDetail = ExamResultDetail::with('Exam')->with('Question')->with('Admission')->where('exam_id',$exam_id)->where('admission_id',$student_id)->get();  
                $result = ExamResult::where('exam_id',$exam_id)->where('admission_id',$student_id)->get()->first();  
                $skip_answer  = ExamResultDetail::with('Exam')->with('Question')->with('Admission')->where('exam_id',$exam_id)->where('admission_id',$student_id)->where('submit_ans',null)->count();  
	            // dd($skip_answer)
                return view('examination.result.answer_key',['data'=>$resultDetail,'result'=>$result,'skip_answer'=>$skip_answer]);
            }  
    
            public function fetchQuestion(Request $request){
                $data = Question::select('questions.*','Exam.name as examName')
        	    ->leftjoin('assign_questions as assignQuestion','assignQuestion.question_id','questions.id')
        	    ->leftjoin('exams as Exam','assignQuestion.exam_id','Exam.id')
        	   ->get();     
	            foreach($data as $key =>$item){
                    $data1[] = array('title' => $item['name'],'choices'=>[$item['ans1'],$item['ans2'],$item['ans3'],$item['ans4']], 'correctAnswer' => $item['correct_ans'],'pointerEvents'=>'false','secondsLeft'=>20,'AnsweredQue'=>"");
                }
                return response()->json([
                    'students' =>  $data1,
                ]);
            }
    
            public function addExamStudents(Request $request){
                if($request->isMethod('post')){
                    $the_file = $request->file('upload_contant');
                    try{
                        $spreadsheet = IOFactory::load($the_file->getRealPath());
                        $sheet        = $spreadsheet->getActiveSheet();
                        $row_limit    = $sheet->getHighestDataRow();
                        $column_limit = $sheet->getHighestDataColumn();
                        $row_range    = range( 2, $row_limit );
                        $column_range = range( 'F', $column_limit );
                        $startcount = 2;
                        $data = array();
                        foreach ( $row_range as $row ) {
                            $admission_no = $sheet->getCell( 'A' . $row )->getValue();
                            $student_id = Student::where('id',$admission_no)->pluck('id')->first();
                            if(!empty($student_id)){
                                $data[] = [
                                    'student_id' => $student_id,
                                    'marks' => $sheet->getCell( 'B' . $row )->getValue(),
                                    'total_marks' => $sheet->getCell( 'C' . $row )->getValue(),
                                    'percentage' => $sheet->getCell( 'D' . $row )->getValue(),
                                    'rank' => $sheet->getCell( 'E' . $row )->getValue(),
                                    'date' => $sheet->getCell( 'F' . $row )->getValue(),
                                    'exam_id' => $request->exam_id,
                                    'date' => $request->date,   
                                ];
                                $startcount++;
                            }   
                        }
                        DB::table('student_result')->insert($data);
                    }   catch (Exception $e) {
                            $error_code = $e->errorInfo[1];
                            return redirect('add_exam_result')->with('error','Error Result Not Added !');
                        }
                        return redirect('examination_dashboard')->with('message','Result Add Successful !');
                }
               
                    return view('examination.add');
            }
    
            public function viewExamStudents(Request $request){
                $search['name'] = $request->name;
                $search['exam_id'] = $request->exam_id;
                if($request->isMethod('post')){
                    $data =StudentGrow::select('student_result.*','enquirys.first_name as name','exams.name as exam_name')
                    ->leftjoin('enquirys as enquirys','enquirys.id','student_result.student_id')
                    ->leftjoin('exams as exams','exams.id','student_result.exam_id');
                    $request->validate([]);
                    if(!empty($request->name)){
                        $value = $request->name;
                        $data = $data->where(function($query) use ($value){
                		  $query->where('name', 'like', '%' .$value. '%');
        		        });
                    }
                    if(!empty($request->stu_id)){
                        $data = $data ->where("enquirys.id", $request->stu_id);
                    }     
                    if(!empty($request->exam_id)){
                        $data = $data ->where("exams.id", $request->exam_id);
                    }    
                    $data = $data->orderBy('rank','ASC')->get();
                    return view('examination.view',['data'=>$data,'search'=>$search]);   
                }
                return view('examination.view',['search'=>$search]);
            }
    
            public function examPrint(Request $request){
                $data = StudentGrow::select('student_result.*','students.first_name as name')
                ->leftjoin('students as students','students.id','student_result.student_id')
                ->leftjoin('exams as exams','exams.id','student_result.exam_type_id')->where('date',date('Y-m-d'))->OrderBy('rank')->get();
                return view('examination.exam_print',['data'=>$data]);
            }
    
            public function StudentAdmitCard(Request $request,$id){
                $data=Student::where('id',$id)->get()->first();
                return view('examination.admit_card',['data'=>$data]);
            }
    
            public function addExaminationSchedule(Request $request){
                $search['class_type_id'] = $request->class_type_id;
                $search['exam_id'] = $request->exam_id;
                $exam_code ="";
                $old_data =[];
                $data1 ="";
                $data2 ="";
                $exam_code = Exam::where('id',$request->exam_id)->first('exam_code'); 
                if((Int)$request->class_type_id > 10){
                    $old_data = ExaminationSchedule::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->get();
                }
                else{
                    $old_data = ExaminationSchedule::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->get();
                }
                //  $old_data = ExaminationSchedule::where('exam_code',$exam_code->exam_code)->get();
                if(count($old_data) > 0){
                    if((Int)$request->class_type_id > 10)
                {
                $data1 = ExaminationScheduleDetail::select('examination_schedule_details.*','subject.sub_name as subject_name')
                ->where('examination_schedule_details.class_type_id',$request->class_type_id)->get();
                $data2 =  AssignExam::select('assign_exams.*','exam.id as exam_id','exam.name as exam_name')
        	    ->leftjoin('exams as exam','assign_exams.exam_id','exam.id')
                ->where('assign_exams.class_type_id',$request->class_type_id)->get();
            }
              
            else{
                $data1 = ExaminationScheduleDetail::select('examination_schedule_details.*','subject.name as subject_name','subject.id as subject_id')
            	    ->leftjoin('subject as subject','subject.id','examination_schedule_details.subject_id')
                    ->where('examination_schedule_details.class_type_id',$request->class_type_id)->get();
                    $data2 =  AssignExam::select('assign_exams.*','exam.id as exam_id','exam.name as exam_name')
                	    ->leftjoin('exams as exam','assign_exams.exam_id','exam.id')
                        ->where('assign_exams.class_type_id',$request->class_type_id)->get();
                    }
                }
                else{
                $data1 = Subject::where('class_type_id',$request->class_type_id)->orderBy('name','ASC')->get();
                $data2 =  AssignExam::select('assign_exams.*','exam.id as exam_id','exam.name as exam_name')
        	    ->leftjoin('exams as exam','assign_exams.exam_id','exam.id')
                ->where('assign_exams.class_type_id',$request->class_type_id)->get();
                }
                // if(!empty($shaduleData)){
                //     $data1 = $shaduleData;
                // }else{
                //     $data1 = Subject::where('class_type_id',$request->class_type_id)->orderBy('name','ASC')->get();
                // }
                return view('examination.examination_schedule.add',['search'=>$search, 'data1'=> $data1,'studentexamview'=>$data2,'exam_code'=>$exam_code->exam_code ?? '']);
            }
    
            public function SubmitSchedule(Request $request){
                // $shadule = ExaminationSchedule::where('class_type_id',$request->class_type_id__)->where('exam_id',$request->exam_id__)->get();
                if($request->isMethod('post')){
                    $exam_code = "";
                    $old_data = "";
                    if((Int)$request->class_type_id__ > 10){
                        $exam_code = Exam::where('id',$request->exam_id__)->first('exam_code'); 
                        $old_data = ExaminationSchedule::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->get();
                    }
                    else{
                        $exam_code = Exam::where('id',$request->exam_id__)->first('exam_code'); 
                        $old_data = ExaminationSchedule::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->get();
                    }
                    if(count($old_data) > 0){
                        for($i=0; $i<count($request->exam_schedule_detail_id); $i++){
                            $detail = ExaminationScheduleDetail::find($request->exam_schedule_detail_id[$i]);
                            $detail->class_type_id = $request->class_type_id__;
                            $detail->date = $request->date[$i];
                            $detail->from_time = $request->from_time[$i];
                            $detail->to_time = $request->to_time[$i];
                            $detail->subject_id = $request->subject_id[$i];
                            $detail->save();
                        } 
                    }
                    else{
                        $data = new ExaminationSchedule;
                        $data->class_type_id = $request->class_type_id__;
                        $data->exam_id = $request->exam_id__;
                        $data->exam_center = $request->exam_center;
                        $data->exam_code = $exam_code->exam_code;
                        $data->save();
                        for($i=0; $i<count($request->subject_id); $i++){
                            $detail = new ExaminationScheduleDetail;
                            $detail->examination_schedule_id = $data->id;
                            $detail->class_type_id = $request->class_type_id__;
                            $detail->date = $request->date[$i];
                            $detail->from_time = $request->from_time[$i];
                            $detail->to_time = $request->to_time[$i];
                            $detail->subject_id = $request->subject_id[$i];
                            $detail->save();
                        } 
                    }
                }
                return redirect::to('add/examination_schedule')->with('message', 'Schedule Update Successfully.');
            }

            public function addAdmitCard(Request $request){
                $search['class_type_id'] = $request->class_type_id;
                $search['exam_id'] = $request->exam_id;
                $data1 = "";
                $exam_code = "";
                $exam_id = "";
                if($request->isMethod('post')){
                    $data = Admission::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'));
                    $data = $data->orderBy('id','DESC')->get();
                    $exam_code = Exam::where('id',$request->exam_id)->first(); 
                    if((Int)$request->class_type_id > 10){
                        $old_data = ExaminationAdmitCard::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->get();
                    }
                    else{
                        $old_data = ExaminationAdmitCard::where('exam_id',$request->exam_id)->where('class_type_id',$request->class_type_id)->get();
                    }
                    $examSchedule = "";
                    $exam_code = $exam_code->exam_code ?? "";
                    $exam_id = $request->exam_id ?? '';
                    $data1 = "";
                    if(count($old_data) >0) {
                        if((Int)$request->class_type_id > 10){
                            $data1 =  ExaminationAdmitCard::select('examination_admit_cards.*','admission.father_mobile','admission.father_name','admission.admissionNo','admission.name','admission.mobile')
                    	    ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
                            ->where('examination_admit_cards.class_type_id',$request->class_type_id)->where('examination_admit_cards.exam_id',$request->exam_id)->get();
                        }
                        else{
                            $data1 =  ExaminationAdmitCard::select('examination_admit_cards.*','admission.father_mobile','admission.father_name','admission.admissionNo','admission.first_name','admission.last_name','admission.mobile')
                	        ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
                            ->where('examination_admit_cards.class_type_id',$request->class_type_id)->where('examination_admit_cards.exam_id',$request->exam_id)->get();
                        }
                    }
                    else{
                        if((Int)$request->class_type_id > 10){
                            $data1 = Admission::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))
                            ->where('class_type_id',$request->class_type_id)->get();
                        }
                        else{
                            $data1 = Admission::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))
                            ->where('class_type_id',$request->class_type_id)->get();
                        }
                    }
                }
                return view('examination.admit_card.add',['search'=>$search, 'data1'=> $data1,'exam_id'=>$exam_id,'exam_code'=>$exam_code]);
            }
    
            public function SubmitAdmitCard(Request $request){
                if($request->isMethod('post')){
                    $exam_code = Exam::where('id',$request->exam_id__)->first('exam_code'); 
                    $old_data =0;
                    $schedule ="";
                    if((Int)$request->class_type_id__ > 10){
                        $old_data = ExaminationAdmitCard::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->get(); 
                        $schedule = ExaminationSchedule::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->first();
                    }
                    else{
                        $old_data = ExaminationAdmitCard::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->get(); 
                        $schedule = ExaminationSchedule::where('exam_id',$request->exam_id__)->where('class_type_id',$request->class_type_id__)->first();
                    }
                    if(!empty($schedule)){
                        if(count($old_data)> 0){
                            for($i=0; $i<count($request->exam_admit_card_id); $i++){
                                $data = ExaminationAdmitCard::find($request->exam_admit_card_id[$i]);
                                //   $data->class_type_id = $request->class_type_id__;
                                //   $data->exam_id = $request->exam_id__;
                                //   $data->exam_code = $exam_code->exam_code;
                                //   $data->admission_id = $request->admission_id[$i];
                                $data->exam_roll_no = $request->exam_roll_no[$i];
                                $data->examination_schedule_id = $schedule->id;
                                $data->save();
                            }
                        }
                        else{
                            for($i=0; $i<count($request->admission_id); $i++){
                                $data = new ExaminationAdmitCard;
                                $data->class_type_id = $request->class_type_id__;
                                $data->exam_id = $request->exam_id__;
                                $data->exam_code = $exam_code->exam_code;
                                $data->admission_id = $request->admission_id[$i];
                                $data->exam_roll_no = $request->exam_roll_no[$i];
                                $data->examination_schedule_id = $schedule->id;
                                $data->save();
                            }
                        }
                    }
                    else{
                        return redirect::to('add/admit_card')->with('error', 'Examination schedule not prepared for the exam.');
                    }
                }
                return redirect::to('add/admit_card')->with('message', 'Examination Admit Card Update Successfully.');
            }
    
            public function AdmitCardNotes(Request $request){
                $data = AdmitCardNote::find(1);
                if(!empty($data)){
                    $data->user_id = Session::get('id');
                    $data->session_id = Session::get('session_id');
                    $data->branch_id = Session::get('branch_id');
                    $data->note = $request->note;
                    $data->status = 1;
                    $data->save();
                    return redirect::to('add/admit_card')->with('message', 'Note Edit Successfully');
                }
                else{
                    $note = new AdmitCardNote;
                    $note->user_id = Session::get('id');
                    $note->session_id = Session::get('session_id');
                    $note->branch_id = Session::get('branch_id');
                    $note->note = $request->note;
                    $note->status = 1; 
                    $note->save();
                    return redirect::to('add/admit_card')->with('message', 'Note Add Successfully');
                }
            }
      
            public function singleDownloadAdmitCardPdf(Request $request,$class_type_id,$exam_id,$admission_id){
                if($request->isMethod('get')){
                    $exam_code = Exam::where('id',$exam_id)->first('exam_code');
                    $data1="";
                    $data1 =  ExaminationAdmitCard::select('examination_admit_cards.*','class.name as class_name','admission.image as student_profile_image','admission.mother_name','admission.father_mobile','admission.father_name','admission.admissionNo','admission.first_name','admission.last_name','admission.mobile','examination_schedule.id as examination_schedule_id')
            	    ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
            	    ->leftjoin('class_types as class','class.id','examination_admit_cards.class_type_id')
            	    ->leftjoin('examination_schedules as examination_schedule','examination_schedule.id','examination_admit_cards.examination_schedule_id')
                    ->where('examination_admit_cards.class_type_id',$class_type_id)->where('examination_admit_cards.exam_id',$exam_id)
                    ->where('examination_admit_cards.admission_id',$admission_id);
                    if(!empty($data1)) {
                        $data1 =$data1->get();
                        $school_data = Setting::first();
                        $pdf = PDF::loadView('print_file.pdf.admit_card_all',['data'=>$data1,'school_data'=>$school_data]);
                        // return $pdf->download('students_admit_card.pdf');
                        return view('print_file.pdf.admit_card_all',['data'=>$data1,'school_data'=>$school_data]);
                    }
                    else{
                        return redirect::to('add/admit_card')->with('error', 'No Data Found.');
                    }  
                }
          
            }
      
            public function examTerminal(Request $request){
                return view('examination.examTerminal');
            }
            
            public function examTerminal2(Request $request){
                return view('examination.digitalExamTerminal');
            }
    
    
} 