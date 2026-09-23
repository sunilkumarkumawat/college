@extends('layout.app')
@section('content')



 @php
    if(!empty($data)) 
{
$decode = json_decode($data->result);
}
@endphp

    <div class="content-wrapper">

        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card card-outline card-orange">
                            <div class="card-header bg-primary">
                                <h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Exam Result</h3>

                                </h3>

                                </h3>

                                <div class="card-tools">
                                    <a href="{{ url('digital/view/exam') }}" class="btn btn-primary btn-sm" id="back"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class='row'>

                                    <div class='col-6 col-md-6 ' style='border:3px solid white'>
                                        <div class='row bg-primary'>
                                            <div class='col-3 col-md-3 p-3'>
                                                TestId :  {{$exam_data->id ?? 'N/A'}} Result
                                            </div>
                                            <div class='col-4 col-md-4 p-3'>
                                                {{$exam_data->name ?? 'N/A'}}
                                            </div>
                                            <div class='col-5 col-md-5 p-3 text-right'>
                                             
                                              
                                             {{ date('d-m-Y h:i A', strtotime($data->created_at ?? ''))}}
                                            </div>
                                        </div>
                                          @php
                                               $decode1 = json_decode($data->subject_id_groupBy);
                                                
                                                    @endphp
                                        <div class='row'>
                                            <div class='col-12 col-md-12'>
                                                <table class="table  ">

                                                    <tbody>
                                                        <tr>

                                                               @if(!empty($decode1)) 
                                                               
                                                               @foreach($decode1 as $item)
                                                               
                                                                                           <td class='text-center'>
                                                                                               @php
                                                                $subject_name = Helper::getSubjectName($item ?? '');
                                                                $percentage = Helper::getSubjectPercentage($data->id ?? '',$item ?? '');
                                                                
                                                                
                                                                @endphp
                                                                                           {{$subject_name ?? ''}}
                                                                                           
                                                                                           
                                                                                           <span
                                class="badge bg-{{  ((($percentage['correct']*4)+($percentage['wrong']*-1))/($percentage['total_ques']*4))*100 >= 50 ? 'success' : 'danger' }}">
                                                                @if(!empty($data))
                                                                
                                                                @php
                                                                $marks =  number_format((float)((($percentage['correct']*4)+($percentage['wrong']*-1))/($percentage['total_ques']*4))*100,2,'.','');
                                                                @endphp
                                                {{ $marks <= 0 ? 0 :$marks}}
                                                
                                                @endif
                                                                %</span></td>
                                                               
                                                               @endforeach
                                                            
                                                               @endif
                                                            
                                                          
                                

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                        <div class='row bg-primary'>
                                            <div class='col-3 col-md-3 p-3'>
                                                Detailed Records
                                            </div>
                                            <div class='col-4 col-md-4 p-3'>
                                                Re-Attemped
                                            </div>
                                            <div class='col-5 col-md-5 p-3 text-right'>
                                                This is online result
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="@if(!empty($data))
                                                {{  ((($data ->correct_ans*4)+($data ->wrong_ans*-1))/($data ->total_ques*4))*100 }}
                                                
                                                @endif" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: @if(!empty($data))
                                                {{  ((($data ->correct_ans*4)+($data ->wrong_ans*-1))/($data ->total_ques*4))*100 }}%
                                                
                                                @endif">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Total Marks:
                                                 @if(!empty($data))
                                                {{  ($data ->correct_ans*4)+($data ->wrong_ans*-1) }}
                                                
                                                @endif
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Out of Marks: 
                                                
                                                @if(!empty($data))
                                                {{  ($data ->total_ques*4) }}
                                                
                                                @endif
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: @if(!empty($data))
                                                {{  (($data ->correct_ans)/($data ->total_ques))*100 }}%
                                                
                                                @endif">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Positive Marks:
                                                  @if(!empty($data))
                                                {{  ($data ->correct_ans*4) }}
                                                
                                                @endif
                                                
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Negative Marks: 
                                                
                                                  @if(!empty($data))
                                                {{  ($data ->wrong_ans*-1) }}
                                                
                                                @endif
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="@if(!empty($data))
                                                {{  (($spend_time)/(600))*100 }}%
                                                
                                                @endif" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: @if(!empty($data))
                                                {{  (($spend_time)/(600))*100 }}%
                                                
                                                @endif">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Spend Time:
                                                @if(!empty($data))
                                                {{  ($data ->time) }}
                                                
                                                @endif
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Total Time: {{$exam_data->duration ?? 'N/A'}} hr :  {{$exam_data->duration_minute ?? 'N/A'}} min
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="@if(!empty($data))
                                                {{  (($data ->correct_ans)/($data ->total_ques))*100 }}
                                                
                                                @endif" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: @if(!empty($data))
                                                {{  (($data ->correct_ans)/($data ->total_ques))*100 }}%
                                                
                                                @endif">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Correct:
                                                @if(!empty($data))
                                                {{  ($data ->correct_ans) }}
                                                
                                                @endif
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Wrong:
                                                @if(!empty($data))
                                                {{  ($data ->wrong_ans) }}
                                                
                                                @endif
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="@if(!empty($data))
                                                {{  (($data ->total_ques - $data ->skip_ques  )/($data ->total_ques))*100 }}
                                                
                                                @endif" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: @if(!empty($data))
                                                {{  (($data ->total_ques - $data ->skip_ques  )/($data ->total_ques))*100 }}%
                                                
                                                @endif">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Attemped:
                                                
                                                @if(!empty($data))
                                                {{  ($data ->total_ques - $data ->skip_ques  ) }}
                                                
                                                @endif
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Not Attempted:
                                                 @if(!empty($data))
                                                {{  ($data ->skip_ques  ) }}
                                                
                                                @endif
                                            </div>
                                        </div>
                                      <!--  <div class='row'>
                                            <div class='col-12 col-md-12 pt-2 p-0'>
                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-green" role="progressbar"
                                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 80%">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-6 col-md-6 '>
                                                Visited:4
                                            </div>
                                            <div class='col-6 col-md-6 text-right'>
                                                Not Visited:6
                                            </div>
                                        </div>-->
                                    </div>


                                    <div class='col-6 col-md-6' style='border:3px solid white'>
                                        
                                        <div class='row '>
                                            <div class='col-12 col-md-12'>
                                                <table class="table table-bordered">
                                                    <thead class='bg-primary'>
                                                        <tr>
                                                            <th style="width: 10px">Q.No.</th>
                                                            <th>Mark</th>
                                                            <th>Time Taken(Seconds)</th>
                                                            <th >Visited Count</th>
                                                            <th >Subject</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    @if(!empty($data))
                                                    
                                                   
                                                    @foreach($decode as $key=> $item)
                                                        <tr>
                                                            <td>{{$key +1}}</td>
                                                            <td class=@if($item->correct == 2)
                                                                 {{'text-success'}}
                                                               @elseif($item->correct == 1)
                                                                {{'text-danger'}}
                                                               @elseif($item->correct == 0)
                                                              
                                                               @endif>
                                                                
                                                               
                                                                @if($item->correct == 2)
                                                                4
                                                               @elseif($item->correct == 1)
                                                               {{-1}}
                                                               @elseif($item->correct == 0)
                                                               0
                                                               
                                                               @endif
                                                                
                                                            </td>
                                                            <td>{{$item->time ?? '' }} </td>
                                                            <td>{{$item->visited_count ?? '' }}</td>
                                                            
                                                            <td>
                                                                
                                                                @php
                                                                $subject_name = Helper::getSubjectName($item->subject_id ?? '');
                                                                @endphp
                                                              
                                                                {{$subject_name ?? '' }}</td>
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
                    </div>
        </section>
    </div>


    <style>
        .nav-color {
            color: #6c757d !important;
        }

        .form-group {

            border-radius: 5px;

            width: 600px;
            padding: 5px;
        }

        .title {
            margin: 5px;
            text-align: center;
        }

        #a1,
        #a2 {
            display: none;
        }
    </style>
    
    
@endsection