@extends('layout.app') 
@section('content')
   <div class="content-wrapper">
          <div class="card-body">
        <div class="row">
            
          <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-user"></i> &nbsp;{{ __('master.Time Table Management') }}</h3>
                    <div class="card-tools">
                			<div class="card-tools"> <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i>{{ __('messages.Back') }} </a> </div>
                    </div>
            
                </div>               
            </div>
            </div> 
    </div> 

       <section class="content">
        <div class="container-fluid">
            
            <div class="row">

            <div class="col-md-3">
                <a href="{{url('class/preiod/add')}}" class="small-box-footer">
                <div class="small-box bg-primary">
                <div class="inner">

                    <h4>{{ __('master.Class Preiod') }} </h4>
                    <p>{{ __('messages.Enter') }}</p>
                </div>
               <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                   <div class="text-center small-box-footer">{{ __('messages.More info') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div></a>
                </div>
            <!--<div class="col-md-3">-->
            <!--    <a href="{{url('#')}}" class="small-box-footer">-->
            <!--    <div class="small-box bg-success">-->
            <!--    <div class="inner">-->
            <!--        <h4>Class Preiod List</h4>-->
            <!--        <p>Enter</p>-->
            <!--    </div>-->
            <!--    <div class="icon">-->
            <!--        <i class="ion ion-stats-bars"></i>-->
            <!--    </div>-->
            <!--    <div class="text-center small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>-->
            <!--    </div></a>-->
            <!--</div>-->
            <div class="col-md-3">
                <a href="{{url('timetable')}}" class="small-box-footer">
                <div class="small-box bg-warning">
                <div class="inner">
                    <h4>{{ __('master.Time Table') }}</h4>
                    <p>{{ __('messages.Enter') }}</p>
                </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                   <div class="text-center small-box-footer">{{ __('messages.More info') }}<i class="fa fa-arrow-circle-right"></i></div>
                </div></a>
                </div>
            <div class="col-md-3">
                <a href="{{url('class/preiod/view')}}" class="small-box-footer">
                <div class="small-box bg-primary">
                <div class="inner">
                    <h4>{{ __('master.Time Table List') }}</h4>
                    <p>{{ __('messages.Enter') }}</p>
                </div>
                 <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                   <div class="text-center small-box-footer">{{ __('messages.More info') }}<i class="fa fa-arrow-circle-right"></i></div>
                </div></a>
                </div>
        </div>
    
</div>    
</section>
     </div>   
        </div>
@endsection        