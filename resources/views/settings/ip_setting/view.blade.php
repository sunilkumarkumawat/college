@php
$role = Helper::getrole();
$actionPermission = Helper::actionPermission();
@endphp
@extends('layout.app') 
@section('content')
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-sliders"></i> &nbsp;{{ __('ip_setting.View IP Setting') }}</h3>
							<div class="card-tools"> 
							<a href="{{url('add_ip_setting')}}" class="btn btn-primary  btn-sm" title="Add IP Setting"><i class="fa fa-plus"></i>{{ __('ip_setting.Add IP Setting') }}</a>
							 <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
							</div>
						</div>
						<div class="card-body">
						    
							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead>
									<tr role="row">
										<th>{{ __('common.SR.NO') }}</th>
										<th>{{ __('ip_setting.IP Address') }}</th>
										<th>{{ __('ip_setting.Remark') }}</th>
										<th>{{ __('ip_setting.Status') }}</th>
										<th>{{ __('common.Action') }}</th>
								</thead>
								<tbody id="user_list_show"> 
								@if(!empty($data)) 
    								@php 
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item['ip_address'] ?? '' }}</td>
										<td>{{ $item['remark'] ?? ''}}</td>
										<td> 
										    @if($actionPermission['edit'] == 1)
										        <a data-id="{{ $item['id'] ?? '' }}" style="{{  $item['status'] == 0 ? 'display:none'   : ''  }}" data-status="0" class="btn btn-xs btn-success change_status" data-bs-toggle="modal" data-bs-target="#statusModel"> &nbsp; Active &nbsp;</a> 
										        <a data-id="{{ $item['id'] ?? '' }}" style="{{  $item['status'] == 1 ? 'display:none'   : ''  }}" data-status="1" class="btn btn-xs btn-danger change_status" data-bs-toggle="modal" data-bs-target="#statusModel">Deactive</a> 
										    @else
										        <a style="{{  $item['status'] == 0 ? 'display:none'   : ''  }}" class="btn btn-xs btn-success disabled" > &nbsp; {{__('common.Active') }} &nbsp;</a>
										        <a style="{{  $item['status'] == 1 ? 'display:none'   : ''  }}" class="btn btn-xs btn-danger disabled" >{{__('common.Deactive') }}</a> 
										    @endif										
										</td>

										<td> 
										    @if($actionPermission['edit'] == 1)
										        <a href="{{url('edit_ip_setting',$item['id'])}}" class="btn btn-primary  btn-xs" title="Edit User"><i class="fa fa-edit"></i></a>
										    @else
										        <a href="#" class="btn btn-primary disabled btn-xs" title="Edit User"><i class="fa fa-edit"></i></a>
										    @endif
										    @if($actionPermission['deletes'] == 1)
										        <a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger  btn-xs ml-3" title="Delete User"><i class="fa fa-trash-o"></i></a> 
										    @else
										        <a href="javascript:;" class="btn btn-danger disabled btn-xs ml-3" title="Delete User"><i class="fa fa-trash-o"></i></a>
										    @endif										        
										</td>
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
	</section>
</div>


<script>
    
$('.deleteData').click(function() {
	var delete_id = $(this).data('id');
	$('#delete_id').val(delete_id);
});

var id="";
var status="";
  $(document).on('click', ".change_status", function() {
      $('#myModal').modal('toggle');
        id = $(this).data("id");
        status = $(this).data("status");
  });
$(document).on('click', ".change_status1", function() {

	$.ajax({
		url: 'ip_status',
		type: 'post',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			status: status,
			id: id
		},
		success: function(response) {
 		   window.location.href = '{{ url('view_ip_setting') }}'
		},
	});
});
</script>
                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                          <div class="modal-dialog">
                            <div class="modal-content" style="background: #555b5beb;">
                        
                              <div class="modal-header">
                                <h4 class="modal-title text-white">{{ __('common.Status Change Confirmation') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                              </div>
                        
                              <form action="#" method="post">
                              <div class="modal-body">
                                      <h5 class="text-white">{{ __('common.Are you sure you want to Change Status') }}  ?</h5>
                              </div>
                              <div class="modal-footer">
                                        <button type="button" class="btn btn-primary waves-effect waves-light change_status1" data-bs-dismiss="modal">{{ __('common.Yes') }}</button>
                                        <button type="button" class="btn btn-danger waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                                            
                                 </div>
                               </form>
                            </div>
                          </div>
                        </div>
<!-- The Modal -->
<div class="modal" id="Modal_id">
	<div class="modal-dialog">
		<div class="modal-content" style="background: #555b5beb;">
			<div class="modal-header">
				<h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
			<form action="{{ url('delete_ip_setting') }}" method="post"> @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('common.Are you sure you want to delete') }}  ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
</div> @endsection