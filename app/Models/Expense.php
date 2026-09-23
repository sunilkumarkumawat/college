<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Expense extends Model
{
        use SoftDeletes;
	protected $table = "expenses"; //table name
   
    public static function totalExpense(){
        $data=Expense::where('branch_id',Session::get('branch_id'))->sum('amount');
        return $data;
    }
    
    public static function thisMonthExpense(){
        $data=Expense::where('branch_id',Session::get('branch_id'))->whereMonth('date',date('m'))->sum('amount');
        return $data;
    }
    
    public static function todayExpense(){
        $data=Expense::where('branch_id',Session::get('branch_id'))->where('date',date('Y-m-d'))->sum('amount');
        return $data;
    }
}
