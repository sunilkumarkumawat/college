@extends('layout.app')
@section('content')

<style>
.fee-assign-container {
    padding: 15px;
}
.assign-header-card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
    background: #ffffff;
}
.assign-header-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
}
.filter-card {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    background: #ffffff;
    margin-bottom: 20px;
}
.filter-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 600;
    color: #334155;
    padding: 12px 20px;
}
.student-table-card {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    background: #ffffff;
}
.student-table-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 14px 20px;
}
.table thead th {
    background-color: #1e293b;
    color: #ffffff;
    font-weight: 600;
    border: none;
    padding: 12px 14px;
    font-size: 0.9rem;
    vertical-align: middle;
}
.table tbody td {
    padding: 12px 14px;
    vertical-align: middle;
    font-size: 0.88rem;
    border-color: #f1f5f9;
}
.table tbody tr:hover {
    background-color: #f8fafc !important;
}
.badge-assigned-head {
    display: inline-block;
    background-color: #e0f2fe;
    color: #0369a1;
    font-size: 0.78rem;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    margin: 2px;
    border: 1px solid #bae6fd;
}
.custom-counter-badge {
    background: #2563eb;
    color: #ffffff;
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}
.custom-selected-badge {
    background: #059669;
    color: #ffffff;
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}
.bottom-action-bar {
    position: sticky;
    bottom: 0;
    background: #ffffff;
    border-top: 2px solid #e2e8f0;
    padding: 14px 25px;
    box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.06);
    z-index: 100;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-label-styled {
    font-weight: 600;
    font-size: 0.85rem;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}
.select2-container .select2-selection--single,
.select2-container .select2-selection--multiple {
    min-height: 40px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 6px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px !important;
}
</style>

<div class="content-wrapper fee-assign-container">
    <div class="container-fluid">

        <!-- Top Header Card -->
        <div class="card assign-header-card">
            <div class="card-body p-3 d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h3 class="assign-header-title">
                        <i class="fa fa-users text-primary mr-2" style="font-size: 1.5rem;"></i>
                        Student Fee Assign
                        <span class="text-muted ml-2" style="font-size: 0.95rem; font-weight: normal;">(छात्र शुल्क असाइन)</span>
                    </h3>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                        <i class="fa fa-info-circle text-info mr-1"></i> Filter students by course/class and assign fee master heads in bulk.
                    </p>
                </div>
                <div class="mt-2 mt-md-0 d-flex align-items-center">
                    <a href="{{ url('feesGroup') }}" class="btn btn-outline-secondary btn-sm mr-2 shadow-sm">
                        <i class="fa fa-money mr-1"></i> Fees Group & Master
                    </a>
                    <a href="{{ url('fee_dashboard') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa fa-arrow-left mr-1"></i> {{ __('common.Back') }}
                    </a>
                </div>
            </div>
        </div>

        @include('layout.message')

        <form id="assignFeesMultipleForm" action="{{ url('assignFeesMultipleStudents') }}" method="POST">
            @csrf

            <!-- Filter & Selection Section -->
            <div class="card filter-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-filter text-primary mr-2"></i> Filter Students & Select Fee Heads</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_clear_filters">
                        <i class="fa fa-refresh mr-1"></i> Reset Filters
                    </button>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <!-- Course Select -->
                        <div class="col-md-3 col-12 mb-3">
                            <label class="form-label-styled">{{ __('common.Course') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="filter_course_id" name="course_id" style="width: 100%;">
                                <option value="">-- {{ __('common.Select') }} Course --</option>
                                @if(!empty($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Class / Semester Select -->
                        <div class="col-md-3 col-12 mb-3">
                            <label class="form-label-styled">{{ __('common.Class') }} / Semester <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="filter_class_type_id" name="class_type_id" style="width: 100%;">
                                <option value="">-- {{ __('common.Select') }} Class --</option>
                                @if(!empty($classType))
                                    @foreach($classType as $type)
                                        <option value="{{ $type->id }}">{{ $type->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Admission / Student No Filter -->
                        <div class="col-md-3 col-12 mb-3">
                            <label class="form-label-styled">{{ __('Admission No') }} / Student ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter_admission_no" name="admissionNo" placeholder="Search by Adm No...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="btn_search_students">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Fees Master Heads Multi-Select -->
                        <div class="col-md-3 col-12 mb-3">
                            <label class="form-label-styled">
                                {{ __('Fees Structure') }} (Fee Heads) <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2" multiple="multiple" id="filter_fees_master_ids" name="fees_master_ids[]" data-placeholder="Select Fee Heads to Assign" style="width: 100%;">
                            </select>
                            <small class="text-muted" id="fees_head_helper">
                                Select class to populate fee heads
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student List Table Card -->
            <div class="card student-table-card mb-4">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <h5 class="mb-0 font-weight-bold text-dark mr-3" style="font-size: 1rem;">
                            <i class="fa fa-graduation-cap text-primary mr-2"></i> Student List
                        </h5>
                        <span class="custom-counter-badge mr-2" id="total_students_badge">0 Total Students</span>
                        <span class="custom-selected-badge" id="selected_students_badge">0 Selected</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-xs btn-outline-primary mr-1" id="btn_quick_select_all">
                            <i class="fa fa-check-square-o mr-1"></i> Select All
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-danger" id="btn_quick_deselect_all">
                            <i class="fa fa-square-o mr-1"></i> Deselect All
                        </button>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0" id="students_assign_table">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">
                                    <input type="checkbox" id="all_students" style="transform: scale(1.3); cursor: pointer;" title="Select All">
                                </th>
                                <th>Student Name</th>
                                <th>Admission No</th>
                                <th>Mobile Number</th>
                                <th>Father's Name</th>
                                <th>Currently Assigned Fee Heads</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_students_list">
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa fa-info-circle text-info fa-2x mb-2 d-block"></i>
                                    Please select a <b>Course</b> and <b>Class / Semester</b> above to load students.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bottom Sticky Submit Bar -->
                <div class="bottom-action-bar">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-shield text-success mr-2" style="font-size: 1.2rem;"></i>
                        <span class="text-muted" style="font-size: 0.88rem;">
                            Selected fee heads will be assigned to checked students. Existing assignments are safely maintained.
                        </span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm" id="btn_submit_assign">
                            <i class="fa fa-check-circle mr-1"></i> Assign Fees to (<span id="btn_selected_count">0</span>) Students
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
var defaultClasses = @json($allClassType ?? []);

function updateSelectedCount() {
    var checked = $('.student_select_checkbox:checked').length;
    var total = $('.student_select_checkbox').length;
    
    $('#selected_students_badge').text(checked + ' Selected');
    $('#btn_selected_count').text(checked);
    $('#total_students_badge').text(total + ' Total Students');
    
    if (total > 0 && checked === total) {
        $('#all_students').prop('checked', true);
    } else {
        $('#all_students').prop('checked', false);
    }
}

function loadStudents(class_type_id, admissionNo) {
    if (!class_type_id) {
        $('#tbody_students_list').html('<tr><td colspan="6" class="text-center py-4 text-muted"><i class="fa fa-info-circle mr-1"></i> Please select a Class / Semester to load students</td></tr>');
        updateSelectedCount();
        return;
    }
    
    $('#tbody_students_list').html('<tr><td colspan="6" class="text-center py-4 text-primary"><i class="fa fa-spinner fa-spin fa-2x"></i><br><span class="mt-2 d-block font-weight-bold">Loading students...</span></td></tr>');
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('getStudentsList') }}",
        method: 'POST',
        data: {
            class_type_id: class_type_id,
            admissionNo: admissionNo
        },
        success: function(response) {
            $('#tbody_students_list').html(response);
            updateSelectedCount();
        },
        error: function(xhr) {
            $('#tbody_students_list').html('<tr><td colspan="6" class="text-center text-danger py-4"><i class="fa fa-exclamation-triangle mr-1"></i> Error loading students list. Please try again.</td></tr>');
            updateSelectedCount();
        }
    });
}

function loadFeeMasterHeads(class_type_id) {
    if (!class_type_id) {
        $('#filter_fees_master_ids').empty().trigger('change');
        $('#fees_head_helper').text('Select class to populate fee heads');
        return;
    }
    
    $('#fees_head_helper').html('<i class="fa fa-spinner fa-spin"></i> Loading fee heads...');
    
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
                $('#fees_head_helper').text(response.length + ' fee head(s) available for this class');
            } else {
                $('#filter_fees_master_ids').empty().trigger('change');
                $('#fees_head_helper').html('<span class="text-warning"><i class="fa fa-warning mr-1"></i> No fee master heads found for this class. Create them in Fees Group first.</span>');
            }
        },
        error: function() {
            $('#fees_head_helper').html('<span class="text-danger">Error loading fee heads</span>');
        }
    });
}

$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();

    // Course Selection -> Updates Class Dropdown
    $('#filter_course_id').change(function() {
        var courseId = $(this).val();
        var classSelect = $('#filter_class_type_id');
        
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
        } else {
            classSelect.empty().append('<option value="">-- {{ __("common.Select") }} Class --</option>');
            if (defaultClasses && defaultClasses.length > 0) {
                $.each(defaultClasses, function(key, val) {
                    classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
            classSelect.val('').trigger('change');
        }
    });

    // Class Selection -> Loads Students & Fee Heads
    $('#filter_class_type_id').change(function() {
        var class_type_id = $(this).val();
        var admissionNo = $('#filter_admission_no').val();
        
        loadFeeMasterHeads(class_type_id);
        loadStudents(class_type_id, admissionNo);
    });

    // Search button & Enter key on Admission No
    $('#btn_search_students').click(function() {
        var class_type_id = $('#filter_class_type_id').val();
        var admissionNo = $('#filter_admission_no').val();
        loadStudents(class_type_id, admissionNo);
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
        $('#tbody_students_list').html('<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fa fa-info-circle text-info fa-2x mb-2 d-block"></i> Please select a <b>Course</b> and <b>Class / Semester</b> above to load students.</td></tr>');
        updateSelectedCount();
    });

    // Select All Checkbox Handler
    $('#all_students').click(function() {
        var isChecked = $(this).prop('checked');
        $('.student_select_checkbox').prop('checked', isChecked);
        updateSelectedCount();
    });

    // Quick Select / Deselect Buttons
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

    // Individual Student Checkbox Handler
    $(document).on('change', '.student_select_checkbox', function() {
        updateSelectedCount();
    });

    // Form Submit Validation
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
            alert("Please select at least one student to assign fees!");
            return false;
        }

        return confirm("Are you sure you want to assign the selected fee structure to " + checkedStudents + " student(s)?");
    });
});
</script>

@endsection
