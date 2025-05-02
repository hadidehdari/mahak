@extends('layouts.app')

@section('title', 'ویرایش اسلایدر')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش اسلایدر</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">تصویر فعلی</label>
                            <div>
                                <img src="{{ asset('storage/' . $slider->image) }}" 
                                     alt="{{ $slider->title }}" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            <label class="mt-2">تصویر جدید (اختیاری)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image">
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="link">لینک (اختیاری)</label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" 
                                   id="link" name="link" value="{{ old('link', $slider->link) }}">
                            @error('link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">ترتیب</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $slider->order) }}" required>
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                       name="is_active" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">انصراف</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 