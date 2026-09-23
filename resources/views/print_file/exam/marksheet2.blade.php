@php
$setting=Helper::getsetting();
//dd($setting);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Report Card</title>
    <style>
        table, th, td {
  border:1px solid black;
  border-collapse: collapse;
}
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
   

}
.container-fluid{
    width: 100%;
    height: 700px;
   /* border: 1px solid green;*/
    background-color: bisque;
}
   

.header{
    width: 100%;
    height: 140px;
   /* border: 1px solid green;*/
    background-color: rgb(89, 89, 182);
}

.marks{
    border: 1px solid black;
}

.header h1, h2, h4{
    text-align: center;
    color: white;
   
}

.hcenter{
    background: rgb(87, 87, 177);
     color: white; width: 8%;
     text-align: center;

}

.detail{
    width: 100%;
    height: 40px;
   /* border: 1px solid red;*/
}

.scolor{
    background-color: white;

}
.scolor2{
    background-color: bisque;

}

.color{
    background-color: rgb(87, 87, 177);
    color: white;
    text-align: center;
}

.color1{
    background-color: white;
    text-align: center;
}
.color2{
    background-color: bisque;
    text-align: center;
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
    width: 100%;
    height: 60px;
   /* border: 1px solid red;*/
}

.result h4{
    text-align: center;
    color: rgb(82, 82, 180);
    margin-top: 20px;

}
  .devision{
    width: 100%;
    height: 40px;
   /* border: 1px solid red;*/
    background-color: rgb(87, 87, 177);
}

.devision h4{
    text-align: center;
    color: white;

}

    </style>
 
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <h1>Rajasthan Board  of Secondry Education,Ajmer</h1>
            <h2>Result: Secondry Examination,2023</h2>
            <h4>Brought to you by National Informatics Center</h4>
        </div>

        <div class="detail">
<h6><u> Detailed Mark sheet </u></h6>
        </div>
        <table  style="width:100%">
            <tr>
              <td style="width:30%; background: white;">Roll Number</td>
              <td style="background-color:  white;">123456987</td>
            </tr>
            <tr>
              <td style="width:30%">Condidate Name</td>
              <td >Subhash Kumar</td>
            </tr>
            <tr>
              <td style="width:30%; background: white;">Father's Name</td>
              <td style="background-color:  white;">Father Name</td>
            </tr>
            <tr>
              <td style="width:30%">Mother's Name</td>
              <td>Mother Name</td>
            </tr>
           <!-- <tr>
              <td style="width:30%; background: white;">School/Center's Nmae</td>
              <td style="background-color:  white;">Deepak School</td>
            </tr>-->
        
            
            </table><br>

  <div class="marks">
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
              <h4>Percentage: 60.83%</h4>
                      </div>
            <div class="devision">
              <h4>Result: First Division</h4>
                      </div>
                    </div>
    </div>
</body>
</html>