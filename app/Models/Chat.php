<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Chat extends Model
{
        use SoftDeletes;
    protected $fillable = ['status'];
	protected $table = "chats"; //table name
	
}