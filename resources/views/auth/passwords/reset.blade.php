@extends('layouts.auth')

@section('content')
<div class="auth-form-wrapper">
    <h2>Set New Password</h2>
    <p class="auth-subtitle">Choose a new password for your account</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email"
                class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email" value="{{ $email ?? old('email') }}" required autofocus
                placeholder="Enter your email address">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input id="password" type="password"
                class="form-input @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password"
                placeholder="Enter new password">
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password"
                class="form-input"
                name="password_confirmation" required autocomplete="new-password"
                placeholder="Confirm new password">
        </div>

        <button type="submit" class="auth-btn">Reset Password</button>

        <a class="auth-link" href="{{ route('login') }}">Back to login</a>
    </form>
</div>
@endsection
