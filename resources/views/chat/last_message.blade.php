

        @if(!empty($lastMessage))
        @if($lastMessage->to_id == Session::get('id'))
            <div class='message receive'>
              <!--<img src='https://d2gcv4sxt84gxu.cloudfront.net/uploads/avatars/995064/original.png?1450125781'>-->
              <div class='message_text'>
                @if(!empty($lastMessage->document))
                    <svg class="downloadDocument" data-chat_document="{{ $value->document ?? '' }}" viewBox="0 0 34 34" height="24" width="24"><path fill="currentColor" d="M17,2c8.3,0,15,6.7,15,15s-6.7,15-15,15S2,25.3,2,17S8.7,2,17,2 M17,1C8.2,1,1,8.2,1,17 s7.2,16,16,16s16-7.2,16-16S25.8,1,17,1L17,1z"></path><path fill="currentColor" d="M22.4,17.5h-3.2v-6.8c0-0.4-0.3-0.7-0.7-0.7h-3.2c-0.4,0-0.7,0.3-0.7,0.7v6.8h-3.2 c-0.6,0-0.8,0.4-0.4,0.8l5,5.3c0.5,0.7,1,0.5,1.5,0l5-5.3C23.2,17.8,23,17.5,22.4,17.5z"></path></svg>
                    @if($lastMessage->extension == 'mp3' || $lastMessage->extension == 'm4a' || $lastMessage->extension == 'aac' || $lastMessage->extension == 'wav')
                        <audio class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="audio/mp3"><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="audio/mp3"></audio>                    
                    @elseif($lastMessage->extension == 'png' || $lastMessage->extension == 'jpg' || $lastMessage->extension == 'jpeg' || $lastMessage->extension == 'gif')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'img_preview.png' }}'">
                    @elseif($lastMessage->extension == 'pdf' || $lastMessage->extension == 'doc' || $lastMessage->extension == 'docx' || $lastMessage->extension == 'xls' || $lastMessage->extension == 'xlsx' || $lastMessage->extension == 'txt' || $lastMessage->extension == 'zip')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'document_preview.png' }}">
                    @elseif($lastMessage->extension == 'mp4' || $lastMessage->extension == 'm4a' || $lastMessage->extension == 'mov' || $lastMessage->extension == 'wmv' || $lastMessage->extension == 'avi' || $lastMessage->extension == 'webm')
                        <video class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="video/mp4"><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="video/ogg"></video>                    
                    @endif
                    
                    <br>
                @endif  
                {{ $lastMessage->message ?? '' }}
                <sub class="text-secondary"> &nbsp; <small>{{ date(' h:i A', strtotime($lastMessage->created_at)) }}</small></sub>
                <i class="fa fa-chevron-down msgAction" data-msgId="{{ $lastMessage->id }}"></i>
              </div>
            </div>
        @else    
            <div class='message sender'>
              <!--<img src="https://orig00.deviantart.net/f144/f/2016/273/b/3/black_widow_3_by_saturnsam-dajg3hy.jpg"/>-->
              <div class='message_text'>
                @if(!empty($lastMessage->document))
                    <svg class="downloadDocument" data-chat_document="{{ $value->document ?? '' }}" viewBox="0 0 34 34" height="24" width="24"><path fill="currentColor" d="M17,2c8.3,0,15,6.7,15,15s-6.7,15-15,15S2,25.3,2,17S8.7,2,17,2 M17,1C8.2,1,1,8.2,1,17 s7.2,16,16,16s16-7.2,16-16S25.8,1,17,1L17,1z"></path><path fill="currentColor" d="M22.4,17.5h-3.2v-6.8c0-0.4-0.3-0.7-0.7-0.7h-3.2c-0.4,0-0.7,0.3-0.7,0.7v6.8h-3.2 c-0.6,0-0.8,0.4-0.4,0.8l5,5.3c0.5,0.7,1,0.5,1.5,0l5-5.3C23.2,17.8,23,17.5,22.4,17.5z"></path></svg>
                    @if($lastMessage->extension == 'mp3' || $lastMessage->extension == 'm4a' || $lastMessage->extension == 'aac' || $lastMessage->extension == 'wav')
                        <audio class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="audio/mp3"><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="audio/mp3"></audio>                    
                    @elseif($lastMessage->extension == 'png' || $lastMessage->extension == 'jpg' || $lastMessage->extension == 'jpeg' || $lastMessage->extension == 'gif')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'img_preview.png' }}'">
                    @elseif($lastMessage->extension == 'pdf' || $lastMessage->extension == 'doc' || $lastMessage->extension == 'docx' || $lastMessage->extension == 'xls' || $lastMessage->extension == 'xlsx' || $lastMessage->extension == 'txt' || $lastMessage->extension == 'zip')
                        <img class="chatImg" src="{{ env('IMAGE_SHOW_PATH').'document_preview.png' }}">
                    @elseif($lastMessage->extension == 'mp4' || $lastMessage->extension == 'm4a' || $lastMessage->extension == 'mov' || $lastMessage->extension == 'wmv' || $lastMessage->extension == 'avi' || $lastMessage->extension == 'webm')
                        <video class="chatImg" controls><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="video/mp4"><source src="{{ env('IMAGE_SHOW_PATH').'chat/document/'.$lastMessage->document }}" type="video/ogg"></video>                    
                    @endif
                    
                    <br>
                @endif
                {{ $lastMessage->message ?? '' }}
                <sub class="text-white"> &nbsp; <small>{{ date(' h:i A', strtotime($lastMessage->created_at)) }}</small></sub>
                <i class="fa fa-chevron-down msgAction" data-msgId="{{ $lastMessage->id }}"></i>
              </div>
            </div>
        @endif
        @endif  