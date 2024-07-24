@extends('layouts.admin')
@section('title', 'Detail Customer')
@section('content')
    @if ($customer->type == '1')
        {{-- @include('customers.customer_corporate') --}}
        @include('customers.customer_corporate')
    @elseif ($customer->type == '2')
        @include('customers._customer_b2b2c')
    @else
        @include('customers._customer_public')
    @endif
@endsection
