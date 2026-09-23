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
							
							<div class="card-tools"> 
							    <a href="{{url('view/exam')}}" class="btn btn-primary btn-sm" id="back"><i class="fa fa-arrow-left"></i> Back</a> 
						    </div>
						</div>
						<div class="card-body">
						   

    <!-- website section start -->
    <div class="container-fluid px-0">
    <section class="quizbody">
       <div class="container">
           <div class="row">
               <div class="col-12 d-flex text-center justify-content-center align-items-center flex-column" style="padding: 50px 0; background-color: #007bff; color: white;">
                    <h1 class="quizh1" style="font-size: 3rem; font-weight: 700;">
                        Exam : {{ $data[0]['examName'] ?? '' }}
                    </h1>
                    <h3 class="descriptionh3">
                        Click below Button to Start the Quiz
                    </h3>
               </div>
               <div class="col-12 button-div d-flex justify-content-center align-items-center">
                   <div>
                        <button class="btn1" id="mainButton">
                            Start Your Quizz
                            <span></span><span></span><span></span><span></span>
                        </button>
                   </div>
               </div>
               <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                        <div class="info_box">
                            <div class="info-title"><span>Some Rules of this Quiz</span></div>
                            <div class="info-list">
                                <div class="info">1. You will have only <span>20 seconds</span> per each question.</div>
                                <div class="info">2. You can skip any question you want.</div>
                                <div class="info">3. You can't select any option once time goes off.</div>
                                <div class="info">4. You can't exit from the Quiz while you're playing.</div>
                                <div class="info">5. You'll get points on the basis of your correct answers.</div>
                                <div class="info">6. Your skipped question will be result 0 points.</div>
                            </div>
                            <div class="buttons">
                                <button class="quit btn btn-danger">Exit Quiz</button>
                                <button class="continue btn btn-primary ques_name">Continue</button>
                            </div>
                    </div>
               </div>
           </div>
       </div>
    </section>
    <section class="questionbody">
        <div class="container-fluid" style="background-color: #007bff;">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="quiz_box">
                            <header>
                                <div class="title">Quiz Application</div>
                                <div class="timer">
                                    <div class="time_left_txt">Time Left</div>
                                    <div class="timer_sec">20</div>
                                </div>
                                <div class="time_line"></div>
                            </header>
                            <section class="qasection">
                                <div class="que_text">
                                    How old am I?
                                </div>
                                <div style="visibility:hidden;margin-bottom:-20px"class="que_ans">
                                  
                                </div>
                                <div style="visibility:hidden;margin-bottom:-20px"class="que_id">
                                   
                                </div>
                              
                                <div class="option_list containerr">
                                    <div class="option">
                                        <input type="radio" name="submit_ans" id="opt1" value="0" class="submit_ans">
                                        <label for="opt1" aria-label="opt1">
                                            <span></span>
                                            option 1
                                        </label>
                                    </div>
                                
                                    <div class="option">
                                        <input type="radio" name="submit_ans" id="opt2" value="1" class="submit_ans">
                                        <label for="opt2" aria-label="opt2">
                                            <span></span>
                                            option 2
                                        </label>
                                    </div>
                                
                                    <div class="option">
                                        <input type="radio" name="submit_ans" id="opt3" value="2" class="submit_ans">
                                        <label for="opt3" aria-label="opt3">
                                            <span></span>
                                            option 3
                                        </label>
                                    </div>
                                    <div class="option">
                                        <input type="radio" name="submit_ans" id="opt4" value="3" class="submit_ans">
                                        <label for="opt4" aria-label="opt4">
                                            <span></span>
                                            option 4
                                        </label>
                                    </div>
                                </div>
                            </section>
                        
                        
                            <footer>
                                <div class="total_que">
                                    <span class="QNO"></span>  of 20
                                </div>
                                <div class="btns">
                                <button class="back btn btn-primary">back</button>
                                <button class="btn btn-warning skip">Skip</button>
                                <button class="btn next ques_name btn-primary">Next</button>
                                <button class="btn result btn-success">Result</button>
                                </div>
                            </footer>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <section class="resultbody">
        <div class="container-fluid" style="background-color: #007bff;">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <div class="result_box">
                        <header class="d-flex flex-column">
                            <div class="title" style="
                                margin-top: 10px;
                                font-size: 30px;
                                font-weight: 700;
                                color: var(--bgprm);
                            ">Your Result</div>
                            <div class="time_line"></div>
                        </header>
                        <section class="result-showing-box">
                            <div class="answer-info">
                                <div class="total-ans d-flex justify-content-between">
                                    <h3>ALL Questions</h3>
                                    <h3 id="TQ"style="color: #007bff;">20</h3>
                                </div>
                                <div class="correct-ans d-flex justify-content-between">
                                    <h4>Correct Answers</h4>
                                    <h4 class="Correct-ans-given" style="color: #007bff;"></h4>
                                </div>
                                <div class="wrong-ans d-flex justify-content-between">
                                    <h4>Wrong Answers</h4>
                                    <h4 class="wrong-ans-given" style="color: #007bff;"></h4>
                                </div>
                                <div class="skipped-ans d-flex justify-content-between">
                                    <h4>Skipped Answers</h4>
                                    <h4 style="color: #007bff;" class="skip-ans-given"></h4>
                                </div>
                            </div>
                            <div class="perc-result">
                                <h3>Your Percentage is <span class="percentage" style="color: #007bff;"></span></h3>
                                <div class="perc-line-div">
                                    <div class="perc-line"></div>
                                </div>
                            </div>
                            <div class="time-result">
                                <h3>You completed the Quiz in <span class="time" style="color: #007bff;"></span> Seconds</h3>
                                <div class="time-line-div">
                                    <div class="time-line"></div>
                                </div>
                            </div>
                        </section>
                        <footer style="height: 100px;">
                            <!--<div class="replay-btn-icons">
                                <div>
                                    <p class="icons-text mb-0">
                                        How you felt about the Quiz
                                    </p>
                                    <div class="icons">
                                    <i class="far fa-surprise"></i>
                                    <i class="far fa-smile-beam"></i>
                                    <i class="far fa-sad-cry"></i>
                                    <i class="far fa-meh"></i>
                                    <i class="far fa-grin-hearts"></i>
                                    </div>
                                </div>
                            </div>-->
                            <div class="btns">
                                <!--<button class="restart btn btn-primary">Restart</button>-->
                            </div>
                            <div class="btns mr-4">
                                <button class="restart btn btn-danger" id="close">Close</button>
                            </div>                            
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<span id="questions"></span>
 @if(!empty($data)) 
                 
                                  @foreach($data as $key =>$item)
                    <input type="hidden" id="quz_{{$key}}" value="{{$item['name']}}">            
                    <input type="hidden" id="ans1_{{$key}}" value="{{$item['ans1']}}">            
                    <input type="hidden" id="ans2_{{$key}}" value="{{$item['ans2']}}">          
                    <input type="hidden" id="ans3_{{$key}}" value="{{$item['ans3']}}">           
                    <input type="hidden" id="ans4_{{$key}}" value="{{$item['ans4']}}">            
                    <input type="hidden" id="correct_ans_{{$key}}" value="{{$item['correct_ans']}}">             
                    <input type="hidden" id="que_id_{{$key}}" value="{{$item['id']}}">             
                                  @endforeach
                              @endif


<script>
let quizJSON = [];
let quizJSON1 = "";
function fetchQuestion()
{

$.ajax({
    type:"GET",
    url:"/fetchQuestion",
    datatype:"json",
    success:function(response){ 
        //console.log(response.students);
        $('tbody').html("");
        $.each(response.students,function (key, item){
            quizJSON1=[item.title,item.choices];
           //  alert(quizJSON1);
      //  alert(item.title + "\r\n\r\n"+item.choices+ "\r\n\r\n"+item.correctAnswer)
           
               })
    }
})

}

        $(document).ready(function () {
             fetchQuestion()
      // alert(quizJSON1);
quizJSON=[
    {
        "title":$('#quz_0').val(),
        "choices":[
            $('#ans1_0').val(),
            $('#ans2_0').val(),
            $('#ans3_0').val(),
            $('#ans4_0').val()
        ],
        "correctAnswer": $('#correct_ans_0').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_0').val()
    },
    {
        "title":$('#quz_1').val(),
        "choices":[
              $('#ans1_1').val(),
              $('#ans2_1').val(),
              $('#ans3_1').val(),
              $('#ans4_1').val()
        ],
        "correctAnswer":$('#correct_ans_1').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_1').val()
    },
    {
        "title":$('#quz_2').val(),
        "choices":[
            $('#ans1_2').val(),
            $('#ans2_2').val(),
            $('#ans3_2').val(),
            $('#ans4_2').val()
        ],
        "correctAnswer":$('#correct_ans_2').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_2').val()
    },
    {
        "title":$('#quz_3').val(),
        "choices":[
             $('#ans1_3').val(),
             $('#ans2_3').val(),
             $('#ans3_3').val(),
             $('#ans4_3').val()
        ],
        "correctAnswer":$('#correct_ans_3').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_3').val()
    },
    {
        "title":$('#quz_4').val(),
        "choices":[
             $('#ans1_4').val(),
             $('#ans2_4').val(),
             $('#ans3_4').val(),
             $('#ans4_4').val()
        ],
        "correctAnswer":$('#correct_ans_4').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_4').val()
    },
    {
        "title":$('#quz_5').val(),
        "choices":[
            $('#ans1_5').val(),
             $('#ans2_5').val(),
             $('#ans3_5').val(),
             $('#ans4_5').val()
        ],
        "correctAnswer":$('#correct_ans_5').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_5').val()
    },
    {
        "title":$('#quz_6').val(),
        "choices":[
            $('#ans1_6').val(),
             $('#ans2_6').val(),
             $('#ans3_6').val(),
             $('#ans4_6').val()
        ],
        "correctAnswer":$('#correct_ans_6').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_6').val()
    },
    {
        "title":$('#quz_7').val(),
        "choices":[
            $('#ans1_7').val(),
             $('#ans2_7').val(),
             $('#ans3_7').val(),
             $('#ans4_7').val()
        ],
        "correctAnswer":$('#correct_ans_7').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_7').val()
    },
    {
        "title":$('#quz_8').val(),
        "choices":[
            $('#ans1_8').val(),
             $('#ans2_8').val(),
             $('#ans3_8').val(),
             $('#ans4_8').val()
        ],
        "correctAnswer":$('#correct_ans_8').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_8').val()
    },
    {
        "title":$('#quz_9').val(),
        "choices":[
            $('#ans1_9').val(),
             $('#ans2_9').val(),
             $('#ans3_9').val(),
             $('#ans4_9').val()
        ],
        "correctAnswer":$('#correct_ans_9').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_9').val()
    },
    {
        "title":$('#quz_10').val(),
        "choices":[
            $('#ans1_10').val(),
             $('#ans2_10').val(),
             $('#ans3_10').val(),
             $('#ans4_10').val()
        ],
        "correctAnswer":$('#correct_ans_10').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_10').val()
    },
    {
        "title":$('#quz_11').val(),
        "choices":[
            $('#ans1_11').val(),
             $('#ans2_11').val(),
             $('#ans3_11').val(),
             $('#ans4_11').val()
        ],
        "correctAnswer":$('#correct_ans_11').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_11').val()
    },
    {
        "title":$('#quz_12').val(),
        "choices":[
            $('#ans1_12').val(),
             $('#ans2_12').val(),
             $('#ans3_12').val(),
             $('#ans4_12').val()
        ],
        "correctAnswer":$('#correct_ans_12').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_12').val()
    },
    {
        "title":$('#quz_13').val(),
        "choices":[
            $('#ans1_13').val(),
             $('#ans2_13').val(),
             $('#ans3_13').val(),
             $('#ans4_13').val()
        ],
        "correctAnswer":$('#correct_ans_13').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_13').val()
    },
    {
        "title":$('#quz_14').val(),
        "choices":[
            $('#ans1_14').val(),
             $('#ans2_14').val(),
             $('#ans3_14').val(),
             $('#ans4_14').val()
        ],
        "correctAnswer":$('#correct_ans_14').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_14').val()
    },
    {
        "title":$('#quz_15').val(),
        "choices":[
            $('#ans1_15').val(),
             $('#ans2_15').val(),
             $('#ans3_15').val(),
             $('#ans4_15').val()
        ],
        "correctAnswer":$('#correct_ans_15').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_15').val()
    },
    {
        "title":$('#quz_16').val(),
        "choices":[
            $('#ans1_16').val(),
             $('#ans2_16').val(),
             $('#ans3_16').val(),
             $('#ans4_16').val()
        ],
        "correctAnswer":$('#correct_ans_16').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_16').val()
    },
    {
        "title":$('#quz_17').val(),
        "choices":[
            $('#ans1_17').val(),
             $('#ans2_17').val(),
             $('#ans3_17').val(),
             $('#ans4_17').val()
        ],
        "correctAnswer":$('#correct_ans_17').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_17').val()
    },
    
    {
        "title":$('#quz_18').val(),
        "choices":[
            $('#ans1_18').val(),
             $('#ans2_18').val(),
             $('#ans3_18').val(),
             $('#ans4_18').val()
        ],
        "correctAnswer":$('#correct_ans_18').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_18').val()
    },
    {
        "title":$('#quz_19').val(),
        "choices":[
            $('#ans1_19').val(),
             $('#ans2_19').val(),
             $('#ans3_19').val(),
             $('#ans4_19').val()
        ],
        "correctAnswer":$('#correct_ans_19').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_19').val()
    },
    {
        "title":$('#quz_20').val(),
        "choices":[
            $('#ans1_20').val(),
             $('#ans2_20').val(),
             $('#ans3_20').val(),
             $('#ans4_20').val()
        ],
        "correctAnswer":$('#correct_ans_20').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_20').val()
    },
    {
        "title":$('#quz_21').val(),
        "choices":[
            $('#ans1_21').val(),
             $('#ans2_21').val(),
             $('#ans3_21').val(),
             $('#ans4_21').val()
        ],
        "correctAnswer":$('#correct_ans_21').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_21').val()
    },
    {
        "title":$('#quz_22').val(),
        "choices":[
            $('#ans1_22').val(),
             $('#ans2_22').val(),
             $('#ans3_22').val(),
             $('#ans4_22').val()
        ],
        "correctAnswer":$('#correct_ans_22').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_22').val()
    },
    {
        "title":$('#quz_23').val(),
        "choices":[
            $('#ans1_23').val(),
             $('#ans2_23').val(),
             $('#ans3_23').val(),
             $('#ans4_23').val()
        ],
        "correctAnswer":$('#correct_ans_23').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_23').val()
    },
    {
        "title":$('#quz_24').val(),
        "choices":[
            $('#ans1_24').val(),
             $('#ans2_24').val(),
             $('#ans3_24').val(),
             $('#ans4_24').val()
        ],
        "correctAnswer":$('#correct_ans_24').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_24').val()
    },
    {
        "title":$('#quz_25').val(),
        "choices":[
            $('#ans1_25').val(),
             $('#ans2_25').val(),
             $('#ans3_25').val(),
             $('#ans4_25').val()
        ],
        "correctAnswer":$('#correct_ans_25').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_25').val()
    },
    {
        "title":$('#quz_26').val(),
        "choices":[
            $('#ans1_26').val(),
             $('#ans2_26').val(),
             $('#ans3_26').val(),
             $('#ans4_26').val()
        ],
        "correctAnswer":$('#correct_ans_26').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_26').val()
    },
    {
        "title":$('#quz_27').val(),
        "choices":[
            $('#ans1_27').val(),
             $('#ans2_27').val(),
             $('#ans3_27').val(),
             $('#ans4_27').val()
        ],
        "correctAnswer":$('#correct_ans_27').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_27').val()
    },
    {
        "title":$('#quz_28').val(),
        "choices":[
            $('#ans1_28').val(),
             $('#ans2_28').val(),
             $('#ans3_28').val(),
             $('#ans4_28').val()
        ],
        "correctAnswer":$('#correct_ans_28').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_28').val()
    },
    {
        "title":$('#quz_29').val(),
        "choices":[
            $('#ans1_29').val(),
             $('#ans2_29').val(),
             $('#ans3_29').val(),
             $('#ans4_29').val()
        ],
        "correctAnswer":$('#correct_ans_29').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_29').val()
    },
    {
        "title":$('#quz_30').val(),
        "choices":[
            $('#ans1_30').val(),
             $('#ans2_30').val(),
             $('#ans3_30').val(),
             $('#ans4_30').val()
        ],
        "correctAnswer":$('#correct_ans_30').val(),
        "pointerEvents":false,
        "secondsLeft":$('#exam_duration').val(),
        "AnsweredQue":"",
        "question_id":$('#que_id_30').val()
    }
    
]
 quizJSON=JSON.stringify(quizJSON);
const quiz=JSON.parse(quizJSON);
console.log(quiz);
// Json work finished
 
var questionnumber=-1;
let scndsLftOfQueArr=[];
let radioBtnChecked=[];

// Some work for DOM Manipulation start


    $("#mainButton").click(function(){
        $(".quizh1").text("Rules");
        $(".descriptionh3").text("Read the Rules and understand them.");
        $(this).parent().fadeIn();
        $(this).parent().parent().remove();
        $(".info_box").fadeIn();
   });


   $(".quit").click(function(){
    location.reload();
   });

   $(".continue").click(function(){
    $(".quizbody").slideUp(1000);
    $(".questionbody").fadeIn(1000);
    questionnumber++;
    countTotalTime();
    showquestionnum();
    showquestion();
    diablingButtons();
    saveRadioBtnValue();
    // startTimeLeft();
    // checkTODisabelPointer();
   });

   $('.btn').on('mouseenter', function () {
    $(this).addClass('active');
   });
   $('.btn').on('mouseleave', function () {
    $(this).removeClass('active');
   });
   function diablingButtons() {
       if (questionnumber==0) {
         $(".back").addClass('disabled');  
       }
       else
       {
         $(".back").removeClass('disabled');  
       }
   }
// Some work for DOM Manipulation end

//allowing uncheck the radio button -->
        document.querySelectorAll('input[type=radio][name=submit_ans]').forEach((elem) => {
            elem.addEventListener('click', allowUncheck);
            elem.previous = elem.checked;
        });
     

    function allowUncheck(e) {
    if (this.previous) {
        this.checked = false;
    }
    document.querySelectorAll(
        `input[type=radio][name=${this.name}]`).forEach((elem) => {
        elem.previous = elem.checked;
    });
    };
//allowing uncheck the radio button <--

// starting the quiz's logical work
   
   let randomnumber;
   let randomnumarr=[];
   let indexpre=randomnumarr[questionnumber];
   let index =quiz[indexpre];

   

   //getting the random number function -->
        function getrandomnumber(){
        randomnumber=Math.floor(Math.random()*29)+1;
        };
   //getting the random number function <--

     //checking the Random Number for not getting same number -->
     function checkRandomNumber() {
         for (let i = 0; i < 31; i++) {     
                getrandomnumber()
                let checkRN= jQuery.inArray( randomnumber,  randomnumarr);
                if (checkRN==-1) {
                    randomnumarr[questionnumber]=randomnumber;
                    break;
                }
                }
                indexpre=randomnumarr[questionnumber];
                index =quiz[indexpre]
     }        
    //checking the Random Number for not getting same number <--

    //showing the QUESTIONS function -->
     function showquestion() {
         radioButtons = $("input:radio[name='submit_ans']");
         if (questionnumber<randomnumarr.length) {
             indexpre=randomnumarr[questionnumber];
             index=quiz[indexpre]
            
         
    
            $(".que_text").text(index.title);
          
            $("label").eq(0).text(index.choices[0]);
            $("label").eq(1).text(index.choices[1]);
            $("label").eq(2).text(index.choices[2]);
            $("label").eq(3).text(index.choices[3]);
            for (var x = 0; x < radioButtons.length; x++) {
                var idVal = $(radioButtons[x]).attr("id");
                radioBtnCheckedVal=$("label[for='"+idVal+"']").text();
                if (radioBtnCheckedVal === radioBtnChecked[questionnumber]) {
                    radioButtons[x].checked = true;
                      $(".que_checked").text(radioBtnCheckedVal);
                }
                if (radioBtnChecked[questionnumber]===" ") {
                    radioButtons[x].checked = false;
                }
            }
            if (questionnumber>0) {
                 resetingTheTime();
             }
             startTimeLeft();
        }
        else
        {
             checkRandomNumber();
            $(".que_text").text(index.title);
              $(".que_ans").text(index.correctAnswer);
            $(".que_id").text(index.question_id);
            $("label").eq(0).text(index.choices[0]);
            $("label").eq(1).text(index.choices[1]);
            $("label").eq(2).text(index.choices[2]);
            $("label").eq(3).text(index.choices[3]);
            $("input:radio[name='submit_ans']").each(function(i) {
                this.checked = false;
            }); 
            console.log(index.correctAnswer);
            if (questionnumber>0) {
                 resetingTheTime();
             }
             startTimeLeft();
        } 
     };
     //showing the QUESTIONS function <--



    //  starting the time of question start function-->
    let secondSetInterval;
    let width;
    function startTimeLeft() {
      secondSetInterval = setInterval(function () {
          index.secondsLeft-=1;
          width=(index.secondsLeft/20)*100;
        //   $(".time_line").css(
        //       {
        //           "width":`${width}%`,
        //           "transition": "width 1s linear"
        //       }
        //   )
            if (index.secondsLeft<10) {
              $(".timer_sec").text("0" + index.secondsLeft);
            }
            else
            {
                $(".timer_sec").text(index.secondsLeft); 
            }
            if (index.secondsLeft==0) {
            $(".option_list").addClass("pointerNone");
            index.pointerEvents=true;
            $(".quiz_box").prepend(`<marquee id="marquee" class="marquee my-2" width="100%" direction="left" height="20px">
            You cannot select any option Now.
            </marquee>`);
            // $(".time_line").hide();
            clearInterval(secondSetInterval);
            }
      },1000);
    };
    //  starting the time of question end function <--


    //  resetting the time of question start function -->
    function resetingTheTime() {
      clearInterval(secondSetInterval);
      secondsForTimeOut=index.secondsLeft;
     scndsLftOfQueArr[questionnumber] = index.secondsLeft;
      secondCount = index.secondsLeft;
      $(".timer_sec").text(index.secondsLeft);    
    };
    //  resetting  the time of question end function <--


    //  starting the time of question start function-->
    let totalSetInterval;
    let totaltime=0;
    function countTotalTime() {
      totalSetInterval = setInterval(function () {
          totaltime+=1;
      },1000);
    };
    //  starting the time of question end function <--


    //  calculating the score and storing the checked values in-->
    let radioBtnCheckedVal;
   var array4 = Array();
 var x2 = -1;
   var idVal ="";
     
    function saveRadioBtnValue() {
        $("input:radio[name='submit_ans']").each(function(i){
            if($(this).is(':checked'))
            {
                 idVal = $(this).attr("id");
                
                if(idVal=="opt1"){array4[x2] = 0;}
                else if(idVal=="opt2"){array4[x2] = 1;}
                else if(idVal=="opt3"){array4[x2] = 2;}
                else if(idVal=="opt4"){array4[x2] = 3;}
                radioBtnCheckedVal=$("label[for='"+idVal+"']").text();
                return false;
            }
            else{
                radioBtnCheckedVal=" ";
                 array4[x2] = "skip";
            }
        });
        
          var userAns = radioBtnCheckedVal;
        radioBtnChecked[questionnumber] = userAns;
        
        
    }
    // calculating the score <--

     //showing the QUESTIONS Number function -->
     function showquestionnum() {
          $(".QNO").text(questionnumber+1 + " ");
     }
     //showing the QUESTIONS Number function <--


// ending the quiz's logical work

// adding the functionalities to buttons starts

$(".back").click(function(){
    x--;
    x2--;
        if (questionnumber<20 && questionnumber>=1) {
            $(".result").hide();
            $(".next").show();
            $(".skip").removeClass('disabled');
            $("#marquee").remove();
            saveRadioBtnValue();
            clearInterval(secondSetInterval);
            questionnumber--;
            showquestionnum();
            showquestion();
            diablingButtons();
            if (index.pointerEvents===true) {   
              $(".option_list").addClass("pointerNone");
               $(".quiz_box").prepend(`<marquee id="marquee" class="marquee my-2" width="100%" direction="left" height="20px">
                You cannot select any option Now.
                </marquee>`)
                clearInterval(secondSetInterval);
                $(".timer_sec").text("00");
            }
            else
            {
             $(".option_list").removeClass("pointerNone");   
            }
            
        }
        else
        {
            diablingButtons();
        }
   });
  var x = 0;
  
 var array = Array();
 var array1 = Array();
 var array3 = Array();

   $(".next, .skip").click(function(){
        
   
      array[x] = $(".que_text").text();
      array1[x] = $(".que_id").text();
      array3[x] = $(".que_ans").text();
     // alert(array);
       x++;
       x2++;
        if (questionnumber<19) {
            $("#marquee").remove(); 
            clearInterval(secondSetInterval); 
            saveRadioBtnValue();
            questionnumber++;
            showquestionnum();
            showquestion();
            diablingButtons();
            indexpre=randomnumarr[questionnumber];
            index =quiz[indexpre]
            if (index.pointerEvents===true) {   
              $(".option_list").addClass("pointerNone");
              $(".quiz_box").prepend(`<marquee id="marquee" class="marquee my-2" width="100%" direction="left" height="20px">
                You cannot select any option Now.
                </marquee>`)
                clearInterval(secondSetInterval);
                $(".timer_sec").text("00");
            }
            else
            {
             $(".option_list").removeClass("pointerNone");   
            }
        }
        if (questionnumber==19) {
            $(".skip").addClass('disabled');
            $(".next").hide();
            $(".result").show();
        }
   });

//    making a function for checking results -->


let CA=0;
let SA=0;
let WA=0;
function checkResults() {
    
    for (let i = 0; i < randomnumarr.length; i++) {
        let indexpre=randomnumarr[i];
        let index =quiz[indexpre]; 
        if (radioBtnChecked[i]==index.choices[index.correctAnswer]) {
            CA++;
        }  
        else if (radioBtnChecked[i]== " ") {
            SA++;
        }
        else
        {
             WA++;
        }      
    }
 
}


//    making a function for checking results <--

// CHECKING THE PECENTAGE
var submit_ans = "";

$( ".submit_ans" ).click(function() {
    var submit_ans = $(this).val();
//toastr.error(submit_ans);
});


    function submitResult()
{
    var exam_id = $('#exam_id').val();
    var ques_name = $('.que_text').text();
var data = {
      'correct_ans': CA,
      'skip_ans': SA,
      'wrong_ans': WA,
      'total_que': $('#TQ').text(),
      'percentage': $(".percentage").text(),
      'time': totaltime,
      'exam_id': exam_id,
      'submit_ans': array4,
      'ques_name': array,
      'ques_id': array1,
      'ques_ans': array3
      
    }

         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
$.ajax({
    type:"POST",
    url:"/submit_exam",
   data: data,
      dataType: "html",
    success:function(response){ 
        //console.log(response.students);
     
     
    }
})

}
let width1=0;
let perc1=0;
function gettingPerc() {
    perc1=(CA/20)*100;
    perc1=Math.round(perc1);
    width1=perc1;
    $(".perc-line").css({
        "width":`${width1}%`,
        "transition": "width 1s linear"
    });
}

let width2=0;
let perc2=0;
function gettingPercTime() {
    perc2=(totaltime/400)*100;
    width2=perc2;
    $(".time-line").css({
        "width":`${width2}%`,
        "transition": "width 1s linear"
    }); 
}
// CHECKING THE PECENTAGE




    $(".result").click(function () {
        
      x2++;
       saveRadioBtnValue();
          array[x] = $(".que_text").text();
            array1[x] = $(".que_id").text();
             array3[x] = $(".que_ans").text();
             
            
    $(".questionbody").remove();
    $(".resultbody").fadeIn();
    saveRadioBtnValue();
    clearInterval(totalSetInterval);
    checkResults();
    gettingPerc();
    gettingPercTime();
    $(".percentage").text(`${perc1}%`);
    $(".skip-ans-given").text(SA);
    $(".wrong-ans-given").text(WA);
    $(".Correct-ans-given").text(CA);
    $(".time").text(totaltime);
   
  var size = array.length;
  var correct=0;
  var skip=0;
  for(i=0;i<=size; i++)
{
    if(array3[i]==array4[i])
    {
        correct++;
    }
    if(array4[i]=="skip")
    {
        skip++;
    }
    
    
}

   // alert(radioBtnChecked);
   //alert(quiz.title[0]+"  "+index[1]+"  "+index[2]+"  "+index[3]+"  "+index[4]+"  "+index[5])
//alert("total quest : "+size + "total wrong : "+(parseInt(size)-parseInt(correct))+"total skipped : "+skip);
 submitResult()
    });
    

// adding the functionalities to buttons ends
    /*$(".icons i").click(function () {
        $(this).siblings().css(
            {
                "display" : "none"
            }, 1000);
            $(this).css({
                "color": "#007bff"
            });
    });*/
    $(".restart").click(function(){
     location.reload();
   });
    $("#close").click(function(){
     window.location.href = '{{ url('/') }}';
   });   
});
</script>
<script>
// $(document).bind("contextmenu",function(e){
//   return false;
//     });
//     document.onkeydown = function(e) {
    
//   if(event.keyCode == 123) {
//      return false;
//   }
//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
//      return false;
//   }
//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
//      return false;
//   }
//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
//      return false;
//   }
//   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
//      return false;
//   }
  
// }

$('#mainButton').click(function(){
    $('#back').addClass('disabled');
    $('#refresh').addClass('disabled');
    $('.nav-link').addClass('disabled');
});
</script>

@endsection