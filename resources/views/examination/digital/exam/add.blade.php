@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
  $getChapter = Helper::getChapter();
  $getTopic = Helper::getTopic();
  $getLevel = Helper::getLevel();
  $getSuka = Helper::getSuka();
  $getExamPattern = Helper::getExamPattern();
  $getExamType = Helper::getExamType();
@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              
            <div class="card card-outline card-orange ">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="nav-icon fas fa fa-leanpub"></i> &nbsp;{{__('examination.Add Exams') }}</h3>
                    <div class="card-tools">
                    <a href="{{url('view/exam')}}" class="btn btn-primary  btn-sm" title="View Exams"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
                    <a href="{{url('examination_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                    
                    </div>
                    
                    </div>  
                    <div class="card-body">
                <form id="quickForm" action="{{ url('add/exam') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    
                    <div class="row border-bottom border-warning">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Pattern Name </label>
                        		    </div>
                        		</div>  
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="pattern_id" name="pattern_id" >
                                            <option value="">Select Pattern</option>
                                            @if(!empty($getExamPattern)) 
                                              @foreach($getExamPattern as $pattern)
                                                 <option value="{{ $pattern->id ?? ''  }}" {{ ($pattern->id == old('pattern_id')) ? 'selected' : '' }}>{{ $pattern->name ?? ''  }}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                        <span id='pattern_id_label'class='pl-1 text-danger' style='font-size: 10px;' > </span>
                        		    </div>
                        		</div>  
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Class </label>
                        		    </div>
                        		</div>  
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="class_type_id" name="class_type_id" required>
                        				    <option value="">Select Class</option>
                                         @if(!empty($classType)) 
                                              @foreach($classType as $class)
                                                 <option value="{{ $class->id ?? ''  }}" {{ ($class->id == old('class_type_id')) ? 'selected' : '' }}>{{ $class->id ?? ''  }} : {{ $class->name ?? ''  }}</option>
                                              @endforeach
                                          @endif
                                        </select>
                                         <span id='class_type_id_label'class='pl-1 text-danger' style='font-size: 10px;' > </span>
                        		    </div>
                        		</div>  
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Test Type </label>
                        		    </div>
                        		</div>  
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="exam_type_id" name="exam_type_id" >
                                            <option value="">Select Test Type</option>
                                            @if(!empty($getExamType)) 
                                              @foreach($getExamType as $examtype)
                                                 <option value="{{ $examtype->id ?? ''  }}" {{ ($examtype->id == old('exam_type_id')) ? 'selected' : '' }}>{{ $examtype->name ?? ''  }}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                        <span id='exam_type_id_label'class='pl-1 text-danger' style='font-size: 10px;' > </span>
                        		    </div>
                        		</div>  
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">{{ __('examination.Subject') }}</label>
                        		    </div>
                        		</div>                 		
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="subject_id" name="subject_id[]" multiple required>
                        				    <option value="">Select Subject</option>
                                         @if(!empty($getsubject)) 
                                              @foreach($getsubject as $subject)
                                                 <option value="{{ $subject->id ?? ''  }}" {{ ($subject->id == old('subject_id')) ? 'selected' : '' }}>{{ $subject->id ?? ''  }} : {{ $subject->name ?? ''  }} {{ $subject['ClassTypes']['name'] ?? ''  }}</option>
                                              @endforeach
                                          @endif
                                        </select>
                                        
                        		    </div>
                        		</div>                 		
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Schedule Date</label>
                        		    </div>
                        		</div>
                                <div class="col-md-7">
                        			<div class="form-group">
                                        <input type="datetime-local" id="exam_date" name="exam_date" class="form-control" value="{{old('exam_date')}}" required>
                        		    </div>
                        		     <span id='exam_date_label'class='pl-1 text-danger' style='font-size: 10px;' > </span>
                        		</div>
                        		<div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Exam Duration</label>
                        		    </div>
                        		</div>
                                <div class="col-md-7">
                        		    <div class="form-group">
                    				    <div class="input-group">
                                          	<input type="tel" name="duration_hour" id="duration_hour" class="form-control" placeholder="Duration Hour" onkeypress="javascript:return isNumber(event)" autocomplete="off" maxlength="2" required>
                                           	<input type="tel" name="duration_minute" id="duration_minute" class="form-control" placeholder="Duration Minute" onkeypress="javascript:return isNumber(event)" autocomplete="off" maxlength="2" required>
                                        
                                        </div>
                    				    <div class="input-group">
                                           <span id='duration_hour_label'class='w-50 pl-1 text-danger' style='font-size: 10px;' > </span>
                                        
                                         <span id='duration_minute_label'class='w-50 pl-2 text-danger' style='font-size: 10px;' > </span>
                                        </div>
                                        
                        		    </div>
                        		</div>
                                <div class="col-md-5">
                    			    <div class="form-group">
                    				    <label style="color:red;">{{ __('examination.Exam Name') }}</label>
                    		        </div>
                		        </div>
                               
                                
                                <div class="col-md-7">
                    			    <div class="form-group">
                    				    <input type="text" id="name_" name="name" class="form-control" placeholder="{{ __('examination.Exam Name') }}" value="{{old('name')}}" required>
                    		        </div>
                    		         <span id='name_label'class='pl-1 text-danger' style='font-size: 10px;' > </span>
                		        </div>                		
        		        </div>                            
                        </div>
                        
                    
                        <div class="col-md-8">
                            <div class="card">
                                
                                
                                    <button type="button" class="btn btn-tool d-none" data-card-widget="collapse"><i class="fa fa-minus text-white"></i></button>
                                 
                                
                                <div class="card-body p-0">
                            <div class="row m-1 bg-primary text-white align-items-center ">
                                <div class="col-md-2">
                                    <div class="row  ">
                                        <div class="col-md-2">
                                            <h1>1</h1>
                                        </div>
                                        <div class="col-md-10">
                                            Level of Question
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row  ">
                                        <div class="col-md-2">
                                            <h1>2</h1>
                                        </div>
                                        <div class="col-md-10">
                                            Percentage of Question Type
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row  ">
                                        <div class="col-md-2">
                                            <h1>3</h1>
                                        </div>
                                        <div class="col-md-10">
                                            Question Selection Priority
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row align-items-center ">
                                        <div class="col-md-2">
                                            <h1>4</h1>
                                        </div>
                                        <div class="col-md-10">
                                            Allow Repetation
                                            <br><small>Specify test type allowing repeated questions from prior tests</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="row p-2 ">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input pointer" type="radio" id="level_0" name="level_id" checked="" value="0">
                                                <label for="level_0" class="custom-control-label pointer">All</label>
                                            </div>  
                                        </div>
                                        @if(!empty($getLevel))
                                            @foreach($getLevel as $level)
                                            <div class="col-md-12">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input pointer" type="radio" id="level_{{ $level->id ?? '' }}" name="level_id" value="{{ $level->id ?? '' }}">
                                                    <label for="level_{{ $level->id ?? '' }}" class="custom-control-label pointer">{{ $level->name ?? '' }}</label>
                                                </div>  
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row p-2 " id='suka_button'>
                                        @if(!empty($getSuka))
                                            @foreach($getSuka as $suke)
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="suka_{{ $suke->id ?? '' }}" class="{{ $suke->name ?? '' }}">{{ $suke->name ?? '' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="tel" id="suka_{{ $suke->id ?? '' }}" name="suka_id[{{ $suke->id ?? '' }}]" class="form-control suka" placeholder="25" maxlength="2" onkeypress="javascript:return isNumber(event)" autocomplete="off" value="25" required>
                                                </div>  
                                            </div>                                            
                                            @endforeach
                                        @endif
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="">Total Percentage</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <b>100</b>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row p-2 ">
                                      <!--  <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success custom-control-input-outline pointer" type="radio" id="selection_priority_0" name="selection_priority" checked="" value="0">
                                                <label for="selection_priority_0" class="custom-control-label pointer">All Questions</label>
                                            </div> 
                                        </div>-->
                                 
                                        <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success custom-control-input-outline pointer" type="radio" id="selection_priority_2" name="selection_priority" value="2" checked>
                                                <label for="selection_priority_2" class="custom-control-label pointer">Active Entered % of Questions Type</label>
                                            </div>  
                                        </div>
                                               <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline pointer" type="radio" id="selection_priority_1" name="selection_priority" value="1">
                                                <label for="selection_priority_1" class="custom-control-label pointer">
                                                    <!--Selected Level of Questions-->
                                                    Deactive Entered % of Questions Type
                                                    </label>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row p-2 ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-danger custom-control-input-outline pointer checkbox" type="checkbox" id="repetation_0"  name="repetation_0">
                                                    <label for="repetation_0" class="custom-control-label pointer">All</label>
                                                </div>
                                                @if(!empty($getExamType))
                                                @foreach($getExamType as $type)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-danger custom-control-input-outline pointer checkbox" type="checkbox" id="repetation_{{ $type->id ?? '' }}" name="repetation_{{ $type->id ?? '' }}">
                                                    <label for="repetation_{{ $type->id ?? '' }}" class="custom-control-label pointer">{{ $type->name ?? '' }}</label>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            </div>
                            <div class='row p-2 ' >
                                <div class='col-md-12 border-top border-primary pt-2'>
                                     <div class="form-group">
                                    <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input pointer" id="customSwitch1">
                                    <label class="custom-control-label pointer" for="customSwitch1">Make Exam By Question's ID</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control d-none" id="exam_by_question_id" name="exam_by_question_id" value="" placeholder="Type Question Ids Ex: 1,4,7,68,98...">
                                </div>
                            </div>                            
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-7 pl-0">
                            <div id="appendChapterData" class="border-bottom border-success appendData"></div>
                        </div>
                        <div class="col-md-5 pr-0">
                            <div id="appendTopicData" class="border-bottom border-success appendData"></div>
                        </div>
                    </div>

                <div class="row pb-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input custom-control-input-primary custom-control-input-outline pointer" type="checkbox" id="filterSubTopic" name="filterSubTopic">
                            <label for="filterSubTopic" class="custom-control-label pointer">Filter Sub Topic</label>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                       <input type='hidden' name='question_objective_ordering' id='question_objective_ordering' />
                       <input type='hidden' name='question_numeric_ordering' id='question_numeric_ordering' />
                        <button type="button" id="checkQuestionAvailability" class="btn btn-primary ">{{ __('common.Submit') }}</button>
                        <button type="submit" id="createExam" class="btn btn-primary d-none">{{ __('common.Submit') }}</button>
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

<script>
$(document).ready(function(){
      $('#pattern_id_label').hide();
$('#class_type_id_label').hide();
   $('#exam_type_id_label').hide();
    $('#exam_date_label').hide();
  $('#duration_hour_label').hide();
  $('#duration_minute_label').hide();
 $('#name_label').hide();
    $('#class_type_id').on('change', function(){
    	var class_type_id = $(this).val();
    	if(class_type_id == 3){
    	    $('#subject_id').attr("multiple", true);
    	}else{
    	    $('#subject_id').attr("multiple", false);
    	}
    });     
    
    /*$('.suka').keyup(function(){
        
        var total_suka = 100;
        var filled_suka = 0;
        $('.suka').each(function(){
            var this_suka = isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
            filled_suka = filled_suka + this_suka;
        });
        toastr.warning(filled_suka);
        if(total_suka > filled_suka){
            toastr.info('Kam H');
        }else if(total_suka == filled_suka){
            toastr.success('Barabar H ===');
        }else if(total_suka < filled_suka){
            toastr.danger('Kuch Jyada ho gaya');
        }else{
            alert('Kidhar Hi Gara ');
        }
    });*/
    
    $('#subject_id').on('change', function(e){
        var baseurl = "{{ url('/') }}";
    	var class_type_id = $('#class_type_id').val();
    	var subject_id = $(this).val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
    	    url: baseurl + '/examChapterData',
    	    data: {class_type_id:class_type_id, subject_id:subject_id},
    	    method: 'post',
    	    success: function(data){
    			$("#appendChapterData").html(data);
    			$('#appendTopicData').html('');
    			$('#filterSubTopic').prop('checked', false);
    	    }
    	});
    });  
    
    $('#filterSubTopic').on('click', function(){
        if ($(this).is(':checked')) {
            var baseurl = "{{ url('/') }}";
            var myForm = $('#quickForm');
    	    var formData = myForm.serialize();
        	var chapter_id = $('.chapter_id').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/examTopicData',
        	    data: formData,
        	    method: 'post',
        	    success: function(data){
        			$("#appendTopicData").html(data);
        			$('.objective,.numeric').attr('readonly', true);
        			$('#appendChapterData input[type="tel"]').val('');
        			$('#appendChapterData input[name="mark"]').val(4);
        	    }
        	});
        	
        }else{
            $('#appendTopicData').html('');
            $('.objective,.numeric').attr('readonly', false);
            $('#appendChapterData input[type="tel"]').val('');
            $('#appendChapterData input[name="mark"]').val(4);
        }
    }); 

    $('#checkQuestionAvailability').on('click', function(e){
        
$('#pattern_id_label').hide();
$('#class_type_id_label').hide();
$('#exam_type_id_label').hide();
$('#exam_date_label').hide();
$('#duration_hour_label').hide();
$('#duration_minute_label').hide();
$('#name_label').hide();
        var baseurl = "{{ url('/') }}";
    	var myForm = $('#quickForm');
    	var formData = myForm.serialize();
    	var final_totalQuesSum = parseInt($('#totalQuesSum').val());
    	    var pattern_id =  parseInt($('#pattern_id').val() != '' ? 1 : 0) ;
            var class_type_id = parseInt($('#class_type_id').val() != '' ? 1 : 0) ;
            var exam_type_id =  parseInt($('#exam_type_id').val() != '' ? 1 : 0) ;
            var exam_date =  parseInt($('#exam_date').val() != '' ? 1 : 0) ;
            var duration_hour =  parseInt($('#duration_hour').val() != '' ? 1 : 0) ;
            var duration_minute =  parseInt($('#duration_minute').val() != '' ? 1 : 0) ;
            var name =  parseInt($('#name_').val() != '' ? 1 : 0) ;
            var exam_by_question_id =  parseInt($('#exam_by_question_id').val() != '' ? 1 : 0) ;
            
        
            if(pattern_id == 0)
            {
                 $('#pattern_id_label').show();
            }
            if(class_type_id == 0)
            {
              $('#class_type_id_label').show();
            }
            if(exam_type_id == 0)
            {
                $('#exam_type_id_label').show();
            }
            if(exam_date == 0)
            {
                $('#exam_date_label').show();
            }
            if(duration_hour == 0)
            {
                $('#duration_hour_label').show();
            }
            if(duration_minute == 0)
            {
                $('#duration_minute_label').show();
            }
            if(name == 0)
            {
                $('#name_label').show();
            }
            
          $('#pattern_id_label').text($('#pattern_id').val() != '' ? '' : 'Plz Select Pattern Id')
          $('#class_type_id_label').text($('#class_type_id').val() != '' ? '' : 'Plz Select Class Type Id')
          $('#exam_type_id_label').text($('#exam_type_id').val() != '' ? '' : 'Plz Select Exam Type Id')
          $('#exam_date_label').text($('#exam_date').val() != '' ? '' : 'Plz Fill Exam Date')
          $('#duration_hour_label').text($('#duration_hour').val() != '' ? '' : 'Plz Fill Time In Hours')
          $('#duration_minute_label').text($('#duration_minute').val() != '' ? '' : 'Plz Fill Time In Minutes')
          $('#name_label').text($('#name_').val() != '' ? '' : 'Plz Fill Exam Name')
         
          
          var validation_by = exam_by_question_id == 1 ?  exam_by_question_id  : final_totalQuesSum;
        
    	if(validation_by > 0  && (pattern_id +class_type_id + exam_type_id+ exam_date + duration_hour + duration_minute + name) ==7){
    	    
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/digital/add/exam',
        	    data: formData,
        	    method: 'post',
        	    success: function(response){
        	        
        	        if(response.status == 1){
        	            alert(final_totalQuesSum + ' Questions are not fulfilling above filters Please Add More Questions or take less Questions!');
        	        }else if(response.status == 0){
        	            toastr.success('Exam Created Successfully!');
        	            window.location = baseurl + 'digital/view/exam';
        	        }else{
        	            alert('Something Went Wrong, Please Contact to Service Provider!');
        	        }
        			
        	    }
        	});
    	}else{
    	    
    	    if((pattern_id +class_type_id + exam_type_id+ exam_date + duration_hour + duration_minute + name) !=7)
    	    {
    	         toastr.error('Please Fill Exam Required Fields !');
    	    }
    	    else
    	    {
    	         toastr.error('Please Fill Total Questions to take!');
    	    }
    	   
    	}
    });     
    
       $(document).on('click', 'input[name="selection_priority"]:checked', function() {
     var suka_button = $('input[name="selection_priority"]:checked').val() == 1 ? 0.1 : 1;
        
        $('#suka_button').css('opacity',suka_button);
       });  
    var ques_array_objective = {};
    var ques_array_numeric = {};
    var suka_array = {};
    $(document).on('blur', '.appendData .checkQuestionCount', function() {
     
        
        var baseurl = "{{ url('/') }}";
        var thisInput = $(this);
        var id =  thisInput.attr('data-id');
        var pattern_id =  $('#pattern_id').val();
        var class_type_id =  $('#class_type_id').val();
        var final_test =   ($('#repetation_3').is(':checked') ?  $('#repetation_3').val() : '' )//allow repeatation
        var chapter_wise =   ($('#repetation_1').is(':checked') ?  $('#repetation_1').val() : '' ); //allow repeatation
        var subject_wise =   ($('#repetation_2').is(':checked') ?  $('#repetation_2').val() : '' );  //allow repeatation
        var all =  ($('#repetation_0').is(':checked') ?  $('#repetation_0').val() : '' );  //allow repeatation
       
     
        var myForm = $('#quickForm');
        var formData = myForm.serialize();
    	var questionCountObjective = $('#objective_'+id).val();
    	var questionCountNumeric = $('#numeric_'+id).val();
        var questionCount = $(this).val();
             	var questionTypeId = $(this).data('question_type_id');
    	var totalQuestionCount= Number(questionTypeId ==1 ? questionCountObjective : questionCountNumeric);
    	 
    
   
    	var level_id = $('input:radio[name="level_id"]:checked').val();
    	var topic_status = '';
        var totalQuesSum = parseInt($('#totalQuesSum').val());
        var suka_status = $('input[name="selection_priority"]:checked').val() == 1 ? 'deactive' : 'active';
       
     
        var skill_q = Math.round((totalQuestionCount*(parseInt($('#suka_1').val())))/100);
        var understanding_q = Math.round((totalQuestionCount*(parseInt($('#suka_2').val())))/100);
        var knowledge_q = Math.round((totalQuestionCount*(parseInt($('#suka_3').val())))/100);
        var application_q = Math.round((totalQuestionCount*(parseInt($('#suka_4').val())))/100);
    
         var sukas =[];
         var total = totalQuestionCount;
        for(var i=0; i<4; i++)
        {
            
          if(i == 0)
          {
              if((total-skill_q) > -1)
              {
                   sukas.push(skill_q);
              
                  total = total-skill_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 1)
          {
              if((total-understanding_q) > -1)
              {
                  sukas.push(understanding_q);
              
                  total = total-understanding_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 2)
          {
              if((total-knowledge_q) > -1)
              {
                  sukas.push(knowledge_q);
              
                  total = total-knowledge_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 3)
          {
             
             
                  sukas.push(total);
              
          
  
          }
     
            }
  
            
             
    var skill_q_total = (totalQuesSum*(parseInt($('#suka_1').val())))/100;
        var understanding_q_total  = (totalQuesSum*(parseInt($('#suka_2').val())))/100;
        var knowledge_q_total  = (totalQuesSum*(parseInt($('#suka_3').val())))/100;
        var application_q_total  = (totalQuesSum*(parseInt($('#suka_4').val())))/100;
            

   	if($(thisInput).hasClass('chapter')){
    	    var chapterOrTopic = 0;
    	    var chapterId = $(this).data('id');
    	    var topicId = 0;
    	    topic_status = 'chapter_id';
    	}else if($(thisInput).hasClass('topic')){
    	    var chapterOrTopic = 1;
    	    var chapterId = $(this).data('chapter_id');
    	    var topicId = $(this).data('id');
    	      topic_status = 'topic_id';
    	}else{}
    	
    	if(totalQuestionCount > 0  ){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/checkQuestionCount',
        	    data: {chapter_id:chapterId,questionTypeId:questionTypeId,
        	   // questionCountNumeric:questionCountNumeric,
        	   // questionCountObjective:questionCountObjective,
        	    questionCount:questionCount,
        	    level_id:level_id,
        	    topic_status:topic_status,
        	    totalQuestionCount:totalQuestionCount,
        	    topic_id:topicId,
        	    sukas:sukas,     
        	    suka_status:suka_status,     
        	    pattern_id:pattern_id,
                class_type_id:class_type_id,
                final_test:final_test,
                chapter_wise:chapter_wise,
                subject_wise:subject_wise,
                all:all
        	        
        	    },
        	    method: 'post',
        	    success: function(response){
        	        if(response.status == 1){
        	            toastr.error(response.error);
        	           // $(thisInput).val('').focus();
        	           
        	           if(questionTypeId == 1)
        	           {
        	                $('#objective_'+id).val('')
        	           }
        	           else
        	           {
        	                $('#numeric_'+id).val('')
        	           }
        	           
                       
        	        }
        	          
        	                  	           if(questionTypeId == 1)
        	           {
        	                 ques_array_objective[id] = response.question_selected;
        	                  console.log('objective : ' + JSON.stringify(ques_array_objective));

        	           }
        	           else
        	           {
        	                ques_array_numeric[id] = response.question_selected;
        	                 console.log('numeric : ' +JSON.stringify(ques_array_numeric));
        	           }
        	           
        	      
        	       
        	        suka_array[id] = response.suka_ids;
        	        
        	   
        	     var skill = 0;
        	     var Understanding = 0;
        	     var Knowledge = 0;
        	     var Application = 0;
        	     $.each(suka_array, function(index, value){
        	         
        	          $.each(value, function(index1, value1){
        	         if(value1 == 1)
        	         {
        	             skill ++;
        	         }
        	        else if(value1 == 2)
        	         {
        	             Understanding ++;
        	         }
        	        else if(value1 == 3)
        	         {
        	             Knowledge ++;
        	         }
        	        else if(value1 == 4)
        	         {
        	             Application ++;
        	         }
        	        
        });
        	       
        });
        

     if(skill_q_total <= skill && (skill_q_total+skill) != 0 )
     {
         
         
         $(".Skill").css('color','green');
     }
     else
     {
          $(".Skill").css('color','red');
     }
     if(understanding_q_total <= Understanding && (understanding_q_total+Understanding) != 0 )
     {
         $(".Understanding").css('color','green');
     }
     else
     {
          $(".Understanding").css('color','red');
     }
     if(knowledge_q_total <= Knowledge && (knowledge_q_total+Knowledge) != 0 )
     {
         $(".Knowledge").css('color','green');
     }else
     {
         $(".Knowledge").css('color','red');
     }
     if(application_q_total <= Application && (application_q_total+Application) != 0 )
     {
         $(".Application").css('color','green');
     }else
     {
           $(".Application").css('color','red');
     }
       
        	    }
        	});
    	}else{
    	    
    	     if(questionTypeId == 1)
        	           {
        	                 ques_array_objective[id] = '';
        	                  console.log('objective : ' + JSON.stringify(ques_array_objective));

        	           }
        	           else
        	           {
        	                ques_array_numeric[id] = '';
        	                 console.log('numeric : ' +JSON.stringify(ques_array_numeric));
        	           }
    	    
    	}
    	  $('#question_objective_ordering').val(JSON.stringify(ques_array_objective))
          $('#question_numeric_ordering').val(JSON.stringify(ques_array_numeric))
    });
    
    $(document).on('blur', '.appendData .checkQuestionCountTopic', function() {
    
        var baseurl = "{{ url('/') }}";
        var thisInput = $(this);
        var id =  thisInput.attr('data-id');
       
       var pattern_id =  $('#pattern_id').val();
        var class_type_id =  $('#class_type_id').val();
        var final_test =   ($('#repetation_3').is(':checked') ?  $('#repetation_3').val() : '' )//allow repeatation
        var chapter_wise =   ($('#repetation_1').is(':checked') ?  $('#repetation_1').val() : '' ); //allow repeatation
        var subject_wise =   ($('#repetation_2').is(':checked') ?  $('#repetation_2').val() : '' );  //allow repeatation
        var all =  ($('#repetation_0').is(':checked') ?  $('#repetation_0').val() : '' );  //allow repeatation
        
        var myForm = $('#quickForm');
        var formData = myForm.serialize();
    	var questionCountObjective = $('#topicObjective_'+id).val();
    	var questionCountNumeric = $('#topicNumeric_'+id).val();
    
    	  var questionCount = $(this).val();
    	var totalQuestionCount= Number(questionCount);
    	var questionTypeId = $(this).data('question_type_id');
    	var level_id = $('input:radio[name="level_id"]:checked').val();
    	var topic_status = '';
        var totalQuesSum = parseInt($('#totalQuesSum').val());
        var suka_status = $('input[name="selection_priority"]:checked').val() == 1 ? 'deactive' : 'active';
       
     
        var skill_q = Math.round((totalQuestionCount*(parseInt($('#suka_1').val())))/100);
        var understanding_q = Math.round((totalQuestionCount*(parseInt($('#suka_2').val())))/100);
        var knowledge_q = Math.round((totalQuestionCount*(parseInt($('#suka_3').val())))/100);
        var application_q = Math.round((totalQuestionCount*(parseInt($('#suka_4').val())))/100);
    
         var sukas =[];
         var total = totalQuestionCount;
        for(var i=0; i<4; i++)
        {
            
          if(i == 0)
          {
              if((total-skill_q) > -1)
              {
                   sukas.push(skill_q);
              
                  total = total-skill_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 1)
          {
              if((total-understanding_q) > -1)
              {
                  sukas.push(understanding_q);
              
                  total = total-understanding_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 2)
          {
              if((total-knowledge_q) > -1)
              {
                  sukas.push(knowledge_q);
              
                  total = total-knowledge_q; 
              }
              else
              {
                  sukas.push(total);
              }
           
  
          }
          if(i == 3)
          {
             
              
                  sukas.push(total);
              
  
          }
     
            }
  
            
             
    var skill_q_total = (totalQuesSum*(parseInt($('#suka_1').val())))/100;
        var understanding_q_total  = (totalQuesSum*(parseInt($('#suka_2').val())))/100;
        var knowledge_q_total  = (totalQuesSum*(parseInt($('#suka_3').val())))/100;
        var application_q_total  = (totalQuesSum*(parseInt($('#suka_4').val())))/100;
            

   	if($(thisInput).hasClass('chapter')){
    	    var chapterOrTopic = 0;
    	    var chapterId = $(this).data('id');
    	    var topicId = 0;
    	    topic_status = 'chapter_id';
    	}else if($(thisInput).hasClass('topic')){
    	    var chapterOrTopic = 1;
    	    var chapterId = $(this).data('chapter_id');
    	    var topicId = $(this).data('id');
    	      topic_status = 'topic_id';
    	}else{}
    	
    	if(questionCount > 0 ){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/checkQuestionCount',
        	    data: {chapter_id:chapterId,questionTypeId:questionTypeId,
        	 //   questionCountNumeric:questionCountNumeric,
        	  //  questionCountObjective:questionCountObjective,
        	  questionCount:questionCount,
        	    level_id:level_id,
        	    topic_status:topic_status,
        	    totalQuestionCount:totalQuestionCount,
        	    topic_id:topicId,
        	    sukas:sukas,     
        	    suka_status:suka_status,
        	      pattern_id:pattern_id,
                class_type_id:class_type_id,
                final_test:final_test,
                chapter_wise:chapter_wise,
                subject_wise:subject_wise,
                all:all
        	        
        	    },
        	    method: 'post',
        	    success: function(response){
        	        if(response.status == 1){
        	            toastr.error(response.error);
        	           // $(thisInput).val('').focus();
        	           
        	           if(questionTypeId == 1)
        	           {
        	            $('#topicObjective_'+id).val('')
        	           }
        	           else
        	           {
        	               $('#topicNumeric_'+id).val('')  
        	           }
                      
        	        }
        	          
        	           if(questionTypeId == 1)
        	           {
        	             ques_array_objective[id] = response.question_selected;
        	               console.log('objective : ' + JSON.stringify(ques_array_objective));

        	           }
        	           else
        	           {
        	               ques_array_numeric[id] = response.question_selected;
        	               console.log('numeric : ' +JSON.stringify(ques_array_numeric));
        	           }
        	       
        	        suka_array[id] = response.suka_ids;
        	        
        	  //   $('#suka_ordering').text(JSON.stringify(suka_array));
        	     var skill = 0;
        	     var Understanding = 0;
        	     var Knowledge = 0;
        	     var Application = 0;
        	     $.each(suka_array, function(index, value){
        	         
        	          $.each(value, function(index1, value1){
        	         if(value1 == 1)
        	         {
        	             skill ++;
        	         }
        	        else if(value1 == 2)
        	         {
        	             Understanding ++;
        	         }
        	        else if(value1 == 3)
        	         {
        	             Knowledge ++;
        	         }
        	        else if(value1 == 4)
        	         {
        	             Application ++;
        	         }
        	        
        });
        	       
        });
        

     if(skill_q_total <= skill && (skill_q_total+skill) != 0 )
     {
         
         $(".Skill").css('color','green');
     }
     else
     {
          $(".Skill").css('color','red');
     }
     if(understanding_q_total <= Understanding && (understanding_q_total+Understanding) != 0 )
     {
         $(".Understanding").css('color','green');
     }
     else
     {
          $(".Understanding").css('color','red');
     }
     if(knowledge_q_total <= Knowledge && (knowledge_q_total+Knowledge) != 0 )
     {
         $(".Knowledge").css('color','green');
     }else
     {
         $(".Knowledge").css('color','red');
     }
     if(application_q_total <= Application && (application_q_total+Application) != 0 )
     {
         $(".Application").css('color','green');
     }else
     {
           $(".Application").css('color','red');
     }
        
        	    }
        	});
    	}else{
    	    
    	    if(questionTypeId == 1)
        	           {
        	                 ques_array_objective[id] = '';
        	                  console.log('objective : ' + JSON.stringify(ques_array_objective));

        	           }
        	           else
        	           {
        	                ques_array_numeric[id] = '';
        	                 console.log('numeric : ' +JSON.stringify(ques_array_numeric));
        	           }
    	}
    	
    	 $('#question_objective_ordering').val(JSON.stringify(ques_array_objective))
         $('#question_numeric_ordering').val(JSON.stringify(ques_array_numeric))
    });
 /*       $(document).on('blur', '.appendData .checkQuestionCountTopic', function() {
            
         
        var baseurl = "{{ url('/') }}";
        var thisInput = $(this);
        var id =  thisInput.attr('data-id');
      
    	var questionCountObjective = $('#topicObjective_'+id).val();
    	var questionCountNumeric = $('#topicNumeric_'+id).val();
    	var questionTypeId = $(this).data('question_type_id');
    	var level_id = $('input:radio[name="level_id"]:checked').val();
    	var topic_status = '';
    

   	if($(thisInput).hasClass('chapter')){
    	    var chapterOrTopic = 0;
    	    var chapterId = $(this).data('id');
    	    var topicId = 0;
    	    topic_status = 'chapter_id';
    	}else if($(thisInput).hasClass('topic')){
    	    var chapterOrTopic = 1;
    	    var chapterId = $(this).data('chapter_id');
    	    var topicId = $(this).data('id');
    	      topic_status = 'topic_id';
    	}else{}
    	
    	if(questionCountObjective > 0  || questionCountNumeric > 0 ){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/checkQuestionCount',
        	    data: {chapter_id:topicId,questionTypeId:questionTypeId,
        	    questionCountNumeric:questionCountNumeric,
        	    questionCountObjective:questionCountObjective,
        	    level_id:level_id,
        	    topic_status:topic_status,
        	    topic_id:topicId},
        	    method: 'post',
        	    success: function(response){
        	        if(response.status == 1){
        	            alert(' Questions are not in Database!');
        	           // $(thisInput).val('').focus();
        	            $('#topicObjective_'+id).val('')
                        $('#topicNumeric_'+id).val('')
                        $('#question_ordering').val(response.question_selected)
        	        }
        	             ques_array[id] = response.question_selected;
        	                suka_array[id] = response.suka_ids;
          $('#question_ordering').val(JSON.stringify(ques_array))
        	        
        	    }
        	});
    	}else{}
    });*/
    
    $('#customSwitch1').click(function(){
        
        if ($(this).is(':checked')) {
            $('#exam_by_question_id').removeClass('d-none');
        } else {
            $('#exam_by_question_id').val('').addClass('d-none');
        }
        $('.btn-tool').click();
        
    });
    
});

</script>


<script>
   
        $(document).ready(function(){
         
            $("#repetation_0").change(function(){
                $(".checkbox").prop('checked', $(this).prop('checked')); 
            });

           
            $(".checkbox").change(function(){
                if(!$(this).prop("checked")){
                    $("#repetation_0").prop("checked", false);
                }
            });
        });
  
</script>

<style>
    .form-control{
        height:24px;
    }
    table{
        font-size:small;
    }
    .bold-input {
      font-weight: bold;
    }
    #appendChapterData, #appendTopicData{
        height:400px;
        overflow-y:scroll;
    }
</style>

@endsection