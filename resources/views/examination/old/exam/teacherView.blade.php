
@extends('layout.app') 
@section('content')

@php

@endphp
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
							<h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp; {{ __('examination.View Exam Results') }}</h3>
						@endif
							<div class="card-tools"> 
                                <a href="{{url('examination_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('messages.Back') }}</a> 
                            </div>
						</div>

                    <form id="quickForm" action="{{ url('view/result') }}" method="post" >
                        @csrf 
                    <div class="row m-2">

            		<div class="col-md-5">
            			<div class="form-group">
            				<label>{{ __('messages.Search By Keywords') }}</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="Search by keywords" value="{{ $search['name'] ?? '' }}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1 ">
                             <label for="" class="text-white">Search</label>
                    	    <button type="submit" class="btn btn-primary">{{ __('messages.Search') }}</button>
                    	</div>
                    			
                    </div>
                </form> 
                <div class="row m-2">
                    <div class="col-md-12">
							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead>
									<tr role="row">
										<th>{{ __('messages.Sr.No.') }}</th>
										<th>{{ __('examination.Exam') }} </th>
										<th>{{ __('examination.Exam Date') }}</th>
										<th>{{ __('Class Name') }}</th>
										<th>{{ __('student.Student Name') }}</th>
										<th>{{ __('Total Ques') }}</th>
										<th>{{ __('Correct Ans') }}</th>
										<th>{{ __('Wrong Ans') }}</th>
										<th>{{ __('Skip Ans') }}</th>
										<th>{{ __('Time') }}</th>
										<th>{{ __('examination.Result (%)') }}</th>
										<th>{{ __('messages.Action') }}</th>
								</thead>
								<tbody> 
								@if(!empty($data)) 
    								@php 
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)
								  
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item['exam_name'] ?? ''}}</td>
										<td>{{ $item['exam_date'] ?? ''}}</td>
																	<td>{{ $item['class_name'] ?? ''}}</td>
										<td>{{ $item['student_fname'] ?? ''}} {{ $item['student_lname'] ?? ''}}</td>
			
							            <td><small class="badge badge-primary w-25">{{ $item['total_ques'] ?? ''}}</small></td>
							            <td><small class="badge badge-success w-25">{{ $item['correct_ans'] ?? ''}}</small></td>
							            <td><small class="badge badge-danger w-25">{{ $item['wrong_ans'] ?? ''}}</small></td>
							            <td><small class="badge badge-warning w-25">{{ $item['skip_ques'] ?? ''}}</small></td>
							            <td><small class="badge badge-secondary ">{{ $item['time'] ?? ''}}</small></td>
							            <td><small class="badge badge-{{  $item['percentage'] < 45 ? 'danger'   : ''  }}{{  $item['percentage'] > 45 && $item['percentage'] < 75 ? 'warning'   : ''  }}{{  $item['percentage'] >= 75 ? 'success'   : ''  }} w-50">{{ number_format($item['percentage'], 2) ?? '' }} %</small></td>
							            <td>
							                <a href="{{url('answer/key') }}/{{$item->exam_id}}/{{$item->admission_id}}" class="btn btn-primary btn-xs" title="View Result"> &nbsp;Detail View </a>
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