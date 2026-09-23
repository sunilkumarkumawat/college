@php
$getAdmissionDatatableFields = Helper::getAdmissionDatatableFields();
$classType = Helper::classType($search['course'] ?? null);
$allClassType = Helper::classType();
$getState = Helper::getState();
$getcitie = Helper::getCity(); 
$getgenders = Helper::getgender();
$getCountry = Helper::getCountry();
$bloodGroupType = Helper::bloodGroupType();
$gender = DB::table('gender')->whereNull('deleted_at')->pluck('name')->implode(',');
$villageList = DB::table('custom_villages_list')->whereNull('deleted_at')->pluck('name')->implode(',');
$class = DB::table('class_types')->where('branch_id',Session('branch_id'))->where('session_id',Session('session_id'))->whereNull('deleted_at')->pluck('name')->implode(',');

$setting = Db::table('settings')->whereNull('deleted_at')->first();
$stateList = DB::table('states')->where('id', 13)->pluck('name')->implode(',');
$cityList = DB::table('citys')->whereNull('deleted_at')->where('state_id', 13)->take(25)->pluck('name')->implode(',');
$bloodgroupList = DB::table('blood_groups')->whereNull('deleted_at')->pluck('name')->implode(',');
$getSession = Helper::getSession();
$courses = Helper::getCourses();
$batches = Helper::getBatch();

@endphp
@extends('layout.app')
@section('content')

<style>
    .fixed_item{
        position:sticky !important;
        right:-8px;
        background-color:white;
        z-index:111;
        box-shadow: -6px 2px 6px #cecece;
    }
    th.fixed_item{
        background-color: #1f2d3d !important;
        color: white !important;
    }
    
    .dropdown-menu.show {
        left: -79px !important;
    }
    
    .flex_centered{
        display:flex;
        align-items:center;
        /*justify-content: space-between;*/
        height: 55px;
    }
    
    .flex_centered a{
        margin-left:10px;
    }
    
    .nowrap{
        white-space:nowrap;
        font-size:14px;
    }
    
    .colored_table thead tr{
        background-color:#002c54;
        color:white;
    }
    .colored_table thead tr th{
        padding:10px;
    }
    
    .overflow_scroll{
        height:250px;
        overflow:scroll;
    }
</style>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-outline card-orange">
            <div class="card-header bg-primary flex_items_toggel">
              <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;{{ __('student.View Students Admission') }}</h3>
              <div class="card-tools">
                <a href="{{url('admissionAdd')}}" class="btn btn-primary  btn-sm"><i class="fa fa-plus"></i><span class="Display_none_mobile"> {{ __('common.Add') }} </span></a>
                <a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i><span class="Display_none_mobile"> {{ __('common.Back') }} </span></a>
              </div>

            </div>
            
        <div class="row m-2">

            <form id="quickForm" action="{{ url('admissionView') }}" method="post" class="w-100">
              @csrf
              
              <div class="row">

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

                <div class="col-md-2 col-6">
                  <div class="form-group">
                    <label>{{ __('Class / Semester') }}</label>
                    <select class="form-control select2" id="class_type_id" name="class_type_id">
                      <option value='' >{{ __('common.Select') }}</option>
                      @if(!empty($classType))
                      @foreach($classType as $type)
                      <option value="{{ $type->id ?? ''  }}" {{ ($type->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="col-md-1 col-6">
                    <div class="form-group">
                        <label>{{ __('Batch') }}</label>
                        <select class="form-control select2" id="batch" name="batch">
                            <option value="">{{ __('common.Select') }}</option>
                            @if(!empty($batches))
                                @foreach($batches as $batch)
                                <option value="{{ $batch->name ?? ''  }}" {{ (($batch->name ?? '') == ($search['batch'] ?? '')) ? 'selected' : '' }}>{{ $batch->name ?? ''  }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-1 col-6">
                    <div class="form-group">
                        <label>{{ __('Session') }}</label>
                        <select class="form-control select2" id="session_id" name="session_id">
                            <option value="">{{ __('All') }}</option>
                            @if(!empty($getSession))
                                @foreach($getSession as $s)
                                    <option value="{{ $s->id }}" {{ ($s->id == ($search['session_id'] ?? Session::get('session_id'))) ? 'selected' : '' }}>
                                        {{ $s->from_year }}-{{ $s->to_year }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-1 col-6">
                  <div class="form-group">
                    <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                     <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                  </div>
                </div>

                <div class="col-md-1 col-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control select2" id="status" name="status">
						    	<option value="">{{ __('common.Select') }}</option>
						    	@if(($search['status'] ?? null) == null)
								<option value="1"  selected>{{ __('Continue') }}</option>
							<option class='text-danger' value="0">{{ __('Discontinue') }}</option>
							@else
								<option value="1"  {{($search['status'] ?? '') == 1 ? 'selected' : '' }}>{{ __('Continue') }}</option>
							<option class='text-danger' value="0" {{($search['status'] ?? '') == 0 ? 'selected' : '' }}>{{ __('Discontinue') }}</option>
							@endif
				       </select>
					</div>
				</div>
                
                <div class="col-md-1 col-6">
					<div class="form-group">
						<label>{{ __('common.Gender') }}</label>
						<select class="form-control invalid select2" id="gender_id" name="gender_id">
							<option value="">{{ __('common.Select') }}</option>
							@if(!empty($getgenders))
							@foreach($getgenders as $value)
							<option value="{{ $value->id}}" {{ ($value->id == ($search['gender_id'] ?? '')) ? 'selected' : '' }}>{{ $value->name ?? ''  }}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
								
                <div class="col-md-2 col-6">
                  <div class="form-group">
                    <label>{{ __('common.Search By Keywords') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}">
                  </div>
                </div>
                
                <div class="col-md-1 col-12">
                  <label class="text-white d-none d-md-block">{{ __('common.Search') }}</label>
                  <button type="submit" class="btn btn-primary btn-block">{{ __('common.Search') }}</button>
                </div>
              
              </div>
            </form>
            
        </div>
        
        <hr class="m-0 ml-2 mr-2">
            <div class="row m-2">
              <div class="col-12" style="overflow-x:scroll;">
                <table id="studentList" class="table table-bordered table-striped dataTable dtr-inline nowrap">
                  <thead id='main_thead' class="bg-primary">
                    <tr role="row">
                      <th></th>
                      <th>{{ __('common.SR.NO') }}</th>
                      @php
                          $table = DB::table('datatable_fields')->first();
                          $dataTable = explode(',',$table->fields);
                      @endphp
                      
                      @if($dataTable)
                      @foreach($dataTable as $val)
                      
                        <th class="text-center  {{$val == 'Mobile' && Session::get('role_id') != 1 ? 'd-none' : ''}}">{{ $val }}</th>
                      @endforeach
                      @endif
                     
                      <!--  <th class="text-center">{{ __('Student.Ad. No') }}</th>-->
                      <!--<th class="text-center">Image</th>-->
                      <!--  <th>{{ __('Ledger No') }}</th>-->
                      <!--  <th>{{ __('Srn') }}</th>-->
                      <!--<th>{{ __('common.Name') }}</th>-->
                      <!--<th>{{ __('common.F Name') }}</th>-->
                      <!--<th>{{ __('common.M Name') }}</th>-->
                      <!--<th>{{ __('common.Class') }}</th>-->
                      <!--<th>{{ __('common.Mobile') }}</th>-->
                      <!--<th>D.O.B.</th>-->
                      <!--<th>State</th>-->
                      <!--<th>City</th>-->
                      <!--<th>Village</th>-->
                      <!--<th>Address</th>-->
                      <!--<th>Pincode</th>-->
                      <!--<th>{{ __('Caste Category') }}</th>-->
                       <!-- <th>{{ __('Id Proof') }}</th>
                      <!--  <th>{{ __('Id Number') }}</th>-->
                      <!--  <th>{{ __('Blood Group') }}</th>-->
                      <!--  <th>{{ __('House') }}</th>-->
                      <!--  <th>{{ __('Height') }}</th>-->
                      <!--  <th>{{ __('Weight') }}</th>-->
                      <!--  <th>Family Income</th>-->
                      <!--  <th>{{ __('Email') }}</th>-->
                      <!--  <th>Family Id</th>-->
                      <!--  <th>Religion</th>-->
                      <!--  <th>Category</th>-->
                      <!--  <th>Aadhar</th>-->
                      <!--  <th>Gender</th>-->
                      <!--  <th>Father Mobile</th>-->
                      <!--  <th>Father Aadhaar</th>-->
                      <!--  <th>Mother Mobile</th>-->
                      <!--  <th>Mother Aadhaar</th>-->
                      <!--  <th>Guardian Name</th>-->
                      <!--  <th>Guardian Mobile</th>-->
                      <!--  <th>Admission Type</th>-->
                      <!--  <th>Bus No.</th>-->
                      <!--  <th>Bus Route</th>-->
                      <!--  <th>Stoppage</th>-->
                      <!--  <th>Transport Charge</th>-->
                      <!--  <th>Bank Name</th>-->
                      <!--  <th>Bank Account</th>-->
                      <!--  <th>Branch Name</th>-->
                      <!--  <th>IFSC</th>-->
                      <!--  <th>MICR Code</th>-->
                      <!--  <th>Remark</th>-->
                      <!--<th>{{ __('student.Ad. Date') }}</th>-->
                      <!--<th>Transport</th>-->
                      <th class="fixed_item">{{ __('common.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody id="product_list_show">

                    @if(!empty($data))
                    @php
                    $i=1;
                    @endphp
                    @foreach ($data as $item)
                        @php

                            $blood_group = DB::table('blood_groups')->whereNull('deleted_at')->where('id',$item->blood_group)->first();
                            $genderName = DB::table('gender')->whereNull('deleted_at')->where('id',$item->gender_id)->first();
                        @endphp
                    <tr>
                        <td><input type='checkbox' class='checkbox_id' data-admission_no="{{$item['admissionNo'] ?? ''}}" data-name="{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}" data-mobile="{{$item['mobile'] ?? ''}}" data-father_name="{{$item['father_name'] ?? ''}}" value='{{$item->id}}'></td>                   
                      <td>{{$item->id}}</td>
                      
                    @if($dataTable)
                    @foreach($dataTable as $val)
                  
                    @if($val == 'Image')
                        <td class="text-center">
                            <img width='50px'height='50px' style='border-radius:3px;padding:1px' class="profileImg pointer deleteImage" data-id="{{ $item->id ?? '' }}" src="{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" data-img="@if(!empty($item->image)) {{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }} @endif" >
                        </td>
                        @elseif($val == 'Name')
                        <td class="myBtn  editables" style="cursor:pointer;" data-id="{{$item->id ?? ''}}"data-field='first_name' data-modal='Admission'>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                        @elseif($val == 'D.O.B.')
                        <td>@if(!empty($item['dob'])) {{ date('d-m-Y', strtotime($item['dob'])) ?? '' }}@endif</td>
                        @elseif($val == 'State')
                        <td>{{ $item['State']['name'] ?? '-' }}</td>
                        @elseif($val == 'City')
                        <td>{{ $item['City']['name'] ?? '-' }}</td>
                        @elseif($val == 'Blood Group')
                        <td>{{ $blood_group->name ?? '-' }}</td>
                        @elseif($val == 'Gender')
                        <td>{{ $genderName->name ?? '-' }}</td>
                        @elseif($val == 'Admission Type')
                    
                            <td class="text-center">
                                @if($item['admission_type_id'] == 1)
                                    <p>Non RTE</p>
                                       
                                @elseif($item['admission_type_id'] == 2)
                                  
                                    <p>RTE</p>
                                @endif
                            </td>
                        @elseif($val == 'Ad. Date')
                        <td>
                            @if(!empty($item['admission_date']))
                          
                                {{date('d-m-Y', strtotime($item['admission_date'])) ?? '' }}
                      
                            @endif
                        </td>
                        @elseif($val == 'Course')
                            <td class="text-center">{{ $item['course'] ?? '-' }}</td>
                        @elseif($val == 'Class')
                            <td class="text-center">{{ $item['ClassTypes']['name'] ?? '-' }}</td>
                        @elseif($val == 'Batch')
                            <td class="text-center"><span class="badge badge-info">{{ $item['batch'] ?? '-' }}</span></td>
                        @elseif($val == 'Student Type')
                            <td class="text-center">{{ $item['student_type'] ?? '-' }}</td>
                        @elseif($val == 'Mobile')
                        
                        @if(Session::get('role_id') == 1)
                         <td class="text-center">{{ $item['mobile'] ?? '-' }}</td>
                        @endif
                          
                        @else
                        <td class="text-center "  data-id="{{$item->id ?? ''}}" data-field='{{$getAdmissionDatatableFields[$val]}}' data-modal='Admission'>{{ $item[$getAdmissionDatatableFields[$val]] ?? ''}} </td>
                    @endif
                    @endforeach
                    @endif
                    
                    <td class="fixed_item"> 
                        <div class="flex_centered">
                            <a href="{{ url('studentDetail') }}/{{ $item['id'] ?? '' }}">
                                <button class="btn btn-success btn-xs" title="Admission View"><i class="fa fa-eye"></i></button>
                            </a>
                            @if($item->status != 3)
                            <a href="{{url('admissionStudentPrint')}}/{{$item->id}}" target="blank">
                                <button class="btn btn-success btn-xs" title="Admission Form"><i class="fa fa-print"></i></button>
                            </a>
                            
                            <!-- <a href="{{url('admissionStudentIdPrint',$item->id)}}" target="blank">
                                <button class="btn btn-success btn-xs" title="Admission ID"><i class="fa fa-credit-card"></i></button>
                            </a> -->
                            
                            <a href="{{url('admissionEdit')}}/{{$item->id}}" target="blank">
                                <button class="btn btn-primary btn-xs" title="Admission Edit"><i class="fa fa-edit"></i></button>
                            </a>
                            
                            <a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData">
                                <button class="btn btn-danger btn-xs" title="Admission Delete"><i class="fa fa-trash-o"></i></button>
                            </a>
                            @else
                            <button class="btn btn-outline-danger ml-2 verify_admission" data-session_id="{{ $item->session_id }}" data-id="{{ $item->id }}" title="Verified Admission">Verified Admission</button>
                            @endif
                        </div>
                        <!--@if(empty($item->student_id_pdf_name))
                        <a href="{{ url('studentId_generator') }}/{{ $item['id'] ?? '' }}" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                        @else
                        <a href="{{ $item->student_id_pdf_name ?? '' }}" class="btn btn-success btn-xs">View PDF</a>
                        @endif-->

                      </td>    

                    </tr>
                    @endforeach
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

<div class="modal fade" id="verify_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Verifying....</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        </div>
        
        <form action="{{ url('verify_admission') }}" method="post">
            @csrf
        
        <div class="modal-body">
            <p>Are you sure you want to move this registration to the admission list?</p>
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Session</label>
                        <select class="form-control" name="session_id" id="sessionId" required>
                            <option value="">Select</option>
                            @if(!empty($getSession))
                                @foreach($getSession as $item)
                                    <option value="{{ $item->id }}">{{ $item->from_year ?? '' }} - {{ $item->to_year ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Yes</button>
        </div>
        </form>
        
      </div>
    </div>
</div>





            <!-- The Modal -->
            <div class="modal" id="Modal_id">
              <div class="modal-dialog">
                <div class="modal-content" style="background: #555b5beb;">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title text-white">Delete Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                  </div>

                  <!-- Modal body -->
                  <form action="{{ url('admissionDelete') }}" method="post">
                    @csrf
                    <div class="modal-body">



                      <input type=hidden id="delete_id" name=delete_id>
                      <h5 class="text-white">Are you sure you want to delete ?</h5>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>


        <div class="modal fade" id="myModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                        <form id="quickForm" action="{{ url('admissionView') }}" method="post">
                      @csrf
                      <div class="row m-2">
        
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="State" class="required">{{ __('student.Admission No.') }}</label>
                             <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                          </div>
                        </div>
                        <div class="col-md-2 col-6">
                          <div class="form-group">
                            <label for="State" class="required">{{ __('messages.State') }}</label>
                            <select class="form-control select2" id="state_id" name="state_id">
                              <option value="">{{ __('messages.Select') }}</option>
                              @if(!empty($getState))
                              @foreach($getState as $state)
                              <option value="{{ $state->id ?? ''}}" {{ ($state->id == $search['state_id']) ? 'selected' : '' }}>{{ $state->name ?? ''}}</option>
                              @endforeach
                              @endif
        
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2 col-6">
                          <div class="form-group">
                            <label for="City">{{ __('messages.City') }}</label>
                            <select class="form-control select2" name="city_id" id="city_id">
                              <option value="">{{ __('messages.Select') }}</option>
                              @if(!empty($getCity))
                              @foreach($getCity as $cities)
                              <option value="{{ $cities->id ?? ''}}" {{ ($cities->id == $search['city_id']) ? 'selected' : '' }}>{{ $cities->name ?? ''  }}</option>
                              @endforeach
                              @endif
                            </select>
                          </div>
                        </div>
                        @if(Session::get('role_id') == 1)
                        <div class="col-md-2 col-6">
                          <div class="form-group">
                            <label>{{ __('messages.Class') }}</label>
                            <select class="form-control select2" id="class_type_id" name="class_type_id">
                              <option value="">{{ __('messages.Select') }}</option>
                              @if(!empty($classType))
                              @foreach($classType as $type)
                              <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['class_type_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                              @endforeach
                              @endif
                            </select>
                          </div>
                        </div>
                       
                        @endif
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>{{ __('messages.Search By Keywords') }}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}">
                          </div>
                        </div>
                        <div class="col-md-1 text-center">
                          <button type="submit" class="btn btn-primary">{{ __('messages.Search') }}</button>
                        </div>
        
                      </div>
                    </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!--image pop-up modal-->
<div id="profileImgModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img id="profileImg" src="" width="100%" height="100%">
      </div>
      <div class="modal-footer" style="display:flex;justify-content:space-between;">
              <a href="javascript:;" data-id='' data-bs-toggle="modal" data-bs-target="#Modal_image" class="">
                                <button class="btn btn-danger btn-xs" title="Image Delete"><i class="fa fa-trash-o"></i> Delete Image</button>
                            </a>
           <a href="" id="downloadLink" download>
               <button class="btn btn-primary btn-xs" title="Image Delete"><i class="fa fa-download" aria-hidden="true"></i> Download Image</button>
                    
                </a>
        <!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>-->
      </div>
    </div>

  </div>
</div>        

<!--image delete Confirmation modal -->
  <div class="modal" id="Modal_image">
              <div class="modal-dialog">
                <div class="modal-content" style="background: #555b5beb;">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title text-white">Delete Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                  </div>
 
                  <!-- Modal body -->
                  <form action="{{ url('imageDelete') }}" method="post">
                    @csrf
                    <div class="modal-body">
                      <input type="hidden" id="delete_image" name="delete_image">
                      <h5 class="text-white">Are you sure you want to delete ?</h5>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

<div id="datatableFieldsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
            <div class="form-group clearfix">
                <div class="icheck-success d-inline">
                <input type="checkbox" id="master_checkbox">
                    <label for="master_checkbox">Select All</label>
                </div>
            </div>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{url('saveAdmissionDatatableFields')}}" method='post'>
            @csrf
        <div class="row">
            @if(!empty($getAdmissionDatatableFields))
            @foreach($getAdmissionDatatableFields as $key => $dataFields)
            @if($key != 'SR.NO')
                <div class="col-md-3">
                    <div class="form-group clearfix">
                        <div class="icheck-success d-inline">
                        <input type="checkbox" class="checkbox" id="field_{{ $dataFields ?? '' }}" name='fields[]' {{ in_array($key, $dataTable) ? 'checked' : ''}} value="{{ $key ?? '' }}">
                            <label for="field_{{ $dataFields ?? '' }}">{{ $key ?? '' }}</label>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
            @endif
            <div class="col-md-12 text-center">
                <button class='btn btn-primary' type='submit'>Save</button>
            </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myLargeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Compose Message</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <div class="modal-body">
            
            
          <div class="row">
          <div class="col-md-12">
                <button class="btn btn-primary btn-xs message-button" data-message="Hello {#name#},

This is Administrator from {#school_name#}. I hope this message finds you well.

We are pleased to provide you with your credentials to access our schoolâ€™s online platform:

APK: https://demo3.rusoft.in/schoolimage/default/GreenGarden.apk
Username: {#user_name#}
Password: {#password#}
Please ensure you keep these credentials secure and do not share them with others. If you have any questions or need further assistance, feel free to contact us at {#school_mobile#}.

Thank you and have a great day!

Best regards,
Administrator
{#school_name#}
{#school_mobile#}">Credentials</button>
                <button class="btn btn-info btn-xs message-button" data-message="Hello {#name#},

This is Administrator from {#school_name#}. I hope this message finds you well.






If you have any questions or need further assistance, feel free to contact us at {#school_mobile#}.

Thank you and have a great day!

Best regards,
Administrator
{#school_name#}
{#school_mobile#}">Message Format</button>


                <button class="btn btn-success btn-xs message-button" data-message="Hello {#name#} ðŸŽ‰âœ¨,

This is Administrator from {#school_name#}. I hope this message finds you well.

We are delighted to extend our warmest wishes to you and your family on this joyous occasion of Diwali ðŸª”. May the festival of lights bring you peace, prosperity, and happiness.

Please enjoy the celebrations safely and cherish these special moments with your loved ones ðŸŽ‡ðŸŽ†. If you have any questions or need further assistance, feel free to contact us at {#school_mobile#}.

Thank you and have a great day! ðŸŒŸ

Best regards,
Administrator
{#school_name#}
{#school_mobile#}">Diwali Wishes</button>
                <button class="btn btn-dark btn-xs message-button" data-message="Hello {#name#},

This is Administrator from {#school_name#}. I hope this message finds you well.

We are excited to extend our heartfelt wishes to you and your family on the vibrant festival of Holi. May your life be filled with the colors of joy, happiness, and love.

Please enjoy the festivities safely and create beautiful memories with your loved ones. If you have any questions or need further assistance, feel free to contact us at {#school_mobile#}.

Thank you and have a great day!

Best regards,
Administrator
{#school_name#}
{#school_mobile#}">Holi Wishes</button>
             
              
              </div>
              </div>
          <div class="row">
            <div class="col-md-4">
              <!-- Message Input -->
              <div class="form-group">
                <label for="message-text" class="col-form-label">Message:</label>
                <textarea class="form-control" id="message-text" rows='10'required></textarea>
              </div> 

              <!-- Attachment Input -->
              <div class="form-group">
                  <div class='d-flex text-center'>
                  <div class='mr-3'>
                  <img id='img_preview' style='border:1px solid #888;border-radius:5px;padding:5px' src='https://demo3.rusoft.in/schoolimage/default/6605525.jpg' width='80px' height='80px'/>
            </div>
            <div class='text-left'>
                <label for="attachment-file" class="col-form-label">Attachment:</label>
                <input type="file" class="form-control" id="attachment-file" accept="image/*">
                </div>
                </div>
              </div>
               
            </div>

            <!-- Right Column (col-md-8) -->
            <div class="col-md-8 overflow_scroll">
    <span class='text-danger' style='font-size:11px'>Note: In the event that a mobile number is not available,the system will omit that particular user from processing.  <br></span>
       
              <table class="table table-striped table-bordered">
                <thead id='secondary_thead'>
               <tr>
                   <th>{{ __('student.Admission No.') }}</th>
                   <th>Name</th>
                   <th>F Name</th>
                   <th>Mobile</th>
                   <th>Status</th>
               </tr>
                </thead>
                <tbody id='secondary_tbody'>
                 
                </tbody>
              </table>
              
               </div>
        
            <div class="col-md-12">
                   <hr class=" border-muted">
            <h5 class="modal-title mb-1" id="myModalLabel">Today's Sent Messages</h5>
              <!-- Table for Rows -->
              <table class="table table-striped table-bordered">
                <thead >
               <tr>
                   <th>Message Id</th>
                   <th>Message</th>
                   <th>Attachment</th>
                   <th>Action</th>
               </tr>
                </thead>
                <tbody id='third_tbody'>
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <div class='text-left'><span style='display:none' class='previousIds'><input type='checkbox' id='previousIds' /> Do Not Use Previous Id's</span><br>
            <button type="button" class="btn btn-info" id="reset_modal">Reset</button>
            <button type="button" class="btn btn-secondary" id="close_modal">Close</button>
          <button type="submit" class="btn btn-primary" id='sendButton'>Send</button>
            </div>
          
        </div>
     
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
    $('.message-button').click(function() {
        var message = $(this).data('message');
        
        $('#message-text').val(message);
    });
});
</script>
       
            <script>
              $('.deleteData').click(function() {
                var delete_id = $(this).data('id');

                $('#delete_id').val(delete_id); 
              });
              
                $('.profileImg').click(function(){
                    var profileImgUrl = $(this).data('img');
                    if(profileImgUrl != ''){
                        $('#profileImgModal').modal('toggle');
                        $('#profileImg').attr('src',profileImgUrl); 
                         $('#downloadLink').attr('href', profileImgUrl);  // Set download link
                    }
                });
                $('.deleteImage').click(function() {
                var delete_image = $(this).data('id');
                $('#delete_image').val(delete_image); 
              });
                
                
                
               
                $('#reset_modal').click(function(){
                $('#studentList_wrapper').find('#btn-whatsapp').trigger('click');
                    // $('#myLargeModal').modal('hide');
                  
                });
                
                
                
                
                
                $( document ).ready(function() {
                    
               var dataCount = parseInt('{{count($data)}}');
                    
    $("#studentList").DataTable({
           "processing": true, // Show processing indicator
            "serverSide": false, 
                  "lengthChange": false, "autoWidth": false,"lengthChange": true, // Default number of rows per page
                "lengthMenu": [10, 20, 50,dataCount] ,
                 "buttons": [ {
                    text: 'Column Visibility',
                    action: function (e, dt, node, config) {
                        $('#datatableFieldsModal').modal('show');
                    }
                },{
                    extend: 'excelHtml5',
                      exportOptions: {
            columns: ':visible:not(:last-child)' // Export only visible columns except the last one
        },
                    customize: function (xlsx) {
                         var cellName ='';
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        var rows = sheet.getElementsByTagName('row');
                        $('row:first c', sheet).attr( 's', '2' ); // first row is bold
                        // Create a new row after A1
                        var newRow = '<row r="2"><c t="inlineStr" r="A2"><is><t></t></is></c></row>';
                        var newNode = $.parseXML(newRow).documentElement;

                        // Adjust the row numbers for subsequent rows
                        for (var i = 1; i < rows.length; i++) {
                            var row = rows[i];
                            var rowIndex = parseInt(row.getAttribute('r'), 10);
                            row.setAttribute('r', rowIndex + 1);
                            

                            // Adjust cell references within the row
                            var cells = row.getElementsByTagName('c');
                            for (var j = 0; j < cells.length; j++) {
                                var cell = cells[j];
                                var cellRef = cell.getAttribute('r');
                                var newCellRef = cellRef.replace(/(\d+)/, function(match) {
                                    return parseInt(match, 10) + 1;
                                });
                                cell.setAttribute('r', newCellRef);
                            }
                        }

                        // Insert the new row after the first row
                        sheet.getElementsByTagName('row')[0].parentNode.insertBefore(newNode, rows[1]);

                        // Modify all header cells' background color, font size, color, and border
                        var styles = xlsx.xl['styles.xml'];
                        var fills = styles.getElementsByTagName('fills')[0];
                        var fonts = styles.getElementsByTagName('fonts')[0];
                        var borders = styles.getElementsByTagName('borders')[0];

                        // Add new fill
                        var fillIndex = fills.childNodes.length;
                        var fill = $.parseXML('<fill><patternFill patternType="solid"><fgColor rgb="6639b5"/></patternFill></fill>').documentElement;
                        fills.appendChild(fill);

                        // Add new font
                        var fontIndex = fonts.childNodes.length;
                        var font = $.parseXML('<font><sz val="14"/><color rgb="ffffff"/></font>').documentElement;
                        fonts.appendChild(font);

                        // Add new border
                        var borderIndex = borders.childNodes.length;
                        var border = $.parseXML('<border><left style="thin"/><right style="thin"/><top style="thin"/><bottom style="thin"/></border>').documentElement;
                        borders.appendChild(border);

                        // Add new xf for the cell
                        var cellXfs = styles.getElementsByTagName('cellXfs')[0];
                        var xfIndex = cellXfs.childNodes.length;
                        var xf = $.parseXML('<xf applyFill="1" applyFont="1" applyBorder="1" fontId="' + fontIndex + '" fillId="' + fillIndex + '" borderId="' + borderIndex + '">'+'<alignment vertical="center"/>'+'</xf>').documentElement;
                        cellXfs.appendChild(xf);

                        // Apply the style to all header cells
                        var headerCells = sheet.querySelectorAll('row:first-of-type c');
                        headerCells.forEach(function(cell) {
                            cell.setAttribute('s', xfIndex);
                        });

var dataCells = sheet.querySelectorAll('row:not(:first-of-type) c');
var dataValidations = sheet.getElementsByTagName('dataValidations')[0];
    if (!dataValidations) {
        dataValidations = sheet.createElement('dataValidations');
        sheet.getElementsByTagName('worksheet')[0].appendChild(dataValidations);
    }

    // Iterate through the rows and add data validation to each V4 cell
    var numberOfRows = dataCells.length; 
                        // Apply the same style to cells with text from <th>
                        var tableHeaders = $('#studentList thead th');
                    var count=-1;
                       var head = '';
                        tableHeaders.each(function(index, th) {
                            count++;
                            var thText = $(th).text();
                            var headerCells = sheet.querySelectorAll('row c[r^="' + String.fromCharCode(65 + index) + '"] is t');
                                head = thText;
                               
                               
                            headerCells.forEach(function(headerCell) {
                              
                                if (headerCell.textContent === thText) {
                        
                                   // headerCell.parentElement.parentElement.setAttribute('s', xfIndex);
                                }
                            });
                             function indexToColumnName(index) {
    let columnName = '';
 while (index >= 0) {
        columnName = String.fromCharCode((index % 26) + 65) + columnName;
        index = Math.floor(index / 26) - 1;
    }
    
    return columnName;
}

                if(head ==='Class')
                {
             for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$class}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
     
                }
                
                 if(head ==='Gender')
                {
                for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$gender}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                    
                }
                
                 if(head ==='State')
                {
                    
                    for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$stateList}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                    
                }
                
                
                 if(head ==='City')
                {
                    
                    for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$cityList}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                    
                }                


                 if(head ==='Blood Group')
                {
                    
                    for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$bloodgroupList}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                    
                }   
                
                 if(head ==='Admission Type')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Non RTE,RTE"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                
                 if(head ==='Income Tax Payee Father')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Yes,No"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                
                 if(head ==='Income Tax Payee Mother')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Yes,No"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                
                 if(head ==='Income Tax Payee Mother')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Yes,No"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                
                 if(head ==='BPL')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Yes,No"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                
                 if(head ==='Religion')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"HINDU,ISLAM,SIKH,BUDDHISM,ADIVASI,JAIN,CHRISTIANITY,OTHER"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }
                 if(head ==='Category')
                {
                    for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"OBC,SC,ST,BC,GEN,SBC,Other"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }

                 if(head ==='Transport')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"Yes,No"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }                
                 if(head ==='Village')
                {
                      for (var rowIndex = 4; rowIndex <= numberOfRows; rowIndex++) {
        var cellRef = indexToColumnName(count) + rowIndex;
        var dataValidation = sheet.createElement('dataValidation');
        dataValidation.setAttribute('type', 'list');
        dataValidation.setAttribute('allowBlank', '1');
        dataValidation.setAttribute('showInputMessage', '1');
        dataValidation.setAttribute('showErrorMessage', '1');
        dataValidation.setAttribute('sqref', cellRef); // Apply to the current V cell
        var formula1 = sheet.createElement('formula1');
        formula1.textContent = '"{{$villageList}}"'; // Options for the dropdown
        dataValidation.appendChild(formula1);
        dataValidations.appendChild(dataValidation);
    }
                    
                }                
                
                 dataValidations.setAttribute('count', dataValidations.childNodes.length);
  
                        });

                        // Remove the style from cells with text from <td>
                       // var dataCells = sheet.querySelectorAll('row:not(:first-of-type) c');
                        dataCells.forEach(function(cell) {
                            var textNode = cell.querySelector('is t');
                            if (textNode) {
                                var text = textNode.textContent;
                                var tdTexts = $('#studentList tbody td').map(function() { return $(this).text(); }).get();
                                if (tdTexts.includes(text)) {
                                    cell.removeAttribute('s');
                                }
                            }
                        });
                        
                        $('row', sheet).first().attr('ht', '150').attr('customHeight', "1");
    
                       
                       var cellA1 = sheet.querySelector('c[r="A1"]');

    // If cell A1 does not exist, create it
    if (!cellA1) {
        cellA1 = sheet.createElement('c');
        cellA1.setAttribute('r', 'A1');
        cellA1.setAttribute('t', 'inlineStr');

        var worksheet = sheet.getElementsByTagName('worksheet')[0];
        var sheetData = worksheet.getElementsByTagName('sheetData')[0];

        if (!sheetData) {
            sheetData = sheet.createElement('sheetData');
            worksheet.appendChild(sheetData);
        }

        var row1 = sheet.querySelector('row[r="1"]');
        if (!row1) {
            row1 = sheet.createElement('row');
            row1.setAttribute('r', '1');
            sheetData.appendChild(row1);
        }

        row1.appendChild(cellA1);
    }

    // Find or create the text element for cell A1
    var isNode = cellA1.querySelector('is');
    if (!isNode) {
        isNode = sheet.createElement('is');
        cellA1.appendChild(isNode);
    }

    var tNode = isNode.querySelector('t');
    if (!tNode) {
        tNode = sheet.createElement('t');
        isNode.appendChild(tNode);
    } 

    // Set the new text content
     tNode.textContent = '{{$setting->name}}\nAddress:{{$setting->address}}\nMobile:{{$setting->mobile}} Email:{{$setting->gmail}}\nDate:{{date("d-M-Y")}}';
                    }
                },'pdf'
                ]
                }).buttons().container().appendTo('#studentList_wrapper .col-md-6:eq(0)');
        // $('#studentList').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         {
        //             extend: 'excelHtml5',
        //              exportOptions: {
        //     columns: 'th:not(:last-child)'
        //  },
        //             customize: function (xlsx) {
        //                 var sheet = xlsx.xl.worksheets['sheet1.xml'];
        //                 var rows = sheet.getElementsByTagName('row');
        //                 $('row:first c', sheet).attr( 's', '2' ); // first row is bold
        //                 // Create a new row after A1
        //                 var newRow = '<row r="2"><c t="inlineStr" r="A2"><is><t>New Cell Content</t></is></c></row>';
        //                 var newNode = $.parseXML(newRow).documentElement;

        //                 // Adjust the row numbers for subsequent rows
        //                 for (var i = 1; i < rows.length; i++) {
        //                     var row = rows[i];
        //                     var rowIndex = parseInt(row.getAttribute('r'), 10);
        //                     row.setAttribute('r', rowIndex + 1);
                            

        //                     // Adjust cell references within the row
        //                     var cells = row.getElementsByTagName('c');
        //                     for (var j = 0; j < cells.length; j++) {
        //                         var cell = cells[j];
        //                         var cellRef = cell.getAttribute('r');
        //                         var newCellRef = cellRef.replace(/(\d+)/, function(match) {
        //                             return parseInt(match, 10) + 1;
        //                         });
        //                         cell.setAttribute('r', newCellRef);
        //                     }
        //                 }

        //                 // Insert the new row after the first row
        //                 sheet.getElementsByTagName('row')[0].parentNode.insertBefore(newNode, rows[1]);

        //                 // Modify all header cells' background color, font size, color, and border
        //                 var styles = xlsx.xl['styles.xml'];
        //                 var fills = styles.getElementsByTagName('fills')[0];
        //                 var fonts = styles.getElementsByTagName('fonts')[0];
        //                 var borders = styles.getElementsByTagName('borders')[0];

        //                 // Add new fill
        //                 var fillIndex = fills.childNodes.length;
        //                 var fill = $.parseXML('<fill><patternFill patternType="solid"><fgColor rgb="6639b5"/></patternFill></fill>').documentElement;
        //                 fills.appendChild(fill);

        //                 // Add new font
        //                 var fontIndex = fonts.childNodes.length;
        //                 var font = $.parseXML('<font><sz val="14"/><color rgb="ffffff"/></font>').documentElement;
        //                 fonts.appendChild(font);

        //                 // Add new border
        //                 var borderIndex = borders.childNodes.length;
        //                 var border = $.parseXML('<border><left style="thin"/><right style="thin"/><top style="thin"/><bottom style="thin"/></border>').documentElement;
        //                 borders.appendChild(border);

        //                 // Add new xf for the cell
        //                 var cellXfs = styles.getElementsByTagName('cellXfs')[0];
        //                 var xfIndex = cellXfs.childNodes.length;
        //                 var xf = $.parseXML('<xf applyFill="1" applyFont="1" applyBorder="1" fontId="' + fontIndex + '" fillId="' + fillIndex + '" borderId="' + borderIndex + '">'+'<alignment vertical="center"/>'+'</xf>').documentElement;
        //                 cellXfs.appendChild(xf);

        //                 // Apply the style to all header cells
        //                 var headerCells = sheet.querySelectorAll('row:first-of-type c');
        //                 headerCells.forEach(function(cell) {
        //                     cell.setAttribute('s', xfIndex);
        //                 });

        //                 // Apply the same style to cells with text from <th>
        //                 var tableHeaders = $('#studentList thead th');
        //                 tableHeaders.each(function(index, th) {
        //                     var thText = $(th).text();
        //                     var headerCells = sheet.querySelectorAll('row c[r^="' + String.fromCharCode(65 + index) + '"] is t');
        //                     headerCells.forEach(function(headerCell) {
        //                         if (headerCell.textContent === thText) {
        //                             headerCell.parentElement.parentElement.setAttribute('s', xfIndex);
        //                         }
        //                     });
        //                 });

        //                 // Remove the style from cells with text from <td>
        //                 var dataCells = sheet.querySelectorAll('row:not(:first-of-type) c');
        //                 dataCells.forEach(function(cell) {
        //                     var textNode = cell.querySelector('is t');
        //                     if (textNode) {
        //                         var text = textNode.textContent;
        //                         var tdTexts = $('#studentList tbody td').map(function() { return $(this).text(); }).get();
        //                         if (tdTexts.includes(text)) {
        //                             cell.removeAttribute('s');
        //                         }
        //                     }
        //                 });
                        
        //                 $('row', sheet).first().attr('ht', '60').attr('customHeight', "1");
                       
                       
        //             }
        //         }
        //     ]
        // });
});
             
              
            </script>
            
            <script>
               $(document).ready(function(){
                   checkmaster();
                   function checkmaster(){
                       var CheckboxLength = parseInt($('.checkbox').length);
                       var checkedCheckboxLength = parseInt($('.checkbox:checked').length);
                       
                       if(CheckboxLength == checkedCheckboxLength){
                           $('#master_checkbox').prop('checked',true);
                       }else{
                           $('#master_checkbox').prop('checked',false);
                       }
                   }
                   
                   
                   $('#master_checkbox').click(function(){
                        if($(this).is(':checked')){
                            $('.checkbox').prop('checked',true);
                        }else{
                            $('.checkbox').prop('checked',false);   
                        } 
                        
                        checkmaster();
                    }); 
                    
                    $('.checkbox').click(function(){
                       checkmaster(); 
                    });
               });
            </script>
            
            <script>
                function todayWhatsappMessages(){
                        $('#third_tbody').html('');
                    var baseUrl = "{{ url('/') }}";
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                        url: baseUrl +'/todayWhatsappMessages',
                        method: 'POST',
                        success: function(response) {
                            if(response.status){ 
                                response.data.forEach(function(item) {
                                     var attachmentContent = item.attachment ? `<a target="_blank" href="${item.attachment}" ><img src="${item.attachment}" width="40px" height="40px"/></a>` : "";

                                     var newRow = `<tr>
                              <td class='messageId'>${item.message_id}</td>
                              <td class='old_message'>${item.message}</td>
                                <td class='attachment'>${attachmentContent}</td>
                    
                              <td ><a class="useMe"data-ids="${response.ids[item.message_id]}" style="cursor:pointer;  text-decoration: underline; color:blue">Use Me</a></td>
                            </tr>`;
                            $('#third_tbody').append(newRow);
                                    
                               
                                });
                            }
                        },
                        
                        error: function(error) {
                            console.error('Error sending data:', error);
                        }
                    });
                }
            
            
    $(document).ready(function() {
        
function generateRandom8DigitNumber() {
    let min = 10000000; // minimum 8-digit number (10000000)
    let max = 99999999; // maximum 8-digit number (99999999)
    return Math.floor(Math.random() * (max - min + 1)) + min;
}



        
        var messageId = '';
        var attachment2 = '';
        var id = [];
        var i =0;
        var filter = [];
        var arr =[];
             var previousIds =[]; 
        var notUsePreviousIds =false;
        var sending = true;
        var customElement = $('<div>', {
            id: 'custom-element',
            class: 'custom-element-class'
        });



        // Load the buttons into the custom element
        customElement.load('{{ url("messangerButtons") }} #custom-buttons', function() {
            // Append the custom element to the wrapper after loading the buttons
            $('#studentList_wrapper .col-md-6:eq(1)').append(customElement);
        });

           $('#studentList_wrapper').on('click', '#btn-sms', function() {
           toastr.error('Service is unavailabe')
            // Add your SMS handling code here
        });
        
        
         $('#close_modal').click(function(){
                    sending = false;
                    $('#myLargeModal').modal('hide');
                });
        
        $('#studentList_wrapper').on('click', '#btn-checkall', function() {
            var status = parseInt($(this).attr('data-status'));
         
            if(status == 0){
                $(this).attr('data-status',1); 
                $(this).removeAttr('class');
                $(this).attr('class','btn btn-secondary btn-sm');
                $('#check_box_icon').removeAttr('class');
                $('#check_box_icon').attr('class','fa fa-check-square');
                $('.checkbox_id').prop('checked',true);
            }else{
                $(this).attr('data-status',0);
                $(this).removeAttr('class');
                $(this).attr('class','btn btn-outline-secondary btn-sm');
                $('#check_box_icon').removeAttr('class');
                $('#check_box_icon').attr('class','fa fa-square-o');
                $('.checkbox_id').prop('checked',false);
            }
        });

        $('#studentList_wrapper').on('click', '#btn-whatsapp', function() {
            
            $('#img_preview').attr('src','https://demo3.rusoft.in/schoolimage/default/6605525.jpg')
            var length = $('.checkbox_id:checked').length;
            if(length > 0){
                messageId =generateRandom8DigitNumber();
            id =[];
            previousIds =[];
notUsePreviousIds =false;
sending = true;

     if ($('#previousIds').is(':checked')) 
 {
    $('#previousIds').prop('checked', false);
 }
 $('.previousIds').hide();

            todayWhatsappMessages();
            $('#message-text').val(''); 
            
           $('#myLargeModal').modal('show');
           $('#secondary_tbody').html('');
           $(".checkbox_id").each(function( index ) {
                if (this.checked) {
                    var admission_no = $(this).data('admission_no');
                    var name = $(this).data('name');
                    var mobile = $(this).data('mobile');
                    var f_name = $(this).data('father_name');
                    var status = mobile ? 'Pending' : 'Mobile Missing';
                    var ids = $(this).val() 
                    
                    
                    if(mobile != '')
                    {
                    id.push({id:ids,mobile:mobile});
                    }
                    
                    var newRow = `<tr>
                              <td>${admission_no}</td>
                              <td>${name}</td>
                               <td>${f_name}</td>
                              <td>${mobile}</td>
                              <td class='status_action' id="status_${ids}">${status}</td> 
                            </tr>`;
                           
                        $('#secondary_tbody').append(newRow);
                }
           
            });
            }else{
                toastr.error('Please Select Students');
            }
        });
        
   
         $('#sendButton').click(function() {
              i=0;
             
            arr = [];
             if(notUsePreviousIds)
             {
                  filter = $.grep(id, function (item) {
                return $.inArray(parseInt(item.id), previousIds) === -1;
            });
            
            arr = filter;
          
             }
             else
             {
                 arr = id;
             }
             
             
             
 function processNext(){
     //toastr.info('done');
 }
           //  $('#sendButton').css('display','none')
             for(i=0; i<arr.length; i++)
             {
                 
              
             if(sending)
             {
                
                 
         sendPostRequest(arr[i]);
               
             }
             setTimeout(processNext, 1000);
             }
             
//              if(i == arr.length)
//              {
//                 setTimeout(todayWhatsappMessages, 3000)

// $('.status_action').each(function() {
//     if ($(this).text().trim() === "Pending") {
 
//         $(this).text("Skipped").addClass('text-info');
//     }
// });

//              }
             
    
             
             if(arr.length == 0)
             {
                 $('.status_action').each(function() {
                    
    if ($(this).text().trim() === "Pending") {
        
     
        $(this).text("Skipped").addClass('text-info');
    }
});
             }
             
        });
        
    function sendPostRequest(data) {
        var baseUrl = "{{ url('/') }}";
        var message = $('#message-text').val(); 
        var fileInput = $('#attachment-file')[0];
        var file = fileInput.files[0];
    
        var formData = new FormData();
        formData.append('message_id', messageId);
        formData.append('id', data.id);
        formData.append('message', message);
        formData.append('modal', 'Admission');
        formData.append('mobile', data.mobile);
        formData.append('attachment2', attachment2);
        if (file) {
            formData.append('image', file);
        }
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/sendWhatsapp',
            method: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Prevent jQuery from overriding the Content-Type header
            success: function(response) {
                if (response.status) {
                    $('#status_' + response.id).addClass('text-success');
                    $('#status_' + response.id).text('Sent');
                }
                if (!response.status) {
                    $('#status_' + response.id).addClass('text-danger');
                    $('#status_' + response.id).text(response.message);
                }
                             if(i == arr.length)
             {
                setTimeout(todayWhatsappMessages, 3000)

$('.status_action').each(function() {
    if ($(this).text().trim() === "Pending") {
 
        $(this).text("Skipped").addClass('text-info');
    }
});

             }
            },
            error: function(error) {
                console.error('Error sending data:', error);
                // Handle error - e.g., display an error message
            }
        });
    }

        $('#studentList_wrapper').on('click', '#btn-email', function() {
           toastr.error('Service is unavailabe')
            // Add your Email handling code here 
        });
          $('#third_tbody').on('click', '.useMe', function() {
               $('.status_action').each(function() {
            
            if ($(this).text().trim() !== "Mobile Missing") {
        
        $(this).text("Pending");
        $(this).attr('class','');
        $(this).addClass('status_action');
    }
               });
            

            var preId = $(this).data('ids');
            
            previousIds = preId.split(',').map(Number);
    
            previousIds  = previousIds.filter(item => item !== 0); 
                
                var text = $(this).closest('tr').find('.old_message').text();
                var text1 = $(this).closest('tr').find('.messageId').text();
                var url =  $(this).closest('tr').find('.attachment a').attr('href');
                $('#message-text').val(text); 
                
                messageId = text1;
                $('.previousIds').show();
                 $('#attachment-file').val('');
                attachment2 = url;
                $('#img_preview').attr('src',url);
                toastr.info('Message applied in the textarea')
            
            
        });
             $('#previousIds').click(function() {
            
             if (this.checked) {
                 
         notUsePreviousIds = true;
             }else
             {
                 notUsePreviousIds = false;
             }
            
        });
        
        
        
         $('#attachment-file').on('change', function(event) {
         
        var file = event.target.files[0];
       if (file) {
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else{
                toastr.error('Please select a valid image file.');
                $(this).val(''); // Clear the input
                $('#img_preview').attr('src', 'https://demo3.rusoft.in/schoolimage/default/6605525.jpg'); // Clear the image preview
            }
       }
    });
    });
    
    
    $(document).ready(function(){
       $('.verify_admission').click(function(){
           var id = $(this).data('id');
           var session_id = $(this).data('session_id');
           
           $('#id').val(id);
           $('#sessionId').val(session_id);
           
          $('#verify_modal').modal('show'); 
       }); 
    });
    
 
</script>


<script>
        $(document).ready(function(){
            $('#downloadZip').on('click', function(){
                    $(this).text('Generating Please Wait...')
                var data = @json($data);
                
                var urls =[];
                var admissionNo =[];
                
                data.forEach(function(item) {
                    if(item.image != '')
                    {
        // urls.push('https://demo3.rusoft.in/schoolimage/profile/'+item.image)
        // urls.push('{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }}'+item.image)
        urls.push('{{ env('IMAGE_SHOW_PATH').'profile/' }}' + item.image);
        admissionNo.push(item.admissionNo)
                    }
                        
                    });
               
             $(this).text('Downloading ...');
                var zip = new JSZip();
                var count = 0;
                var zipFilename = "{{$setting->name}}.zip";

                urls.forEach(function(url, i){
                    var filename = admissionNo[i]+".jpg"; // Change the filename as needed
                    
                    fetch(url)
                    .then(response => response.blob())
                    .then(blob => {
                        zip.file(filename, blob, {binary: true});
                        count++;
                        if(count === urls.length){
                            zip.generateAsync({type:'blob'}).then(function(content) {
                                saveAs(content, zipFilename);
                            });
                        }
                          setTimeout(function() {
                            $('#downloadZip').text('Bulk Images Download [Zip]');
                        }, 3000); // 3000 milliseconds = 3 seconds
                    })
                    .catch(function(error) {
                        console.log("Error fetching image:", error);
                    });
                });
                
               
            });
        });
    </script>
    
<script src="https://stuk.github.io/jszip/dist/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>

<script>
$(document).ready(function(){
    function updateClassDropdown(classSelect, data) {
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.Select") }}</option>');
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
});
</script>

            @endsection