@php
$getPermission = Helper::getPermission();
@endphp
@extends('layout.app') 
@section('content')

<div class="content-wrapper">
  

    <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">   
  <div class="col-md-12 pr-0 {{($getPermission->add == 1) ? '' : 'd-none'}}">
            <div class="card card-outline card-orange mr-1">
             <div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-archive"></i> &nbsp;Invantory Item</h3>
							<div class="card-tools"> <a href="{{url('invantory_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('common.Back') }}</a> </div>
						</div>
						<form id="quickForm" action="{{ url('invantory_item_add') }}" method="post" > 
						    @csrf						
							<div class="row col-12">
							    
								<div class="col-md-3">
									<div class="form-group">
										<label style="color: red;">{{ __('common.Name') }}*</label>
										<input class="form-control  @error('name') is-invalid @enderror" type="text" id="name" name="name" placeholder="{{ __('common.Name') }}"> 
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Hsn Code</label>
										<input class="form-control  @error('hsn_code') is-invalid @enderror" type="text" id="hsn_code" name="hsn_code" placeholder="Hsn Code"> 
                                        @error('hsn_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label style="color: red;">Unit*</label>
										<input class="form-control  @error('unit') is-invalid @enderror" type="text" id="unit" name="unit" placeholder="Unit"> 
                                        @error('unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label style="color: red;">Mrp*</label>
										<input class="form-control  @error('mrp') is-invalid @enderror" type="text" id="mrp" name="mrp" placeholder="Mrp"> 
                                        @error('mrp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror								    
								    </div>
								</div>
							
								</div>
							
							 <div class="row m-2 pb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">{{ __('common.submit') }}</button>
                        </div>
                    </div>

					        
					    </form>
					    </div>
				</div>
				
				<div class="col-md-12 pl-0">
            <div class="card card-outline card-orange ml-1">
             <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fa fa-archive"></i> &nbsp;{{ __(' Inventory Item') }} </h3>
            <div class="card-tools">

            </div>
             </div>  
              <div class="row m-2">
                    <div class="col-md-12">
                       <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                          <thead class="bg-primary">
          <tr role="row">
                    <th>{{ __('common.SR.NO') }}</th>
                   
                    <th>{{ __('common.Name') }}</th>
                     <th>Hsn Code</th>
                    <th>Unit</th>
                    <th>Mrp</th>
                    <th>Available Stock</th>
                    @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                     <th>{{ __('common.Action') }}</th>
                    @endif
          </thead>
          <tbody>
         
              @if(!empty($data))
                @php
                   $i=1
                @endphp
                @foreach ($data  as $item)
                <tr @if($item['available_stock'] <= 0 ) style="background: #ff00006e;"@endif>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item['name'] ?? '' }}</td>
                        <td>{{ $item['hsn_code'] ?? '' }}</td>
                        <td>{{ $item['unit'] ?? '' }}</td>
                        <td>{{ $item['mrp'] ?? '' }}</td>
                        <td>
                        
                        @php
            $purchased = DB::table('inventory_details')->where('inventory_item_id',$item['id'])->whereNull('deleted_at')->sum('qty');
            $sold = DB::table('inventory_sale_details')->where('inventory_item_id',$item['id'])->whereNull('deleted_at')->sum('qty');
                    
                    $stock = $purchased - $sold;
                      
                        @endphp
                        
                        {{ (Int)($stock ?? 0 )}}</td>
                   
                        @if($getPermission->edit == 1 || $getPermission->deletes == 1)
                            <td>
                                @if($getPermission->edit == 1)
                                <a href="{{url('invantory_item_edit') }}/{{$item->id}}" class="btn btn-primary  btn-xs ml-3" title="Edit Complaint"><i class="fa fa-edit"></i></a> 
								@endif
								@if($getPermission->deletes == 1)
								<a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger  btn-xs ml-3" ><i class="fa fa-trash-o"></i></a> 
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
			<form action="{{ url('invantory_item_delete') }}" method="post"> 
			    @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('common.Are you sure you want to delete') }} ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('common.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
		</div>
	</div>
		</div>
	</div>
	</section>
</div>

				
				
		
@endsection