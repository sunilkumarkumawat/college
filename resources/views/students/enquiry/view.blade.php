@php
  $getCourses = Helper::getCourses();
  $classType = Helper::classType();
  $getState = Helper::getState();
  $getCity = Helper::getCity();
  $getCountry = Helper::getCountry();
  $getPermission = Helper::getPermission();
  $getEnquiryStatus = Helper::getEnquiryStatus();
  $getSession = Helper::getSession();
@endphp
@extends('layout.app') 
@section('content')



<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12"> 
            <div class="card  card-outline card-orange">
             <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp; {{ __('student.View Students Enquiry') }} </h3>
            <div class="card-tools">
            <!--<a class="btn btn-danger" href="{{url('enquiry_qr_generate')}}"><i class="fa fa-download"></i> {{ __('Enquiry QR') }}</a>-->
            <a href="{{url('enquiryAdd')}}" class="btn btn-primary  btn-sm {{($getPermission->add == 1) ? '' : 'd-none'}}" ><i class="fa fa-plus"></i>{{ __('common.Add') }}</a>
            <a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
          
            </div>
            
            </div>                 
        <form id="quickForm" action="{{ url('enquiryView') }}" method="post" >
                        @csrf 
            <div class="row m-2">
            	<div class="col-md-2 d-none">
            		<div class="form-group"> 
            			<label for="State" class="required">{{ __('common.State') }}</label>
            			<select class="form-control  select2" id="state_id" name="state_id" >
                        <option value="">{{ __('common.Select') }}</option>
                    @if(!empty($getState)) 
                          @foreach($getState as $state)
                             <option value="{{ $state->id ?? ''}}" {{ ($state->id == ($search['state_id'] ?? '')) ? 'selected' : '' }}>{{ $state->name ?? ''}}</option>
                          @endforeach
                    @endif
                      
                        </select>
            		
            		</div>
            	</div>
            	<div class="col-md-2 d-none">
            	    <div class="form-group">
            	        <label for="City">{{ __('common.City') }}</label>
            	        <select class="select2 form-control" name="city_id" id="city_id" >
            	        <option value="">{{ __('common.Select') }}</option>      
            	            @if(!empty($getCity)) 
                          @foreach($getCity as $cities)
                             <option value="{{ $cities->id ?? ''}}" {{ ($cities->id == ($search['city_id'] ?? '')) ? 'selected' : '' }}>{{ $cities->name ?? ''  }}</option>
                          @endforeach
                       @endif
            			</select>
            	    </div>
            	</div>
                <div class="col-md-2 col-6">
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
                <div class="col-md-2 col-6">
            		<div class="form-group">
            			<label>{{ __('Course') }}</label>
            			<select class="select2 form-control" id="course_id" name="course_id" >
            			<option value="">{{ __('common.Select') }}</option>
                         @if(!empty($getCourses)) 
                              @foreach($getCourses as $course)
                                 <option value="{{ $course->id }}" {{ ($course->id == ($search['course_id'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? ''  }}</option>
                              @endforeach
                          @endif
                        </select>
            	    </div>
            	</div>
                <div class="col-md-2 col-6">
            		<div class="form-group">
            			<label>{{ __('Class / Semester') }}</label>
            			<select class="select2 form-control" id="class_type_id" name="class_type_id" >
            			<option value="">{{ __('common.Select') }}</option>
                         @if(!empty($classType)) 
                              @foreach($classType as $type)
                                 @if(empty($search['course_id']) || $type->course_id == $search['course_id'])
                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                 @endif
                              @endforeach
                          @endif
                        </select>
            	    </div>
            	</div>

			    <div class="col-md-2 col-6">    
                    <div class="form-group">
                        <label>{{ __('status') }}</label>
                        <select class="select2 form-control" id="enquiry_status" name="enquiry_status">
                            <option value="">{{ __('common.Select') }}</option>
                            @if(!empty($getEnquiryStatus))
                            @foreach($getEnquiryStatus as $type)
                            <option value="{{ $type->id ?? ''  }}" {{ ($type->id == ($search['enquiry_status'] ?? '')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-1 col-6">    
                    <div class="form-group">
                        <label>{{ __('Reminder Date') }}</label>
                        <input type="date" class="form-control" id="reminder_date" name="reminder_date" value="{{$search['reminder_date'] ?? '' }}">	
                    </div>
            	</div> 
        		<div class="col-md-2 col-6">
        			<div class="form-group">
        				<label>{{ __('common.Search By Keywords') }}</label>
        				<input type="text" class="form-control" id="name" name="name" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}">
        		    </div>
        		</div> 
                <div class="col-md-1 col-6">
                    <div class="form-group">
                        <label for="" class="text-white d-block">{{ __('common.Select') }}</label>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">{{ __('common.Search') }}</button>
                            <button type="submit" name="pdf" value="pdf" class="btn btn-primary {{($getPermission->download == 1) ? '' : 'd-none'}}">{{ __('common.Pdf') }}</button>
                        </div>
                    </div>
            	</div>
            </div>
        </form>

        <div class="row m-2">
          <div class="col-12">
           
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                  <thead>
                  <tr role="row">
                      <th>{{ __('common.SR.NO') }}</th>
                      <th>{{ __('student.Reg.No.') }}</th>
                       <th>{{ __('common.Name') }}</th>
                        <th>{{ __('common.Mobile No.') }}</th>
                       <th>{{ __('Course') }}</th>
                       <th>{{ __('Class / Semester') }}</th>
                      <th>{{ __('common.F Name') }}</th>
                      <th>{{ __('student.Reg.\Date') }}</th>
                      <th>{{ __('Message') }}</th>
                      <th>{{ __('Status') }}</th>
                        @if($getPermission->download == 1 || $getPermission->edit == 1 || $getPermission->deletes == 1)   
                          <th>{{ __('common.Action') }}</th>
                        @endif
                      </tr>
                  </thead>
                  <tbody class="product_list_show">
                  
                      @if(!empty($data))
                            @php
                           // dd($data);
                               $i=1
                            @endphp
                            @foreach ($data  as $item)
                          <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item['registration_no'] ?? ''  }}</td>
                                <td>{{ $item['first_name'] ?? ''  }} {{ $item['last_name'] ?? ''  }}</td>
                                <td class="editable"  data-id="{{$item->id ?? ''}}" data-field="mobile" data-modal='Enquiry'>{{ $item['mobile'] ?? ''  }}</td>
                                <td><span class="badge badge-primary">{{ $item['course_name'] ?? '-' }}</span></td>
                                <td>{{ $item['class_name'] ?? '' }}</td>
                                <td>{{ $item['father_name'] ?? ''  }}</td>
                                <td>{{date('d-M-Y', strtotime($item['registration_date'])) ?? '' }}</td>
                                <td title="{{$item['message'] ?? ''}}">
                                     @if(!empty($item['message']))
                                   {{ strlen($item['message'] ?? '') > 10 ? substr($item['message'], 0, 10) . '...' : ($item['message'] ?? '') }}
                                    @else
                                    -
                                    @endif
                                   
                                    </td>
                                @php
                                $enquiry = DB::table('enquiry_status')->where('id',$item->enquiry_status)->whereNull('deleted_at')->first();
                             
                                @endphp
                                <td>{{$enquiry->name ?? '-'}}</td>
                              
                                @if($getPermission->download == 1 || $getPermission->edit == 1 || $getPermission->deletes == 1)
                                <td style="width: 18%;">
                                    @if($getPermission->download == 1)
                                    <a href="{{url('registrationPrint')}}/{{$item->id}}" target="blank" class="btn btn-primary  btn-xs" title=" Registration Print"><i class="fa fa-print"></i></a>
                                    @endif
                                    @if($getPermission->edit == 1)
                                    <a href="javascript:;"  data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#remark_id"  class="remark btn btn-primary  btn-xs ml-3 m-2 " title="Remark Student Registration"><i class="fa fa-bell"></i></a>                                      
                                    <a href="{{url('enquiryEdit',$item->id)}}" class="btn btn-primary  btn-xs ml-3" title="Edit Student Registration"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if($getPermission->deletes == 1)
                                    <a href="javascript:;"  data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id"  class="deleteData btn btn-primary  btn-xs ml-3" title="Delete Student Registration"><i class="fa fa-trash-o"></i></a>  
                                    @endif
                                    <a href="{{url('studentRegistrationDetail',$item->id)}}" class="btn btn-primary  btn-xs ml-3" title="View Student Registration"><i class="fa fa-eye"></i></a>  
                                </td>
                                @endif
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


    <!-- The Modal -->
<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <!-- Modal body -->
      <form action="{{ url('enquiryDelete') }}" method="post">
              	 @csrf
      <div class="modal-body">
              
            
            
              <input type=hidden id="delete_id" name=delete_id>
              <h5 class="text-white">{{ __('common.Are you sure you want to delete') }}?</h5>
           
      </div>

      <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
         </div>
       </form>

    </div>
  </div>
</div>


<div class="modal" id="remark_id">
  <div class="modal-dialog">
    <div class="modal-content mod_siz">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"> {{ __('student.Remark Add') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>

      </div>

      <!-- Modal body -->
      <form action="{{ url('enquiryRemarkAdd') }}" method="post">
              	 @csrf
				 <input type="hidden" id="student_id" name="student_id" value="">
				   <div class="row p-3">
            	<div class="col-md-6">    
            	 <label class="text-danger">{{ __('Reminder Date') }}</label>
            		<input type="date" class="form-control input-radius @error('date') is-invalid @enderror" id="date" placeholder="Date" name="date" value="{{date('Y-m-d')}}">	
					                        
            		</div>                 
            	               
            	        <div class="col-md-6">    
                        	 <label class="text-danger">{{ __('Status') }}</label>
                        	 <select class="select2  form-control" id="enquiry_status_id" name="enquiry_status_id">
                            <option value="">{{ __('common.Select') }}</option>
                            @if(!empty($getEnquiryStatus))
                            @foreach($getEnquiryStatus as $type)
                            <option value="{{ $type->id ?? ''  }}">{{ $type->name ?? ''  }}</option>
                            @endforeach
                            @endif
                        </select>
                        </div>                 
                       
            	        <div class="col-md-6">    
                        	 <label class="text-danger">{{ __('student.Remark') }}</label>
                                <textarea id="remark" name="remark"class="form-control" rows="4" cols="50" required></textarea>

                        </div>                 
							</div>														
            					<div class="text-center col-md-12">
            					    

            				 <button type="submit" class="btn btn-primary mt-5 " id="submitButton">{{ __('common.Submit') }}</button>
                            
            			</div>
            		</form>

    </div>
  </div>
</div>


<!--<div class="modal fade" id="statusEnquiry">-->
<!--    <div class="modal-dialog modal-dialog-centered">-->
<!--      <div class="modal-content">-->
<!--        <div class="modal-header">-->
<!--          <h4 class="modal-title">Give Message</h4>-->
<!--          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>-->
<!--        </div>-->
<!--       <form id="quickForm" action="{{ url('enquiry_status_update') }}" method="post" >-->
<!--        @csrf-->
<!--        <div class="modal-body">-->
<!--            <input type="hidden" id="admission_id" name="admission_id">-->
<!--            <input type="hidden" id="status" name="status">-->
<!--            <div class="form-group">-->
<!--                <label>Reminder Date</label>-->
<!--                <div id="reminderrrr">-->
                    
<!--                </div>-->
                
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label>Message</label>-->
<!--                <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message"></textarea>-->
<!--            </div>-->
<!--        </div>-->
        
<!--        <div class="modal-footer">-->
<!--          <button type="submit" class="btn btn-primary">Submit</button>-->
<!--          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
<!--        </div>-->
<!--        </form>-->
        
<!--      </div>-->
<!--    </div>-->
<!--</div>-->

<script>
    $(document).ready(function(){
       $('.statusEnquiry').change(function(){
           var status = $(this).find(':selected').val();
           var status_html = $(this).find(':selected').html();
           if(status_html != "Select"){
                var add_id = $(this).data('admission_id');
                var message = $(this).data('message');
                var reminder_date = $(this).data('reminder_date');
                var momentDate = moment(reminder_date, 'DD-MM-YY hh:mm A');
                var formattedDate = momentDate.format('YYYY-MM-DDTHH:mm');
                var inputes = "<input type='datetime-local' class='form-control' id='reminderDate' name='reminder_date' value='"+ formattedDate +"'>"
               $('#reminderrrr').html(inputes);
               $('#status').val(status);
               $('#admission_id').val(add_id);
               $('#message').val(message);
               $('#statusEnquiry').modal('show');
           }
       }); 

       $('.deleteData').click(function() {
           var delete_id = $(this).data('id'); 
           $('#delete_id').val(delete_id); 
       });

       $(".remark").click(function(){
           var student_id = $(this).data('id');
           $("#student_id").val(student_id);
       });

       // Dynamic Course-dependent Classes / Semesters loader
       $(document).on('change', '#course_id', function() {
           var courseId = $(this).val();
           var classSelect = $('#class_type_id');
           
           classSelect.empty();
           classSelect.append('<option value="">{{ __("common.Select") }}</option>');
           
           if (courseId) {
               $.ajax({
                   url: "{{ url('getClassesByCourse') }}",
                   type: "GET",
                   data: { course_id: courseId },
                   dataType: "json",
                   success: function(data) {
                       if (data && data.length > 0) {
                           $.each(data, function(key, val) {
                               classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
                           });
                       }
                       classSelect.trigger('change');
                   },
                   error: function() {
                       classSelect.trigger('change');
                   }
               });
           } else {
               @if(!empty($classType))
                   @foreach($classType as $type)
                       classSelect.append('<option value="{{ $type->id ?? '' }}">{{ $type->name ?? '' }}</option>');
                   @endforeach
               @endif
               classSelect.trigger('change');
           }
       });
    });
</script>

<style>
    .mod_siz{
        width: 136%;
height: 370px;
    }
    .padding_table thead tr{
    background: #002c54;
    color:white;
    }
        
    .padding_table th, .padding_table td{
         padding:5px;
         font-size:14px;
    }
</style>

@endsection    
