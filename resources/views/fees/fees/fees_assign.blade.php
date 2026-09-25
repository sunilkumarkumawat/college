@extends('layout.app')
@section('content')

@php
    $courses = Helper::getCourses();
    $batches = Helper::getBatch();
    $getFeesGroup = Helper::getFeesGroup();
    $getSession = Helper::getSession();
@endphp

<style>
/* Page & Container */
.content-wrapper {
    background-color: #f4f6f9;
}

/* Card Header - Solid Brand Dark with Crisp White Text & Right-Aligned Tools */
.card-outline.card-orange .card-header.bg-primary {
    background-color: #002c54 !important;
    background: #002c54 !important;
    color: #ffffff !important;
    padding: 8px 15px !important;
    border-bottom: 2px solid #001a33 !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    width: 100% !important;
}
.card-header.bg-primary h3,
.card-header.bg-primary .card-title {
    color: #ffffff !important;
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    margin: 0 !important;
    float: none !important;
    display: flex !important;
    align-items: center !important;
}
.card-header.bg-primary .card-tools {
    margin-left: auto !important;
    margin-right: 0 !important;
    float: none !important;
    position: static !important;
    display: flex !important;
    align-items: center !important;
}
.card-header.bg-primary .btn {
    background-color: rgba(255, 255, 255, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.45) !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    padding: 4px 10px !important;
}
.card-header.bg-primary .btn:hover {
    background-color: rgba(255, 255, 255, 0.35) !important;
    color: #ffffff !important;
    border-color: #ffffff !important;
}

/* Filter Section */
.filter-label {
    font-size: 12.5px;
    font-weight: 700;
    margin-bottom: 4px;
    color: #1e293b;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Table Header - Solid Dark with Pure White Font */
.table-assign thead,
.table-assign thead tr,
.table-assign thead th {
    background-color: #002c54 !important;
    background: #002c54 !important;
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    padding: 8px 6px !important;
    vertical-align: middle !important;
    border: 1px solid #103a61 !important;
    text-align: center;
}
.table-assign thead th,
.table-assign thead th * {
    color: #ffffff !important;
}

/* Table Body */
.table-assign tbody td {
    padding: 6px 8px !important;
    font-size: 13px !important;
    vertical-align: middle !important;
    color: #0f172a !important;
}
.table-assign tbody tr:hover {
    background-color: #f1f5f9 !important;
}

/* Interactive Real-Time Fee Head Chips */
.fee-head-chip {
    display: inline-flex;
    align-items: center;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    margin: 2px 2px;
    transition: all 0.2s ease;
    user-select: none;
}
.chip-assigned {
    background-color: #e0f2fe;
    color: #0369a1;
    border: 1px solid #0284c7;
}
.chip-assigned:hover {
    background-color: #bae6fd;
}
.chip-unassigned {
    background-color: #f8fafc;
    color: #64748b;
    border: 1px solid #cbd5e1;
}
.chip-unassigned:hover {
    background-color: #f1f5f9;
    border-color: #94a3b8;
}
.chip-name {
    font-weight: 600;
    margin-right: 4px;
}
.chip-amt {
    font-weight: 700;
    color: #0f172a;
}
.chip-assigned .chip-amt {
    color: #0369a1;
}

/* Badges */
.badge-secondary {
    background-color: #475569 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
}

/* Select2 Customization */
.select2-container .select2-selection--single,
.select2-container .select2-selection--multiple {
    min-height: 33px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 4px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 30px !important;
    font-size: 13px !important;
    color: #1e293b !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    padding: 1px 4px !important;
    font-size: 12.5px !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #002c54 !important;
    border: 1px solid #001a33 !important;
    color: #ffffff !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    padding: 2px 8px !important;
    margin-top: 3px !important;
    border-radius: 4px !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #ffffff !important;
    margin-right: 6px !important;
    font-weight: bold !important;
    opacity: 0.9 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #facc15 !important;
    opacity: 1 !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #002c54 !important;
    color: #ffffff !important;
}

/* Mid-bar Strip */
.mid-action-strip {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 6px 12px;
}

/* Toast Notifications */
#fee_toast_box {
    position: fixed;
    top: 20px;
    right: 25px;
    z-index: 9999;
    min-width: 280px;
}
</style>

<div id="fee_toast_box"></div>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange mb-3 shadow-sm">
                        
                        <!-- Card Header -->
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold">
                                <i class="fa fa-users mr-1"></i> Student Fee Assign
                            </h3>
                            <div class="card-tools">
                                <a href="{{ url('feesGroup') }}" class="btn btn-primary btn-sm mr-2" title="Fees Group & Master">
                                    <i class="fa fa-money mr-1"></i> Fees Structure
                                </a>
                                <a href="{{ url('fee_dashboard') }}" class="btn btn-primary btn-sm" title="Back">
                                    <i class="fa fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            @include('layout.message')

                            <!-- Filter Inputs Row in Perfect Sequence: Course -> Batch -> Search Student -> Fee Heads -->
                            <div class="row mb-2">
                                <!-- 1. Course Select -->
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="filter-label">
                                        <span>Course <span class="text-danger">*</span></span>
                                    </label>
                                    <select class="form-control form-control-sm select2" id="filter_course_id" name="course_id" style="width: 100%;">
                                        <option value="">-- Select Course --</option>
                                        @if(!empty($courses))
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- 2. Batch Select -->
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="filter-label">
                                        <span>Batch <span class="text-danger">*</span></span>
                                    </label>
                                    <select class="form-control form-control-sm select2" id="filter_batch" name="batch" style="width: 100%;">
                                        <option value="">-- Select Batch --</option>
                                        @if(!empty($batches))
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->name ?? '' }}">{{ $batch->name ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- 3. Admission No / Student ID / Name Search -->
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="filter-label">
                                        <span>Student ID / Name / Mobile</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" id="filter_admission_no" name="admissionNo" placeholder="Type to filter instantly...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btn_search_students" title="Search">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Fees Master Heads Multi-Select for Quick Bulk Assign -->
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="filter-label">
                                        <span>Fee Heads Multi-Select</span>
                                        <span class="small font-weight-normal">
                                            <a href="javascript:void(0)" id="btn_select_all_filter_heads" class="text-primary mr-1">All</a>
                                            <a href="javascript:void(0)" id="btn_deselect_all_filter_heads" class="text-muted">Clear</a>
                                        </span>
                                    </label>
                                    <select class="form-control form-control-sm select2" multiple="multiple" id="filter_fees_master_ids" name="fees_master_ids[]" data-placeholder="-- All Course Fee Heads --" style="width: 100%;">
                                    </select>
                                </div>
                            </div>

                            <!-- Fast Action Toolbar & Real-Time Status Strip -->
                            <div class="mid-action-strip d-flex flex-wrap justify-content-between align-items-center mb-2">
                                <div class="mb-1 mb-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
                                    <button type="button" class="btn btn-warning btn-xs font-weight-bold shadow-xs text-dark" id="btn_quick_apply_all_loaded" style="font-size: 11.5px; padding: 4px 10px;">
                                        <i class="fa fa-bolt text-dark mr-1"></i> Quick Apply All Heads to ALL Loaded (<span class="total_students_count_text">0</span>)
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs font-weight-bold shadow-xs" id="btn_bulk_assign_realtime" style="font-size: 11.5px; padding: 4px 10px;">
                                        <i class="fa fa-check-circle mr-1"></i> Assign to Selected Students (<span class="selected_students_count_text">0</span>)
                                    </button>
                                    <span class="badge badge-light border text-muted py-1 px-2" style="font-size: 11px;">
                                        <i class="fa fa-info-circle text-primary mr-1"></i> Click any head or Check All button to assign in real-time
                                    </span>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 4px;">
                                    <span class="badge px-2 py-1" id="total_students_badge" style="background-color: #334155; color: #ffffff; font-size: 12px; font-weight: 500;">Total: 0</span>
                                    <span class="badge px-2 py-1 mr-1" id="selected_students_badge" style="background-color: #16a34a; color: #ffffff; font-size: 12px; font-weight: 600;">Selected: 0</span>
                                    <button type="button" class="btn btn-default btn-xs border" id="btn_quick_select_all" style="font-size: 11.5px; padding: 3px 8px;" title="Select all loaded students">
                                        <i class="fa fa-check-square text-primary mr-1"></i>Select All
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs border" id="btn_quick_deselect_all" style="font-size: 11.5px; padding: 3px 8px;" title="Deselect all">
                                        <i class="fa fa-square-o text-danger mr-1"></i>Deselect
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs border" id="btn_clear_filters" style="font-size: 11.5px; padding: 3px 8px;" title="Reset Filters">
                                        <i class="fa fa-refresh text-secondary mr-1"></i>Reset
                                    </button>
                                </div>
                            </div>

                            <!-- High Density Students Table Container -->
                            <div class="table-responsive border rounded" style="max-height: 540px; overflow-y: auto;">
                                <table class="table table-bordered table-striped table-hover table-sm mb-0 table-assign" id="students_assign_table">
                                    <thead style="position: sticky; top: 0; z-index: 10;">
                                        <tr>
                                            <th style="width: 40px; text-align: center; vertical-align: middle;">
                                                <input type="checkbox" id="all_students" style="cursor: pointer;" title="Select All">
                                            </th>
                                            <th style="width: 40px; text-align: center; vertical-align: middle;">#</th>
                                            <th style="text-align: left; vertical-align: middle; min-width: 140px;">Student Name</th>
                                            <th style="width: 110px; text-align: center; vertical-align: middle;">Admission No.</th>
                                            <th style="width: 120px; text-align: center; vertical-align: middle;">Class / Sem</th>
                                            <th style="text-align: left; vertical-align: middle; min-width: 120px;">Father's Name</th>
                                            <th style="width: 100px; text-align: center; vertical-align: middle;">Mobile No.</th>
                                            <th style="text-align: left; vertical-align: middle; min-width: 270px;">Course Fee Heads (Click to Toggle / Auto-Save)</th>
                                            <th style="width: 110px; text-align: center; vertical-align: middle;">Total Fee</th>
                                            <th style="width: 80px; text-align: center; vertical-align: middle;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_students_list">
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-muted">
                                                <i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i>
                                                Please select both <b>Course</b> and <b>Batch</b> above to view and assign students.
                                            </td>
                                        </tr>
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

<!-- Student Fee Details & Modification Modal -->
<div class="modal fade" id="studentFeeEditModal" tabindex="-1" role="dialog" aria-labelledby="studentFeeEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" id="studentFeeEditModalBody">
            <div class="text-center py-5">
                <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                <p class="mt-2 text-muted font-weight-bold">Loading Student Fee Details...</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom Theme Confirmation Modal for Fee Assign / Clear Actions -->
<div class="modal fade" id="feeAssignConfirmModal" tabindex="-1" role="dialog" aria-labelledby="feeAssignConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 480px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header py-3 px-4 text-white" id="feeConfirmModalHeader" style="background: linear-gradient(135deg, #002c54 0%, #00172d 100%); border-bottom: 2px solid #ff7b00;">
                <h5 class="modal-title font-weight-bold d-flex align-items-center" id="feeAssignConfirmModalLabel" style="font-size: 16px; letter-spacing: 0.3px; margin: 0;">
                    <i class="fa fa-question-circle mr-2 text-warning" id="feeConfirmIcon"></i>
                    <span id="feeConfirmTitle">Confirm Action</span>
                </h5>
                <button type="button" class="close text-white btn-close-modal" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: none; outline: none; cursor: pointer;">
                    <span aria-hidden="true" style="font-size: 22px;">&times;</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-4 text-center">
                <!-- Action Icon Badge -->
                <div class="mb-3">
                    <div id="feeConfirmIconWrapper" class="d-inline-flex justify-content-center align-items-center rounded-circle" style="width: 65px; height: 65px; background: rgba(0, 44, 84, 0.08);">
                        <i class="fa fa-check-square-o fa-2x text-success" id="feeConfirmBigIcon"></i>
                    </div>
                </div>

                <!-- Headline -->
                <h6 class="font-weight-bold text-dark mb-2" id="feeConfirmHeadline" style="font-size: 16px;">
                    Assign All Fee Heads?
                </h6>

                <!-- Context Card -->
                <div class="p-3 mb-3 text-left rounded" id="feeConfirmStudentInfoBox" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 13px;">
                    <div class="d-flex justify-content-between mb-1" id="feeConfirmStudentNameRow">
                        <span class="text-muted"><i class="fa fa-user mr-1 text-primary"></i> Student Name:</span>
                        <strong class="text-dark" id="feeConfirmStudentName">-</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1" id="feeConfirmStudentAdmRow">
                        <span class="text-muted"><i class="fa fa-id-card mr-1 text-secondary"></i> Admission No:</span>
                        <strong class="badge badge-secondary px-2 py-1" id="feeConfirmStudentAdmNo">-</strong>
                    </div>
                    <div class="d-flex justify-content-between" id="feeConfirmExtraRow">
                        <span class="text-muted"><i class="fa fa-tag mr-1 text-info"></i> Action:</span>
                        <span class="font-weight-bold text-dark" id="feeConfirmExtraDetails">-</span>
                    </div>
                </div>

                <!-- Message Text -->
                <p class="text-muted mb-0" id="feeConfirmMessage" style="font-size: 13px; line-height: 1.5;">
                    Are you sure you want to proceed with this real-time fee update?
                </p>
                <div class="alert alert-warning py-1 px-2 mt-2 mb-0 d-none text-left" id="feeConfirmPaidWarning" style="font-size: 11.5px; border-radius: 6px;">
                    <i class="fa fa-shield mr-1"></i> <strong>Protection:</strong> Fee heads with already recorded payments will remain untouched.
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer py-2 px-4 bg-light d-flex justify-content-between border-top">
                <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-1 btn-close-modal" data-dismiss="modal" data-bs-dismiss="modal" style="border-radius: 6px;">
                    <i class="fa fa-times mr-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-sm btn-success font-weight-bold px-4 py-1" id="btn_confirm_fee_modal_action" style="border-radius: 6px;">
                    <i class="fa fa-check mr-1"></i> <span id="btn_confirm_fee_modal_text">Yes, Proceed</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var searchTimer = null;

function showFeeToast(msg, type = 'success') {
    var bgClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var toastHtml = '<div class="alert ' + bgClass + ' alert-dismissible shadow-sm py-2 px-3 mb-2" style="font-size: 12.5px; border-radius: 6px;">' +
        '<button type="button" class="close" data-dismiss="alert" style="font-size: 16px;">&times;</button>' +
        '<i class="fa ' + icon + ' mr-1"></i> ' + msg +
        '</div>';
    
    var $toast = $(toastHtml).appendTo('#fee_toast_box');
    setTimeout(function() {
        $toast.fadeOut(400, function() { $(this).remove(); });
    }, 3500);
}

function updateSelectedCount() {
    var checked = $('.student_select_checkbox:checked').length;
    var total = $('.student_select_checkbox').length;
    
    $('#selected_students_badge').text('Selected: ' + checked);
    $('.selected_students_count_text').text(checked);
    $('#total_students_badge').text('Total: ' + total);
    $('.total_students_count_text').text(total);
    
    if (total > 0 && checked === total) {
        $('#all_students').prop('checked', true);
    } else {
        $('#all_students').prop('checked', false);
    }
}

function loadStudents() {
    var course_id = $('#filter_course_id').val();
    var batch = $('#filter_batch').val();
    var admissionNo = $('#filter_admission_no').val();
    
    if ((!course_id || !batch) && !admissionNo) {
        var msg = 'Please select both <b>Course</b> and <b>Batch</b> above to view and assign students.';
        if (!course_id && !batch) {
            msg = 'Please select a <b>Course</b> and <b>Batch</b> above to view students.';
        } else if (!course_id) {
            msg = 'Please select a <b>Course</b> above.';
        } else if (!batch) {
            msg = 'Please select a <b>Batch</b> above to load student list.';
        }
        $('#tbody_students_list').html('<tr><td colspan="10" class="text-center py-5 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> ' + msg + '</td></tr>');
        updateSelectedCount();
        return;
    }
    
    $('#tbody_students_list').html('<tr><td colspan="10" class="text-center py-5 text-primary"><i class="fa fa-spinner fa-spin fa-2x"></i><br><span class="mt-2 d-block font-weight-bold" style="font-size: 12.5px;">Loading students and course fee structure...</span></td></tr>');
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getStudentsList') }}",
        method: 'POST',
        data: {
            course_id: course_id,
            batch: batch,
            admissionNo: admissionNo
        },
        success: function(response) {
            $('#tbody_students_list').html(response);
            updateSelectedCount();
        },
        error: function(xhr) {
            $('#tbody_students_list').html('<tr><td colspan="10" class="text-center text-danger py-5"><i class="fa fa-exclamation-triangle mr-1"></i> Error loading students list.</td></tr>');
            updateSelectedCount();
        }
    });
}

function loadFeeMasterHeads(course_id) {
    if (!course_id) {
        $('#filter_fees_master_ids').empty().trigger('change');
        return;
    }

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getMasterData') }}",
        method: 'POST',
        data: { course_id: course_id },
        success: function(response) {
            var options = [];
            if (response && response.length > 0) {
                for (var i = 0; i < response.length; i++) {
                    var item = response[i];
                    var amt = item.amount ? parseFloat(item.amount).toLocaleString('en-IN') : '0';
                    var className = item.class_name ? ' [' + item.class_name + ']' : '';
                    var label = item.fees_group_name + className + ' (₹' + amt + ')';
                    options.push('<option value="' + item.id + '">' + label + '</option>');
                }
                $('#filter_fees_master_ids').html(options.join('')).trigger('change');
            } else {
                $('#filter_fees_master_ids').empty().trigger('change');
            }
        },
        error: function() {
            $('#filter_fees_master_ids').empty().trigger('change');
        }
    });
}

$(document).ready(function() {
    $('.select2').select2();

    // Select All / Clear in Filter Heads Select2
    $('#btn_select_all_filter_heads').click(function(e) {
        e.preventDefault();
        $('#filter_fees_master_ids > option').prop('selected', true);
        $('#filter_fees_master_ids').trigger('change');
    });

    $('#btn_deselect_all_filter_heads').click(function(e) {
        e.preventDefault();
        $('#filter_fees_master_ids').val(null).trigger('change');
    });

    // Course Select Handler
    $('#filter_course_id').change(function() {
        var courseId = $(this).val();
        loadFeeMasterHeads(courseId);
        loadStudents();
    });

    // Batch Select Handler
    $('#filter_batch').change(function() {
        loadStudents();
    });

    // Fast Debounced Student Search
    $('#filter_admission_no').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            loadStudents();
        }, 350);
    });

    $('#btn_search_students').click(function() {
        loadStudents();
    });

    // Reset Filters
    $('#btn_clear_filters').click(function() {
        $('#filter_course_id').val('').trigger('change');
        $('#filter_batch').val('').trigger('change');
        $('#filter_admission_no').val('');
        $('#filter_fees_master_ids').empty().trigger('change');
        $('#tbody_students_list').html('<tr><td colspan="10" class="text-center py-5 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> Please select both <b>Course</b> and <b>Batch</b> above.</td></tr>');
        updateSelectedCount();
    });

    // Select All / Deselect All Students Checkbox
    $('#all_students').click(function() {
        var isChecked = $(this).prop('checked');
        $('.student_select_checkbox').prop('checked', isChecked);
        updateSelectedCount();
    });

    $('#btn_quick_select_all').click(function() {
        $('.student_select_checkbox').prop('checked', true);
        $('#all_students').prop('checked', true);
        updateSelectedCount();
    });

    $('#btn_quick_deselect_all').click(function() {
        $('.student_select_checkbox').prop('checked', false);
        $('#all_students').prop('checked', false);
        updateSelectedCount();
    });

    $(document).on('change', '.student_select_checkbox', function() {
        updateSelectedCount();
    });

    // REAL-TIME INDIVIDUAL FEE HEAD TOGGLE
    $(document).on('change', '.toggle-fee-head-checkbox', function(e) {
        var $checkbox = $(this);
        var admissionId = $checkbox.data('admission-id');
        var masterId = $checkbox.data('master-id');
        var isChecked = $checkbox.is(':checked') ? 1 : 0;
        var $chip = $('#chip_' + admissionId + '_' + masterId);
        var $icon = $('#icon_' + admissionId + '_' + masterId);

        $chip.css('opacity', '0.6');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ url('toggleStudentFeeHead') }}",
            method: 'POST',
            data: {
                admission_id: admissionId,
                fees_master_id: masterId,
                state: isChecked
            },
            success: function(res) {
                $chip.css('opacity', '1');
                if (res.status === 'success') {
                    if (res.action === 'assigned') {
                        $chip.removeClass('chip-unassigned').addClass('chip-assigned');
                        $icon.removeClass('d-none');
                        $checkbox.prop('checked', true);
                    } else {
                        $chip.removeClass('chip-assigned').addClass('chip-unassigned');
                        $icon.addClass('d-none');
                        $checkbox.prop('checked', false);
                    }
                    
                    if (res.total_amount !== undefined) {
                        $('#student_total_' + admissionId).text('₹' + parseFloat(res.total_amount).toLocaleString('en-IN'));
                    }
                    showFeeToast(res.message, 'success');
                } else {
                    $checkbox.prop('checked', !isChecked);
                    showFeeToast(res.message || 'Error updating fee head', 'error');
                }
            },
            error: function(xhr) {
                $chip.css('opacity', '1');
                $checkbox.prop('checked', !isChecked);
                showFeeToast('Server error while updating fee head', 'error');
            }
        });
    });

    // GLOBAL PENDING ACTION STATE FOR CUSTOM CONFIRMATION MODAL
    var pendingFeeAction = {
        type: null, // 'assign_all_student', 'clear_all_student', 'quick_apply_loaded', 'bulk_assign_selected'
        admissionId: null,
        admissionIds: [],
        studentName: '',
        admissionNo: '',
        totalHeads: 0,
        masterIds: []
    };

    // TRIGGER MODAL: ASSIGN ALL COURSE HEADS TO SINGLE STUDENT
    $(document).on('click', '.btn-student-assign-all-heads', function(e) {
        e.preventDefault();
        var admissionId = $(this).data('admission-id');
        var studentName = $(this).data('student-name') || 'Selected Student';
        var admissionNo = $(this).data('admission-no') || '-';
        var totalHeads = $(this).data('total-heads') || 'all';

        pendingFeeAction = {
            type: 'assign_all_student',
            admissionId: admissionId,
            admissionIds: [admissionId],
            studentName: studentName,
            admissionNo: admissionNo,
            totalHeads: totalHeads,
            masterIds: []
        };

        // Configure Modal for Assign All
        $('#feeConfirmModalHeader').css('border-bottom', '2px solid #28a745');
        $('#feeConfirmIcon').attr('class', 'fa fa-check-circle mr-2 text-success');
        $('#feeConfirmTitle').text('Assign All Course Fee Heads');
        $('#feeConfirmBigIcon').attr('class', 'fa fa-check-square-o fa-2x text-success');
        $('#feeConfirmIconWrapper').css('background', 'rgba(40, 167, 69, 0.12)');
        $('#feeConfirmHeadline').text('Assign All Course Heads to Student?');
        
        $('#feeConfirmStudentInfoBox').show();
        $('#feeConfirmStudentNameRow').show();
        $('#feeConfirmStudentAdmRow').show();
        $('#feeConfirmStudentName').text(studentName);
        $('#feeConfirmStudentAdmNo').text(admissionNo);
        $('#feeConfirmExtraDetails').html('<span class="text-success font-weight-bold">Assign all (' + totalHeads + ') fee heads in real-time</span>');
        
        $('#feeConfirmMessage').text('Are you sure you want to assign all course fee structure heads to ' + studentName + '? This will update instantly.');
        $('#feeConfirmPaidWarning').addClass('d-none');
        
        $('#btn_confirm_fee_modal_action')
            .removeClass('btn-danger btn-primary btn-warning')
            .addClass('btn-success')
            .prop('disabled', false)
            .html('<i class="fa fa-check-square-o mr-1"></i> <span id="btn_confirm_fee_modal_text">Yes, Assign All</span>');

        $('#feeAssignConfirmModal').modal('show');
    });

    // TRIGGER MODAL: CLEAR ALL UNPAID HEADS FOR SINGLE STUDENT
    $(document).on('click', '.btn-student-unassign-all-heads', function(e) {
        e.preventDefault();
        var admissionId = $(this).data('admission-id');
        var studentName = $(this).data('student-name') || 'Selected Student';
        var admissionNo = $(this).data('admission-no') || '-';
        var $row = $('#student_row_' + admissionId);
        var assignedCheckboxes = $row.find('.toggle-fee-head-checkbox:checked');
        
        if (assignedCheckboxes.length === 0) {
            showFeeToast('No fee heads are currently assigned to clear for this student', 'error');
            return;
        }

        pendingFeeAction = {
            type: 'clear_all_student',
            admissionId: admissionId,
            admissionIds: [admissionId],
            studentName: studentName,
            admissionNo: admissionNo,
            totalHeads: assignedCheckboxes.length,
            masterIds: []
        };

        // Configure Modal for Clear All
        $('#feeConfirmModalHeader').css('border-bottom', '2px solid #dc3545');
        $('#feeConfirmIcon').attr('class', 'fa fa-trash mr-2 text-danger');
        $('#feeConfirmTitle').text('Clear All Assigned Fee Heads');
        $('#feeConfirmBigIcon').attr('class', 'fa fa-trash fa-2x text-danger');
        $('#feeConfirmIconWrapper').css('background', 'rgba(220, 53, 69, 0.12)');
        $('#feeConfirmHeadline').text('Clear All Fee Heads for Student?');
        
        $('#feeConfirmStudentInfoBox').show();
        $('#feeConfirmStudentNameRow').show();
        $('#feeConfirmStudentAdmRow').show();
        $('#feeConfirmStudentName').text(studentName);
        $('#feeConfirmStudentAdmNo').text(admissionNo);
        $('#feeConfirmExtraDetails').html('<span class="text-danger font-weight-bold">Clear (' + assignedCheckboxes.length + ') assigned heads</span>');
        
        $('#feeConfirmMessage').text('Are you sure you want to unassign all fee heads for ' + studentName + '?');
        $('#feeConfirmPaidWarning').removeClass('d-none');
        
        $('#btn_confirm_fee_modal_action')
            .removeClass('btn-success btn-primary btn-warning')
            .addClass('btn-danger')
            .prop('disabled', false)
            .html('<i class="fa fa-trash mr-1"></i> <span id="btn_confirm_fee_modal_text">Yes, Clear All</span>');

        $('#feeAssignConfirmModal').modal('show');
    });

    // TRIGGER MODAL: QUICK APPLY ALL HEADS TO ALL LOADED STUDENTS
    $('#btn_quick_apply_all_loaded').click(function(e) {
        e.preventDefault();
        var allStudentIds = [];
        $('.student_select_checkbox').each(function() {
            allStudentIds.push($(this).val());
        });

        if (allStudentIds.length === 0) {
            showFeeToast('No students loaded in the table. Please select Course and Batch first.', 'error');
            return;
        }

        var feeMasterIds = $('#filter_fees_master_ids').val() || [];
        var count = allStudentIds.length;

        pendingFeeAction = {
            type: 'quick_apply_loaded',
            admissionId: null,
            admissionIds: allStudentIds,
            studentName: '',
            admissionNo: '',
            totalHeads: 0,
            masterIds: feeMasterIds
        };

        // Configure Modal for Quick Apply
        $('#feeConfirmModalHeader').css('border-bottom', '2px solid #ffc107');
        $('#feeConfirmIcon').attr('class', 'fa fa-bolt mr-2 text-warning');
        $('#feeConfirmTitle').text('Quick Apply All Fee Heads');
        $('#feeConfirmBigIcon').attr('class', 'fa fa-bolt fa-2x text-warning');
        $('#feeConfirmIconWrapper').css('background', 'rgba(255, 193, 7, 0.15)');
        $('#feeConfirmHeadline').text('Quick Apply to ALL Loaded Students?');
        
        $('#feeConfirmStudentInfoBox').show();
        $('#feeConfirmStudentNameRow').hide();
        $('#feeConfirmStudentAdmRow').hide();
        $('#feeConfirmExtraDetails').html('<span class="badge badge-primary px-2 py-1" style="font-size: 13px;">' + count + ' Students Loaded</span>');
        
        $('#feeConfirmMessage').text('Are you sure you want to assign all course fee structure heads to ALL ' + count + ' students loaded in this batch? This will be applied live in real-time.');
        $('#feeConfirmPaidWarning').addClass('d-none');
        
        $('#btn_confirm_fee_modal_action')
            .removeClass('btn-danger btn-warning btn-primary')
            .addClass('btn-success')
            .prop('disabled', false)
            .html('<i class="fa fa-bolt mr-1"></i> <span id="btn_confirm_fee_modal_text">Yes, Quick Apply (' + count + ')</span>');

        $('#feeAssignConfirmModal').modal('show');
    });

    // TRIGGER MODAL: BULK ASSIGN TO SELECTED/CHECKED STUDENTS
    $('#btn_bulk_assign_realtime').click(function(e) {
        e.preventDefault();
        var selectedStudents = [];
        $('.student_select_checkbox:checked').each(function() {
            selectedStudents.push($(this).val());
        });

        if (selectedStudents.length === 0) {
            showFeeToast('Please select at least one student checkbox in the table.', 'error');
            return;
        }

        var feeMasterIds = $('#filter_fees_master_ids').val() || [];
        var count = selectedStudents.length;

        pendingFeeAction = {
            type: 'bulk_assign_selected',
            admissionId: null,
            admissionIds: selectedStudents,
            studentName: '',
            admissionNo: '',
            totalHeads: 0,
            masterIds: feeMasterIds
        };

        // Configure Modal for Selected Bulk Assign
        $('#feeConfirmModalHeader').css('border-bottom', '2px solid #002c54');
        $('#feeConfirmIcon').attr('class', 'fa fa-users mr-2 text-info');
        $('#feeConfirmTitle').text('Assign Fee Heads to Selected Students');
        $('#feeConfirmBigIcon').attr('class', 'fa fa-users fa-2x text-primary');
        $('#feeConfirmIconWrapper').css('background', 'rgba(0, 44, 84, 0.12)');
        $('#feeConfirmHeadline').text('Assign Heads to ' + count + ' Selected Student(s)?');
        
        $('#feeConfirmStudentInfoBox').show();
        $('#feeConfirmStudentNameRow').hide();
        $('#feeConfirmStudentAdmRow').hide();
        $('#feeConfirmExtraDetails').html('<span class="badge badge-success px-2 py-1" style="font-size: 13px;">' + count + ' Students Selected</span>');
        
        $('#feeConfirmMessage').text('Are you sure you want to assign fee structure heads to the ' + count + ' checked student(s) in real-time?');
        $('#feeConfirmPaidWarning').addClass('d-none');
        
        $('#btn_confirm_fee_modal_action')
            .removeClass('btn-danger btn-warning btn-success')
            .addClass('btn-primary')
            .prop('disabled', false)
            .html('<i class="fa fa-check-circle mr-1"></i> <span id="btn_confirm_fee_modal_text">Yes, Assign to (' + count + ')</span>');

        $('#feeAssignConfirmModal').modal('show');
    });

    // PROCEED EXECUTION HANDLER FOR CUSTOM CONFIRMATION MODAL
    $('#btn_confirm_fee_modal_action').click(function() {
        var $confirmBtn = $(this);
        $confirmBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Processing in real-time...');

        if (pendingFeeAction.type === 'assign_all_student') {
            var admissionId = pendingFeeAction.admissionId;
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('bulkAssignCourseFees') }}",
                method: 'POST',
                data: {
                    admissionIds: [admissionId],
                    fees_master_ids: []
                },
                success: function(res) {
                    $('#feeAssignConfirmModal').modal('hide');
                    if (res.status === 'success') {
                        // Real-time update row DOM
                        var $row = $('#student_row_' + admissionId);
                        $row.find('.toggle-fee-head-checkbox').prop('checked', true);
                        $row.find('.fee-head-chip').removeClass('chip-unassigned').addClass('chip-assigned');
                        $row.find('[id^="icon_' + admissionId + '_"]').removeClass('d-none');
                        
                        if (res.updated_totals && res.updated_totals[admissionId] !== undefined) {
                            $('#student_total_' + admissionId).text('₹' + parseFloat(res.updated_totals[admissionId]).toLocaleString('en-IN'));
                        } else if (res.total_amount !== undefined && res.total_amount > 0) {
                            $('#student_total_' + admissionId).text('₹' + parseFloat(res.total_amount).toLocaleString('en-IN'));
                        }
                        showFeeToast(pendingFeeAction.studentName + ': All course fee heads assigned successfully!', 'success');
                    } else {
                        showFeeToast(res.message || 'Error assigning heads', 'error');
                    }
                },
                error: function() {
                    $('#feeAssignConfirmModal').modal('hide');
                    showFeeToast('Server error while assigning fee heads', 'error');
                }
            });
        } 
        else if (pendingFeeAction.type === 'clear_all_student') {
            var admissionId = pendingFeeAction.admissionId;
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('clearStudentFeeHeads') }}",
                method: 'POST',
                data: {
                    admission_id: admissionId
                },
                success: function(res) {
                    $('#feeAssignConfirmModal').modal('hide');
                    if (res.status === 'success') {
                        // Real-time update row DOM
                        var $row = $('#student_row_' + admissionId);
                        $row.find('.toggle-fee-head-checkbox').prop('checked', false);
                        $row.find('.fee-head-chip').removeClass('chip-assigned').addClass('chip-unassigned');
                        $row.find('[id^="icon_' + admissionId + '_"]').addClass('d-none');
                        
                        var newTotal = (res.updated_totals && res.updated_totals[admissionId] !== undefined) ? res.updated_totals[admissionId] : (res.total_amount || 0);
                        $('#student_total_' + admissionId).text('₹' + parseFloat(newTotal).toLocaleString('en-IN'));
                        
                        showFeeToast(pendingFeeAction.studentName + ': Unpaid fee heads cleared successfully!', 'success');
                    } else {
                        showFeeToast(res.message || 'Error clearing fee heads', 'error');
                    }
                },
                error: function() {
                    $('#feeAssignConfirmModal').modal('hide');
                    showFeeToast('Server error while clearing fee heads', 'error');
                }
            });
        }
        else if (pendingFeeAction.type === 'quick_apply_loaded' || pendingFeeAction.type === 'bulk_assign_selected') {
            var targetIds = pendingFeeAction.admissionIds;
            var masterIds = pendingFeeAction.masterIds;

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('bulkAssignCourseFees') }}",
                method: 'POST',
                data: {
                    admissionIds: targetIds,
                    fees_master_ids: masterIds
                },
                success: function(res) {
                    $('#feeAssignConfirmModal').modal('hide');
                    if (res.status === 'success') {
                        // Real-time update all affected rows
                        targetIds.forEach(function(admId) {
                            var $row = $('#student_row_' + admId);
                            if (masterIds && masterIds.length > 0) {
                                masterIds.forEach(function(mId) {
                                    $row.find('.toggle-fee-head-checkbox[data-master-id="' + mId + '"]').prop('checked', true);
                                    $('#chip_' + admId + '_' + mId).removeClass('chip-unassigned').addClass('chip-assigned');
                                    $('#icon_' + admId + '_' + mId).removeClass('d-none');
                                });
                            } else {
                                $row.find('.toggle-fee-head-checkbox').prop('checked', true);
                                $row.find('.fee-head-chip').removeClass('chip-unassigned').addClass('chip-assigned');
                                $row.find('[id^="icon_' + admId + '_"]').removeClass('d-none');
                            }

                            if (res.updated_totals && res.updated_totals[admId] !== undefined) {
                                $('#student_total_' + admId).text('₹' + parseFloat(res.updated_totals[admId]).toLocaleString('en-IN'));
                            }
                        });
                        showFeeToast(res.message || 'Bulk fee assignment completed successfully!', 'success');
                    } else {
                        showFeeToast(res.message || 'Error during bulk assignment', 'error');
                    }
                },
                error: function() {
                    $('#feeAssignConfirmModal').modal('hide');
                    showFeeToast('Server error during bulk fee assignment', 'error');
                }
            });
        }
    });

    // OPEN STUDENT FEE EDIT / MODIFICATION MODAL
    $(document).on('click', '.btn-edit-student-fees', function() {
        var admissionId = $(this).data('admission-id');
        $('#studentFeeEditModal').modal('show');
        $('#studentFeeEditModalBody').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted font-weight-bold">Loading Student Fee Details...</p></div>');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ url('getStudentFeeDetailsModal') }}",
            method: 'POST',
            data: { admission_id: admissionId },
            success: function(html) {
                $('#studentFeeEditModalBody').html(html);
            },
            error: function() {
                $('#studentFeeEditModalBody').html('<div class="alert alert-danger m-3"><i class="fa fa-exclamation-triangle mr-1"></i> Failed to load fee details.</div>');
            }
        });
    });

    // MODAL: LIVE CALCULATION ON INPUT CHANGE
    $(document).on('input', '.input-amount, .input-discount', function() {
        var detailId = $(this).data('detail-id');
        var $row = $('#row_detail_' + detailId);
        var amt = parseFloat($row.find('.input-amount').val()) || 0;
        var disc = parseFloat($row.find('.input-discount').val()) || 0;
        var net = amt - disc;
        $row.find('.net-display').text('₹' + net.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    });

    // MODAL: SAVE INDIVIDUAL ROW VIA AJAX
    $(document).on('click', '.btn-save-detail-row', function() {
        var detailId = $(this).data('detail-id');
        var admissionId = $(this).data('admission-id');
        var $row = $('#row_detail_' + detailId);
        var $btn = $(this);

        var amount = $row.find('.input-amount').val();
        var discount = $row.find('.input-discount').val();
        var dueDate = $row.find('.input-due-date').val();
        var fine = $row.find('.input-fine').val();

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ url('updateStudentFeeDetailInline') }}",
            method: 'POST',
            data: {
                detail_id: detailId,
                amount: amount,
                discount: discount,
                due_date: dueDate,
                fine: fine
            },
            success: function(res) {
                $btn.prop('disabled', false).html('<i class="fa fa-check text-success"></i> Saved');
                setTimeout(function() {
                    $btn.html('<i class="fa fa-save"></i> Save');
                }, 2000);

                if (res.status === 'success') {
                    if (res.total_amount !== undefined) {
                        $('#modal_summary_total').text('₹' + parseFloat(res.total_amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                        $('#student_total_' + admissionId).text('₹' + parseFloat(res.total_amount).toLocaleString('en-IN'));
                    }
                    if (res.net_amount !== undefined) {
                        $('#modal_summary_net').text('₹' + parseFloat(res.net_amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    }
                    showFeeToast(res.message || 'Fee updated successfully', 'success');
                } else {
                    showFeeToast(res.message || 'Error updating fee', 'error');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                showFeeToast('Server error while saving fee detail', 'error');
            }
        });
    });

    // ROBUST GLOBAL MODAL DISMISS / CANCEL / CLOSE HANDLER
    $(document).on('click', '[data-dismiss="modal"], [data-bs-dismiss="modal"], .btn-close-modal, .close', function(e) {
        var $modal = $(this).closest('.modal');
        if ($modal.length > 0) {
            $modal.modal('hide');
        }
    });
});
</script>

@endsection
