@php
$getSetting = Helper::getSetting();
$getstudentbirthday = Helper::getstudentbirthday();
$getUsersBirthday = Helper::getUsersBirthday();
$getUser=Helper::getUser();
$getSession=Helper::getSession();
$getNewChat=Helper::getNewChat();
$getAllBranch = Helper::getAllBranch();
$roleName = DB::table('role')->whereNull('deleted_at')->find(Session::get('role_id'));
@endphp
<style>
  .selectDesign {
    padding: 5px 10px;
    background: transparent;
    border: 1px solid #a5a5a5;
    border-radius: 4px;
  }
  .marquee-parent {
      position: relative;
      width: 100%;
      overflow: hidden;
      height: 40px;
    display: flex;
    align-items: center;
    }
    
    
</style>

<!--<div class="marquee">-->
<!--    <p>{{$getSetting->name}}</p>-->
<!--</div>-->
<!-- Navbar -->

<!--<div class="col-md-12">-->
<!--   <div class="marquee-parent bg-danger">-->
<!--   <marquee class="pointer marquee-child" scrollamount="8" >-->
<!--          <b>The software is in test mode. Avoid real entries related to UPI/Online Payments in iPhone, Bank API is under development; other modules are fully functional.</b>-->
<!--      </marquee>-->
<!--    </div>-->
<!--</div> -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light p-0">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item ml-1">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
    </li>
  </ul>
  
  <ul class="navbar-nav " style="margin-left: 73px; margin-top: 25px;" id="navbar_nav">
    <li class="nav-item dropdown">
      <div class="Display_none_desktop" >
       <h4 class="first-name">{{ Session::get('first_name') ?? '' }} &nbsp &nbsp</h4>
       <div style="display: flex;align-items: first baseline;justify-content: space-evenly;">
           <h4>{{$getUser['ClassTypes']['name'] ?? ''}}</h4>
        <!--<p class="role-name">{{ $roleName->name ?? '' }}</p>-->
       </div>
      </div>
    </li>
      <!--  <li class="nav-item">
        <a  style="margin:5px;padding:0px;text-align: center; " href="javascript:whatsapp_qrcode_get();">
           <i class="nav-icon fa fa-whatsapp" style="color:green;font-size:18px;"></i>&nbsp;Login status<br><i class="nav-icon fa fa-circle" style="color:red;font-size:12px;">&nbsp;</i></a>
  </li>-->
</ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto flex_centerd_profile">
  
    @if(Session::get('role_id') == 1)
    @if(count($getstudentbirthday) > 0 || count($getUsersBirthday) > 0)

    <li class="nav-item">
      <a class="nav-link" href="{{url('happy_birthday')}}">

        <img width="40px" style="margin-top:-8px" src="{{ env('IMAGE_SHOW_PATH').'default/birthday.webp' }}">
      </a>
    </li>

    @endif
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" data-toggle="modal" data-target="#subModules" role="button">
        <i class="fa fa-search"></i>
      </a>
    </li> -->
    

    @php
        $queMessage = DB::table('message_queue')->whereNull('deleted_at')->where('message_status', 0)->orderBy('id','DESC')->take(3)->get();
        $queMessageCount = DB::table('message_queue')->whereNull('deleted_at')->where('message_status', 0)->count();
    @endphp
    @if($queMessageCount > 0)
    
    <li class="nav-item dropdown ">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fa fa-whatsapp text-success"></i>
          <span class="badge badge-danger navbar-badge">{{ $queMessageCount ?? '' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;">
          
        @foreach($queMessage as $quemsg)
            <a href="#" class="dropdown-item">
                <div class="media">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    {{ $quemsg->receiver_number ?? '' }}
                    <!-- <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span> -->
                    </h3>
                    <p class="text-sm">{{ Str::limit($quemsg->content ?? '', 15, '...') }}</p>
                    <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 
                    {{ (time() - strtotime($quemsg->created_at) < 60) ? 'Just now' : 
                        ((time() - strtotime($quemsg->created_at) < 3600) ? floor((time() - strtotime($quemsg->created_at)) / 60) . ' minutes ago' : 
                        ((time() - strtotime($quemsg->created_at) < 86400) ? floor((time() - strtotime($quemsg->created_at)) / 3600) . ' hours ago' : 
                        ((time() - strtotime($quemsg->created_at) < 604800) ? floor((time() - strtotime($quemsg->created_at)) / 86400) . ' days ago' : 
                        date("d M Y", strtotime($quemsg->created_at))))) }}

                </p>
                </div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @endforeach
          
          <a href="{{ url('WhatsAppMessageHistory') }}" class="dropdown-item dropdown-footer">See All Pending WhatsApp Messages</a>
        </div>
    </li>
    
    @endif

    @endif

    <li class="nav-item dropdown Display_none_mobile">
      <form action="{{url('changeLang')}}" method="POST">
        @csrf
        <select class="selectDesign " id="lang" name="lang" onchange="this.form.submit()">
          @php
          $languages = DB::table('languages')->whereNull('deleted_at')->get();
          @endphp
          @if(!empty($languages))
          @foreach($languages as $type)
          <option value="{{$type->value ?? '' }}" {{ session()->get('locale') == $type->value ? 'selected' : '' }}>{{$type->name ?? ''}}</option>

          @endforeach
          @endif
        </select>
      </form>
    </li>


    @if(Session::get('role_id') !== 3)
    <li class="nav-item dropdown">
      <div class="Display_none_mobile">
        <form action="{{url('changeBranch')}}" method="POST">
          @csrf
          <select class="selectDesign " id="branch_id" name="branch_id" onchange="this.form.submit()">
            @if(!empty($getAllBranch))
            <!--<option value=""> All Branch</option>-->
            @foreach($getAllBranch as $branch)

            <option value="{{ $branch->id ?? ''  }} " {{ ( $branch->id == Session::get('admin_branch_id')) ? 'selected' : '' }} {{ ( $branch->id == Session::get('branch_id')) ? 'selected' : '' }}> {{ $branch->branch_name ?? ''  }} </option>
            @endforeach
            @endif
          </select>
        </form>
      </div>
    </li>
    @endif

    @if(Session::get('role_id') != 1 && Session::get('role_id') != 6)
    <li class="nav-item dropdown">
      <div class="Display_none_mobile">
        <select class="selectDesign " id="sessionData" name="sessionData" disabled>
          @if(!empty($getSession))
          @foreach($getSession as $type)
          <option value="{{ $type->id ?? ''  }} " {{ ( $type->id == Session::get('session_id')) ? 'selected' : '' }}>{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
          @endforeach
          @endif
        </select>
      </div>
    </li>
    @else
    <li class="nav-item dropdown">
      <div class="Display_none_mobile">
        <form action="{{url('sectionDataId')}}" method="POST">
          @csrf
          <select class="selectDesign " id="sessionData" name="sessionData" onchange="this.form.submit()">
            @if(!empty($getSession))
            @foreach($getSession as $type)
            <option value="{{ $type->id ?? ''  }} " {{ ( $type->id == Session::get('session_id')) ? 'selected' : '' }}>{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
            @endforeach
            @endif
          </select>
        </form>
      </div>
    </li>
    @endif

    <li class="nav-item dropdown">
      <div class="Display_none_mobile">
        <a href="{{ URL::current() }}" id="refresh" class="refresh_btn" onclick=""><i class="fa fa-refresh "></i> </a>
      </div>
    </li>
<div id="refresh-animation" class="refresh-animation" style="display:none;">
    <div class="big-circle"></div>
</div>
    @if(!empty(Session::get('id')))
    <li class="nav-item dropdown mobile_padding">
      <a class="user-panel" data-toggle="dropdown" href="#">
        @if(Session::get('role_id')==3)
        <img src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" class="img-circle elevation-2" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'">
        @else
        <img src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" class="img-circle elevation-2" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/user_image.jpg' }}'">
        @endif
        {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        {{-- <span class="dropdown-item dropdown-header">15 Notifications</span> --}}
        {{-- <div class="dropdown-divider"></div> --}}
        <div class="row border-bottom mr-0">
          <div class="col-md-4 col-4">
            @if(Session::get('role_id')==3)
            <img class="profile_user_img" src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
            @else
            <img class="profile_user_img" src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
            @endif
          </div>
          <div class="col-md-8 col-8 align_centerd">
            <div>
              <h4>{{ Session::get('first_name') ?? '' }}</h4>
              <p>{{ $roleName->name ?? '' }}</p>
            </div>
          </div>
        </div>

        <a href="{{ url('profile/edit') }}/{{Session::get('id') ?? '' }}" class="{{ url('profile/edit/'.Session::get('id'))  == URL::current() ? 'dropdown-item border-bottom back_active_header' : "dropdown-item border-bottom" }}">
          <i class="fa fa-user-circle mr-2"></i>Profile Setting
          {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
        </a>

        <a href="{{ url('change_password') }}" class="{{ url('change_password')  == URL::current() ? 'dropdown-item border-bottom back_active_header' : "dropdown-item border-bottom" }}">
          <i class="fa fa-key mr-2"></i>Change Password
          {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
        </a>
        
        @if(Session::get('role_id') == 1)
        <a href="{{url('helpAndUpdate')}}" class="text-warning dropdown-item border-bottom">
          <i class="fa fa-question-circle-o mr-2"></i>Help & Updates
          {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
        </a>
        @endif
        
   @if(Session::get('role_id') == 1 || Session::get('role_id') == 2)
        <div class="dropdown-item border-bottom Display_none_PC">
         
          <div class="flex_row">
            <i class="fa fa-calendar-check-o mr-2"></i>
            <form action="{{url('sectionDataId')}}" method="POST">
              @csrf
              <select class="form-control select" id="sessionData" name="sessionData" onchange="this.form.submit()">
                @if(!empty($getSession))
                @foreach($getSession as $type)
                <option value="{{ $type->id ?? ''  }} " {{ ( $type->id == Session::get('session_id')) ? 'selected' : '' }}>{{ $type->from_year ?? ''  }} - {{ $type->to_year ?? ''  }}</option>
                @endforeach
                @endif
              </select>
            </form>
          </div>
         
        </div>
 @endif
        <a href="#" class="dropdown-item border-bottom text-danger" onclick="confirmLogout(event)">
          <i class="fa fa-sign-out mr-2"></i> Log Out
          {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
        </a>

        {{-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
      </div>
    </li>
    @endif

  </ul>
</nav>

<div class="modal fade" id="subModules">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <input type="text" id="find_value" name="find_value" class="form-control" placeholder="Search Modules">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body" id="sub_modules">
        No Data Found
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    var BASEURL = "{{ url('/') }}";
    $(document).on('keyup', '#find_value', function() {
      var values = $(this).val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: BASEURL + '/get_modules',
        data: {
          name: values
        },
        success: function(data) {
          if (data.length != 0) {
            // alert(JSON.stringify(data));
          } else {

          }
        }
      });
    });
  });
</script>


<script>
  function SearchValue() {

    var BASEURL = "{{ url('/') }}";
    var SearchItem = $('#SearchItem').val();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: BASEURL + '/all_students_search',
      data: {
        name: SearchItem
      },
      success: function(data) {

        $('.students_search').html('');
        $('.students_search').html(data);

      }
    });

  }
</script>
<!-- <script>
  var today = new Date();
  var day = today.getDate();
  var month = today.getMonth() + 1;

  function appendZero(value) {
    return "0" + value;
  }

  function theTime() {
    var d = new Date();
    document.getElementById("time").innerHTML = d.toLocaleTimeString("en-US");
  }

  if (day < 10) {
    day = appendZero(day);
  }

  if (month < 10) {
    month = appendZero(month);
  }

  today = day + "-" + month + "-" + today.getFullYear();

  document.getElementById("date").innerHTML = today;

  var myVar = setInterval(function() {
    theTime();
  }, 1000);
</script> -->

<script>
  $(document).ready(function() {
    // Function to show or hide the brand title
    function brandShow() {
      if ($('.sidebar').hasClass('os-host-scrollbar-horizontal-hidden')) {
        $('.brand_title').show();
      } else {
        $('.brand_title').hide();
      }
    }

    // Run the function initially to set the correct state
    brandShow();

    // Observe DOM changes and run the function when needed
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'class') {
          brandShow();
        }
      });
    });

    // Start observing the sidebar element for attribute changes
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
      observer.observe(sidebar, {
        attributes: true
      });
    }
  });
</script>

<script>
    function confirmLogout(event) {
    event.preventDefault();
    document.getElementById('logout-confirmation').style.display = 'flex';
}

function closePopup() {
    document.getElementById('logout-confirmation').style.display = 'none';
}

function logout() {
    window.location.href = "{{url('logout')}}"; 
}

</script>


<script>
    function refreshPage(event) {
    event.preventDefault(); 
    const animation = document.getElementById('refresh');
    animation.style.display = 'flex';

   
    setTimeout(() => {
        animation.style.display = 'none';
        location.reload(); 
    }, 1000); 
}

</script>
<style>
.Display_none_desktop{
    display:none;
}
  @media screen and (max-width:600px) {
      .Display_none_desktop{
        display:block;
        color:black;
        font-size:20px;
      display: flex;
       
    }
    .first-name{
        display:inline;
    }
    #navbar_nav{
        margin-left:0px !important;
        margin-top:0px !important;
    }
    .role-name{
        font-size:15px;
        display:inline;
    }
    .user-panel {
      padding: 0px 0px !important
    }
   
  }

  .solid {
    border: solid thin;
    margin: 4px;
    width: 110px;
    height: 91px;
  }

  .center {
    margin-left: 33%;
  }

  .user-panel {
    padding: 0px 1rem;
  }

  .user-panel img {
    height: 2rem;
    width: 2rem;
    margin-top: 4px;
  }

  .preloader {
    /*background-color:#f7f7f7e8;
*/
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999999;
    -webkit-transition: .6s;
    -o-transition: .6s;
    transition: .6s;
    margin: 0 auto;
  }

  .preloader .preloader-circle {
    width: 169px;
    height: 169px;
    position: relative;
    border-style: solid;
    border-width: 1px;
    border-top-color: #ff2020;
    border-bottom-color: transparent;
    border-left-color: transparent;
    border-right-color: transparent;
    z-index: 10;
    border-radius: 50% ! important;
    -webkit-box-shadow: 0 1px 5px 0 rgba(35, 181, 185, 0.15);
    box-shadow: 0 1px 5px 0 rgba(35, 181, 185, 0.15);
    background-color: #ffffff;
    -webkit-animation: zoom 2000ms infinite ease;
    animation: zoom 2000ms infinite ease;
    -webkit-transition: .6s;
    -o-transition: .6s;
    transition: .6s;
  }

  .preloader .preloader-circle2 {
    border-top-color: #0078ff;
  }

  .preloader .preloader-img {
    position: absolute;
    top: 50%;
    z-index: 200;
    left: 0;
    right: 0;
    margin: 0 auto;
    text-align: center;
    display: inline-block;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    padding-top: 6px;
    -webkit-transition: .6s;
    -o-transition: .6s;
    transition: .6s;
  }

  .preloader .preloader-img img {
    max-width: 163px
  }

  . .preloader .pere-text strong {
    font-weight: 800;
    color: #dca73a;
    text-transform: uppercase;
  }

  @-webkit-keyframes zoom {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
      -webkit-transition: .6s;
      -o-transition: .6s;
      transition: .6s
    }

    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
      -webkit-transition: .6s;
      -o-transition: .6s;
      transition: .6s
    }
  }

  @keyframes zoom {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
      -webkit-transition: .6s;
      -o-transition: .6s;
      transition: .6s
    }

    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
      -webkit-transition: .6s;
      -o-transition: .6s;
      transition: .6s;
    }
  }

  .section-padding2 {
    padding-top: 200px;
    padding-bottom: 200px;
  }

  @media only screen and (min-width: 1200px) and (max-width: 1600px) {
    .section-padding2 {
      padding-top: 200px;
      padding-bottom: 200px;
    }
  }

  @media only screen and (min-width: 992px) and (max-width: 1199px) {
    .section-padding2 {
      padding-top: 200px;
      padding-bottom: 200px;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .section-padding2 {
      padding-top: 100px;
      padding-bottom: 100px;
    }
  }

  @media only screen and (min-width: 576px) and (max-width: 767px) {
    .section-padding2 {
      padding-top: 50px;
      padding-bottom: 50px;
    }
  }

  @media (max-width: 575px) {
    .section-padding2 {
      padding-top: 50px;
      padding-bottom: 50px
    }
  }

  .padding-bottom {
    padding-bottom: 250px;
  }

  @media only screen and (min-width: 1200px) and (max-width: 1600px) {
    .padding-bottom {
      padding-bottom: 250px;
    }
  }

  @media only screen and (min-width: 992px) and (max-width: 1199px) {
    .padding-bottom {
      padding-bottom: 150px;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .padding-bottom {
      padding-bottom: 40px;
    }
  }

  @media only screen and (min-width: 576px) and (max-width: 767px) {
    .padding-bottom {
      padding-bottom: 10px;
    }
  }

  @media (max-width: 575px) {
    .padding-bottom {
      padding-bottom: 10px;
    }
  }

  .lf-padding {
    padding-left: 60px;
    padding-right: 60px;
  }

  @media only screen and (min-width: 992px) and (max-width: 1199px) {
    .lf-padding {
      padding-left: 60px;
      padding-right: 60px;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .lf-padding {
      padding-left: 30px;
      padding-right: 30px
    }
  }

  @media only screen and (min-width: 576px) and (max-width: 767px) {
    .lf-padding {
      padding-left: 15px;
      padding-right: 15px;
    }
  }

  .align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
  }

  .justify-content-center {
    -ms-flex-pack: center !important;
    justify-content: center !important;
  }

  .d-flex {
    display: -ms-flexbox !important;
    display: flex !important;
  }
 .refresh-animation {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999; /* Ensure it appears above other content */
    }
    
    .big-circle {
        width: 100px; 
        height: 100px; 
        border: 10px dashed black; 
        border-top: 10px solid transparent; /* Top transparent for spinning effect */
        border-radius: 50%;
        animation: rotate 0.6s linear infinite; /* Continuous rotation */
    }
    
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
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