<!--<h1>Mast H Chalne Do..🎉🎊✔️💵</h1>-->
@php
@endphp
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SR.</th>
            <th>Chapter Name</th>
            <th>Objective</th>
            <th>Numeric</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($subjectData))
        @foreach($subjectData as $subject)
            @php
                $chapterData = DB::table('chapters_digital')->where('subject_id', $subject->id)->whereNull('deleted_at')->get();
            @endphp
            <tr class="bg-light ">
                <th></th>
                <th class="text-white">{{ $subject['ClassTypes']->name ?? '' }} {{ $subject->name ?? '' }} </th>
                <th></th>
                <th></th>
                <th></th>
            </tr> 
            @if(!empty($chapterData))
                @php
                    $i = 1;
                @endphp  
         
            @foreach($chapterData as $chapter)
    
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $chapter->name ?? '' }}
                    <input type="hidden" id="" name="chapter_id[]" value="{{ $chapter->id ?? '' }}">
                </td>
                <td>
    			    <input type="tel" id="objective_{{ $chapter->id ?? '' }}" data-id="{{ $chapter->id ?? '' }}" data-question_type_id="1" name="objectiveQuestion[]" class="form-control chapter objective checkQuestionCount" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)">
                </td>
                <td>
    			    <input type="tel" id="numeric_{{ $chapter->id ?? '' }}" data-id="{{ $chapter->id ?? '' }}" data-question_type_id="2" name="numericQuestion[]" class="form-control chapter numeric checkQuestionCount" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)">
                </td>
                <td>
    			    <input type="tel" id="total_{{ $chapter->id ?? '' }}" name="totalQuestion[]" class="form-control " placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
                </td>
            </tr> 
    
            @endforeach
            @endif
            
        @endforeach
        @endif
        <tr>
            <th></th>
            <th>Total Questions</th>
            <th>
                <input type="tel" id="objectiveSum" name="objectiveSum" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly >
            </th>
            <th>
                <input type="tel" id="numericSum" name="numericSum" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
            <th>
                <input type="tel" id="totalQuesSum" name="totalQuesSum" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
        </tr> 
        <tr>
            <th></th>
            <th> Marks</th>
            <th>
                <input type="tel" id="" name="mark" class="form-control" value="4" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
            <th>
                <input type="tel" id="" name="mark" class="form-control" value="4" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
            <th>
                <input type="tel" id="" name="mark" class="form-control" value="4" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
        </tr>
        <tr>
            <th></th>
            <th>Total Marks</th>
            <th>
                <input type="tel" id="objectiveMark" name="objectiveMark" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly >
            </th>
            <th>
                <input type="tel" id="numericMark" name="numericMark" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
            <th>
                <input type="tel" id="totalQuesMark" name="totalQuesMark" class="form-control bold-input" placeholder="" autocomplete="off" onkeypress="javascript:return isNumber(event)" tabindex="1" readonly>
            </th>
        </tr> 
    </tbody>

</table>

<script>
$(document).ready(function(){
    
    $('.chapter').blur(function(){
        var chapterId = $(this).data('id');
        var value = $(this).val();
        var objective = parseInt($('#objective_' + chapterId).val());
        var numeric = parseInt($('#numeric_' + chapterId).val());
        
            if(isNaN(objective)){ objective = 0; }
            if(isNaN(numeric)){ numeric = 0; }
            
        var quesSum = objective + numeric;
        var objectiveSum = numericSum = totalQuesSum = inputValue = objectiveMark = numericMark = totalQuesMark = 0;
        
        $('.objective').each(function(){
            inputValue = isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
            objectiveSum = objectiveSum + inputValue;
        });
        $('.numeric').each(function(){
            inputValue = isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
            numericSum = numericSum + inputValue;
        });
        
            totalQuesSum = objectiveSum + numericSum;
            objectiveMark = objectiveSum * 4;
            numericMark = numericSum * 4;
            totalQuesMark = objectiveMark + numericMark;
        
        $('#total_' + chapterId).val(quesSum);
        $('#objectiveSum').val(objectiveSum);
        $('#numericSum').val(numericSum);
        $('#totalQuesSum').val(totalQuesSum);
        $('#objectiveMark').val(objectiveMark);
        $('#numericMark').val(numericMark);
        $('#totalQuesMark').val(totalQuesMark);
    });
    
});
</script>