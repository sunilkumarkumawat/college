@php
  $classType = Helper::classType();
  $getSession = Helper::getSession();
  $getCounter = Helper::getCounters();
  $getPaymentMode = Helper::getPaymentMode();


@endphp
@extends('layout.app') 
@section('content')



<div class="content-wrapper">

    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-money"></i> &nbsp;{{ __('fees.Fees Details') }} </h3>
                            <div class="card-tools">
                                <!--<a href="{{url('Fees/add')}}" class="btn btn-primary  btn-sm" title="Add Fees"><i class="fa fa-plus"></i>{{ __('common.Add') }}</a>-->
                                <a href="{{url('reporting_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="tab-content">
                                            <form id="quickForm" action="{{url('hostel_reporting')}}" method="post">
                                                @csrf
                                                <div class="row m-2">
                                                    
                                                    <div class="col-md-2">
                                                		<div class="form-group">
                                                			<label>From Date</label>
                                                                <input type="date" class="form-control " id="starting" name="starting" value="{{$search['starting'] ?? ''}}">                 	    
                                                        </div>
                                                	</div>
                                                	<div class="col-md-2">
                                                        <div class="form-group ">
                                                            <label>To Date</label>
                                                                <input type="date" class="form-control " id="ending" name="ending" value="{{$search['ending'] ?? ''}}">
                                            			</div> 
                                                    </div>
                                                   
                                                    
                                                    
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Payment Mode</label>
                                                            <select class="form-control " id="" name="payment_mode_id">
                                                                <option value="">{{ __('common.Select') }}</option>
                                                                @if(!empty($getPaymentMode)) @foreach($getPaymentMode as $mode)
                                                                <option value="{{ $mode->id ?? ''  }}" {{ ( $mode[ 'id']==$search[ 'payment_mode_id']) ? 'selected' : '' }}>{{ $mode->name ?? '' }} </option>
                                                                @endforeach @endif
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 ">
                                                        <label class="text-white">{{ __('Session') }}</label>
                                                        <input type="submit" class="btn btn-primary" name="button_value" value="Search" />
                                                    </div>
                                                    <div class="col-md-1 ">
                                                     <label class="text-white">{{ __('Session') }}</label>
                                                        <input type="submit" class="btn btn-primary" name="PaymentMode" value="Pay Mode" />
                                                    </div>
                                                    <div class="col-md-1 ">
                                                         <label class="text-white">{{ __('Session') }}</label>
                                                        <input type="submit" class="btn btn-primary" name="pending_fees" value="Pending Fees" />
                                                    </div>
                                                </div>
                            
                                            </form>
                                    </div>
                            
                                </div>
                            </div>
                        

               


                        <div class="row mb-2 m-2">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                                    <thead>
                                        <tr role="row">
                                            <th>{{ __('common.SR.NO') }}</th>
                                           
                                            <th>Name</th>
                                           
                                            <th>{{ __('Fees Collect') }}</th>
                                           

                                    </thead>
                                    <tbody id="fees_list_show">

                                        @if(!empty($getPaymentMode)) 
                                        @php $i=1; 
                                        @endphp
                                        @foreach ($getPaymentMode as $item)
                                        @php
                                        $total_amount = DB::table('fees_detail')
                                        ->where('payment_mode_id', $item->id)->where('fees_detail.fees_type',1)->sum('total_amount');
                                            
                                        @endphp
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                             <td>{{ $item->name ?? '' }}</td>
                                            <td>{{ $total_amount ?? 0}}</td>
                                        </tr>
                                          
                                        @endforeach
                                        

                                        @endif
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



 
@endsection 