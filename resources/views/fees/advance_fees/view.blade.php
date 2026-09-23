@extends('layout.app') 
@section('content')
@php
$getPermission = Helper::getPermission();
$courses = Helper::getCourses();
$classType = Helper::classType($search['course_id'] ?? null);
$allClassType = Helper::classType();
$batches = Helper::getBatch();
$getSession = Helper::getSession();
@endphp
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp;{{ __('Advance Fees') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('fee_dashboard')}}" class="btn btn-primary btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}</a>
                            </div>
                        </div>
                        
                        
                         <form id="quickForm" action="{{ url('AdvanceFees') }}" method="post" >
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="admissionNo">{{ __('student.Admission No.') }}</label>
                            <input type="text" class="form-control" id="admissionNo" name="admissionNo" placeholder="{{ __('student.Admission No.') }}" value="{{ $search['admissionNo'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"> 
                            <label>{{ __('messages.Search By Keywords') }}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.Ex. Name, Father Name, Mobile, Email, etc.') }}" value="{{$search['name'] ?? ''}}">
                        </div>
                    </div>
                    	
                                	
                        <div class="col-md-1 ">
                             <label for="" style="color: white;">Search</label>
                    	    <button type="submit" class="btn btn-primary" srtle="margin-top: 26px !important;">{{ __('messages.Search') }}</button>
                    	</div>
                    			
                    </div>
                </form>   

                        

                        <div class="row m-2">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline padding_table">
                                    <thead>
                                        <tr role="row">
                                            <th>{{ __('student.Admission No.') }}</th>
                                            <th>{{ __('Student Name') }}</th>
                                            <th>{{ __('Father Name') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Batch') }}</th>
                                            <th>{{ __('Student Type ') }}</th>
                                            <th>{{ __('Balance') }}</th>
                                            <th>{{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if(!empty($data)) 
                                        @php $i=1 @endphp 
                                        @foreach ($data as $item) 

                                        <tr>
                                            <td>{{ $item['admissionNo'] ?? '' }}</td>
                                            <td>{{ $item['first_name'] ?? '' }}</td>
                                            <td>{{ $item['father_name'] ?? '' }}</td>
                                            <td>{{ $item['course'] ?? '' }}</td>
                                            <td>{{ $item['batch'] ?? '' }}</td>
                                            <td>{{ $item['student_type'] ?? '' }}</td>
                                            <td>{{ $item['balance'] ?? '' }}</td>
                                            <td>
						                   <a  class="btn btn-primary MOBILE_btn btn-sm admission_id" data-toggle="modal" data-id="{{$item['unique_system_id'] }}" data-balance="{{$item['balance'] ?? 0}}" data-target="#demo3"
                                                title="Add New balance"><i class="fa fa-balance-scale"></i> </a>
                                                <button type="button" class="btn btn-primary data" data-id="{{ $item['unique_system_id'] ?? '' }}" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye"></i></button>

                                            </td>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">  Advance Fees History</h5>
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

<style>
    .padding_table thead tr{
    background: #002c54;
    color:white;
}
    
.padding_table th, .padding_table td{
     padding:5px;
     font-size:14px;
}
</style>
<script>
  $('.admission_id').click(function() {
  var unique_system_id = $(this).data('id'); 
  var balance = $(this).data('balance'); 
  
  $('#balance').val(balance); 
  $('.balance').html(balance); 
  $('#unique_system_id').val(unique_system_id); 
  } );
 </script>

<div  class="modal fade" id="demo3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content w-100">
        <div class="modal-header  bg_yellow text-white pb-2 pt-2">
             <h4 class="modal-title">Add New</h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
         <form id="example1" action="{{ url('AddAdvanceFees') }}"  method="post" >
                    @csrf
                    <div class="row m-2">
                        <div class="col-md-4 border border-secondary p-1">
                            <span class="float-left">Available balance</span>
                            <span class="float-right"><b class="balance"> ₹ 0</b></span>
                            <input type="hidden" name="unique_system_id" id="unique_system_id" value="" >
                            <input type="hidden" name="balance" id="balance" value="" >
                        </div>
                        <div class="col-md-3 pl-5">
                            <label class="toggleSwitch xlarge" onclick="">
                                    <input type="checkbox"  class="toggle_switch"  data-status="debit" checked/>
                                            
                                                <span>
                                                    <span>Debit</span>
                                                    <span>Credit</span>
                                                </span>
                                                <a></a>
                                            </label>
                                            <input type="hidden"  value="credit"id="debit_credit"  name="debit_credit"/>
                        </div>
                         
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="credit">Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror input1" id="date" value=""name="date" placeholder="Date*" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror input1" id="amount_1" onkeypress="javascript:return isNumber(event)" value="" name="amount" placeholder="Amount*" required>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="text" class="form-control @error('details') is-invalid @enderror input1" id="details" name="details" placeholder="Details*" required>
                                @error('details')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                      
                        <div class="col-md-12 mt-3 p-2 mb-3 bg-secondary1">
                            <span class="float-left">Available balance</span>
                            <span class="float-right"><b> ₹ <span class=" balance opening_balance"></span> </b></span>
                        </div>
                    </div>
                    <div class="row m-2 pb-2 mt-3 ">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </div>
                    </div>
                </form>
        </div>
      </div>
      
    </div>
  </div>
  <script>
    $(document).ready(function () {
       
     $('#amount_1').keyup(function () {
        var balance = parseInt($('#balance').val()) || 0;
       // alert(balance);
          if($(".toggle_switch" ).is(":checked"))
         {
           $(".opening_balance").html(balance+parseInt($(this).val()))
            
         }
         else
         {
              $(".opening_balance").html('₹ ' + balance-parseInt($(this).val()))
         }
    
}); 


        $("#open").click(function () {
            $(".eye_hide").toggle();
        });
        $(".toggle_switch").click(function () {
          var status = $(this).attr('data-status');
        
           var opening_balance = parseInt($('#balance').val());
           if($( ".toggle_switch" ).is(":checked"))
         {
            $("#debit_credit").val("credit");
             $(".opening_balance").html(parseInt(opening_balance)+parseInt($('#amount_1').val()))
          }
         else
         {
             $("#debit_credit").val("debit");
               $(".opening_balance").html(parseInt(opening_balance)-parseInt($('#amount_1').val()))
         }
         });

    $(".data").click(function(){
       var id = $(this).data("id");
       var basurl = "{{ url('/') }}";
       $.ajax({
             headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
        type:'post',
        url: basurl +'/viewAdvanceFees',
        data: {unique_system_id:id},
         dataType: 'json',
        success: function (response) {
            $(".response").html(response.html);
        }
      }); 
        });

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
<style>
    @media only screen {
  .toggleSwitch {
    display: inline-block;
    height: 18px;
    position: relative;
    overflow: visible;
    padding: 0;
    cursor: pointer;
    width: 40px
  }
  .toggleSwitch * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .toggleSwitch label,
  .toggleSwitch > span {
    line-height: 20px;
    height: 20px;
    vertical-align: middle;
  }
  .toggleSwitch input:focus ~ a,
  .toggleSwitch input:focus + label {
    outline: none;
  }
  .toggleSwitch label {
    position: relative;
    z-index: 3;
    display: block;
    width: 100%;
  }
  .toggleSwitch input {
    position: absolute;
    opacity: 0;
    z-index: 5;
  }
  .toggleSwitch > span {
    position: absolute;
    width: 100%;
    margin: 0;
    text-align: left;
    white-space: nowrap;
  }
  .toggleSwitch > span span {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 5;
    display: block;
    width: 50%;
    text-align: left;
    font-size: 0.9em;
    width: 100%;
    top: -2px;
    opacity: 0;
  }
  
.toggleSwitch a {
  position: absolute;
  right: 50%;
  z-index: 4;
  display: block;
  height: 27.5px;
  padding: 0;
  left: 4px;
  width: 18px;
  background-color: #fff;
  border: 1px solid #CCC;
  border-radius: 100%;
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  top: 5;
}
  .toggleSwitch > span span:first-of-type {
    color:#515151;
    opacity: 1;
    left: 45%;
  }
 .toggleSwitch > span::before {
  content: '';
  display: block;
  width: 114%;
  height: 82%;
  position: absolute;
  top: 3px;
  background-color: #e6e6e6;
  border: 2px solid #959494;
  border-radius: 30px;
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
  box-shadow: inset 7px 1px 10px -2px #9f9999;
}
  .toggleSwitch input:checked ~ a {
  border-color: #fff0;
  left: 100%;
  margin-left: 17px;
}
  .toggleSwitch input:checked ~ span::before {
  border-color: #0DB31F;
  box-shadow: inset 0 0 0 30px #0DB31F;
}
  .toggleSwitch input:checked ~ span span:first-of-type {
    opacity: 0;
  }
  .toggleSwitch input:checked ~ span span:last-of-type {
     opacity: 1;
  color: #fff;
  margin: 0px 15px;
  }
  /* Switch Sizes */
  .toggleSwitch.large {
    width: 60px;
    height: 27px;
  }
  .toggleSwitch.large a {
    width: 27px;
  }
  .toggleSwitch.large > span {
    height: 29px;
    line-height: 28px;
  }
  .toggleSwitch.large input:checked ~ a {
    left: 41px;
  }
  .toggleSwitch.large > span span {
    font-size: 1.1em;
  }
  .toggleSwitch.large > span span:first-of-type {
    left: 50%;
  }
 .toggleSwitch.xlarge {
  width: 78.5px;
  height: 34px; 
  }
  .toggleSwitch.xlarge a {
  width:28px;
}
  .toggleSwitch.xlarge > span {
    height: 38px;
    line-height: 37px;
  }
  .toggleSwitch.xlarge input:checked ~ a {
  left: 41.8px;
}
  .toggleSwitch.xlarge > span span {
    /*font-size: 1.4em;*/
  }
  .toggleSwitch.xlarge > span span:first-of-type {
    left:45%;
    width: 53px;
  }
}
</style>
@endsection
