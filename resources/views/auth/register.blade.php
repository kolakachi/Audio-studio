@extends('layouts.auth')

{{-- @section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
@endsection --}}

@section('content')
@if (config('settings.registration') == 'enabled')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    {{-- <h3 class="text-center font-weight-bold mb-4">Sign Up to <span class="text-info"><a href="{{ url('/') }}">{{ config('app.url') }}</a></span></h3> --}}

    <div class="input-box mb-2">                             
        <label for="name" class="fs-12 font-weight-bold text-md-right">{{ __('Full Name') }}</label>
        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" autofocus placeholder="First and Last Names">
        @error('name')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror                            
    </div>

    <div class="input-box mb-2">                             
        <label for="email" class="fs-12 font-weight-bold text-md-right">{{ __('Email Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="Email Address" required>
        @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror                            
    </div>

    <div class="input-box mb-2">                            
        <label for="password" class="fs-12 font-weight-bold text-md-right">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror                            
    </div>

    <div class="input-box">
        <label for="password-confirm" class="fs-12 font-weight-bold text-md-right">{{ __('Confirm Password') }}</label>                       
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="Confirm Password">                        
    </div>

    

    {{-- <input type="hidden" name="recaptcha" id="recaptcha"> --}}
    {{-- <div class="d-flex justify-content-between">
        <input type="hidden" name="recaptcha" id="recaptcha">
        <a class="text-info" href="{{ route('login') }}">{{ __('Login') }}</a>
    </div> --}}

    <div class="d-grid mt-2 ">                        
        <button type="submit" class="btn btn-primary mr-2 fw-bold text-white">{{ __('Sign Up') }}</button> 
    </div>
</form>
    
@else
    <h5 class="text-center pt-9">New user registration is disabled currently</h5>
@endif
@endsection

@section('js')
	<!-- Awselect JS -->
	<script src="{{URL::asset('plugins/awselect/awselect.min.js')}}"></script>
	<script src="{{URL::asset('js/awselect.js')}}"></script>

    @if (config('services.google.recaptcha.enable') == 'on')
         <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif
   
@endsection
