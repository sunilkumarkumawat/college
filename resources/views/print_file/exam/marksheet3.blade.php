@php
$setting=Helper::getsetting();
//dd($setting);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>ReportCard 2</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet"> 
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container-fluid{
    width: 100%;
    height: 1050px;
   /* border: 1px solid green;*/
    background-color: white;
}

.contant{
    width: 80%;
    height: 1050px;
    margin: 0 auto;
    border: 1px solid black;
    background-color: bisque;

}
.header{
    height: 200px;
    width:100%;
    display: flex;
   /* border: 1px solid greenyellow;*/
    margin: 0 auto;

    
}

.rolnumber{
    width: 25%;
    height: 150px;
   /* border: 1px solid green;*/
   /* background-color: bisque;*/
    display: flex;
    justify-content: center;
    align-items: center;
}
.sname{
    width: 45%;
    height: 200px;
   /*border: 1px solid green;*/
   /* background-color: hotpink;*/
    text-align: center;
    color: black;

}
.simage{
    width: 30%;
    height: 150px;
  /* border: 1px solid green;*/
   /* background-color: aqua;*/
   
}
#cool{
    fill:none;
  }
  textPath{
    font-size:35px;
    font-family:  cursive;
  }

  .info{
    width: 100%;
    height: 65px;
    /*border: 1px solid green;*/
    display: flex;
    text-align: center;
    background-color: rgb(65, 65, 151);
    color: whitesmoke;
  }
  .info1{
    width: 10%;
    height: 65px;
    /*border: 1px solid green; */
  }
  .info2{
    width: 8%;
    height: 65px;
    /*border: 1px solid green;*/
  }
  .info3{
    width: 8%;
    height: 65px;
   /* border: 1px solid green;*/
  }
  .info4{
    width: 14%;
    height: 65px;
   /* border: 1px solid green;*/
    
  }
  .info5{
    width: 10%;
    height: 65px;
   /* border: 1px solid green;*/

  }
  .info6{
    width: 30%;
    height: 65px;
   /* border: 1px solid green;*/

  }
  .info7{
    width: 30%;
    height: 65px;
   /* border: 1px solid green;*/
  }
  .data{
    width: 100%;
    height: 40px;
    border: 1px solid black;
    color: whitesmoke;
    display: flex;
    text-align: center;
    color: black;
  }
  .data1{
    width: 10%;
    height: 40px;
   /* border: 1px solid green; */
  }
  .data2{
    width: 8%;
    height: 40px;
   /* border: 1px solid green;*/
  }
  .data3{
    width: 8%;
    height: 40px;
    /*border: 1px solid green;*/
  }
  .data4{
    width: 14%;
    height: 40px;
   /* border: 1px solid green;*/
    
  }
  .data5{
    width: 10%;
    height: 40px;
   /* border: 1px solid green;*/

  }
  .data6{
    width: 30%;
    height: 40px;
    /*border: 1px solid green;*/

  }
  .data7{
    width: 30%;
    height: 40px;
   /* border: 1px solid green;*/
  }

  .colors{
    color: black;
    margin-left: 15px;
    float: left;
  }

  .school{
    font-size: 24px;
    margin-left: 15px;
  }

  .hcenter{
     background: rgb(87, 87, 177);
     color: bisque; width: 8%;
     text-align: center;

}

.detail{
    width: 100%;
    height: 40px;
   /* border: 1px solid red;*/
}

.scolor{
    background-color: bisque;
    color: black;

}
.scolor2{
    background-color: bisque;
    color: black;

}

.color{
    background-color: rgb(87, 87, 177);
    color: bisque;
    text-align: center;
}

.color1{
    background-color: bisque;
    text-align: center;
    color: black;
}
.color2{
    background-color: bisque;
    text-align: center;
    color: black;
}

.detail h6{
    text-align: center;
    color: rgb(82, 82, 180);


}

table, th, td{
   padding-left: 5px;
   color: rgb(78, 78, 165);
  }

  .result{
    padding-top: 5px;
    display: flex;
    align-items: center;
    height: 120px;
   border: 1px solid black;
    
 }
 .result p{
     margin-top: 5px;
     margin-left: 10px;
 }
 
 
 
 .footer{
     width: 100%;
     height: 80px;
     /*border: 1px solid pink;*/
    /* background-color: salmon;*/
          
 }
 
 .date{
     width: 30%;
     height: 80px;
    /* border: 1px solid blueviolet;*/
     float: left; 
     padding: 20px;
   
 }
 
 .sign{
     width: 30%;
     height: 80px;
    /* border: 1px solid blueviolet;*/
     float: right;
     align-items: center;
     text-align: center;
     padding-top: 20px;
     
     
 }

</style>
<body>
    <div class="container-fluid">
        <div class="contant">
         <div class="header">
            <div class="rolnumber">
                <p>क्रमांक (S.No.)<br>
                123456789</p>
            </div>
            <div class="sname"> 
            
                <svg width="580" xmlns="http://www.w3.org/2000/svg">
                  <title>cool</title>
                 <path id="cool" d="M73.2,148.6c4-6.1,65.5-96.8,178.6-95.6c111.3,1.2,170.8,90.3,175.1,97" />
                   <text>
                      <textPath xlink:href="#cool">
                       माध्यमिक शिक्षा बोर्ड ,राजस्थान
                      </textPath>
                 </text>
                </svg>
                <h5>High School Examination,2023<h5>
            </div>
            <div class="simage">
               <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$setting['left_logo'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'" width="50%" height="100px">
            </div>

        </div>
        <div class="info">
            <div class="info1">नामांक<br>
                Roll No.
                <hr>
            </div>
            <div class="info2">केन्द्र<br>
                Center
                <hr>
            </div>
            <div class="info3">जिला<br>
                District
                <hr>
            </div>
            <div class="info4">नियमित/स्वयंपाठी<br>
                Regular/Private
                <hr>
            </div>
            <div class="info5">श्रेणी<br>
                Category
                <hr>
            </div>
            <div class="info6">वर्ग का नाम<br>
                Group Name
                <hr>
            </div>
            <div class="info7">सन्दर्भ संख्या<br>
                Ref.No.
                <hr>
            </div>

        </div>
        <div class="data">
            <div class="data1">2916218
            </div>
            <div class="data2">07008
            </div>
            <div class="data3">JAIPUR
            </div>
            <div class="data4">REGULAR
            </div>
            <div class="data5">1
            </div>
            <div class="data6">HUMANITIES 
            </div>
            <div class="data7">113448
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <span class="colors">विद्यार्थी का नाम</span><br>
                <span class="colors">Student's Name</span><br>
                <span class="colors">माता का नाम</span><br>
                <span class="colors">Mother's Name</span><br>
                <span class="colors">पिता का नाम</span><br>
                <span class="colors">Father's Name</span><br>
                
            </div>
            <div class="col-md-4">
                <p style="color: black;">RAKESH KUMAWAT</p><br>
                <p style="color: black;">SANTOSHI DEVI</p><br>
                <p style="color: black;">CHAND RATAN SONI</p><br>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="col-md-12 school">
            <span class="colors">विद्यालय का नाम</span><br>
            {{$setting->name ?? ''}}</div>


            <table  style="width:100%";>
                <tr>
                  <th rowspan="2"style="background-color: rgb(87, 87, 177); color: white;">Subject Name</th>
                  <th colspan="5" class="color">Marks Obtained</th>
                  
                </tr>
                 
              
                <tr>
                  <td class="hcenter">TH</td>
                  <td class="hcenter">SS</td>
                  <td class="hcenter">TH+SS</td>
                  <td class="hcenter">PR</td>
                  <td class="hcenter">Total</td>
                
                </tr>
               
                <tr>
                  <td class="scolor">HINDI</td>
                  <td  class="color1">37</td>
                  <td  class="color1">20</td>
                  <td  class="color1">57</td>
                  <td  class="color1"></td>
                  <td  class="color1">57</td>
                </tr>
                <tr>
                  <td class="scolor2">ENGLISH</td>
                  <td class="color2">30</td>
                  <td class="color2">20</td>
                  <td class="color2">50</td>
                  <td class="color2"></td>
                  <td class="color2">50</td>
                </tr>
                <tr>
                  <td  class="scolor">SCIENCE</td>
                  <td  class="color1">45</td>
                  <td  class="color1">20</td>
                  <td  class="color1">65</td>
                  <td  class="color1"></td>
                  <td  class="color1">65</td>
                </tr>
                <tr>
                  <td class="scolor2">SOC.SCIENCE</td>
                  <td class="color2">47</td>
                  <td class="color2">20</td>
                  <td class="color2">67</td>
                  <td class="color2"></td>
                  <td class="color2">67</td>
                </tr>
                <tr>
                  <td  class="scolor">MATHEMATICS</td>
                  <td  class="color1">38</td>
                  <td  class="color1">20</td>
                  <td  class="color1">58</td>
                  <td  class="color1"></td>
                  <td  class="color1">58</td>
                </tr>
                <tr>
                  <td class="scolor2">SANSKRIT</td>
                  <td class="color2">54</td>
                  <td class="color2">20</td>
                  <td class="color2">74</td>
                  <td class="color2"></td>
                  <td class="color2">74</td>
                </tr>
                <tr>
                  <td  class="scolor"><b>Total Marks</b></td>
                  <td  class="color1"></td>
                  <td  class="color1"></td>
                  <td  class="color1"></td>
                  <td  class="color1"></td>
                  <td  class="color1"> <b> 371</b></td>
                </tr>
                
                </table>
             
                <div class="result">
                    <p>प्राप्तांक  AGGREGATE<br><br>
                    परिणाम   RESULT</p>
                  
            </div>
            <div class="footer">
                <div class="date">

                    <p>DATED 05/04/2023</p><BR>
                    <p>JAIPUR</p>
                </div>
                <div class="sign">
                    <p style="font-family: Brush Script Mt; font-size: 20px;">Subhash</p>
                    <p>परीक्षा नियंत्रक</p>
                    <p>Controller of Examination</p>
                </div>

            </div>
       
    </div>
    </div>
      
    </html>
    
</body>
</html>