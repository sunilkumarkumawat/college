
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
    height: 465px;
}
.bg{
    
    text-align: center;
    color: #fff;
    width: 300px;
    height: 180px;
    border-radius: 12px 12px 12px 12px;
}
.bg_clr_blue{
    background-color: rgb(10, 198, 255);
}
.bg_clr_red{
    background-color: rgb(255, 57, 57);
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
  font-weight: bold;
  font-size: 22px;
  letter-spacing: 1px;
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

 
    </style>    
</head>
@php
$getSetting = Helper::getSetting();
@endphp
<body onLoad="" >
    @if(!empty($data))
    @php
    $dataArray = $data->toArray();
    $chunkedArray = array_chunk($dataArray, 8);
    $chunkedArray = array_values($chunkedArray);
    @endphp
 
    @foreach($chunkedArray as $key=>$chunk)


            <div class="" style=''>
                
    @foreach($chunk as $item)

           <div class="id-card">
            <div class="page">
      
      
    <div class="container front_font" style="background: white; border-radius:12px; padding:0">
        <table style="margin-top: -48px;">
            <tr>
                <td class="bg {{ ($item['hostler'] == 'NonHostler') ? 'bg_clr_red' : 'bg_clr_blue'}} {{ ($item['internship'] == 'Internship') ? 'bg_clr_green' : ''}}">
                    <img id="pic1" src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$item['college_left_logo'] ?? '' }}" alt=""> 
                    <p class="cl_name">{{ $item['college_name'] ?? '' }}</p>
                    <p style="font-size:15px; text-align:center; margin-bottom:0; margin-top:0;">Ram Nagar, Rajpura Distt. Patiala, <br>Punjab INDIA</p>
                </td>
            </tr>
            <tr class="text">
                <td class="identity_card">IDENTITY CARD</td>
            </tr>
            <tr class="text">
                <td><img id="profile" src="{{ env('IMAGE_SHOW_PATH') . 'customIdCard/' . $item['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" alt=""></td>
            </tr>
            <tr class="text">
                <td class="stu_info">{{ $item['first_name'] ?? '' }}</td>
            </tr>
            <tr class="text">
            <td class="stu_info">{{ $item['department'] ?? '' }} {{ $item['batch'] ?? '' }} ({{ $item['designation'] ?? '' }})</td>
            </tr>
        </table>
        
    </div>
            
    </div>
    <div class="page">
       
    <div class="container back_font" style="background: white; border-radius:12px;">
        <table style="rotate:180deg; height:100%;">
            @php 
                $designation = str_replace(' ', '', $item['designation']);
            @endphp
            @if(str_replace(' ', '', $item['designation']) == 'Student' || str_replace(' ', '', $item['designation']) == 'Intern')
            <tr>
                <td class="second-table" >&nbsp;&nbsp;Roll Number <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}} "><p class="" style="margin-bottom:0; margin-top:-4px;">{{ $item['roll_no'] ?? '' }}</p></td>
            </tr>
            @elseif($designation == 'PGResident')
                <tr>
                    <td class="second-table">&nbsp;&nbsp;NMC Id <span>:</span></td>
                    <td class="{{ $designation == 'Student' ? 'second-table-td' : 'second-table-td-emp' }}">
                        <p style="margin-bottom:0; margin-top:-4px;">{{ $item['roll_no'] ?? '' }}</p>
                    </td>
                </tr>
            
            @else
            <tr>
                <td class="second-table" >&nbsp;&nbsp;Employee Code <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="" style="margin-bottom:0; margin-top:-4px;">
                    {{ $item['employee_code'] ?? '' }}</p></td>
            </tr>
            @endif
            <tr>
                <td class="second-table">&nbsp;&nbsp;Blood Group <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="" style="margin-bottom:0; margin-top:-4px;">{{ $item['blood_group'] ?? '' }}</p></td>
            </tr>
            <tr>
                <td class="second-table">&nbsp;&nbsp;D.O.B. <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['dob']) ? date('d-m-Y', strtotime($item['dob'])) : '' }}</p></td>
            </tr>
            @if(str_replace(' ', '', $item['designation']) == 'Student' || str_replace(' ', '', $item['designation']) == 'Intern')
                @if(str_replace(' ', '', $item['internship']) == 'Internship')
                    <tr>
                        <td class="second-table">&nbsp;&nbsp;Internship Start Date<span>:</span></td>
                        <td class="{{ (str_replace(' ', '', $item['internship']) == 'Internship') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['internship_start_date']) ? date('d-m-Y', strtotime($item['internship_start_date'])) : '' }}</p></td>
                    </tr>
                    <tr>
                        <td class="second-table">&nbsp;&nbsp;Internship Completion Date <span>:</span></td>
                        <td class="{{ (str_replace(' ', '', $item['internship']) == 'Internship') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['internship_completion_date']) ? date('d-m-Y', strtotime($item['internship_completion_date'])) : '' }}</p></td>
                    </tr>
                    
               
                @else
                    <tr>
                        <td class="second-table">&nbsp;&nbsp;Valid Upto <span>:</span></td>
                        <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['valid_upto']) ? date('d-m-Y', strtotime($item['valid_upto'])) : '' }}</p></td>
                    </tr>
                @endif
                
                 @elseif($designation == 'PGResident')
                    <tr>
                        <td class="second-table">&nbsp;&nbsp;Valid Upto <span>:</span></td>
                        <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['valid_upto']) ? date('d-m-Y', strtotime($item['valid_upto'])) : '' }}</p></td>
                    </tr>
            @else
            <tr>
                <td class="second-table">&nbsp;&nbsp;D.O.J. <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ ($item['date_of_joining']) ? date('d-m-Y', strtotime($item['date_of_joining'])) : '' }}</p></td>
            </tr>
            @endif
            
            <tr>
                <td class="second-table" >&nbsp;&nbsp;Address <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p style="margin-bottom:0; margin-top:-5px;">{{ $item['address'] ?? '' }}</p></td>
            </tr>
            <tr>
                <td class="second-table">&nbsp;&nbsp;Contact <span>:</span></td>
                <td class="{{ (str_replace(' ', '', $item['designation']) == 'Student') ? 'second-table-td' : 'second-table-td-emp'}}"><p class="stu_value">{{ $item['mobile'] ?? '' }}</p></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="" class="sign" style="padding: 10px;">
                <img class="seal" src="{{ env('IMAGE_SHOW_PATH').'/setting/seal_sign/'.$item['college_seal_sign'] ?? '' }}">    
                <br>Issuing Authority</td>
            </tr>
            <tr>
                <td colspan="2" id="information" class="" style="font-size: 10px; font-weight:bold; background-color: black; color:white;">The bearer is required to carry this card daily to the institute</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;If found please return to :</td>
            </tr>
            <tr>
                <td colspan="2" id="clg-name"  class="" style="font-size: 13px; font-weight:bold; color:black;">{{ $item['college_name'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 12px; text-align:center;">Principal office : Ram Nagar, Rajpura Distt. Patiala</td>
            </tr>
            <tr>
                <td class="text" colspan="2">Phone : 01762-520000, 520100, 520500</td>
            </tr>
            <tr>
                <td colspan="2" class="text">Email : {{ $item['college_email'] ?? '' }}</td>
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
@endforeach



        </div>
        <!-- Ensure the page break is applied correctly -->
        <!--<div class="page-break"></div>-->
    @endforeach
    @endif


</body>
</html>


