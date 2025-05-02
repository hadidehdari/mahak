@extends('layouts.guest')

@section('content')
<div class="login-container">
    <div class="login-card">
        <img src="{{ asset('images/mahak-logo.png') }}" alt="ماهک" class="logo">
        <h2>ثبت نام در ماهک</h2>
        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
            @csrf
            <div class="form-floating mb-4">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="نام و نام خانوادگی" required>
                <label for="name">نام و نام خانوادگی</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09123456789" required dir="ltr">
                <label for="phone">شماره موبایل</label>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" dir="ltr">
                <label for="email">ایمیل (اختیاری)</label>
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

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="تکرار رمز عبور" required>
                <label for="password-confirm">تکرار رمز عبور</label>
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary">
                    ثبت نام
                </button>
            </div>

            <div class="text-center">
                <span>قبلاً ثبت نام کرده‌اید؟</span>
                <a href="{{ route('login') }}" class="text-decoration-none">ورود</a>
            </div>
        </form>
    </div>
</div>
@endsection
