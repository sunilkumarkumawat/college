@php
$role = Helper::roleType();
$getPermission = Helper::getPermission();
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
							<h3 class="card-title"><i class="fa fa-code-fork"></i> &nbsp;{{ __('master.View Branch') }}</h3>
							<div class="card-tools">
							    @if($getPermission->add == 1)
							     <a href="{{url('addBranch')}}" class="btn btn-primary  btn-sm" title="Add Branch"><i class="fa fa-plus"></i>{{ __('common.Add') }} </a>
							     @endif
							     
							     <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="Back User"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
							     
							     </div>
						</div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive dataTable dtr-inline ">
                  <thead>
                  <tr role="row">
                      <th>{{ __('master.Sr. No.') }}</th>
                            <th>{{ __('master.Branch Code') }} </th>
                            <th>{{ __('master.Branch Name') }} </th>
                            <th>{{ __('master.Contact Person') }}</th>
                            <th>{{ __('common.Mobile') }}</th>
                            <th>{{ __('common.Email') }}</th>
                            <!-- <th>{{ __('master.Country') }}</th> -->
                            <th>{{ __('common.State') }} </th>
                            <th>{{ __('common.City') }} </th>
                            <!-- <th>{{ __('master.Pin Code') }}</th> -->
                            <th>{{ __('common.Address') }}</th>
                            @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                <th>{{ __('common.Action') }}</th>
                            @endif
                             
                      
                  </thead>
                  <tbody>
                      
                      @if(!empty($data))
                        @php
                           $i=1
                        @endphp
                        @foreach ($data  as $item)
                        <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item['branch_code']  }}</td>
                                <td>{{ $item['branch_name']  }}</td>
                                <td>{{ $item['contact_person']  }}</td>
                                <td>{{ $item['mobile']  }}</td>
                                <td>{{ $item['email']  }}</td>
                                <!-- <td>{{ $item['country']  }}</td> -->
                                <td>{{ $item['state']  }}</td>
                                <td>{{ $item['city']  }}</td>
                                <!-- <td>{{ $item['pin_code']  }}</td> -->
                                <td>{{ $item['address']  }}</td>
                               @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                <td>
                                    @if($getPermission->edit == 1)
                                    <a class="btn btn-primary btn-xs" href="{{url('editBranch',$item->id)}}" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                @if($getPermission->deletes == 1)
                                @if($item->id !== 1)
                                <a class="delete btn btn-danger  btn-xs ml-2"data-id='{{$item->id}}'  href="javascript:"data-bs-toggle="modal" data-bs-target="#Modal_id" title="Delete"><i class="fa fa-trash"></i></a>
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
      
    </section>
    
  	</div>
				</div>
			</div>
		</div>
	</div>
	</section>
</div>
        
        
    <script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
    
<script>
  $('.delete').click(function(){
    $('#delete_id').val($(this).data('id'));
    $('#Modal_id').modal('show');
  });
 </script>

<!-- The Modal -->
<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <!-- Modal body -->
      <form action="{{ url('deleteBranch') }}" method="post">
              	 @csrf
      <div class="modal-body">
              
            
            
              <input type="hidden" id="delete_id" name="delete_id">
              <h5 class="text-white">{{ __('common.Are you sure you want to delete') }}  ?</h5>
           
      </div>

      <div class="modal-footer">
                    <button type="button" class="btn btn-close btn-default waves-effect remove-data-from-delete-form"aria-hidden="true" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
         </div>
       </form>

    </div>
  </div>
</div>

@endsection 