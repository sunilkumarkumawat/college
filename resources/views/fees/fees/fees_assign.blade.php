@extends('layout.app')
@section('content')

@php
    $courses = Helper::getCourses();
    $classType = Helper::classType();
    $allClassType = Helper::classType();
    $getFeesGroup = Helper::getFeesGroup();
    $getSession = Helper::getSession();
@endphp

<style>
/* Page & Container */
.content-wrapper {
    background-color: #f4f6f9;
}

/* Card Header - Solid Brand Dark with Crisp White Text */
.card-outline.card-orange .card-header.bg-primary {
    background-color: #002c54 !important;
    background: #002c54 !important;
    color: #ffffff !important;
    padding: 10px 15px !important;
    border-bottom: 2px solid #001a33 !important;
}
.card-header.bg-primary h3,
.card-header.bg-primary .card-title,
.card-header.bg-primary i,
.card-header.bg-primary span {
    color: #ffffff !important;
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    margin: 0 !important;
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
    display: block;
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

/* Badges for Assigned Fee Heads */
.badge-head-tag {
    background-color: #0284c7 !important;
    color: #ffffff !important;
    border: 1px solid #0369a1 !important;
    font-weight: 600 !important;
    font-size: 11.5px !important;
    padding: 3px 8px !important;
    border-radius: 4px !important;
    display: inline-block !important;
    margin: 2px !important;
}
.badge-head-tag i {
    color: #ffffff !important;
}
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
</style>

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
                                <a href="{{ url('feesGroup') }}" class="btn btn-primary btn-sm" title="Fees Group & Master">
                                    <i class="fa fa-money mr-1"></i> Fees Structure
                                </a>
                                <a href="{{ url('fee_dashboard') }}" class="btn btn-primary btn-sm ml-1" title="Back">
                                    <i class="fa fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>

                        <form id="assignFeesMultipleForm" action="{{ url('assignFeesMultipleStudents') }}" method="POST">
                            @csrf
                            <div class="card-body p-3">
                                @include('layout.message')

                                <!-- Filter Inputs Row -->
                                <div class="row mb-2">
                                    <!-- Course Select -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="filter-label">Course <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" id="filter_course_id" name="course_id" style="width: 100%;">
                                            <option value="">-- Select Course --</option>
                                            @if(!empty($courses))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Class / Semester Select -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="filter-label">Class / Semester <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" id="filter_class_type_id" name="class_type_id" style="width: 100%;">
                                            <option value="">-- Select Class --</option>
                                            @if(!empty($classType))
                                                @foreach($classType as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Admission No / Search -->
                                    <div class="col-md-2 col-sm-6 mb-2">
                                        <label class="filter-label">Student ID / Name</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm" id="filter_admission_no" name="admissionNo" placeholder="Adm No. / Name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" id="btn_search_students" title="Search">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fees Master Heads Multi-Select -->
                                    <div class="col-md-4 col-sm-6 mb-2">
                                        <label class="filter-label">
                                            Fees Master Heads to Assign <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm select2" multiple="multiple" id="filter_fees_master_ids" name="fees_master_ids[]" data-placeholder="-- Select Fee Heads to Assign --" style="width: 100%;">
                                        </select>
                                    </div>
                                </div>

                                <!-- Action Toolbar & Counter Strip -->
                                <div class="mid-action-strip d-flex flex-wrap justify-content-between align-items-center mb-2">
                                    <div class="mb-1 mb-md-0">
                                        <span style="font-size: 12.5px; color: #334155;">
                                            <i class="fa fa-info-circle text-primary mr-1"></i> 
                                            Select <b>Class</b> & <b>Fee Heads</b>, choose students, and click <b>Assign Fees Structure</b>.
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge px-2 py-1 mr-1" id="total_students_badge" style="background-color: #334155; color: #ffffff; font-size: 12px; font-weight: 500;">Total: 0</span>
                                        <span class="badge px-2 py-1 mr-2" id="selected_students_badge" style="background-color: #16a34a; color: #ffffff; font-size: 12px; font-weight: 600;">Selected: 0</span>
                                        <button type="button" class="btn btn-default btn-xs border mr-1" id="btn_quick_select_all" style="font-size: 11.5px; padding: 3px 8px;">
                                            <i class="fa fa-check-square text-primary mr-1"></i>Select All
                                        </button>
                                        <button type="button" class="btn btn-default btn-xs border mr-1" id="btn_quick_deselect_all" style="font-size: 11.5px; padding: 3px 8px;">
                                            <i class="fa fa-square-o text-danger mr-1"></i>Deselect
                                        </button>
                                        <button type="button" class="btn btn-default btn-xs border" id="btn_clear_filters" style="font-size: 11.5px; padding: 3px 8px;" title="Reset">
                                            <i class="fa fa-refresh text-secondary mr-1"></i>Reset
                                        </button>
                                    </div>
                                </div>

                                <!-- High Density Students Table Container -->
                                <div class="table-responsive border rounded" style="max-height: 520px; overflow-y: auto;">
                                    <table class="table table-bordered table-striped table-hover table-sm mb-0 table-assign" id="students_assign_table">
                                        <thead style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 40px; text-align: center; vertical-align: middle;">
                                                    <input type="checkbox" id="all_students" style="cursor: pointer;" title="Select All">
                                                </th>
                                                <th style="width: 45px; text-align: center; vertical-align: middle;">#</th>
                                                <th style="text-align: left; vertical-align: middle;">Student Name</th>
                                                <th style="width: 120px; text-align: center; vertical-align: middle;">Admission No.</th>
                                                <th style="width: 130px; text-align: center; vertical-align: middle;">Class / Semester</th>
                                                <th style="text-align: left; vertical-align: middle;">Father's Name</th>
                                                <th style="width: 110px; text-align: center; vertical-align: middle;">Mobile No.</th>
                                                <th style="text-align: left; vertical-align: middle;">Currently Assigned Fee Heads</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_students_list">
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i>
                                                    Please select a <b>Course</b> and <b>Class / Semester</b> above to view and assign students.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Card Footer Sticky Action Bar -->
                            <div class="card-footer d-flex justify-content-between align-items-center py-2 px-3" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                                <div style="font-size: 12px; color: #64748b;">
                                    <i class="fa fa-check-circle text-success mr-1"></i> Selected fee heads will be assigned. Existing fee heads will not be duplicated.
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm font-weight-bold px-4" id="btn_submit_assign" style="font-size: 13px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <i class="fa fa-check mr-1"></i> Assign Fees to (<span id="btn_selected_count">0</span>) Students
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
var defaultClasses = @json($allClassType ?? []);

function updateSelectedCount() {
    var checked = $('.student_select_checkbox:checked').length;
    var total = $('.student_select_checkbox').length;
    
    $('#selected_students_badge').text('Selected: ' + checked);
    $('#btn_selected_count').text(checked);
    $('#total_students_badge').text('Total: ' + total);
    
    if (total > 0 && checked === total) {
        $('#all_students').prop('checked', true);
    } else {
        $('#all_students').prop('checked', false);
    }
}

function loadStudents(class_type_id, admissionNo, course_id) {
    if (!class_type_id && !course_id) {
        $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-5 text-muted"><i class="fa fa-info-circle mr-1"></i> Please select a Course or Class / Semester</td></tr>');
        updateSelectedCount();
        return;
    }
    
    $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-5 text-primary"><i class="fa fa-spinner fa-spin fa-2x"></i><br><span class="mt-2 d-block font-weight-bold" style="font-size: 12.5px;">Loading students...</span></td></tr>');
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getStudentsList') }}",
        method: 'POST',
        data: {
            class_type_id: class_type_id,
            course_id: course_id,
            admissionNo: admissionNo
        },
        success: function(response) {
            $('#tbody_students_list').html(response);
            updateSelectedCount();
        },
        error: function(xhr) {
            $('#tbody_students_list').html('<tr><td colspan="8" class="text-center text-danger py-5"><i class="fa fa-exclamation-triangle mr-1"></i> Error loading students list.</td></tr>');
            updateSelectedCount();
        }
    });
}

function loadFeeMasterHeads(class_type_id) {
    if (!class_type_id) {
        $('#filter_fees_master_ids').empty().trigger('change');
        return;
    }
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getMasterData') }}",
        method: 'POST',
        data: { class_type_id: class_type_id },
        success: function(response) {
            var options = [];
            if (response && response.length > 0) {
                for (var i = 0; i < response.length; i++) {
                    var item = response[i];
                    var amt = item.amount ? parseFloat(item.amount).toLocaleString('en-IN') : '0';
                    var label = item.fees_group_name + ' (₹' + amt + ')';
                    options.push('<option value="' + item.id + '" selected>' + label + '</option>');
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

    // Course Select Handler
    $('#filter_course_id').change(function() {
        var courseId = $(this).val();
        var classSelect = $('#filter_class_type_id');
        var admissionNo = $('#filter_admission_no').val();
        
        if (courseId) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "POST",
                data: { _token: "{{ csrf_token() }}", course_id: courseId },
                dataType: "json",
                success: function(data) {
                    classSelect.empty().append('<option value="">-- Select Class --</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(key, val) {
                            classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                        });
                    }
                    classSelect.val('').trigger('change');
                }
            });
            loadStudents('', admissionNo, courseId);
        } else {
            classSelect.empty().append('<option value="">-- Select Class --</option>');
            if (defaultClasses && defaultClasses.length > 0) {
                $.each(defaultClasses, function(key, val) {
                    classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
            classSelect.val('').trigger('change');
            $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-5 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> Please select a <b>Course</b> and <b>Class / Semester</b> above.</td></tr>');
            updateSelectedCount();
        }
    });

    // Class Select Handler
    $('#filter_class_type_id').change(function() {
        var class_type_id = $(this).val();
        var course_id = $('#filter_course_id').val();
        var admissionNo = $('#filter_admission_no').val();
        
        loadFeeMasterHeads(class_type_id);
        if (class_type_id || course_id) {
            loadStudents(class_type_id, admissionNo, course_id);
        }
    });

    // Search Trigger
    $('#btn_search_students').click(function() {
        var class_type_id = $('#filter_class_type_id').val();
        var course_id = $('#filter_course_id').val();
        var admissionNo = $('#filter_admission_no').val();
        loadStudents(class_type_id, admissionNo, course_id);
    });

    $('#filter_admission_no').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btn_search_students').click();
        }
    });

    // Reset Filters
    $('#btn_clear_filters').click(function() {
        $('#filter_course_id').val('').trigger('change');
        $('#filter_admission_no').val('');
        $('#filter_fees_master_ids').empty().trigger('change');
        $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-5 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> Please select a <b>Course</b> and <b>Class / Semester</b> above.</td></tr>');
        updateSelectedCount();
    });

    // Select All Checkbox
    $('#all_students').click(function() {
        var isChecked = $(this).prop('checked');
        $('.student_select_checkbox').prop('checked', isChecked);
        updateSelectedCount();
    });

    // Quick Select Buttons
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

    // Form Submission Confirmation & Validation
    $('#assignFeesMultipleForm').on('submit', function(event) {
        var checkedStudents = $('.student_select_checkbox:checked').length;
        var selectedFeeHeads = $('#filter_fees_master_ids').val();

        if (!selectedFeeHeads || selectedFeeHeads.length === 0) {
            event.preventDefault();
            alert("Please select at least one Fee Head to assign!");
            $('#filter_fees_master_ids').focus();
            return false;
        }

        if (checkedStudents === 0) {
            event.preventDefault();
            alert("Please select at least one student from the table!");
            return false;
        }

        return confirm("Are you sure you want to assign the selected fee structure to " + checkedStudents + " student(s)?");
    });
});
</script>

@endsection
