<head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/adminlte.min.css') }}">
  <script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
            <script src="{{URL::asset('public/assets/school/js/jquery-ui.min.js')}}"></script>
</head>

@php
$getSetting=Helper::getSetting();

@endphp
<style>
  .border_solid{
    border: 1px solid;
  }
  .px_boerder{
   border-bottom: 2px solid black;
  }
  .col_padding{
       padding: 0px 0px 0px 14px;
  }
  .test_padding{
       padding: 0px 26px 0px 0px;
  }
  .font_weight{
           font-size: 17px;
    font-weight: 500;
    line-height: 26px;
    color: black;
    letter-spacing: 0.04em;
  }
  .email_font{
     padding: 27px 12px 41px 17px !important;
  }
  .font_family{
         font-family: fangsong;
  }


</style>


<div class="container border_solid">
    @include('print_file.print_header')
    <div class="row">
        <div class="col-md-12 mt-2 text-center">
            <h4 class="font_family"><b>{{$exam_name->name ?? ''}}</b></h4>
        </div>
       <div class="col-md-12 col_padding px_boerder">
           <span class="font_family text-center mt-0"><b>Class</b> : {{$exam_name->class_name ?? ''}}</span></br>
           <span class="font_family mb-0"><b>Exam ID</b> : {{$exam_name->id ?? ''}}</span></br>
           <span class="font_family mb-0"><b>Date</b> : {{date('d-m-Y h:i A', strtotime($exam_name->exam_date ?? 'N/A'))}}</span></br>
           <span class="font_family mb-0"><b>Time</b> : {{$exam_name->duration ?? '0'}} hr {{$exam_name->duration_minute ?? '0'}} min</span></br>
           <span class="font_family mb-0"><b>Marks</b> : {{count(explode(',', $exam_name->questions_id))*$per_question_marks }}</span></br>
       </div>
      
       <div class="col-md-12 px_boerder justify-content-center">
           <div class="row">
           <div class="col-md-3 text-center ">
                <span class="font_family  mt-0"><b>Right</b> : {{$exam_result->correct_ans ?? 0}}</span>
               </div>
           <div class="col-md-3 text-center ">
           <span class="font_family  mt-0"><b>Wrong </b>: {{$exam_result->wrong_ans ?? 0}}</span>
               </div>
           <div class="col-md-3 text-center ">
                    <span class="font_family  mt-0"><b>Skip </b>: {{$exam_result->skip_ques ?? 0}}</span>
               </div>
           <div class="col-md-3 text-center ">
              <span class="font_family mt-0"><b>Total </b>: {{$exam_result->total_ques ?? 0}}</span>
               </div>
               </div>
               
          
          
      
         
       </div>
       
       
        @foreach($data as $item)
      
        
       <div class="col-md-12">
           <h4 class="text-center mt"><b><u>{{$item['subject_id'] ?? 'N/A'}}</u></b></h4>
       </div>
       <div class="col-md-12" >
           
            
        
            @foreach($item['data'] as $key => $subitem) 
        
       </br>
               <span class="font_weight font_family"> Q.{{$subitem['srno'] .')'}}{!! html_entity_decode($subitem['question_name'] ?? '', ENT_QUOTES, 'UTF-8') !!} 
                </span></br>
               <span class="font_weight font_family"> Q.{{'        '}}{!! html_entity_decode($subitem['hi_question_name'] ?? '', ENT_QUOTES, 'UTF-8') !!} 
                </span>
          
           
           <div class='container'>
           <div class='row'>
      @if($subitem['question_type_id'] ==1)         
           <div class='col-md-3'>
 
 
 @if( $subitem['correct_ans'] != 1 && $subitem['user_ans'] == 1 )
 <i class="fa fa-close text-danger"></i>
 @endif
  @if( $subitem['correct_ans'] == 1 && $subitem['user_ans'] != 1 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 @if( $subitem['correct_ans'] == 1 && $subitem['user_ans'] == 1 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 
 
 <b>A]</b> {!! html_entity_decode($subitem['ans_a'] ?? '', ENT_QUOTES, 'UTF-8') !!} </br>
 {!! html_entity_decode($subitem['hi_ans_a'] ?? '', ENT_QUOTES, 'UTF-8') !!}
 
</div>
           <div class='col-md-3'>
                @if( $subitem['correct_ans'] != 2 && $subitem['user_ans'] == 2 )
 <i class="fa fa-close text-danger"></i>
 @endif
  @if( $subitem['correct_ans'] == 2 && $subitem['user_ans'] != 2 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 @if( $subitem['correct_ans'] == 2 && $subitem['user_ans'] == 2 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 
<b>B]</b> {!! html_entity_decode($subitem['ans_b'] ?? '', ENT_QUOTES, 'UTF-8') !!} </br>
 {!! html_entity_decode($subitem['hi_ans_b'] ?? '', ENT_QUOTES, 'UTF-8') !!}
</div>
           <div class='col-md-3'>
                  @if( $subitem['correct_ans'] != 3 && $subitem['user_ans'] == 3 )
 <i class="fa fa-close text-danger"></i>
 @endif
  @if( $subitem['correct_ans'] == 3 && $subitem['user_ans'] != 3 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 @if( $subitem['correct_ans'] == 3 && $subitem['user_ans'] == 3 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
<b>C]</b> {!! html_entity_decode($subitem['ans_c'] ?? '', ENT_QUOTES, 'UTF-8') !!} </br>
 {!! html_entity_decode($subitem['hi_ans_c'] ?? '', ENT_QUOTES, 'UTF-8') !!}
</div>
           <div class='col-md-3'>   @if( $subitem['correct_ans'] != 4 && $subitem['user_ans'] == 4 )
 <i class="fa fa-close text-danger"></i>
 @endif
  @if( $subitem['correct_ans'] == 4 && $subitem['user_ans'] != 4 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
 @if( $subitem['correct_ans'] == 4 && $subitem['user_ans'] == 4 )
 <i class="fa fa-check-square-o text-success"></i>
 @endif
<b>D]</b> {!! html_entity_decode($subitem['ans_d'] ?? '', ENT_QUOTES, 'UTF-8') !!} </br>
 {!! html_entity_decode($subitem['hi_ans_a'] ?? '', ENT_QUOTES, 'UTF-8') !!}
</div>
       
       @else
        <div class='col-md-3'>
           <i class="fa fa-check-square-o text-success"></i> <b>Right Ans.)</b>  {{$subitem['ans_a'] ?? ''}}
           </div>
       <div class="col-md-3">
         <i class="{{($subitem['user_ans'] ?? '') == ($subitem['ans_a'] ?? '') ? 
         'fa fa-check-square-o text-success' : 'fa fa-close text-danger'
          }}"></i> 
          
          <b>Your Ans.)</b> {{$subitem['user_ans'] ?? ''}}
           </div>
      
       @endif   
       
       
</div>
               
           </div>
        
           
           @endforeach
        
          
         
        
       </div>
        @endforeach
    </div>
   
 </div>
  
  
  <script>
      $('p').attr('style', '');
$('p').replaceWith(function()
{
  return '<span>' + $(this).html() + '</span>';
});
  </script>
 

  <!--
  <script type="text/javascript">
    window.print();
  </script>  -->