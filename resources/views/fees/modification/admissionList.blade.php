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
            <td class="text-center align-middle" style="width: 40px;">
                <input type="checkbox" name="admissionIds[]" class="student_select_checkbox" value="{{ $item->id ?? '' }}" style="cursor: pointer;" />
            </td>
            <td class="text-center align-middle" style="width: 45px;">{{ $key + 1 }}</td>
            <td class="align-middle text-left font-weight-bold text-dark">
                {{ $item->first_name ?? '' }} {{ $item->last_name ?? '' }}
            </td>
            <td class="text-center align-middle">
                <span class="badge badge-secondary px-2 py-1" style="font-size: 11.5px; font-weight: 500;">
                    {{ $item->admissionNo ?? '-' }}
                </span>
            </td>
            <td class="text-center align-middle text-nowrap">
                {{ $item->ClassTypes->name ?? '-' }}
            </td>
            <td class="align-middle text-left">
                {{ $item->father_name ?? '-' }}
            </td>
            <td class="text-center align-middle">
                {{ $item->mobile ?? '-' }}
            </td>
            <td class="align-middle text-left" style="min-width: 180px;">
                @if(count($feesGroupData) > 0)
                    @foreach($feesGroupData as $fees_group)
                        <span class="badge badge-info mr-1 mb-1 font-weight-normal" style="font-size: 11px; padding: 3px 6px;">
                            <i class="fa fa-check text-xs mr-1"></i>{{ $fees_group->name ?? '' }}
                        </span>
                    @endforeach
                @else
                    <span class="text-muted small font-italic">None Assigned</span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr class="text-center">
        <td colspan="8" class="py-4 text-muted">
            <i class="fa fa-info-circle text-warning fa-2x mb-2 d-block"></i>
            <span>No students found matching the selected criteria.</span>
        </td>
    </tr>
@endif