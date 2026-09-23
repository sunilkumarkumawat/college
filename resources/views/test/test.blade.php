@php
$getstudents = Helper::getstudents();
$getgenders = Helper::getgender();
$classType = Helper::classType();
$getState = Helper::getState();
$getCity = Helper::getCity();
$getCountry = Helper::getCountry();
$getSetting = Helper::getSetting();
$bloodGroupType = Helper::bloodGroupType();
$getAdmissionDatatableFields = Helper::getAdmissionDatatableFields();
$list = DB::table('custom_villages_list')->orderBy('name','ASC')->whereNull('deleted_at')->get();
$gender = DB::table('gender')->whereNull('deleted_at')->pluck('name')->implode(',');
$villageList = DB::table('custom_villages_list')->whereNull('deleted_at')->pluck('name')->implode(',');
$class = DB::table('class_types')->whereNull('deleted_at')->pluck('name')->implode(',');
$setting = Db::table('settings')->whereNull('deleted_at')->first();
$stateList = DB::table('states')->where('id', 13)->pluck('name')->implode(',');
$cityList = DB::table('citys')->whereNull('deleted_at')->where('state_id', 13)->take(25)->pluck('name')->implode(',');
$bloodgroupList = DB::table('blood_groups')->whereNull('deleted_at')->pluck('name')->implode(',');
@endphp
@extends('layout.app')
@section('content')

@php
    $studentCount = DB::table('admissions')->where('deleted_at',null)->count();
@endphp
						
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<div class="content-wrapper">

	<section class="content pt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-outline card-orange">
						<div class="card-header bg-primary">
							<h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;{{ __('student.Students Admission Management') }}</h3>
							<div class="card-tools">
								<a href="{{url('admissionView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> <span class="Display_none_mobile"> {{ __('common.View') }} </span></a>
								<a href="{{url('studentsDashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> <span class="Display_none_mobile"> {{ __('common.Back') }} </span></a>
							</div>

						</div>
            <div class="row m-2">
              
             <form id="" class='col-md-7' action="{{ url('testExcel') }}" method="post" enctype="multipart/form-data">
							@csrf         
                        <div class="row ">
                            <!--<div class="col-md-2">-->
                            <!--    <label>{{ __('student.Download Excel Format') }}</label>-->
                            <!--    <button class="btn btn-danger" id="downloadExcel" type="button" data-link="schoolimage/Student_Blank_Excel_Format.xlsx"><i class="fa fa-download"></i> {{ __('student.Download Excel') }}</button>-->
                            <!--</div>-->

                            <div class="col-md-5">
                                <label>{{ __('student.Upload Excel') }} </label>
                                <div class='d-flex'>
                                <input class="form-control" type="file" id="excel" name="excel" required><button type="submit" class="ml-2 btn btn-primary">{{ __('student.Upload') }}</button>
                            </div>
                            </div>
                                                        
                           
                        </div>
                      </form>
            </div>
						              
	
                        
					</div>
				</div>
			</div>
		</div>
	</section>

</div>






@endsection