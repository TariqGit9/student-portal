@extends('layouts.auth')

@section('content')

<div class="wrap-login100 p-t-30 p-b-50">
    <span class="login100-form-title p-b-41">
         Login
    </span>
    <form class="login100-form validate-form p-b-33 p-t-5"  method="POST" action="{{ route('login') }}">
        @csrf

        <div class="wrap-input100 validate-input" data-validate = "Enter username">
            <input id="email" type="email" class="input100 @error('email') is-invalid @enderror"placeholder="User Name" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
        
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input  id="password" type="password" class="input100 @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password" >
            <span class="focus-input100" data-placeholder="&#xe80f;"></span>
        
        </div>
        @error('email')
       <center style="color:red">
        
           
            <span class="" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    
        @error('password')
        <span class="" role="alert">
            <strong>Password is wrong</strong>
        </span>
       @enderror
    </center>
       

        
 
        <div class="container-login100-form-btn m-t-32">
            <button class="login100-form-btn">
                Login
            </button>
        </div>

    </form>
</div>
@endsection
