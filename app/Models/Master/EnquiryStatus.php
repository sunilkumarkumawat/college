<?php

namespace App\Models\Master;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EnquiryStatus extends Model
{
        use SoftDeletes;
	protected $table = "enquiry_status"; //table name
	
	 public static function countStatus(){
        $data=EnquiryStatus::whereNull('deleted_at')->count();
        if($data){
            return $data;
        }
        return 0;
    }
	
}