@extends('layout.app') 
@section('content')

                                                                   
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('master.Edit Time Period') }}</h3>
							
							<div class="card-tools">
                                        <a href="{{url('time_periods')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> {{ __('View') }} </a>
                                        <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                        </div>
                           </div>                      
                          <form id="quickForm" action="{{ url('edit_periods') }}/{{($data->id)}}" method="post" >
                                @csrf
                        	<div class="row m-2">
                             
                                <div class="col-md-6">
                                    <label class="text-danger">{{ __('master.From Time') }}*</label>
                                    <input type="time" class="form-control @error('from_time') is-invalid @enderror" onkeydown="return /[a-zA-Z ]/i.test(event.key)"
                                        id="from_time"
                                        name="from_time"
                                       
                                        value="{{date("H:i", strtotime($data['from_time']))}}"
                                    />
                                    @error('from_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                           
                             
                                <div class="col-md-6">
                                    <label class="text-danger">{{ __('master.To Time') }}*</label>
                                    <input type="time" class="form-control @error('to_time') is-invalid @enderror" onkeydown="return /[a-zA-Z ]/i.test(event.key)"
                                        id="to_time"
                                        name="to_time"
                                       
                                         value="{{date("H:i", strtotime($data['to_time']))}}"
                                    />
                                    @error('to_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
        <div class="col-md-12 text-center">
			<button type="submit" onclick="timeCheck()" class="btn btn-primary">{{ __('messages.Update') }}</button><br><br>
		</div>
    	</form>
            </div>
        </div>
    </div>
    </section>
</div>

<script>

$("#quickForm").submit(function(e){
     
  

  var element = document.getElementById("from_time").value;
  var element1 = document.getElementById("to_time").value;
  
  if (element == "") {
  alert("Please Enter Time");
    return false;  
  }

  else {
  
 
 
  // get input time
  var time = element.split(":");
  var hour = time[0];
  if(hour == '00') {hour = 24}
  var min = time[1];
  
   var inputTime = hour+"."+min;
  
  var time1 = element1.split(":");
  var hour1 = time1[0];
  if(hour1 == '00') {hour1 = 24}
  var min1 = time1[1];
  
  var inputTime1 = hour1+"."+min1;
 
  
  var totalTime = inputTime1 - inputTime;
  
 
  if ((Math.abs(totalTime)) > 0.29000000000000004) {
  
  } 
  else {
   
      e.preventDefault();
    alert("Less Time");
  }
    }
  });
   
</script>

@endsection