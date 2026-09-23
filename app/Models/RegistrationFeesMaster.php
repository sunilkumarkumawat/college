<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RegistrationFeesMaster extends Model
{
        use SoftDeletes;
	protected $table = "registration_fees_masters"; //table name

     public function feesGroup()
    {
        return $this->belongsTo('App\Models\FeesGroup','fees_group_id');
    }

    
}