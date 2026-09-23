<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Remark extends Model
{
          use SoftDeletes;
	protected $table = "registration_remarks"; //table name
	
}