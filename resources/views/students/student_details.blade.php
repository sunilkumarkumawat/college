@php
   $classType = Helper::classType();
    $getAttendanceStatus= Helper::getAttendanceStatus();
    $getgenders = Helper::getgender();
    $getState = Helper::getState();
    $getCity = Helper::getCity();
    $getCountry = Helper::getCountry();
    
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
        <h3 class="card-title"><i class="fa fa-calendar-check-o"></i> &nbsp;{{ __('student.Student Details') }}</h3>
        <div class="card-tools">
        <a onclick="history.back()" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
        </div>
        
        </div>         
        <form id="quickForm" action="{{url('student_details')}}" method="post" >
            @csrf 
            <div class="row m-2">
                <!--<div class="col-md-2">
                  <div class="form-group">
                    <label for="State" class="required">Admission No.</label>
                     <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="Admission No." value="{{ $search['admissionNo'] ?? '' }}">
                  </div>
                </div>-->
                <div class="col-md-2">
            		<div class="form-group">
            			<label>{{ __('common.Class') }}</label>
            			<select class="form-control select2" id="class_type_id" name="class_type_id" >
            			<option value="">{{ __('common.Select') }}</option>
                         @if(!empty($classType)) 
                              @foreach($classType as $type)
                                 <option value="{{ $type->id ?? ''  }}" {{$search['class_type_id'] == $type->id ? 'selected' : ''}}>{{ $type->name ?? ''  }}</option>
                              @endforeach
                          @endif
                        </select>
            	    </div>
            	</div>
               <!-- <div class="col-md-4">
            		<div class="form-group">
            			<label>{{ __('messages.Search By Keywords') }}</label>
            			<input type="text" class="form-control" id="searchName" name="name" placeholder="{{ __('messages.Ex. Student Name, Father/ Mother Name, Mobile etc.') }}" value="{{ $search['name'] ?? '' }}"> 
            	    </div>
            	</div> -->
                <div class="col-md-1 ">
                     <label for="" class="text-white">{{ __('common.Search') }}</label>
            	    <button type="submit" class="btn btn-primary">{{ __('common.Search') }}</button>
            	</div>
            </div>
        </form>        

                	<div class="col-md-12" style="overflow:scroll !important">

                  <table  class="table table-bordered table-striped border  dataTable dtr-inline text-nowrap">
                  <thead>
                  <tr role="row">
                            <th>{{ __('common.SR.NO') }}</th>
                            <th>{{ __('student.Img') }}</th>
                            <th>{{ __('student.Admission No.') }}</th>
                            <th>{{ __('common.First Name') }}</th>
                            <th>{{ __('common.Last Name') }}</th>
                            <th>{{ __('common.Class') }}</th>
                            <th>{{ __('common.DOB') }}</th>
                            <th>{{ __('common.Gender') }}</th>
                            <th>{{ __('common.Email') }}</th>
                            <th>{{ __('student.Username') }}</th>
                            <th>{{ __('common.Password') }}</th>
                            <th>{{ __('common.Mobile') }}</th>
                            <th>{{ __('student.Father Img') }}</th>
                            <th>{{ __('common.Fathers Name') }}</th>
                            <th>{{ __('student.Father Mob.') }}</th>
                            <th>{{ __('student.Mother Img') }}</th>
                            <th>{{ __('common.Mothers Name') }}</th>
                            <th>{{ __('student.Adhar') }}</th>
                            <!--<th>{{ __('RollNo') }}</th>-->
                            <th>{{ __('common.Address') }}</th>
                            <th>{{ __('common.Country') }}</th> 
                            <th>{{ __('common.State') }}</th> 
                            <th>{{ __('common.City') }}</th> 
                            <th>{{ __('common.Village City') }}</th> 
                            <th>{{ __('common.Pincode') }}</th> 
                            <th>{{ __('student.Admission Type') }}</th> 
                            <th>{{ __('student.Admission Date') }}</th> 
                            <th>{{ __('student.Remark') }} </th> 
                           
                            <!--<th>{{ __('messages.Action') }}</th>-->
                        </tr>
        
                    </thead>
                    <tbody class="student_list_show">
           
<form action="{{url('multiAdmissionEdit')}}" method="post" enctype='multipart/form-data'>
@if(!empty($data))

    @csrf
    @if($data->count() > 0)
            @php
               $i=1
            @endphp
            @foreach ($data  as $key=>$item)
            
            <tr>
                <td>{{ $i++ }}</td>
                <td><img src=" {{ !empty($item['image']) ? env('IMAGE_SHOW_PATH').'profile/'.$item['image'] :  env('IMAGE_SHOW_PATH').'default/user_image.jpg'}}" width="50px" height="50px" /> <input type="file" name="student_img[]"  /></td>
                <td><input type="text" class="form-control" name="admissionNo[]" value="{{ $item['admissionNo'] ?? '' }}" readonly/>
                <input type="hidden" class="form-control" name="admission_id[]" value="{{ $item['id'] ?? '' }}" readonly/></td>
                <td><input type="text" name="first_name[]" value="{{ $item['first_name'] ?? '' }}" /></td>
                <td><input type="text" name="last_name[]" value="{{ $item['last_name'] ?? '' }}" /></td>
                <td>	<select class="form-control select2 class_type_id class_type_id_{{$key}}" data-id="{{$key}}" name="class_type_id[]" >
            			<option value="">{{ __('messages.Select') }}</option>
                         @if(!empty($classType)) 
                              @foreach($classType as $type)
                                 <option value="{{ $type->id ?? ''  }}" {{$item['class_type_id'] == $type->id ? 'selected' : ''}} >{{ $type->name ?? ''  }}</option>
                              @endforeach
                          @endif
                        </select>
                        </td>
                        <td><input type="date" name="dob[]" value="{{ $item['dob'] ?? '' }}" /></td>
                        <td>
                        	<select class="form-control invalid" id="gender_id" name="gender_id[]">
											<option value="">{{ __('messages.Select') }}</option>
											@if(!empty($getgenders))
											@foreach($getgenders as $value)
											<option value="{{ $value->id}}" {{ ($value->id == $item['gender_id']) ? 'selected' : '' }}>{{ $value->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
                        
                        </td>
                        <td><input type="text" name="email[]" value="{{ $item['email'] ?? '' }}" /></td>
                        <td>{{ $item['userName'] ?? '' }}</td>
                        <td>{{ $item['confirm_password'] ?? '' }}</td>
                        <td><input type="text" name="mobile[]" maxlength="10" onkeypress="javascript:return isNumber(event)" value="{{ $item['mobile'] ?? '' }}" /></td>
                       <td>
                           
                           <img src="{{ !empty($item['father_img']) ? env('IMAGE_SHOW_PATH').'father_image/'.$item['father_img'] :  env('IMAGE_SHOW_PATH').'default/user_image.jpg'}}" width="50px" height="50px" /> <input type="file" name="father_img[]"  /></td>
                        <td><input type="text" name="father_name[]" value="{{ $item['father_name'] ?? '' }}" /></td>
                        <td><input type="text" name="father_mobile[]" maxlength="10" onkeypress="javascript:return isNumber(event)" value="{{ $item['father_mobile'] ?? '' }}" /></td>
                         <td><img src="{{ !empty($item['mother_img']) ? env('IMAGE_SHOW_PATH').'mother_image/'.$item['mother_img'] :  env('IMAGE_SHOW_PATH').'default/user_image.jpg'}}" width="50px" height="50px" /> <input type="file" name="mother_img[]"  /></td>
                        <td><input type="text" name="mother_name[]" value="{{ $item['mother_name'] ?? '' }}" /></td>
                        <td><input type="text" name="aadhaar[]" onkeypress="javascript:return isNumber(event)" value="{{ $item['aadhaar'] ?? '' }}" /></td>
                        <!--<td><input type="text" name="roll_no[]" onkeypress="javascript:return isNumber(event)"value="{{ $item['roll_no'] ?? '' }}" /></td>-->
                        <td><textarea type="text" name="address[]"  >{{ $item['address'] ?? '' }}</textarea></td>
                        <td>
                            
                            		<select class="form-control country_id" data-id="{{$key}}" name="country[]" >
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getCountry))
											@foreach($getCountry as $country)
											<option value="{{ $country->id ?? ''  }}" {{ ($country->id == $item['country_id']) ? 'selected' : '' }}>{{ $country->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
                        </td>
                        <td>
                            
                            		<select class="form-control state_id state_id_{{$key}} " data-id={{$key}} name="state[]">
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getState))
											@foreach($getState as $state)
											<option value="{{ $state->id ?? ''}}" {{ ($state->id == $item['state_id']) ? 'selected' : '' }}>{{ $state->name ?? ''}}</option>
											@endforeach
											@endif
										</select>
                        </td>
                        <td>
                            
                            	<select class="form-control city_id_{{$key}} " name="city[]" >
											<option value="">{{ __('common.Select') }}</option>
											@if(!empty($getCity))
											@foreach($getCity as $cities)
											<option value="{{ $cities->id ?? ''  }}" {{ ($cities->id == $item['city_id']) ? 'selected' : '' }}>{{ $cities->name ?? ''  }}</option>
											@endforeach
											@endif
										</select>
                        </td>
                         <td><input type="text" name="village_city[]" value="{{ $item['village_city'] ?? '' }}" /></td>
                         <td><input type="text" name="pincode[]" maxlength="6" onkeypress="javascript:return isNumber(event)" value="{{ $item['pincode'] ?? '' }}" /></td>
                        <td>
                             
                            
                            <select class="form-control invalid" id="admission_type_id" name="admission_type_id[]">
											<option value="">{{ __('common.Select') }}</option>
											<option value="1" {{ (1 == $item['admission_type_id']) ? 'selected' : '' }}>Regular</option>
											<option value="2" {{ (2 == $item['admission_type_id']) ? 'selected' : '' }}>Non</option>
											<option value="3" {{ (3 == $item['admission_type_id']) ? 'selected' : '' }}>Other</option>
										</select>
                        </td>
                        <td><input type="date" name="admission_date[]" value="{{ $item['admission_date'] ?? '' }}" /></td>
                         <td><input type="text" name="remark_1[]" value="{{ $item['remark_1'] ?? '' }}" /></td>
                         
                        
               
            </tr>
       @endforeach
       
   
       
    @else
        <tr>
            <td colspan="12" class="text-center">No Students Found !</td>
        </tr>
@endif
                
@endif 


                    </tbody>
                </table>
                
                <div class="col-md-12 text-center p-3" style="display:{{$search['class_type_id'] != '' ? 'block' : 'none' }}"><button type="submit" class="btn btn-primary"   >{{__('common.Update') }} </button></div>
           
                </form>
                </div>
                </div>
    </div>
</div>
</div>
</div>
</section>
        
</div>


<div class="modal fade" id="StuDetails">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
      <div class="modal-content">
      
        <div class="modal-header">
            <div class="d-flex align-items-center">
                <img src="" class="profile_pic_show" id="profile_pic" alt="profile_pic">
                <h4 class="modal-title ml-2">Student Details</h4> 
          </div>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body" id="pase_here">
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
</div>

<script>

    
$( document ).ready(function() {
    var session_id = $('#session_id').val();
    if(session_id != 1){
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('min', today);        
    }
}); 
</script>  
<script>
    $(document).delegate('.getAllData', 'click', function(){
        var val = $(this).data("data");
        var image = $(this).data("photo");
        if(image != ""){
        var path = "{{env('IMAGE_SHOW_PATH').'/profile/'}}";
        $('#profile_pic').prop('src',(path + image));
        }else{
        $('#profile_pic').prop('src',"https://img.freepik.com/premium-vector/student-avatar-illustration-user-profile-icon-youth-avatar_118339-4406.jpg?w=2000");
        }
        $('#pase_here').html(val);
    });
</script>

<script>
    $(document).delegate('.tab-item', 'click', function(){
            $(".tab-item").removeClass("active");
            $(this).addClass("active");

            var index = $(this).index();
            $(".tab-pane").removeClass("active");
            $(".tab-pane").eq(index).addClass("active");
    });
</script>


<!--<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })

</script>-->

<style>
    .profile_pic_show{
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    

    .tab-header {
        display: flex;
    }

    .tab-item {
        padding: 10px 20px;
        width: 100%;
        cursor: pointer;
        border: 1px solid #ccc;
        border-bottom: none;
        background-color: #f1f1f1;
    }

    .tab-item.active {
        background-color: #6639b5;
        color: white;
    }

    .tab-pane {
        display: none;
        padding: 20px;
        border: 1px solid #ccc;
    }

    .tab-pane.active {
        display: block;
    }
</style>
  

<style>
    .student_new_table{
        white-space:nowrap;
    }
    
    .student_new_table th, .student_new_table td{
        padding:10px;
    }
</style>


<script>
     $( window ).on("load", function() {

//   $( ".stream_subject_div" ).each(function( index ) {
//   $( this ).select2();
// });
//  $('.stream_subject_div_0').select2();

});
$( document ).ready(function() {

         $('.stream_subject_div').on('change', function(e){
             var id=$(this).data('id');
             var value=$(this).val();
             $('.input_stream_subject_div_'+id).val(value);
             
             
             
             
         });
         $('.class_type_id').on('change', function(e){
             
             
              $(".stream_id_div").css("display","none");
              $(".stream_subject_div").css("display","none");
                var baseurl = "{{ url('/') }}";
            	var class_type_id = $(this).val();
            
                    if(parseInt(class_type_id) > 10 )
                    {
                         $(".stream_id_div").css("display","block");
                $(".stream_subject_div").css("display","block");
                    }
                    
            
            	var key = $(this).data('id');
            
               	var url_ = "";
            	  var cur_route = window.location.pathname;
            	  
            	  if(cur_route == "/add/examination_schedule" ||  cur_route == "/add/admit_card")
            	  {
            	    url_ =   baseurl+'/examData/'+class_type_id+'/'+"null";
            	      
            	  }
            	  else
            	  {
            	   url_= baseurl+'/sectionData/'+class_type_id;
            	  }
            	  
                $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            	  url: url_,
            	  success: function(data){
            	     if(data != ''){
            	         	  if(cur_route == "/add/examination_schedule" || cur_route == "/add/admit_card")
            	  {
            	   	$(".exam_id_").html(data);
            	      
            	  }
            	 
            	  
            	         	$(".section_id_"+key).html(data);
            	     }else{
            	         	$(".section_id_"+key).html(data);
            	         alert('Section Not Found');
            	     }
            	  }
            	});
            });
            
            
              $('.stream_id_div').on('change', function(e){
                   
                var baseurl = "{{ url('/') }}";
            	var stream_id = $(this).val();
            	var id = $(this).data('id');
            
            	var class_type_id = $(".class_type_id_"+id).val();
               
                $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            	  url: baseurl+'/streamData/'+stream_id+'/'+class_type_id,
            	  success: function(data){
            	     if(data != ''){
            	         	$(".stream_subject_div_"+id).html(data);
            	         
            	         	$(".stream_subject_div_"+id).select2({
                            multiple: true,
                                });
            	         

            	     }else{
            	         	$(".stream_subject_div_"+id).html(data);
                           
            	         alert('Section Not Found');
            	     }
            	  }
            	});
            });
            
             $('.country_id').on('change', function(e){
                var baseurl = "{{ url('/') }}";
            	var country_id = $(this).val();
            	var id = $(this).data('id');
                $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            	  url: baseurl+'/countryData/'+country_id,
            	  success: function(data){
            			$(".state_id_"+id).html(data);
            	  }
            	});
            	
            });
            
            $('.state_id').on('change', function(e){
                var baseurl = "{{ url('/') }}";
            	var state_id = $(this).val();
            	var id = $(this).data('id');
                $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            	  url: baseurl+'/stateData/'+state_id,
            	  success: function(data){
            			$(".city_id_"+id).html(data);
            	  }
            	});
            	
            });
       
});
</script>


@endsection 