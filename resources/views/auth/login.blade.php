@extends('layouts.auth')

@section('content')
<div class="auth-form-wrapper">
    <h2>Welcome Back</h2>
    <p class="auth-subtitle">Sign in to your account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="login">Email or Username</label>
            <input id="login" type="text"
                class="form-input{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                name="login" value="{{ old('user_name') ?: old('email') }}" required autofocus
                placeholder="Enter your email or username">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
            @error('user_name')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password"
                class="form-input @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password"
                placeholder="Enter your password">
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Sign In</button>

        <a class="auth-link" href="{{ route('password.request') }}">Forgot your password?</a>
    </form>
</div>
@endsection
