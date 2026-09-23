@php
    $getstudents = Helper::getstudents();
    $getgenders = Helper::getgender();
    $classType = Helper::classType();
    $getState = Helper::getState();
    $getCity = Helper::getCity();
    $getCountry = Helper::getCountry();
    $getSetting = Helper::getSetting();
    $bloodGroupType = Helper::bloodGroupType();
    $getMonths = Helper::getMonth();
    $getAttendanceStatus= Helper::getAttendanceStatus();
@endphp
@extends('layout.app')
@section('content')
@php
    $studentCount = DB::table('admissions')->where('deleted_at',null)->count();
@endphp
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-calendar"></i> &nbsp;{{ __('Academic Calendar Add') }}</h3>
							<div class="card-tools">
								<a href="{{url('view_weekend')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> <span class="Display_none_mobile"> {{ __('common.View') }} </span></a>
								<a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile"> {{ __('common.Back') }} </span></a>
							</div>
						</div>
                        <form id="quickForm" action="{{ url('add_weekend') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row m-2">
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __(' Date') }}<span style="color:red;">*</span></label>
										<input type="date" class="form-control invalid" id="date" name="date" placeholder=" Date" value="{{date('Y-m-d')}}" required>
										<span class="invalid-feedback" id="date_invalid" role="alert">
                                            <strong>The  Date field is required</strong>
                                        </span>
									</div>
								</div>
                                <div class="col-md-3">
									<div class="form-group">
									    <label>{{ __('Event/Schedule') }}<span style="color:red;">*</span></label>
										<input type="text" name="event_schedule" id="event_schedule" class="form-control invalid " value="{{ old('event_schedule') }}" placeholder="{{ __('Event/Schedule') }}" required>
										<span class="invalid-feedback" id="event_schedule_invalid" role="alert">
                                            <strong>The Event/Schedule field is required</strong>
                                        </span>
									</div>
								</div>
                                <div class="col-md-3">
								    <label>{{ __('Attendance status for that day') }}<span style="color:red;">*</span></label>
    							    <select class="form-control select2" id="attendance_status" name='attendance_status' required>
                        			    <option value="" >Select</option>
                                        @if(!empty($getAttendanceStatus)) 
                                            @foreach($getAttendanceStatus as $attendance_status)
                                                    <option value="{{ $attendance_status->id ?? '' }}"  @if(!empty($stu_att)) {{ $attendance_status->id == $stu_att->attendance_status_id ? 'selected' : '' }} @endif>{{ $attendance_status->name ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>  
								</div>
                                <div class="col-md-12 text-center mt-5">
								    <button type="submit" class="btn btn-primary" id="submitButton">{{ __('common.submit') }}</button><br><br>
							    </div>
                            </div>
	                    </form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection