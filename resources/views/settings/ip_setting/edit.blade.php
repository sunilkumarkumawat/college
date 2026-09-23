
@extends('layout.app')
@section('content')


<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('ip_setting.Edit IP Setting') }} </h3>
                    <div class="card-tools">
                    <a href="{{url('view_ip_setting')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{ __('View') }} </a>
                    <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('edit_ip_setting') }}/{{ $data->id ?? '' }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
            
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;">{{__('setting.IP Address') }} *</label>
                                <input type="text" class="form-control @error('ip_address') is-invalid @enderror" id="ip_address" name="ip_address" value="{{ $data->ip_address ?? '' }}" placeholder="{{__('setting.IP Address') }}">
                                @error('ip_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                           <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('setting.Remark') }}</label>
                                <input type="text" class="form-control @error('remark') is-invalid @enderror" id="remark" name="remark" value="{{ $data->remark ?? '' }}" placeholder="{{ __('setting.Remark') }}">
                                @error('remark')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row m-2 pb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">{{ __('common.Update') }}</button>
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