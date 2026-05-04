@extends('layouts.auth')

@section('content')
<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-brand">
            <img class="auth-logo" src="{{ asset('emblem.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            <div class="auth-title">{{ config('app.name', 'Laravel') }}</div>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
            </div>

            <button type="submit" class="btn auth-btn w-100">{{ __('Send Password Reset Link') }}</button>

            <div class="mt-3 text-center">
                <a class="auth-link" href="{{ route('login') }}">{{ __('Back to Login') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
