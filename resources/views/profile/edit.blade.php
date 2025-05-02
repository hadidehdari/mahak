@extends('layouts.app')

@section('title', 'تنظیمات پروفایل')

@push('styles')
<style>
    .profile-photo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
        border: 3px solid #e9ecef;
        border-radius: 50%;
        padding: 5px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .profile-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    .profile-photo:hover {
        transform: scale(1.05);
    }
    .profile-photo-upload {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: #0d6efd;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    .profile-photo-upload:hover {
        background-color: #0b5ed7;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ویرایش پروفایل</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">عکس پروفایل</label>
                            <div class="profile-photo-container">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}" 
                                     alt="عکس پروفایل" 
                                     id="profile-preview" 
                                     class="profile-photo">
                                <div class="profile-photo-upload" onclick="openMediaManager('profile_photo')">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control d-none" id="profile_photo" name="profile_photo" value="{{ old('profile_photo', $user->profile_photo) }}">
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">نام</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">شماره موبایل</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">ایمیل</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">رمز عبور جدید</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تکرار رمز عبور جدید</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.media-manager.modal')

@push('scripts')
<script>
$(document).ready(function() {
    // به‌روزرسانی پیش‌نمایش تصویر
    $('#profile_photo').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            $('#profile-preview').attr('src', '{{ asset("storage") }}/' + filePath);
        }
    });
});
</script>
@endpush

@endsection
