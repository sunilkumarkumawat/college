<?php

namespace App\Models\Master;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Homework extends Model
{
        use SoftDeletes;
	protected $table = "homeworks"; //table name
	
     public function Admission(){
         
        return $this->belongsTo('App\Models\Admission','subject');
    }

     public function Subject(){
         
        return $this->belongsTo('App\Models\Subject','subject');
    }
    
    public function ClassType(){
        return $this->belongsTo('App\Models\ClassType','class_type_id');
    }

     public function Section(){
        return $this->belongsTo('App\Models\Master\Section','section_id');
    }    
    
     public function Teacher(){
        return $this->belongsTo('App\Models\Teacher','teacher_id');
    }    
    
    public static function todayHomework(){
        $data = Homework::where('session_id',Session::get('session_id'))
		 ->where('branch_id',Session::get('branch_id'))->where('homework_issue_date',date('Y-m-d'));
        if(Session::get('role_id') == 2){
             $classTeacherOf = DB::table('teachers')->where('id',Session::get('teacher_id'))->whereNull('deleted_at')->first('class_type_id');
                
                if(!empty($classTeacherOf))
                {
            $homework = $data->where('class_type_id',$classTeacherOf->class_type_id)->count();
                }
        }else{
            $homework = $data->count();
        }
            return $homework;
    }    
    
}