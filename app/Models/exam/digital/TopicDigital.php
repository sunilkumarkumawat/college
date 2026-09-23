<?php

namespace App\Models\exam\digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class TopicDigital extends Model
{
       use SoftDeletes;
	protected $table = "topics_digital"; //table name
	

    public function ClassTypes()
    {
        return $this->belongsTo('App\Models\ClassType','class_type_id');
    }

    public function Subject()
    {
        return $this->belongsTo('App\Models\Subject','subject_id');
    }
    
    public function Chapter()
    {
        return $this->belongsTo('App\Models\exam\digital\Chapter','chapter_id');
    }
}