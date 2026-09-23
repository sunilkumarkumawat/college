@php
  $classType = Helper::classType();
 
    
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
							<h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;Event Management</h3>
							<div class="card-tools"> <a href="{{url('event_management_view')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> view</a> </div>
						</div>
						<div class="card-body">
						<form id="quickForm" action="{{ url('event_management') }}" method="post" enctype="multipart/form-data"> 
						    @csrf						
						 	<div class="row m-2">
								<div class="col-md-4">
									<div class="form-group">
										<label style="color:red;">Class*</label>
            				<select class="form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" value="{{old('class_type_id')}}">
                            <option value="" >Select</option>
                             @if(!empty($classType)) 
                                  @foreach($classType as $type)
                                     <option value="{{ $type->id ?? ''  }}" >{{ $type->name ?? ''  }}</option>
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
            		
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: red;">Student Name*</label>
										<input class="form-control  @error('student_name') is-invalid @enderror" type="text" id="student_name" name="student_name" placeholder="Student Name" value="{{ $data->student_name ??  '' }}"> 
                                        @error('student_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: red;">Event Name*</label>
										<input class="form-control  @error('event_name') is-invalid @enderror" type="text" id="event_name" name="event_name" placeholder="Event Name" value="{{ $data->event_name ??  '' }}"> 
                                        @error('event_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
                
            </div>
							
        					 <div class="row m-2 pb-2">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                </div>
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