
				<table id="example1" class="table table-bordered table-striped  dataTable">
				  <thead>
						<tr role="row">
						
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
    					
    				
    						<tr>
    						    
    							<td><input class="add_question mr-2" data-question_type_id="{{ $type->question_type_id ?? '' }}" data-subject_id="{{ $type->subject_id ?? '' }}" type="checkbox" data-question_id="{{ $type->id ?? '' }}" name="checkbox" checked > {{ $type['Subject']['name'] ?? '' }}</td>
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
		