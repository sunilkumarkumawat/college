<?php

namespace App\Http\Controllers\fees;

use Illuminate\Validation\Validator;
use App\Models\StudentFees;
use App\Models\fees\Emi;
use Session;
use Helper;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmiController extends Controller
{
            public function emiAdd(Request $request){
                $data = Emi::get();
                if($request->isMethod('post')){
                    $request->validate([
                        'emi_date' => 'required',
                        'emi_name' => 'required',     
                    ]);
                    $data = new Emi;
                    $data->emi_date = $request->emi_date;
                    $data->emi_name = $request->emi_name;
                    $data->save();
                    return redirect::to('emi_add')->with('message', 'Emi Added Successfully !');
                }
                return view('fees.emi.add',['data'=>$data]);
            }
    
            public function emiEdit(Request $request,$id){
                $data = Emi::find($id);
                if($request->isMethod('post')){
                    $request->validate([
                        'emi_date' => 'required',
                        'emi_name' => 'required',     
                    ]);
                    $data->emi_date = $request->emi_date;
                    $data->emi_name = $request->emi_name;
                    $data->save();
                    return redirect::to('emi_add')->with('message', 'Emi Edit Successfully !');
                }
                return view('fees.emi.edit',['data'=>$data]);
            }
    
            public function emiDelete(Request $request){
                $data = Emi::where('id',$request->delete_id)->delete();
                return redirect::to('emi_add')->with('message', 'Emi Delete Successfully !');
            }
    
}
