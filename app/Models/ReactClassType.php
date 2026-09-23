<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ReactClassType extends Model
{
       use SoftDeletes;
	protected $table = "react_class_types"; //table name
	
 public static function countClasss(){
        $data=ClassType::whereNull('deleted_at')->count();
        if($data){
            return $data;
        }
        return 0;
    }	
	 
}