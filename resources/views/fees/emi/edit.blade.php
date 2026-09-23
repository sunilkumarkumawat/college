@extends('layout.app') 
@section('content')
 <div class="content-wrapper">
   <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-12">    
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                        <h3 class="card-title"><i class="fa fa-money"></i> &nbsp; Edit EMI</h3>
                        <div class="card-tools">
                        <a href="{{url('emi_add')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i>Back</a>
                        </div> 
                        </div>        
                        <div class"card-body">
                            <form id="quickForm" action="{{url('emi_edit')}}/{{$data->id}}"  method="post" >
                                @csrf
                            <div class="row m-2">
                                <div class="col-md-2 col-6">
                            		<div class="form-group">
                            			<label>Emi Date</label>
                            			<input class="form-control" type="date" id="emi_date" name="emi_date" value="{{  $data->emi_date ?? ''}}">
                            	    </div>
                            	</div>
                            	<div class="col-md-2 col-6">
                            		<div class="form-group">
                            			<label>Emi Name</label>
                            			<input class="form-control" type="text" id="emi_name" name="emi_name" placeholder="Emi Name" value="{{$data->emi_name ?? ''}}">
                            	    </div>
                            	</div>
                                <div class="col-md-2 col-6">
                            	    <div class="form-group">
                            	        <label>&nbsp;</label><br>
                            			<button type="submit" class="btn btn-primary">Update</button>
                            	    </div>                    
                            	</div>		
                            </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 

@endsection    