<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SukaDigital extends Model
{
        use SoftDeletes;
	protected $table = "sukas_digital"; //table name

    
}