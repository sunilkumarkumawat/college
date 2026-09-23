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
                                <a href="{{url('Fees/add')}}" class="btn btn-primary  btn-sm" title="Add Fees"><i class="fa fa-plus"></i>{{ __('common.Add') }}</a>
                                <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>
                            </div>
                        </div>
                        @include('report/report/search')
                        

               


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
                                        ->where('payment_mode_id', $item->id)->sum('total_amount');
                                            
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