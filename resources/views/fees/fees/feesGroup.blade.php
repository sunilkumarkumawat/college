@php
$getPermission = Helper::getPermission();
$getSession = Helper::getSession();
$classType = Helper::classType();
@endphp

@extends('layout.app') 
@section('content')

<style>
/* Strictly Scoped Styles for Fees Unified Setup Page (Does NOT affect Sidebar, Header, or other pages) */
.fees-unified-page {
    --brand-dark: #002c54;
    --brand-dark-hover: #004b8d;
    --brand-darker: #001a33;
    --brand-light: #f8fafc;
    --brand-border: #cbd5e1;
}

/* Base Buttons & Dark Background High-Contrast Rules */
.fees-unified-page .btn-primary {
    background-color: var(--brand-dark) !important;
    border-color: var(--brand-dark) !important;
    color: #ffffff !important;
}
.fees-unified-page .btn-primary:hover, 
.fees-unified-page .btn-primary:focus, 
.fees-unified-page .btn-primary:active {
    background-color: var(--brand-dark-hover) !important;
    border-color: var(--brand-dark-hover) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
}
.fees-unified-page .btn-primary i {
    color: inherit !important;
}

/* Card Headers with Dark Background */
.fees-unified-page .card-header.bg-primary {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-bottom: 1px solid var(--brand-darker) !important;
}
.fees-unified-page .card-header.bg-primary .card-title,
.fees-unified-page .card-header.bg-primary h3,
.fees-unified-page .card-header.bg-primary h5 {
    color: #ffffff !important;
    margin-bottom: 0;
}
.fees-unified-page .card-header.bg-primary .card-title i,
.fees-unified-page .card-header.bg-primary h3 i {
    color: #ffffff !important;
}
.fees-unified-page .card-header.bg-primary .badge-light {
    background: #ffffff !important;
    color: var(--brand-dark) !important;
    font-weight: 700;
}

/* Course Selector Container */
.fees-unified-page .course-selector-box {
    background: #f0f7ff !important;
    border: 1px solid #b8daff !important;
    border-radius: 6px;
    padding: 8px 10px;
    margin-bottom: 10px;
}

/* Structure Mode Toggle Buttons */
.fees-unified-page .mode-toggle-btn {
    flex: 1;
    padding: 6px 8px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
    border: 1px solid var(--brand-border);
    background: #ffffff;
    color: #1e293b;
    cursor: pointer;
    transition: all 0.2s ease;
}
.fees-unified-page .mode-toggle-btn:hover {
    background: #e2e8f0;
    color: var(--brand-dark);
    border-color: #94a3b8;
}
.fees-unified-page .mode-toggle-btn.active {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
.fees-unified-page .mode-toggle-btn.active:hover {
    background: var(--brand-dark-hover) !important;
    color: #ffffff !important;
}
.fees-unified-page .mode-toggle-btn.active small {
    color: #e2e8f0 !important;
}
.fees-unified-page .mode-toggle-btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.fees-unified-page .mode-toggle-btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

/* Quick Preset Pills */
.fees-unified-page .quick-preset-btn {
    display: inline-block;
    padding: 2px 8px;
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
.fees-unified-page .quick-preset-btn:hover {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.12);
}

/* Preview Box */
.fees-unified-page .preview-badge {
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
.fees-unified-page .preview-box-container {
    background: #ffffff;
    border: 1px solid #c2d4ea;
    border-radius: 5px;
    padding: 8px;
    height: auto !important;
    max-height: none !important;
    overflow: visible !important;
}
.fees-unified-page #preview_box {
    height: auto !important;
    max-height: none !important;
    overflow: visible !important;
}
.fees-unified-page .preview-header {
    background: #e8f2fc;
    color: var(--brand-dark);
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 8px;
    border-radius: 4px;
    margin-bottom: 6px;
}
.fees-unified-page .fee-master-amount-box {
    background: #fffdf5;
    border: 1px solid #ffeeba;
    border-radius: 5px;
    padding: 8px 10px;
    margin-top: 8px;
    margin-bottom: 8px;
}

/* Category Badges */
.fees-unified-page .badge-academic { background-color: #007bff !important; color: #ffffff !important; }
.fees-unified-page .badge-examination { background-color: #e65100 !important; color: #ffffff !important; }
.fees-unified-page .badge-practical { background-color: #00838f !important; color: #ffffff !important; }
.fees-unified-page .badge-admission { background-color: #512da8 !important; color: #ffffff !important; }
.fees-unified-page .badge-facility { background-color: #00796b !important; color: #ffffff !important; }
.fees-unified-page .badge-refundable { background-color: #2e7d32 !important; color: #ffffff !important; }
.fees-unified-page .badge-hostel_transport { background-color: #c2185b !important; color: #ffffff !important; }
.fees-unified-page .badge-other { background-color: #455a64 !important; color: #ffffff !important; }

/* Table Headers (High-Contrast White on Dark) */
.fees-unified-page .padding_table thead tr th,
.fees-unified-page #example1 thead tr th {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    font-size: 11.5px !important;
    padding: 7px 9px !important;
    font-weight: 600 !important;
    border-color: var(--brand-darker) !important;
    vertical-align: middle !important;
}
.fees-unified-page .padding_table thead tr th a,
.fees-unified-page .padding_table thead tr th i,
.fees-unified-page #example1 thead tr th a,
.fees-unified-page #example1 thead tr th i {
    color: #ffffff !important;
}

/* Executive Course Cards, KPI Chips & Quick Filters */
.fees-unified-page .badge-light {
    background-color: #f1f5f9 !important;
    color: #1e293b !important;
    border: 1px solid #cbd5e1 !important;
}
.fees-unified-page .card-header.bg-primary .badge-light,
.fees-unified-page .course-card-header .badge-light {
    background-color: #ffffff !important;
    color: var(--brand-dark) !important;
    font-weight: 700 !important;
    border: none !important;
}

.fees-unified-page .kpi-chip-card {
    background: #ffffff !important;
    border: 1px solid var(--brand-border) !important;
    border-radius: 6px;
    padding: 6px 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 8px;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.fees-unified-page .kpi-chip-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.08);
}
.fees-unified-page .kpi-chip-icon {
    width: 34px;
    height: 34px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.fees-unified-page .kpi-chip-icon.icon-courses {
    background: #e0f2fe !important;
    color: #0284c7 !important;
}
.fees-unified-page .kpi-chip-icon.icon-classes {
    background: #e0e7ff !important;
    color: #4338ca !important;
}
.fees-unified-page .kpi-chip-icon.icon-pool {
    background: #dcfce7 !important;
    color: #15803d !important;
}
.fees-unified-page .kpi-chip-icon.icon-heads {
    background: #fef3c7 !important;
    color: #b45309 !important;
}
.fees-unified-page .kpi-chip-val {
    font-size: 13.5px;
    font-weight: 700;
    line-height: 1.1;
    color: #0f172a;
}
.fees-unified-page .kpi-chip-label {
    font-size: 9px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quick Filters Box Container */
.fees-unified-page .quick-filters-box {
    background: #f1f5f9 !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 6px;
    padding: 8px 10px;
    margin-bottom: 10px;
}
.fees-unified-page .quick-filters-box label {
    color: var(--brand-dark) !important;
    font-weight: 700 !important;
    font-size: 11.5px !important;
}
.fees-unified-page .quick-filters-box label i {
    color: var(--brand-dark-hover) !important;
}
.fees-unified-page .quick-filters-box .text-muted,
.fees-unified-page .quick-filters-box small {
    color: #475569 !important;
    font-weight: 600 !important;
    font-size: 10px !important;
}

/* Course Filter Scroll with Left & Right Arrows */
.fees-unified-page .course-filter-wrapper {
    display: flex;
    align-items: center;
    gap: 6px;
    position: relative;
    width: 100%;
}
.fees-unified-page .course-scroll-btn {
    width: 26px;
    height: 26px;
    min-width: 26px;
    border-radius: 50%;
    background: #ffffff !important;
    border: 1px solid var(--brand-border) !important;
    color: var(--brand-dark) !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.15s ease-in-out;
    padding: 0;
    font-size: 11px;
}
.fees-unified-page .course-scroll-btn:hover {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2) !important;
}
.fees-unified-page .course-filter-scroll {
    display: flex;
    overflow-x: auto;
    gap: 6px;
    padding: 3px 2px;
    flex-grow: 1;
    scroll-behavior: smooth;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE & Edge */
}
.fees-unified-page .course-filter-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

/* Course Filter Pills */
.fees-unified-page .course-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    border: 1px solid var(--brand-border) !important;
    background: #ffffff !important;
    color: #1e293b !important;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}
.fees-unified-page .course-pill-btn i {
    color: #0284c7 !important;
}
.fees-unified-page .course-pill-btn .badge-counter {
    background: #e2e8f0 !important;
    color: #0f172a !important;
    border-radius: 10px;
    padding: 1px 6px;
    font-size: 9.5px;
    font-weight: 700;
}
.fees-unified-page .course-pill-btn:hover {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
.fees-unified-page .course-pill-btn:hover i {
    color: #ffffff !important;
}
.fees-unified-page .course-pill-btn:hover .badge-counter {
    background: rgba(255,255,255,0.25) !important;
    color: #ffffff !important;
}
.fees-unified-page .course-pill-btn.active {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 5px rgba(0,44,84,0.3) !important;
}
.fees-unified-page .course-pill-btn.active:hover {
    background: var(--brand-dark-hover) !important;
    color: #ffffff !important;
}
.fees-unified-page .course-pill-btn.active i {
    color: #ffffff !important;
}
.fees-unified-page .course-pill-btn.active .badge-counter {
    background: rgba(255,255,255,0.25) !important;
    color: #ffffff !important;
}

/* Course Cards */
.fees-unified-page .course-card {
    background: #ffffff;
    border: 1px solid var(--brand-border);
    border-radius: 8px;
    margin-bottom: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    transition: all 0.2s ease;
    overflow: hidden;
}
.fees-unified-page .course-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: #94a3b8;
}
.fees-unified-page .course-card-header {
    background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-dark-hover) 100%) !important;
    color: #ffffff !important;
    padding: 8px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
}
.fees-unified-page .course-card-title {
    font-size: 13px;
    font-weight: 700;
    margin: 0;
    color: #ffffff !important;
    display: flex;
    align-items: center;
    gap: 6px;
}
.fees-unified-page .course-card-title i {
    color: #ffffff !important;
}

/* Setup Button Inside Course Card */
.fees-unified-page .course-card-header .btn-setup-course {
    background: #ffffff !important;
    color: var(--brand-dark) !important;
    border: 1px solid #ffffff !important;
    font-weight: 700 !important;
    transition: all 0.15s ease-in-out;
}
.fees-unified-page .course-card-header .btn-setup-course:hover {
    background: var(--brand-darker) !important;
    color: #ffffff !important;
    border-color: var(--brand-darker) !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2) !important;
}
.fees-unified-page .course-card-header .btn-setup-course:hover i {
    color: #ffffff !important;
}

/* Dual View Switch Buttons */
.fees-unified-page .view-switch-btn {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border: 1px solid var(--brand-border);
    background: #ffffff;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s ease;
}
.fees-unified-page .view-switch-btn:hover {
    background: #e2e8f0;
    color: var(--brand-dark);
    border-color: #94a3b8;
}
.fees-unified-page .view-switch-btn.active {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
}
.fees-unified-page .view-switch-btn.active:hover {
    background: var(--brand-dark-hover) !important;
    color: #ffffff !important;
}
.fees-unified-page .view-switch-btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.fees-unified-page .view-switch-btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

/* Quick Export Toolbar Buttons */
.fees-unified-page .quick-export-btn {
    font-size: 10.5px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 4px;
    border: 1px solid var(--brand-border);
    background: #ffffff;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s ease;
}
.fees-unified-page .quick-export-btn:hover {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.12);
}
.fees-unified-page .quick-export-btn:hover i {
    color: #ffffff !important;
}

/* DataTables Buttons */
.fees-unified-page .dt-buttons .btn {
    background: #ffffff !important;
    color: #1e293b !important;
    border: 1px solid var(--brand-border) !important;
    font-weight: 600 !important;
    font-size: 11px !important;
    padding: 3px 8px !important;
    transition: all 0.15s ease !important;
}
.fees-unified-page .dt-buttons .btn:hover {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark) !important;
}

/* Empty Course State */
.fees-unified-page .empty-course-box {
    background: #f8fafc !important;
    border: 1.5px dashed #cbd5e1 !important;
    border-radius: 6px;
    padding: 16px 12px;
    text-align: center;
}
.fees-unified-page .empty-course-box .empty-msg {
    color: #334155 !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    margin-bottom: 8px;
}
.fees-unified-page .empty-course-box .empty-msg i {
    color: #0284c7 !important;
    margin-right: 4px;
}
.fees-unified-page .empty-course-box .empty-msg strong {
    color: var(--brand-dark) !important;
}
.fees-unified-page .btn-configure-course {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border: 1px solid var(--brand-dark) !important;
    font-weight: 700 !important;
    font-size: 11px !important;
    padding: 4px 12px !important;
    border-radius: 4px;
    transition: all 0.15s ease-in-out;
}
.fees-unified-page .btn-configure-course:hover {
    background: var(--brand-dark-hover) !important;
    color: #ffffff !important;
    border-color: var(--brand-dark-hover) !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.18) !important;
}
.fees-unified-page .btn-configure-course i {
    color: #ffffff !important;
}

/* Modal Headers & Tables */
.fees-unified-page.modal .modal-header.bg-primary,
.modal.fees-unified-page .modal-header.bg-primary {
    background: var(--brand-dark) !important;
    color: #ffffff !important;
    border-bottom: 1px solid var(--brand-darker) !important;
}
.fees-unified-page.modal .modal-header.bg-primary .modal-title,
.modal.fees-unified-page .modal-header.bg-primary .modal-title {
    color: #ffffff !important;
}
.fees-unified-page.modal .modal-header.bg-primary .close,
.modal.fees-unified-page .modal-header.bg-primary .close {
    color: #ffffff !important;
    text-shadow: none;
    opacity: 0.9;
    transition: opacity 0.15s ease, color 0.15s ease;
}
.fees-unified-page.modal .modal-header.bg-primary .close:hover,
.modal.fees-unified-page .modal-header.bg-primary .close:hover {
    color: #ffdd57 !important;
    opacity: 1;
}
.fees-unified-page.modal table thead th,
.modal.fees-unified-page table thead th {
    background: #f1f5f9 !important;
    color: #0f172a !important;
    font-weight: 700 !important;
    border-bottom: 2px solid #cbd5e1 !important;
    font-size: 11.5px !important;
}
.fees-unified-page.modal table tbody td,
.modal.fees-unified-page table tbody td {
    color: #1e293b !important;
    font-size: 11.5px !important;
}

/* Back Button in Card Header */
.fees-unified-page .card-header .btn-back-header {
    background: #ffffff !important;
    color: var(--brand-dark) !important;
    font-weight: 700 !important;
    border: 1px solid #ffffff !important;
    transition: all 0.15s ease;
}
.fees-unified-page .card-header .btn-back-header:hover {
    background: #e2e8f0 !important;
    color: var(--brand-darker) !important;
}
</style>

<div class="content-wrapper fees-unified-page">
    <section class="content pt-2">
        <div class="container-fluid">
            <!-- Top Action Header Bar -->
            <div class="row align-items-center mb-2">
                <div class="col-md-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0 mb-0" style="background:none;">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('fee_dashboard')}}">Fee Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Unified Fees Setup</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-8 text-md-right d-flex justify-content-end align-items-center flex-wrap" style="gap: 6px;">
                    <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#students_list_modal" data-bs-toggle="modal" data-bs-target="#students_list_modal" style="font-size:11.5px;">
                        <i class="fa fa-users"></i> Student Fee Assign
                    </button>
                    <button type="button" id="fees_modification_btn" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#fees_modification" data-bs-toggle="modal" data-bs-target="#fees_modification" style="font-size:11.5px;">
                        <i class="fa fa-pencil-square-o"></i> Student Fee Modification
                    </button>
                    <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#special_fee_modal" data-bs-toggle="modal" data-bs-target="#special_fee_modal" style="font-size:11.5px;">
                        <i class="fa fa-star"></i> Registration Fee
                    </button>
                </div>
            </div>

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
                                                    <select class="form-control form-control-sm" name="sem_group_type" id="sem_group_type">
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
                                        <div class="fee-master-amount-box mb-2">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold text-dark mb-1" style="font-size:11.5px;">
                                                    <i class="fa fa-inr text-success"></i> Default Amount (Applied to all semesters):
                                                </label>
                                                <input type="text" class="form-control form-control-sm font-weight-bold text-success" id="batch_common_amount" placeholder="e.g. 15000" value="15000" oninput="syncCommonAmount(this.value)" onkeypress="javascript:return isNumber(event)">
                                            </div>
                                        </div>

                                        <!-- Due Date Schedule Generator Box -->
                                        <div class="card p-2 mb-2" style="background: #f0f7ff; border: 1px solid #b8daff; border-radius: 4px;">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="font-weight-bold text-primary" style="font-size: 11px;">
                                                    <i class="fa fa-calendar-check-o text-primary"></i> Auto Due Date Schedule
                                                </span>
                                                <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 font-weight-bold" style="font-size: 10px;" onclick="applyDueDateSchedule()">
                                                    <i class="fa fa-magic"></i> Auto-Fill Dates
                                                </button>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6 pr-1">
                                                    <div class="form-group mb-1">
                                                        <label class="mb-0 text-muted" style="font-size: 10px; font-weight: 600;">Start Date (Sem 1)</label>
                                                        <input type="date" class="form-control form-control-sm" id="schedule_start_date" value="{{ date('Y-m-10') }}" onchange="applyDueDateSchedule()" style="font-size: 11px; height: 26px; padding: 2px 4px;">
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <div class="form-group mb-1">
                                                        <label class="mb-0 text-muted" style="font-size: 10px; font-weight: 600;">Interval / Gap</label>
                                                        <select class="form-control form-control-sm" id="schedule_interval" onchange="applyDueDateSchedule()" style="font-size: 10.5px; height: 26px; padding: 2px 4px;">
                                                            <option value="6" selected>Every 6 Months (Semester)</option>
                                                            <option value="1">Every 1 Month (Monthly)</option>
                                                            <option value="2">Every 2 Months (Bi-Monthly)</option>
                                                            <option value="3">Every 3 Months (Quarterly)</option>
                                                            <option value="4">Every 4 Months (Tri-Annual)</option>
                                                            <option value="12">Every 12 Months (Yearly)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6 pr-1">
                                                    <div class="form-group mb-0">
                                                        <label class="mb-0 text-muted" style="font-size: 10px; font-weight: 600;">Due Day of Month</label>
                                                        <select class="form-control form-control-sm" id="schedule_due_day" onchange="applyDueDateSchedule()" style="font-size: 10.5px; height: 26px; padding: 2px 4px;">
                                                            <option value="same" selected>Same Day as Start Date</option>
                                                            <option value="1">1st of Month</option>
                                                            <option value="5">5th of Month</option>
                                                            <option value="10">10th of Month</option>
                                                            <option value="15">15th of Month</option>
                                                            <option value="20">20th of Month</option>
                                                            <option value="25">25th of Month</option>
                                                            <option value="last">Last Day of Month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <div class="form-group mb-0">
                                                        <label class="mb-0 text-muted" style="font-size: 10px; font-weight: 600;">Quick Actions</label>
                                                        <div class="btn-group btn-group-sm d-flex" role="group">
                                                            <button type="button" class="btn btn-outline-secondary btn-xs w-50" style="font-size:9.5px; height: 26px; padding: 1px 3px;" onclick="clearDueDates()" title="Clear all due dates">
                                                                <i class="fa fa-times text-danger"></i> Clear
                                                            </button>
                                                            <button type="button" class="btn btn-primary btn-xs w-50" style="font-size:9.5px; height: 26px; padding: 1px 3px;" onclick="applyDueDateSchedule()" title="Calculate & Fill">
                                                                <i class="fa fa-refresh"></i> Apply
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-muted mt-1" style="font-size: 9px; line-height: 1.1;">
                                                <i class="fa fa-info-circle text-info"></i> Auto-generates due dates across semesters based on selected interval.
                                            </small>
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
                                        <input type="text" class="form-control form-control-sm font-weight-bold" id="single_class_fee_name" name="single_class_fee_name" placeholder="e.g. Tuition Fee, Admission Fee" oninput="updateSingleClassPreview()">
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
                                        <select class="form-control form-control-sm" name="single_class_group_type" id="single_class_group_type">
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
                                        <input type="text" class="form-control form-control-sm" id="head_only_name" name="head_only_name" placeholder="e.g. Admission Fee, Caution Money" oninput="updateHeadOnlyPreview()">
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold mb-1" style="font-size:11px;">Category</label>
                                        <select class="form-control form-control-sm" name="head_only_group_type" id="head_only_group_type">
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
                
                <!-- Right Side: Class-wise Fees Master Structure -->
                <div class="{{($getPermission->add == 1) ? 'col-md-7 pl-0' : 'col-md-12 pl-0'}}">
                    <div class="card card-outline card-orange ml-1">
                        <div class="card-header bg-primary py-2 d-flex align-items-center justify-content-between">
                            <h3 class="card-title font-weight-bold" style="font-size:14px;"><i class="fa fa-table"></i> &nbsp;Class-wise Fees Master</h3>
                            <div class="card-tools d-flex align-items-center" style="gap: 6px;">
                                <span class="badge badge-light" style="font-size:10px;">Structure & Breakdown</span>
                                <a href="{{url('fee_dashboard')}}" class="btn btn-back-header btn-xs font-weight-bold py-1 px-2 shadow-none text-nowrap" style="font-size:11px;"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
                            </div>
                        </div>  
                        
                        <div class="card-body p-2">
                                    @php
                                        $activeSessionId = $search['session_id'] ?? Session::get('session_id');
                                        if ($activeSessionId === 'all') {
                                            $activeSessionId = Session::get('session_id');
                                        }

                                        // Group all fees_master rows by class_type_id
                                        $feesMasterByClass = [];
                                        $totalAmountConfigured = 0;
                                        $distinctHeads = [];
                                        $coursesWithFees = [];
                                        $configuredClassIds = [];

                                        if (!empty($allFeesMasterRows)) {
                                            foreach ($allFeesMasterRows as $row) {
                                                $cId = $row->class_type_id;
                                                if (!isset($feesMasterByClass[$cId])) {
                                                    $feesMasterByClass[$cId] = [];
                                                }
                                                $feesMasterByClass[$cId][] = $row;
                                                $totalAmountConfigured += (float)($row->amount ?? 0);
                                                if (!empty($row->fees_group_id)) {
                                                    $distinctHeads[$row->fees_group_id] = true;
                                                }
                                                if (!empty($row->ClassTypes->course_id)) {
                                                    $coursesWithFees[$row->ClassTypes->course_id] = true;
                                                }
                                                $configuredClassIds[$cId] = true;
                                            }
                                        }

                                        $totalConfiguredCourses = count($coursesWithFees);
                                        $totalConfiguredClasses = count($configuredClassIds);
                                        $totalDistinctHeads = count($distinctHeads);
                                    @endphp

                                    <!-- Top KPI Summary Cards -->
                                    <div class="row mb-2">
                                        <div class="col-6 col-md-3 mb-1">
                                            <div class="kpi-chip-card">
                                                <div class="kpi-chip-icon icon-courses">
                                                    <i class="fa fa-graduation-cap"></i>
                                                </div>
                                                <div>
                                                    <div class="kpi-chip-val text-primary">{{ $totalConfiguredCourses }} <small class="text-muted" style="font-size:10px;">/ {{ count($courses ?? []) }}</small></div>
                                                    <div class="kpi-chip-label">Configured Courses</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-1">
                                            <div class="kpi-chip-card">
                                                <div class="kpi-chip-icon icon-classes">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                                <div>
                                                    <div class="kpi-chip-val text-info">{{ $totalConfiguredClasses }} <small class="text-muted" style="font-size:10px;">Semesters</small></div>
                                                    <div class="kpi-chip-label">Active Classes</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-1">
                                            <div class="kpi-chip-card">
                                                <div class="kpi-chip-icon icon-pool">
                                                    <i class="fa fa-inr"></i>
                                                </div>
                                                <div>
                                                    <div class="kpi-chip-val text-success">₹{{ number_format($totalAmountConfigured) }}</div>
                                                    <div class="kpi-chip-label">Total Fee Pool</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-1">
                                            <div class="kpi-chip-card">
                                                <div class="kpi-chip-icon icon-heads">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <div>
                                                    <div class="kpi-chip-val text-warning">{{ $totalDistinctHeads }} <small class="text-muted" style="font-size:10px;">Heads</small></div>
                                                    <div class="kpi-chip-label">Fee Heads Used</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Course Filter Pills Bar -->
                                    <div class="quick-filters-box">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="font-weight-bold mb-0">
                                                <i class="fa fa-filter"></i> Quick Course Filters:
                                            </label>
                                            <small>Click course to filter instantly</small>
                                        </div>
                                        <div class="course-filter-wrapper">
                                            <button type="button" class="course-scroll-btn" onclick="scrollCourseFilters(-220)" title="Scroll Left">
                                                <i class="fa fa-chevron-left"></i>
                                            </button>
                                            <div class="course-filter-scroll" id="course_pill_list">
                                                <button type="button" class="course-pill-btn active" data-course-id="all" onclick="filterByCourse('all', this)">
                                                    <i class="fa fa-globe"></i> All Courses <span class="badge-counter">{{ $totalConfiguredCourses }}</span>
                                                </button>
                                                @if(!empty($courses))
                                                    @foreach($courses as $c)
                                                        @php
                                                            $cClasses = !empty($allClassType) ? $allClassType->where('course_id', $c->id) : collect();
                                                            $cConfiguredCount = 0;
                                                            $cTotalFee = 0;
                                                            foreach($cClasses as $cl) {
                                                                if (isset($feesMasterByClass[$cl->id])) {
                                                                    $cConfiguredCount++;
                                                                    foreach($feesMasterByClass[$cl->id] as $fRow) {
                                                                        $cTotalFee += (float)($fRow->amount ?? 0);
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <button type="button" class="course-pill-btn" data-course-id="{{ $c->id }}" onclick="filterByCourse('{{ $c->id }}', this)">
                                                            <i class="fa fa-graduation-cap"></i> {{ $c->name }}
                                                            <span class="badge-counter">₹{{ number_format($cTotalFee) }}</span>
                                                        </button>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="course-scroll-btn" onclick="scrollCourseFilters(220)" title="Scroll Right">
                                                <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Filter Toolbar (Live Search + Category Filter + View Switcher + Export Suite) -->
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2" style="gap: 6px;">
                                        <!-- Live Search Input -->
                                        <div class="d-flex align-items-center flex-grow-1" style="max-width: 280px;">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0" style="height: 28px;"><i class="fa fa-search text-muted" style="font-size:11px;"></i></span>
                                                </div>
                                                <input type="text" id="fees_live_search" class="form-control form-control-sm border-left-0" placeholder="Live filter course, sem, head..." oninput="liveFilterFees(this.value)" style="height: 28px; font-size:11px;">
                                                <div class="input-group-append" id="clear_search_btn_container" style="display:none;">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="clearLiveFilter()" style="height: 28px; font-size:10px;"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Mode Switcher -->
                                        <div class="d-inline-flex align-items-center" role="group">
                                            <button type="button" id="btn_view_cards" class="view-switch-btn active" onclick="switchRightView('cards')" title="Course-wise structured cards view">
                                                <i class="fa fa-th-large"></i> Course Cards
                                            </button>
                                            <button type="button" id="btn_view_table" class="view-switch-btn" onclick="switchRightView('table')" title="Flat exportable data table view">
                                                <i class="fa fa-table"></i> Master Table
                                            </button>
                                        </div>

                                        <!-- Quick Export Toolbar -->
                                        <div class="d-inline-flex align-items-center" style="gap: 4px;">
                                            <span class="text-muted font-weight-bold mr-1" style="font-size: 10.5px;">Export:</span>
                                            <button type="button" class="quick-export-btn text-success" onclick="triggerDataExport('excel')" title="Export to Excel">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </button>
                                            <button type="button" class="quick-export-btn text-info" onclick="triggerDataExport('csv')" title="Export to CSV">
                                                <i class="fa fa-file-text-o"></i> CSV
                                            </button>
                                            <button type="button" class="quick-export-btn text-danger" onclick="triggerDataExport('pdf')" title="Export to PDF">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </button>
                                            <button type="button" class="quick-export-btn text-primary" onclick="triggerDataExport('print')" title="Print Fee Structure">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                        </div>
                                    </div>

                                    <!-- VIEW MODE 1: COURSE-WISE EXECUTIVE CARDS (DEFAULT) -->
                                    <div id="course_cards_container">
                                        @if(!empty($courses))
                                            @php $renderedCourses = 0; @endphp
                                            @foreach($courses as $c)
                                                @php
                                                    $cClasses = !empty($allClassType) ? $allClassType->where('course_id', $c->id) : collect();
                                                    $cConfiguredCount = 0;
                                                    $cTotalFee = 0;
                                                    $cClassRows = [];

                                                    foreach($cClasses as $cl) {
                                                        if (isset($feesMasterByClass[$cl->id])) {
                                                            $cConfiguredCount++;
                                                            $cClassRows[$cl->id] = $feesMasterByClass[$cl->id];
                                                            foreach($feesMasterByClass[$cl->id] as $fRow) {
                                                                $cTotalFee += (float)($fRow->amount ?? 0);
                                                            }
                                                        }
                                                    }
                                                    $dur = !empty($c->duration) ? (int)$c->duration : 3;
                                                    $totSem = !empty($c->total_semester) && (int)$c->total_semester > 0 ? (int)$c->total_semester : ($dur * 2);
                                                    $renderedCourses++;
                                                @endphp

                                                <div class="course-card course-group-item" id="course_card_{{ $c->id }}" data-course-id="{{ $c->id }}" data-course-name="{{ strtolower($c->name) }}">
                                                    <!-- Course Executive Banner -->
                                                    <div class="course-card-header">
                                                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                                            <span class="course-card-title">
                                                                <i class="fa fa-graduation-cap"></i> {{ $c->name }}
                                                            </span>
                                                            <span class="badge badge-light text-dark font-weight-bold" style="font-size:10px;">
                                                                {{ ($c->course_type == 'Yearly') ? ($dur . ' Year(s) - Yearly') : ($totSem . ' Semesters') }}
                                                            </span>
                                                            @if($cConfiguredCount > 0)
                                                                <span class="badge badge-warning text-dark font-weight-bold" style="font-size:10px;">
                                                                    {{ $cConfiguredCount }} / {{ $cClasses->count() }} Semesters Configured
                                                                </span>
                                                            @else
                                                                <span class="badge badge-secondary" style="font-size:10px;">Not Configured</span>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                                                            <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size:11.5px;">
                                                                ₹{{ number_format($cTotalFee) }} Total Course Fee
                                                            </span>
                                                            <button type="button" class="btn btn-xs btn-setup-course font-weight-bold shadow-sm" onclick="selectCourseForSetup('{{ $c->id }}')" style="font-size:10.5px;">
                                                                <i class="fa fa-plus-circle"></i> Setup in Form
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Course Body: Semester Breakdown Table -->
                                                    <div class="p-2">
                                                        @if($cConfiguredCount > 0)
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-striped table-hover mb-0 padding_table" style="font-size: 11.5px;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="140px"><i class="fa fa-calendar-o"></i> Semester / Class</th>
                                                                            <th>Fee Heads Breakdown (Category | Amount | Due Date)</th>
                                                                            <th width="110px" class="text-right">Total Semester Fee</th>
                                                                            @if($getPermission->edit == 1)
                                                                            <th width="45px" class="text-center">Action</th>
                                                                            @endif
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($cClasses as $cl)
                                                                            @if(isset($cClassRows[$cl->id]))
                                                                                @php
                                                                                    $semRows = $cClassRows[$cl->id];
                                                                                    $semTotal = 0;
                                                                                @endphp
                                                                                <tr class="course-class-row" data-class-name="{{ strtolower($cl->name) }}">
                                                                                    <td class="font-weight-bold text-primary align-middle">
                                                                                        <i class="fa fa-book text-muted mr-1"></i> {{ $cl->name }}
                                                                                    </td>
                                                                                    <td style="padding: 3px 6px;">
                                                                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                                                                            @foreach($semRows as $sRow)
                                                                                                @php
                                                                                                    $amt = (float)($sRow->amount ?? 0);
                                                                                                    $semTotal += $amt;
                                                                                                    $fgName = $sRow->feesGroup->name ?? 'Fee Head';
                                                                                                    $fgType = $sRow->feesGroup->group_type ?? 'academic';
                                                                                                    $badgeClass = 'badge-academic';
                                                                                                    if ($fgType === 'examination') $badgeClass = 'badge-examination';
                                                                                                    elseif ($fgType === 'practical') $badgeClass = 'badge-practical';
                                                                                                    elseif ($fgType === 'admission') $badgeClass = 'badge-admission';
                                                                                                    elseif ($fgType === 'facility') $badgeClass = 'badge-facility';
                                                                                                    elseif ($fgType === 'refundable') $badgeClass = 'badge-refundable';
                                                                                                    elseif ($fgType === 'hostel_transport') $badgeClass = 'badge-hostel_transport';

                                                                                                    $dueDateStr = !empty($sRow->installment_due_date) ? date('d-M-y', strtotime($sRow->installment_due_date)) : null;
                                                                                                @endphp
                                                                                                <div class="d-inline-flex align-items-center border rounded px-2 py-1 bg-white shadow-sm" style="font-size: 11px; gap: 5px;">
                                                                                                    <span class="badge {{ $badgeClass }}" style="font-size: 9px; padding: 2px 4px;">{{ ucfirst($fgType) }}</span>
                                                                                                    <span class="font-weight-bold text-dark">{{ $fgName }}:</span>
                                                                                                    <span class="font-weight-bold text-success">₹{{ number_format($amt) }}</span>
                                                                                                    @if($dueDateStr)
                                                                                                        <span class="badge badge-light border text-muted" style="font-size: 9px;" title="Due Date">
                                                                                                            <i class="fa fa-calendar-check-o text-info"></i> {{ $dueDateStr }}
                                                                                                        </span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="text-right align-middle font-weight-bold text-success" style="font-size: 12.5px;">
                                                                                        ₹{{ number_format($semTotal) }}
                                                                                    </td>
                                                                                    @if($getPermission->edit == 1)
                                                                                    <td class="text-center align-middle">
                                                                                        <a href="{{ url('feesMasterEdit') }}/{{ $cl->id }}" class="btn btn-primary btn-xs" title="Edit Semester Fees">
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                    @endif
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="empty-course-box">
                                                                <div class="empty-msg">
                                                                    <i class="fa fa-info-circle"></i> No fee structure configured for <strong>{{ $c->name }}</strong> in this session.
                                                                </div>
                                                                <button type="button" class="btn btn-configure-course shadow-sm" onclick="selectCourseForSetup('{{ $c->id }}')">
                                                                    <i class="fa fa-plus-circle"></i> Click Here to Configure {{ $c->name }}
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-light text-center border">
                                                No courses available to display.
                                            </div>
                                        @endif

                                        <div id="no_course_search_results" class="p-4 text-center border rounded bg-white mt-2" style="display:none; border: 1.5px dashed #cbd5e1 !important;">
                                            <i class="fa fa-search text-muted mb-2" style="font-size:24px;"></i>
                                            <h6 class="font-weight-bold text-dark mb-1" style="font-size:13px;">No Matching Fee Structures Found</h6>
                                            <p class="text-muted mb-2" style="font-size:11px;">Try clearing search keywords or selecting "All Courses".</p>
                                            <button type="button" class="btn btn-xs btn-primary font-weight-bold" onclick="clearLiveFilter()">Reset Filter</button>
                                        </div>
                                    </div>

                                    <!-- VIEW MODE 2: MASTER FLAT DATA TABLE (DATATABLES EXPORTABLE) -->
                                    <div id="master_table_container" style="display: none;">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table w-100">
                                                <thead>
                                                    <tr role="row">
                                                        <th width="30px">#</th>
                                                        <th>Course</th>
                                                        <th>Semester / Class</th>
                                                        <th>Fee Head Name</th>
                                                        <th>Category</th>
                                                        <th class="text-right">Amount (₹)</th>
                                                        <th>Due Date</th>
                                                        @if($getPermission->edit == 1)
                                                        <th width="45px" class="text-center">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($allFeesMasterRows))
                                                        @php $mCount = 1; @endphp
                                                        @foreach($allFeesMasterRows as $row)
                                                            @php
                                                                $fgType = $row->feesGroup->group_type ?? 'academic';
                                                                $badgeClass = 'badge-academic';
                                                                if ($fgType === 'examination') $badgeClass = 'badge-examination';
                                                                elseif ($fgType === 'practical') $badgeClass = 'badge-practical';
                                                                elseif ($fgType === 'admission') $badgeClass = 'badge-admission';
                                                                elseif ($fgType === 'facility') $badgeClass = 'badge-facility';
                                                                elseif ($fgType === 'refundable') $badgeClass = 'badge-refundable';
                                                                elseif ($fgType === 'hostel_transport') $badgeClass = 'badge-hostel_transport';
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $mCount++ }}</td>
                                                                <td><strong>{{ $row->ClassTypes->course->name ?? 'Course' }}</strong></td>
                                                                <td><span class="text-primary font-weight-bold">{{ $row->ClassTypes->name ?? '' }}</span></td>
                                                                <td><strong class="text-dark">{{ $row->feesGroup->name ?? 'N/A' }}</strong></td>
                                                                <td><span class="badge {{ $badgeClass }}">{{ ucfirst($fgType) }}</span></td>
                                                                <td class="text-right font-weight-bold text-success">₹{{ number_format((float)($row->amount ?? 0)) }}</td>
                                                                <td>
                                                                    {{ !empty($row->installment_due_date) ? date('d-M-Y', strtotime($row->installment_due_date)) : 'No Due Date' }}
                                                                </td>
                                                                @if($getPermission->edit == 1)
                                                                <td class="text-center">
                                                                    <a href="{{ url('feesMasterEdit') }}/{{ $row->class_type_id }}" class="btn btn-primary btn-xs" title="Edit Class Fees">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
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
            <div class="modal-header bg-danger py-2 text-white">
                <h5 class="modal-title text-white font-weight-bold" id="exampleModalLabel" style="font-size: 14px;"><i class="fa fa-trash"></i> {{ __('common.Delete Confirmation') }}</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
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

<!-- Modals Section for Unified Fees Setup -->

<!-- 1. Registration / Special Fee Modal -->
<div class="modal fade fees-unified-page" id="special_fee_modal" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-2">
        <h5 class="modal-title font-weight-bold" style="font-size:14px;"><i class="fa fa-star"></i> Assign Amount for Registration / Special Fee Heads</h5>
        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('specialFeesMaster') }}" method="POST" class="submit-form reload">
        @csrf
        <div class="modal-body p-3">
          <div class="col-md-5 pl-0 mb-2">
            <div class="form-group mb-2">
              <label class="font-weight-bold" style="font-size:11.5px;">{{ __('Course') }}<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm select2" id="special_course_id" name="course_id" required>
                <option value="">-- {{ __('common.Select') }} Course --</option>
                @if(!empty($courses))
                  @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>

          <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm mb-0" style="font-size: 11.5px;">
              <thead class="bg-light">
                <tr>
                  <th>{{ __('fees.Fees Group') }}* &nbsp; (Type : Registration)</th>
                  <th width="100px">{{ __('NRI') }}*</th>
                  <th width="100px">{{ __('Management') }}*</th>
                  <th width="100px">{{ __('Govt.') }}*</th>
                  <th width="120px" class="text-center">Partial Payable (50%)</th>
                </tr>
              </thead>
              <tbody id="table_bodyregistration">
                <tr>
                  <td colspan="5" class="text-center text-muted py-3">Please select a course to load data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="modal-footer py-1">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
          <button type="submit" class="btn btn-primary btn-sm submit-btn font-weight-bold"><i class="fa fa-check"></i> Update Registration Fees</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 2. Student Fee Assign Modal (Bulk) -->
<div class="modal fade fees-unified-page" id="students_list_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h5 class="modal-title font-weight-bold" style="font-size:14px;"><i class="fa fa-users"></i> Assign Fee Structure to Students for Selected Class</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignFeesMultiple" action="{{ url('assignFeesMultipleStudents') }}" method="POST">
            @csrf    
            <div class="modal-body p-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold mb-1" style="font-size:11px;">{{ __('Course') }}</label>
                            <select class="form-control form-control-sm select2" id="bulk_course_id" name="course_id">
                                <option value="">-- Select Course --</option>
                                @if(!empty($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold mb-1" style="font-size:11px;">{{ __('common.Class') }} / Sem*</label>
                            <select class="form-control form-control-sm select2" id="bulk_class_type_id" name="class_type_id" required>
                              <option value="">-- Select Class / Sem --</option>
                              @if(!empty($classType))
                                @foreach($classType as $type)
                                  <option value="{{ $type->id }}">{{ $type->name ?? ''  }}</option>
                                @endforeach
                              @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold mb-1" style="font-size:11px;">{{ __('student.Admission No.') }}</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Filter Admission No." name="admissionNo" id="bulk_admission_no">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold mb-1" style="font-size:11px;">Fees Master Heads to Assign*</label>
                            <select class="form-control form-control-sm select2" multiple id="bulk_fees_master_ids" name="fees_master_ids[]" required>
                            </select>
                        </div>
                    </div>
                </div>
                        
                <div class="table-responsive border rounded mb-2" style="max-height:280px; overflow-y:auto;">
                    <table class="table table-bordered table-striped table-sm text-center mb-0" style="font-size:11.5px;">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th width="30px"><input type='checkbox' id="all_students" /></th>
                                <th>Student Name</th>
                                <th>{{ __('student.Admission No.') }}</th>
                                <th>Mobile</th>
                                <th>Father Name</th>
                                <th>Assigned Fees</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_students_list">
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Please select a class above to load students list</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-info py-1 px-2 mb-0" style="font-size:11px;">
                    <i class="fa fa-info-circle"></i> <b>Note:</b> If any selected fee head is already assigned to a student, the system will skip that head and assign the remaining heads.
                </div>
            </div>
            
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                <button type="submit" class="btn btn-success btn-sm font-weight-bold"><i class="fa fa-check"></i> Assign Fees to Selected Students</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Student Fee Modification Modal -->
<div class="modal fade fees-unified-page" id="fees_modification" tabindex="-1" aria-labelledby="feesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h5 class="modal-title font-weight-bold" style="font-size:14px;"><i class="fa fa-pencil-square-o"></i> Student Fee Modification & Concession</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <form id="feesForm" class="mb-2">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <div class="form-group mb-1">
                                <label for="admission_modification" class="font-weight-bold mb-0" style="font-size:11px;">{{ __('student.Admission No.') }}</label>
                                <input type="text" class="form-control form-control-sm" id="admission_modification" placeholder="Admission No.">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-1">
                                <label for="modification_course_id" class="font-weight-bold mb-0" style="font-size:11px;">{{ __('Course') }}</label>
                                <select class="form-control form-control-sm select2" id="modification_course_id" name="modification_course_id">
                                    <option value="">-- Select Course --</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-1">
                                <label for="class_modification" class="font-weight-bold mb-0" style="font-size:11px;">{{ __('common.Class') }}</label>
                                <select class="form-control form-control-sm select2" id="class_modification" name="class_type_id">
                                    <option value="">-- Select Class --</option>
                                    @if(!empty($classType))
                                    @foreach($classType as $type)
                                    <option value="{{ $type->id }}">{{ $type->name ?? '' }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-block font-weight-bold" id="searchButton" style="height:31px;">
                                    <i class="fa fa-spinner fa-spin d-none" id="waitBtn"></i> <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-1">
                            <small class="text-danger d-block" style="font-size:10.5px; line-height:1.2;">
                                1. Verify if there are any payments under the current fee head. If payments exist, modifications are not allowed.<br>
                                2. Changes are auto-saved in the background as soon as you change amount or discount.
                            </small>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive border rounded mt-2" style="max-height:300px; overflow-y:auto;"> 
                    <table class="table table-bordered table-striped table-sm text-center mb-0" style="font-size:11.5px;">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th>Name</th>
                                <th>{{ __('student.Admission No.') }}</th>
                                <th>Mobile</th>
                                <th>Fees Assign Detail</th>
                                <th style="width:100px;">Discount (% / Amt)</th>
                                <th>Due Date</th>
                                <th style="width:70px;">Fine %</th>
                                <th style="width:80px;">Refundable</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_modification">
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">Search with Admission No. or Class to view student assigned fees</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
function scrollCourseFilters(offset) {
    var container = document.getElementById('course_pill_list');
    if (container) {
        container.scrollBy({
            left: offset,
            behavior: 'smooth'
        });
    }
}

var currentMode = 'semester';
var currentCourseClasses = [];

var allDefaultClasses = [
    @if(!empty($allClassType))
        @foreach($allClassType as $type)
            { id: "{{ $type->id }}", name: "{{ $type->name }}" },
        @endforeach
    @endif
];

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

function applyDueDateSchedule() {
    var startDateInput = document.getElementById('schedule_start_date');
    if (!startDateInput) return;
    var startDateVal = startDateInput.value;
    if (!startDateVal) return;
    
    var intervalMonths = parseInt(document.getElementById('schedule_interval').value) || 6;
    var dueDayRule = document.getElementById('schedule_due_day').value;
    
    var startParts = startDateVal.split('-');
    if (startParts.length < 3) return;
    
    var baseYear = parseInt(startParts[0]);
    var baseMonth = parseInt(startParts[1]) - 1; // 0-indexed month
    var baseDay = parseInt(startParts[2]);

    var dueInputs = document.querySelectorAll('.sem-row-due');
    dueInputs.forEach(function(input, idx) {
        var targetMonthTotal = baseMonth + (idx * intervalMonths);
        var targetYear = baseYear + Math.floor(targetMonthTotal / 12);
        var targetMonth = targetMonthTotal % 12;
        
        var targetDay = baseDay;
        if (dueDayRule === 'last') {
            targetDay = new Date(targetYear, targetMonth + 1, 0).getDate();
        } else if (dueDayRule !== 'same') {
            targetDay = parseInt(dueDayRule);
        }
        
        // Ensure day doesn't exceed total days in that month (e.g. Feb 28/29)
        var maxDaysInMonth = new Date(targetYear, targetMonth + 1, 0).getDate();
        if (targetDay > maxDaysInMonth) {
            targetDay = maxDaysInMonth;
        }
        
        var formattedMonth = String(targetMonth + 1).padStart(2, '0');
        var formattedDay = String(targetDay).padStart(2, '0');
        input.value = targetYear + '-' + formattedMonth + '-' + formattedDay;
    });
}

function clearDueDates() {
    var dueInputs = document.querySelectorAll('.sem-row-due');
    dueInputs.forEach(function(input) {
        input.value = '';
    });
}

function updateSemPreview() {
    var baseName = document.getElementById('sem_base_name').value.trim() || 'Tuition Fee';
    var count = parseInt(document.getElementById('sem_count').value) || 6;
    var commonAmount = document.getElementById('batch_common_amount').value || '15000';

    var html = '';

    if (currentCourseClasses.length > 0) {
        var loopCount = Math.min(count, currentCourseClasses.length);
        html += '<div class="table-responsive" style="height: auto; border: 1px solid #c2d4ea; border-radius: 4px;">';
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

    // Auto-apply schedule if start date is set
    applyDueDateSchedule();
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

// Right Panel View Mode Switcher (Cards vs Table)
function switchRightView(mode) {
    if (mode === 'cards') {
        $('#btn_view_cards').addClass('active');
        $('#btn_view_table').removeClass('active');
        $('#course_cards_container').show();
        $('#master_table_container').hide();
    } else {
        $('#btn_view_cards').removeClass('active');
        $('#btn_view_table').addClass('active');
        $('#course_cards_container').hide();
        $('#master_table_container').show();
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().columns.adjust().responsive.recalc();
        }
    }
}

// Course Quick Filter Pills Handler
function filterByCourse(courseId, btnElement) {
    $('.course-pill-btn').removeClass('active');
    if (btnElement) {
        $(btnElement).addClass('active');
    }

    if (courseId === 'all') {
        $('.course-group-item').show();
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().column(1).search('').draw();
        }
    } else {
        $('.course-group-item').hide();
        $('#course_card_' + courseId).show();

        var courseNameText = $(btnElement).text().trim().replace(/₹[0-9,]+/g, '').trim();
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().column(1).search(courseNameText).draw();
        }
    }
    checkVisibleCourseCards();
}

// Live Search Filter across Course Cards and Flat Table
function liveFilterFees(query) {
    query = (query || '').toLowerCase().trim();
    if (query.length > 0) {
        $('#clear_search_btn_container').show();
    } else {
        $('#clear_search_btn_container').hide();
    }

    var visibleCount = 0;
    $('.course-group-item').each(function() {
        var card = $(this);
        var courseText = (card.data('course-name') || '').toLowerCase();
        var cardContent = card.text().toLowerCase();

        if (query === '' || courseText.indexOf(query) > -1 || cardContent.indexOf(query) > -1) {
            card.show();
            visibleCount++;
        } else {
            card.hide();
        }
    });

    if (visibleCount === 0) {
        $('#no_course_search_results').show();
    } else {
        $('#no_course_search_results').hide();
    }

    // Also search DataTable in table view
    if ($.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().search(query).draw();
    }
}

// Clear Live Search Filter
function clearLiveFilter() {
    $('#fees_live_search').val('');
    $('#clear_search_btn_container').hide();
    $('.course-pill-btn[data-course-id="all"]').click();
    liveFilterFees('');
}

function checkVisibleCourseCards() {
    var visible = $('.course-group-item:visible').length;
    if (visible === 0) {
        $('#no_course_search_results').show();
    } else {
        $('#no_course_search_results').hide();
    }
}

// Direct Trigger for DataTables Export Suite
function triggerDataExport(type) {
    // Switch to table view first so DataTable is active and visible
    switchRightView('table');
    
    setTimeout(function() {
        if (!$.fn.DataTable.isDataTable('#example1')) {
            alert('DataTable is initializing, please try again.');
            return;
        }
        var dt = $('#example1').DataTable();
        if (type === 'excel') {
            $('.buttons-excel').trigger('click');
        } else if (type === 'csv') {
            $('.buttons-csv').trigger('click');
        } else if (type === 'pdf') {
            $('.buttons-pdf').trigger('click');
        } else if (type === 'print') {
            $('.buttons-print').trigger('click');
        } else if (type === 'copy') {
            $('.buttons-copy').trigger('click');
        }
    }, 150);
}

// Auto-select course in left unified setup form
function selectCourseForSetup(courseId) {
    var sel = document.getElementById('course_selector');
    if (!sel) return;
    sel.value = courseId;
    $(sel).trigger('change');
    switchMode('semester');
    
    // Smooth scroll to left form
    $('html, body').animate({
        scrollTop: $('#course_selector_box').offset().top - 70
    }, 400);
}

function getStudents(class_type_id, bulk_admission_no, admission_type_id) {
    $('#tbody_students_list').html('<tr><td colspan="6" class="text-center py-2"><i class="fa fa-spinner fa-spin"></i> Loading students...</td></tr>');
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getStudentsList') }}",
        method: 'POST',
        data: {
            admissionNo: bulk_admission_no,
            class_type_id: class_type_id,
            admission_type_id: admission_type_id
        },
        success: function(response) {
            $('#tbody_students_list').html(response);
            $('#all_students').prop('checked', false);
            $('#bulk_class_type_id').val(class_type_id);
        },
        error: function(xhr) {
            $('#tbody_students_list').html('<tr><td colspan="6" class="text-center text-danger py-2">Error loading students</td></tr>');
        }
    });
}

function getMasterData(class_type_id) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getMasterData') }}",
        method: 'POST',
        data: { class_type_id: class_type_id },
        success: function(response) {
            var masterData = [];
            if (response && response.length > 0) {
                $('#bulk_fees_master_ids').empty();
                for (var i = 0; i < response.length; i++) {
                    var code = '<option value="' + response[i].id + '" selected>' + response[i].fees_group_name + ' (₹' + (response[i].amount || 0) + ')</option>';
                    masterData.push(code);
                }
                $('#bulk_fees_master_ids').html(masterData.join(''));
            } else {
                $('#bulk_fees_master_ids').empty();
            }
        }
    });
}

function updateClassDropdownByCourse(courseId, classSelect, defaultClasses) {
    if (courseId) {
        $.ajax({
            url: "{{ url('getClassesByCourse') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", course_id: courseId },
            dataType: "json",
            success: function(data) {
                classSelect.empty().append('<option value="">-- {{ __("common.Select") }} --</option>');
                if (data && data.length > 0) {
                    $.each(data, function(key, val) {
                        classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                    });
                }
                classSelect.val('').trigger('change');
            }
        });
    } else {
        classSelect.empty().append('<option value="">-- {{ __("common.Select") }} --</option>');
        if (defaultClasses && defaultClasses.length > 0) {
            $.each(defaultClasses, function(key, val) {
                classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
            });
        }
        classSelect.val('').trigger('change');
    }
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

    // Select All Checkbox for Student Assignment
    $('#all_students').click(function() {
        $('.student_select_checkbox').prop('checked', $(this).prop('checked'));
    });
    
    $(document).on('click', '.student_select_checkbox', function() {
        var total = $('.student_select_checkbox').length;
        var checked = $('.student_select_checkbox:checked').length;
        $('#all_students').prop('checked', total === checked);
    });

    $('#bulk_class_type_id').change(function() {
        var class_type_id = $(this).val();
        var bulk_admission_no = $('#bulk_admission_no').val();
        if (!class_type_id) {
            $('#tbody_students_list').html('<tr><td colspan="6" class="text-center text-muted py-2">Please select class</td></tr>');
            $('#bulk_fees_master_ids').empty();
        } else {
            getStudents(class_type_id, bulk_admission_no, null);
            getMasterData(class_type_id);
        }
    });

    $('#bulk_admission_no').blur(function() {
        var class_type_id = $('#bulk_class_type_id').val();
        var bulk_admission_no = $(this).val();
        if (class_type_id) {
            getStudents(class_type_id, bulk_admission_no, null);
        }
    });

    $('#assignFeesMultiple').on('submit', function(event) {
        var checkedCount = $('.student_select_checkbox:checked').length;
        if (checkedCount === 0) {
            event.preventDefault();
            alert("Please select at least one student!");
            return false;
        }
    });

    // Special Fees / Registration Modal Course Change
    $("#special_course_id").change(function() {
        var course_id = $(this).val();
        if (course_id) {
            $("#table_bodyregistration").html('<tr><td colspan="5" class="text-center py-2"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('specialFeesMastercourseData') }}",
                method: 'POST',
                data: { course_id: course_id },
                success: function(response) {
                    $('#table_bodyregistration').html(response);
                },
                error: function() {
                    $('#table_bodyregistration').html('<tr><td colspan="5" class="text-center text-danger py-2">Error loading registration fee heads</td></tr>');
                }
            });
        } else {
            $('#table_bodyregistration').html('<tr><td colspan="5" class="text-center text-muted py-2">Please select a course to load data</td></tr>');
        }
    });

    // Student Fee Modification Search Handler
    $('#searchButton').click(function() {
        var admissionNo = $('#admission_modification').val();
        var classTypeId = $('#class_modification').val();
        $('#waitBtn').removeClass('d-none');
        $('#tbody_modification').html('<tr><td colspan="8" class="text-center py-2"><i class="fa fa-spinner fa-spin"></i> Searching...</td></tr>');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ url('feesModification') }}",
            method: 'POST',
            data: {
                admissionNo: admissionNo,
                class_type_id: classTypeId
            },
            success: function(response) {
                $('#waitBtn').addClass('d-none');
                $('#tbody_modification').html(response);
            },
            error: function(xhr) {
                $('#waitBtn').addClass('d-none');
                $('#tbody_modification').html('<tr><td colspan="8" class="text-center text-danger py-2">Error searching student fees</td></tr>');
            }
        });
    });

    // Student Fee Modification - Live Blur Auto-Save Handler
    $('#tbody_modification').on('blur', '.fees_assign_detail', function() {
        var currentTd = $(this);
        var id = currentTd.data('detail_id');
        var value = currentTd.val();
        var oldValue = currentTd.data('old_value');
        var payFees = currentTd.data('pay_fees');
        var field = currentTd.attr('name');
        var discountType = currentTd.data('type') || '';
        var discountValue = currentTd.val();

        if (payFees == 0) {
            if (value !== oldValue) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{ url('updateAssignedFees') }}",
                    method: 'POST',
                    data: {
                        fees_assign_detail_id: id,
                        value: value,
                        field: field,
                        discountType: discountType,
                        discountValue: discountValue
                    },
                    success: function(response) {
                        currentTd.data('old_value', value);
                    },
                    error: function(xhr) {
                        alert('An error occurred updating fee.');
                    }
                });
            }
        } else {
            alert('Cannot modify fees: payments already exist under this fee head for this student.');
            currentTd.val(oldValue);
        }
    });

    $('#tbody_modification').on('keyup', '.discountInPercent', function() {
        var discountInPercentId = $(this).data('id');
        var discountInPercent = parseFloat($(this).val());
        var feesGroupAmount = parseFloat($('#feesGroupAmount_' + discountInPercentId).val());
        var discountInAmount = (discountInPercent * feesGroupAmount) / 100;
        $('#discountInAmount_' + discountInPercentId).val(isNaN(discountInAmount) ? '' : discountInAmount.toFixed(2));
    });

    $(document).on('change', '#bulk_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#bulk_class_type_id'), allDefaultClasses);
    });

    $(document).on('change', '#modification_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#class_modification'), allDefaultClasses);
    });
});
</script>

@endsection