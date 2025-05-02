@extends('layouts.app')

@section('title', 'ویرایش پویش')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش پویش {{ $campaign->title }}</h3>
                </div>
                <form action="{{ route('campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">عنوان پویش</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $campaign->title) }}" 
                                   required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      required>{{ old('description', $campaign->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="banner_image">تصویر بنر</label>
                            @if($campaign->banner_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($campaign->banner_image) }}" 
                                         alt="{{ $campaign->title }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px;">
                                </div>
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input @error('banner_image') is-invalid @enderror" 
                                           id="banner_image" 
                                           name="banner_image" 
                                           accept="image/*">
                                    <label class="custom-file-label" for="banner_image">انتخاب فایل جدید</label>
                                </div>
                            </div>
                            @error('banner_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">تاریخ شروع</label>
                            <input type="date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date', $campaign->start_date->format('Y-m-d')) }}" 
                                   required>
                            @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">تاریخ پایان</label>
                            <input type="date" 
                                   class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date', $campaign->end_date->format('Y-m-d')) }}" 
                                   required>
                            @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $campaign->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-default">انصراف</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // نمایش نام فایل انتخاب شده
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush 