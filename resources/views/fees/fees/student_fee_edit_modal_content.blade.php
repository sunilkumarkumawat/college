<div class="modal-header py-2 bg-primary text-white" style="background-color: #002c54 !important;">
    <h5 class="modal-title font-weight-bold" style="font-size: 15px; color: #ffffff !important;">
        <i class="fa fa-user-circle mr-1"></i> Fee Modification: {{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }} ({{ $student->admissionNo ?? '-' }})
    </h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; color: #fff;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body p-3" style="background-color: #f8fafc;">
    <!-- Student Summary Ribbon -->
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 mb-1">
            <div class="p-2 border rounded bg-white shadow-xs">
                <small class="text-muted d-block font-weight-bold" style="font-size: 11px; text-transform: uppercase;">Class / Semester</small>
                <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $student->ClassTypes->name ?? '-' }}</span>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-1">
            <div class="p-2 border rounded bg-white shadow-xs">
                <small class="text-muted d-block font-weight-bold" style="font-size: 11px; text-transform: uppercase;">Student Type</small>
                <span class="badge badge-info px-2 py-1" style="font-size: 11.5px;">{{ $student->student_type ?? 'General' }}</span>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-1">
            <div class="p-2 border rounded bg-white shadow-xs">
                <small class="text-muted d-block font-weight-bold" style="font-size: 11px; text-transform: uppercase;">Total Assigned</small>
                <span class="font-weight-bold text-primary" style="font-size: 13.5px;" id="modal_summary_total">
                    ₹{{ number_format($feesAssign->total_amount ?? 0, 2) }}
                </span>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-1">
            <div class="p-2 border rounded bg-white shadow-xs">
                <small class="text-muted d-block font-weight-bold" style="font-size: 11px; text-transform: uppercase;">Net Payable</small>
                <span class="font-weight-bold text-success" style="font-size: 13.5px;" id="modal_summary_net">
                    ₹{{ number_format($feesAssign->net_amount ?? 0, 2) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Assigned Fee Heads Table -->
    @if(!empty($assignedDetails) && count($assignedDetails) > 0)
        <div class="table-responsive border rounded bg-white">
            <table class="table table-bordered table-sm mb-0" style="font-size: 12.5px;">
                <thead style="background-color: #002c54; color: #ffffff;">
                    <tr>
                        <th style="width: 35px; text-align: center;">#</th>
                        <th>Fee Head</th>
                        <th style="width: 115px;">Amount (₹)</th>
                        <th style="width: 110px;">Discount (₹)</th>
                        <th style="width: 115px;">Net (₹)</th>
                        <th style="width: 140px;">Due Date</th>
                        <th style="width: 100px;">Fine (₹)</th>
                        <th style="width: 85px; text-align: center;">Paid</th>
                        <th style="width: 80px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedDetails as $k => $detail)
                        @php
                            $headTotal = floatval($detail->fees_group_amount ?? 0);
                            $headDisc = floatval($detail->discount ?? 0);
                            $headNet = $headTotal - $headDisc;
                        @endphp
                        <tr id="row_detail_{{ $detail->id }}">
                            <td class="text-center align-middle">{{ $k + 1 }}</td>
                            <td class="align-middle font-weight-bold text-dark">
                                {{ $detail->fees_group_name ?? 'Fee Head' }}
                            </td>
                            <td class="align-middle">
                                <input type="number" 
                                       step="any" 
                                       class="form-control form-control-sm text-right modal-detail-input input-amount" 
                                       data-detail-id="{{ $detail->id }}" 
                                       value="{{ $headTotal }}" 
                                       style="font-size: 12px; height: 28px; padding: 2px 6px;">
                            </td>
                            <td class="align-middle">
                                <input type="number" 
                                       step="any" 
                                       class="form-control form-control-sm text-right modal-detail-input input-discount" 
                                       data-detail-id="{{ $detail->id }}" 
                                       value="{{ $headDisc }}" 
                                       style="font-size: 12px; height: 28px; padding: 2px 6px;">
                            </td>
                            <td class="align-middle text-right font-weight-bold text-dark net-display" id="net_disp_{{ $detail->id }}">
                                ₹{{ number_format($headNet, 2) }}
                            </td>
                            <td class="align-middle">
                                <input type="date" 
                                       class="form-control form-control-sm modal-detail-input input-due-date" 
                                       data-detail-id="{{ $detail->id }}" 
                                       value="{{ $detail->installment_due_date ? date('Y-m-d', strtotime($detail->installment_due_date)) : '' }}" 
                                       style="font-size: 11.5px; height: 28px; padding: 2px 4px;">
                            </td>
                            <td class="align-middle">
                                <input type="number" 
                                       step="any" 
                                       class="form-control form-control-sm text-right modal-detail-input input-fine" 
                                       data-detail-id="{{ $detail->id }}" 
                                       value="{{ floatval($detail->installment_fine ?? 0) }}" 
                                       style="font-size: 12px; height: 28px; padding: 2px 6px;">
                            </td>
                            <td class="align-middle text-center">
                                @if(($detail->paid_amount ?? 0) > 0)
                                    <span class="badge badge-success px-1 py-1" style="font-size: 11px;">₹{{ number_format($detail->paid_amount, 0) }}</span>
                                @else
                                    <span class="badge badge-light text-muted border px-1 py-1" style="font-size: 11px;">₹0</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-primary btn-save-detail-row px-2 py-0" 
                                        data-detail-id="{{ $detail->id }}" 
                                        data-admission-id="{{ $student->id }}"
                                        title="Save this fee head"
                                        style="font-size: 11px; height: 26px; line-height: 24px;">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning text-center py-4 mb-0">
            <i class="fa fa-exclamation-circle fa-2x mb-2 d-block"></i>
            <strong>No Fee Heads Currently Assigned</strong>
            <p class="small text-muted mb-0 mt-1">Please close this modal and check the fee head checkboxes on the main table to assign fee heads to this student.</p>
        </div>
    @endif
</div>

<div class="modal-footer py-2 px-3 bg-light d-flex justify-content-between">
    <span class="text-muted small">
        <i class="fa fa-info-circle mr-1"></i> Changes will update the student's fee ledger instantly.
    </span>
    <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">
        <i class="fa fa-times mr-1"></i> Close
    </button>
</div>
