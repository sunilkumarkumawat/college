@php
$permission = DB::table('permission_messages')->whereNull('deleted_at')->get();
@endphp


@if(!empty($permission))

@foreach($permission as $item)


@endforeach
@endif