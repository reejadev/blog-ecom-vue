@extends('layouts.layout')

@section('content')
<div class="w-[400px] mx-auto bg-red-500 py-2 px-3 text-white rounded">
    {{ $session->session_id }} Your order is completed
</div>


@endsection