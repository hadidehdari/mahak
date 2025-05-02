@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن دسته‌بندی جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">نام دسته‌بندی</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poster" class="form-label">پوستر</label>
                            <div class="poster-container">
                                <img src="{{ old('poster') ? asset('storage/' . old('poster')) : asset('images/no-image.png') }}" 
                                     alt="پوستر دسته‌بندی" 
                                     id="poster-preview" 
                                     class="poster-preview">
                                <div class="poster-upload" onclick="openMediaManager('poster')">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" class="form-control" id="poster" name="poster" value="{{ old('poster') }}">
                                <img src="{{ old('poster') ? old('poster') : asset('images/no-image.png') }}" 
                                     alt="پوستر دسته‌بندی" 
                                     class="mt-2" 
                                     style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                            </div>
                            @error('poster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_type" class="form-label">نوع محتوا</label>
                            <select class="form-select @error('content_type') is-invalid @enderror" id="content_type" name="content_type" required>
                                <option value="">انتخاب کنید</option>
                                <option value="video" {{ old('content_type') === 'video' ? 'selected' : '' }}>ویدیو</option>
                                <option value="audio_book" {{ old('content_type') === 'audio_book' ? 'selected' : '' }}>کتاب صوتی</option>
                            </select>
                            @error('content_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="background_color" class="form-label">رنگ پس‌زمینه</label>
                            <input type="color" class="form-control form-control-color @error('background_color') is-invalid @enderror" id="background_color" name="background_color" value="{{ old('background_color', '#FFFFFF') }}" required>
                            @error('background_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="text_color" class="form-label">رنگ متن</label>
                            <input type="color" class="form-control form-control-color @error('text_color') is-invalid @enderror" id="text_color" name="text_color" value="{{ old('text_color', '#000000') }}" required>
                            @error('text_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.media-manager.modal')

@push('styles')
<style>
    .poster-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
        border: 3px solid #e9ecef;
        border-radius: 10px;
        padding: 5px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .poster-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    .poster-preview:hover {
        transform: scale(1.05);
    }
    .poster-upload {
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
    .poster-upload:hover {
        background-color: #0b5ed7;
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // به‌روزرسانی پیش‌نمایش پوستر
    $('#poster').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            $('#poster-preview').attr('src', '{{ asset("storage") }}/' + filePath);
        }
    });
});
</script>
@endpush
@endsection 