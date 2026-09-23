@php
$role_id = Session::get('role_id');
@endphp

@extends('layout.app')
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">

        <div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-support"></i> &nbsp;{{ __('master.View Shops') }} </h3>
							<div class="card-tools">
						@if($role_id != 3)
                            <a href="{{url('books_uniform_add')}}" class="btn btn-primary  btn-sm"><i class="fa fa-plus"></i> {{ __('common.Add') }} </a>
                            <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                        @else 
                      <a href="{{url('dashboard')}}" class="btn btn-primary  btn-xs "><i class="fa fa-arrow-left"></i> <span class="" >{{ __('Back') }} </span></a>
                      @endif  
                            </div>
						</div>
						<div class="row">
							@if(!empty($data))
							 @foreach ($data as $item)
							<div class="col-md-4">
							    <div class="card shop_card">
							        <div class="card-body">
							            <div class="row d-flex align-items-center">
							                <div class="col-md-4 col-3">
							                    <div class="shadow_box">
							                  <img class="shadow_drop" src="@if($item->category == "Books")
							                                                {{env('IMAGE_SHOW_PATH').'default/Book.png'}}
							                                                @else
							                                                {{env('IMAGE_SHOW_PATH').'default/Uniform.png'}}
							                                                @endif" alt="Card image" style="width:100%">
							                   </div>
							                        
							                </div>
							                <div class="col-md-8 col-9 all_p_oof">
							                    <p><b>{{ __('master.Shop Name') }} :- {{ $item->shop_name ?? '--' }}</b></p>
							                    <p><b>{{ __('master.Shopkeeper No') }} :- {{ $item->shop_keeper_no ?? '--' }}</b></p>
							                    <p><b>{{ __('master.Live Location') }} :- {{ $item->live_location ?? '--' }}</b></p>
							                    <p><b>{{ __('common.Address') }} :- {{ $item->address ?? '--' }}</b></p>
							                </div>
							            </div>
							        </div>
							        @if($role_id != 3)
							        <div class="card-footer text-center">
							            
										<a href="{{url('books_uniform_edit') }}/{{$item->id}}">
										    <button class="btn btn-lg btn-primary">{{ __('common.Edit') }}</button>
										</a> 
										<a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData">
										   <button class="btn btn-lg btn-danger">{{ __('common.Delete') }}</button>
										</a> 
												
							        </div>
							        @endif
							    </div>
							</div>
							@endforeach 
							@endif
						</div>
					</div>
				</div>
			</div>
            </div>

</section>
</div>

<style>
    .all_p_oof p{
        margin-bottom:0px;
        font-size: 14px;
    }
    
    .shop_card{
        margin:10px;
    }
    
    .shadow_drop{
        filter:drop-shadow(4px 4px 2px gray);
    }
    
    .shadow_box{
        border: 1px solid #cbcbcb;
        border-radius: 4px;
        padding: 10px;
        height: 100px;
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

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
			<form action="{{ url('books_uniform_delete') }}" method="post"> 
			    @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('common.Are you sure you want to delete') }}  ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection