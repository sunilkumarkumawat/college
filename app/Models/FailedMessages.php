<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class FailedMessages extends Model
{
        //use SoftDeletes;
	protected $table = "failed_messages"; //table name
	
	
	public static function countResendMessages(){
	      $data = FailedMessages::where('session_id',Session::get('session_id'))->where('status',0);
	    if(Session::get('role_id') > 1)
	    {
	        $data = $data->where('branch_id',Session::get('branch_id'));
	    }
      
       $data = $data->count();
            return $data;
    }
    
}


