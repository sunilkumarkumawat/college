@extends('layout.app')
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-whatsapp"></i> &nbsp; {{ __('WhatsApp Messages History') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('send_message_terminal')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>
                        </div>  

                    <div class="row m-2">
                        <div class="col-md-12">
                            
                                <table id="example1"class="table table-bordered">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Message</th>
                                            <th>Create Time</th>
                                            <th>Sent Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($data))
                                            @php
                                                $i = 1;
                                            @endphp
                                        @foreach($data as $item)
                                            <input type="hidden" name="module_id[]" value="{{ $item->id ?? '' }}">
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><small>{{ $item->receiver_number ?? '' }}</small></td>
                                            <td>
                                                <small>
                                                @if($item->message_status == 0)
                                                <span class="badge badge-warning">In Queue</span>
                                                @elseif($item->message_status == 1)
                                                <span class="badge badge-success">Sent</span>
                                                @elseif($item->message_status == 2)
                                                <span class="badge badge-danger">Failed</span>
                                                @else
                                                @endif
                                                </small>
                                            </td>
                                            <td>
                                                <small class="pointer" title="{{ $item->content ?? '' }}" >{{ Str::limit($item->content ?? '', 15, '...') }}<small>
                                            </td>
                                            <td><small>{{ date('D, d M Y, h:i:s A', strtotime($item->created_at)) }}</small></td>
                                            <td><small>{{ ($item->sent_at) ? date('D, d M Y, h:i:s A', strtotime($item->sent_at)) : '' }}</small></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                          
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection