@php
$noticeBoard = Helper::noticeBoard();
$getstudentbirthday = Helper::getstudentbirthday();
$task = Helper::task();
$chartAttendanceStudents = Helper::chartAttendanceStudents();
$chartAttendanceTeachers = Helper::chartAttendanceTeachers();
//$getfeesReminder = Helper::getFeesReminders();
$getremark = Helper::getremark();
//$getlibraryfeesReminder = Helper::getlibraryfeesReminder();
//$gethostelReminder = Helper::gethostelReminder();

@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper">
<input type="hidden" id="value">
<input type="hidden" id="value2">
    <section class="content pt-3">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-home"></i> &nbsp;{{ __('Reporting Dashboard')  }}</h3>
                            
                            <div class="card-tools">
                                <!--<a href="{{url('add_user')}}" class="btn btn-primary  btn-sm" title="Add User"><i class="fa fa-plus"></i> Add User</a>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
            <p><i class="fa fa-dot-circle-o"></i> {{ __('Fee Details') }} </p>
            </div>
                <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('fees_reporting') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fa fa-graduation-cap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('Fees Reporting') }}</span>
                                <span class="info-box-number">Enter</span>
                            </div>
                        </div>
                    </a>
                </div>
             
                </div>
                <div class="row">
            <p><i class="fa fa-dot-circle-o"></i> Hostel </p>
            </div>
                <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('hostel_reporting') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fa fa-graduation-cap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Hostel</span>
                                <span class="info-box-number">Enter</span>
                            </div>
                        </div>
                    </a>
                </div>
                 <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{ url('hostel_pending_fees') }}">
                            <div class="info-box mb-3 text-dark">
                                <span class="info-box-icon bg-success elevation-1"><i
                                        class="fa fa-graduation-cap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending Fees</span>
                                    <span class="info-box-number">Enter</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                  
        
        </div>
    </section>

</div>

@endsection