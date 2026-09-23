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
        <!--<a href="{{url('Fees/add')}}" class="btn btn-primary  btn-sm" title="Add Fees"><i class="fa fa-plus"></i>{{ __('common.Add') }}</a>-->
        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>
        </div>
        
        </div>  
        
                  
                        
                        
                    <div class="row m-2">
                        
                <div class="container">

  <ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item">

      <a class="nav-link active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Search by Student</a>

    </li>

    <li class="nav-item">

      <a class="nav-link" id="session-tab" data-toggle="tab" href="#session" role="tab" aria-controls="session" aria-selected="false">Search by Session</a>

    </li>

    <li class="nav-item">

      <a class="nav-link" id="counter-tab" data-toggle="tab" href="#counter" role="tab" aria-controls="counter" aria-selected="false">Search by Counter</a>

    </li>

  </ul>

  <div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">

        <form action="{{url('fees_reporting')}}" method="post" >
 <div class="row m-2">
        <div class="col-md-3">

        <div class="form-group">

    <label for="searchKeyword" class="form-label">Search By Keyword:</label>

    <input type="text" class="form-control" id="searchKeyword" name="searchKeyword">

  </div>
  
  </div>
<div class="col-md-3">
  <div class="form-group">

    <label for="class_type_id" class="form-label">Class:</label>

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

    <label for="sessionId" class="form-label">Session ID</label>

    <select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="sessionId" name="session_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>


  </div>
</div>
<div class="col-md-3">
    <div class="form-group">

    <label for="submitId" class="form-label text-white">Submit</label>
  <input type="submit" id='submitId'class="btn btn-primary" value='Submit' />
  
  </div>
</div>
</div>
</form>
</div>
    

    <div class="tab-pane fade" id="session" role="tabpanel" aria-labelledby="session-tab">

        <form action="{{url('fees_reporting')}}" method="post" >
 <div class="row m-2">
        <div class="col-md-3">

        <div class="form-group">

    <label for="searchKeyword" class="form-label">Search By Keyword:</label>

    <input type="text" class="form-control" id="searchKeyword" name="searchKeyword">

  </div>
  
  </div>
<div class="col-md-3">
  <div class="form-group">

    <label for="class_type_id" class="form-label">Class:</label>

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

    <label for="sessionId" class="form-label">Session ID</label>

    <select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="sessionId" name="session_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>


  </div>
</div>
<div class="col-md-3">
    <div class="form-group">

    <label for="submitId" class="form-label text-white">Submit</label>
  <input type="submit" id='submitId'class="btn btn-primary" value='Submit' />
  
  </div>
</div>
</div>
</form>

    </div>

    <div class="tab-pane fade" id="counter" role="tabpanel" aria-labelledby="counter-tab">

     <form action="{{url('fees_reporting')}}" method="post" >
 <div class="row m-2">
        <div class="col-md-3">

        <div class="form-group">

    <label for="searchKeyword" class="form-label">Search By Keyword:</label>

    <input type="text" class="form-control" id="searchKeyword" name="searchKeyword">

  </div>
  
  </div>
<div class="col-md-3">
  <div class="form-group">

    <label for="class_type_id" class="form-label">Class:</label>

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

    <label for="sessionId" class="form-label">Session ID</label>

    <select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="sessionId" name="session_id" >
                    			   <option value="">{{ __('common.Select') }}</option>
                                 @if(!empty($getSession)) 
                                      @foreach($getSession as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ( $type['id'] == $search['session_id']) ? 'selected' : '' }} >{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>


  </div>
</div>
<div class="col-md-3">
    <div class="form-group">

    <label for="submitId" class="form-label text-white">Submit</label>
  <input type="submit" id='submitId'class="btn btn-primary" value='Submit' />
  
  </div>
</div>
</div>
</form>

    </div>

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