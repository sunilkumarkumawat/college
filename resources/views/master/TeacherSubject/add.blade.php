@php
$getSubject = Helper::getSubject();
$classType = Helper::classType();
$getTimePeriod = Helper::getTimePeriod();
$getAllTeachers = Helper::getAllTeachers();

$numbers = [
    0 => 'First',
    1 => 'Second',
    2 => 'Third',
    3 => 'Fourth',
    4 => 'Fifth',
    5 => 'Sixth',
    6 => 'Seventh',
    7 => 'Eighth',
    8 => 'Ninth',
    9 => 'Tenth',
    10 => 'Eleventh',
    11 => 'Twelfth',
    12 => 'Thirteenth',
    13 => 'Fourteenth',
    14 => 'Fifteenth',
    15 => 'Sixteenth',
    16 => 'Seventeenth',
    17 => 'Eighteenth',
    18 => 'Nineteenth',
    19 => 'Twentieth',
];

$newNumber = [];


@endphp

@foreach($getTimePeriod as $key =>$time)

@php
$newNumber[$time->id] = $numbers[$key];
@endphp

@endforeach

@php
//dd($newNumber);
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
                            <h3 class="card-title"><i class="fa fa-image"></i> {{ __('master.Add Subject Teacher') }}</h3>
                            <div class="card-tools">
                                <a onclick="history.back()" class="btn btn-primary  btn-sm" title="View Gallery"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>

                        </div>
                        <form id="quickForm" action="{{ url('teacher_subject_add') }}" method="post" enctype="multipart/form-data" class="was-validated">
                            @csrf
                            <div class="row m-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('common.Class') }}*</label>
                                        <select class="form-control @error('class_type_id') is-invalid @enderror select2" id="class_type_id" name="class_type_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($classType))
                                            @php
                                                $groupedTSClasses = $classType->groupBy(function($item) {
                                                    return $item->course->name ?? 'Other / General';
                                                });
                                            @endphp
                                            @foreach($groupedTSClasses as $courseName => $classes)
                                            <optgroup label="{{ $courseName }}">
                                                @foreach($classes as $type)
                                                <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == old('class_type_id')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                            @endif
                                        </select>
                                         <div class="invalid-feedback">{{ __('master.Please fill out this field.') }}</div>
                                    </div>
                                </div>
                             
                             
                              
                                <div class="col-md-2 div_subject_id" style="display:block;">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('common.Subject') }}*</label>
                                        <select class="form-control  @error('subject_id') is-invalid @enderror select2" id="subject_id" name="subject_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                         
                                        </select>
                                        <div class="invalid-feedback">{{ __('master.Please fill out this field.') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('master.Teacher') }}*</label>
                                        <select class="form-control @error('teacher_id') is-invalid @enderror select2" id="teacher_id" name="teacher_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getAllTeachers))
                                            @foreach($getAllTeachers as $type)
                                            <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == old('teacher_id')) ? 'selected' : '' }}>{{ $type->first_name ?? ''  }} {{ $type->last_name ?? ''}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                       <div class="invalid-feedback">{{ __('master.Please fill out this field.') }}</div>
                                    </div>
                                </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                        <label style="color: red;">{{ __('master.Time') }}</label>
                                        <select class="form-control  @error('time_period_id') is-invalid @enderror select2" id="time_period_id" name="time_period_id" required>
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getTimePeriod))
                                            @foreach($getTimePeriod as $key => $type)
                                            <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == old('time_period_id')) ? 'selected' : '' }}>{{ date('h:i:s A', strtotime($type->from_time)) ?? ''  }} To {{ date('h:i:s A', strtotime($type->to_time)) ?? ''  }} [{{$numbers[$key]}}]</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">{{ __('master.Please fill out this field.') }}</div>
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



            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-support"></i> &nbsp; {{ __('master.View Subject Teacher') }} </h3>
                            <div class="card-tools">
                                
                                <form action="{{ url('printTimeTable') }}" method="post" target="_blank">
                                @csrf
                                    <select class="selectDesign text-secondary" id="class_type_id_print" name="class_type_id_print">
                                        <option value="">All Classes</option>
                                        @if(!empty($classType))
                                        @foreach($classType as $type)
                                        <option value="{{ $type->id ?? ''  }}" >{{ $type->name ?? ''  }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <button type="submit" class="btn btn-primary  btn-sm" title="Print TimeTable"><i class="fa fa-print"></i> Print TimeTable</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>{{ __('common.SR.NO') }}</td>

                                                <th>{{ __('common.Class') }} </th>
                                                <th>{{ __('common.Subject') }} </th>
                                                <th>{{ __('master.Teacher Name') }}</th>
                                                <th>{{ __("Period's Name") }}</th>
                                                <th>{{ __('master.Time Periods') }}</th>
                                                <th>{{ __('common.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($data))
                                            @php
                                            $i=1;
                                            $count = 0;
                                           $class_type_id = '';
                                            @endphp
                                            @foreach ($data as $item)
                                            @php
                                            
                                            if($class_type_id == '')
                                            {
                                            $class_type_id == $item->class_type_id;
                                            }
                                            if($class_type_id == $item->class_type_id)
                                            {
                                           
                                            $count++;
                                            }
                                            else
                                            {
                                            $class_type_id = $item->class_type_id;
                                            $count =0;
                                            }

                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item['class_name'] ?? '' }}</td>
                                                <td>{{ $item['subject_name'] ?? '' }}</td>
                                                <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }} </td>
                                                <td>{{$newNumber[$item->time_period_id] ?? ''}}</td>
                                                <td>{{ date('h:i:s A', strtotime($item->from_time)) ?? ''  }} To {{ date('h:i:s A', strtotime($item->to_time)) ?? ''  }} </td>


                                                <td>
                                                    <!--<a href="{{url('teacher_subject_edit') }}/{{$item->id}}" class="btn btn-primary  btn-xs ml-3" title="Edit Sports"><i class="fa fa-edit"></i></a>-->
                                                    <a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger  btn-xs ml-3" title="Delete Sports"><i class="fa fa-trash-o"></i></a>
                                                </td>
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
        </div>
</div>


</section>
</div>


<script>
    $('.deleteData').click(function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
</script>

<div class="modal" id="Modal_id">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">
            <div class="modal-header">
                <h4 class="modal-title text-white">{{ __('common.Delete Confirmation') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <form action="{{ url('teacher_subject_delete') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type=hidden id="delete_id" name=delete_id>
                    <h5 class="text-white">{{ __('common.Are you sure you want to delete') }} ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection