@extends('layouts.guestLayout')
@section('content')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/pages/authentication.css') }}">
@endsection
<div class="auth-wrapper auth-basic px-2">
    @yield('auth')
</div>
@endsection