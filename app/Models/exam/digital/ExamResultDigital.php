<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExamResultDigital extends Model
{
        use SoftDeletes;
	protected $table = "exam_results_digital"; //table name

//     public function Exam(){
//         return $this->belongsTo('App\Models\exam\Exam','exam_id');
//     } 

//     public function AssignExam(){
//         return $this->belongsTo('App\Models\exam\AssignExam','exam_id');
//     } 

//     public function Admission(){
//         return $this->belongsTo('App\Models\Admission','admission_id');
//     } 

//     public static function countExamResult(){
//         $data = ExamResult::where('session_id',Session::get('session_id'))
// 		 ->where('branch_id',Session::get('branch_id'))->count();
//         return $data;
//     }
//     public static function countExamResultStudent(){
//         $data = ExamResult::where('session_id',Session::get('session_id'))
// 		 ->where('branch_id',Session::get('branch_id'))->where('admission_id',Session::get('id'))->count();
//         return $data;
//     }
    
}