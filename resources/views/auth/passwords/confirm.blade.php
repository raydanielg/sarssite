@extends('layouts.auth')

@section('content')
<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-brand">
            <img class="auth-logo" src="{{ asset('emblem.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            <div class="auth-title">{{ config('app.name', 'Laravel') }}</div>
        </div>

        <div class="mb-3">{{ __('Please confirm your password before continuing.') }}</div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn auth-btn w-100">{{ __('Confirm Password') }}</button>

            @if (Route::has('password.request'))
                <div class="mt-3 text-center">
                    <a class="auth-link" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
