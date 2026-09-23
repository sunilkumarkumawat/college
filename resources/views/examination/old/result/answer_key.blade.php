@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
  $getSection = Helper::getSection();
  $getSetting=Helper::getSetting();
 
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
                        <h3 class="card-title"><i class="fa fa-check-square-o"></i> &nbsp; Answer Key</h3>
                        <div class="card-tools">
                        <a href="{{url('#')}}" class="btn btn-primary  btn-sm" title="Print" onclick="printDiv('printableArea')"><i class="fa fa-download"></i> Download</a>
                        
                            @if(Session::get('role_id') == 3)
                                <a href="{{url('view/exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('messages.Back') }}  </a> 
                            @else
                                <a href="{{ url()->previous() }}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
                            @endif                        
                        
                        </div>
                        
                        </div>  
                        
                    	<div class="row m-2">
                		    <div class="col-md-12">	
                
                                <div id="printableArea" name="printableArea">
                                    @include('print_file.print_header')
                                    <table width="100%" style="border-bottom: 2px solid black;">
                                        <tr>
                                            <td width="25%"><b>Exam Name</b></td>
                                            <td width="25%"><b>: {{ $data[0]['Exam']->name ?? '' }}</b></td>
                                            <td width="25%"><b>Exam Date</b></td>
                                            <td width="25%"><b>: {{ date('d-m-y', strtotime($data[0]['Exam']->exam_date)) ?? '' }}</b></td>        
                                        </tr>
                                    </table>                                    
                                    
                                    <table width="100%" style="border-bottom: 2px solid black;">
                                        <tr>
                                            <td width="25%"><b>Name</b></td>
                                            <td width="25%"><b>: {{ $data[0]['Admission']->first_name ?? '' }} {{ $data[0]['Admission']->last_name ?? '' }}</b></td>
                                            <td width="25%"><b>Mobile</b></td>
                                            <td width="25%"><b>: +91 {{ $data[0]['Admission']->mobile ?? '' }}</b></td>        
                                        </tr>
                                        <tr>
                                            <td width="25%"><b>Father Name</b></td>
                                            <td width="25%"><b>: {{ $data[0]['Admission']->father_name ?? '' }}</b></td>
                                            <td width="25%"><b>Email</b></td>
                                            <td width="25%"><b>: {{ $data[0]['Admission']->email ?? '' }}</b></td>        
                                        </tr>
                                    </table>

                                    <table width="100%" style="border-bottom: 2px solid black;">
                                        <tr class="text-center">
                                            <td>Total Question</td>
                                            <td>Correct Answer</td>
                                            <td>Wrong Answer</td>
                                            <td>Skipped Question</td>
                                            <td>Result (%)</td>
                                            <td>Time</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><small class="badge badge-info w-25">{{ $result['total_ques'] ?? ''}}</small></td>
                                            <td><small class="badge badge-success w-25">{{ $result['correct_ans'] ?? ''}}</small></td>
                                            <td><small class="badge badge-danger w-25">{{ $result['wrong_ans'] ?? ''}}</small></td>
                                            <td><small class="badge badge-warning w-25">{{ $skip_answer ?? ''}}</small></td>
                                            <td><small class="badge badge-{{  $result['percentage'] <= 45 ? 'danger'   : ''  }}{{  $result['percentage'] > 45 && $result['percentage'] < 75 ? 'warning'   : ''  }}{{  $result['percentage'] >= 75 ? 'success'   : ''  }} w-50">{{ $result['percentage'] ?? '' }} %</small></td>
                                            <td><small class="badge badge-secondary w-50">{{ $result['time'] ?? ''}}</small></td>
                                        </tr>                                        
                                    </table>
                                    
                                    <table style="width:100%" style="border-bottom: 2px solid black;">
								@if(!empty($data)) 
    								@php 
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)              
                                        <tr>
                                            <td colspan="4" ><b>{{ $i++ }}. &nbsp; {{ $item->ques_name ?? '' }} </b>
                                            
                                            @if($item['submit_ans'] == null)<b class="badge badge-warning">Skipped</b>
                                            @elseif($item['submit_ans'] ==$item['correct_ans'] )<b class="badge badge-success">Correct</b>
                                            @elseif($item['submit_ans'] != $item['correct_ans'])<b class="badge badge-danger">Wrong</b>@endif
                                  
                                            
                                            
                                            
                                            </td>
                                        </tr>
                                        <tr>
                                          
                                           
                                      
                                           
                                            <td style="width:25%" class="pl-4  @if($item['submit_ans'] == null) skipped @else {{  0 == $item['submit_ans'] ? ' submit_ans c'   : ''  }}@endif{{  $item['correct_ans'] == 0 ? '-c correct_ans  '   : ''  }} ">(A) &nbsp; {{ $item['Question']->ans1 ?? '' }}</td>
                                            <td style="width:25%" class=" @if($item['submit_ans'] == null) skipped @else{{  1 == $item['submit_ans'] ? ' submit_ans  c'   : ''  }}@endif{{  $item['correct_ans'] ==1 ? '-c correct_ans  '   : ''  }} ">(B) &nbsp; {{ $item['Question']->ans2 ?? '' }}</td>
                                            <td style="width:25%" class="  @if($item['submit_ans'] == null) skipped @else{{  2 == $item['submit_ans'] ? ' submit_ans c'   : ''  }}@endif{{  $item['correct_ans'] ==2 ? '-c correct_ans '   : ''  }} ">(C) &nbsp; {{ $item['Question']->ans3 ?? '' }}</td>
                                            <td style="width:25%" class="  @if($item['submit_ans'] == null) skipped @else{{  3 == $item['submit_ans'] ? ' submit_ans  c'   : ''  }}@endif{{  $item['correct_ans'] ==3 ? '-c correct_ans '   : ''  }} ">(D) &nbsp; {{ $item['Question']->ans4 ?? '' }}</td>        
                                        </tr>
                                @endforeach
                                @endif
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
    .c-c{
     color:green !important;   
    
    }
    .skipped{
        color:black;   
       
    }
    .correct_ans{
     color:green !important;     
     font-weight:bold;
       
    }
    .submit_ans{
     color:red;     
     font-weight:bold;
       
    }
    }
</style>
@endsection