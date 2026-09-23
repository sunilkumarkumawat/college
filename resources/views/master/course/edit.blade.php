@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('Edit Course') }} </h3>
                            <div class="card-tools">
                                <a href="{{url('course_add')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>
                        </div>                      

                        <form id="quickForm" action="{{ url('course_edit') }}/{{$data['id']}}" method="post">
                            @csrf
                            <div class="row mb-2 m-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Course Name') }}* </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('Course Name') }}" value="{{ $data['name'] ?? '' }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Course Type') }}* </label>
                                        <select class="form-control" id="course_type" name="course_type" required onchange="calculateSemesters()">
                                            <option value="Semester" {{ (($data['course_type'] ?? 'Semester') == 'Semester') ? 'selected' : '' }}>Semester Wise</option>
                                            <option value="Yearly" {{ (($data['course_type'] ?? '') == 'Yearly') ? 'selected' : '' }}>Yearly Wise</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Duration (Years)') }}* </label>
                                        <select class="form-control" id="duration" name="duration" required onchange="calculateSemesters()">
                                            <option value="1" {{ (($data['duration'] ?? 1) == 1) ? 'selected' : '' }}>1 Year</option>
                                            <option value="2" {{ (($data['duration'] ?? 1) == 2) ? 'selected' : '' }}>2 Years</option>
                                            <option value="3" {{ (($data['duration'] ?? 1) == 3) ? 'selected' : '' }}>3 Years</option>
                                            <option value="4" {{ (($data['duration'] ?? 1) == 4) ? 'selected' : '' }}>4 Years</option>
                                            <option value="5" {{ (($data['duration'] ?? 1) == 5) ? 'selected' : '' }}>5 Years</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Total Semesters') }}* </label>
                                        <input type="number" class="form-control" id="total_semester" name="total_semester" min="0" max="12" value="{{ $data['total_semester'] ?? 0 }}" required>
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

<script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
<script>
    function calculateSemesters() {
        var type = $('#course_type').val();
        var duration = parseInt($('#duration').val()) || 1;
        if (type === 'Yearly') {
            $('#total_semester').val(0);
        } else {
            $('#total_semester').val(duration * 2);
        }
    }
</script>

@endsection