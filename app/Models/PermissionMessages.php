<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PermissionMessages extends Model
{
        use SoftDeletes;
	protected $table = "permission_messages"; //table name
	
}