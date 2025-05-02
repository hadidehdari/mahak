@extends('layouts.app')

@section('title', 'تنظیمات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تنظیمات</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="app_name" class="form-label">نام برنامه</label>
                            <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                   id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required>
                            @error('app_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="app_version" class="form-label">ورژن برنامه</label>
                            <input type="text" class="form-control @error('app_version') is-invalid @enderror" 
                                   id="app_version" name="app_version" value="{{ old('app_version', $settings['app_version']) }}" required>
                            @error('app_version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="splash_image" class="form-label">تصویر اسپلش</label>
                            <div class="splash-image-container">
                                <img src="{{ old('splash_image', $settings['splash_image']) ? old('splash_image', $settings['splash_image']) : asset('images/no-image.png') }}" 
                                     alt="تصویر اسپلش" 
                                     id="splash-preview" 
                                     class="splash-preview">
                                <div class="splash-upload" onclick="openMediaManager('splash_image')">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control d-none" id="splash_image" name="splash_image" value="{{ old('splash_image', $settings['splash_image']) }}">
                            @error('splash_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره تنظیمات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.media-manager.modal')

@push('styles')
<style>
    .splash-image-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
        border: 3px solid #e9ecef;
        border-radius: 10px;
        padding: 5px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .splash-preview {
        width: 300px;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    .splash-preview:hover {
        transform: scale(1.05);
    }
    .splash-upload {
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
    .splash-upload:hover {
        background-color: #0b5ed7;
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // به‌روزرسانی پیش‌نمایش تصویر اسپلش
    $('#splash_image').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            $('#splash-preview').attr('src', filePath);
        }
    });
});
</script>
@endpush
@endsection 