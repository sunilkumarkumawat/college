                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline ">
                            <thead>
                                <tr role="row">
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    @if($data[0]['role_id'] == 3)
                                    <th>Class</th>
                                    @endif
                                    <th>F Name</th>
                                    <th>Gender</th>
                                    <th>Mobile</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(!empty($data))
                                @php
                                    $i=1
                                @endphp

                                @foreach ($data  as $item)
                               
                                <tr style="cursor: pointer;" onclick="showData('{{ $item['id']  }}');">
                                    @if($item['role_id'] == 3)
                                    <input type="hidden" id="admissionNo_{{$item['id']}}" value="{{ $item['admissionNo']  }}">
                                    @else
                                    <input type="hidden" id="user_id_{{$item['id']}}" value="{{ $item['id']  }}">
                                    @endif
                                    <td>{{ $i++  }}</td>
                                    <td>{{ $item['first_name']  }} {{ $item['last_name']  }}</td>
                                    @if($item['role_id'] == 3)
                                    <td>{{ $item['ClassTypes']['name'] ?? '' }}
                            @if (!empty($item['Section']['name']))
                                ({{ $item['Section']['name'] }})
                            @endif</td>
                                    
                                    @endif
                                    <td>{{ $item['father_name'] ?? '' }}</td>
                                    <td>{{ $item['Gender']['name'] ?? '' }}</td>
                                    <td>{{ $item['mobile'] ?? '' }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>