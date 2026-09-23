<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Id Print</title>
    <!--<link rel="stylesheet" href="{{ asset('public/assets/school/css/adminlte.min.css') }}">-->
</head>
@php
$getSetting = Helper::getSetting();
@endphp

<body style="background-color: #ebe5e5;">
    <table>
        <tr>
            <td class="p-1" >
      
    <div class="container front_font" style="border: hidden;background: white; border-radius:12px; padding:0">
        <table style="margin-top: -33px;">
            <tr>
                <td class="bg">
                    <img id="pic1" src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] ?? '' }}" alt=""> 
                    <p class="cl_name">{{ $getSetting->name ?? '' }}</p>
                    <p style="font-size:15px; text-align:center; margin-bottom:0;">Ram Nagar, Rajpura Distt. Patiyala<br>Punjab INDIA</p>
                </td>
            </tr>
            <tr class="text">
                <td class="identity_card">IDENTITY CARD</td>
            </tr>
            <tr class="text">
                <td><img id="profile" src="{{ env('IMAGE_SHOW_PATH') . 'customIdCard/' . $data->image }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" alt=""></td>
            </tr>
            <tr class="text">
                <td class="stu_info">{{ $data->first_name ?? '' }}</td>
            </tr>
            <tr class="text">
            <td class="stu_info">{{ $data->department ?? '' }} 2023 ({{ $data->designation ?? '' }})</td>
            </tr>
        </table>
    </div>
            </td>
            <td class="p-1" >
    <div class="container back_font" style="border: hidden;background: white; border-radius:12px;">
        <table>
            <tr>
                <td class="second-table" style="width: 35%;">Roll Number</td>
                <!-- <td>:</td> -->
                <td>: {{ $data->roll_no ?? '' }}</td>
            </tr>
            <tr>
                <td class="second-table">Blood Group</td>
                <!-- <td>:</td> -->
                <td>: {{ $data->blood_group ?? '' }}</td>
            </tr>
            <tr>
                <td class="second-table">D.O.B</td>
                <!-- <td>:</td> -->
                <td> : {{ ($data->dob) ? date('d-m-Y', strtotime($data->dob)) : '' }}</td>
            </tr>
            <tr>
                <td>Valid Upto</td>
                <!-- <td>:</td> -->
                <td> : {{ ($data->valid_upto) ? $data->valid_upto : '' }}</td>
            </tr>
            <tr>
                <td class="second-table" style="display: flex;">Address</td>
                <!-- <td>:</td> -->
                <td>
                    : {{ $data->address ?? '' }}
                </td>
            </tr>
            <tr>
                <td class="second-table">Contact</td>
                <!-- <td>:</td> -->
                <td> : {{ $data->mobile ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="" class="sign" style="padding: 10px;">
                <img class="seal" src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] ?? '' }}">    
                <br>Issuing Authority</td>
            </tr>
            <tr>
                <td colspan="2" id="information" style="font-size: 10px; font-weight:600;">The bearer is required to carry this card daily to the institute</td>
            </tr>
            <tr>
                <td colspan="2">If found please return to :</td>
            </tr>
            <tr>
                <td colspan="2" id="clg-name" style="font-size: 13px;">GAIN SAGAR MEDICAL COLLEGE & HOSPITAL</td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 12px; text-align:center;">Principal office(Medical) : Ram Nagar, Rajpura Distt.</td>
            </tr>
            <tr>
                <td class="text" colspan="2">Phone : 01762-520000, 520100, 520500</td>
                <!-- <td class="footer_2">01762-52000, 520100, 520500</td> -->
            </tr>
            <tr>
                <td colspan="2" class="text">Email : Principalmedical@giansagar.net</td>
            </tr>
            
            <tr>
                <td colspan="2" class="text">Website : www.giansagar.net</td>
            </tr>
            <!-- <tr>
                <td class="footer">Principal office(Medical) :</td>
                <td class="footer_2">Ram Nagar, Rajpura Distt.</td>
            </tr>
            <tr>
                <td class="footer">Phone : </td>
                <td class="footer_2">01762-52000,520100,520500</td>
            </tr>
            <tr>
                <td class="footer">E-Mail : </td>
                <td class="footer_2">principalmedical@giansagar.net</td>
            </tr>
            <tr>
                <td class="footer">Website : </td>
                <td class="footer_2">www.giansagar.net</td>
            </tr> -->

        </table>
    </div>
            </td>
        </tr>
    </table>
<style>
body{
  
    font-family: Georgia, Arial, sans-serif;
    
}
.container{
    border: 1px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 300px;
    height: 465px;
    border: 2px solid #000;
}
.bg{
    background-color: rgb(10, 198, 255);
    text-align: center;
    color: #fff;
    width: 300px;
    height: 200px;
    border-radius: 12px 12px 12px 12px;
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
    width: 50px;
    height: 50px;
}
.text{
    text-align: center;
}
.identity_card{
    font-family: initial;
  font-weight: 600;
  font-size: 20px;
  letter-spacing: 1px;
}
.stu_info{
    font-weight: 600;
  letter-spacing: 1px;
}
#profile{
    border: 1px solid #000;
    border-radius: 9%;
    height: 150px;
    width: 130px;
}
.front_font{
    font-family: arial;
}
.back_font{
    font-size: 13px;
    font-weight:500;
}

.sign{
    text-align: right;   
}

#information{
    background-color:rgb(10, 198, 255);
    color: #fff;
}
#clg-name{
    color: rgb(10, 198, 255);
    text-align: center;
}
.footer{
    text-align: end;
}
.footer_2{
    text-align: start;
    font-size: 20px;
    font-weight: 500;
}

 
</style>
</body>

</html>