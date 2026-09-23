@php
    $classType = Helper::classType($search['course'] ?? null);
    $allClassType = Helper::classType();
    $courses = Helper::getCourses();
    $batches = Helper::getBatch();
    $getAttendanceStatus = Helper::getAttendanceStatus();
@endphp
@extends('layout.app') 
@section('content')

<style>
    .paddingTable thead tr {
        background: #002c54;
        color: white;
    }
    
    .paddingTable thead tr th {
        padding: 8px 10px;
        vertical-align: middle;
    }
    .checkbox-class {
        width: 18px;
        height: 18px;
        vertical-align: middle;
    }
    .promotion-target-box {
        background-color: #f4f6f9;
        border: 1px solid #d2d6de;
        border-radius: 6px;
        padding: 15px;
    }
</style>

<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<input type="hidden" id="session_id" value="{{ Session::get('role_id') ?? '' }}">

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-graduation-cap"></i> &nbsp;{{ __('Promote Students') }}</h3>
                            <div class="card-tools">
                                <a href="{{ url('studentsDashboard') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}</a>
                            </div>
                        </div>

                        <!-- Step 1: Search / Filter Source Students -->
                        <div class="card-body pb-0">
                            <form id="quickForm" action="{{ url('student/promote_add') }}" method="post">
                                @csrf 
                                <div class="row">
                                    <div class="col-md-2 col-6">
                                        <div class="form-group">
                                            <label>{{ __('Course') }}</label>
                                            <select class="form-control select2" id="search_course" name="course">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($courses))
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->name ?? '' }}" {{ ($search['course'] ?? '') == $course->name ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="form-group">
                                            <label>{{ __('Class / Semester') }}</label>
                                            <select class="form-control select2" id="search_class_type_id" name="class_type_id">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($classType)) 
                                                    @foreach($classType as $type)
                                                        <option value="{{ $type->id ?? '' }}" {{ ($search['class_type_id'] ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name ?? '' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="form-group">
                                            <label>{{ __('Batch') }}</label>
                                            <select class="form-control select2" id="search_batch" name="batch">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($batches))
                                                    @foreach($batches as $b)
                                                        <option value="{{ $b->name ?? '' }}" {{ ($search['batch'] ?? '') == $b->name ? 'selected' : '' }}>{{ $b->name ?? '' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="form-group">
                                            <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                                            <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="form-group">
                                            <label>{{ __('common.Search By Keywords') }}</label>
                                            <input type="text" class="form-control" name="name" placeholder="{{ __('messages.Ex. Student Name, Father/ Mother Name, Mobile etc.') }}" value="{{ $search['name'] ?? '' }}"> 
                                        </div>
                                    </div> 
                                    <div class="col-md-1 col-12">
                                        <label for="" class="d-none d-md-block">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> {{ __('common.Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr class="mt-2 mb-2">

                        <!-- Step 2: Promotion Target & Student Selection Form -->
                        <form id="promoteForm" action="{{ url('studentsPromoteAdd') }}" method="post">
                            @csrf 
                            <div class="card-body pt-0">
                                <div class="promotion-target-box mb-3">
                                    <h6 class="text-primary font-weight-bold mb-3"><i class="fa fa-arrow-circle-right"></i> {{ __('Promotion Target Configuration') }}</h6>
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="form-group mb-0">
                                                <label class="text-danger">{{ __('Promote To Course') }} *</label>
                                                <select class="form-control select2" id="promote_course" name="promote_course" required>
                                                    <option value="">{{ __('common.Select') }}</option>
                                                    @if(!empty($courses))
                                                        @foreach($courses as $c)
                                                            <option value="{{ $c->name ?? '' }}" {{ ($search['course'] ?? '') == $c->name ? 'selected' : '' }}>{{ $c->name ?? '' }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group mb-0">
                                                <label class="text-danger">{{ __('Promote To Class / Semester') }} *</label>
                                                <select class="form-control select2" id="promote_class_type_id" name="promote_class_type_id" required>
                                                    <option value="">{{ __('common.Select') }}</option>
                                                    @if(!empty($classType))
                                                        @foreach($classType as $promoteClass)
                                                            <option value="{{ $promoteClass->id ?? '' }}">{{ $promoteClass->name ?? '' }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <div class="form-group mb-0">
                                                <label>{{ __('Promote To Batch') }}</label>
                                                <select class="form-control select2" id="promote_batch" name="promote_batch">
                                                    <option value="">{{ __('Current / Same Batch') }}</option>
                                                    @if(!empty($batches))
                                                        @foreach($batches as $b)
                                                            <option value="{{ $b->name ?? '' }}" {{ ($search['batch'] ?? '') == $b->name ? 'selected' : '' }}>{{ $b->name ?? '' }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <div class="form-group mb-0">
                                                <label class="text-danger">{{ __('In Session') }} *</label>
                                                <select class="form-control select2" id="new_session_id" name="session_id" required>
                                                    @if(!empty($session)) 
                                                        @foreach($session as $item)
                                                            <option value="{{ $item->id ?? '' }}" 
                                                                @if(Session::get('session_id') + 1 == $item->id) selected @endif
                                                                @if(Session::get('session_id') + 1 > $item->id) disabled @endif>
                                                                {{ $item->from_year ?? '' }}-{{ $item->to_year ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    @endif  
                                                </select>      
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <div class="form-group mb-0">
                                                <label class="text-danger">{{ __('Promotion Date') }} *</label>
                                                <input class="form-control @error('date') is-invalid @enderror" type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                                                @error('date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                   
                                            </div>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped border dataTable dtr-inline paddingTable">
                                        <thead>
                                            <tr role="row">
                                                <th width="80">
                                                    <input type="checkbox" id="masterCheckbox" class="pointer checkbox-class" checked> 
                                                    <label class="pointer mb-0 text-white" for="masterCheckbox">{{ __('Select') }}</label>
                                                </th>
                                                <th>{{ __('Admission No.') }}</th>
                                                <th>{{ __('Student Name') }}</th>
                                                <th>{{ __('Father Name') }}</th>
                                                <th>{{ __('Course') }}</th>
                                                <th>{{ __('Current Class / Semester') }}</th>
                                                <th>{{ __('Batch') }}</th>
                                                <th>{{ __('common.Mobile') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($data))
                                                @if($data->count() > 0)
                                                    @php $i = 1; @endphp
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>
                                                                {{ $i++ }} &nbsp;
                                                                <input type="checkbox" class="student-checkbox pointer checkbox-class" name="admission_ids[]" value="{{ $item['id'] ?? '' }}" checked>
                                                            </td>
                                                            <td>{{ $item['admissionNo'] ?? '' }}</td>
                                                            <td><strong>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</strong></td>
                                                            <td>{{ $item['father_name'] ?? '' }}</td>
                                                            <td><span class="badge badge-info">{{ $item['course'] ?? ($item['ClassTypes']['course']['name'] ?? 'N/A') }}</span></td>
                                                            <td>{{ $item['ClassTypes']['name'] ?? '' }}</td>
                                                            <td><span class="badge badge-secondary">{{ $item['batch'] ?? '-' }}</span></td>
                                                            <td>{{ $item['mobile'] ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center text-danger py-4">
                                                            <i class="fa fa-exclamation-circle fa-2x mb-2"></i><br>
                                                            No Students Found for the selected criteria!
                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-4">
                                                        <i class="fa fa-search fa-2x mb-2"></i><br>
                                                        Please apply filters above to find students for promotion.
                                                    </td>
                                                </tr>
                                            @endif    
                                        </tbody>
                                    </table>
                                </div>

                                @if(!empty($data) && $data->count() > 0)
                                    <div class="row mt-3 mb-2">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fa fa-graduation-cap"></i> {{ __('Promote Selected Students') }}
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>                  
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('.select2').select2();

    // 1. Search Form: Dynamic Dependent Class loading on Search Course change
    $(document).on('change', '#search_course', function() {
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
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(key, val) {
                            classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                        });
                    }
                    classSelect.val('').trigger('change.select2').trigger('change');
                },
                error: function() {
                    classSelect.val('').trigger('change.select2').trigger('change');
                }
            });
        } else {
            @if(!empty($allClassType))
                @foreach($allClassType as $type)
                    classSelect.append('<option value="{{ $type->id }}">{{ $type->name }}</option>');
                @endforeach
            @endif
            classSelect.val('').trigger('change.select2').trigger('change');
        }
    });

    // 2. Promotion Target: Dynamic Dependent Class loading on Promote Course change
    $(document).on('change', '#promote_course', function() {
        var courseName = $(this).val();
        var classSelect = $('#promote_class_type_id');
        
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.Select") }}</option>');
        
        if (courseName) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course: courseName },
                dataType: "json",
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(key, val) {
                            classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                        });
                    }
                    classSelect.val('').trigger('change.select2').trigger('change');
                },
                error: function() {
                    classSelect.val('').trigger('change.select2').trigger('change');
                }
            });
        } else {
            @if(!empty($allClassType))
                @foreach($allClassType as $type)
                    classSelect.append('<option value="{{ $type->id }}">{{ $type->name }}</option>');
                @endforeach
            @endif
            classSelect.val('').trigger('change.select2').trigger('change');
        }
    });

    // Form submit confirmation
    $('#promoteForm').on('submit', function(e) {
        var checkedStudents = $('.student-checkbox:checked').length;
        if (checkedStudents === 0) {
            e.preventDefault();
            toastr.error('Please select at least one student to promote.');
            return false;
        }

        return confirm('Are you sure you want to promote ' + checkedStudents + ' selected student(s)?');
    });

    // Master Checkbox Toggle
    $('#masterCheckbox').on('change', function() {
        $('.student-checkbox').prop('checked', $(this).prop('checked'));
    });

    $(document).on('change', '.student-checkbox', function() {
        var total = $('.student-checkbox').length;
        var checked = $('.student-checkbox:checked').length;
        $('#masterCheckbox').prop('checked', total === checked);
    });

    // Trigger initial promote_course change if preselected
    var initialCourse = "{{ $search['course'] ?? '' }}";
    if (initialCourse) {
        $('#promote_course').trigger('change');
    }
});
</script>
@endsection 