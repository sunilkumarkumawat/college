@php
  $classType = Helper::classType();
  $getSession = Helper::getSession();
  $getCounter = Helper::getCounters();


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
        
                  
                        
                        
                    <div class="row m-2">
                        
                         <div class="col-md-12 bg-secondary">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#keywords" data-toggle="tab">{{ __('Search By Student') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#session" data-toggle="tab">{{ __('Search By Session') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#search_by_counter" data-toggle="tab">{{ __('Search By Counter') }}</a></li>
                               
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content">
                                <div class="active tab-pane" id="keywords">
                                     <form id="quickForm" action="{{url('fees_reporting')}}" method="post" >
                        @csrf 
                                  <div class="row m-2">
                                       
                  
               
                        <div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('common.Class') }}</label>
                    			<select class="form-control select2" id="class_type_id" name="class_type_id" >
                    			<option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($classType)) 
                                      @foreach($classType as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['class_type_id']) ? 'selected' : '' }} >{{ $type->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>
                    	 <div class="col-md-3">
                    		<div class="form-group">
                    			<label>{{ __('common.Search By Keywords') }}</label>
                    			<select class="form-control select2" id="name" name="name" >
                    			<option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($allStudent)) 
                                      @foreach($allStudent as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['name']) ? 'selected' : '' }} >{{ $type->first_name ?? ''  }} {{ $type->last_name ?? ''  }} [{{ $type->class_name ?? ''}}]</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>     
                    	                     	<div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('Session') }}</label>
                    				<select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="" name="session_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                                 @error('session_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror     
                    	    </div>
                    	</div>
                    	    <div class="col-md-1 ">
                             <label class="text-white">{{ __('Session') }}</label>
                    	    <input type="submit" class="btn btn-primary" name="button_value" value="Search" />
                    	</div>
                    	</div>
                    	
                    	</form>
                                </div>
                                

                                <div class="tab-pane" id="session">

                                    <div class="card-body p-0 mb-3">
                                      <form id="quickForm" action="{{url('fees_reporting')}}" method="post" >
                        @csrf 
                                     <div class="row m-2">
                                           <div class="col-md-3">
                    		<div class="form-group">
                    			<label>{{ __('common.Search By Keywords') }}</label>
                    			<select class="form-control select2" id="name" name="name" >
                    			<option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($allStudent)) 
                                      @foreach($allStudent as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['name']) ? 'selected' : '' }} >{{ $type->first_name ?? ''  }} {{ $type->last_name ?? ''  }} [{{ $type->class_name ?? ''}}]</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>     
                    	    <div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('common.Class') }}</label>
                    			<select class="form-control select2" id="class_type_id" name="class_type_id" >
                    			<option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($classType)) 
                                      @foreach($classType as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['class_type_id']) ? 'selected' : '' }} >{{ $type->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>
                                         	<div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('Session') }}</label>
                    				<select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="" name="session_ids" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                                 @error('session_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror     
                    	    </div>
                    	</div>
                    	
                    	  
                    	    <div class="col-md-1 ">
                             <label class="text-white">{{ __('Session') }}</label>
                    	    <input type="submit" class="btn btn-primary" name ="button_value" value="Session" />
                    	</div>
                    	
                    	</div>
                    	</form>
                                    </div>

                                </div>
                                <div class="tab-pane" id="search_by_counter">

                                    <div class="card-body p-0 mb-3">
                                           <form id="quickForm" action="{{url('fees_reporting')}}" method="post" >
                        @csrf 
                                     <div class="row m-2">
                     
                     
                           	    <div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('Counter') }}</label>
                    			<select class="form-control select2" id="counter_id" name="counter_id" >
                    			<option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getCounter)) 
                                      @foreach($getCounter as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['counter_id']) ? 'selected' : '' }} >{{ $type->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>
                    	
                    	                                 	<div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('Session') }}</label>
                    				<select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="" name="session_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                                 @error('session_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror     
                    	    </div>
                    	</div>
                     
                     
                        
                            <div class="col-md-1 ">
                             <label class="text-white">{{ __('Session') }}</label>
                    	    <input type="submit" class="btn btn-primary" name ="button_value" value="Counter Search" />
                    	</div>
                                         
                                         </div>
                                         </form>
                                    </div>

                                </div>

                            

                               

                            </div>

                        </div>
                        </div>
                    <div class="row m-2">
              
                   <!-- 	<div class="col-md-1">
                    		<div class="form-group">
                    			<label>{{ __('common.Section') }}</label>
                    				<select class="form-control select2 section_id" id="" name="section_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSection)) 
                                      @foreach($getSection as $type)
                                         <option value="{{ $type->id ?? ''  }} {{ ( $type['id'] == $search['section_id']) ? 'selected' : '' }}" >{{ $type->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>-->
              
                    	<div class="col-md-2" id="stream_id_div" style="display:{{ ($search['class_type_id'] ?? '') > 10 ? 'block' : 'none'}}">
                    		<div class="form-group">
                    			<label>{{ __('common.Stream') }}</label>
                    
                    			<select class="form-control select2" id="stream_id" name="stream_id" >
                    			
                    				<option value="">{{ __('common.Select') }}</option>
                                             <option value="Arts" {{ ("Arts" == $search['stream_id']) ? 'selected' : ''}}>Arts</option>
                                             <option value="Science" {{ ("Science" == $search['stream_id']) ? 'selected' : ''}}>Science</option>
                                             <option value="Commerce" {{ ("Commerce" == $search['stream_id']) ? 'selected' : ''}}>Commerce</option>
                    			
                    			</select>
                    		</div>
                    	</div>
                 
                       
                    <!--    <div class="col-md-2">
            			<div class="form-group">
            				<label>{{ __('student.Admission No.') }}</label>
            				<input type="text" class="form-control" id="admission_no" name="admission_no" placeholder="{{ __('student.Admission No.') }}" value="{{$search['admission_no'] ?? ''}}">
            		    </div>
            		</div>--> 
            	               	
                       
                    
                    			
                    </div>
                </form>        

        
    	<div class="row mb-2 m-2">
		    <div class="col-md-12">	
        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
          <thead>
          <tr role="row">
              <th>{{ __('common.SR.NO') }}</th>
              <!--<th>{{ __('AD NO') }}</th>-->
                    <!--<th>{{ __('fees.Student Name') }}</th>-->
                    <!--<th>{{ __('common.Fathers Name') }}</th>-->
                    <th>{{ __('common.Class') }}</th>
                    <th>{{ __('Session') }}</th>
                    
                    <th>{{ __('Fees Assign') }}</th>
                    <th>{{ __('Fees Collect') }}</th>
                    <th>{{ __('Pending Fees') }}</th>
                  
          </thead>
          <tbody id="fees_list_show">
              
              @if(!empty($session))
                @php
                   $i=1;
                   $total_assign=0;
                   $total_collect=0;
                   $total_pending=0;
                   $total_session_assign =0;
                   $total_session_collect =0;
                
                @endphp

                @foreach ($session  as $item)
                @php
                $total_session_assign =0;
                     $total_session_collect =0;
                 @endphp
                 @foreach ($fees  as $item1)
                  
                  @if($item['session_id'] == $item1['session_id'])
                  
                  @php
                  $total_session_assign += $item1['assign_amount'];
                  $total_session_collect += $item1['total_collect'];
                 
                  @endphp
                
                  
                  @endif
                  
                  @endforeach
                  
                  
                  
                <tr>
                   
                        <td>{{ $i++ }}</td>
                        <!--<td>{{  $item['admissionNo'] ?? '' }}</td>-->
                        <!--<td>{{ $item['first_name'] ?? ''  }} {{ $item['last_name'] ?? ''  }}</td>-->
                        <!--<td>{{ $item['father_name'] ?? ''  }}</td>-->
                        <td>{{ $item['class_name'] ?? ''  }} 
                        @if(!empty($item['section_name']))
                        ({{ $item['section_name'] ?? ''  }})
                        @endif
                        
                        </td>
                        <td>{{ ($item['session_from_year'] ?? 0) .'-'. ($item['session_to_year'] ?? '')  }}</td>
                        <td>{{ $total_session_assign ?? 0  }}</td>
                        <td>{{ $total_session_collect  ?? 0}}</td>
                        <td>{{ ($total_session_assign ?? 0) - ($total_session_collect)}}</td>
                        
                        
              </tr>
              @php
              $total_assign +=$total_session_assign;
              $total_collect +=$total_session_collect;
              $total_pending += $total_session_assign-$total_session_collect;
              @endphp
             
           
              @endforeach
              <tfoot>
               <tr>
                  <td></td>
                  <!--<td></td>-->
                  <!--<td></td>-->
                  <!--<td></td>-->
                  
                  <td><b>{{__('Total') }}</b></td>
                  <td></td>
                  <td><b>{{$total_assign ?? ''}}</b></td>
                  <td><b>{{$total_collect ?? ''}}</b></td>
                 <td><b>{{$total_pending ?? ''}}</b></td>
                 

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
        


<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <div class="modal-header">
        <h4 class="modal-title text-white">{{ __('fees.Revert Fees Confirmation') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <form action="{{ url('collect_fees_delete') }}" method="post">
              	 @csrf
      <div class="modal-body">
              <input type=hidden id="delete_id" name=delete_id>
              <input type=hidden id="collect_id" name=collect_id>
              <input type=hidden id="revert_amount" name=revert_amount>
              <h5 class="text-white">{{ __('fees.Are you sure you want to revert fees ? This action is irreversible.') }}</h5>
      </div>
      <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
         </div>
       </form>
    </div>
  </div>
</div>
 
<script>
  $('.deleteData').click(function() {
  var delete_id = $(this).data('id'); 
  var collect_id = $(this).data('collect_id'); 
  var revert_amount = $(this).data('revert_amount'); 
  
  $('#delete_id').val(delete_id); 
  $('#collect_id').val(collect_id); 
  $('#revert_amount').val(revert_amount); 
  } );

    
             $('.feesDetail').click(function() {
                 count=2;
	var first_name = $(this).data('first_name');
	var class_type_id = $(this).data('class_type_id');
	var section_id = $(this).data('section_id');
	var admission_id = $(this).data('admission_id');

// 	$('#first_name').html(first_name);
// 	$('#class_type_id1').html(class_type_id);
// 	$('#section_id1').html(section_id);
// 	$('#admission_id').val(admission_id);
   var basurl = "{{ url('/') }}";
            $.ajax({
                 type: "post",
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        	    url: basurl+'getFeesDetail',
        	     data:{admission_id:admission_id},
        	    success: function(result){
        	     
        	  jQuery('#tbody').html(result)
        	   $('#myModal').modal('toggle');
        	         	$('#first_name').html(first_name);
                        $('#class_type_id1').html(class_type_id);
                    	$('#section_id1').html(section_id);
 	                    $('#admission_id').val(admission_id);
 	        	 
 	        	   $(".editable").each(function () {
        //Reference the Label.
        var label = $(this);
 
        //Add a TextBox next to the Label.
        label.after("<input type = 'text' style = 'display:none;width:100px;' />");
 
        //Reference the TextBox.
        var textbox = $(this).next();
 
        //Set the name attribute of the TextBox.
        
        textbox[0].name = this.id.replace("n"+count, "amount[]");
    count++;
        //Assign the value of Label to TextBox.
        textbox.val(label.html());
 
        //When Label is clicked, hide Label and show TextBox.
        label.click(function () {
            $(this).hide();
            $(this).next().show();
        });
 
        //When focus is lost from TextBox, hide TextBox and show Label.
        textbox.focusout(function () {
            $(this).hide();
            $(this).prev().html($(this).val());
            $(this).prev().show();
        });
    });
 	       	  }
        	});
        
             });
</script>
@endsection 