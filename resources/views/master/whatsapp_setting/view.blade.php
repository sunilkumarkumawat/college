@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fa fa-whatsapp"></i> &nbsp; {{ __('WhatsApp Setting') }}</h3>
                            <div class="card-tools">
                                <a href="{{url('#')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{ __('common.View') }}</a>
                                <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
                            </div>
                        </div>  

                    <div class="row m-2">
                        <div class="col-md-12">
                            <form action="{{ url('whatsapp_setting') }}" method="post">
                                @csrf
                                <table id="example1"class="table table-bordered">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Module</th>
                                            <th>Permission</th>
                                            <th>Media Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($data))
                                            @php
                                                $i = 1;
                                            @endphp
                                        @foreach($data as $item)
                                            <input type="hidden" name="module_id[]" value="{{ $item->id ?? '' }}">
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->module ?? '' }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" id="" name="permission[]">
                                                        <option value="0" {{ ($item->permission == 0) ? 'selected' : '' }}>Inactive</option>
                                                        <option value="1" {{ ($item->permission == 1) ? 'selected' : '' }}>Active</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" id="" name="type[]">
                                                        <option value="text" {{ ($item->type == 'text') ? 'selected' : '' }}>Text</option>
                                                        <option value="media" {{ ($item->type == 'media') ? 'selected' : '' }}>Media & Text</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm text-center">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection