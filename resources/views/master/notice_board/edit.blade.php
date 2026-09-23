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
                    <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('master.Edit Notice') }}  </h3>
                    <div class="card-tools">
                    <a href="{{url('notice_board/view')}}/{{0}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('notice_board/edit') }}/{{($data->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
        
                        <div class="col-md-8">
                             <div class="form-group">
                             <label for="exampleInputEmail1"style="color:red;">{{ __('master.Title') }}*</label>
                                    <input autofocus="" id="title" name="title" placeholder="{{ __('master.Title') }}" type="text" class="form-control @error('title') is-invalid @enderror"  value="{{ $data['title'] ?? '' }}" />
                                        @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group"><label style="color:red;">{{ __('master.Message') }}*</label>
                                    <textarea id="compose-textarea" name="message" class="form-control @error('message') is-invalid @enderror" value="{{ $data['message'] ?? '' }}" style="height: 260px;">{{ $data['message'] ?? '' }}</textarea>
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
                                            <input id="from_date" name="from_date"  placeholder="From Date" type="date" class="form-control date"  value="{{ $data['from_date'] ?? '' }}" />
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"style="color:red;">{{ __('master.To Date') }}*</label><small class="req"> *</small>
                                            <input id="to_date" name="to_date"  placeholder="To Date" type="date" class="form-control date"  value="{{ $data['to_date'] ?? '' }}" />
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-horizontal">
                                            <label for="exampleInputEmail1">{{ __('master.Send To') }}</label>
                                           
                                        @php
                                            $roleId =explode(",",$data['role_id']);
                                         @endphp                                       
                                        @if(!empty($getRole)) 
                                            @foreach($getRole as $type)
                                                <div class="checkbox">
                                                    <input type="checkbox" name="role_id[]" value="{{ $type['id'] ?? '' }}"  
                                                    {{ in_array($type->id, $roleId)  ? 'checked' : '' }}> <b>{{ $type['name'] ?? '' }}</b> 
                                                </div>                             
                                            @endforeach
                                        @endif    
                                           
                                           
                                        
                                    </div>
                                </div>  
                             
                             	<div class="col-md-12 text-center">
									<button type="submit" class="btn btn-primary">{{ __('common.Update') }}</button>
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