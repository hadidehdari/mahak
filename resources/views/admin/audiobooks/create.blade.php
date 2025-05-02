@extends('layouts.app')

@section('title', 'افزودن کتاب صوتی جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن کتاب صوتی جدید</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.audiobooks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
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
                            <label for="cover_image" class="form-label">تصویر جلد</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" value="{{ old('cover_image') }}" placeholder="مسیر تصویر را وارد کنید">
                                <button class="btn btn-outline-secondary" type="button" onclick="openMediaManager('cover_image')">
                                    <i class="fas fa-images"></i> انتخاب از کتابخانه
                                </button>
                            </div>
                            <div class="mt-2">
                                <img src="{{ old('cover_image') ? (Str::startsWith(old('cover_image'), 'http') ? old('cover_image') : asset('storage/' . old('cover_image'))) : asset('images/no-image.png') }}" 
                                     alt="تصویر جلد" 
                                     id="cover-preview" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">دسته‌بندی</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="creator_id" class="form-label">سازنده</label>
                            <select class="form-select @error('creator_id') is-invalid @enderror" id="creator_id" name="creator_id" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($creators as $creator)
                                    <option value="{{ $creator->id }}" {{ old('creator_id') == $creator->id ? 'selected' : '' }}>
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
                                    <option value="{{ $ageGroup->id }}" {{ old('age_group_id') == $ageGroup->id ? 'selected' : '' }}>
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
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    ویژه
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    فعال
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                            <a href="{{ route('admin.audiobooks.index') }}" class="btn btn-secondary">انصراف</a>
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
$(document).ready(function() {
    // به‌روزرسانی پیش‌نمایش تصویر جلد
    $('#cover_image').on('change', function() {
        const filePath = $(this).val();
        if (filePath) {
            if (filePath.startsWith('http')) {
                $('#cover-preview').attr('src', filePath);
            } else {
                $('#cover-preview').attr('src', '{{ asset("storage") }}/' + filePath);
            }
        }
    });
});
</script>
@endpush
@endsection 