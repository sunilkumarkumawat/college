@php
dd($feesDetail);
@endphp
@extends('layout.app') 
@section('content')
    <div class="container" ><br>
    <div class="card" style="background-color: aliceblue;">
     
       <div class="row p-7 mt-4">
       <div class="col-md-4"></div>
       <div class="col-md-4 text-center">
          <img src="{{ env('IMAGE_SHOW_PATH').'student_image/'.$data['student_img'] }}" style="border-radius: 50%; width: 30%; height: 120px;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/student_image/nee.jpg' }}'">

        </div>
        <div class="col-md-4"></div>
        </div>
             <div class="col-md-12 text-center">
                <h5><b>{{$data->first_name ?? ''}} {{$data->last_name ?? ''}}</b></h5>
                <h5>{{$data->id ?? ''}}</h5>
            </div>
       <div class="row p-3">
       <div class="col-md-4 col-4 text-center" style="border-right: 3px solid gray;">
           <p>2,80,000</p>
           <p><span style="color:lightgray">Total Amount</span></p>
       </div>
       <div class="col-md-4 col-4 text-center" style="border-right: 3px solid gray;">
           <p>1,31,450</p>
           <p><span style="color:lightgray">Paid Amount</span></p>
       </div>
        <div class="col-md-4 col-4 text-center">
            <p><span style="color:brown;">1,48,550</span></p>
            <p> <span style="color:lightgray">Due Amount</span></p>
        </div>
        </div>
             <div class="col-md-12 text-center text-primary">
                <h5><b>View Transaction History > </b></h5>
            </div>
            </div>
    </div> 
   
<br>

 <div class="container">
               <div class="col-md-12 text-left">
                <h5><b>Payment Dues</b></h5></div>
<br>
     
   <div class="col-md-12">           
      <div class="card p-4">
        <p><b>Fee Payment Request</b></p>
        <div class="row">
    <div class="col-md-10 col-6 ">
        <p>Fee Amount</p>
        <p><b>1,48,550</b></p>
    </div>
    
    <div class="col-md-2 mt-2 col-6">
       <a href="{{ url('Fees/add') }}" class="btn btn-success btn-xs" >Pay Now</a>
    </div>
        </div>
</div>
   </div>         
</div>

@endsection      




