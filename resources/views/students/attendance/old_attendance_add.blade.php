@php
   $classType = Helper::classType();
    $getAttendanceStatus= Helper::getAttendanceStatus();
@endphp
@extends('layout.app') 
@section('content')
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<input type="hidden" id="session_id" value="{{ Session::get('role_id') ?? '' }}">
 <div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
    <div class="card card-outline card-orange">
         <div class="card-header bg-primary">
        <h3 class="card-title"><i class="fa fa-calendar-check-o"></i> &nbsp;{{ __('student.Fill Students Attendance') }}</h3>
        <div class="card-tools">
        <a href="{{url('studentsAttendanceView')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-eye"></i>{{ __('common.View') }}</a>
        <a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
        </div>
        
        </div>         
          @if(count($classType) > 0)
        <form id="quickForm" action="#" method="post" >
            @csrf 
            <div class="row m-2">
                 @if(Session::get('role_id') == 1)
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="State" class="required">{{ __('student.Admission No.') }}</label>
                     <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                  </div>
                </div>
                @endif
                <div class="col-md-2">
            		<div class="form-group">
            			<label>{{ __('common.Class') }}</label>
            			<select class="form-control select2" id="class_type_id" name="class_type_id" >
            			     @if(Session::get('role_id') != 2)
            			<option value="">{{ __('common.Select') }}</option>
            			@endif
                         @if(!empty($classType)) 
                              @foreach($classType as $type)
                                 <option value="{{ $type->id ?? ''  }}" >{{ $type->name ?? ''  }}</option>
                              @endforeach
                          @endif
                        </select>
            	    </div>
            	</div>
            	 @if(Session::get('role_id') == 1)
                <div class="col-md-4">
            		<div class="form-group">
            			<label>{{ __('common.Search By Keywords') }}</label>
            			<input type="text" class="form-control" id="searchName" name="name" placeholder="{{ __('common.Ex. Name, Mobile, Email, Aadhaar etc.') }}" value="{{ $search['name'] ?? '' }}"> 
            	    </div>
            	</div> 
            	@endif
                <div class="col-md-1 ">
                     <label for="" class="text-white">{{ __('common.Search') }}</label>
            	    <button type="button" class="btn btn-primary" onclick="SearchValue()" >{{ __('common.Search') }}</button>
            	</div>
            </div>
        </form>        

 
            <form action="{{ url('studentsAttendanceAdd') }}" method="post">
                @csrf 
                <div class="row m-2">
                	<div class="col-md-2">
                		<div class="form-group">
                			<label class="text-danger">{{ __('common.Date') }}*</label>
                			<input class="form-control @error('date') is-invalid @enderror" type="date" id="date" name="date" value="{{date('Y-m-d')}}">
                              	@error('date')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror            	    
                	    </div>
                	</div> 
                	</div> 
                
           
                	<div class="col-md-12">
             
            	
                
                  <table id="example1" class="table table-bordered table-striped border  dataTable dtr-inline ">
                  <thead>
                  <tr role="row">
                            <th>{{ __('student.Admission No.') }}</th>
                            <th>{{ __('common.Name') }}</th>
                            <th>{{ __('common.Class') }}</th>
                            <th>{{ __('common.Fathers Name') }}</th>
                            <th>{{ __('common.Mobile No.') }}</th>
                            <th>{{ __('student.Attendance') }}</th>
                        </tr>
        
                    </thead>
                    <tbody class="student_list_show">
            
                    </tbody>
                </table>
                </div>
             
                <div class="row m-2">
                    <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary" >{{ __('student.Submit Attendance') }}</button></div>
                </div>
                </div>
            </form>        
            
              @else
                <p class="text-center text-danger mt-2">You are not yet authorized for marking attendance .... please contact your administrator</p>
                  @endif
    </div>
</div>
</div>
</div>
</section>
        
</div>



<script>
    function SearchValue() {
        var name = $('#searchName').val();
        var class_type_id = $('#class_type_id :selected').val();
        var admissionNo = $('#admissionNo').val();
        var URL = "{{ url('/') }}";
        if(class_type_id > 0 || name != '' || admissionNo != ''){
        $.ajax({
                 headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url: URL+'/SearchValueAtten',
            data: {class_type_id:class_type_id,name:name,admissionNo:admissionNo},
            success: function (data) {
                $('.student_list_show').html(data);
            }
          });
        }else{
                toastr.error('Please put a value in minimum one column !');
            }               
    };
    
$( document ).ready(function() {
    var session_id = $('#session_id').val();
    if(session_id != 1){
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('min', today);        
    }
}); 
</script>  
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })

</script>
@endsection 