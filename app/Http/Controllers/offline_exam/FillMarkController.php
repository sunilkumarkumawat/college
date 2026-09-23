<?php

namespace App\Http\Controllers\offline_exam;
use Illuminate\Validation\Validator;
use App\Models\exam\Question;
use App\Models\exam\Exam;
use App\Models\exam\AssignExam;
use App\Models\exam\FillMinMaxMarks;
use App\Models\exam\FillMarks;
use App\Models\Admission;
use App\Models\exam\ExaminationSchedule;
use App\Models\examoffline\PerformanceMarks;
use App\Models\exam\ExaminationScheduleDetail;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassType;
use App\Models\Master\TeacherSubject;
use Session;
use Helper;
use Str;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class FillMarkController extends Controller
{
            public function fillMarks(Request $request){
                $search["name"] = "";
                $search["class_type_id"] = $request->class_type_id;
                $search["class_type_id"] = $request->class_name;
                $search["exam_id"] = $request->exam_id ?? "";
                $data1 = "";
                $data2 = "";
                $marks = "";
                if ($request->isMethod("post")) {
                    $request->validate([]);
                    $classOrderBy = ClassType::where('id',$request->class_name)->first('orderBy');
                    $subjects = Subject::where("class_type_id", $request->class_name)
                    ->orderBy("sort_by", "ASC");
                    if(Session::get('role_id') == 2){
                        $checkClassTeacher= Teacher::where('id',Session::get('teacher_id'))->where('class_type_id',$request->class_name)->first();
                        if(empty($checkClassTeacher)){
                            $classes = TeacherSubject::where('teacher_id',Session::get('teacher_id'))->where('class_type_id',$request->class_name)->groupBy('subject_id')->get();
                            if(!empty($classes)){
                                $att = array();
                                foreach($classes as $item){
                                    $att[] = $item->subject_id;
                                }
                                $subjects =$subjects->whereIn('id',$att);
                            }
                        }
                    }
                    $subjects = $subjects->get();
                    $students = Admission::where("class_type_id", $request->class_name)
                    ->where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->orderBy("first_name", "ASC")
                    ->get();
                    $examlist = AssignExam::select(
                        "assign_exams.*",
                        "exam.id as exam_id",
                        "exam.name as exam_name"
                    )
                    ->leftjoin("exams as exam", "assign_exams.exam_id", "exam.id")
                    ->where("assign_exams.class_type_id", $request->class_name)
                    ->where('assign_exams.session_id',3)
                    ->get();
                    return view("examination.offline_exam.fill_mark.fill_marks", [
                        "data1" => $subjects,
                        "data2" => $students,
                        "search" => $search,
                        "examlist" => $examlist,
                        "classOrderBy" => $classOrderBy->orderBy,
                    ]);
                }
                return view("examination.offline_exam.fill_mark.fill_marks", [
                    "search" => $search,
                ]);
            }
    
            public function performanceMarks(Request $request){
                $search["class_type_id"] = $request->class_name;
                $search["term_id"] = $request->term_id ?? "";
                $data1 = "";
                $data2 = "";
                $marks = "";
                if ($request->isMethod("post")) {
                    $request->validate([]);
                    $subjects = Subject::where("class_type_id", $request->class_name)
                    ->where("branch_id", Session::get("branch_id"))
                    ->where("other_subject", 1)
                    ->orderBy("name", "ASC")
                    ->get();
                    $students = Admission::where("class_type_id", $request->class_name)
                    ->where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->orderBy("first_name", "ASC")
                    ->get();
                    return view("examination.offline_exam.fill_mark.performance_marks", [
                        "data1" => $subjects,
                        "data2" => $students,
                        "search" => $search,
                    ]);
                }
                return view("examination.offline_exam.fill_mark.performance_marks", [
                    "search" => $search,
                ]);
            }
    
            public function performanceMarksSubmit(Request $request){
                if ($request->isMethod("post")) {
                    $count = 0;
                    if (!empty($request->admission_id)) {
                        for ($i = 0; $i < count($request->admission_id); $i++) {
                            for ($j = 0; $j < count($request->subject_id); $j++) {
                                if (!empty($request->performance_marks_id)) {
                                    if($request->performance_marks_id[$count] != ''){
                                        $add1 = PerformanceMarks::find(
                                            $request->performance_marks_id[$count]
                                        );
                                    }
                                    else{
                                        $add1 = new PerformanceMarks();
                                    }
                                } 
                                $add1->term_id = $request->term_id;
                                $add1->class_type_id = $request->class_type_id;
                                $add1->admission_id = $request->admission_id[$i];
                                $add1->user_id = Session::get("id");
                                $add1->session_id = Session::get("session_id");
                                $add1->branch_id = Session::get("branch_id");
                                if (isset($request->performance[$request->subject_id_fill[$count]])) {
                                    $add1->performance = $request->performance[$request->subject_id_fill[$count]] == 1 ? 1 : 0;
                                } 
                                else{
                                    $add1->performance = 0; 
                                }
                                $add1->subject_id = $request->subject_id_fill[$count];
                                $add1->student_marks = $request->student_marks[$count];
                                if($request->check_null[$count] != null){
                                    $add1->save();
                                }
                                else{
                                    if($request->student_marks[$count] != ''){
                                        $add1->save();
                                    }
                                }
                                    $count++;
                            }
                        }
                    }
                    return redirect::to("performance_marks")->with(
                        "message",
                        "Marks Updated Successfully."
                    );
                }
            }

            public function fillMarksSubmit(Request $request){
                if ($request->isMethod("post")) {
                    $count1 = 0;
                    if (!empty($request->subject_id)) {
                        for ($i = 0; $i < count($request->subject_id); $i++) {
                            if (!empty($request->fill_min_max_marks_id)) {
                                if($request->fill_min_max_marks_id[$count1] != ''){
                                    $add = FillMinMaxMarks::find(
                                        $request->fill_min_max_marks_id[$count1]
                                    );
                                }
                                else{
                                    $add = new FillMinMaxMarks();
                                }
                            } 
                            $add->class_type_id = $request->class_type_id;
                            $add->exam_id = $request->exam_id;
                            $add->user_id = Session::get("id");
                            $add->session_id = Session::get("session_id");
                            $add->branch_id = Session::get("branch_id");
                            $add->subject_id = $request->subject_id[$i];
                            $add->exam_minimum_marks = $request->exam_minimum_marks[$i];
                            $add->exam_maximum_marks = $request->exam_maximum_marks[$i];
                            $add->save();
                            $count1++;
                        }
                    }
                    $count = 0;
                    if (!empty($request->admission_id)) {
                        for ($i = 0; $i < count($request->admission_id); $i++) {
                            for ($j = 0; $j < count($request->subject_id); $j++) {
                                if (!empty($request->fill_marks_id)) {
                                    if($request->fill_marks_id[$count] != ''){
                                        $add1 = FillMarks::find(
                                            $request->fill_marks_id[$count]
                                        );
                                    }
                                    else{
                                        $add1 = new FillMarks();
                                    }
                                } 
                                $add1->exam_id = $request->exam_id;
                                $add1->class_type_id = $request->class_type_id;
                                $add1->admission_id = $request->admission_id[$i];
                                $add1->user_id = Session::get("id");
                                $add1->session_id = Session::get("session_id");
                                $add1->branch_id = Session::get("branch_id");
                                $add1->subject_id = $request->subject_id_fill[$count];
                                $add1->student_marks = $request->student_marks[$count];
                                // if($request->check_null[$count] != null)
                                // {
                                //      $add1->save();
                                // }
                                // else{
                                //      if($request->student_marks[$count] != '')
                                // {
                                // $add1->save();
                                // }
                                // }
                                $add1->save();
                                $count++;
                            }
                        }
                    }
                    return redirect::to("fill_marks")->with(
                        "message",
                        "Marks Updated Successfully."
                    );
                }
            }

            public function download_marksheet(Request $request){
                $search["name"] = "";
                $search["class_type_id"] = $request->class_name;
                $search["exam_id"] = $request->exam_id ?? "";
                if ($request->isMethod("post")) {
                    $students = Admission::where("class_type_id", $request->class_name)
                    ->where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->orderBy("first_name", "ASC")
                    ->get();
                    $examlist = AssignExam::select(
                        "assign_exams.*",
                        "exam.id as exam_id",
                        "exam.name as exam_name"
                    )
                    ->leftjoin("exams as exam", "assign_exams.exam_id", "exam.id")
                    ->where("assign_exams.class_type_id", $request->class_name)
                    ->get();
                    return view(
                        "examination.offline_exam.download_marksheet.download_marksheet",
                        [
                            "data" => $students,
                            "search" => $search,
                            "examlist" => $examlist,
                        ]
                    );  
                }
                return view(
                    "examination.offline_exam.download_marksheet.download_marksheet",
                    ["search" => $search]
                );
            }
            
            public function printReportCard(Request $request){
                if($request->isMethod('post')){
                    $student = Admission::where("id", $request->admission_id)
                    ->where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->first();
                    $subjects = Subject::where("class_type_id", $request->class_type_id)
                    ->where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->orderBy("name", "ASC")
                    ->get();
                    return view('examination.offline_exam.download_marksheet.download_pdf',['data'=>$student,'subjects'=>$subjects,'exam_id'=>$request->exam_id]);
                }
            }
    
            public function bulk_marksheet(Request $request){
                $search['class_type_id'] = $request->class_type_id ?? '';
                    if($request->isMethod('post')){
                        $student_list= Admission::where('class_type_id',$request->class_type_id)
                        ->where("session_id", Session::get("session_id"))
                        ->where("branch_id", Session::get("branch_id"))
                        ->where('status',1)->get();
                        $subjects = Subject::where("class_type_id", $request->class_type_id)
                        ->where("session_id", Session::get("session_id"))
                        ->where("branch_id", Session::get("branch_id"))
                        ->orderBy("name", "ASC")
                        ->get();
                        $exam =  AssignExam::select('assign_exams.*','exam.name as exam_name','exam.id as exam_id')
    	                ->leftjoin('exams as exam','exam.id','assign_exams.exam_id')->
                	    where('exam.deleted_at',null)->
                	    where('assign_exams.class_type_id',$request->class_type_id)->where('assign_exams.session_id',Session::get('session_id'))->groupBy('assign_exams.exam_id')->get();
                        return view('examination.offline_exam.bulk_marksheet.bulk_marksheet',['subject'=>$subjects,'exam'=>$exam ,'search'=>$search,'student_list'=>$student_list]);
                    }
                return view('examination.offline_exam.bulk_marksheet.bulk_marksheet',['search'=>$search]);
            }
            //  public function bulk_marksheet_generate(Request $request){
            //  //dd($request);
            //  $search['class_type_id'] = $request->class_type_id ?? '';
            //  $subject ='';
            //  $exam ='';
            //   if($request->isMethod('post')){
            //         $classOrderBy = ClassType::where('id',$request->class_type_id)->first('orderBy');
            //       $admission_id = Admission::where('class_type_id',$request->class_type_id)
            //         ->where("session_id", Session::get("session_id"))
            //                 ->where("branch_id", Session::get("branch_id"))
            //       ->where('status',1);
            //           if($request->single_student != '')
            //             {
            //           $admission_id  = $admission_id ->where('admissionNo',$request->single_student);
            //             }
            //           $admission_id =$admission_id->get();
            //          $a = $request->exam_array;
            //          $b = $request->subject_array;
            //          $exam_id ;
            //          $subject_id ;
            //          $subject_id_exculded=[] ;
            //          $count=0;
            //          $count1=0;
            //         foreach($a as $key=>$item)
            //         {
            //             $count++;
            //             $exam_id[] =array_search($count, $a);
            //         }
            //         foreach($b as $key=>$item)
            //         {
            //             Subject::where('id',$key)->update(['sort_by'=>$item]);
                     
            //             $count1++;
            //             $subject_id[] =array_search($count1, $b);
            //         }
              
                    
            //         foreach($exam_id as $key=>$item)
            //         {
            //         $list_exam[$key] = Exam::where('id',$item)->first();
            //         }
            //         foreach($subject_id as $key=>$item)
            //         {
            //         $list_subject[$key] = Subject::select('subject.*')->where('subject.id',$item)->first();
            //         $value= Subject::select('subject.*')->where('other_subject' ,0)->where('subject.id',$item)->first();
                    
            //         if(!empty($value))
            //         {
            //             $subject_id_exculded[] = $value->id;
            //         }
            //         }
                  
                  
                  
            //       $getClassOrder = ClassType::where('id',$request->class_type_id)->first('orderBy');
                    
            //      if($request->make_grade == 0)
            //      {
                     
            //          if($getClassOrder->orderBy > 10)
            //          {
            //               return view('print_file.exam.marksheet_2', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);     
                   
            //          }
            //          else
            //          {
            //               return view('print_file.exam.marksheet_1', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);     
                   
            //          }
                       
            
            //     //  return view('examination.offline_exam.download_marksheet.demo',['exam_id'=>$exam_id,'subject_id'=>$subject_id,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);
            //     //  return view('examination.offline_exam.download_marksheet.numberMarksheet',['exam_id'=>$exam_id,'subject_id'=>$subject_id,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);
            //      }
            //      else
            //      {
            //     //  $printPreview =    Helper::printPreview('Marksheet');
                    
            //     //  return view($printPreview, ['exam_id'=>$exam_id,'subject_id'=>$subject_id,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);          
            //       return redirect::to("bulk_marksheet")->with(
            //                 "error",
            //                 "Marksheet template for the current class is not ready."
            //             );
            //           // return view('examination.offline_exam.download_marksheet.gradeMarksheet',['exam_id'=>$exam_id,'subject_id'=>$subject_id,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);
            //      }
            //      }
            //     }
            
            public function bulk_marksheet_generate(Request $request){
            $search['class_type_id'] = $request->class_type_id ?? '';
            $subject ='';
            $exam ='';
            if($request->isMethod('post')){
                $classOrderBy = ClassType::where('id',$request->class_type_id)->first('orderBy');
                $admission_id = Admission::where('class_type_id',$request->class_type_id)
                ->where("session_id", Session::get("session_id"))
                ->where("branch_id", Session::get("branch_id"))
                ->where('status',1);
                if($request->single_student != ''){
                    $admission_id  = $admission_id ->where('id',$request->single_student);
                }
                $admission_id =$admission_id->get();
                $a = $request->exam_array;
                $b = $request->subject_array;
                $exam_id ;
                $subject_id ;
                $subject_id_exculded=[] ;
                $count=0;
                $count1=0;
                foreach($a as $key=>$item){
                    $count++;
                    $exam_id[] =array_search($count, $a);
                }
                foreach($b as $key=>$item){
                    //Subject::where('id',$key)->update(['sort_by'=>$item]);
                    $count1++;
                    $subject_id[] =array_search($count1, $b);
                }
                foreach($exam_id as $key=>$item){
                    $list_exam[$key] = Exam::where('id',$item)->first();
                }
                foreach($subject_id as $key=>$item){
                    $list_subject[$key] = Subject::select('subject.*')->where('subject.id',$item)->first();
                    $value= Subject::select('subject.*')->where('other_subject' ,0)->where('subject.id',$item)->first();
                    if(!empty($value)){
                        $subject_id_exculded[] = $value->id;
                    }
                }
                if($classOrderBy->orderBy > 8){
                    if(Session::get('role_id') == 3){
                        $pdf = PDF::loadView('print_file.exam.marksheet_pdf_2', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);
                        $pdf->setPaper('A4', 'portrait');
                        return $pdf->download('Marksheet.pdf');
                    }
                    return view('print_file.exam.marksheet_2', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);     
                    }
                    else{
                        if(Session::get('role_id') == 3){
                            $pdf = PDF::loadView('print_file.exam.marksheet_pdf', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);
                            $pdf->setPaper('A4', 'portrait');
                            return $pdf->download('Marksheet.pdf');
                        }
                        return view('print_file.exam.marksheet_1', ['classOrderBy'=>$classOrderBy->orderBy,'exam_id'=>$exam_id,'subject_id'=>$subject_id_exculded,'admission_id'=>$admission_id,'list_subject'=>$list_subject,'subject'=>$subject,'exam'=>$exam,'list_exam'=>$list_exam]);     
                    }
                }
            }

            public function myExams(Request $request){
                $class_type_id = Session::get('class_type_id');
                $admission_id = Session::get('id');
                $classOrder = 0;    
                $subject_array=[];
                $exam_array=[];
                if(!empty($class_type_id)){
                    $classOrder = ClassType::where('id',$class_type_id)->first();
                    $classOrder = $classOrder->orderBy ?? 0 ;
                    $exam = AssignExam::where('class_type_id',$class_type_id)->whereNotNull('result_declaration_date')->where('result_declaration_date','<=',date('Y-m-d'))->pluck('exam_id')->implode(',');
                    if(!empty($exam)){
                        $exam = explode(',',$exam);
                        foreach($exam as $key=>$arr){
                            $exam_array[$arr] = $key+1;
                        }
                    }
                }
                if($classOrder > 10){
                    $streams = Admission::where('id',$admission_id)->first();
                    if(!empty($streams)){
                        $subjects = $streams->stream_subject != '' ? $streams->stream_subject : '';  
                    }
                }
                else{
                    $subjects = Subject::where('class_type_id',$class_type_id)->pluck('id')->implode(',');
                }
                if(!empty($subjects)){
                    $subjects = explode(',',$subjects);
                    foreach($subjects as $key=>$arr){
                        $subject_array[$arr] = $key+1;
                    }
                }
                return view('examination.offline_exam.exam.myExams',['subjects'=>$subjects,'subject_array'=>$subject_array,'exam'=>$exam,'exam_array'=>$exam_array,'single_student'=>$admission_id]);
            }
    
}
