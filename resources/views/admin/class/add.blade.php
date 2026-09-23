@php
   $getCountry = Helper::getCountry();
   $getState = Helper::getState();
   $getCity = Helper::getCity();
   $getPermission = Helper::getPermission();
   $getAllBranch = Helper::getAllBranch();
@endphp
@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">    
                <div class="col-md-4 pr-0 {{ ($getPermission->add == 1) ? '' : 'd-none'}}">
                    <div class="card card-outline card-orange mr-1">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-book"></i> &nbsp;{{ __('Add Class / Semester') }} </h3>
                            <div class="card-tools"></div>
                        </div>

                        <form id="quickForm" action="{{ url('add_class') }}" method="post">
                            @csrf
                            <div class="row m-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Course') }} *</label>
                                        <select class="form-control select2 @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($courses))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ (old('course_id') == $course->id) ? 'selected' : '' }}>
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-danger">{{ __('Class / Semester Name') }} *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g. BA 1st Sem, BCA 2nd Sem" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row m-2">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="submitButton">{{ __('common.submit') }} </button>
                                </div>
                            </div>
                        </form>
                    </div>          
                </div>
        
                <div class="{{ ($getPermission->add == 1) ? 'col-md-8 pl-0' : 'col-md-12 pl-0'}}">
                    <div class="card card-outline card-orange ml-1">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-list"></i> &nbsp;{{ __('View Class / Semester') }} </h3>
                            <div class="card-tools">
                                <a href="{{url('master_dashboard')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }}</a>
                            </div>
                        </div>                 
                        
                        <div class="row m-2">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline">
                                    <thead class="bg-primary">
                                        <tr role="row">
                                            <th>{{ __('common.SR.NO') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Class / Semester') }}</th>
                                            @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                                <th>{{ __('common.Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($data))
                                            @php $i = 1; @endphp
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $item->course->name ?? 'General' }}
                                                        </span>
                                                    </td>
                                                    <td><strong>{{ $item['name'] }}</strong></td>
                                                    @php
                                                        $admissions = DB::table('admissions')->where('class_type_id', $item['id'])->get();
                                                    @endphp
                                                    @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                                                        <td> 
                                                            @if(count($admissions) == 0)
                                                                @if($getPermission->edit == 1)
                                                                    <a href="{{ url('edit_class') }}/{{ $item['id'] ?? '' }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a> 
                                                                @endif
                                                                @if($getPermission->deletes == 1)
                                                                    <a href="javascript:;" data-id="{{ $item['id'] }}" data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger btn-xs ml-2" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
        
<script>
    $('.deleteData').click(function() {
        var delete_id = $(this).data('id'); 
        $('#delete_id').val(delete_id); 
    });
</script>

<!-- The Modal -->
<div class="modal" id="Modal_id">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">
            <div class="modal-header">
                <h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <form action="{{ url('class_delete') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="delete_id">
                    <h5 class="text-white">{{ __('common.Are you sure you want to delete') }} ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
