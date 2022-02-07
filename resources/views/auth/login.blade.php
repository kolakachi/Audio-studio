@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    @if ($message = Session::get('success'))
        <div class="alert alert-login alert-success"> 
            <strong> {{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-login alert-danger">
            <strong> {{ $message }}</strong>
        </div>
    @endif
    <div class="mb-4">
      <label for="email" class="form-label">{{ __('Email Address') }}</label>
      <input id="email" type="email" class="form-control" placeholder="Enter your login email" name="email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror 
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">{{ __('Password') }}</label>
      <input id="password" type="password" class="form-control" placeholder="Enter your login password" name="password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="d-flex justify-content-between">
      <div class="mb-3 form-check">
        <input id="remember" type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">{{ __('Keep me logged in') }}</label>
      </div>
      @if (Route::has('password.request'))
      <input type="hidden" name="recaptcha" id="recaptcha">
      <a href="{{ route('password.request') }}" class="forgot-link">{{ __('Forgot Your Password?') }}</a>
      @endif
    </div>
    <div class="d-grid mt-2">
        <button type="submit" class="btn btn-primary fw-bold text-white">
        Login
      </button>
    </div>
</form>
        {{-- <p class="auth-tip">Don’t have an account yet? <a href="{{ route('register') }}">{{ route('register') }}</a></p> --}}

@endsection

@section('js')
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