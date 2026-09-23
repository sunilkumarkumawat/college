@php
   $getstudents = Helper::getstudents();
   $getSection = Helper::getSection();
   $classType = Helper::classType();
@endphp
@extends('layout.app') 
@section('content')
 <div class="content-wrapper">
   <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-12">    
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-money"></i> &nbsp; Add EMI</h3>
                        <div class="card-tools">
                        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
                        </div> 
                        </div>        
                        <div class"card-body">
                            <form id="quickForm" action="{{url('emi_add')}}"  method="post" >
                                @csrf
                            <div class="row m-2">
                                <div class="col-md-12 col-6">
                            		<div class="form-group">
                            			<label>Emi Date</label>
                            			<input class="form-control" type="date" id="emi_date" name="emi_date">
                            	    </div>
                            	</div>
                            	<div class="col-md-12 col-6">
                            		<div class="form-group">
                            			<label>Emi Name</label>
                            			<input class="form-control" type="text" id="emi_name" name="emi_name" placeholder="Emi Name" >
                            	    </div>
                            	</div>
                                <div class="col-md-12 col-6 text-center">
                            	    <div class="form-group">
                            	        <label>&nbsp;</label><br>
                            			<button type="submit" class="btn btn-primary">Submit</button>
                            	    </div>                    
                            	</div>		
                            </div>
                            </form> 
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">    
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-money"></i> &nbsp; View EMI</h3>
                        <div class="card-tools">
                        <a href="{{url('fee_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
                        </div> 
                        </div>        
                        <div class="card-body mt-2">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline">
                                  <thead>
                                    <tr role="row">
                                      <th>Sr No.</th>
                                      <th>Emi Name</th>
                                      <th>Emi Date</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  
                                  <tbody id="product_list_show">
                                    @if(!empty($data))
                                    @php
                                    $i=1
                                    @endphp
                                    @foreach ($data as $item)
                                    <tr>
                                      <td>{{ $i++ }}</td>
                                      <td>{{ $item['emi_name'] ?? '' }}</td>
                                      <td>{{ date('d-m-Y',strtotime($item['emi_date'] ?? '')) }}</td>
                                      <td>
                                          <a href="{{url('emi_edit')}}/{{$item->id}}">
                                              <button type="button" class="btn btn-primary btn-xs">Edit</button>
                                          </a>
                                          <button type="button" data-id="{{$item->id}}" data-target="#deleteEMi" data-toggle="modal" class="btn btn-danger btn-xs deleteEMi">Delete</button>
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
    </section>
</div> 

<div class="modal fade" id="deleteEMi">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb; color:white;">
            <div class="modal-header">
              <h4 class="modal-title">Delete Conformation</h4>
              <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
            </div>
            <form action="{{url('emi_delete')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete ?</p>
                  <input type="hidden" id="delete_id" name="delete_id">
                </div>
        
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">Delete</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
       $('.deleteEMi').click(function(){
          var delete_id  = $(this).data('id');
          $('#delete_id').val(delete_id);
       });
    });
</script>

@endsection    