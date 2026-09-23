@extends('layout.app') 
@section('content')
@php
$classType = Helper::classType();
$setting = Helper::getSetting();

@endphp
<div class="content-wrapper">
<section class="content pt-3">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
               <div class="card-header bg-primary flex_items_toggel">
                  <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp; {{ __('Offline Examination Schedule') }} </h3>
                  <div class="card-tools cl-6"> 
                     <a onclick="history.back()" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i><span class="Display_none_mobile">{{ __('messages.Back') }} </span> </a> 
                  </div>
               </div>
               <div class="card-body">
                  <form id="quickForm_find" action="{{ url('add_offline_examination_schedule') }}" method="post" >
                     @csrf 
                     <div class="row">
                        <div class="col-md-2 col-6">
                           <div class="form-group">
                              <label class="text-danger">{{ __('messages.Class') }}*</label>
                              <select class="select2 form-control @error('class_type_id') is-invalid @enderror " id="class_type_id" name="class_type_id">
                                 <option value="">{{ __('messages.Select') }}</option>
                                 @if(!empty($classType))
                                 @foreach($classType as $type)
                                 <option value="{{ $type->id ?? ''  }}" {{ ($type->id == $search['class_type_id']) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
                                 @endforeach
                                 @endif
                              </select>
                              @error('class_type_id')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        
                        <div class="col-md-2 col-6">
                           <div class="form-group">
                              <label class="text-danger">{{ __('messages.Exam Name') }}*</label>
                              <select class="select2 form-control exam_id_" id="exam_id" name="exam_id" >
                                 <option value="">{{ __('messages.Select') }}</option>
                                 @if(!empty($current_selected_exam)) 
                                
                                 @foreach($current_selected_exam as $type)
                                 <option value="{{ $type->exam_id}} " {{ ( $type->exam_id == $search['exam_id'] ? 'selected' : '' ) }}>{{ $type->exam_name ?? ''  }}</option>
                                 @endforeach
                                 @endif
                                 @error('exam_id')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </select>
                           </div>
                        </div>
                        <div class="col-md-1 col-6">
                           <label for="" class="text-white">Search</label><br>
                           <button type="submit" onClick="checkValidation(event)" class="btn btn-primary">{{ __('messages.Search') }}</button>
                        </div>
                     </div>
                  </form>
                  @if(!empty($data1))    
                  <div class="row m-2">
                     <div class="col-12">
                        <form action={{url('submit_schedule')}} method="post">
                           @csrf
                            <div class="card p-0">
                               <div class="card-body p-0" style="display: block;">
                                  <div class="table-responsive">
                                     <table class="table table-bordered table-striped dataTable dtr-inline nowrap">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Subject Name</th>
                                    <th>Date</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                    <th style="width: 15px;">Order By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                 $i = 1;
                             
                                @endphp
                                 <input type="hidden" id="class_type_id__" name="class_type_id_save" value="{{$search['class_type_id'] ?? ''}}">
                                <input type="hidden" id="exam_id__" name="exam_id_save" value="{{$search['exam_id'] ?? ''}}">
                                @foreach($data1 as $item)
                                    
                                @php
                                
                                  $oldData = Helper::oldScheduleDetails($item->id, $item->class_type_id,$search['exam_id'] ?? '',$search['stream_id'] ?? '');
                                  //dd($search);
                                @endphp
                              
                                <tr>
                                    <td>{{ $i++ }}.</td>
                                    <td><input type="hidden" class="form-control" name="subject_id[]" value="{{$item->id ?? '' }}" id="subject_id" readonly value="{{ $oldData->subject_id ?? ''}}">
                                    @php
                                       $subjectName = Helper::getSubjectName($item->id,$item->class_type_id,$search['stream_id'] ?? '');
                                    @endphp
                                    {{$subjectName ?? ''}}
                                    </td>
                                    <td><input type="date" name="date[]" id="date" class="form-control" value="{{ $oldData['date'] ?? ''}}"  ></td> 
                                    <td><input type="time" name="from_time[]" id="from_time" class="form-control" value="{{ $oldData['from_time'] ?? ''}}" ></td>
                                    <td><input type="time" name="to_time[]" id="to_time" class="form-control" value="{{ $oldData['to_time'] ?? ''}}" ></td>
                                     <td><input type="text" name="order_by[]" id="order_by" class="form-control" value="{{ $oldData['order_by'] ?? ''}}" placeholder="Order By"></td>
                              
                              
                                 </tr>
                                @endforeach
                             
                               
                            </tbody>
                            </table>
                                  </div>
                               </div>
                               @if($data1->count() != 0)
                                    <div class="card-footer mt-2" style="display: block;">
                                  <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                           <div class="form-group">
                                                <label>Exam Center</label>
                                                <input type="text" class="form-control" name="exam_center" id="exam_center" value="{{ $oldData->exam_center ?? 'Pending to fetch'}}" placeholder="Exam Center">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3 mb-3 text-center">
                                           <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                        </div>
                               </div>
                               @endif
                        </form>
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
</section>
</div>


@endsection
<script>
    function checkValidation(event){
        event.preventDefault()
        var classval = $('#class_type_id').val();
        var examVal = $('#exam_id').val();
        if(classval == ""){
           toastr.error('Please select a class ');
        }else if(examVal == ""){
            toastr.error('Please select a exam ');
        }else{
            $('#quickForm_find').trigger('submit');
        }
    }
</script>


