@php
    $getAttendanceStatus= Helper::getAttendanceStatus();


@endphp      
@if(!empty($data))

                @if($data->count() > 0)
                        @php
                           $i=1;
     
                        @endphp
                        @foreach ($data  as $key => $item)
                          @php
                           $stu_att = DB::table('student_attendance')
                                ->where('session_id', Session::get('session_id'))
                                ->where('branch_id', Session::get('branch_id'))
                                ->where('admission_id', $item['id'])
                                ->whereDate('date', $custom_date)
                                ->first();
        
                        @endphp
                        <tr>
                                <input type="hidden" id="class_type_id" name="class_type_id[]" value="{{ $item['class_type_id'] ?? '' }}">
                                 <input type="hidden" id="name" name="name[]" value="{{ $item['name'] ?? '' }}">
                                <input type="hidden" id="email" name="email[]" value="{{ $item['email'] ?? '' }}">
                                <input type="hidden" id="first_name" name="first_name[]" value="{{ $item['first_name'] ?? '' }}">
                                <input type="hidden" id="mobile" name="mobile[]" value="{{ $item['mobile'] ?? '' }}">
                            <td>{{ $i++ }}</td>
                            <td>  <input type="hidden" id="admission_id" name="admission_id[]" value="{{ $item['id'] ?? '' }}">
                              
                              <input type="checkbox" class="checkbox checkbox_select" name="studentId[]" data-admission_no="{{ $item['admissionNo'] ?? '' }}" data-student_name='{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}' checked value="{{ $item['id'] ?? '' }}">  {{ $item['admissionNo'] ?? '' }}</td>
                            <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                            <td>{{ $item['ClassTypes']['name'] ?? '' }}
                            @if (!empty($item['Section']['name']))
                                ({{ $item['Section']['name'] }})
                            @endif</td>
                            <td>{{ $item['father_name'] ?? '' }}</td> 
                            <td>{{ $item['mother_name'] ?? '' }}</td>
                            <td style='white-space:nowrap;'>{{ isset($item['dob']) ? \Carbon\Carbon::parse($item['dob'])->format('d-m-Y') : '' }}</td>
                            <td>
                    		<select class="form-control attendance_status_{{ $item['id'] ?? '' }}" id="attendance_status" name="attendance_status[]" 
                    			data-name="{{ $item['first_name'] ?? '' }}"
                    			data-mobile="{{ $item['mobile'] ?? '' }}"
                    			data-email="{{ $item['email'] ?? '' }}"
                    			data-class_type_id = "{{ $item['class_type_id'] ?? '' }}"
                    			data-admission_id="{{ $item['id'] ?? '' }}"
                    		required
                    			>
                    			 
                    			 <option value=''>Select</option>
                                 @if(!empty($getAttendanceStatus)) 
                                 
                                    @foreach($getAttendanceStatus as $attendance_status)
                                    
                                            <option value="{{ $attendance_status->id ?? '' }}"  @if(!empty($stu_att)) {{ $attendance_status->id == $stu_att->attendance_status_id ? 'selected' : '' }} @endif>{{ $attendance_status->name ?? '' }}</option>
                                      
                                    @endforeach
                                @endif

                                </select>                                    
                            </td>                            
                        </tr>
                   @endforeach
                @else
                   <tr>
                  <td colspan="12" class="text-center">No Students Found !</td>
                   </tr>
                @endif
                  
              @endif    
              
         
                 