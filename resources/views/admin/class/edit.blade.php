@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('Edit Class / Semester') }} </h3>
                            <div class="card-tools">
                                <a href="{{url('add_class')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>
                        </div>                      

                        <form id="quickForm" action="{{ url('edit_class') }}/{{$data['id']}}" method="post">
                            @csrf
                            <div class="row mb-2 m-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Course') }}* </label>
                                        <select class="form-control select2 @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($courses))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ (($data['course_id'] ?? '') == $course->id) ? 'selected' : '' }}>
                                                        {{ $course->name }} ({{ $course->duration }} {{ $course->duration > 1 ? 'Yrs' : 'Yr' }})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('course_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Class / Semester Name') }}* </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g. BA 1st Sem" value="{{ $data['name'] ?? '' }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('common.Update') }}</button><br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

@endsection