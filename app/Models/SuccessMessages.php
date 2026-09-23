<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SuccessMessages extends Model
{
        use SoftDeletes;
	protected $table = "success_messages"; //table name
	
}