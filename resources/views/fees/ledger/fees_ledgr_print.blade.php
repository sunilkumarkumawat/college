



@if(!empty($student))
@foreach ($student as $data)
@php
$totelDr = 0;
$totelCr = 0;
    $getSetting = Helper::getSetting();
    $account = Helper::getQRCode($getSetting->account_id);
    $images = env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'];
    $session = DB::table('sessions')->whereNull('deleted_at')->where('id', $data->session_id ?? '')->first();
    @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Ledger</title>
    <style>
        body { font-family: serif; font-size: 20px; max-width: 750px; margin: 25px auto; }
        .student_img { width: 80px; height: 100px; margin-top: 5%; margin-left: 20%; padding-bottom: 10px; }
        .canceled { font-size: 80px; color: rgba(255, 0, 0, 0.54); position: absolute; top: 103px; width: 100%; text-align: center; transform: rotate(-26deg); }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        th, td { border: 1px solid #1a1919; text-align: left; padding: 5px; }
        .border_none { border: none; }
        .bg_color_heading td { background-color: #f2f2f2; font-weight: 600; }
        .font_family { font-size: 13px; font-weight: normal; font-family: math; }
    </style>
</head>
<body>



<table>
    <tr>
        <td class="border_none" style="width: 20%;"><img src="{{$images}}" style="width: 117px; height: 117px;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'"></td>
        <td colspan="2" class="border_none" style="text-align: center; font-size: 30px;"><strong>{{$getSetting['name'] ?? ''}}</strong></td>
    </tr>
</table>

<table>
    <tr>
        <td class="border_td" style="width: 13%;border: 0px;"><b>Student ID</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: {{ $data->admissionNo ?? '-' }}</td>

        <td class="border_td" style="width: 13%;border: 0px;"><b>Univ Roll No</b></td>
        <td class="border_td" style="width: 13%;border: 0px;">: {{ $data->roll_no ?? '' }} </td>
    </tr>
    <tr>
        <td class="border_td" style="width: 13%;border: 0px;"><b>Name	</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: {{ $data->first_name ?? '-' }}</td>

        <td class="border_td" style="width: 13%;border: 0px;"><b>Father Name</b></td>
        <td class="border_td" style="width: 13%;border: 0px;">:{{ $data->father_name ?? '' }}</td>
    </tr>
    <tr>
        <td class="border_td" style="width: 13%;border: 0px;"><b>Gender	</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: {{ $data->genderName ?? '-' }}</td>

        <td class="border_td" style="width: 13%;border: 0px;"><b>Class</b></td>
        <td class="border_td" style="width: 13%;border: 0px;">: {{ $data->class_name ?? '' }} </td>
    </tr>
    <tr>
        <td class="border_td" style="width: 13%;border: 0px;"><b>Course	</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: {{ $data->course ?? '-' }}</td>

        <td class="border_td" style="width: 13%;border: 0px;"><b>Batch</b></td>
        <td class="border_td" style="width: 13%;border: 0px;">: {{ $data->batch ?? '' }} </td>
    </tr>
    <tr>
        <!-- <td class="border_td" style="width: 13%;border: 0px;"><b>Refund Advance		</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: 0 </td> -->
        <td class="border_td" style="width: 13%;border: 0px;"><b>Session</b></td>
        <td class="border_td"style="width: 16%;border: 0px;">: {{$session->from_year ?? ''}}-{{$session->to_year ?? ''}} </td>

       
    </tr>
    <!-- <tr>
      
    <td class="border_td" style="width: 13%;border: 0px;"><b>Pend Credi Amt</b></td>
        <td class="border_td" style="width: 16%;border: 0px;"> : </td>
    </tr> -->
</table>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Particulars	</th>
            <th>Dr.Amount</th>
            <th>Cr.Amount</th>
            <th>Balance	</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $i = 1;
        $feesAssign = App\Models\fees\FeesAssignDetail::select('fees_assign_details.*', 'fees_group.name as group_name','admissions.first_name as admission_stu_name')
                    ->join('fees_group', 'fees_group.id', '=', 'fees_assign_details.fees_group_id')
                    ->join('admissions', 'admissions.id', '=', 'fees_assign_details.admission_id')
                    ->where('admission_id',$data->id)
                    ->get();
        @endphp
        @foreach ($feesAssign as $assign) 
          
            <tr>
                <td>{{ date("d-m-Y", strtotime($assign->created_at))  }}</td>
                <td>{{ $assign->group_name ?? '' }}</td>
                <td>{{ $assign->fees_group_amount-$assign->discount }}</td>
                <td>0</td>
                
                <td>{{ $assign->fees_group_amount-$assign->discount }}</td>
                @php
                     $totelDr +=$assign->fees_group_amount-$assign->discount;
                @endphp
            </tr>
        @endforeach

        @php 
        $i = 1;
        $invoice_data =  App\Models\fees\FeesDetailsInvoices::select('fees_details_invoices.*')
        ->where('admission_id',$data->id)->whereIn('fees_details_invoices.status',[0,1])->get();

                   
        @endphp
        @foreach ($invoice_data as $invoice) 
          @php
          $explode = explode(',',$invoice->fees_details_id);
                    $fess_print = App\Models\FeesDetail::select('fees_detail.*','fees_group.name as fees_group_name')
                        ->leftJoin('fees_group','fees_group.id','fees_detail.fees_group_id')
                        ->whereIn('fees_detail.id',$explode)->pluck('fees_group_name')
                        ->first();
                        
          @endphp
            <tr>
                <td>{{ date("d-m-Y", strtotime($invoice->payment_date))  }}</td>
                <td>{{ $fess_print ?? 'N/A' }}( Receipt No. {{$invoice->invoice_no ?? ''}} ) 				</td>
                <td></td>
                <td>{{ $invoice->amount+$invoice->discount ?? ''}}</td>
                
                <td>{{$invoice->amount+$invoice->discount ?? '' }}</td>
                @php
                     $totelCr +=$invoice->amount+$invoice->discount
                @endphp
            </tr>
        @endforeach
        <tr>
                <td  style="text-align: center;"></td>
                <td  style="text-align: center;">Total</td>
                
                <td>{{$totelDr ?? ''}}</td>
                <td>{{$totelCr ?? ''}}</td>
                <td>{{$totelDr-$totelCr ?? ''}}</td>

            </tr>
    </tbody>
</table>
</body>
<div style="page-break-after: always;"></div>

@endforeach
@endif
<script type="text/javascript">
  window.print();
</script>