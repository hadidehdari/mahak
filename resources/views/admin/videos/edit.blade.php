@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش ویدیو</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.videos.update', $video) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $video->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $video->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">تصویر بندانگشتی</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" value="{{ old('thumbnail', $video->thumbnail) }}" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="openMediaManager('thumbnail')">
                                    <i class="fas fa-folder-open"></i> انتخاب از کتابخانه
                                </button>
                            </div>
                            <div class="mt-2">
                                <img src="{{ old('thumbnail', $video->thumbnail) ? asset('storage/' . old('thumbnail', $video->thumbnail)) : asset('images/no-image.png') }}" 
                                     alt="تصویر بندانگشتی" 
                                     id="thumbnail-preview" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 150px;">
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_url" class="form-label">آدرس ویدیو</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url', $video->video_url) }}" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="openMediaManager('video_url')">
                                    <i class="fas fa-folder-open"></i> انتخاب از کتابخانه
                                </button>
                            </div>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">مدت زمان (ثانیه)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $video->duration) }}" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file_size" class="form-label">حجم فایل</label>
                            <input type="text" class="form-control @error('file_size') is-invalid @enderror" id="file_size" name="file_size" value="{{ old('file_size', $video->file_size) }}" placeholder="مثال: 1.2GB">
                            @error('file_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="background_color" class="form-label">رنگ پس‌زمینه</label>
                            <input type="color" class="form-control form-control-color @error('background_color') is-invalid @enderror" id="background_color" name="background_color" value="{{ old('background_color', $video->background_color) }}">
                            @error('background_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">دسته‌بندی</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $video->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="creator_id" class="form-label">سازنده/کارگردان</label>
                            <select class="form-select @error('creator_id') is-invalid @enderror" id="creator_id" name="creator_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($creators as $creator)
                                    <option value="{{ $creator->id }}" {{ old('creator_id', $video->creator_id) == $creator->id ? 'selected' : '' }}>
                                        {{ $creator->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('creator_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="age_group_id" class="form-label">گروه سنی</label>
                            <select class="form-select @error('age_group_id') is-invalid @enderror" id="age_group_id" name="age_group_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($ageGroups as $ageGroup)
                                    <option value="{{ $ageGroup->id }}" {{ old('age_group_id', $video->age_group_id) == $ageGroup->id ? 'selected' : '' }}>
                                        {{ $ageGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('age_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">ویژه</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">امتیاز (0-5)</label>
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating', $video->rating) }}" min="0" max="5" step="0.1">
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating_count" class="form-label">تعداد امتیازدهی</label>
                            <input type="number" class="form-control @error('rating_count') is-invalid @enderror" id="rating_count" name="rating_count" value="{{ old('rating_count', $video->rating_count) }}" min="0">
                            @error('rating_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">انصراف</a>
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
    // به‌روزرسانی پیش‌نمایش تصویر بندانگشتی
    $('#thumbnail').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            $('#thumbnail-preview').attr('src', '{{ asset("storage") }}/' + filePath);
        }
    });
});
</script>
@endpush
@endsection 