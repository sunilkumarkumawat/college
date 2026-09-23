@php
$getgenders = Helper::getgender();
$getState = Helper::getState();
$getCity = Helper::getCity();
$getCountry = Helper::getCountry();
$getSetting = Helper::getSetting();
$bloodGroupType = Helper::bloodGroupType();
$batches = DB::table('batches')->get();
$getAllBranch = Helper::getAllBranch();
$getFeesGroups = DB::table('fees_group')->where('group_type','registration')->get();
$courses = DB::table('courses')->get();
@endphp

<head>
<title>{{ $getSetting->name ?? '' }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="icon" type="image/x-icon" href="{{ env('IMAGE_SHOW_PATH').'setting/left_logo/'.$getSetting->left_logo }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/mini_logo.png' }}'">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/bs-stepper/css/bs-stepper.min.css"> -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://adminlte.io/themes/v3/plugins/bs-stepper/js/bs-stepper.min.js"></script> -->
<script src="{{URL::asset('public/assets/school/js/form/submit-form.js')}}"></script>
</head>

<div class="content-wrapper reg-wrap">
@include('layout.message')

<!-- ============ HEADER ============ -->
<div class="header">
    <img src="{{env('IMAGE_SHOW_PATH').'/setting/left_logo/'.$getSetting->left_logo}}" alt="Company Logo" class="header-logo">
    <div class="header-title">
        <span class="header-eyebrow"><span class="live-dot" aria-hidden="true"></span>Admissions 2026&ndash;27</span>
        <span class="header-name">{{ $getSetting->name ?? 'Gian Sagar Educational and Charitable Trust' }}</span>
    </div>
    @if(!empty(Session::get('role_id')))
        <a href="{{url('registrationDashboard')}}" class="btn-back">&larr; Back</a>
    @else
        <a href="https://www.giansagar.net" class="btn-back">&larr; Back</a>
    @endif
</div>


<div class="container reg-container">
    <div class="row">
        <div class="col-12">

            <form id="" action="{{ url('registration') }}" class="submit-form1" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="transaction_id" id="transaction_id">

                <div class="reg-card">

                    <div class="reg-card-head">
                        <h1 class="reg-title">Student Registration</h1>
                        <p class="reg-sub">Batch 2026&ndash;27 &middot; Ram Nagar, Rajpura, Punjab</p>
                    </div>

                    <!-- ======= PULSE STEPPER ======= -->
                    <div class="bs-stepper linear pulse-stepper">
                        <p class="step-progress-text" id="stepProgressText"></p>
                        <div class="bs-stepper-header pulse-stepper-header" role="tablist">
                            <div class="step" data-target="#logins-part">
                                <button type="button" class="step-trigger pulse-node" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="false" disabled="disabled">
                                    <span class="pulse-dot">1</span>
                                    <span class="pulse-label">Registration</span>
                                </button>
                            </div>

                            <div class="pulse-line-wrap" aria-hidden="true">
                                <svg viewBox="0 0 200 40" preserveAspectRatio="none" class="pulse-svg">
                                    <path class="pulse-track" d="M0,20 L70,20 L80,6 L92,34 L104,20 L200,20"></path>
                                    <path class="pulse-fill" d="M0,20 L70,20 L80,6 L92,34 L104,20 L200,20"></path>
                                </svg>
                            </div>

                            <div class="step active" data-target="#information-part">
                                <button type="button" class="step-trigger pulse-node" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="true">
                                    <span class="pulse-dot">2</span>
                                    <span class="pulse-label">Payment</span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">

                            <!-- ============================================================= -->
                            <!-- STEP 1 : REGISTRATION DETAILS                                  -->
                            <!-- ============================================================= -->
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                                <div class="neet-lookup">
                                    <p class="neet-lookup-text">
                                        Already registered?
                                        <span class="neet-lookup-link" id="showNeetInput">Find my details</span>
                                    </p>

                                    <div class="neet-lookup-row">
                                        <div class="field-group" id="neetInputBox" style="display:none;">
                                            <label>NEET Roll No. of registered student</label>
                                            <input type="text" class="form-control mono-input" id="find_neet_roll_no"
                                                placeholder="Enter 10-digit NEET Roll No." value="{{ old('mobile') }}" maxlength="10" 
                                                onkeypress="return isNumber(event)">
                                            <input type="hidden" id="registration_id" name="registration_id" value="{{ old('registration_id') }}">
                                        </div>
                                        <div id="searchBtnBox" style="display:none;">
                                            <button type="button" class="btn-pill btn-pill-outline" id="searchNeetBtn">Search</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-label">Course &amp; Batch</div>
                                <div class="field-grid">

                                    <div class="field-group">
                                        <label>Select College/Branch<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="branch_id" name="branch_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getAllBranch))
                                                @foreach($getAllBranch as $Branch)
                                                    @if(!empty(Session::get('role_id')))
                                                        <option value="{{ $Branch->id ?? '' }}">{{ $Branch->branch_name ?? '' }}</option>
                                                    @else
                                                        @if(in_array($Branch->id, [1,2,3,4]))
                                                            <option value="{{ $Branch->id ?? '' }}">{{ $Branch->branch_name ?? '' }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback" id="branch_id_invalid" role="alert"><strong>Branch is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('Course') }}<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="course_id" name="course_id">
                                            <option value="">{{ __('Select Course') }}</option>
                                        </select>
                                        <span class="invalid-feedback" id="course_id_invalid" role="alert"><strong>Course is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>NEET Roll No.<span class="req">*</span></label>
                                        <input type="text" class="form-control mono-input invalid" id="neet_roll_no" name="neet_roll_no" placeholder="NEET Roll No." value="{{old('mobile')}}" maxlength="10" onkeypress="javascript:return isNumber(event)">
                                        <span class="invalid-feedback" id="neet_roll_no_invalid" role="alert"><strong>NEET Roll No. is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('Student Type') }}<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="student_type" name="student_type">
                                            <option value="">{{ __('common.Select') }}</option>
                                            <option value="NRI">NRI</option>
                                            <option value="Management">Management</option>
                                            <option value="Govt">Govt.</option>
                                        </select>
                                        <span class="invalid-feedback" id="student_type_invalid" role="alert"><strong>Student Type is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('Batch') }}<span class="req">*</span></label>
                                        @php
                                            $currentYear = date('Y');
                                            $savedBatch = old('batch') ?? '';
                                            $isEdit = !empty(Session::get('role_id'));
                                        @endphp
                                        <select class="form-control select2 batch_val" id="batch">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @foreach($batches as $batch)
                                                @php $isPastYear = $batch->name < $currentYear; @endphp
                                                <option value="{{ $batch->name }}"
                                                    {{ ($batch->name == $savedBatch) ? 'selected' : '' }}
                                                    {{ (!$isEdit && $isPastYear) ? 'disabled' : '' }}>
                                                    {{ $batch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="batch" id="batch_hidden" class="batch_val" value="{{ $savedBatch ?? '' }}">
                                    </div>

                                </div>

                                <div class="section-label">Student Details</div>
                                <div class="field-grid">

                                    <div class="field-group">
                                        <label>{{ __('Student Name') }}<span class="req">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control invalid" value="{{ old('first_name') }}" placeholder="{{ __('Student Name') }}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
                                        <span class="invalid-feedback" id="first_name_invalid" role="alert"><strong>Student Name is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Fathers Name') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control invalid" id="father_name" name="father_name" placeholder="{{ __('common.Fathers Name') }}" value="{{old('father_name')}}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
                                        <span class="invalid-feedback" id="father_name_invalid" role="alert"><strong>Fathers Name is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Mothers Name') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control invalid" id="mother_name" name="mother_name" placeholder="{{ __('common.Mothers Name') }}" value="{{old('mother_name')}}" onkeydown="return /[a-zA-Z ]/i.test(event.key)">
                                        <span class="invalid-feedback" id="mother_name_invalid" role="alert"><strong>Mothers Name is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('Date Of Registration') }}<span class="req">*</span></label>
                                        <input type="date" class="form-control invalid" id="registration_date" name="registration_date" value="{{date('Y-m-d')}}">
                                        <span class="invalid-feedback" id="registration_date_invalid" role="alert"><strong>Date Of Registration is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Date Of  Birth') }}<span class="req">*</span></label>
                                        <input type="date" class="form-control invalid" id="dob" name="dob" placeholder="Date Of Birth" value="{{old('dob')}}">
                                        <span class="invalid-feedback" id="dob_invalid" role="alert"><strong>Date Of  Birth is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Gender') }}<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="gender_id" name="gender_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getgenders))
                                                @foreach($getgenders as $value)
                                                    <option value="{{ $value->id}}" {{ ($value->id == old('gender_id')) ? 'selected' : '' }}>{{ $value->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback" id="gender_id_invalid" role="alert"><strong>Gender is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('Blood Group') }}<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="blood_group" name="blood_group">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($bloodGroupType))
                                                @foreach($bloodGroupType as $bloodtype)
                                                    <option value="{{ $bloodtype->name ?? '' }}" {{ ($bloodtype->name == old('blood_group')) ? 'selected' : '' }}>{{ $bloodtype->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback" id="blood_group_invalid" role="alert"><strong>Blood Group is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Mobile No.') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control mono-input invalid" id="mobile" name="mobile" placeholder="{{ __('common.Mobile No.') }}" value="{{old('mobile')}}" maxlength="10" minlength="10" onkeypress="javascript:return isNumber(event)">
                                        <span class="invalid-feedback" id="mobile_invalid" role="alert"><strong>Mobile No. is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>Category<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="category" name="category">
                                            <option value="">Select</option>
                                            <option value="OBC" {{ ('OBC' == old('category')) ? 'selected' : '' }}>OBC</option>
                                            <option value="ST" {{ ('ST' == old('category')) ? 'selected' : '' }}>ST</option>
                                            <option value="SC" {{ ('SC' == old('category')) ? 'selected' : '' }}>SC</option>
                                            <option value="BC" {{ ('BC' == old('category')) ? 'selected' : '' }}>BC</option>
                                            <option value="GEN" {{ ('GEN' == old('category')) ? 'selected' : '' }}>GEN</option>
                                            <option value="SBC" {{ ('SBC' == old('category')) ? 'selected' : '' }}>SBC</option>
                                            <option value="Other" {{ ('Other' == old('category')) ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <span class="invalid-feedback" id="category_invalid" role="alert"><strong>Category is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.E-Mail') }}<span class="req">*</span></label>
                                        <input type="email" class="form-control invalid" id="email" name="email" placeholder="{{ __('common.E-Mail') }}" value="{{old('email')}}">
                                        <span class="invalid-feedback" id="email_invalid" role="alert"><strong>E-Mail is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>Religion<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" id="religion" name="religion">
                                            <option value="">{{ __('common.Select') }}</option>
                                            <option value="Hindu" {{ ('Hindu' == old('religion')) ? 'selected' : '' }}>Hindu</option>
                                            <option value="Islam" {{ ('Islam' == old('religion')) ? 'selected' : '' }}>Islam</option>
                                            <option value="Sikh" {{ ('Sikh' == old('religion')) ? 'selected' : '' }}>Sikh</option>
                                            <option value="Buddhism" {{ ('Buddhism' == old('religion')) ? 'selected' : '' }}>Buddhism</option>
                                            <option value="Adivasi" {{ ('Adivasi' == old('religion')) ? 'selected' : '' }}>Adivasi</option>
                                            <option value="Jain" {{ ('Jain' == old('religion')) ? 'selected' : '' }}>Jain</option>
                                            <option value="Christianity" {{ ('Christianity' == old('religion')) ? 'selected' : '' }}>Christianity</option>
                                            <option value="Other" {{ ('Other' == old('religion')) ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <span class="invalid-feedback" id="religion_invalid" role="alert"><strong>Religion is required</strong></span>
                                    </div>

                                </div>

                                <div class="section-label">Address</div>
                                <div class="field-grid">

                                    <div class="field-group">
                                        <label>{{ __('common.Country') }}<span class="req">*</span></label>
                                        <select class="form-control select2 invalid" name="country_id" id="country_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getCountry))
                                                @foreach($getCountry as $country)
                                                    <option value="{{ $country->id ?? '' }}" {{ ($country->id == $getSetting->country_id) ? 'selected' : '' }}>{{ $country->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback" id="country_id_invalid" role="alert"><strong>Country is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label for="State" class="required">{{ __('common.State') }}<span class="req">*</span></label>
                                        <select class="form-control stateId invalid" id="state_id" name="state_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                            @if(!empty($getState))
                                                @foreach($getState as $state)
                                                    <option value="{{ $state->id ?? ''}}">{{ $state->name ?? ''}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="invalid-feedback" id="state_id_invalid" role="alert"><strong>State is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label for="City">{{ __('common.City') }}<span class="req">*</span></label>
                                        <select class="form-control cityId invalid" name="city_id" id="city_id">
                                            <option value="">{{ __('common.Select') }}</option>
                                        </select>
                                        <span class="invalid-feedback" id="city_id_invalid" role="alert"><strong>City is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('student.Village/City') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control invalid" id="village_city" name="village_city" placeholder="{{ __('student.Village/City') }}" value="{{old('village_city')}}">
                                        <span class="invalid-feedback" id="village_city_invalid" role="alert"><strong>Village/City is required</strong></span>
                                    </div>

                                    <div class="field-group field-group-wide">
                                        <label>{{ __('student.Students Address') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control invalid" id="address" name="address" placeholder="{{ __('student.Students Address') }}" value="{{old('address')}}">
                                        <span class="invalid-feedback" id="address_invalid" role="alert"><strong>Students Address is required</strong></span>
                                    </div>

                                    <div class="field-group">
                                        <label>{{ __('common.Pin Code') }}<span class="req">*</span></label>
                                        <input type="text" class="form-control mono-input invalid" id="pincode" name="pincode" placeholder="{{ __('common.Pin Code') }}" value="{{old('pincode')}}" maxlength="6" onkeypress="javascript:return isNumber(event)">
                                        <span class="invalid-feedback" id="pincode_invalid" role="alert"><strong>Pin Code is required</strong></span>
                                    </div>

                                </div>

                                <div class="reg-actions">
                                    <button type="submit" class="btn-pill btn-pill-primary btn-pill-lg" id="submit_registration">
                                        Save &amp; Continue to Payment &rarr;
                                    </button>
                                </div>
                            </div>

                            <!-- ============================================================= -->
                            <!-- STEP 2 : PAYMENT PROCESS                                       -->
                            <!-- ============================================================= -->
                            <div id="information-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="information-part-trigger">

                                <div class="pay-head">
                                    <h2 class="pay-title">Payment Process</h2>
                                    <p class="pay-sub">Select the applicable fee heads below to proceed.</p>
                                </div>

                                <div class="field-group">
                                    <label>Applicable Fees Groups</label>
                                    <ul id="fees_group_list" class="fees-list">
                                        <li class="list-group-item text-muted">No fees group selected.</li>
                                    </ul>
                                </div>

                                <div class="pay-summary">
                                    <div class="pay-total">
                                        <span class="pay-total-label">Total Amount</span>
                                        <span class="pay-total-amount">&#8377;<span id="total_amount">0</span></span>
                                    </div>

                                    <div class="field-group">
                                        <label>Payment Mode</label>
                                        <select class="form-control" id="payment_mode_id" name="payment_mode_id" required="">
                                            <option value="">Select</option>
                                            @if(!empty(Session::get('role_id')))
                                                <option value="1">Cash</option>
                                                <option value="10">Debit/Credit Card</option>
                                            @endif
                                            <option value="6">UPI/Online</option>
                                        </select>
                                        <div class="manual_transaction_id_div d-none">
                                            <label class="text-white">Transaction ID </label>
                                            <input type="text" id="manual_transaction_id" name="manual_transaction_id" class="form-control" placeholder="Enter transaction id..."  />
                                        </div>
                                    </div>
                             
                                </div>

                                <input type="hidden" class="form-control invalid w-20" id="registration_invoice_no" name="registration_invoice_no" value="{{$BillCounter ?? ''}}">
                                <div class="fees_group_list"></div>
                                <div class="idsHtmlamont"></div>

                                <div class="reg-actions reg-actions-split">
                                    <button type="button" class="btn-pill btn-pill-outline" onclick="stepper.previous()">&larr; Previous</button>
                                    <button type="submit" class="btn-pill btn-pill-primary btn-pill-lg" id="final_submit">Pay Fees &amp; Submit</button>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="reg-card-foot">
                        For any query visit the Gian Sagar Educational and Charitable Trust: Ram Nagar, Rajpura Distt. Patiala, Punjab-140401
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>



<!-- <div class="closed-wrap">
    <div class="closed-card">
        <div class="closed-icon">&#9940;</div>
        <h2 class="closed-title">Online Registration Closed</h2>
        <p class="closed-text">For Offline Registration, please visit our <strong>College Campus</strong>.</p>
    </div>
</div> -->



</div>

<!-- Loading screen modal -->
<div class="modal reg-loading-modal" id="loadingModal" data-backdrop="static" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="w-100">
      <div class="modal-body text-center">
        <div class="ecg-loader" aria-hidden="true">
            <svg viewBox="0 0 220 60" class="ecg-loader-svg">
                <path class="ecg-loader-track" d="M0,30 L60,30 L72,8 L86,52 L98,30 L220,30"></path>
                <path class="ecg-loader-pulse" d="M0,30 L60,30 L72,8 L86,52 L98,30 L220,30"></path>
            </svg>
        </div>
        <p class="loading-title">Paying fees, please wait&hellip;</p>
        <p class="loading-sub">Please do not hit refresh, back button, or close this window.</p>
      </div>
    </div>
  </div>
</div>

<script>
class Stepper {
    constructor(el) {
        this.el = el;
        this.steps = Array.from(el.querySelectorAll('.step'));
        this.contents = Array.from(el.querySelectorAll('.bs-stepper-content > .content'));
        this.activeIndex = 0;
        this._show(0); // hamesha first step se start, chahe markup me kuch bhi ho
    }
    _show(index) {
        if (index < 0 || index >= this.steps.length) return;
        this.steps.forEach((step, i) => {
            const trigger = step.querySelector('.step-trigger');
            step.classList.toggle('active', i === index);
            if (trigger) trigger.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });
        this.contents.forEach((content, i) => {
            content.classList.toggle('active', i === index);
            content.classList.toggle('dstepper-block', i === index);
        });
        this.activeIndex = index;
        this.el.dispatchEvent(new CustomEvent('shown.bs-stepper', { detail: { indexStep: index } }));
    }
    next() { this._show(this.activeIndex + 1); }
    previous() { this._show(this.activeIndex - 1); }
    to(index) { this._show(index); }
}
</script>
<script>
document.getElementById('batch').addEventListener('change', function () {
    document.getElementById('batch_hidden').value = this.value;
});
</script>

<script>
     let allCourses = @json($courses);
$(document).ready(function () {
    $('#branch_id').on('change', function () {
        let branchId = $(this).val();
        $('#course_id').empty().append('<option value="">Select Course</option>');
        let filteredCourses = allCourses.filter(course => course.branch_id == branchId);
        filteredCourses.forEach(function(course) {
            $('#course_id').append('<option value="' + course.id + '">' + course.name + '</option>');
        });
    });
});
</script>

<script>
$(document).on('change', '.fees_group_checkbox, .partial_checkbox', function () {
    let total = 0;
    $('.fees_group_checkbox:checked').each(function () {
        total += parseFloat($(this).data('amount'));
    });
    $('#total_amount').text(total.toFixed(2));
});
$(document).on('change', '.partial_checkbox', function () {
    const partial = $(this);
    const id = partial.data('id');
    const full = parseFloat(partial.data('full'));
    const isChecked = partial.is(':checked');
    const newAmount = isChecked ? (full / 2) : full;
    $('.amount_display[data-id="' + id + '"]').text(newAmount);
    let mainCheckbox = $('.fees_group_checkbox[value="' + id + '"]');
    mainCheckbox.data('amount', newAmount);
    calculateTotal();
});
$(document).on('change', '.fees_group_checkbox', function () {
    calculateTotal();
});
function calculateTotal() {
    let total = 0;
    $('.fees_group_checkbox:checked').each(function () {
        total += parseFloat($(this).data('amount'));
    });
    $('#total_amount').text(total.toFixed(2));
}

$(document).ready(function() {

    let registrationId = null;

    $('#submit_registration').click(function(e) {
        e.preventDefault();
        var all_filled_up = true;

        $('.invalid').each(function() {
            var this_value = $(this).val();
            var this_id = $(this).attr('id');
            if (this_value.trim() === '') {
                $('#' + this_id + '_invalid').css('display', 'block');
                all_filled_up = false;
            } else {
                $('#' + this_id + '_invalid').css('display', 'none');
            }
        });
        let student_type = $('#student_type').val();
        $('#student_type').val(student_type).trigger('change');

        if (all_filled_up) {
            var formData = new FormData($('.submit-form1')[0]);
            $.ajax({
                url: "{{ url('registration') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status === true) {
                        toastr.success(res.message);
                        registrationId = res.registration_id;
                        $('#registration_id').val(registrationId);
                        window.stepper.next(); 
                    } else {
                        toastr.error('Something went wrong.');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_invalid').text(value[0]).show();
                        });
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    } else {
                        toastr.error('Server error. Please try again.');
                    }
                }
            });
        } else {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });

    $('#final_submit').click(function(e) {
        e.preventDefault();
        if (!registrationId) {
            toastr.error("Please complete registration first.");
            return;
        }

        var payment_mode_id = $('#payment_mode_id').val();
        var transaction_id = $('#transaction_id').val();
        var registration_invoice_no = $('#registration_invoice_no').val();
        var manual_transaction_id = $('#manual_transaction_id').val();

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('registration_id', registrationId);
        formData.append('payment_mode_id', payment_mode_id);
        formData.append('transaction_id', transaction_id);
        formData.append('registration_invoice_no', registration_invoice_no);

        var checkedFees = $('.fees_group_checkbox:checked');
        if (checkedFees.length === 0) {
            toastr.error("Please select at least one Fees Head.");
            return;
        }

        $('.fees_group_checkbox:checked').each(function() {
            formData.append('registration_fees_master_ids[]', $(this).val());
            formData.append('amount[]', $(this).data('amount'));
        });

        if (payment_mode_id == 1) {
            finalSubmit(formData);
        } else if (payment_mode_id == 6) {
            onlineTransaction(formData);
        } else if (payment_mode_id == 10) {
            if(payment_mode_id == 10 && manual_transaction_id == ''){
                toastr.error('Please enter transaction id for card payment');
                return;
            }
            if(payment_mode_id == 10 && manual_transaction_id != ''){
                formData.set('transaction_id', manual_transaction_id);
            }
            finalSubmit(formData);
        } else {
            toastr.error('Please Select Payment Mode');
        }
    });

    function finalSubmit(formData) {
        $.ajax({
            url: "{{ url('registration/saveFees') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === true) {
                    toastr.success(res.message);

                    allowRefresh = true;
                    window.onbeforeunload = null;

                    @if(Session::get('role_id') == 1)
                        window.location.href = "{{ url('registrationList') }}";
                    @else
                        let amountPaid = $('#total_amount').text();
                        let receiptUrl = "{{ url('registrationList/print') }}/"
                            + res.registration_id + "/"
                            + res.payment_date + "/"
                            + res.registration_invoice_no;
                        showPhonePeModal("success", amountPaid, receiptUrl);
                    @endif
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save fee details. Please try again.');
            }
        });
    }

    function onlineTransaction(){
        var btn = $('#final_submit');
        $('#loadingModal').addClass('show');

        let newTab = window.open("", "_blank");
        var name = $('#first_name').val();
        var total_amount = $('#total_amount').text();
        var email = $('#email').val();
        var requestAmount = total_amount;
        fetch("{{ url('payuPaymentInitiateUniversal') }}", {
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json"
            },
            method: "POST",
            body: JSON.stringify({amount: requestAmount, name: name, email: email})
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const txnidInput = doc.querySelector('input[name="txnid"]');

            if (newTab) {
                newTab.document.open();
                newTab.document.write(html);
                newTab.document.close();

                let checkTab = setInterval(() => {
                    if (newTab.closed) {
                        clearInterval(checkTab);
                        if(txnidInput.value){
                            checkTransactionStatusUniversal(txnidInput.value, requestAmount);
                        } else {
                            alert('Something went wrong !');
                        }
                        $('#loadingModal').removeClass('show');
                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
                    }
                }, 500);

                window.onbeforeunload = function () {
                    if (!allowRefresh) {
                        return "Are you sure you want to cancel the payment?";
                    }
                };
            } else {
                alert("Popup blocked! Please allow popups for this site.");
            }
        })
        .catch(error => {
            if (newTab) newTab.close();
            console.error("Error loading payment page:", error);
        });
    }

    function checkTransactionStatusUniversal(txnid, requestAmount) {
        fetch("{{ url('checkTransactionStatusUniversal') }}/" + txnid, { method: "GET" })
        .then(response => response.json())
        .then(data => {
            console.log("Payment status:", data.message);
            if(data.status == true){
                //showPhonePeModal("success", requestAmount);
                var transaction_id = data.txnid;
                $('#transaction_id').val(transaction_id);
                var payment_mode_id = $('#payment_mode_id').val();

                var formData1 = new FormData();
                formData1.append('_token', '{{ csrf_token() }}');
                formData1.append('registration_id', registrationId);
                formData1.append('payment_mode_id', payment_mode_id);
                formData1.append('transaction_id', transaction_id);

                $('.fees_group_checkbox:checked').each(function() {
                    formData1.append('registration_fees_master_ids[]', $(this).val());
                    formData1.append('amount[]', $(this).data('amount'));
                });

                finalSubmit(formData1);
            } else if(data.status == false){
                showPhonePeModal("failed", 0);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }

    let gseRedirectTimer = null;

    function showPhonePeModal(status, amount, receiptUrl) {
        const successIcon = `
            <svg viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M8 12.5 10.8 15.5 16 9.5"/>
            </svg>`;
        const failIcon = `
            <svg viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M15 9 9 15M9 9l6 6"/>
            </svg>`;

        let modalHtml = `
            <div class="phonepe-modal" id="transactionResultModal">
                <div class="modal-box ${status}">
                    <div class="icon">${status === "success" ? successIcon : failIcon}</div>
                    <h2>${status === "success" ? "Payment Successful!" : "Payment Failed"}</h2>
                    <p>${status === "success" ? `₹${amount} paid successfully` : "Your transaction was unsuccessful."}</p>
                    ${status === "success" ? `
                        <div class="gse-redirect-track">
                            <div class="gse-redirect-fill" id="gseRedirectFill"></div>
                        </div>
                        <p class="gse-redirect-text" id="gseRedirectText">Taking you to your receipt in 5s…</p>
                        <button id="transactionResultBtn" data-status="success" data-receipt-url="${receiptUrl}">View Receipt Now</button>
                    ` : `
                        <button id="transactionResultBtn" data-status="failed">OK</button>
                    `}
                </div>
            </div>`;
        document.body.insertAdjacentHTML("beforeend", modalHtml);

        if (status === "success" && receiptUrl) {
            let seconds = 10;
            const fill = document.getElementById('gseRedirectFill');
            const text = document.getElementById('gseRedirectText');

            requestAnimationFrame(() => {
                fill.style.transition = `width ${seconds}s linear`;
                fill.style.width = '100%';
            });

            gseRedirectTimer = setInterval(function () {
                seconds -= 1;
                if (text) text.textContent = seconds > 0
                    ? `Taking you to your receipt in ${seconds}s…`
                    : `Opening your receipt…`;
                if (seconds <= 0) {
                    clearInterval(gseRedirectTimer);
                    window.location.href = receiptUrl;
                }
            }, 1000);
        }
    }

    let allowRefresh = false;

    $(document).on("click", "#transactionResultBtn", function(){
        allowRefresh = true;
        let status = $(this).data('status');
        let receiptUrl = $(this).data('receipt-url');

        if (gseRedirectTimer) clearInterval(gseRedirectTimer);

        if (status === 'success' && receiptUrl) {
            window.location.href = receiptUrl;
        } else {
            @if(Session::get('role_id') == 1)
                window.location.href = "{{ url('registrationList') }}";
            @else
                window.location.href = "https://www.giansagar.net";
            @endif
        }

        let modal = document.getElementById("transactionResultModal");
        if (modal) modal.remove();
    });

    checkPopUps();

    function checkPopUps() {
        if (!isSafari()) return;
        var newWindow = window.open('', '_blank');
        if (!newWindow || newWindow.closed || typeof newWindow.closed == "undefined") {
            alert("POP-UPS ARE BLOCKED! To enable them:\n\n" +
                "\uD83D\uDCF1 FOR SAFARI (iPhone/iPad):\n" +
                "1. Open 'Settings'.\n" +
                "2. Scroll down and tap 'Safari'.\n" +
                "3. Find 'Block Pop-ups' under 'General'.\n" +
                "4. Toggle OFF 'Block Pop-ups' (it should turn gray).\n\n"
            );
            window.location.reload();
        } else {
            newWindow.close();
        }
    }

    function isSafari() {
        let ua = navigator.userAgent.toLowerCase();
        return ua.includes("safari") && !ua.includes("chrome");
    }

    $('#payment_mode_id').change(function() {
        if ($(this).val() == '10') {
            $('.manual_transaction_id_div').removeClass('d-none');
        } else {
            $('.manual_transaction_id_div').addClass('d-none');
        }
    });

});
</script>

<script>
    $('#neet_roll_no').on('change', function () {
        let neet_roll_no = $(this).val();
        let get_by_neet = $('#find_neet_roll_no').val();

        if (!get_by_neet) {
            $.ajax({
                url: "{{ url('/get_duplicate_registration') }}",
                type: "POST",
                data: { neet_roll_no: neet_roll_no, _token: '{{ csrf_token() }}' },
                success: function (res) {
                    if (!res.success) {
                        $('#neet_roll_no_invalid').show();
                        $('#neet_roll_no').addClass('is-invalid');
                        $('#neet_roll_no_invalid strong').text(res.message);
                        $('#neet_roll_no').val('');
                    } else {
                        $('#neet_roll_no_invalid').hide();
                        $('#neet_roll_no').removeClass('is-invalid');
                    }
                }
            });
        }
    });

    $('#searchNeetBtn').click(function () {
        $('#neet_roll_no_invalid').hide();
        $('#neet_roll_no').removeClass('is-invalid');
    });

    $('#student_type,#branch_id,#course_id').on('change', function () {
        let type = $(this).val();
        let branch_id = $('#branch_id').val();
        let course_id = $('#course_id').val();
        let registration_id = $('#registration_id').val();

        if (!type) {
            $('#fees_group_list').html('<li class="list-group-item text-muted">No fees group selected.</li>');
            return;
        }

        $.ajax({
            url: "{{ url('/get-fees-groups') }}",
            type: "POST",
            data: {
                student_type: type,
                branch_id: branch_id,
                course_id: course_id,
                registration_id: registration_id,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                if (res.status) {
                    $('#fees_group_list').html(res.html);
                } else {
                    $('#fees_group_list').html('<li class="list-group-item text-danger">No fees group found.</li>');
                    $('#fees_master_hidden_inputs').html('');
                }
            },
            error: function () {}
        });
    });

    $(document).on('change', '.partial_checkbox', function () {
        const partial = $(this);
        const id = partial.data('id');
        const full = parseFloat(partial.data('full'));
        const isChecked = partial.is(':checked');
        const newAmount = isChecked ? (full / 2) : full;
        $('.amount_display[data-id="' + id + '"]').text(newAmount);
        $('.fees_group_checkbox[value="' + id + '"]').data('amount', newAmount);
    });
</script>

<script>
    $(document).ready(function () {
        $('#showNeetInput').on('click', function () {
            $('#neetInputBox').slideDown();
            $('#searchBtnBox').slideDown();
        });

        $('#searchNeetBtn').on('click', function () {
            let neetRoll = $('#find_neet_roll_no').val().trim();
            if (neetRoll.length !== 10) {
                alert("Please enter a valid 10-digit NEET Roll No.");
                return;
            }

            $.ajax({
                url: '{{ url("registration/get-by-neet") }}',
                method: 'GET',
                data: { neet_roll_no: neetRoll },
                success: function (res) {
                    if (res.success === true) {
                        let d = res.data;
                        $('#registration_id').val(d.id);
                        $('#first_name').val(d.first_name);
                        $('#neet_roll_no').val(d.neet_roll_no);
                        $('#father_name').val(d.father_name);
                        $('#mother_name').val(d.mother_name);
                        $('#dob').val(d.dob);
                        $('#mobile').val(d.mobile);
                        $('#email').val(d.email);
                        $('#pincode').val(d.pincode);
                        $('#address').val(d.address);
                        $('#village_city').val(d.village_city);
                        $('#registration_date').val(d.registration_date);
                        $('#category').val(d.category).trigger('change');
                        $('#blood_group').val(d.blood_group).trigger('change');
                        $('#religion').val(d.religion).trigger('change');
                        $('#student_type').val(d.student_type).trigger('change');
                        $('.batch_val').val(d.batch);
                        $('#batch').val(d.batch).trigger('change');
                        $('#gender_id').val(d.gender_id).trigger('change');
                        $('#branch_id').val(d.branch_id).trigger('change');
                        $('#country_id').val(d.country_id).trigger('change');
                        setTimeout(function () {
                            $('#course_id').val(d.course_id).trigger('change');
                            $('#state_id').val(d.state_id).trigger('change');
                        }, 500);
                        setTimeout(function () {
                            $('#city_id').val(d.city_id).trigger('change');
                        }, 1000);
                        $('#student_type').val(d.student_type).trigger('change');
                    } else {
                        toastr.error('No registration found for this NEET Roll No.');
                    }
                },
                error: function () {
                    alert("Something went wrong.");
                }
            });
        });
    });

    function isNumber(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        return (charCode >= 48 && charCode <= 57);
    }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'));

    var stepEl = document.querySelector('.bs-stepper');
    var progressText = document.getElementById('stepProgressText');

    function updateStepProgress() {
        if (!progressText) return;
        var activeStep = stepEl.querySelector('.step.active');
        if (!activeStep) return;
        var isPayment = activeStep.getAttribute('data-target') === '#information-part';
        progressText.textContent = isPayment
            ? 'Step 2 of 2 \u00B7 Payment process'
            : 'Step 1 of 2 \u00B7 Registration details';
    }

    updateStepProgress();
    stepEl.addEventListener('shown.bs-stepper', updateStepProgress);
  });

  function isNumber(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
  }

$(document).ready(function(){
    $('#country_id').on('change', function(e){
        var baseurl = "{{ url('/') }}";
        var country_id = $(this).val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            url: baseurl+'/countryData/'+country_id,
            success: function(data){ $("#state_id").html(data); }
        });
    });
    $('#state_id').on('change', function(e){
        var baseurl = "{{ url('/') }}";
        var state_id = $(this).val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
            url: baseurl+'/stateData/'+state_id,
            success: function(data){ $("#city_id").html(data); }
        });
    });
});
</script>

<!-- ============================================================= -->
<!-- CARE-CLINICAL DESIGN SYSTEM                                   -->
<!-- ============================================================= -->
<style>
:root{
    --ink:#0D2B2E;
    --bg:#F3F9F8;
    --surface:#FFFFFF;
    --teal-900:#0F4C5C;
    --teal-700:#146B7A;
    --teal-500:#14B8A6;
    --teal-100:#E4F5F2;
    --coral:#FF6B4A;
    --coral-700:#E4522F;
    --line:#DCEAE8;
    --muted:#5C7A78;
    --danger:#E5484D;
    --font-display:'Space Grotesk', 'Inter', sans-serif;
    --font-body:'Inter', -apple-system, sans-serif;
    --font-mono:'IBM Plex Mono', monospace;
    --radius:16px;
    --shadow-card:0 12px 32px -16px rgba(15,76,92,0.22);
}
.pointer{cursor:pointer}
.reg-wrap{ font-family:var(--font-body); color:var(--ink); background:var(--bg); position:relative; overflow-x:hidden; min-height:100vh; }
.reg-wrap *{ box-sizing:border-box; }
.reg-wrap::before, .reg-wrap::after{
    content:''; position:fixed; z-index:0; pointer-events:none; border-radius:50%; filter:blur(60px); opacity:.16;
}
.reg-wrap::before{ width:340px; height:340px; background:var(--teal-500); top:-120px; right:-100px; }
.reg-wrap::after{ width:300px; height:300px; background:var(--coral); bottom:-100px; left:-100px; }
.reg-wrap > *{ position:relative; z-index:1; }

/* ---------- header ---------- */
.reg-wrap .header{
    display:flex; align-items:center; gap:14px;
    padding:14px 18px; background:var(--surface);
    border-bottom:1px solid var(--line);
    position:sticky; top:0; z-index:20;
    box-shadow:0 2px 12px -8px rgba(15,76,92,0.15);
}
.header-logo{ max-height:42px; border-radius:8px; flex-shrink:0; }
.header-title{ display:flex; flex-direction:column; line-height:1.15; flex:1; min-width:0; }
.header-eyebrow{ font-family:var(--font-mono); font-size:11px; letter-spacing:.06em; text-transform:uppercase; color:var(--teal-500); display:inline-flex; align-items:center; gap:6px; }
.live-dot{ width:7px; height:7px; border-radius:50%; background:var(--coral); flex-shrink:0; box-shadow:0 0 0 0 rgba(255,107,74,.6); animation:liveDotPulse 1.8s ease-out infinite; }
@keyframes liveDotPulse{ 0%{ box-shadow:0 0 0 0 rgba(255,107,74,.55); } 70%{ box-shadow:0 0 0 8px rgba(255,107,74,0); } 100%{ box-shadow:0 0 0 0 rgba(255,107,74,0); } }
.header-name{ font-family:var(--font-display); font-weight:600; font-size:15px; color:var(--teal-900); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.btn-back{
    flex-shrink:0; font-family:var(--font-body); font-weight:600; font-size:13px;
    color:var(--teal-900); background:var(--teal-100); border:1px solid var(--line);
    padding:8px 14px; border-radius:999px; text-decoration:none; transition:.15s ease;
}
.btn-back:hover{ background:var(--teal-500); color:#fff; text-decoration:none; }

/* ---------- container / card ---------- */
.reg-container{ padding:18px 14px 60px; max-width:960px; }
.reg-card{
    background:var(--surface); border-radius:var(--radius);
    box-shadow:var(--shadow-card); border:1px solid var(--line);
    overflow:hidden;
    animation:cardIn .5s cubic-bezier(.22,.9,.32,1.1) both;
}
@keyframes cardIn{ from{ opacity:0; transform:translateY(18px); } to{ opacity:1; transform:translateY(0); } }
.reg-card-head{ padding:22px 20px 6px; }
.reg-title{ font-family:var(--font-display); font-weight:700; font-size:22px; color:var(--teal-900); margin:0; }
.reg-sub{ font-size:13px; color:var(--muted); margin:4px 0 0; }
.reg-card-foot{
    padding:16px 20px; border-top:1px solid var(--line); background:var(--teal-100);
    font-size:12px; color:var(--teal-700); text-align:center; font-style:italic;
}

/* ---------- pulse stepper (signature element) ---------- */
.step-progress-text{ margin:14px 20px 0; font-family:var(--font-mono); font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:var(--teal-500); }
.bs-stepper-content .content{ display:none; }
.bs-stepper-content .content.active{ display:block; }
.pulse-stepper-header{ display:flex; align-items:center; gap:0; padding:10px 20px 8px; }
.pulse-node{
    background:none; border:none; display:flex; flex-direction:column; align-items:center; gap:6px;
    cursor:default; opacity:.55;
}
.step.active .pulse-node{ opacity:1; }
.pulse-dot{
    width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-family:var(--font-mono); font-weight:600; font-size:13px;
    background:var(--teal-100); color:var(--teal-700); border:2px solid var(--line);
}
.step.active .pulse-dot{ background:var(--teal-500); color:#fff; border-color:var(--teal-500); box-shadow:0 0 0 5px rgba(20,184,166,.15); }
.pulse-label{ font-size:11px; font-weight:600; letter-spacing:.02em; color:var(--muted); }
.step.active .pulse-label{ color:var(--teal-900); }
.pulse-line-wrap{ flex:1; height:24px; margin:0 6px 20px; }
.pulse-svg{ width:100%; height:100%; overflow:visible; }
.pulse-track{ fill:none; stroke:var(--line); stroke-width:2.5; }
.pulse-fill{
    fill:none; stroke:var(--teal-500); stroke-width:2.5; stroke-linecap:round; stroke-linejoin:round;
    stroke-dasharray:260; stroke-dashoffset:260;
    animation:pulseDraw 1.8s ease-out forwards .2s, pulseGlow 2.6s ease-in-out infinite 2s;
}
@keyframes pulseDraw{ to{ stroke-dashoffset:0; } }
@keyframes pulseGlow{ 0%,100%{ opacity:1; } 50%{ opacity:.55; } }

/* ---------- section labels ---------- */
.section-label{
    font-family:var(--font-mono); font-size:11px; letter-spacing:.08em; text-transform:uppercase;
    color:var(--teal-500); margin:22px 20px 10px; padding-top:14px; border-top:1px dashed var(--line);
}
.bs-stepper-content .content > .section-label:first-child{ border-top:none; margin-top:6px; }

/* ---------- field grid ---------- */
.field-grid{ display:grid; grid-template-columns:1fr; gap:14px; padding:0 20px; }
@media(min-width:640px){ .field-grid{ grid-template-columns:1fr 1fr; } }
@media(min-width:960px){ .field-grid{ grid-template-columns:1fr 1fr 1fr; } }
.field-group{ display:flex; flex-direction:column; gap:6px; }
.field-group-wide{ grid-column:1 / -1; }
.field-group label{ font-size:12.5px; font-weight:600; color:var(--teal-900); margin:0; }
.req{ color:var(--coral); margin-left:2px; }

.reg-wrap .form-control{
    height:48px; border-radius:10px; border:1.5px solid var(--line);
    background:var(--surface); font-family:var(--font-body); font-size:16px; color:var(--ink);
    padding:10px 14px; transition:border-color .15s ease, box-shadow .15s ease, transform .15s ease;
}
.reg-wrap .form-control:focus{
    outline:none; border-color:var(--teal-500); box-shadow:0 0 0 4px rgba(20,184,166,.14);
    transform:translateY(-1px);
}
.reg-wrap select.form-control{ appearance:none; background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='9'><path d='M1 1l6 6 6-6' stroke='%235C7A78' stroke-width='2' fill='none' fill-rule='evenodd'/></svg>"); background-repeat:no-repeat; background-position:right 14px center; }
.mono-input{ font-family:var(--font-mono); letter-spacing:.03em; }
.reg-wrap .invalid-feedback strong{ font-weight:600; font-size:12px; color:var(--danger); }

/* ---------- neet lookup ---------- */
.neet-lookup{ margin:16px 20px 4px; padding:14px 16px; background:var(--teal-100); border:1px dashed var(--teal-500); border-radius:12px; }
.neet-lookup-text{ margin:0; font-size:13.5px; color:var(--teal-900); }
.neet-lookup-link{ color:var(--coral-700); font-weight:700; cursor:pointer; text-decoration:underline; }
.neet-lookup-row{ display:flex; flex-wrap:wrap; align-items:flex-end; gap:10px; }
.neet-lookup-row .field-group{ flex:1; min-width:220px; }

/* ---------- actions ---------- */
.reg-actions{ padding:26px 20px 10px; display:flex; justify-content:flex-end; }
.reg-actions-split{ justify-content:space-between; }
.btn-pill{
    font-family:var(--font-body); font-weight:700; font-size:14px; border-radius:999px;
    padding:11px 22px; border:1.5px solid transparent; cursor:pointer; transition:transform .12s ease, box-shadow .12s ease, background .15s ease, color .15s ease, border-color .15s ease;
    text-decoration:none; -webkit-tap-highlight-color:transparent; min-height:46px;
}
.btn-pill-primary{ background:var(--coral); color:#fff; box-shadow:0 10px 24px -10px rgba(255,107,74,.55); }
.btn-pill-primary:hover{ background:var(--coral-700); color:#fff; transform:translateY(-1px); }
.btn-pill-primary:active{ transform:translateY(0) scale(.97); box-shadow:0 4px 12px -6px rgba(255,107,74,.55); }
.btn-pill-outline{ background:transparent; border-color:var(--line); color:var(--teal-900); }
.btn-pill-outline:hover{ border-color:var(--teal-500); color:var(--teal-500); }
.btn-pill-outline:active{ transform:scale(.97); }
.btn-pill-lg{ padding:13px 28px; font-size:15px; }

/* ---------- payment step ---------- */
.pay-head{ padding:6px 20px 0; }
.pay-title{ font-family:var(--font-display); font-weight:700; font-size:19px; color:var(--teal-900); margin:0; }
.pay-sub{ font-size:13px; color:var(--muted); margin:4px 0 14px; }
.pay-head + .field-group{ padding:0 20px; }
.fees-list{ list-style:none; margin:8px 0 0; padding:0; display:flex; flex-direction:column; gap:8px; }
.fees-list .list-group-item{
    border:1.5px solid var(--line); border-radius:12px; padding:12px 14px; background:var(--surface);
    font-size:14px; transition:.15s ease;
}
.fees-list .list-group-item:has(input:checked){ border-color:var(--teal-500); background:var(--teal-100); }
.fees-list input[type="checkbox"]{ width:18px; height:18px; accent-color:var(--teal-500); margin-right:8px; vertical-align:middle; }
.fees-list .badge-pill{ font-family:var(--font-mono); background:var(--teal-900) !important; border-radius:5px; align-content: center; }
.fees-list label{ font-size:12.5px; color:var(--teal-700); display:inline-block; }

.pay-summary{ margin:18px 20px 0; padding:16px; background:var(--teal-900); border-radius:14px; display:flex; flex-wrap:wrap; gap:16px; align-items:flex-end; justify-content:space-between; }
.pay-total{ display:flex; flex-direction:column; gap:2px; }
.pay-total-label{ font-family:var(--font-mono); font-size:11px; letter-spacing:.06em; text-transform:uppercase; color:rgba(255,255,255,.65); }
.pay-total-amount{ font-family:var(--font-display); font-weight:700; font-size:30px; color:#fff; }
.pay-summary .field-group{ min-width:200px; }
.pay-summary .field-group label{ color:rgba(255,255,255,.85); }
.pay-summary select.form-control{ background-color:#fff; }

/* ---------- closed state ---------- */
.closed-wrap{ display:flex; justify-content:center; align-items:center; padding:60px 16px; }
.closed-card{ background:linear-gradient(135deg, var(--coral), var(--coral-700)); color:#fff; padding:34px 28px; border-radius:20px; box-shadow:0 20px 40px -18px rgba(228,82,47,.5); max-width:420px; text-align:center; }
.closed-icon{ font-size:36px; margin-bottom:8px; }
.closed-title{ font-family:var(--font-display); font-weight:700; font-size:22px; margin:0 0 8px; }
.closed-text{ font-size:14.5px; margin:0; }

/* ---------- loading modal (fully self-contained, no Bootstrap JS needed) ---------- */
#loadingModal.reg-loading-modal{
    display:none; position:fixed; inset:0; z-index:2000;
    align-items:center; justify-content:center;
    background:rgba(13,43,46,.68); backdrop-filter:blur(4px);
    padding:16px;
}
#loadingModal.reg-loading-modal.show{ display:flex; animation:overlayIn .2s ease both; }
@keyframes overlayIn{ from{ opacity:0; } to{ opacity:1; } }
.reg-loading-modal .modal-dialog{ margin:0; max-width:320px; width:100%; }
.reg-loading-modal .modal-body{ background:var(--teal-900); border-radius:18px; padding:26px 20px; box-shadow:0 30px 60px -20px rgba(0,0,0,.5); animation:modalPop .3s cubic-bezier(.22,.9,.32,1.3) both; }
@keyframes modalPop{ from{ opacity:0; transform:scale(.88) translateY(10px); } to{ opacity:1; transform:scale(1) translateY(0); } }
.ecg-loader{ width:100%; height:56px; margin-bottom:6px; }
.ecg-loader-svg{ width:100%; height:100%; }
.ecg-loader-track{ fill:none; stroke:rgba(255,255,255,.18); stroke-width:2.5; }
.ecg-loader-pulse{
    fill:none; stroke:var(--teal-500); stroke-width:3; stroke-linecap:round; stroke-linejoin:round;
    stroke-dasharray:60 400; stroke-dashoffset:0;
    animation:ecgTravel 1.6s linear infinite;
}
@keyframes ecgTravel{ from{ stroke-dashoffset:0; } to{ stroke-dashoffset:-460; } }
.loading-title{ color:#fff; font-weight:700; font-size:14.5px; margin:4px 0 2px; }
.loading-sub{ color:rgba(255,255,255,.7); font-size:12px; margin:0; }

/* ---------- phonepe result modal (kept, restyled) ---------- */
.phonepe-modal{
    position:fixed; top:0; left:0; width:100%; height:100%; z-index:1050;
    background:rgba(13,43,46,.55); display:flex; justify-content:center; align-items:center; backdrop-filter:blur(8px);
}
.modal-box{
    background:linear-gradient(135deg, var(--teal-900), var(--teal-500));
    color:#fff; text-align:center; padding:26px 22px; border-radius:18px; width:280px;
    box-shadow:0 20px 40px -16px rgba(0,0,0,.4); animation:slideUp .3s;
    position:relative; overflow:hidden;
    font-family:var(--font-body);
}
.modal-box.failed{ background:linear-gradient(135deg, var(--coral-700), var(--coral)); }
.gse-redirect-track {
    width: 100%;
    height: 6px;
    background: rgba(255,255,255,0.2);
    border-radius: 999px;
    overflow: hidden;
    margin: 14px 0 8px;
}
.gse-redirect-fill {
    height: 100%;
    width: 0%;
    background: #C7A046;
    border-radius: 999px;
}
.gse-redirect-text {
    font-size: 12.5px;
    color: rgba(255,255,255,0.85);
    margin-bottom: 6px;
}
@keyframes slideUp{ from{ transform:translateY(30px); opacity:0; } to{ transform:translateY(0); opacity:1; } }
.modal-box .icon{ margin:6px 0 12px; display:flex; justify-content:center; }
.result-icon-svg{ width:64px; height:64px; }
.result-icon-circle{ fill:none; stroke:rgba(255,255,255,.9); stroke-width:2.5; stroke-dasharray:145; stroke-dashoffset:145; animation:circleDraw .5s ease-out forwards; }
.result-icon-check{ fill:none; stroke:#fff; stroke-width:3.5; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:40; stroke-dashoffset:40; animation:checkDraw .35s ease-out forwards .45s; }
@keyframes circleDraw{ to{ stroke-dashoffset:0; } }
@keyframes checkDraw{ to{ stroke-dashoffset:0; } }
.confetti-burst{ position:absolute; inset:0; pointer-events:none; overflow:hidden; border-radius:inherit; }
.confetti-burst i{
    position:absolute; top:50%; left:50%; width:6px; height:10px; border-radius:2px;
    background:#fff; opacity:0; animation:confettiPop .8s ease-out forwards .3s;
}
.confetti-burst i:nth-child(1){ background:#FFD166; transform:rotate(10deg); --tx:-70px; --ty:-60px; animation-delay:.32s; }
.confetti-burst i:nth-child(2){ background:#fff; transform:rotate(-15deg); --tx:70px; --ty:-55px; animation-delay:.36s; }
.confetti-burst i:nth-child(3){ background:#FF6B4A; transform:rotate(30deg); --tx:-40px; --ty:-90px; animation-delay:.3s; }
.confetti-burst i:nth-child(4){ background:#14B8A6; transform:rotate(-30deg); --tx:45px; --ty:-90px; animation-delay:.4s; }
.confetti-burst i:nth-child(5){ background:#fff; transform:rotate(5deg); --tx:-90px; --ty:-20px; animation-delay:.34s; }
.confetti-burst i:nth-child(6){ background:#FFD166; transform:rotate(-8deg); --tx:90px; --ty:-15px; animation-delay:.38s; }
@keyframes confettiPop{
    0%{ opacity:1; transform:translate(-50%,-50%) rotate(0deg) scale(1); }
    100%{ opacity:0; transform:translate(calc(-50% + var(--tx)), calc(-50% + var(--ty))) rotate(180deg) scale(.6); }
}
.modal-box h2{ font-family:var(--font-display); font-size:18px; margin:0 0 6px; }
#transactionResultBtn{
    background:#fff; color:var(--teal-900); border:none; padding:10px 26px;
    border-radius:999px; cursor:pointer; font-weight:700; font-size:14px; margin-top:14px;
}
#transactionResultBtn:hover{ background:var(--teal-100); }

/* ---------- mobile refinements ---------- */
@media(max-width:640px){
    .reg-container{ padding:12px 10px 100px; }
    .reg-card{ border-radius:14px; }
    .reg-title{ font-size:19px; }
    .header-name{ font-size:13.5px; }
    .header-eyebrow{ font-size:10px; }
    .pulse-label{ font-size:10px; }
    .field-grid{ padding:0 14px; gap:12px; }
    .neet-lookup{ margin:14px 14px 4px; }
    .section-label{ margin:18px 14px 8px; }
    .pay-summary{ margin:16px 14px 0; flex-direction:column; align-items:stretch; }
    .pay-total-amount{ font-size:26px; }

    .reg-actions{
        position:sticky; bottom:0; left:0; right:0; z-index:15;
        background:var(--surface); margin:0; padding:12px 14px calc(12px + env(safe-area-inset-bottom));
        border-top:1px solid var(--line); box-shadow:0 -8px 20px -14px rgba(15,76,92,.3);
    }
    .reg-actions .btn-pill{ flex:1; }
    .reg-actions-split{ gap:10px; }
}

/* ---------- reduced motion ---------- */
@media (prefers-reduced-motion: reduce){
    .pulse-fill, .ecg-loader-pulse, .reg-card{ animation:none !important; stroke-dashoffset:0; }
}
</style>