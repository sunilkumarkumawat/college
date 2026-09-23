@php
$getSetting=Helper::getSetting();
$getSession=Helper::getSession();
//dd($getSetting);
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    .reg_td{
        position: absolute;
        right:0;
        display: flex;
        border: none;
        white-space: nowrap;
        margin-top: 5px;
        margin-right: 10px;
    }
        .style4 {
            font-size: 18px
        }
        .style5 {
            font-size: 40px;
            font-weight: bold;
            color:#aac818;
            margin-top: 15px;
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
    .title_top {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 0px;
    }
    .end_flex {
        display: flex;
        align-items: end;
    }
    .description_head {
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 0px;
    }
    .title_bottom {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 0px;
    }
    .border_table {
        border: 1px solid black;
        padding: 10px;
    }
    .second_table {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
    .second_table th {
        border: 1px solid black;
        background-color: #CCCCCC;
    }
    .second_table td {
        border: 1px solid black;
    }
    .height_table {
        margin-top: 9%;
    }
    .last_tr_main{
        display: flex;
        align-items: end;
        justify-content: space-between;
        padding: 10px;
    }
    .pagination_height{
        height: 35cm;
    }
    .relative_text{
        position: relative;
    }
    .absolute_text{
       position: absolute;
        right: 0;
        top: 0;
    }
</style>
<body>
    
    @if(!empty($admission_id))
    @foreach($admission_id as $admission_id)
    <div class="container pagination_height">
        <table width="100%" class="border_table" cellspacing="0" cellpadding="0" style="background-image: url('{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png'}}');
            background-repeat: no-repeat;
            background-position: center;background-size: 500px 500px;">
             <tr style="position:relative">
                <td colspan="9">
                    <table width="100%" cellspacing="0" cellpadding="0" border="2" >
                        <tr >
                            <td width="20%" style="text-align:center;padding:10px; border: 0px solid white;">
                                <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'"   width = "100%" >
                                </td>
                            <td width="80%" style="border: 0px solid white;">
                                <div>
                                    <div align="center">
                                        <p class="style5">{{$getSetting['name'] ?? ''}}</p>
                                        <div><span class="style4"><strong>Address</strong> - {{$getSetting['address'] ?? ''}},{{$getSetting['pincode'] ?? ''}}</span></div>
                                        <div><span class="style4"><strong>Email Id</strong> - {{$getSetting['gmail'] ?? ''}}</span></div>
                                        <p>&nbsp;</p>
                                    </div>
                                </div>
                            </td>
                            <td width="0%" class="reg_td">
                                <div><span class="style4"><strong>Reg. No. : </strong> {{$getSetting['regNo'] ?? ''}}</span></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @php
                $className = DB::table('class_types')
                ->where('id',$admission_id->class_type_id)
                ->where('session_id',Session::get('session_id'))
                 ->where('branch_id',Session::get('branch_id'))
                ->whereNull('deleted_at')->first();
            @endphp
            <tr>
                <td style="padding-left: 20px;">Class</td>
                <td>: <b>{{$className->name ?? '' }}</b></td>
                <td>Student Name</td>
                <td>: <b>{{$admission_id->first_name ?? '' }}</b></td>
                <td>Father's Name</td>
                <td>: <b>{{$admission_id->father_name ?? '' }}</b></td>
                <td>Roll No.</td>
                <td>: <b>{{$admission_id->exam_roll_no ?? '' }}</b></td>
                <td rowspan="2" class="text-center">
               
                    <img src="{{env('IMAGE_SHOW_PATH').'profile/'.($admission_id->image ?? '')}}" class="mt-2"  onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'"  width="100px" alt="student_profile">
                </td>
            </tr>
            <tr>
                <td style="padding-left: 20px;">Reg No.</td>
                <td>: <b>{{$admission_id->admissionNo ?? ''}}</b></td>
                <td>Date Of Birth</td>
                <td>: <b>{{date('d-m-Y', strtotime($admission_id->dob ?? '')) ?? '' }}</b></td>
                <td>Mother's Name</td>
                <td>: <b>{{$admission_id->mother_name ?? '' }}</b></td>
                <td></td>
                <td><b></b></td>
            </tr>
            <tr>
                <td colspan="12">
                    <table width="100%" class="second_table mt-3 text-center" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th rowspan="2">
                                    Subject
                                </th>
                                @foreach($list_exam as $item)
                                <th>{{$item->name ?? ''}}</th>
                                @endforeach
                                <th>&nbsp;</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                @php
                                    $max = [];
                                    $getMaximumTotal = 0;
                                @endphp
                                @foreach($list_exam as $item)
                                @php
                                    $getMaximum = DB::table('fill_min_max_marks')
                                    ->where('exam_id',$item->id)
                                    ->where('session_id',Session::get('session_id'))
                                    ->where('branch_id',Session::get('branch_id'))
                                    ->whereNull('deleted_at')->first();
                                    
                                    $max[$item->id] = $getMaximum->exam_maximum_marks ?? 0;
                                    
                                    if ($getMaximum) {
                                        $getMaximumTotal += $getMaximum->exam_maximum_marks;
                                    }
                                @endphp
                               <th>{{$getMaximum->exam_maximum_marks ?? ''}}</th>
                                @endforeach
                                <th></th>
                                <th>{{$getMaximumTotal}}</th>
                            </tr>
                            @if(!empty($list_exam)) 
                              @php
                               $total_obtained_bottom=0;
                                 $total_possible_bottom = 0; 
                                 $total_possible_bottom_before = 0; 
                                 $arr= []; 
                                 $total_possible_right_before = 0; 
                              @endphp
                            @foreach($list_subject as $key => $item)
                              @php 
                                    $total_obtained =0;
                                    $grade=0;
                                    $total_possible_right = count($list_exam); 
                                    $total_possible_bottom = count($list_exam); 
                                    $g_grade_right ='';
                                    $g_grade_bottom ='';
                                    $great_g_grade_bottom ='';
                                @endphp 
                            <tr>
                                <td>
                                    {{$item->name ?? '' }}</td>
                               @foreach($list_exam as $item1)
                                @php
                                $number = DB::table('fill_marks')
                                ->where('exam_id',$item1->id)
                                ->where('subject_id',$item->id ?? '')
                                ->where('admission_id',$admission_id->id)
                                ->where('session_id',Session::get('session_id'))
                                ->where('branch_id',Session::get('branch_id'))
                                ->where('deleted_at',null)
                                ->first();
                   if(!empty($number))
                               {
                               $declare_date = $number->created_at ?? '';
                                 if($number->student_marks != null)
                                 {
                                 $total_possible_bottom_before += $max[$item1->id];
                                $total_possible_right_before += $getMaximum->exam_maximum_marks ?? 0;
                                 }
                                 else{
                                   $total_possible_bottom_before += 0;
                                $total_possible_right_before +=0;
                                 }
                                } 
                                @endphp
                               <td>
                                 @if(!empty($number))  
                                 @php
                                 $marks =  0;
                                 if($number->student_marks != null &&  strtolower($number->student_marks) != 'ab')
                                 {
                                 $marks = $number->student_marks ;
                                 }
                                 $total_obtained += $marks;
                                  $total_obtained_bottom += $marks;
                                  $grade = $marks;
                                 @endphp
                              {{ strtoupper($number->student_marks ?? '-')}}
                              
                              @else
                              -
                                @endif
                                   </td>
                                @endforeach
                                <th>&nbsp;</th>
                                <td>
                                   @if($total_obtained > 0 )  
                                   @php
                                   $g_grade_right = ($total_obtained/($total_possible_right*($total_possible_right_before == 0 ? 1 : $total_possible_right_before)))*100 ?? 0;
                                   @endphp
                                    {{ $total_obtained ?? 0 }}
                                @else
                                -
                                @endif
                                    </td>
                            </tr>
                            @endforeach
                            @endif
                            <tr>
                                 @foreach($list_exam as $item)
                                <th>&nbsp;</th>
                                @endforeach
                                <th>&nbsp;</th>
                              <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <td>Total Marks </td>
                                @foreach($list_exam as $item)
                                   @php
                                
                                $number2 = DB::table('fill_marks')
                                ->where('exam_id',$item->id)
                                ->where('admission_id',$admission_id->id)
                                ->whereIn('subject_id',$subject_id)
                                ->where('session_id',Session::get('session_id'))
                                ->where('branch_id',Session::get('branch_id'))
                                ->where('deleted_at',null)
                                ->sum('student_marks');
                                @endphp
                                
                                
                                
                               <td>
                                   @if(!empty($number2))  
                                  
                                   @php
                                   $g_grade_bottom = ($number2/$total_possible_bottom_before)*100 ?? 0;
                                   @endphp
                                  
                                  {{$number2 ?? 0}}
                                @endif
                               </td>
                                @endforeach
                                <th>&nbsp;</th>
                                <td>
                                      @foreach($list_exam as $item3)
                                     @php
                                $number3 = DB::table('fill_marks')
                                ->whereIn('exam_id',$exam_id)
                                ->where('admission_id',$admission_id->id)
                                ->whereIn('subject_id',$subject_id)
                                ->where('session_id',Session::get('session_id'))
                                ->where('branch_id',Session::get('branch_id'))
                                ->where('deleted_at',null)
                                ->sum('student_marks');
                                @endphp
                                @endforeach
                                   @if(!empty($number3))    
                                    @php
                                    $great_g_grade_bottom= ($number3/((($total_possible_bottom_before))))*100;
                                    @endphp
                    {{ $number3  }}
                                  @endif
                                    </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
            @php
                $next = DB::table('class_types')
                ->where('id', '>', $admission_id->class_type_id)
                ->where('session_id',Session::get('session_id'))
                                ->where('branch_id',Session::get('branch_id'))
                ->first();
            @endphp
            <tr class="relative_text">
                <td colspan="6">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="12">
                                @if((Int)$great_g_grade_bottom > 33 )
                                    @if(!empty($next))
                                    <p class="title_bottom">&nbsp;&nbsp;**Congratulationns Promoted to Class - <span class="font-weight-bold">{{$next->name}} </span></p>
                                    <br>
                                    <br>
                                    @endif
                                @endif
                                
                                <!--<p class="title_bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Result Declaration Date :-{{date('d/m/Y', strtotime($declare_date  ?? ''))}}</p>-->
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="12">
                                    <p class="title_bottom">Marks in Percentage :  {{ round($great_g_grade_bottom ,2) }}%</p>
                                    <br>
                                    <br>
                                <p class="title_bottom">&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="12">
                                    <p class="title_bottom">Result : {{(Int)$great_g_grade_bottom > 32.99 ? 'Pass' : 'Fail'}}</p>
                                    <br>
                                    <br>
                                <p class="title_bottom">&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <table width="100%" cellspacing="0" cellpadding="0" class="height_table">
                        <tr class="last_tr_main">
                            <td colspan="6">
                                <!--<p class="title_bottom">-->
                                <!--    Note : [91-100% = A+] , [76-90% = A] , [61-75% = B] , [41-60% = C] ,  [0-40% = D]-->
                                <!--</p>-->
                                  <p class="title_bottom">Class Teacher's Signature</p>
                            </td>
                            <td colspan="3">
                                <!--<p class="title_bottom">Class Teacher's Signature</p>-->
                            </td>
                            <td colspan="3" class="text-center">
                                <img src="{{env('IMAGE_SHOW_PATH')}}{{'setting/seal_sign/'}}{{ $getSetting['seal_sign']}}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'" alt="seal" width="100px">
                                <p class="title_bottom">Principal's Signature</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
    @endforeach
    @endif
</body>
</html>