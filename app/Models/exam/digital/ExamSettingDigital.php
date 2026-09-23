<?php

namespace App\Models\exam\digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class ExamSettingDigital extends Model
{
       use SoftDeletes;
	protected $table = "exam_setting_digital"; //table name
	
       
    
}