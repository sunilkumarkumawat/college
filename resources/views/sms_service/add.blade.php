@php
$getRole = Helper::roleType();
$getCourses = Helper::getCourses();
$classType = Helper::classType();
$getSession = Helper::getSession();
@endphp
@extends('layout.app') 
@section('content')

                                                                  
<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12">
    <div class="card card-outline card-orange">
        	<div class="card-header bg-primary">
                        					    
							<h3 class="card-title"><i class="fa fa-whatsapp"></i> &nbsp;Send WhatsApp</h3>
						
							<div class="card-tools"> 
							@if(Session::get('role_id') !== 3)
							    <a href="{{url('send_message_terminal')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a> 
                            @endif
                                
                            </div>
						</div>
						
                 
        <section class="content">
            <div class="container-fluid">
                <div class="row m-2">
                    <div class="col-md-12 title"><h5 class="text-danger">{{ __('smsService.Select Candidates') }} :-</h5></div>
                    <div class="col-md-3 col-6">
                		<div class="form-group">
                			<label style="color:red;">{{ __('messages.Select') }}*</label>
                			<select class="form-control select2" id="role" name="role">
                			<option value="">{{ __('messages.Select') }}</option>
                              @if(!empty($getRole))
                                @foreach($getRole as $value)
                                @if (in_array($value->id, [1,2]))
                                @else
                                    <option value="{{ $value->id ?? ''  }}">{{ $value->name ?? ''  }}</option>
                                @endif
                                @endforeach
                                 <!--<option value="1001">Enquiry Students</option>-->
                                 <option value="1002">Single Number</option>
                              @endif

                            </select>
                	    </div>
                	</div>

                    <div class="col-md-2 col-6 student_filter_fields" style="display:none">
                		<div class="form-group">
                			<label>{{ __('Session') }}</label>
                			<select class="form-control select2" id="session_id" name="session_id">
                                <option value="">{{ __('common.All') }}</option>
                                @if(!empty($getSession))
                                    @foreach($getSession as $s)
                                        <option value="{{ $s->id }}" {{ ($s->id == Session::get('session_id')) ? 'selected' : '' }}>
                                            {{ $s->from_year }}-{{ $s->to_year }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                	    </div>
                	</div>

                    <div class="col-md-3 col-6 student_filter_fields" style="display:none">
                		<div class="form-group">
                			<label>{{ __('Course') }}</label>
                			<select class="form-control select2" id="course_id" name="course_id">
                                <option value="">{{ __('common.All') }}</option>
                                @if(!empty($getCourses))
                                    @foreach($getCourses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                	    </div>
                	</div>
                       	
                    <div class="col-md-3 col-6 student_filter_fields" style="display:none">
                		<div class="form-group">
                			<label>{{ __('Class / Semester') }}</label>
                			<select class="form-control select2" id="class_type_id" name="class_type_id" >
                			<option value="">{{ __('common.All') }}</option>
                             @if(!empty($classType)) 
                                  @foreach($classType as $type)
                                     <option value="{{ $type->id ?? ''  }}">{{ $type->name ?? ''  }}</option>
                                  @endforeach
                              @endif
                            </select>
                	    </div>
                	</div> 
                	
                    <div class="col-md-1 col-6" id="search_div">
                         <label class="text-white d-block">{{ __('messages.Search') }}</label>
                	    <button type="button" class="btn btn-primary" onclick="SearchValue()">{{ __('smsService.Search') }}</button>
                	</div>
                </div>
      
        </section>
        <section>
         <form id="sendSms" action="{{ url('send_message') }}" method="post" enctype='multipart/form-data'>   
            @csrf
    
                <div class="row m-2">
                    <div class="col-md-12" id="student_list_show" style="height: 210px; overflow-y: scroll;">

                    </div>
                </div>
         </section>
            <div id="chcekshow" class="d-none">
            <hr>
            <div class="row m-2">
                <div class="col-md-12 single_mobile_number" style="display:none">
                    <div class="row mb-3">
                        <div class="col-md-3">
                    		<div class="form-group">
                    			<label>Mobile Number</label>
                    			<input type='text' class="form-control" placeholder="Mobile No." maxlength="10" id="single_mobile_number" name="single_mobile_number" />
                    	    </div>
                	    </div>
                	    
                        <div class="col-md-3 d-none">
                    		<div class="form-group">
                    			<label>Email</label>
                    			<input type='email' class="form-control" placeholder="Email" id="single_email" name="single_email" />
                    	    </div>
                	    </div>
                    </div>
                </div>
                <div class=" col-md-12 title">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="text-danger">{{ __('smsService.Message Details') }}:-</h5>
                        </div>
                        
                        <div class="col-md-9">
                             <div class="row">
                                <!--<div class="col-md-3">-->
                                <!--    <div class="form-group clearfix">-->
                                <!--        <div class="icheck-primary d-inline">-->
                                <!--            <input type="checkbox" class="check_fills" data-label="for_email" id="email_checkbox" name="email_checkbox">-->
                                <!--            <label for="email_checkbox">Email</label>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                            <input type="checkbox" class="check_fills" data-label="for_mob" id="whatsapp_checkbox" name="whatsapp_checkbox">
                                            <label for="whatsapp_checkbox">Whatsapp</label>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-3">-->
                                <!--    <div class="form-group clearfix">-->
                                <!--        <div class="icheck-danger d-inline">-->
                                <!--            <input type="checkbox" class="check_fills" data-label="for_mob" id="sms_checkbox" name="sms_checkbox">-->
                                <!--            <label for="sms_checkbox">Sms</label>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    </div>
        
        	    <input type="hidden" id="role_id__" name="role_id">
        		<div class="col-md-6">
        	    	<div class="form-group">
        				<label style="color:black;">{{ __('smsService.Message') }}</label>
        				<textarea id="message_box" placeholder="Message" name="message" rows="6" class="form-control">{{ old('message') ?? '' }}</textarea>
        				   
                        <div id="count">{{ __('smsService.Total Characters') }}: <span id="current_count">0</span></div>        				    
        		    </div>
        	    </div>
        	<div class="col-md-12">
        	    	<div class="form-group">
        				<label style="colo:black">{{ __('Attachment') }}</label></br>
        				<input id='attachment_box'type='file' name='file'  />   				    
        		    </div>
        	    </div>
        	</div>
        	

            <div class="row m-2">
                <div class="col-md-12 text-center pb-2">
                    <button type="button" id="submit" class="btn btn-primary">{{ __('messages.Send Message') }}</button>
                </div>
                <div class="col-md-12 text-right pb-2">
                    <button type="submit" id="submit2" style="opacity:0"></button>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</section>
</div>

<script src="https://demo.smart-school.in/backend/plugins/ckeditor/ckeditor.js"></script>

<script>
    var baseurl = "https://www.school.rukmanisoftware.com/";
    CKEDITOR.replace(ckeditor, {
      toolbar: 'Ques',    
      allowedContent : true,              
      extraPlugins: 'ckeditor_wiris',
      enterMode : CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P,
      customConfig: baseurl+'public/assets/school/js/ckeditor_config.js'
    });
</script>



<script type="text/javascript">
$('textarea').keyup(function() {    
    var characterCount = $(this).val().length,
        current_count = $('#current_count'),
        count = $('#count');    
        current_count.text(characterCount);        
});

    function SearchValue() {
        var role_id = $('#role :selected').val();
        var session_id = $('#session_id :selected').val();
        var course_id = $('#course_id :selected').val();
        var class_type_id = $('#class_type_id :selected').val();
        if(role_id > 0){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                type:'post',
                url: '{{ url("sms_search_data") }}',
                data: {
                    role_id: role_id,
                    session_id: session_id,
                    course_id: course_id,
                    class_type_id: class_type_id
                },
                success: function (data) {
                    $('#student_list_show').html(data);
                    $('#chcekshow').removeClass('d-none');
                },
                error: function () {
                    toastr.error('Error fetching data !');
                }
            });
        }else{
            toastr.error('Please select a Candidate Type !');
        }               
    };

</script>

<script>
    $(document).ready(function(){
        $('#submit').click(function(event){
            event.preventDefault();
            var role_id = $('#role').val();
            $('#role_id__').val(role_id);
            var checked_length = $('.check_fills:checked').length;
            if(checked_length != 0){
                $('#submit2').click();
            }else{
                toastr.error('Please select at least 1 Message Service.');
            }
        });
    });

$(document).ready(function() {
    $('#role').change(function() {
        $('.check_fills').prop('checked',false);
        var selectedRole = $(this).val();
        if (selectedRole === '3' || selectedRole === '1001') {
            $('.student_filter_fields').show();
            $('.single_mobile_number').hide();
        }
        else if(selectedRole === '1002') {
            $('.single_mobile_number').show();
            $('#student_list_show').html("");
            $('.student_filter_fields').hide();
            $('#search_div').hide();
            $('#chcekshow').removeClass('d-none');
        }
        else {
            $('.student_filter_fields').hide();
            $('.single_mobile_number').hide();
            $('#search_div').show();
        }
    });

    // Dynamic Course-dependent Classes loader
    $(document).on('change', '#course_id', function() {
        var courseId = $(this).val();
        var classSelect = $('#class_type_id');
        
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.All") }}</option>');
        
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

<script>
    
     $("#sendSms").submit(function (e) {
     
     var attachment = $('#attachment_box').val();
     var message = $('#message_box').val();
     
     var count = 1;
     if(attachment == '' && message == '')
     {
         count = 0;
     }
     
     
     if(count == 0)
     {
             e.preventDefault();
         toastr.error('You have to select message or attachment')
     }
    
});


$(document).ready(function(){
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    $('#single_email').on('keyup',function(){
        $('#email_checkbox').prop('checked',false);
    });
    
    $('#single_mobile_number').on('keyup',function(){
        $('#whatsapp_checkbox').prop('checked',false);
        $('#sms_checkbox').prop('checked',false);
    });

   $('.check_fills').change(function(){
       if($('#role').val() == "1002"){
           var label = $(this).data('label');
            if(label == "for_email"){
                if ($(this).is(':checked')) {
                    var email = $('#single_email').val();
                    if(email == ""){
                        toastr.error('Email Can Not Be left Blank');
                        $(this).prop('checked',false);
                    }else if (!isValidEmail(email)) {
                        toastr.error('Invalid Email Address');
                        $(this).prop('checked',false);
                    }
                }
            }else{
                if ($(this).is(':checked')) {
                    var mobile_no = $('#single_mobile_number').val();
                    if(mobile_no == ""){
                        toastr.error('Mobile No. Can Not Be left Blank');
                        $(this).prop('checked',false);
                    }else if(mobile_no.length < 10){
                        toastr.error('Mobile No. Must Be 10 Digit');
                        $(this).prop('checked',false);
                    }
                }
            }
       }
       
   }); 
});
</script>

@endsection

