@if(!empty($data) && count($data) > 0)
    @foreach($data as $key => $item)
        @php
            $fees_assign_details = DB::table('fees_assign_details')->whereNull('deleted_at')->where('admission_id', $item->id)->get();
            $fees_group_ids = [];
            if(!empty($fees_assign_details)){
                foreach($fees_assign_details as $fees){
                    $fees_group_ids[] = $fees->fees_group_id;
                }
            }
            
            $feesGroupData = [];
            if(count($fees_group_ids) != 0){
                $feesGroupData = DB::table('fees_group')->whereNull('deleted_at')->whereIn('id', array_unique($fees_group_ids))->get();
            }
        @endphp
        <tr>
            <td style="text-align: center; vertical-align: middle;">
                <input type="checkbox" name="admissionIds[]" class="student_select_checkbox" value="{{ $item->id ?? '' }}" style="transform: scale(1.2); cursor: pointer;" />
            </td>
            <td class="font-weight-bold text-dark">
                {{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}
            </td>
            <td>
                <span class="badge badge-light border px-2 py-1 font-weight-normal" style="font-size: 0.85rem;">
                    {{ $item->admissionNo ?? '-' }}
                </span>
            </td>
            <td>
                <i class="fa fa-phone text-muted mr-1"></i> {{ $item->mobile ?? '-' }}
            </td>
            <td>
                {{ $item->father_name ?? '-' }}
            </td>
            <td>
                @if(count($feesGroupData) > 0)
                    @foreach($feesGroupData as $fees_group)
                        <span class="badge-assigned-head">
                            <i class="fa fa-check text-success mr-1"></i>{{ $fees_group->name ?? '' }}
                        </span>
                    @endforeach
                @else
                    <span class="text-muted font-italic" style="font-size: 0.82rem;">None Assigned</span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr class="text-center">
        <td colspan="6" class="py-4 text-muted">
            <i class="fa fa-info-circle text-warning fa-2x mb-2 d-block"></i>
            <span>No students found matching the selected criteria.</span>
        </td>
    </tr>
@endif