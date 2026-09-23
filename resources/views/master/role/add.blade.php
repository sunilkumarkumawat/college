@php
$sidebar = Helper::getSiderbar();
$getPermission = Helper::getPermission();
@endphp
@extends('layout.app')
@section('content')

     <div class="content-wrapper">
   
   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">    
        <div class="col-md-4 pr-0 {{ ($getPermission->add == 1) ? '' : 'd-none'}}">
            <div class="card card-outline card-orange mr-1">
             <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-user-circle-o"></i> &nbsp;{{ __('master.Role') }}</h3>
                			<div class="card-tools">
           
            </div>
            
            </div>                                  

    <form id="quickForm" action="{{ url('role_add') }}" method="post" >
        @csrf
		<div class="row m-2">
                <div class="col-md-12">
					<label class="text-danger">{{ __('master.Role') }} *</label>
					<input type="text" class="form-control @error('role') is-invalid @enderror " id="role" name="role" placeholder="{{ __('master.Role') }}" value="{{old('role')}}">
					@error('role')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
            </div>
	
          <div class="row m-2">
                    <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">{{ __('common.submit') }}  </button>
                    </div>
                </div>
              </form>
            </div>          
        </div>
        
        <div class="{{ ($getPermission->add == 1) ? 'col-md-8 pl-0' : 'col-md-12 pl-0'}}">
            <div class="card card-outline card-orange ml-1">
             <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fa fa-user-circle-o"></i> &nbsp;{{ __('master.View Role') }}</h3>
            <div class="card-tools">
            <!--<a href="{{url('students/add')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-plus"></i> Add</a>-->
            <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>
            </div>
            
            </div>                 
                <div class="row m-2">
                    <div class="col-md-12">
                	</div>
                    <div class="col-md-12">
                       <table id="" class="table table-bordered table-striped dataTable dtr-inline ">
                          <thead>
                          <tr role="row">
              <th>{{ __('common.SR.NO') }}</th>
                    <th>{{ __('master.Role') }}  </th>
                    @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                    <th>{{ __('common.Action') }}</th>
                    @endif
          </thead>
          <tbody>
              
              @if(!empty($role))
                @php
                   $i=1
                @endphp
                @foreach ($role as $item)
                <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item['name'] ?? '' }}</td>
                    @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                        <td>
                            @if($item['id']  <= 5)
                            @else
                            @if(Session::get('role_id') == 1)
                            @if($getPermission->edit == 1)
                                <a href="{{ url('role_Edit') }}/{{ $item['id'] ?? '' }}" class="btn btn-primary  btn-xs" title="Edit"><i class="fa fa-edit"></i></a> 
                                @endif
                                @if($getPermission->deletes == 1)
                                <a href="javascript:;" data-id='{{$item['id'] }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger btn-xs ml-3"><i class="fa fa-trash-o"></i></a>
                                @endif
                            @else
                               <a href="javascript:;" data-id='{{$item['id'] }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger btn-xs ml-3"><i class="fa fa-trash-o"></i></a>
                            @endif
                            @endif
                        </td>
                    @endif     
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

  

      <script>
    $("#select_all").change(function () {  
        $(".checkbox").prop('checked', $(this).prop("checked")); 
    });
</script>  
<script>
  $('.deleteData').click(function() {
  var delete_id = $(this).data('id'); 
  
  $('#delete_id').val(delete_id); 
  } );
 </script>
  
<!-- The Modal -->
<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title text-white">{{__('common.Delete Confirmation') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <!-- Modal body -->
      <form action="{{ url('role_delete') }}" method="post">
              	 @csrf
      <div class="modal-body">
              
            
            
              <input type=hidden id="delete_id" name=delete_id>
              <h5 class="text-white">{{__('common.Are you sure you want to delete') }}  ?</h5>
           
      </div>

      <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{__('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{__('common.Delete') }}</button>
         </div>
       </form>

    </div>
  </div>
</div>

@endsection

