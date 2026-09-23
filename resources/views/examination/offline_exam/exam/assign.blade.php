@php
  $classType = Helper::examPanelClassType();
  $getsubject = Helper::getSubject();
@endphp
@extends('layout.app')
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary flex_items_toggel">
                    <h3 class="card-title"><i class="nav-icon fas fa fa-tag"></i> &nbsp;Edit :: {{$data->name ?? ''}} </h3>
                    <div class="card-tools">
                    <a href="{{url('view/exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile">{{ __('messages.Back') }}</span>  </a>
                    </div>
                    
                    </div>        
                    <form id="quickForm" action="{{ url('assign/exam') }}/{{$data->id ?? ''}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row m-2">
                            
                           <div class="col-md-3 col-6">
                			<div class="form-group">
                				<label style="color:red;">{{ __('messages.Class') }}*</label>
                				<select class="form-control @error('class_type_id') is-invalid @enderror select2" id="class_type_id" name="class_type_id[]" multiple>
                                <option value="" >{{ __('messages.Select') }}</option>
                                 @if(!empty($classType)) 
                                      @foreach($classType as $type)
                                         <option value="{{ $type->id ?? ''  }}" {{ ($type->id == old('class_type_id')) ? 'selected' : '' }}>{{ $type->name ?? ''  }}</option>
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
                		   
                      
                		   <div class="col-md-3 col-6">
        		                <lable class="Display_none_mobile">&nbsp;</lable><br>
        		                <input type="hidden" name="id" value="{{$data->id ?? ''}}" />
                                <button type="submit" class="btn btn-primary ">{{ __('examination.Assign') }}</button>
                           </div>
    		            </div>
                    </form>

                <div class="row m-3 pb-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Sr No.</td>
                                <td>Class</td>
                                <td>Result Declaration Date</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($AssignExam))
                            @php
                            $i = 1;
                            @endphp
                            @foreach($AssignExam as $item)
                            
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $item->class_name}}</td>
                                <!--<td>{{ $item->result_declaration_date}}</td>-->
                                    <!--{{date('d-M-Y', strtotime($item['result_declaration_date'])) ?? '' }}-->
                                <td  class="myBtn  editable" style="cursor:pointer;" data-id="{{$item->id ?? ''}}"data-field='result_declaration_date' data-modal='exam\AssignExam'>
                                    {{ $item['result_declaration_date'] ?? '' }}
                                </td>
                                @php
                                    $fillMarks = DB::table('fill_marks')->where('exam_id',$data->id)->where('class_type_id',$item->class_type_id)->whereNull('deleted_at')->first();
                                    //dd($fillMarks);
                                @endphp
                                <td>
                                  @if(empty($fillMarks))
                                    <button type="button" class="btn btn-danger deleteAssign" data-assign_id="{{$item->id ?? ''}}" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Delete Conformation</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="{{ url('assign/delete/exam') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                <input type="hidden" id="exam_id" name="exam_id" value="{{$data->id ?? ''}}">
                                <input type="hidden" id="assign_id" name="assign_id">
                                 Are You Sure ?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Sumbit</button>
                                </div>
                            </form>
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
    $(document).ready(function(){
        $('.deleteAssign').click(function(){
           var assign_id = $(this).data('assign_id');
           $('#assign_id').val(assign_id);
        });
    })
</script>


@endsection