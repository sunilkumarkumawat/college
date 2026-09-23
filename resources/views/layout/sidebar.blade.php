   @php
   
   $sidebar =Helper::getSiderbar();
   $getPermisn = Helper::getPermisn();
   $getPermisnByBranch = Helper::getPermisnByBranch();
   $getSetting = Helper::getSetting();
   $allPermisn = explode(',',$getPermisn['sidebar_id']);
    
   @endphp
   <style>
       .brand-image {
           height: 2rem !important;
           width: 2rem !important;
       }

       .quick-menu::before {
           content: "";
           border-top: 12px solid transparent;
           border-bottom: 12px solid transparent;
           border-right: 12px solid #fff;
           position: absolute;
           top: 10px;
           left: -12px;
           z-index: 10;
       }

       .dropdown-footer {
           text-align: left;
       }

       .quick-menu[x-placement^="bottom"],
       .quick-menu[x-placement^="left"],
       .quick-menu[x-placement^="right"],
       .quick-menu[x-placement^="top"] {
           right: auto;
           bottom: auto;
       }

       .quick-menu {
           /*transition: 1s;*/
           position: fixed !important;
           top: -38px !important;
           left: 12.8rem !important;
           z-index: 1000;
           display: none;
           float: left;
           min-width: 12rem;
           padding: .5rem 0;
           margin: .125rem 0 0;
           font-size: 1rem;
           color: #212529;
           text-align: left;
           list-style: none;
           background-color: #fff;
           background-clip: padding-box;
           border: 1px solid rgba(0, 0, 0, .15);
           border-radius: .25rem;
           box-shadow: 10px 3px 12px 0 rgba(0, 0, 0, 0.26);
       }

       .nav {
           margin-bottom: 40px !important;
       }

       @media only screen and (max-width: 990px) {
           .quick-menu {
               top: 4px !important;
               left: -2.2rem !important;
           }
       }


       /* New Css Start */

       .top_brand_section {
           display: flex;
           align-items: center;
           border-bottom: 2px solid white;
           margin-bottom: 20px;
           padding-bottom: 20px;
           padding-top: 20px;
           padding-left: 10px;
           padding-right: 10px;
           position: relative;
           height: 70px;
       }

       .brand_img {
           width: 40px;
           height: 40px;
       }

       .brand_title {
           margin-bottom: 0px;
           width: 200px;
           font-size: 14px;
           font-weight: 600;
           color: white;
           margin-left: 10px;
       }

       .toggle_button {
           position: absolute;
           background: white;
           width: 30px;
           height: 30px;
           font-size: 18px;
           border-radius: 50%;
           text-align: center;
           display: flex;
           align-items: center;
           justify-content: center;
           bottom: -15px;
           right: -14px;
           border: 2px solid blue;
           cursor: pointer;
       }
       .confirmation-popup {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        z-index: 9999;
        justify-content: center;
        align-items: center;
        }
        
        .popup-content {
        background-color: white;
        padding: 20px;
       
        max-width: 600px;
        text-align: center;
        }
        #logout-confirmation .btn{
            box-shadow:2px 2px 2px black;
            margin: 10px;
        }
   </style>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar bg-light">
        <!-- Brand Logo -->
        <a href="{{url('/')}}">
          <div class="top_brand_section">
               <img src="{{ env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting['left_logo'] ?? '' }}" alt="" class="brand_img" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/no_image.png' }}'">
    
               <p class="brand_title" style="display:none;">{{$getSetting->name}}</p>
                <!--<div class="main-header navbar navbar-expand navbar-white navbar-light p-0">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
                        </li>
                    </ul>
                </div>-->
                
               <!--<div class="toggle_button" data-widget="pushmenu">
                   <i class="fa fa-angle-right"></i>
               </div>-->
           </div>
        </a>
     @if(session::get('role_id') == 1)
        <!--<a href="#" class="brand-link pt-0 pb-0" style="font-size: 1rem;" data-toggle="dropdown">-->
            <!--<i class="fa fa-th text-white" style="padding: 0.5rem 0.5rem 0 1.3rem;"></i>-->
            <!--<span class="brand-text text-white">{{ __('messages.Quick Links') }}</span>-->
        <!--</a>-->
        @endif
          <div class="dropdown-menu quick-menu dropdown-menu-sm dropdown-menu-right text-left">
        <a href="{{ url('admissionView') }}" class="dropdown-item dropdown-footer"><i class="fa fa-user-plus"></i> {{ __('student.Student Details') }} </a>
        <!--<a href="{{ url('fees/add') }}" class="dropdown-item dropdown-footer"><i class="fa fa-money"></i> {{ __('fees.Collect Fees') }} </a>-->
        <a href="{{ url('expenseAdd') }}" class="dropdown-item dropdown-footer"><i class="fa fa-credit-card"></i> {{ __('expense.Add Expense') }} </a>
        <a href="{{ url('studentsAttendanceView') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-check-o"></i> {{ __('student.Student Attendance') }}</a>
        <a href="{{ url('staff_attendance_add') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-check-o"></i> {{ __('staff.Staff Attendance') }}</a>
        <!--<a href="{{ url('#') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-check-o"></i> {{ __('staff.Staff Panel') }} </a>
        <a href="{{ url('class/preiod/add') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-times-o"></i> {{ __('messages.Class Timetable') }}</a>
        <a href="{{ url('admission/add') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-check-o"></i> {{ __('student.Student Admission') }}</a>-->
        <a href="{{ url('complaint_view') }}" class="dropdown-item dropdown-footer"><i class="fa fa-calendar-check-o"></i> {{ __('master.Complain') }}</a>
         <a href="{{ url('upload/content') }}" class="dropdown-item dropdown-footer"><i class="fa fa-download"></i> {{ __('messages.Upload Content') }}</a>
       <!--<a href="{{ url('#') }}" class="dropdown-item dropdown-footer"><i class="fa fa-object-group"></i> {{ __('invantory.Invantory') }}</a>
       <a href="{{ url('notice_board/view') }}" class="dropdown-item dropdown-footer"><i class="fa fa-bullhorn"></i> {{ __('messages.Notice Board') }}</a>--> 
        </div>
        
        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- SidebarSearch Form -->
        <!--<div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>-->
 
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!--Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library-->
            @if(!empty($sidebar))
                @foreach($sidebar as $data)
                    @foreach($allPermisn as $permisnData)
                        @if($data['id'] == $permisnData)
                        <li class="nav-item menu-open ">
                            <a href="{{url($data['url'])}}" class="nav-link {{ url($data['url'])  == URL::current() ? 'active' : "" }}">
                            <i class="nav-icon fas {{$data['ican'] ?? ''}}"></i>
                            @if(Session::get('locale') == 'hi')
                                <p>{{$data['hindi_name'] ?? ''}}</p>
                            @else
                                <p>{{$data['name'] ?? ''}}</p>
                            @endif
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endforeach
            @endif
        

            @if(Session::get('role_id') == 1)
                <li class="nav-item menu-open ">
                    <a href="{{url('helpAndUpdate')}}" class="nav-link text-warning">
                        <i class="nav-icon fa fa-question-circle-o"></i>
                        <p>
                            Help & Updates
                        </p>
                    </a>
                </li>
            @endif
            <li class="nav-item menu-open ">
                <a href="#" class="nav-link text-danger" onclick="confirmLogout(event)">
                    <i class="nav-icon fa fa-sign-out"></i>
                    <p>Log Out</p>
                </a>
            </li>
            
         </ul>   
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

