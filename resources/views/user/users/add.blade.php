@php
$getCountry = Helper::getCountry();
$getState = Helper::getState();
$getCity = Helper::getCity();
$roleType = Helper::roleType();
$sidebar = Helper::getSiderbar();
$getPermisnByBranch = Helper::getPermisnByBranch();
$allPermisn = explode(',',$getPermisnByBranch['branch_sidebar_id']);
$subsidebar  = DB::table('sidebar_sub')->groupBy('sidebar_id')->orderBy('sidebar_id','ASC')->get();
$allowSubSidebar  = explode(',',$getPermisnByBranch['sidebar_sub_id']);
$getSetting = Helper::getSetting();

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
                    <h3 class="card-title"><i class="fa fa-desktop"></i> &nbsp;{{ __('user.Add User') }} </h3>
                    <div class="card-tools">
                    <a href="{{url('viewUser')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{ __('common.View') }}  </a>
                    <a href="{{url('user_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}  </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('addUser') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
        @if(Session::get('role_id') == 1)
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('user.Branch ID') }} *</label>
                                <select class="form-control @error('branch_id') is-invalid @enderror select2" name="branch_id" name="branch_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                @if(!empty($branch)) 
                                          @foreach($branch as $Branch)
                                             <option value="{{ $Branch->id ?? ''  }}">{{ $Branch->branch_name ?? ''  }}</option>
                                          @endforeach
                                @endif                                    
                                </select>
                                @error('branch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        @endif
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.First Name') }} *</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" onkeydown="return /[a-zA-Z ]/i.test(event.key)" id="first_name" name="first_name" value="{{old('first_name')}}" placeholder="{{ __('common.First Name') }}">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                           <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Last Name') }} *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" onkeydown="return /[a-zA-Z ]/i.test(event.key)" id="last_name" name="last_name" value="{{old('last_name')}}" placeholder="{{ __('common.Last Name') }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Mobile No.') }} *</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{old('mobile')}}" placeholder="{{ __('common.Mobile No.') }} " maxlength="10" onkeypress="javascript:return isNumber(event)">
        
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Email') }} *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{old('email')}}" placeholder="{{ __('common.Email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
        
                            </div>
                        </div>                
        		<!--<div class="col-md-2" >
                    <div class="form-group">
                     <label>Country</label>
                      <select class="form-control select2" name="country" id="country_id">
                          @if(!empty($getCountry)) 
                              @foreach($getCountry as $country)
                                 <option value="{{ $country->id ?? ''  }}" {{ ($country->id == Session::get('countries_id')) ? 'selected' : '' }}>{{ $country->name ?? ''  }}</option>
                              @endforeach
                          @endif
                      
                      
                        	@error('country')
        						<span class="invalid-feedback" role="alert">
        							<strong>{{ $message }}</strong>
        						</span>
        					@enderror
                      </select>
                      </div>
                    </div>-->
        			<div class="col-md-2">
        				<div class="form-group"> 
        					<label for="State" class="required"  style="color:red;">{{ __('common.State') }}*</label>
        					<select class="select2 form-control @error('state') is-invalid @enderror" id="state_id" name="state">
        					    <option value="" >{{ __('common.Select') }}</option>
                                @if(!empty($getState)) 
                                      @foreach($getState as $state)
                                         <option value="{{ $state->id ?? ''}}" {{ ($state->id == $getSetting->state_id) ? 'selected' : '' }}>{{ $state->name ?? ''}}</option>
                                      @endforeach
                                @endif
                            </select>
                          	@error('state')
        						<span class="invalid-feedback" role="alert">
        							<strong>{{ $message }}</strong>
        						</span>
        					@enderror        				
        				</div>
        			</div>
        			<div class="col-md-2">
        			    <div class="form-group">
        			        <label for="City" style="color:red;">{{ __('common.City') }}*</label>
        			        <select class="select2 form-control @error('city') is-invalid @enderror" name="city" id="city_id">
        			            <option value="" >{{ __('common.Select') }}</option>
        			            @if(!empty($getCity)) 
                              @foreach($getCity as $cities)
                                 <option value="{{ $cities->id ?? ''  }}" {{ ($cities->id == $getSetting->city_id) ? 'selected' : '' }}>{{ $cities->name ?? ''  }}</option>
                              @endforeach
                                @endif
        					</select>
        					@error('city')
        						<span class="invalid-feedback" role="alert">
        							<strong>{{ $message }}</strong>
        						</span>
        					@enderror        					
        			    </div>
        			</div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Address') }} *</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{old('address')}}" placeholder="{{ __('common.Address') }}">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('user.User Name') }}*</label>
                                <input type="text" class="form-control @error('userName') is-invalid @enderror" id="userName" name="userName" value="{{old('userName')}}" placeholder="{{ __('user.User Name') }}">
                                @error('userName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Password') }}*</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}" placeholder="{{ __('common.Password') }}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
        
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{ __('common.Confirm Password') }}*</label>
                                <input type="text" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" value="{{old('confirm_password')}}" placeholder="{{ __('common.Confirm Password') }}">
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
        
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                              <label style="color:red;">{{ __('user.Role') }}*</label>
                              <div class="input-group mb-3">
                                <select class="form-control @error('role_id') is-invalid @enderror select2" name="role_id" id="role_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($roleType))
                                    @php
                                    $array = [1,2,3];
                                    @endphp
                                    @foreach($roleType as $item)
                                    @if (in_array($item->id, $array)) 
                                    @else
                                    <option value="{{ $item->id ?? ''  }}">{{ $item->name ?? ''  }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                                <div class="input-group-append">
                                    <a href="{{ url('role_add') }}" target="_blank">
                                        <button class="btn btn-primary" type="button" style="height: 100%;">
                                          <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                          </div>
                        </div>    
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('common.Salary') }}</label>
                                <input type="text" class="form-control" id="salary" name="salary" value="{{old('salary')}}" placeholder="{{ __('common.Salary') }}" onkeypress="javascript:return isNumber(event)">
                            </div>
                        </div>                         
                        <div class="col-md-2">
                            <div class="form-group">
                               <label>{{ __('common.Photo') }}</label>
                               <input type="file" class="form-control " id="photo" name="photo" value="{{old('photo')}}" accept="image/png, image/jpg, image/jpeg">
										 <p class="text-danger" id="image_error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color:red;">{{ __('user.Sidebar Permission') }}*</label>
                                    @if(!empty($sidebar))
                                    @foreach($sidebar as $data)
                                        @foreach($allPermisn as $permisnData)
                                            @if($data['id'] == $permisnData)
                                                <div class="custom-control custom-checkbox">
                                                <input name="sidebar_id[]" class="custom-control-input custom-control-input-primary custom-control-input-outline checkbox pointer @error('sidebar_id') is-invalid @enderror" type="checkbox" id="{{ $data->id ?? ''  }}" value="{{ $data->id ?? ''  }}">
                                                <label for="{{ $data->id ?? ''  }}" class="custom-control-label pointer ">
                                                    @if(Session::get('locale') == 'hi')
                                                        <p>{{$data['hindi_name']?? ''}}</p>
                                                    @else
                                                        <p>{{$data['name']?? ''}}</p>
                                                    @endif</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @endif

                                @error('sidebar_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                       
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!--<label>&nbsp;</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="select_all" name="" value="" class="checkbox">
                                    <label for="select_all">{{ __('user.Select All') }} </label>
                                </div>
                            </div> -->                           
                        </div>
       		            <div class="col-md-6">
                	    	<div class="form-group">
                	    	    <label class="d-none" style="color:red;">{{ __('user.Select Action') }}*</label>
                                    <div class="row">
                                       <!-- <div class="col-sm-3">
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="add" name="add" value="1">
                                                    <label for="add">{{ __('common.Add') }}</label>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-sm-3 d-none">
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="edit" name="edit" value="1">
                                                    <label for="edit">{{ __('common.Edit') }}</label>
                                                </div>
                                            </div>
                                        </div>                                 
                                        <div class="col-sm-3 d-none">
                                            <div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="delete" name="delete" value="1">
                                                    <label for="delete">{{ __('common.Delete') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 d-none">
                                            <div class="form-group clearfix">
                                                <div class="icheck-warning d-inline">
                                                    <input type="checkbox" id="download" name="download" value="1">
                                                    <label for="download">{{ __('common.Download') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="col-md-12">
                                    <div class="form-group">
                                        <label style="color:red;"> Sub Panel </label>
                                        <select class="" multiple="multiple" name="sidebar_sub_id[]" id="sidebar_sub_id" style="width: 100%;height: 49pc;">
                                            <option value="">Select</option>
                                           
                                            @if(!empty($subsidebar))
                                                 @foreach($subsidebar as $sub)
                                                  <optgroup label="{{$sub->sidebar_name ?? ''}}" style="display:none" class="sidebar_{{$sub->sidebar_id ?? '' }} local-link">
                                                     @php
                                                     $sidebar2  = DB::table('sidebar_sub')->where('sidebar_id',$sub->sidebar_id)->orderBy('sidebar_id','ASC')->get();
                                                     @endphp
                                                     @if(!empty($sidebar2))
                                                       @foreach($sidebar2 as $sub1)
                                                            @foreach($allowSubSidebar as $allow)
                                                            @if($sub1->id == $allow)
                                                              <option value="{{$sub1->id ?? '' }}" >{{$sub1->name ?? '' }} </option>
                                                               @endif
                                                            @endforeach                                                            
                                                        @endforeach
                                                    @endif

                                                 </optgroup>
                                                @endforeach
                                            @endif

                                             
                                        </select>
                                       
                                    </div>
                                </div>
                                    </div>
                		    </div>
                		</div>                
                    </div>
                    
                    	
                    <div class="row m-2 pb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">{{ __('common.submit') }}</button>
                        </div>
                    </div>
                   
                    
                </form>
            </div>
</div>
</div>
</div>
</section>
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#photo').change(function(e){
            $('#image_error').html("");
            var fileName = $(this).val();
        var extension = fileName.split(".").pop();
        if (
          extension.toLowerCase() === "png" ||
          extension.toLowerCase() === "jpg" ||
          extension.toLowerCase() === "jpeg"
        ) {
            if (e.target.files[0].size > Img_Size) {
                $('#image_error').html("please select Image Size under 2MB");
                $(this).val('');
            }else{
                $('#image_error').html("");
            }
        }else{
            $('#image_error').html("Image Size File");
            $(this).val('');
        }
        });
    });
    </script>
    
    <style>
    #image_error{
        font-weight: bold;
    font-size: 14px;
    }
        .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
    </style>

<script>
    $("#select_all").change(function () {  
        $(".checkbox").prop('checked', $(this).prop("checked")); 
    });
    
    $(".checkbox").click(function(){
        var id = $(this).attr('id');
        var name = $(this).attr('data-name');
      if ($(this).is(':checked')) {
     $('.sidebar_'+id).show();
      }else {
         $('.sidebar_'+id).hide();
      }
}); 
    
$( "#role_id" ).change(function() {
    var basurl = "{{ url('/') }}";
    var role_id = $(this).val()
 
    $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
    $.ajax({
        type: "POST",
        url: basurl+"/user_side_per",
        data: {role_id:role_id},
        dataType: "html",
        success: function (response) {
              $(".checkbox").prop('checked', false);
         var side_bar = response;
          var words = side_bar.split(",");


        for(var i=0; i<=words.length; i++)
         {
            $("#"+words[i]).prop('checked', true);
         }
         
        },

    });  
});
</script>

@endsection