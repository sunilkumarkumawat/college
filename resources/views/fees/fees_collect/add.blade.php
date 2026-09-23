@php
$getstudents = Helper::getstudents();
$courses = Helper::getCourses();
$classType = Helper::classType($serach['course_id'] ?? null);
$allClassType = Helper::classType();
$getPaymentMode = Helper::getPaymentMode();
$getSession = Helper::getSession();
$batches = Helper::getBatch();
$array = [];
@endphp
@extends('layout.app')
@section('content')

<style>
    .padding_table thead tr{
        background: #002c54;
        position: sticky;
        top: 0;
        color: white;
        /*box-shadow: 0px 4px 6px #a8a8a8;*/
    }
    
    .padding_table thead tr th{
        padding:5px !important;
    }
    
    .padding_table tr th, .padding_table tr td{
        font-size:14px;
    }
</style>

<div class="content-wrapper">
    
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange mb-0">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-money"></i> &nbsp;{{ __('fees.Collect Student Fees') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('fees/index')}}" class="btn btn-primary  btn-sm" title="View Fees"><i class="fa fa-eye"></i>{{ __('common.View') }} </a>
                                <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <form id="quickForm" method="post" action="{{ url('Fees/add') }}">
                                @csrf
                                <div class="row m-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('Session') }}</label>
                                            <select class="form-control select2" id="session_id" name="session_id">
                                                <option value="">{{ __('common.All') }}</option>
                                                @if(!empty($getSession))
                                                    @foreach($getSession as $session)
                                                        <option value="{{ $session->id ?? '' }}" {{ ($session->id == ($serach['session_id'] ?? '')) ? 'selected' : '' }}>{{ $session->from_year ?? '' }} - {{ $session->to_year ?? '' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('Course') }}</label>
                                            <select class="form-control select2" id="course_id" name="course_id">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($courses))
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id ?? '' }}" {{ ($course->id == ($serach['course_id'] ?? '')) ? 'selected' : '' }}>{{ $course->name ?? '' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('Class/Semester') }}</label>
                                            <select class="form-control select2" id="class_type_id" name="class_type_id">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($classType))
                                                @foreach($classType as $type)
                                                    @if(Session::get('role_id') !== 2)
                                                        <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == ($serach['class_type_id'] ?? '') ) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                                    @else
                                                        <option value="{{ $type->id ?? ''  }}" {{ ( $type->id == ($serach['class_type_id'] ?? '') ) ? 'selected' : '' }} {{ ($type->id !== Session::get('class_type_id')) ? 'hidden' : '' }}>{{ $type->name ?? ''  }}</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>{{ __('Batch') }}</label>
                                            <select class="form-control select2" id="batch" name="batch">
                                                <option value="">{{ __('common.Select') }}</option>
                                                @if(!empty($batches))
                                                    @foreach($batches as $batch)
                                                    <option value="{{ $batch->name ?? ''  }}" {{ ($batch->name == ($serach['batch'] ?? '')) ? 'selected' : '' }}>{{ $batch->name ?? ''  }}</option>
                                                    @endforeach
                                                @endif
                                            </select>                           
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> 
                                            <label>{{ __('student.Admission No.') }}</label>
                                            <input type="text" class="form-control" id="admission_no" name="admission_no" placeholder="{{ __('student.Admission No.') }}" value="{{$serach['admission_no'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{ __('common.Search By Keywords') }}</label>
                                            <input type="text" class="form-control" value="{{$serach['name'] ?? ''}}" id="name" name="name" placeholder="{{ __('common.Search By Keywords') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="text-white">{{ __('common.Search') }}</label>
                                            <button type="submit" class="btn btn-primary">{{ __('common.Search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @if(!empty($data))
                            
                            <div class="row m-2" >
                                
                                <div class='col-12 col-md-7' style="max-height: 225px;overflow-y: scroll;">
                                <table class="table table-bordered small_td padding_table" id="trColor">
                                    <thead>
                                        <tr>
<!--                                            <th>RTE/Non RTE</th>
-->                                            <th>Ledger No.</th>
                                            <!--<th>Image</th>-->
                                            <th class="text-center">{{ __('student.Admission No.') }} </th>
                                            <th>{{ __('common.Name') }}</th>
                                            <th>{{ __('common.Class') }} </th>
                                            <!--<th>{{ __('common.Fathers Name') }}</th>-->
                                            <!--<th>{{ __('common.Mothers Name') }}</th>-->
                                            @if(Session::get('role_id') == 1)
                                            <!--<th>{{ __('common.Mobile') }}</th>-->
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                      
                                        @endphp
                                        @foreach ($data as $item)
                                        @php
                                        $array[$item->id] =$item;
                                @endphp
                                            <tr  class="quickCollect" data-id='{{$item->id ?? ''}}'style="cursor:pointer; " onclick="showData('{{ $item['unique_system_id']  }}','{{ Session::get('session_id') }}')">
<!--                                            <td>{{ $item->admission_type_id == 2 ? 'RTE' : 'Non RTE' }}</td>
-->                                            <td>{{ $item->ledger_no ?? 'NA' }}</td>
                                            <!--<td class="text-center">-->
                                            <!--    <img src="{{ env('IMAGE_SHOW_PATH').'profile/'.$item['image'] }}" -->
                                            <!--        class="photo_img" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">-->
                                            <!--</td>-->
                                            <td class="text-center">{{ $item['admissionNo'] ?? '' }}</td>
                                            <td>{{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? '' }}</td>
                                            <td>{{ $item['ClassTypes']['name'] ?? '' }}</td>
                                            <!--<td>{{ $item['father_name'] ?? '' }}</td>-->
                                            <!--<td>{{ $item['mother_name'] ?? '' }}</td>-->
                                              @if(Session::get('role_id') == 1)
                                         <!--<td>{{ $item['mobile'] ?? '' }}</td>-->
                                        @endif
                                            
                                        </tr>                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                   <div class='col-12 col-md-5' id='show_details' style='display:none;position:relative'> 
                                       
                                   <table class='table table-bordered' style="font-size: 14px;">
    <tr>
        <th rowspan='6' style='text-center;padding:10px'>
            <img src='' width='150px' height='150px' id="student-image" />
        </th>
    </tr>
    <tr>
        <th>Name</th>
        <th id="student-name"></th>
    </tr>
    <tr>
        <th>Mobile</th>
        <th id="student-mobile"></th>
    </tr>
    <tr>
        <th>Father</th>
        <th id="father-name"></th>
    </tr>
    <tr>
        <th>Mother</th>
        <th id="mother-name"></th>
    </tr>
    <tr>
        <th>Father Mobile</th>
        <th id="father-mobile"></th>
    </tr>
</table>
                                       </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="student_fees_detail"></div>
        </div>
    </section>
</div>


<style>
    .photo_img{
        border-radius: 10px;
        padding: 2px;
        width: 50px;
        height: 50px;
    }
    .blink2 {
 
 animation: blink-animation 0.5s infinite step-start;
}

@keyframes  blink-animation {
 0% {
   opacity: 1;
 }
 5% {
   opacity: 0.1;
 }

 100% {
   opacity: 1;
 }
}   
</style>

<script>
$(document).ready(function() {
    $('#trColor tr').click(function() {
        $(this).css('backgroundColor', '#002c54');
        $(this).css('color', '#fff');
        $( this ).siblings().css( "background-color", "white" );
        $( this ).siblings().css( "color", "black" );
    });

    function updateClassDropdown(classSelect, data) {
        classSelect.empty();
        classSelect.append('<option value="">{{ __("common.Select") }}</option>');
        if (data && data.length > 0) {
            $.each(data, function(key, val) {
                classSelect.append('<option value="' + val.id + '">' + val.name + '</option>');
            });
        }
        if (classSelect.hasClass("select2-hidden-accessible")) {
            classSelect.select2('destroy');
        }
        classSelect.select2();
        classSelect.val('').trigger('change');
    }

    $(document).on('change', '#course_id', function() {
        var courseId = $(this).val();
        var classSelect = $('#class_type_id');
        if (courseId) {
            $.ajax({
                url: "{{ url('getClassesByCourse') }}",
                type: "GET",
                data: { course_id: courseId },
                dataType: "json",
                success: function(data) {
                    updateClassDropdown(classSelect, data);
                },
                error: function() {
                    updateClassDropdown(classSelect, []);
                }
            });
        } else {
            var defaultClasses = [];
            @if(!empty($allClassType))
                @foreach($allClassType as $type)
                    defaultClasses.push({ id: "{{ $type->id }}", name: "{{ $type->name }}" });
                @endforeach
            @endif
            updateClassDropdown(classSelect, defaultClasses);
        }
    });

    $(".quickCollect").on("click", function(){
        @if(!empty($array))
            var array = @json($array);
            var id = $(this).data('id');
            var student = array[id];

            if (student) {
                const IMAGE_SHOW_PATH = "{{ env('IMAGE_SHOW_PATH') }}";
                const path = student.image 
                    ? `${IMAGE_SHOW_PATH}profile/${student.image}` 
                    : `${IMAGE_SHOW_PATH}default/user_image.jpg`;

                $("#student-image").attr("src", path);
                $("#student-name").text(student.first_name + ' ' + (student.last_name ? student.last_name : ''));
                $("#student-mobile").text(student.mobile || '');
                $("#father-name").text(student.father_name || '');
                $("#mother-name").text(student.mother_name || '');
                $("#father-mobile").text(student.father_mobile || '');

                $('#show_details').show();
            }
        @endif
    });
});

function showData(unique_system_id, session_id) {
    var basurl = "{{ url('/') }}";
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }, 
        type: 'post',
        url: basurl + '/student_fees_onclick',
        data: {
            unique_system_id: unique_system_id,
            session_id: session_id,
        },
        success: function(data) {
            if (data == 0) {
                alert('Please Assign the Fees for this Student !');
            } else {
                $('#student_fees_detail').html(data);
            }
        }
    });
}

function SearchValue() {
    var basurl = "{{ url('/') }}";
    var class_type_id = $('#class_type_id :selected').val();
    var name = $('#name').val();
    if (class_type_id > 0 || name != '') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: basurl + '/SearchValueStd',
            data: {
                class_type_id: class_type_id,
                name: name
            },
            success: function(data) {
                $('.student_list_show').html(data);
            }
        });
    } else {
        alert('Please put a value in minimum one column !');
    }
}
</script>

@endsection