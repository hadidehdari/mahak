@extends('layouts.guest')

@section('content')
<div class="login-container">
    <div class="login-card">
        <img src="{{ asset('images/mahak-logo.png') }}" alt="ماهک" class="logo">
        <h2>ورود به پنل مدیریت ماهک</h2>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf
            <div class="form-floating mb-4">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09123456789" required dir="ltr">
                <label for="phone">شماره موبایل</label>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="رمز عبور" required>
                <label for="password">رمز عبور</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    مرا به خاطر بسپار
                </label>
            </div>
            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary">
                    ورود
                </button>
            </div>
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                        رمز عبور خود را فراموش کرده‌اید؟
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection