@php
  $classType = Helper::classType();
  $getCountry = Helper::getCountry();
  $getAllUsers = Helper::getAllUsers();
  $getSession = Helper::getSession();
@endphp

@extends('layout.app') 
@section('content')

<style>
.padding_table thead tr{
    background:#002c54;
    color:white;
}
.padding_table th, .padding_table td{
    padding:5px;
    font-size:14px;
}
@keyframes blink {
    0%, 49%, 100% { opacity: 1; }
    50%, 99% { opacity: 0.3; }
}
.blinking-msg {
    animation: blink 1.5s infinite;
    color: #ff6b6b;
    font-weight: bold;
}
</style>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">
<div class="row">
<div class="col-12">

<div class="card card-outline card-orange">
<div class="card-header bg-primary">
    <h3 class="card-title">
        <i class="fa fa-bar-chart-o"></i> {{ __('Store Daily Collection') }}.
        
    </h3>
    <div class="card-tools">
        <a href="{{ url('addStationaryRequest') }}" class="btn btn-primary btn-sm" title="Back">
            <i class="fa fa-plus-circle mr-1"></i> {{ __('Make Request') }}
        </a>
        <a href="{{ url('storeDashboard') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}
        </a>
    </div>
</div>

{{-- ================= FILTER FORM ================= --}}
<form method="post">
@csrf



<div class="row m-2">

    <div class="col-md-2">
        <label>{{ __('fees.From Date') }}</label>
        <input type="date" class="form-control" name="starting"
               value="{{ request('starting') }}">
    </div>

    <div class="col-md-2">
        <label>{{ __('fees.To Date') }}</label>
        <input type="date" class="form-control" name="ending"
               value="{{ request('ending') }}">
    </div>

    <div class="col-md-2">
        <label>{{ __('Tran. Status') }}</label>
        <select class="form-control" name="transaction_status">
            <option value="">All</option>
            <option value="success" {{ request('transaction_status') == 'success' ? 'selected' : '' }}>Success</option>
            <option value="cancelled" {{ request('transaction_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="failure" {{ request('transaction_status') == 'failure' ? 'selected' : '' }}>Failure</option>
            <option value="pending" {{ request('transaction_status') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
    </div>

    <div class="col-md-2">
        <label>{{ __('Payment Mode') }}</label>
        <select class="form-control" name="payment_mode_id">
            <option value="">All</option>
            <option value="1" {{ request('payment_mode_id') == 1 ? 'selected' : '' }}>Cash</option>
            <option value="6" {{ request('payment_mode_id') == 6 ? 'selected' : '' }}>UPI/Online</option>
            <option value="10" {{ request('payment_mode_id') == 10 ? 'selected' : '' }}>Debit/Credit Card</option>
        </select>
    </div>

    <div class="col-md-2 mt-4">
        <button class="btn btn-primary mt-2">
            <i class="fa fa-search"></i> {{ __('messages.Search') }}
        </button>
    </div>

</div>
</form>

{{-- ================= TABLE ================= --}}
<div class="row m-2">
<div class="col-12" id="downloadLeaflet">

<table id="example1"
       class="table table-bordered table-striped dataTable dtr-inline padding_table">

<thead>
<tr>
    <th>{{ __('messages.Sr.No.') }}</th>
    <th>Collect By</th>
    <th>Receipt No.</th>
    <th>Txn Id & Status</th>
    <th>{{ __('student.Admission No.') }}</th>
    <th>Class</th>
    <th>{{ __('Student Name') }}</th>
    <th>{{ __('messages.Fathers Name') }}</th>
    <th>{{ __('Payment date') }}</th>
    <th>{{ __('Items') }}</th>
    <th>{{ __('Payment Modes') }}</th>
    <th>{{ __('Discount') }}</th>
    <th>{{ __('Amount') }}</th>
</tr>
</thead>

<tbody>
@php
    $srNo = 1;
    $totalAmt = 0;
@endphp

@foreach($data as $row)
@php
    $totalAmt += $row->total_amount;
@endphp
<tr>

    <td>{{ $srNo++ }}</td>

    {{-- Collect By --}}
    <td>Admin</td>

    {{-- Receipt No --}}
    <td>
          <a target='_blank' class='btn btn-info btn-xs' href="{{url('storeReceipt')}}/{{$row->receipt_no ?? ''}}/{{$row->admission_id ?? ''}}"> #{{ $row->receipt_no }}</a>
       
    </td>


    {{-- Txn Id & Status --}}
    <td>
        @if(!empty($row->transaction_id))
            <small class="text-primary">{{ $row->transaction_id ?? '' }}</small>
        @endif
        @if(in_array($row->payment_mode_id, [6, 10]))
                                       
        <br><span class="{{ $row->transaction_status === 'success' ? 'text-success' : ($row->transaction_status === 'pending' ? 'text-warning' : 'text-danger') }}">{{ !empty($row->transaction_status) ? $row->transaction_status : 'N/A' }}</span>

        @endif
                        
        @if($row->payment_mode_id == 6 && $row->transaction_status !== 'success') 

                <br><button class="btn btn-success btn-xs checkTxnStatusBtn" data-txnid="{{ $row->transaction_id ?? '' }}" data-table-id="{{ $row->id }}">Check PayU Status & Update</button>
            
        @endif

        @if($row->payment_mode_id == 1) 
            <br><span class="text-success">Paid Cash</span>
        @endif
    </td>

    <td>{{ $row->admissionNo }}</td>
    <td>{{ $row->class_name }}</td>
    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
    <td>{{ $row->father_name }}</td>

    <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
    <td>
        @php
            $items = DB::table('store_item_student_requests')
                ->where('receipt_no', $row->receipt_no)
                ->pluck('store_item_id')
                ->toArray();
            $items = DB::table('store_items')
                ->whereIn('id', $items)
                ->pluck('name')
                ->toArray();
        @endphp
        <span class="text-primary">{{ implode(', ', $items) }}</span>
    </td>

    <td>{{ $row->payment_mode ?? 'Cash' }}</td>

    <td>0</td>

    <td class="text-right">
        {{ number_format($row->total_amount,2) }}
    </td>

</tr>
@endforeach
</tbody>

<tfoot style="font-weight:bold;">
<tr>
    <td colspan="12" style="text-align:right;">Total Amount</td>
    <td class="text-right">{{ number_format($totalAmt,2) }}</td>
</tr>
</tfoot>

</table>

<div class="text-center my-2">
    <button class="btn btn-sm btn-success" id="printFile">
        <i class="fa fa-print"></i> Print
    </button>
</div>

</div>
</div>

</div>
</div>
</div>
</section>
</div>

{{-- ================= PRINT SCRIPT ================= --}}
<script>
$(document).ready(function () {
    $('#printFile').click(function () {
        printContent();
    });
});

function printContent() {
    var styles = '';
    $('style, link[rel="stylesheet"]').each(function () {
        styles += this.outerHTML;
    });

    var content = $('#downloadLeaflet').html();
    var win = window.open('', '_blank');

    win.document.write('<html><head><title>Store Daily Collection</title>');
    win.document.write(styles);
    win.document.write('</head><body style="margin:10px;">');
    win.document.write(content);
    win.document.write('</body></html>');

    win.document.close();
    setTimeout(function () {
        win.print();
        win.close();
    }, 500);
}
</script>


<script>
$(document).ready(function () {
  
   
    $(".checkTxnStatusBtn").click(async function () {

        const btn = $(this);
        const originalBtnText = btn.text();
        var txnid = $(this).data('txnid');
        var table_id = $(this).data('table-id');

        try {
            btn.prop("disabled", true).html(`<i class="fa fa-spinner fa-spin"></i> ${originalBtnText}`);

            const response = await fetch("{{ url('checkPayUTxnStatus') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                body: JSON.stringify({ txnid: txnid })
            });

            const data = await response.json();

            if (response.ok) {
                //toastr.info(data.message);
                $('#checkTxnStatusModal').modal('show');
                const parsed = typeof data.response === 'string' ? JSON.parse(data.response) : data.response;
                const prettyHTML = syntaxHighlight(parsed);
               
                $('#txnJsonOutput').html(prettyHTML);

                if (parsed.transaction_details) {
                    const transactions = Object.values(parsed.transaction_details);

                    transactions.forEach(txn => {
                       
                            //alert('✅ Payment Fetched for Txn ID: ' + txn.txnid + '\nMihpayid: ' + txn.mihpayid + '\nAmount: ' + txn.transaction_amount + '\nDate: ' + txn.addedon + '\n\nThe payment status will be updated shortly.\n\n' + txn.status);
                            updateTxnStatus(table_id, txn.txnid, txn.status);
                       
                    });
                }
                // const parsedData = JSON.parse(data.response); 
                // var prettyJson = JSON.stringify(parsedData, null, 4);
                // $('#txnJsonOutput').text(prettyJson);
            } else {
                toastr.error(data.message || "Something went wrong. Please try again.");
            }
        } catch (error) {
            let errorMessage = error.message || "An unexpected error occurred.";
            toastr.error(errorMessage);
            console.error("Error:", errorMessage);
        } finally {
            btn.prop("disabled", false).text(originalBtnText);
        }
        
    });    

    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, null, 4);
        }

        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            let cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return `<span class="${cls}">${match}</span>`;
        });
    }

    const updateTxnStatus = async (id, txnid, status) => {
        try {
            const res = await fetch('/update-store-txn-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    table_id: id,
                    transaction_id: txnid,
                    transaction_status: status
                })
            });

            const data = await res.json();

            if (data.status === true) {
                toastr.success(data.message || 'Payment status updated successfully');
            } else {
                toastr.warning(data.message || 'Payment updated but needs review');
            }

        } catch (e) {
            console.error('Txn Update Failed:', e);
            toastr.error('Failed to update payment status');
        }
    };



});

</script>
 <div id="checkTxnStatusModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h3>Transaction Result</h3>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <pre class="json-viewer bg-dark text-white p-3 rounded" style="font-family: monospace; max-height: 500px; overflow-y: auto;">
        <code id="txnJsonOutput"></code>
    </pre>
      </div>
     <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>       
<style>
    th, td{
    white-space: nowrap !important;

}

.json-viewer .key       { color: #ffd700; }  /* yellow */
  .json-viewer .string    { color:rgb(69, 248, 135); }  /* green */
  .json-viewer .number    { color: #fe774f; }  /* orange */
  .json-viewer .boolean   { color: #82aaff; }  /* blue */
  .json-viewer .null      { color: #c670ff; }  /* purple */

  
</style>

@endsection
