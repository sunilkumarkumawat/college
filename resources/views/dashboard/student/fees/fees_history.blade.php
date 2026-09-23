@php
$role = Helper::roleType();
$getPermission = Helper::getPermission();
$actionPermission = Helper::actionPermission();
$getPaymentMode = Helper::getPaymentMode();
@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper fee-history-page">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange fee-card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-money"></i> &nbsp;{{ __('Fees History') }}</h3>
                             <div class="card-tools">
                                 @if(Session::get('role_id') == 3)
                                <a href="{{url('dashboard')}}" class="btn btn-primary  btn-xs "><i class="fa fa-arrow-left"></i> <span class="" >{{ __('Back') }} </span></a>
                                 @endif
                            </div>
                        </div>
                        
                            <section class="content">
                                <div class="container-fluid">
                                    
                                    <div class="row">
                                   <div class="col-md-12">
                                        <div class="listing_tab tabs-custom">
                                            <ul class="nav-tabs">
                                                <li class="get_data active" data-title="fees">
                                                    <a href="#fees">Fees</a>
                                                </li>
                                                <li class="get_data" data-title="payment_history">
                                                    <a href="#payment_history">Payment History</a>
                                                </li>
                                                <li class="get_data" id="onlinePay" data-title="online_pay">
                                                    <a href="#online_pay"> Pay Fees</a>
                                                </li>
                                            </ul>
                                        </div>
                                
                                        <div class="tabData w-100" id="tab_fees" style="display:none;">
                                        <form action="{{ url('fees_history') }}" method="post">
                                        @csrf
                                        <div class="row pt-2">
                                            @if(!empty($sessions))
                                            @foreach($sessions as $stuSession)
                                                <div class="col-md-2 col-4">
                                                    <button type="submit" name="session_id" value="{{ $stuSession->id ?? '' }}" class="btn session-chip @if($stuSession->id == $ActiveSession_id) btn-primary active @else btn-light @endif">{{ $stuSession->from_year ?? '' }} - {{ $stuSession->to_year ?? '' }}</button>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </form>
                                            @php
                                                $hasDueDate = !empty($getFees) && collect($getFees)->contains(function ($fee) {
                                                    return !empty($fee->installment_due_date);
                                                });
                                                
                                                $hasDiscount = false;
                                                $hasFine = false;

                                                if(!empty($getFees)){
                                                    foreach($getFees as $item) {
                                                        if(($item->discount ?? 0) > 0) {
                                                            $hasDiscount = true;
                                                        }
                                                        
                                                        $paidAmount_check = App\Models\FeesDetail::where('fees_type',0)->where('status', 0)
                                                           ->where('admission_id',$item->admission_id)
                                                           ->where('fees_group_id',$item->fees_group_id)
                                                           ->where('session_id',$ActiveSession_id)
                                                           ->sum('total_amount');
                                                        $balance_check  = $item->fees_group_amount - $paidAmount_check - ($item->discount ?? 0);
                                                        
                                                        if(!empty($item->installment_due_date) && $item->installment_due_date > date('Y-m-d')){
                                                            $fine_amt_check = $balance_check/100*($item->installment_fine ?? 0);
                                                            if($fine_amt_check > 0) $hasFine = true;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="card-body pr-0 pl-0">
                                                      <table class="table table-responsive fee-table">
                                                        <thead>
                                                            <tr class="sky_tr">
                                                                <th>#</th>
                                                                <th>Fees Type</th>
                                                                @if($hasDueDate)
                                                                    <th>Due Date</th>
                                                                @endif
                                                                <th>Status</th>
                                                                <th>Amount</th>
                                                                @if($hasDiscount)
                                                                <th>Discount</th>
                                                                @endif
                                                                @if($hasFine)
                                                                <th>Fine</th>
                                                                @endif
                                                                <th>Paid</th>
                                                                <th style="text-align: right;">Balance</th>
                                                            </tr>
                                                        </thead>
    
                                                        <tbody>
                                                            @if(!empty($getFees))
                                                                @php
                                                                    $i = 1;
                                                                    $grand_total = 0;
                                                                    $Paids = 0;
                                                                    $Discount  = 0;
                                                                    $Fine  = 0;
                                                                    $balances = 0;
                                                                    $fine_amt = 0;
                                                                    $pending_approval_total = 0;
                                                                @endphp
                                                                @foreach($getFees as $item) 
                                                                   <tr>
                                                                       @php
                                                                      
                                                                       $pad = App\Models\FeesDetail::where('fees_type',0)->where('status', 0)
                                                                       ->where('admission_id',$item->admission_id)
                                                                       ->where('fees_group_id',$item->fees_group_id)
                                                                       ->where('session_id',$ActiveSession_id)

                                                                       ->sum('total_amount');

                                                                       $pendingFees = App\Models\FeesDetail::where('fees_type',0)->where('status', 1)
                                                                       ->where('admission_id',$item->admission_id)
                                                                       ->where('fees_group_id',$item->fees_group_id)
                                                                       ->where('session_id',$ActiveSession_id)
                                                                       ->count();
                                                                       
                                                                       $pendingFeesAmt = App\Models\FeesDetail::where('fees_type',0)->where('status', 1)
                                                                       ->where('admission_id',$item->admission_id)
                                                                       ->where('fees_group_id',$item->fees_group_id)
                                                                       ->where('session_id',$ActiveSession_id)
                                                                       ->sum('total_amount');
                                                                       
                                                                       $discount = App\Models\FeesDetail::select('fees_detail.*')->where('fees_type',0)->where('admission_id',Session::get('id'))->where('fees_group_id',$item->fees_group_id)
                                                                       ->whereIn('status', [0, 1])
                                                                       ->where('session_id',$ActiveSession_id)->sum('discount');
                                                                      
                                                                       $paidAmount = $pad;
                                                                       $balance  = $item->fees_group_amount - $paidAmount - $item->discount;
                                                                       @endphp
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $item->group_name ?? '' }} </td>
                                                                        @if($hasDueDate)
                                                                            <td>
                                                                                @if(!empty($item->installment_due_date)) 
                                                                                    {{ date('d-M-Y', strtotime($item->installment_due_date)) }}
                                                                                    @php
                                                                                    if($item->installment_due_date > date('Y-m-d')){
                                                                                    $fine_amt = $balance/100*$item->installment_fine;
                                                                                    }
                                                                                    @endphp
                                                                                @endif
                                                                                
                                                                            </td>
                                                                        @endif
                                                                        <td>@if($pendingFees > 0)<span class="label1 label-warning-custom ">Pending Approval</span> @elseif($item->fees_group_amount > $paidAmount )<span class="label1 label-danger-custom ">Unpaid</span> @else <span class="label1 label-success-custom ">Paid</span>  @endif</td>
                                                                        <td>{{ $item->fees_group_amount ?? '0' }}</td>
                                                                        @if($hasDiscount)
                                                                        <td>{{ $item->discount ?? '0' }}</td>
                                                                        @endif
                                                                        @if($hasFine)
                                                                        <td>{{ $fine_amt ?? '0' }}</td>
                                                                        @endif
                                                                        <td>{{$paidAmount ?? '0'}} </td>
                                                                         <td style="text-align: right;">{{$balance ?? ''}}</td>
                                                                         
                                                                         @php
                                                                         $grand_total += $item->fees_group_amount;
                                                                         $Paids += $paidAmount;
                                                                         $Discount  += $item->discount;
                                                                         $Fine  += $fine_amt;
                                                                         $balances += $balance;
                                                                         $pending_approval_total += $pendingFeesAmt;
                                                                         @endphp
                                                                   </tr>
                                                                  
                                                                @endforeach
                                                                @php
                                                                    $colspanCount = 6 + ($hasDueDate ? 1 : 0) + ($hasDiscount ? 1 : 0) + ($hasFine ? 1 : 0);
                                                                @endphp
                                                                <tr>
                                                                    <td colspan="{{ $colspanCount }}">
                                                                        <div class="fee-summary-grid">
                                                                            <div class="fee-summary-item">
                                                                                <span>Grand Total</span>
                                                                                <strong>{{$grand_total ?? ''}}</strong>
                                                                            </div>
                                                                            <div class="fee-summary-item">
                                                                                <span>Paid</span>
                                                                                <strong>{{$Paids ?? ''}}</strong>
                                                                            </div>
                                                                            @if($hasDiscount)
                                                                            <div class="fee-summary-item">
                                                                                <span>Discount</span>
                                                                                <strong>{{$Discount ?? ''}}</strong>
                                                                            </div>
                                                                            @endif
                                                                            @if($hasFine)
                                                                            <div class="fee-summary-item">
                                                                                <span>Fine</span>
                                                                                <strong>{{$Fine ?? ''}}</strong>
                                                                            </div>
                                                                            @endif
                                                                            @if($pending_approval_total > 0)
                                                                            <div class="fee-summary-item pending-approval">
                                                                                <span>Pending Approval</span>
                                                                                <strong>{{$pending_approval_total ?? ''}}</strong>
                                                                            </div>
                                                                            @endif
                                                                            <div class="fee-summary-item balance">
                                                                                <span>Balance</span>
                                                                                <strong>{{$balances ?? ''}}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="balance" value="{{$balances ?? ''}}">
                                                                    </td>
                                                                </tr>
                                                                @else
                                                                @php
                                                                    $colspanCount = 6 + ($hasDueDate ? 1 : 0) + ($hasDiscount ? 1 : 0) + ($hasFine ? 1 : 0);
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td colspan="{{ $colspanCount }}"><b>!! NO DATA FOUND !!</b></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                 
                                                </div>
                                            </div>
                                         <div class="tabData w-100" id="tab_online_pay" style="display:none;">
                                         <div class="container">
                                         
                                        <form id="myForm" action="{{ url('studentSidePaySubmit') }}" method="post">
                                            @csrf

                                            <input  type="hidden" id="admission_id" name="admission_id" value="{{ Session::get('id') ?? '' }}" />
                                            <input  type="hidden" id="advance_payment" name="advance_payment" value="no" />
                                            <input  type="hidden" id="session_id" name="session_id" value="{{ Session::get('session_id') ?? '' }}" />
                                            <input  type="hidden" id="email" name="email" value="{{ Session::get('email') ?? '' }}" />
                                            <input  type="hidden" id="mobile" name="mobile" value="{{ Session::get('mobile') ?? '' }}" />
                                            <input  type="hidden" id="name" name="name" value="{{ Session::get('first_name') ?? '' }}" />
                                            <input  type="hidden" id="class_type_id1" name="class_type_id" value="{{ Session::get('class_type_id') ?? '' }}" />
                                            <input  type="hidden" name="slip_no"  value="{{sprintf('%004s', $BillCounter['counter']+1)  ?? ''}}" >
                                            <input  type="hidden" id="payment_status" name="payment_status" value="1" />

                                                                    <div class="row">
                                                                    <!-- <div class="col-md-6">
                                                                        <label for="feesType">Fees Type <span class="text-danger">*</span></label>
                                                <select class="form-control" id="feesType" required>
                                                <option value="" selected>Select</option>
                                                </select>
                                            </div> -->
                                            
                                            </div>
	                                            <div class="row mt-3">
	                                            <div class="col-md-12 html">
	                                                
	                                            </div>

                                                <div class="col-md-12 d-none" id="pendingApprovalNotice">
                                                    <div class="alert alert-warning mb-2">
                                                        Your fee payment is pending approval. You cannot pay this pending amount again until it is approved or rejected.
                                                    </div>
                                                </div>

                                            

                                            <!-- <div class="col-md-6">
                                                <label for="paymentMethod">Payment Method <span class="text-danger">*</span></label>
                                                <select class="form-control" name="payment_mode_id" id="paymentMethod" required>
                                                <option value="" selected>Select Payment Method</option>
                                                 @if(!empty($getPaymentMode))
                                                @foreach($getPaymentMode as $paymode)
                                                <option value="{{ $paymode->id ?? '' }}" class="{{ in_array($paymode->id ?? '', [3, 4, 5]) ? '' : 'd-none' }}">{{ $paymode->name ?? '' }} </option>
                                                @endforeach
                                                @endif 

                                                <option value="4">Offline</option>
                                                   
                                                        <option value="6">Online</option>
                                                   
                                                </select>
                                            </div> -->

                                                <div class="col-md-12 payment-box d-none mb-4">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="payment-amount-box">
                                                                <span class="payment-box-label">You Are Paying</span>
                                                                <div class="payment-amount-input">
                                                                    <span>₹</span>
                                                                    <input type="tel" class="payment-input" name="amount" id="amount" oninput="validateAmount(this)" placeholder="0.00" value="{{ $balances ?? '0' }}" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-8">
                                                            <div class="payment-method-box">
                                                                <label class="payment-box-label mb-2">Choose Payment Method</label>
                                                                <div class="payment-method-options">
                                                                    <div class="icheck-warning d-inline payment-method-option">
                                                                        <input class="paymentMode" type="radio" name="payment_mode_id" id="offline" value="4" required>
                                                                        <label for="offline"><i class="fa fa-university"></i> Offline</label>
                                                                    </div>
                                                            
                                                                    <div class="icheck-success d-inline payment-method-option">
                                                                        <input class="paymentMode" type="radio" name="payment_mode_id" id="online" value="6"  required>
                                                                        <label for="online"><i class="fa fa-credit-card"></i> Online</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 offlineInput d-none">
                                                            <div class="form-group">
                                                                <label for="account_holder">Account Holder <span class="text-danger">*</span></label>
                                                                <input class="form-control payment-input" type="text" id="account_holder" name="account_holder" placeholder="Account Holder">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 offlineInput d-none">
                                                            <div class="form-group">
                                                                <label for="transaction_id">UTR No./Transaction Id <span class="text-danger">*</span></label>
                                                                <input class="form-control payment-input" type="text" id="transaction_id" name="transaction_id" placeholder="UTR No./ Transaction Id">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 offlineInput d-none">
                                                            <div class="form-group">
                                                                <label for="payment_receipt">Payment Slip <span class="text-danger">*</span></label>
                                                                <input class="form-control-file payment-input" type="file" id="payment_receipt" name="payment_receipt" accept="image/*,application/pdf">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-right pt-3">
                                                            <button type="submit" class="pay-btn btn-submit">
                                                                <i class="fa fa-money"></i> Pay Fees Now
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </form>
                                           
                                                <div class="row m-2 d-none" id="noRemaining">
                                                    <div class="col-md-12 text-center">!! NO REMAINING FEES FOUND !!</div>
                                                </div>
                                            
                                        </div>

                                     
                                      
                                        </div>
                                        <div class="tabData w-100" id="tab_payment_history" style="display:none;">
                                            @php
                                                $hasPaidDiscount = false;
                                                $hasPaidFine = false;
                                                if(!empty($getPaidFees)){
                                                    foreach($getPaidFees as $item2) {
                                                        if(($item2->discount ?? 0) > 0) $hasPaidDiscount = true;
                                                        if(($item2->total_fine ?? 0) > 0) $hasPaidFine = true;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="card-body pr-0 pl-0">
                                                      <table class="table table-responsive fee-table">
                                                        <thead>
                                                            <tr class="sky_tr">
                                                                <th>#</th>
                                                                <th>Invoice No</th>
                                                                <th>Fees Type</th>
                                                                <th>Date</th>
                                                                <th>Method</th>
                                                                @if($hasPaidDiscount)
                                                                <th>Discount</th>
                                                                @endif
                                                                @if($hasPaidFine)
                                                                <th>Fine</th>
                                                                @endif
                                                                <th>Amount</th>
                                                                <th>Payment Status</th>
                                                            </tr>
                                                        </thead>
    
                                                        <tbody>
                                                            @if(!empty($getPaidFees))
                                                            @php
                                                                $i = 1;
                                                                
                                                            @endphp
                                                                @foreach($getPaidFees as $item2)
                                                                   <tr>
                                                                       @php
                                                                            $fee_detail_id = explode(',',$item2->fees_details_id);
                                                                           $head_names = '';
                               
                                                                            $head_names = DB::table('fees_detail')
                                                                                ->leftJoin('fees_group', 'fees_detail.fees_group_id', '=', 'fees_group.id')
                                                                                ->whereIn('fees_detail.id', $fee_detail_id)
                                                                                ->whereNull('fees_detail.deleted_at')
                                                                                ->pluck('fees_group.name') 
                                                                                ->implode(',');        
                                                                     
                                                                       @endphp
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>
                                                                            @if($item2->status == 0)
                                                                                <form target='_blank'action="{{ url('printFeesInvoice') }}" method="post">
                                                                                     @csrf
                                                                                     
                                                                                     <input type='hidden' name='fees_details_invoice_id' value='{{$item2->id}}' />
                                                                                     <button class='btn btn-xs btn-primary'>
                                                                                    {{ $item2->invoice_no ?? '' }}
                                                                                    
                                                                                    </button>
                                                                                    
                                                                                </form>
                                                                            @elseif($item2->status == 1)
                                                                                <button class='btn btn-xs btn-warning' disabled>
                                                                                    {{ $item2->invoice_no ?? '' }}
                                                                                    
                                                                                    </button>
                                                                            @else
                                                                               
                                                                            @endif
                                                                               
                                                                            </td>
                                                                        <td>{{ $head_names ?? '' }}</td>
                                                                        <td>
                                                                            @if(!empty($item2->payment_date)) 
                                                                                {{ date('d-M-Y', strtotime($item2->payment_date)) }}
                                                                            @endif
                                                                            
                                                                        </td>
                                                                        <td>{{$item2->payment_mode ?? ''}}</td>
                                                                        @if($hasPaidDiscount)
                                                                        <td>{{ $item2->discount ?? '0' }}</td>
                                                                        @endif
                                                                        @if($hasPaidFine)
                                                                        <td>{{ $item2->total_fine ?? '0' }}</td>
                                                                        @endif
                                                                        <td>{{ $item2->amount ?? '0' }}</td>
                                                                        <td>
                                                                            @if($item2->status == 0)
                                                                                <span style="color: green;">Received</span>
                                                                            @elseif($item2->status == 1)
                                                                                <span style="color: #fd7e14;">Pending Approval</span>
                                                                            @else
                                                                               <span style="color: red;">Cancelled</span>
                                                                            @endif
                                                                        </td>
                                                                                                                                                 
                                                                   </tr>
                                                                  
                                                                @endforeach
                                                               
                                                                @else
                                                                @php
                                                                    $colspanPaidCount = 7 + ($hasPaidDiscount ? 1 : 0) + ($hasPaidFine ? 1 : 0);
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td colspan="{{ $colspanPaidCount }}"><b>!! NO DATA FOUND !!</b></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                 
                                                </div>
                                            </div>
                                           
                                      
                                </div>
                                </div>
                                </div>
                             </div>
                            </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Loading screen modal -->
<div class="modal" id="loadingModal" style="background:#000000ba" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="w-100">
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only text-white">Paying fees please wait...</span>
        </div>
        <p class="mt-2 text-white">‼️ Paying fees please wait... ‼️ </p>
        <p class="text-white">⚠️ Please do not hit refresh or back button or close this window. </p>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        var length = $('.get_data').length;
        for(var i= 0; i < length; i++){
            var title = $('.get_data').eq(0).data('title');
            $('.get_data').eq(0).addClass('active');
        }
        
        $('#tab_' + title).show();
        
        $('.get_data').click(function(){
            var title = $(this).data('title');
            $('.tabData').hide();
            $('.get_data').removeClass('active');
            
            $(this).addClass('active');
            $('#tab_' + title).show();
        }); 

        if ($(window).width() >= 768) { 
            $("table").removeClass("table-responsive");
        }
    });

</script>




<script>

let allowRefresh = false;

$(document).ready(function() {

    var payable_amount = 0;
    
    $('#onlinePay').on('click', function(event) {
        var amount = Number($('#amount').val());
        var balance = Number($('#balance').val());
        var onlinePayBtn = $("#onlinePay");
        payable_amount = amount;
        if(balance >= amount){
        $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('fees_check') }}",  // Replace with your actual route
                    method: 'POST',
                    data: {
                        amount: amount,
                    },
                    beforeSend: function () {
                        onlinePayBtn.prop("disabled", true).html('<a href="#online_pay"><i class="fa fa-spinner fa-spin"></i> Pay Fees</a>');
                        $(".error, .alert").remove(); // Clear old messages
                            $(".is-invalid").removeClass('is-invalid');
                    },
                    success: function(response) {
                       $('.html').html(response.data);
                        $('#amount').val(response.payable);
                        onlinePayBtn.prop("disabled", false).html('<a href="#online_pay"> Pay Fees</a>');
                        if(Number(response.payable) === 0 && Number(response.pending_approval) === 0){
                            $('#myForm,.payment-box').addClass('d-none');
                            $('#pendingApprovalNotice').addClass('d-none');
                            $('#noRemaining').removeClass('d-none');
                        }else if(Number(response.payable) === 0 && Number(response.pending_approval) > 0){
                            $('#myForm').removeClass('d-none');
                            $('.payment-box').addClass('d-none');
                            $('#pendingApprovalNotice').removeClass('d-none');
                            $('#noRemaining').addClass('d-none');
                        }else{
                            $('#myForm,.payment-box').removeClass('d-none');
                            $('#pendingApprovalNotice').addClass('d-none');
                            $('#noRemaining').addClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        onlinePayBtn.prop("disabled", false).html('<a href="#online_pay">  Pay Fees</a>');
                        console.log('An error occurred:', xhr);
                    }
                }); 
            }else{
                //toastr.error('Amount cannot be greater than total pending.' + balance);

	                Number($('#amount').val(''));
	                $('.html').html('');
	                $('#pendingApprovalNotice').addClass('d-none');
	            }
    });

    $(document).on('click', '.partial_checkbox', function(){
        
        var partial_checkbox_id = $(this).attr('id');
        var payableElement = $('.html').find('#payable_' + partial_checkbox_id);
        var this_pay = $(this).data('pay');
        var this_id = $(this).data('id');
        payableElement.find('.main-amount').toggleClass('line-through', this.checked);

        // Append or remove '5000' separately
        if (this.checked) {
            if (payableElement.find('.extra-amount').length === 0) {
                payableElement.append(' <span class="extra-amount">' + Math.round(this_pay/2) + '</span>');
                $('.html').find('#selected_head_amount_' + this_id).val(Math.round(this_pay/2));
                payable_amount = payable_amount - this_pay/2;
            }
        } else {
            payableElement.find('.extra-amount').remove();
            $('.html').find('#selected_head_amount_' + this_id).val(this_pay);
            payable_amount = payable_amount + this_pay/2;
        }
        
        $('#amount').val(Math.round(payable_amount));

        checkUnselected();
        //$('.html').find('#total_payable').append(' <span class="">' + payable_amount + '</span>');
    });

    function checkUnselected() {
        if ($('.partial_checkbox:checked').length === 0) {
            $('.html').find('#total_payable').removeClass('line-through');
            $('.html').find('#total_payable_text').html('');
        }else{
            $('.html').find('#total_payable').addClass('line-through');
            $('.html').find('#total_payable_text').html(Math.round(payable_amount));
        }
    }

    $("#myForm").submit(function(event){
       
       event.preventDefault();
        var $form = $(this);
        var btn = $form.find(".btn-submit");
   $('#loadingModal').modal('show');
   $('.collect_btn_hide').hide();
    var buttonValue = $('.collect_btn').val(); 
       var formData = new FormData($('#myForm')[0]); // Get all form data, including files

       var paymentModeId = formData.get('payment_mode_id');

       
       //alert('Payment Done');
   
        $.ajax({
           headers: {
               'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
           },
           type: 'post',
           url: "{{ url('studentSidePaySubmit') }}",
           data: formData,
           processData: false,  // Important: Don't process the data
           contentType: false,  // Important: Set content type to false, letting jQuery assign it
           beforeSend: function () {
                btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ' + btn.text()).addClass('d-none');
            },
           success: function(data) {
               if(data.status == true)
               {

                    if(paymentModeId == 6){

                        let newTab = window.open("", "_blank"); // Open new blank tab
                        var name = "{{ Session::get('first_name') }}";
                        var email = "{{ Session::get('email') }}";
                        var requestAmount = $('#amount').val();
                        var invoiceId = data.invoiceId;
                        fetch("{{ url('payuPaymentInitiate') }}", { // Fetch Laravel route
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Content-Type": "application/json" // Ensures JSON format
                            },
                            method: "POST",
                            body: JSON.stringify({invoiceId:invoiceId, amount: requestAmount, name: name, email: email})
                        })
                        .then(response => response.text()) // Get response as text (HTML content)
                        .then(html => {
                            if (newTab) { // Check if newTab was successfully opened
                                newTab.document.open();
                                newTab.document.write(html); // Write content to new tab
                                newTab.document.close();

                                

                                 // Start monitoring if the tab is closed
                                let checkTab = setInterval(() => {
                                    if (newTab.closed) {
                                        clearInterval(checkTab);
                                                                                
                                        checkTransactionStatus(invoiceId, requestAmount);
                                        
                                        $('#loadingModal').modal('hide');
                                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');

                                    }
                                }, 500); // Check every 500ms

                                
                                //toastr.success('Fee History Ccreated');
                                window.onbeforeunload = function () {
                                    if (!allowRefresh) {
                                        return "Are you sure you want to cancel the payment?";
                                    }
                                };
                               
                            } else {
                                alert("Popup blocked! Please allow popups for this site.");
                            }
                        })
                        .catch(error => {
                            if (newTab) newTab.close();
                            console.error("Error loading payment page:", error);
                        });

                    }else{
                        $('#loadingModal').modal('hide');
                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
                        toastr.success('Fee Collected Successfully');
                        window.location.href = 'fees_history';
                    }
                                    
               }
               else
               {
                btn.prop("disabled", false).text(btn.text());
                   $('#loadingModal').modal('hide');
                   toastr.error('Something Went Wrong');
                   btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
               }
           },
           error: function (xhr) {
               
                    var errorMessage = xhr.responseJSON?.message || "An unexpected error occurred.";
                    toastr.error(errorMessage);

                btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
            },
       });
     });

    
    function checkTransactionStatus(invoiceId, requestAmount) {
        fetch("{{ url('checkTransactionStatus') }}/" + invoiceId, {
            method: "GET"
        })
        .then(response => response.json()) 
        .then(data => {

            console.log("Payment status:", data.message); 
            if(data.status == 1){
                fetch("{{ url('payUCancel') }}/" + invoiceId, {
                    method: "GET"
                })
                .then(response => {
                    showPhonePeModal("failed", 0);
                })
                .catch(error => console.error("Error:", error));
            }else if(data.status == 2){
                showPhonePeModal("failed", 0);
            }else if(data.status == 0){
                showPhonePeModal("success", requestAmount);
            }else{
                alert(data.message);
            }
            
        })
        .catch(error => console.error("Error:", error));
    }

     $('.paymentMode').change(function(){
        
        var paymentMethodVal = $(this).val();
        if(paymentMethodVal == 4){
            $('.offlineInput').removeClass('d-none');
            $('#account_holder,#transaction_id,#payment_receipt').attr('required', true);
        }else{
            //alert('Online Payment is Under Testing Phase till Avoid using Online Payment');
            $('.offlineInput').addClass('d-none');
            $('#account_holder,#transaction_id,#payment_receipt').attr('required', false);
        }
     });

     

    function showPhonePeModal(status, amount) {
        let modalHtml = `
            <div class="phonepe-modal" id="transactionResultModal">
                <div class="modal-box ${status}">
                    <div class="icon">${status === "success" ? "✅" : "❌"}</div>
                    <h2>${status === "success" ? "Payment Successful!" : "Payment Failed"}</h2>
                    <p>${status === "success" ? `₹${amount} paid successfully` : "Your transaction was unsuccessful."}</p>
                    <button id="transactionResultBtn">OK</button>
                </div>
            </div>`;
        document.body.insertAdjacentHTML("beforeend", modalHtml);
    }

    $(document).on("click", "#transactionResultBtn", function(){
        allowRefresh = true;
        window.location.href = 'fees_history';
        let modal = document.getElementById("transactionResultModal").remove();
    });

    checkPopUps();
    
    function checkPopUps() {

        if (!isSafari()) return;
        
        var newWindow = window.open('', '_blank'); // Try opening a new window

        if (!newWindow || newWindow.closed || typeof newWindow.closed == "undefined") {
            alert("POP-UPS ARE BLOCKED! To enable them:\n\n" + 
                "📱 FOR SAFARI (iPhone/iPad):\n" +
                "1. Open 'Settings'.\n" +
                "2. Scroll down and tap 'Safari'.\n" +
                "3. Find 'Block Pop-ups' under 'General'.\n" +
                "4. Toggle OFF 'Block Pop-ups' (it should turn gray).\n\n"
            );

                window.location.href = 'fees_history';
        } else {
            newWindow.close(); // Close the window if successfully opened
        }
    }

    function isSafari() {
        let ua = navigator.userAgent.toLowerCase();
        return ua.includes("safari") && !ua.includes("chrome"); // Detect Safari but exclude Chrome
    }

});
</script>

<style>
.phonepe-modal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;
    background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;
    backdrop-filter: blur(8px);
}
.modal-box {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white; text-align: center; padding: 20px; border-radius: 15px;
    width: 280px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); animation: slideUp 0.3s;
}
@keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.icon { font-size: 50px; margin: 10px 0; }
button {
    background: #ffcc00; color: #333; border: none; padding: 10px 20px;
    border-radius: 8px; cursor: pointer; font-size: 16px; margin-top: 15px;
}
button:hover { background: #ffdd44; }


.form-group {
    display: flex;
    align-items: center; 
    gap: 10px;
    flex-wrap: wrap; 
}

.table th, .table td {
  padding: 4px 8px;
}
.tabs-custom .nav-tabs {
    position: relative;
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}
.label-success-custom {
    border: #47a447 1px solid;
    color: #47a447;
    
}
.label-danger-custom {
    border: #d2322d 1px solid;
    color: #d2322d;
}
.label-warning-custom {
    border: #f0ad4e 1px solid;
    color: #f0ad4e;
}
.label1 {
     display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}

.tabs-custom .nav-tabs > li {
    position: relative;
    margin-right: 20px;
}

.tabs-custom .nav-tabs > li a {
    text-decoration: none;
  padding: 3px 19px;
  display: inline-block;
  position: relative;
  color: #333;
  font-weight: bold;
  transition: all 250ms ease;
  font-size: 13px;
}

/*.tabs-custom .nav-tabs > li.active a {
    color: #ffbd2e;
}*/
.nav-tabs {
  border-bottom: none;
}
.tabs-custom .nav-tabs > li.active:before {
    content: '';
    height: 4px;
    width: 8px;
    display: block;
    position: absolute;
    bottom: -5px;
    left: 50%;
    border-radius: 0 0 8px 8px;
    transform: translateX(-50%);
    background: #ffbd2e;
}

.tabs-custom .nav-tabs > li.active {
    border-bottom: 2px solid #ffbd2e;
}

    .listing_tab ul{
        padding-left: 0px;
        margin-bottom: 0px;
        list-style: none;
        display: flex;
        align-items: center;
    }
    
    .padding_table td,
    .padding_table th{
        padding: 10px;
    }
    
  
    
    .listing_tab{
        margin: 10px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #c6c6c6;
       
    }
    
    /*.listing_tab ul li{
        background: lightgray;
        padding: 10px;
        margin: 0px 10px;
        border-radius: 4px;
        cursor:pointer;
        font-size:16px;
        font-weight:400;
    }*/
    
   
    
    .listing_tab ul li:first_child{
        margin-left:0px;
    }
    .sky_tr {
  background: #e6e6e659;
  color: black;
}
.line-through {
    text-decoration: line-through; /* Keep the strikethrough */
    color: #a0a0a0; /* Change text color to a subdued gray for better visibility */
}


        .payment-box {
            background: #1e1e1e;
            padding: 25px;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
            text-align: center;
        }
        .payment-box label {
            display: block;
            color: #999;
            font-size: 16px;
            text-align: left;
            margin-bottom: 5px;
        }
        .payment-input {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            border: 2px solid #555;
            background: #222;
            color: #fff;
            outline: none;
        }
        .payment-input:focus {
            border-color: #4caf50;
        }
        .pay-btn {
            position: relative;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background: linear-gradient(45deg, #007BFF, #0056b3);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            outline: none;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.4);
        }

        .pay-btn:hover {
            background: linear-gradient(45deg, #0056b3, #003d82);
            box-shadow: 0px 8px 20px rgba(0, 123, 255, 0.6);
            transform: translateY(-2px);
        }

        .pay-btn:active {
            transform: scale(0.95);
            box-shadow: 0px 3px 10px rgba(0, 123, 255, 0.3);
        }

        /* Ripple Effect */
        .pay-btn::after {
            content: "";
            position: absolute;
            width: 300%;
            height: 300%;
            top: 50%;
            left: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: transform 0.6s ease-out, opacity 0.6s ease-out;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            opacity: 0;
        }

        .pay-btn:active::after {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            transition: 0s;
        }

.fee-history-page .fee-card {
    border-radius: .25rem;
}

.fee-history-page .listing_tab {
    margin: 10px 0 15px;
    padding: 0;
    border-bottom: 1px solid #dee2e6;
}

.fee-history-page .listing_tab ul {
    gap: 2px;
    flex-wrap: wrap;
}

.fee-history-page .tabs-custom .nav-tabs > li {
    margin-right: 0;
}

.fee-history-page .tabs-custom .nav-tabs > li a {
    padding: .5rem .9rem;
    color: #495057;
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    font-weight: 600;
}

.fee-history-page .tabs-custom .nav-tabs > li.active {
    border-bottom: 0;
}

.fee-history-page .tabs-custom .nav-tabs > li.active:before {
    display: none;
}

.fee-history-page .tabs-custom .nav-tabs > li.active a {
    color: #007bff;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.fee-history-page .session-chip {
    width: 100%;
    margin-bottom: .5rem;
    font-weight: 600;
}

.fee-history-page .fee-table {
    display: table;
    width: 100%;
    margin-bottom: 0;
    background-color: #fff;
}

.fee-history-page .fee-table thead th {
    background-color: #f4f6f9;
    border-bottom: 2px solid #dee2e6;
    color: #343a40;
    font-weight: 700;
    white-space: nowrap;
}

.fee-history-page .fee-table tbody td,
.fee-history-page .fee-table tbody th {
    vertical-align: middle;
}

.fee-history-page .fee-table tbody tr:hover td {
    background-color: rgba(0, 123, 255, .04);
}

.fee-history-page .label1 {
    display: inline-block;
    padding: .28rem .5rem;
    border-radius: .2rem;
    font-size: 12px;
    font-weight: 700;
}

.fee-history-page .label-success-custom {
    background-color: #d4edda;
    border-color: #28a745;
    color: #155724;
}

.fee-history-page .label-danger-custom {
    background-color: #f8d7da;
    border-color: #dc3545;
    color: #721c24;
}

.fee-history-page .label-warning-custom {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #856404;
}

.fee-history-page .fee-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: .75rem;
    padding: .5rem 0;
}

.fee-history-page .fee-summary-item {
    padding: .75rem;
    border-left: 3px solid #007bff;
    background-color: #f8f9fa;
}

.fee-history-page .fee-summary-item span {
    display: block;
    color: #6c757d;
    font-size: 12px;
    font-weight: 600;
}

.fee-history-page .fee-summary-item strong {
    display: block;
    margin-top: .15rem;
    color: #343a40;
    font-size: 18px;
}

.fee-history-page .fee-summary-item.balance {
    border-left-color: #ffc107;
}

.fee-history-page .fee-summary-item.balance strong {
    color: #dc3545;
}

.fee-history-page .fee-summary-item.pending-approval {
    border-left-color: #ffc107;
}

.fee-history-page .fee-summary-item.pending-approval strong {
    color: #fd7e14;
}

.fee-history-page #pendingApprovalNotice .alert {
    border-radius: .25rem;
    font-weight: 600;
}

.fee-history-page .payment-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    padding: 1rem;
}

.fee-history-page .payment-input {
    border-radius: .25rem;
    border: 1px solid #ced4da;
    background-color: #fff;
    color: #495057;
    font-size: 14px;
    padding: .375rem .75rem;
}

.fee-history-page .payment-box .form-group {
    display: block;
    margin-bottom: 1rem;
}

.fee-history-page .payment-box label {
    color: #343a40;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
}

.fee-history-page .payment-amount-box,
.fee-history-page .payment-method-box {
    height: 100%;
    margin-bottom: 1rem;
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    background-color: #fff;
}

.fee-history-page .payment-box-label {
    display: block;
    margin-bottom: .35rem;
    color: #6c757d;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
}

.fee-history-page .payment-amount-input {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #007bff;
}

.fee-history-page .payment-amount-input span {
    color: #007bff;
    font-size: 28px;
    font-weight: 700;
}

.fee-history-page .payment-amount-input input {
    width: 100% !important;
    border: 0;
    background: transparent;
    color: #343a40;
    font-size: 30px;
    font-weight: 700;
    padding: .25rem .5rem;
}

.fee-history-page .payment-method-options {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
}

.fee-history-page .payment-method-option {
    min-width: 135px;
    padding: .65rem .85rem;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    background-color: #fff;
}

.fee-history-page .payment-method-option label {
    margin-bottom: 0;
    cursor: pointer;
}

.fee-history-page .payment-method-option i {
    margin-right: .35rem;
}

.fee-history-page .pay-btn {
    border-radius: .25rem;
    background: #007bff;
    box-shadow: none;
    padding: .6rem 1.25rem;
    font-size: 15px;
}

.fee-history-page .pay-btn:hover {
    background: #0069d9;
    box-shadow: none;
}

@media (max-width: 767px) {
    .fee-history-page .fee-table {
        display: block;
        overflow-x: auto;
    }

    .fee-history-page .fee-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .fee-history-page .fee-summary-item.balance {
        grid-column: 1 / -1;
    }
}
</style>

@endsection
