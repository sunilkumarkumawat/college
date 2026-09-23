@extends('layout.app') 
@section('content')
    
    <div class="content-wrapper">
           
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Student Action Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('students_dashboard')}}">Student</a></li>
                </ol>
            </div>
            </div>
        </div>
        </div>
      <hr class="bg-danger m-2">
     <div class="card m-2">
             
              
              <div class="card-body">
     <div class="card-header">
                <h3 class="card-title">Student Action</h3>
              </div>
              <form id="quickForm" action="{{ url('action_add') }}" method="post" >
             <div class="row m-2">
                    <div class="col-md-6">
			        <div class="form-group">
				<label>Student New Old:</label>
				<select name="spl_files1" id="spl_files1" class="form-control">
                <option value="0">Select</option>
                <option value="1">#</option>
                <option value="18">#</option>
                <option value="20">#</option>
                <option value="34">#</option>
                <option value="35">#</option>
                <option value="36">#</option>
                <option value="37">#</option>
                <option value="38">#</option>
                <option value="39">#</option>
                <option value="40">#</option>
               
                </select>
		    </div>
		            </div>
                  
            </div> 
            
            
            <div class="row">
                <div class="col-md-3">
	    	        <div class="form-group">
				    <label>Student Name:</label>
				    <input type="text" class="form-control " id="name" name="name" placeholder="Student Name" value="">
		            </div>
		        </div>
		        <div class="col-md-3">
	    	        <div class="form-group">
				    <label>Student Class:</label>
				    <input type="text" class="form-control " id="student_class" name="student_class" placeholder="Student Class" value="">
		            </div>
		        </div>
		        <div class="col-md-3">
	    	        <div class="form-group">
				    <label>Student Section:</label>
				    <input type="text" class="form-control " id="student_section" name="student_section" placeholder="Student Section" value="">
		            </div>
		        </div>
		        <div class="col-md-3">
	    	        <div class="form-group">
				    <label>Student Roll No.:</label>
				    <input type="text" class="form-control " id="student_roll_no" name="student_roll_no" placeholder="Student Roll No." value="">
		            </div>
		        </div>
            </div>    
            <div class="row m-2">
                <div class="col-md-10 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    
    
    
    
    
    
    
    
    
    </div>
@endsection    