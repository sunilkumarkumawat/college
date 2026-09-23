<?php

namespace App\Http\Controllers\student_login;
use App\Models\User;
use App\Models\State;
use App\Models\Admission;
use App\Models\Master\Branch;
use App\Models\Master\Uniform;
use App\Models\Master\Rule;
use App\Models\Master\GatePass;
use App\Models\Master\Prayer;
use App\Models\Master\Homework;
use App\Models\Master\TeacherSubject;
use Illuminate\Validation\Validator;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

            public function timetableView(){
                $data = TeacherSubject::select('teacher_subjects.*', 'subject.name as subjectName', 'teachers.first_name', 'teachers.last_name', 'class_types.name as className', 'time_periods.from_time', 'time_periods.to_time')
                    ->leftjoin('teachers', 'teachers.id', 'teacher_subjects.teacher_id')
                    ->leftjoin('class_types', 'class_types.id', 'teacher_subjects.class_type_id')
                    ->leftjoin('time_periods', 'time_periods.id', 'teacher_subjects.time_period_id')
                    ->leftjoin('subject', 'subject.id', 'teacher_subjects.subject_id')
                    ->where('teacher_subjects.class_type_id', Session::get('class_type_id'))
                    ->where('teacher_subjects.session_id', Session::get('session_id'))
                    ->get();
                return view('dashboard.student.timetable', ['data' => $data]);
            }
        
            public function homeworkView(){
                $allhomework = Homework::with('Subject')->orderBy('id', 'DESC')->get();
                return view('dashboard.student.homework', ['data' => $allhomework]);
            }
        
            public function gatePassView(){
                $admissionNo = Admission::where('session_id', Session::get('session_id'))->where('id', Session::get('id'));
                $count = $admissionNo->count();
                $data = "";
                if ($count > 0) {
                    $admissionNo = $admissionNo->first();
                    $data = GatePass::where('admissionNo', $admissionNo->id)->get();
                }
                return view('dashboard.student.gate_pass_view', ['data' => $data]);
            }
        
            public function prayerView(){
                $data = Prayer::get();
                return view('dashboard.student.prayer_view', ['data' => $data]);
            }
        
            public function uniformView(){
                $data = Uniform::get();
                return view('dashboard.student.uniform_view', ['data' => $data]);
            }
        
            public function ruleView(){
                $data = Rule::get();
                return view('dashboard.student.rule_view', ['data' => $data]);
            }

}
