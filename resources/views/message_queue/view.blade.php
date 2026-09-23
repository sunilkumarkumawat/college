@php
    $getHostel = Helper::getHostel();
    $getPermission = Helper::getPermission();
@endphp
@extends('layout.app') 
@section('content')
<style>
    .top{
        margin-top: -12px;
    }
</style>
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-credit-card"></i> &nbsp;{{ __('View Message Queue') }}</h3>	
						</div>
						<div class="card-body">
                            <div class="col-md-12" id="">

                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                            <thead class="bg-primary">
                                <tr role="row">
                                    <th>{{ __('Sr No.') }}</th>
                                    <th>{{ __('Message ID ') }}</th>
                                    <th>{{ __('Receiver number') }}</th>
                                    <th>{{ __('Message Type') }}</th>
                                    <th>{{ __('Content') }}</th>
                                    <th>{{ __('Media Link') }}</th>
                                    <th>{{ __('Message status') }}</th>
                                    <th>{{ __('Submitted at') }}</th>
                                    <th>{{ __('Sent/failed at') }}</th>
                                    <th>{{ __('Delivered at') }}</th>
                                    <th>{{ __('common.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
  @if(!empty($data))
                        @php
                       // dd($data);
                           $i=1
                        @endphp
                        @foreach ($data  as $item)
                                   <tr>
                                       
                      
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item['message_id'] ?? '' }} </td>
                                    <td>{{ $item['receiver_number'] ?? '' }} </td>
                                    <td>{{ $item['message_type'] ?? '' }} </td>
                                    <td>{{ $item['content'] ?? '' }} </td>
                                    <td>{{ $item['media_link'] ?? '' }} </td>
                                    <td>{{ $item['message_status'] ?? '' }} </td>
                                    <td>{{ $item['submitted_at'] ?? '' }} </td>
                                    <td>{{ $item['sent_at'] ?? '' }} </td>
                                    <td>{{ $item['delivered_at'] ?? '' }} </td>
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
		</div>
	</section>
</div>


@endsection      