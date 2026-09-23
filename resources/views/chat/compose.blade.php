@php

@endphp
@extends('layout.app') 
@section('content')
<style>
    footer{
        display:none;
    }
    #blankChat{
        background-image: url('{{ env('IMAGE_SHOW_PATH').'default/chat/chat_bg.jpg' }}');
        /*opacity:0.4;*/
    }
    #chatProfileImg {
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
    }    
    #recent{
        height:450px;
        overflow-y:auto;
    }
    svg {
        fill: #6639b5;
    }  
    .back{
        color: #6639b5;
    }
    .fa, svg{
        cursor:pointer;
    }
    .modal-dialog {
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: auto;
    }
</style>
<style>
/*img {
  transition: 1s;
}

img:hover {
  transform: scale(2.5);
  z-index: 1100;
}*/
@media only screen and (min-width: 768px) {
    #newChat{
        display:none;
    }
}
@media only screen and (max-width: 767px) {
    #blankChatImg{
        display:none;
    }
}

* {
  box-sizing: border-box;
  position: relative;
}

#newChat{
position: fixed;
top: 30.5rem;
right: 30px;
padding: 10px;
background-color: #6639b5;
border-radius: 50%;
z-index:1;
fill: white;
rotate: 180deg;    
}

#stopButton{
padding: 10px;
border-radius: 50%;
animation: pulse 1s infinite;    
}
@keyframes pulse {
    0% {
        box-shadow: 0px 0px 3px 1px #6639b5;
    }

    100% {
        box-shadow: 0px 0px 3px 10px #6639b5;

    }
}
#submitForm{
width: 100%;
display: contents;    
}
.badge-primary{
    color: #fff;
    background-color: #6639b5;
    border-radius: 50%;    
}
.msgAction{
    display:none;
    cursor:pointer;
}
.message_text:hover .msgAction{
    display:inline;
}
.unseen_count{
    /*display:flex;
    align-items:center;
    justify-content:center;
    height:20px;
    width:20px;*/
}
.chatAction{
    display:none;
    cursor:pointer;
}
.chat_info:hover .chatAction{
    display:inline;
}
.message_text svg {
  display: contents;  
}
.message_text:hover svg {
    display: flex;
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 1;    
    color: #fd7e14;
}
.chatImg {
position: relative !important;
width: 100% !important;
height: 100% !important;
border-radius: 0px !important;
bottom: 0 !important;
}
.chatbox {
  background: #fafafa;
  box-shadow: 0px 10px 20px 0px rgba(0, 0, 0, 0.21), 0px 30px 20px -10px rgba(0, 0, 0, 0.2), 0px 60px 20px -30px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  height: 100%;
  background-image: url('{{ env('IMAGE_SHOW_PATH').'default/chat/chat_bg.jpg' }}');
}
.chatbox__header {
  width: 100%;
  background: #6639b5;
  background: -webkit-linear-gradient(to left, #8966c6, #6639b5);
  background: linear-gradient(to left, #8966c6, #6639b5);
  align-items: center;
  justify-content: center;
}
.chatbox__header img {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
}
.chatbox__body {
  height: 400px;
  width: 100%;
  background: #f5f5f5;
  background-image: url('{{ env('IMAGE_SHOW_PATH').'default/chat/chat_bg.jpg' }}');
  display: flex;
  flex-direction: column-reverse;
  overflow: auto;
  padding: 10px 10px 20px;
}
.chatbox__body .message {
  display: block;
  width: auto;
  margin: 5px;
  align-self: flex-start;
  flex-direction: row;
  max-width: 85%;
  word-wrap: break-word;
}
.chatbox__body .message img {
  width: 30px;
  height: 30px;
  border-radius: 15px;
  -webkit-animation: image 0.2s;
  animation: image 0.2s;
}
.chatbox__body .message.receive {
  /*padding-left: 30px;*/
}
.chatbox__body .message.receive .message_text {
  /*margin-left: 10px;*/
  padding: 5px;
  border-radius: 3px;
  background: #fff;
  box-shadow: 0 1px 0.5px rgba(11, 20, 6, 0.19);
  animation: starkMessage 0.2s;
  -webkit-animation: starkMessage 0.2s;
}
.chatbox__body .message.receive .message_text:before {
  position: absolute;
  content: " ";
  left: -5px;
  bottom: 0;
  border-right: solid 10px #fff;
  border-top: solid 10px transparent;
  box-shadow: 0 1px rgba(11, 20, 6, 0.19);
  z-index: 0;
}
.chatbox__body .message.receive img {
  position: absolute;
  left: 0;
  bottom: -15px;
}
.chatbox__body .message.sender {
  color: white;
  align-self: flex-end;
  /*padding-right: 30px;*/
}
.chatbox__body .message.sender .message_text {
  /*margin-right: 10px;*/
  background: #6639b5;
  box-shadow: 0 1px 0.5px rgba(11, 20, 6, 0.19);
  background: -webkit-linear-gradient(to left, #8966c6, #6639b5);
  background: linear-gradient(to left, #8966c6, #6639b5);
  padding: 5px;
  border-radius: 3px;
  z-index: 99;
  animation: starkMessage 0.2s;
  -webkit-animation: starkMessage 0.2s;
}
.chatbox__body .message.sender .message_text:after {
  position: absolute;
  content: " ";
  right: -5px;
  bottom: 0;
  border-left: solid 10px #8966c6;
  border-top: solid 10px transparent;
  box-shadow: 0 1px rgba(11, 20, 6, 0.19);
  z-index: 0;
}
.chatbox__body .message.sender img {
  position: absolute;
  right: 0;
  bottom: -15px;
}
.chatbox__input {
  display: flex;
  width: 100%;
  background: #fff;
  /*height: 60px;*/
  border-top: 0.5px solid #efefef;
}
.chatbox__input input {
  flex: 3;
  padding: 1em 2em;
  outline: none;
  border: 0;
  letter-spacing: 0.1em;
}
.chatbox__input button {
  outline: none;
  border: 0;
  flex: 1;
  background: white;
}
.chatbox__input svg {
  fill: #6639b5;
}
::placeholder {
  color: #dedede;
  opacity: 1;
}

@keyframes starkMessage {
  from {
    transform: scale(0.9);
  }
  80% {
    transform: scale(1.05);
  }
  to {
    transform: scale(1);
  }
}
@keyframes image {
  from {
    bottom: -50px;
  }
  to {
    bottom: -15px;
  }
}
</style>
<script>
$(document).ready(function(){
$('#fullscreenBtn').click(function() {
    $('.main-header').toggleClass('d-none');
    if($('.main-header').hasClass('d-none')){
        $(this).addClass('fa-compress').removeClass('fa-expand');
    }else{
        $(this).removeClass('fa-compress').addClass('fa-expand');
    }
});    
});

</script>
<div class="content-wrapper">
    <section class="pt-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-orange mb-1">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-snapchat"></i> &nbsp;{{ __('Chat.Chat Panel') }}  </h3><small><a href="" download="" id="downloadButton">Download Audio</a></small>
                            <input type="hidden" id="sessionId" value="{{ Session::get('id') }}">
                            <div class="card-tools">
                                <i class="fa fa-expand align-middle" data-widget="fullscreen" id="fullscreenBtn" height="24" width="24"></i> &nbsp; &nbsp; 
                                <svg class="" id="" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M12.072,1.761c-3.941-0.104-7.579,2.105-9.303,5.65c-0.236,0.486-0.034,1.07,0.452,1.305 c0.484,0.235,1.067,0.034,1.304-0.45c1.39-2.857,4.321-4.637,7.496-4.553c0.539,0.02,0.992-0.4,1.013-0.939s-0.4-0.992-0.939-1.013 C12.087,1.762,12.079,1.762,12.072,1.761z M1.926,13.64c0.718,3.876,3.635,6.975,7.461,7.925c0.523,0.13,1.053-0.189,1.183-0.712 c0.13-0.523-0.189-1.053-0.712-1.183c-3.083-0.765-5.434-3.262-6.012-6.386c-0.098-0.53-0.608-0.88-1.138-0.782 C2.178,12.6,1.828,13.11,1.926,13.64z M15.655,21.094c3.642-1.508,6.067-5.006,6.201-8.946c0.022-0.539-0.396-0.994-0.935-1.016 c-0.539-0.022-0.994,0.396-1.016,0.935c0,0.005,0,0.009,0,0.014c-0.107,3.175-2.061,5.994-4.997,7.209 c-0.501,0.201-0.743,0.769-0.543,1.27c0.201,0.501,0.769,0.743,1.27,0.543C15.642,21.1,15.648,21.097,15.655,21.094z"></path><path fill="#009588" d="M19,1.5c1.657,0,3,1.343,3,3s-1.343,3-3,3s-3-1.343-3-3S17.343,1.5,19,1.5z"></path></svg>
                                <svg class="ml-3" id="NewChat" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M19.005,3.175H4.674C3.642,3.175,3,3.789,3,4.821V21.02 l3.544-3.514h12.461c1.033,0,2.064-1.06,2.064-2.093V4.821C21.068,3.789,20.037,3.175,19.005,3.175z M14.016,13.044H7.041V11.1 h6.975V13.044z M17.016,9.044H7.041V7.1h9.975V9.044z"></path></svg>
                                <svg class="ml-2" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M12,7c1.104,0,2-0.896,2-2c0-1.105-0.895-2-2-2c-1.104,0-2,0.894-2,2 C10,6.105,10.895,7,12,7z M12,9c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,9.895,13.104,9,12,9z M12,15 c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,15.894,13.104,15,12,15z"></path></svg>
                            </div>
                        </div>        

                        <div class="row m-0" style="background-color: #efeae2;">
                            <div class="col-md-4 p-0 bg-white" id="chatHistory">
                                
                                <div class="input-group p-1">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="search fa fa-search"></i><i class="back fa fa-arrow-left" style="display:none"></i></span>
                                </div>
                                <input type="search" class="form-control" id="searchChat" name="searchChat" onkeyup="SearchChat()" placeholder="{{ __('Chat.Search or start new chat') }}" autocomplete="off">
                                </div>
                                <div id="recent">
                                    @if(count($recent) > 0)
                                    <table class="table table-hover mb-0" >
                                      <thead>
                                        <tr>
                                           <th colspan="3" class="bg-light"><span class="text-white ">{{ __('Chat.CHATS') }}</span> </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                            
                                                @foreach ($recent as $item)
                                                    
                                                    @if(Session::get('regisUniqueId') == $item->to_id)
                                                        @if($item->from_role_id == 3)
                                                            @php
                                                                $tofrom = DB::table('admissions')->where('regisUniqueId',$item->from_id)->whereNull('deleted_at')->first();
                                                            @endphp
                                                        @else
                                                            @php
                                                                $tofrom = DB::table('users')->where('chatUniqueId',$item->from_id)->whereNull('deleted_at')->first();
                                                            @endphp
                                                        @endif
                                                    @elseif(Session::get('regisUniqueId') == $item->from_id)
                                                        @if($item->to_role_id == 3)
                                                            @php
                                                                $tofrom = DB::table('admissions')->where('regisUniqueId',$item->to_id)->whereNull('deleted_at')->first();
                                                            @endphp
                                                        @else
                                                            @php
                                                                $tofrom = DB::table('users')->where('regisUniqueId',$item->to_id)->whereNull('deleted_at')->first();
                                                            @endphp
                                                        @endif
                                                    @endif
                                                      
                                                    
                                                    @php
                                                        $lastMsg = DB::table('chats')->where('connection_id',$item->connection_id)->whereNull('deleted_at')->get()->last();
                                                        $unseenCount = DB::table('chats')->where('status',0)->where('connection_id',$item->connection_id)->whereNull('deleted_at')->count();
                                                    @endphp
                                                <tr class="border-bottom chat_info" style="cursor:pointer; " onclick="showData('{{ $tofrom->regisUniqueId ?? '' }}');" >
                                                        <input type="hidden" id="role_id_{{ $tofrom->regisUniqueId ?? '' }}" value="{{ $tofrom->role_id ?? '' }}">
                                                        <input type="hidden" id="click_id_{{ $tofrom->regisUniqueId ?? '' }}" value="{{ $tofrom->regisUniqueId ?? '' }}">
                                                        <input type="hidden" id="to_name_id_{{ $tofrom->regisUniqueId ?? ''}}" value="{{ $tofrom->first_name ?? '' }} {{ $tofrom->last_name ?? '' }}">
                                                        @if(!empty($tofrom->image))
                                                            <input type="hidden" id="to_img_id_{{ $tofrom->chatUniqueId }}" value="{{ env('IMAGE_SHOW_PATH').'profile/'.$tofrom->image ?? '' }}">
                                                            <td class="p-1" ><img id="chatProfileImg" src="{{ env('IMAGE_SHOW_PATH').'profile/'.$tofrom->image ?? '' }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'"></td>
                                                        @else
                                                            <input type="hidden" id="to_img_id_{{ $tofrom->regisUniqueId ?? '' }}" value="{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}">
                                                            <td class="p-1" ><img id="chatProfileImg" src="{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}" ></td>
                                                        @endif
                                                        <td class="p-1" title="{{ $tofrom->first_name ?? '' }} {{ $tofrom->last_name ?? '' }}">{{ $tofrom->first_name ?? '' }} {{ $tofrom->last_name ?? '' }}
                                                            <br>@if($lastMsg->from_id == Session::get('regisUniqueId'))<svg width="16" height="11" viewBox="0 0 16 11" ><path class="seenCheck @if($lastMsg->status == 1) text-primary @endif" fill="currentColor" d="M11.071.653a.457.457 0 0 0-.304-.102.493.493 0 0 0-.381.178l-6.19 7.636-2.405-2.272a.463.463 0 0 0-.336-.146.47.47 0 0 0-.343.146l-.311.31a.445.445 0 0 0-.14.337c0 .136.047.25.14.343l2.996 2.996a.724.724 0 0 0 .501.203.697.697 0 0 0 .546-.266l6.646-8.417a.497.497 0 0 0 .108-.299.441.441 0 0 0-.19-.374L11.07.653Zm-2.45 7.674a15.31 15.31 0 0 1-.546-.355.43.43 0 0 0-.317-.12.46.46 0 0 0-.362.158l-.292.33a.482.482 0 0 0 .013.666l1.079 1.073c.135.135.3.203.495.203a.699.699 0 0 0 .552-.267l6.62-8.391a.446.446 0 0 0 .109-.298.487.487 0 0 0-.178-.375l-.355-.273a.487.487 0 0 0-.673.076L8.62 8.327Z" ></path></svg>@endif
                                                            <small class='text-secondary'>@if(!empty($lastMsg->message)){{ Str::limit($lastMsg->message,25) ?? '' }}@else{{ Str::limit($lastMsg->document,25) ?? '' }}@endif</small> 
                                                        </td>
                                                        <td class="p-1 text-center" ><small class="text-secondary">@if(date('Y-m-d', strtotime($lastMsg->created_at)) == date('Y-m-d')) {{ date(' h:i A', strtotime($lastMsg->created_at)) }}  @elseif(date('Y-m-d', strtotime($lastMsg->created_at)) == date('Y-m-d', strtotime("-1 days"))) Yesterday @else {{ date('d/m/y', strtotime($lastMsg->created_at)) }} @endif</small><br>@if(!empty($unseenCount) && $lastMsg->to_id == Session::get('regisUniqueId'))<span id="unseenCount" class="unseen_count badge badge-primary mr-1">{{ $unseenCount ?? '' }}</span>@endif <i class="fa fa-chevron-down chatAction"></i></td>
                                                </tr>
                                               @endforeach
                                            
                                    </tbody>
                                    </table>
                                    @endif
        
                                    <div id="append_search">
                                        
                                    </div>
                                    <svg id="newChat" viewBox="0 0 24 24" height="54" width="54" ><path fill="" d="M19.005,3.175H4.674C3.642,3.175,3,3.789,3,4.821V21.02 l3.544-3.514h12.461c1.033,0,2.064-1.06,2.064-2.093V4.821C21.068,3.789,20.037,3.175,19.005,3.175z M14.016,13.044H7.041V11.1 h6.975V13.044z M17.016,9.044H7.041V7.1h9.975V9.044z"></path></svg>
                                </div>

                            </div>
                            
                            <div class="col-md-8 p-0 text-center" id="blankChat">
                                <div class='chatbox' style="display:none">
                                    <div id="chatboxHeader" class='chatbox__header p-1'>
                                        <div class='text-white'>
                                           <div class="row" style="align-items: center;">
                                            <div class="col-md-1 col-1 pl-3">
                                                <i id="backHome" class="fa fa-arrow-left"></i>
                            		        </div>                    
                                            <div class="col-md-2 col-2">
                                                <img id="to_img" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/no_image.png' }}'" src="" >
                            		        </div>                    
                                            <div class="col-md-6 col-6 text-left">
                                                <h6 class="mb-0"><span id="to_name"></span> </h6>
                                                <small>School Account</small>
                            		        </div>
                                            <div class="col-md-3 col-3 text-right">
                                                <svg viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M15.9,14.3H15L14.7,14c1-1.1,1.6-2.7,1.6-4.3c0-3.7-3-6.7-6.7-6.7S3,6,3,9.7 s3,6.7,6.7,6.7c1.6,0,3.2-0.6,4.3-1.6l0.3,0.3v0.8l5.1,5.1l1.5-1.5L15.9,14.3z M9.7,14.3c-2.6,0-4.6-2.1-4.6-4.6s2.1-4.6,4.6-4.6 s4.6,2.1,4.6,4.6S12.3,14.3,9.7,14.3z"></path></svg>
                                                <svg class="ml-2" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M12,7c1.104,0,2-0.896,2-2c0-1.105-0.895-2-2-2c-1.104,0-2,0.894-2,2 C10,6.105,10.895,7,12,7z M12,9c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,9.895,13.104,9,12,9z M12,15 c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,15.894,13.104,15,12,15z"></path></svg>
                            		        </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="msgOption" class='chatbox__header p-1 bg-danger' style="display:none">
                                        <div class='text-white'>
                                           <div class="row mt-2 mb-2" style="align-items: center;">
                                            <div class="col-md-1 col-1 pl-3">
                                                <i id="backMsg" class="fa fa-arrow-left"></i>
                            		        </div>                    
                                            <div class="col-md-2 col-2">
                            		        </div>                    
                                            <div class="col-md-6 col-6 text-left">
                            		        </div>
                                            <div class="col-md-3 col-3 text-right">
                                                <svg id="deleteMsg" viewBox="0 0 24 24" width="20" height="20" class="mr-2"><path d="M5,0,3,2H0V4H16V2H13L11,0ZM15,5H1V19.5A2.5,2.5,0,0,0,3.5,22h9A2.5,2.5,0,0,0,15,19.5Z" fill="currentColor"></path></svg>
                                                <span onclick="copyFunction()" class=" ml-2 mr-3"><i class="fa fa-copy"></i></span>
                            		        </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='chatbox__body' id='chatbox__body'>
                                                               
                                    </div>                             
                            
                                    <div class='chatbox__input'>
                                    <form id="submitForm" enctype='multipart/form-data'>
                                        <input type="hidden" id="to_id" name="to_id" value="">
                                        <input type="hidden" id="role_id" name="role_id" value="">                  
                                        <input type="file" id="attachFile" name="attachFile" class="d-none" value="">
                                        <button id="attach">
                                          <svg class="" viewBox="0 0 24 24" width="24" height="24">
                                              <path d="M1.816 15.556v.002c0 1.502.584 2.912 1.646 3.972s2.472 1.647 3.974 1.647a5.58 5.58 0 0 0 3.972-1.645l9.547-9.548c.769-.768 1.147-1.767 1.058-2.817-.079-.968-.548-1.927-1.319-2.698-1.594-1.592-4.068-1.711-5.517-.262l-7.916 7.915c-.881.881-.792 2.25.214 3.261.959.958 2.423 1.053 3.263.215l5.511-5.512c.28-.28.267-.722.053-.936l-.244-.244c-.191-.191-.567-.349-.957.04l-5.506 5.506c-.18.18-.635.127-.976-.214-.098-.097-.576-.613-.213-.973l7.915-7.917c.818-.817 2.267-.699 3.23.262.5.501.802 1.1.849 1.685.051.573-.156 1.111-.589 1.543l-9.547 9.549a3.97 3.97 0 0 1-2.829 1.171 3.975 3.975 0 0 1-2.83-1.173 3.973 3.973 0 0 1-1.172-2.828c0-1.071.415-2.076 1.172-2.83l7.209-7.211c.157-.157.264-.579.028-.814L11.5 4.36a.572.572 0 0 0-.834.018l-7.205 7.207a5.577 5.577 0 0 0-1.645 3.971z"></path>
                                          </svg>
                                        </button>   
                                        <button id="deleteRecBtn" class="d-none" type="button">
                                          <svg id="deleteRec" viewBox="0 0 24 24" width="24" height="24"><path d="M5,0,3,2H0V4H16V2H13L11,0ZM15,5H1V19.5A2.5,2.5,0,0,0,3.5,22h9A2.5,2.5,0,0,0,15,19.5Z" fill=""></path></svg>
                                        </button>   
                                        <input name="message" id="message" placeholder='Message' autocomplete="off">
                                        
                                        <audio src="" controls id="audio-playback" class="d-none"></audio>
                                        <button id="sendChat">
                                          <svg class="svg" style="display:none" height='24' viewbox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'>
                                            <path d='M2.01 21L23 12 2.01 3 2 10l15 2-15 2z'></path>
                                          </svg>
                                          <svg class="mic" id="recordButton" viewBox="0 0 24 24" width="24" height="24">
                                              <path d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2z"></path>
                                          </svg>
                                          <svg class="d-none" id="stopButton" viewBox="0 0 24 24" width="54" height="54">
                                              <path d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2z"></path>
                                          </svg>
                                        </button>
                                    </form>
                                    </div>
                                    
                                </div>                                
                               
                                <img id="blankChatImg" src="{{ env('IMAGE_SHOW_PATH').'default/rukmanisoft_logo.png' }}">
                            </div>
                        </div> 
    
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header border-bottom-0 pb-0">
          <p>Delete message?</p>
        </div>
        <div class="modal-body text-right">
            <input type="text" class="d-none" id="copy_message" name="copy_message">
            <input type="hidden" id="msg_delete_id" name="msg_delete_id">
          <button id="deleteMessage" type="button" class="btn btn-default" style="color:#6639b5">DELETE FOR EVERYONE</button>
        </div>
        <div class="modal-footer border-top-0">
          <button type="button" class="btn btn-default" style="color:#6639b5" data-bs-dismiss="modal">CANCEL</button>
        </div>
      </div>
      
    </div>
  </div>
  
<script>
    var URL  = "{{ url('/') }}";
</script>
<script type="text/javascript">
$(document).ready(function(){
    var URL  = "{{ url('/') }}";
    toastr.options = {"positionClass": "toast-bottom-center","timeOut": "1000","hideMethod": "fadeOut"};
});

function lastChat() {
   
    var click_id = '0';
    var session_id = $("#sessionId").val();

    var myAudio = new Audio('{{URL::asset('resources/views/chat/NewChatNotification.mp3')}}');
   
        $.ajax({
                 headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url: URL+'/chat/last/message',
            data: {click_id:click_id},
             //dataType: 'json',
        success: function (result) {
         
            var result = JSON.parse(result);

            if(result.lastCount < result.count){
    
                    var message_container = document.createElement("div");
                    if(result.extension == 'url'){
                        var messagess = `<div class="message_text"> <a href="${result.message}" target="blank">${result.message}</a> <sub class="text-secondary"> &nbsp; <small>${result.created_at}</small></sub> </div>`;
                    }else{
                        var messagess = `<div class="message_text"> ${result.message} <sub class="text-secondary"> &nbsp; <small>${result.created_at}</small></sub> </div>`;
                    }
                    message_container.className = "message receive msgAction";
                    message_container.innerHTML = messagess;      
                    body.insertBefore(message_container, body.firstChild);

                    myAudio.play();  
                    var id = result.id;
                    $.ajax({
                            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                        type:'post',
                        url: URL+'/chat/message/seen',
                        data: {id:id},
                         //dataType: 'json',
                    success: function () {
                    }
                    });                    
            }
  
        }
        });
};

$("#newChat,#NewChat").click(function(){
    $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        type:'post',
        url: URL+'/search/chat/user',
        data: {searchChat:''},
        success: function (data) {
            $('#append_search').html('');
            $('#append_search').html(data);
        }
      });    
});

function SearchChat() {

    var searchChat = $('#searchChat').val();
    if(searchChat == ''){
        $('#append_search').html('');
    }
    if(searchChat !== ''){
        $(".back").show();
        $(".search").hide();
    }else{
        $(".back").hide();
        $(".search").show(); 
        $('#append_search').html('');
    }    

    $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        type:'post',
        url: URL+'/search/chat/user',
        data: {searchChat:searchChat},
        success: function (data) {
            $('#append_search').html('');
            $('#append_search').html(data);
        }
      });
}

$(".back").click(function(){
    $('#append_search').html('');
    $('#searchChat').val('');
    $(".card-header,.search").show();     
    $(".back").hide();     
});

$("#backHome").click(function(){
    $('#append_search').html('');
    $('.chatbox').hide();
    $(".card-header").show();
    $("#chatHistory").show();     
});

$("#backMsg").click(function(){
    $("#msgOption").hide();   
    $("#chatboxHeader").show();
    $(".message_text").removeAttr("style");
});

$("#deleteMsg").click(function(){
    $("#deleteModal").modal('toggle');
});

function copyFunction() {
    
    var copyText = document.getElementById("copy_message");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    $("#backMsg").click();
    $(".message_text").removeAttr("style");
    toastr.info('Message copied');
}
        
function showData(id) {
   
    var role_id = $('#role_id_'+id).val();
    var click_id = $('#click_id_'+id).val();
    var to_img_id = $('#to_img_id_'+id).val();
    var to_name_id = $('#to_name_id_'+id).val();
  
    $("#to_id").val(click_id);
    $("#role_id").val(role_id);
    $("#to_img").attr('src',to_img_id);
    $("#to_name").html(to_name_id);

    var myAudio = new Audio('{{URL::asset('resources/views/chat/NewChatNotification.mp3')}}');
    
        $.ajax({
                 headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url: URL+'/chat/user/show/click',
            data: {role_id:role_id,click_id:click_id},
             //dataType: 'json',
        success: function (data) {
            if($(window).width() < 768){
                $('#chatHistory').hide();
                $('.card-header').hide();
            }else{
                $('#backHome').hide();
            }
            $('#chatbox__body').html(data);
            $('#blankChatImg,#unseenCount').hide();
            $('.chatbox').show();
          //  $(".seenCheck").addClass('text-primary');
            myAudio.play();
           
        }
        });
};

//var myInterval = setInterval(lastChat, 3000);


$("#deleteMessage").click(function(){
    var msg_delete_id = $("#msg_delete_id").val();
    $("#deleteModal").modal('toggle');
    $("#backMsg").click();
    var myAudio = new Audio('{{URL::asset('resources/views/chat/ChatSentNotification.mp3')}}');
    $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        type:'post',
        url: URL+'/delete/chat/message',
        data: {msg_delete_id:msg_delete_id},
        success: function (data) {
            $( ".deleting" ).hide();
            myAudio.play();
            toastr.info('Message deleted');
        }
      });    
});

$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
}); 
        
$("#message").keyup(function(){
    var message = $('#message').val();
    if(message !== ''){
        $(".svg").show();
        $(".mic").hide();
    }else{
        $(".svg").hide();
        $(".mic").show(); 
    }
    if (event.keyCode == 13) {
        $("#sendChat").click();
    }
});
    
$("#attach").click(function(event){
    $("#attachFile").click();
      event.preventDefault();
      return false;      
});

$('#attachFile').change(function(){
    var attachFile = $(this).val();
    if(attachFile != ''){
        $(".mic").hide(); 
        $(".svg").show();
    }
});

$('#recordButton').on('click', function() {
    var myAudio = new Audio('{{URL::asset('resources/views/chat/MicOpen.mp3')}}');
    myAudio.play();
    $(".mic,#attach,#message").addClass('d-none');
    $("#stopButton").removeClass('d-none');  
})
$('#stopButton').on('click', function() {
    var myAudio = new Audio('{{URL::asset('resources/views/chat/MicClose.mp3')}}');
    myAudio.play();    
    $("#audio-playback,#deleteRecBtn").removeClass('d-none');
    $(".mic,#stopButton").addClass('d-none');  
    $(".svg").show();  
});
$("#deleteRec").click(function(){
    $("#deleteRecBtn,#audio-playback").addClass('d-none');
    $(".mic,#attach,#message").removeClass('d-none');
    $(".svg").hide();
})
</script>
<script>
// audio recorder
let recorder, audio_stream;
const recordButton = document.getElementById("recordButton");
recordButton.addEventListener("click", startRecording);

// stop recording
const stopButton = document.getElementById("stopButton");
stopButton.addEventListener("click", stopRecording);

// set preview
const preview = document.getElementById("audio-playback");

// set download button event
const downloadAudio = document.getElementById("downloadButton");
downloadAudio.addEventListener("click", downloadRecording);

function startRecording() {

    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function (stream) {
            audio_stream = stream;
            recorder = new MediaRecorder(stream);

            // when there is data, compile into object for preview src
            recorder.ondataavailable = function (e) {
                const url = URL.createObjectURL(e.data);
                preview.src = url;

                // set link href as blob url, replaced instantly if re-recorded
                downloadAudio.href = url;
            };
            recorder.start();

            timeout_status = setTimeout(function () {
                console.log("5 min timeout");
                stopRecording();
            }, 300000);
        });
}

function stopRecording() {
    recorder.stop();
    audio_stream.getAudioTracks()[0].stop();
}

function downloadRecording(){
    var name = new Date();
    var res = name.toISOString().slice(0,10)
    downloadAudio.download = res + '.wav';
}
</script>
@endsection      