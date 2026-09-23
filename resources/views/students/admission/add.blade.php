@php
$getstudents = Helper::getstudents();
$getgenders = Helper::getgender();
$classType = Helper::classType();
$getState = Helper::getState();
$getCity = Helper::getCity();
$getCountry = Helper::getCountry();
$getSetting = Helper::getSetting();
$bloodGroupType = Helper::bloodGroupType();
$getAdmissionDatatableFields = Helper::getAdmissionDatatableFields();
$list = DB::table('custom_villages_list')->orderBy('name','ASC')->whereNull('deleted_at')->get();
$gender = DB::table('gender')->whereNull('deleted_at')->pluck('name')->implode(',');
$villageList = DB::table('custom_villages_list')->whereNull('deleted_at')->pluck('name')->implode(',');
$class = DB::table('class_types')->whereNull('deleted_at')->pluck('name')->implode(',');
$setting = Db::table('settings')->whereNull('deleted_at')->first();
$stateList = DB::table('states')->where('id', 13)->pluck('name')->implode(',');
$cityList = DB::table('citys')->whereNull('deleted_at')->where('state_id', 13)->take(25)->pluck('name')->implode(',');
$bloodgroupList = DB::table('blood_groups')->whereNull('deleted_at')->pluck('name')->implode(',');
$courses = DB::table('courses')->where('branch_id', Session::get('branch_id'))->get();
$batches = DB::table('batches')->get();
$session = DB::table('sessions')->whereNull('deleted_at')->where('id', Session::get('session_id') ?? '')->first();

@endphp
@extends('layout.app')
@section('content')

@php
    $studentCount = DB::table('admissions')->where('deleted_at',null)->count();
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
							<h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;{{ __('student.Students Admission Management') }}</h3>
							<div class="card-tools">
								<a href="{{url('admissionView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> <span class="Display_none_mobile"> {{ __('common.View') }} </span></a>
								<a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile"> {{ __('common.Back') }} </span></a>
							</div>

						</div>
						              
						<!--<form id="quickForm" action="{{url('admissionStudentSearch')}}" method="post">-->
						<!--	@csrf-->

						<!--	<div class="row m-2">-->
						<!--		<div class=" col-md-12 title">-->
						<!--			<h5>{{ __('student.Search Registered Students') }}:-</h5>-->
						<!--		</div>-->
						<!--		<div class="col-md-3">-->
						<!--			<div class="form-group">-->
						<!--				<label>{{ __('student.Registration No') }}</label>-->
						<!--				<input type="text" class="form-control"  id="registration_no"name="registration_no" placeholder="{{ __('student.Registration No') }}" value="{{ $search['registration_no'] ?? '' }}">-->
						<!--			</div>-->
						<!--		</div>-->
						<!--		<div class="col-md-3">-->
						<!--			<div class="form-group">-->
						<!--				<label class='text-danger'>{{ __('common.Class') }}*</label>-->
						<!--				<select class="form-control select2 " id="class_search_id" name="class_search_id" required>-->
						<!--					<option value="">{{ __('common.Select') }}</option>-->
						<!--					@if(!empty($classType))-->
						<!--					@foreach($classType as $type)-->
						<!--					<option value="{{ $type->id ?? ''  }}">{{ $type->name ?? ''  }}</option>-->
						<!--					@endforeach-->
						<!--					@endif-->
						<!--				</select>-->
						<!--			</div>-->
						<!--		</div>-->
								
						<!--		<div class="col-md-5">-->
						<!--			<div class="form-group">-->
						<!--				<label>{{ __('common.Search By Keywords') }}</label>-->
						<!--				<input type="text" class="form-control" id="searchName" name="name" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}">-->
						<!--			</div>-->
						<!--		</div>-->
						<!--		<div class="col-md-1 ">-->
						<!--			<div class="form-group">-->
						<!--				<label class="text-white">{{__('common.Search') }}</label>-->
						<!--				<button type="button" class="btn btn-primary" onclick="SearchValue()">{{ __('common.Search') }}</button>-->
						<!--			</div>-->
						<!--		</div>-->

						<!--	</div>-->
						<!--</form>-->

						<!--<div class="student_list_show"></div>-->
                        <hr>
						<form id="quickForm_addmission" action="{{ url('admissionAdd') }}" method="post" enctype="multipart/form-data">
							@csrf

							<input type="hidden" id="admissionNo" name="admissionNo" value="{{$BillCounter ?? ''}}">

							<!-- 1. ACADEMIC DETAILS SECTION -->
							<div class="card card-outline card-primary mb-3 shadow-sm">
								<div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
									<h6 class="card-title text-primary font-weight-bold mb-0">
										<i class="fa fa-graduation-cap mr-1"></i> {{ __('student.Academic Details') ?? 'Academic Information' }}
									</h6>
									<span class="badge badge-info py-1 px-2">
										Last Student ID: {{$BillCounter - 1 ?? ''}}
									</span>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Course') }} <span class="text-danger">*</span></label>
												<select class="form-control invalid select2" id="course" name="course">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($courses))
														@foreach($courses as $course)
														<option value="{{ $course->name ?? ''  }}" data-duration="{{ $course->duration ?? 1 }}" data-semester="{{ $course->total_semester ?? 0 }}" data-type="{{ $course->course_type ?? 'Semester' }}" {{ ($course->name == old('course')) ? 'selected' : '' }}>
															{{ $course->name ?? ''  }} ({{ $course->duration ?? 1 }} {{ ($course->duration > 1) ? 'Yrs' : 'Yr' }}{{ ($course->course_type == 'Semester' && $course->total_semester > 0) ? ' / ' . $course->total_semester . ' Sem' : '' }})
														</option>
														@endforeach
													@endif
												</select>
												<span class="invalid-feedback" id="course_invalid" role="alert">
													<strong>The Course field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Class / Semester') }} <span class="text-danger">*</span></label>
												<select class="form-control invalid select2" id="class_type_id" name="class_type_id">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($classType))
														@foreach($classType as $type)
														<option value="{{ $type->id ?? ''  }}" data-orderBy="{{ $type->orderBy ?? ''  }}" {{ ($type->id == old('class_type_id')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
														@endforeach
													@endif
												</select>
												<span class="invalid-feedback" id="class_type_id_invalid" role="alert">
													<strong>The Class / Semester field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Batch') }} <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="batch" name="batch" placeholder="Auto-calculated (e.g. {{ date('Y') }}-{{ date('y', strtotime('+3 years')) }})" value="{{ old('batch') }}" readonly style="background-color: #e9ecef; cursor: not-allowed;">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Student Type') }} <span class="text-danger">*</span></label>
												<select class="form-control select2" id="student_type" name="student_type">
													<option value="Regular" {{ (old('student_type') == 'Regular') ? 'selected' : '' }}>Regular</option>
													<option value="Management" {{ (old('student_type') == 'Management') ? 'selected' : '' }}>Management</option>
													<option value="Govt" {{ (old('student_type') == 'Govt') ? 'selected' : '' }}>Govt.</option>
													<option value="NRI" {{ (old('student_type') == 'NRI') ? 'selected' : '' }}>NRI</option>
												</select>
											</div>
										</div>

										<div class="col-md-3" id="stream_subject_div" style="display:none;">
											<div class="form-group">
												<label class="font-weight-bold">Stream Subject <span class="text-danger">*</span></label>
												<select class="form-control select2" multiple id="stream_subject" name="stream_subject[]">
													<option value="">{{ __('common.Select') }}</option>
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Roll No') }}</label>
												<input type="text" class="form-control" name="roll_no" id="roll_no" placeholder="{{ __('Roll No') }}" value="{{ old('roll_no') }}">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Date Of Admission') }}</label>
												<input type="date" class="form-control" id="admission_date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- 2. STUDENT & PARENT DETAILS SECTION -->
							<div class="card card-outline card-primary mb-3 shadow-sm">
								<div class="card-header bg-light py-2">
									<h6 class="card-title text-primary font-weight-bold mb-0">
										<i class="fa fa-user mr-1"></i> {{ __('student.Personal Details') }}
									</h6>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Student Name') }} <span class="text-danger">*</span></label>
												<input type="text" name="first_name" id="first_name" class="form-control invalid" value="{{ old('first_name') }}" placeholder="{{ __('Student Name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
												<span class="invalid-feedback" id="first_name_invalid" role="alert">
													<strong>The Student Name field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Fathers Name') }} <span class="text-danger">*</span></label>
												<input type="text" class="form-control invalid" id="father_name" name="father_name" placeholder="{{ __('common.Fathers Name') }}" value="{{ old('father_name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
												<span class="invalid-feedback" id="father_name_invalid" role="alert">
													<strong>The Father's name field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Mothers Name') }}</label>
												<input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="{{ __('common.Mothers Name') }}" value="{{ old('mother_name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Date Of  Birth') }} <span class="text-danger">*</span></label>
												<input type="date" class="form-control invalid" id="dob" name="dob" value="{{ old('dob') }}">
												<span class="invalid-feedback" id="dob_invalid" role="alert">
													<strong>The Date of Birth field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Gender') }} <span class="text-danger">*</span></label>
												<select class="form-control invalid select2" id="gender_id" name="gender_id">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($getgenders))
														@foreach($getgenders as $value)
														<option value="{{ $value->id }}" {{ ($value->id == old('gender_id')) ? 'selected' : '' }}>{{ $value->name ?? '' }}</option>
														@endforeach
													@endif
												</select>
												<span class="invalid-feedback" id="gender_id_invalid" role="alert">
													<strong>The Gender field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Mobile No.') }} <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{ __('common.Mobile No.') }}" value="{{ old('mobile') }}" maxlength="10" onkeypress="javascript:return isNumber(event)">
												<div id="mobileValidationMessage" style="color: red; display: none; font-size:13px;">Must be at least 10 digits</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Fathers Contact No') }} <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder="{{ __('common.Fathers Contact No') }}" value="{{ old('father_mobile') }}" maxlength="10" onkeypress="javascript:return isNumber(event)">
												<div id="fathermobileValidationMessage" style="color: red; display: none; font-size:13px;">Must be at least 10 digits</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">Category</label>
												<select class="form-control select2" id="category" name="category">
													<option value="GEN" {{ ('GEN' == old('category')) ? 'selected' : '' }}>GEN</option>
													<option value="OBC" {{ ('OBC' == old('category')) ? 'selected' : 'selected' }}>OBC</option>
													<option value="SC" {{ ('SC' == old('category')) ? 'selected' : '' }}>SC</option>
													<option value="ST" {{ ('ST' == old('category')) ? 'selected' : '' }}>ST</option>
													<option value="BC" {{ ('BC' == old('category')) ? 'selected' : '' }}>BC</option>
													<option value="SBC" {{ ('SBC' == old('category')) ? 'selected' : '' }}>SBC</option>
													<option value="Other" {{ ('Other' == old('category')) ? 'selected' : '' }}>Other</option>
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">Religion</label>
												<select class="form-control select2" id="religion" name="religion">
													<option value="Hindu" {{ ('Hindu' == old('religion')) ? 'selected' : 'selected' }}>Hindu</option>
													<option value="Islam" {{ ('Islam' == old('religion')) ? 'selected' : '' }}>Islam</option>
													<option value="Sikh" {{ ('Sikh' == old('religion')) ? 'selected' : '' }}>Sikh</option>
													<option value="Buddhism" {{ ('Buddhism' == old('religion')) ? 'selected' : '' }}>Buddhism</option>
													<option value="Jain" {{ ('Jain' == old('religion')) ? 'selected' : '' }}>Jain</option>
													<option value="Christianity" {{ ('Christianity' == old('religion')) ? 'selected' : '' }}>Christianity</option>
													<option value="Other" {{ ('Other' == old('religion')) ? 'selected' : '' }}>Other</option>
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('Blood Group') }}</label>
												<select class="form-control select2" id="blood_group" name="blood_group">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($bloodGroupType))
														@foreach($bloodGroupType as $bloodtype)
														<option value="{{ $bloodtype->name ?? '' }}" {{ ($bloodtype->name == old('blood_group')) ? 'selected' : '' }}>{{ $bloodtype->name ?? '' }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Aadhaar No.') }}</label>
												<input type="text" class="form-control" id="aadhaar" name="aadhaar" placeholder="{{ __('common.Aadhaar No.') }}" value="{{ old('aadhaar') }}" maxlength="12" onkeypress="javascript:return isNumber(event)">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.E-Mail') }}</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="{{ __('common.E-Mail') }}" value="{{ old('email') }}">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- 3. ADDRESS DETAILS SECTION -->
							<div class="card card-outline card-primary mb-3 shadow-sm">
								<div class="card-header bg-light py-2">
									<h6 class="card-title text-primary font-weight-bold mb-0">
										<i class="fa fa-map-marker mr-1"></i> Address Details / पते का विवरण
									</h6>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Country') }}</label>
												<select class="form-control select2" name="country" id="country_id">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($getCountry))
														@foreach($getCountry as $country)
														<option value="{{ $country->id ?? '' }}" {{ ($country->id == ($getSetting->country_id ?? '')) ? 'selected' : '' }}>{{ $country->name ?? '' }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold required">{{ __('common.State') }} <span class="text-danger">*</span></label>
												<select class="form-control stateId select2 invalid" id="state_id" name="state">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($getState))
														@foreach($getState as $state)
														<option value="{{ $state->id ?? '' }}" {{ ($state->id == ($getSetting->state_id ?? '')) ? 'selected' : '' }}>{{ $state->name ?? '' }}</option>
														@endforeach
													@endif
												</select>
												<span class="invalid-feedback" id="state_id_invalid" role="alert">
													<strong>The State field is required</strong>
												</span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.City') }}</label>
												<select class="form-control cityId select2" name="city" id="city_id">
													<option value="">{{ __('common.Select') }}</option>
													@if(!empty($getCity))
														@foreach($getCity as $cities)
														<option value="{{ $cities->id ?? '' }}" {{ ($cities->id == ($getSetting->city_id ?? '')) ? 'selected' : '' }}>{{ $cities->name ?? '' }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('common.Pin Code') }}</label>
												<input type="text" class="form-control" id="pincode" name="pincode" placeholder="{{ __('common.Pin Code') }}" value="{{ old('pincode') }}" maxlength="6" onkeypress="javascript:return isNumber(event)">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Village/City') }}</label>
												<input type="text" class="form-control" id="village_city" name="village_city" placeholder="{{ __('student.Village/City') }}" value="{{ old('village_city') }}">
											</div>
										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Students Address') }}</label>
												<input type="text" class="form-control" id="address" name="address" placeholder="{{ __('student.Students Address') }}" value="{{ old('address') }}">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- 4. DOCUMENT UPLOAD SECTION -->
							<div class="card card-outline card-primary mb-3 shadow-sm">
								<div class="card-header bg-light py-2">
									<h6 class="card-title text-primary font-weight-bold mb-0">
										<i class="fa fa-file-image-o mr-1"></i> {{ __('student.Document Upload') }}
									</h6>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Student Photo') }}</label>
												<div class="d-flex align-items-center">
													<input type="file" class="form-control-file" name="student_img" id="student_img" accept="image/png, image/jpg, image/jpeg">
													<img src="{{ env('IMAGE_SHOW_PATH').'/student_image/profile_img.png' }}" class="rounded ml-2 border" width="50px" height="50px" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
												</div>
												<p class="text-danger mb-0" id="image_error"></p>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Father Photo') }}</label>
												<div class="d-flex align-items-center">
													<input type="file" class="form-control-file" name="father_img" id="father_img" accept="image/png, image/jpg, image/jpeg">
													<img src="{{ env('IMAGE_SHOW_PATH').'/student_image/profile_img.png' }}" class="rounded ml-2 border" width="50px" height="50px" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
												</div>
												<p class="text-danger mb-0" id="image_errors"></p>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label class="font-weight-bold">{{ __('student.Mother Photo') }}</label>
												<div class="d-flex align-items-center">
													<input type="file" class="form-control-file" name="mother_img" id="mother_img" accept="image/png, image/jpg, image/jpeg">
													<img src="{{ env('IMAGE_SHOW_PATH').'/student_image/profile_img.png' }}" class="rounded ml-2 border" width="50px" height="50px" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
												</div>
												<p class="text-danger mb-0" id="image_er"></p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- SUBMIT BUTTON -->
							<div class="col-md-12 text-center my-4"> 
								<button type="submit" class="btn btn-primary btn-lg px-5 shadow" id="is-invalid">
									<i class="fa fa-check-circle mr-1"></i> {{ __('common.submit') }}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        var baseUrl = "{{ url('/') }}";
        
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
    
    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
</style>



<style>
	@media only screen and (max-width: 600px) {
		.upload {
			margin-left: 27%;
			margin-top: 7%;
		}
	}
</style>
<script>
	var basurl = "{{ url('/') }}";
		
		
		
	function SearchValue() {
		var basurl = "{{ url('/') }}";
		var name = $('#searchName').val();
		var registration_no = $('#registration_no').val();
		var class_search_id = $('#class_search_id :selected').val();
		if (class_search_id > 0 || registration_no != '' || name != '') {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				},
				type: 'post',
				url: basurl + '/admissionStudentSearch',
				data: {
					class_search_id: class_search_id,
					name: name,
					registration_no: registration_no
				},
				//dataType: 'json',
				success: function(data) {
                    $('.student_list_show').addClass('fadeinout');
					$('.student_list_show').html(data);
                    setTimeout(function() {
                         $('.student_list_show').removeClass('fadeinout');
                    }, 2000);
				}
			});
		} else {
			toastr.error('Please put a value in one column !');
		}
	};
    
 

	function showData(student_id) {
		var basurl = "{{ url('/') }}";
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			},
			type: 'post',
			url: basurl + '/admissionStudentOnClick',
			data: {
				student_id: student_id
			},
			dataType: 'json',
			success: function(data) {

				if (data) {
				    if(data.stu_data.status !== 1){
					$('#reg_id').val(data.stu_data.registration_no);
					$('#first_name').val(data.stu_data.first_name);
					$('#last_name').val(data.stu_data.last_name);
					$('#aadhaar').val(data.stu_data.aadhaar);
					$('#student_id').val(data.stu_data.name);
					$('#gender_id').val(data.stu_data.gender_id);
					$('#class_type_id').val(data.stu_data.class_type_id);
					$('#dob').val(data.stu_data.dob);
					$('#mobile').val(data.stu_data.mobile);
					$('#email').val(data.stu_data.email);
					$('#father_name').val(data.stu_data.father_name);
					$('#mother_name').val(data.stu_data.mother_name);
					$('#father_mobile').val(data.stu_data.father_mobile);
					$('#admission_type_id').val(data.stu_data.admission_type_id);
					$('#sms_contact_no').val(data.stu_data.sms_contact_no);
					$('#village_city').val(data.stu_data.village_city);
					$('#address').val(data.stu_data.address);
					$('#pincode').val(data.stu_data.pincode);
					$('#remark_1').val(data.stu_data.remark_1);
					$('#country_id').val(data.stu_data.country_id);
                    $('.stateId').val(data.stu_data.state_id);
                    $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                	  url: basurl+'/stateData/' + data.stu_data.state_id,
                	  success: function(value){
            		    $(".cityId").html(value);
                	  }
                    });
        	        setTimeout(function() {
                        var count = $('.cityId').children('option').length;
                        for (var i = 0; i < count; i++) {
                            var option = $('.cityId').children('option').eq(i);
                            var id = option.val();
                            if (id == data.stu_data.city_id) {
                                option.prop('selected', true);
                            }
                        }
                    }, 500); 
					$('#student_img').val(data.stu_data.student_img);
					$('#father_img').val(data.stu_data.father_img);
					$('#mother_img').val(data.stu_data.mother_img);
					$('#student_roll_no').val(data.stu_data.roll_no);
					$('#school_name').val(data.stu_data.school_name);
					$('#date_of_admission').val(data.stu_data.dob);
				}else{
				    $('#reg_id,#first_name,#last_name,#aadhaar,#student_id,#gender_id,#class_type_id,#dob,#mobile,#email,#father_name,#mother_name,#father_mobile,#admission_type_id,#sms_contact_no,#village_city,#address,#pincode,#remark_1,#country_id').val("");
				}
				} else {
					alert('No more records found');
				}

			}
		});
	};

	
	$('#is-invalid').click(function(e){
    e.preventDefault();
    var isValid = true;

    $('.invalid').each(function(){
        var this_value = $(this).val();
        var this_id = $(this).attr('id'); 
        if(!this_value || this_value === ''){
            $('#' + this_id + '_invalid').show();
            isValid = false;
        }else{
            $('#' + this_id + '_invalid').hide();
        }
    });

    var mobileValue = $('#mobile').val() || '';
    if (mobileValue.length < 10) {
        $('#mobileValidationMessage').show();
        isValid = false;
    } else {
        $('#mobileValidationMessage').hide();
    }

    var fatherMobileValue = $('#father_mobile').val() || '';
    if (fatherMobileValue.length < 10) {
        $('#fathermobileValidationMessage').show();
        isValid = false;
    } else {
        $('#fathermobileValidationMessage').hide();
    }

    if(isValid){
        $('#quickForm_addmission').trigger('submit');
    }else{
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
});
</script>

<script>
$(document).ready(function(){
    function calculateBatch() {
        var selectedOption = $('#course').find(':selected');
        var duration = parseInt(selectedOption.data('duration')) || 0;
        if (duration > 0) {
            var currentYear = new Date().getFullYear();
            var endYear = currentYear + duration;
            var endYearShort = String(endYear).slice(-2);
            $('#batch').val(currentYear + '-' + endYearShort);
        } else {
            $('#batch').val('');
        }
    }

    // Dynamic Course-dependent Classes / Semesters loader and Batch calculator
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
                    classSelect.empty();
                    classSelect.append('<option value="">{{ __("common.Select") }}</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(key, val) {
                            classSelect.append('<option value="' + val.id + '" data-orderby="' + (val.orderBy || '') + '">' + val.name + '</option>');
                        });
                    }
                    if (classSelect.hasClass('select2')) {
                        classSelect.trigger('change.select2');
                    }
                }
            });
        } else {
            classSelect.empty();
            classSelect.append('<option value="">{{ __("common.Select") }}</option>');
            if (classSelect.hasClass('select2')) {
                classSelect.trigger('change.select2');
            }
        }
    });

    if ($('#course').val() && !$('#batch').val()) {
        calculateBatch();
    }
  });
</script>
@endsection