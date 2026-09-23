<?php

namespace App\Http\Controllers\offline_exam;
use Illuminate\Validation\Validator;
use App\Models\exam\Question;
use App\Models\exam\Exam;
use App\Models\exam\AssignExam;
use App\Models\ClassType;
use Session;
use Helper;
use Str;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function viewExam(Request $request){
        
        
        $search['name'] = $request->name;
            $data = Exam::select('exams.*','class_type.name as class_name','assign_exam.class_type_id as class_id')
                ->leftjoin('assign_exams as assign_exam','exams.id','assign_exam.exam_id')
                ->leftjoin('class_types as class_type','class_type.id','assign_exam.class_type_id')
            ->where('exams.session_id',Session::get('session_id'))
            ->where('exams.branch_id',Session::get('branch_id'));
          
        
            if($request->isMethod('post')){
                if (!empty($request->name)){
                    $data = $data->where("exams.name",'like','%'.$request->name.'%');
                }
            }
            $data = $data->groupBy('exams.id')->orderBy('id','DESC')->get();
          
          
     //    dd(Session::get('role_id'));

     
      
      
    return view('examination.offline_exam.exam.view ',['data'=>$data,'search'=>$search]);
    }
    
    public function addExam(Request $request){
         if($request->isMethod('post')){
                 $request->validate([
                     
         'name'  => 'required',
        //  'class_type_id'  => 'required',
        
         ]);
         $add = new Exam;//model name
	     $add->user_id = Session::get('id');
	     $add->session_id = Session::get('session_id');
         $add->branch_id = Session::get('branch_id');
		 $add->name =$request->name;
		 $add->class_type_id =$request->class_type_id;
		 $add->description =$request->description;
	     $add->save();
	
		  return redirect::to('view/exam')->with('message', 'Exam added Successfully.');
        }

        return view('examination.offline_exam.exam.add');
    } 
    
     public function editExam(Request $request, $id){
         $data = Exam::find($id);
         
        
            if($request->isMethod('post')){
                $request->validate([

         'name'  => 'required',
        //  'class_type_id'  => 'required',
   
         ]);

	     $data->user_id = Session::get('id');
         $data->session_id = Session::get('session_id');
         $data->branch_id = Session::get('branch_id');	     
		 $data->name =$request->name;
		 $data->class_type_id =$request->class_type_id;
	     $data->save();

            return redirect::to('view/exam')->with('message', 'Exam Updated Successfully.');
        }

        return view('examination.offline_exam.exam.edit',['data'=>$data]);
    } 
    
    public function assignExam(Request $request, $id){
      
    $examId = $id;
    $data2 = Exam::where('id', $id)->first();

    $AssignExam = AssignExam::select('assign_exams.*', 'class_types.name as class_name')
                ->leftJoin('class_types', 'class_types.id', 'assign_exams.class_type_id')
                ->where('assign_exams.exam_id', $id)
                ->where('assign_exams.session_id', Session::get('session_id'))
                ->where('assign_exams.branch_id', Session::get('branch_id'))
                ->get();

    if ($request->isMethod('post')) {
        $request->validate([
            'class_type_id' => 'required|array',
        ]);

        $addedClasses = [];

        // Loop through class_type_ids
        foreach ($request->class_type_id as $classTypeId) {
            $old = AssignExam::where('class_type_id', $classTypeId)
                ->where('exam_id', $examId)
                ->first();

            if ($old) {
                
                continue; 
            }

            $add = new AssignExam();
            $add->user_id = Session::get('id');
            $add->session_id = Session::get('session_id');
            $add->branch_id = Session::get('branch_id');
            $add->class_type_id = $classTypeId;
            $add->exam_id = $examId;
            $add->save();

            $class = ClassType::find($classTypeId);
            $addedClasses[] = $class->name;
        }

        // Prepare message for the result
        $message = 'Exam Assigned Successfully.';

        if (!empty($addedClasses)) {
            $message .= ' Added to classes: ' . implode(', ', $addedClasses) . '.';
        }
     


        return redirect()->to('assign/exam/' . $examId)->with('message', $message);
    }

    return view('examination.offline_exam.exam.assign', ['AssignExam' => $AssignExam, 'data' => $data2]);
}


    
    /* public function assignExam(Request $request, $id){
        $examId = $id;
          $data2 = Exam::where('id',$id)->first();
           $AssignExam = AssignExam::select('assign_exams.*','class_types.name as class_name')
        ->leftjoin('class_types','class_types.id','assign_exams.class_type_id')->where('assign_exams.exam_id',$id)->where('assign_exams.session_id',Session::get('session_id'))->where('assign_exams.branch_id',Session::get('branch_id'))->get();
        
        
         if($request->isMethod('post')){
                 $request->validate([
                     
            'class_type_id'  => 'required',
         ]);
         $old = AssignExam::where('class_type_id',$request->class_type_id)->where('exam_id',$examId)->first();
         if(!empty($old)){
           return redirect::to('assign/exam/'.$examId)->with('error', 'Class already exists !');
         }
         $add = new AssignExam; //model name
	     $add->user_id = Session::get('id');
	     $add->session_id = Session::get('session_id');
         $add->branch_id = Session::get('branch_id');    
// 		 $add->class_type_id = $request->class_type_id;
		 $add->class_type_id=serialize($request->class_type_id);
		 $add->exam_id = $examId;
	     $add->save();
	     
	          
		 return redirect::to('assign/exam/'.$examId)->with('message', 'Exam Assigned Successfully.');
        }
        return view('examination.offline_exam.exam.assign',['AssignExam'=>$AssignExam,'data'=>$data2]);
    } */
    

    
     public function deleteAssignExam(Request $request){
        $question = AssignExam::find($request->assign_id)->delete();
        return redirect::to('assign/exam/'.$request->exam_id)->with('message', 'Class Unassigned Successfully.');
    }
    
}