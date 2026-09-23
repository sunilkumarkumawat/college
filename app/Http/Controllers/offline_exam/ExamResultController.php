<?php

namespace App\Http\Controllers\offline_exam;
use Illuminate\Validation\Validator;
use App\Models\exam\Question;
use App\Models\exam\Exam;
use App\Models\exam\FillMinMaxMarks;
use App\Models\exam\FillMarks;
use App\Models\Admission;
use App\Models\exam\ExaminationSchedule;
use App\Models\exam\ExaminationScheduleDetail;
use App\Models\Subject;
use Session;
use Helper;
use Str;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamResultController extends Controller
{

            public function examResultGraph(Request $request){
                $exam = "";
                $student = "";
                $search["class_type_id"] = $request->class_type_id;
                $search["admission_id"] = $request->admission_id;
                $search["subject_id"] = $request->subject_id;
                $search["exam_id"] = $request->exam_id;
                $search["pattern"] = $request->pattern;
                $search["toppers"] = $request->toppers;
                if($request->isMethod('post')){
                    if($request->pattern == 1){
                        $exam = ExaminationSchedule::with('Exam')->with('Subject')->with('ClassType');
                        $student = Admission::where('status',1);
                        if(Session::get('role_id') == 2){
                            $exam = $exam->whereIn('class_type_id', explode(',', Session::get('class_type_id')));
                            $student = $student->whereIn('class_type_id', explode(',', Session::get('class_type_id')));
                        }
                        elseif(Session::get('role_id') == 3){
                            $exam = $exam->where('class_type_id', Session::get('class_type_id'));
                            $student = $student->where('class_type_id', Session::get('class_type_id'));
                        }
                        else{
                            $exam = $exam;
                            $student = $student;
                        }
                        if(!empty($request->exam_id)){
                            $exam = $exam->where('exam_id', $request->exam_id);
                        }
                        if(!empty($request->class_type_id)){
                            $exam = $exam->where('class_type_id', $request->class_type_id);
                            $student = $student->where('class_type_id', $request->class_type_id);
                        }
                        if(!empty($request->subject_id)){
                            $exam = $exam->where('subject_id', $request->subject_id);
                        }
                        if(!empty($request->admission_id)){
                            $student = $student->whereIn('id', $request->admission_id);
                        }
                        $exam = $exam->orderBy('class_type_id')->get();
                        $student = $student->orderBy('first_name')->pluck('id');
                    }
                    else if($request->pattern == 2){
                        $exam = ExaminationSchedule::with('Exam')->with('Subject')->with('ClassType');
                        $student = Admission::select('admissions.*')->leftJoin('fill_marks','admissions.id','fill_marks.admission_id')->with('ClassTypes')->where('admissions.status', 1);
                        if(Session::get('role_id') == 2){
                            $exam = $exam->whereIn('class_type_id', explode(',', Session::get('class_type_id')));
                            $student = $student->whereIn('admissions.class_type_id', explode(',', Session::get('class_type_id')));
                        }
                        elseif(Session::get('role_id') == 3){
                            $exam = $exam->where('class_type_id', Session::get('class_type_id'));
                            $student = $student->where('admissions.class_type_id', Session::get('class_type_id'));
                        }
                        else{
                            $exam = $exam;
                            $student = $student;
                        }
                        if(!empty($request->exam_id)){
                            $exam = $exam->where('exam_id', $request->exam_id);
                        }
                        if(!empty($request->class_type_id)){
                            $exam = $exam->where('class_type_id', $request->class_type_id);
                            $student = $student->where('admissions.class_type_id', $request->class_type_id);
                        }
                        if(!empty($request->subject_id)){
                            $exam = $exam->where('subject_id', $request->subject_id);
                        }
                        if(!empty($request->admission_id)){
                            $student = $student->whereIn('admissions.id', $request->admission_id);
                        }
                        $exam = $exam->orderBy('id', 'DESC')->get();
                        $fillMarks = FillMarks::groupBy('admission_id')->pluck('admission_id');
                        if($request->toppers == 1){
                            $student = $student->groupBy('admissions.id')->orderBy('fill_marks.student_marks', 'DESC')->take(3)->get();
                        }else{
                            $student = $student->whereIn('admissions.id', $fillMarks)->groupBy('admissions.id')->orderBy('admissions.first_name')->get();
                        }
                    }
                    else{
                    }
                }
                return view('examination.offline_exam.examResult.examResultGraph',['exam' => $exam, 'studentId' => $student, 'search' => $search]);
            }

}
