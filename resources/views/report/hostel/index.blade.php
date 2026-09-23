@php
  $classType = Helper::classType();
  $getSession = Helper::getSession();
  $getCounter = Helper::getCounters();
  $getPaymentMode = Helper::getPaymentMode();
    $getHostel = Helper::getHostel();
    $getHostelFloor = Helper::getHostelFloor();
    $getHostelBuildingAll = Helper::getHostelBuildingAll();
    $getHostelRoom = Helper::getHostelRoom();
    $getHostelBed = Helper::getHostelBed();

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
                                            			<label>{{ __('hostel.Select Hostel') }}</label>
                                        				<select class=" form-control" id="hostel_id" name="hostel_id">
                                                            <option value="">{{ __('common.Select') }}</option>
                                                         @if(!empty($getHostel)) 
                                                              @foreach($getHostel as $type)
                                                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['hostel_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                	</div>    
                                                    <div class="col-md-2">
                                            			<label>{{ __('hostel.Select Building') }}</label>
                                        				<select class=" form-control building_id" id="building_id" name="building_id">
                                                            <option value="">{{ __('common.Select') }}</option>
                                                              @if(!empty($getHostelBuildingAll)) 
                                                              @foreach($getHostelBuildingAll as $type)
                                                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['building_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                	</div>  
                                                    <div class="col-md-2">
                                            			<label>{{ __('hostel.Select Floor') }}</label>
                                        				<select class=" form-control floor_id" id="floor_id" name="floor_id">
                                                            <option value="">{{ __('common.Select') }}</option>
                                                              @if(!empty($getHostelFloor)) 
                                                              @foreach($getHostelFloor as $type)
                                                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['floor_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                	</div>   
                                                    <div class="col-md-2">
                                            			<label>{{ __('hostel.Select Room') }}</label>
                                        				<select class=" form-control room_id" id="room_id" name="room_id">
                                                            <option value="">{{ __('common.Select') }}</option>
                                                              @if(!empty($getHostelRoom)) 
                                                              @foreach($getHostelRoom as $type)
                                                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['room_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                              @endforeach
                                                          @endif
                                                        </select>
                                                	</div>  
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
                                                    <div class="col-md-2">
                                                             <div class="form-group">
                                                                <label>{{__('common.Month')}} </label>
                                                                <select class="form-control" id="month_id" name="month_id">
                                                                <option value="">{{__('hostel.Select Month')}}</option>  
                                                                @if(!empty(Helper::getMonth()))
                                                                        @foreach(Helper::getMonth() as $mon)
                                                                       
                                                                        <option value="{{ $mon->id }}"  {{ ($mon->id == $search['month_id']) ? 'selected' : '' }}>  {{ $mon->name ?? ''}}</option>
                                                                        @endforeach
                                                                    @endif  
                                                                </select>
                                                             </div>
                                                          </div>
                                                    <div class="col-md-1 ">
                                                        <label class="text-white">{{ __('Session') }}</label>
                                                        <input type="submit" class="btn btn-primary" name="button_value" value="Search" />
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
                                            <!--<th>{{ __('common.SR.NO') }}</th>-->
                                            <th>{{ __('AD NO') }}</th>
                                            <th>{{ __('fees.Student Name') }}</th>
                                            <th>{{ __('common.Fathers Name') }}</th>
                                            <th>Date</th>
                                            <th>{{ __('Fees Collect') }}</th>
                                           

                                    </thead>
                                    <tbody id="fees_list_show">

                                        @if(!empty($data)) 
                                        @php $i=1; 
                                        $total_assign=0; 
                                        $total_collect=0; 
                                       // dd($data);
                                        @endphp
                                        @foreach ($data as $item)
                                        <tr>

                                            <!--<td>{{ $i++ }}</td>-->
                                            <td>{{ $item['admissionNo'] ?? '' }}</td>
                                            <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                                            <td>{{ $item['father_name'] ?? '' }}</td>
                                            <td>{{ $item['date'] ?? '' }}</td>
                                            <td>{{ $item['total_amount'] ?? 0}}</td>
                                            


                                        </tr>
                                            @php 
                                                $total_collect +=$item['total_amount']; 
                                            @endphp 
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                
                                                <td></td><td></td>
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


<script>
        $('#hostel_id').on('change', function(e){
     var basurl = "{{ url('/') }}";
	var hostel_id = $(this).val();
    $.ajax({
         headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
		  url: basurl+'/hostelData/'+hostel_id,
	  success: function(data){
			$("#building_id").html(data);
	  }
	});
	
});    

$('#building_id').on('change', function(e){
     var basurl = "{{ url('/') }}";
	var building_id = $(this).val();
    $.ajax({
         headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
	 	  url: basurl+'/BuildingData/'+building_id,
	  success: function(data){
			$("#floor_id").html(data);
	  }
	});
	
});
$('#floor_id').on('change', function(e){
     var basurl = "{{ url('/') }}";
	var floor_id = $(this).val();
    $.ajax({
         headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
	 		  url: basurl+'/FloorData/'+floor_id,
	  success: function(data){
			$("#room_id").html(data);
	  }
	});
	
});
$('#room_id').on('change', function(e){
     var basurl = "{{ url('/') }}";
	var room_id = $(this).val();
    $.ajax({
         headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
	 	  url: basurl+'/RoomData/'+room_id,
	  success: function(data){
			$("#bed_id").html(data);
	  }
	});
	
});
    </script>
 
@endsection 