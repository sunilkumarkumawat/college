@php
$getSetting=Helper::getSetting();
//dd($certificate_data);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='Style.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
text-align: center;
  padding: 8px;
}
.report{
    text-align: left;
}
.bg{
        background-color: #b2b2ff;
}

}
</style>
</head>

<body>
    
    
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-md-3">
                <img  <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] }}" style="border-radius: 50%;
   width: 40%;
    height: 100px;">
            </div>
            <div class="col-md-6 text-center">
               <h2>{{$getSetting['name'] ?? ''}}</h2>
               <p><b>Address  :</b> {{$getSetting['address'] ?? ''}}</p>
               <p><b>Phone No :</b> {{$getSetting['mobile'] ?? ''}}  <b>Email :</b> {{$getSetting['gmail'] ?? ''}}</p>
            </div>
            <div class="col-md-3">
                <!-- <img src="{{ env('IMAGE_SHOW_PATH').'/setting/right_logo/'.$getSetting['right_logo'] }}" style="border-radius: 50%;
    width: 40%;
    height: 100px;
    margin-left: 37%;">-->
            </div>
            <div class="col-md-12 text-center text-primary">
                <h5><b><u>Report Card-Final ( {{$data->from_year ?? ''}}-{{$data->to_year ?? ''}} )</u></b></h5>
            </div>
            
            <div class="col-md-4">
               <p><b>Student Name : {{$data->first_name ?? ''}}{{$data->last_name ?? ''}}</b><br>
               <b>Class : {{$data->class_name ?? ''}}</b><br>
               <b>Mobile Number: {{$data->mobile ?? ''}} </b><br>
               <b>Date of Birth: {{date('d-m-Y', strtotime($data['dob'])) ?? '' }}</b></p>
                  

            </div>
            <div class="col-md-4">
          
            </div>
            <div class="col-md-4">
               <!--  <p><b>Student Name : Abhishek Kumar Chaudhary</b><br>
               <b>Class : UKG-A</b><br>
               <b>Mobile Number: 9792278278 </b><br>
               <b>Date of Birth: 02-AUg-2005 </b></p>-->
            </div>
            
            
            
            
            
            
            
            
            
            
            
        </div><br>
    </div>
    
<table>
  <tr>
    <th class="report bg">Scholastic Area </th>
    <th colspan="5" class="bg">Contact</th>
    <th colspan="5"  class="bg">Country</th>
     <th colspan="2"  class="bg">ok</th>
  </tr>
  <tr>
    <th class="report">Subjects</th>
    <td>FA1<br> 30</td>
    <td>FA2<br> 30</td>
    <td>SA1<br> 40</td>
    <td>Total<br> 100</td>
    <td>Grade</td>
    <td>Fa1<br> 30</td>
    <td>FA2<br> 30</td>
    <td>SA1<br> 40</td>
    <td>Total<br> 100</td>
    <td>Grade</td>
    <td>Total<br> 100</td>
    <td>Grade</td>

  </tr>
  <tr>
    <th class="report">English</th>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A1</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A1</td>
    <td>18</td>
    <td>A1</td>

  </tr>
    <tr>
    <th class="report">Hindi</th>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>A2</td>

  </tr>
  <tr>
    <th class="report">Mathematics</th>
   <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>A2</td>

  </tr>
  <tr>
    <th class="report">Science </th>
   <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>A2</td>
    <td>18</td>
    <td>A2</td>

  </tr>
  <tr>
    <th class="report">Social Science</th>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>B2</td>

  </tr>
  <tr>
    <th class="report">GK</th>
     <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>B2</td>
  </tr>
  <tr>
    <th class="report">Saskrit</th>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B2</td>
    <td>18</td>
    <td>B2</td>

  </tr>
  <tr>
    <th class="report">Computer </th>
     <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B3</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>18</td>
    <td>B3</td>
    <td>18</td>
    <td>B3</td>

  </tr>
  <tr>
    <th class="report">Total Marks Obtained  </th>
    <td></td>
    <td></td>
    <td></td>
    <td>18</td>
    <td>B3</td>
    <td></td>
    <td></td>
    <td></td>
    <td>18</td>
    <td>B3</td>
    <td>18</td>
    <td>B3</td>
  </tr>
  <tr>
    <th class="report">Percentage  </th>
    <td></td>
    <td></td>
    <td></td>
    <td>32%</td>
    <td>B1</td>
    <td></td>
    <td></td>
    <td></td>
    <td>32%</td>
    <td>B1</td>
    <td>32%</td>
    <td>B2</td>

  </tr>
 
</table><br><br>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
    <table>
  <tr>
    <th class="bg"> Co-Scholastic Area </th>
    <th class="bg">Term1</th>
    <th class="bg">Term2</th>
  </tr>
  <tr>
    <td>Game</td>
    <td>A</td>
    <td>A</td>
  </tr>

  <tr>
    <td>Punctuality</td>
    <td>B</td>
    <td>B</td>
  </tr>
 
 
  
</table>
</div>

<div class="col-md-6">
       <table>
  <tr>
    <th  class="bg">Co-Scholastic Area </th>
    <th class="bg">Term1</th>
    <th class="bg">Term2</th>
  </tr>
  <tr>
    <td>Games</td>
    <td>A</td>
    <td>A</td>
  </tr>

  <tr>
    <td>Punctuality</td>
    <td>B</td>
    <td>B</td>
  </tr>
 
 
  
</table> <br>
</div>
<div class="col-md-12">
    <table>
    <tr>
        <th class="report">Class Teacher Remark </th>
       
    </tr>
    <tr>
        <th class="report">Remark wil come here</th>
       
    </tr>
    <tr>
        <th class="report">Result </th>
       
    </tr>
    <tr>
        <th class="report">Result will come here </th>
       
    </tr>
</table> <br>
</div>

<div class="col-md-4">
    <table>
        <tr>
            <th colspan="2"class="bg">Scholastic Grade Structure</th>
             </tr>
             
            <td><b>Mark Range</b></td>
            <td><b>Range</b></td>
        <tr>
       
            <td>91-100</td>
            <td> A1</td>
           
        </tr>
        <tr>
            <td>81-90</td>
            <td> A2</td>
        </tr>
        <tr>
            <td> 71-80</td>
            <td> B1</td>
        </tr>
        <tr>
            <td>61-70</td>
            <td> B2</td>
        </tr>
        <tr>
            <td>51-60</td>
            <td>C1</td>
        </tr>
        <tr>
            <td>41-50</td>
            <td> C2</td>
        </tr>
        <tr>
            <td>31-40</td>
            <td> D1</td>
        </tr>
        <tr>
            <td>0-30</td>
            <td> D2</td>
        </tr>
        
    </table>
</div>
<div class="col-md-4">
    <table>
        <tr>
            <th colspan="2" class="bg"> Co-Scholastic Grade Structure</th>
            
        </tr>
         
            <td><b>Mark Range</b></td>
            <td><b>Range</b></td>
          
          <tr>
       
            <td>91-100</td>
            <td> A1</td>
           
        </tr>
        <tr>
            <td>81-90</td>
            <td> A2</td>
        </tr>
        <tr>
            <td> 71-80</td>
            <td> B1</td>
        </tr>
        <tr>
            <td>61-70</td>
            <td> B2</td>
        </tr>
        <tr>
            <td>51-60</td>
            <td>C1</td>
        </tr>
        <tr>
            <td>41-50</td>
            <td> C2</td>
        </tr>
        <tr>
            <td>31-40</td>
            <td> D1</td>
        </tr>
        <tr>
            <td>0-30</td>
            <td> D2</td>
        </tr>
    </table>
</div>

<div class="col-md-4">
    <img src="{{ env('IMAGE_SHOW_PATH').'/setting/seal_sign/'.$getSetting['seal_sign'] }}"     width="30%" height="104px" style="margin-top: 40% !important;
    margin-left: 46%;">
    <p style="margin-left: 46%;width: 35%;border-top: 2px solid black;"><b>Principal Signature</b></p>
</div>
        
    </div><br><br>
</div>





</body>
</html>

