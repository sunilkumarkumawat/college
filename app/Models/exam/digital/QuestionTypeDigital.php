<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuestionTypeDigital extends Model
{
        use SoftDeletes;
	protected $table = "question_types_digital"; //table name

    
}