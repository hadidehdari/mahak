@extends('layouts.app')

@section('title', 'ایجاد پویش جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ایجاد پویش جدید</h3>
                </div>
                <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">عنوان پویش</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
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
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="banner_image">تصویر بنر</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input @error('banner_image') is-invalid @enderror" 
                                           id="banner_image" 
                                           name="banner_image" 
                                           accept="image/*" 
                                           required>
                                    <label class="custom-file-label" for="banner_image">انتخاب فایل</label>
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
                                   value="{{ old('start_date') }}" 
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
                                   value="{{ old('end_date') }}" 
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
                                       {{ old('is_active') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="" class="btn btn-default">انصراف</a>
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