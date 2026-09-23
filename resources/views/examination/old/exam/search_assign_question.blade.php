		@php
		$q_id = array();
		@endphp

            @foreach ($assigned_questions as $item)
            
            @php
            $q_id[] = $item;
            @endphp
            @endforeach

<div  >
				<table id="example1" class="table table-bordered table-striped  dataTable">
				  <thead>
						<tr role="row">
							<th>Q. ID:</th>
							<th>Subject </th>
							<th>Question Type</th>
							<!--<th>Duration</th>-->
							<th>Action</th>
					</thead>
					<tbody>
    					@if(!empty($data)) 
    						@php 
    						    $i=1 
    						@endphp 
    					@foreach ($data as $type)
    						<tr  @if(in_array($type->id,$q_id)) hidden @endif>
    						    
    							<td><input class="add_question" type="checkbox" data-subject_id="{{ $type->subject_id ?? '' }}" data-question_id="{{ $type->id ?? '' }}" name="checkbox"  @if(in_array($type->id,$q_id)) checked @endif > Q. ID: {{ $type['id'] ?? '' }}</td>
    							<td>{{ $type['Subject']['name'] ?? '' }}</td>
    							<td>
    							    @if($type['question_type_id'] == 1)
    							        Objective
    							    @else
    							        Descriptive
    							    @endif
    							</td>
    							<td>{{ $type['name'] ?? '' }}</td>
                           </tr>
    					@endforeach 
    					@endif 
				    </tbody>	
				</table>
				</div>