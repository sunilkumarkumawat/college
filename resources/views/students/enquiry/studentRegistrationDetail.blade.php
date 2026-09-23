@php
  $classType = Helper::classType();
  $getState = Helper::getState();
  $getCity = Helper::getCity();
  $getCountry = Helper::getCountry();
@endphp

@extends('layout.app') 
@section('content')



<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12"> 
            <div class="card  card-outline card-orange">
             <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp; {{ __('student.Students Registration Detail') }}</h3>
            <div class="card-tools">
            <a href="{{url('enquiryView')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-eye"></i> View</a>
            <a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            
            </div> 
            
             <div class="row m-2">
          <div class="col-12">
           
                <table id="" class="table table-bordered table-striped dataTable dtr-inline ">
                  <thead>
                   @if(!empty($data))
                   
                   @php
                   //dd($data);
                   @endphp
                      <tr>
                        <th>{{ __('common.Name') }} </th>
                        <th>{{ $data['first_name'] ?? ''}}</th>
                       </tr>
                      <tr>
                        <th>{{ __('Course') }} </th>
                        <th>{{ $data['course']['name'] ?? '-' }}</th>
                       </tr>
                      <tr>
                        <th>{{ __('Class / Semester') }} </th>
                        <th>{{ $data['ClassTypes']['name'] ?? '' }}</th>
                       </tr>
                     
                      <tr>
                        <th>{{ __('common.Mobile') }}</th>
                        <th>{{ $data['mobile'] ?? ''}}</th>
                      </tr>
                      <tr>
                        <th>{{ __('common.Email') }}</th>
                        <th>{{ $data['email'] ?? ''}}</th>
                       </tr>
                       @if($data->id_proof != '')
                        <tr>
                        <th>{{ $data->id_proof ?? ''}}</th>
                        <th>{{ $data['id_number'] ?? ''}}</th>
                       </tr>
                       @endif
                       
                      <tr>
                        <th>{{ __('common.Fathers Name') }}</th>
                        <th>{{ $data['father_name'] ?? ''}}</th>
                       </tr>
                      <tr>
                        <th>{{ __('common.Mothers Name') }}</th>
                        <th>{{ $data['mother_name'] ?? ''}}</th>
                       </tr>
                      <tr>
                        <th>{{ __('common.DOB') }}</th>
                        <th>{{date('d-m-Y', strtotime($data['dob'])) ?? '' }}</th>
                       </tr>
                      <tr>
                        <th>{{ __('student.Registration Date') }}</th>
                        <th>{{date('d-m-Y', strtotime($data['registration_date'])) ?? '' }}</th>
                       </tr>
                      <!--<tr>-->
                      <!--  <th>{{ __('common.Pincode') }}</th>-->
                      <!--  <th>{{ $data['pincode'] ?? ''}}</th>-->
                      <!-- </tr>-->
                      <tr>
                        <th>{{ __('common.Address') }}</th>
                        <th>{{ $data['address'] ?? ''}}</th>
                       </tr>
                    @endif
                </thead>
            </table>
        </div>
    </div>
  </div>
</div>
</div>
</div>
</section> 
                    
                 </div>
               
               
             <div class="content-wrapper rem_edit_pos">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12"> 
            <div class="card  card-outline card-orange">
             <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp; {{ __('student.Remark View') }}</h3>
            <div class="card-tools">
          <!--  <a href="{{url('students/add')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-plus"></i>{{ __('messages.Add') }}</a>
            <a href="{{url('students_dashboard')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-arrow-left"></i>{{ __('messages.Back') }}</a>
            --></div>
            
            </div> 
            
             <div class="row m-2">
          <div class="col-12">
           
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                      <thead>
                                                  <tr>
                                                    <th>{{ __('common.SR.NO') }}</th>
                                                    <th> {{ __('common.Date') }}</th>
                                                     <th> {{ __('student.Remark') }}</th>
                                                     <th>{{ __('common.Action') }} </th>
                                                  </tr>
                                              </thead>
                                                <tbody >
                                             @if(!empty($remark))
                                             @php
                                             
                                                $i=1;
                                             @endphp
                    
                                          @foreach($remark as $item)
                                       
                                          <tr >
                                          
                                             <td>{{ $i++ }}</td>
                                             <td>{{date('d-m-Y', strtotime($item['date'])) ?? '' }}</td>
                                              <td>{{ $item['remark'] ?? ''}}</td>
        
                                             <td>

                                               <a href="javascript:;" data-remark="{{$item->remark}}" data-date="{{$item->date}}"  data-id='{{$item->id}}' data-toggle="modal" data-target="#Modal_id" class="editBtn"><i class="fa fa-edit"></i> </li></a>

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
            
            
            
            
            
            <div class="modal" id="Modal_id">
  <div class="modal-dialog ">
    <div class="modal-dialog">
    <div class="modal-content mod_siz">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('student.Edit Remark') }} </h4>
        <button type="button" class="btn-close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>
      <!-- Modal body -->
      <form action="{{ url('enquiryRemarkEdit') }}" method="post">
              	 @csrf
				 <input type="hidden" id="student_id" name="student_id" value="">
				   <div class=" row p-4">
            	<div class="col-md-6">    
            	 <label for="name">{{ __('common.Date') }}</label>
            		<input type="date" class="form-control input-radius @error('date') is-invalid @enderror" id="datevv" placeholder="Date" name="date" value="" >	
					                        
            		</div>                 
            	<div class="col-md-6">    
            	 <label for="name">{{ __('student.Remark') }}</label>
            		<input type="" class="form-control input-radius @error('remark') is-invalid @enderror" id="remark" placeholder="{{ __('student.Remark') }}" name="remark" value="" required>	
					                        
            		</div>                 
            	             
            	                       
							</div>														
            					<div class="text-center col-md-12">
            					  
            				 <button type="submit" class="btn btn-primary mt-3" id="submitButton">{{ __('common.Update') }}</button>
                            
            			</div>
            		</form>

    </div>
  </div>
</div>
</div>

<script>
	$(".remark").click(function(){
		var remark_id = $(this).data('id');
		$("#remark_id").val(remark_id);
	})
	
	</script>
	<script>
 	$(".editBtn").click(function(){
		var id = $(this).data('id');
		var date = $(this).data('date');
		var remark = $(this).data('remark');
		$("#student_id").val(id);
		$("#datevv").val(date);
		$("#remark").val(remark);
		
	})   
</script>

<style>
    .mod_siz{
        width: 136%;
height: 300px;
    }
    .rem_edit_pos{
        margin-top:-10%;
    }
</style>
            @endsection