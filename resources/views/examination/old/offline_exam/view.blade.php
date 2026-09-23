@php
  $classType = Helper::classType();
  $getsubject = Helper::getSubject();
  $getSection = Helper::getSection();
  $date = date('Y-m-d');

@endphp
@extends('layout.app') 
@section('content')

<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary flex_items_toggel">
                        @if(Session::get('') == 3)
                            <h3 class="card-title"><i class="fa fa-leanpub"></i> &nbsp; My Offline Examinations</h3>
                        @else						    
							<h3 class="card-title"><i class="nav-icon fas fa fa-leanpub"></i> &nbsp; Offline Exams View</h3>
						@endif
							<div class="card-tools"> 
							@if(Session::get('role_id') !== 3)
							    <a href="{{url('add_offline_exam')}}" class="btn btn-primary  btn-sm"><i class="fa fa-plus"></i><span class="Display_none_mobile">{{ __('messages.Add') }}</span> </a> 
							    <a onclick="history.back()" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i><span class="Display_none_mobile">{{ __('messages.Back') }} </span> </a> 
                            @endif

                                
                            </div>
						</div>
						<div class="card-body">

                  <!--  <form id="quickForm" action="{{ url('view/exam') }}" method="post" >
                        @csrf 
                    <div class="row">

            		<div class="col-md-5 col-8">
            			<div class="form-group">
            				<label>{{ __('messages.Search By Keywords') }}</label>
            				<input type="text" class="form-control" id="name" name="name" placeholder="Search by keywords" value="{{ $search['name'] ?? '' }}">
            		    </div>
            		</div>                     	
                        <div class="col-md-1 col-4">
                             <label for="" class="text-white">Search</label><br>
                    	    <button type="submit" class="btn btn-primary">{{ __('messages.Search') }}</button>
                    	</div>
                    			
                    </div>
                </form> -->
                        <div class="col-md-12" style="overflow-x:scroll;">
							<table id="example1" class="table table-bordered table-striped  dataTable nowrap">
								<thead>
									<tr role="row">
										<th>{{ __('messages.Sr.No.') }}</th>
										<th>{{ __('Name of Exam') }} </th>
										@if(Session::get('role_id') == 1)
										<th>{{ __('Assigned to') }}</th>
										<th>{{ __('Start Date') }}</th>
										@endif
										<th>{{ __('messages.Action') }}</th>
										</tr>
								</thead>
								<tbody> 
								@if(!empty($data)) 
    								@php 
    								
    							
    								    $i=1 
    								@endphp 
								@foreach ($data as $item)
								    @php
								        $oldData = Helper::oldExamSubmit($item['id']);
								    @endphp
									<tr>
									
										<td>{{ $i++ }}</td>
										<td>{{ $item['name'] ?? ''}}</td>
										    @if(Session::get('role_id') == 1)
										<td> 
										@php
									$list= 	Helper::getAssignedExamList($item->id ?? '');
										
										@endphp
										
									<span class="{{$list == '' ? 'text-danger' : ''}}">	{{$list == '' ? 'NA' : $list}}</span>
										
										
										</td>@endif
								<td>
								    @if( date('d-m-Y', strtotime($item['start_date'] ?? '')) != '01-01-1970')
								    {{date('d-F-Y', strtotime($item['start_date'] ?? ''))}}
								    @else
								   <span class="text-danger">NA</span>
								    @endif
								    </td>
							            <td>
                                        @if(Session::get('role_id') == 3)
                                            @if(!empty($oldData))
                                            
                                              @php
								     
								        $examResultDetailId = Helper::examResultDetail($item['id']);
								    								    @endphp
								    			 <a class="btn btn-primary btn-xs" data-toggle="dropdown" title="Show Option"><i class="fa fa-bars"></i></a>
                                      
                                        <ul class="dropdown-menu" style="">
                                          <a href="{{url('view_marksheet1')}}" target="blank"><li class="dropdown-item text-danger"><i class="fa fa-align-center"></i> Marksheet 1</li></a>
                                           <a href="{{url('view_marksheet2')}}" target="blank"><li class="dropdown-item text-success"><i class="fa fa-bar-chart"></i> Marksheet 2</li></a>
                                          <a href="{{url('view_marksheet3')}}" target="blank"><li class="dropdown-item text-primary"><i class="fa fa-barcode"></i> Marksheet 3</li></a>
                                           <a href="{{url('view_marksheet4')}}" target="blank"><li class="dropdown-item text-dark"><i class="fa fa-credit-card"></i> Marksheet 4</li></a>
                                          <a href="{{url('view_marksheet5')}}" target="blank"><li class="dropdown-item text-success"><i class="fa fa-black-tie"></i> Marksheet 5</li></a>

                                                                                  
                                        </ul>
								    								    
							                <a href="{{url('download/marksheet') }}/{{ $examResult['admission_id'] }}/{{ $examResult['exam_id'] }}" target="blank" class="btn btn-primary btn-xs ml-3" title="Download Marksheet"><i class="fa fa-download"></i> </a>
							                <a href="{{url('view/marksheet') }}/{{ $examResult['admission_id'] }}/{{ $examResult['exam_id'] }}" target="blank" class="btn btn-warning btn-xs ml-3" title="View Marksheet"><i class="fa fa-eye"></i> </a>
							                <a href="{{url('student_admit_card') }}/{{Session::get('id')}}" class="btn btn-danger btn-xs ml-3" title="Admit Card" target="blank"><i class="fa fa-user"></i> </a>                                       
                                          
                                            @endif
                                        @endif
						                @if(Session::get('role_id') == 1)
                                             <a href="{{url('assign_offline_exam') }}/{{$item->id}}" class="btn btn-primary btn-xs ml-3" title="Assign Exam to Class"><i class="fa fa-tag"></i></a>
						                    <a href="{{url('edit_offline_exam') }}/{{$item->id}}" class="btn btn-success btn-xs ml-3" title="Edit Exam"><i class="fa fa-edit"></i></a> 
											<a href="javascript:;" data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id" class="deleteData btn btn-danger  btn-xs ml-3" title="Delete Exam"><i class="fa fa-trash-o"></i></a> 
										@endif
										
										 @if(Session::get('role_id') == 2)
						              
                                           <a href="{{url('teacher/view/exam') }}/{{$item->id}}" target="blank" class="btn btn-warning btn-xs ml-3" title="View Marksheet"><i class="fa fa-eye"></i> </a>
							                
                                          
                                            
                                            @endif
                                            
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



<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl" >
      <div class="modal-content">
        <div class="modal-header">
            <h4 style="width:100%;">{{ __('examination.Select Questions for Exam') }} : &nbsp; <span id="exam_name"></span><span style="float: inline-end;" id="q_array"></span></h4>   
                <button type="button" id="closeModal"class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
            <div class="modal-body">
                <form id="quickForm" action="#" method="post" >
                    @csrf 
                    <div class="row">
            	
                        <div class="col-md-2">
                    		<div class="form-group">
                    			<label>{{ __('messages.Subject') }}</label>
                    			<select class="form-control select2" id="subject_id" >
                    			<option value="">{{ __('messages.Select') }}</option>
                                 @if(!empty($getsubject)) 
                                      @foreach($getsubject as $type)
                                         <option value="{{ $type->id ?? ''  }}" >{{ $type->name ?? ''  }}</option>
                                      @endforeach
                                  @endif
                                </select>
                    	    </div>
                    	</div>                    	
                    	<div class="col-md-2">
                    		<div class="form-group">
                    			<label>{{ __('examination.Question Type') }}</label>
                    				<select class="form-control select2" id="question_type_id" >
                    			   <option value="">{{ __('messages.Select') }}</option>
                    			   <option value="1">Objective</option>
                    			   <option value="2">Descriptive</option>
                                </select>
                    	    </div>
                    	</div>    

                        <div class="col-md-1 ">
                             <label class="text-white">Search</label>
                    	    <button type="button" id ="search_que"class="btn btn-primary" onclick="SearchValue()">{{ __('messages.Search') }}</button>
                    	</div>
                    			
                    </div>
                </form> 
                    <div style="height: 110px;overflow: scroll;">
				<table class="table table-bordered table-striped  dataTable">
					<tbody id="question_list_show"> 

					</tbody>
				</table>
</div>

                    <div style="height: 300px;overflow: scroll;">
                        <h3> Already Assigned Questions : - </h3>
				<table class="table table-bordered table-striped  dataTable">
					<tbody id="question_list_show2"> 

					</tbody>
				</table>
</div>
            </div>
        
            <div class="modal-footer">
              <button class="btn btn-danger" id="closeModal"class="close" data-dismiss="modal">{{ __('messages.Close') }}</button>
            </div>
      </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="Modal_id">
	<div class="modal-dialog">
		<div class="modal-content" style="background: #555b5beb;">
			<div class="modal-header">
				<h4 class="modal-title text-white">{{ __('messages.Delete Confirmation') }}</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
			<input type="hidden" id="exam_id1" >
			<form action="{{ url('delete_offline_exam') }}" method="post"> 
			    @csrf
				<div class="modal-body">
					<input type=hidden id="delete_id" name=delete_id>
					<h5 class="text-white">{{ __('messages.Are you sure you want to delete') }} ?</h5> </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('messages.Delete') }}</button>
				</div>
			</form>
		</div>
	</div>
</div> 


<script>
 var count = 0;
    function SearchValue() {
       
        var question_type_id = $('#question_type_id :selected').val();
        
        var subject_id = $('#subject_id :selected').val();
       
        
           var exam_id1 = $('#exam_id1').val();
        if(question_type_id > 0 || subject_id > 0 ){
           $.ajax({
                 headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url: '/search/assigned/question',
            data: {question_type_id:question_type_id,subject_id:subject_id,exam_id1:exam_id1},
             //dataType: 'json',
            success: function (data) {
                
                $('#question_list_show').html(data);
              
               $( ".add_question" ).each(function() {
                  if($(this).prop('checked') == true){
                    //count++;
                 }
                 
                });
                
             
           
                
       
          
            }
            
          }); 
          
            
        }
     
        
    };
    
    
      
    
    
    
    
    
$('.deleteData').click(function() {
	var delete_id = $(this).data('id');
	$('#delete_id').val(delete_id);
});

var exam_id = '';


$('.assignQuestion').click(function() {
   
    
    exam_id = $(this).data('id');
    
       getAssignedQuestion();
    
    
var name = $(this).data('name');

$('#exam_id').val(exam_id);
$('#exam_id1').val(exam_id);

$('#exam_name').html(name);
$('#examName').html(name);

});



function getAssignedQuestion(){
    var cou = -1;
     $.ajax({
                 headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url: '/search/already/assigned/question',
            data: {id:exam_id},
             //dataType: 'json',
            success: function (data) {
                
                $('#question_list_show2').html(data);
              
               $( "#question_list_show2 tr" ).each(function() {
                 
                    cou++;
              
                 
                });
                
               
           $("#q_array").text("Selected questions : " + cou);
            }
          }); 
}

$(document).on('click', ".add_question", function () {
    
 
    var question_id = $(this).data('question_id');
    var subject_id = $(this).data('subject_id');
    var subject_type_id = $(this).attr('data-subject_id');
    var question_type_id = $(this).attr('data-question_id');
    
  $('#myModal #subject_id').val(subject_type_id).change();
 
    var submit_id="";
    if($(this).prop('checked') == true){
        
      submit_id="0";
      count++;
  
    }else{
       submit_id="1";
    count--;
  
    }
    var data = {
                'exam_id': exam_id,
                'question_id': question_id,
                'subject_id': subject_id,
                'submit_id': submit_id,
                }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
           $.ajax({
                type: "POST",
                url: "/assign/question",
                data: data,
                dataType: "html",
                success: function (response) {
                toastr.info('Record Saved Successfully.');
                getAssignedQuestion()
               $('#myModal #search_que').trigger("click");
               
                },

            });
   
});




</script>
<script>
$(document).on('click', ".startExam", function () {
        toastr.error('You Cannot Attempt This Exam Now !');        
});
$(document).on('click', ".oldData", function () {
        toastr.error('You Already Attempted This Exam !');        
});
</script>
@endsection