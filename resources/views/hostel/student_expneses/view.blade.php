@php
$allstudents = Helper::allstudents();
@endphp
@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
			    <div class="col-md-12 col-12">
			        <div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-users"></i> &nbsp; {{ __('Hostel Student Expenses View') }}</h3>
							<div class="card-tools"> 
							    <a href="{{url('student_expenses_add')}}" class="btn btn-primary  btn-sm"><i class="fa fa-plus"></i>{{ __('common.Add') }}  </a> 
							    <a href="{{url('hostel_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}  </a> 
							</div>
						</div>
			            
			            <div class="card-body">
			                <div class="row m-2">
			                    <div class="col-md-12 mb-3">
			                        <form action="{{ url('student_expenses') }}" method="post">
			                            @csrf
			                        <div class="row">
			                            <div class="col-md-4">
			                                <div class="form-group">
			                                    <label>Select Student</label>
			                                    <select id="hostelAssignId" name="hostel_assign_id" class="form-control select2">
                                                  <option value="">{{ __('common.Select') }}</option>
                                                  @if(!empty($allstudents))
                                                  @foreach($allstudents as $value)
                                                  <option value="{{ $value->id }}" {{ $value->id == $search['hostel_assign_id'] ? 'selected' : ''  }}>{{ $value->first_name ?? ''}} {{'[Father Name : '}}{{ $value->father_name ?? 'N/A'}}{{' ]'}}</option>
                                                  @endforeach
                                                  @endif
                                                </select>
			                                </div>
			                            </div>
			                            
			                            <div class="col-md-2">
			                                <div class="form-group">
			                                    <label>Payment Status</label>
			                                    <select class="form-control select2" id="payment_status" name="payment_status">
			                                        <option value="">Select</option>
			                                        <option value="1" {{ ("1" == $search['payment_status']) ? 'selected' : '' }}>Paid</option>
			                                        <option value="0" {{ ("0" == $search['payment_status']) ? 'selected' : '' }}>Unpaid</option>
			                                    </select>
			                                </div>
			                            </div>
			                            
			                            <div class="col-md-2">
			                                <div class="form-group">
			                                    <label>Expense Date</label>
			                                    <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ $search['expense_date'] ?? '' }}">
			                                </div>
			                            </div>
			                            
			                            <div class="col-md-2">
			                                <label>&nbsp;</label><br>
			                                <button type="submit" class="btn btn-primary" id="search_data">Search</button>
			                            </div>
			                        </div>
			                        </form>
			                    </div>
                                <div class="col-md-12">
                                    <table id="expence_data" class="table table-bordered">
                                    <thead class="bg-primary">
                                        <tr role="row">
                                            <th><input type="checkbox" id="masterCheckbox"> {{ __('Sr.No.') }}</th> 
                                            <th>{{ __('common.Name') }}</th> 
                                            <th>{{ __('common.Mobile') }}</th>          
                                            <th>{{ __('common.Fathers Name') }}</th>                                           
                                            <th>{{ __('hostel.Assign Date') }}</th>                                           
                                            <th>{{ __('Payment Mode') }}</th>                                           
                                            <th>{{ __('hostel.Expense Name') }}</th>                                           
                                            <th>{{ __('hostel.Expense Amount') }}</th>                                           
                                            <th>{{ __('hostel.Left Amount') }}</th>                                           
                                            <th>{{ __('hostel.Details') }}</th>                                           
                                            <th>{{ __('common.Action') }}</th>                                           
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="student_list_show">
                            
                                        @if(count($data) != 0)
                                        @foreach($data as $key =>$item)
                                        
                                        @if(!empty($item->expense_amount))
                                        <tr data-id="{{$item->id ?? ''}}" class="expence_list">
                                             <td>@if($item->paid_status != 1)<input type="checkbox" class="childCheckbox" data-left_amt="{{ $item->left_amount ?? '' }}" data-expence_id="{{$item->expense_id ?? ''}}">@endif {{$key+1 }}</td>  
                                            <td>{{$item->first_name ?? ''}}</td>
                                            <td>{{$item->mobile ?? ''}}</td>
                                            <td>{{$item->father_name ?? ''}}</td>
                                            <td>{{ date('d-m-Y', strtotime($item['expense_date'])) }}</td>
                                            <td>{{$item->payMode ?? ''}}</td>
                                            <td>{{$item->expense_name ?? ''}}</td>
                                            <td>{{$item->expense_amount ?? ''}}</td>
                                            <td>{{$item->left_amount ?? ''}}</td>
                                            <td class="text-center">
                                                @php
                                                $value = Helper::getExpanceDetails($item->expense_id ?? '');
                                                $i = 1;
                                                @endphp
                                                
                                                <button type="button" class="show_details btn btn-primary btn-xs"
                                                data-data="
                                                    @if(count($value) != 0)
                                                        @foreach($value as $details)
                                                        <tr>
                                                        <td>{{$i++}}</td><td>{{$details->paid_amount ?? ''}}</td> <td>{{date('d-m-Y', strtotime($details['created_at'])) ?? '' }}
                                                        </td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class='text-center'>
                                                        <td colspan='12'>No Data Found</td>
                                                        </tr>
                                                    @endif"
                                                data-toggle="modal" data-target="#detail_paid">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                            <td>
                                                
                                                <button type="button" {{$item->paid_status == 1 ? 'disabled' : ''}} class="btn-xs paid_data btn btn-{{ $item->paid_status == 1 ? 'success' : 'danger'}}" 
                                                            data-id="{{$item->expense_id ?? ''}}"
                                                            data-status="{{$item->paid_status ?? ''}}"
                                                            data-toggle="modal"
                                                            data-expance="{{$item->left_amount ?? ''}}"
                                                            data-target="#myPaidModal">
                                                        {{ $item->paid_status == 1 ? 'Paid' : 'Pay'}}
                                                </button>
                                                @if($item->paid_status != 1)
                                                    <button type="button" data-toggle="modal" data-target="#deleteExpance" class="btn-xs delete_now btn btn-danger mr-2" data-delete_id="{{ $item->expense_id ?? '' }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                               
                                                <a href="{{ url('student_expenses_edit') }}/{{ $item->expense_id }}">
                                                    <button type="button" class="btn-xs btn btn-primary mr-2">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                
                                                 @endif

                                            </td>
                                      </tr>
                                      @endif
                                    @endforeach
                                    <tr class="text-center">
                                        <td colspan="12" class="p-3">
                                            <button class="btn btn-primary" id="all_pay">Pay</button>
                                        </td>
                                    </tr>
                                    @else
                                    <tr class="text-center">
                                        <td colspan="12" class="p-3">
                                            No Data Found
                                        </td>
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



<div class="modal" id="myPaidModal">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">
            <div class="modal-header">
                <h4 class="modal-title text-white">{{__('hostel.Amount To Be Paid') }} :- <i class="fa fa-inr"></i> <span id="expance_amt"></span></h4>
                <button type="button" class="btn-close" data-dismiss="modal" ><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
                <form action="{{url('change_expense_status')}}" method="post">
                      @csrf
                    <div class="modal-body">
                        <input type="hidden" id="paid_status" name="status" />
                        <input type="hidden" id="paid_id" name="paid_id" />
                        <div class="row">
                            <div class="col-md-6">
                            <label class="text-white">{{__('hostel.Amount to Pay') }}</label>
                            <input type="text" required class="form-control amount_to_pay" id="amount_to_pay" name="amount_to_pay" onkeypress="javascript:return isNumber(event)" placeholder="{{__('hostel.Amount to Pay') }}" />
                            </div>
                            <div class="col-md-6">
                            <label class="text-white">{{__('hostel.Left Amount') }}</label>
                            <input type="text" class="form-control" id="paid_amount" name="paid_amount" placeholder="{{__('hostel.Left Amount') }}" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{ __('common.Close') }}</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">{{__('hostel.Save') }}</button>
                    </div>
                </form>
        </div>
    </div>
</div>
<div class="modal" id="deleteExpance">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">
            <div class="modal-header">
                <h4 class="modal-title text-white">{{__('common.Delete Confirmation') }}</h4>
                <button type="button" class="btn-close" data-dismiss="modal" ><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
                <form action="{{url('delete_expence')}}" method="post">
                      @csrf
                    <div class="modal-body">
                        <input type="hidden" id="delete_id" name="delete_id" />
                        <span class="text-white">{{__('common.Are you sure you want to delete') }}?</span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{ __('common.Close') }}</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">{{__('common.Delete') }}</button>
                    </div>
                </form>
        </div>
    </div>
</div>
<div class="modal fade" id="detail_paid">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">{{__('hostel.Expance Details') }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
          <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{__('common.SR.NO') }}</th>
                    <th>{{__('hostel.Paid Amount') }}</th>
                    <th>{{__('common.Date') }}</th>
                  </tr>
                </thead>
                <tbody id="details_expance">
                  
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.paid_data').click(function(){
            var paid_id = $(this).data("id");
            var paid_status = $(this).data("status");
            var expance_amt = $(this).data("expance");
            $("#expance_amt").html(expance_amt);
            $("#paid_id").val(paid_id);
            $("#paid_status").val(paid_status);
        });
        
        $('.amount_to_pay').change(function(){
            var amtToPay = $('#amount_to_pay').val();
            var expance_amt = $('#expance_amt').html();
            var paid_amount = expance_amt-amtToPay;
            if(paid_amount < 0){
             toastr.error('Pay amount should be smalller than total amount')
                
               $('#paid_amount').val("");
               $('#amount_to_pay').val("");
            }else{
               $('#paid_amount').val(paid_amount);
            }
           
        });
        
        $('.show_details').click(function(){
          var data = $(this).data("data");
          $('#details_expance').html(data);
        });
        
        $('.delete_now').click(function(){
          var delete_id = $(this).data("delete_id");
          $('#delete_id').val(delete_id);
        });
    });
</script>

<script>
    $(document).ready(function() {
    $('#all_pay').hide();
    $('.childCheckbox').on("change", function () {
        if ($('.childCheckbox:checked').length > 0) {
            var product = 0;
            $('.childCheckbox:checked').each(function () {
                product += $(this).data('left_amt');
            });
            $('#all_pay').show().text('Pay: ' + product);
        } else {
            $('#all_pay').hide();
            $('#masterCheckbox').prop("checked", false);
        }
    });

    $('#masterCheckbox').on("change", function () {
        $('.childCheckbox').prop("checked", $('#masterCheckbox').prop("checked"));
        $('.childCheckbox').trigger("change");
    });
});

</script>
<script>
/*$(document).ready(function() {
    $('#search_data').click(function(){
        var hostel_id = $('#hostelAssignId').find(':selected').val();
        
        if(hostel_id != ""){
            $('.expence_list').each(function(){
                var hostel_assign_id = $(this).data('id');
                    if(hostel_assign_id == hostel_id){
                       $(this).show();
                    }else{
                       $(this).hide();
                    }
            });
        }else{
            $('.expence_list').show();
        }    
    });
});
*/
</script>

<script>
    $(document).ready(function() {
        $('#all_pay').on("click", function () {
            var checkedChildCheckboxes = $('.childCheckbox:checked');
            var base_url = "{{ url('/') }}";
            var details = [];
            
            checkedChildCheckboxes.each(function () {
                var expence_id = $(this).data('expence_id');
                var leftAmt = $(this).data('left_amt');
                details.push({ expence_id: expence_id, left_amt: leftAmt });
            });
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                type:'post',
                url: base_url + '/expenses_all_pay',
                data: {
                    details:details
                },
                success: function (data) {
                    alert('Amount Paid Successfully');
                    window.location.reload();
                }
            });
        });
    });
</script>

@endsection



















