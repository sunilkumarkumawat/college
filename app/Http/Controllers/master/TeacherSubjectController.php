<?php

namespace App\Http\Controllers\master;

use Illuminate\Validation\Validator;
use App\Models\User;
use App\Models\TeacherCategory;
use App\Models\Subject;
use App\Models\Master\TeacherSubject;
use Session;
use Hash;
use Str;
use Redirect;
use Helper;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller

{
            public function teacherSubjectAdd(Request $request){
                if ($request->isMethod('post')) {
                    $request->validate([
                        'teacher_id'  => 'required',
                        'class_type_id'  => 'required',
                        'subject_id'  => 'required',
                        'time_period_id'  => 'required',
                    ]);
                    $check = TeacherSubject::where('class_type_id',$request->class_type_id)->where('branch_id',Session::get('branch_id'))->where('time_period_id',$request->time_period_id)->count();
                    if($check == 0){
                        $section = new TeacherSubject; //model name
                        $section->session_id = Session::get('session_id');
                        $section->branch_id = Session::get('branch_id');
                        $section->user_id = Session::get('id');
                        $section->teacher_id = $request->teacher_id;
                        $section->class_type_id = $request->class_type_id;
                        $section->time_period_id = $request->time_period_id;
                        $section->subject_id = $request->subject_id;
                        $section->save();
                        return redirect::to('teacher_subject_add')->with('message', 'Teacher Subject Time add Successfully.');
                    }
                    else{  
                        return redirect::to('teacher_subject_add')->with('error', 'Subject time has already been added ! ');
                    }
                }
                $data = TeacherSubject::select('teacher_subjects.*','class_types.name as class_name','subject.name as subject_name','teachers.first_name','teachers.last_name',
                'time_periods.from_time','time_periods.to_time')
                ->leftjoin('class_types','class_types.id','teacher_subjects.class_type_id')
                ->leftjoin('subject','subject.id','teacher_subjects.subject_id')
                ->leftjoin('teachers','teachers.id','teacher_subjects.teacher_id')
                ->leftjoin('time_periods','time_periods.id','teacher_subjects.time_period_id')->where('teacher_subjects.branch_id',Session::get('branch_id'))->orderBy('class_types.orderBy','ASC')->orderBy('time_periods.from_time','ASC')->get();
                return view('master.TeacherSubject.add', ['data' => $data]);
            }
                
            public function teacherSubjectEdit(Request $request, $id){
                $data = TeacherSubject::find($id);
                if ($request->isMethod('post')) {
                    $request->validate([
                        'teacher_id'  => 'required',
                        'class_type_id'  => 'required',
                        'subject_id'  => 'required',
                        'time_period_id'  => 'required',
                    ]);
                    $data->session_id = Session::get('session_id');
                    $data->branch_id = Session::get('branch_id');
                    $data->subject_id = $request->subject_id;
                    $data->teacher_id = $request->teacher_id;
                    $data->class_type_id = $request->class_type_id;
                    $data->time_period_id = $request->time_period_id;
                    $data->save();
                    return redirect::to('teacher_subject_add')->with('message', 'Teacher Subject Edited Successfully.');
                }
                return view('master.TeacherSubject.edit', ['data' => $data]);
            }

            public function teacherSubjectDelete(Request $request){
                $id = $request->delete_id;
                $sss = TeacherSubject::find($id)->delete();
                return redirect::to('teacher_subject_add')->with('message', ' Teacher Subject  Deleted Successfully.');
            }

            public function printTimeTable(Request $request){
                if($request->isMethod('post')){
                    $data = TeacherSubject::select('teacher_subjects.*','class_types.name as class_name','subject.name as subject_name','teachers.first_name','teachers.last_name',
                    'time_periods.from_time','time_periods.to_time')
                    ->leftjoin('class_types','class_types.id','teacher_subjects.class_type_id')
                    ->leftjoin('subject','subject.id','teacher_subjects.subject_id')
                    ->leftjoin('teachers','teachers.id','teacher_subjects.teacher_id')
                    ->leftjoin('time_periods','time_periods.id','teacher_subjects.time_period_id')->where('teacher_subjects.branch_id',Session::get('branch_id'));
                    if(!empty($request->class_type_id_print)){
                        $data = $data->where('teacher_subjects.class_type_id', $request->class_type_id_print)->orderBy('class_types.orderBy','ASC')->orderBy('time_periods.from_time','ASC')->get();
                    }
                    else{
                        $data = $data->orderBy('class_types.orderBy','ASC')->orderBy('time_periods.from_time','ASC')->get();
                    }
                    $printPreview =    Helper::printPreview('Time Table');
                }
                return view($printPreview, ['data' => $data]);                       
            }
    
}
