<?php

namespace App\Http\Controllers\chat;
use Illuminate\Validation\Validator; 
use App\Models\Common;
use App\Models\Admission;
use App\Models\Chat;
use App\Models\User;
use Session;
use Hash;
use Str;
use Redirect;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller

{

    public function chatTest(){
        return view('chat.test');
    }

    public function compose(Request $request){
    
        /*$user = Admission::all();
        foreach($user as $userupdate){
  
            $var = '3-' . $userupdate->id . '-' . $userupdate->created_at->format('d-m-Y') . '-' . mt_rand(100000, 999999);
            $update = Admission::where('id',$userupdate->id)->update(['regisUniqueId'=>$var]);
        }*/

        $recent = Chat::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('to_id',Session::get('regisUniqueId'))->orwhere('from_id',Session::get('regisUniqueId'))->groupBy('connection_id')->orderBy('id','DESC')->get();

        return view('chat.compose',['recent'=>$recent]);
    }

    public function chatLastMessage(Request $request){
        
        $lastCount = Session::get('lastCount');
        
        $lastMessage = Chat::where('to_id',Session::get('regisUniqueId'))->get()->last();
        
        $count = Chat::where('to_id',Session::get('regisUniqueId'))->count();
        
        $newCount = Session::put('lastCount',$count);
        
        $created_at = date(' h:i A', strtotime($lastMessage->created_at));

        return json_encode(array('my_id' => $lastMessage->to_id, 'lastCount' => $lastCount, 'count' => $count, 'message' => $lastMessage->message, 'extension' => $lastMessage->extension, 'document' => $lastMessage->document, 'created_at' => $created_at, 'id' => $lastMessage->id ));
    }
    
    public function chatUserShowClick(Request $request){
        
        /*if($request->get('role_id') == 3){
            $chatDetails =  Admission::where('id',$request->get('click_id'))->get()->first(); 
        }else{
            $chatDetails =  User::where('id',$request->get('click_id'))->get()->first(); 
        } */ 
        
        $click_id = $request->click_id;
        $chatHistory = Chat::whereIn('from_id',[Session::get('regisUniqueId'),$click_id])->whereIn('to_id',[Session::get('regisUniqueId'),$click_id])->orderBy('id','DESC')->get();
        $seenStatus = Chat::where('from_id',$click_id)->where('to_id',Session::get('regisUniqueId'))->update(['status'=>1]);
    
        return  view('chat.chat_detail',['chatHistory'=>$chatHistory]);

    }
    
    public function chatMessageSeen(Request $request){
        $makeSeen = Chat::where('id',$request->id)->update(['status'=>1]);
    }

    public function sendChat(Request $request){
      
        if($request->isMethod('post')){
            $upload = new Chat;//model name
            $upload->session_id = Session::get('session_id');
            $upload->branch_id = Session::get('branch_id');
            $upload->from_role_id = Session::get('role_id');
            $upload->from_id = Session::get('regisUniqueId');
            $upload->to_role_id = $request->role_id;
            $upload->to_id = $request->to_id;
            $upload->message = $request->message;
            
            $connection1 = Session::get('regisUniqueId') . '+' . $request->to_id;
            $connection2 = $request->to_id . '+' . Session::get('regisUniqueId');
            $connectionId = Chat::whereIn('connection_id',[$connection1,$connection2])->get();
            if(count($connectionId) > 0){
                $upload->connection_id = $connectionId[0]->connection_id;
            }else{
                $upload->connection_id = $connection1;
            }
            if(filter_var($request->message, FILTER_VALIDATE_URL) == TRUE){
            	$upload->extension = "url";
            }            
            if($request->file('attachFile')){
                $image = $request->file('attachFile');
                $path = $image->getRealPath();      
                $document =  $image->getClientOriginalName();
                $destinationPath = env('IMAGE_UPLOAD_PATH').'chat/document';
                $image->move($destinationPath, $document);  
                $upload->document = $document;
                
                $upload->extension = $image->getClientOriginalExtension();
            }               
            $upload->save();
            
        }    

    }

    public function searchChat(Request $request){
        $search['searchChat'] = $request->searchChat;
        $value = $request->searchChat;
        $studata =  Admission::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('status',1)
            ->where(function($query) use ($value){
        		    $query->where("first_name",'like','%'.$value.'%');
                    $query->orwhere("last_name",'like','%'.$value.'%');
                    $query->orwhere("userName",'like','%'.$value.'%');
                    $query->orwhere("mobile",'like','%'.$value.'%');
                    $query->orwhere("email",'like','%'.$value.'%');
               
		    })->get();
        $userdata =  User::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('status',1)->whereNotIn('id',[Session::get('id')])
            ->where(function($query) use ($value){
        		    $query->where("first_name",'like','%'.$value.'%');
                    $query->orwhere("last_name",'like','%'.$value.'%');
                    $query->orwhere("userName",'like','%'.$value.'%');
                    $query->orwhere("mobile",'like','%'.$value.'%');
                    $query->orwhere("email",'like','%'.$value.'%');
               
		    })->get();
           
        $array = [];
        
        foreach($studata as $stu){
            array_push($array, $stu);
        }
        foreach($userdata as $user){
            array_push($array, $user);
        }

        return  view('chat.append_search',['data'=>$array,'search' => $search]);
    } 

    public function downloadChatDocument(Request $request){
        $file = 'schoolimage/chat/document/'.$request->chatDocument;
        return Response::download($file);
    }

    public function deleteChatMessage(Request $request){
        $ids = explode(",", $request->msg_delete_id);
        $delete = Chat::whereIn('id', $ids)->delete();
    }


























    

}    