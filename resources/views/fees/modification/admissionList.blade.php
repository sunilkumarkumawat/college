@if(!empty($data) && count($data) > 0)
    @php
        $studentIds = $data->pluck('id')->toArray();
        $feesAssigns = DB::table('fees_assigns')->whereNull('deleted_at')->whereIn('admission_id', $studentIds)->pluck('total_amount', 'admission_id')->toArray();
    @endphp

    @foreach($data as $key => $item)
        @php
            $studentMasters = $courseFeesMasters;
            $studentTotal = isset($feesAssigns[$item->id]) ? floatval($feesAssigns[$item->id]) : 0;
        @endphp
        <tr id="student_row_{{ $item->id }}">
            <td class="text-center align-middle" style="width: 40px;">
                <input type="checkbox" name="admissionIds[]" class="student_select_checkbox" value="{{ $item->id }}" style="cursor: pointer; width: 16px; height: 16px;" />
            </td>
            <td class="text-center align-middle font-weight-bold text-muted" style="width: 40px;">
                {{ $key + 1 }}
            </td>
            <td class="align-middle text-left font-weight-bold text-dark" style="min-width: 140px;">
                <span class="d-block text-truncate" style="max-width: 180px;" title="{{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}">
                    {{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}
                </span>
                @if(!empty($item->student_type) && $item->student_type != 'General')
                    <span class="badge badge-warning text-dark px-1" style="font-size: 10px; font-weight: 600;">
                        {{ $item->student_type }}
                    </span>
                @endif
            </td>
            <td class="text-center align-middle" style="width: 110px;">
                <span class="badge badge-secondary px-2 py-1 font-weight-bold" style="font-size: 11.5px; letter-spacing: 0.3px;">
                    {{ $item->admissionNo ?? '-' }}
                </span>
            </td>
            <td class="text-center align-middle text-nowrap" style="font-size: 12px; width: 120px;">
                <span class="badge badge-light border text-dark font-weight-bold px-2 py-1 d-block mb-1">
                    {{ $item->ClassTypes->name ?? '-' }}
                </span>
                @if(!empty($item->batch))
                    <span class="badge badge-info px-1 py-0" style="font-size: 10.5px;">
                        {{ $item->batch }}
                    </span>
                @endif
            </td>
            <td class="align-middle text-left text-muted" style="font-size: 12px; min-width: 120px;">
                {{ $item->father_name ?? '-' }}
            </td>
            <td class="text-center align-middle text-nowrap" style="font-size: 12px; width: 100px;">
                {{ $item->mobile ?? '-' }}
            </td>
            <td class="align-middle text-left" style="min-width: 250px;">
                <div class="d-flex flex-wrap align-items-center" style="gap: 4px;">
                    @if(!empty($studentMasters) && count($studentMasters) > 0)
                        @foreach($studentMasters as $fm)
                            @php
                                $mapKey = $item->id . '_' . $fm->id;
                                $isAssigned = isset($assignedDetailMap[$mapKey]);
                                
                                if($item->student_type == "NRI"){
                                    $headAmt = $fm->nri ?? $fm->amount;
                                } elseif($item->student_type == "Management"){
                                    $headAmt = $fm->management ?? $fm->amount;
                                } elseif($item->student_type == "Govt"){
                                    $headAmt = $fm->govt ?? $fm->amount;
                                } else {
                                    $headAmt = $fm->amount;
                                }
                                
                                if($isAssigned && isset($assignedDetailMap[$mapKey]->fees_group_amount)){
                                    $headAmt = $assignedDetailMap[$mapKey]->fees_group_amount;
                                }
                            @endphp
                            <label class="fee-head-chip {{ $isAssigned ? 'chip-assigned' : 'chip-unassigned' }}" 
                                   id="chip_{{ $item->id }}_{{ $fm->id }}"
                                   title="{{ $fm->feesGroup->name ?? 'Fee Head' }} (₹{{ number_format($headAmt, 0) }}) - Click to {{ $isAssigned ? 'Remove' : 'Assign' }}">
                                <input type="checkbox" 
                                       class="toggle-fee-head-checkbox" 
                                       data-admission-id="{{ $item->id }}" 
                                       data-master-id="{{ $fm->id }}" 
                                       {{ $isAssigned ? 'checked' : '' }} 
                                       style="cursor: pointer; margin-right: 4px;">
                                <span class="chip-name">{{ $fm->feesGroup->name ?? 'Head' }}</span>
                                <span class="chip-amt">₹{{ number_format($headAmt, 0) }}</span>
                                <span class="chip-status ml-1">
                                    <i class="fa fa-check text-success {{ $isAssigned ? '' : 'd-none' }}" id="icon_{{ $item->id }}_{{ $fm->id }}"></i>
                                </span>
                            </label>
                        @endforeach
                    @else
                        <span class="text-muted small font-italic">No Fee Heads Configured for this Class</span>
                    @endif
                </div>
            </td>
            <td class="text-center align-middle text-nowrap" style="width: 110px;">
                <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 12.5px;" id="student_total_{{ $item->id }}">
                    ₹{{ number_format($studentTotal, 0) }}
                </span>
            </td>
            <td class="text-center align-middle text-nowrap" style="width: 80px;">
                <button type="button" 
                        class="btn btn-xs btn-outline-primary btn-edit-student-fees font-weight-bold" 
                        data-admission-id="{{ $item->id }}"
                        style="font-size: 11.5px; padding: 2px 8px;"
                        title="Edit Fee Details, Discounts & Due Dates">
                    <i class="fa fa-pencil mr-1"></i> Edit
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr class="text-center">
        <td colspan="10" class="py-5 text-muted">
            <i class="fa fa-info-circle text-warning fa-2x mb-2 d-block"></i>
            <span class="font-weight-bold" style="font-size: 13px;">No students found matching the selected criteria.</span>
        </td>
    </tr>
@endif