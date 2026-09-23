<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class TeacherSubject extends Model
{
       use SoftDeletes;
	protected $table = "teacher_subjects"; //table name
	
	
}