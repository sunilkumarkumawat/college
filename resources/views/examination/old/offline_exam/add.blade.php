@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary flex_items_toggel">
                    <h3 class="card-title"><i class="nav-icon fas fa fa-leanpub"></i> &nbsp;Add Exams</h3>
                    <div class="card-tools">
                    <a href="{{url('view/exam')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i><span class="Display_none_mobile"> {{ __('messages.View') }} </span> </a>
                    <a onclick="history.back()" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile"> {{ __('messages.Back') }}</span> </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('add_offline_exam') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
                       <div class="col-md-3 col-12">
            			<div class="form-group">
            				<label style="color:red;">{{ __('messages.Exam Name') }}</label>
            				<input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Exam Name" value="{{old('name')}}">
                             @error('name')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div>
                       <div class="col-md-3 col-12">
            			<div class="form-group">
            				<label >{{ __('Exam Start Date') }}</label>
            				<input type="date"  name="start_date" class="form-control"  value="{{old('start_date')}}">
                            
            		    </div>
            		</div>
            		
            		
                   
        		
           
                
		        </div>

                <div class="row m-2 pb-2">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary ">{{ __('messages.Submit') }}</button>
                    </div>
                </div>
                
            
            </form>
</div>
</div>
</div>
</div>
</section>
</div>

<script>
    $("[type='number']").keypress(function (evt) {
    evt.preventDefault();
    
    alert("Use only Buttons For Increase/Decrease Time")
    
});

 window.onload=function(){
var today = new Date().toISOString().split('T')[0];
document.getElementsByName("exam_date")[0].setAttribute('min', today);

var now = new Date();

var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);

var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

document.getElementsByName("exam_date")[0].value = today;
    }

</script>



@endsection