<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Marksheet</title>
</head>
@php
$getSetting=Helper::getSetting();
//dd($certificate_data);
@endphp
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .marksheet {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .header img {
        margin-right: 10px;
    }

    h1 {
        margin: 0;
    }

    .student-info {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #f5f5f5;
    }

    .total {
        text-align: right;
        margin-top: 20px;
    }

    .total p {
        margin: 5px 0;
    }

    strong {
        font-weight: bold;
    }
</style>

<body>
    <div class="marksheet">
        <div class="header">
            <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] }}" alt="Logo" style="width: 215px;">
            <h1>Student Marksheet</h1>
        </div>
        <div class="student-info">
            <p><strong>Name:</strong> {{$data[0]->first_name ?? '' }}{{" "}}{{$data[0]->last_name ?? '' }}</p>
            <p><strong>Roll No:</strong> {{$data[0]->admissionNo ?? '' }}</p>
            <p><strong>Class:</strong> {{$data[0]->class_name ?? '' }}</p>
        </div>
        <table>
            
            
            <tr>
                <th>Subject</th>
                <th>Marks Obtained</th>
                <th>Total Marks</th>
            </tr>
            @if(!empty($data))
            
            @php
            $total_obtained =0;
            $total_possible =0;
            
            @endphp
                                 @foreach($data as $key => $item )
                                      <tr>
                <td>{{$item->subject_name ?? '' }}</td>
                <td>{{$item->student_marks ?? '' }}
                 <!--{{$total_obtained += $item->student_marks ?? '0' }}-->
                </td>
             @if(count(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '')) >0) 
                                       @foreach(Helper::getMaxMarks($item->exam_id ?? '', $item->class_type_id ?? '') as $marks)
                                      @if($marks->subject_id ==  $item->subject_id)    
                                      <!--{{$total_possible += $marks->exam_maximum_marks ?? '0' }}-->
                                       <td>
                                      
                                       {{ $marks->exam_maximum_marks ?? ''}}
                                     
                                       </td>
                                        @endif
                                       @endforeach
                                       @endif
            </tr>
                                 
                                 @endforeach
                                 @endif
          
        </table>
        <div class="total">
            <p><strong>Total Marks Obtained:</strong>  {{$total_obtained ?? '0'  }}</p>
            <p><strong>Total Possible Marks:</strong>   {{$total_possible ?? '0'  }}</p>
        </div>
    </div>
</body>

</html>