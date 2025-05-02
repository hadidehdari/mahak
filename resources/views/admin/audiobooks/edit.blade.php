@extends('layouts.app')

@section('title', 'ویرایش کتاب صوتی')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش کتاب صوتی</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.audiobooks.edit', ['audiobook' => $audioBook]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $audioBook->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $audioBook->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover_image">تصویر جلد</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" value="{{ old('cover_image', $audioBook->cover_image) }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mediaModal">انتخاب از کتابخانه</button>
                                </div>
                            </div>
                            @error('cover_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover_image_url">یا لینک تصویر</label>
                            <input type="url" class="form-control @error('cover_image_url') is-invalid @enderror" id="cover_image_url" name="cover_image_url" value="{{ old('cover_image_url') }}">
                            @error('cover_image_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>پیش‌نمایش تصویر</label>
                            <div>
                                <img src="{{ $audioBook->cover_image ? (Str::startsWith($audioBook->cover_image, 'http') ? $audioBook->cover_image : asset('storage/' . $audioBook->cover_image)) : asset('images/no-image.png') }}" 
                                     alt="تصویر جلد" 
                                     style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                     id="cover_image_preview">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_id">دسته‌بندی</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $audioBook->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="creator_id">سازنده</label>
                            <select class="form-control @error('creator_id') is-invalid @enderror" id="creator_id" name="creator_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($creators as $creator)
                                    <option value="{{ $creator->id }}" {{ old('creator_id', $audioBook->creator_id) == $creator->id ? 'selected' : '' }}>
                                        {{ $creator->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('creator_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="age_group_id">گروه سنی</label>
                            <select class="form-control @error('age_group_id') is-invalid @enderror" id="age_group_id" name="age_group_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($ageGroups as $ageGroup)
                                    <option value="{{ $ageGroup->id }}" {{ old('age_group_id', $audioBook->age_group_id) == $ageGroup->id ? 'selected' : '' }}>
                                        {{ $ageGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('age_group_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" {{ old('is_featured', $audioBook->is_featured) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">ویژه</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active', $audioBook->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('admin.audiobooks.slides.create', $audioBook) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> افزودن اسلاید جدید
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        <a href="{{ route('admin.audiobooks.index') }}" class="btn btn-secondary">انصراف</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal انتخاب تصویر از کتابخانه -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">انتخاب تصویر از کتابخانه</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
    // نمایش پیش‌نمایش تصویر
    function updateImagePreview() {
        const coverImage = document.getElementById('cover_image').value;
        const coverImageUrl = document.getElementById('cover_image_url').value;
        const preview = document.getElementById('cover_image_preview');
        
        if (coverImageUrl) {
            preview.src = coverImageUrl;
        } else if (coverImage) {
            preview.src = coverImage.startsWith('http') ? coverImage : '{{ asset("storage/") }}/' + coverImage;
        } else {
            preview.src = '{{ asset("images/no-image.png") }}';
        }
    }

    document.getElementById('cover_image').addEventListener('change', updateImagePreview);
    document.getElementById('cover_image_url').addEventListener('change', updateImagePreview);

    // انتخاب تصویر از کتابخانه مدیا
    document.addEventListener('DOMContentLoaded', function() {
        const mediaLibrary = document.getElementById('mediaLibrary');
        const coverImageInput = document.getElementById('cover_image');
        
        // اینجا کد مربوط به لود کردن کتابخانه مدیا و انتخاب تصویر اضافه می‌شود
    });
</script>
@endpush 