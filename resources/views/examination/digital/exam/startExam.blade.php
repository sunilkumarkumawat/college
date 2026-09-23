@extends('layout.app') 
@section('content')

@php

$start_time = Session::get('exam_'.$exam_id);
@endphp

<script type="text/javascript" async
          src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML">
  </script>
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-rss ftlayer"></i> &nbsp; Start Exam - {{$exam_name->name ?? 'N/A'}}</h3>
							<h3 class="text-right" style="float: left;width:200px;font-size: 1.5rem;font-weight: 400;">Time Left =)
							<h3 class="text-left ml-2 countdown_exam" style="float: left;width:200px;font-size: 1.5rem;font-weight: 400;">
							</h3>
							
							</h3>
			
							
						<!--	<div class="card-tools"> 
							    <a href="{{url('view/exam')}}" class="btn btn-primary btn-sm" id="back"><i class="fa fa-arrow-left"></i> Back</a> 
							    
						    </div>-->
						    
						</div>
					
						<div class="card-body">
						 
						 
						 <div class='row'>
						     
						     <div class ='col-12 col-md-9'>
						          <div class='row'>
						             <form class="form-horizontal">
<fieldset>



<!-- Multiple Radios -->
<div class="form-group">
    
  <h3 class="control-label" for="radios" id="test"></h3>
  <h5 class="control-label" style='line-height:35px' for="radios" id="q1">Q. 1 
  {!! htmlspecialchars($questions[0]->name ?? '')!!} </br>
    {!! htmlspecialchars($questions[0]->hi_name ?? '')!!}
 </h5>
  
  @if($exam_name->medium == 1)
  
  <span style='font-size:20px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="hindi">
     
        {!! htmlspecialchars($questions[0]->hi_name ?? '')!!}
    </span>
@endif

  <br>
  <div class="col-md-12 objective">
  <div class="radio">
   
      <input name="radios" class='mr-2'value="1" type="radio" id="o1">
    <label for="o1">
    <span id='ans_a'  class="font-weight-bold">{!! htmlspecialchars($questions[0]->ans_a ?? '')!!} </span> </br>
   
    </label>
	</div>
  <div class="radio">
  
      <input name="radios" class='mr-2' value="2" type="radio" id="o2">
       <label for="o2">
      <span id='ans_b' class="font-weight-bold">{!! htmlspecialchars($questions[0]->ans_b ?? '')!!}</span> </br>
     
    </label>
	</div>
  <div class="radio">
    
      <input name="radios" class='mr-2' value="3" type="radio" id="o3">
      <label for="o3">
      <span id='ans_c' class="font-weight-bold">{!! htmlspecialchars($questions[0]->ans_c ?? '')!!}</span> </br>
      
    </label>
	</div>
  <div class="radio">
  
      <input name="radios" class='mr-2' value="4" type="radio" id="o4">
        <label for="o4">
     <span id='ans_d' class="font-weight-bold">{!! htmlspecialchars($questions[0]->ans_d ?? '')!!}</span> </br>
     
    </label>
	</div>
  </div>
  <div class="col-md-12 numeric">
  <div class="radio">
    <label for="radios-0">
     <span>Your Answer : </span> <input name="numeric_ans" class='w-100' type="text" id="numeric_ans">
    
   
    </label>
	</div>

  </div>
</div>

</fieldset>
</form>

<div class="form-group" id="a1">Correct!</div>
<div class="form-group" id="a2">Incorrect!</div>
						              
						              </div>
						         
						         </div>
						     <div class ='col-12 col-md-3'>
						         
						         <div class='row' > 
						         		     <div class ='col-12 col-md-12 p-0'>
						         		         <button  class="btn btn-secondary w-50 " style='border-radius:0px' id='subject_name'>{{$questions[0]->subject_name ?? ''}}</button>
						         		         
						         </div>
						         
						         <div class ='col-12 col-md-12'>
						              <div class='row bg-danger' > 
						         		     <div class ='col-6 col-md-4'>
						         		         ExamId : {{$exam_name->id ?? 'N/A'}}
						         		         </div>
						         		     <div class ='col-6 col-md-8'>
						         		         {{$exam_name->name ?? 'N/A'}}
						         		         </div>
						         		  
						             </div>
						         </div>
						         
						         <div class ='col-12 col-md-12'>
						              <div class='row pt-3' id='ques_list' > 
                            
                            @if(!empty($questions))
                            @foreach($questions as $key => $item)
                             <div class ='col-2 col-md-2 mb-2'>
						         		 <button  class="btn btn-secondary w-100 question_number not_visited"  id='ques_{{$key}}' data-question ={{$key}}><span style='font-size:12px !important'>{{$key+1}}</span></button>
						         		         </div>
						    @endforeach
						    @endif
						              </div>
						              </div>
						         <div class ='col-12 col-md-12'>
						              <div class='row pt-3' > 
                           
                             <div class ='col-6 col-md-6 mb-2  '>
						         		 <span  class="btn btn-success  ">&nbsp;</span> Answered
						         		         </div>
                             <div class ='col-6 col-md-6 mb-2  '>
						         		 <span  class="btn btn-danger  ">&nbsp;</span> Not Answered
						         		         </div>
                             <div class ='col-6 col-md-6 mb-2 '>
						         		 <span  class="btn btn-purple  ">&nbsp;</span> Marked
						         		         </div>
                             <div class ='col-6 col-md-6 mb-2 '>
						         		 <span  class="btn btn-secondary  ">&nbsp;</span> Not Visited
						         		         </div>
						        		    
						              </div>
						              </div>
						     </div>
						 </div>
						 
						 
						 
					</div>
					<div class='row' style='position:absolulte; bottom:0px'> 
						 
						 <div class='col-6 col-md-3' ><button  class="btn btn-secondary w-100 " id='clear_response'>Clear Response</button></div>
						 <div class='col-6 col-md-3' ><button  class="btn btn-purple w-100 " id='mark_for_review'>Mark For Review</button></div>
						 <div class='col-6 col-md-2' ><button class="btn btn-primary w-100 " id="save_and_next">Save & Next</button></div>
						 <div class='col-6 col-md-1' >
						     
						     <form action ="{{url('digitalResultExam')}}" method='post' id='formAdd' >
						         @csrf
						         <input type='hidden' name='result' id='form_submit_ans'/>
						         <input type='hidden' name='exam_id' value ='{{$exam_id ?? ''}}' />
						         <!--<input type='text' name='question_id' id='question_ids' />-->
						         <input type='hidden' name='not_visited' id='not_visited' />
						        
						         <input type='hidden' name='total_ques' value ='{{count($questions)}}' />
						         <input type='hidden' name='total_correct' id='total_correct' value ='{{count($questions)}}' />
						         <input type='hidden' name='total_skip' id='total_skip'  value ='{{count($questions)}}' />
						         <input type='hidden' name='total_wrong' id='total_wrong'  />
						         <input type='hidden' name='spend_time' id='spend_time'  />
						         <input type='hidden' name='subject_id_groupBy' id='subject_id_groupBy'  />
						         
						         
						         <input  type='button' class="btn btn-success w-100 " value='Submit'  data-toggle="modal" data-target="#exampleModal"/>
						         
						     </form>
						     
						
						 
						 
						 </div>
						 <div class='col-6 col-md-3' ><button  class="btn btn-purple w-100 " data-toggle="modal" data-target=".bd-example-modal-lg">Question Paper</button></div>
						 </div>
				</div>
			</div>
		</div>
	</section>
</div>



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="container">
         @foreach($questions as $key=> $item)
        <div class="row" style='border-bottom:1px solid black'>
    <div class="col-12 col-md-6 p-3 ">
       <span class='font-weight-bold'>Q.{{$key+1}}) {!! html_entity_decode($item->name ?? '', ENT_QUOTES, 'UTF-8') !!}   </span> 
           <div class="row mt-4">
    <div class="col-12 col-md-12 p-1">
        <b>a.)</b> {!! html_entity_decode($item->ans_a ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>b.)</b> {!! html_entity_decode($item->ans_b ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>c.)</b> {!! html_entity_decode($item->ans_c ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>d.)</b> {!! html_entity_decode($item->ans_d ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    
        </div>
        </div>
    <div class="col-12 col-md-6 p-3">
        @if(!empty($item->hi_name))
       <span class='font-weight-bold'>  Q.{{$key+1}}) {!! html_entity_decode($item->hi_name ?? 'N/A', ENT_QUOTES, 'UTF-8') !!}  </span> 
        <div class="row mt-4">
    <div class="col-12 col-md-12 p-1">
         <b>a.)</b> {!! html_entity_decode($item->hi_ans_a ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>b.)</b> {!! html_entity_decode($item->hi_ans_b ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>c.)</b> {!! html_entity_decode($item->hi_ans_c ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    <div class="col-12 col-md-12 p-1">
         <b>d.)</b> {!! html_entity_decode($item->hi_ans_d ?? '', ENT_QUOTES, 'UTF-8') !!} 
        
        </div>
    
        </div>
        @endif
        </div>
        </div>
     
      
      
      @endforeach
  
        </div>
        
      
     
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Do you really want to submit ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id='modal-btn-confirm'>Confirm</button>
      </div>
    </div>
  </div>
</div>
<script>


var myArray = @json($questions);
var paper_medium = @json($exam_name);
  var groupedData = [];
$.each(myArray, function(index, item) {
      var key = item.subject_id;

      if ($.inArray(item.subject_id, groupedData) == -1) {
        groupedData.push(item.subject_id);
      }

    //  groupedData[key].push(item.subject_id);
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
 ansArray[index] = { 'que_id' :myArray[index].id ,'ans' : null ,'correct': 0 ,'time' : 0 ,'visited_count': 0 ,'subject_id' : myArray[index].subject_id}
});

$('#form_submit_ans').val(JSON.stringify(ansArray))
$('#not_visited').val($('.not_visited').length)
   
      
    $( "#save_and_next" ).on( "click", function() {
      
       if(count < length){
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

        ansArray[count] = { 'que_id': myArray[count].id,'ans' : ansValue ?? null,'correct': correctAns,'time' : countUp ,'visited_count': (ansArray[count].visited_count+1) ,'subject_id' :myArray[count].subject_id };
        
        
        
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

}
else
{
    toastr.error('This is the last question.')
}
} );

 $( "#mark_for_review" ).on( "click", function() {
    $( "#ques_"+count).attr('class','btn btn-purple w-100 question_number'); 
    count++;
    setQuestion()
 });
     
$( ".question_number" ).on( "click", function() {

 

 var key = $(this).attr('data-question');
   count = parseInt(key);
   setQuestion();
} );
     function setQuestion() {
           $('.question_number').attr('style','');
          $('#ques_'+count).css('background-color','black'); 
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
    ques_medium =(myArray[count].name ?? '' ) +'</br>'+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +(myArray[count].hi_name ?? '');
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

$('#subject_name').html(myArray[count].subject_name ?? '');



if(myArray[count].question_type_id == 2)
{
   $('#numeric_ans').val(ansArray[count].ans);
}else
{
   $("input[name='radios'][value=" + ansArray[count].ans + "]").prop('checked', true);
}


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
      
      
      
//       $(document).ready(function(){
//       $('#formAdd').submit(function() {
          
          
//     var c = confirm("Do you really want to continue?");
//     return c; //you can just return c because it will be true or false
// });
//     });
$('#ques_0').trigger('click');

 $( "#clear_response" ).on( "click", function() {
     $('input[name="radios"]').prop('checked', false);
     
 });
</script>


<script>
 $(document).ready(function(){
     setTimmer();
     function setTimmer(){
    var currentDate = new Date();

    // Set another date (e.g., 30 minutes later)
    
    var session_time = @json($start_time) ;
    var futureDate = new Date(session_time); // 30 minutes in milliseconds

    // Calculate the time difference
    var timeDifference = (futureDate - currentDate)/1000;
   



    // Convert the time difference to minutes and seconds
    // var minutes = Math.floor(timeDifference / 60000);
    // var seconds = ((timeDifference % 60000) / 1000).toFixed(0);
     var hours = Math.floor(timeDifference / 3600);
    var minutes = Math.floor((timeDifference % 3600) / 60);
    var seconds = (timeDifference % 60).toFixed(0);;
    
    $('.countdown_exam').text(hours +' hr '+minutes +' min ' +  seconds + ' sec ')
    
    if(parseInt(minutes) <= 0 && parseInt(seconds) <= 0)
    {
         if(parseInt(hours) <= 0 )
    {
        clearInterval(intervalId)
          $( "#formAdd" ).trigger( "submit" );
    }
    }
     }
     
     
var intervalId = window.setInterval(function(){
setTimmer();
}, 1000);
 });
 
</script>


<script>


    var modalConfirm = function(callback){
  
  
 
 
  $("#modal-btn-confirm").on("click", function(){
    callback(true);
    $("#exampleModal").modal('hide');
  });
  

};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
  $( "#formAdd" ).trigger( "submit" );
  }
});
</script>
<script type="text/javascript">
function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

$(document).ready(function(){
     $(document).on("keydown", disableF5);
});
</script>

<style>

.radio{
    display: flex;
  align-items: first baseline;
 
}
label{
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


  
}
</style>



@endsection