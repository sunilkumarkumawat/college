@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
  $getChapter = Helper::getChapter();
  $getTopic = Helper::getTopic();
  $getLevel = Helper::getLevel();
  $getQuestionType = Helper::getQuestionType();
  $getSuka = Helper::getSuka();
  $getUploadBypic = Helper::getUploadBypic();
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
                    <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;Edit Question </h3>
                    <div class="card-tools">
                    <!--<a href="{{url('view/question')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> View </a>-->
                    <a href="{{url('digital/view/question')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('digital/edit/question') }}/{{ $data->id ?? '' }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
 
                    <div class="col-md-2">
            			<div class="form-group">
            				<label style="color:red;">Class </label>
            				<select class="select2 form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" required>
                             @if(!empty($classType)) 
                                  @foreach($classType as $class)
                                     <option value="{{ $class->id ?? ''  }}"  {{ $class->id == 3 ? 'disabled' : '' }}  {{ $class->id == old('class_type_id', $data->class_type_id) ? 'selected' : ''}}>{{ $class->id ?? ''  }} : {{ $class->name ?? ''  }}</option>
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
                    <div class="col-md-2">
            			<div class="form-group">
            				<label style="color:red;">{{ __('examination.Subject') }}</label>
            				<select class="select2 form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                             @if(!empty($getsubject)) 
                                  @foreach($getsubject as $subject)
                                     <option value="{{ $subject->id ?? ''  }}" {{ $subject->id == old('subject_id', $data->subject_id) ? 'selected' : ''}}>{{ $subject->id ?? ''  }} : {{ $subject->name ?? ''  }} {{ $subject['ClassTypes']['name'] ?? ''  }}</option>
                                  @endforeach
                              @endif
                            </select>
                             @error('subject_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Chapter</label>
            				<select class="select2 form-control @error('chapter_id') is-invalid @enderror" id="chapter_id" name="chapter_id" required>
                             @if(!empty($getChapter)) 
                                  @foreach($getChapter as $chapter)
                                     <option value="{{ $chapter->id ?? ''  }}" {{ $chapter->id == old('chapter_id', $data->chapter_id) ? 'selected' : ''}}>{{ $chapter->id ?? ''  }} : {{ $chapter->name ?? ''  }} </option>
                                  @endforeach
                              @endif
                            </select>
                             @error('chapter_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Topic</label>
            				<select class="select2 form-control @error('topic_id') is-invalid @enderror" id="topic_id" name="topic_id" required>
                             @if(!empty($getTopic)) 
                                  @foreach($getTopic as $topic)
                                     <option value="{{ $topic->id ?? ''  }}" {{ $topic->id == old('topic_id', $data->topic_id) ? 'selected' : ''}}>{{ $topic->id ?? ''  }} : {{ $topic->name ?? ''  }} </option>
                                  @endforeach
                              @endif
                            </select>
                             @error('topic_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div> 
                    <div class="col-md-2">
            			<div class="form-group">
            				<label style="color:red;">Level</label>
            				<select class="select2 form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id" required>
                                @if(!empty($getLevel)) 
                                  @foreach($getLevel as $level)
                                     <option value="{{ $level->id ?? ''  }}" {{ $level->id == old('level_id', $data->level_id) ? 'selected' : ''}}>{{ $level->id ?? ''  }} : {{ $level->name ?? ''  }} </option>
                                  @endforeach
                                @endif
                            </select>
                             @error('level_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div> 
                    <div class="col-md-2">
            			<div class="form-group">
            				<label style="color:red;">Q. Type SUKA</label>
            				<select class="select2 form-control @error('suka_id') is-invalid @enderror" id="suka_id" name="suka_id" required>
                                @if(!empty($getSuka)) 
                                  @foreach($getSuka as $suka)
                                     <option value="{{ $suka->id ?? ''  }}" {{ $suka->id == old('suka_id', $data->suka_id) ? 'selected' : ''}}>{{ $suka->id ?? ''  }} : {{ $suka->name ?? ''  }} </option>
                                  @endforeach
                                @endif
                            </select>
                             @error('suka_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div> 
 
                    <div class="col-md-2">
                        <div class="form-group">
                            <label style="color:red;"> {{ __('examination.Question Type') }}</label>
                            <select class="select2 form-control @error('question_type_id') is-invalid @enderror" id="question_type_id" name="question_type_id" required>
        					    @if(!empty($getQuestionType)) 
                                  @foreach($getQuestionType as $questionType)
                                     <option value="{{ $questionType->id ?? ''  }}" {{ $questionType->id == old('question_type_id', $data->question_type_id) ? 'selected' : ''}}>{{ $questionType->id ?? ''  }} : {{ $questionType->name ?? ''  }} </option>
                                  @endforeach
                                @endif
                            </select>
                             @error('question_type_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror                          
        				</div>
        			</div>
                </div>
                <div class="row m-2" id="parentDiv">
            		<div class="col-md-6">
            			<div class="form-group">
            				<label  style="color:red;">{{ __('examination.Question') }} in English</label>
            				<textarea class="form-control required summernote" id="name" name="name" placeholder="Type/paste your question in English"  required>{{ $data->name ?? old('name') }}</textarea>
            		    </div>
        		    </div> 
            		<div class="col-md-6">
            			<div class="form-group">
            				<label  style="">{{ __('examination.Question') }} in Hindi</label>
            				<textarea class="form-control summernote" id="hi_name" name="hi_name" placeholder="Type/paste your question in Hindi" >{{ $data->hi_name ?? old('hi_name') }}</textarea>
            		    </div>
        		    </div> 
        		    <div class="col-md-6 option_1">
            				       
            			<div class="form-group ">
            				<label style="color:red;">  {{ __('examination.Option') }}-1 </label>
        				    <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox" name="correct_ans" id="correct_ans" class="pointer appendRow_0 checkbox" data-id="0" value="1" {{ 1 == old('correct_ans', $data->correct_ans) ? 'checked' : '' }} >
                                </span>
                                </div>
                              	<textarea name="ans_a" id="ans_a" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 1" >{{ $data->ans_a ?? old('ans_a') }}</textarea>
                              	<textarea name="hi_ans_a" id="hi_ans_a" class="form-control checkAns numeric summernote" placeholder="{{ __('examination.Answer') }} 1 in Hindi" >{{ $data->hi_ans_a ?? old('hi_ans_a') }}</textarea>
                            </div>
            		    </div>
            		
    		        </div>
    	            <div class="col-md-6 option_2 numeric">
            			<div class="form-group ">
            				<label style="color:red;">  {{ __('examination.Option') }}-2 </label>
        				    <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox" name="correct_ans" class="pointer appendRow_0 checkbox" data-id="0" value="2" {{ 2 == old('correct_ans', $data->correct_ans) ? 'checked' : '' }}>
                                </span>
                                </div>
                              	<textarea name="ans_b" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 2" >{{ $data->ans_b ?? old('ans_b') }}</textarea>
                              	<textarea name="hi_ans_b" id="hi_ans_b" class="form-control checkAns numeric summernote" placeholder="{{ __('examination.Answer') }} 2 in Hindi" >{{ $data->hi_ans_b ?? old('hi_ans_b') }}</textarea>
                            </div>
            		    </div>
            		
    		        </div>
    	            <div class="col-md-6 option_3 numeric">
            				<div class="form-group ">
            				<label style="color:red;">  {{ __('examination.Option') }}-3 </label>
        				    <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox" name="correct_ans" class="pointer appendRow_0 checkbox" data-id="0" value="3" {{ 3 == old('correct_ans', $data->correct_ans) ? 'checked' : '' }}>
                                </span>
                                </div>
                              	<textarea name="ans_c" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 3" >{{ $data->ans_c ?? old('ans_c') }}</textarea>
                              	<textarea name="hi_ans_c" id="hi_ans_c" class="form-control checkAns numeric summernote" placeholder="{{ __('examination.Answer') }} 3 in Hindi" >{{ $data->hi_ans_c ?? old('hi_ans_c') }}</textarea>
                            </div>
            		    </div>
            		
    		        </div>
    	            <div class="col-md-6 option_4 numeric">
            		      	<div class="form-group ">
            				<label style="color:red;">  {{ __('examination.Option') }}-4 </label>
        				    <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                <input type="checkbox" name="correct_ans" class="pointer appendRow_0 checkbox" data-id="0" value="4" {{ 4 == old('correct_ans', $data->correct_ans) ? 'checked' : '' }}>
                                </span>
                                </div>
                                <textarea name="ans_d" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 4" >{{ $data->ans_d ?? old('ans_d') }}</textarea>
                                <textarea name="hi_ans_d" id="hi_ans_d" class="form-control checkAns numeric summernote" placeholder="{{ __('examination.Answer') }} 4 in Hindi" >{{ $data->hi_ans_d ?? old('hi_ans_d') }}</textarea>
                            </div>
            		    </div>
                    </div> 
            		<div class="col-md-6">
            			<div class="form-group">
            				<label  style="">Solution in English</label>
            				<textarea class="form-control summernote " id="solution" name="solution" placeholder="">{{ $data->solution ?? old('solution') }}</textarea>
            		    </div>
        		    </div>                                
            		<div class="col-md-6">
            			<div class="form-group">
            				<label  style="">Solution in Hindi</label>
            				<textarea class="form-control summernote" id="hi_solution" name="hi_solution" placeholder="">{{ $data->hi_solution ?? old('hi_solution') }}</textarea>
            		    </div>
        		    </div>                                
                </div>
                <div class="row m-2 pb-2">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary ">{{ __('common.Update') }}</button>
                    </div>
                </div>
                
            
            </form>
</div>
</div>
</div>
</div>
</section>
</div>

<style>
.note-statusbar, .note-toolbar {
    display: none !important;
}
.input-group .note-editor{
    width: 46%;
    height: 45px;
}
.input-group-prepend{
    height: 45px;
}
#uploadManually .row{
    width: 100%;
}
.form-group {
    /*margin-bottom : 0;*/
}
.card {
    margin-bottom: 0;
}
</style>
<script>
$(document).ready(function(){
    
    questionTypeCheck();
    
    $('.summernote').summernote({
        inheritPlaceholder: true,
    });  
    
    $('.checkAns').each(function(){
        var initialContent = $(this).val();
        $(this).summernote('code', initialContent);
    })

    $('#question_type_id').on('change', function(){
        questionTypeCheck();
    }); 
    
    function questionTypeCheck(){
        var question_type_id = $('#question_type_id').val();

        if(question_type_id == 2){
            $(".numeric").addClass('d-none');
            $("#correct_ans").attr('required', true);
        }else{
            $(".numeric").removeClass('d-none');
            $("#correct_ans").attr('required', false);
        }         
    }
    
    $(document).on('click', '#parentDiv :checkbox', function() {
        var $box = $(this);
        var boxGroupId = $(this).data('id');
        if ($box.is(":checked")) {
            $('.appendRow_' + boxGroupId).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });    
});
</script>
<script>
  $(document).on("change", "#ans_a", function() {
  alert($(this).val());
}); 
</script>
@endsection