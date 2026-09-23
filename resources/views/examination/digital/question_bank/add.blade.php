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
                    <h3 class="card-title"><i class="fa fa-check-square-o"></i> &nbsp; {{ __('examination.Add Questions') }}</h3>
                    <div class="card-tools">
                    <a href="{{ env('IMAGE_SHOW_PATH') . 'Ques Upload.docx' }}" class="btn btn-primary  btn-sm" title="Download Blank Docx" download><i class="fa fa-download"></i> Download Blank Docx </a>
                    <button type="button" class="btn btn-primary  btn-sm" title="View Id Information" data-toggle="modal" data-target="#idInfoModal"><i class="fa fa-info-circle"></i> Id Info </button>
                    <a href="{{url('digital/view/question')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
                    <a href="{{url('examination_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                    </div>
                    
                    </div>      



            <form id="quickForm" action="{{ url('digital/add/question') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="row m-2">
 
                    <div class="col-md-2">
            			<div class="form-group">
            				<label style="color:red;">Class </label>
            				<select class="select2 form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" required>
                             @if(!empty($classType)) 
                                  @foreach($classType as $class)
                                     <option value="{{ $class->id ?? ''  }}"  {{ $class->id == 3 ? 'disabled' : '' }}  {{ ($class->id == old('class_type_id')) ? 'selected' : '' }}>{{ $class->id ?? ''  }} : {{ $class->name ?? ''  }}</option>
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
                                     <option value="{{ $subject->id ?? ''  }}" {{ ($subject->id == old('subject_id')) ? 'selected' : '' }}>{{ $subject->id ?? ''  }} : {{ $subject->name ?? ''  }} {{ $subject['ClassTypes']['name'] ?? ''  }}</option>
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
                                     <option value="{{ $chapter->id ?? ''  }}" {{ ($chapter->id == old('subject_id')) ? 'selected' : '' }}>{{ $chapter->id ?? ''  }} : {{ $chapter->name ?? ''  }} </option>
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
                                     <option value="{{ $topic->id ?? ''  }}" {{ ($topic->id == old('topic_id')) ? 'selected' : '' }}>{{ $topic->id ?? ''  }} : {{ $topic->name ?? ''  }} </option>
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
                                     <option value="{{ $level->id ?? ''  }}" {{ ($level->id == old('level_id')) ? 'selected' : '' }}>{{ $level->id ?? ''  }} : {{ $level->name ?? ''  }} </option>
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
                                     <option value="{{ $suka->id ?? ''  }}" {{ ($suka->id == old('suka_id')) ? 'selected' : '' }}>{{ $suka->id ?? ''  }} : {{ $suka->name ?? ''  }} </option>
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
                                 <option value="{{ $questionType->id ?? ''  }}" {{ ($questionType->id == old('question_type_id')) ? 'selected' : '' }}>{{ $questionType->id ?? ''  }} : {{ $questionType->name ?? ''  }} </option>
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
        			<!--<div class="col-md-2">
            			<div class="form-group">
            			    <label style="color:red;"> Pattern</label>
            				<select class="select2 form-control" id="" name="pattern_id" >
                                <option value="">Select Pattern</option>
                                <option value="0">JEE MAIN</option>
                                <option value="1">JEE ADVANCE</option>
                                <option value="2">NEET</option>
                            </select>
            		    </div>
            		</div>-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label style="color:red;"> Add Ques. By</label>
                            <select class="select2 form-control @error('upload_by_id') is-invalid @enderror" id="upload_by_id" name="upload_by_id">
    					    @if(!empty($getUploadBypic)) 
                              @foreach($getUploadBypic as $uploadBy)
                                 <option value="{{ $uploadBy->id ?? ''  }}" {{ ($uploadBy->id == old('upload_by_id')) ? 'selected' : '' }}>{{ $uploadBy->id ?? ''  }} : {{ $uploadBy->name ?? ''  }} </option>
                              @endforeach
                            @endif
                            </select>
                             @error('upload_by_id')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror                          
        				</div>
        			</div>
        			
        			<div class="col-md-2" id="uploadDocs">
                        <label style="color:red;">Upload Docs </label>
                        <input class="form-control" type="file" id="docs" name="docs" required="">
                    </div>
        
                </div>
                
                <div id="parentDiv">
                    <div class="row m-2 d-none" id="uploadManually">
                    <div class="row border-bottom border-warning" id="appendRow_0" >
                        <div class="col-md-11">
                            <div class="row" id="">
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label  style="color:red;">{{ __('examination.Question') }} in English</label>
                        				<textarea class="form-control required summernote" id="name" name="name[]" placeholder="Type/paste your question in English" ></textarea>
                        		    </div>
                    		    </div> 
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label  style="">{{ __('examination.Question') }} in Hindi</label>
                        				<textarea class="form-control summernote" id="hi_name" name="hi_name[]" placeholder="Type/paste your question in Hindi" ></textarea>
                        		    </div>
                    		    </div> 
                    		    <div class="col-md-6 option_1">
                        				       
                        			<div class="form-group ">
                        				<label style="color:red;">  {{ __('examination.Option') }}-1 </label>
                    				    <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <input type="checkbox" name="correct_ans[]" class="pointer appendRow_0 checkbox" data-id="0" value="1" checked>
                                            </span>
                                            </div>
                                          	<textarea type="text"  name="ans_a[]" id="ans_a" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 1" ></textarea>
                                          	<textarea type="text"  name="hi_ans_a[]" id="hi_ans_a" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 1 in Hindi"></textarea>
                                        </div>
                        		    </div>
                        		
                		        </div>
                	            <div class="col-md-6 option_2 numeric">
                        			<div class="form-group ">
                        				<label style="color:red;">  {{ __('examination.Option') }}-2 </label>
                    				    <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <input type="checkbox" name="correct_ans[]" class="pointer appendRow_0 checkbox" data-id="0" value="2">
                                            </span>
                                            </div>
                                          	<textarea type="text" name="ans_b[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 2" ></textarea>
                                          	<textarea type="text" name="hi_ans_b[]" id="hi_ans_b" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 2 in Hindi"></textarea>
                                        </div>
                        		    </div>
                        		
                		        </div>
                	            <div class="col-md-6 option_3 numeric">
                        				<div class="form-group ">
                        				<label style="color:red;">  {{ __('examination.Option') }}-3 </label>
                    				    <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <input type="checkbox" name="correct_ans[]" class="pointer appendRow_0 checkbox" data-id="0" value="3">
                                            </span>
                                            </div>
                                          	<textarea type="text"  name="ans_c[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 3" ></textarea>
                                          	<textarea type="text"  name="hi_ans_c[]" id="hi_ans_c" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 3 in Hindi"></textarea>
                                        </div>
                        		    </div>
                        		
                		        </div>
                	            <div class="col-md-6 option_4 numeric">
                        		      	<div class="form-group ">
                        				<label style="color:red;">  {{ __('examination.Option') }}-4 </label>
                    				    <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                            <input type="checkbox" name="correct_ans[]" class="pointer appendRow_0 checkbox" data-id="0" value="4">
                                            </span>
                                            </div>
                                            <textarea type="text"  name="ans_d[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 4" ></textarea>
                                            <textarea type="text"  name="hi_ans_d[]" id="hi_ans_d" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 4 in Hindi"></textarea>
                                        </div>
                        		    </div>
                                </div> 
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label  style="">Solution in English</label>
                        				<textarea class="form-control summernote " id="solution" name="solution[]" placeholder=""></textarea>
                        		    </div>
                    		    </div>                                
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label  style="">Solution in Hindi</label>
                        				<textarea class="form-control summernote" id="hi_solution" name="hi_solution[]" placeholder=""></textarea>
                        		    </div>
                    		    </div>                                
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button>
                                <!--<button type="button" class="btn btn-danger btn-sm removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button>-->
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                     



                    <div class="row m-2 pb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                
            
            </form>
</div>
</div>
</div>
</div>
</section>
</div>

<div class="modal fade" id="idInfoModal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Id Informations for Upload Questions by Docs File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row m-2">
 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : Class </label>
            				<select class="select2 form-control @error('class_type_id') is-invalid @enderror" id="" name="" >
                             @if(!empty($classType)) 
                                  @foreach($classType as $class)
                                     <option value="{{ $class->id ?? ''  }}" {{ $class->id == 3 ? 'disabled' : '' }} {{ ($class->id == old('class_type_id')) ? 'selected' : '' }}>{{ $class->id ?? ''  }} : {{ $class->name ?? ''  }}</option>
                                  @endforeach
                              @endif
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : {{ __('examination.Subject') }}</label>
            				<select class="select2 form-control @error('subject_id') is-invalid @enderror" id="" name="" >
                             @if(!empty($getsubject)) 
                                  @foreach($getsubject as $subject)
                                     <option value="{{ $subject->id ?? ''  }}" {{ ($subject->id == old('subject_id')) ? 'selected' : '' }}>{{ $subject->id ?? ''  }} : {{ $subject->name ?? ''  }} {{ $subject['ClassTypes']['name'] ?? ''  }}</option>
                                  @endforeach
                              @endif
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : Chapter</label>
            				<select class="select2 form-control @error('chapter_id') is-invalid @enderror" id="" name="" >
                             @if(!empty($getChapter)) 
                                  @foreach($getChapter as $chapter)
                                     <option value="{{ $chapter->id ?? ''  }}" {{ ($chapter->id == old('subject_id')) ? 'selected' : '' }}>{{ $chapter->id ?? ''  }} : {{ $chapter->name ?? ''  }} </option>
                                  @endforeach
                              @endif
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : Topic</label>
            				<select class="select2 form-control @error('topic_id') is-invalid @enderror" id="" name="" >
                             @if(!empty($getTopic)) 
                                  @foreach($getTopic as $topic)
                                     <option value="{{ $topic->id ?? ''  }}" {{ ($topic->id == old('topic_id')) ? 'selected' : '' }}>{{ $topic->id ?? ''  }} : {{ $topic->name ?? ''  }} </option>
                                  @endforeach
                              @endif
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : Level</label>
            				<select class="select2 form-control @error('level_id') is-invalid @enderror" id="" name="" >
                                <option value="1">1 : Easy</option>
                                <option value="2">2 : Medium</option>
                                <option value="3">3 : Difficult</option>
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
            			<div class="form-group">
            				<label style="color:red;">Id : Q. Type SUKA</label>
            				<select class="select2 form-control @error('suka_id') is-invalid @enderror" id="" name="" >
                                <option value="1">1 : S - Skill</option>
                                <option value="2">2 : U - Understanding</option>
                                <option value="3">3 : K - Knowledge</option>
                                <option value="4">4 : A - Application</option>
                            </select>
            		    </div>
            		</div> 
                    <div class="col-md-4">
                            <div class="form-group">
                                <label style="color:red;">Id : {{ __('examination.Question Type') }}</label>
                                <select class="select2 form-control @error('question_type_id') is-invalid @enderror" id="" name="">
        					    <option value="1" >1 : Objective</option>
        					    <option value="2" >2 : Numeric </option>
                            </select>                         
        				</div>
        			</div>
        			
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
.card {
    margin-bottom: 0;
}
</style>

<script>

$(document).ready(function() { 
    
    $('.summernote').summernote({
        inheritPlaceholder: true,
    });
    
    $('#upload_by_id').on('change', function(){
      
    	var upload_by_id = $(this).val();

    	if(upload_by_id == 1){
    	    $('#uploadDocs').removeClass('d-none');
    	    $('#uploadManually').addClass('d-none');
    	    $('#docs').attr('required', true);
    	    //$('.required').attr('required', false);
    	}else if(upload_by_id == 2){
    	    $('#uploadDocs').addClass('d-none');
    	    $('#uploadManually').removeClass('d-none');
    	    $('#docs').attr('required', false);
    	    //$('.required').attr('required', true);
    	}else{
    	    
    	}
	
    }); 

    $('#question_type_id').on('change', function(){
        questionTypeCheck();
    }); 
    
    function questionTypeCheck(){
        var question_type_id = $('#question_type_id').val();

        if(question_type_id == 2){
            $(".numeric").addClass('d-none');
            //$('.numeric').attr('required', false);
        }else{
            $(".numeric").removeClass('d-none');
            //$('.numeric').attr('required', true);
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

    count=0;
        $( ".removeprodtxtbx" ).eq( 0 ).css( "display", "none" );
        $(document).on("click", "#clonebtn", function() {
    count++;
        $('#uploadManually').append('<div class="row border-bottom border-warning" id="appendRow_'+count+'"><div class="col-md-11"><div class="row" id=""><div class="col-md-6"><div class="form-group"><label  style="color:red;">{{ __('examination.Question') }} in English</label><textarea class="form-control required summernote" id="name" name="name[]" placeholder="Type/paste your question in English" ></textarea></div></div><div class="col-md-6"><div class="form-group"><label  style="">{{ __('examination.Question') }} in Hindi</label><textarea class="form-control summernote" id="hi_name" name="hi_name[]" placeholder="Type/paste your question in Hindi"></textarea></div></div><div class="col-md-6 option_1"><div class="form-group "><label style="color:red;">  {{ __('examination.Option') }}-1 </label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" name="correct_ans[]" class="pointer checkbox checkbox appendRow_'+count+'" data-id="'+count+'" value="1" checked></span></div><input type="text"  name="ans_a[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 1" ><input type="text"  name="hi_ans_a[]" id="hi_ans_a" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 1 in Hindi" ></div></div></div><div class="col-md-6 option_2 numeric"><div class="form-group "><label style="color:red;">  {{ __('examination.Option') }}-2 </label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" name="correct_ans[]" class="pointer checkbox appendRow_'+count+'" data-id="'+count+'" value="2"></span></div><input type="text" name="ans_b[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 2" ><input type="text" name="hi_ans_b[]" id="hi_ans_b" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 2 in Hindi"></div></div></div><div class="col-md-6 option_3 numeric"><div class="form-group "><label style="color:red;">  {{ __('examination.Option') }}-3 </label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" name="correct_ans[]" class="pointer checkbox appendRow_'+count+'" data-id="'+count+'" value="3"></span></div><input type="text"  name="ans_c[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 3" ><input type="text"  name="hi_ans_c[]" id="hi_ans_c" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 3 in Hindi"></div></div></div><div class="col-md-6 option_4 numeric"><div class="form-group "><label style="color:red;">  {{ __('examination.Option') }}-4 </label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" name="correct_ans[]" class="pointer checkbox appendRow_'+count+'" data-id="'+count+'" value="4"></span></div><input type="text"  name="ans_d[]" id="" class="form-control checkAns required summernote" placeholder="{{ __('examination.Answer') }} 4" ><input type="text"  name="hi_ans_d[]" id="hi_ans_d" class="form-control numeric summernote" placeholder="{{ __('examination.Answer') }} 4 in Hindi"></div></div></div><div class="col-md-6"><div class="form-group"><label  style="">Solution in English</label><textarea class="form-control summernote" id="solution" name="solution[]" placeholder=""></textarea></div></div><div class="col-md-6"><div class="form-group"><label  style="">Solution in Hindi</label><textarea class="form-control summernote" id="hi_solution" name="hi_solution[]" placeholder=""></textarea></div></div></div></div><div class="col-md-1 text-center"><div class="form-group "><button type="button" class="btn btn-primary btn-sm addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-danger btn-sm removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button></div></div></div>');

        $( ".removeprodtxtbx" ).eq( count ).css( "display", "block" );
        $( ".addmoreprodtxtbx" ).eq( count ).css( "display", "none" );
            questionTypeCheck();
            $('.summernote').summernote({
                inheritPlaceholder: true,
            });
        });
            
        $(document).on("click", "#removerow", function() {
            $(this).parent().parent().parent('div').remove();
            count--;
        });    
});

</script>

<script>
  $(document).on("change", "#ans_a", function() {
  alert($(this).val());
}); 
</script>

@endsection