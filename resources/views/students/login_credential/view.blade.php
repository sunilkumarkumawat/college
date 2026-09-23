@php
    $classType = Helper::classType();
    $courses = Helper::getCourses();
    $totalStudents = !empty($data) ? $data->count() : 0;
    $generatedCount = !empty($data) ? $data->whereNotNull('userName')->where('userName', '!=', '')->count() : 0;
    $pendingCount = $totalStudents - $generatedCount;
@endphp
@extends('layout.app')
@section('content')

<style>
    .credential-badge {
        font-family: 'Consolas', 'Courier New', monospace;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .copy-btn {
        cursor: pointer;
        transition: transform 0.1s;
    }
    .copy-btn:hover {
        transform: scale(1.15);
    }
    .password-field-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .summary-card {
        border-radius: 6px;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary d-flex align-items-center justify-content-between">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-key"></i> &nbsp; {{ __('Login Credential Reports & Management') }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{ url('studentsDashboard') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-arrow-left"></i> {{ __('common.Back') }}
                                </a>
                            </div>
                        </div>

                        <!-- Search & Filter Card -->
                        <div class="card-body pb-0">
                            <form id="quickForm" action="{{ url('login_credential_reports') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                                            <input type="text" class="form-control" id="admissionNo" name="admissionNo" 
                                                placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('Course') }}</label>
                                            <select class="select2 form-control" id="search_course" name="course">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($courses))
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->name ?? '' }}" {{ ($search['course'] ?? '') == $course->name ? 'selected' : '' }}>
                                                            {{ $course->name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Class / Semester') }}</label>
                                            <select class="select2 form-control" id="search_class_type_id" name="class_type_id">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($classType))
                                                    @foreach($classType as $type)
                                                        <option value="{{ $type->id ?? '' }}" {{ ($type->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>
                                                            {{ $type->name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('Credential Status') }}</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="">{{ __('All Students') }}</option>
                                                <option value="generated" {{ ($search['status'] ?? '') == 'generated' ? 'selected' : '' }}>Generated</option>
                                                <option value="pending" {{ ($search['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending / Not Set</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('common.Search By Keywords') }}</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                placeholder="{{ __('messages.Ex. Student Name, Father/ Mother Name, Mobile etc.') }}" 
                                                value="{{ $search['name'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fa fa-search"></i> {{ __('common.Search') }}
                                        </button>
                                        <a href="{{ url('login_credential_reports') }}" class="btn btn-secondary ml-2">
                                            <i class="fa fa-refresh"></i> {{ __('Reset') }}
                                        </a>
                                    </div>

                                    <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                        <button type="button" class="btn btn-success" id="openModalBtn">
                                            <i class="fa fa-cogs"></i> Generate Credentials (Bulk)
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr class="my-1">

                        <!-- Summary Cards -->
                        @if(!empty($data))
                        <div class="card-body py-2">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="summary-card bg-light border">
                                        <div>
                                            <small class="text-muted text-uppercase font-weight-bold">Total Students</small>
                                            <h4 class="mb-0 text-primary font-weight-bold">{{ $totalStudents }}</h4>
                                        </div>
                                        <i class="fa fa-users fa-2x text-primary opacity-50"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="summary-card bg-light border border-success">
                                        <div>
                                            <small class="text-success text-uppercase font-weight-bold">Credentials Generated</small>
                                            <h4 class="mb-0 text-success font-weight-bold" id="generated_count_display">{{ $generatedCount }}</h4>
                                        </div>
                                        <i class="fa fa-check-circle fa-2x text-success"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="summary-card bg-light border border-warning">
                                        <div>
                                            <small class="text-warning text-uppercase font-weight-bold">Credentials Pending</small>
                                            <h4 class="mb-0 text-warning font-weight-bold" id="pending_count_display">{{ $pendingCount }}</h4>
                                        </div>
                                        <i class="fa fa-clock-o fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Results Table -->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th style="width:70px;" class="text-center">
                                                <input type="checkbox" id="select_all" class="pointer" style="width:16px;height:16px;vertical-align:middle;">
                                                <label for="select_all" class="pointer mb-0 text-white"><small>All</small></label>
                                            </th>
                                            <th>#</th>
                                            <th>{{ __('student.Admission No.') }}</th>
                                            <th>{{ __('student.Student Name') }}</th>
                                            <th>{{ __('student.Father Name') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Class / Semester') }}</th>
                                            <th>{{ __('common.Mobile') }}</th>
                                            <th>{{ __('UserName') }}</th>
                                            <th>{{ __('Password') }}</th>
                                            <th class="text-center">{{ __('Status') }}</th>
                                            <th class="text-center" style="width:110px;">{{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($data) && $data->count() > 0)
                                            @php $i = 1; @endphp
                                            @foreach ($data as $item)
                                                @php
                                                    $hasCred = !empty($item->userName);
                                                    $studentCourse = $item->course ?? ($item->ClassTypes->course->name ?? 'N/A');
                                                @endphp
                                                <tr id="student_row_{{ $item->id }}">
                                                    <td class="text-center">
                                                        <input type="checkbox" class="student_checkbox pointer" value="{{ $item->id }}" style="width:16px;height:16px;">
                                                    </td>
                                                    <td>{{ $i++ }}</td>
                                                    <td><strong class="text-primary">{{ $item->admissionNo ?? '-' }}</strong></td>
                                                    <td>
                                                        <span class="font-weight-bold">{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}</span>
                                                    </td>
                                                    <td>{{ $item->father_name ?? '-' }}</td>
                                                    <td><span class="badge badge-info">{{ $studentCourse }}</span></td>
                                                    <td>{{ $item->class_name ?? ($item->ClassTypes->name ?? '-') }}</td>
                                                    <td>{{ $item->mobile ?? '-' }}</td>
                                                    
                                                    <!-- Username Column -->
                                                    <td>
                                                        <span id="display_username_{{ $item->id }}">
                                                            @if(!empty($item->userName))
                                                                <span class="badge badge-light border credential-badge text-dark p-1">
                                                                    {{ $item->userName }}
                                                                </span>
                                                                <i class="fa fa-clone text-primary ml-1 copy-btn" title="Copy Username" onclick="copyToClipboard('{{ $item->userName }}', 'Username copied!')"></i>
                                                            @else
                                                                <span class="text-muted font-italic"><small>Not Set</small></span>
                                                            @endif
                                                        </span>
                                                    </td>

                                                    <!-- Password Column -->
                                                    <td>
                                                        <span id="display_password_container_{{ $item->id }}">
                                                            @if(!empty($item->confirm_password))
                                                                <div class="password-field-wrapper">
                                                                    <span class="badge badge-light border credential-badge text-dark p-1 masked-pass" id="pass_masked_{{ $item->id }}">
                                                                        ••••••••
                                                                    </span>
                                                                    <span class="badge badge-light border credential-badge text-dark p-1 d-none plain-pass" id="pass_plain_{{ $item->id }}">
                                                                        {{ $item->confirm_password }}
                                                                    </span>
                                                                    <i class="fa fa-eye text-muted ml-1 pointer toggle-pass-btn" title="Show / Hide Password" onclick="togglePasswordVisibility({{ $item->id }})"></i>
                                                                    <i class="fa fa-clone text-primary ml-1 copy-btn" title="Copy Password" onclick="copyToClipboard('{{ $item->confirm_password }}', 'Password copied!')"></i>
                                                                </div>
                                                            @else
                                                                <span class="text-muted font-italic"><small>Not Set</small></span>
                                                            @endif
                                                        </span>
                                                    </td>

                                                    <!-- Status Badge Column -->
                                                    <td class="text-center" id="status_badge_{{ $item->id }}">
                                                        @if($hasCred)
                                                            <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                                        @else
                                                            <span class="badge badge-warning text-dark"><i class="fa fa-clock-o"></i> Pending</span>
                                                        @endif
                                                    </td>

                                                    <!-- Action Column: Edit / Create Specific Student -->
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-primary btn-xs px-2 edit-credential-btn" 
                                                            data-id="{{ $item->id }}"
                                                            data-name="{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}"
                                                            data-adm="{{ $item->admissionNo ?? '' }}"
                                                            data-mobile="{{ $item->mobile ?? '' }}"
                                                            data-course="{{ $studentCourse }}"
                                                            data-class="{{ $item->class_name ?? ($item->ClassTypes->name ?? '') }}"
                                                            data-username="{{ $item->userName ?? '' }}"
                                                            data-password="{{ $item->confirm_password ?? '' }}"
                                                            title="Edit or Set Credentials for this Student">
                                                            <i class="fa fa-edit"></i> Edit / Set
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center text-muted py-4">
                                                    <i class="fa fa-search fa-2x mb-2 text-muted"></i><br>
                                                    No student records found matching your filters.
                                                </td>
                                            </tr>
                                        @endif
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

<!-- ============================================================== -->
<!-- 1️⃣ SINGLE STUDENT CREDENTIAL MODAL -->
<!-- ============================================================== -->
<div class="modal fade" id="singleCredentialModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-user-circle"></i> Student Login Credentials</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="singleCredentialForm">
                @csrf
                <input type="hidden" id="single_student_id" name="student_id">

                <div class="modal-body">
                    <!-- Student Info Box -->
                    <div class="bg-light p-3 rounded mb-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong id="modal_student_name" class="text-primary h6 mb-0"></strong>
                            <span class="badge badge-secondary" id="modal_student_adm"></span>
                        </div>
                        <div class="small text-muted">
                            <span><strong>Course:</strong> <span id="modal_student_course"></span></span> | 
                            <span><strong>Class:</strong> <span id="modal_student_class"></span></span>
                        </div>
                    </div>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="single_username" class="font-weight-bold">
                            Username *
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="single_username" name="username" required placeholder="Enter Username">
                        </div>
                        <small class="form-text text-muted">
                            Quick Suggestions: 
                            <a href="javascript:void(0)" class="badge badge-light border mr-1" id="btn_suggest_adm">Use Admission No</a>
                            <a href="javascript:void(0)" class="badge badge-light border mr-1" id="btn_suggest_stu">Use stu_admNo</a>
                            <a href="javascript:void(0)" class="badge badge-light border" id="btn_suggest_namemob">Use Name+Mobile</a>
                        </small>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="single_password" class="font-weight-bold">
                            Password *
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="single_password" name="password" required minlength="4" placeholder="Enter Password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="btn_toggle_single_pass" title="Show / Hide Password">
                                    <i class="fa fa-eye" id="single_pass_eye"></i>
                                </button>
                                <button class="btn btn-outline-primary" type="button" id="btn_random_pass" title="Generate Random Password">
                                    <i class="fa fa-random"></i> Auto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="btn_save_single_cred">
                        <i class="fa fa-check"></i> Save & Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- 2️⃣ BULK USERNAME & PASSWORD GENERATOR MODAL -->
<!-- ============================================================== -->
<div class="modal fade" id="generateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ url('studentUserNameCreate') }}" method="POST">
            @csrf
            <input type="hidden" name="student_ids" id="bulk_student_ids">
            
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa fa-cogs"></i> Bulk Username & Password Generator</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info py-2 mb-3">
                        <i class="fa fa-info-circle"></i> <span id="bulk_selected_count_text">Generating credentials for selected students.</span>
                    </div>

                    <div class="row">
                        <!-- USERNAME FORMULA CHECKBOXES -->
                        <div class="col-md-6 border-right">
                            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-user"></i> Username Formula / Fields</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="username_admission_no" checked>
                                <label class="form-check-label pointer" for="username_admission_no">Admission No</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="username_name">
                                <label class="form-check-label pointer" for="username_name">
                                    First Name (first <input type="number" name="name_letters" value="4" min="1" max="15" class="form-control form-control-sm d-inline-block" style="width:65px"> letters)
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="username_mobile">
                                <label class="form-check-label pointer" for="username_mobile">
                                    Mobile (last <input type="number" name="mobile_digits" value="4" min="1" max="10" class="form-control form-control-sm d-inline-block" style="width:65px"> digits)
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="username_dob">
                                <label class="form-check-label pointer" for="username_dob">Date of Birth (DDMMYY)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="username_class">
                                <label class="form-check-label pointer" for="username_class">Class / Semester Code</label>
                            </div>
                        </div>

                        <!-- PASSWORD FORMULA / CUSTOM CHECKBOXES -->
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-lock"></i> Password Formula / Options</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="password_admission_no">
                                <label class="form-check-label pointer" for="password_admission_no">Admission No</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="password_name">
                                <label class="form-check-label pointer" for="password_name">First Name</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="password_mobile" checked>
                                <label class="form-check-label pointer" for="password_mobile">Mobile Number</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="password_dob">
                                <label class="form-check-label pointer" for="password_dob">Date of Birth (DDMMYY)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="password_class">
                                <label class="form-check-label pointer" for="password_class">Class / Semester Code</label>
                            </div>

                            <hr class="my-2">
                            <label class="font-weight-bold">Or Set Fixed Custom Password:</label>
                            <input type="text" name="custom_password" id="custom_password" class="form-control" placeholder="e.g. 12345678 or Pass@123">
                            <small class="text-muted">If custom password is typed, it overrides the checkboxes above.</small>
                        </div>
                    </div>

                    <hr>

                    <!-- LIVE PREVIEW BOX -->
                    <div class="bg-light p-3 rounded border">
                        <h6 class="font-weight-bold mb-2 text-dark"><i class="fa fa-eye"></i> Live Simulation Preview:</h6>
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <small class="text-muted">Student Name:</small>
                                <input type="text" id="ex_name" value="Ravi Kumar" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <small class="text-muted">Mobile:</small>
                                <input type="text" id="ex_mobile" value="9876543210" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <small class="text-muted">DOB:</small>
                                <input type="date" id="ex_dob" value="2005-08-15" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <small class="text-muted">Admission No:</small>
                                <input type="text" id="ex_admission" value="ADM1024" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="mt-2 pt-2 border-top d-flex justify-content-around">
                            <span>Username Preview: <strong id="usernamePreview" class="text-primary font-monospace">[Username]</strong></span>
                            <span>Password Preview: <strong id="passwordPreview" class="text-success font-monospace">[Password]</strong></span>
                        </div>
                    </div>

                    <!-- Hidden fields for sending order -->
                    <input type="hidden" name="username_order" id="username_order">
                    <input type="hidden" name="password_order" id="password_order">
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4"><i class="fa fa-bolt"></i> Generate for Selected Students</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT LOGIC -->
<!-- ============================================================== -->
<script>
    $(document).ready(function () {
        $('.select2').select2();

        // 1. Dynamic Dependent Class Loading on Search Course Change
        $('#search_course').on('change', function () {
            var courseName = $(this).val();
            var classSelect = $('#search_class_type_id');

            classSelect.empty();
            classSelect.append('<option value="">{{ __("common.Select") }}</option>');

            if (courseName) {
                $.ajax({
                    url: "{{ url('getClassesByCourse') }}",
                    type: "GET",
                    data: { course: courseName },
                    dataType: "json",
                    success: function (data) {
                        if (data && data.length > 0) {
                            $.each(data, function (key, val) {
                                classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                            });
                        }
                        classSelect.trigger('change.select2');
                    }
                });
            } else {
                @if(!empty($classType))
                    @foreach($classType as $type)
                        classSelect.append('<option value="{{ $type->id }}">{{ $type->name }}</option>');
                    @endforeach
                @endif
                classSelect.trigger('change.select2');
            }
        });

        // 2. Select All Checkbox
        $('#select_all').on('change', function () {
            $('.student_checkbox').prop('checked', $(this).is(':checked'));
        });

        $(document).on('change', '.student_checkbox', function () {
            var total = $('.student_checkbox').length;
            var checked = $('.student_checkbox:checked').length;
            $('#select_all').prop('checked', total === checked);
        });

        // 3. Open Bulk Generate Modal with Selection Validation
        $('#openModalBtn').on('click', function (e) {
            var selectedIds = [];
            $('.student_checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                toastr.warning('Please select at least one student from the table.');
                return false;
            }

            $('#bulk_student_ids').val(selectedIds.join(','));
            $('#bulk_selected_count_text').text('Generating credentials for ' + selectedIds.length + ' selected student(s).');
            $('#generateModal').modal('show');
        });

        // 4. Single Student Credential Modal Open & Setup
        var currentStudentData = {};
        $('.edit-credential-btn').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var adm = $(this).data('adm');
            var course = $(this).data('course');
            var className = $(this).data('class');
            var username = $(this).data('username') || '';
            var password = $(this).data('password') || '';
            var mobile = $(this).data('mobile') || '';

            currentStudentData = {
                id: id,
                name: name,
                adm: adm,
                mobile: mobile,
                course: course,
                className: className
            };

            $('#single_student_id').val(id);
            $('#modal_student_name').text(name);
            $('#modal_student_adm').text('Adm: ' + (adm || 'N/A'));
            $('#modal_student_course').text(course || 'N/A');
            $('#modal_student_class').text(className || 'N/A');

            $('#single_username').val(username || (adm ? adm : ''));
            $('#single_password').val(password || '12345678');
            $('#single_password').attr('type', 'password');
            $('#single_pass_eye').removeClass('fa-eye-slash').addClass('fa-eye');

            $('#singleCredentialModal').modal('show');
        });

        // Single Modal Quick Suggestions
        $('#btn_suggest_adm').on('click', function () {
            if (currentStudentData.adm) {
                $('#single_username').val(currentStudentData.adm);
            }
        });
        $('#btn_suggest_stu').on('click', function () {
            if (currentStudentData.adm) {
                $('#single_username').val('stu_' + currentStudentData.adm);
            }
        });
        $('#btn_suggest_namemob').on('click', function () {
            var cleanName = (currentStudentData.name || '').toLowerCase().replace(/\s+/g, '').substring(0, 4);
            var cleanMob = (currentStudentData.mobile || '').replace(/\D/g, '').slice(-4);
            $('#single_username').val(cleanName + cleanMob);
        });

        // Toggle Single Password Visibility
        $('#btn_toggle_single_pass').on('click', function () {
            var passField = $('#single_password');
            var eyeIcon = $('#single_pass_eye');
            if (passField.attr('type') === 'password') {
                passField.attr('type', 'text');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passField.attr('type', 'password');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Generate Random Password
        $('#btn_random_pass').on('click', function () {
            var randomChars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789@#$';
            var generatedPass = '';
            for (var i = 0; i < 8; i++) {
                generatedPass += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
            }
            $('#single_password').val(generatedPass);
            $('#single_password').attr('type', 'text');
            $('#single_pass_eye').removeClass('fa-eye').addClass('fa-eye-slash');
        });

        // 5. Submit Single Credential Form via AJAX
        $('#singleCredentialForm').on('submit', function (e) {
            e.preventDefault();
            var studentId = $('#single_student_id').val();
            var username = $('#single_username').val().trim();
            var password = $('#single_password').val().trim();

            if (!username || !password) {
                toastr.error('Username and password are required.');
                return;
            }

            $('#btn_save_single_cred').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: "{{ url('updateSingleStudentCredential') }}",
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    student_id: studentId,
                    username: username,
                    password: password
                },
                dataType: "json",
                success: function (res) {
                    $('#btn_save_single_cred').prop('disabled', false).html('<i class="fa fa-check"></i> Save & Update');
                    if (res.status) {
                        toastr.success(res.message);
                        $('#singleCredentialModal').modal('hide');

                        // Update DOM Row
                        $('#display_username_' + studentId).html(
                            '<span class="badge badge-light border credential-badge text-dark p-1">' + username + '</span> ' +
                            '<i class="fa fa-clone text-primary ml-1 copy-btn" title="Copy Username" onclick="copyToClipboard(\'' + username + '\', \'Username copied!\')"></i>'
                        );

                        $('#display_password_container_' + studentId).html(
                            '<div class="password-field-wrapper">' +
                                '<span class="badge badge-light border credential-badge text-dark p-1 masked-pass" id="pass_masked_' + studentId + '">••••••••</span>' +
                                '<span class="badge badge-light border credential-badge text-dark p-1 d-none plain-pass" id="pass_plain_' + studentId + '">' + password + '</span>' +
                                '<i class="fa fa-eye text-muted ml-1 pointer toggle-pass-btn" title="Show / Hide Password" onclick="togglePasswordVisibility(' + studentId + ')"></i>' +
                                '<i class="fa fa-clone text-primary ml-1 copy-btn" title="Copy Password" onclick="copyToClipboard(\'' + password + '\', \'Password copied!\')"></i>' +
                            '</div>'
                        );

                        $('#status_badge_' + studentId).html('<span class="badge badge-success"><i class="fa fa-check"></i> Active</span>');

                        // Update Edit Button data attributes
                        var editBtn = $('button.edit-credential-btn[data-id="' + studentId + '"]');
                        editBtn.data('username', username);
                        editBtn.data('password', password);
                    } else {
                        toastr.error(res.message || 'Failed to update credentials.');
                    }
                },
                error: function (xhr) {
                    $('#btn_save_single_cred').prop('disabled', false).html('<i class="fa fa-check"></i> Save & Update');
                    var errorMsg = 'An error occurred while updating.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                }
            });
        });
    });

    // ==============================================================
    // HELPER FUNCTIONS (Copy to Clipboard & Toggle Password in Table)
    // ==============================================================
    function copyToClipboard(text, message) {
        if (!text) return;
        navigator.clipboard.writeText(text).then(function () {
            toastr.info(message || 'Copied to clipboard!');
        }).catch(function () {
            toastr.error('Failed to copy');
        });
    }

    function togglePasswordVisibility(studentId) {
        var masked = $('#pass_masked_' + studentId);
        var plain = $('#pass_plain_' + studentId);

        if (plain.hasClass('d-none')) {
            plain.removeClass('d-none');
            masked.addClass('d-none');
        } else {
            plain.addClass('d-none');
            masked.removeClass('d-none');
        }
    }

    // ==============================================================
    // BULK GENERATOR FORMULA & LIVE PREVIEW SCRIPT
    // ==============================================================
    document.addEventListener('DOMContentLoaded', function () {
        const usernameFields = [
            { id: 'username_admission_no', key: 'admission_no' },
            { id: 'username_name', key: 'name' },
            { id: 'username_mobile', key: 'mobile' },
            { id: 'username_dob', key: 'dob' },
            { id: 'username_class', key: 'class' }
        ];

        const passwordFields = [
            { id: 'password_admission_no', key: 'admission_no' },
            { id: 'password_name', key: 'name' },
            { id: 'password_mobile', key: 'mobile' },
            { id: 'password_dob', key: 'dob' },
            { id: 'password_class', key: 'class' }
        ];

        const example = {
            name: document.getElementById('ex_name'),
            mobile: document.getElementById('ex_mobile'),
            dob: document.getElementById('ex_dob'),
            admission: document.getElementById('ex_admission'),
        };

        function getFieldValue(key) {
            switch (key) {
                case 'name':
                    const len = document.querySelector('[name="name_letters"]').value || 4;
                    return (example.name.value || '').trim().toLowerCase().replace(/\s+/g, '').substring(0, len);
                case 'mobile':
                    const digits = document.querySelector('[name="mobile_digits"]').value || 4;
                    return (example.mobile.value || '').trim().replace(/\D/g, '').slice(-digits);
                case 'dob':
                    const dob = example.dob.value;
                    if (!dob) return '';
                    const parts = dob.split('-');
                    return parts.length === 3 ? parts[2] + parts[1] + parts[0].slice(2) : '';
                case 'admission_no':
                    return (example.admission.value || '').trim();
                case 'class':
                    return 'bca1';
                default:
                    return '';
            }
        }

        function updateOrdersAndPreview() {
            const u_order = [];
            const p_order = [];
            let username = '';
            let password = '';

            usernameFields.forEach(f => {
                const cb = document.getElementById(f.id);
                if (cb && cb.checked) {
                    u_order.push(f.key);
                    username += getFieldValue(f.key);
                }
            });

            const customPass = document.getElementById('custom_password').value.trim();
            if (customPass) {
                password = customPass;
            } else {
                passwordFields.forEach(f => {
                    const cb = document.getElementById(f.id);
                    if (cb && cb.checked) {
                        p_order.push(f.key);
                        password += getFieldValue(f.key);
                    }
                });
            }

            document.getElementById('username_order').value = u_order.join(',');
            document.getElementById('password_order').value = p_order.join(',');
            document.getElementById('usernamePreview').innerText = username || '[Username]';
            document.getElementById('passwordPreview').innerText = password || '[Password]';
        }

        document.querySelectorAll('#generateModal input').forEach(el => {
            el.addEventListener('input', updateOrdersAndPreview);
            el.addEventListener('change', updateOrdersAndPreview);
        });

        // Initialize preview once
        updateOrdersAndPreview();
    });
</script>
@endsection