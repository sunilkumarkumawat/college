@php
   $getUser = Helper::getUser();
   $getstudents = Helper::getstudents();
   $getgenders = Helper::getgender();
   $classType = Helper::classType();
   $getCountry = Helper::getCountry();
   $getState = Helper::getState();
   $getCity = Helper::getCity();
   $teacher = DB::table('teachers')->where('id',Session::get('teacher_id'))->whereNull('deleted_at')->first();
@endphp

@extends('layout.app') 
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">

                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-user-circle-o"></i> &nbsp; View Profile</h3>
                    <div class="card-tools">
                      <a href="{{url('dashboard')}}" class="btn btn-primary  btn-xs"><i class="fa fa-arrow-left"></i> <span class="">{{ __('Back') }} </span></a>
                    </div>
                </div> 
              <div class="card-body box-profile">
                  <form id="quickForm" action="{{ url('profile/edit') }}/{{Session::get('id') ?? '' }}" method="post" enctype="multipart/form-data">
                     @csrf
                  <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            @if(Session::get('role_id')==3)  
                                <img class="profile-user-img img-fluid rounded-circle" src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" style="width:100px; height:100px;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                            @else
                                <img class="profile-user-img img-fluid rounded-circle" src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" style="width:100px; height:100px;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                            @endif                            
                        </div>
                    </div>
                <div class="container rounded bg-white">
                    <div class="row">
                            <div class="col-md-3">
    	    	                <div class="form-group">
    				                <label>Profile Photo</label>
    				                @if(!empty($teacher))
    				                    <input type="file" {{$teacher->teacher_update == 1 ? 'disabled' : ''}} class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ $data['photo'] ?? ""  }}">
    				                @else
    				                    <input type="file"  class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ $data['photo'] ?? ""  }}">
    		                        @endif
    		                        @error('photo')
            		                <span class="invalid-feedback" role="alert">
            			            <strong>{{ $message }}</strong>
            		                </span>
            			            @enderror
    		                    </div>
    		                </div>
		                
                      	   <div class="col-md-3">
                            <lable>Father Photo</lable>
                            <div class="input file form-control @error('father_img') is-invalid @enderror">
                                <input type="file"  name="father_img" id="father_img" value="{{ $data['father_img'] ?? '' }}">
                                @error('father_img')
                					<span class="invalid-feedback" role="alert">
                						<strong>{{ $message }}</strong>
                					</span>
                				@enderror
                            </div>  
                        </div>
                
                    	<div class="col-md-3">
                            <lable>Mother Photo</lable>
                            <div class="input file form-control @error('mother_img') is-invalid @enderror">
                                <input type="file"  name="mother_img" id="mother_img" value="{{ $data['mother_img'] ?? '' }}">
                                @error('mother_img')
                					<span class="invalid-feedback" role="alert">
                						<strong>{{ $message }}</strong>
                					</span>
                				@enderror
                            </div>  
                        </div>
                    
		                 <div class="col-md-3">
            				<div class="form-group"> 
            					<label>User Name</label>
            					<input type="text" class="form-control "  value="{{ $data['userName'] ?? ""  }}" placeholder="User Name">
            				</div>
            			</div>
            			
                        <div class="form-group col-md-3">
                            <label> Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ $data['first_name'] ?? ""  }}" placeholder="First name">
                            @error('first_name')
    		                <span class="invalid-feedback" role="alert">
    			                <strong>{{ $message }}</strong>
    		                </span>
    			            @enderror
			            </div>
			            
			        <!--    <div class="form-group col-md-3">
                            <label>Last name:</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror " name="last_name" id="last_name" value="{{ $data['last_name'] ?? ""  }}" placeholder="Last name">
                            @error('last_name')
    		                <span class="invalid-feedback" role="alert">
    			                <strong>{{ $message }}</strong>
    		                </span>
    			            @enderror
			            </div>-->
			            
		            @if(Session ::get('role_id') == 3)            
                		 <div class="col-md-3">
                	    	<div class="form-group">
                				<label style="color:red;"> Aadhaar no.*</label>
                				<input type="text" class="form-control @error('aadhaar') is-invalid @enderror" id="aadhaar" name="aadhaar" placeholder=" Aadhaar no." value="{{ $data['aadhaar'] ?? '' }}" maxlength="12" onkeypress="javascript:return isNumber(event)" readonly>
                				 @error('aadhaar')
                					<span class="invalid-feedback" role="alert">
                						<strong>{{ $message }}</strong>
                					</span>
                				@enderror
                		    </div>
                		</div>	
                		
                		 <div class="col-md-3">
                            <div class="form-group">
                              <label style="color:red;">Gender*</label>
                              <select class="form-control @error('gender_id') is-invalid @enderror" id="gender_id" name="gender_id" disabled>
                				<option value="">Select</option>
                                @if(!empty($getgenders)) 
                                      @foreach($getgenders as $value)
                                         <option value="{{ $value->id}} " {{ ( $value->id == $data['gender_id'] ? 'selected' : '' ) }}>{{ $value->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                                 @error('gender_id')
                					<span class="invalid-feedback" role="alert">
                						<strong>{{ $message }}</strong>
                					</span>
                				@enderror
                            </div>
                        </div>
                            
                        <div class="col-md-3">
                			<div class="form-group">
                				<label >Class</label>
                			
                				<select class="form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" disabled>
                				   <option value="">Select</option>
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
		
                	   <!--<div class="col-md-3">
                			<div class="form-group">
                				<label style="color:red;">Admission Type*</label>
                			
                				<select class="form-control @error('admission_type_id') is-invalid @enderror" id="admission_type_id" name="admission_type_id" disabled>
                                    <option value="">Select</option>
                                    <option value="1" {{ $data['admission_type_id'] == 1 ? "selected" : "" }}>Regular</option>
                                    <option value="2" {{ $data['admission_type_id'] == 2 ? "selected" : "" }}>Non</option>
                                    <option value="3" {{ $data['admission_type_id'] == 3 ? "selected" : "" }}>Other</option>
                                 </select>
                                 @error('admission_type_id')
                				<span class="invalid-feedback" role="alert">
                					<strong>{{ $message }}</strong>
                				</span>
                			@enderror
                		    </div>
                		</div>-->     
	                @endif	
		
	            		<div class="col-md-3">
            				<div class="form-group"> 
            					<label>Date Of Birth :</label>
            					<input type="date"class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ $data['dob'] ?? ""  }}" placeholder="Date Of Birth" >
            					@error('dob')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror
                            </div>
            			</div>
            			
		               <div class="form-group col-md-3">
                            <label>Mobile:</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror " name="mobile" id="mobile" value="{{ $data['mobile'] ?? ""  }}" placeholder="Mobile" maxlength="10" onkeypress="javascript:return isNumber(event)" >
                                @error('mobile')
        		                <span class="invalid-feedback" role="alert">
        			            <strong>{{ $message }}</strong>
        		                </span>
        			            @enderror
			            </div>
			            
			            <div class="form-group col-md-3">
                            <label>Email:</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror " name="email" id="email" value="{{ $data['email'] ?? ""  }}" placeholder="Email" >
                                @error('email')
        		                <span class="invalid-feedback" role="alert">
        			            <strong>{{ $message }}</strong>
        		                </span>
        			            @enderror
			            </div>
			            
			            
			            <div class="form-group col-md-3">
                            <label>Father name:</label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror " name="father_name" id="father_name" value="{{ $data['father_name'] ?? ""  }}" placeholder="Father Name" >
                            @error('father_name')
    		                <span class="invalid-feedback" role="alert">
    			            <strong>{{ $message }}</strong>
    		                </span>
    			            @enderror
			            </div>
			            
			            @if(Session::get('role_id') == 3)
			            
			            <div class="form-group col-md-3">
                            <label>Mother name:</label>
                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror " name="mother_name" id="father_name" value="{{ $data['mother_name'] ?? ""  }}" placeholder="Mother Name" >
                            @error('mother_name')
    		                <span class="invalid-feedback" role="alert">
    			            <strong>{{ $message }}</strong>
    		                </span>
    			            @enderror
			            </div>
			       
			            
		            	 <div class="col-md-3">
                	    	<div class="form-group">
                				<label>Father's Contact No.</label>
                				<input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder=" Father's Contact No." value="{{ $data['father_mobile'] ?? '' }}" maxlength="10" onkeypress="javascript:return isNumber(event)" >
                		    </div>
                		  </div>
                    		  
            		    @endif
            		    
            			<div class="col-md-3" >
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control select2" name="country_id" id="country_id"  >
                                    @if(!empty($getCountry)) 
                                      @foreach($getCountry as $country)
                                         <option value="{{ $country->id ?? ''  }}" {{ ( $country['id'] == $data['country_id']) ? 'selected' : '' }}>{{ $country->name ?? ''  }}</option>
                                      @endforeach
                                    @endif
                                    
                              
                                	@error('country_id')
                						<span class="invalid-feedback" role="alert">
                							<strong>{{ $message }}</strong>
                						</span>
                					@enderror
                                </select>
                            </div>
                        </div>
                        
            			<div class="col-md-3">
            				<div class="form-group"> 
            					<label for="State" class="required">State</label>
            					<select class="form-control" id="state_id" name="state_id" >
                                    @if(!empty($getState)) 
                                        @foreach($getState as $state)
                                            <option value="{{ $state->id ?? ''}}" {{ ( $state['id'] == $data['state_id']) ? 'selected' : '' }}>{{ $state->name ?? ''}}</option>
                                        @endforeach
                                    @endif
                                    
                                  	@error('state_id')
                						<span class="invalid-feedback" role="alert">
                							<strong>{{ $message }}</strong>
                						</span>
                					@enderror
                                </select>
            				</div>
            			</div>
            			
            			<div class="col-md-3">
            			    <div class="form-group">
            			        <label for="City">City</label>
            			        <select class="form-control" name="city_id" id="city_id"  >
            			            @if(!empty($getCity)) 
                                  @foreach($getCity as $cities)
                                     <option value="{{ $cities->id ?? ''  }}" {{ ( $cities['id'] == $data['city_id']) ? 'selected' : '' }}>{{ $cities->name ?? ''  }}</option>
                                  @endforeach
                              @endif
            					
            					@error('city_id')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror
            					</select>
            			    </div>
            			</div>
            			
            			<div class="col-md-3">
            				<div class="form-group"> 
            					<label>Address :</label>
            					<input type="text"class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $data['address'] ?? ""  }}" placeholder="Address" >
            					@error('address')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror
                            </div>
            			</div>
            			
            			<div class="col-md-3">
            				<div class="form-group"> 
            					<label>Pin Code :</label>
            					<input type="text"class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ $data['pincode'] ?? ""  }}" placeholder="Pin Code" >
            					@error('pincode')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror
                            </div>
            			</div>
                    </div>
                </div>
                            
               
                    <div class="col-md-12 text-center">
    		           <button type="submit" class="btn btn-primary btn-sm">Update</button>
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