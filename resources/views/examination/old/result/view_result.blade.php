
@extends('layout.app') 
@section('content')

<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
                        @if(Session::get('role_id') == 3)
                            <h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp; My Result </h3>
                        @else						    
							<h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp; View Students</h3>
						@endif
							<div class="card-tools"> 
                                <a href="{{url('view/result')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back </a> 
                            </div>
						</div>

                    <form id="quickForm" action="{{ url('#') }}" method="post" >
                        @csrf 
                    <div class="row m-2">

            		<div class="col-md-5">
            			<div class="form-group">
            				<label>Search By Keywords</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="Ex. Name, Father/ Mother Name, Mobile No., Aadhaar etc" value="{{ $search['name'] ?? '' }}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1 ">
                             <label for="" class="text-white">Search</label>
                    	    <button type="submit" class="btn btn-primary">Search</button>
                    	</div>
                    			
                    </div>
                </form> 
                <div class="row m-2">
                    <div class="col-md-12">
							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead>
									<tr role="row">
										<th>Sr. No.</th>
										<th>Name </th>
										<th>Father Name</th>
										<th>Mobile</th></th>
										<th>Total Question</th>
										<th>Correct Answer</th>
										<th>Wrong Answer</th>
										<th>Skipped Answer</th>
										<th>Result (%)</th>
										<th>Time Taken</th>
										<th>Action</th>
								</thead>
								<tbody> 
								@if(!empty($data)) 
    								@php 
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item['Admission']['first_name'] ?? ''}} {{ $item['Admission']['last_name'] ?? ''}}</td>
										<td>{{ $item['Admission']['father_name'] ?? ''}}</td>
										<td>{{ $item['Admission']['mobile'] ?? ''}}</td>
										<td><small class="badge badge-info w-25">{{ $item['total_ques'] ?? ''}}</small></td>
										<td><small class="badge badge-success w-25">{{ $item['correct_ans'] ?? ''}}</small></td>
										<td><small class="badge badge-danger w-25">{{ $item['total_ques']-$item['correct_ans']-$item['skip_ques'] ?? ''}}</small></td>
										<td><small class="badge badge-warning w-25">{{ $item['skip_ques'] ?? ''}}</small></td>
										<td><small class="badge badge-{{  $item['percentage'] <= 45 ? 'danger'   : ''  }}{{  $item['percentage'] > 45 && $item['percentage'] < 75 ? 'warning'   : ''  }}{{  $item['percentage'] >= 75 ? 'success'   : ''  }} w-50">{{ $item['percentage'] ?? ''}} %</small></td>
										<td><small class="badge badge-secondary w-75">{{ $item['time'] ?? ''}}</small></td>
							            <td>
							                <a href="{{url('download/marksheet') }}/{{ $item['admission_id'] }}/{{ $item['exam_id'] }}" target="blank" class="btn btn-primary btn-xs" title="Download Marksheet"><i class="fa fa-download"></i> </a>
							                <a href="{{url('view/marksheet') }}/{{ $item['admission_id'] }}/{{ $item['exam_id'] }}" target="blank" class="btn btn-warning btn-xs" title="View Marksheet"><i class="fa fa-eye"></i> </a>
							                <a href="{{url('answer/key') }}/{{ $item->id }}" class="btn btn-success btn-xs" title="Answer Key"><i class="fa fa-check-square-o"></i> </a>
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
		</div>
	</section>
</div>

@endsection