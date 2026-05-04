@extends('layouts.auth')

@section('content')
<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-brand">
            <img class="auth-logo" src="{{ asset('emblem.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            <div class="auth-title">{{ config('app.name', 'Laravel') }}</div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                @endif
            </div>

            <button type="submit" class="btn auth-btn w-100">{{ __('Login') }}</button>
        </form>
    </div>
</div>
@endsection
