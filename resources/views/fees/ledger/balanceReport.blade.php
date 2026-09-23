@php
  $courses = Helper::getCourses();
  $classType = Helper::classType($search['course_id'] ?? null);
  $allClassType = Helper::classType();
  $batches = Helper::getBatch();
  $getCountry = Helper::getCountry();
  $getSetting = Helper::getSetting();
  $getSession = Helper::getSession();
@endphp
<title>
      Student Balance Report {{date('Y-m-d')}} 
</title>
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
        <h3 class="card-title"><i class="fa fa-rupee"></i> &nbsp;{{ __('Student Balance Report') }}</h3>
        <div class="card-tools">
        <!--<a href="{{url('hostel/collect/fees')}}" class="btn btn-primary  btn-sm" title="Add Fees"><i class="fa fa-plus"></i> Add</a>-->
        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
        </div>
        
        </div>  
            <form id="quickForm" action="{{ url('balanceReport') }}" method="post" >
                @csrf 
                    <div class="row m-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Session</label>
                            <select class="form-control select2" id="session_id" name="session_id">
                                <option value="all" {{ ($search['session_id'] ?? '') == 'all' ? 'selected' : '' }}>All</option>
                                @if(!empty($getSession))
                                    @foreach($getSession as $session)
                                        <option value="{{ $session->id ?? '' }}" {{ ($session->id == ($search['session_id'] ?? Session::get('session_id'))) ? 'selected' : '' }}>{{ $session->from_year ?? ''  }} - {{ $session->to_year ?? ''  }}</option>
                                    @endforeach
                                @endif
                            </select>                 	    
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('Course') }}</label>
                            <select class="form-control select2" id="course_id" name="course_id">
                                <option value="">{{ __('common.Select') }}</option>
                                @if(!empty($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ ($course->id == ($search['course_id'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>{{ __('Class/Semester') }}</label>
                            <select class="form-control select2" id="class_type_id" name="class_type_id">
                                <option value="">{{ __('common.Select') }}</option>
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
                   
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                            <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                        </div>
                    </div>
                    	
                    
                        <div class="col-md-1">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control " id="status" name="status">
						    	<option value="">{{ __('common.Select') }}</option>
						    	@if($search['status'] == null)
								<option value="1"  selected>{{ __('Continue') }}</option>
							<option class='text-danger' value="0">{{ __('Discontinue') }}</option>
								<!-- <option value="3">{{ __('Registration Request') }}</option> -->
							
							@else
								<option value="1"  {{$search['status'] == 1 ? 'selected' : '' }}>{{ __('Continue') }}</option>
							<option class='text-danger' value="0" {{$search['status'] == 0 ? 'selected' : '' }}>{{ __('Discontinue') }}</option>
								<!-- <option value="3"  {{$search['status'] == 3 ? 'selected' : '' }}>{{ __('Registration Request') }}</option> -->
							@endif
						
							
				       </select>
					</div>
				</div>
            		<div class="col-md-3">
            			<div class="form-group"> 
            				<label>{{ __('messages.Search By Keywords') }}</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.Ex. Name, Father Name, Mobile, Email, etc.') }}" value="{{$search['name'] ?? ''}}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1 ">
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
                    <th>{{ __('student.Admission No.') }}</th>
                    <th>{{ __('Student Name') }}</th>
                    <th>{{ __('messages.Fathers Name') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Category ') }}</th>
                    <th>Student Type</th>
                    <th>Course</th>
                    <th>Class</th>
                    <th>Batch</th>
                    <th>{{ __('Status') }}</th>
                  
                    @if(!empty($getSession))
                        @foreach($getSession as $sess)
                            <th>{{ $sess->from_year ?? '' }}-{{ $sess->to_year ?? '' }}</th>
                        @endforeach
                    @endif
                    <th>{{ __('messages.Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_pending = []; // Initialize array for total pending fees per session
                @endphp
        
                @if(!empty($data))
                    @php $i = 1; @endphp
        
                    @foreach ($data as $item)
                        @php
                            $genderName = DB::table('gender')
                                ->whereNull('deleted_at')
                                ->where('id', $item->gender_id)
                                ->first();
                                $className = App\Models\Admission::select('admissions.unique_system_id','admissions.class_type_id','class_types.name as className')
                                                    ->leftJoin('class_types', 'class_types.id', 'admissions.class_type_id')
->where('unique_system_id', $item->unique_system_id)
    ->pluck('className')
    ->implode(',');
                        @endphp
                        
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item['admissionNo'] ?? '' }}</td>
                            <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                            <td>{{ $item['father_name'] ?? '' }}</td>
                            <td>{{ $genderName->name ?? '' }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>{{ $item['student_type'] ?? '' }}</td>
                            <td>{{ $item['course'] ?? '' }}</td>
                            <td>{{ $className ?? '' }}</td>
                            <td>{{ $item['batch'] ?? '' }}</td>
                            <td>
                                @if($item['status'] == 1)
                                    Continue
                                @else
                                    <span class='text-danger'>Discontinue</span>
                                @endif
                            </td>
        
                            @if(!empty($getSession))
                                @foreach($getSession as $sess)
                                    @php
                                        $admission_ids = App\Models\Admission::where('session_id', $sess->id)
                                            ->where('unique_system_id', $item->unique_system_id)
                                            ->pluck('id');  // Get admission IDs as a collection
        
                                        $pending = 0; // Reset pending fees for this session
        
                                        if ($admission_ids->isNotEmpty()) {
                                            foreach ($admission_ids as $admission_id) {
                                                $assign = App\Models\fees\FeesAssignDetail::where('admission_id', $admission_id)
                                                    ->select(
                                                        DB::raw('SUM(fees_group_amount) as fees_group_amount'),
                                                        DB::raw('SUM(discount) as discount')
                                                    )->first();

                                                $paid = DB::table('fees_detail')
                                                    ->where('admission_id', $admission_id)
                                                    ->whereIn('status', [0,1])
                                                    ->whereNull('deleted_at')
                                                    ->select(
                                                        DB::raw('SUM(installment_fine) as total_installment_fine'),
                                                        DB::raw('SUM(discount) as total_discount'),
                                                        DB::raw('SUM(total_amount) as total_amount')
                                                    )
                                                    ->first();
        
                                                $pending += (($assign->fees_group_amount-$assign->discount ?? 0) - ($paid->total_amount ?? 0)) - ($paid->total_discount ?? 0);
                                            }
                                        }
        
                                        // Ensure total_pending is initialized before adding
                                        if (!isset($total_pending[$sess->id])) {
                                            $total_pending[$sess->id] = 0;
                                        }
                                        $total_pending[$sess->id] += $pending;
                                    @endphp
                                    <td>{{ number_format($pending, 2) }}</td> <!-- Display pending fees for each session -->
                                @endforeach
                            @endif
        
                            <td>
                                <a href="{{ url('fees_ledger_print', $item->unique_system_id) }}" target="_blank" class="btn btn-primary btn-xs" title="View Fees Ledger">
                                    <i class="fa fa-bar-chart-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        
            <tfoot>
                <tr>
                    <td colspan="11"></td> <!-- Empty columns for non-session fields -->
                    @if(!empty($getSession))
                        @foreach($getSession as $sess)
                            <td>{{ number_format($total_pending[$sess->id] ?? 0, 2) }}</td>
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
<script>
$(document).ready(function() {
    function updateClassDropdown(classSelect, data) {
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.Select") }}</option>');
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

    $(document).on('change', '#course_id', function() {
        var courseId = $(this).val();
        var classSelect = $('#class_type_id');
        if (courseId) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course_id: courseId },
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
                @foreach($allClassType as $type)
                    defaultClasses.push({ id: "{{ $type->id }}", name: "{{ $type->name }}" });
                @endforeach
            @endif
            updateClassDropdown(classSelect, defaultClasses);
        }
    });
});
</script>
@endsection 