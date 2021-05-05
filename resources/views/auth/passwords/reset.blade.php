@extends('layouts.auth')
@section('content')
    <div class="wrap-login100 p-t-30 p-b-50">
        <span class="login100-form-title p-b-41">
            Login
        </span>
        <form class="login100-form validate-form p-b-33 p-t-5"  method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="wrap-input100 validate-input" data-validate = "Enter username">
                <input id="email" type="text" class="input100{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                name="email" value="{{ $email ?? old('email') }}"  required autofocus>
                <span class="focus-input100" data-placeholder="&#xe82a;"></span>
            </div>
            <div class="wrap-input100 validate-input" data-validate="Enter password">
                <input  id="password" type="password" class="input100 @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password" >
                <span class="focus-input100" data-placeholder="&#xe80f;"></span>
            </div>
            <div class="wrap-input100 validate-input" data-validate="Enter password">
                <input  id="password-confirm" type="password" class="input100 @error('password') is-invalid @enderror" placeholder="Password" name="password_confirmation" required autocomplete="current-password" >
                <span class="focus-input100" data-placeholder="&#xe80f;"></span>
            </div>
            <div class="text-center">
                @error('email')
                    <span class="text-danger " role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('password')
                    <span class="text-danger text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="container-login100-form-btn m-t-32">
                <button class="login100-form-btn">
                {{ __('Reset Password') }}
                </button>
            </div>

        </form>
    </div>
@endsection
