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
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="nav-icon fas fa fa-leanpub"></i> &nbsp;{{__('examination.Edit Exam') }}</h3>
                    <div class="card-tools">
                    <a href="{{url('digital/view/exam')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('digital/edit/exam') }}/{{ $data->id ?? '' }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2 border-bottom border-warning">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Pattern Name </label>
                        		    </div>
                        		</div>  
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="" name="pattern_id" >
                                            <option value="">Select Pattern</option>
                                            @if(!empty($getExamPattern)) 
                                              @foreach($getExamPattern as $pattern)
                                                 <option value="{{ $pattern->id ?? ''  }}" {{ ($pattern->id == old('pattern_id', $data->pattern_id)) ? 'selected' : '' }}>{{ $pattern->name ?? ''  }}</option>
                                              @endforeach
                                            @endif
                                        </select>
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
                                                 <option value="{{ $class->id ?? ''  }}" {{ ($class->id == old('class_type_id', $data->class_type_id)) ? 'selected' : '' }}>{{ $class->id ?? ''  }} : {{ $class->name ?? ''  }}</option>
                                              @endforeach
                                          @endif
                                        </select>
                        		    </div>
                        		</div>  
                                <div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Test Type </label>
                        		    </div>
                        		</div>  
                                <div class="col-md-7">
                        			<div class="form-group">
                        				<select class="select2 form-control" id="" name="exam_type_id" >
                                            <option value="">Select Test Type</option>
                                            @if(!empty($getExamType)) 
                                              @foreach($getExamType as $examtype)
                                                 <option value="{{ $examtype->id ?? ''  }}" {{ ($examtype->id == old('exam_type_id', $data->exam_type_id)) ? 'selected' : '' }}>{{ $examtype->name ?? ''  }}</option>
                                              @endforeach
                                            @endif 
                                        </select>
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
                                                 <option value="{{ $subject->id ?? ''  }}" {{ ($subject->id == old('subject_id', $data->subject_id)) ? 'selected' : '' }}>{{ $subject->id ?? ''  }} : {{ $subject->name ?? ''  }} {{ $subject['ClassTypes']['name'] ?? ''  }}</option>
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
                                        <input type="datetime-local" id="exam_date" name="exam_date" class="form-control" value="{{ $data->exam_date ?? old('exam_date') }}" required>
                        		    </div>
                        		</div>
                        		<div class="col-md-5">
                        			<div class="form-group">
                        				<label style="color:red;">Exam Duration</label>
                        		    </div>
                        		</div>
                                <div class="col-md-7">
                        		    <div class="form-group">
                    				    <div class="input-group">
                                          	<input type="tel" name="duration_hour" id="duration_hour" class="form-control" placeholder="Duration Hour" value="{{ $data->duration ?? old('duration_hour') }}" onkeypress="javascript:return isNumber(event)" autocomplete="off" maxlength="2" required>
                                          	<input type="tel" name="duration_minute" id="duration_minute" class="form-control" placeholder="Duration Minute" value="{{ $data->duration_minute ?? old('duration_minute') }}" onkeypress="javascript:return isNumber(event)" autocomplete="off" maxlength="2" required>
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
                    				    <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('examination.Exam Name') }}" value="{{ $data->name ?? old('name') }}" required>
                    		        </div>
                		        </div>                		
        		        </div>                            
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row bg-primary text-white align-items-center">
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
                                                <input class="custom-control-input pointer" type="radio" id="level_0" name="level_id" value="0" {{ (0 == old('level_id', $data->level_id)) ? 'checked' : '' }}>
                                                <label for="level_0" class="custom-control-label pointer">All</label>
                                            </div>  
                                        </div>
                                        @if(!empty($getLevel))
                                            @foreach($getLevel as $level)
                                            <div class="col-md-12">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input pointer" type="radio" id="level_{{ $level->id ?? '' }}" name="level_id" value="{{ $level->id ?? '' }}" {{ ($level->id == old('level_id', $data->level_id)) ? 'checked' : '' }}>
                                                    <label for="level_{{ $level->id ?? '' }}" class="custom-control-label pointer">{{ $level->name ?? '' }}</label>
                                                </div>  
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row p-2 ">
                                        @if(!empty($getSuka))
                                            @foreach($getSuka as $suke)
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="suka_{{ $suke->id ?? '' }}" class="">{{ $suke->name ?? '' }}</label>
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
                                        <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success custom-control-input-outline pointer" type="radio" id="selection_priority_0" name="selection_priority" value="0" {{ (0 == old('selection_priority', $data->selection_priority)) ? 'checked' : '' }}>
                                                <label for="selection_priority_0" class="custom-control-label pointer">All Questions</label>
                                            </div> 
                                        </div>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success custom-control-input-outline pointer" type="radio" id="selection_priority_1" name="selection_priority" value="1" {{ (1 == old('selection_priority', $data->selection_priority)) ? 'checked' : '' }}>
                                                <label for="selection_priority_1" class="custom-control-label pointer">Selected Level of Questions</label>
                                            </div>  
                                        </div>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success custom-control-input-outline pointer" type="radio" id="selection_priority_2" name="selection_priority" vaLUE="2" {{ (2 == old('selection_priority', $data->selection_priority)) ? 'checked' : '' }}>
                                                <label for="selection_priority_2" class="custom-control-label pointer">Entered % of Questions Type</label>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row p-2 ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-danger custom-control-input-outline pointer" type="checkbox" id="repetation_0" checked="" name="repetation_0">
                                                    <label for="repetation_0" class="custom-control-label pointer">All</label>
                                                </div>
                                                @if(!empty($getExamType))
                                                @foreach($getExamType as $type)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-danger custom-control-input-outline pointer" type="checkbox" id="repetation_{{ $type->id ?? '' }}" name="repetation_{{ $type->id ?? '' }}">
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
                    </div>

                    <div class="row m-2">
                        <div class="col-md-7">
                            <div id="appendChapterData" class="border-bottom border-success appendData"></div>
                        </div>
                        <div class="col-md-5">
                            <div id="appendTopicData" class="border-bottom border-success appendData"></div>
                        </div>
                    </div>

                <div class="row m-2 pb-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input custom-control-input-primary custom-control-input-outline pointer" type="checkbox" id="filterSubTopic" name="filterSubTopic">
                            <label for="filterSubTopic" class="custom-control-label pointer">Filter Sub Topic</label>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button" id="checkQuestionAvailability" class="btn btn-primary ">{{ __('common.Update') }}</button>
                        <button type="submit" id="createExam" class="btn btn-primary d-none">{{ __('common.Update') }}</button>
                    </div>
                </div>
                
            
            </form>
</div>
</div>
</div>
</div>
</section>
</div>

<script>
$(document).ready(function(){
    
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
        var baseurl = "{{ url('/') }}";
    	var myForm = $('#quickForm');
    	var formData = myForm.serialize();
    	var final_totalQuesSum = parseInt($('#totalQuesSum').val());
    	if(final_totalQuesSum > 0){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/checkQuestionAvailability',
        	    data: formData,
        	    method: 'post',
        	    success: function(response){
        	        if(response.status == 1){
        	            alert(final_totalQuesSum + ' Questions are not in Database!');
        	        }else{
        	            $('#createExam').click();
        	        }
        			
        	    }
        	});
    	}else{
    	    alert('Please Fill Total Questions to take!');
    	}
    });     
    
    $(document).on('blur', '.appendData .checkQuestionCount', function() {
        var baseurl = "{{ url('/') }}";
        var thisInput = $(this);
    	var questionCount = $(this).val();
    	var questionTypeId = $(this).data('question_type_id');
    	if($(thisInput).hasClass('chapter')){
    	    var chapterOrTopic = 0;
    	    var chapterId = $(this).data('id');
    	    var topicId = 0;
    	}else if($(thisInput).hasClass('topic')){
    	    var chapterOrTopic = 1;
    	    var chapterId = $(this).data('chapter_id');
    	    var topicId = $(this).data('id');
    	}else{}
    	
    	if(questionCount > 0){
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/checkQuestionCount',
        	    data: {questionCount:questionCount, chapterId:chapterId, questionTypeId:questionTypeId, chapterOrTopic:chapterOrTopic, topicId:topicId},
        	    method: 'post',
        	    success: function(response){
        	        if(response.status == 1){
        	            alert(questionCount + ' Questions are not in Database!');
        	            $(thisInput).val('').focus();
        	        }else{}
        	    }
        	});
    	}else{}
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