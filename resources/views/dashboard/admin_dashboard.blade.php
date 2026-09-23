@php
$noticeBoard = Helper::noticeBoard();
$getstudentbirthday = Helper::getstudentbirthday();
$task = Helper::task();
$chartAttendanceStudents = Helper::chartAttendanceStudents();
$chartAttendanceTeachers = Helper::chartAttendanceTeachers();
$getremark = Helper::getremark();
$roleName = DB::table('role')->whereNull('deleted_at')->find(Session::get('role_id'));

@endphp

@extends('layout.app')
@section('content')


<div class="content-wrapper students_search">
<input type="hidden" id="value">
<input type="hidden" id="value2">
    <section class="content pt-3">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-home"></i> &nbsp;{{ $roleName->name ?? '' }} Dashboard</h3>
                            
                            <div class="card-tools">
                                <!--<a href="{{url('add_user')}}" class="btn btn-primary  btn-sm" title="Add User"><i class="fa fa-plus"></i> Add User</a>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
            <p><i class="fa fa-dot-circle-o"></i> Student Details</p>
            </div>
                <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('admissionView') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fa fa-graduation-cap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.TOTAL STUDENTS') }}</span>
                                <span class="info-box-number">{{App\Models\Admission::countActiveAdmission()}}</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                 <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.FEES COLLECTION') }}</span>
                                <span class="info-box-number"><i class="fa fa-rupee"></i>
                                    {{ number_format(\App\Models\FeesDetail::totalCollection() ,2) ?? '' }}</span>
                            </div>
                        </div>
                    
                </div>
                  
             <div class="col-12 col-sm-6 col-md-3">
           <form id="myForm" action="{{ url('fees/index') }}" method="post">
                @csrf  
                <input type="hidden" class="form-control" id="starting" name="starting" value="{{ date('Y-m-d') }}">
                <input type="hidden" class="form-control" id="ending" name="ending" value="{{ date('Y-m-d') }}">
                <div class="info-box mb-3 text-dark" onclick="submitForm()">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                       <button type="submit" class="bg-white" style="border:hidden;text-align:left"> <span class="info-box-text">{{ __('dashboard.TODAY COLLECTION') }}</span></button>
                        <span class="info-box-number"><i class="fa fa-rupee"></i>
                            {{ number_format(\App\Models\fees\FeesDetailsInvoices::todayCollection(), 2) ?? '' }}
                        </span>
                    </div>
                </div>
            </form>
        </div>
        
  </div>
                  
        <div class="row">
            <p><i class="fa fa-dot-circle-o"></i> {{ __('dashboard.User Details') }} </p>
            </div>
            
            
             <div class="row">
                   <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('viewUser') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user-secret"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.TOTAL USERS') }}</span>
                                <span class="info-box-number">{{ \App\Models\User::countUser() ?? '0' }}</span>
                            </div>
                        </div>
                    </a>
                </div>
             
   <!--             <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('bank/account/index') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-bank"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.TOTAL ACCOUNTS') }}</span>
                                <span class="info-box-number">{{\App\Models\Account::countAccount() }}</span>
                            </div>
                        </div>
                    </a>
                </div>-->
          <!--      <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('invantory_dashboard') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-archive"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.INVENTORY') }}</span>
                                <span class="info-box-number"> 0</span>
                            </div>
                        </div>
                    </a>
                </div>-->
           
            <!--  <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ url('complaint_view') }}">
                        <div class="info-box mb-3 text-dark">
                            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-snapchat"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('dashboard.TOTAL COMPLAINTS') }}</span>
                                <span class="info-box-number">{{\App\Models\Master\Complaint::countComplaint() }}</span>
                            </div>
                        </div>
                    </a>
                </div>-->
                 
                 </div>
       
 
    <div class="row">

                     @if(count($getstudentbirthday) > 0)  
                  <div class="col-md-4">
                     <div class="card card-warning" >
                    <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-bell"> {{ __('Birthday Notification') }}</i> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                     
                            <marquee direction="up" scrollamount="4" id="test" onMouseOver="document.all.test.stop()"
                                onMouseOut="document.all.test.start()">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                    @if(!empty($getstudentbirthday))
                              
                                    @foreach($getstudentbirthday as $item)
                                 
                                    <li class="">
                                        <a href="{{ url('admissionView') }}">
                                            <span class="text text-dark">{{ $item->first_name ?? '' }}{{ $item->last_name ?? '' }}</span>
                                            <small class="badge badge-danger"><i class="fa fa-envelope-o"></i>
                                                New</small>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </marquee>
                        </div>

                    </div>
              
            </div>
                
                @endif
                          

                     @if(count($getremark) > 0)  
                     
                  <div class="col-md-4">
                     <div class="card card-danger" >
                    <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-bell"> {{ __('Student Remark Notification') }}</i> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                     
                            <marquee direction="up" scrollamount="4" id="student" onMouseOver="document.all.student.stop()"
                                onMouseOut="document.all.student.start()">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                    @if(!empty($getremark))
                              
                                    @foreach($getremark as $item)
                                 
                                    <li class="">
                                        <a href="{{ url('students/index') }}">
                                            <span class="text text-dark">{{ $item->remark ?? '' }}</span>
                                            <small class="badge badge-danger"><i class="fa fa-envelope-o"></i>
                                                New</small>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </marquee>
                        </div>

                    </div>
              
            </div>
                
                @endif
                
                
                 
                
                
                       @if(count($noticeBoard) > 0) 

                   
                  
                        
                         <div class="col-md-4">
                     <div class="card card-warning">
                    <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-bell"> {{ __('Notifications ') }}</i> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                         <div class="card-body">
                            <marquee direction="up" scrollamount="4" id="newnotic" onMouseOver="document.all.newnotic.stop()"
                                onMouseOut="document.all.newnotic.start()">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                   @if(!empty($noticeBoard))
                                    @foreach($noticeBoard as $item)
                                 
                                    <li class="">
                                      <a href="{{ url('notice_board/view') }}/{{$item->id}}">
                                           <span class="text text-dark"> {!! html_entity_decode($item->message ?? '', ENT_QUOTES, 'UTF-8') !!} {!! html_entity_decode($item->title ?? '', ENT_QUOTES, 'UTF-8') !!}</span>
                                            <small class="badge badge-danger"><i class="fa fa-envelope-o"></i>
                                                New</small>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </marquee>
                        </div>

                    </div>
              
            </div>
            @endif
           
         <!--   @if(count($noticeBoard) > 0) 
                    <div class="col-md-6">
                     <div class="card card-warning">
                    <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-bell">{{ __('dashboard.Notifications') }} </i> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fa fa-times"></i>
                              </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <marquee direction="up" scrollamount="4" id="Notifications" onMouseOver="document.all.Notifications.stop()"
                                onMouseOut="document.all.Notifications.start()">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                   @if(!empty($noticeBoard))
                                    @foreach($noticeBoard as $item)
                                 
                                    <li class="">
                                      <a href="{{ url('notice_board/view') }}/{{$item->id}}">
                                           <span class="text text-dark">{{ $item->title ?? '' }}</span>
                                            <small class="badge badge-danger"><i class="fa fa-envelope-o"></i>
                                                New</small>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </marquee>
                        </div>

                    </div>
              
  -->
          
      <!--
                             <div class="card-body">
                            <marquee direction="up" scrollamount="4" id="Notifications" onMouseOver="document.all.Notifications.stop()"
                                onMouseOut="document.all.Notifications.start()">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                    @if(!empty($noticeBoard))
                                    @foreach($noticeBoard as $item)
                                    <li class="">
                                        <a href="{{ url('notice_board/view') }}/{{$item->id}}">
                                            <span class="text text-dark">{{ $item->title ?? '' }}</span>
                                            <small class="badge badge-danger"><i class="fa fa-envelope-o"></i>
                                                New</small>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                             </ul>
                            </marquee>
                        </div>

                    </div>
                    
                    @endif
                    -->
                    
                <!--    <div class="col-md-12">-->
                <!--    <div class="card">-->
                <!--        <div class="card-header ui-sortable-handle flex_items_mb">-->
                <!--            <h3 class="card-title_mb">-->
                <!--                <i class="ion ion-clipboard mr-1"></i>-->
                <!--                {{ __('dashboard.To Do List') }}-->
                <!--            </h3>-->
                <!--            <div class="card-tools">-->
                <!--                <div class="row">-->
                                    
                <!--                    <div class="col-md-12 col-12 text-center">-->
                <!--                        <a href='{{url("to_do_assign")}}' style="margin-top:-10px"><button type="button" class="btn btn-primary"><i-->
                <!--                                class="fa fa-plus"></i> {{ __('Add/View') }}</button></a>-->
                <!--                    </div>-->
                <!--                </div>-->

                <!--            </div>-->
                <!--        </div>-->
                         
                <!--        <div class="card-body">-->
                           
                <!--            <ul class="todo-list ui-sortable todoList" data-widget="todo-list">-->
                              
                <!--            </ul>-->
                <!--        </div>-->
                        
                <!--    </div>-->
                <!--</div>-->
                 
                 <!--<div class="col-md-5">
                    <div class="card">
                        <div class="card-header ui-sortable-handle flex_items_mb">
                            <h3 class="card-title_mb">
                                <i class="ion ion-clipboard mr-1"></i>
                                {{ __('dashboard.To Do List') }}
                            </h3>
                            <div class="card-tools">
                                <div class="row">
                                    <div class="col-md-8 col-8">
                                        <input type="text" class="form-control form-control-border" id="task"
                                            name="task" placeholder="{{ __('dashboard.Enter Task') }}...">
                                    </div>
                                    <div class="col-md-4 col-4">
                                        <button type="button" class="add_task btn btn-primary float-right btn-xs"><i
                                                class="fa fa-plus"></i> {{ __('common.Add') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                         
                        <div class="card-body">
                           
                            <ul class="todo-list ui-sortable todoList" data-widget="todo-list">
                              
                            </ul>
                        </div>
                        
                    </div>
                </div>-->
               <div class="col-md-6">
                    <div class="card">
                        <div class="card-header ui-sortable-handle flex_items_mb">
                            <h3 class="card-title_mb  collection">
                              <i class="fa fa-money mr-1" aria-hidden="true"></i>

                                {{ __('Monthly Fee Collection') }}
                            </h3>
                           
                            <button id="monthly" class='btn btn-primary btn-xs' >Monthly</button>
                            <button id="7_days" class='btn btn-primary btn-xs' >{{date('d')}} Days</button>
                        </div>
                         
                        <div class="card-body " id="chart-container">
                           
                             <canvas class='bg-white'id="myChart"></canvas>
                              
                            </ul>
                        </div>
                        
                    </div>
                </div>
                <!--<div class="col-md-6" id="calendarElement">-->

                <!--</div>-->
                
            </div>

      <!--      <div class="row">-->
      <!--          <div class="col-md-6">-->
      <!--<div class="card card-danger">-->
      <!--                  <div class="card-header">-->
      <!--                      <h3 class="card-title"> {{ __('dashboard.Student Attendance Chart') }} </h3>-->
      <!--                      <div class="card-tools">-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                              <i class="fa fa-minus"></i>-->
      <!--                          </button>-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                              <i class="fa fa-times"></i>-->
      <!--                          </button>-->
      <!--                      </div>-->
      <!--                  </div>-->
      <!--                  <div class="card-body">-->
      <!--                      <div class="chartjs-size-monitor">-->
      <!--                          <div class="chartjs-size-monitor-expand">-->
      <!--                              <div class=""></div>-->
      <!--                          </div>-->
      <!--                          <div class="chartjs-size-monitor-shrink">-->
      <!--                              <div class=""></div>-->
      <!--                          </div>-->
      <!--                      </div>-->
      <!--                      <canvas id="donutChart"-->
      <!--                          style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"-->
      <!--                          class="chartjs-render-monitor" width="487" height="250"></canvas>-->
      <!--                  </div>-->

      <!--              </div>-->
                   

      <!--              <div class="card card-primary" style="display:none !important">-->
      <!--                  <div class="card-header">-->
      <!--                      <h3 class="card-title"> {{ __('dashboard.Area Chart') }} </h3>-->
      <!--                      <div class="card-tools">-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                              <i class="fa fa-minus"></i>-->
      <!--                          </button>-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                              <i class="fa fa-times"></i>-->
      <!--                          </button>-->
      <!--                      </div>-->
      <!--                  </div>-->
      <!--                  <div class="card-body">-->
      <!--                      <div class="chart">-->
      <!--                          <div class="chartjs-size-monitor">-->
      <!--                              <div class="chartjs-size-monitor-expand">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                              <div class="chartjs-size-monitor-shrink">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                          </div>-->
      <!--                          <canvas id="areaChart"-->
      <!--                              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"-->
      <!--                              class="chartjs-render-monitor" width="487" height="250"></canvas>-->
      <!--                      </div>-->
      <!--                  </div>-->

      <!--              </div>-->


              


      <!-- </div>-->

      <!--          <div class="col-md-6">-->
      <!--             <div class="card card-danger">-->
      <!--                      <div class="card-header">-->
      <!--                      <h3 class="card-title">{{ __('dashboard.Teacher Attendance Chart') }} </h3>-->
      <!--                      <div class="card-tools">-->
      <!--                      <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                      <i class="fa fa-minus"></i>-->
      <!--                      </button>-->
      <!--                      <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                      <i class="fa fa-times"></i>-->
      <!--                      </button>-->
      <!--                      </div>-->
      <!--                      </div>-->
      <!--                      <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>-->
      <!--                      <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>-->
      <!--                      </div>-->
                            
      <!--                      </div>-->
      <!--              <div class="card card-info" style="display:none !important">-->
      <!--                  <div class="card-header">-->
      <!--                      <h3 class="card-title"> {{ __('dashboard.Line Chart') }} </h3>-->
      <!--                      <div class="card-tools">-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                              <i class="fa fa-minus"></i>-->
      <!--                          </button>-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                              <i class="fa fa-times"></i>-->
      <!--                          </button>-->
      <!--                      </div>-->
      <!--                  </div>-->
      <!--                  <div class="card-body">-->
      <!--                      <div class="chart">-->
      <!--                          <div class="chartjs-size-monitor">-->
      <!--                              <div class="chartjs-size-monitor-expand">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                              <div class="chartjs-size-monitor-shrink">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                          </div>-->
      <!--                          <canvas id="lineChart"-->
      <!--                              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"-->
      <!--                              class="chartjs-render-monitor" width="487" height="250"></canvas>-->
      <!--                      </div>-->
      <!--                  </div>-->

      <!--              </div>-->


      <!--         <div class="card card-success">-->
      <!--                  <div class="card-header">-->
      <!--                      <h3 class="card-title"> {{ __('dashboard.Bar Chart') }} </h3>-->
      <!--                      <div class="card-tools">-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                              <i class="fa fa-minus"></i>-->
      <!--                          </button>-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                              <i class="fa fa-times"></i>-->
      <!--                          </button>-->
      <!--                      </div>-->
      <!--                  </div>-->
      <!--                  <div class="card-body">-->
      <!--                      <div class="chart">-->
      <!--                          <div class="chartjs-size-monitor">-->
      <!--                              <div class="chartjs-size-monitor-expand">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                              <div class="chartjs-size-monitor-shrink">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                          </div>-->
      <!--                          <canvas id="barChart"-->
      <!--                              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"-->
      <!--                              class="chartjs-render-monitor" width="487" height="250"></canvas>-->
      <!--                      </div>-->
      <!--                  </div>-->

      <!--              </div>-->


      <!--              <div class="card card-success">-->
      <!--                  <div class="card-header">-->
      <!--                      <h3 class="card-title"> {{ __('dashboard.Stacked Bar Chart') }}</h3>-->
      <!--                      <div class="card-tools">-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
      <!--                              <i class="fa fa-minus"></i>-->
      <!--                          </button>-->
      <!--                          <button type="button" class="btn btn-tool" data-card-widget="remove">-->
      <!--                              <i class="fa fa-times"></i>-->
      <!--                          </button>-->
      <!--                      </div>-->
      <!--                  </div>-->
      <!--                  <div class="card-body">-->
      <!--                      <div class="chart">-->
      <!--                          <div class="chartjs-size-monitor">-->
      <!--                              <div class="chartjs-size-monitor-expand">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                              <div class="chartjs-size-monitor-shrink">-->
      <!--                                  <div class=""></div>-->
      <!--                              </div>-->
      <!--                          </div>-->
      <!--                          <canvas id="stackedBarChart"-->
      <!--                              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"-->
      <!--                              class="chartjs-render-monitor" width="487" height="250"></canvas>-->
      <!--                      </div>-->
      <!--                  </div>-->

      <!--              </div>-->

      <!--          </div>-->

      <!--      </div>-->

      




        </div>
    </section>

</div>


<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fullcalendar/main.css">
<script src="https://adminlte.io/themes/v3/plugins/fullcalendar/main.js"></script>

<script>


  $('.fees-collection-info').click(function(){
         $('#fees_info_modal').modal('toggle');   
      });

   $(window).on("load", function(){
        tableviewajax()
			
			  });
      function tableviewajax() {
     $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
		            $.ajax({
                     	url:'/task_list',
					type:'post',
				  data: {
                status: "1",
               
            },
               
                success: function(result) {
                   // var result = JSON.parse(result);
                
                    if (result) {

                      //  toastr.success(result.msg);
                        	$('.todoList').html(result)
                        //	alert("done");
                      
                    } else {
                       $('.todoList').html("<p class='text-center'><img style='width:184px' src='{{ env('IMAGE_SHOW_PATH') ?? '' }}/default/Dashboard/task-task-icon-155379995.webp'></p>");

                    }
                }
            })
      }
      
    $(document).on('click', ".add_task", function () {
        var task = $('#task').val();
        var data = { 'task': task }
        if(task=="")
        {
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid red")
          $("#task").css("margin-left","0px")
          }, 20);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid black")
           $("#task").css("margin-left","3px")
          }, 40);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid red")
           $("#task").css("margin-left","0px")
          }, 60);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid black")
           $("#task").css("margin-left","3px")
          }, 80);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid red")
           $("#task").css("margin-left","0px")
          }, 100);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid black")
           $("#task").css("margin-left","3px")
          }, 120);
             setTimeout(function() {
          $("#task").css("border-bottom","1px solid red")
           $("#task").css("margin-left","0px")
          }, 140);
             
        }
        else{
        
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            url: "/add/task",
            data: data,
            dataType: "html",
            success: function (response) {
                toastr.success('Task Added Successfully.');
                  tableviewajax()
                  $("#task").val("");
                     $("#task").css("border-bottom","1px solid black");
            },
        });
        }
    });

    $(document).on('click', ".task_status", function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '/status/task',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: status,
                id: id
            },
            success: function () {
                toastr.success('Record Saved Successfully.');
               
            },
        });
    });

    $(document).on('click', ".task_delete", function () {
        var task_id = $(this).data('id');
        var data = { 'task_id': task_id }
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            url: "/delete/task",
            data: data,
            dataType: "html",
            success: function (response) {
                $("#task_li").remove();
                toastr.error('Task Deleted Successfully.');
              tableviewajax()
            },
        });
    });
</script>
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label: 'Electronics',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutData = {
            labels: [
                'Present',
                'Absent',
                'Work From Home',
                'Half-Day',
                'Holiday',
               
            ],
            datasets: [
                {
                    data: [ 
                    {{$chartAttendanceStudents['Present']}},{{$chartAttendanceStudents['Absent']}},{{$chartAttendanceStudents['Work_From_Home']}},{{$chartAttendanceStudents['Half_Day']}},{{$chartAttendanceStudents['Holiday']}}],
                    backgroundColor: ['#00a65a', '#f56954',  '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      //  var pieData = donutData;
         var pieData = {
            labels: [
                'Present',
                'Absent',
                'Work From Home',
                'Half-Day',
                'Holiday',
               
            ],
            datasets: [
                {
                    data: [ 
                    {{$chartAttendanceTeachers['Present']}},{{$chartAttendanceTeachers['Absent']}},{{$chartAttendanceTeachers['Work_From_Home']}},{{$chartAttendanceTeachers['Half_Day']}},{{$chartAttendanceTeachers['Holiday']}}],
                    backgroundColor: ['#00a65a', '#f56954',  '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }
       
       
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })

        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, barChartData)

        var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })
    })
</script>
<script>
    $(window).on("load", function(){
        
      function tableviewajax() {
     $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
		            $.ajax({
                     	url:'/task_list',
					type:'post',
				  data: {
                status: "1",
               
            },
               
                success: function(result) {
                   // var result = JSON.parse(result);
                
                    if (result) {

                      //  toastr.success(result.msg);
                        	$('.todoList').html(result)
                        //	alert("done");
                      
                    } else {
                       // toastr.error(result.msg);
                    }
                }
            })
      }
      tableviewajax()
			
			  });
			  
			  
			  
</script>



<script>

var token_no = "{{env('SOFTWARE_TOKEN_NO')}}";
                   $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "https://rukmanisoftware.com/api/checkSchoolToken/" + token_no,
              
         success:function(response){ 
                setSession(response.data.student_count,response.data.user_count,response.data.branch_count);
            }
        });
            
            
            function setSession(data1,data2,data3){
                
                
                    $.ajax({
                type: "POST",
                url: "/set_session_count",
                data:{
                    student_count:data1,
                    user_count:data2,
                    branch_count:data3
                },
               
         success:function(response){ 
                 
    }
            });
            }
 

</script>
@php
$data = Helper::getMonthWiseFeeCollection();
$data1 = Helper::getWeeklyWiseFeeCollection();
@endphp
<script>
    $(document).ready(function() {
        var myChart; // Declare a global variable to store the chart instance
        
        // Load the initial chart (Monthly Data)
        chartData(@json($data));

        // Event handler for weekly data
        $('#7_days').click(function() {
            updateChart(@json($data1), `
                <i class="fa fa-money mr-1" aria-hidden="true"></i>
                Weekly Fee Collection
            `);
        });

        // Event handler for monthly data
        $('#monthly').on('click', function() {
            updateChart(@json($data), `
                <i class="fa fa-money mr-1" aria-hidden="true"></i>
                Monthly Fee Collection
            `);
        });

        // Function to update chart with new data
        function updateChart(data, labelHTML) {
            if (myChart) {
                myChart.destroy(); // Destroy the existing chart
            }
            $('.collection').html(labelHTML); // Update collection label
            chartData(data); // Create a new chart with updated data
        }

        // Function to create a chart
        function chartData(val) {
            var val1 = val['val1'];
            var val2 = val['val2'];

            var ctx = document.getElementById('myChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar', // Example chart type
                data: {
                    labels: val1,
                    datasets: [{
                        label: '',
                        data: val2,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>

@endsection