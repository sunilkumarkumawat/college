<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WhatsappApiResponse extends Model
{
        use SoftDeletes;
	protected $table = "whatsapp_api_response"; //table name
	
}