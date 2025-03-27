@extends('layouts.layout')

@section('content')
<div class="bg-red-500 py-2 px-3 text-black rounded">

    <h1>Your payment has failed</h1>
    <p>{{ $message ?? '' }}</p>


</div>

@endsection