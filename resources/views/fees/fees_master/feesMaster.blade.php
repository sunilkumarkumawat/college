@php
$getFeesGroup = Helper::getFeesGroup();
$classType = Helper::classType($search['course_id'] ?? null);
$allClassType = Helper::classType();
$getPermission = Helper::getPermission();
$courses = Helper::getCourses();
$getSession = Helper::getSession();
$filteredData = $dataview;
@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper">

  <section class="content pt-3">
      
      <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-4">
        <nav aria-label="breadcrumb">
    <ol class="breadcrumb p-0" style='margin-top:5px'>
      <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{url('master_dashboard')}}">Master</a></li>
      <li class="breadcrumb-item active" aria-current="page">Fees Master</li>
    </ol>
  </nav>
      </div>
      <div class="col-md-8 text-md-right">
        <button style='margin-top:-11px' class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#special_fee_modal">Registration Fee Master</button>
        <button style='margin-top:-11px' class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#students_list_modal">Student Fee Assign</button>
        <button style='margin-top:-11px' id="fees_modification_btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fees_modification">Student Fee Modification</button>
        <!--<button style='margin-top:-11px' class="btn btn-primary">Modify Fees</button>-->
        <!--<button style='margin-top:-11px' class="btn btn-primary">Modify Fees</button>-->
      </div>
    </div>
  </div>


    <div class="container-fluid">
      <div class="row">
      
           
          <div class="card card-outline w-100">
            
            
              <div class="row m-2">
                   
                    <div class="col-md-12">
                       <div class="card">
                           <div class="card-body pl-0 pr-0 pt-2 pb-2">
                                               <div class="col-md-12 text-left"> 
                                            <p class="text-danger font-weight-bold ">Full Payment assign to {{ __('common.Class') }} :-</p>
                                        </div>
                                        <form  class="col-md-12" id="quickForm" action="{{ url('feesMasterAdd') }}" method="post">
                                          @csrf
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>{{ __('Course') }}</label>
                                      <select class="form-control select2" id="assign_course_id" name="course_id">
                                        <option value="">{{ __('common.Select') }}</option>
                                        @if(!empty($courses))
                                          @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                          @endforeach
                                        @endif
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label style="color:red;">{{ __('common.Class') }}*</label>
                                      <select class="form-control select2 @error('class_type_id') is-invalid @enderror " id="class_type_id" name="class_type_id" required>
                                        <option value="">{{ __('messages.Select') }}</option>
                                        @if(!empty($classType))
                                        @foreach($classType as $type)
                                        <option value="{{ $type->id }}">{{ $type->name ?? ''  }}</option>
                                        @endforeach
                                        @endif
                                      </select>
                                      @error('class_type_id')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12 ">
                  <table id="" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                                           <thead>
                                      <tr>
                                        <th>{{ __('fees.Fees Group') }}*</th>
                                        <th>{{ __('messages.Amount') }}*</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th class="d-none">{{ __('Editable') }}</th>
                                        <!--<th></th>-->
                
                                      </tr>
                                    </thead>
                                          
                               
                                   
                                    <tbody id="table_body">
                                      <tr id="appendRow_0">
                
                                        <td>
                                          <select class="form-control select2 @error('fees_group_id') is-invalid @enderror select_fees_group_id" id="fees_group_id" name="fees_group_id[]" Required>
                                            <option value="">{{ __('messages.Select') }}</option>
                                            @if(!empty($getFeesGroup))
                                             @foreach ($getFeesGroup->where('fees_type', 'full') as $type)
                                            <option value="{{ $type->id ?? ''  }}">{{ $type->name ?? ''  }}</option>
                                            @endforeach
                                            @endif
                                          </select>
                                        </td>
                                        <td >
                                          <input class="form-control amount_0  @error('amount') is-invalid @enderror" type="text" name="amount[]" required id="amount"  placeholder="Amount" onkeypress="javascript:return isNumber(event)">
                                        </td>
                                        <td >
                                          <input class="form-control" type="date" name="installment_due_date[]"  >
                                        </td>
                                        <td class="d-none">
                                            <input class="form-control change_box" data-amount_id="0" type="checkbox" name="editable[]" id="editable">
                                            <input type="hidden" name="editable_value[]" class="close_edited_value" id="editable_value" value="0">
                                        </td>
                                        <!--<td >-->
                                        <!--  <div class="action_container">-->
                                        <!--    <button type="button" class="btn btn-primary btn-xs addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button>-->
                                        <!--    <button type="button" class="btn btn-danger btn-xs removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button>-->
                                        <!--  </div>-->
                                        <!--</td>-->
                                      </tr>
                                    </tbody>
                                  </table>
                
                                </div>
                  <div class="col-md-12">
                                <div class="col-md-12 text-center">
                                  <button type="submit" class="btn btn-primary">{{ __('messages.submit') }} </button>
                                </div>
                              </div>
                              </form>
                           </div>
                       </div>
                    </div>
                    
                    <div class="col-md-6 d-none">
                        <div class="card">
                            <div class="card-body pl-0 pr-0 pt-2 pb-2">
                                <form  class="col-md-12" id="installment_form">
                    <div class="col-md-12 text-left"> 
                        <p class="text-danger font-weight-bold ">Installment Payment assign to class :-</p>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="totalAmount">Amt of Installment</label>
                                <input type="text" class="form-control" id="totalAmount" name='total_amount' placeholder="Enter total amount">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                          <div class="form-group">
                                <label style="color:red;">{{ __('common.Class') }}*</label>
                                <select class="form-control" id="installment_class_type_id select2" name="installment_class_type_id">
                                  <option value="">{{ __('messages.Select') }}</option>
                                  @if(!empty($classType))
                                  @foreach($classType as $type)
                                  <option value="{{ $type->id }}">{{ $type->name ?? ''  }}</option>
                                  @endforeach
                                  @endif
                                </select>
                          </div>
                        </div>
                        
                        <!--<div class="col-md-3">
                            <div class="form-group">
                                <label for="numInstallments">Installment Frequency</label>
                                <input type="number" min="1" value='1' max='12' class="form-control" id="frequency">
                            </div>
                        </div>-->
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="numInstallments">Due Date On Every</label>
                               <select class="form-control " name="due_date_on_every" id='due_date_on_every'>
									<!--<option value="">{{ __('common.Select') }}</option>-->
								
									@for($i=1; $i < 32; $i++)
									 <option value="{{ sprintf('%02d', $i) }}" {{ sprintf('%02d', $i) == "05" ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
									@endfor
								
								</select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-white">Preview</label><br>
                                <button type="button" class="btn btn-primary" id="previewBtn">Preview</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div id="errorNotification" class="alert alert-danger" style="display: none;font-size:12px"></div>
                    </div>
                
                    <div id="installments_data" style="display:none;">
                        <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped dataTable dtr-inline padding_table">
            <thead>
                <tr>
                    <th><input type='checkbox' id="select_all" {{ count($feesGroupInstallmentsList) == 0 ? 'disabled' : '' }} /></th>
                    <th>Installment Name</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Due Date</th>
                    <th>Fine[In Percentage %]</th>
                </tr>
            </thead>  
            <tbody id="academicCalendar">
                @if(count($feesGroupInstallmentsList) != 0)
                    @php
                       $i=1;
                    @endphp
                    @foreach ($feesGroupInstallmentsList as $key => $item)
                        <tr>
                                <td><input type='checkbox' name="installmentRow[]" class="select_checkbox" value="{{ $item->id }}" /></td>
                                <td>
                                    {{$item['name'] ?? ''}}
                                    <input type="hidden" class="form-control installmentName install" id="installment_name_{{$item->id}}" value="{{ $item['name'] ?? '' }}">
                                    <input type="hidden" class="form-control installmentId" id="installment_id_{{$item->id}}" value="{{$item['id'] ?? ''}}">
                                </td>
                                <td><input type="text" id="installment_amount_{{ $item->id }}" class="form-control installment-amount amountInstallment"></td>
                                <td>
                                    <select class="form-control installmentMonth" id="installment_month_{{ $item->id }}">
                                        <option value="Jan" selected="">Jan</option>
                                        <option value="Feb">Feb</option>
                                        <option value="Mar">Mar</option>
                                        <option value="Apr">Apr</option>
                                        <option value="May">May</option>
                                        <option value="Jun">Jun</option>
                                        <option value="Jul">Jul</option>
                                        <option value="Aug">Aug</option>
                                        <option value="Sep">Sep</option>
                                        <option value="Oct">Oct</option>
                                        <option value="Nov">Nov</option>
                                        <option value="Dec">Dec</option>
                                    </select>
                                </td>
                                <td><input type="date" class="form-control installmentDueDate" id="installment_due_date_{{ $item->id }}"></td>
                                <td><input type="number" class="installmentFine" min="0" value="0" max="100" class="form-control" id="installment_fine_{{ $item->id }}" placeholder="Enter fine"></td>
                            </tr>
                    @endforeach
                    @else
                    <tr class="text-center">
                        <td class="text-danger" colspan="12">Please Create Installment First !!</td>
                    </tr>
                @endif
            </tbody>
        </table>
                	</div>
                </div>
                    </div>
                     
                
                
                
                 <div class="row m-2">
                    <div class="col-md-12 text-center">
                  <button type="button" id="installment_submit_button" style="display:none;" class="btn btn-primary">{{ __('messages.submit') }} </button>
                </div>
                        </div>
              </form>
                            </div>
                        </div>
                    </div>
              
              
              </div>
              
              <div class="card m-2">
                  <div class="card-body pl-0 pr-0 pt-2 pb-2">
                       <div class="col-md-12">
           <div class="col-md-12  text-left"> 
                <p class="text-danger font-weight-bold">Fees assigned to classes list :-</p>
            </div>
            <div class="row m-2">
                    <div class="col-md-12">
                        <form action="{{ url('feesMasterAdd') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Session') }}</label>
                                        <select class="form-control select2" id="session_id" name="session_id">
                                            <option value="all" {{ ($search['session_id'] ?? '') == 'all' ? 'selected' : '' }}>{{ __('common.All') }}</option>
                                            @if(!empty($getSession))
                                                @foreach($getSession as $session)
                                                    <option value="{{ $session->id ?? '' }}" {{ ($session->id == ($search['session_id'] ?? Session::get('session_id'))) ? 'selected' : '' }}>{{ $session->from_year ?? ''  }} - {{ $session->to_year ?? ''  }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('Course') }}</label>
                                        <select class="form-control select2" id="filter_course_id" name="course_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($courses))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ ($course->id == ($search['course_id'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ __('common.Class') }}</label>
                                        <select class="form-control select2" id="classTypeID" name="class_type_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($classType))
                                                @foreach($classType as $class)
                                                    <option value="{{ $class->id }}" {{ ($class->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>{{ $class->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary">{{ __('common.Search') }}</button>
                                    <a href="{{ url('feesMasterAdd') }}" class="btn btn-secondary">{{ __('common.Reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
              <div class="col-md-12">
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                  <thead>
                    <tr role="row">
                      <th>{{ __('messages.Sr.No.') }}</th>
                      <th>{{ __('messages.Class') }}</th>
                      <th>{{ __('fees.Fees Group') }}</th>
                      @if($getPermission->edit == 1)
                      <th>{{ __('messages.Action') }}</th>
                       @endif
                    </tr>
                  </thead>
                  <tbody id="">

                    @if(!empty($dataview))
                    @php
                    $i=1;
                    $masterFeesArray = [];
                    @endphp
                    @foreach ($dataview as $item)
                        @php
                            $masterFees = [];
                        @endphp
                    <tr class="all_data" data-class="{{$item->class_type_id}}">
                      <td style="padding:0px;">{{ $i++ }}</td>
                      <td style="padding:0px;">{{ $item['ClassTypes']['name'] ??'' }}</td>
                     <td style="padding:0px;">
                        <table width="100%">
                            <thead>
                                <tr style="background-color:transparent;color:black;">
                                    <th style="padding:0px;">Group</th>
                                    <th style="padding:0px;">Amount</th>
                                    <th style="padding:0px;">Due Date</th>
                                    <td style="padding:6px;"></td>
                                </tr>
                        </thead>
                        <tbody>
                            
                       
                          @php
                            $allDataQuery = DB::table('fees_master')
                            ->leftjoin('fees_group','fees_group.id','=','fees_master.fees_group_id')
                            ->select('fees_master.amount','fees_master.nri','fees_master.management','fees_master.govt','fees_group.name as fees_group_name','fees_master.id','fees_master.fees_group_id','fees_master.installment_due_date')
                            ->where('class_type_id',$item->class_type_id);

                            if (!empty($search['session_id']) && $search['session_id'] !== 'all') {
                                $allDataQuery->where('fees_master.session_id', $search['session_id']);
                            } elseif (empty($search['session_id'])) {
                                $allDataQuery->where('fees_master.session_id', Session::get('session_id'));
                            }
                            $allData = $allDataQuery->whereNull('fees_master.deleted_at')->get();
                          @endphp
                        @if(!empty($allData))
                        @foreach ($allData as $mydata)
                            @php
                            //dd($mydata);
                                $masterFees[] = $mydata->fees_group_name;
                            @endphp
                            <tr style="background-color:transparent">
                                <td style="padding:0px;">{{ $mydata->fees_group_name ?? '' }}</td>
                                <td style="padding:0px;">{{ $mydata->amount ?? '' }}</td>
                                <td style="padding:0px;">{{ !empty($mydata->installment_due_date) ? date('d-m-Y', strtotime($mydata->installment_due_date)) : '' }}</td>
                               
                                <td style="padding:0px;">
                                @php
                                $rowSessionId = $item->session_id ?? Session::get('session_id');
                                $isDeleteAllowed1 = DB::table('fees_detail')->where('fees_group_id',$mydata->fees_group_id)->where('session_id',$rowSessionId)->where('branch_id',Session::get('branch_id'))->whereNull('deleted_at')->count();
                                $isDeleteAllowed2 = DB::table('fees_assign_details')->where('class_type_id',$item['ClassTypes']['id'])->where('fees_group_id',$mydata->fees_group_id)->where('session_id',$rowSessionId)->where('branch_id',Session::get('branch_id'))->whereNull('deleted_at')->count();
                            
                                @endphp
                                
                            @if(($isDeleteAllowed1+$isDeleteAllowed2) == 0)
                                <a href="javascript:;" data-groupname='{{$mydata->id ?? ''}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData {{($getPermission->deletes == 1) ? '' : 'd-none'}}"><i class="fa fa-remove text-danger" title="Delete"></i></a>
                            @endif
                                                    </td>

                                                </tr>

                        @endforeach
                        @endif
                        </tbody>
                        </table>
                      </td>
                      @if($getPermission->edit == 1)
                      <td style="padding:0px;">
                        <a href="{{ url('feesMasterEdit') }}/{{$item['class_type_id'] ?? '' }}" class="text-success"><i class="fa fa-edit pl-2"></i></a>
                      </td>
                      @endif
                  
                    </tr>
                    @php
                        $masterFeesArray[$item->class_type_id] = $masterFees;
                    @endphp
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
                  	        <div class="col-md-12">
                    <p class="note_text text-danger">
                        <b>Note :</b> You can't delete the fees group until it is no longer in use.
                    </p>
                </div>
            </div>
        </div>
                  </div>
              </div>
                 
              

            
           
          </div>
       


      </div>
    </div>
  </section>
</div>



  <!-- Modal -->
    <div class="modal fade" id="fees_modification" tabindex="-1" aria-labelledby="feesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feesModalLabel">Modify Student Fees</h5>
                    <button type="button" class="btn btn-outline-danger btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="feesForm" class="mb-3">
                        <div class="row">
                                                 <!-- <div class="col-md-2">
									<div class="form-group">
										<label>Admission Type(Non RTE)</label>
										<select class="form-control invalid" id="admission_type_id_modify" name="admission_type_id_modify">
										
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>
									   
									</div>
								</div> -->
                            <div class="col-md-2">
                                <label for="admissionNo" class="form-label">{{ __('student.Admission No.') }}</label>
                                <input type="text" class="form-control" id="admission_modification" placeholder="Enter {{ __('student.Admission No.') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="modification_course_id" class="form-label">{{ __('Course') }}</label>
                                <select class="form-control select2" id="modification_course_id" name="modification_course_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="class" class="form-label">{{ __('common.Class') }}</label>
                                <select class="form-control select2" id="class_modification" name="class_type_id">
                                    <option value="">{{ __('messages.Select') }}</option>
                                    @if(!empty($classType))
                                    @foreach($classType as $type)
                                    <option value="{{ $type->id }}">{{ $type->name ?? '' }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="search" class="text-white form-label">Search</label>
                                <button type="button" class="btn btn-primary form-control" id="searchButton"><i class="fa fa-spinner fa-spin d-none" id="waitBtn"></i>  Search </button>
                            </div>
                            <div class="col-md-6" style="line-height:1;">
                                <small class="text-danger">1. Verify if there are any payments under the current fee head. If payments exist, modifications are not allowed.</small><br>
                                <small class="text-danger">2. There is no need to manually save changes. The system will automatically update the fees when the input field loses focus.</small>
                            </div>
                        </div>
                    </form>
                    
                    <div class='row'> 
                    
                    
                      
                    <div class='col-md-12'> 
                          
                    <table class="table table-bordered text-center padding_table " >
                        <thead style="position:sticky; top:0;">
                            <tr >
                                <th>Name</th>
                                <th>{{ __('student.Admission No.') }}</th>
                                <th>Mobile</th>
                                <th>Fees Assign Detail</th>
                                <th style="width:70px;">Discount in % | Amt.</th>
                                <th>Due Date</th>
                                <th style="width:80px;">Fine %</th>
                                <th style="width:80px;">Fees Refund </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_modification"></tbody>
                    </table>
                   
                    
                    </div>
                    <div class='col-md-5' id="feesInputsContainer"> 
                    
                    
                    </div>
                    </div>
               
                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="scrollTopButton"><i class="fa fa-arrow-up"></i> Top</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
  

<style> 
    .padding_table thead tr{
    background: #002c54;
    color:white;
}
    
.padding_table th, .padding_table td{
     padding:5px;
     font-size:14px;
     vertical-align: inherit;
}


</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

 <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                var btn = $('#searchButton');
                var admissionNo = $('#admission_modification').val();
                var classTypeId = $('#class_modification').val();
                var admission_type_id_modify = $('#admission_type_id_modify').val();

                $.ajax({
                    headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				},
                    url: '/feesModification',  // Replace with your actual route
                    method: 'Post',
                    data: {
                        admissionNo: admissionNo,
                        class_type_id: classTypeId,
                        admission_type_id_modify:admission_type_id_modify
                    },
                    beforeSend: function () {
                        $('#waitBtn').removeClass('d-none');
                    },
                    success: function(response) {
                        $('#tbody_modification').html(response);
                        $('#waitBtn').addClass('d-none');
                    },
                    error: function(xhr) {
                        alert('An error occurred:', xhr);
                        $('#waitBtn').addClass('d-none');
                    }
                }); 
            });
            
            $('#tbody_modification').on('click', '.delete_assigned', function() {
         
                var fees_assign_detail_id = $(this).data('detail_id');
                
                var currentTd = $(this);

                $.ajax({
                    headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				},
                    url: '/deleteAssignedFees',  // Replace with your actual route
                    method: 'POST',
                    data: {
                        fees_assign_detail_id: fees_assign_detail_id,
                      
                    },
                    success: function(response) {
                     currentTd.closest('td').remove();
                    },
                    error: function(xhr) {
                        alert('An error occurred:', xhr);
                    }
                }); 
            });
   
            
            
         $('#tbody_modification').on('focusout', '.fees_assign_detail', function() {
            var fees_assign_detail_id = $(this).data('detail_id');
            
            var value = $(this).val();
            var old_value = $(this).data('old_value');
            var field = $(this).attr('name');
            var discountValue = parseFloat($('#discountInAmount_' + fees_assign_detail_id).val());
            var currentTd = $(this);
            var parentTr = currentTd.closest('tr');

            function compareValues(value1, value2) {
                // Check if both values are valid dates
                const date1 = Date.parse(value1);
                const date2 = Date.parse(value2);
                
                
                if (!isNaN(date2)) {
                    // Both values are valid dates
                    return date1 !== date2;
                }
            
                // Check if both values are numbers (integer or float)
                const num1 = parseFloat(value1);
                const num2 = parseFloat(value2);
                
                if (!isNaN(num1) && !isNaN(num2)) {
                    // Both values are numbers
                    return num1 !== num2;
                }
            
                // If they are not both dates or both numbers, they are not equal
                return false;
            }
            
           
            if(field == 'fees_group_amount'){
                var pay_fees = $(this).data('pay_fees');

                if(value < pay_fees){
                    toastr.error('The student has already paid an amount of Rs '+pay_fees);
                    $(this).val(old_value);
                return
                }

            }

                if (compareValues(value, old_value) ) {
                  
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/updateAssignedFees',  // Replace with your actual route
                        method: 'POST',
                        data: {
                            fees_assign_detail_id: fees_assign_detail_id,
                            value: value,
                            field: field,
                            discountValue: discountValue
                        },
                        success: function(response) {
                            toastr.success('Fees Updated Successfully');
                            currentTd.data('old_value', value);
                            currentTd.val(value);
                        },
                        error: function(xhr) {
                            alert('An error occurred:', xhr);
                        }
                    });
                }
            });
            
            $('#tbody_modification').on('keyup', '.discountInPercent', function() {
                var discountInPercentId = $(this).data('id');
                var discountInPercent = parseFloat($(this).val());
                var feesGroupAmount = parseFloat($('#feesGroupAmount_' + discountInPercentId).val());
                var discountInAmount = (discountInPercent * feesGroupAmount) / 100;
                $('#discountInAmount_' + discountInPercentId).val(isNaN(discountInAmount) ? '' : discountInAmount.toFixed(2));
            });
            
            $("#scrollTopButton").click(function () {
                $(".modal-body").animate({ scrollTop: 0 }, "slow");
            });

        });

  $('#tbody_modification').on('click', '.add-btn', function() {
                var row = $(this).closest('tr');
                var name = row.find('td:nth-child(1)').text();
                var mobile = row.find('td:nth-child(2)').text();
                var feesDetail = `
                    <div class="fees-detail">
                        <h5>Fees for ${name} (${mobile})</h5>
                        <div class="mb-3">
                            <label for="feesName" class="form-label">Fees Name</label>
                            <input type="text" class="form-control" name="feesName[]" placeholder="Enter Fees Name">
                        </div>
                        <div class="mb-3">
                            <label for="feesAmount" class="form-label">Fees Amount</label>
                            <input type="text" class="form-control" name="feesAmount[]" placeholder="Enter Fees Amount">
                        </div>
                    </div>
                `;
                $('#feesInputsContainer').append(feesDetail);
            });
      
        function submitFeesModification() {
            // Handle the save changes button click event here
            console.log('Save changes clicked');
        }
    </script>

<script>
  $(document).ready(function() {
    count = 0;
    $(".removeprodtxtbx").eq(0).css("display", "none");
    $(document).on("click", "#clonebtn", function() {
        
      count++;
      var newRow = '<tr id="appendRow_' + count + '">'
        + '<td colspan="3">'
        + '<select class="form-control select2" id="fees_group_id" name="fees_group_id[]" Required>'
        + '<option value="">{{ __("messages.Select") }}</option>'
        + '@if(!empty($getFeesGroup))'
        + '@foreach($getFeesGroup as $type)'
        + '<option value="{{ $type->id ?? "" }}">{{ $type->name ?? "" }}</option>'
        + '@endforeach'
        + '@endif'
        + '</select>'
        + '</td>'
        + '<td colspan="3">'
        + '<input class="form-control amount_'+ count +'" type="text" name="amount[]" id="amount" Required placeholder="Amount" onkeypress="javascript:return isNumber(event)">'
        + '</td>'
        +'<td colspan="3">'
        +'<input class="form-control change_box" data-amount_id="'+ count +'" type="checkbox" name="editable[]">'
        +'<input type="hidden" class="close_edited_value" name="editable_value[]" value="0">'
        +'</td>'
        + '<td colspan="3">'
        + '<div class="action_container">'
        + '<button type="button" class="btn btn-primary btn-xs addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button>'
        + '<button type="button" class="btn btn-danger btn-xs removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button>'
        + '</div>'
        + '</td>'
        + '</tr>';

      $('#table_body').append(newRow);
      $(".removeprodtxtbx").eq(count).css("display", "block");
      $(".addmoreprodtxtbx").eq(count).css("display", "none");
      
    
    });

    $(document).on("click", "#removerow", function() {
      $(this).parents('tr').remove();
      count--;
      window.calculateSum(); // Assuming you have a function named "calculateSum" defined elsewhere.
    });
  });
  
  $(document).ready(function(){
     $('.filterData').click(function(){
        var classId = $('#classTypeID').find(':selected').val();
        var elements = $('.all_data');
        var count = elements.length;
        
        for (var i = 0; i < count; i++) {
            if(classId != ""){
            var class_type_id = elements.eq(i).data('class');
            if(class_type_id == classId){
                elements.eq(i).show();
            }else{
                elements.eq(i).hide();
            }
            }else{
                elements.eq(i).show();
            }
        }
     }); 
  });
</script>

<script>
$(document).ready(function(){
   $(document).on('click','.change_box',function(){
       var amount_id = $(this).data('amount_id');
       if($(this).prop('checked')){
           $(this).siblings('input').val(1);
           $('.amount_' + amount_id).val(0);
           $('.amount_' + amount_id).attr('type','hidden');
       }else{
           $(this).siblings('input').val(0);
           $('.amount_' + amount_id).val(0);
           $('.amount_' + amount_id).attr('type','text');
       }
   }); 
});
</script>

<script>
    $('.deleteData').click(function() {
    var delete_id = $(this).data('groupname');

    $('#delete_id').val(delete_id);
  });
</script>
<!-- The Modal -->
<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <div class="modal-header">
        <h4 class="modal-title text-white">{{ __('messages.Delete Confirmation') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <form action="{{ url('feesMasterDelete') }}" method="post">
        @csrf
        <div class="modal-body">
          <input type=hidden id="delete_id" name=delete_id>
          <h5 class="text-white">{{ __('messages.Are you sure you want to delete') }} ?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('messages.Delete') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="special_fee_modal" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Assign the amount for special Fees Groups</h4>
      </div>
      
      <form action="{{ url('specialFeesMaster') }}" method="POST" class="submit-form reload">
        @csrf
        
        <div class="modal-body">
          <div class="col-md-3">
            <div class="form-group">
              <label>{{ __('Course') }}<span style="color:red;">*</span></label>
              <select class="form-control select2" id="course_id" name="course_id">
                <option value="">{{ __('common.Select') }}</option>
                @foreach($courses as $course)
                  <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-12 overflow_scroll">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ __('fees.Fees Group') }}* &nbsp; (Type : Registration)</th>
                  <th>{{ __('NRI') }}*</th>
                  <th>{{ __('Management') }}*</th>
                  <th>{{ __('Govt.') }}*</th>
                  <th>Partial Payable (50%)</th>
                </tr>
              </thead>
              <tbody id="table_bodyregistration">
                <tr>
                  <td colspan="5" class="text-center text-muted">Please select a course to load data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-xs submit-btn">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        
      </form>
    </div>
 </div>
</div>


<div class="modal fade" id="students_list_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Assign Installment Payment to Students for the selected {{ __('common.Class') }}</h4>
            </div>
            <form id="assignFeesMultiple" action="{{ url('assignFeesMultipleStudents') }}" method="POST">
            @csrf    
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                                                 <!-- <div class="col-md-2">
									<div class="form-group">
										<label>Admission Type(Non RTE)</label>
										<select class="form-control invalid" id="admission_type_id" name="admission_type_id">
										
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>
									   
									</div>
								</div> -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Course') }}</label>
                                <select class="form-control select2" id="bulk_course_id" name="course_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('common.Class') }}</label>
                                <select class="form-control select2" id="bulk_class_type_id" name="class_type_id">
                                  <option value="">{{ __('messages.Select') }}</option>
                                  @if(!empty($classType))
                                  @foreach($classType as $type)
                                  <option value="{{ $type->id }}">{{ $type->name ?? ''  }}</option>
                                  @endforeach
                                  @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('student.Admission No.') }}</label>
                                <input type="text" class="form-control" placeholder="{{ __('student.Admission No.') }}" name="admissionNo" id="bulk_admission_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fees Master</label>
                                <select class="form-control select2" multiple id="bulk_fees_master_ids" name="fees_master_ids[]" required>
                                  <!--<option value="">{{ __('messages.Select') }}</option>-->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                        
                <div class="col-md-12 overflow_scroll">
                    <table class="table table-bordered  text-center padding_table" >
                        <thead>
                            <tr>
                                <th><input type='checkbox' id="all_students" /></th>
                                <th>Name</th>
                                <th>{{ __('student.Admission No.') }}</th>
                                <th>Mobile</th>
                                <th>Father</th>
                                <th>Assigned Fees</th>
                              
                            </tr>
                        </thead>
                        <tbody id="tbody_students_list"></tbody>
                    </table>
                </div>
                
                <div class="col-md-12">
                    <div class="note_text note">
                        <p>1. If any selected fee head is already assigned to a student, the system will skip that head and assign the remaining heads.</p>
                        <p>2. To modify a student's assigned fees, go to the fee modification area.</p>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<style>
.note{
    background-color: #9e9e9e5e;
    border-radius: 4px;
    padding: 10px;
}

.note p{
    color: red;
    font-size:12px;
    font-weight: 400;
    margin-bottom:0px;
}
.overflow_scroll{
    height:300px;
    overflow-y:scroll;
}
</style>


<script>
    function getStudents(class_type_id,bulk_admission_no,admission_type_id){
         $('#tbody_students_list').html('');
        $.ajax({
            headers: {
			    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
		    },
            url: '/getStudentsList',  // Replace with your actual route
            method: 'Post',
            data: {
                admissionNo:bulk_admission_no,
                class_type_id:class_type_id,
                admission_type_id:admission_type_id
            },
            success: function(response) {
                $('#tbody_students_list').html(response);
                $('#all_students').prop('checked',false);
                $('#bulk_class_type_id').val(class_type_id);
            },
            error: function(xhr) {
                console.log('An error occurred:', xhr);
            }
        });
    }
    
    function getMasterData(class_type_id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: '/getMasterData',  // Replace with your actual route
            method: 'POST',
            data: {
                class_type_id: class_type_id
            },
            success: function(response) {
                var masterData = [];
                if(response.length != 0){
                    $('#bulk_fees_master_ids').html("");
                        
                    for(var i = 0; i < response.length; i++){
                        var code = '<option value="'+ response[i].id +'">'+ response[i].fees_group_name +'</option>'; // Corrected quote
                        masterData.push(code); 
                    }
                    if(masterData.length > 0){
                     $('#bulk_fees_master_ids').html(masterData.join(''));   
                    }
                    
                     
                }
            },
            error: function(xhr) {
                console.log('An error occurred:', xhr);
            }
        });
    }
        
        
const installmentNamesToCheck = @json($feesGroupInstallmentsList);

document.getElementById('previewBtn').addEventListener('click', function() {
    let hasError = false;

    // Get values from inputs
    const totalAmount = parseInt(document.getElementById('totalAmount').value);
    // const installmentFrequency = parseInt(document.getElementById('frequency').value);
    const installmentFrequency = 1;
    const classTypeId = document.getElementById('installment_class_type_id').value;
    let dueDay = parseInt(document.getElementById('due_date_on_every').value);
    
    const numInstallments = $('.select_checkbox:checkbox:checked').length;
    const installmentNamesToCheckLength = installmentNamesToCheck.length;
    const installmentAmount = Math.floor(totalAmount / numInstallments);
    const remainder = totalAmount % numInstallments;
    const fullMonthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    if(installmentNamesToCheckLength === 0){
        toastr.error("Please Create Installment First !!");
        return;
    }

    if (classTypeId === "") {
        toastr.error("Please Select Class");
        $('#installment_class_type_id').focus();
        return;
    }
    
    if (isNaN(totalAmount)) {
        toastr.error("Please Enter Amount");
        $('#totalAmount').focus();
        return;
    }
    
    $('#installments_data').show();

    const errorNotification = document.getElementById('errorNotification');
    errorNotification.style.display = 'none';
    errorNotification.innerHTML = '';
    
    const checkedCheckboxes = $('.select_checkbox:checkbox:checked');
    
    $('.amountInstallment').val("");
    $('.installmentMonth').val("Jan");
    $('.installmentDueDate').val("");
    $('.installmentFine').val(0);
    
    for (let i = 0; i < numInstallments; i++) {
        let amount = installmentAmount;
        if (i < remainder) {
            amount += 1;
        }

        let selectedMonthIndex = (i * installmentFrequency) % 12;
        let month = fullMonthList[selectedMonthIndex];

        let year = new Date().getFullYear();
        let monthIndex = selectedMonthIndex + 1;

        let nextMonth = new Date(year, monthIndex, 1);
        nextMonth.setDate(0);
        let lastDayOfMonth = nextMonth.getDate();

        if (dueDay > lastDayOfMonth) {
            dueDay = lastDayOfMonth;
        }

        let monthStr = monthIndex.toString().padStart(2, '0');
        let dueDate = `${year}-${monthStr}-${dueDay.toString().padStart(2, '0')}`;

        let installmentName = `Installment ${i + 1}`;
        let rowClass = '';

        if (installmentNamesToCheck.includes(installmentName)) {
            rowClass = 'class="bg-danger"';
            hasError = true;
        }
        
        var row_id = checkedCheckboxes.eq(i).val();
        
        $('#installment_amount_' + row_id).val(amount);
        $('#installment_due_date_' + row_id).val(dueDate);
        $('#installment_month_' + row_id).val(month);
    }

    if (hasError) {
        errorNotification.innerHTML = `Note: One or more installment names match the restricted list. Please review the highlighted rows.<br>
        Caution: Proceeding will override the existing data with the new entries.`;
        errorNotification.style.display = 'block';
    }
});

</script>

<script>
$(document).ready(function(){
    var formSubmit = true;
    
    $('#students_list_modal').modal({
        backdrop: 'static',
        keyboard: false
    });

    $('#select_all').click(function(){
        if($(this).prop('checked')){
            $('.select_checkbox').prop('checked',true);
            $('#installment_submit_button').show();
        } else {
            $('.select_checkbox').prop('checked',false);
            $('#installment_submit_button').hide();
        }
        
        $('#previewBtn').click();
    });
    
    $(document).on('click', '.select_checkbox', function(){
        $('#previewBtn').click();
        var total_checkbox_count = $('.select_checkbox').length;
        var total_checked_checkbox_count = $('.select_checkbox:checkbox:checked').length;
        if(total_checkbox_count === total_checked_checkbox_count){
            $('#select_all').prop('checked',true);
            $('#installment_submit_button').show();
        } else {
            $('#select_all').prop('checked',false);
            $('#installment_submit_button').hide();
        }
        
        if(total_checked_checkbox_count === 0){
            $('#installment_submit_button').hide();
        } else {
            $('#installment_submit_button').show();
        }
    });
    
    $('#installment_submit_button').click(function(){
        formSubmit = true;
        $('.amountInstallment, .installmentName, .installmentId, .installmentMonth, .installmentDueDate, .installmentFine').removeAttr('name');
        var total_checked_checkbox_count = $('.select_checkbox:checkbox:checked').length;
        const checkedCheckboxes = $('.select_checkbox:checkbox:checked');
        
        const checkboxes = document.querySelectorAll('.select_checkbox');

        let checkedValues = [];
        
        checkboxes.forEach(checkbox => {
          if (checkbox.checked) {
            const tr = checkbox.closest('tr');
            const installElements = tr.querySelectorAll('.install');
            Array.from(installElements).forEach(element => {
              checkedValues.push(element.value);
            });
        }
        });
        
        var installMentClass = $('#installment_class_type_id').val();
        
        var masterFeesArray = @json($masterFeesArray);
        var installmentArray = masterFeesArray[installMentClass];
          
        var matchedValues = checkedValues.filter(function(value) {
            return $.inArray(value, installmentArray) !== -1;
        });
        
        if(matchedValues != ""){
            formSubmit = false;
        }
        
        for(var l = 0; l < total_checked_checkbox_count; l++){
            var row_id = checkedCheckboxes.eq(l).val();
            
            $('#installment_amount_' + row_id).attr('name', 'installment_value[]');
            $('#installment_due_date_' + row_id).attr('name', 'installment_due_date[]');
            $('#installment_month_' + row_id).attr('name', 'installment_month[]');
            $('#installment_name_' + row_id).attr('name', 'installment_name[]');
            $('#installment_id_' + row_id).attr('name', 'installment_id[]');
            $('#installment_fine_' + row_id).attr('name', 'installment_fine[]');
        }
        
        var formData = $('#installment_form').serialize();
        
        if(formSubmit){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: '/createFeesInstallmentClassWise',  // Replace with your actual route
            method: 'POST',
            data: JSON.stringify(formData),
            success: function(response) {
                toastr.success("Fees Master Created Successfully");
                window.location.reload();
                // if(response.entry == true){
                //     toastr.success("Fees Master Created Successfully");
                //     var classTypeId = response.class_type_id;
                //     getStudents(classTypeId, null);
                //     setTimeout(function() {
                //          $('#students_list_modal').modal('show');
                //     }, 800);
                // }else{
                //     toastr.success("Fees Master Created Successfully");
                // }
            },
            error: function(xhr) {
                console.log('An error occurred:', xhr);
            }
        });
    }else{
        toastr.error('Verify if there are any payments under the current fee head. If payments exist, modifications are not allowed.');
    }
            
    });
});


    $(document).ready(function(){
        $('#all_students').click(function(){
            if($(this).prop('checked')){
                $('.student_select_checkbox').prop('checked',true);
            }else{
                $('.student_select_checkbox').prop('checked',false);
            }  
        });
        
        $(document).on('click','.student_select_checkbox',function(){
            var total_checkbox_count = $('.student_select_checkbox').length;
            var total_checked_checkbox_count = $('.student_select_checkbox:checkbox:checked').length;
            if(total_checkbox_count == total_checked_checkbox_count){
                $('#all_students').prop('checked',true);
            }else{
                $('#all_students').prop('checked',false);
            }
        });
        
        $('#admission_type_id').change(function() {
            
            $('#bulk_class_type_id').trigger('change');
        });
        $('#bulk_class_type_id').change(function() {
           var class_type_id = $('#bulk_class_type_id').val();
           var bulk_admission_no = $('#bulk_admission_no').val();
           var admission_type_id = $('#admission_type_id').val();
            
            if(class_type_id == ""){
                toastr.error('plaase Select Class');
                $('#tbody_students_list').html("");
                $('#bulk_fees_master_ids').html("");
            }else{
                getStudents(class_type_id,bulk_admission_no,admission_type_id);       
                getMasterData(class_type_id);
            }
        });
        $('#bulk_admission_no').blur(function() {
           var class_type_id = $('#bulk_class_type_id').val();
           var bulk_admission_no = $('#bulk_admission_no').val();
             var admission_type_id = $('#admission_type_id').val();
            getStudents(class_type_id,bulk_admission_no,admission_type_id);   
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#assignFeesMultiple').on('submit', function(event){
           event.preventDefault();
           
           var checkedCount = $('.student_select_checkbox:checkbox:checked').length;
           
           if(checkedCount == 0){
               toastr.error("Please select students");
           }else{
               document.getElementById('assignFeesMultiple').submit();
           }
           
       }); 
    });

    function updateRefundFees(checkbox, id) {
    const hiddenInput = document.getElementById('refund_fees_value_' + id);
    if (checkbox.checked) {
        hiddenInput.value = 'yes';
    } else {
        hiddenInput.value = 'no';
    }
    saveRefundFees(id, hiddenInput.value); // Call the save function
}

// Move saveRefundFees outside $(document).ready() to make it accessible globally
function saveRefundFees(id, value) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        url: '/updateAssignedFees', // Replace with your actual route
        method: 'POST',
        data: {
            fees_assign_detail_id: id,
            value: value,
            field: 'fees_refund'
        },
        success: function(response) {
            toastr.success('Fees Updated Successfully');
        },
        error: function(xhr) {
            console.log('An error occurred:', xhr);
        }
    });
}



</script>

<script>
$(document).ready(function() {
    function updateClassDropdownByCourse(courseId, classSelect, defaultClasses) {
        if (courseId) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course_id: courseId },
                dataType: "json",
                success: function(data) {
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
                },
                error: function() {
                    classSelect.empty();
                    classSelect.append('<option value="">{{ __("common.Select") }}</option>');
                    if (classSelect.hasClass("select2-hidden-accessible")) {
                        classSelect.select2('destroy');
                    }
                    classSelect.select2();
                    classSelect.val('').trigger('change');
                }
            });
        } else {
            classSelect.empty();
            classSelect.append('<option value="">{{ __("common.Select") }}</option>');
            if (defaultClasses && defaultClasses.length > 0) {
                $.each(defaultClasses, function(key, val) {
                    classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
            if (classSelect.hasClass("select2-hidden-accessible")) {
                classSelect.select2('destroy');
            }
            classSelect.select2();
            classSelect.val('').trigger('change');
        }
    }

    var allDefaultClasses = [
        @if(!empty($allClassType))
            @foreach($allClassType as $type)
                { id: "{{ $type->id }}", name: "{{ $type->name }}" },
            @endforeach
        @endif
    ];

    $(document).on('change', '#assign_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#class_type_id'), allDefaultClasses);
    });

    $(document).on('change', '#filter_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#classTypeID'), allDefaultClasses);
    });

    $(document).on('change', '#bulk_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#bulk_class_type_id'), allDefaultClasses);
    });

    $(document).on('change', '#modification_course_id', function() {
        updateClassDropdownByCourse($(this).val(), $('#class_modification'), allDefaultClasses);
    });

    $("#course_id").change(function() {
        var course_id = $(this).val();
        if(course_id) {
            $("#table_bodyregistration").html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('specialFeesMastercourseData') }}",
                type: 'POST',
                dataType: 'json',
                data: { course_id: course_id },
                success: function(response) {
                    $("#table_bodyregistration").html(response.html);
                },
                error: function() {
                    $("#table_bodyregistration").html('<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>');
                }
            });
        } else {
            $("#table_bodyregistration").html('<tr><td colspan="4" class="text-center text-muted">Please select a course to load data</td></tr>');
        }
    });
});
</script>
@endsection