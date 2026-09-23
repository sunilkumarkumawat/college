@php

$task = Helper::task();


@endphp
  @if(!empty($task))
  
  
               @foreach($task as $item)
                 @php
                $fdate = $item->created_at;
$tdate = date('Y-m-d H:i:s');
$datetime1 = new DateTime($fdate);
$datetime2 = new DateTime($tdate);
$interval = $datetime1->diff($datetime2);
$days = $interval->format('%a');

@endphp
                                <li class="" id="_{{ $item->id ?? '' }}">
                                    <span class="handle ui-sortable-handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" class="task_status"
                                            data-id="{{ $item->id ?? '' }}" data-status="{{ $item->status ?? '' }}"
                                            name="task_status" id="_{{ $item->name ?? '' }}"
                                            style="{{  $item['status'] == 1 ? 'checked' : '' }}">
                                        <label for="_{{ $item->name ?? '' }}"></label>
                                    </div>
                                    <span class="text">{{ $item->name ?? '' }}</span>
                                    <small class="badge badge-{{$days<=2 ? 'success' : ''}}{{$days>=3 && $days<=6  ? 'primary' : ''}}{{$days>=7  ? 'danger' : ''}}"><i class="fa fa-clock"></i> {{$days}} days ago</small>
                                    <div class="tools">
                                        <i class="fa fa-trash-o task_delete" data-id="{{ $item->id ?? '' }}"></i>
                                    </div>
                                </li>
                                @endforeach
                                @endif
