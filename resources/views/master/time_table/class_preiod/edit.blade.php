@php
$classType = Helper::classType();
$getSection = Helper::getSection();
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
							<h3 class="card-title"><i class="fa fa-calendar-times-o"></i> &nbsp; TimeTable</h3>
							<div class="card-tools"> <a href="{{url('class/preiod/add')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back</a> </div>
						</div>
						<form id="quickForm" action="{{ url('class/preiod/edit') }}/{{ $data['id'] ?? '' }}" method="post" enctype="multipart/form-data"> 
						    @csrf
            <div class="row m-2">
                
                
                
                
                
                
                <div class="col-md-2">
			<div class="form-group">
				<label  style="color:red;">Class*</label>
				
				<select class="form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" value="{{old('class_type_id')}}">
				   <option value="">Class</option>
                 @if(!empty($classType)) 
                      @foreach($classType as $type)
                         <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == $data['class_type_id'] ? 'selected' : '' ) }} >{{ $type->name ?? ''  }}</option>
                      @endforeach
                  @endif
                </select>
                 @error('class_type_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		    </div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label  style="color:red;">Section*</label>
				
					<select class="form-control @error('section_id') is-invalid @enderror section_id" id="section_id" name="section_id">
				   <option value="" >Section</option>
                 @if(!empty($getSection)) 
                      @foreach($getSection as $section)
                         <option value="{{ $section->id ?? ''  }}" {{ ( $section->id == $data['section_id'] ? 'selected' : '' ) }}>{{ $section->name ?? ''  }}</option>
                      @endforeach
                  @endif
                </select>
                 @error('section_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		    </div>
		</div>
     
           
                	<div class="col-md-2">
	    	<div class="form-group">
				<label   style="color:red;">Preiod Name*</label>
				<input type="text" class="form-control @error('preiod_name') is-invalid @enderror" id="preiod_name" name="preiod_name" placeholder=" Preiod Name" value="{{ $data['preiod_name']}}">
		         @error('preiod_name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		    </div>
		</div>
	
    	<div class="col-md-2">
	    	<div class="form-group">
				<label   style="color:red;">Start Time*</label>
				<input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" placeholder=" Start Time" value="{{$data['start_time'] ?? ''}}">
		         @error('start_time')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		    </div>
		</div>
    		<div class="col-md-2">
    			<div class="form-group">
    				<label style="color:red;">End Time*</label>
    				<input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" placeholder=" End Time" value="{{$data['end_time'] ?? ''}}">
    		        @error('end_time')
    					<span class="invalid-feedback" role="alert">
    						<strong>{{ $message }}</strong>
    					</span>
    				@enderror
    		    </div>
    		</div>
  
        <div class="col-md-12 text-center">
			<button type="submit" class="btn btn-info ">Update</button><br><br>
		</div>
    	</form>
</div>
</div>
</div>
</div>
</div>
</section>
</div>

@endsection