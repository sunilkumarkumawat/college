<?php

namespace App\Models\fees;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FeesDetailsInvoices extends Model
{
        use SoftDeletes;
	protected $table = "fees_details_invoices"; //table name

    public static function todayCollection(){
        $data = FeesDetailsInvoices::where('session_id', Session::get('session_id'))
         ->where('branch_id', Session::get('branch_id'))
         ->where('payment_date', date('Y-m-d'))
         ->whereIn('status', [0, 1])
         ->sum('amount');
         return $data;
     }
}