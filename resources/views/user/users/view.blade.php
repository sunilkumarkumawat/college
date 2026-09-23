@php
$role = Helper::roleType();
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
							<h3 class="card-title"><i class="fa fa-desktop"></i> &nbsp; {{ __('View Users') }}</h3>
							<div class="card-tools">
							     <a href="{{url('addUser')}}" class="btn btn-primary  btn-sm" title="Add User"><i class="fa fa-plus"></i> {{ __('common.Add') }} </a>
							     
							     <a href="{{url('user_dashboard')}}" class="btn btn-primary  btn-sm" title="Back User"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
							     
							     </div>
						</div>
						<div class="card-body">
						    
                            <form id="quickForm"  method="post" >
                                @csrf
                            <div class="row">
                                <div class="col-md-2">
                            		<div class="form-group">
                            			<label>{{ __('user.Search By Role') }}</label>
                            			<select class="select2 form-control" id="role_id" name="role_id" >
                            			<option value="">{{ __('common.Select') }}</option>
                                         @if(!empty($role)) 
                                              @foreach($role as $type)
                                                 <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == 3 ?? '' ) ? 'hidden' : '' }} {{ ($type->id == $search['role_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                              @endforeach
                                          @endif
                                        </select>
                            	    </div>
                            	</div>
                               	<div class="col-md-4">
            			<div class="form-group">
            				<label>{{ __('common.Search By Keywords') }}</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1 ">
                             <label class="text-white">Search</label>
                    	    <button type="submit" class="btn btn-primary" >{{ __('common.Search') }}</button>
                    	</div>	
                            </div>
                            </form> 						    
						    
							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead class="bg-primary">
									<tr role="row">
										<th>{{ __('common.SR.NO') }}</th>
										<th class="text-center">Image</th>
										<th>{{ __('user.Role') }}</th>
										<th>{{ __('common.Name') }} </th>
										<th>{{ __('common.Mobile') }}</th>
										<th>{{ __('common.E-Mail') }}</th>
										<th>{{ __('user.User Name') }}</th>
										<th>{{ __('common.Password') }}</th>
										<th>{{ __('common.Status') }}</th>
										<th>{{ __('common.Action') }}</th>
								</thead>
								<tbody id="user_list_show"> 
								@if(!empty($data)) 
    								@php 
    								    $i=1; 
    								@endphp 
								@foreach ($data as $item)
									<tr>
										<td>{{ $i++ }}</td>
										<td class="text-center">
                                            <img class="profileImg pointer" src="{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" data-img="@if(!empty($item->image)) {{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }} @endif" >
                                        </td>
										<td>{{ $item['roleName']['name'] ?? '' }}</td>
								        <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
										<td>{{ $item['mobile'] ?? ''}}</td>
										<td>{{ $item['email'] ?? ''}}</td>
										<td>{{ $item['userName'] ?? '' }}</td>
										<td>{{ $item['confirm_password'] ?? ''}}</td>
										<td> 
										@if($actionPermission['edit'] == 1)
										@if($item->role_id != 2)
										@if($item->status==1)

                                            <button data-toggle="modal" data-target="#statusModal" data-id="{{ $item['id'] ?? '' }}" class="btn btn-primary  w-100 btn btn-primary btn-sm userStatus" data-status="0">Active</button>
                                 
                                            @else
                    
                                            <button data-toggle="modal" data-target="#statusModal" data-id="{{ $item['id'] ?? '' }}" class="btn btn-primary  w-75 btn btn-primary btn-sm userStatus" data-status="1">Inactive</button>
                                   
                                            @endif 
                                            @else
                                            <select name="status" data-id="{{ $item['id'] ?? '' }}" class="btn btn-primary form-control statusDrop w-75 {{$item->status == 0 ? 'btn btn-primary' : '' }} {{ $item->status == 1 ?  : '' }} {{ $item->status == 2 ? 'bg-info' : '' }}">
                                                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Dropped Teacher</option>
                                            </select>
                                        @endif    
										<!--<a data-id="{{ $item['id'] ?? '' }}" style="{{  $item['status'] == 0 ? 'display:none'   : ''  }}" 
										data-status="0" class="btn btn-xs btn-success change_status" 
										data-bs-toggle="modal" data-bs-target="#statusModel"> &nbsp; Active &nbsp;</a> <a data-id="{{ $item['id'] ?? '' }}" style="{{  $item['status'] == 1 ? 'display:none'   : ''  }}" data-status="1" class="btn btn-xs btn-danger change_status" data-bs-toggle="modal" data-bs-target="#statusModel">Deactive</a> -->
										@endif
										</td>
										<td>
									    @if($actionPermission['edit'] == 1)
									    <a href="{{url('editUser',$item['id'])}}" class="btn btn-primary  btn-xs" title="Edit User"><i class="fa fa-edit"></i></a>
									    @else
									    <button class="btn btn-primary disabled btn-xs"><i class="fa fa-edit"></i></button>
									    @endif

									    @if($item->role_id !== 1 && $item->role_id !== Session::get('role_id'))
									    @if($actionPermission['deletes'] == 1)
									    <a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-primary  btn-xs ml-3" title="Delete User"><i class="fa fa-trash-o"></i></a> 
									    @else
									    <button class="btn btn-primary disabled btn-xs ml-3"><i class="fa fa-trash-o"></i></button> 
									    @endif	

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
    $(document).ready(function(){
        
        $('.statusDrop').change(function(){
           var status = $(this).val(); 
            $('#status_id').val(status);
            $('#id').val($(this).data('id'));
            $('#statusModal').modal('show');
        });
        
        $('.deleteData').click(function() {
        	var delete_id = $(this).data('id');
        	$('#delete_id').val(delete_id);
        });
        
        $('.userStatus').click(function(){
            var status = $(this).data('status');
            $('#status_id').val(status);
            $('#id').val($(this).data('id'));
        });
    });
</script>

<div class="modal fade" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #002c54;">
      <div class="modal-header">
        <h4 class="modal-title text-white">Change Status Conformation</h4>
        <button type="button" class="btn-close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <form action="{{ url('userStatus') }}" method="post">
            @csrf
      <div class="modal-body">
          <input type="hidden" id="status_id" name="status_id">
          <input type="hidden" id="id" name="id">
          <h5 class="text-white">Are you sure you want to Change Status ?</h5>
           
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" >Close</button>
            <button type="submit" class="btn btn-danger waves-effect waves-light">Submit</button>
         </div>
       </form>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="Modal_id">
	<div class="modal-dialog">
		<div class="modal-content" style="background: #002c54;">
			<div class="modal-header">
				<h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
			<form action="{{ url('deleteUser') }}" method="post">
			     @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('common.Are you sure you want to delete') }} ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="profileImgModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img id="profileImg" src="" width="100%" height="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  
<style>
    .profileImg {
        width:50px;
        height:50px;
        border-radius:50%;
    }
    
    .statusDrop option{
        background-color: white !important;
        color:black !important;
    }
</style>
<script>
    $('.profileImg').click(function(){
        var profileImgUrl = $(this).data('img');
        if(profileImgUrl != ''){
            $('#profileImgModal').modal('toggle');
            $('#profileImg').attr('src',profileImgUrl);
        }
    });
</script>
@endsection