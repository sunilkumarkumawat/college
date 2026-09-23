<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator;
use App\Models\WhatsappApiResponse;
use App\Models\Master\Branch;
use App\Models\Setting;
use App\Models\SuccessMessages;
use App\Models\PermissionMessages;
use App\Models\MessageQueue;
use App\Models\Admission;
use Session;
use Hash;
use Str;
use Helper;
use File;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
class WhatsappController extends Controller
{
            public function whatsappSetting(Request $request){
                if($request->isMethod('post')){
                  for($count = 0; $count <= count($request->module_id); $count++){
                        if(isset($request->module_id[$count])){
                            $update = PermissionMessages::find($request->module_id[$count]);
                            $update->permission = $request->permission[$count];
                            $update->type = $request->type[$count];
                            $update->save();
                        }
                    }
                  return redirect::to('whatsapp_setting')->with('message', 'WhatsApp Setting Updated!');
                }
                $data = PermissionMessages::all();
                return view('master.whatsapp_setting.view', ['data' => $data]);
            }
    
            public function setWhatsappPermission(Request $request){
                $find = PermissionMessages::where('module',$request->module)->first();
                $find->permission =$request->checkbox;
                $find->save();
                echo 'Messaging Updated.';
            }
            
            public function todayWhatsappMessages(Request $request){
                $today = Carbon::today();
                $modal = $request->modal ?? 'Admission';
                $data = SuccessMessages::whereDate('created_at', $today)->where('service', 'whatsapp')->where('modal', $modal)->where('service','!=','otp')->whereNotNull('message_id')->groupBy('message_id')->get();
                $ids = [];
                if (!empty($data)) {
                    foreach ($data as $item) {
                        $old_ids = SuccessMessages::where('message_id', $item->message_id)
                            ->groupBy('ids')
                            ->pluck('ids')
                            ->implode(',');
                        $ids[$item->message_id] = ',' . $old_ids;
                    }
                }
                return response()->json(['status' => true, 'data' => $data, 'ids' => $ids], 200);
            }
    
            public function sendWhatsapp(Request $request){
                $branch = Branch::first();
                $setting = Setting::first();
                $modal = 'App\Models\\' . $request->modal;
                $toMobile = $request->mobile;
                $text = $request->message ?? '';
                $id = $request->id ?? '';
                $mobile = $request->mobile ?? '';
                $service = $request->service ?? 'Whatsapp';
                $otp = $request->otp ?? '';  //login request only
                $randomNumber = mt_rand(10000000, 99999999);
                $otpRequest = mt_rand(100000, 999999);
                $array1 =   array(
                    '{#name#}',
                    '{#school_name#}',
                    '{#user_name#}',
                    '{#password#}',
                    '{#email#}',
                    '{#school_mobile#}');
                /*start login otp area*/
                if($otp != ''){
                    // $otpRequest = Crypt::encrypt('232323');
                    $request->session()->put('otp_request',Crypt::encrypt($otpRequest));
                    $text = str_replace('[#otp]', $otpRequest, $text);
                }
                /*end login otp area*/
                $message_id = $request->message_id ?? $randomNumber;
                $serverUrl = $branch->api_link ?? '';
                $photo = '';
                $filepath = '';
                if ($request->file('image')) {
                    $image = $request->file('image');
                    $path = $image->getRealPath();
                    $photo = time() . uniqid() . $image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH') . 'whatsapp_documents';
                    $image->move($destinationPath, $photo);
                    $filepath = env('IMAGE_SHOW_PATH') . 'whatsapp_documents/' . $photo;
                }
                else{
                    $filepath = $request->attachment2 ?? ''; 
                }
                $params = [];
                if (!empty($serverUrl)) {
                    $users = $modal::find($id);
                    if (!empty($users)) {
                        if($otp == ''){
                            $array2 = array(
                                ($users->first_name ?? '')." ".($users->last_name ?? ''),
                                $setting->name ?? '',
                                $users->userName ?? '',
                                $users->confirm_password,
                                $users->email ?? '',
                                $setting->mobile ?? '');
                            $text=   str_replace($array1,$array2,$text);
                        }
                        if ($filepath == '') {
                            $params = [
                                'number' => '91' . $toMobile,
                                'type' => 'text',
                                'message' => $text,
                                'instance_id' => $branch->instance_id,
                                'access_token' => $branch->access_token,
                            ];
                        } 
                        else {
                            $params = [
                                'number' => '91' . $toMobile,
                                'type' => 'media',
                                'message' => $text,
                                'media_url' => $filepath,
                                'instance_id' => $branch->instance_id,
                                'access_token' => $branch->access_token,
                            ];
                        }
                        $url = $serverUrl . '&' . http_build_query($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $output = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($output);
                        if (($result->status ?? '') == 'success' || ($result->status ?? '') == 'error') {
                            $message = $result->message ?? '';
                            $error = $message->messageTimestamp ?? null;
                            if ($error == null) {
                                $whatsapp_error = new WhatsappApiResponse();
                                $whatsapp_error->item = json_encode($params);
                                $whatsapp_error->message = $result->message ?? null;
                                $whatsapp_error->save();
                                session()->put('whatsapp_error', $whatsapp_error->message);
                                session()->put('whatsapp_error_respose_id', $whatsapp_error->id);
                                return response()->json(['status' => false, 'id' => $id, 'message' => $result->message ?? null], 200);
                            }
                            $saveMessage = new SuccessMessages();
                            $saveMessage->message_id = $message_id;
                            $saveMessage->message = $text;
                            $saveMessage->modal = $request->modal ?? '';
                            $saveMessage->attachment = $filepath;
                            $saveMessage->ids = $id;
                            $saveMessage->service = $service;
                            $saveMessage->mobile = $mobile;
                            $saveMessage->save(); 
                            return response()->json(['status' => true, 'id' => $id], 200);
                        }
                    }
                }
                else {
                    $whatsapp_error = new WhatsappApiResponse();
                    $whatsapp_error->item = 'Whatsapp Authentication Error';
                    $whatsapp_error->message = 'Whatsapp Api Url Missing';
                    $whatsapp_error->save();
                    session()->put('whatsapp_error', $whatsapp_error->message);
                    session()->put('whatsapp_error_respose_id', $whatsapp_error->id);
                    return response()->json(['status' => false, 'message' => 'Whatsapp Authentication Error'], 200);
                }
            }

            public function validateOtpWhatsapp(Request $request){
                $otp_generated =  Crypt::decrypt(Session::get('otp_request'));
                $otp_requested =  $request->otp;
                if((int)$otp_generated == (int)$otp_requested){
                    $request->session()->put('otp_request','accepted');
                    return response()->json(['status' => true, 'message' => 'Otp Verification Successfully'], 200);
                }
                else{
                    return response()->json(['status' => false, 'message' => 'Otp Verification Failed'], 200);
                }
            }
            
            public function messangerButtons(Request $request){
                return view('messanger.buttons');
            }
    
            public function whatsappSendFeesRemainder(Request $request){
                if(!empty($request->checkbox)){
                    
                    foreach($request->checkbox as $admission_id){
                     
                        if(!empty($request->mobile[$admission_id]) != '' ){
                           
                            $message = $request->message[$admission_id];
                            $array1 = [
                                '<span class="bg-danger p-1">', 
                                '</span>', 
                                '&nbsp;',  // Example of a non-breaking space entity
                                '&lt;',    // Less-than symbol encoded
                                '&gt;',    // Greater-than symbol encoded
                                '&amp;',   // Ampersand encoded
                            ];
                            $array2 = [
                                '',  // Replace opening <span> with nothing
                                '',  // Replace closing </span> with nothing
                                ' ', // Replace non-breaking space with a regular space
                                '<', // Replace &lt; with <
                                '>', // Replace &gt; with >
                                '&', // Replace &amp; with &
                            ];

                            $message = str_replace($array1, $array2, $message);
                           
                            $admission = Admission::find($admission_id);
                            if($admission->mobile){
                                Helper::MessageQueueSetup(Session::get('id'), $admission->branch_id, $admission->session_id, 20, $admission->mobile, $message); 
                            }
                            
                            //Helper::sendWhatsappMessage($request->mobile[$admission_id],$message,$filepath=null);

                           // $this->messageReadyWhatsappMessage($admission_id,$request->mobile[$admission_id],$message,$filepath=null);
                        }
                    }
                }
                return redirect::to('feesRemainderCron')->with('message','Remainder Set Successfully');
            }
    
            public function messageReadyWhatsappMessage($admission_id,$toMobile,$text,$filepath){
                $service = $request->service ?? 'Whatsapp';
                $randomNumber = mt_rand(10000000, 99999999);
                $message_id = $request->message_id ?? $randomNumber;
                $branch = Branch::first();
                $serverUrl = $branch->api_link ?? '';
                if (!empty($serverUrl)) {
                    // $users = $modal::find($id);
                    $text =  $text;  
                    $testMobile = Session::get('testMobile');
                    if(!empty($testMobile)){
                        $toMobile = $testMobile;
                    }
                    //   $filepath = '';
                    if (!empty($toMobile)) {
                        if ($filepath == '') {
                            $params = [
                                'number' => '91' . $toMobile,
                                'type' => 'text',
                                'message' => $text,
                                'instance_id' => $branch->instance_id,
                                'access_token' => $branch->access_token,
                            ];
                        } 
                        else {
                            $params = [
                                'number' => '91' . $toMobile,
                                'type' => 'media',
                                'message' => $text,
                                'media_url' => $filepath,
                                'instance_id' => $branch->instance_id,
                                'access_token' => $branch->access_token,
                            ];
                        }
                        $url = $serverUrl . '&' . http_build_query($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $output = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($output);
                        if (($result->status ?? '') == 'success' || ($result->status ?? '') == 'error') {
                            $message = $result->message ?? '';
                            $error = $message->messageTimestamp ?? null;
                            if ($error == null) {
                                $whatsapp_error = new WhatsappApiResponse();
                                $whatsapp_error->item = json_encode($params);
                                $whatsapp_error->message = $result->message ?? null; 
                                $whatsapp_error->save();
                                session()->put('whatsapp_error', $whatsapp_error->message);
                                session()->put('whatsapp_error_respose_id', $whatsapp_error->id);
                                return response()->json(['status' => false, 'id' => $admission_id, 'message' => $result->message ?? null], 200);
                                return redirect::to('feesRemainderCron')->with('error', $result->message ?? null);
                            }
                            $saveMessage = new SuccessMessages();
                            $saveMessage->message_id = $message_id;
                            $saveMessage->message = $text;
                            $saveMessage->modal = $request->modal ?? '';
                            $saveMessage->attachment = $filepath;
                            $saveMessage->ids = $admission_id;
                            $saveMessage->service = $service;
                            $saveMessage->mobile = $toMobile;
                            $saveMessage->save(); 
                            // return response()->json(['status' => true, 'id' => $admission_id], 200);
                            //return redirect::to('feesRemainderCron')->with('message','Remainder message sent successfully');
                        }
                    }
                } 
                else {
                    $whatsapp_error = new WhatsappApiResponse();
                    $whatsapp_error->item = 'Whatsapp Authentication Error';
                    $whatsapp_error->message = 'Whatsapp Api Url Missing';
                    $whatsapp_error->save();
                    session()->put('whatsapp_error', $whatsapp_error->message);
                    session()->put('whatsapp_error_respose_id', $whatsapp_error->id);
                    // return response()->json(['status' => false, 'message' => 'Whatsapp Authentication Error'], 200);
                    return redirect::to('feesRemainderCron')->with('error','Whatsapp Authentication Error');
                }
            }
    
    
            public function whatsappApiResponse(Request $request){
                if ($request->isMethod('post')) {
                    $data = WhatsappApiResponse::find($request->whatsapp_error_respose_id);
                    if ($request->action == 'Discard') {
                        $data->discard_date = date('Y-m-d');
                        $data->save();
                    } 
                    else {
                        $data->status = 1;
                        $data->save();
                    }
                    session()->forget('whatsapp_error');
                    session()->forget('whatsapp_error_respose_id');
                    return $data;
                }
            }


    public function WhatsAppMessageHistory(Request $request){
        $data = MessageQueue::orderBy('id', 'DESC')->get();
        return view('master.whatsapp_setting.WhatsAppMessageHistory', ['data' => $data]);
    }
            
}
