@extends('layout.app') 
@section('content')
@php
$classType = Helper::classType();
$setting = Helper::getSetting();
$studentexamview = Helper::studentexamview();
@endphp
<div class="content-wrapper">
<section class="content pt-3">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
               <div class="card-header bg-primary">
                  <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp; {{ __('Admit Card') }} </h3>
                  <div class="card-tools cl-6"> 
                     <a href="{{url('examination_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('messages.Back') }}  </a> 
                  </div>
               </div>
               <div class="card-body">
                  <form id="quickForm_find" action="{{ url('add/admit_card') }}" method="post" >
                     @csrf 
                     <div class="row">
                        <div class="col-md-2">
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
                        <div class="col-md-2">
                           <div class="form-group">
                              <label class="text-danger">{{ __('messages.Exam Name') }}*</label>
                              <select class="select2 form-control exam_id_" id="exam_id" name="exam_id" >
                                 <option value="">{{ __('messages.Select') }}</option>
                                 @if(!empty($studentexamview)) 
                                 @foreach($studentexamview as $type)
                                 <option value="{{ $type->id}} " {{ ( $type->id == $search['exam_id'] ? 'selected' : '' ) }}>{{ $type->name ?? ''  }}</option>
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
                           <label for="" class="text-white">Search</label>
                           <button type="submit" onClick="checkValidation(event)" class="btn btn-primary">{{ __('messages.Search') }}</button>
                        </div>
                     </div>
                  </form>
                  @if(!empty($data1))    
                  <div class="row m-2">
                     <div class="col-12">
                        <form action={{url('SubmitAdmitCard')}} method="post">
                           @csrf
                            <div class="card p-0">
                               <div class="card-body p-0" style="display: block;">
                                  <div class="table-responsive">
                                     <table class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Admission no.</th>
                                    <th>Name</th>
                                    <th>Mob no.</th>
                                    <th>Father's name</th>
                                    <th>Father's mob no.</th>
                                    <th>Exam roll no.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                 $i = 1;
                                @endphp
                                @foreach($data1 as $key=>$item)
                                <input type="hidden" id="class_type_id__" name="class_type_id__" value="{{$item->class_type_id ?? ''}}">
                                <input type="hidden" id="exam_id__" name="exam_id__" value="{{ $exam_id ?? ''}}">
                                <input type="hidden" id="exam_code" name="exam_code" value="{{ $exam_code ?? ''}}">
                                <tr>
                                    <td>{{ $i++ }}.</td>
                                    <td><input type="hidden" class="form-control" name="admission_id[]" id="admission_id" readonly value="{{ $item->id ?? ''}}">{{ $item->admissionNo ?? ''}}</td>
                                    <td><input type="text" name="student_name[]" id="student_name" class="form-control" readonly value="{{ $item->name ?? '' }}"></td>
                                    <td><input type="text" name="mobile[]" id="mobile" class="form-control" readonly value="{{ $item->mobile ?? '' }}"></td>
                                    <td><input type="text" name="fathers_name[]" id="fathers_name" class="form-control" readonly value="{{ $item->father_name ?? '' }}"></td>
                                    <td><input type="text" name="fathers_mobile[]" id="fathers_mobile" class="form-control" readonly value="{{ $item->father_mobile ?? '' }}"></td>
                                    <td>
                                        @if(!empty($data1[0]->exam_roll_no))
                                       <input type="hidden" name="exam_admit_card_id[]"  value="{{ $item->id ?? ''}}"> 
                                        @endif
                                        <input type="text" name="exam_roll_no[]" id="exam_roll_no" {{ ("exId_".$key) == "exId_0" ? ("") : "readonly" }} onChange="autoIncreament(event,{{$key}})" class="form-control autoIncreament exId_{{$key}}" value="{{ $item->exam_roll_no ?? old('exam_roll_no')}}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                                  </div>
                               </div>
                               @if($data1->count() != 0)
                                    <div class="col-md-12 mt-3 mb-3 text-center">
                                           <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
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

<script>
function autoIncreament(event,id){
     //alert(id);
   var curruntVal = $('.exId_'+id).val();
   var count = $('.autoIncreament').length;
   var i = 1;
   for(i; i < count; i++){
        $('.exId_'+i).val(parseInt(curruntVal) + 1);
   }
//   alert(count);
}
</script>
