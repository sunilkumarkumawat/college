
@extends('layout.app') 
@section('content')

<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">						    
							<h3 class="card-title"><i class="nav-icon fas fa fa-trash"></i> &nbsp;View Deleted Exam</h3>
							<div class="card-tools"> 
							    <a href="{{url('digital/add/exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-plus"></i> {{ __('common.Add') }} </a> 
							    <a href="{{url('digital/view/exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a> 
                            </div>
						</div>
						<div class="card-body">

							<table id="example1" class="table table-bordered table-striped  dataTable">
								<thead>
									<tr role="row">
										<th>{{ __('common.SR.NO') }}</th>
										<th>{{ __('examination.Exam') }} </th>
										<th>Delete Date</th>
										<th>Deleted By</th>
										<th>{{ __('common.Action') }}</th>
								</thead>
								<tbody> 
								@if(!empty($data)) 
    								@php 
    								    $i=1;
    								@endphp 
								@foreach ($data as $item)
								    @php
								    $user = DB::table('users')->where('id', $item->user_id)->whereNull('deleted_at')->first();
								    @endphp
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $item->name ?? ''}} </td>
										<td>{{date('d-m-Y, h:i:s A, l', strtotime($item->deleted_at)) ?? '' }}</td>
										<td><span class="text-danger"><small>{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</small></span></td>
							            <td>
							                <!--<a href="{{url('print/exam') }}/{{ $item->id ?? '' }}" target="_blank" class="btn btn-success btn-xs ml-3" title="Download AnswerKey"><i class="fa fa-download"></i></a>
                                            <a href="{{url('print/exam') }}/{{ $item->id ?? '' }}" target="_blank" class="btn btn-info btn-xs ml-3" title="Print Exam"><i class="fa fa-print"></i></a>-->
											<a href="javascript:;" data-id='{{$item->id ?? '' }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="restoreData btn btn-danger btn-xs ml-3" title="Restore Exam"><i class="fa fa-history"></i></a> 
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



<!-- The Modal -->
<div class="modal" id="Modal_id">
	<div class="modal-dialog">
		<div class="modal-content" style="background: #555b5beb;">
			<div class="modal-header">
				<h4 class="modal-title text-white">Restore Confirmation</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
			<input type="hidden" id="exam_id1" >
			<form action="{{ url('digital/restore/exam') }}" method="post"> 
			    @csrf
				<div class="modal-body">
					<input type=hidden id="restore_id" name="restore_id">
					<h5 class="text-white">Are you sure you want to Restore this Exam ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{__('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">Restore</button>
				</div>
			</form>
		</div>
	</div>
</div> 


<script>
$('.restoreData').click(function() {
	var restore_id = $(this).data('id');
	$('#restore_id').val(restore_id);
});
</script>
@endsection