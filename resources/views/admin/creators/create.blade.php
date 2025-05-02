@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن سازنده/کارگردان جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.creators.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">نام</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">عکس</label>
                            <div class="photo-container">
                                <img src="{{ old('photo') ? old('photo') : asset('images/no-image.png') }}" 
                                     alt="عکس سازنده/کارگردان" 
                                     id="photo-preview" 
                                     class="photo-preview">
                                <div class="photo-upload" onclick="openMediaManager('photo')">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" class="form-control" id="photo" name="photo" value="{{ old('photo') }}">
                            </div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                            <a href="{{ route('admin.creators.index') }}" class="btn btn-secondary">انصراف</a>
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
    .photo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
        border: 3px solid #e9ecef;
        border-radius: 10px;
        padding: 5px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .photo-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    .photo-preview:hover {
        transform: scale(1.05);
    }
    .photo-upload {
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
    .photo-upload:hover {
        background-color: #0b5ed7;
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // به‌روزرسانی پیش‌نمایش عکس
    $('#photo').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            $('#photo-preview').attr('src', filePath);
        }
    });
});
</script>
@endpush
@endsection 