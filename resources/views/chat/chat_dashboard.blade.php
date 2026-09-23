
@extends('layout.app') 
@section('content')
@php

@endphp
                                                                    
<div class="content-wrapper">
  
         <div class="card-body">
        <div class="row">
            
          <div class="col-12 col-md-12">
            <div class="card card-outline card-orange">
                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-user"></i> &nbsp; {{ __('Chat.Chat Dashboard') }}</h3>
                    <div class="card-tools">
<!--                      <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
-->                   </div>
            
                </div>               
            </div>
            </div>
            </div> 
    <section class="content">
        <div class="container-fluid">
            
            <div class="row">

            <div class="col-md-3">
                <a href="{{url('chat/compose')}}"  class="small-box-footer">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>{{ __('Chat.Inbox') }}</h4>
                        <h4>{{ $home_count ?? '0' }}</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-inbox"></i>
                    </div>
                    <div class="text-center small-box-footer">{{ __('messages.More info') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div></a>
            </div>    
            
            <div class="col-md-3">
                <a href="{{url('chat/compose')}}"  class="small-box-footer">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4>{{ __('Chat.Compose') }}</h4>
                        <h4>{{ $home_count ?? '0' }}</h4>
                    </div>
                    <div class="icon">     
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="text-center small-box-footer">{{ __('messages.More info') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div></a>
            </div>
        </div>
    </div>
</section>
</div>
</div>


  
       

@endsection

