@extends('layouts.auth')

@section('content')

<div class="wrap-login100 p-t-30 p-b-50">
    <span class="login100-form-title p-b-41">
    {{ __('Reset Password') }}
    </span>
    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
    @endif
    <form class="login100-form validate-form p-b-33 p-t-5"  method="POST"  action="{{ route('password.email') }}">
                        @csrf

                        <div class="wrap-input100 validate-input" >
                            <input id="email" type="text" class="input100"
                            name="email" value="{{ old('user_name') ?: old('email') }}" placeholder='Email' required autofocus>
                            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        
                        </div>

                        @error('email')
                         <span style="color:red">
                        
                        
                            <span class="" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                
                    </span>
                    

                        
                
                        <div class="container-login100-form-btn m-t-32">
                            <button type="submit"  class="login100-form-btn">
                                Reset Password
                            </button>
                        </div>

                    </form>
</div>
@endsection
