@php
$getstudents = Helper::getstudents();
$getgenders = Helper::getgender();
$classType = Helper::classType();
$getCountry = Helper::getCountry();
$bloodGroupType = Helper::bloodGroupType();
$list = DB::table('custom_villages_list')->orderBy('name','ASC')->whereNull('deleted_at')->get();
$courses = DB::table('courses')->where('branch_id', Session::get('branch_id'))->get();
$batche_data = DB::table('batches')->get();
@endphp
@extends('layout.app')
@section('content')


<input type="hidden" id="session_id" value="{{ Session::get('role_id') ?? '' }}">
<input type="hidden" id="admission_id" value="{{ $data->id ?? '' }}">
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('messages.Edit Students Admission') }} </h3>
							<div class="card-tools">
								<a href="{{url('admissionView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
								<a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
							</div>

						</div>
						<form id="quickForm" action="{{ url('admissionEdit') }}/{{$data['id']}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row m-4">
								<div class=" col-md-12 title mt-n3">
									<h5 class="text-danger">{{ __('messages.Personal Details') }}:-</h5>
								</div>
								<!-- <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('student.Admission No.') }}</label>
										<input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="Admission No" value="{{$data['admissionNo']}}" onkeypress="javascript:return isNumber(event)">
									     <span class="invalid-feedback" id="admissionNo_invalid" role="alert">
                                                <strong>The Admission No field is required</strong>
                                         </span>
									</div>
								</div> -->
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Course') }}</label>
                                      
                                        <select class="form-control select2" id="course" name="course">
                                            <option value="">{{ __('common.Select') }}</option>
											@if(!empty($courses))
											@foreach($courses as $course)
											<option value="{{ $course->name ?? ''  }}" data-duration="{{ $course->duration ?? 1 }}" data-semester="{{ $course->total_semester ?? 0 }}" data-type="{{ $course->course_type ?? 'Semester' }}" data-orderBy="{{ $course->orderBy ?? ''  }}"  {{ ( $course->name == $data['course'] ? 'selected' : '' ) }} >
                                                {{ $course->name ?? ''  }} ({{ $course->duration ?? 1 }} {{ ($course->duration > 1) ? 'Yrs' : 'Yr' }}{{ ($course->course_type == 'Semester' && $course->total_semester > 0) ? ' / ' . $course->total_semester . ' Sem' : '' }})
                                            </option>
											@endforeach
											@endif
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Student Type') }}</label>
                                        <select class="form-control  select2" id="student_type" name="student_type">
                                            <option value="">{{ __('common.Select') }}</option>
                                            <option value="NRI" {{ $data['student_type'] == 'NRI' ? 'selected' : '' }}>NRI</option>
                                            <option value="Management" {{ $data['student_type'] == 'Management' ? 'selected' : '' }}>Management</option>
                                            <option value="Govt" {{ $data['student_type'] == 'Govt' ? 'selected' : '' }}>Govt.</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Batch') }}</label>
                                        <input type="text" class="form-control" id="batch" name="batch" placeholder="Auto-calculated (e.g. 2026-29)" value="{{ $data['batch'] ?? '' }}" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                                    </div>
                                </div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Class / Semester') }}<span style="color:red;">*</span></label>

										<select class="form-control invalid" id="class_type_id" name="class_type_id">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($classType))
											@foreach($classType as $type)
											<option value="{{ $type->id ?? ''  }}" data-orderBy="{{ $type->orderBy ?? ''  }}"  {{ ( $type->id == $data['class_type_id'] ? 'selected' : '' ) }} >{{ $type->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
										<span class="invalid-feedback" id="class_type_id_invalid" role="alert">
                                            <strong>The Class / Semester field is required</strong>
                                        </span>
									</div>
								</div>

                                @php
								    $streamSubjects = Helper::getStreamSubjects($data->class_type_id ?? '');
								@endphp
								
								<div class="col-md-3" id="stream_subject_div" style="display:{{ $data['stream_subject'] != "" ? 'block' : 'none' }}">
									<div class="form-group">
										<label>Stream Subject<span style="color:red;">*</span></label>

										<select class="form-control select2" multiple id="stream_subject" name="stream_subject[]">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($streamSubjects))
                                                @foreach($streamSubjects as $subject)
                                                    <option value="{{ $subject->id ?? '' }}" {{ in_array($subject->id, explode(',', $data->stream_subject)) ? 'selected' : ''  }}>{{ $subject->name ?? '' }}</option>
                                                @endforeach
                                            @endif
										</select>
									</div>
								</div>
                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Roll No') }}<span style=""></span></label>
										<input type="text" class="form-control " name="roll_no" placeholder="{{ __('Roll No') }}"  value="{{$data['roll_no']}}">
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Student Name') }}<span style="color:red;">*</span></label>
										<input type="text" name="first_name" id="first_name" class="form-control invalid" value="{{ $data['first_name'] ?? '' }}" placeholder="{{ __('Student Name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
										<span class="invalid-feedback" id="first_name_invalid" role="alert">
                                            <strong>The First Name field is required</strong>
                                        </span>
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Fathers Name') }}<span style="color:red;">*</span></label>
										<input type="text" class="form-control invalid" id="father_name" name="father_name" placeholder="{{ __('common.Fathers Name') }}" value="{{ $data['father_name'] ?? ''}}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
										<span class="invalid-feedback" id="father_name_invalid" role="alert">
                                            <strong>The Father's name field is required</strong>
                                        </span>
										</select>
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('student.Date Of Admission') }}</label>
										<input type="date" class="form-control" id="admission_date" name="admission_date" value="{{ $data['admission_date'] == '1970-01-01' ? '' : $data['admission_date'] ?? ''}}">
									
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Mothers Name') }}</label>
										<input type="text" class="form-control " id="mother_name" name="mother_name" placeholder="{{ __('common.Mothers Name') }}" value="{{ $data['mother_name'] ?? ''}}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
									
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Date Of  Birth') }}<span style="color:red;">*</span></label>
										<input type="date" class="form-control invalid" id="dob" name="dob" placeholder=" Date Of  Birth" value="{{$data['dob'] ?? ''}}">
										<span class="invalid-feedback" id="dob_invalid" role="alert">
                                            <strong>The dob field is required</strong>
                                        </span>
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Gender') }}<span style="color:red;">*</span></label>
										<select class="form-control invalid" id="gender_id" name="gender_id">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getgenders))
											@foreach($getgenders as $value)
											<option value="{{ $value->id}}" {{ ( $value->id == $data['gender_id'] ? 'selected' : '' ) }}>{{ $value->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
										<span class="invalid-feedback" id="gender_id_invalid" role="alert">
                                            <strong>The gender field is required</strong>
                                        </span>
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Blood Group') }}</label>
										<select class="form-control" id="blood_group" name="blood_group">
											<option value="">{{ __('common.Select') }}</option>
        										@if(!empty($bloodGroupType))
        											@foreach($bloodGroupType as $bloodtype)
        											<option value="{{ $bloodtype->name ?? ''  }}" {{ ( $bloodtype->name == $data['blood_group'] ? 'selected' : '' ) }}>{{ $bloodtype->name ?? ''  }}</option>
        											@endforeach
        										@endif
										</select>
									
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Mobile No.') }}</label>
										<!--<input type="text" class="form-control " id="mobile" name="mobile" placeholder="{{ __('common.Mobile No.') }}" value="{{ $data['mobile'] ?? ''}}"minlength="10" maxlength="10" onkeypress="javascript:return isNumber(event)">-->
						                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{ __('common.Mobile No.') }}" value="{{ $data['mobile'] ?? '' }}" maxlength="10">
                                            <div id="mobileValidationMessage" style="color: red; display: none; font-size:13px;">must be at least 10 characters</div>

									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Category') }}</label>
										<select class="form-control" id="category" name="category">
											<option value="">{{ __('common.Select') }}</option>
											<option value="OBC" {{ ('OBC' == $data['category'] ? 'selected' : '' ) }}>OBC</option>
											<option value="ST" {{ ('ST' == $data['category'] ? 'selected' : '' ) }}>ST</option>
											<option value="SC" {{ ('SC' == $data['category'] ? 'selected' : '' ) }}>SC</option>
											<option value="BC" {{ ('BC' == $data['category'] ? 'selected' : '' ) }}>BC</option>
											<option value="GEN" {{ ('GEN' == $data['category'] ? 'selected' : '' ) }}>GEN</option>
											<option value="SBC" {{ ('SBC' == $data['category'] ? 'selected' : '' ) }}>SBC</option>
											<option value="Other" {{ ('Other' == $data['category'] ? 'selected' : '' ) }}>Other</option>
										</select>
										
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.E-Mail') }}</label>
										<input type="email" class="form-control " id="email" name="email" placeholder="{{ __('common.E-Mail') }}" value="{{ $data['email'] ?? '' }}">
							          
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Aadhaar No.') }}</label>
										<input type="text" class="form-control" id="aadhaar" name="aadhaar" placeholder=" {{ __('common.Aadhaar No.') }}" value="{{ $data['aadhaar'] ?? '' }}" maxlength="12" onkeypress="javascript:return isNumber(event)">
									
									</div>
								</div>

                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Religion') }}</label>
										<select class="form-control" id="religion" name="religion">
											<option value="">{{ __('common.Select') }}</option>
											<option value="Hindu" {{ ('Hindu' == $data['religion'] ? 'selected' : '' ) }}>Hindu</option>
											<option value="Islam" {{ ('Islam' == $data['religion'] ? 'selected' : '' ) }}>Islam</option>
											<option value="Sikh" {{ ('Sikh' == $data['religion'] ? 'selected' : '' ) }}>Sikh</option>
											<option value="Buddhism" {{ ('Buddhism' == $data['religion'] ? 'selected' : '' ) }}>Buddhism</option>
											<option value="Adivasi" {{ ('Adivasi' == $data['religion'] ? 'selected' : '' ) }}>Adivasi</option>
											<option value="Jain" {{ ('Jain' == $data['religion'] ? 'selected' : '' ) }}>Jain</option>
											<option value="Christianity" {{ ('Christianity' == $data['religion'] ? 'selected' : '' ) }}>Christianity</option>
											<option value="Other" {{ ('Other' == $data['religion'] ? 'selected' : '' ) }}>Other</option>
										</select>
										
									</div>
								</div>
                                
                                <div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Ledger No') }}<span style=""></span></label>
										<input type="text" class="form-control " name="ledger_no" placeholder="{{ __('Ledger No') }}"  value="{{$data['ledger_no']}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('SRN') }}</label>
										<input type="text" class="form-control" id="srn" name="srn" value="{{ $data['srn'] ?? '' }}" placeholder="{{ __('SRN') }}" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Family ID') }}</label>
										<input type="text" class="form-control" id="family_id" name="family_id" value="{{ $data['family_id'] ?? '' }}" placeholder="{{ __('Family ID') }}" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
								
								<!--<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Last Name') }}</label>
										<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $data['last_name'] ?? '' }}" placeholder="{{ __('common.Last Name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
									</div>
								</div>-->
							
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Jan Aadhaar No.') }}</label>
										<input type="text" class="form-control" id="jan_aadhaar" name="jan_aadhaar" placeholder=" {{ __('Jan Aadhaar No.') }}" value="{{ $data['jan_aadhaar'] ?? '' }}" maxlength="10" onkeypress="javascript:return isNumber(event)">
									
									</div>
								</div>
								
								
								
							
								


								
								
								
								
								<!--<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Is RTE Student') }}</label>
										<select class="form-control" id="rte_student" name="rte_student">
										
											<option value="Yes" {{ ('Yes' == $data['rte_student'] ? 'selected' : '' ) }}>Yes</option>
											<option value="No" {{ ('No' == $data['rte_student'] ? 'selected' : '' ) }}>No</option>
										</select>
										
									</div>
								</div>-->
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Admission Type(Non RTE)</label>
										<select class="form-control" id="admission_type_id" name="admission_type_id">
											<!--<option value="">{{ __('common.Select') }}</option>-->
											<option value="1" {{ (1 == $data['admission_type_id'] ? 'selected' : '' ) }}>Yes</option>
											<option value="2" {{ (2 == $data['admission_type_id'] ? 'selected' : '' ) }}>No</option>
										</select>
										
									</div>
								</div>
									
								
								<!--<div class="col-md-3">
								    <div class="form-group">
								        <label>Nationalty</label>
								        	<select class="form-control" id="nationalty" name="nationalty">
											<option value="">{{ __('common.Select') }}</option>
											<option value="OBC" {{ ('OBC' == $data['nationalty'] ? 'selected' : '' ) }}>OBC</option>
											<option value="ST" {{ ('ST' == $data['nationalty'] ? 'selected' : '' ) }}>ST</option>
											<option value="SC" {{ ('SC' == $data['nationalty'] ? 'selected' : '' ) }}>SC</option>
											<option value="BC" {{ ('BC' == $data['nationalty'] ? 'selected' : '' ) }}>BC</option>
											<option value="GEN" {{ ('GEN' == $data['nationalty'] ? 'selected' : '' ) }}>GEN</option>
											<option value="SBC" {{ ('SBC' == $data['nationalty'] ? 'selected' : '' ) }}>SBC</option>
											<option value="Other" {{ ('Other' == $data['nationalty'] ? 'selected' : '' ) }}>Other</option>
										</select>
								    </div>
								</div>-->
									<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Caste') }}</label>
										<input type="text" class="form-control" id="caste_category" name="caste_category" placeholder="{{ __('Caste') }}" value="{{ $data['caste_category'] ?? ''}}" >
									
									</div>
								</div>
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Medium</label>
										<select class="form-control" id="medium" name="medium">
											<option value="">Select</option>
											<option value="Hindi" {{ ('Hindi' == $data['medium'] ? 'selected' : '' ) }}>Hindi</option>
											<option value="English" {{ ('English' == $data['medium'] ? 'selected' : '' ) }}>English</option>
										</select>
									</div>
								</div>
                               
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Country') }}</label>
										<select class="form-control" name="country" id="country_id">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getCountry))
											@foreach($getCountry as $country)
											<option value="{{ $country->id ?? ''  }}" {{ ( $country->id == $data['country_id'] ? 'selected' : '' ) }} >{{ $country->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="State" class="required">{{ __('common.State') }}</label>
										<select class="form-control stateId " id="state_id" name="state">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getState))
											@foreach($getState as $state)
											<option value="{{ $state->id ?? ''}}" {{ ( $state->id == $data['state_id'] ? 'selected' : '' ) }} >{{ $state->name ?? ''}}</option>
											@endforeach
											@endif
										</select>

									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="City">{{ __('common.City') }}</label>
										<select class="form-control cityId " name="city" id="city_id">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getCity))
											@foreach($getCity as $cities)
											<option value="{{ $cities->id ?? ''  }}" {{ ( $cities->id == $data['city_id'] ? 'selected' : '' ) }} >{{ $cities->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
									</div>
								</div>
								<!--	<div class="col-md-3">-->
								<!--	<div class="form-group">-->
								<!--		<label>{{ __('student.Village/City') }}</label>-->
								<!--		<select class="form-control select2 " id="village_city" name="village_city">-->
								<!--			<option value="">{{ __('common.Select') }}</option>-->
								<!--			@if(!empty($list))-->
								<!--			@foreach($list as $type)-->
								<!--			<option value="{{ $type->name ?? ''  }}" {{ ( $type->name == $data['village_city'] ? 'selected' : '' ) }}>{{ $type->name ?? ''  }}</option>-->
								<!--			@endforeach-->
								<!--			@endif-->
								<!--		</select>-->
								<!--	</div>-->
								<!--</div>-->
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('messages.Village/City') }}</label>
										<input type="text" class="form-control" id="village_city" name="village_city" placeholder="{{ __('messages.Village/City') }}" value="{{ $data['village_city'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('student.Students Address') }}</label>
										<input type="text" class="form-control " id="address" name="address" placeholder="{{ __('student.Students Address') }}" value="{{ $data['address'] ?? ''}}">
										
									</div>
								</div>
									<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Family Annual Income') }}</label>
										<input type="text" name="family_annual_income" id="family_annual_income" class="form-control" value="{{ $data['family_annual_income'] ?? ''}}" placeholder="{{ __('Family Annual Income') }}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Relation With The Student') }}</label>
										<input type="text" name="relation_student" id="relation_student" class="form-control" value="{{ $data['relation_student'] ?? ''}}" placeholder="{{ __('Relation With The Student') }}">
										
									</div>
								</div>
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('School Studied Last Year') }}</label>
										<input type="text" name="school_namestudied_last_year" id="school_namestudied_last_year" class="form-control" value="{{ $data['school_namestudied_last_year'] ?? ''}}" placeholder="{{ __('School Studied Last Year') }}">
										
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('House') }}</label>
										<input type="text" name="house" id="house" class="form-control" value="{{ $data['house'] ?? ''}}" placeholder="{{ __('House') }}">
										
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Height') }}</label>
										<input type="text" name="height" id="height" class="form-control" value="{{ $data['height'] ?? ''}}" placeholder="{{ __('Height') }}">
										
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Weight') }}</label>
										<input type="txt" name="weight" id="weight" class="form-control" value="{{ $data['weight'] ?? ''}}" placeholder="{{ __('Weight') }}">
										
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('messages.Pin Code') }}</label>
										<input type="text" class="form-control" id="pincode" name="pincode" placeholder="{{ __('messages.Pin Code') }}" value="{{ $data['pincode'] ?? ''}}" maxlength="6" onkeypress="javascript:return isNumber(event)">
										
									</div>
								</div>
                                
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('student.Remark') }} </label>
										<input type="text" class="form-control" id="remark_1" name="remark_1" placeholder="{{ __('student.Remark') }} " value="{{ $data['remark_1'] ?? ''}}">
									</div>
								</div>
                               
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('common.Fathers Contact No') }}</label>
										<input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder="{{ __('common.Fathers Contact No') }}" value="{{ $data['father_mobile'] ?? ''}}" maxlength="10" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
                               
                                <div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Transport') }}</label>
										<select class="form-control select2" id="transport" name="transport">
											<option value="Yes" {{ ('Yes' == $data->transport) ? 'selected' : '' }}>{{ __('Yes') }}</option>
											<option value="No" {{ ('No' == $data->transport) ? 'selected' : '' }}>{{ __('No') }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Bus Number') }} </label>
										<input type="text" class="form-control" id="bus_number" name="bus_number" placeholder="{{ __('Bus Number') }} " value="{{ $data['bus_number'] ?? ''}} ">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Bus Route') }} </label>
										<input type="text" class="form-control" id="bus_route" name="bus_route" placeholder="{{ __('Bus Route') }} " value="{{$data['bus_route'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Stoppage') }} </label>
										<input type="text" class="form-control" id="stoppage" name="stoppage" placeholder="{{ __('Stoppage') }} " value="{{$data['stoppage'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{ __('Transport Charges') }} </label>
										<input type="text" class="form-control" id="transpor_charges" name="transpor_charges" placeholder="{{ __('Transport Charges') }} " value="{{$data['transpor_charges'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Bank Name') }} </label>
										<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="{{ __('Bank Name') }} " value="{{$data['bank_name'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Bank Account') }} </label>
										<input type="text" class="form-control" id="bank_account" name="bank_account" placeholder="{{ __('Bank Account') }} " value="{{$data['bank_account'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Branch Name') }} </label>
										<input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="{{ __('Branch Name') }} " value="{{$data['branch_name'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('IFSC') }} </label>
										<input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="{{ __('IFSC') }} " value="{{$data['ifsc'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __(' MICR Code') }} </label>
										<input type="text" class="form-control" id="micr_code" name="micr_code" placeholder="{{ __('MICR Code') }} " value="{{$data['micr_code'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Bank Account Holder</label>
										<input type="text" class="form-control" id="bank_account_holder" name="bank_account_holder" placeholder="Bank Account Holder" value="{{ $data['bank_account_holder'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Optional Subject</label>
										<input type="text" class="form-control" id="optional_subject" name="optional_subject" placeholder="Optional Subject" value="{{ $data['optional_subject'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Urban/Ruler</label>
										<input type="text" class="form-control" id="urban" name="urban" placeholder="Urban/Ruler" value="{{ $data['urban'] ?? '' }}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>District</label>
										<input type="text" class="form-control" id="district" name="district" placeholder="District" value="{{ $data['district'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Tehsil</label>
										<input type="text" class="form-control" id="tehsil" name="tehsil" placeholder="Tehsil" value="{{$data['tehsil'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Father's Pancard</label>
										<input type="text" class="form-control" id="father_pancard" name="father_pancard" placeholder="Father's Pancard" value="{{ $data['father_pancard'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Mother's Pancard</label>
										<input type="text" class="form-control" id="mother_pancard" name="mother_pancard" placeholder="Mother's Pancard" value="{{ $data['mother_pancard'] ?? ''}}">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Income Tax Payee Father</label>
										<select class="form-control" id="income_tax_payee_father" name="income_tax_payee_father">
										    <option value="">Select</option>
										    <option value="Yes" {{ "Yes" == $data['income_tax_payee_father'] ? 'selected' : '' }}>Yes</option>
										    <option value="No" {{ "No" == $data['income_tax_payee_father'] ? 'selected' : '' }}>No</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Income Tax Payee Mother</label>
										<select class="form-control" id="income_tax_payee_mother" name="income_tax_payee_mother">
										    <option value="">Select</option>
										    <option value="Yes" {{ "Yes" == $data['income_tax_payee_mother'] ? 'selected' : '' }}>Yes</option>
										    <option value="No" {{ "No" == $data['income_tax_payee_mother'] ? 'selected' : '' }}>No</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>BPL</label>
										<select class="form-control" id="bpl" name="bpl">
										    <option value="">Select</option>
										    <option value="Yes" {{ "Yes" == $data['bpl'] ? 'selected' : '' }}>Yes</option>
										    <option value="No" {{ "No" == $data['bpl'] ? 'selected' : '' }}>No</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>BPL Cetificate No.</label>
										<input type="text" class="form-control" id="bpl_certificate_no" name="bpl_certificate_no" placeholder="BPL Cetificate No." value="{{ $data['bpl_certificate_no'] ?? ''}}">
									</div>
								</div>
							<div class="col-md-4 d-none">
									<div class="form-group">
										<label>Name  And  Address Of Previous School</label>
										<input type="text" class="form-control" id="previous_school" name="previous_school" placeholder="Name  And  Address Of Previous School" value="{{ $data['previous_school'] ?? ''}}">
									</div>
								</div>
								
							</div>
							
							
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Fathers Aadhaar') }}</label>
										<input type="text" class="form-control" id="father_aadhaar" name="father_aadhaar" placeholder="{{ __('Fathers Aadhaar') }}" value="{{$data['father_aadhaar'] ?? ''}}" maxlength="12" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>Father Occupation</label>
										<input type="text" class="form-control" id="father_occupation" name="father_occupation" placeholder="Father Occupation" value="{{old('father_occupation')}}">
									</div>
								</div>
                                
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Mother Mobile No') }}</label>
										<input type="text" class="form-control" id="mother_mob" name="mother_mob" placeholder="{{ __('Mother Mobile No') }}" value="{{$data['mother_mob'] ?? ''}}" maxlength="10" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Mothers Aadhaar') }}</label>
										<input type="text" class="form-control" id="mother_aadhaar" name="mother_aadhaar" placeholder="{{ __('Mothers Aadhaar') }}" value="{{$data['mother_aadhaar'] ?? ''}}" maxlength="12" onkeypress="javascript:return isNumber(event)">
									</div>
								</div>
								
                                <div class="col-md-3 d-none">
									<div class="form-group">
										<label>Mother Occupation</label>
										<input type="text" class="form-control" id="mother_occupation" name="mother_occupation" placeholder="Mother Occupation" value="{{$data['mother_occupation'] ?? ''}}">
									</div>
								</div>
								
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Guardian Name') }}</label>
										<input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="{{ __('Guardian Name') }}" value="{{$data['guardian_name'] ?? ''}}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
									
									</div>
								</div>
								<div class="col-md-3 d-none">
									<div class="form-group">
										<label>{{ __('Guardian Mobile No') }}</label>
										<input type="text" class="form-control " id="guardian_mobile" name="guardian_mobile" placeholder="{{ __('Guardian Mobile No') }}" value="{{$data['guardian_mobile'] ?? ''}}" maxlength="10" onkeypress="javascript:return isNumber(event)">
								
									</div>
								</div>
							
								
							</div>
						
							<div class="row m-2 d-none">
								<div class=" col-md-12 title">
									<h5 class="text-danger">{{ __('messages.Document Upload') }}:-</h5>
								</div>
								<div class="col-md-3">
									<lable>{{ __('student.Student Photo') }}</lable>
									<div class="input file form-control">
										<input type="file" class="" name="student_img" id="student_img" value="{{ $data['image'] ?? '' }}"  accept="image/png, image/jpg, image/jpeg">
                                   
								    </div>
								</div>

								<div class="col-md-1">
									<img src="{{ env('IMAGE_SHOW_PATH').'profile/'.$data['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" width="60px" height="60px">
								</div>
								<div class="col-md-3">
									<lable><b>{{ __('messages.Father Photo') }}</b></lable>
									<div class="input file form-control @error('father_img') is-invalid @enderror">
										<input type="file" name="father_img" id="father_img" value="{{ $data['father_img'] ?? '' }}" accept="image/png, image/jpg, image/jpeg">
										 <p class="text-danger" id="image_errors"></p>
										@error('father_img')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-1">
									<img src="{{ env('IMAGE_SHOW_PATH').'father_image/'.$data['father_img'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" width="60px" height="60px">
								</div>
								<div class="col-md-3">
									<lable><b>{{ __('messages.Mother Photo') }}</b></lable>
									<div class="input file form-control @error('mother_img') is-invalid @enderror">
										<input type="file" name="mother_img" id="mother_img" value="{{ $data['mother_img'] ?? '' }}" accept="image/png, image/jpg, image/jpeg">
										 <p class="text-danger" id="image_er"></p>
										@error('mother_img')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-1">
									<img src="{{ env('IMAGE_SHOW_PATH').'mother_image/'.$data['mother_img'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" width="60px" height="60px">
								</div>
							</div>
							<hr>
							
							<div class="mesterClassAmt" class="row m-2"></div>
							<div class="col-md-12 text-center ">
							    <div >
								<button type="submit" class="btn btn-info" name='update'  value="update_n_next" >{{ __('Update & Next') }}</button>
								<button type="submit" class="btn btn-primary"   id="is-invalid" >{{ __('messages.Update') }}</button><br><br>
							</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handler for form submission
    $('form').on('submit', function(event) {
        // Perform mobile input validation
       /* var mobileValue = $('#mobile1').val();
        var mobileMinLength = 10;

        if (mobileValue.length < mobileMinLength) {
            $('#mobileValidationMessage').show();
            event.preventDefault();  
            $('html, body').animate({
            scrollTop: 0
        }, 800);
        } else {
            $('#mobileValidationMessage').hide();
        }*/

        // Perform father's mobile input validation
        // var father_mobileInputValue = $('#father_mobile').val();
        // var fatherMobileMinLength = 10;

        // if (father_mobileInputValue.length < fatherMobileMinLength) {
        //     $('#fathermobileValidationMessage').show();
        //     event.preventDefault(); 
        //     $('html, body').animate({
        //     scrollTop: 0
        // }, 800);
        // } else {
        //     $('#fathermobileValidationMessage').hide();
        // }
    });
});
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        
      
        $('#student_img').change(function(e){
            $('#image_error').html("");
            var fileName = $(this).val();
        var extension = fileName.split(".").pop();
        if (
          extension.toLowerCase() === "png" ||
          extension.toLowerCase() === "jpg" ||
          extension.toLowerCase() === "jpeg"
        ) {
            if (e.target.files[0].size > Img_Size) {
                $('#image_error').html("please select Image Size under 2MB");
                $(this).val('');
            }else{
                $('#image_error').html("");
            }
        }else{
            $('#image_error').html("Image Size File");
            $(this).val('');
        }
        });
    });

    $(document).ready(function(){
        $('#father_img').change(function(e){
            $('#image_errors').html("");
            var fileName = $(this).val();
        var extension = fileName.split(".").pop();
        if (
          extension.toLowerCase() === "png" ||
          extension.toLowerCase() === "jpg" ||
          extension.toLowerCase() === "jpeg"
        ) {
            if (e.target.files[0].size > Img_Size) {
                $('#image_errors').html("please select Image Size under 2MB");
                $(this).val('');
            }else{
                $('#image_errors').html("");
            }
        }else{
            $('#image_errors').html("Image Size File");
            $(this).val('');
        }
        });
    });


    $(document).ready(function(){
        $('#mother_img').change(function(e){
            $('#image_er').html("");
            var fileName = $(this).val();
        var extension = fileName.split(".").pop();
        if (
          extension.toLowerCase() === "png" ||
          extension.toLowerCase() === "jpg" ||
          extension.toLowerCase() === "jpeg"
        ) {
            if (e.target.files[0].size > Img_Size) {
                $('#image_er').html("please select Image Size under 2MB");
                $(this).val('');
            }else{
                $('#image_er').html("");
            }
        }else{
            $('#image_er').html("Image Size File");
            $(this).val('');
        }
        });
    });
   
</script>
<style>
    #image_error{
        font-weight: bold;
    font-size: 14px;
    }
    #image_er{
        font-weight: bold;
    font-size: 14px;
    }
    #image_errors{
        font-weight: bold;
    font-size: 14px;
    }
</style>


<script>
      $(document).ready(function(){
        var baseUrl = "{{ url('/') }}";
        $('#stream_subject_div').hide();
        var orderBy = parseInt($('#class_type_id').find('option:selected').attr('data-orderBy'));
        
        if(orderBy > 10){
            $('#stream_subject_div').show();
        }
        
        $('#class_type_id').change(function(){
            var class_type_id = parseInt($(this).val());
            var orderBy = parseInt($(this).find('option:selected').attr('data-orderBy'));
            
            if(orderBy > 10){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: baseUrl + '/getStreamSubjects',
                    data: {
                        class_type_id: class_type_id
                    },
                    success: function(data) {
                        var options = "";
                        $('#stream_subject').html("");
                            for(var i = 0; i < data.length; i++){
                                options += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>';
                            }
                        $('#stream_subject').html(options);
                        $('#stream_subject_div').show();
                    }
                });
            }else{
                $('#stream_subject').html("");
                $('#stream_subject_div').hide();
            }
        });
    });

</script>

<script>

$(document).ready(function(){
 //   $('#class_type_id').val('');
    
    if($('#admission_type_id').val() == 1){
            $('.mesterClassAmt').removeClass('d-none');
            //mesterData();
        }else{
            $('.mesterClassAmt').addClass('d-none');
        }
    $('#class_type_id').change(function(){
        if($('#admission_type_id').val() == 1){
            $('.mesterClassAmt').removeClass('d-none');
            //mesterData();
        }else{
            $('.mesterClassAmt').addClass('d-none');
        }
    });
    
    $('#admission_type_id').change(function(){
      //      $('#class_type_id').val('');
      
            if($('#admission_type_id').val() == 1){
            $('.mesterClassAmt').removeClass('d-none');
            //mesterData();
        }else{
            $('.mesterClassAmt').addClass('d-none');
        }veClass('d-none');
            //mesterData();
    });
    
})
$(document).ready(function(){

    $('.feesAssignCheckbox').click(function(){
        assignCheck()
    })
    $('.discount,#great_discount').keyup(function(){
        assignCheck()
    })
    
    function assignCheck(){
        
        var thisamt = thisdisct = thisid = netamt = totalamt = totaldisct = payamt = greatdisct = finaldisct = 0;
        $('.feesAssignCheckbox').each(function(){
            
            if($(this).is(':checked')){

                thisid = $(this).data('id');
                thisamt = parseFloat($('#amount_' + thisid).val());
                thisdisct = parseFloat($('#discount_' + thisid).val());
                greatdisct = parseFloat($('#great_discount').val());
                
                if(isNaN(thisdisct)){thisdisct = 0;}
                if(isNaN(greatdisct)){greatdisct = 0;}
                totalamt = totalamt + thisamt;
                totaldisct = totaldisct + thisdisct;
                
                //toastr.warning(greatdisct);
                //toastr.info(thisdisct);
            }
        })  
                
        payamt = totalamt - totaldisct;
        $('#total_amount').val(totalamt);
        $('#net_discount').val(totaldisct);
        $('#pay_amt').val(payamt);

        if(greatdisct > 0){

            finaldisct = totaldisct + greatdisct;
            payamt = totalamt - finaldisct;
            $('#net_discount').val(finaldisct);
            $('#pay_amt').val(payamt);
        }
        
        if(totalamt > 0){
            if(totaldisct >= totalamt || finaldisct >= totalamt){
                toastr.error('Total discount should be lessthan Net amount');
            }
        }
    }
    
})

// $(document).ready(function(){

//     $('#class_type_id').change(function(){
//         mesterData();
//     });
    
//     mesterData();
// })
// 	var basurl = "{{ url('/') }}";
// 	function mesterData() {
	
// 		var class_type_id = $('#class_type_id :selected').val();

// 		var admission_id = $('#admission_id').val();
// 		if (class_type_id > 0) {
// 			$.ajax({
// 				headers: {
// 					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
// 				},
// 				type: 'post',
// 				url: basurl + '/mesterClassAmt',
// 				data: {
// 					class_type_id: class_type_id, admission_id:admission_id
// 				},
// 				//dataType: 'json',
// 				success: function(data) {
//                 if(data != ""){
//                      $('.mesterClassAmt').show();
//                     	$('.mesterClassAmt').html(data);

//             	    //var array = [];
//             	        /*$.each( feesAssign, function(index,value){
//             	            alert("ok");
//             	        })*/
//                     	//alert(JSON.stringify(feesAssign));

//                 }else{
//                                 $('.mesterClassAmt').hide();
//                               // $('#class_type_id').val("");
//                     			//alert('please assign master fees *!');
                    			
//                 }

// 				}
// 			});
// 		} else {
// 			toastr.error('Please put a value in one column !');
// 		}
// 	};
</script>
<script>
	$(document).ready(function() {
		var session_id = $('#session_id').val();
		if (session_id != 1) {
			$("#aadhaar").attr('readonly', 'true');
		}
	});
</script>

<script>
	$(function() {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})

	})
	
	
$('#is-invalid').click(function(e){
    e.preventDefault();
    var all_filled_up = 2000;
    $('.invalid').each(function(){
        var this_type = $(this).attr('type');
        if(this_type == "file"){
          var this_value = $(this).prop("files")[0];
        }else{
          var this_value = $(this).val();
        }
        var this_id = $(this).attr('id');
        if(this_value == ''){
            $('#' + this_id + '_invalid').css('display','block');
            all_filled_up = all_filled_up + ' && ' + this_value;
        }else{
            $('#' + this_id + '_invalid').css('display','none');
        }
    })
    if(all_filled_up == 2000){
        var total_amt = $('#total_amount').val();
        if(total_amt == ""){
                 if($('#admission_type_id').val() == 1){
                toastr.error('First Assign Fees');
            }else{
                $('#quickForm').trigger('submit');
            }
        }else{
        $('#quickForm').trigger('submit');
        }
    }else{
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
})

    function calculateBatch() {
        var selectedOption = $('#course').find(':selected');
        var duration = parseInt(selectedOption.data('duration')) || 0;
        if (duration > 0) {
            var currentYear = new Date().getFullYear();
            var endYear = currentYear + duration;
            var endYearShort = String(endYear).slice(-2);
            $('#batch').val(currentYear + '-' + endYearShort);
        }
    }

    // Dynamic Course-dependent Classes / Semesters loader
    $('#course').on('change', function() {
        var courseName = $(this).val();
        var classSelect = $('#class_type_id');
        
        calculateBatch();

        if (courseName) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course: courseName },
                dataType: "json",
                success: function(data) {
                    var currentSelected = classSelect.val();
                    classSelect.empty();
                    classSelect.append('<option value="">{{ __("common.Select") }}</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(key, val) {
                            var isSelected = (val.id == currentSelected) ? ' selected' : '';
                            classSelect.append('<option value="' + val.id + '" data-orderby="' + (val.orderBy || '') + '"' + isSelected + '>' + val.name + '</option>');
                        });
                    }
                    if (classSelect.hasClass('select2')) {
                        classSelect.trigger('change.select2');
                    }
                }
            });
        }
    });
</script>
@endsection
