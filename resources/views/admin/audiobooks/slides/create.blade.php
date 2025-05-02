@extends('layouts.app')

@section('title', 'افزودن اسلاید جدید به ' . $audioBook->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">افزودن اسلاید جدید</h3>
                    <a href="{{ route('admin.audiobooks.slides.index', $audioBook) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i>
                        بازگشت
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.audiobooks.slides.store', $audioBook) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">عنوان</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">توضیحات</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">تصویر</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" value="{{ old('image') }}" readonly>
                                        <button type="button" class="btn btn-primary" onclick="openMediaManager('image')">
                                            <i class="bi bi-image"></i>
                                            انتخاب از رسانه
                                        </button>
                                    </div>
                                    <div id="image-preview" class="mt-2"></div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="audio_url" class="form-label">آدرس فایل صوتی</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('audio_url') is-invalid @enderror" 
                                               id="audio_url" name="audio_url" value="{{ old('audio_url') }}" required>
                                        <button type="button" class="btn btn-primary" onclick="openMediaManager('audio')">
                                            <i class="bi bi-file-earmark-music"></i>
                                            انتخاب از رسانه
                                        </button>
                                    </div>
                                    @error('audio_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="duration" class="form-label">مدت زمان (ثانیه)</label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration', 0) }}" required min="0">
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="order" class="form-label">ترتیب</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                           id="order" name="order" value="{{ old('order', 0) }}" required min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                            <a href="{{ route('admin.audiobooks.slides.index', $audioBook) }}" class="btn btn-secondary">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.media-manager.modal')

@push('scripts')
<script>
function openMediaManager(type) {
    const modal = document.getElementById('mediaManagerModal');
    const mediaManager = new bootstrap.Modal(modal);
    
    // تنظیم callback برای انتخاب فایل
    window.selectMediaCallback = function(url) {
        if (type === 'image') {
            document.getElementById('image').value = url;
            document.getElementById('image-preview').innerHTML = `
                <img src="${url}" class="img-thumbnail" style="max-height: 200px;">
            `;
        } else if (type === 'audio') {
            document.getElementById('audio_url').value = url;
        }
        mediaManager.hide();
    };
    
    mediaManager.show();
}
</script>
@endpush
@endsection 