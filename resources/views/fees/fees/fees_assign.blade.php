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
.table-assign thead th {
    background-color: #002c54;
    color: #ffffff;
    font-size: 13px;
    padding: 6px 8px;
    vertical-align: middle;
    border: 1px solid #1a4267;
}
.table-assign tbody td {
    padding: 5px 8px;
    font-size: 12.5px;
    vertical-align: middle;
}
.table-assign tbody tr:hover {
    background-color: #e9ecef !important;
}
.select2-container .select2-selection--single,
.select2-container .select2-selection--multiple {
    min-height: 31px !important;
    border: 1px solid #ced4da !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px !important;
    font-size: 13px;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    padding: 0 4px;
    font-size: 12px;
}
.filter-label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 2px;
    color: #333;
}
</style>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange mb-3">
                        <div class="card-header bg-primary">
                            <h3 class="card-title font-weight-bold">
                                <i class="fa fa-users"></i> &nbsp;{{ __('Student Fee Assign') }} (छात्र शुल्क असाइन)
                            </h3>
                            <div class="card-tools">
                                <a href="{{ url('feesGroup') }}" class="btn btn-primary btn-sm" title="Fees Group & Master">
                                    <i class="fa fa-money"></i> {{ __('Fees Structure') }}
                                </a>
                                <a href="{{ url('fee_dashboard') }}" class="btn btn-primary btn-sm" title="Back">
                                    <i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}
                                </a>
                            </div>
                        </div>

                        <form id="assignFeesMultipleForm" action="{{ url('assignFeesMultipleStudents') }}" method="POST">
                            @csrf
                            <div class="card-body p-2">
                                @include('layout.message')

                                <!-- Compact Filter Bar -->
                                <div class="row mx-1 mt-1 mb-2">
                                    <!-- Course Select -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="filter-label">{{ __('common.Course') }} <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" id="filter_course_id" name="course_id" style="width: 100%;">
                                            <option value="">-- {{ __('common.Select') }} Course --</option>
                                            @if(!empty($courses))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Class / Semester Select -->
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        <label class="filter-label">{{ __('common.Class') }} / Sem <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" id="filter_class_type_id" name="class_type_id" style="width: 100%;">
                                            <option value="">-- {{ __('common.Select') }} Class --</option>
                                            @if(!empty($classType))
                                                @foreach($classType as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Admission No / Search -->
                                    <div class="col-md-2 col-sm-6 mb-2">
                                        <label class="filter-label">{{ __('student.Admission No.') }} / Name</label>
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
                                <div class="row mx-1 mb-2 align-items-center bg-light border rounded py-1 px-2">
                                    <div class="col-md-7 col-12 mb-1 mb-md-0">
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle text-primary"></i> 
                                            Select <b>Class</b> & <b>Fee Heads</b>, check students in the table below, then click <b>Assign Fees Structure</b>.
                                        </small>
                                    </div>
                                    <div class="col-md-5 col-12 text-md-right text-left">
                                        <span class="badge badge-secondary px-2 py-1 mr-1 font-weight-normal" id="total_students_badge" style="font-size: 12px;">Total: 0</span>
                                        <span class="badge badge-success px-2 py-1 mr-2 font-weight-bold" id="selected_students_badge" style="font-size: 12px;">Selected: 0</span>
                                        <button type="button" class="btn btn-default btn-xs border mr-1" id="btn_quick_select_all">
                                            <i class="fa fa-check-square"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-default btn-xs border mr-1" id="btn_quick_deselect_all">
                                            <i class="fa fa-square-o"></i> Deselect
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs" id="btn_clear_filters" title="Reset">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>

                                <!-- High Density Students Table Container -->
                                <div class="table-responsive border rounded" style="max-height: 520px; overflow-y: auto;">
                                    <table class="table table-bordered table-striped table-hover table-sm text-center table-assign mb-0" id="students_assign_table">
                                        <thead class="sticky-top" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 40px; text-align: center;">
                                                    <input type="checkbox" id="all_students" style="cursor: pointer;" title="Select All">
                                                </th>
                                                <th style="width: 45px;">#</th>
                                                <th style="text-align: left;">Student Name</th>
                                                <th style="width: 120px;">{{ __('student.Admission No.') }}</th>
                                                <th style="width: 110px;">{{ __('common.Class') }}</th>
                                                <th style="text-align: left;">{{ __('student.Father\'s Name') }}</th>
                                                <th style="width: 110px;">{{ __('common.Mobile No.') }}</th>
                                                <th style="text-align: left;">Currently Assigned Fee Heads</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_students_list">
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    <i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i>
                                                    Please select a <b>Course</b> and <b>Class / Semester</b> above to view and assign students.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Card Footer Sticky Action Bar -->
                            <div class="card-footer bg-light d-flex justify-content-between align-items-center py-2">
                                <div class="text-muted" style="font-size: 12px;">
                                    <i class="fa fa-check-circle text-success mr-1"></i> Already assigned fee heads will not be duplicated.
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm font-weight-bold px-4" id="btn_submit_assign">
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
        $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa fa-info-circle mr-1"></i> Please select a Course or Class / Semester</td></tr>');
        updateSelectedCount();
        return;
    }
    
    $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-4 text-primary"><i class="fa fa-spinner fa-spin fa-2x"></i><br><span class="mt-1 d-block font-weight-bold" style="font-size: 12px;">Loading students...</span></td></tr>');
    
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
            $('#tbody_students_list').html('<tr><td colspan="8" class="text-center text-danger py-4"><i class="fa fa-exclamation-triangle mr-1"></i> Error loading students list.</td></tr>');
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
                    classSelect.empty().append('<option value="">-- {{ __("common.Select") }} Class --</option>');
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
            classSelect.empty().append('<option value="">-- {{ __("common.Select") }} Class --</option>');
            if (defaultClasses && defaultClasses.length > 0) {
                $.each(defaultClasses, function(key, val) {
                    classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
            classSelect.val('').trigger('change');
            $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> Please select a <b>Course</b> and <b>Class / Semester</b> above.</td></tr>');
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
        $('#tbody_students_list').html('<tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa fa-filter fa-2x mb-2 text-secondary d-block"></i> Please select a <b>Course</b> and <b>Class / Semester</b> above.</td></tr>');
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
