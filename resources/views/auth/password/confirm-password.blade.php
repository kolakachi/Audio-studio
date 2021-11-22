@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.confirm') }}">
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
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">{{ __('Password') }}</label>
      <input id="password" type="password" class="form-control" placeholder="Enter your login email" name="password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror 
    </div>
    <div class="d-grid mt-2">
      <button type="submit" class="btn btn-primary fw-bold text-white">
        {{ __('Confirm') }}
      </button>
    </div>
</form>

@endsection