<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\Setting;
use App\Models\Admission;
use App\Models\User;
use App\Models\BirthdayWishes;
use App\Models\Master\MessageTemplate;
use Session;
use Hash;
use Str;
use Redirect;
use Helper;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BirthdayController extends Controller

{
    public function happy_birthday(){
        $today=now();
    
        $student = Admission::select('admissions.*','types.name as class_name')
            ->leftjoin('class_types as types','types.id','admissions.class_type_id')
            ->where('admissions.branch_id',Session::get('branch_id'))
            ->where('admissions.session_id',Session::get('session_id'))
            ->where('admissions.status', 1)
            ->whereMonth('admissions.dob',$today->month)
            ->whereDay('admissions.dob',$today->day)
            ->get();
        $user = User::where('branch_id',Session::get('branch_id'))
            ->where('status', 1)
            ->whereMonth('dob',$today->month)
            ->whereDay('dob',$today->day)
            ->get();
        return view('birthday/view',['data'=>$student,'data2'=> $user]);
    }
    public function send_wishes(Request $request){
        
            $template = MessageTemplate::Select('message_templates.*','message_types.slug')
                    ->leftjoin('message_types','message_types.id','message_templates.message_type_id')
                    ->where('message_types.status',1)->where('message_types.slug','birthday-wishes')->first();
                    
            $setting = Setting::where('branch_id',Session::get('branch_id'))->first();                 
                            
             // dd($setting)  ;           
        /* $setting = Setting::first(['right_logo','name']);
      
    
                for($count = 0; $count <= count($request->checkbox); $count++){
                   if(isset($request->checkbox[$count])){
        			$subject = "Birthday Wishes From Rukmani Software" ;
			        $message = "The warmest wishes to a great member of our team. May your special day be full of happiness, fun and cheer!";
			        $logo = $setting->right_logo;
			        
                    $emailData= ['email'=>$request->checkbox[$count],'logo'=>$logo,'subject'=>$subject,'messages'=>$message];
                   
                   Helper::sendMail('email_print.Wishes',$emailData);     
                   }
                              
                }   
                return redirect::to('happy_birthday')->with('message', 'Wishes Sent Successfully.');*/
                
                
              
                if($request->isMethod('post')){
                    
                    $error=0;
            if(!empty($request->checkbox_user))
            {
                foreach($request->checkbox_user as $key => $item)
                {
                     $arrey1 = array(
                                 '{#name#}',
                                 );
                       
                    $arrey2 = array(
                                    $request->first_name_user[$key],
                                    );
               
                    $message = str_replace($arrey1,$arrey2,$template->whatsapp_content);                  
           $response =   Helper::sendWhatsappMessage($request->mobile_user[$key],'text',$message,null);
                    
                    $value = new  BirthdayWishes;
                    $value->user_id = Session::get('user_id');
                    $value->session_id = Session::get('session_id');
                    $value->branch_id = Session::get('branch_id');
                    $value->user_id_sender = $item ;
                  $value->role_id = $request->role_id_user[$key] ;
                    
                  $decode = json_decode($response);
                  
                  
                   if (!isset($decode->status) || $decode->status == 'error' || empty($decode)) {
    $value->status = 1; // 0 for success, 1 for failed

    $value->failed_message = isset($decode->message) ? $decode->message : 'Unknown error occurred';

 //   $value->save();

    $error++;
    // return redirect::to('happy_birthday')->with('error', 'Something went wrong !!!');
}
                  else
                  {
                      $value->status = 0; //0 for success ,1 for failed
                     
                        $value->save();
                  }
                        
                }
                
                 //  return redirect::to('happy_birthday')->with('message', 'Wishes Sent Successfully.');
            }
            if(!empty($request->checkbox_student))
            {
                foreach($request->checkbox_student as $key => $item)
                {
                    $arrey1 = array(
                                '{#name#}',
                                '{#school_name#}');
                       
                    $arrey2 = array(
                                    $request->first_name_student[$key],
                                    $setting->name
                                    );
                                    
                    $message = str_replace($arrey1,$arrey2,$template->whatsapp_content);   
           
           
           $response=  Helper::sendWhatsappMessage($request->mobile_student[$key],$message,null);
           
             $value = new  BirthdayWishes;
                    $value->user_id = Session::get('user_id');
                    $value->session_id = Session::get('session_id');
                    $value->branch_id = Session::get('branch_id');
                    $value->admission_id = $item ;
                    $value->role_id = $request->role_id_student[$key] ;
                  
                     $decode = json_decode($response);
                  
                  
            if (!isset($decode->status) || $decode->status == 'error' || empty($decode)) {
    $value->status = 1; // 0 for success, 1 for failed

    $value->failed_message = isset($decode->message) ? $decode->message : 'Unknown error occurred';

    //$value->save();

    $error++;
    // return redirect::to('happy_birthday')->with('error', 'Something went wrong !!!');
}
                   else
                  {
                      $value->status = 0; //0 for success ,1 for failed
                     
                        $value->save();
                  }
                        
                }
                
                   
            }
             
             if($error > 0)
             {
                 return redirect::to('happy_birthday')->with('error', 'WhatsApp service is currently experiencing peak usage, causing temporary server downtime. Please try again after some time.');    
             }else
             {
                   return redirect::to('happy_birthday')->with('message', 'Wishes Sent Successfully.'); 
             }
                         
        
        }
            }

 
 

    
}