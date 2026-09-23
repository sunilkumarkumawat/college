<?php

namespace App\Models\exam;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExamResult extends Model
{
        use SoftDeletes;
	protected $table = "exam_results"; //table name

    public function Exam(){
        return $this->belongsTo('App\Models\exam\Exam','exam_id');
    } 

    public function AssignExam(){
        return $this->belongsTo('App\Models\exam\AssignExam','exam_id');
    } 

    public function Admission(){
        return $this->belongsTo('App\Models\Admission','admission_id');
    } 

    public static function countExamResult(){
        $data = ExamResult::where('session_id',Session::get('session_id'))
		 ->where('branch_id',Session::get('branch_id'))->count();
        return $data;
    }
    
}