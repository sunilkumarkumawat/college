<?php

namespace App\Http\Controllers\offline_exam;
use Illuminate\Validation\Validator;
use App\Models\ExaminationAdmitCard;

use App\Models\exam\Exam;
use App\Models\Admission;
use App\Models\Setting;
use App\Models\exam\AssignExam;
use Session;

use Helper;
use Str;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
class AdmitCardController extends Controller
{
            public function addAdmitCard(Request $request){
                $search['class_type_id'] = $request->class_type_id;
                $search['section_id'] = $request->section_id;
                $search['exam_id'] = $request->exam_id;
                $search['stream_id'] = $request->stream_id;
                $students = Admission::where("session_id", Session::get("session_id"))
                ->where("branch_id", Session::get("branch_id"));
                if($request->isMethod('post')){
                    if($request->class_type_id != ''){
                        $students = $students->where("class_type_id", $request->class_type_id);
                    }
                    $students = $students->orderBy("first_name", "ASC")->get();
                    return view('examination.offline_exam.admit_card.add',['search'=>$search, 'data1'=> $students,'exam_id'=>$request->exam_id ?? '']);
                }
                return view('examination.offline_exam.admit_card.add',['search'=>$search, 'data1'=> $students,'exam_id'=>$request->exam_id ?? '']);
            }
    
            public function download_admit_card(Request $request){
                $search['class_type_id'] = $request->class_type_id;
                $search['section_id'] = $request->section_id;
                $search['exam_id'] = $request->exam_id;
                $students = Admission::where("session_id", Session::get("session_id"))
                ->where("branch_id", Session::get("branch_id"))->where('status',1)->where('status',1);
                if($request->isMethod('post')){
                    if($request->class_type_id != ''){
                        $students = $students->where("class_type_id", $request->class_type_id);
                        $exam =  AssignExam::select('assign_exams.*','exam.id as exam_id','exam.name as exam_name')
                	    ->leftjoin('exams as exam','assign_exams.exam_id','exam.id')
                        ->where('assign_exams.class_type_id',$request->class_type_id)
                        ->where('assign_exams.session_id',Session::get('session_id'))
                        ->where('assign_exams.branch_id',Session::get('branch_id'))
                        ->get();
                    }
                    $students = $students->orderBy("first_name", "ASC")->get();
                    return view('examination.offline_exam.admit_card.download_admit_card',['search'=>$search, 'exam'=>$exam,'data1'=> $students,'exam_id'=>$request->exam_id ?? '']);
                }
                return view('examination.offline_exam.admit_card.download_admit_card',['search'=>$search, 'data1'=> $students,'exam_id'=>$request->exam_id ?? '']);
            }
    
            public function SubmitAdmitCard(Request $request){
                if($request->isMethod('post')){
                    $students = Admission::where("session_id", Session::get("session_id"))
                    ->where("branch_id", Session::get("branch_id"))
                    ->where("class_type_id", $request->class_type_id)
                    ->orderBy("first_name", "ASC")->get();
                    if (!empty($request->exam_admit_card_id)) {
                        for($i=0; $i<count($request->exam_admit_card_id); $i++){
                            if($request->exam_admit_card_id[$i] != ''){
                                $add = ExaminationAdmitCard::find(
                                    $request->exam_admit_card_id[$i]
                                 );
                            }
                            else{
                                $add = new ExaminationAdmitCard();
                            }
                            $add->user_id = Session::get("id");
                            $add->session_id = Session::get("session_id");
                            $add->branch_id = Session::get("branch_id");
                            $add->class_type_id = $request->class_type_id;
                            $add->exam_id = $request->exam_id;
                            $add->admission_id = $request->admission_id[$i];
                            $add->exam_roll_no = $request->exam_roll_no[$i];
                            //    $add->examination_schedule_id = $schedule->id;
                            $add->save();
                        } 
                    }
                    return redirect::to('add/admit_card')->with('message', 'Examination Admit Card Update Successfully.')->with('data1',$students);
                }
                return redirect::to('add/admit_card')->with('message', 'Examination Admit Card Update Successfully.');
            }
    
            public function singleDownloadAdmitCardPdf(Request $request,$class_type_id,$exam_id,$admission_id){
                if($request->isMethod('get')){
                    $data =  ExaminationAdmitCard::select('examination_admit_cards.*','exams.name as exam_name','class.name as class_name','admission.image as student_profile_image','admission.mother_name','admission.father_mobile','admission.father_name','admission.admissionNo','admission.first_name','admission.mobile')
            	    ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
            	    ->leftjoin('class_types as class','class.id','examination_admit_cards.class_type_id')
            	    ->leftjoin('exams','exams.id','examination_admit_cards.exam_id')
                    ->where('examination_admit_cards.class_type_id',$class_type_id)->where('examination_admit_cards.exam_id',$exam_id)
                    ->where('examination_admit_cards.admission_id',$admission_id)->get();
                    $school_data = Setting::first();
                    //$pdf = PDF::loadView('print_file.pdf.admit_card_all',['data'=>$data1,'school_data'=>$school_data]);
                    $printPreview =    Helper::printPreview('Admit Card');
                    // dd($printPreview);
                    return view($printPreview, ['data'=>$data,'school_data'=>$school_data]);
                    //return view('print_file.pdf.admit_card_all',['data'=>$data,'school_data'=>$school_data]);
                }
            }
      
            public function downloadAdmitCard(Request $request,$exam_id,$class_type_id,$admission_id){
                $arr ;
                if ($admission_id != ""){
                    foreach(explode(',', $admission_id) as $info){
                        $arr[] = $info;
                    }
                }
                if($request->isMethod('get')){
                    $data =  ExaminationAdmitCard::select('examination_admit_cards.*','exams.name as exam_name','class.name as class_name','class.orderBy as class_orderBy',
                    'admission.image as student_profile_image','admission.mother_name','admission.father_mobile','admission.father_name',
                    'admission.admissionNo','admission.first_name','admission.mobile','admission.stream_subject')
            	    ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
            	    ->leftjoin('class_types as class','class.id','examination_admit_cards.class_type_id')
            	    ->leftjoin('exams','exams.id','examination_admit_cards.exam_id')
                    ->where('examination_admit_cards.class_type_id',$class_type_id)->where('examination_admit_cards.exam_id',$exam_id)
                    ->whereIn('examination_admit_cards.admission_id',$arr)->where("examination_admit_cards.session_id", Session::get("session_id"))
                    ->where("examination_admit_cards.branch_id", Session::get("branch_id"))->orderBy('id', 'ASC')->get();
                    $school_data = Setting::where("branch_id", Session::get("branch_id"))->first();
                    //$pdf = PDF::loadView('print_file.pdf.admit_card_all',['data'=>$data1,'school_data'=>$school_data]);
                    $printPreview =    Helper::printPreview('Admit Card');
                     //dd($printPreview);
                    return view($printPreview, ['data'=>$data,'school_data'=>$school_data]);
                    // return view('print_file.pdf.admit_card_all',['data'=>$data,'school_data'=>$school_data]);
                }
            }
            
            public function without_subject_admit_card(Request $request,$exam_id,$class_type_id,$admission_id){
                $arr ;
                if ($admission_id != ""){
                    foreach(explode(',', $admission_id) as $info){
                        $arr[] = $info;
                    }
                }
                if($request->isMethod('get')){
                    $data =  ExaminationAdmitCard::select('examination_admit_cards.*','exams.name as exam_name','class.name as class_name','admission.image as student_profile_image','admission.mother_name','admission.father_mobile','admission.father_name','admission.admissionNo','admission.first_name','admission.mobile')
            	    ->leftjoin('admissions as admission','admission.id','examination_admit_cards.admission_id')
            	    ->leftjoin('class_types as class','class.id','examination_admit_cards.class_type_id')
	                ->leftjoin('exams','exams.id','examination_admit_cards.exam_id')
                    ->where('examination_admit_cards.class_type_id',$class_type_id)->where('examination_admit_cards.exam_id',$exam_id)
                    ->whereIn('examination_admit_cards.admission_id',$arr)->where("examination_admit_cards.session_id", Session::get("session_id"))
                    ->where("examination_admit_cards.branch_id", Session::get("branch_id"))->orderBy('id', 'DESC')->get();
                    $school_data = Setting::where("branch_id", Session::get("branch_id"))->first();
                    //$pdf = PDF::loadView('print_file.pdf.admit_card_all',['data'=>$data1,'school_data'=>$school_data]);
                    $printPreview =    Helper::printPreview('Admit Card');
                    //   dd($printPreview);
                    return view("master.printFilePanel.ExaminationManagement.without_sub_admit_card", ['data'=>$data,'school_data'=>$school_data]);
                    // return view('print_file.pdf.admit_card_all',['data'=>$data,'school_data'=>$school_data]);
                }
            }
}