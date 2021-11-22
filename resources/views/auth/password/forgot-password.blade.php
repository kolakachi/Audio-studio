@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
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
    <div class="d-grid mt-2">
      <button type="submit" class="btn btn-primary fw-bold text-white">
        {{ __('Email Password Reset Link') }}
      </button>
    </div>
</form>
<p class="auth-tip">or <a href="{{ route('login') }}">{{ __('Login') }}</a></p>


@endsection