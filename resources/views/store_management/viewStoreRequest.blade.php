@php
  $classType = Helper::classType();
  $getSetting = Helper::getSetting();
@endphp
@extends('layout.app') 
@section('content')

<style>
       .border_none {
            border: none;
        }
        .bg_color_heading {
            background-color: #f1f1f1;
        }
        @media print {
            button {
                display: none;
            }
            body {
                margin: 0;
                padding: 20px;
                font-family: Arial, sans-serif;
            }
            .page {
                width: 100%;
                border: 1px solid #000;
                padding: 20px;
                box-sizing: border-box;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            .bg_color_heading td {
                background-color: #f1f1f1;
                font-weight: bold;
            }
            .border_none {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
     
   </style>

                            <div class="content-wrapper">
                            
                               <section class="content pt-3">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-md-12">      
                                <div class="card card-outline card-orange">
                                    <div class="card-header bg-primary">
                                    <h3 class="card-title"><i class="fa fa-th-large"></i> &nbsp;{{ __('View Stationary Request') }} </h3>
                                    <div class="card-tools">
                                    <a href="{{url('addStationaryRequest')}}" class="btn btn-primary  btn-sm" title="Make Stationary Request"><i class="fa fa-plus"></i> {{ __('Make Stationary Request') }}</a>
                                    @if(Session::get('role_id') !== 3)
                                    <a href="{{ Session::get('role_id') == 3 ? url('addStationaryRequest') : url('storeDashboard') }}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                                    @endif    
                                </div>
                                    
                                    </div>  
                                    <form method="post" >
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
                                            
                                                <div class="col-md-2 mt-4">
                                                    <button class="btn btn-primary mt-2">
                                                        <i class="fa fa-search"></i> {{ __('messages.Search') }}
                                                    </button>
                                                </div>
                                            
                                            </div>
                                            </form>
                                        <div class="row m-2">  
                                        
                                            <div class="col-md-12" style="overflow-x:scroll;">
                                 <table id="example1" class="table table-responsive table-bordered table-striped dataTable dtr-inline nowrap no-footer">
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
                                <th>{{ __('Payment Modes') }}</th>
                                 <th>{{ __('Item') }}</th>
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

                            @if(Session::get('role_id') != 3 || $row->transaction_status === 'success')
                              
                               
                            <tr>
                            
                                <td>{{ $srNo++ }}</td>
                            
                                {{-- Collect By --}}
                                <td>Admin</td>
                            
                                {{-- Receipt No --}}
                                <td>
                               @if(Session::get('role_id') != 3||(
                                        Session::get('role_id') == 3
                                        && in_array($row->payment_mode_id, [1, 6, 10])
                                        && $row->transaction_status == 'success'
                                    )
                                )
                                    
                                    <a target='_blank' class='btn btn-info btn-xs' href="{{url('storeReceipt')}}/{{$row->receipt_no ?? ''}}/{{$row->admission_id ?? ''}}">#{{$row->receipt_no ?? ''}}</a>
                                    @if(Session::get('role_id') != 3)
                                    <!-- <a class='btn btn-danger btn-xs delete_row' data-id="{{$row->receipt_no ?? ''}}" data-toggle="modal" data-target="#revert_modal"><i class="fa fa-trash"></i></a> -->
                                    @endif
                                @endif

                              
                                </td>
                            
                                {{-- Txn Id & Status --}}
                                <td>
                                    @if(!empty($row->transaction_id))
                                        <small class="text-primary">{{ $row->transaction_id ?? '' }}</small>
                                        <br>
                                    @endif

                                    @if(in_array($row->payment_mode_id, [6, 10]))
                                       
                                    <span class="{{ $row->transaction_status === 'success' ? 'text-success' : ($row->transaction_status === 'pending' ? 'text-warning' : 'text-danger') }}">{{ !empty($row->transaction_status) ? $row->transaction_status : 'N/A' }}</span>

                                    @endif


                                    @if($row->payment_mode_id == 6 && $row->transaction_status !== 'success') 
                        
                                            <!-- <br><button class="btn btn-success btn-xs checkTxnStatusBtn" data-txnid="{{ $row->transaction_id ?? '' }}" data-table-id="{{ $row->id }}">Check PayU Status & Update</button> -->
                                      
                                    @endif
                                   
                                    @if($row->payment_mode_id == 1) 
                                        <br><span class="text-success">Received</span>
                                    @endif
                                </td>
                            
                                <td>{{ $row->admissionNo }}</td>
                                <td>{{ $row->class_name }}</td>
                                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                <td>{{ $row->father_name }}</td>
                            
                                <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                            
                                <td>{{ $row->payment_mode ?? 'Cash' }}</td>
                            
                                 @php
                                   $store_item_student = DB::table('store_item_student_requests')
                                   ->leftJoin('store_items as si', 'store_item_student_requests.store_item_id', '=', 'si.id')
                                   ->where('store_item_student_requests.branch_id',Session::get('branch_id'))
                                   ->where('store_item_student_requests.receipt_no', $row->receipt_no)->select('store_item_student_requests.*','si.name as item_name')->get();

                                @endphp
                                  <td >
                                @if(!empty($store_item_student))
                                    @foreach($store_item_student as $item)
                                      
                                            {{ $item->item_name }},<br>
                                       
                                    @endforeach
                              @endif
                               </td>
                            
                                <td class="text-right">
                                    {{ number_format($row->total_amount,2) }}
                                </td>
                              
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
							</table>
				</div>
 
            </div> 
</div>           
                        
                  
    </div>
  </div>
</div>
</section>
</div>
        
        <div class="modal fade" id="revert_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header --> 
        <div class="modal-header">
          <h5 class='text-danger'>If you delete this receipt,all related transactions will also be deleted. </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form method='post' action='{{url("deleteReceiptInventory")}}' method="post">
      	    @csrf
            <div class="modal-body">
              
                <input type="hidden" id="delete_receipt" name="delete_receipt">
                <h5 >
               Do you still wish to continue?</h5>
            </div>
        
            <div class="modal-footer">
                <button type="button" id="hide_modal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
   <script>
      $( ".delete_row" ).on( "click", function() {
var delete_receipt = $(this).data('id');
$('#delete_receipt').val(delete_receipt);
} );
  </script>
<script>
  $(document).ready(function(){
    $('.toggle-options').click(function(e){
      e.preventDefault(); 
      var $options = $(this).next('.options-buttons');
      $('.options-buttons').not($options).slideUp();
      $options.slideToggle();
    });
    $(document).click(function(event) { 
      var $target = $(event.target);
      if(!$target.closest('.toggle-options').length && !$target.closest('.options-buttons').length) {
        $('.options-buttons').slideUp();
      }        
    });
  });
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