<div class="row">
    <div class="col-md-12">
        <div class="tab-content">
                <form id="quickForm" action="{{url('reporting')}}" method="post">
                    @csrf
                    <div class="row m-2">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Department </label>
                                <select class="form-control " id="" name="department_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    
                                    <option value="school" {{ ( 'school'==$search[ 'department_id']) ? 'selected' : 'selected' }}>School</option>
                                     <option value="hostel" {{ ( 'hostel'==$search[ 'department_id']) ? 'selected' : '' }}>Hostel </option>
                                       <option value="library" {{ ( 'library' ==$search[ 'department_id']) ? 'selected' : '' }}>Library </option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                    		<div class="form-group">
                    			<label>From Date</label>
                                    <input type="date" class="form-control " id="starting" name="starting" value="{{$search['starting'] ?? ''}}">                 	    
                            </div>
                    	</div>
                    	<div class="col-md-2">
                            <div class="form-group ">
                                <label>To Date</label>
                                    <input type="date" class="form-control " id="ending" name="ending" value="{{$search['ending'] ?? ''}}">
                			</div> 
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>{{ __('common.Class') }}</label>
                                <select class="form-control select2" id="class_type_id" name="class_type_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($classType)) @foreach($classType as $type)
                                    <option value="{{ $type->id ?? ''  }}" {{ ( $type[ 'id']==$search[ 'class_type_id']) ? 'selected' : '' }}>{{ $type->name ?? '' }}</option>
                                    @endforeach @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 stream_show" id="stream_id_div" style="display:none">
                            <div class="form-group">
                                <label>{{ __('common.Stream') }}</label>

                                <select class="form-control select2" id="stream_id" name="stream_id">

                                    <option value="">{{ __('common.Select') }}</option>
                                    <option value="Arts" {{ ( "Arts"==$search[ 'stream_id']) ? 'selected' : ''}}>Arts</option>
                                    <option value="Science" {{ ( "Science"==$search[ 'stream_id']) ? 'selected' : ''}}>Science</option>
                                    <option value="Commerce" {{ ( "Commerce"==$search[ 'stream_id']) ? 'selected' : ''}}>Commerce</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Session') }}</label>
                                <select class="form-control select2 session_id @error('session_id') is-invalid @enderror" id="" name="session_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($getSession)) @foreach($getSession as $type)
                                    <option value="{{ $type->id ?? ''  }}" {{ ( $type[ 'id']==$search[ 'session_id']) ? 'selected' : '' }}>{{ $type->from_year ?? '' }} - {{ $type->to_year ?? '' }}</option>
                                    @endforeach @endif
                                </select>
                                @error('session_id')
                                <span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span> 
            					@enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Payment Mode</label>
                                <select class="form-control " id="" name="payment_mode_id">
                                    <option value="">{{ __('common.Select') }}</option>
                                    @if(!empty($getPaymentMode)) @foreach($getPaymentMode as $mode)
                                    <option value="{{ $mode->id ?? ''  }}" {{ ( $mode[ 'id']==$search[ 'payment_mode_id']) ? 'selected' : '' }}>{{ $mode->name ?? '' }} </option>
                                    @endforeach @endif
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-1 ">
                            <label class="text-white">{{ __('Session') }}</label>
                            <input type="submit" class="btn btn-primary" name="button_value" value="Search" />
                        </div>
                        <div class="col-md-1 ">
                            
                            <input type="submit" class="btn btn-primary" name="PaymentMode" value="Pay Mode" />
                        </div>
                        <div class="col-md-1 ">
                            
                            <input type="submit" class="btn btn-primary" name="pending_fees" value="Pending Fees" />
                        </div>
                    </div>

                </form>
        </div>

    </div>
</div>