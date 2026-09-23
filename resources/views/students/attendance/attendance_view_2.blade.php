@extends('layout.app') 
@section('content')
@php
$attendanceType = Helper::attendanceType();
$classType = Helper::classType($search['course'] ?? null);
$allClassType = Helper::classType();
$getPermission = Helper::getPermission();
$courses = Helper::getCourses();
$batches = Helper::getBatch();
@endphp
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


 <div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-calendar-minus-o"></i> &nbsp;{{ __('student.View Students Attendance') }}</h3>
                    <div class="card-tools">
                        @if(Session::get('role_id') !== 3)
                    <a href="{{url('studentsAttendanceAdd')}}" class="btn btn-primary {{($getPermission->add == 1) ? '' : 'd-none'}} btn-sm" ><i class="fa fa-plus"></i>{{ __('common.Add') }}  </a>
                 
                   <a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}  </a>
                      @endif
                    </div>
                    
                    </div>      
                    
                    @if(count($classType) > 0 || !empty($courses))
                <form id="quickForm" action="{{ url('studentsAttendanceViewTable') }}" method="post">
                    @csrf 
                  
                    <div class="row m-2">
                        <div class="col-md-2 col-6">
                			<div class="form-group">
                				<label>{{ __('Course') }}</label>
                				<select class="form-control select2" id="course" name="course">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->name ?? '' }}" {{ ($course->name == ($search['course'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                		    </div>
                		</div>

                		@if(Session::get('role_id') == 1 || Session::get('role_id') == 2)
                        <div class="col-md-2 col-6">
                    		<div class="form-group">
                    			<label>{{ __('Class / Semester') }}</label>
                    			<select class="form-control select2" id="class_type_id" name="class_type_id">
                    			    @if(Session::get('role_id') != 2)
                    			    <option value="">{{ __('common.Select') }}</option>
                                    @endif
                                    @if(!empty($classType)) 
                                        @foreach($classType as $type)
                                            <option value="{{ $type->id ?? '' }}" {{ ($type->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>{{ $type->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                    	    </div>
                    	</div>
                        @endif

                        <div class="col-md-1 col-6">
                			<div class="form-group">
                				<label>{{ __('Batch') }}</label>
                				<select class="form-control select2" id="batch" name="batch">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($batches))
                                        @foreach($batches as $b)
                                            <option value="{{ $b->name ?? '' }}" {{ (($b->name ?? '') == ($search['batch'] ?? '')) ? 'selected' : '' }}>{{ $b->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                		    </div>
                		</div>

                        <div class="col-md-2 col-6">
                			<div class="form-group">
                				<label>{{ __('common.Month') }}</label>
                				<select class="form-control select2" id='date__' name="date">
                                    <option value=''>--{{ __('student.Select Month') }}--</option>
                                    <option {{$search['date'] == '01' || $search['date'] == 1 ? "selected" : "" }} value='01'>January</option>
                                    <option {{$search['date'] == '02' || $search['date'] == 2 ? "selected" : "" }} value='02'>February</option>
                                    <option {{$search['date'] == '03' || $search['date'] == 3 ? "selected" : "" }} value='03'>March</option>
                                    <option {{$search['date'] == '04' || $search['date'] == 4 ? "selected" : "" }} value='04'>April</option>
                                    <option {{$search['date'] == '05' || $search['date'] == 5 ? "selected" : "" }} value='05'>May</option>
                                    <option {{$search['date'] == '06' || $search['date'] == 6 ? "selected" : "" }} value='06'>June</option>
                                    <option {{$search['date'] == '07' || $search['date'] == 7 ? "selected" : "" }} value='07'>July</option>
                                    <option {{$search['date'] == '08' || $search['date'] == 8 ? "selected" : "" }} value='08'>August</option>
                                    <option {{$search['date'] == '09' || $search['date'] == 9 ? "selected" : "" }} value='09'>September</option>
                                    <option {{$search['date'] == '10' || $search['date'] == 10 ? "selected" : "" }} value='10'>October</option>
                                    <option {{$search['date'] == '11' || $search['date'] == 11 ? "selected" : "" }} value='11'>November</option>
                                    <option {{$search['date'] == '12' || $search['date'] == 12 ? "selected" : "" }} value='12'>December</option>
                                </select> 
                		    </div>
                		</div>

                        <div class="col-md-1 col-6">
                			<div class="form-group">
                				<label>{{ __('Year') }}</label>
                				<select class="form-control select2" id='year' name="year">
                                    @for($y = 2023; $y <= 2030; $y++)
                                    <option value='{{ $y }}' {{ ($search['year'] ?? date('Y')) == $y ? "selected" : "" }}>{{ $y }}</option>
                                    @endfor
                                </select> 
                		    </div>
                		</div>

                        @if(Session::get('role_id') == 1)
                        <div class="col-md-1 col-6">
                            <div class="form-group">
                                <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                                <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-2 col-6">
                			<div class="form-group">
                				<label>{{ __('common.Search By Keywords') }}</label>
                				<input type="text" class="form-control" id="name" name="name" value="{{ $search['name'] ?? '' }}" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}">
                		    </div>
                		</div> 
                    	@endif	

                        <div class="col-md-1 col-12">
                    	    <label class="text-white d-none d-md-block">{{ __('common.Search') }}</label>
                    	    <button type="submit" class="btn btn-primary btn-block">{{ __('common.Search') }}</button>
                    	</div>
	
                    </div>
                </form>
                @else
                <p class="text-center text-danger mt-2">You are not yet authorized for viewing attendance .... please contact your administrator</p>
                  @endif
 

                  <div class="table-responsive p-0" style="max-height: 72vh; border: 1px solid #dee2e6; overflow: auto;">
                    <table id="table" class="table table-bordered table-striped table-hover compact-att-table mb-0">
                      <thead>
                        <tr id='days' role="row">
                        </tr>
                      </thead>
                      <tbody id='student_list'>
                      </tbody>
                    </table>
                  </div>
   
                  <div class="col-12 py-2 d-flex flex-wrap align-items-center justify-content-between bg-light border-top mt-2">
                    <div class="d-flex flex-wrap align-items-center">
                      <button class="btn btn-primary btn-sm mr-3 font-weight-bold" onclick="downloadCSV()"><i class="fa fa-download"></i> {{ __('Download CSV') }}</button>
                      <span class="badge badge-success px-2 py-1 mr-1">P</span> <span class="mr-3 small text-muted font-weight-bold">{{ __('Present') }}</span>
                      <span class="badge badge-danger px-2 py-1 mr-1">A</span> <span class="mr-3 small text-muted font-weight-bold">{{ __('Absent') }}</span>
                      <span class="badge badge-primary px-2 py-1 mr-1">H</span> <span class="mr-3 small text-muted font-weight-bold">{{ __('Holiday') }}</span>
                      <span class="badge badge-warning px-2 py-1 mr-1 text-dark">L</span> <span class="mr-3 small text-muted font-weight-bold">{{ __('Leave') }}</span>
                      <span class="badge badge-secondary px-2 py-1 mr-1">E</span> <span class="mr-3 small text-muted font-weight-bold">{{ __('Event') }}</span>
                      <span class="mr-2 small font-weight-bold" style="color: #28a745;"><i class="fa fa-clock-o"></i> In: Time (Green)</span>
                      <span class="small font-weight-bold" style="color: #dc3545;"><i class="fa fa-clock-o"></i> Out: Time (Red)</span>
                    </div>
                  </div>

                  </div>
                    
              </div>
            </div>
        </div>
      </div>
    </section>
</div>

<!-- Loading screen modal -->
<div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="w-100">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only text-white">Loading...</span>
                </div>
                <p class="mt-2 text-white loading_text">Loading Attendance Data...</p>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.select2').select2();
    });

    function updateClassDropdown(classSelect, data) {
        classSelect.empty();
        @if(Session::get('role_id') != 2)
        classSelect.append('<option value="">{{ __("common.Select") }}</option>');
        @endif
        if (data && data.length > 0) {
            $.each(data, function(key, val) {
                classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
            });
        }
        if (classSelect.hasClass("select2-hidden-accessible")) {
            classSelect.select2('destroy');
        }
        classSelect.select2();
        classSelect.val('').trigger('change');
    }

    $(document).on('change', '#course', function() {
        var courseName = $(this).val();
        var classSelect = $('#class_type_id');
        
        if (courseName) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course: courseName },
                dataType: "json",
                success: function(data) {
                    updateClassDropdown(classSelect, data);
                },
                error: function() {
                    updateClassDropdown(classSelect, []);
                }
            });
        } else {
            var defaultClasses = [];
            @if(!empty($allClassType))
                @foreach($allClassType as $type)
                    defaultClasses.push({ id: "{{ $type->id }}", name: "{{ $type->name }}" });
                @endforeach
            @endif
            updateClassDropdown(classSelect, defaultClasses);
        }
    });

    $('#quickForm').submit(function(event) {
        var date_array = [];
        var allStudents = @json($allStudents);

        $('#student_list').html('');
        event.preventDefault();
        $('#loadingModal').modal('show');
        var name = ($('#name').val() || '').toLowerCase().trim();
        var course = $('#course').val();
        var class_type_id = $('#class_type_id').val();
        var batch = $('#batch').val();
        var date = parseInt($('#date__').val());
      
        var admissionNo = ($('#admissionNo').val() || '').trim();
        var URL = "{{ url('/') }}";
        var year = $('#year').val();
        var month = parseInt($('#date__').val()) - 1;
        var daysInMonth = new Date(year, date, 0).getDate();
        var days = $('#days');
        days.html('');
        days.append('<th class="sticky-col-adm" style="min-width:55px; max-width:55px;">Adm No</th>');
        days.append('<th class="sticky-col-name" style="min-width:130px; text-align:left;">Name</th>');
        row_days = '';
        for(var i = 1; i <= daysInMonth; i++)
        {
            var dt = new Date(year, month, i);
            var dayOfWeek = dt.toLocaleString('en', { weekday: 'short' }); 
            var isSunday = (dt.getDay() === 0);
            var sunClass = isSunday ? 'bg-danger text-white' : '';
            row_days += '<th class="text-center ' + sunClass + '" style="min-width:32px; padding:3px 2px;"><span style="font-size:11px; font-weight:700;">' + i + '</span><br><span style="font-size:9px; font-weight:normal; opacity:0.9;">' + dayOfWeek + '</span></th>';
        }
        row_days += '<th class="text-center bg-success text-white" style="min-width:28px; padding:3px 2px; font-size:10px;" title="Present">P</th>';
        row_days += '<th class="text-center bg-danger text-white" style="min-width:28px; padding:3px 2px; font-size:10px;" title="Absent">A</th>';
        row_days += '<th class="text-center bg-primary text-white" style="min-width:28px; padding:3px 2px; font-size:10px;" title="Holiday">H</th>';
        row_days += '<th class="text-center bg-warning text-dark" style="min-width:28px; padding:3px 2px; font-size:10px;" title="Leave">L</th>';
        row_days += '<th class="text-center bg-secondary text-white" style="min-width:28px; padding:3px 2px; font-size:10px;" title="Event">E</th>';
        days.append(row_days);

        var container = $('#student_list');
        var count = 0;    
        allStudents.forEach(function(item, index) {
            var matchClass = true;
            if (class_type_id) {
                matchClass = (parseInt(item.class_type_id) == parseInt(class_type_id));
            }
            var matchCourse = true;
            if (course) {
                matchCourse = (item.course == course);
            }
            var matchBatch = true;
            if (batch) {
                matchBatch = (item.batch == batch);
            }
            var matchAdmissionNo = true;
            if (admissionNo) {
                matchAdmissionNo = (item.admissionNo == admissionNo || item.id == admissionNo);
            }
            var matchName = true;
            if (name) {
                var fullName = ((item.first_name || '') + ' ' + (item.last_name || '')).toLowerCase();
                var mobile = (item.mobile || '');
                var email = (item.email || '').toLowerCase();
                var aadhaar = (item.aadhaar || '');
                matchName = (fullName.includes(name) || mobile.includes(name) || email.includes(name) || aadhaar.includes(name));
            }

            if(matchClass && matchCourse && matchBatch && matchAdmissionNo && matchName)
            {
                var admDisplay = item.admissionNo ? item.admissionNo : item.id;
                var nameDisplay = item.first_name + (item.last_name ? ' ' + item.last_name : '');
                var row = '<tr id="' + item.id + '"><td class="sticky-col-adm font-weight-bold text-center">' + admDisplay + '</td><td class="sticky-col-name student-name" title="' + nameDisplay + '">' + nameDisplay + '</td>';

                var row2 = '';
                var row3 = '';

                var array_d = [];
                for(var i = 1; i <= daysInMonth; i++)
                {
                    var newclass = year + '-' + $('#date__').val() + '-' + (i < 10 ? '0' + i : i);
                    array_d.push(newclass);
                    row2 += '<td class="attendance-cell ' + newclass + '_' + item.id + '"></td>';
                }                           
                row3 += '<td class="text-center font-weight-bold text-success persent_' + item.id + '">0</td>';
                row3 += '<td class="text-center font-weight-bold text-danger absent_' + item.id + '">0</td>';
                row3 += '<td class="text-center font-weight-bold text-primary holiday_' + item.id + '">0</td>';
                row3 += '<td class="text-center font-weight-bold text-warning leave_' + item.id + '">0</td>';
                row3 += '<td class="text-center font-weight-bold text-secondary event_' + item.id + '">0</td>';
                 
                container.append(row + row2 + row3 + '</tr>');
                date_array[count] = { 'id': item.id, 'date': array_d };
                count++;
            }
        });

        var result = [];
        function divideIntoSlots(number) {
            var slots = Math.ceil(number / 15);
            var start = 0;
            for (var i = 0; i < slots; i++) {
                var slotValue = Math.min(15, number); 
                var end = start + slotValue - 1;
                result.push({ 'from': start, 'to': end });
                start = end + 1;
                number -= slotValue;
            }
            return result;
        }

        var slots = divideIntoSlots(date_array.length);
        var loop = 0;

        fetchData();
        function fetchData() {
            if(loop < result.length)
            {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    type: 'post',
                    url: URL + '/studentsAttendanceViewTable',
                    data: { data: JSON.stringify(date_array), loop: result[loop] },
                    success: function (response) {
                        $.each(response.data, function(index, item) {
                            $.each(item, function(index2, item2) {
                                var span_row = '';
                                if(item2.attendance_status_id == 1)
                                {
                                    var inTime = convertTo12HrFormat(item2.time);
                                    var outTime = convertTo12HrFormat(item2.out_time);
                                    var timeHtml = '';
                                    if (inTime) {
                                        timeHtml += '<span class="time-in">In:' + inTime + '</span>';
                                    }
                                    if (outTime) {
                                        timeHtml += '<span class="time-out">Out:' + outTime + '</span>';
                                    }
                                    
                                    if (timeHtml) {
                                        span_row = '<div class="d-flex flex-column align-items-center"><span class="badge badge-success badge-status">P</span>' + timeHtml + '</div>';
                                    } else {
                                        span_row = '<span class="badge badge-success badge-status">P</span>';
                                    }
                                }
                                else if(item2.attendance_status_id == 3)
                                {
                                    span_row = '<span class="badge badge-danger badge-status">A</span>';
                                }
                                else if(item2.attendance_status_id == 5)
                                {
                                    span_row = '<span class="badge badge-primary badge-status">H</span>';
                                }
                                else if(item2.attendance_status_id == 9)
                                {
                                    span_row = '<span class="badge badge-warning badge-status text-dark">L</span>';
                                }
                                else if(item2.attendance_status_id == 10)
                                {
                                    span_row = '<span class="badge badge-secondary badge-status">E</span>';
                                }
                                $('.' + item2.date + '_' + item2.admission_id).html(span_row);
                            });
                        });

                        loop++;
                        fetchData();
                        countStatuses();
                    }
                });
            } else {
                $('#loadingModal').modal('hide');
            }
        }
    });

    function countStatuses() {
        const table = document.getElementById('table');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let present = 0, absent = 0, holiday = 0, event = 0, leave = 0;
            const rowId = row.id;

            const totalCells = row.cells.length;
            const dayCellEnd = totalCells - 5;
            for (let i = 2; i < dayCellEnd; i++) {
                const cell = row.cells[i];
                const badge = cell.querySelector('.badge-status');
                if (badge) {
                    const status = badge.innerText.trim();
                    switch (status) {
                        case 'P':
                            present++;
                            break;
                        case 'A':
                            absent++;
                            break;
                        case 'H':
                            holiday++;
                            break;
                        case 'E':
                            event++;
                            break;
                        case 'L':
                            leave++;
                            break;
                    }
                }
            }

            const presentCell = document.querySelector(`.persent_${rowId}`);
            const absentCell = document.querySelector(`.absent_${rowId}`);
            const holidayCell = document.querySelector(`.holiday_${rowId}`);
            const eventCell = document.querySelector(`.event_${rowId}`);
            const leaveCell = document.querySelector(`.leave_${rowId}`);

            if (presentCell) presentCell.innerText = present;
            if (absentCell) absentCell.innerText = absent;
            if (holidayCell) holidayCell.innerText = holiday;
            if (eventCell) eventCell.innerText = event;
            if (leaveCell) leaveCell.innerText = leave;
        }
    }

    function convertTo12HrFormat(time24h) {
        if (!time24h || time24h === 'null' || time24h === 'undefined' || time24h === '00:00:00' || String(time24h).trim() === '') {
            return '';
        }
        var timeStr = String(time24h).trim();
        var timeArray = timeStr.split(':');
        if (timeArray.length < 2) return timeStr;
        var hours = parseInt(timeArray[0], 10);
        var minutes = parseInt(timeArray[1], 10);
        if (isNaN(hours) || isNaN(minutes)) return '';
        var period = hours < 12 ? 'AM' : 'PM';

        if (hours === 0) {
            hours = 12;
        } else if (hours > 12) {
            hours = hours - 12;
        }

        return hours + ':' + (minutes < 10 ? '0' + minutes : minutes) + ' ' + period;
    }

    function downloadCSV() {
        var month = $('#date__ option:selected').text();
        var classtype = $('#class_type_id option:selected').text();
        let csv = [];
        var pageTitle = document.title;
        csv.push(pageTitle);
        csv.push(`Month: ${month}, Class: ${classtype}`);

        const rows = document.querySelectorAll("#table tr");

        for (const row of rows.values()) {
            const cells = row.querySelectorAll("td, th");
            const rowText = Array.from(cells).map((cell) => {
                return '"' + cell.innerText.replace(/"/g, '""').replace(/\r?\n/g, ' ').trim() + '"';
            });
            csv.push(rowText.join(","));
        }
        
        const csvFile = new Blob([csv.join("\n")], {
            type: "text/csv;charset=utf-8;"
        });

        saveAs(csvFile, "Attendance_" + month + "_" + classtype + ".csv");
    }
</script>        

<style>
    .compact-att-table {
        font-size: 11px;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .compact-att-table th, 
    .compact-att-table td {
        padding: 3px 4px !important;
        vertical-align: middle !important;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    .compact-att-table td.student-name {
        text-align: left;
        font-size: 11.5px;
        font-weight: 500;
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .compact-att-table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #002c54 !important;
        color: #fff !important;
        border-color: #0b3d6f !important;
    }
    .compact-att-table .sticky-col-adm {
        position: sticky;
        left: 0;
        background-color: #f8f9fa;
        z-index: 5;
    }
    .compact-att-table .sticky-col-name {
        position: sticky;
        left: 55px;
        background-color: #f8f9fa;
        z-index: 5;
    }
    .compact-att-table thead th.sticky-col-adm,
    .compact-att-table thead th.sticky-col-name {
        z-index: 15;
        background-color: #002c54 !important;
        color: #fff !important;
    }
    .badge-status {
        display: inline-block;
        min-width: 18px;
        font-size: 10px;
        padding: 1px 4px;
        font-weight: 700;
        border-radius: 3px;
        line-height: 1.2;
    }
    .time-in {
        color: #28a745;
        font-size: 8px;
        font-weight: 700;
        line-height: 1.1;
        white-space: nowrap;
        margin-top: 1px;
    }
    .time-out {
        color: #dc3545;
        font-size: 8px;
        font-weight: 700;
        line-height: 1.1;
        white-space: nowrap;
        margin-top: 1px;
    }
    .attendance-cell {
        min-width: 32px;
        max-width: 60px;
    }
</style>
@endsection 