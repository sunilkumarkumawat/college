@extends('layout.app')
@section('content')


 <div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{__('master.Edit Message Type') }} </h3>
                            <div class="card-tools">
                                        <a href="{{url('messageType')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> {{ __('View') }} </a>
                                        <a href="{{url('messageDashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>

                        </div>
                            </div>                      
                                  <form id="quickForm" action="{{ url('messageTypeEdit') }}/{{$data['id'] ?? ''}}" method="post">
    @csrf

    <div class="row m-2">

        {{-- Message Type Name --}}
        <div class="col-md-4">
            <label class="text-danger">Message Type Name *</label>
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   name="name"
                   value="{{ $data->name ?? old('name') }}"
                   placeholder="Message Type Name"
                   onkeydown="return /[a-zA-Z ]/i.test(event.key)">

            @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Template Name --}}
        <div class="col-md-4">
            <label class="text-danger">Template Name *</label>
            <input type="text"
                   class="form-control @error('template_name') is-invalid @enderror"
                   name="template_name"
                   value="{{ $data->template_name ?? old('template_name') }}"
                   placeholder="Template Name">

            @error('template_name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    </div>

    {{-- Template Content --}}
    <div class="row m-2">
        <div class="col-md-12">
            <label class="text-danger">Template Content *</label>
            <textarea class="form-control @error('template_content') is-invalid @enderror"
                      name="template_content"
                      rows="5"
                      placeholder="Write template content here...">{{ $data->template_content ?? old('template_content') }}</textarea>

            @error('template_content')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row m-2">
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">
                {{ __('common.Update') }}
            </button>
        </div>
    </div>

</form>

                </div>
            </div>
        </div>
    </section>
</div>
 
@endsection

