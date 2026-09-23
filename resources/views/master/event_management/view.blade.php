@php
  $classType = Helper::classType();
  $getSection = Helper::getSection();

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
            <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp; View Event Management</h3>
            <div class="card-tools">
            <a href="{{url('event_management')}}" class="btn btn-primary  btn-sm" ><i class="fa fa-plus"></i> Add</a>
           
            </div>
            
            </div>                 
                  
        <div class="row m-2">
          <div class="col-12">
           
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                  <thead>
                  <tr role="row">
                      <th>Sr.No.</th>
                      <th> Class</th>
                       <th>Student Name</th>
                       <th>Event Name</th>
                      
                      <th>Action</th>
                      
                      
                      
                  </thead>
                  <tbody class="product_list_show">
                  
                  @if(!empty($data))
                        @php
                       // dd($data);
                           $i=1
                        @endphp
                        @foreach ($data  as $item)
                        <tr>
                                <td>{{ $i++ }}</td>
                              
                                  <td>{{ $item['ClassType']['name'] ??'' }} </td>
                                <td>{{ $item['student_name']  }}</td>

                                <td>{{ $item['event_name']  }}</td>
                               
                                <td>
                                    <a href="{{url('event_management/edit',$item->id)}}" class="btn btn-primary  btn-xs" title="Edit Event Management"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:;"  data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id"  class="deleteData btn btn-danger  btn-xs ml-3" title="Delete Student Registration"><i class="fa fa-trash-o"></i></a>                                      
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





<!-- The Modal -->
<div class="modal" id="Modal_id">
  <div class="modal-dialog">
    <div class="modal-content" style="background: #555b5beb;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title text-white">Delete Confirmation</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      </div>

      <!-- Modal body -->
      <form action="{{ url('event_management_delete') }}" method="post">
              	 @csrf
      <div class="modal-body">
              
            
            
              <input type=hidden id="delete_id" name=delete_id>
              <h5 class="text-white">Are you sure you want to delete  ?</h5>
           
      </div>

      <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
         </div>
       </form>

    </div>
  </div>
</div>

<script>
    $('.deleteData').click(function() {
  var delete_id = $(this).data('id'); 
  
  $('#delete_id').val(delete_id); 
  } );
</script>
<script>
        function SearchValue() {
             var basurl = "{{ url('/') }}";
            var registration_no = $('#registration_no').val();
            var class_type_id = $('#class_type_id :selected').val();
            var section_id = $('.section_id :selected').val();
            var country_id = $('#country_id :selected').val();
            var state_id = $('#state_id :selected').val();
            var city_id = $('#city_id :selected').val();
            if(section_id > 0 || class_type_id > 0 || country_id > 0 || state_id > 0 || city_id > 0 || registration_no != ''){
            $.ajax({
                     headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                type:'post',
                url: basurl+'/student_search_data',
                data: {class_type_id:class_type_id,section_id:section_id,country_id:country_id,state_id:state_id,city_id:city_id,registration_no:registration_no},
                 //dataType: 'json',
                success: function (data) {
                   
                  
                    $('.product_list_show').html(data);
                   
                }
              });
            }else{
                alert('Please put a value in minimum one column !');
            }              
        };

</script>
@endsection    
