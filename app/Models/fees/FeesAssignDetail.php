<?php

namespace App\Models\fees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FeesAssignDetail extends Model
{
        use SoftDeletes;
	protected $table = "fees_assign_details"; //table name

    
}