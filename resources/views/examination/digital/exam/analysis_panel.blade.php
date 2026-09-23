@extends('layout.app')
@section('content')
    <div class="content-wrapper">

        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card card-outline card-orange">
                            <div class="card-header bg-primary">
                                <h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Online Exam Analysis</h3>

                                    <div class="card-tools">
                                      
                                        
                                        @if(Session::get('role_id') == 1)
                                        <a href="{{ url('view/exam') }}" class="btn btn-primary btn-sm" id="back"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                @else
                                 <a href="{{ url('view/exam/student') }}" class="btn btn-primary btn-sm" id="back"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                @endif
                                    </div>

                            </div>

                            <div class="card-body">
                                <div class='row'>


                                    <div class='col-12 col-md-3'>
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo"
                                                        aria-expanded="true">
                                                        Assignment Section
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" data-parent="#accordion"
                                                style="">
                                                <div class="card-body">

                                                   <div class='row  pb-3' >
                                                        <div class='col-6 col-md-6 text-center pb-3' id='dateWise' style=' border-bottom: 1px solid #6639b5  ;cursor:pointer'>
                                                            DateWise Search
                                                        </div>
                                                        <div class='col-6 col-md-6 text-center pb-3' id='chapterWise'style='cursor:pointer'>
                                                            ChapterWise Search
                                                        </div>


                                                    </div>
                                                    <form action='{{url("examTerminal")}}' method='post' >
                                                        @csrf
                                                        
                                                        
 <div class='row pb-3  dateWise_tab' style='border-bottom: 1px solid lightgrey'>
     
                                                        <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">From Date</label>
                                                            
                                                                <input type='date' name='from_date' value='{{$search["from_date"] == null ? now()->subDays(7)->format("Y-m-d") : $search["from_date"]}}'class='form-control' />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">To Date</label>
                                                            <input type='date' name='to_date' value='{{$search["to_date"] == null ? now()->format("Y-m-d") : $search["to_date"]}}'class='form-control' />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-12 pb-2 text-center">
                                                               
                                        <Button type='submit'class='btn btn-primary'>Search</Button>
                                 
                                                        </div>
                                                        
                                                        

                                                    </div>
                                                    </form>

                                                     <div class='row  chapterWise_tab' style='border-bottom: 1px solid lightgrey'>
                                                        
                                                      
                                                        <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">Exam Status</label>
                                                                <select class="form-control " name=""
                                                                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                    <option value="" data-select2-id="3">All</option>


                                                                    <option value="1">Pending</option>
                                                                    <option value="2">Solved</option>
                                                                    <option value="3">Upcomming</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                              <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">Exam Pattern</label>
                                                            @php
                                                            $exam_pattern = DB::table('exam_patterns_digital')->whereNull('deleted_at')->get();
                                                            @endphp
                                                                
                                                                <select class="form-control " name="exam_pattern"
                                                                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                    <option value="" data-select2-id="3">All</option>
                                                                        @if(!empty($exam_pattern))
                                                                        @foreach($exam_pattern as $item)
                                                                        <option value="{{$item->id ?? ''}}">{{$item->name ?? ''}}</option>
                                                                        @endforeach
                                                                        @endif

                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                              <div class='row  chapterWise_tab' style='border-bottom: 1px solid lightgrey'>
                                                    <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">Subject</label>
                                                                @php
                                                            $subjects = DB::table('subject')->whereIn('class_type_id',[Session::get('class_type_id'),3])->whereNull('deleted_at')->get();
                                                            @endphp
                                                                <select class="form-control " name="subject" id='subject'
                                                                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                    <option value="" data-select2-id="3">All</option>

                                                                        @if(!empty($subjects))
                                                                        @foreach($subjects as $item)
                                                                        <option value="{{$item->id ?? ''}}">{{$item->name ?? ''}}</option>
                                                                        @endforeach
                                                                        @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                            <div class="col-md-6 col-6">
                                                            <div class="form-group">
                                                                <label style="color:#6639b5">Chapter Name</label>
                                                                  @php
                                                            $chapters = DB::table('chapters_digital')->whereIn('class_type_id',[Session::get('class_type_id'),3])->whereNull('deleted_at')->get();
                                                            @endphp
                                                                <select class="form-control " name="chapters" id='chapters'
                                                                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                    <option value="" data-select2-id="3">All</option>

                                                                        <!--@if(!empty($chapters))-->
                                                                        <!--@foreach($chapters as $item)-->
                                                                        <!--<option value="{{$item->id ?? ''}}">{{$item->name ?? ''}}</option>-->
                                                                        <!--@endforeach-->
                                                                        <!--@endif-->

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-12 pb-2 text-center">
                                                               
                                        <Button class='btn btn-primary'>Search</Button>
                                 
                                                        </div>
                                                        
                                                        

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class='col-12 col-md-9'>

                                        <div class='row'>
                                                    @if(count($data) > 0)
                                                        
                                                        @foreach($data as $item)
                                           
                                                         <div class="col-md-3 col-6">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <span style='font-size:18px;cursor:pointer 'class="card-title" data-toggle="tooltip" data-placement="top" title="{{$item->exam_name ?? ''}}">{{substr($item->exam_name ?? '',0,20).'...'}}</span>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body p-0" style="display: block;">
                                                        <ul class="nav nav-pills flex-column">
                                                            
                                                            <li class="nav-item active">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-calendar"></i> Date
                                                                    <span
                                                                        class="badge bg-success float-right"> {{date('d-m-Y h:i A', strtotime($item->created_at ?? ''))}}</span>
                                                                </a>
                                                            </li>
                                                           


                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-clock"></i> Time Taken
                                                                    
                                                                    
                                                                    <!--<span class="badge bg-warning float-right">{{$item->exam_time ?? ''}} -->
                                                                    <!--    min</span>-->
                                                                        <span class="badge bg-success float-right"> {{$item->time ?? ''}} - 
                                                                        min</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-question"></i> Total Question
                                                                    <span class="badge bg-primary float-right">{{$item->total_ques ?? ''}}
                                                                        </span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-check"></i> Correct
                                                                    <span class="badge bg-success float-right">{{$item->correct_ans ?? ''}}
                                                                        </span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-times"></i> Wrong
                                                                    <span class="badge bg-danger float-right">{{$item->wrong_ans ?? ''}}
                                                                        </span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-forward"></i> Skip
                                                                    <span class="badge bg-secondary float-right">{{$item->skip_ques ?? ''}}
                                                                        </span>
                                                                </a>
                                                            </li>
                                                         
                                                            
                                                            @php 
                                                         
                                                         
                                                         
                                                             $percentage = (((($item->correct_ans ?? 0)*4) + (($item->wrong_ans ?? 0)*-1))/(($item->total_ques ?? 0)*4))*100;
                                                             
                                                           if($percentage < 0)
                                                           {
                                                           $percentage =0;
                                                           }
                                                            
                                                            @endphp
                                                            <li class="nav-item {{$percentage < 40 ? 'bg-danger' : ''}} {{$percentage > 40 && $percentage < 70  ? 'bg-warning' : ''}}{{$percentage > 70 ? 'bg-success' : ''}}">
                                                                <a href="#" class="nav-link_1 nav-color">
                                                                    <i class="fa fa-percent"></i> Percentage
                                                                    <span class="badge bg-secondary float-right">{{ $percentage ?? 0}}%
                                                                        </span>
                                                                </a>
                                                            </li>
                                                            
                                                            <li class="nav-item  text-center">
                                                                <!--<form action='{{url("downloadAnswerKey")}}' method='post' >-->
                                                                <form target='_blank'action='{{url("digitalDownloadAnswerKey")}}' method='post' >
                                                                    @csrf
                                                                    
                                                                    <input type='hidden' name='exam_result_id' value='{{$item->id ?? ""}}' />
                                                                <button  type ='submit'class="btn btn-secondary w-100" style='font-size:12px !important'>
                                                                    <i class="fa fa-download"></i> Answer Key
                                                                   
                                                                </button>
                                                                </form>
                                                            </li>
                                                            <li class="nav-item  text-center">
                                                                <form target='_blank' action='{{url("digitalQuestionKey")}}' method='post' >
                                                                    @csrf
                                                                      <input type='hidden' name='exam_result_id' value='{{$item->id ?? ""}}' />
                                                                      
                                                                 
                                                                <button  type ='submit'class="btn btn-secondary w-100" style='font-size:12px !important'>
                                                                    <i class="fa fa-download"></i> Marksheet
                                                                   
                                                                </button>
                                                                </form>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="{{ url('digitalExamAnalysis') }}/{{$item->id ?? ''}}" class='w-100 ' >
                                                                    <button type="submit"
                                                                        class="btn btn-success w-100 " style='font-size:12px !important'>Analysis & Review</button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>

                                            </div>
                                                        
                                                        @endforeach
                                                        
                                                        @else
                                                        
                                                        <div class="col-md-12 col-12 text-center">
                                                            <h3>No Data Found For Analysis !!!</h3>
                                                                </div>
                                                        @endif
                                           
                                         


                                        </div>
                                      
                                    </div>



                                </div>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
<script>
   
   
    $("#subject").on("change", function(){
          
        var baseurl = "{{ url('/') }}";
        var subject_id = $(this).val();
   $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        	    url: baseurl + '/getChapters',
        	    data: {subject_id:subject_id
        	    },
        	    method: 'post',
        	    success: function(response){
        	      
        
        	$.each(response.chapters, function(index, value) {
        	    
        	       var newOption = $("<option>").attr("value", value.id).text(value.name);
                $('#chapters').append(newOption);
});
        
        	          
        	        
        	          
        	    }
        	});
}); 
         
   
</script>
<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$( ".chapterWise_tab" ).hide();
$( "#dateWise" ).on( "click", function() {
  $('.dateWise_tab').show();
  $('#dateWise').css('border-bottom','1px solid #6639b5');
  $('#chapterWise').css('border-bottom','0px solid #6639b5');
  $('.chapterWise_tab').hide();
});
$( "#chapterWise" ).on( "click", function() {
  $('.dateWise_tab').hide();
  $('.chapterWise_tab').show();
   $('#dateWise').css('border-bottom','0px solid #6639b5');
  $('#chapterWise').css('border-bottom','1px solid #6639b5');
});
</script>


    <style>
        .nav-color {
            color: #6c757d !important;
        }
        .nav-link_1{
            display: block;
            padding-left: .5rem;
            padding-right: .5rem;
            font-size:12px;
        }
    </style>
@endsection