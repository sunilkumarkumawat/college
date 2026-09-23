@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{url('students_dashboard')}}">Student</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
               <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                  <thead>
                  <tr role="row">
                      <th>Sr.No.</th>
                      <th>Student New Old</th>
                      <th>Student Name</th>
                      <th>Student Class</th>
                      <th>Student Section</th>
                      <th>Student Roll No.</th>
                      <th>Edit/Delete</th>
                      
                      
                      
                  </thead>
                  <tbody>
                  
                  @if(!empty($data))
                        @php
                           $i=1
                        @endphp
                        @foreach ($data  as $item)
                        <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item['student_old_new']  }}</td>
                                <td>{{ $item['name']  }}</td>
                                <td>{{ $item['student_class']  }}</td>
                                <td>{{ $item['student_section']  }}</td>
                                <td>{{ $item['student_roll_no']  }}</td>
                                
                               <td><a class=" text-center" href="{{url('#',$item->id)}}" ><i class="fa fa-edit"></i></a>
                           
                           <a href="javascript:;"  data-id='{{$item->id}}' data-bs-toggle="modal" data-bs-target="#Modal_id"  class="deleteData" ><i style= "color:red;"class="fa fa-trash-alt"></i></a> 
                            </td>
                        </tr>
                   @endforeach
                @endif
                  </tbody>
                  </table>
              </div>
              <!-- /.card-body -->
            </div>
           <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    
</div>





@endsection      