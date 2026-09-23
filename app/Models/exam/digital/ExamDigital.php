<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExamDigital extends Model
{
        use SoftDeletes;
	protected $table = "exams_digital"; //table name

    protected $fillable = [
        'user_id', 
        'branch_id',
        'session_id',
    ];
    
    public function Subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    } 
    
//     public static function countExam(){
//         $data = Exam::where('session_id',Session::get('session_id'));
        
//         if(Session::get('role_id') > 1){
//             $data = $data->where('branch_id',Session::get('branch_id'));
//         }
// 		$data = $data->count();
//         return $data;
//     }
//     public static function countExamStudent(){
       
//         $data = Exam::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->whereIn('class_type_id',[Session::get('class_type_id'),3])->count();
//         return $data;
//     }

//     public static function thisMonthExam(){
//         $data = Exam::where('session_id',Session::get('session_id'));
        
//         if(Session::get('role_id') > 1){
//             $data = $data->where('branch_id',Session::get('branch_id'));
//         }
        
//         $data = $data->whereMonth('exam_date',date('m'))->count();
//         return $data;
//     }
    
}