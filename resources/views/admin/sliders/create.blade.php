@extends('layouts.app')

@section('title', 'افزودن اسلایدر جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن اسلایدر جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">تصویر</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" value="{{ old('image') }}" required readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="openMediaManager('image')">
                                        انتخاب از کتابخانه
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">نوع اسلایدر</label>
                            <select class="form-control @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">انتخاب کنید</option>
                                <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>دسته‌بندی</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>ویدیو</option>
                                <option value="audiobook" {{ old('type') == 'audiobook' ? 'selected' : '' }}>کتاب صوتی</option>
                                <option value="campaign" {{ old('type') == 'campaign' ? 'selected' : '' }}>کمپین</option>
                                <option value="external" {{ old('type') == 'external' ? 'selected' : '' }}>لینک خارجی</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" id="target-container">
                            <!-- محتوای این بخش بر اساس نوع اسلایدر تغییر می‌کند -->
                        </div>

                        <div class="form-group">
                            <label for="order">ترتیب</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', 0) }}" required>
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                       name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">انصراف</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal انتخاب تصویر از کتابخانه -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">انتخاب تصویر از کتابخانه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="mediaLibrary">
                    <!-- محتوای کتابخانه مدیا اینجا لود می‌شود -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // مدیریت انتخاب تصویر از کتابخانه
    document.addEventListener('DOMContentLoaded', function() {
        const mediaModal = document.getElementById('mediaModal');
        const mediaLibrary = document.getElementById('mediaLibrary');
        
        // بارگذاری محتوای کتابخانه مدیا هنگام باز شدن مودال
        mediaModal.addEventListener('show.bs.modal', function () {
            fetch('{{ route("admin.media.picker") }}')
                .then(response => response.text())
                .then(html => {
                    mediaLibrary.innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // انتخاب تصویر از کتابخانه
    window.selectImage = function(imagePath) {
        document.getElementById('image').value = imagePath;
        const modal = bootstrap.Modal.getInstance(document.getElementById('mediaModal'));
        modal.hide();
    };

    // تغییر محتوای target-container بر اساس نوع اسلایدر
    document.getElementById('type').addEventListener('change', function() {
        const type = this.value;
        const container = document.getElementById('target-container');
        
        switch(type) {
            case 'category':
                container.innerHTML = `
                    <label for="target_id">دسته‌بندی</label>
                    <select class="form-control" id="target_id" name="target_id" required>
                        <option value="">انتخاب کنید</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('target_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                `;
                break;
                
            case 'video':
                container.innerHTML = `
                    <label for="target_id">ویدیو</label>
                    <select class="form-control" id="target_id" name="target_id" required>
                        <option value="">انتخاب کنید</option>
                        @foreach($videos as $video)
                            <option value="{{ $video->id }}" {{ old('target_id') == $video->id ? 'selected' : '' }}>
                                {{ $video->title }}
                            </option>
                        @endforeach
                    </select>
                `;
                break;
                
            case 'audiobook':
                container.innerHTML = `
                    <label for="target_id">کتاب صوتی</label>
                    <select class="form-control" id="target_id" name="target_id" required>
                        <option value="">انتخاب کنید</option>
                        @foreach($audiobooks as $audiobook)
                            <option value="{{ $audiobook->id }}" {{ old('target_id') == $audiobook->id ? 'selected' : '' }}>
                                {{ $audiobook->title }}
                            </option>
                        @endforeach
                    </select>
                `;
                break;
                
            case 'campaign':
                container.innerHTML = `
                    <label for="target_id">کمپین</label>
                    <select class="form-control" id="target_id" name="target_id" required>
                        <option value="">انتخاب کنید</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ old('target_id') == $campaign->id ? 'selected' : '' }}>
                                {{ $campaign->title }}
                            </option>
                        @endforeach
                    </select>
                `;
                break;
                
            case 'external':
                container.innerHTML = `
                    <label for="link">لینک خارجی</label>
                    <input type="url" class="form-control" id="link" name="link" 
                           value="{{ old('link') }}" required>
                `;
                break;
                
            default:
                container.innerHTML = '';
        }
    });

    // اجرای تغییر اولیه در صورت وجود مقدار قبلی
    if (document.getElementById('type').value) {
        document.getElementById('type').dispatchEvent(new Event('change'));
    }
</script>
@endpush 