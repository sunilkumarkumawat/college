@php
$all_class = Helper::classType();
$getSection = Helper::getSection();
//dd($data);
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
                            <h3 class="card-title"><i class="fa fa-edit"></i> {{ __('master.Edit Section-class') }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{url('master/class_add')}}" class="btn btn-primary  btn-sm"><i
                                        class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>

                            </div>
                        </div>

                        <form id="quickForm" action="{{ url('master/class_edit') }}/{{$data['id']}}" method="post">
                            @csrf
                            <div class="row mb-2 m-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('master.Class Type') }}*</label>

                                        <select class="select2 form-control @error('class_id') is-invalid @enderror"
                                            id="class_id" name="class_id" value="{{old('class_id')}}">

                                            @if(!empty($all_class))
                                            @foreach($all_class as $class)
                                            <option value="{{ $class->id ?? ''  }}" {{ ($class->id == $data['class_id']) ? 'selected' : '' }}>{{ $class->name ?? '' }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('class_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('master.Section') }}*</label>

                                        <select class="form-control select2 @error('section_id') is-invalid @enderror" id="section_id"
                                            name="section_id" value="{{$data['section_id'] ?? ''}}">

                                            @if(!empty($section))
                                            @foreach($section as $class)
                                            <option value="{{ $class->id ?? ''  }}" {{ ($class->id == $data['section_id']) ? 'selected' : '' }}>{{ $class->name ?? '' }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('section')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary ">{{ __('common.Update')
                                    }}</button><br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection