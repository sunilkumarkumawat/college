<?php

namespace App\Models\exam\digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class LevelDigital extends Model
{
       use SoftDeletes;
	protected $table = "levels_digital"; //table name
	
    public function ClassTypes()
    {
        return $this->belongsTo('App\Models\ClassType','class_type_id');
    }
    
}