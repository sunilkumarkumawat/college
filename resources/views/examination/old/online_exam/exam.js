    $(document).ready(function () {
        
let quizJSON=[
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        "secondsLeft":20,
        "AnsweredQue":""
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
        document.querySelectorAll('input[type=radio][name=option]').forEach((elem) => {
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
         radioButtons = $("input:radio[name='option']");
         if (questionnumber<randomnumarr.length) {
             indexpre=randomnumarr[questionnumber];
             index =quiz[indexpre]
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
            $("label").eq(0).text(index.choices[0]);
            $("label").eq(1).text(index.choices[1]);
            $("label").eq(2).text(index.choices[2]);
            $("label").eq(3).text(index.choices[3]);
            $("input:radio[name='option']").each(function(i) {
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
    function saveRadioBtnValue() {
        $("input:radio[name='option']").each(function(i){
            if($(this).is(':checked'))
            {
                var idVal = $(this).attr("id");
                radioBtnCheckedVal=$("label[for='"+idVal+"']").text();
                return false;
            }
            else{
                radioBtnCheckedVal=" "
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


   $(".next, .skip").click(function(){
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
});
</script>
<script>
$(document).bind("contextmenu",function(e){
  return false;
    });
    document.onkeydown = function(e) {
    
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
  
}