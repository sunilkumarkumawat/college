@extends('layout.app')
@section('content')


    <div class="content-wrapper">

        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card card-outline card-orange">
                            <div class="card-header bg-primary">
                                <h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Online Exam</h3>

                                    <div class="card-tools">
                                        <a href="{{ url('digital/view/exam') }}" class="btn btn-primary btn-sm" id="back"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                            </div>

                            <div class="card-body">
                                <div class='row'>


                                    <div class='col-12 col-md-4'>
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
                                                    <form action='{{url("digitalExamTerminal")}}' method='post' >
                                                        @csrf
                                                    <div class='row  pb-3' >
                                                        <div class='col-6 col-md-6 text-center pb-3' id='dateWise' style=' border-bottom: 1px solid #6639b5  ;cursor:pointer'>
                                                            DateWise Search
                                                        </div>
                                                        <div class='col-6 col-md-6 text-center pb-3' id='chapterWise'style='cursor:pointer'>
                                                            ChapterWise Search
                                                        </div>


                                                    </div>
                                                    
                                                        
                                                        
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
                                                                        <option value="{{$item->id ?? ''}}" {{ ($item->id == $search["exam_pattern"]) ? 'selected' : '' }}>{{$item->name ?? ''}}</option>
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
                                                                        <option value="{{$item->id ?? ''}}" {{ ($item->id == $search["subject"]) ? 'selected' : '' }}>{{$item->name ?? ''}}</option>
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
                                                               
                                        <Button class='btn btn-primary' type='submit'>Search</Button>
                                 
                                                        </div>
                                                        
                                                        

                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class='col-12 col-md-8'>

                                        <div class='row'>
   @if(count($data) > 0)
                                                        
                                                        @foreach($data as $item)
                                                        
                                                        @php
                                                        
                                                        $count =0;
                                                        if(count($exam_count)>0)
                                                        {
                                                        foreach($exam_count as $sub_item)
                                                        {
                                                        if($item->id == $sub_item->exam_id)
                                                        {
                                                        $count++;
                                                        }
                                                        
                                                        }
                                                        }
                                                        
                                                        @endphp
                                                        
                                                  
                                            <div class="col-md-4 col-6">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title" style='cursor:pointer' data-toggle="tooltip" data-placement="top" title="{{$item->name ?? ''}}">{{substr($item->name ?? '',0,15).'...'}} </h3>
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
                                                                <a href="#" class="nav-link nav-color">
                                                                    <i class="fa fa-book"></i> Exam Id
                                                                    <span class="badge bg-primary float-right">{{$item->id ?? 'NA'}}</span>
                                                                </a>
                                                            </li>
                                                            @php
 $exam_time = \Carbon\Carbon::parse($item->exam_date ?? '');
@endphp
                                                            <li class="nav-item active">
                                                                <a href="#" class="nav-link nav-color">
                                                                    <i class="fa fa-calendar"></i> Create On
                                                                    <span
                                                                        class="badge bg-success float-right">{{date('d-m-Y h:i A', strtotime($item->created_at ?? 'NA' ?? ''))}}</span></br>
                                                                        
                                                                </a>
                                                            </li>
                                                            <li class="nav-item active">
                                                                <a href="#" class="nav-link nav-color">
                                                                    <i class="fa fa-check"></i> Start
                                                                    <span class="badge bg-success float-right">{{date('d-m-Y h:i A', strtotime($item->exam_date ?? 'NA')) }}
                                                                        </span>
                                                                </a>
                                                            </li>


                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link nav-color">
                                                                    <i class="fa fa-clock"></i> Exam Time Duration
                                                                    <span class="badge bg-warning float-right">{{$item->duration ?? 'NA'}} hr : {{$item->duration_minute ?? 'NA'}}
                                                                        min</span>
                                                                </a>
                                                            </li>
                                                            
                                                            @if($count >0)
                                                            
                                                            <li class="nav-item li_hover" data-toggle="tooltip" data-placement="top" title="Go to Analysis">
                                                                
                                                                <form action="{{ url('analysisPanel') }}" method="post">
                                                                    @csrf
                                                                    <input type='hidden' name='exam_id' value='{{$item->id ?? ''}}' />
                                                                <button  type='submit' class="btn btn-primary w-100">
                                                                    <i class="fa fa-check"></i> This Exam Given
                                                                   {{$count ?? 'NA'}} Times
                                                                </button>
                                                                
                                                                </form>
                                                            </li>
                                                            @endif
                                                            <li class="nav-item">
                                                                @if($exam_time->isPast())
  
                                                                   <form action="{{ url('digitalStartExam') }}" method="post">
                                                                    @csrf
                                                                    <input type='hidden' value="{{$item->id ?? ''}}" name='exam_id' />
                                                                    <button type="{{$item->result_status == 0 ? 'submit':'button'}}"
                                                                        class="btn btn-{{$item->result_status == 0 ? 'success':'danger'}} w-100 ">{{$item->result_status == 0 ? 'Start':'Ended'}}</button>
                                                                </form>
                                                                @else
                                                                   
                                                                 <button disabled type="button"
                                                                        class="btn btn-success w-100 ">Will Start Soon ....</button>
                                                                @endif
                                                                
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>

                                            </div>
                                          
                                           @endforeach
                                           @else
                                           <div class='col-md-12 text-center'>
                                               <h3> No Exam Found !!!</h3>
                                                                </div>
                                              
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
    <style>
        .nav-color {
            color: #6c757d !important;
        }
        .li_hover:hover {
            background: skyblue !important;
        }
    
    </style>
@endsection