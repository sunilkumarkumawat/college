<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuestionDigital extends Model
{
        use SoftDeletes;
	protected $table = "questions_digital"; //table name

    public function Subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    } 

    public function ClassType(){
        return $this->belongsTo('App\Models\ClassType','class_type_id');
    } 
    public function QuestionTypeDigital(){
        return $this->belongsTo('App\Models\exam\digital\QuestionTypeDigital','question_type_id');
    } 

//     public static function countQuestion(){
//         $data = Question::where('session_id',Session::get('session_id'));
        
//         if(Session::get('role_id') > 1){
//             $data = $data->where('branch_id',Session::get('branch_id'));
//         }
// 		 $data = $data->count();
//         return $data;
//     }
	
    
}