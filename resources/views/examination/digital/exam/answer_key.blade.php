





<!DOCTYPE html>
<html>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/school/css/adminlte.min.css') }}">
</head>

@php
$getSetting=Helper::getSetting();

@endphp
<style>
  .border_solid{
    border: 1px solid;
  }
    .font_family{
         font-family: fangsong;
     }
    .border_s{
        border-bottom: 2px solid;
    }
    .px_boerder{
          border-bottom: 2px solid;
    }
    .line_height{
       line-height: 75px;
    }
    .background_color{
      background-color: black;
      color: aliceblue;
      padding: 5px 0px 1px 0px;
    }
  </style>

</head>
<body>
<div class="container border_solid">
 <div class="row">
  <div class="col-md-4 mt-3 border_s">
      <img alt="left_logo"  src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'" style="width: 130px;"></td>
  
  </div>
  <div class="col-md-6 border_s mt-3 text-center">
      <h3><b >{{$getSetting['name'] ?? ''}}</b></h3>
      <p><b >Address :- </b> {{$getSetting['address'] ?? ''}}</p>
      <p><b >Phone:-</b> {{$getSetting['mobile'] ?? ''}} &nbsp;<b>Email :</b> {{$getSetting['gmail'] ?? ''}}  </p>
  </div>
  <div class="col-md-2 border_s">
      
  </div>
  <hr>
  
      <div class="col-md-12 mt-2 text-center">
            <h4 class="font_family"><b>{{$exam_name->name ?? ''}}</b></h4>
        </div>
       <div class="col-md-6 col_padding">
           <p class="font_family mb-0"><b>Date</b> :  {{date('d-m-Y h:i A', strtotime($exam_name->exam_date ?? ''))}}</p>
           <p class="font_family mb-0"><b>Time</b> : {{$exam_name->duration ?? '0'}} hr {{$exam_name->duration_minute ?? '0'}} min</p>
           <p class="font_family mb-0"><b>Marks</b> : {{count(explode(',', $exam_name->questions_id))*$per_question_marks }}</p>
       </div>
       <div class="col-md-6 test_padding">
           <p class="text-right font_family mb-0"><b>TEST ID</b> : {{$exam_name->id ?? ''}}</p>
       </div>
       <div class="col-md-12 px_boerder">
           <p class="font_family text-center mt-0">Class : {{$exam_name->class_name ?? 'N/A'}}</p>
       </div>
      <div class="col-md-12 mt-2 text-center">
          <div class="background_color">
              <h5 class="font_family"><b>: ANSWER KEY :</b></h5>
          </div>
      </div>
      
      
      @foreach($data as $item)
<div class="col-md-12">
           <h4 class="text-center mt"><b><u>{{$item['subject_id'] ?? 'N/A'}}</u></b></h4>
       </div>
           
   

               
           
       
      <div class='container'>
           <div class='row'>

  @foreach($item['data'] as $key => $subitem)         
         
            <div class='col-md-2'>
               Q.{{$subitem['srno'] ?? '' }})<b>{{'    ['}} 
                {{$subitem['ans'] == 1  ? 'a' : ''}}
{{$subitem['ans'] == 2  ? 'b' : ''}}
{{$subitem['ans'] == 3  ? 'c' : ''}}
{{$subitem['ans'] == 4  ? 'd ' : ''}}
{{$subitem['question_type_id'] == 2  ? $subitem['ans'] : ''}} ]</b>
                </div>
           
        
@endforeach
          
            </tr>

         
        </div>
       
 
@endforeach      
		
  </div>
</div>
</body>
</html> 
  
