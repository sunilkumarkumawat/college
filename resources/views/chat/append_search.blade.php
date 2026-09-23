    @if(!empty($data[0]->id != ''))
    <table class="table table-hover" >
        <thead>
            <tr>
               <th colspan="3" class="bg-light"><span class="text-white ">CONTACTS</span> </th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($data  as $item)
                @php
                $role = DB::table('role')->where('id',$item->role_id)->whereNull('deleted_at')->get()->first();
                @endphp
                <tr class="border-bottom chat_info" style="cursor:pointer;" onclick="showData('{{ $item['regisUniqueId'] ?? '' }}');" >
                    <input type="hidden" id="role_id_{{$item['regisUniqueId'] ?? '' }}" value="{{ $item['role_id'] ?? '' }}">
                    <input type="hidden" id="click_id_{{$item['regisUniqueId'] ?? '' }}" value="{{ $item['regisUniqueId'] ?? '' }}">
                    <input type="hidden" id="to_name_id_{{$item['regisUniqueId'] ?? '' }}" value="{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}">
                    <td class="p-1" >
                        @if(!empty($item->image))
                            <input type="hidden" id="to_img_id_{{$item['regisUniqueId'] ?? '' }}" value="{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] ?? '' }}">
                            <img id="chatProfileImg" src="{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] ?? '' }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'">
                        @else
                            <input type="hidden" id="to_img_id_{{$item['regisUniqueId'] ?? '' }}" value="{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}">
                            <img id="chatProfileImg" src="{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}">
                        @endif
                    </td>
                    <td class="p-1" title="{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}">{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}
                        <br><i class="fa fa-graduation-cap"></i> <small>{{ $role->name ?? '' }} {{ $item['mobile'] ?? '' }}</small> 
                    </td>
                    <td class="p-1 text-center" style="color: transparent;"><small>{{ date(' h:i A', strtotime($item->created_at)) }}</small></td>
                </tr>
           @endforeach
            
        </tbody>
    </table>
    @endif