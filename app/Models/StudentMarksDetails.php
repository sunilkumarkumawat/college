<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentMarksDetails extends Model
{
       use SoftDeletes;
	protected $table = "student_marks_details"; //table name

    
}