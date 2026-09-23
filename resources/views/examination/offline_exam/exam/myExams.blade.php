@extends('layout.app')
@section('content')

@php
$examSchedule = DB::table('examination_schedules')->where('branch_id', Session::get('branch_id'))->where('session_id', Session::get('session_id'))->where('class_type_id', Session::get('class_type_id'))->whereNull('deleted_at')->groupBy('exam_id')->get();
@endphp

<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;Examination</h3>
							<div class="card-tools">
								<!--<a href="{{url('admissionView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> <span class="Display_none_mobile"> {{ __('common.View') }} </span></a>-->
								<a href="{{url('dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span> {{ __('common.Back') }} </span></a>
							</div>

						</div>


					</div>
				</div>
				

                
                <div class="col-md-12">
				    <p><i class="fa fa-calendar"></i> Exam Schedule</p>
				</div>
                @if(!empty($examSchedule))		
                <div class="col-12 col-md-12">
                @foreach($examSchedule as $schedule)
                    @php
                       $examss = DB::table('exams')->find($schedule->exam_id);
                    @endphp
                    <div class="col-md-6">
                    <div class="card collapsed-card">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                    <i class="fa fa-calendar mr-1"></i>
                    Exam : {{ $examss->name ?? '' }}
                    </h3>
                    <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fa fa-plus"></i>
                    </button>
                    
                    </div>
                    </div>
                    <div class="card-body" style="">
                 @php
                                        $i = 1;
                                        $examSchedules = DB::table('examination_schedules')
                                            ->where(['exam_id' => $examss->id])
                                            ->where('class_type_id', Session::get('class_type_id'))
                                            ->where('branch_id', Session::get('branch_id'))
                                            ->where('session_id', Session::get('session_id'))->orderBy('date')->orderBy('from_time')
                                            ->whereNull('deleted_at')
                                            ->get();
                                    @endphp
                            @if(count($examSchedules) > 0)
                                <table class="exam-schedule table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Subject Name</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <!--<th>To Time</th>-->
                                        </tr>
                                    </thead>
                                   <tbody>
                                       
                                    @foreach ($examSchedules as $exam)
                                    @php
                                    $subjectData = DB::table('subject')->whereNull('deleted_at')->where('class_type_id', Session::get('class_type_id'))
                                    ->where('id',$exam->subject_id)
                                    ->first();
                                    @endphp
                                        <tr>
                                            <td>{{ $i++ }}.</td>
                                            <td>{{ $subjectData->name }}</td>
                                            <td>{{ $exam->date ? date('d-M-Y', strtotime($exam->date)) : '' }}</td>
                                            <td>
                                                @if (!empty($exam->from_time))
                                                    {{ date('h:i A', strtotime($exam->from_time)) }} - {{ date('h:i A', strtotime($exam->to_time)) }}
                                                @else
                                                    School Time
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                  
                                </table>
                            @endif
                
                    </div>
                    </div>
                    </div>
                @endforeach
                </div>
                @endif
			</div>
		</div>
	</section>

</div>



 <script>
    $(document).ready(function() {
        
        
      // When the image is clicked
      $('.image').click(function() {
        var imageUrl = $(this).attr('src');
        $('#modalImage').attr('src', imageUrl); // Set image in modal
        $('#imageModal').modal('show'); // Show the modal

        // Set download link on download button
        $('#downloadButton').off('click').on('click', function() {
          var link = document.createElement('a');
          link.href = imageUrl;
          link.download = 'downloaded_image.jpg'; // Set the download filename
          link.click();
        });
      });
    });
  </script>


<script>
$(document).ready(function() {
    $('.exam-schedule').each(function() {
        var $table = $(this);
        var rows = $table.find('tbody tr').get();

        rows.sort(function(a, b) {
            var dateA = new Date($(a).find('td:nth-child(3)').text());
            var dateB = new Date($(b).find('td:nth-child(3)').text());
            return dateA - dateB;
        });

        $.each(rows, function(index, row) {
            $table.find('tbody').append(row);
        });
    });
});
</script>

@endsection