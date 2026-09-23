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
                                            <th>{{ __('AD NO') }}</th>
                                            <th>{{ __('fees.Student Name') }}</th>
                                            <th>{{ __('common.Fathers Name') }}</th>
                                            <th>{{ __('common.Class') }}</th>
                                            
                                            <th>{{ __('Fees Collect') }}</th>
                                           

                                    </thead>
                                    <tbody id="fees_list_show">

                                        @if(!empty($data)) 
                                        @php $i=1; $total_assign=0; 
                                        $total_collect=0; 
                                      //  dd($data);
                                        @endphp
                                        @foreach ($data as $item)
                                        <tr>

                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item['admissionNo'] ?? '' }}</td>
                                            <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                                            <td>{{ $item['father_name'] ?? '' }}</td>
                                            <td>{{ $item['class_name'] ?? '' }} @if(!empty($item['section_name'])) ({{ $item['section_name'] ?? '' }}) @endif

                                            </td>
                                            <td>{{ $item['total_amount'] ?? 0}}</td>
                                            


                                        </tr>
                                            @php 
                                                $total_assign +=$item['assign_amount']; 
                                                $total_collect +=$item['total_amount']; 
                                            @endphp 
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                               
                                                <td></td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td><b>{{__('Total') }}</b>
                                                </td>

                                                <td><b>{{$total_collect ?? ''}}</b>
                                                </td>
                                                
                                                </td>


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
    </section>
</div>



 
@endsection 