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
            font-size: 40px;
            font-weight: bold;
            color:#aac818;
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
    <table width="100%" border="2" cellspacing="0" cellpadding="0" style="background-image: url('{{ env('IMAGE_SHOW_PATH').'/default/logo_opacity.png'}}');
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
                            <td class="reg_td">
                                 <div><span class="style4"><strong>Reg. No. : </strong> {{$getSetting['regNo'] ?? ''}}</span></div>
                            </td>
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
                <p>{{$data[0]->admissionNo ?? '' }}</p>
                <p>{{$data[0]->name ?? '' }}</p>
               
                <p>{{$data[0]->father_name ?? '' }}</p>
              
                <p>{{$data[0]->mother_name ?? '' }}</p>
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
                <p>{{$data[0]->exam_roll_no ?? '' }}</p>
                <p>{{$data[0]->class_name ?? '' }} @if($data[0]->stream_id != "")[{{$data[0]->stream_id ?? ''}}]@endif</p>
                <p>{{date('d-m-Y', strtotime($data[0]->dob)) ?? '' }}</p>
                <p>{{$data[0]->gender_id == 1 ? 'Male' : 'Female' }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="4 " style="text-align: center;">
                <div align="center " class="style13 ">
                    <p>&nbsp;</p>
                    <p><strong>Progress Report Card (Session {{$data[0]->from_year ?? ''}}{{"-"}}{{$data[0]->to_year ?? ''}}) </strong></p>
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
   
        @php
            $student_stream_subject = DB::table('admissions')->where('admissionNo',$data[0]->admissionNo)->where('deleted_at',null)->first();

            $arr =[];

foreach(explode(',', $student_stream_subject->stream_subject) as $info)
{
    $arr[] = $info;

}

@endphp


       @if(!empty($data)) @php $total_obtained =0; $total_possible =0; @endphp
       @php
            $graceNumber = 0;
            
            $postFixGrace = ' ';
            $postFixFail = '';
            $total_marks = 0 ;
            @endphp
           @foreach($data as $key => $item111 )
                @if($item111->other_subject != 1)
                    @if($item111->class_type_id >13)  
                        @if(in_array($item111->subject_id, $arr))
                            @if(count(Helper::getMaxMarks($item111->exam_id ?? '', $item111->class_type_id ?? '',$item111->section_id  ?? '')) >0)
                                @foreach(Helper::getMaxMarks($item111->exam_id ?? '', $item111->class_type_id ?? '',$item111->section_id  ?? '' ) as $marks1)
                                    @if($marks1->subject_id == $item111->subject_id)
                                        @php
                                            $total_marks += $marks1->exam_maximum_marks;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @else
                  
                 
                      
                            @if(count(Helper::getMaxMarks($item111->exam_id ?? '', $item111->class_type_id ?? '',$item111->section_id  ?? '')) >0)
                                @foreach(Helper::getMaxMarks($item111->exam_id ?? '', $item111->class_type_id ?? '',$item111->section_id  ?? '') as $marks1)
                              
                                    @if($marks1->subject_id == $item111->subject_id)
                                        @php
                                            $total_marks += $marks1->exam_maximum_marks;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        
                       
                @endif
            @endif
        @endforeach
          
          
          
          
          
              
       @php
         $graceNumber = ($total_marks*1)/100;
          //   dd($graceNumber);
       @endphp
       
       
       
       
       
       
       
            
       @foreach($data as $key => $item )
               @if($item->other_subject != 1)
               
          
           @if($item->class_type_id >13)  
            @if(in_array($item->subject_id, $arr))
            
       
                <tr style="text-align: center;">    
                    <td style="padding: 5px;text-transform:uppercase">{{$item->subject_name ?? '' }}</td>
                       @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                       @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '' ) as $marks)
                       @if($marks->subject_id == $item->subject_id)
                    <td>
                          @if($marks->make_grade ==1)
                          GRADE
                             @else
                            {{ $marks->exam_maximum_marks ?? ''}}
                       @endif
                        
                     
                    
                    
                            <!--{{$total_obtained += $item->student_marks ?? '0' }}-->
                        </td>
                 
                    <!--{{$total_possible += $marks->exam_maximum_marks ?? '0' }}-->
                    <td>
                          {{$item->student_marks ?? '' }}
                    </td>
                     <td class="grace">
                        @if($item->student_marks < 33)
                            @if((33 - $item->student_marks) <= $graceNumber)
                                G
                            @php  
                        $graceNumber =  $graceNumber-(33-$item->student_marks);
                        $postFixGrace = 'With Grace';
                            // dd($graceNumber);
                        @endphp
                        @else
                          F
                        @php
                        
                        $postFixFail = 'F';
                        @endphp
                        @endif
                        @else
                        {{ (($item->student_marks ?? 0 )/($marks->exam_maximum_marks ?? 0))*100 > 74 ? 'D' : '-'  }}
                        @endif
                    </td>
                    @endif @endforeach @endif
                </tr>
                @endif
@else
<tr style="text-align: center;">    
                    <td style="padding: 5px; text-transform:uppercase">{{$item->subject_name ?? '' }}</td>
                       @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                       @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '' ) as $marks)
                       @if($marks->subject_id == $item->subject_id)
                    <td>{{ $marks->exam_maximum_marks ?? ''}}
                            <!--{{$total_obtained += $item->student_marks ?? '0' }}-->
                        </td>
                 
                    <!--{{$total_possible += $marks->exam_maximum_marks ?? '0' }}-->
                    <td>
                          {{$item->student_marks ?? '' }}
                    </td>
                    <td class="grace">
                        @if($item->student_marks < 33)
                            @if((33 - $item->student_marks) <= $graceNumber)
                                G
                            @php  
                       
                        $graceNumber =  $graceNumber-(33-$item->student_marks);
                        $postFixGrace = 'With Grace';
                          // dd($graceNumber);
                        @endphp
                        @else
                          F
                        @php
                        
                        $postFixFail = 'F';
                        @endphp
                        @endif
                        @else
                        {{($item->student_marks > 75) ? 'D' : ''}} 
                        @endif
                    </td>
                    @endif @endforeach @endif
                </tr>

                @endif
    @endif
                @endforeach @endif
       
       
        <tr>
            <td>
                <div align="center" class="text-center">
                    <p style="padding: 10px 0px;"><strong>Total Max. Marks: - {{$total_possible ?? '0' }} </strong></p>
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
                                            <div align="center "><br><strong>Percentage: - {{ sprintf("%.2f", ($total_obtained / $total_possible) * 100) }}% </strong></div>
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
                                        
                                    @if($postFixFail == 'F')
                                    Fail
                                        
                                    @else
                                     {{(($total_obtained/$total_possible)*100 >= 33 )&& (($total_obtained/$total_possible)*100 <= 44.99) ? 'Third Division '.$postFixGrace : '' }} 
                                        {{($total_obtained/$total_possible)*100 <= 32 ? 'Fail' : '' }} 
                                        {{(($total_obtained/$total_possible)*100 >= 45 )&& (($total_obtained/$total_possible)*100 <= 59.99) ? 'Second Division '.$postFixGrace : '' }}
                                        {{($total_obtained/$total_possible)*100 >= 60 ? 'First Division '.$postFixGrace : ''}} 
                                    @endif
                                        
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <tr>
                    <td colspan="6 ">
                        <!--start other subject first row  -->
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style=" border-right: 2px solid grey; ">
                                        <table width="100% " cellspacing="0 " cellpadding="0 ">
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div align="center "></div>
                                                        <br>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100% ">
                                          
                                        </table>
                                    </td>
                                </tr>
                        </table>
                            <tr>
                                <td colspan="6">
                                    <table width="100% " cellspacing="0" cellpadding="0 " class="other_row0">
                                        <tr>
                                            <td width="25%"  style="border-right: 2px solid grey; ">
                                                <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                    <tr>
                                                        <td>
                                                            <div> <br>
                                                                <div align="center" class="text-center"><strong>Other Subjects </strong></div>
                                                                <br>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            
                                       
                                                @if(!empty($data)) 
                                                  @php
                                                  $row_count = 0;
                                                  $row_count_key = 0;
                                                  
                                                   $max_marks = [];
                                                   @endphp
                                                @foreach($data as $keyupper => $item )
                                                
                                                
                                                @if($item->other_subject == 1 && $row_count <= 2)
                                                    <td  style=" border-right: 2px solid grey;" class="same_width0">
                                                        <table width="100%" cellspacing="0 " cellpadding="0 ">
                                                            <tr >
                                                                <td  >
                                                                    <div align="center" class="style3 text-center" >
                                                                        <p><strong>{{$item->subject_name ?? '' }}</strong></p>
                                                                        <p><strong>
                                                                             @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                                                                            
                                                                               @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '' ) as $marks)
                                                                               @if($marks->subject_id == $item->subject_id)
                                                                               
                                                                               
                                                                               @if($marks->make_grade ==1)
                                                                               
                                                                               @else
                                                                                ({{ $marks->exam_maximum_marks ?? ''}})
                                                                               @endif
                                                                           
                                                                            
                                                                            @php
                                                                            $max_marks[] = $marks->exam_maximum_marks ?? '';
                                                                            @endphp
                                                                           
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                           </strong></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                            </td>
                                                @php
                                                $row_count++;
                                                $row_count_key = $keyupper;
                                                @endphp
                                                @endif
                                                @endforeach
                                                @endif
                                        </tr>
                                    </table>
                                    
                                    <!--end other subject first row  -->
                                   
                                    <!--start other subject second row-->
                                    
                                    <tr>
                                        <td colspan="6">
                                            <table width="100%" cellspacing="0" cellpadding="0" class="other_row0">
                                                <tr style="border-bottom: 1px solid black;">
                                                    <td width="25%" style="border-right: 2px solid grey;">
                                                        <table width="100%" cellspacing="0 " cellpadding="0 ">
                                                            <tr>
                                                                <td>
                                                                    <div> <br>
                                                                        <div align="center" class="text-center"><strong>Marks Obtained/Grade </strong></div>
                                                                        <br>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                     @if(!empty($data)) 
                                                     @php
                                                       $row_count_bottom = 0;
                                                       $count_max = 0;
                                                     @endphp
                                                    
                                                    @foreach($data as $key5 => $item )
                                                    
                                                    @if($item->other_subject == 1  && $row_count_bottom <= 2)
                                                    <td width="25%"  style="border-right: 2px solid grey;" class="same_width0">
                                                        <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                            <tr>
                                                                <td  >
                                                                    <div align="center" class="style3 text-center"><strong> 
                                                                    @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                                                                       @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '' ) as $marks)
                                                                       @if($marks->subject_id == $item->subject_id)
                                                                  
    
                                                                     {{$item->student_marks ?? 0}}
                                                                    
                                                                   
                                                                    @endif
                                                                    @endforeach
                                                                    @endif</strong></div>
                                                                </td>
                                                            </tr>
                                                    </table>
                                                    </td>
                                                    @php
                                                        $row_count_bottom++;
                                                        @endphp
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                   
                                                </tr>
                                            </table>
                                            
                                            <table width="100%" cellspacing="0" cellpadding="0" class="other_row1">
                                                <tr>
                                            <td  width="25%"style="border-right: 2px solid grey; " >
                                                <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                    <tr>
                                                        <td>
                                                            <div> <br>
                                                                <div align="center" class="text-center"><strong>Other Subjects </strong></div>
                                                                <br>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                                @if(!empty($data)) 
                                                  @php
                                                
                                                   $max_marks = [];
                                                $row_count_second = 0;
                                                   @endphp
                                                @foreach($data as $key4 => $item )
                                                
                                                @if($key4 > $row_count_key)
                                                @if($item->other_subject == 1 && $row_count_second <= 10 )
                                                    <td   style=" border-right: 2px solid grey;" class="same_width">
                                                        <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                            <tr >
                                                                <td >
                                                                    <div align="center" class="style3 text-center">
                                                                        <p><strong>{{$item->subject_name ?? '' }}</strong></p>
                                                                        <p><strong>
                                                                             @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                                                                            
                                                                               @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '' ) as $marks)
                                                                               
                                                                               
                                                                               @php
                                                                             //  dd($marks->make_grade);
                                                                               @endphp
                                                                               @if($marks->subject_id == $item->subject_id)
                                                                            
                                                                            @if($marks->make_grade ==1)
                                                                               
                                                                               @else
                                                                                ({{ $marks->exam_maximum_marks ?? ''}})
                                                                               @endif
                                                                            
                                                                            @php
                                                                            $max_marks[] = $marks->exam_maximum_marks ?? '';
                                                                            @endphp
                                                                           
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                           </strong></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                            </td>
                                                @php
                                                $row_count_second++;
                                                @endphp
                                                
                                                @endif
                                                @endif
                                                @endforeach
                                                @endif
                                        </tr>
                                            </table>
                                            <tr>
                                        <td colspan="6">
                                            <table width="100% " cellspacing="0 " cellpadding="0 " class="other_row1">
                                                <tr>
                                                    <td width="25%" style="border-right: 2px solid grey; ">
                                                        <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                            <tr>
                                                                <td>
                                                                    <div> <br>
                                                                        <div align="center" class="text-center"><strong>Marks Obtained/Grade </strong></div>
                                                                        <br>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                     @if(!empty($data)) 
                                                     @php
                                                     $count_max = 0;
                                                     $row_count_bottom1 =0;
                                                     @endphp
                                                     
                                                    @foreach($data as $key6 => $item )
                                                      @if($key6 > $row_count_key)
                                                    @if($item->other_subject == 1 && $row_count_bottom1 <= 10)
                                                    <td    style="border-right: 2px solid grey;" class="same_width">
                                                        <table width="100% " cellspacing="0 " cellpadding="0 ">
                                                            <tr>
                                                                <td >
                                                                    <div align="center" class="style3 text-center"><strong> 
                                                                    @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '')) >0)
                                                                       @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '',$item->section_id  ?? '') as $marks)
                                                                       @if($marks->subject_id == $item->subject_id)
                                                                  
    
                                                                     {{$item->student_marks ?? 0}}
                                                                    
                                                                   
                                                                    @endif
                                                                    @endforeach
                                                                    @endif</strong></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    
                                                    @php
                                                  $row_count_bottom1++;
                                                    @endphp
                                                    @endif
                                                    @endif
                                                    @endforeach
                                               
                                                    @endif
                                                   
                                                </tr>
                                            </table>  
                                            
                                            
                                            
                       <!--end other subject second row  -->
                                @php
                                    $next = DB::table('class_types')->where('id', '>', $data[0]->class_type_id)->first();
                                @endphp
                                            <tr>
                                                <td colspan="4" class="remove_borders">
                                                    <table width="100% " cellspacing="0 " cellpadding="0">
                                                            <tr style="display: block;">
                                                                <td colspan="6">
                                                                    <p>&nbsp;</p>
                                                                     @if($postFixFail != 'F')
                                                                    @if(($total_obtained/$total_possible)*100 > 33 )
                                                                    @if(!empty($next))
                                                                    <p>&nbsp;&nbsp;**Congratulationns Promoted to Class - <span class="font-weight-bold">{{$next->name}} </span></p>
                                                                    <br>
                                                                    <br>
                                                                    @endif
                                                                    @endif
                                                                    @endif
                                                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Result Declaration Date :- <span class="font-weight-bold"> {{date('d/m/Y', strtotime($data[0]->created_at ?? ''))}} </span></p>
                                                                    <p>&nbsp;</p>
                                                                  
                                                                </td>
                                                            </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="4 ">
                                                    <table width="100% " cellspacing="0 " cellpadding="0 " style="margin-top: -9%;">
                                                  
                                                          <tr>
                    <td colspan="2">
                        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 14%;">
                            <tr>
                                <td>
                                    <div>
                                        <div>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                               
                                                <tr>
                                                    
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong></strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong>
                                    <img width="50px" height="50px"src="{{env('IMAGE_SHOW_PATH')}}{{'/setting/seal_sign/'}}{{$getSetting->controller_sign ?? ''}}" />
                                                                 </strong></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div align="center"><strong><img width="50px" height="50px"src="{{env('IMAGE_SHOW_PATH')}}{{'/setting/seal_sign/'}}{{$getSetting->seal_sign ?? ''}}" /></strong></div>
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
                                            </table><br>
                                        </div>
                                    </div>
                                    <div></div>
                                </td>
    
                            </tr>
    
                        </table>
                    </td>
                </tr>    
                                                    </table>
                                                </td>
                                            </tr>
                                        </td>
                                    </tr>
                                        </td>
                                    </tr> 
                           
                        </td>
                </tr> 
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