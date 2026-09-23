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
            						    
            			    <form id="quickForm" action="{{ url('registrationListGroup') }}" method="post" >
                            @csrf 
                                <div class="row m-2">
                                	<div class="col-md-2">
                                		<div class="form-group">
                                			<label>{{ __('fees.From Date') }}</label>
                                                <input type="date" class="form-control " id="starting" name="starting" value="{{ $serach['starting'] ?? '' }}">                 	    
                                        </div>
                                	</div>
                                	<div class="col-md-2">
                                        <div class="form-group ">
                                            <label>{{ __('fees.To Date') }}</label>
                                                <input type="date" class="form-control " id="ending" name="ending" value="{{ $serach['ending'] ?? '' }}">
                            			</div> 
                                    </div>
                                	
                                            	
                                    <div class="col-md-1 ">
                                         <label for="" style="color: white;">Search</label>
                                	    <button type="submit" class="btn btn-primary" srtle="margin-top: 26px !important;">{{ __('messages.Search') }}</button>
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
										<th>{{ __('common.Name') }} </th>
										<th>Father's Name </th>
										<th>Mother's Name </th>
										<th>Registration Date </th>
										
										<th>Blood Group </th>
										<th>{{ __('common.Mobile') }}</th>
										<th>Category </th>
										<th>{{ __('common.E-Mail') }}</th>
										<th>{{ __('Unique Reg. No') }}</th>
										<th>Payment Date</th>
										<th>Total Amount</th>
										<th>Action</th>
								</thead>
								<tbody id=""> 
								@if($data->isNotEmpty()) 
    								@php 
    								    $i=1;
    								@endphp 
								@foreach ($data as $item)
								
									<tr>
									    @php
										 $raj = DB::table('registrations')->where('id',$item['registration_id'])->whereNull('deleted_at')->get()->first();
										@endphp
										<td>{{ $i++ }}</td>
										<td>{{ $raj->neet_roll_no ?? ''}}</td>
								    	<td>{{ $raj->student_type ?? ''}}</td>
										<td>{{ $raj->batch ?? ''}}</td>
								        <td>{{ $raj->first_name ?? '' }} </td>
								        <td>{{ $raj->father_name ?? '' }} </td>
								        <td>{{ $raj->mother_name ?? '' }} </td>
								       <td>
                                            {{ !empty($raj->registration_date) ? \Carbon\Carbon::parse($raj->registration_date)->format('d-m-Y') : '' }}
                                        </td>
                                        
                                      
								        <td>{{ $raj->blood_group ?? '' }} </td>
										<td>{{ $raj->mobile ?? ''}}</td>
										<td>{{ $raj->category ?? ''}}</td>
										<td>{{ $raj->email ?? ''}}</td>
										<td style="text-wrap-mode: nowrap;">{{ $raj->unique_registration_id ?? '' }}</td>
									  <td style="text-wrap-mode: nowrap;">
                                            {{ !empty($item->payment_date) ? \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') : '' }}
                                        </td>
										<td style="text-wrap-mode: nowrap;">{{$item->total_amount ?? '' }}</td>
										 
										<td style="white-space: nowrap;"> 
									
									
									
                                        
                                                <a href="{{'registrationList/print/'.$item['registration_id'] ?? ''}}/{{$item['payment_date'] ?? ''}}/{{$item['registration_invoice_no'] ?? ''}}" target="_blank"> <i class="fa fa-print" aria-hidden="true"></i></a>

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