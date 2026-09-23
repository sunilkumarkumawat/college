
@extends('layout.app') @section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 pr-0">
                    <div class="card card-outline card-orange mr-1">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp;{{ __('master.Add Subject') }}</h3>
                            <div class="card-tools"><!--<a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back</a>--></div>
                        </div>

                        <form id="quickForm" action="{{ url('create_subject') }}" method="post">
                            @csrf
                            <div class="row m-2">
                             
                                <div class="col-md-12">
                                    <label class="text-danger">{{ __('master.Subject') }}*</label>
                                    <input type="text" class="form-control @error('add_subject') is-invalid @enderror" 
                                        id="add_subject"
                                        name="add_subject"
                                        placeholder="{{ __('master.Subject') }}"
                                        value="{{old('add_subject')}}"
                                    />
                                    @error('add_subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                     <input type="checkbox" class="" 
                                        id="other_subject"
                                        name="other_subject"
                                        placeholder="{{ __('Other Subject') }}"
                                        value="1"
                                    /> Other Subject
                                </div>
                            </div>

                            <div class="row m-2">
                                <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button><br /></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-8 pl-0">
                    <div class="card card-outline card-orange ml-1">
                        <div class="card-header bg-primary flex_items_toggel">
                            <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp;{{ __('master.View Subject') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('master_dashboard')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="Display_none_mobile">{{ __('messages.Back') }}</span></a>
                            </div>
                        </div>
                        <form action="{{ url('multi_edit_subject') }}" method="post" >
                            @csrf
                           
                        <div class="row m-2">
                         

            	
                    	
                            <div class="col-md-12" style="overflow-x:scroll;">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline nowrap">
                                    <thead class="bg-primary">
                                        <tr role="row">
                                            <th>{{ __('messages.Sr.No.') }}</th>
                                            <th>{{ __('messages.Subject') }}</th>
                                       
                                            <th>{{ __('Delete') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if(!empty($data)) 
                                        @php $i=1 ;
                                        
                                      
                                        @endphp 
                                        @foreach ($data as $item)
                                        
                                        <tr>
                                            
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <input type="hidden" value="{{ $item['id'] ?? '' }}" name="id[]"  /> 
                                                <input type="text" value="{{ $item['name'] ?? '' }}" name="add_subject[]"  />  &nbsp; <input type="radio" value="0" name="other_subject_{{$item->id}}"  {{$item['other_subject'] == 1 ? '' : 'checked' }} /> Main &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" style='accent-color:red' value="1" name="other_subject_{{$item->id}}"  {{$item['other_subject'] == 1 ? 'checked' : '' }} /> Other
                                                
                                                </td>
                                          
                                            <td>
                                           <!--<a href="{{ url('edit_create_subject') }}/{{ $item['id'] ?? '' }}" class="btn btn-primary  btn-xs" title="Edit" ><i class="fa fa-edit"></i></a> -->
                                              <a href="javascript:;" data-id='{{$item['id'] }}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-primary btn-xs ml-3" title="Delete"><i class="fa fa-trash-o"></i></a>
                                              </td>
                                        </tr>
                                        @endforeach @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                         <div class="row m-2">
                                <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button><br /></div>
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
    $(".deleteData").click(function () {
        var delete_id = $(this).data("id");

        $("#delete_id").val(delete_id);
    });
</script>



<!-- The Modal -->
<div class="modal" id="Modal_id">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-white">{{ __('messages.Delete Confirmation') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <!-- Modal body -->
            <form action="{{ url('delete_create_subject') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="delete_id" />
                    <h5 class="text-white">{{ __('messages.Are you sure you want to delete') }} ?</h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('messages.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

