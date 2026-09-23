<?php

namespace App\Models\exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExamResultDetail extends Model
{
        use SoftDeletes;
	protected $table = "exam_result_details"; //table name

    public function ExamResult(){
        return $this->belongsTo('App\Models\exam\ExamResult','exam_result_id');
    } 
    
    public function Exam(){
        return $this->belongsTo('App\Models\exam\Exam','exam_id');
    } 
    
    public function Question(){
        return $this->belongsTo('App\Models\exam\Question','ques_id');
    } 

    public function Admission(){
        return $this->belongsTo('App\Models\Admission','admission_id');
    } 
	
}