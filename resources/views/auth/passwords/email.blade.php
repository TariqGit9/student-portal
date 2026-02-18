@extends('layouts.auth')

@section('content')
<div class="auth-form-wrapper">
    <h2>Reset Password</h2>
    <p class="auth-subtitle">Enter your email to receive a reset link</p>

    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email"
                class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email" value="{{ old('email') }}" required autofocus
                placeholder="Enter your email address">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Send Reset Link</button>

        <p class="auth-note">
            <strong>Note:</strong> If you are not registered with an email, please contact your school administration.
        </p>

        <a class="auth-link" href="{{ route('login') }}">Back to login</a>
    </form>
</div>
@endsection
