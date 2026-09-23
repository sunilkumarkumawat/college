@php
  $courses = Helper::getCourses();
  $classType = Helper::classType($search['course'] ?? null);
  $allClassType = Helper::classType();
  $getCountry = Helper::getCountry();
  $getSetting = Helper::getSetting();
  $getSession = Helper::getSession();
  $batches = Helper::getBatch();
@endphp
@extends('layout.app') 
@section('content')

<style>
    
    .padding_table thead tr{
    background: #002c54;
    color:white;
}
    
.padding_table th, .padding_table td{
     padding:0px;
     font-size:14px;
}
</style>

<div class="content-wrapper">

   <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">      
    <div class="card card-outline card-orange">
        <div class="card-header bg-primary">
        <h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp;{{ __('Student Fees Ledger') }}</h3>
        <div class="card-tools">
        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
        </div>
        
        </div>  
            <form id="quickForm" action="{{ url('fees/ledger') }}" method="post" >
                @csrf 
                    <div class="row m-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('Session') }}</label>
                            <select class="form-control select2" id="session_id" name="session_id">
                                <option value="">{{ __('common.All') }}</option>
                                @if(!empty($getSession))
                                    @foreach($getSession as $session)
                                        <option value="{{ $session->id ?? '' }}" {{ ($session->id == ($search['session_id'] ?? '')) ? 'selected' : '' }}>{{ $session->from_year ?? ''  }} - {{ $session->to_year ?? ''  }}</option>
                                    @endforeach
                                @endif
                            </select>                 	    
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                        <label>{{ __('Course') }}</label>
                            <select class="form-control select2" id="course" name="course">
                            <option value="">{{ __('common.Select') }}</option>
                            @if(!empty($courses))
                                @foreach($courses as $course)
                                <option value="{{ $course->name ?? ''  }}"  {{ ($course->name == ($search['course'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? ''  }}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('Class/Semester') }}</label>
                            <select class="form-control select2" id="class_type_id" name="class_type_id">
                                <option value="">{{ __('common.All') }}</option>
                                @if(!empty($classType))
                                    @foreach($classType as $class)
                                        <option value="{{ $class->id ?? '' }}" {{ ($class->id == ($search['class_type_id'] ?? '')) ? 'selected' : '' }}>{{ $class->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>                 	    
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                        <label>{{ __('Batch') }}</label>
                            <select class="form-control select2" id="batch" name="batch">
                                <option value="">{{ __('common.Select') }}</option>
                                @if(!empty($batches))
                                    @foreach($batches as $batch)
                                    <option value="{{ $batch->name ?? ''  }}" {{ ($batch->name == ($search['batch'] ?? '')) ? 'selected' : '' }}>{{ $batch->name ?? ''  }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="State">{{ __('student.Admission No.') }}</label>
                            <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-1">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control " id="status" name="status">
						    	<option value="">{{ __('common.Select') }}</option>
						    	@if(($search['status'] ?? '') == null && ($search['status'] ?? '') !== '0')
								<option value="1"  selected>{{ __('Continue') }}</option>
							<option class='text-danger' value="0">{{ __('Discontinue') }}</option>
							@else
								<option value="1"  {{ ($search['status'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Continue') }}</option>
							<option class='text-danger' value="0" {{ ($search['status'] ?? '') == '0' ? 'selected' : '' }}>{{ __('Discontinue') }}</option>
							@endif
				       </select>
					</div>
				</div>
            		<div class="col-md-2">
            			<div class="form-group"> 
            				<label>{{ __('messages.Search By Keywords') }}</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.Ex. Name, Father Name, Mobile, Email, etc.') }}" value="{{$search['name'] ?? ''}}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1">
                             <label for="" style="color: white;">Search</label>
                    	    <button type="submit" class="btn btn-primary" >{{ __('messages.Search') }}</button>
                    	</div>
                    			
                    </div>
                </form>        

        
    	<div class="row m-2"> 
    	    <div class="col-md-12 head_table text-center"></div>
    	    </div>
    	<div class="row m-2">
		    <div class="col-md-12  " style="overflow-x:auto;">	
        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
          <thead>
          <tr role="row">
            <th>{{ __('messages.Sr.No.') }}</th>
            <!--<th>{{ __('Counter') }}</th>-->
            <th>{{ __('student.Admission No.') }}</th>
            <th>{{ __('Student Name') }}</th>
            <th>{{ __('messages.Fathers Name') }}</th>
            <th>{{ __('Gender') }}</th>
            <th>{{ __('Category ') }}</th>
            <th>Student Type</th>
            <th>Course</th>
            <th>Class</th>
            <th>Session </th>
            <th>Batch  </th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Total Fees') }}</th>
            <th>{{ __('Total Paid Fees') }}</th>
            <th>{{ __('Paid Fine') }}</th>
            <th>Discount</th>
            <th>{{ __('Pending Fees') }}</th>

            @php
             $feesGroups = [];
             if(($search['class_type_id'] ?? '') != '')
                        {
                                $feesGroups = DB::table('fees_master')
                                ->leftJoin('fees_group', 'fees_master.fees_group_id', '=', 'fees_group.id') 
                                ->where('fees_master.session_id', Session::get('session_id'))
                                ->whereNull('fees_master.deleted_at')
                                ->groupBy('fees_master.fees_group_id')
                                ->where('fees_master.class_type_id', $search['class_type_id'] ?? '')
                                ->select('fees_master.*', 'fees_group.name as group_name') 
                                ->get();
                        }
                                            @endphp
                                           @if(!empty($feesGroups))
                                           @foreach($feesGroups as $item)
                                              <th>{{$item->group_name ?? ''}}</th>
                                           @endforeach
                                           @endif

            <th>{{ __('messages.Action') }}</th>
          </thead>
          <tbody>
          @php
                
                   $total_assigned=0;
                   $total_collected=0;
                   $total_discount=0;
                   $total_pending=0;
                   $total_fine=0;
                   
                @endphp

              @if(!empty($data))
                @php
                   $i=1;
                   $feesGroupsAmt = [];               
                @endphp

                @foreach ($data  as $item)
                
                
              
                  @php
                  $genderName = DB::table('gender')->whereNull('deleted_at')->where('id',$item->gender_id)->first();
                  $session = DB::table('sessions')->whereNull('deleted_at')->where('id', $item->session_id ?? '')->first();

                  $assign_discount = $item['assign_discount'] ?? 0;

                  $paid = DB::table('fees_detail')
                                ->where('admission_id', $item->id)
                                ->whereIn('status',[0,1])
                                ->whereNull('deleted_at')
                                ->select(
                                    DB::raw('SUM(installment_fine) as total_installment_fine'),
                                    DB::raw('SUM(discount) as total_discount'),
                                    DB::raw('SUM(total_amount) as total_amount')
                                )
                                ->first();
                $fees_counters = DB::table('fees_counters')->where('id', $item->fees_counter_id)->whereNull('deleted_at')->first();

                 // dd($paid);
                  $total_assigned += ($item['total_amount']-$assign_discount ?? 0);
                   $total_collected += ($paid->total_amount ?? 0);
                   $total_discount += ($paid->total_discount ?? 0);
                   $total_fine += $paid->total_installment_fine ?? 0;
                   $total_pending += (($item['total_amount']-$assign_discount ?? 0)-($paid->total_amount ?? 0))-($paid->total_discount ?? 0);
              
                @endphp
                <tr>
                    <td>{{ $i++ }}</td>
                    <!--<td>{{ $fees_counters->name ?? ''  }}</td>-->
                    <td>{{ $item['admissionNo'] ?? ''  }}</td>
                    <td>{{ $item['first_name'] ?? ''  }} {{ $item['last_name'] ?? ''  }}</td>
                    <td>{{ $item['father_name'] ?? ''  }}</td>
                    <td>{{ $genderName->name ?? '' }}</td>
                    <td>{{ $item['category']  }}</td>
                    <td>{{ $item['student_type'] ?? '' }}</td>
                    <td>{{ $item['course'] ?? '' }}</td>
                    <td>{{ $item['className'] ?? '' }}</td>
                    <td>{{$session->from_year ?? ''}}-{{$session->to_year ?? ''}}</td>
                    <td>{{ $item['batch'] ?? '' }}</td>
                    <td>
                    @if($item['status'] == 1)
                        Continue
                    @else
                       <spam class='text-danger' >Discontinue </spam>
                    @endif
                    </td>
                    <td> {{ number_format($item['total_amount']-$assign_discount,2) ?? '' }}</td>
                    <td> {{ number_format($paid->total_amount ,2) ?? '' }}</td>
                    <td> {{ number_format($paid->total_installment_fine ,2) ?? '' }}</td>
                    <td> {{ number_format($paid->total_discount ,2) ?? '' }}</td>
                    <td> {{ number_format(($item['total_amount']-$assign_discount) - $paid->total_amount ,2)  }}</td>
         


                                           @php
                                     
                                     if(($search['class_type_id'] ?? '') != '')                                    
                                        {
                                            $feesGroups = DB::table('fees_master')
                                                ->leftJoin('fees_group', 'fees_master.fees_group_id', '=', 'fees_group.id') 
                                                ->where('fees_master.session_id', Session::get('session_id'))
                                                ->where('fees_master.branch_id', Session::get('branch_id'))
                                                ->whereNull('fees_master.deleted_at')
                                                ->groupBy('fees_master.fees_group_id')
                                                ->select('fees_master.*', 'fees_group.name as group_name') 
                                                ->where('fees_master.class_type_id', $search['class_type_id'] ?? '')
                                                ->get();
                                            }
                                           
                                            @endphp
                                           
                                           @if(!empty($feesGroups))
                                           @php
                                           $total=0;
                                           
                                           @endphp
                                           @foreach($feesGroups as $item1)
                                          @php 
                                          $fees_assign = App\Models\fees\FeesAssignDetail::
                                          where('fees_group_id', $item1->fees_group_id)->where('admission_id',$item->id)->sum('fees_group_amount');
                                         
                                          $head = DB::table('fees_detail')->where('session_id', Session::get('session_id'))
                                          ->where('admission_id',$item->id)->where('fees_group_id',$item1->fees_group_id)
                                          ->whereIn('status',[0,1])->sum('total_amount');
                                          
                                        
                                          
                                          if(!empty($head)){
                                         
                                          $total = $fees_assign-$head;
                                          }else{
                                          $total = $fees_assign;
                                          }

                                           if (!isset($feesGroupsAmt[$item1->id])) {
                                                                $feesGroupsAmt[$item1->id] = 0;
                                                            }
                                                            $feesGroupsAmt[$item1->id] += $total;
                                                            @endphp
                                         <td>{{$total ?? 0}} </td>
                                           
                                           
                                           @endforeach
                                           
                                           @endif
                   
                    <td>
                    <button type="button" class="btn btn-primary data" data-id="{{ $item->id ?? '' }}" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye"></i></button>
                    <a href="{{url('fees_ledger_print',$item->unique_system_id)}}" target="blank" class="btn btn-primary  btn-xs" title="View Fees Ledger"><i class="fa fa-bar-chart-o"></i></a>

                    </td>
              </tr>
              @endforeach
            @endif
          
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{number_format($total_assigned,2) ?? ''}}</td>
                <td>{{number_format($total_collected,2) ?? ''}}</td>
                <td>{{number_format($total_fine,2) ?? ''}}</td>
                <td>{{number_format($total_discount,2) ?? ''}}</td>
                <td>{{number_format($total_pending,2) ?? ''}}</td>
                
                @php
                //dd($feesGroupsAmt);
                                     $feesGroups = [];
                                     if(($search['class_type_id'] ?? '') != '')                                    
                                        {
                                            $feesGroups = DB::table('fees_master')
                                                ->leftJoin('fees_group', 'fees_master.fees_group_id', '=', 'fees_group.id') 
                                                ->where('fees_master.session_id', Session::get('session_id'))
                                                ->whereNull('fees_master.deleted_at')
                                                ->groupBy('fees_master.fees_group_id')
                                                ->select('fees_master.*', 'fees_group.name as group_name') 
                                                ->where('fees_master.class_type_id', $search['class_type_id'] ?? '')
                                                ->get();
                                            }
                                            
                                            @endphp
                                           
                                           @if(!empty($feesGroups))
                                           @php
                                           $total=0;
                                           @endphp
                                           @foreach($feesGroups as $item1)
                                          
                                           
                                         <td>{{$feesGroupsAmt[$item1->id]  ?? ''}}</td>
                                           
                                           
                                           @endforeach
                                           
                                           @endif
               
                <td></td>
            </tr>
            </tfoot>
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
          $(document).ready(function(){
                $(".data").click(function(){
                    var id = $(this).data("id");
                    var basurl = "{{ url('/') }}";
                    $.ajax({
                            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                        type:'post',
                        url: basurl +'/fees_ledger_view',
                        data: {admission_id:id},
                        dataType: 'json',
                        success: function (response) {
                            //alert(JSON.stringify(response));
                            $(".response").html(response.html);
                        }
                    }); 
                });
        
                
              
   
  });
      </script>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="exampleModalLabel">Ledger History</h5>&nbsp;&nbsp;&nbsp;&nbsp;
       
     
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body response">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
 $(document).ready(function(){

var  total_assigned =  "{{number_format($total_assigned ?? '' ,2) }}";
var  total_collected =  "{{number_format($total_collected ?? '' ,2) }}";
var  total_discount =  "{{number_format($total_discount ?? '',2) }}";
var  total_pending =  "{{number_format($total_pending ?? '' ,2) }}";
var  total_fine =  "{{number_format($total_fine ?? '' ,2) }}";
                 
                 
                
    function updateClassDropdown(classSelect, data) {
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.All") }}</option>');
        if (data && data.length > 0) {
            $.each(data, function(key, val) {
                classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
            });
        }
        if (classSelect.hasClass("select2-hidden-accessible")) {
            classSelect.select2('destroy');
        }
        classSelect.select2();
        classSelect.val('').trigger('change');
    }

    $(document).on('change', '#course', function() {
        var courseName = $(this).val();
        var classSelect = $('#class_type_id');
        if (courseName) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course: courseName },
                dataType: "json",
                success: function(data) {
                    updateClassDropdown(classSelect, data);
                },
                error: function() {
                    updateClassDropdown(classSelect, []);
                }
            });
        } else {
            var defaultClasses = [];
            @if(!empty($allClassType))
                @foreach($allClassType as $class)
                    defaultClasses.push({ id: "{{ $class->id }}", name: "{{ $class->name }}" });
                @endforeach
            @endif
            updateClassDropdown(classSelect, defaultClasses);
        }
    });

$('.head_table').append('<table class="table table-bordered table-striped"><tr><td class="bg-primary">Total Fee</td><td>₹ '+total_assigned+'</td><td class="bg-primary">Total Discount</td><td >₹ '+total_discount+'</td><td class="bg-primary">Total Collected</td><td>₹ '+total_collected+'</td><td class="bg-primary">Total Pending</td><td>₹ '+total_pending+'</td><td class="bg-primary">Total Fine</td><td>₹ '+total_fine+'</td></tr><table>');
    });
</script>
       
<style>
    .label-success-custom {
    border: #47a447 1px solid;
    color: #47a447;
    
}
.btn-print{
        margin: 3px;
    margin-left: 17px;
    font-size: 13px;
}
.label-danger-custom {
    border: #d2322d 1px solid;
    color: #d2322d;
}
th, td{
    white-space: nowrap !important;

}
</style>
@endsection 