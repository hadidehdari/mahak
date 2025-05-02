@extends('layouts.app')

@section('title', 'افزودن صفحه ثابت')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن صفحه ثابت</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.store') }}" method="POST">
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
                            <label for="content">محتوا</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_title">عنوان متا</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                            @error('meta_title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">توضیحات متا</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="route_name">نام مسیر</label>
                            <input type="text" class="form-control @error('route_name') is-invalid @enderror" 
                                   id="route_name" name="route_name" value="{{ old('route_name') }}" required>
                            <small class="form-text text-muted">نام یکتای مسیر برای دسترسی به صفحه (به انگلیسی و بدون فاصله)</small>
                            @error('route_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="route_path">مسیر</label>
                            <input type="text" class="form-control @error('route_path') is-invalid @enderror" 
                                   id="route_path" name="route_path" value="{{ old('route_path') }}" required>
                            <small class="form-text text-muted">مسیر نمایش صفحه در مرورگر (مثال: about-us)</small>
                            @error('route_path')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                       name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">انصراف</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/aopr068hhhdflzqg8xt4rjvwp00l3b92undzx01vkvrmzbei/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            // Premium features
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        language: 'fa_IR',
        directionality: 'rtl',
        height: 500,
        tinycomments_mode: 'embedded',
        tinycomments_author: '{{ auth()->user()->name }}',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
@endpush
@endsection 