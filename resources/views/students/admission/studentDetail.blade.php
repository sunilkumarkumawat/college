@extends('layout.app') 
@section('content')
@php
$getSetting = Helper::getSetting();
$getUser = $data;

$busAssign=Helper::busAssign();
@endphp

<div class="content-wrapper">
    
   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-3">
            <div class="card card-outline card-orange">

                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-user-circle-o"></i> &nbsp;{{ __('messages.Profile')  }}</h3>
                    <div class="card-tools">
                        <!--<a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="Add User"><i class="fa fa-arrow-left"></i> Back</a>-->
                    </div>
                </div> 
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img_frame" src="{{ env('IMAGE_SHOW_PATH').'/profile/'.$getUser['image'] }}" style="width:105px; height:105px;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'">
                    </div>
    
                    <h3 class="profile-username text-center">{{ $getUser->first_name ?? '' }} {{ $getUser->last_name ?? '' }}</h3>
    
                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>{{ __('student.Admission No.')  }}</b> <a class="float-right">{{$getUser['admissionNo'] ?? ''}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>{{ __('student.Roll No')  }}</b> <a class="float-right">{{$getUser['roll_no'] ?? ''}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>{{ __('messages.Class')  }}</b> <a class="float-right">{{$getUser['ClassTypes']['name'] ?? ''}}</a>
                      </li>
                      <li class="list-group-item">
                        <b>{{ __('messages.Admission')  }}</b> 
                            @if($getUser['admission_type_id'] == 1)
                                <a class="float-right">Regular</a>
                            @endif
                            @if($getUser['admission_type_id'] == 2)
                                <a class="float-right">Non</a>
                            @endif                      
                            @if($getUser['admission_type_id'] == 3)
                                <a class="float-right">{{ __('messages.Other')  }}</a>
                            @endif                        
                        </li>                   
                    </ul>
    
                  </div>
             
            </div>

         </div>
         
          <div class="col-12 col-md-9">
            <div class="card card-outline card-orange">

                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;{{ __('messages.Personal Details')  }} </h3>
                    <div class="card-tools">
                        <a href="{{ url('studentsDashboard') }}"><button class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Back
                        </button></a>
                        @if($data->status != 3)
                        <a href="{{url('admissionEdit',$data->id)}}" class="btn btn-primary btn-sm" title="Edit Student"><i class="fa fa-edit"></i></a>
                        <!--<a href="{{url('Fees/add')}}" class="btn btn-primary  btn-sm" title="Collect Fees"><i class="fa fa-money"></i></a>-->
                        <a href="#" data-user_name="{{ $data['userName'] ?? '' }}" data-confirm_password="{{ $data['confirm_password'] ?? '' }}" data-first_name="{{ $data['first_name'] ?? '' }}" data-last_name="{{ $data['last_name'] ?? '' }}" class="btn btn-primary btn-sm loginDetail" title="Login Details"><i class="fa fa-key"></i></a>
                        <a data-id="{{ $data['id'] ?? '' }}" style="{{  $data['status'] == 0 ? 'display:none'   : ''  }}" data-status="0" class="btn btn-primary  btn-sm change_status" data-bs-toggle="modal" data-bs-target="#statusModel" title="Disable Student"><i class="fa fa-thumbs-o-up"></i></a>
                        <a data-id="{{ $data['id'] ?? '' }}" style="{{  $data['status'] == 1 ? 'display:none'   : ''  }}" data-status="1" class="btn btn-primary  btn-sm change_status " data-bs-toggle="modal" data-bs-target="#statusModel" title="Enable Student"><i style="color:red" class="fa fa-thumbs-o-down "></i></a>
                        @endif
                     </div>
                </div> 
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">{{ __('messages.Profile')  }}</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="profile">
                        <div class="card-body p-0 mb-3">
                            <table class="table table-sm table-hover border">
                                <tbody>
                                    <tr>
                                    <td>{{ __('messages.Admission Date')  }}</td>
                                    <td>@if(!empty($getUser['admission_date'])) {{ date('d-m-Y', strtotime($getUser['admission_date']))  ?? '' }} @else - @endif</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.Date Of  Birth')  }}</td>
                                    <td>{{ date('d-m-Y', strtotime($getUser['dob'])) ?? '' }} </td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.Mobile Number')  }}</td>
                                    <td>{{$getUser['mobile'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.E-Mail')  }}</td>
                                    <td>{{$getUser['email'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.Address')  }}</td>
                                    <td>{{$getUser['address'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.Gender')  }}</td>
                                    <td>{{$getUser['Gender']['name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Aadhar')  }}</td>
                                    <td>{{$getUser->aadhaar ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Jan Aadhar')  }}</td>
                                    <td>{{$getUser->jan_aadhaar ?? ''}}</td>
                                    </tr>
                                    <!--<tr>
                                    <td>{{ __('Religions')  }}</td>
                                    <td>{{$getUser->religion ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Blood Group')  }}</td>
                                    <td>{{$getUser->blood_group_type_id ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Category')  }}</td>
                                    <td>{{$getUser->caste_categories_id ?? ''}}</td>
                                    </tr>-->
                                    <tr>
                                    <td>{{ __('Country')  }}</td>
                                    <td>{{$getUser['country_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('State')  }}</td>
                                    <td>{{$getUser['state_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('City')  }}</td>
                                    <td>{{$getUser['city_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('House')  }}</td>
                                    <td>{{$getUser->house ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Height')  }}</td>
                                    <td>{{$getUser->height ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Weight')  }}</td>
                                    <td>{{$getUser->weight ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Pincode')  }}</td>
                                    <td>{{$getUser->pincode ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Remark')  }}</td>
                                    <td>{{$getUser->remark_1 ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('Previous School Name and Address')  }}</td>
                                    <td>{{$getUser->previous_school ?? ''}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-body p-0 mb-3">
                            <table class="table table-sm border table-hover">
                                <thead>
                                    <tr class="bg-light">
                                    <th width="39%" class="text-white">{{ __('messages.Parent / Guardian Details')  }} </th>
                                    <th></th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td class="col-md-4">{{ __('messages.Fathers Name')  }}</td>
                                    <td class="col-md-5">{{$getUser['father_name'] ?? ''}}</td>
                                    <td rowspan="3">
                                        <img class="profile-user-img img-fluid img_frame" src="{{ env('IMAGE_SHOW_PATH').'/father_image/'.$getUser['father_img'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'" style="width:60px; height:60px;">
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>{{ __('messages.Fathers Contact No')  }}</td>
                                    <td>{{$getUser['father_mobile'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <!--<td>{{ __('messages.Father Occupation')  }}</td>-->
                                    <!--<td>{{$getUser['null'] ?? ''}}</td>-->
                                    </tr>
                                    <tr>
                                    <td class="col-md-4">{{ __('messages.Mothers Name')  }}</td>
                                    <td class="col-md-5">{{$getUser['mother_name'] ?? ''}}</td>
                                    <td rowspan="3">
                                        <img class="profile-user-img img-fluid img_frame" src="{{ env('IMAGE_SHOW_PATH').'/mother_image/'.$getUser['mother_img'] }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/user_image.jpg' }}'" style="width:60px; height:60px;">
                                    </td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--<td>{{ __('messages.Mothers Contact No.')  }}</td>-->
                                    <!--<td>{{$getUser['mother_mobile'] ?? ''}}</td>-->
                                    <!--</tr>-->
                                    <!--<tr>-->
                                    <!--<td>{{ __('messages.Mother Occupation')  }}</td>-->
                                    <!--<td>{{$getUser['null'] ?? ''}}</td>-->
                                    <!--</tr>-->
                                </tbody>
                            </table>
                        </div>
                   
                        
                        @if(!empty($getUser))
                        @if($getUser->hostel ?? '')
                         <div class="card-body p-0 mb-3">
                            <table class="table table-sm border table-hover">
                                <thead>
                                    <tr class="bg-light">
                                    <th width="39%" class="text-white">Hostel Details</th>
                                    <th></th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>Hostel Name</td>
                                    <td>{{$hostelDeatils['hostel_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>Building</td>
                                    <td>{{$hostelDeatils['building_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>Floor</td>
                                    <td>{{$hostelDeatils['floor_name'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                    <td>Room</td>
                                    <td>{{$hostelDeatils['room_name'] ?? ''}}</td>
                                    
                                    </tr>
                                    <tr>
                                    <td>Bed No.</td>
                                    <td>{{$hostelDeatils['bed_name'] ?? ''}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                      
                                @if($getUser->library ?? '')
                        <div class="card-body p-0 mb-3">
                            <table class="table table-sm border table-hover">
                                <thead>
                                    <tr class="bg-light">
                                    <th width="39%" class="text-white">Library Details</th>
                                    <th></th>
                                    <th></th>
                                    </tr>
                                </thead>
                           
                                <tbody>
                                    <tr>
                                    <td>Library Plans</td>
                                    <td> @if(!empty($libraryDetails))
                                                   @foreach ($libraryDetails as $time)  
                                                    <span class="badge {{ date('Y-m-d') <= $time['renew_date']  ? 'badge-active' : 'badge-expired' }} ">{{$time->study_time ?? ''}} (Valid: {{ date('d-M-Y', strtotime($time['renew_date'])) }}) <br></span>
                                                   <br>
                                                   @endforeach
                                                @endif</td>
                                    </tr>
                                  
                                    
                                </tbody>
                            </table>
                        </div>
                          @endif
                          @endif
                  </div>
                 
                  <div class="tab-pane" id="fees">
                      
                          <div class="card-body p-0 mb-3">
                            <table class="table table-sm table-hover border">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Sr.No.')  }}</th>
                                        <th>{{ __('Fees Group')  }}</th>
                                        <th>{{ __('messages.Amount')  }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                @if(!empty($result['school_fees']))
                                @php
                                   $i=1;
                                $total_amount = 0;
                            
                                @endphp
                                @foreach ($result['school_fees']  as $item)
                                
                                    <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$item['group_name'] ?? ''}}</td>
                                    <td>
                                        {{$item['amount'] ?? ''}}
                                        
                                        <!--{{ $total_amount += $item['amount'] ?? 0 }}-->
                                    
                                    </td>
                                   </tr>
                                    
                                    @endforeach
                                    
                                    @endif
                                     @if(!empty($result['hostel_fees']))
                                @foreach ($result['hostel_fees']  as $item)
                                
                                    <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{'Hostel Fees'}}</td>
                                    <td>{{$item['hostel_fees'] ?? ''}}
                                     <!--{{ $total_amount += $item['hostel_fees'] ?? 0 }}-->
                                    </td>
                                   </tr>
                                    
                                    @endforeach
                                    @endif
                                     @if(!empty($result['library_fees']))
                                @foreach ($result['library_fees']  as $item)
                                
                                    <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{'Library Fees'}}</td>
                                    <td>{{$item['library_fees'] ?? ''}}
                                   <!--{{ $total_amount += $item['library_fees'] ?? 0 }}-->
                                    
                                    </td>
                                   </tr>
                                    
                                    @endforeach
                                @endif
                                
                                <tr>
                                    <th class="text-center" colspan=2>Total</th>
                                    
                                    <th >{{ $total_amount ?? 0 }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body p-0 mb-3">
                            <table class="table table-sm table-hover border">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Sr.No.')  }}</th>
                                        <th>{{ __('fees.Fees Type')  }}</th>
                                        <th>{{ __('messages.Amount')  }}</th>
                                        <th>{{ __('Deposit Date')  }}</th>
                                        <th>{{ __('messages.Pay Mode') }}</th>
                                        <th>{{ __('messages.Action')  }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                @if(!empty($result['feesDetail']))
                                @php
                                   $i=1;
                                
                            
                                @endphp
                                @foreach ($result['feesDetail']  as $item)
                                
                                    <tr>
                                    <td>{{ $i++}}</td>
                                    <td>
                                    @if( $item['fees_type'] == 0)
                                    School
                                    @elseif($item['fees_type'] == 1)
                                    Hostel
                                    @elseif($item['fees_type'] == 2)
                                    Library
                                    @endif
                                    </td>
                                    <td>{{$item['total_amount'] ?? ''}}</td>
                                    <td>{{date('d-m-Y', strtotime($item['date'] ?? ''))}}</td>
                                    <td>{{$item['PaymentMode']['name'] ?? ''}}</td>
                                    <td><a href="{{url('print_payement',$item->id)}}" target="blank" class="btn btn-success  btn-xs" title="Fees Print"><i class="fa fa-print"></i></a></td>
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
            </div>
            
          </div>
    </section>

</div>

<style>
    .card-header .nav-pills .nav-link {
        color: #db5b06;
    }
    
    .img_frame{
        border-radius:4px;
    }
</style>
<script>
    /*$( document ).ready(function() {
    var statusColor = $('#statusColor').data();
    alert(statusColor);
    if(statusColor = 0){
        $(".card").addClass("bg-danger");
    }
});*/
    $(document).on('click', ".loginDetail", function() {
        $('#Modal_id').modal('toggle');
        userName = $(this).data("user_name");
        confirm_password = $(this).data("confirm_password");
        first_name = $(this).data("first_name");
        last_name = $(this).data("last_name");

        $('#userName').html(userName);
        $('#confirm_password').html(confirm_password);
        $('#first_name').html(first_name);
        $('#last_name').html(last_name);
    });

    $(document).on('click', ".change_status", function() {
        $('#myModal').modal('toggle');
        id = $(this).data("id");
        status = $(this).data("status");
    });
    $(document).on('click', ".change_status1", function() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/stu_status',
            data: {
                status: status,
                id: id
            },
            success: function(response) {
                location.reload();
                toastr.success('Status Changed Successfully !');
            },
        });
    });
</script>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #555b5beb;">

            <div class="modal-header">
                <h4 class="modal-title text-white">{{ __('common.Status Change Confirmation') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <form action="#" method="post">
                <div class="modal-body">
                    <h5 class="text-white">{{ __('common.Are you sure you want to Change Status ?') }}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect waves-light change_status1" data-bs-dismiss="modal">{{ __('common.Yes') }}</button>
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.No') }}</button>

                </div>
            </form>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="Modal_id">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('student.Login Details') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center"><span id="first_name"></span> <span id="last_name"></span></h4>
                <div class="row border-bottom">
                    <div class="col-md-4"><b>{{ __('student.User Type') }}</b></div>
                    <div class="col-md-4"><b>{{ __('student.Username') }}</b></div>
                    <div class="col-md-4"><b>{{ __('common.Password') }}</b></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-4">{{ __('student.Student') }}</div>
                    <div class="col-md-4" id="userName"></div>
                    <div class="col-md-4" id="confirm_password"></div>
                </div>
                <div class="row mt-3">
                    <div class-"col-md-12"><b class=" text-primary">{{ __('student.Login Url') }}: &nbsp; <a href="{{url('/')}}/student/login" target="blank">{{url('/')}}/student/login</a></b></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-bs-dismiss="modal">{{ __('common.Close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
 
