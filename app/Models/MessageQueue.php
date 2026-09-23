<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MessageQueue extends Model
{
        use SoftDeletes;
	protected $table = "message_queue"; //table name

}