@extends('layouts.app')
@section('title','Reset Password') 
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection
@section('content')
    <div class="auth-inner pt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 mx-auto">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>
                                {{ __('Reset Password') }}
                            </h3>
                        </div>

                        <div class="card-body row">
                            <form method="POST" action="{{ route('changePassword', ['user' => $user]) }}">
                                @csrf
                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="email"
                                        class="form-label">{{ __('Old Password') }}</label>
                                        <input id="old_password" type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            name="old_password" required autofocus>

                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="password"
                                        class="form-label">{{ __('New Password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            name="new_password" required autocomplete="new-password">

                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="password-confirm"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="new_password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="col-12 mb-0">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                        <a href="/" class="btn btn-outline-dark">
                                            {{ __('locale.Cancel') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
