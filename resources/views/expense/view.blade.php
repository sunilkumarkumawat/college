@php
    $getHostel = Helper::getHostel();
    $getPermission = Helper::getPermission();
    $getSession = Helper::getSession();
@endphp
@extends('layout.app') 
@section('content')
<style>
    .top{
        margin-top: -12px;
    }
</style>
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-credit-card"></i> &nbsp;{{ __('expense.View Expense') }}</h3>
							
							
							<div class="card-tools"> 
							  <!--<a class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> {{ __('Add Head') }} </a>-->
							    <a href="{{url('expenseAdd')}}" class="btn btn-primary  {{($getPermission->add == 1) ? '' : 'd-none'}} btn-sm"><i class="fa fa-plus"></i>{{ __('common.Add') }}</a> 
							    <!--<a href="{{url('hostel_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back </a>--> 
							</div>
							
						</div>
						<div class="card-body">
                        <form id="quickForm" action="{{ url('expenseView') }}" method="post" >
                        @csrf 
                    <div class="row m-2">
                        <div class="col-md-2 col-6 top">
                            <div class="form-group">
                                <label>{{ __('Session') }}</label>
                                <select class="form-control select2" id="session_id" name="session_id">
                                    <option value="">{{ __('common.All') }}</option>
                                    @if(!empty($getSession))
                                        @foreach($getSession as $s)
                                            <option value="{{ $s->id }}" {{ ($s->id == ($search['session_id'] ?? Session::get('session_id'))) ? 'selected' : '' }}>
                                                {{ $s->from_year }}-{{ $s->to_year }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2 top">
                     		<div class="form-group">
                     			<label>{{ __('expense.From Date') }}</label>
             				    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $search['from_date'] ?? '' }}" >
                            </div>
                     	</div>
                     	<div class="col-md-2 col-6 top">
                            <div class="form-group ">
                                <label>{{ __('expense.To Date') }}</label>
             				    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $search['to_date'] ?? '' }}">
                 			</div> 
                        </div>
             		    <div class="col-md-3 col-6 top">
             			    <div class="form-group">
             				    <label>{{ __('common.Search By Keywords') }}</label>
             				    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('common.Search By Keywords') }}" value="{{ $search['name'] ?? '' }}">
             		        </div>
             		    </div>                     	
                        <div class="col-md-1 col-6 top">
                            <label class="text-white d-block">Search</label>
                     	    <button type="submit" class="btn btn-primary" >{{ __('common.Search') }}</button>
                     	</div>
                    </div>
       </form>
                            <div class="col-md-12" id="">

                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                            <thead class="bg-primary">
                                <tr role="row">
                                    <th>{{ __('common.SR.NO') }}</th>
                                    <th>{{ __('Expense Head') }}</th>
                                    <th>{{ __('Staff/User') }}</th>
                                    <th>{{ __('common.Date') }}</th>
                                    <th>{{ __('expense.Quantity') }}</th>
                                    <th>{{ __('common.Amount') }}</th>
                                    @if($getPermission->edit == 1 || $getPermission->download == 1 || $getPermission->deletes == 1)
                                    <th>{{ __('common.Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @if(!empty($data))
                                @php
                                    $i=1;
                                   $total = 0;
                                @endphp

                                @foreach ($data  as $item)
                               @php
                            $expance = DB::table('expenses')->where('date',$item['date'])->get();
                               @endphp
<!--                                <tr data-bs-toggle="modal" data-bs-target="#Modal_new" class="cursor pointer expanseShow" data-expanse="{{ $expance }}">
-->                                <tr>
                                    <td>{{ $i++ }}</td>
                                    
                                    @php
                                   
                                    $user_name = DB::table('users')->where('id',$item->user_id)->first();
                                    @endphp
                                    <td>{{ $item['name']?? 'Not Mentioned' }} </td>
                                    <td>{{ $user_name->first_name ?? 'Not Mentioned' }} {{ $user_name->last_name ?? '' }} </td>
                                    <td>{{ date('d-m-Y', strtotime($item['date'])) ?? '' }}</td>
                                    <td>{{ $item['quantity'] ?? '' }}</td>
                                    <td id="{{ $item['date'] ?? '' }}">{{ $item['amount'] ?? '' }}</td>
                                    @if($getPermission->edit == 1 || $getPermission->download == 1 || $getPermission->deletes == 1)
                                    <td>
                                        @if($getPermission->download == 1)
                                        <a href="{{ url('expensePrint') }}/{{ $item['id'] }}" target="blank" class="ml-1 btn btn-primary  btn-xs" title="Print Expense" ><i class="fa fa-print"></i></a> 
                                        @endif
                                        @if($getPermission->edit == 1)
                                        <a href="{{ url('expenseEdit') }}/{{ $item['id'] }}" class="btn btn-primary  btn-xs ml-3" title="Edit Expense" ><i class="fa fa-edit"></i></a> 
                                        @endif
                                        @if($getPermission->deletes == 1)
                                        <a href="javascript:;" data-id='{{ $item['id'] ?? '' }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-primary btn-xs ml-1" title="Delete Expense"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>  
                                    @endif
                                </tr>
                               
                               @php
                               $total += $item['amount'] ;
                               @endphp
                                @endforeach
                           
                             
                             <tfoot>
                              
                                  <tr>
                                        <th class="text-white">Total</th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </td>
                                        <th> <b>{{ __('messages.Total Amount') }}</b></th>
                                        <th> <b id="total_amt">₹ {{$total ?? ''}}</b></th>
                                        <!--<th></th>-->
                                        <th></th>   
                                  </tr>    
                              
                               
                            
                               
                            </tfoot>
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

<!--<div class="modal" id="Modal_new">-->
<!--	<div class="modal-dialog">-->
<!--		<div class="modal-content" style="margin-left: -30%;width: 160%;">-->
<!--			<div class="modal-header">-->
<!--			    	<h3>Total Expances</h3>-->
<!--				<h4 class="modal-title text-white"></h4>-->
<!--				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>-->
<!--			</div>-->
		
<!--			    <div class="modal-body">-->
<!--			        <div class="row">-->
<!--			            <div class="col-md-12" id="appendTable"></div>-->
<!--			        </div>-->
<!--			    </div>-->

					  
<!--				<div class="modal-footer">-->
<!--					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>-->
<!--				</div>-->
		
<!--		</div>-->
<!--	</div>-->
<!--</div> -->
<!--</div> -->



















<!-- The Modal -->
<div class="modal" id="Modal_id">
	<div class="modal-dialog">
		<div class="modal-content" style="background: #555b5beb;">
			<div class="modal-header">
				<h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
			<form action="{{ url('expenseDelete') }}" method="post"> 
			    @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('common.Are you sure you want to delete') }}  ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
</div> 


   
<script>
$('.deleteData').click(function() {
	var delete_id = $(this).data('id');
	$('#delete_id').val(delete_id);
});

// $(".expanseShow").click(function(){
//     var expanse = $(this).data('expanse');
//     var tablestart = "<table class='table table-bordered table-striped dataTable dtr-inline'><tr><th>Name</th><th>Name</th><th>Name</th><th>Name</th></tr>";
//     var tableend = "<tr><td></td><td></td><td><b>Total</b></td><td id='sumamt'></td></tr></table>";
//     var tr = "";
//     var sumamt = 0;
//     $.each( expanse, function( key, value ) {
//         tr = tr + "<tr><td>" + value.name + "</td><td>" + value.date + "</td><td>" + value.quantity + "</td><td>" + value.amount + "</td></tr>";
//         sumamt += parseInt(value.amount);
//     });
//     var table = tablestart + tr + tableend;
//     $("#appendTable").html(table);
//     $("#sumamt").html(sumamt);
// })
</script>


@endsection      