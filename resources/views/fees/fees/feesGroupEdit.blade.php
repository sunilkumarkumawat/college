@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-edit"></i> &nbsp;{{ __('fees.Edit Fees Group') }} / Fee Head</h3>
                            <div class="card-tools">
                                <a href="{{url('feesGroup')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> {{ __('messages.View') }} </a>
                                <a href="{{url('fee_dashboard')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('Back') }} </a>
                            </div>
                        </div>                 
                        
                        <form id="quickForm" action="{{ url('feesGroupEdit') }}/{{$data['id']}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="color:red;">{{ __('messages.Name') }} / Fee Head Name*</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Fee Head Name" value="{{ old('name', $data['name'] ?? '') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                    			
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Category / Fee Type</label>
                                            <select class="form-control" name="group_type" id="group_type">
                                                <option value="">-- Select Category --</option>
                                                <option value="academic" {{ (old('group_type', $data['group_type'] ?? '') == 'academic') ? 'selected' : '' }}>Academic (Tuition / University)</option>
                                                <option value="examination" {{ (old('group_type', $data['group_type'] ?? '') == 'examination') ? 'selected' : '' }}>Examination (Semester / Annual)</option>
                                                <option value="practical" {{ (old('group_type', $data['group_type'] ?? '') == 'practical') ? 'selected' : '' }}>Laboratory & Practical</option>
                                                <option value="admission" {{ (old('group_type', $data['group_type'] ?? '') == 'admission' || old('group_type', $data['group_type'] ?? '') == 'registration') ? 'selected' : '' }}>Admission & Registration</option>
                                                <option value="facility" {{ (old('group_type', $data['group_type'] ?? '') == 'facility') ? 'selected' : '' }}>Campus Facility & Library</option>
                                                <option value="refundable" {{ (old('group_type', $data['group_type'] ?? '') == 'refundable') ? 'selected' : '' }}>Refundable Deposit / Caution Money</option>
                                                <option value="hostel_transport" {{ (old('group_type', $data['group_type'] ?? '') == 'hostel_transport') ? 'selected' : '' }}>Hostel & Transport</option>
                                                <option value="other" {{ (old('group_type', $data['group_type'] ?? '') == 'other') ? 'selected' : '' }}>Other / Miscellaneous</option>
                                            </select>
                                        </div>                    	
                                    </div>
                                    
                                    <div class="col-md-2" style="align-content: flex-end;">
                                        <div class="form-group">
                                            <label for="refund_fees_value" class="pointer">Refundable Fee :</label><br>
                                            <input type="checkbox" class="pointer" id="refund_fees_value" value="yes" @if(old('fees_refund', strtolower($data->fees_refund ?? '')) === 'yes') checked @endif onchange="updateRefundFees(this)">
                                            <small class="text-muted d-block">Caution / Security</small>
                                            <input type="hidden" id="fees_refund" name="fees_refund" value="{{ old('fees_refund', $data['fees_refund'] ?? 'no') }}">     
                                        </div>                    	
                                    </div>

                                    <div class="col-md-3" style="align-content: flex-end;">
                                        <div class="form-group">
                                            <label for="fees_partial_checkbox" class="pointer">Partial Payable (50%) :</label><br>
                                            <input type="checkbox" class="pointer" id="fees_partial_checkbox" value="1" @if(old('fees_partial', $data->fees_partial ?? 0) == 1) checked @endif onchange="updatePartialPayable(this)">
                                            <small class="text-muted d-block">Allow 50% split pay</small>
                                            <input type="hidden" id="fees_partial" name="fees_partial" value="{{ old('fees_partial', $data['fees_partial'] ?? 0) }}">
                                        </div>                    	
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('messages.Update') }} Fee Head</button>
                                        <a href="{{ url('feesGroup') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function updateRefundFees(checkbox) {
        if (checkbox.checked) {
            document.getElementById('fees_refund').value = 'yes';
        } else {
            document.getElementById('fees_refund').value = 'no';
        }
    }

    function updatePartialPayable(checkbox) {
        if (checkbox.checked) {
            document.getElementById('fees_partial').value = 1;
        } else {
            document.getElementById('fees_partial').value = 0;
        }
    }
</script>
@endsection