

        @if(!empty($chatHistory))
        @foreach($chatHistory as $value)
        @if($value->to_id == Session::get('regisUniqueId'))
            <div class='message receive msgAction' data-msgId="{{ $value->id }}" data-copy_message="{{ $value->message }}">
              <!--<img src='https://d2gcv4sxt84gxu.cloudfront.net/uploads/avatars/995064/original.png?1450125781'>-->
              <div class='message_text'>
                @if(!empty($value->document))
                    <svg class="downloadDocument" data-chat_document="{{ $value->document ?? '' }}" viewBox="0 0 34 34" height="24" width="24"><path fill="currentColor" d="M17,2c8.3,0,15,6.7,15,15s-6.7,15-15,15S2,25.3,2,17S8.7,2,17,2 M17,1C8.2,1,1,8.2,1,17 s7.2,16,16,16s16-7.2,16-16S25.8,1,17,1L17,1z"></path><path fill="currentColor" d="M22.4,17.5h-3.2v-6.8c0-0.4-0.3-0.7-0.7-0.7h-3.2c-0.4,0-0.7,0.3-0.7,0.7v6.8h-3.2 c-0.6,0-0.8,0.4-0.4,0.8l5,5.3c0.5,0.7,1,0.5,1.5,0l5-5.3C23.2,17.8,23,17.5,22.4,17.5z"></path></svg>
                    @if($value->extension == 'mp3' || $value->extension == 'm4a' || $value->extension == 'aac' || $value->extension == 'wav')
                        <audio class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" type="audio/mpeg"></audio>                    
                    @elseif($value->extension == 'png' || $value->extension == 'jpg' || $value->extension == 'jpeg' || $value->extension == 'gif')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'img_preview.png' }}'">
                    @elseif($value->extension == 'pdf' || $value->extension == 'doc' || $value->extension == 'docx' || $value->extension == 'xls' || $value->extension == 'xlsx' || $value->extension == 'txt' || $value->extension == 'zip')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'document_preview.png' }}">
                    @elseif($value->extension == 'mp4' || $value->extension == 'm4a' || $value->extension == 'mov' || $value->extension == 'wmv' || $value->extension == 'avi' || $value->extension == 'webm')
                        <video class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" type="video/mp4"></video>                    
                    @endif
                    
                    <br>
                @endif  
                @if($value->extension == 'url')
                    <a href="{{ $value->message ?? '' }}" target="blank">{{ $value->message ?? '' }}</a>
                @else
                    {{ $value->message ?? '' }} 
                @endif
                <sub class="text-secondary"> &nbsp; <small>{{ date(' h:i A', strtotime($value->created_at)) }}</small></sub>
                <!--<i class="fa fa-chevron-down msgAction" data-msgId="{{ $value->id }}" data-copy_message="{{ $value->message }}"></i>-->
              </div>
            </div>
        @else    
            <div class='message sender msgAction' data-msgId="{{ $value->id }}" data-copy_message="{{ $value->message }}">
              <!--<img src="https://orig00.deviantart.net/f144/f/2016/273/b/3/black_widow_3_by_saturnsam-dajg3hy.jpg"/>-->
              <div class='message_text'>
                @if(!empty($value->document))
                    <svg class="downloadDocument" data-chat_document="{{ $value->document ?? '' }}" viewBox="0 0 34 34" height="24" width="24"><path fill="currentColor" d="M17,2c8.3,0,15,6.7,15,15s-6.7,15-15,15S2,25.3,2,17S8.7,2,17,2 M17,1C8.2,1,1,8.2,1,17 s7.2,16,16,16s16-7.2,16-16S25.8,1,17,1L17,1z"></path><path fill="currentColor" d="M22.4,17.5h-3.2v-6.8c0-0.4-0.3-0.7-0.7-0.7h-3.2c-0.4,0-0.7,0.3-0.7,0.7v6.8h-3.2 c-0.6,0-0.8,0.4-0.4,0.8l5,5.3c0.5,0.7,1,0.5,1.5,0l5-5.3C23.2,17.8,23,17.5,22.4,17.5z"></path></svg>
                    @if($value->extension == 'mp3' || $value->extension == 'm4a' || $value->extension == 'aac' || $value->extension == 'wav')
                        <audio class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" type="audio/mpeg"></audio>                    
                    @elseif($value->extension == 'png' || $value->extension == 'jpg' || $value->extension == 'jpeg' || $value->extension == 'gif')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'img_preview.png' }}'">
                    @elseif($value->extension == 'pdf' || $value->extension == 'doc' || $value->extension == 'docx' || $value->extension == 'xls' || $value->extension == 'xlsx' || $value->extension == 'txt' || $value->extension == 'zip')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'document_preview.png' }}">
                    @elseif($value->extension == 'mp4' || $value->extension == 'm4a' || $value->extension == 'mov' || $value->extension == 'wmv' || $value->extension == 'avi' || $value->extension == 'webm')
                        <video class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$value->document }}" type="video/mp4"></video>                    
                    @endif
                    
                    <br>
                @endif
                @if($value->extension == 'url')
                    <a href="{{ $value->message ?? '' }}" target="blank">{{ $value->message ?? '' }}</a>
                @else
                    {{ $value->message ?? '' }} 
                @endif
                <sub class="text-white"> &nbsp; <small>{{ date(' h:i A', strtotime($value->created_at)) }}</small></sub>
                <!--<i class="fa fa-chevron-down msgAction" data-msgId="{{ $value->id }}" data-copy_message="{{ $value->message }}"></i>-->
              </div>
            </div>
        @endif
        @endforeach
        @endif            




<script>

$("#sendChat").click(function(e){
    var message = $('#message').val();
    var attachFile = $('#attachFile').val();

    var sent_at = new Date().toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
    $("#start").click();
    
    e.preventDefault();
    var formData = new FormData($("#submitForm")[0]);  
   
    if(message != '' || attachFile != ''){

        var myAudio = new Audio('{{URL::asset('resources/views/chat/ChatSentNotification.mp3')}}');

        $('#message').val('');
        myAudio.play();

        var message_container = document.createElement("div");
        var messagess = `<div class="message_text"> ${message} <sub class="text-white"> &nbsp; <small>${sent_at}</small></sub> </div>`;
        message_container.className = "message sender msgAction";
        message_container.innerHTML = messagess;      
        body.insertBefore(message_container, body.firstChild);
        input.value = ""; 

        $(".svg").hide();
        $(".mic").show();
                    
            $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    type:'post',
                    url: URL+'/send/chat',
                    enctype: 'multipart/form-data',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,                        
                success: function (data) {

                }
            });
    }
});
    
var send = document.querySelector('.chatbox__input svg');
var body = document.querySelector('.chatbox__body')
var input = document.querySelector('input');

$(".downloadDocument").click(function(){
    var chatDocument = $(this).data('chat_document');
    $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        type:'post',
        url: URL+'/download/chat/document',
        data: {chatDocument:chatDocument},
        success: function (data) {
            toastr.info('Download Succcessful')
        }
      });    
});

    var arra = [];
$(".msgAction").click(function(){
    $(this).addClass('deleting');
    $(this).children().css({"background": "#f57a13"});
    var msg_id = $(this).attr("data-msgId");
    var copy_message = $(this).attr("data-copy_message");

    if(arra.indexOf(msg_id) > -1){
        var i = $.inArray(msg_id,arra)
        if (i >= 0){
            arra.splice(i, 1);
        }
        $("#msg_delete_id").val(arra);
        $(this).removeClass('deleting');
        $(this).children().removeAttr("style");
    }else{
        arra.push(msg_id);
    }
    $("#msg_delete_id").val(arra);
    $("#chatboxHeader").hide();
    $("#msgOption").show();
    $("#copy_message").val(copy_message);
});


</script>
