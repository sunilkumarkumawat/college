<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RegFeesAssignDetails extends Model
{
        use SoftDeletes;
	protected $table = "reg_fees_assign_details"; //table name

    
}