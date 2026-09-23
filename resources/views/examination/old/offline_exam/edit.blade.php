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
                    <h3 class="card-title"><i class="nav-icon fas fa fa-edit"></i> &nbsp;{{ __('examination.Edit Exam') }} </h3>
                    <div class="card-tools">
                    <a href="{{url('view/exam')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i><span class="Display_none_mobile">{{ __('messages.Back') }}</span>  </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('edit_offline_exam') }}/{{ $data->id ?? '' }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">

                       <div class="col-md-3">
            			<div class="form-group">
            				<label style="color:red;">{{ __('examination.Exam Name') }} :*</label>
            				<input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Exam Name" value="{{ $data['name'] ?? '' }}">
                             @error('name')
            					<span class="invalid-feedback" role="alert">
            						<strong>{{ $message }}</strong>
            					</span>
            				@enderror
            		    </div>
            		</div>
                       <div class="col-md-3">
            			<div class="form-group">
            				<label >{{ __('Exam Start Date') }} :</label>
            				<input type="date"  name="start_date" class="form-control "  value="{{ $data['start_date'] ?? '' }}">
                             
            		    </div>
            		</div>

            	
       
                   
        		
		        </div>

                <div class="row m-2 pb-2">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary ">{{ __('messages.Update') }}</button>
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