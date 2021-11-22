@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.update') }}">
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
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    <div class="mb-4">
      <label for="email" class="form-label">{{ __('Email Address') }}</label>
      <input id="email" type="email" class="form-control" placeholder="Enter your login email" name="email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror 
    </div>
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control" placeholder="Enter your login password" name="password">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  {{ $message }}
              </span>
          @enderror
      </div>
      <div class="mb-3">
        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" placeholder="Enter your login password" name="password_confirmation">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  {{ $message }}
              </span>
          @enderror
      </div>
    <div class="d-grid mt-2">
      <button type="submit" class="btn btn-primary fw-bold text-white">
        {{ __('Reset Password') }}
      </button>
    </div>
</form>

@endsection