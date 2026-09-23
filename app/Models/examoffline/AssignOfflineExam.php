<?php

namespace App\Models\examoffline;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AssignOfflineExam extends Model
{
        use SoftDeletes;
	protected $table = "assign_offline_exams"; //table name
	
}