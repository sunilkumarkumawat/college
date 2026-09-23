

@php
  $courses = Helper::getCourses();
  $classType = Helper::classType($search['course_id'] ?? null);
  $allClassType = Helper::classType();
  $batches = Helper::getBatch();
  $getCountry = Helper::getCountry();
  $getAllUsers = Helper::getAllUsers();
  $getSession = Helper::getSession();
@endphp
@extends('layout.app') 
@section('content')

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

<div class="content-wrapper">

   <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">      
    <div class="card card-outline card-orange">
        <div class="card-header bg-primary">
        <h3 class="card-title"><i class="fa fa-bar-chart-o"></i> &nbsp;{{ __('Fee Receipts') }}</h3>
        <div class="card-tools">
        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
        </div>
        
        </div>   
        
        
        <form id="quickForm" action="{{ url('ca_report') }}" method="post" >
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
                                <select class="form-control select2" id="course_id" name="course_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id ?? '' }}" {{ ($course->id == ($search['course_id'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
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
                        <div class="col-md-1">
                			<div class="form-group"> 
                				<label>{{ __('student.Admission No.') }}</label>
                				<input type="text" class="form-control" id="admission_no" name="admission_no" placeholder="{{ __('student.Admission No.') }}" value="{{$search['admission_no'] ?? ''}}">
                		    </div>
                        </div> 
                        @if(Session::get('role_id') == 1)
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>{{ __('Users') }}</label>
                                <select class="select2 form-control" id="user_id" name="user_id">
                                <option value='' >All Users </option>
                                @if(!empty($getAllUsers))
                                @foreach($getAllUsers as $getCoun)
                                <option value="{{ $getCoun->id ?? ''  }}" {{ ($getCoun->id == ($search['user_id'] ?? '')) ? 'selected' : '' }}>{{$getCoun->first_name ?? ''}} {{$getCoun->last_name ?? ''}}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                        @endif
                    	<div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('fees.From Date') }}</label>
                                    <input type="date" class="form-control " id="starting" name="starting" value="{{ $search['starting'] ?? '' }}">                 	    
                            </div>
                    	</div>
                    	<div class="col-md-1">
                            <div class="form-group ">
                                <label>{{ __('fees.To Date') }}</label>
                                    <input type="date" class="form-control " id="ending" name="ending" value="{{ $search['ending'] ?? '' }}">
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
                    	    <button type="submit" class="btn btn-primary">{{ __('messages.Search') }}</button>
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
            <th>Collect By</th>
            <th>Receipt No.</th>
            <th>Txn Id & Status</th>
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

            <th>{{ __('Payment date') }}</th>
            <th>{{ __('Discount') }}</th>
            <th>{{ __('Fine') }}</th>
            <th>{{ __('Amount') }}</th>
         
          </thead>
         <tbody>
             
             @if(!empty($data))
             @php
            $amount = 0;
            $fine = 0;
            $discount =0;
             @endphp
             @foreach($data as $key => $receipt)
              
             <tr>
                 @php
                 $genderName = DB::table('gender')->whereNull('deleted_at')->where('id',$receipt->gender_id)->first();
                  $session = DB::table('sessions')->whereNull('deleted_at')->where('id', $receipt->session_id ?? '')->first();

                 @endphp
                 
                 <td>{{$key+1}}</td>
                 <td>{{$receipt->users_first_name ?? ''}} {{$receipt->users_last_name ?? ''}}
                    <small class="text-success">{{ $receipt->payment_mode ?? '' }}</small>
                 </td>
                 <td class='d-flex'>
                     <form action="{{url('printFeesInvoice')}}" method="post" target="_blank">
                         @csrf
                         <button class="text-primary" type="submit" id="fees_details_invoice_id" style="border: none; background: transparent; border-bottom: 2px solid #1f2d3d;" name="fees_details_invoice_id" value="{{$receipt->id ?? ''}}">{{$receipt->invoice_no ?? ''}}</button>
                     </form>
                 </td>
               <td>
                   @if(!empty($receipt->transaction_id))
                   <small class="text-primary">{{ $receipt->transaction_id ?? '' }} <br></small>
                   @endif
                      @if($receipt->status == 0)
                        <span style="color: green;">Received</span>
                    @elseif($receipt->status == 1)
                        <span style="color: red;">Pending</span>
                    @elseif($receipt->status == 2)
                       <span style="color: red;">Cancelled</span>
                    @endif
                   
                    @if($receipt->payment_mode_id == 6 && $receipt->transaction_id != null)
                    <br><button class="btn btn-success btn-xs checkTxnStatusBtn" data-txnid="{{ $receipt->transaction_id ?? '' }}">Check PayU Status</button>
                    @endif
               </td>
                   <td>{{ $receipt['admissionNo'] ?? ''  }}</td>
                    <td>{{ $receipt['first_name'] ?? ''  }} {{ $item['last_name'] ?? ''  }}</td>
                    <td>{{ $receipt['father_name'] ?? ''  }}</td>
                    <td>{{ $genderName->name ?? '' }}</td>
                    <td>{{ $receipt['category']  }}</td>
                    <td>{{ $receipt['student_type'] ?? '' }}</td>
                    <td>{{ $receipt['course'] ?? '' }}</td>
                    <td>{{ $receipt['class_name'] ?? '' }}</td>
                    <td>{{$session->from_year ?? ''}}-{{$session->to_year ?? ''}}</td>
                    <td>{{ $receipt['batch'] ?? '' }}</td>
                    <td>
                    @if($receipt['ad_status'] == 1)
                        Continue
                    @else
                       <spam class='text-danger' >Discontinue </spam>
                    @endif
                    </td>
                 <td>{{date('d-m-Y', strtotime($receipt->payment_date ?? ''))}}</td>
                 <td>
                    @if($receipt->status == 0  )
                        <span style="color: green;">{{$receipt->discount ?? 0}}</span>
                        @php $discount +=$receipt->discount; @endphp
                    @elseif($receipt->status == 1)
                        <span style="color: #fd7e14;">{{$receipt->discount ?? 0}}</span>
                        @php $discount +=$receipt->discount; @endphp
                    @elseif($receipt->status == 2)
                       <span style="color: red;">{{$receipt->discount ?? 0}}</span>
                    @endif
                 </td>
                 <td>
                    @if($receipt->status == 0  )
                        <span style="color: green;">{{$receipt->total_fine ?? 0}}</span>
                        @php $fine +=$receipt->total_fine; @endphp
                    @elseif($receipt->status == 1)
                        <span style="color: #fd7e14;">{{$receipt->total_fine ?? 0}}</span>
                        @php $fine +=$receipt->total_fine; @endphp
                    @elseif($receipt->status == 2)
                       <span style="color: red;">{{$receipt->total_fine ?? 0}}</span>
                    @endif
                 </td>
                 <td>
                    @if($receipt->status == 0  )
                        <span style="color: green;">{{$receipt->amount ?? 0}}</span>
                        @php $amount +=$receipt->amount; @endphp
                    @elseif($receipt->status == 1)
                        <span style="color: #fd7e14;">{{$receipt->amount ?? 0}}</span>
                        @php $amount +=$receipt->amount; @endphp
                    @elseif($receipt->status == 2)
                       <span style="color: red;">{{$receipt->amount ?? 0}}</span>
                    @endif
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{number_format($discount,2) ?? ''}}</td>
                <td>{{number_format($fine,2) ?? ''}}</td>
                <td>{{number_format($amount,2) ?? ''}}</td>
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

<script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
<script>
$(document).ready(function () {
  
   
    $(".checkTxnStatusBtn").click(async function () {

        const btn = $(this);
        const originalBtnText = btn.text();
        var txnid = $(this).data('txnid');

        try {
            btn.prop("disabled", true).html(`<i class="fa fa-spinner fa-spin"></i> ${originalBtnText}`);

            const response = await fetch("{{ url('checkPayUTxnStatus') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                body: JSON.stringify({ txnid: txnid })
            });

            const data = await response.json();

            if (response.ok) {
                toastr.success(data.message);
                $('#checkTxnStatusModal').modal('show');
                const parsed = typeof data.response === 'string' ? JSON.parse(data.response) : data.response;
                const prettyHTML = syntaxHighlight(parsed);
                $('#txnJsonOutput').html(prettyHTML);
                // const parsedData = JSON.parse(data.response); 
                // var prettyJson = JSON.stringify(parsedData, null, 4);
                // $('#txnJsonOutput').text(prettyJson);
            } else {
                toastr.error(data.message || "Something went wrong. Please try again.");
            }
        } catch (error) {
            let errorMessage = error.message || "An unexpected error occurred.";
            toastr.error(errorMessage);
            console.error("Error:", errorMessage);
        } finally {
            btn.prop("disabled", false).text(originalBtnText);
        }
        
    });

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
                @foreach($allClassType as $class)
                    defaultClasses.push({ id: "{{ $class->id }}", name: "{{ $class->name }}" });
                @endforeach
            @endif
            updateClassDropdown(classSelect, defaultClasses);
        }
    });

    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, null, 4);
        }

        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            let cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return `<span class="${cls}">${match}</span>`;
        });
    }

});

</script>
 <div id="checkTxnStatusModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h3>Transaction Result</h3>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <pre class="json-viewer bg-dark text-white p-3 rounded" style="font-family: monospace; max-height: 500px; overflow-y: auto;">
        <code id="txnJsonOutput"></code>
    </pre>
      </div>
     <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>       
<style>
    th, td{
    white-space: nowrap !important;

}

.json-viewer .key       { color: #ffd700; }  /* yellow */
  .json-viewer .string    { color:rgb(69, 248, 135); }  /* green */
  .json-viewer .number    { color: #fe774f; }  /* orange */
  .json-viewer .boolean   { color: #82aaff; }  /* blue */
  .json-viewer .null      { color: #c670ff; }  /* purple */

  
</style>
@endsection 