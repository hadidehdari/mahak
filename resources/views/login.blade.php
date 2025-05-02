@extends('layouts.guest')

@section('title', 'ورود به پنل مدیریت')

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
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                <label for="email">ایمیل</label>
                @error('email')
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">مرا به خاطر بسپار</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">فراموشی رمز عبور؟</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>
                ورود به حساب کاربری
            </button>
        </form>
    </div>
</div>
@endsection
