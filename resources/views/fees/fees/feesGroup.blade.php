@php
$getPermission = Helper::getPermission();
$getSession = Helper::getSession();
$classType = Helper::classType();
@endphp

@extends('layout.app') 
@section('content')

<style>
/* Clean & High-Contrast Compact Styles */
.course-selector-box {
    background: #f0f7ff !important;
    border: 1px solid #b8daff !important;
    border-radius: 6px;
    padding: 8px 10px;
    margin-bottom: 10px;
}
.mode-toggle-btn {
    flex: 1;
    padding: 6px 8px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
    border: 1px solid #ced4da;
    background: #ffffff;
    color: #333333;
    cursor: pointer;
    transition: all 0.2s ease;
}
.mode-toggle-btn.active {
    background: #002c54 !important;
    color: #ffffff !important;
    border-color: #002c54 !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
.mode-toggle-btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.mode-toggle-btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
.quick-preset-btn {
    display: inline-block;
    padding: 2px 7px;
    margin: 2px 1px;
    font-size: 10.5px;
    font-weight: 600;
    border-radius: 10px;
    border: 1px solid #b8daff;
    background: #eef6ff;
    color: #004085;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
}
.quick-preset-btn:hover {
    background: #002c54;
    color: #ffffff;
    border-color: #002c54;
}
.preview-badge {
    display: inline-block;
    padding: 3px 7px;
    margin: 2px 1px;
    font-size: 10.5px;
    font-weight: 600;
    border-radius: 4px;
    background: #ffffff;
    color: #004085;
    border: 1px solid #99caff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.preview-box-container {
    background: #ffffff;
    border: 1px solid #c2d4ea;
    border-radius: 5px;
    padding: 8px;
}
.preview-header {
    background: #e8f2fc;
    color: #002c54;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 8px;
    border-radius: 4px;
    margin-bottom: 6px;
}
.fee-master-amount-box {
    background: #fffdf5;
    border: 1px solid #ffeeba;
    border-radius: 5px;
    padding: 8px 10px;
    margin-top: 8px;
    margin-bottom: 8px;
}
.badge-academic { background-color: #007bff; color: #fff; }
.badge-examination { background-color: #fd7e14; color: #fff; }
.badge-practical { background-color: #17a2b8; color: #fff; }
.badge-admission { background-color: #6f42c1; color: #fff; }
.badge-facility { background-color: #20c997; color: #fff; }
.badge-refundable { background-color: #28a745; color: #fff; }
.badge-hostel_transport { background-color: #e83e8c; color: #fff; }
.badge-other { background-color: #6c757d; color: #fff; }

.padding_table thead tr th {
    background: #002c54 !important;
    color: #ffffff !important;
    font-size: 11.5px !important;
    padding: 6px 8px !important;
    font-weight: 600 !important;
}
.padding_table td {
    padding: 5px 8px !important;
    font-size: 11.5px !important;
    vertical-align: middle !important;
    color: #212529 !important;
}
.filter-box-custom {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 6px;
    padding: 8px 10px;
}
.filter-label-custom {
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
/* Header & Tab alignment */
.card-header::after {
    display: none !important;
}
.card-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    min-height: 40px !important;
    padding: 5px 10px !important;
}
.card-header .nav-pills {
    margin: 0 !important;
}
.card-header .nav-pills .nav-link {
    margin: 0 !important;
}
.card-header .card-tools {
    margin: 0 !important;
}
</style>

<div class="content-wrapper">
    <section class="content pt-2">
        <div class="container-fluid">
            <div class="row">   
                <!-- Left Side: Create Fee Heads & Assign to Fees Master -->
                <div class="col-md-5 pr-0 {{($getPermission->add == 1) ? '' : 'd-none'}}">
                    <div class="card card-outline card-orange mr-1">
                        <div class="card-header bg-primary py-2">
                            <h3 class="card-title font-weight-bold" style="font-size:14px;"><i class="fa fa-money"></i> &nbsp;Fee Structure & Heads Setup</h3>
                            <div class="card-tools">
                                <span class="badge badge-light" style="font-size:10px;">Unified Setup</span>
                            </div>
                        </div>                 
                        
                        <div class="card-body p-2">
                            <!-- Course Auto-Detect Box -->
                            <div class="course-selector-box" id="course_selector_box">
                                <label class="font-weight-bold text-primary mb-1 d-flex justify-content-between align-items-center" style="font-size:11.5px;">
                                    <span><i class="fa fa-graduation-cap"></i> Select Course (Auto-Detects Semesters / Years): <span class="text-danger" id="course_req_star">*</span></span>
                                    <span class="badge badge-primary px-2" id="course_mode_badge" style="font-size: 10px;">Required</span>
                                </label>
                                <select class="form-control form-control-sm select2 font-weight-bold" id="course_selector" onchange="onCourseSelected(this)">
                                    <option value="">-- Select Course (e.g. BA, BSc, B.Ed) --</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $c)
                                            @php
                                                $cType = !empty($c->course_type) ? $c->course_type : 'Semester';
                                                $dur = !empty($c->duration) ? (int)$c->duration : 3;
                                                $totSem = !empty($c->total_semester) && (int)$c->total_semester > 0 ? (int)$c->total_semester : ($dur * 2);
                                            @endphp
                                            <option value="{{ $c->id }}" 
                                                data-name="{{ $c->name }}" 
                                                data-type="{{ strtolower($cType) }}" 
                                                data-duration="{{ $dur }}" 
                                                data-semesters="{{ $totSem }}">
                                                {{ $c->name }} &nbsp; [{{ ($cType == 'Yearly') ? ($dur . ' Year(s) - Yearly') : ($totSem . ' Semesters') }}]
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="course_detected_info" class="text-success mt-1 font-weight-bold" style="font-size:10.5px; display:none;">
                                    <i class="fa fa-check-circle"></i> <span id="course_detected_text"></span>
                                </div>
                            </div>

                            <!-- Structure Mode Selector -->
                            <label class="font-weight-bold mb-1 text-muted" style="font-size:11px;">Structure Mode:</label>
                            <div class="d-flex mb-2">
                                <div class="mode-toggle-btn active" id="btn_mode_semester" onclick="switchMode('semester')">
                                    <i class="fa fa-graduation-cap"></i> Semester-Wise<br><small style="font-size:9.5px;">(All Semesters)</small>
                                </div>
                                <div class="mode-toggle-btn" id="btn_mode_single_class" onclick="switchMode('single_class')">
                                    <i class="fa fa-book"></i> Single Class<br><small style="font-size:9.5px;">(1 Class / Sem)</small>
                                </div>
                                <div class="mode-toggle-btn" id="btn_mode_single_head" onclick="switchMode('single_head')">
                                    <i class="fa fa-tag"></i> Fee Head Only<br><small style="font-size:9.5px;">(No Class)</small>
                                </div>
                            </div>

                            <form id="quickForm" action="{{ url('feesGroup') }}" method="post">
                                @csrf
                                <input type="hidden" name="mode" id="form_mode" value="semester">

                                <!-- MODE 1: ALL SEMESTERS (BATCH) -->
                                <div id="section_semester">
                                    <!-- Notice shown when NO course is selected -->
                                    <div id="course_required_notice" class="p-3 text-center border rounded bg-white my-2" style="border: 1.5px dashed #007bff !important; border-radius: 6px;">
                                        <i class="fa fa-graduation-cap text-primary" style="font-size: 28px;"></i>
                                        <h6 class="font-weight-bold text-dark mt-2 mb-1" style="font-size: 13px;">Please Select a Course Above</h6>
                                        <p class="text-muted mb-0" style="font-size: 11px;">
                                            Select a Course from the dropdown above (e.g. <strong>BA, BSc, B.Ed</strong>) to auto-detect semesters and generate class-wise fee structure.
                                        </p>
                                    </div>

                                    <!-- Controls shown when a course is selected -->
                                    <div id="section_semester_controls" style="display: none;">
                                        <div class="form-group mb-2">
                                            <label class="font-weight-bold text-dark mb-1" style="font-size:11.5px;">Fee Head Base Name*</label>
                                            <div class="mb-1">
                                                <span class="quick-preset-btn" onclick="setSemBase('Tuition Fee', 'academic')">Tuition Fee</span>
                                                <span class="quick-preset-btn" onclick="setSemBase('Semester Exam Fee', 'examination')">Exam Fee</span>
                                                <span class="quick-preset-btn" onclick="setSemBase('Practical / Lab Fee', 'practical')">Practical Fee</span>
                                                <span class="quick-preset-btn" onclick="setSemBase('Development Fee', 'academic')">Development Fee</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm font-weight-bold" id="sem_base_name" value="Tuition Fee" placeholder="e.g. Tuition Fee, Exam Fee" oninput="updateSemPreview()">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="font-weight-bold mb-1" style="font-size:11px;">Total Semesters / Years*</label>
                                                    <select class="form-control form-control-sm font-weight-bold" id="sem_count" onchange="updateSemPreview()">
                                                        <option value="1">1 Semester</option>
                                                        <option value="2">2 Semesters (1 Year)</option>
                                                        <option value="3">3 Semesters</option>
                                                        <option value="4">4 Semesters (2 Years)</option>
                                                        <option value="5">5 Semesters</option>
                                                        <option value="6" selected>6 Semesters (3 Years)</option>
                                                        <option value="7">7 Semesters</option>
                                                        <option value="8">8 Semesters (4 Years)</option>
                                                        <option value="9">9 Semesters</option>
                                                        <option value="10">10 Semesters (5 Years)</option>
                                                        <option value="12">12 Semesters (6 Years)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="font-weight-bold mb-1" style="font-size:11px;">Category</label>
                                                    <select class="form-control form-control-sm" name="group_type" id="sem_group_type">
                                                        <option value="academic" selected>Academic (Tuition / University)</option>
                                                        <option value="examination">Examination</option>
                                                        <option value="practical">Laboratory & Practical</option>
                                                        <option value="facility">Campus Facility & Library</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fees Master Assignment Settings (Default Amount) -->
                                        <div class="fee-master-amount-box">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold text-dark mb-1" style="font-size:11.5px;">
                                                    <i class="fa fa-check-square-o text-success"></i> Default Amount (Applied to all semesters):
                                                </label>
                                                <input type="text" class="form-control form-control-sm font-weight-bold text-success" id="batch_common_amount" placeholder="e.g. 15000" value="15000" oninput="syncCommonAmount(this.value)" onkeypress="javascript:return isNumber(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODE 2: SINGLE CLASS ASSIGNMENT -->
                                <div id="section_single_class" style="display: none;">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold mb-1" style="font-size:11px;">Select Class / Semester*</label>
                                        <select class="form-control form-control-sm select2 font-weight-bold" name="single_class_type_id" id="single_class_type_id" onchange="updateSingleClassPreview()">
                                            <option value="">-- Select Class / Semester --</option>
                                            @if(!empty($classType))
                                                @foreach($classType as $cl)
                                                    <option value="{{ $cl->id }}" data-course-id="{{ $cl->course_id }}">{{ $cl->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold text-dark mb-1" style="font-size:11.5px;">Fee Head Name*</label>
                                        <div class="mb-1">
                                            <span class="quick-preset-btn" onclick="setSingleClassName('Tuition Fee', 'academic')">Tuition Fee</span>
                                            <span class="quick-preset-btn" onclick="setSingleClassName('Admission Fee', 'admission')">Admission Fee</span>
                                            <span class="quick-preset-btn" onclick="setSingleClassName('Caution Money (Refundable)', 'refundable')">Caution Money</span>
                                            <span class="quick-preset-btn" onclick="setSingleClassName('Semester Exam Fee', 'examination')">Exam Fee</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm font-weight-bold" id="single_class_fee_name" name="name" placeholder="e.g. Tuition Fee, Admission Fee" oninput="updateSingleClassPreview()">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold mb-1" style="font-size:10.5px;">Amount (₹)*</label>
                                                <input type="text" class="form-control form-control-sm font-weight-bold text-success" name="single_amount" id="single_class_amount" placeholder="Amount (₹)" oninput="updateSingleClassPreview()" onkeypress="javascript:return isNumber(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold mb-1" style="font-size:10.5px;">Due Date</label>
                                                <input type="date" class="form-control form-control-sm" name="single_due_date" id="single_class_due_date">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold mb-1" style="font-size:11px;">Category</label>
                                        <select class="form-control form-control-sm" name="group_type" id="single_class_group_type">
                                            <option value="academic">Academic (Tuition / University)</option>
                                            <option value="admission">Admission & Registration</option>
                                            <option value="examination">Examination</option>
                                            <option value="practical">Laboratory & Practical</option>
                                            <option value="facility">Campus Facility & Library</option>
                                            <option value="refundable">Refundable Deposit (Caution Money)</option>
                                            <option value="hostel_transport">Hostel & Transport</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- MODE 3: SINGLE FEE HEAD ONLY -->
                                <div id="section_single_head" style="display: none;">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold text-dark mb-1" style="font-size:11.5px;">Fee Head Name*</label>
                                        <div class="mb-1">
                                            <span class="quick-preset-btn" onclick="setHeadOnly('Admission Fee', 'admission', 'no')">Admission Fee</span>
                                            <span class="quick-preset-btn" onclick="setHeadOnly('Caution Money (Refundable)', 'refundable', 'yes')">Caution Money</span>
                                            <span class="quick-preset-btn" onclick="setHeadOnly('Library Security Deposit', 'refundable', 'yes')">Library Deposit</span>
                                            <span class="quick-preset-btn" onclick="setHeadOnly('Hostel & Mess Fee', 'hostel_transport', 'no')">Hostel Fee</span>
                                            <span class="quick-preset-btn" onclick="setHeadOnly('Transportation Fee', 'hostel_transport', 'no')">Transport Fee</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="head_only_name" name="name" placeholder="e.g. Admission Fee, Caution Money" oninput="updateHeadOnlyPreview()">
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold mb-1" style="font-size:11px;">Category</label>
                                        <select class="form-control form-control-sm" name="group_type" id="head_only_group_type">
                                            <option value="admission">Admission & Registration</option>
                                            <option value="refundable">Refundable Deposit</option>
                                            <option value="academic">Academic</option>
                                            <option value="examination">Examination</option>
                                            <option value="practical">Laboratory & Practical</option>
                                            <option value="facility">Campus Facility & Library</option>
                                            <option value="hostel_transport">Hostel & Transport</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-2 p-2 border rounded bg-white">
                                                <input type="checkbox" id="head_only_refund" onchange="updateHeadOnlyRefund(this)">
                                                <label for="head_only_refund" class="font-weight-normal mb-0 pointer" style="font-size:11px;">Refundable Fee</label>
                                                <input type="hidden" id="fees_refund" name="fees_refund" value="no">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-2 p-2 border rounded bg-white">
                                                <input type="checkbox" id="head_only_partial" onchange="updateHeadOnlyPartial(this)">
                                                <label for="head_only_partial" class="font-weight-normal mb-0 pointer" style="font-size:11px;">Partial (50%)</label>
                                                <input type="hidden" id="fees_partial" name="fees_partial" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Batch Inputs for Form Submission -->
                                <div id="batch_inputs_container"></div>

                                <!-- Live Clean Preview Box (High Contrast & Editable) -->
                                <div class="preview-box-container mt-2 mb-2" id="preview_box_container" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center preview-header">
                                        <span><i class="fa fa-pencil-square-o text-primary"></i> <span id="preview_title">Fee Heads & Structure Preview:</span></span>
                                        <span class="badge badge-primary px-2" id="preview_count_badge">6 Semesters</span>
                                    </div>
                                    <div id="preview_box">
                                        <!-- dynamic badges/rows -->
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm btn-block font-weight-bold py-2 shadow-sm" id="submit_btn">
                                    <i class="fa fa-check-circle"></i> Save Fee Structure & Heads
                                </button>
                            </form>
                        </div>
                    </div>          
                </div>
                
                <!-- Right Side: Unified Tabs for Fees Master & Fee Heads List -->
                <div class="{{($getPermission->add == 1) ? 'col-md-7 pl-0' : 'col-md-12 pl-0'}}">
                    <div class="card card-outline card-orange ml-1">
                        <!-- Compact Single-Line Tab & Action Header -->
                        <div class="card-header bg-primary px-2 py-1 d-flex align-items-center justify-content-between flex-nowrap" style="min-height: 40px !important;">
                            <ul class="nav nav-pills d-inline-flex m-0 p-0 align-items-center flex-nowrap" id="feesTab" role="tablist" style="gap: 6px;">
                                <li class="nav-item m-0">
                                    <a class="nav-link active font-weight-bold py-1 px-3 shadow-none text-nowrap" id="fees-master-tab" data-toggle="pill" href="#tab_fees_master" role="tab" style="background:#ffffff; color:#002c54 !important; border-radius:4px; font-size:11.5px; border:1px solid #ffffff; cursor:pointer;">
                                        <i class="fa fa-table"></i> Class-wise Fees Master
                                    </a>
                                </li>
                                <li class="nav-item m-0">
                                    <a class="nav-link font-weight-bold py-1 px-3 shadow-none text-nowrap" id="fees-group-tab" data-toggle="pill" href="#tab_fees_group" role="tab" style="background:rgba(255,255,255,0.2); color:#ffffff !important; border-radius:4px; font-size:11.5px; border:1px solid rgba(255,255,255,0.4); cursor:pointer;">
                                        <i class="fa fa-list"></i> All Fee Heads
                                    </a>
                                </li>
                            </ul>
                            <div class="m-0 p-0 ml-auto" style="flex-shrink: 0;">
                                <a href="{{url('fee_dashboard')}}" class="btn btn-light btn-xs font-weight-bold py-1 px-2 shadow-none text-nowrap" style="font-size:11px; color:#002c54;"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
                            </div>
                        </div>  
                        
                        <div class="card-body p-2">
                            <div class="tab-content" id="feesTabContent">
                                <!-- TAB 1: FEES MASTER (CLASS-WISE FEES STRUCTURE) -->
                                <div class="tab-pane fade show active" id="tab_fees_master" role="tabpanel">
                                    <!-- Search Filter for Fees Master -->
                                    <form method="GET" action="{{ url('feesGroup') }}" class="mb-2 filter-box-custom">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="filter-label-custom">Session</label>
                                                <select class="form-control form-control-sm bg-white" name="session_id">
                                                    <option value="all" {{ (($search['session_id'] ?? '') == 'all') ? 'selected' : '' }}>All Sessions</option>
                                                    @if(!empty($getSession))
                                                        @foreach($getSession as $ses)
                                                            <option value="{{ $ses->id }}" {{ (($search['session_id'] ?? Session::get('session_id')) == $ses->id) ? 'selected' : '' }}>{{ $ses->from_year ?? '' }} - {{ $ses->to_year ?? '' }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="filter-label-custom">Course</label>
                                                <select class="form-control form-control-sm bg-white" name="course_id" id="filter_course_id">
                                                    <option value="">All Courses</option>
                                                    @if(!empty($courses))
                                                        @foreach($courses as $c)
                                                            <option value="{{ $c->id }}" {{ (($search['course_id'] ?? '') == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="filter-label-custom">Class / Sem</label>
                                                <select class="form-control form-control-sm bg-white" name="class_type_id" id="filter_class_type_id">
                                                    <option value="">All Classes</option>
                                                    @if(!empty($classType))
                                                        @foreach($classType as $cl)
                                                            <option value="{{ $cl->id }}" {{ (($search['class_type_id'] ?? '') == $cl->id) ? 'selected' : '' }}>{{ $cl->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="filter-label-custom">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-sm btn-block py-1"><i class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Table: Fees Master Assigned to Classes -->
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                                            <thead>
                                                <tr role="row">
                                                    <th width="30px">#</th>
                                                    <th width="140px">{{ __('messages.Class') }} / Semester</th>
                                                    <th>Assigned Fee Structure (Head | Amount | Due Date)</th>
                                                    @if($getPermission->edit == 1)
                                                    <th width="45px" class="text-center">{{ __('messages.Action') }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($feesMasterList))
                                                    @php $k = 1; @endphp
                                                    @foreach ($feesMasterList as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $k++ }}</td>
                                                            <td><strong class="text-primary">{{ $item['ClassTypes']['name'] ?? '' }}</strong></td>
                                                            <td style="padding: 2px;">
                                                                @php
                                                                    $rowSessionId = $item->session_id ?? Session::get('session_id');
                                                                    $allData = DB::table('fees_master')
                                                                        ->leftjoin('fees_group', 'fees_group.id', '=', 'fees_master.fees_group_id')
                                                                        ->select('fees_master.amount', 'fees_group.name as fees_group_name', 'fees_master.id', 'fees_master.fees_group_id', 'fees_master.installment_due_date')
                                                                        ->where('class_type_id', $item->class_type_id)
                                                                        ->where('fees_master.session_id', $rowSessionId)
                                                                        ->whereNull('fees_master.deleted_at')
                                                                        ->get();
                                                                @endphp
                                                                <table width="100%" class="table table-sm table-borderless mb-0">
                                                                    @foreach ($allData as $mydata)
                                                                        <tr style="border-bottom: 1px dashed #dee2e6;">
                                                                            <td style="padding: 2px 4px; font-weight:600;">{{ $mydata->fees_group_name ?? '' }}</td>
                                                                            <td style="padding: 2px 4px; font-weight: 700; color: #28a745;">₹{{ number_format($mydata->amount ?? 0) }}</td>
                                                                            <td style="padding: 2px 4px; font-size: 10.5px; color: #6c757d;">
                                                                                {{ !empty($mydata->installment_due_date) ? date('d-M-Y', strtotime($mydata->installment_due_date)) : 'No Due Date' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </td>
                                                            @if($getPermission->edit == 1)
                                                            <td class="text-center">
                                                                <a href="{{ url('feesMasterEdit') }}/{{ $item['class_type_id'] ?? '' }}" class="btn btn-primary btn-xs" title="Edit Class Fees"><i class="fa fa-edit"></i></a>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB 2: ALL FEE HEADS (FEES GROUPS) -->
                                <div class="tab-pane fade" id="tab_fees_group" role="tabpanel">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                                            <thead>
                                                <tr role="row">
                                                    <th width="30px">#</th>
                                                    <th>Fee Head Name</th>
                                                    <th>Category</th>
                                                    <th width="80px" class="text-center">Refundable</th>
                                                    <th width="70px" class="text-center">Partial (50%)</th>
                                                    @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                                    <th width="50px" class="text-center">{{ __('messages.Action') }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($dataview))
                                                    @php $j = 1; @endphp
                                                    @foreach ($dataview->where('fees_type', 'full') as $item)
                                                        @php
                                                            $groupTypeClass = 'badge-other';
                                                            $groupTypeLabel = !empty($item->group_type) ? ucfirst(str_replace('_', ' & ', $item->group_type)) : 'General';
                                                            if ($item->group_type === 'academic') { $groupTypeClass = 'badge-academic'; }
                                                            elseif ($item->group_type === 'examination') { $groupTypeClass = 'badge-examination'; }
                                                            elseif ($item->group_type === 'practical') { $groupTypeClass = 'badge-practical'; }
                                                            elseif ($item->group_type === 'admission' || $item->group_type === 'registration') { $groupTypeClass = 'badge-admission'; }
                                                            elseif ($item->group_type === 'facility') { $groupTypeClass = 'badge-facility'; }
                                                            elseif ($item->group_type === 'refundable') { $groupTypeClass = 'badge-refundable'; }
                                                            elseif ($item->group_type === 'hostel_transport') { $groupTypeClass = 'badge-hostel_transport'; }
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $j++ }}</td>
                                                            <td><strong class="text-dark">{{ $item['name'] ?? '' }}</strong></td>
                                                            <td><span class="badge {{ $groupTypeClass }}">{{ $groupTypeLabel }}</span></td>
                                                            <td class="text-center">
                                                                @if(strtolower($item['fees_refund'] ?? '') === 'yes')
                                                                    <span class="badge badge-success"><i class="fa fa-check"></i> Yes</span>
                                                                @else
                                                                    <span class="badge badge-light border">No</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if($item->fees_partial == 1)
                                                                    <span class="badge badge-primary">Yes</span>
                                                                @else
                                                                    <span class="badge badge-light border">No</span>
                                                                @endif
                                                            </td>
                                                            @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                                            <td class="text-center">
                                                                @if($getPermission->edit == 1)
                                                                    <a href="{{ url('feesGroupEdit') }}/{{ $item['id'] ?? '' }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a> 
                                                                @endif
                                                                @if($getPermission->deletes == 1)
                                                                    @php
                                                                        $rowSessionId = $item->session_id ?? Session::get('session_id');
                                                                        $isDeleteAllowed1 = DB::table('fees_detail')->where('fees_group_id', $item->id)->where('session_id', $rowSessionId)->where('branch_id', Session::get('branch_id'))->whereNull('deleted_at')->count();
                                                                        $isDeleteAllowed2 = DB::table('fees_assign_details')->where('fees_group_id', $item->id)->where('session_id', $rowSessionId)->where('branch_id', Session::get('branch_id'))->whereNull('deleted_at')->count();
                                                                    @endphp
                                                                    @if(($isDeleteAllowed1 + $isDeleteAllowed2) == 0)
                                                                        <a href="javascript:;" data-id='{{$item['id'] }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                    @else
                                                                        <span class="text-muted" title="In Use (Locked)"><i class="fa fa-lock"></i></span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <p class="text-muted mb-0" style="font-size:11px;">
                                    <i class="fa fa-info-circle text-info"></i> <b>Tip:</b> Creating fee heads here with Amount & Due Date automatically configures Fees Master for student admissions & collection.
                                </p>
                            </div>
                        </div> 
                    </div>          
                </div>
            </div>  
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="Modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.Delete Confirmation') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('feesGroupDelete') }}" method="post">
                @csrf
                <div class="modal-body">
                    {{ __('common.Are you sure you want to delete') }}?
                    <input type="hidden" name="delete_id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('common.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var currentMode = 'semester';
var currentCourseClasses = [];

function onCourseSelected(selectElem) {
    var opt = selectElem.options[selectElem.selectedIndex];
    var infoDiv = document.getElementById('course_detected_info');
    var infoText = document.getElementById('course_detected_text');
    var noticeDiv = document.getElementById('course_required_notice');
    var controlsDiv = document.getElementById('section_semester_controls');
    var previewContainer = document.getElementById('preview_box_container');
    var submitBtn = document.getElementById('submit_btn');

    if (!opt || !opt.value) {
        infoDiv.style.display = 'none';
        currentCourseClasses = [];
        
        if (currentMode === 'semester') {
            if (noticeDiv) noticeDiv.style.display = 'block';
            if (controlsDiv) controlsDiv.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.className = 'btn btn-secondary btn-sm btn-block font-weight-bold py-2 disabled';
            submitBtn.innerHTML = '<i class="fa fa-hand-o-up"></i> Please Select a Course to Continue';
        }
        
        var singleClassSelect = $('#single_class_type_id');
        singleClassSelect.empty().append('<option value="">-- Select Class / Semester --</option>');
        @if(!empty($classType))
            @foreach($classType as $cl)
                singleClassSelect.append('<option value="{{ $cl->id }}" data-course-id="{{ $cl->course_id }}">{{ $cl->name }}</option>');
            @endforeach
        @endif
        return;
    }

    var courseId = opt.value;
    var courseName = opt.getAttribute('data-name');
    var courseType = opt.getAttribute('data-type') || 'semester';
    var duration = parseInt(opt.getAttribute('data-duration')) || 3;
    var totalSemesters = parseInt(opt.getAttribute('data-semesters')) || (duration * 2);

    infoDiv.style.display = 'block';

    if (courseType === 'yearly') {
        infoText.innerText = 'Detected: ' + courseName + ' (Yearly - ' + duration + ' Years)';
        document.getElementById('sem_count').value = duration;
    } else {
        infoText.innerText = 'Detected: ' + courseName + ' (Semester - ' + totalSemesters + ' Semesters)';
        document.getElementById('sem_count').value = totalSemesters;
    }

    // Fetch classes of selected course
    $.ajax({
        url: "{{ url('getClassesByCourse') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            course_id: courseId
        },
        dataType: 'json',
        success: function(res) {
            currentCourseClasses = res || [];
            
            // Populate single class dropdown with only classes of this course
            var singleClassSelect = $('#single_class_type_id');
            singleClassSelect.empty().append('<option value="">-- Select Class / Semester --</option>');
            $.each(currentCourseClasses, function(idx, item) {
                singleClassSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
            });

            if (currentMode === 'semester') {
                if (noticeDiv) noticeDiv.style.display = 'none';
                if (controlsDiv) controlsDiv.style.display = 'block';
                if (previewContainer) previewContainer.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.className = 'btn btn-primary btn-sm btn-block font-weight-bold py-2 shadow-sm';
                updateSemPreview();
            } else if (currentMode === 'single_class') {
                updateSingleClassPreview();
            }
        },
        error: function() {
            currentCourseClasses = [];
            if (currentMode === 'semester') {
                if (noticeDiv) noticeDiv.style.display = 'block';
                if (controlsDiv) controlsDiv.style.display = 'none';
                if (previewContainer) previewContainer.style.display = 'none';
                submitBtn.disabled = true;
                submitBtn.className = 'btn btn-secondary btn-sm btn-block font-weight-bold py-2 disabled';
                submitBtn.innerHTML = '<i class="fa fa-hand-o-up"></i> Please Select a Course to Continue';
            }
        }
    });
}

function switchMode(mode) {
    currentMode = mode;
    document.getElementById('form_mode').value = mode;

    document.getElementById('btn_mode_semester').classList.remove('active');
    document.getElementById('btn_mode_single_class').classList.remove('active');
    document.getElementById('btn_mode_single_head').classList.remove('active');

    document.getElementById('section_semester').style.display = 'none';
    document.getElementById('section_single_class').style.display = 'none';
    document.getElementById('section_single_head').style.display = 'none';

    var courseBox = document.getElementById('course_selector_box');
    var courseBadge = document.getElementById('course_mode_badge');
    var courseReqStar = document.getElementById('course_req_star');
    var noticeDiv = document.getElementById('course_required_notice');
    var controlsDiv = document.getElementById('section_semester_controls');
    var previewContainer = document.getElementById('preview_box_container');
    var submitBtn = document.getElementById('submit_btn');
    var courseSelected = document.getElementById('course_selector').value !== '';

    if (mode === 'semester') {
        document.getElementById('btn_mode_semester').classList.add('active');
        document.getElementById('section_semester').style.display = 'block';
        courseBox.style.display = 'block';
        courseBadge.innerText = 'Required';
        courseBadge.className = 'badge badge-primary px-2';
        courseReqStar.style.display = 'inline';

        if (courseSelected && currentCourseClasses.length > 0) {
            if (noticeDiv) noticeDiv.style.display = 'none';
            if (controlsDiv) controlsDiv.style.display = 'block';
            if (previewContainer) previewContainer.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.className = 'btn btn-primary btn-sm btn-block font-weight-bold py-2 shadow-sm';
            updateSemPreview();
        } else {
            if (noticeDiv) noticeDiv.style.display = 'block';
            if (controlsDiv) controlsDiv.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.className = 'btn btn-secondary btn-sm btn-block font-weight-bold py-2 disabled';
            submitBtn.innerHTML = '<i class="fa fa-hand-o-up"></i> Please Select a Course to Continue';
        }
    } else if (mode === 'single_class') {
        document.getElementById('btn_mode_single_class').classList.add('active');
        document.getElementById('section_single_class').style.display = 'block';
        courseBox.style.display = 'block';
        courseBadge.innerText = 'Filter Course';
        courseBadge.className = 'badge badge-info px-2';
        courseReqStar.style.display = 'none';
        if (previewContainer) previewContainer.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.className = 'btn btn-primary btn-sm btn-block font-weight-bold py-2 shadow-sm';
        updateSingleClassPreview();
    } else {
        document.getElementById('btn_mode_single_head').classList.add('active');
        document.getElementById('section_single_head').style.display = 'block';
        courseBox.style.display = 'none';
        if (previewContainer) previewContainer.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.className = 'btn btn-primary btn-sm btn-block font-weight-bold py-2 shadow-sm';
        updateHeadOnlyPreview();
    }
}

function setSemBase(name, cat) {
    document.getElementById('sem_base_name').value = name;
    if (cat) document.getElementById('sem_group_type').value = cat;
    updateSemPreview();
}

function setSingleClassName(name, cat) {
    document.getElementById('single_class_fee_name').value = name;
    if (cat) document.getElementById('single_class_group_type').value = cat;
    updateSingleClassPreview();
}

function setHeadOnly(name, cat, isRefund) {
    document.getElementById('head_only_name').value = name;
    if (cat) document.getElementById('head_only_group_type').value = cat;
    var refCheck = document.getElementById('head_only_refund');
    if (isRefund === 'yes') {
        refCheck.checked = true;
        document.getElementById('fees_refund').value = 'yes';
    } else {
        refCheck.checked = false;
        document.getElementById('fees_refund').value = 'no';
    }
    updateHeadOnlyPreview();
}

function updateHeadOnlyRefund(checkbox) {
    document.getElementById('fees_refund').value = checkbox.checked ? 'yes' : 'no';
}

function updateHeadOnlyPartial(checkbox) {
    document.getElementById('fees_partial').value = checkbox.checked ? 1 : 0;
}

function syncCommonAmount(val) {
    $('.sem-row-amount').val(val);
}

function updateSemPreview() {
    var baseName = document.getElementById('sem_base_name').value.trim() || 'Tuition Fee';
    var count = parseInt(document.getElementById('sem_count').value) || 6;
    var commonAmount = document.getElementById('batch_common_amount').value || '15000';

    var html = '';

    if (currentCourseClasses.length > 0) {
        var loopCount = Math.min(count, currentCourseClasses.length);
        html += '<div class="table-responsive" style="max-height: 220px; overflow-y: auto; border: 1px solid #c2d4ea; border-radius: 4px;">';
        html += '<table class="table table-sm table-bordered table-striped mb-0 text-dark" style="font-size: 11px; background: #ffffff;">';
        html += '<thead style="background: #002c54; color: #ffffff; position: sticky; top: 0; z-index: 2;">';
        html += '<tr>';
        html += '<th style="padding: 4px 6px; width: 25%; background: #002c54; color: #ffffff;">Class / Sem</th>';
        html += '<th style="padding: 4px 6px; width: 31%; background: #002c54; color: #ffffff;">Fee Head Name</th>';
        html += '<th style="padding: 4px 6px; width: 22%; background: #002c54; color: #ffffff;">Amount (₹)</th>';
        html += '<th style="padding: 4px 6px; width: 22%; background: #002c54; color: #ffffff;">Due Date</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';

        for (var i = 0; i < loopCount; i++) {
            var cl = currentCourseClasses[i];
            var headName = baseName + ' - Sem ' + (i + 1);

            html += '<tr>';
            html += '<td style="vertical-align: middle; padding: 4px 6px;">';
            html += '<strong class="text-primary">' + cl.name + '</strong>';
            html += '<input type="hidden" name="class_type_id[]" value="' + cl.id + '">';
            html += '</td>';
            html += '<td style="vertical-align: middle; padding: 4px 6px;">';
            html += '<input type="text" name="fee_name[]" class="form-control form-control-sm p-1 font-weight-bold text-dark sem-head-name" value="' + headName + '" style="font-size: 11px; height: 26px; border: 1px solid #ced4da;">';
            html += '</td>';
            html += '<td style="vertical-align: middle; padding: 4px 6px;">';
            html += '<input type="number" name="amount[]" class="form-control form-control-sm p-1 font-weight-bold text-success text-right sem-row-amount" value="' + commonAmount + '" min="0" style="font-size: 11px; height: 26px; border: 1px solid #28a745; background: #f8fff9;">';
            html += '</td>';
            html += '<td style="vertical-align: middle; padding: 4px 6px;">';
            html += '<input type="date" name="due_date[]" class="form-control form-control-sm p-1 sem-row-due" value="" style="font-size: 10px; height: 26px; border: 1px solid #ced4da;">';
            html += '</td>';
            html += '</tr>';
        }

        html += '</tbody></table></div>';
        document.getElementById('batch_inputs_container').innerHTML = '';
        document.getElementById('submit_btn').innerHTML = '<i class="fa fa-check-circle"></i> Save ' + loopCount + ' Semester Fee Structure (Fees Master)';
    }

    document.getElementById('preview_title').innerText = 'Semester-wise Fees & Amount Setup:';
    document.getElementById('preview_box').innerHTML = html;
    document.getElementById('preview_count_badge').innerText = (currentCourseClasses.length > 0 ? Math.min(count, currentCourseClasses.length) : count) + ' Semesters';
}

function updateSingleClassPreview() {
    var clElem = document.getElementById('single_class_type_id');
    var clName = clElem.options[clElem.selectedIndex] ? clElem.options[clElem.selectedIndex].text : 'Selected Class';
    var feeName = document.getElementById('single_class_fee_name').value.trim() || 'Tuition Fee';
    var amount = document.getElementById('single_class_amount').value || '0';

    var html = '<div class="d-flex justify-content-between align-items-center p-2 border rounded bg-white" style="font-size:11.5px;">'
             + '<span><strong class="text-primary">' + clName + '</strong> &rarr; <span class="badge badge-light border text-dark">' + feeName + '</span></span>'
             + '<span class="font-weight-bold text-success" style="font-size:13px;">₹' + amount + '</span>'
             + '</div>';

    document.getElementById('preview_title').innerText = 'Single Class Fee Master:';
    document.getElementById('preview_box').innerHTML = html;
    document.getElementById('batch_inputs_container').innerHTML = '';
    document.getElementById('preview_count_badge').innerText = '1 Class';
    document.getElementById('submit_btn').innerHTML = '<i class="fa fa-check-circle"></i> Save Class Fee Structure (Fees Master)';
}

function updateHeadOnlyPreview() {
    var name = document.getElementById('head_only_name').value.trim() || 'Admission Fee';
    var html = '<div class="p-2 border rounded bg-white"><span class="badge badge-primary font-weight-bold" style="font-size:12px;"><i class="fa fa-tag"></i> ' + name + '</span></div>';

    document.getElementById('preview_title').innerText = 'Fee Head:';
    document.getElementById('preview_box').innerHTML = html;
    document.getElementById('batch_inputs_container').innerHTML = '';
    document.getElementById('preview_count_badge').innerText = 'Head Only';
    document.getElementById('submit_btn').innerHTML = '<i class="fa fa-plus-circle"></i> Create Fee Head';
}

$(document).ready(function() {
    // Initial check: if course was selected, trigger auto-detect
    var initCourse = document.getElementById('course_selector');
    if (initCourse && initCourse.value) {
        onCourseSelected(initCourse);
    } else {
        switchMode('semester');
    }
    
    $(document).on('click', '.deleteData', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });

    // Dynamic Tab Pill Switch Styling
    $('#feesTab a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#feesTab a').on('shown.bs.tab', function (e) {
        $('#feesTab a').css({
            'background': 'rgba(255,255,255,0.2)',
            'color': '#ffffff',
            'border-color': 'rgba(255,255,255,0.4)'
        });
        $(e.target).css({
            'background': '#ffffff',
            'color': '#002c54',
            'border-color': '#ffffff'
        });
    });

    // Form Submission Client-side Validation
    $('#quickForm').on('submit', function(e) {
        var mode = $('#form_mode').val();
        if (mode === 'semester') {
            var courseVal = $('#course_selector').val();
            if (!courseVal) {
                e.preventDefault();
                alert('Please select a Course first!');
                $('#course_selector').focus();
                return false;
            }
            if (currentCourseClasses.length === 0) {
                e.preventDefault();
                alert('No classes found for the selected course.');
                return false;
            }
        } else if (mode === 'single_class') {
            var classVal = $('#single_class_type_id').val();
            var nameVal = $('#single_class_fee_name').val().trim();
            if (!classVal) {
                e.preventDefault();
                alert('Please select a Class / Semester!');
                $('#single_class_type_id').focus();
                return false;
            }
            if (!nameVal) {
                e.preventDefault();
                alert('Please enter Fee Head Name!');
                $('#single_class_fee_name').focus();
                return false;
            }
        } else if (mode === 'single_head') {
            var headVal = $('#head_only_name').val().trim();
            if (!headVal) {
                e.preventDefault();
                alert('Please enter Fee Head Name!');
                $('#head_only_name').focus();
                return false;
            }
        }
    });
});
</script>

@endsection