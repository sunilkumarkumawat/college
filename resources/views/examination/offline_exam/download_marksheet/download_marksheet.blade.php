@php
$classType = Helper::classType();
@endphp
@extends('layout.app') 
@section('content')

<style>
    .pdf_size{
        margin-top: 2%;
        margin-left: -11%;
    }
</style>
<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
                    
                            <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp; {{ __('Download Marks') }} </h3>
                       
							<div class="card-tools cl-6"> 
							
							   
							    <a href="{{ url('examination_dashboard') }}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}  </a> 
                            </div>
						</div>
						
					
						<div class="card-body">
   
                        <div class="row">
                            <div class="col-md-8">
                            <form id="quickForm" action="{{ url('download_marksheet') }}" method="post" class="was-validated" >
                                @csrf
                                <div class="row">
                                <div class="col-md-3">
                        			<div class="form-group">
                        				<label style="color:red;">{{ __('messages.Class') }}*</label>
                        				<select class="select2 form-control @error('class_name') is-invalid @enderror " id="class_type_id" name="class_name" required>
                                <option value="">{{ __('messages.Select') }}</option>
                                                                @if(!empty($classType))
                                                                  @foreach($classType as $type)
                                                                  
                                                                  @if($type->id > 10)
                                                                  <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['class_type_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                                  @endif
                                                                  @endforeach
                                                                @endif
                                        </select>
                                           <div class="invalid-feedback">Please fill out this field.</div>
                        		    </div>
      </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                                			<label style="color:red;">{{ __('messages.Exam Name') }}*</label>
                                                			<select class="select2 form-control @error('exam_id') is-invalid @enderror exam_id_" id="exam_id" name="exam_id" required>
                                                		
                                                              <option value="" >{{ __('messages.Select') }}</option>
                                                              @if(!empty($examlist))
                                                              @foreach($examlist as $item)
                                                              
                                                              <option value="{{ $item->exam_id ?? ''  }}" {{ ($item->exam_id == $search['exam_id']) ? 'selected' : '' }}>{{ $item->exam_name ?? ''  }}</option>
                                                                @endforeach
                                                              @endif
                                                             
                                                            </select>
                                                              <div class="invalid-feedback">Please fill out this field.</div>
                                                	    </div>
                             </div>
                                <div class="col-md-1 col-6">
                                    <lable>&nbsp;</lable><br>
                                <button type="submit" class="btn btn-primary">{{ __('messages.Search') }}</button>
                                </div>
                            </div>
                            </form>
                            </div>
                      
    </div>
               
	               
                
                
        <div class="row m-2">
         <div class="col-12 mt-5">
             <div class="card">
   <div class="card-header border-transparent">
      <div class="card-tools">
         <button type="button" class="btn btn-primary btn-tool" data-card-widget="collapse">
         <i class="fa fa-minus"></i>
         </button>
      </div>
   </div>
   <div class="card-body p-0" style="display: block;">
      <div class="table-responsive">
           <table class="table table-bordered table-striped">
                <thead>
                <tr>
				<th>S No</th>
                <th>Adm Number</th>
                <th>Student's Name</th>
                 <th>Father's Name</th>
                 <th>Action</th>
                </tr>
                </thead>
			
			
				<tbody>
			
				@if(!empty($data)) 
				@if($data->count() != 0)
                @foreach($data as $key=> $item)
                <tr>
                    <td>{{$key+1 ?? ""}}</td>
                    <td>{{$item->admissionNo ?? ""}}</td>
                    <td>{{$item->first_name ?? ""}} {{$item->last_name ?? ""}}</td>
                    <td>{{$item->father_name ?? ""}}</td>
                    <td>
                         <div class="d-flex">
                          <form action="{{url('print_report_card')}}" target="blank" method="post">
                            @csrf
                                <input type="hidden" name="admission_id" value="{{$item->id ?? ""}}" />
                                <input type="hidden" name="exam_id" value="{{$search['exam_id'] ?? ''}}" />
                                <input type="hidden" name="class_type_id" value="{{$search['class_type_id'] ?? ''}}" />
                                <button type="submit" class="btn btn-secondary" > <i class="fa fa-print"></i> </button> 
                            
                            </form>
                         </div>
                    </td>

                        
                                                      
                        </tr>
                        @endforeach
                        
                       
                        @else
                        <tr>
                            <td class="text-center" colspan="12">No Data Found</td>
                        </tr>
                        @endif
                        @endif
 </tbody>
				
                </table>
        
      </div>
   </div>
</div>
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
    
        $('#class_type_id').on('change', function(e){
            
                $("#stream_id").val("");
                $("#stream_subject").html("");
                $("#stream_id_div").css("display","none");
                $("#stream_subject_div").css("display","none");
                
                $(".div_stream_id_").css("display","none");
                $(".div_subject_id").css("display","block");
                $('#subject_id').prop('required',true);
                $('#stream_subject_id').prop('required',false);
                $('#stream_subject_id').val('')
                $('#stream_id_').prop('required',false);
                $('#stream_id_').val('');

                var baseurl = "{{ url('/') }}";
            	var class_type_id = $(this).val();
            	  
                $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            	    url: baseurl + '/examData/' + class_type_id,
            	    success: function(data){
    	         	    $("#exam_id").html(data);
            	    }
            	});
        });
    
});
</script>
@endsection