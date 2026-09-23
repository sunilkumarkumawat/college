@php
$getSetting=Helper::getSetting();
$getSession=Helper::getSession();
@endphp
<head>
<title>Mark Sheet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
    .style12 {
        font-size: 24px;
        font-weight: bold;
    }
    
    .reg_td{
        position: absolute;
        right:0;
        display: flex;
          border: none;
          white-space: nowrap;
          margin-top: 10px;
          margin-right: 10px;
    }
    
    p{
        margin-bottom:0px;
    }
    
    .style13 {
        font-size: 18px
    }
       .style4 {
            font-size: 18px
        }
        
        .style5 {
            font-size: 80px;
            font-weight: bold;
            color : #c70707;
        }
        
        .style9 {
            font-size: 16px
        }
        
        .style10 {
            font-size: 24px;
            padding: 0px 15px 0px;
            letter-spacing:1px;
            line-height:40px;
        }
        
        .style11 {
            font-size: 36px;
            font-weight: bold;
        }
        .text-center-padding{
            text-align:center;
            padding:5px;
            text-transform:uppercase
        }
</style>

<script>
    
    $( document ).ready(function() {
  var length = (75/$('.same_width').length)*2;
  var length1 = (75/$('.same_width0').length)*2;
  
  
 
  $('.same_width').css('width',length+'%')
  $('.same_width0').css('width',length1+'%')
 
 if($('.same_width').length == 0) 
  {
      $('.other_row1').hide();
  }
 if($('.same_width0').length == 0) 
  {
      $('.other_row').hide();
  }
});
</script>
    <div class="container">
    <table width="100%" border="2" cellspacing="0" cellpadding="0" style="background-image: url('{{ env('IMAGE_SHOW_PATH').'/setting/watermark_image/'.$getSetting->watermark_image }}');
            background-repeat: no-repeat;
            background-position: center;background-size: 700px 700px;">
        <tr>
            <td colspan="4">
                   <table width="100%" cellspacing="0" cellpadding="0" border="2" >
                        <tr style="position: relative;">
                            <td width="20%" style="text-align:center;padding:10px; border: 0px solid white;">
                                <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'"   width = "100%" >
                                
                                </td>
                            <td width="80%" style="border: 0px solid white;">
                                <div>
                                    <div align="center">
                                        <p class="style5">{{$getSetting['name'] ?? ''}}</p>
                                      
                                        <div><span class="style4"><strong>Address</strong> - {{$getSetting['address'] ?? ''}},{{$getSetting['pincode'] ?? ''}}</span></div>
                                        <div><span class="style4"><strong>Email Id</strong> - {{$getSetting['gmail'] ?? ''}}</span></div>
                                      
                                      <!--  <div class="style4"><strong>Website - </strong></div>
                                        <div class="style4"><strong>Mobile App - </strong> </div>-->
                                        <p>&nbsp;</p>
                                    </div>
                                </div>
                            </td>
                            <!--<td class="reg_td">
                                 <div><span class="style4"><strong>Reg. No. : </strong> {{$getSetting['regNo'] ?? ''}}</span></div>
                            </td>-->
                        </tr>
                    </table>
            </td>
        </tr>
        <tr>
            <td width="21% "style="padding: 0px 12px 11px;">
                <p>Admission No.</p>
                <p>Name</p>
                <p>Father's Name</p>
                <p>Mother's Name</p>
            </td>
            <td width="29% " style="padding: 0px 10px 13px;">
                <p>{{$data->admissionNo ?? '' }}</p>
                <p>{{$data->first_name ?? '' }}</p>
               
                <p>{{$data->father_name ?? '' }}</p>
              
                <p>{{$data->mother_name ?? '' }}</p>
                <p>
                </p>
            </td>
            <td width="26%" style="padding: 0px 11px 16px;">
                <p> Exam Roll No.</p>
                <p>Class:</p>
                <p>Date Of Birth:</p>
                <p>Gender: </p>
            </td>
            <td width="24%" style="padding: 0px 12px 12px;">
                <p>{{$data->exam_roll_no ?? '' }}</p>
                <p>{{$data->class_name ?? '' }} </p>
                <p>{{date('d-m-Y', strtotime($data->dob)) ?? '' }}</p>
                <p>{{$data->gender_id == 1 ? 'Male' : 'Female' }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="4 " style="text-align: center;">
                <div align="center " class="style13 ">
                    <p>&nbsp;</p>
                    
                    @php
                    
                    $session  = DB::table('sessions')->where('id',Session::get('session_id'))->whereNull('deleted_at')->first();
                   
                    @endphp
                    <p><strong>Progress Report Card (Session {{$session->from_year ?? '' }}{{"-"}}{{$session->to_year ?? ''}}) </strong></p>
                    <p>&nbsp;</p>
                </div>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td style="padding: 9px;">
                <div align="center " class="style13 "><strong>Subjects</strong></div>
            </td>
            <td>
                <div align="center "><span class="style13 "><strong>Maximum Marks </strong></span></div>
            </td>
            <td>
                <div align="center "><strong>Marks</strong> <span class="style13 "><strong>Obtained</strong> </span></div>
            </td>
            <td>
                <div align="center "><strong>Subject Dictation </strong></div>
            </td>
        </tr>
   
     @if(!empty($subjects))
     
     @php
     $total_marks =0;
     $total_obtained =0;
     $fail = false;
     
     @endphp
     @foreach($subjects as $item)
     @php
        $MaximumMarks = DB::table('fill_min_max_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('class_type_id',$data->class_type_id ?? '')
                                     ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
                                     
        $total_marks +=  $MaximumMarks->exam_maximum_marks ?? 0;                          
                                     
        $old_marks = DB::table('fill_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('admission_id',$data->id)
                                      ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
        $total_obtained +=  $old_marks->student_marks ?? 0; 
          if(($MaximumMarks->exam_minimum_marks ?? 0) > ($old_marks->student_marks ?? 0)  && $fail == false)
        {
        $fail= true;
        }
     @endphp
     <tr>
          <td class='text-center-padding'>{{$item->name ?? ''}}</td>
          <td class='text-center-padding'>{{$MaximumMarks->exam_maximum_marks ?? '-'}}</td>
          <td class='text-center-padding'>{{$old_marks->student_marks ?? '-'}}</td>
          @php
          $distinct = (($old_marks->student_marks ?? 0)/($MaximumMarks->exam_maximum_marks ?? 0))*100;
          @endphp
          <td class='text-center-padding'>{{$distinct > 74.99 ? 'D' : '-' }}</td>
         
     </tr>
     @endforeach
     @endif
        <tr>
            <td>
                <div align="center" class="text-center">
                    <p style="padding: 10px 0px;"><strong>Total Max. Marks: - {{$total_marks ?? '0' }} </strong></p>
                </div>
            </td>
            <td colspan="3 ">
                <div align="center" style="text-align: center;margin-left: 20%;">
                    <p style="padding: 10px 0px;"><strong>Total  Marks Obtained</strong> :- {{$total_obtained ?? '0' }} </p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6 ">
                <table width="100% " cellspacing="0 " cellpadding="0 ">
                    <tr>
                        <td width="49% " style=" border-right: 2px solid grey; ">
                            <table width="100% " cellspacing="0 " cellpadding="0 ">
                                <tr style="text-align: center;">
                                    <td>
                                        <div>
                                            <div align="center "><br><strong>
                                @php
                                $percentage =   number_format(round(($total_obtained/$total_marks)*100), 2);
                                @endphp
                                                Percentage: - {{$percentage}}%
                                                </strong></div>
                                            <br>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="51% ">
                            <table width="100% " cellspacing="0 " cellpadding="0 ">
                                <tr>
                                    <td width="33% " style="text-align: center;">
                                        <div align="center " class="style3 "><strong>Result: - </strong>
                                        @if($fail)
                                        Fail
                                        @else
                                      @if($percentage < 33)
                                      Fail
                                      @elseif($percentage > 32.99 && $percentage < 50 )
                                      Third Division
                                      @elseif($percentage > 49.99 && $percentage < 60 )
                                      Second Division
                                      @elseif($percentage > 59.99 && $percentage < 101 )
                                      First Division
                                        @endif
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
    </table>
    
    
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
            <td width='25%' align="center" class="text-center"><b>Other Subject</b></td>
            
            
             @if(!empty($subjects))
             @php
             $count_other_subject =0;
             $count_other_subject_marks =0;
             $key_current =0;
             @endphp
                                                
                                                @foreach($subjects as $key => $item)
                                                
                                                @if($item->other_subject == 1 && $count_other_subject < 3)
                                                
                                                
                                                @php
                                                $count_other_subject ++;
                                                $key_current = $key;
                                                 $MaximumMarksOther = DB::table('fill_min_max_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('class_type_id',$data->class_type_id ?? '')
                                     ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
                                                @endphp
                                            <td  style=" border-right: 2px solid grey;" >
                                                                    <div align="center" class="style3 text-center" >
                                                                        <p><strong>{{$item->name ?? '' }}</strong></p>
                                                                        <p><strong>
                                                                            ( {{$MaximumMarksOther->exam_maximum_marks ?? '-'}} )
                                                                           </strong></p>
                                                                    </div>
                                            </td>
                                                @endif
                                                
                                                @endforeach
                                                @endif
                                                    
                                                
            </tr>
            
            <tr>
                <td align="center" class="text-center"><b> Marks Obtained</b></td>
              @if(!empty($subjects))
                                                
                                                @foreach($subjects as $key => $item)
                                                
                                                @if($item->other_subject == 1 && $count_other_subject_marks < 3)
                                                
                                                
                                                @php
                                                $count_other_subject_marks++;
                                                    $old_marks_other = DB::table('fill_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('admission_id',$data->id)
                                      ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
                                     
                                     @endphp
                                                
                                            <td align='center'  style="border-right: 2px solid grey;">
                                                {{$old_marks_other->student_marks ?? ''}}
                                                </td>
                                                @endif
                                                
                                                @endforeach
                                                @endif
            </tr>
            
            
            <!--second row other marks -->
            
            
            @if($subjects->sum('other_subject') > 3)
            <tr>
            <td width='25%' align="center" class="text-center"><b>Other Subject</b></td>
            
            
             @if(!empty($subjects))
                                                
                                                @foreach($subjects as $key => $item)
                                                
                                                @if($item->other_subject == 1 && $key > $key_current)
                                                
                                                
                                                @php
                                                 $MaximumMarksOther = DB::table('fill_min_max_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('class_type_id',$data->class_type_id ?? '')
                                     ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
                                                @endphp
                                            <td  style=" border-right: 2px solid grey;" >
                                                                    <div align="center" class="style3 text-center" >
                                                                        <p><strong>{{$item->name ?? '' }}</strong></p>
                                                                        <p><strong>
                                                                            ( {{$MaximumMarksOther->exam_maximum_marks ?? '-'}} )
                                                                           </strong></p>
                                                                    </div>
                                            </td>
                                                @endif
                                                
                                                @endforeach
                                                @endif
                                                    
                                                
            </tr>
            
            <tr>
                <td align="center" class="text-center"><b> Marks Obtained</b></td>
              @if(!empty($subjects))
                                                
                                                @foreach($subjects as $key => $item)
                                                
                                                @if($item->other_subject == 1 && $key > $key_current)
                                                
                                                
                                                @php
                                                
                                                    $old_marks_other = DB::table('fill_marks')
                                     ->where('exam_id', $exam_id)
                                     ->where('admission_id',$data->id)
                                      ->where('subject_id',$item->id ?? '')
                                     ->where('branch_id',Session::get('branch_id'))
                                     ->where('session_id',Session::get('session_id'))
                                     ->whereNull('deleted_at')->first();
                                     
                                     @endphp
                                                
                                            <td align='center'  style="border-right: 2px solid grey;">
                                                {{$old_marks_other->student_marks ?? ''}}
                                                </td>
                                                @endif
                                                
                                                @endforeach
                                                @endif
            </tr>
            
            @endif
        </tbody>
        
        </table>
    
      <table width="100%" border=1>
    <tr>
    <td colspan="6">
                                                                    <p>&nbsp;</p>
                                                                    
                                                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Result Declaration Date :- <span class="font-weight-bold">  </span></p>
                                                                    <p>&nbsp;</p>
                                                                  
                                                                </td>
</tr>
    </table>
    
      <table width="100%" border=1>
                                               
                                                <tr>
                                                    
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong></strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong>
                                    <img width="50px" height="50px"src="{{env('IMAGE_SHOW_PATH')}}{{'/setting/seal_sign/'}}{{$getSetting->controller_sign ?? ''}}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/seal.png' }}'" />
                                                                 </strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong><img width="50px" height="50px"src="{{env('IMAGE_SHOW_PATH')}}{{'/setting/seal_sign/'}}{{$getSetting->seal_sign ?? ''}}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/seal.png' }}'" /></strong></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong>Class Teacher Sign </strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong>Controller of Examination </strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong>Principal Signature</strong></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
    
    </div>
    
    
    
    
    <script>
        $( document ).ready(function() {
    var fail = "{{$postFixFail ?? ''}}";
   if(fail == 'F')
   {
    $( ".grace" ).each(function( index ) {
 if($.trim($(this).text()) == 'G')
 {
     $(this).text('F');
 }
});
   }
    
});
    </script>