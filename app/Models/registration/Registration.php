<?php

namespace App\Models\registration;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Registration extends Model
{
        use SoftDeletes;
    protected $table = "registrations"; //table name

    
    
}
