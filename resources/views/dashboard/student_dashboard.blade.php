@extends('layout.app')
@section('content')

@php
    $getSetting = Helper::getSetting();
    $getUser = Helper::getUser();
    $noticeBoard = Helper::noticeBoard();

    $fee_assigned = DB::table('fees_assigns')->where('admission_id', Session::get('id'))->whereNull('deleted_at')->first();
    $fee_collected = DB::table('fees_collect')->where('admission_id', Session::get('id'))->whereNull('deleted_at')->first();
    $fee_pending = (($fee_assigned->total_amount ?? 0) - ($fee_assigned->total_discount ?? 0)) - ($fee_collected->amount ?? 0);
    $pending_approval_fees_count = \App\Models\FeesDetail::where('admission_id', Session::get('id'))
                                    ->where('status', 1) // 1 for pending approval
                                    ->count();
    
@endphp

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row pt-3">
                
                <div class="col-md-12 pr-0 pl-0">
                    <div class="card card-outline card-orange fee-card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-home"></i> &nbsp;Student Dashbaord</h3>
                             <div class="card-tools">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content pt-0">
        <div class="container-fluid">
            <!-- Profile & Quick Stats Row -->
            <div class="row">
                <!-- Profile Card -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" 
                                     src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" 
                                     alt="User profile"
                                     onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                            </div>

                            <h3 class="profile-username text-center">{{ Session::get('name') }}</h3>
                            <p class="text-muted text-center">{{ $getUser['ClassTypes']['name'] ?? 'N/A' }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Admission No.</b> <a class="float-right">{{ $getUser['admissionNo'] ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Roll No.</b> <a class="float-right">{{ $getUser['roll_no'] ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>D.O.B</b> <a class="float-right">{{ date('d-m-Y', strtotime($getUser['dob'])) ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender</b> <a class="float-right">{{ $getUser['Gender']['name'] ?? 'N/A' }}</a>
                                </li>
                            </ul>

                            <!-- <a href="{{ url('profile/edit/'.Session::get('id')) }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a> -->
                        </div>
                    </div>
                </div>

                <!-- Stats Cards & Actions -->
                <div class="col-md-8">
                    <!-- Info boxes -->
                    <div class="row">
                        <!--<div class="col-lg-6">-->
                        <!--    <div class="info-box">-->
                        <!--        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-money"></i></span>-->
                        <!--        <div class="info-box-content">-->
                        <!--            <span class="info-box-text">Fees Pending</span>-->
                        <!--            <span class="info-box-number">-->
                        <!--                @if($fee_pending > 0)-->
                        <!--                    ₹{{ number_format($fee_pending, 2) }}-->
                        <!--                @elseif($pending_approval_fees_count > 0)-->
                        <!--                    <small class="text-warning">Pending Approval</small>-->
                        <!--                @else-->
                        <!--                    <small class="text-success">No Dues</small>-->
                        <!--                @endif-->
                        <!--            </span>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                       
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('student_fees_details') }}/{{ Session::get('id') }}" class="btn btn-outline-primary btn-block btn-sm">
                                        <i class="fa fa-receipt"></i> Fees Details
                                    </a>
                                </div> -->
                                <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('fees_history') }}" class="btn btn-outline-success btn-block btn-sm">
                                        <i class="fa fa-history"></i> Fees History
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('notice_board/view/0') }}" class="btn btn-outline-warning btn-block btn-sm">
                                        <i class="fa fa-bell"></i> Notice Board
                                    </a>
                                </div>
                                <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('addStationaryRequest') }}" class="btn btn-outline-info btn-block btn-sm">
                                        <i class="fa fa-shopping-cart"></i> Store/Stationary
                                    </a>
                                </div>
                                <!-- <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('student_homework') }}" class="btn btn-outline-danger btn-block btn-sm">
                                        <i class="fa fa-book"></i> Homework
                                    </a>
                                </div> -->
                                <!-- <div class="col-6 col-lg-4 mb-2">
                                    <a href="{{ url('timetable') }}" class="btn btn-outline-secondary btn-block btn-sm">
                                        <i class="fa fa-calendar"></i> Timetable
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Section with Tabs -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="personal-tab" data-toggle="pill" href="#personal" role="tab" aria-controls="personal" aria-selected="true">
                                        <i class="fa fa-user"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="parents-tab" data-toggle="pill" href="#parents" role="tab" aria-controls="parents" aria-selected="false">
                                        <i class="fa fa-users"></i> Parents/Guardian
                                    </a>
                                </li>
                                @if(!empty($getUser) && ($getUser->hostel ?? ''))
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="hostel-tab" data-toggle="pill" href="#hostel" role="tab" aria-controls="hostel" aria-selected="false">
                                            <i class="fa fa-home"></i> Hostel Details
                                        </a>
                                    </li> -->
                                @endif
                                @if(!empty($getUser) && ($getUser->library ?? ''))
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="library-tab" data-toggle="pill" href="#library" role="tab" aria-controls="library" aria-selected="false">
                                            <i class="fa fa-book"></i> Library
                                        </a>
                                    </li> -->
                                @endif
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="fees-tab" data-toggle="pill" href="#fees" role="tab" aria-controls="fees" aria-selected="false">
                                        <i class="fa fa-money-check"></i> Fees
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <!-- Personal Details Tab -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <td width="25%"><b>Mobile Number</b></td>
                                                    <td width="25%">{{ $getUser['mobile'] ?? 'N/A' }}</td>
                                                    <td width="25%"><b>E-Mail</b></td>
                                                    <td width="25%">{{ $getUser['email'] ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Address</b></td>
                                                    <td>{{ $getUser['address'] ?? 'N/A' }}</td>
                                                    <td><b>Aadhaar No.</b></td>
                                                    <td>{{ $getUser->aadhaar ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Blood Group</b></td>
                                                    <td>{{ $getUser->blood_group_type_id ?? 'N/A' }}</td>
                                                    <td><b>Category</b></td>
                                                    <td>{{ $getUser->caste_categories_id ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Country</b></td>
                                                    <td>{{ $getUser['Country']['name'] ?? 'N/A' }}</td>
                                                    <td><b>State</b></td>
                                                    <td>{{ $getUser['State']['name'] ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>City</b></td>
                                                    <td>{{ $getUser['City']['name'] ?? 'N/A' }}</td>
                                                    <td><b>Pincode</b></td>
                                                    <td>{{ $getUser->pincode ?? 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Parents Tab -->
                                <div class="tab-pane fade" id="parents" role="tabpanel" aria-labelledby="parents-tab">
                                    <div class="row">
                                        @if(!empty($getUser['father_name']))
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header with-border">
                                                        <h3 class="card-title">Father's Details</h3>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <img class="img-circle" width="100" height="100"
                                                             src="{{ env('IMAGE_SHOW_PATH').'/father_image/'.$getUser['father_img'] }}" 
                                                             onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                                                        <hr>
                                                        <table class="table table-sm table-bordered">
                                                            <tr>
                                                                <td><b>Name</b></td>
                                                                <td>{{ $getUser['father_name'] ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Contact No</b></td>
                                                                <td>{{ $getUser['father_mobile'] ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($getUser['mother_name']))
                                            <div class="col-lg-6 col-md-12">
                                                <div class="card card-danger">
                                                    <div class="card-header with-border">
                                                        <h3 class="card-title">Mother's Details</h3>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <img class="img-circle" width="100" height="100"
                                                             src="{{ env('IMAGE_SHOW_PATH').'/mother_image/'.$getUser['mother_img'] }}" 
                                                             onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                                                        <hr>
                                                        <table class="table table-sm table-bordered">
                                                            <tr>
                                                                <td><b>Name</b></td>
                                                                <td>{{ $getUser['mother_name'] ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Contact No</b></td>
                                                                <td>{{ $getUser['mother_mobile'] ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Hostel Tab -->
                                @if(!empty($getUser) && ($getUser->hostel ?? ''))
                                    <!-- <div class="tab-pane fade" id="hostel" role="tabpanel" aria-labelledby="hostel-tab">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td width="35%"><b>Hostel Name</b></td>
                                                            <td>{{ $hostelDeatils['hostel_name'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Building</b></td>
                                                            <td>{{ $hostelDeatils['building_name'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Floor</b></td>
                                                            <td>{{ $hostelDeatils['floor_name'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Room</b></td>
                                                            <td>{{ $hostelDeatils['room_name'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Bed No.</b></td>
                                                            <td>{{ $hostelDeatils['bed_name'] ?? 'N/A' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> -->
                                @endif

                                <!-- Library Tab -->
                                @if(!empty($getUser) && ($getUser->library ?? ''))
                                    <!-- <div class="tab-pane fade" id="library" role="tabpanel" aria-labelledby="library-tab">
                                        @if(!empty($libraryDetails))
                                            <div class="row">
                                                @foreach ($libraryDetails as $time)
                                                    <div class="col-lg-6 col-md-12 mb-3">
                                                        <div class="card card-info">
                                                            <div class="card-header with-border">
                                                                <h5 class="card-title">{{ $time->study_time ?? 'N/A' }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <span class="badge {{ date('Y-m-d') <= $time['renew_date'] ? 'badge-success' : 'badge-danger' }}">
                                                                    Valid Till: {{ date('d-M-Y', strtotime($time['renew_date'])) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> No library plans available
                                            </div>
                                        @endif
                                    </div> -->
                                @endif

                                <!-- Fees Tab -->
                                <!-- <div class="tab-pane fade" id="fees" role="tabpanel" aria-labelledby="fees-tab">
                                    <h5 class="mb-3"><b>Fee Structure</b></h5>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th>Fee Group</th>
                                                    <th style="width: 20%">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($result['school_fees']))
                                                    @foreach ($result['school_fees'] as $item)
                                                        <tr>
                                                            <td>{{ $item['group_name'] ?? 'N/A' }}</td>
                                                            <td><b>₹{{ number_format($item['amount'] ?? 0, 2) }}</b></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if(!empty($result['hostel_fees']))
                                                    @foreach ($result['hostel_fees'] as $item)
                                                        <tr>
                                                            <td>Hostel Fees</td>
                                                            <td><b>₹{{ number_format($item['hostel_fees'] ?? 0, 2) }}</b></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if(!empty($result['library_fees']))
                                                    @foreach ($result['library_fees'] as $item)
                                                        <tr>
                                                            <td>Library Fees</td>
                                                            <td><b>₹{{ number_format($item['library_fees'] ?? 0, 2) }}</b></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <h5 class="mb-3"><b>Payment History</b></h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th>Fee Type</th>
                                                    <th>Amount</th>
                                                    <th>Payment Date</th>
                                                    <th>Payment Mode</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($result['feesDetail']))
                                                    @foreach ($result['feesDetail'] as $item)
                                                        <tr>
                                                            <td>
                                                                @if($item['fees_type'] == 0)
                                                                    <span class="badge badge-primary">School</span>
                                                                @elseif($item['fees_type'] == 1)
                                                                    <span class="badge badge-warning">Hostel</span>
                                                                @elseif($item['fees_type'] == 2)
                                                                    <span class="badge badge-info">Library</span>
                                                                @endif
                                                            </td>
                                                            <td><b>₹{{ number_format($item['total_amount'] ?? 0, 2) }}</b></td>
                                                            <td>{{ date('d-M-Y', strtotime($item['date'] ?? '')) }}</td>
                                                            <td><span class="badge badge-success">{{ $item['PaymentMode']['name'] ?? 'N/A' }}</span></td>
                                                            <td>
                                                                <a href="{{ url('print_payement', $item->id) }}" target="_blank" class="btn btn-xs btn-info">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">
                                                            <i class="fa fa-info-circle"></i> No payment records found
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice Board -->
            @if(count($noticeBoard) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="card-header with-border">
                                <h3 class="card-title"><i class="fa fa-bell"></i> Notice Board</h3>
                            </div>
                            <div class="card-body">
                                @foreach($noticeBoard as $item)
                                    <div class="callout callout-info border-left-warning mb-3">
                                        <a href="{{ url('notice_board/view', $item->id) }}" style="text-decoration: none; color: inherit;">
                                            <h5>{!! html_entity_decode($item->title ?? '', ENT_QUOTES, 'UTF-8') !!}</h5>
                                            <p>{!! html_entity_decode($item->message ?? '', ENT_QUOTES, 'UTF-8') !!}</p>
                                            <small><span class="badge badge-danger"><i class="fa fa-star"></i> New</span></small>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

@endsection