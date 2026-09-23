@php
$setting=Helper::getsetting();
$getsubject=Helper::getSubject();
//dd($getsubject);
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Student Marksheet</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='main.js'></script>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.outer{
    width: 100%;
    height: 900px;
    border: 1px solid royalblue;
    margin: 10px auto;
    background-color: lemonchiffon;

}

.container{
    width: 95%;
    height: 860px;
    border: 1px solid royalblue;
    margin: 10px auto;
    margin-top: 20px;

}

.header{
    width: 100%;
    height: 180px;
   /* border: 1px solid greenyellow;*/
    margin: 0 auto;
    display: flex;
}
.logo{
    width: 35%;
    height: 180px;
    /*border: 1px solid blueviolet; */
    display: flex;
    align-items: center;
    justify-content: center;
  
}
.schoolname{
    width: 60%;
    height: 180px;
    /*border: 1px solid blueviolet; */
    
}

.schoolname p{
    color: royalblue;
    text-align: center;
}

.serial{
    width: 20%;
    height: 180px;
    color: black;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 30px;
}

.record{
    width: 100%;
    height: 594px;
    border: 1px solid royalblue;
   /* background-color: aqua;*/
         
}
.name{
    width: 100%;
    height: 142px;
    border: 1px solid royalblue;
    /*background-color: aqua;*/
}

.intro{
    width: 100%;
  /* height: 142px;*/
    border: 1px solid royalblue;
    /*background-color: purple;*/
    display: flex;
}

.sname{
    width: 70%;
    height: 100px;
    border: 1px solid royalblue;
   /* background-color: yellowgreen;*/
}

.simage{
    width: 30%;
    height: 100px;
   /* border: 1px solid darkorange;
    background-color: rosybrown;*/
    display: flex;
    justify-content: center;
    align-items: center;
}

.h{
    border-bottom: 1px solid royalblue;
    height: 20px;
}

.number{
    width: 100%;
   /* height: 150px;*/
    display: flex;
}

.subject{
    width: 30%;
    height: 50px;
    border: 1px solid royalblue;
    /*display: flex;*/
    justify-content: center;
    align-items: center;
    text-align: center;
    padding-top: 5px;
   /* background-color: lightgoldenrodyellow;*/

}

.allsub{
    width: 70%;
    height: 50px;
    border: 1px solid royalblue;
    display: flex;
   /* background-color: lightgoldenrodyellow;*/
    
}

.col{
    border-left: 1px solid royalblue;
    border-bottom: 1px solid royalblue;
    width: 20%;
    height: 50px;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding-top: 5px;

}

.collect{
        width: 100%;
        height: 280px;
        display: flex;
    
}

.subname{
    width: 30%;
    height: 280px;
    border: 1px solid royalblue;
   /* background-color: brown;*/
    justify-content: center;
    align-items: center;
   
   

}

.subname p{
    margin-left: 10px;
    color: black;
}

.receive{
    width: 70%;
    height: 280px;
    border: 1px solid royalblue;
}
.result{
   padding-top: 5px;
   display: flex;
   align-items: center;
   height: 120px;
   border: 1px solid blue;
   
}
.result p{
    margin-top: 5px;
    margin-left: 10px;
}



.footer{
    width: 100%;
    height: 150px;
    /*border: 1px solid pink;*/
   /* background-color: salmon;*/
         
}

.date{
    width: 30%;
    height: 100px;
   /* border: 1px solid blueviolet;*/
    float: left; 
    padding: 20px;
  
}

.sign{
    width: 30%;
    height: 100px;
   /* border: 1px solid blueviolet;*/
    float: right;
    align-items: center;
    text-align: center;
    padding-top: 20px;
    
    
}
</style>
<body>
    <div class="outer">
        <div class="container">
            <div class="header">
                <div class="logo">
                    <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$setting['left_logo'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'" width="60%" height="150px">
                </div>
                <div class="schoolname">
                    <p style="font-size: 40px;">{{$setting->name ?? ''}}</p>
                   
                    <p style="font-size: 25px;">अंक विवरण Marks Statement</p>
                    <p style="font-size: 25px;">वार्षिक परीक्षा, 2022</p>
                    <p style="font-size: 25px;">Annual Exam, 2022</p>
                </div>
                <div class="serial"  style="color: lightcoral;">123456</div>
            </div>
            <div class="record">
                <div class="name">
                    <div class="intro">
                        <div class="sname">
                            <div class="h">
                                <p style="color: blue;">नाम Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Session::get('first_name')}} {{Session::get('last_name')}}</p>
                            </div>
                            <div class="h">
                                <p style="color: blue;">माता का नाम Mother's Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Session::get('mother_name')}}    </p>
                            </div>
                            <div class="h">
                                <p style="color: blue;"> पिता का नाम Father's Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Session::get('father_name')}} </p>
                            </div>
                            <div class="h">
                                <p style="color: blue;">रोल कोड Roll Code <span style="padding-left: 150px;"> रोल नंबर Roll Number </span>
                                </p>
                            </div>
                        </div>
                        <div class="simage">
                            <img src="{{ env('IMAGE_SHOW_PATH').'/user/'.$data->photo ?? '' }}" width="30%" height="90px">
                        </div>
                    </div>
                    <div class="h">
                        <p style="color: blue;">पंजीकरण सं. Registration No. <span style="padding-left: 150px;"> संकाय Faculty</span>
                        </p>
                    </div>
                    <div>
                        <p style="color: blue;"> विद्यालय का नाम School Name &nbsp;&nbsp; :  &nbsp;&nbsp; {{$setting->name ?? ''}} </p>
                    </div>
                </div>

                <div class="number">
                    <div class="subject">
                        <p style="color: blue;">विषय का नाम</p>
                        <p style="color: blue;">Subject Name</p>
                    </div>
                    <div class="allsub">
                        <div class="col">
                            <p>कुल अंक</p>
                            <p>F. Marks</p>
                        </div>
                        <div class="col">
                            <p>उतीर्ण अंक</p>
                            <p>P. Marks</p>
                        </div>
                        <div class="col" >
                            <p>3</p>
                            <hr>
                            
                            
                        </div>
                        <div class="col">
                            <p>4</p>
                        </div>
                        <div class="col">
                            <p>5</p>
                        </div>
                        <div class="col">
                            <p>6</p>
                        </div>
                        <div class="col">
                            <p>7</p>
                        </div>
                        
                        
                        
                    </div>
                </div>

                <div class="collect">
                    <div class="subname">
                        <p style="color: blue;">1. अनिवार्य &nbsp;&nbsp;  COMPULSORY</p>
                        <p>{{ $getsubject->pluck('name')->first() ?? '' }}</p>
                        <p>HINDI</p>
                        <p>MATHS</p><br><br>
                        <p style="color: blue;">2. ऐच्छिक &nbsp;&nbsp; OPTIONAL</p>
                        <p>SCIENCE</p>
                        <p>SO.SCIENCE</p>
                        <p>ACCOUNTS</p><br><br>
                        <p style="color: blue;">3. अतिरिक्त &nbsp;&nbsp; Additional</p>
                    </div>
                    <div class="receive">4</div>
                </div>
                    <div class="result">
                        <p style="color: blue;">प्राप्तांक  AGGREGATE<br><br>
                        परिणाम   RESULT</p>
                       <p> <span style="padding-left: 400px;" >TOTAL</span><p>
                </div>
            </div>

            <div class="footer">
                <div class="date">

                    <p style="color: blue;">DATED 18/3/2023</p><BR>
                    <p style="color: blue;">JAIPUR</p>
                </div>
                <div class="sign">
                    <p style="font-family: Brush Script Mt; font-size: 20px;">Subhash</p>
                    <p style="color: blue;">परीक्षा नियंत्रक</p>
                    <p style="color: blue;">Controller of Examination</p>
                </div>

            </div>
        </div>


    </div>

</body>

</html>