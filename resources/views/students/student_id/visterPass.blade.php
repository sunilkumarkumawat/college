
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Id Print</title>
    <!--<link rel="stylesheet" href="{{ asset('public/assets/school/css/adminlte.min.css') }}">-->

<link href="https://fonts.googleapis.com/css2?family=Baskervville+SC&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">   
     <style>
     @import url('https://fonts.googleapis.com/css2?family=Baskervville+SC&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        body {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: white;
            font-family: Arial, sans-serif;
        }
        
        .page {
            width: 100%;
            height: 100%;
          
            box-sizing: border-box;
            
            page-break-after: always; /* Ensure page break after each page */
        }
        

       

        
    .pt-serif-regular {
        font-family: "PT Serif", serif;
        font-weight: 400;
        font-style: normal;
    }
    .container{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 300px;
        /*height: 465px;*/
    }
    .bg{
        
        text-align: center;
        color: white;
        width: 300px;
        height: 180px;
        border-radius: 12px 12px 12px 12px;
    }
    .bg_clr_blue{
        background-color: rgb(10, 198, 255);
    }
    .bg_clr_red{
        background-color: rgb(34 201 162);
    }
    .bg_clr_green{
        background-color: rgb(9, 193, 52);
    }
    .text_clr_blue{
        color: rgb(10, 198, 255);
    }
    .text_clr_red{
        color: rgb(255, 57, 57);
    }
    .cl_name{
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0;
        margin-top:5px;
    }
    
    #pic1{
        padding-top: 4px;
        height: 90px;
        width: 100px;
    
        
    }
    .seal{
        width: 150px;
        height: 80px;
    }
    .text{
        text-align: center;
    }
    .identity_card{
        font-family: bold;
        position: absolute;
        font-weight: bold;
        font-size: 39px;
        letter-spacing: 1px;
        top: 92px;
        right: 52px;
    }
    .stu_info{
        font-weight: bold;
      letter-spacing: 1px;
    }
    #profile{
        border: 2px solid #000;
        border-radius: 9%;
        height: 150px;
        width: 130px;
    }
    .front_font{
        font-family: arial;
        font-weight:bold;
    }
    .back_font{
        font-size: 13px;
        font-weight:bold;
    }
    
    .sign{
        text-align: right;   
    }
    
    #information{
        color: #fff;
    }
    #clg-name{
        text-align: center;
        text-transform: uppercase;
    }
    .footer{
        text-align: end;
    }
    .footer_2{
        text-align: start;
        font-size: 20px;
        font-weight: 500;
    }
    .second-table{
        display: flex;
      justify-content: space-between;
    }
    .second-table-td{
       width: 68%;
    }
    .second-table-td-emp{
       width: 61%;
    }
    .stu_value{
        margin-bottom:0;
        margin-top:-3px;
    }
    
    .id-card{
        margin-top: -114px;
    }
 
    </style>    
</head>
@php
$getSetting = Helper::getSetting();
@endphp
<body onLoad="" >

            <div class="" style=''>
            @for($i=1; $i <= $count; $i++)

           <div class="id-card">
            <div class="page">
      
    <div class="container front_font" style="background: white; border-radius:12px; padding:0;height: 463px;">
        <table style="margin-top: -48px;">
            <tr>
               <td class="bg bg_clr_red ">
                    <img id="pic1" src="https://giansagarcollege.rusofterp.in/schoolimage//setting/left_logo/173899359467a6efba6a4e6173890756067a59fa81d2a6image-removebg-preview (1).png" alt=""> 
                    <p class="cl_name">Gian Sagar Medical College &amp; Hospital</p>
                    <p style="font-size:15px; text-align:center; margin-bottom:0; margin-top:0;">Ram Nagar, Rajpura Distt. Patiala, <br>Punjab INDIA</p>
                </td>
            </tr>
            <tr class="text" style="position: relative;">
                <td class="identity_card">Visitor Pass</td>
            </tr>
            <!--<tr class="text">
                <td><img id="profile" src="" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" alt=""></td>
            </tr>
            <tr class="text">
                <td class="stu_info">Ravi</td>
            </tr>
            <tr class="text">
            <td class="stu_info">Pathology  (vister)</td>
            </tr>-->
        </table>
        
    </div>
            
    </div>
    <div class="page" style="height: 466px;">
       
    <div class="container back_font" style="background: white; border-radius:12px;">
        <table style="rotate:180deg; height:100%;">
           
            
            <!--<tr>
                <td class="second-table" >&nbsp;&nbsp;Roll Number <span>:</span></td>
                <td class="second-table-td second-table-td-emp"><p class="" style="margin-bottom:0; margin-top:-4px;">5555</p></td>
            </tr>
           
            <tr>
                <td class="second-table">&nbsp;&nbsp;Blood Group <span>:</span></td>
                <td class="second-table-td second-table-td-emp"><p class="" style="margin-bottom:0; margin-top:-4px;">A+</p></td>
            </tr>
            <tr>
                <td class="second-table">&nbsp;&nbsp;D.O.B. <span>:</span></td>
                <td class="second-table-td second-table-td-emp"><p class="stu_value">12-02-2001</p></td>
            </tr>
          
                    <tr>
                        <td class="second-table">&nbsp;&nbsp;Valid Upto <span>:</span></td>
                        <td class="second-table-td second-table-td-emp"><p class="stu_value">03-02-2025</p></td>
                    </tr>
              
            
            <tr>
                <td class="second-table" >&nbsp;&nbsp;Address <span>:</span></td>
                <td class="second-table-td second-table-td-emp"><p style="margin-bottom:0; margin-top:-5px;">Jaipur</p></td>
            </tr>
            <tr>
                <td class="second-table">&nbsp;&nbsp;Contact <span>:</span></td>
                <td class="second-table-td second-table-td-emp"><p class="stu_value">8003486291</p></td>
            </tr>-->
            <tr>
                <td></td>
                <td colspan="" class="sign" style="padding: 10px;">
                <img class="seal" src="{{ env('IMAGE_SHOW_PATH').'/setting/seal_sign/'.$getSetting['seal_sign'] }}">    
                <br>Issuing Authority</td>
            </tr>
            <tr>
                <td colspan="2" id="information" class="" style="font-size: 10px; font-weight:bold; background-color: black; color:white;">The bearer is required to carry this card daily to the institute</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;If found please return to :</td>
            </tr>
            <tr>
                <td colspan="2" id="clg-name"  class="" style="font-size: 13px; font-weight:bold; color:black;">Gian Sagar Medical College & Hospital</td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 12px; text-align:center;">Principal office : Ram Nagar, Rajpura Distt. Patiala</td>
            </tr>
            <tr>
                <td class="text" colspan="2">Phone : 01762-520000, 520100, 520500</td>
            </tr>
            <tr>
                <td colspan="2" class="text">Email : itsupport@giansagar.net</td>
            </tr>
            
            <tr>
                <td colspan="2" class="text">Website : www.giansagar.net</td>
            </tr>

        </table>
    </div>
          
    </div>
    </div>
   
    
    
    
    

<!--</div>-->
<!--<br><br><br>-->




@endfor
        </div>
        <!-- Ensure the page break is applied correctly -->
        <!--<div class="page-break"></div>-->
        

</body>
</html>


