@php

@endphp
@extends('layout.app') 
@section('content')
<link rel="stylesheet" href="{{ asset('resources/views/examination/online_exam/exam.css') }}">
<!--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>-->
<!--@import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");-->
<!--<script src="{{URL::asset('resources/views/examination/online_exam/exam.js')}}"></script>-->

<input type="hidden" id="exam_id" name="exam_id" value="{{ $id ?? '' }}">
<input type="hidden" id="exam_duration" value="60">
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Online Exam</h3>
							<h3 class="text-right" style="float: left;width:200px;font-size: 1.5rem;font-weight: 400;">Time Left ::
							<h3 class="text-left ml-2 countdown" style="float: left;width:200px;font-size: 1.5rem;font-weight: 400;">
							<h3 class="text-left ml-2 countdown1" style="float: left;width:200px;font-size: 1.5rem;font-weight: 400;">
							</h3>
							
							</h3>
							
							<div class="card-tools"> 
							    <a href="{{url('view/exam')}}" class="btn btn-primary btn-sm" id="back"><i class="fa fa-arrow-left"></i> Back</a> 
						    </div>
						    
						</div>
					
						<div class="card-body">
						   

    <!-- website section start -->
    <form action="{{url('submit_exam')}}"  method="post">
        @csrf
             <input type="hidden" name="wrong_ans" id="wrong" value="0" />
             <input type="hidden" name="correct_ans" id="correct" value=0 />
             <input type="hidden" name="skip" id="skip" value="{{count($data1)}}" />
             <input type="hidden" name="timer" id="timer"  />
        <div class="container">
            <div class="row">
        @if(!empty($data1))
        <input type="hidden" name="exam_id" value="{{$data1[0]['exam_id']}}" />
        @php
        
      $i = 1;
      $index = 0;
      $total_quest = 0;
        @endphp
        
        @foreach($data1 as $item )
        <!--{{ $total_quest ++}}-->
        @if($item['question_type_id'] == 1)
        <div class="col-1">Ques. {{$i++}}</div>
        <div class="col-11">
            <label class="form-control mb-1 border-0 font-weight-bold" for="element">{{$item['title']}}</label>
             <input type="hidden" name="ques_name[]" value="{{$item['title']}}" />
             <input type="hidden" name="ques_id[]" value="{{$item['question_id']}}" />
             <input type="hidden" name="ques_ans[]" value="{{$item['correctAnswer']}}" />
            
             
<!--             <div class=" mb-5">-->
<!--                   <input class=" m-2 mt-0 submit_ans"  type="radio" data-ques-id="{{$item['question_id']}}"  name="submit_ans[]" value="0">{{$item['choices'][0]}}-->
<!-- <input type="radio" class="m-2 mt-0 submit_ans"  data-ques-id="{{$item['question_id']}}"  name="submit_ans[]" value="1">{{$item['choices'][1]}}-->
<!--<input type="radio" class="m-2 mt-0 submit_ans"  data-ques-id="{{$item['question_id']}}" name="submit_ans[]" value="2">{{$item['choices'][2]}}-->
<!--<input type="radio" class="m-2 mt-0 submit_ans"  data-ques-id="{{$item['question_id']}}" name="submit_ans[]" value="3">{{$item['choices'][3]}}-->
                 
<!--             </div>-->
            
 <select class="form-control submit_ans mb-5"  data-ques-id="{{$item['question_id']}}"  data-index="{{$index++}}"name="submit_ans[]" >
		    	<option value="">Select an option</option>
           
			<option value="0">{{$item['choices'][0]}}</option>
			<option value="1">{{$item['choices'][1]}}</option>
			<option value="2">{{$item['choices'][2]}}</option>
			<option value="3">{{$item['choices'][3]}}</option>

		

		</select>

            
        </div>  
       <!-- @else
            <div class="col-1">Ques. {{$i++}}</div>
               <div class="col-11">
            	<label class="form-control" for="element1">{{$item['title']}}</label>
 <input type="hidden" name="ques_name[]" value="{{$item['title']}}" />
             <input type="hidden" name="ques_id[]" value="{{$item['question_id']}}" />
             <input type="hidden" name="ques_ans[]" value="{{$item['correctAnswer']}}" />
             
		<textarea id="element1" class="form-control" rows="5"  cols="5" name=submit_ans[] data-ques-id="{{$item['question_id']}}"> </textarea>

            
        </div>  
        
        @endif-->
        
        @endforeach
             <input type="hidden" name="total_que" value="{{$total_quest}}" />
           @endif
 
        
     
            <div class="col-12">
         		<button class="btn btn-success" type="submit" id="submit_exam">Submit</button>

        </div>      
                
            </div>
             </div>
              
                
                
            </div>
             </div>

	



	</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<script>
    
    $("form").submit(function(event){
  event.preventDefault
  var $inputs = $('form :input');

    // not sure if you wanted this, but I thought I'd add it.
    // get an associative array of just the values.
    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });



});

var  submit_ans = [];
    $(".submit_ans").change(function(event){
        
        var index = $(this).attr("data-index");
var ans =$(this).val();
var  que_id =$(this).attr('data-ques-id');

var correct = 0;
var wrong =0;
var skip =0;





var array = {!! str_replace("'", "\'", json_encode($data1)) !!};

$(array).each(function(key , item){
  
  
 if(parseInt(que_id) == parseInt(item.question_id) )
   {
       

       if(ans == item.correctAnswer)
       {
           submit_ans[index] = 1;
       }
       else
       {
           submit_ans[index] = 0;
       }
 
  
   
   }
   

   
  });
  
  
  for(i=0; i<array.length; i++)
  {
      
      if(submit_ans[i] == 1)
      {
       correct++;
      }
      else if(submit_ans[i] == 0)
      {
          wrong++;
          
      }
  }


$("#correct").val(correct);
$("#wrong").val(wrong);
$("#skip").val(parseInt(array.length)-(correct+wrong));

    // alert("correct ::: "+ correct + " :: wrong :: "+ wrong);
// alert(ans)
// alert(que_id);




});
</script>

<script>


var timer2 = "{{$data1[0]['duration'] ?? ''}}:01";
var timer1 = "{{$data1[0]['duration'] ?? ''}}:01";

if (timer2 === '') {
  console.error('No duration found in $data1');
} else {
  var interval = setInterval(function() {
    var timer = timer2.split(':');
    var minutes = parseInt(timer[0], 10);
    var seconds = parseInt(timer[1], 10);
    --seconds;
    minutes = (seconds < 0) ? --minutes : minutes;
    if (minutes < 0) {
      clearInterval(interval);
      $("#submit_exam").trigger("click");
    }
    seconds = (seconds < 0) ? 59 : seconds;
    seconds = (seconds < 10) ? '0' + seconds : seconds;
    $('.countdown').html(minutes + ':' + seconds);
    timer2 = minutes + ':' + seconds;
    var diff = Math.abs(timer1 - timer2);
    $('.countdown1').html(diff);
  }, 1000);
}
</script>

<script>
    var sec = -1;
function pad(val) { return val > 9 ? val : "0" + val; }
setInterval(function () {
    $("#seconds").html(pad(++sec % 60));
    $("#minutes").html(pad(parseInt(sec / 60, 10) % 60));
    $("#hours").html(pad(parseInt(sec / 3600, 10)));
    
    $("#timer").val(pad(parseInt(sec / 3600, 10))+":"+ pad(parseInt(sec / 60, 10) % 60) +":" + pad(++sec % 60) );
}, 1000);
</script>


@endsection