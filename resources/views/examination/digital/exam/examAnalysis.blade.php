@extends('layout.app') 
@section('content')


<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Analysis Exam - {{$data->exam_name ?? 'N/A'}}</h3>
							
							<div class="card-tools"> 
							    <a href="{{url('view/exam')}}" class="btn btn-primary btn-sm" id="back"><i class="fa fa-arrow-left"></i> Back</a> 
							    
						    </div>
						    
						</div>
					
						<div class="card-body">
						 
						 
						 <div class='row'>
						     
						     <div class ='col-6 col-md-8'>
						          <div class='row'>
						             <form class="form-horizontal">
<fieldset>



<!-- Multiple Radios -->
<div class="form-group  review_hide">
    

  <h5 class="control-label" style='line-height:35px'  for="radios" id="q1">Q. 1 {{$questions[0]->name ?? ''}}</h5>
  


  <br>
  <div class="col-md-12 objective">
  <div class="radio">
    <label for="radios-0">
   a.)
    <span id='ans_a' class="font-weight-bold">{{$questions[0]->ans_a ?? ''}}</span> </br>
   
   
    </label>
	</div>
  <div class="radio">
    <label for="radios-1">
    b.)
      <span id='ans_b' class="font-weight-bold">{{$questions[0]->ans_b ?? ''}}</span> </br>
      
   
    </label>
	</div>
  <div class="radio">
    <label for="radios-2">
     c.)
      <span id='ans_c' class="font-weight-bold">{{$questions[0]->ans_c ?? ''}}</span> </br>
       
 
    </label>
	</div>
  <div class="radio">
    <label for="radios-3">
     d.)
     <span id='ans_d' class="font-weight-bold">{{$questions[0]->ans_d ?? ''}}</span> </br>
     
   
    </label>
	</div>
  </div>
  <div class="col-md-12 numeric">
  <div class="radio1">
    <label for="radios-0">
     <span>Your Answer => </span> <input name="numeric_ans" class='w-100' type="text" id="numeric_ans" readonly>
    
   
    </label>
	</div>

  </div>
 
</div>


<div class="form-group  review_show">
    
 
 
  <div class="col-md-12">
  <div class="radio1">
    <label for="radios-0">
     <span id='ans_correct'>Ans : {{$questions[0]->correct_ans == 1 ? 'a' : ''}}{{$questions[0]->correct_ans == 2 ? 'b' : ''}}{{$questions[0]->correct_ans == 3 ? 'c' : ''}}{{$questions[0]->correct_ans == 4 ? 'd' : ''}}=> </span>
     </br>
     <span id='ans_reivew'>
         {{$questions[0]->solution ?? ''}}
     </span>
    
   
    </label>
	</div>

  </div>
</div>
</fieldset>
</form>


						              
						              </div>
						   <!--      		              <div class='row'>
						                   <div class ='col-12 col-md-12'>
sdfs
</div>						              
						              </div>-->
						         </div>
						     <div class='col-6 col-md-4' style='border:3px solid white'>
                                        
                                        <div class='row '>
                                            <div class='col-12 col-md-12'>
                                                
                                                <div id ='divv'style="height:370px;overflow:scroll">
                                                <table class="table table-bordered">
                                                    <thead class='bg-primary'>
                                                        <tr style="position: sticky;top: 0;background: #6639b5;">
                                                            <th colspan=2 style="width: 10px">Q.No.</th>
                                                           
                                                            <th>Mark</th>
                                                            <th>Time(Sec)</th>
                                                            <th >Visited Count</th>
                                                            <th >Subject</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    @if(!empty($data))
                                                    
                                                   @php
                                                $decode = json_decode($data->result);
                                                @endphp
                                                    @foreach($decode as $key=> $item)
                                                        <tr class="table_tr_selector   question_number" id='ques_{{$key}}' data-question ={{$key}}>
                                                             <td style='background-color:white ;color:black' class='arrow_td' id='arrow_td_{{$key}}'> 
 </td>
                                                            <td> {{$key +1}}</td>
                                                            <td class=@if($item->correct == 2)
                                                                
                                                               @elseif($item->correct == 1)
                                                               
                                                               @elseif($item->correct == 0)
                                                              
                                                               @endif>
                                                                
                                                               
                                                                @if($item->correct == 2)
                                                                4
                                                               @elseif($item->correct == 1)
                                                               {{-1}}
                                                               @elseif($item->correct == 0)
                                                              Skip / NV
                                                               
                                                               @endif
                                                                
                                                            </td>
                                                            <td>{{$item->time ?? '' }} </td>
                                                          <td>{{$item->visited_count ?? '' }} </td>
                                                            
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

                                <div class ='col-12 col-md-12' >
						              <div class='row pt-1 ' > 
                           
                             <div class ='col-6 col-md-4'>
						         		 <span  class="btn btn-success  ">{{$data->correct_ans ?? 'N/A'}}</span> Correct
						         		         </div>
                             <div class ='col-6 col-md-4'>
						         		 <span  class="btn btn-danger  ">{{$data->wrong_ans ?? 'N/A'}}</span> Wrong
						         		         </div>
                  <!--           <div class ='col-3 col-md-3'>-->
						         		 <!--<span  class="btn btn-purple  ">&nbsp;</span> Not Answered-->
						         		 <!--        </div>-->
                             <div class ='col-6 col-md-4 '>
						         		 <span  class="btn btn-secondary  ">{{$data->skip_ques ?? 'N/A'}}</span> Not Visited
						         		         </div>
						        		    
						              </div>
						              </div>
                                        </div>
                                    </div>
						 
						 
						 
					</div>
					<div class='row' > 
						 
						 <div class='col-6 col-md-2'><button  class="btn btn-dark w-100 " id='previous'> <i class="fa fa-arrow-left"></i> Previous</button></div>
						 <div class='col-6 col-md-2' ><button  class="btn btn-purple w-100 " id='mark_for_review'>Show Review</button></div>
						 <div class='col-6 col-md-2' ><button class="btn btn-dark w-100 " id="next">Next <i class="fa fa-arrow-right"></i></button></div>
						 
						 
						<!-- <div class='col-6 col-md-1' >
						     
						     <form action ="{{url('resultExam')}}" method='post' id='formAdd' >
						         @csrf
						         <input type='hidden' name='result' id='form_submit_ans'/>
						         <input type='hidden' name='exam_id' value ='1' />
						         <input type='text' name='question_id' id='question_ids' />
						         <input type='hidden' name='not_visited' id='not_visited' />
						         <input type='hidden' name='admission_id' value ='23' />
						         <input type='hidden' name='total_ques' value ='{{count($questions)}}' />
						         <input type='hidden' name='total_correct' id='total_correct' value ='{{count($questions)}}' />
						         <input type='hidden' name='total_skip' id='total_skip'  value ='{{count($questions)}}' />
						         <input type='hidden' name='total_wrong' id='total_wrong'  />
						         <input type='hidden' name='spend_time' id='spend_time'  />
						         <input type='hidden' name='subject_id_groupBy' id='subject_id_groupBy'  />
						         
						         
						         <input  type='submit' class="btn btn-success w-100 " value='Submit' />
						         
						     </form>
						     
						
						 
						 
						 </div>-->
						 
						 </div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>

var myArray = @json($questions);
var decode = @json($decode);
var paper_medium = @json($exam_name);

  var groupedData = [];
$.each(myArray, function(index, item) {
      var key = item.subject_id;

      if ($.inArray(item.subject_id, groupedData) == -1) {
        groupedData.push(item.subject_id);
      }

    //  groupedData[key].push(item.subject_id);
    });
$.each(decode, function(index, item) {
     
var value = item.correct ;

if(value == 2)
{
    $( "#ques_"+index ).addClass( 'bg-success' ) ;
         
}
else if(value == 1)
{
   $( "#ques_"+index ).addClass( 'bg-danger' ) ;
         
}
 else
 {
     $( "#ques_"+index ).addClass( 'bg-dark' ) ;
      
 }
    });
    
 

var length = myArray.length; 
var count =0;     

         
         
if(myArray[0].question_type_id == 2)
{
    $('.objective').hide();
    $('.numeric').show();
}else
{
     $('.objective').show();
    $('.numeric').hide();
}

var countUp =0;
const myInterval = setInterval(myTimer, 1000);

function myTimer() {
 
 countUp ++;
}

function myStop() {
  clearInterval(myInterval);
  
}

//myTimer();

var ansArray =[];

 $( myArray ).each(function( index ) {
 ansArray[index] = { 'que_id' :myArray[index].id ,'ans' : null ,'correct': 0 ,'time' : 0 ,'subject_id' : myArray[index].subject_id}
});

$('#form_submit_ans').val(JSON.stringify(ansArray))
$('#not_visited').val($('.not_visited').length)
    $( "#save_and_next" ).on( "click", function() {
       
       
       var ansValue = '';
         var correctAns = 1;
         
        
        if(myArray[count].question_type_id == 2)
{
    ansValue = $('#numeric_ans').val();
    
    if(ansValue == myArray[count].ans_a)
        {
            correctAns = 2 ; //correct
        }
        else
        {
            correctAns = 1; //wrong
        }
       
}else
{
     ansValue = $('input[name="radios"]:checked').val();
      if(ansValue == myArray[count].correct_ans)
        {
            correctAns = 2 ; //correct
        }
        else
        {
            correctAns = 1; //wrong
        }
    
}

        ansArray[count] = { 'que_id': myArray[count].id,'ans' : ansValue ?? null,'correct': correctAns,'time' : countUp ,'subject_id' :myArray[count].subject_id };
        
        
        
       if ( $('input[name="radios"]').is(":checked")) {
        $( "#ques_"+count).attr('class','btn btn-success w-100 question_number');
}
   else
   {
         $( "#ques_"+count).attr('class','btn btn-danger w-100 question_number');
         
          if(myArray[count].question_type_id == 2)
{
    $( "#ques_"+count).attr('class','btn btn-success w-100 question_number');
}
   }
   count++;
    countUp =0;
    
  
    if(length != count)
    {
    setQuestion()
}
const arrayOfIds = myArray.map(obj => obj.id);
$('#form_submit_ans').val(JSON.stringify(ansArray))
// $('#question_ids').val(JSON.stringify(arrayOfIds))
$('#not_visited').val($('.not_visited').length)
 //$('#test').text(JSON.stringify(ansArray))


var total_correct = 0;
var total_wrong = 0;
var total_skip = 0;
var total_time = 0;

ansArray.forEach(function(element) {
if(element.correct == 2)

{
    total_correct ++;
}
else if(element.correct == 1)
{
    total_wrong++;
}
else if(element.correct == 0)
{
    total_skip++;
}
total_time += parseInt(element.time); 




});


$('#total_skip').val(total_skip);
$('#total_wrong').val(total_wrong);
$('#total_correct').val(total_correct);
$('#spend_time').val(secondsToHours(total_time));
$('#subject_id_groupBy').val(JSON.stringify(groupedData));


} );

 var isToggled = false;


 $("#mark_for_review").on( "click", function() {
        
        
       
        isToggled = !isToggled;

        
        if (isToggled) {
         $('.review_hide').hide();
        $('.review_show').show();
         $("#mark_for_review").text('Show Question');
           
        } else {
           $('.review_hide').show();
         $('.review_show').hide();
         $("#mark_for_review").text('Show Review');  
        }
    });


 $( "#previous" ).on( "click", function() {
     
    if(count <= 0)
     {
         toastr.error('No more previous question !')
       
     }
     else
     {
    count--;
    setQuestion();
     }
    
 });
 $( "#next" ).on( "click", function() {
     
     if(count >= length-1)
     {
         toastr.error('No more question left !')
         
     }
     else
     {
    count++;
    setQuestion();
     }
    
 });

     
$( ".question_number" ).on( "click", function() {

 var key = $(this).attr('data-question');
   count = parseInt(key);
   setQuestion();
} );

setQuestion()
     function setQuestion() {
         
             isToggled = true;
      
          $("#mark_for_review").trigger('click');
           $(".arrow_td").html('');
          $("#arrow_td_"+count).html('<i class="fa fa-arrow-right" aria-hidden="true"></i>');
         
        
          
        
       $('input[name="radios"]').prop('checked', false);
       $('#numeric_ans').val('');
       if(myArray[count].question_type_id == 2)
{
    $('.objective').hide();
    $('.numeric').show();
}else
{
     $('.objective').show();
    $('.numeric').hide();
}

var ques_medium = '';
var objective_a = '';
var objective_b = '';
var objective_c = '';
var objective_d = '';
if(paper_medium.medium ==1) //english
{
    ques_medium = (myArray[count].name ?? '');
    objective_a = (myArray[count].ans_a ?? '');
    objective_b = (myArray[count].ans_b ?? '');
    objective_c = (myArray[count].ans_c ?? '');
    objective_d = (myArray[count].ans_d ?? '');
}
else if(paper_medium.medium ==2) //hindi
{
    ques_medium = (myArray[count].hi_name ?? '');
      objective_a = (myArray[count].hi_ans_a ?? '');
      objective_b = (myArray[count].hi_ans_b ?? '');
      objective_c = (myArray[count].hi_ans_c ?? '');
      objective_d = (myArray[count].hi_ans_d ?? '');
}
else if(paper_medium.medium ==3)//both
{
    ques_medium = (myArray[count].name ?? '' ) +'</br>'+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_name ?? '')
     objective_a = (myArray[count].ans_a ?? '') +'</br>' + (myArray[count].hi_ans_a ?? '') ;
     objective_b = (myArray[count].ans_b ?? '') +'</br>' + (myArray[count].hi_ans_b ?? '') ;
     objective_c = (myArray[count].ans_c ?? '') +'</br>' + (myArray[count].hi_ans_c ?? '') ;
     objective_d = (myArray[count].ans_d ?? '') +'</br>' + (myArray[count].hi_ans_d ?? '') ;
}


         $('#q1').html('Q. '+(count+1)+' ' + ques_medium);
      
$('#ans_a').html(objective_a);
$('#ans_b').html(objective_b);
$('#ans_c').html(objective_c);
$('#ans_d').html(objective_d);
// $('#hi_ans_a').html('&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_ans_a ?? '') );
// $('#hi_ans_b').html('&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_ans_b ?? ''));
// $('#hi_ans_c').html('&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_ans_c ?? ''));
// $('#hi_ans_d').html('&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_ans_d ?? ''));



if(myArray[count].question_type_id == 2)
{
     $('#numeric_ans').val(decode[count].ans);   
     $('#numeric_ans').css('border','5px solid black');
     if(parseInt(decode[count].correct) == 2)
    {
         $('#numeric_ans').css('border','5px solid green');
        // $('#ans_a').css('border','1px solid green');
    }
    
    else if(parseInt(decode[count].correct) == 1)
    {
     $('#numeric_ans').css('border','5px solid red');
    }
  

}else
{
   $('.radio').eq(0).css('border','1px solid white');
   $('.radio').eq(1).css('border','1px solid white');
   $('.radio').eq(2).css('border','1px solid white');
   $('.radio').eq(3).css('border','1px solid white');
//   $('#ans_b').css('background-color','white');
//   $('#ans_c').css('background-color','white');
//   $('#ans_d').css('background-color','white');
    
    //for a
    if(parseInt(decode[count].ans) == 1 &&  parseInt(decode[count].correct) == 2)
    {
         $('.radio').eq(0).css('border','1px solid green');
    //   $( "#ques_"+count ).css( "background-color", "green" ) ;
    //      $( "#ques_"+count ).css( "color", "white" ) ;
    }
    else if(parseInt(decode[count].ans) == 1 &&  parseInt(decode[count].correct) == 1)
    {
     $('.radio').eq(0).css('border','1px solid red');
//   $( "#ques_"+count ).css( "background-color", "red" ) ;
//          $( "#ques_"+count ).css( "color", "white" ) ;
    }
    
    //for b
    
     if(parseInt(decode[count].ans) == 2 &&  parseInt(decode[count].correct) == 2)
    {
         $('.radio').eq(1).css('border','1px solid green');
        // $('#ans_b').css('border','1px solid green');
    }
    else if(parseInt(decode[count].ans) == 2 &&  parseInt(decode[count].correct) == 1)
    {
     $('.radio').eq(1).css('border','1px solid red');
    // $('#ans_b').css('border','1px solid red');
    }
    
    //for c
     if(parseInt(decode[count].ans) == 3 &&  parseInt(decode[count].correct) == 2)
    {
         $('.radio').eq(2).css('border','1px solid green');
        // $('#ans_c').css('border','1px solid green');
    }
    else if(parseInt(decode[count].ans) == 3 &&  parseInt(decode[count].correct) == 1)
    {
         $('.radio').eq(2).css('border','1px solid red');
    
    // $('#ans_c').css('border','1px solid red');
    }
    
    
    //for d
     if(parseInt(decode[count].ans) == 4 &&  parseInt(decode[count].correct) == 2)
    {
        // $('#ans_d').css('border','1px solid green');
         $('.radio').eq(3).css('border','1px solid green');
    }
    else if(parseInt(decode[count].ans) == 4 &&  parseInt(decode[count].correct) == 1)
    {
     $('.radio').eq(3).css('border','1px solid red');
    // $('#ans_d').css('border','1px solid red');
    }}
    
    var right_ans = 'Ans : a =>';

if(myArray[count].correct_ans == 1)
{
 $('.radio').eq(0).css('border','1px solid green');
}
else if(myArray[count].correct_ans == 2)
{
     $('.radio').eq(1).css('border','1px solid green');
//   $('#ans_b').css('border','1px solid green');
right_ans = 'Ans : b =>'
}
else if(myArray[count].correct_ans == 3)
{
     $('.radio').eq(2).css('border','1px solid green');
//   $('#ans_c').css('border','1px solid green');
right_ans = 'Ans : c =>'
}
else if(myArray[count].correct_ans == 4)
{
     $('.radio').eq(3).css('border','1px solid green');
    // $('#ans_d').css('border','1px solid green');
    right_ans = 'Ans : d =>'
}



if(myArray[count].question_type_id == 2)
{
    right_ans = 'Ans : '+ myArray[count].ans_a
}
 $('#ans_correct').html(right_ans);
 $('#ans_reivew').html('<b>Description : </b> ' + (myArray[count].solution ?? 'No solution availabe for the question. '));
 if(myArray[count].solution == null)
 {
     $('#ans_reivew').css('color','red');
 }
 else
 {
     $('#ans_reivew').css('color','black');
 }
 
 
console.log(ansArray)
$('p').attr('style', '');
$('p').replaceWith(function()
{
  return '<span>' + $(this).html() + '</span>';
});




     }
     
     function secondsToHours(seconds) {
         var hours = Math.floor(seconds / 3600);
    var minutes = Math.floor((seconds % 3600) / 60);
    var remainingSeconds = seconds % 60;

    return hours + ':'+ minutes + ':'+ remainingSeconds
    
      }
      
      $(document).ready(function(){
      $('#formAdd').submit(function() {
    var c = confirm("Do you really want to continue?");
    return c; //you can just return c because it will be true or false
});
    });
</script>


<script>

$(document).ready(function(){
    
   
  var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled || document.msFullscreenEnabled;

  if(!fullscreenEnabled){
    console.log('Fullscreen not supported');
  }

  $('#fullscreenButton').click(function(){
    if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
      exitFullscreen();
    } else {
      requestFullscreen();
    }
  });

  function requestFullscreen() {
    var element = document.documentElement;

    if (element.requestFullscreen) {
      element.requestFullscreen();
    } else if (element.mozRequestFullScreen) {
      element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) {
      element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) {
      element.msRequestFullscreen();
    }
  }

  function exitFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }

});
</script>


<script>
    $(function() {
    
    $(window).ready(function() {
       $('#fullscreenButton').trigger('click');
    });
});
</script>



<style>

.radio{
    width:100%;
    border-radius:6px;
padding-left:10px;
margin:5px;
display: flex;
  align-items: first baseline;
    
}

label{
     cursor:pointer;
}
.table_tr_selector:hover {
  color: white;
  background: #6639b5;
  cursor:pointer;
}

   
    .nav-color {
  color: #6c757d !important;
}
.form-group {
 
  border-radius: 5px;
 
width: auto;
  padding: 5px;
}

.title {
  margin: 5px;
  text-align: center;
}

#a1,#a2 {display:none;}
.btn-purple
{
  color: #fff;
  background-color: #841717;
  border-color: #841717;
  box-shadow: none;
}
</style>



@endsection