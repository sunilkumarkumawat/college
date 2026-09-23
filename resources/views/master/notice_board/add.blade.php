        @php
   $getRole = Helper::roleType();
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
                            <h3 class="card-title"><i class="fa fa-envelope"></i> &nbsp;  {{ __('master.Add Notice') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('notice_board/view')}}/{{0}}" class="btn btn-primary  btn-sm" title="View Notice Bord"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
                                <a href="https://demo3.rusoft.in/master_dashboard" class="btn btn-primary  btn-sm" title="Back "><i class="fa fa-arrow-left"></i>Back   </a>
                            </div>
                        </div>        
                        <form id="quickForm" action="{{ url('notice_board/add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row m-2">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"style="color:red;">{{ __('master.Title') }}*</label>
                                        <input autofocus="title" class="form-control @error('title') is-invalid @enderror"id="title" name="title" placeholder="{{ __('master.Title') }}" type="text" value="" />
                                        @error('title')
                    						<span class="invalid-feedback" role="alert">
                    							<strong>{{ $message }}</strong>
                    						</span>
                				        @enderror
                                    </div>
                                    <div class="form-group"><label style="color:red;">{{ __('master.Message') }}*</label>
                                        <textarea   class="form-control @error('message') is-invalid @enderror"id="compose-textarea" name="message"  style="height: 300px;"> </textarea>
                                        @error('message')
                    						<span class="invalid-feedback" role="alert">
                    							<strong>{{ $message }}</strong>
                    						</span>
                				        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"style="color:red;">{{ __('master.From Date') }}*</label><small class="req"> *</small>
                                        <input class="form-control @error('from_date') is-invalid @enderror"id="from_date" name="from_date"  placeholder="From Date" type="date"  value="" />
                                        @error('from_date')
                    						<span class="invalid-feedback" role="alert">
                    							<strong>{{ $message }}</strong>
                    						</span>
                				        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"style="color:red;">{{ __('master.To Date') }}*</label><small class="req"> *</small>
                                        <input class="form-control @error('to_date') is-invalid @enderror"id="to_date" name="to_date"  placeholder="To Date" type="date"   value="" />
                                        @error('to_date')
        						            <span class="invalid-feedback" role="alert">
                    							<strong>{{ $message }}</strong>
                    						</span>
                    			    	@enderror
                                    </div>
                                    <div class="form-horizontal">
                                        <label for="exampleInputEmail1"style="color:red;">{{ __('master.Send To') }}*</label>
                                        @if(!empty($getRole)) 
                                            @foreach($getRole as $type)
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="role_id[]" value="{{ $type['id'] ?? '' }}"  /> <b>{{ $type['name'] ?? '' }}</b> </label>
                                                </div>                             
                                            @endforeach
                                        @endif
                                    </div>
                                </div>  
                             	<div class="col-md-12 text-center">
    								<button type="submit" class="btn btn-primary">{{ __('common.Submit') }}</button>
    							</div>
                            </div>
                        </form>
                	</div>
                </div>  
            </div>                      
        </div>
    </section>
</div>
@endsection  