<?php

namespace App\Models\examoffline;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExamOffline extends Model
{
        use SoftDeletes;
	protected $table = "exam_offline"; //table name

   
    
    public static function countExam(){
        $data = ExamOffline::where('session_id',Session::get('session_id'))
		 ->where('branch_id',Session::get('branch_id'))->count();
        return $data;
    }

    public static function thisMonthExam(){
        $data = ExamOffline::where('session_id',Session::get('session_id'))
		 ->where('branch_id',Session::get('branch_id'))->whereMonth('exam_date',date('m'))->count();
        return $data;
    }
    
}