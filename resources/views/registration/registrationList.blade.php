@php
$role = Helper::roleType();
$classType = Helper::classType();
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
							<h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp; {{ __('View Registration') }}</h3>
							<div class="card-tools">
                                     @if(!empty(Session::get('role_id')))
                                    <a href="{{url('registration')}}"><button class='btn btn-danger'>&larr; Back</button></a>
                                 
                                    @endif 
							     
                            </div>
						</div>
						<div class="card-body">
						    
                            <form id="quickForm"  method="post" >
                                @csrf
                            <div class="row">
                                <div class="col-md-2">
                    					<div class="form-group">
                    						<label>Status</label>
                    						<select class="form-control " id="status" name="status">
                    						    	<option value="">{{ __('common.Select') }}</option>
                    						    	@if($search['status'] == null)
                    								<option value="1"  >{{ __('Admission Students') }}</option>
                    							<option  value="0" selected>{{ __('Counselling') }}</option>

                    							@else
                    								<option value="1"  {{$search['status'] == 1 ? 'selected' : '' }}>{{ __(' Admission Students') }}</option>
                    							<option value="0" {{$search['status'] == 0 ? 'selected' : '' }}>{{ __('Counselling') }}</option>
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
						    
							<table id="example1" class="table table-bordered table-striped  dataTable table-responsive">
								<thead class="bg-primary">
									<tr role="row">
										<th>{{ __('common.SR.NO') }}</th>
										<th>{{ __('NEET Roll No') }}</th>
										<th>{{ __('Student Type') }}</th>
										<th>{{ __('Batch') }}</th>
										<th>{{ __('Course') }}</th>
										<th>{{ __('common.Name') }} </th>
										<th>Father's Name </th>
										<th>Mother's Name </th>
										<th>Registration Date </th>
										<th>Date Of  Birth </th>
										<th>Blood Group </th>
										<th>Gender </th>
										<th>{{ __('common.Mobile') }}</th>
										<th>Category </th>
										<th>{{ __('common.E-Mail') }}</th>
										<th>{{ __('Unique Reg. No') }}</th>
										<th>Total Paid Amount</th>
										<th>Action</th>
								</thead>
								<tbody id=""> 
								@if($data->isNotEmpty()) 
    								@php 
    								    $i=1;
    								@endphp 
								@foreach ($data as $item)
								    @php
								        $gender = DB::table('gender')->where('id',$item['gender_id'])->whereNull('deleted_at')->first();
								        //dd($gender);
									@endphp	    
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item['neet_roll_no'] ?? ''}}</td>
								    	<td>{{ $item['student_type'] ?? ''}}</td>
										<td>{{ $item['batch'] ?? ''}}</td>
										<td>{{ $item['courses_name'] ?? ''}}</td>
								        <td>{{ $item['first_name'] ?? '' }} </td>
								        <td>{{ $item['father_name'] ?? '' }} </td>
								        <td>{{ $item['mother_name'] ?? '' }} </td>
								       <td>
                                            {{ !empty($item['registration_date']) ? \Carbon\Carbon::parse($item['registration_date'])->format('d-m-Y') : '' }}
                                        </td>
                                        
                                        <td style="text-wrap-mode: nowrap;">
                                            {{ !empty($item['dob']) ? \Carbon\Carbon::parse($item['dob'])->format('d-m-Y') : '' }}
                                        </td>
								        <td>{{ $item['blood_group'] ?? '' }} </td>
								        
										<td>{{ $gender->name ?? ''}}</td>
									
										<td>{{ $item['mobile'] ?? ''}}</td>
										<td>{{ $item['category'] ?? ''}}</td>
										<td>{{ $item['email'] ?? ''}}</td>
										<td style="text-wrap-mode: nowrap;">{{ $item['unique_registration_id'] ?? '' }}</td>
										@php
										    $pay = DB::table('reg_fees_assign_details')->where('registration_id',$item['id'])->whereNull('deleted_at')->count();
										    $paid = DB::table('reg_fees_assign_details')->where('registration_id',$item['id'])->whereNull('deleted_at')->SUM('fees_group_amount');
										@endphp
										<td style="text-wrap-mode: nowrap;">{{ $paid }}</td>
										 
										<td style="white-space: nowrap;"> 
									
										@if($pay > 0)
										@if($item['status'] == 0 )
                                          <button type="button" class="btn btn-info btn-sm counsellingModal"  data-id="{{ $item->id }}"
                                                    data-toggle="modal"
                                                    data-target="#counsellingModal">
                                                    <span> counselling</span>
                                                </button>
                                                <a href="{{'registration/print/'.$item['id'] ?? ''}}" target="_blank"> <i class="fa fa-print" aria-hidden="true"></i></a>

                                            @endif
                                        @else
Not Paid
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



<div class="modal fade" id="counsellingModal" tabindex="-1" role="dialog" aria-labelledby="counsellingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
    
      <div class="modal-header  ">
        <h5 class="modal-title" id="counsellingModalLabel">Counselling</h5>
        <button type="button" class="close " data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
         <!-- Modal body -->
      <form action="{{ url('counselling') }}" method="post">
              	 @csrf
      <div class="modal-body p-0" style="min-height:200px;">
        <div class="container">
        <div class="row">
                                <input type="hidden" class="form-control" id="registration_id" name="registration_id">

            <div class="col-md-3">
                <div class="form-group">
                    <label>{{ __('common.Class') }}</label>
                    <select class="form-control invalid select2" id="class_type_id" name="class_type_id">
                        <option value="">{{ __('common.Select') }}</option>
                        @if(!empty($classType))
                        @foreach($classType as $type)
                        <option value="{{ $type->id ?? ''  }}" data-orderBy="{{ $type->orderBy ?? ''  }}" {{ ($type->id == old('class_type_id')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
       </div>
      </div>
    
    <div class="modal-footer text-white">
       <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
        <button type="submit" class="btn  btn-success" >Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>




<script>

    $(document).on('click', '.counsellingModal', function () {
    var id = $(this).data('id');
    $('#registration_id').val(id);
});
</script>
@endsection