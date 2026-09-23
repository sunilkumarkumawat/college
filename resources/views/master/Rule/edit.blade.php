@php
$roleType = Helper::roleType();

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
                            <h3 class="card-title"><i class="fa fa-image"></i> {{ __('master.Edit Rule') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('rules_add')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-eye"></i> {{ __('View') }}</a>
                                <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="View Gallery"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>

                        </div>
                        <form id="quickForm" action="{{ url('rules_edit') }}/{{$data['id']}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row m-2">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('common.Name') }}*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" placeholder="{{ __('common.Name') }}" value="{{$data['name'] ?? ''}}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('master.Role Name') }}*</label>
                                        <select class="select2 form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                            <option value="">Select</option>
                                            @if(!empty($roleType))
                                            @foreach($roleType as $item)
                                            <option value="{{ $item->id ?? ''  }}"{{ ( $item['id'] == $data['role_id'] ??  old('role_id')) ? 'selected' : '' }}>{{ $item->name ?? ''  }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('master.Description') }}</label>
                                        <textarea class="form-control " type="text" id="description" name="description" placeholder="{{ __('master.Description') }}">{{$data['description'] ?? ''}}</textarea>

                                    </div>
                                </div>

                            </div>
                            <div class="row m-2">

                                <div class="col-md-12 mt-3 mb-3 text-center">
                                    <button type="submit" class="btn btn-primary ">{{ __('common.Submit') }}</button>
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