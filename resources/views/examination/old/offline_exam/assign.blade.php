@php
  $classType = Helper::classType();
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
                    <h3 class="card-title"><i class="nav-icon fas fa fa-tag"></i> &nbsp;Class Assign to Exam </h3>
                    <div class="card-tools">
                    <a href="{{url('view_offline_exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile">{{ __('messages.Back') }}</span>  </a>
                    </div>
                    
                    </div>        
                    <form id="quickForm" action="{{ url('assign_offline_exam') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row m-2">
    
                           <div class="col-md-3 col-6">
                			<div class="form-group">
                				<label style="color:red;">{{ __('messages.Class') }}*</label>
                				<select class="form-control @error('class_type_id') is-invalid @enderror" id="class_type_id" name="class_type_id" value="{{old('class_type_id')}}">
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
        		                <input type="hidden" name="id" value="{{$data ?? ''}}" />
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
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data3))
                            @php
                            $i = 1;
                            @endphp
                            @foreach($data3 as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    @if(!empty($classType)) 
                                    @foreach($classType as $type)
                                    
                                    @if($type->id == $item->class_type_id)
                                   {{ $type->name}}
                                   
                                    @endif
                                    
                                      @endforeach
                                    @endif
                                    
                                    {{$item->stream_id != '' ? ' [ '.$item->stream_id .' ] ' : ''}}
                                    
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteAssign" data-assign_id="{{$item->id ?? ''}}" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
                            <form action="{{ url('assign_delete_offline_exam') }}" method="post">
                                @csrf
                            <div class="modal-body">
                            <input type="hidden" id="exam_id" name="exam_id" value="{{$data ?? ''}}">
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