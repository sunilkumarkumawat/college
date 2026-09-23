<?php

namespace App\Models\exam\digital;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UploadByDigital extends Model
{
        use SoftDeletes;
	protected $table = "upload_bys_digital"; //table name

    
}