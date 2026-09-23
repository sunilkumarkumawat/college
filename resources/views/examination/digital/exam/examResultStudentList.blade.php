@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
  $date = date('Y-m-d');
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
							<h3 class="card-title"><i class="nav-icon fas fa fa-leanpub"></i> &nbsp;{{ __('examination.Exams View') }} - {{$exam_data->name ?? ''}}</h3>
							<div class="card-tools"> 
							    <a href="{{url('digital/view/exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a> 
                                
                            </div>
						</div>
						<div class="card-body">

							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead>
									<tr role="row">
										<th>{{ __('common.SR.NO') }}</th>
										<th>{{ __('Student Name') }} </th>
										<th>{{ __('Mobile') }} </th>
										<th>{{ __('DateTime') }} </th>
										<th>{{ __('Given DateTime') }} </th>
										<th>{{ __('Total Question') }} </th>
										<th>{{ __('Correct') }} </th>
										<th>{{ __('Wrong') }} </th>
										<th>{{ __('Skip') }} </th>
										<th>{{ __('Time') }} </th>
										<th>{{ __('Result') }} </th>
										<th>{{ __('Exam Repeat') }} </th>
									
								</thead>
								<tbody> 
								@if(!empty($data)) 
    								@php 
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)
								
								@php
								 $percentage = (((($item->correct_ans ?? 0)*4) + (($item->wrong_ans ?? 0)*-1))/(($item->total_ques ?? 0)*4))*100;
								 if($percentage < 0)
                                                           {
                                                           $percentage =0;
                                                           }
								@endphp
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item->first_name ?? '' }}</td>
										<td>{{ $item->mobile ?? '' }}</td>
										<td>{{  date('d-m-Y h:i A', strtotime($exam_data->exam_date ?? '')) }}</td>
										<td>{{  date('d-m-Y h:i A', strtotime($item->created_at ?? '')) }}</td>
										<td>{{  $item->total_ques ?? ''  }}</td>
										<td>{{  $item->correct_ans ?? ''  }}</td>
										<td>{{  $item->wrong_ans ?? ''  }}</td>
										<td>{{  $item->skip_ques ?? ''  }}</td>
										<td>{{  $item->time ?? ''  }} </td>
										<td class="{{$percentage < 40 ? 'bg-danger' : ''}} {{$percentage > 40 && $percentage < 70  ? 'bg-warning' : ''}}{{$percentage > 70 ? 'bg-success' : ''}}">{{  $percentage ?? 0  }}%</td>
							            <td>
							                @php
							                $repeat = DB::table('exam_results_digital')->where('admission_id',$item->admission_id)->where('exam_id',$item->exam_id)->whereNull('deleted_at')->count();
							                @endphp
							                
							                @if($repeat > 0)
							                
							                <form action="{{url('analysisPanel')}}" target="_blank" method="post">
							                    
							                    @csrf
							                    
							                    <input type='hidden' value='{{$item->exam_id ?? ''}}' name='exam_id' />
							                    <input type='hidden' value='request_from_admin' name='request_from_admin' />
							                    <input type='hidden' value='{{$item->admission_id ?? ''}}' name='admission_id' />
							                    <button class='btn btn-primary' type="submit"> {{$repeat ?? 0}} times</button>
							                </form>
							                
							                @else
							               {{$repeat ?? 0}} times
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


@endsection