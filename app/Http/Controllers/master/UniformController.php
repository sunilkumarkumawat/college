<?php

namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\Uniform;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniformController extends Controller

{

            public function add(Request $request){
                $data = Uniform::whereNull('deleted_at')->where('branch_id',Session::get('branch_id'))->orderBy('id','DESC')->get();
                if($request->isMethod('post')){
                    $request->validate([
                        'uniform_image'  => 'required',
                    ]);
                    /*  if ($request->file('uniform_image')) {
                        $image = $request->file('uniform_image');
                        $path = $image->getRealPath();
                        $uniform_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'uniform_image';
                        $image->move($destinationPath, $uniform_image);
                    }*/
                    foreach ($request->file('uniform_image') as $image) {
                        $uniform_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'uniform_image';
                        $image->move($destinationPath, $uniform_image);
                        $uniform = new Uniform;
                        $uniform->user_id = Session::get('id');
                        $uniform->session_id = Session::get('session_id');
                        $uniform->branch_id = Session::get('branch_id');
                        $uniform->uniform_image = $uniform_image;
                        $uniform->description = $request->description;
                        $uniform->save();
                    }
                    /* $uniform = new Uniform;//model name
                    $uniform->uniform_image =$uniform_image;
                    $uniform->save();*/
                    return redirect::to('uniform_add')->with('message', 'Uniform add Successfully.');
                }  
                return view('master.Uniform.add',['data'=>$data]);
            } 

            public function edit(Request $request,$id){
                // dd($request);
                $data = Uniform::find($id);
                if($request->isMethod('post')){
                    $uniform_image = '';
                    if ($request->file('uniform_image')) {
                        $image = $request->file('uniform_image');
                        $path = $image->getRealPath();
                        $uniform_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'uniform_image';
                        $image->move($destinationPath, $uniform_image);
                        if (File::exists(env('IMAGE_UPLOAD_PATH') . 'uniform_image/' . $data->uniform_image)) {
                            File::delete(env('IMAGE_UPLOAD_PATH') . 'uniform_image/' . $data->uniform_image);
                        }
                        $data->uniform_image = $uniform_image;
                    }
                    $data->description = $request->description;
                    $data->save();
                    return redirect::to('uniform_add')->with('message', 'Uniform Update  Successfully.');
                }
                return view('master.Uniform.edit',['data'=>$data]);
            }
     
            public function delete(Request $request){
                $id = $request->delete_id;
                $sss = Uniform::find($id);
                if (File::exists(env('IMAGE_UPLOAD_PATH') . 'uniform_image/' . $sss->uniform_image)) {
                    File::delete(env('IMAGE_UPLOAD_PATH') . 'uniform_image/' . $sss->uniform_image);
                }
                $sss->delete();
                return redirect::to('uniform_add')->with('message', 'Uniform  Delete Successfully.');
            }
    
}
