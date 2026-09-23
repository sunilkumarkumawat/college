@extends('layout.app') 
@section('content')
@php
$classType = Helper::classType();
$getallStudent = Helper::getallStudent();
$getExamType = Helper::getExamType();
$getSubject = Helper::getSubject();

@endphp
<div class="content-wrapper">
<section class="content pt-3">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
               <div class="card-header bg-primary">
                  <h3 class="card-title"><i class="fa fa-bar-chart"></i> &nbsp; Examination Result Statistics Graph </h3>
                  <div class="card-tools cl-6"> 
                   
                     <a href="{{ url('examination_dashboard') }}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}  </a> 
                  </div>
               </div>
               <div class="card-body">

                    <form id="quickForm_find" action="{{ url('examResultGraph') }}" method="post" >
                         @csrf 
                         <div class="row">
                            <div class="col-md-2 col-12">
                               <div class="form-group">
                                  <label class="text-danger">{{ __('messages.Exam Name') }}*</label>
                                  <select class="select2 form-control exam_id_" id="exam_id" name="exam_id" >
                                     <option value="">{{ __('messages.Select') }}</option>
                                     @if(!empty($getExamType)) 
                                    
                                     @foreach($getExamType as $type)
                                     <option value="{{ $type->id}} " {{ ($type->id == $search['exam_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                     @endforeach
                                     @endif
                                     @error('exam_id')
                                     <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                     </span>
                                     @enderror
                                  </select>
                               </div>
                            </div>                             
                            <div class="col-md-2 col-12">
                               <div class="form-group">
                                  <label class="text-danger">{{ __('messages.Class') }}*</label>
                                  <select class="select2 form-control @error('class_type_id') is-invalid @enderror " id="class_type_id" name="class_type_id" >
                                     <option value="">{{ __('messages.Select') }}</option>
                                     @if(!empty($classType))
                                     @foreach($classType as $class)
                                     <option value="{{ $class->id ?? ''  }}" {{ ($class->id == $search['class_type_id']) ? 'selected' : '' }}>{{ $class->name ?? ''  }}</option>
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
                            <div class="col-md-2 col-12">
    							<div class="form-group">
    								<label class="text-danger">Subjects*</label>
    								<select class="form-control invalid select2 @error('subject_id') is-invalid @enderror " id="subject_id" name="subject_id" >
    									<option value="">Select</option>
    									@if(!empty($getSubject))
                                         @foreach($getSubject as $subject)
                                         <option value="{{ $subject->id ?? ''  }}" {{ ($subject->id == $search['subject_id']) ? 'selected' : '' }}>{{ $subject->name ?? ''  }}</option>
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
    						<div class="col-md-3 col-12 align-content-end">
    							<div class="form-group">
    								<div class="icheck-warning d-inline">
                                        <input type="radio" id="pattern1" name="pattern" value="1" checked {{ (1 == $search['pattern']) ? 'checked' : '' }}>
                                        <label for="pattern1">Exam Wise</label>
                                    </div>
                                    <div class="icheck-warning d-inline">
                                        <input type="radio" id="pattern2" name="pattern" value="2" {{ (2 == $search['pattern']) ? 'checked' : '' }}>
                                        <label for="pattern2">Student Wise</label>
                                    </div>
    							</div>
    						</div>
    						<div class="col-md-2 col-12 align-content-end ">
    							<div class="form-group">
    							<div class="icheck-success d-inline">
                                    <input type="checkbox" id="toppers" value="1" name="toppers" {{ (1 == $search['toppers']) ? 'checked' : '' }}>
                                    <label for="toppers">Show Toppers</label>
                                    </div>
    							</div>
    						</div>
                            <div class="col-md-8 col-12">
                                <label class="text-danger">Students*</label>
                               <div class="form-group input-group">
                                  
                                  <select class="select2 form-control @error('admission_id') is-invalid @enderror" id="admission_id" name="admission_id[]" multiple >
                                     <option value="">{{ __('messages.Select') }}</option>
                                    @if(!empty($getallStudent))
                                     @foreach($getallStudent as $stu)
                                     <option value="{{ $stu->id ?? ''  }}" {{ !empty($search['admission_id']) ? in_array($stu->id, $search['admission_id'])  ? 'selected' : '' : '' }}>{{ $stu->first_name ?? ''  }} {{ $stu->last_name ?? ''  }}</option>
                                     @endforeach
                                     @endif
                                  </select>
                                  <span class="input-group-append">
                                <button type="button" id="allSelect" class="btn btn-success ">Select All</button>
                                </span>
                                  @error('admission_id')
                                  <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                               </div>

                            </div>
                            <div class="col-md-1 text-right">
                                <div class="form-group">
                               <label for="" class="text-white">Submit</label>
                               <button type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                               </div>
                            </div>
                         </div>
                    </form>
                    
                    @if(!empty($exam))
                    
                        <div class="row">
                            @if($search['pattern'] == 1)
                                
                                @if(!empty($search['toppers']) && $search['toppers'] == 1)
                                    
                                        @foreach($exam as $exa)
                                            @php
                                                $student = DB::table('admissions')->select('admissions.*')->leftJoin('fill_marks','admissions.id','fill_marks.admission_id')->where('admissions.class_type_id', $exa->class_type_id)->where('admissions.status',1)->whereNull('admissions.deleted_at')->groupBy('admissions.id')->orderBy('fill_marks.student_marks', 'DESC')->take(3)->get();
                                                
                                            @endphp
                                            @foreach($student as $key => $studen)
                                                <span class="examValues" data-id="barChart_{{ $exa->id ?? '' }}" data-subject="{{ $studen->first_name ?? '' }}"></span>
                                                @php
                                                    $mark = DB::table('fill_marks')->where('exam_id', $exa->id)->where('admission_id', $studen->id)->first();
                                                @endphp
                                                <span class="markValues" data-id="barChart_{{ $exa->id ?? '' }}" data-mark="{{ $mark->student_marks ?? '' }}"></span>
                                            @endforeach   
                                           
                                            <div class="col-md-6">
                                                
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fa fa-trophy"></i> {{ $exa['Exam']->name ?? '' }} : {{ $exa['ClassType']->name ?? '' }} : {{ $exa['Subject']->name ?? '' }} <i class="fa fa-angellist"></i> </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                            <canvas id="barChart_{{ $exa->id ?? '' }}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 645px;" width="1290" height="500" class="chartjs-render-monitor barChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>    
        
                                            </div>
                                        @endforeach
                                
                                @else
                                        
                                        @foreach($exam as $exa)
                                            @php
                                                $student = DB::table('admissions')->where('class_type_id', $exa->class_type_id)->whereIn('id', $studentId)->where('status',1)->whereNull('deleted_at')->orderBy('first_name')->get();
                                                $avgPercent = 0;
                                                $ap = 0;
                                                $averagePercent = 0;
                                            @endphp
                                            @foreach($student as $studen)
                                                <span class="examValues" data-id="barChart_{{ $exa->id ?? '' }}" data-subject="{{ $studen->first_name ?? '' }}"></span>
                                                @php
                                                    $mark = DB::table('fill_marks')->where('exam_id', $exa->id)->where('admission_id', $studen->id)->first();
                                                  if(!empty($mark)){
                                                    $avgPercent = $avgPercent += $mark->percent;
                                                    }
                                                    $ap++;
                                                @endphp
                                                <span class="markValues" data-id="barChart_{{ $exa->id ?? '' }}" data-mark="{{ $mark->student_marks ?? '' }}"></span>
                                            @endforeach   
                                                @if($avgPercent > 0)
                                                    @php
                                                        $averagePercent = $avgPercent / $ap;
                                                    @endphp
                                                @endif
                                            <div class="col-md-6">
                                                
                                                <div class="card card-light">
                                                    <div class="card-header">
                                                        <h3 class="card-title">{{ $exa['Exam']->name ?? '' }} : {{ $exa['ClassType']->name ?? '' }} : {{ $exa['Subject']->name ?? '' }} </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                            <canvas id="barChart_{{ $exa->id ?? '' }}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 645px;" width="1290" height="500" class="chartjs-render-monitor barChart"></canvas>
                                                            <div class="progress">
                                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                                                              aria-valuenow="{{ $averagePercent ?? '' }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $averagePercent ?? '' }}%">
                                                                <span class="font-weight-bolder">Overall {{ round($averagePercent, 2) ?? '' }}% &nbsp; @if($averagePercent >= 80)<i class="fa fa-trophy text-warning"></i> @elseif($averagePercent <= 30) <i class="fa fa-thumbs-down text-warning"></i> @else<i class="fa fa-thumbs-up text-warning"></i> @endif</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
        
                                            </div>
                                        @endforeach                                
                                
                                @endif
                                
                                
                            @elseif($search['pattern'] == 2)
                                
                                @if(!empty($search['toppers']) && $search['toppers'] == 1)
                                
                                        @foreach($studentId as $studen)
                                            @php
                                                $avgPercent = 0;
                                                $ap = 0;
                                                $averagePercent = 0;
                                            @endphp
                                            @foreach($exam as $exa)
                                                <span class="examValues" data-id="barChart_{{ $studen->id ?? '' }}" data-subject="{{ $exa['Exam']->name ?? '' }} : {{ $exa['Subject']['name'] ?? '' }} : {{ date('d-m-y', strtotime($exa['date'])) ?? '' }} "></span>
                                                @php
                                                    $mark = DB::table('fill_marks')->where('exam_id', $exa->id)->where('admission_id', $studen->id)->first();
                                                   if(!empty($mark)){
                                                    $avgPercent = $avgPercent += $mark->percent;
                                                    }
                                                    $ap++;
                                                @endphp
                                                <span class="markValues" data-id="barChart_{{ $studen->id ?? '' }}" data-mark="{{ $mark->student_marks ?? '' }}"></span>
                                            @endforeach   
                                                @if($avgPercent > 0)
                                                    @php
                                                        $averagePercent = $avgPercent / $ap;
                                                    @endphp
                                                @endif
                                            <div class="col-md-6">
                
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fa fa-trophy"></i> {{ $studen->first_name ?? '' }} {{ $studen->last_name ?? '' }} : {{ $studen['ClassTypes']->name ?? '' }} <i class="fa fa-angellist"></i> </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                            <canvas id="barChart_{{ $studen->id ?? '' }}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 645px;" width="1290" height="500" class="chartjs-render-monitor barChart"></canvas>
                                                            <div class="progress">
                                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                                                              aria-valuenow="{{ $averagePercent ?? '' }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $averagePercent ?? '' }}%">
                                                                <span class="font-weight-bolder">Overall {{ round($averagePercent, 2) ?? '' }}% &nbsp; @if($averagePercent >= 80)<i class="fa fa-trophy text-warning"></i> @elseif($averagePercent <= 30) <i class="fa fa-thumbs-down text-warning"></i> @else<i class="fa fa-thumbs-up text-warning"></i> @endif</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                
                                            </div>
                                        @endforeach                                
                                
                                @else
                                
                                        @foreach($studentId as $studen)
                                            @php
                                                $avgPercent = 0;
                                                $ap = 0;
                                                $averagePercent = 0;
                                            @endphp
                                            @foreach($exam as $exa)
                                                <span class="examValues" data-id="barChart_{{ $studen->id ?? '' }}" data-subject="{{ $exa['Exam']->name ?? '' }} : {{ $exa['Subject']['name'] ?? '' }} : {{ date('d-m-y', strtotime($exa['date'])) ?? '' }} "></span>
                                                @php
                                                    $mark = DB::table('fill_marks')->where('exam_id', $exa->id)->where('admission_id', $studen->id)->first();
                                                  if(!empty($mark)){
                                                    $avgPercent = $avgPercent += $mark->percent;
                                                    }
                                                    $ap++;
                                                @endphp
                                                <span class="markValues" data-id="barChart_{{ $studen->id ?? '' }}" data-mark="{{ $mark->student_marks ?? '' }}"></span>
                                            @endforeach   
                                                @if($avgPercent > 0)
                                                    @php
                                                        $averagePercent = $avgPercent / $ap;
                                                    @endphp
                                                @endif
                                            <div class="col-md-6">
                
                                                <div class="card card-light">
                                                    <div class="card-header">
                                                        <h3 class="card-title">{{ $studen->first_name ?? '' }} {{ $studen->last_name ?? '' }} : {{ $studen['ClassTypes']->name ?? '' }} </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                            <canvas id="barChart_{{ $studen->id ?? '' }}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 645px;" width="1290" height="500" class="chartjs-render-monitor barChart"></canvas>
                                                            <div class="progress">
                                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                                                              aria-valuenow="{{ $averagePercent ?? '' }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $averagePercent ?? '' }}%">
                                                                <span class="font-weight-bolder">Overall {{ round($averagePercent, 2) ?? '' }}% &nbsp; @if($averagePercent >= 80)<i class="fa fa-trophy text-warning"></i> @elseif($averagePercent <= 30) <i class="fa fa-thumbs-down text-warning"></i> @else<i class="fa fa-thumbs-up text-warning"></i> @endif</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                
                                            </div>
                                        @endforeach
                                
                                @endif
                            
                            @endif
                        </div>
                        
                    @endif
               </div>
            </div>
         </div>
      </div>
</section>
</div>

<script>
$(document).ready(function(){
    $('#allSelect').click(function(){
        var selectAll = $(this).data('selectAll');
        if (!selectAll) {
          $('#admission_id').find('option').prop('selected', true).end().trigger('change');
          $(this).text('Unselect').data('selectAll', true);
        } else {
          $('#admission_id').find('option').prop('selected', false).end().trigger('change');
          $(this).text('Select All').data('selectAll', false);
        }
    });
    
    $('input[type="radio"][name="pattern"]').click(function(){
        var pattern = $(this).val();
        if(pattern == 2){
            $('#class_type_id').attr('required', true);
        }else{
            $('#class_type_id').attr('required', false);
        }
    });
})
</script>
<script>
  $(function () {

    $('.barChart').each(function(){
        var thiscanvas = $(this);

        var exams = [];
        $('.examValues').each(function(){
            if(thiscanvas.attr('id') == $(this).data('id')){
                var subject = $(this).data('subject');
                exams.push(subject);
            }
        })        
        var marks = [];
        
        $('.markValues').each(function(){
            if(thiscanvas.attr('id') == $(this).data('id')){
                var mark = $(this).data('mark');
                marks.push(mark);
            }
        })
        
        var areaChartData = {
          //labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          labels  : exams,
          datasets: [
            {
              label               : 'Marks Obtained',
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 205, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(201, 203, 207, 0.2)'
              ],
              borderColor: [
                  'rgb(255, 99, 132)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(201, 203, 207)'
              ],
              borderWidth: 1,
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : marks
            },
          ]
        }
        
        //areaChartData.datasets[0].data.sort((a, b) => a - b);
        
        var barChartCanvas = $('#'+thiscanvas.attr('id')).get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0
    
        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          datasetFill             : false,
          plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: 'black',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function (value) {
                            return value;
                        }
                    }
                },
          scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                }
              }]
            }
        }
    
        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        
        })
    })
  })
</script>
@endsection

