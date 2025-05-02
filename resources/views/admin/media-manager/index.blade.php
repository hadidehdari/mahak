@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت رسانه</h3>
                    <div class="card-tools">
                        <form action="{{ route('media-manager.upload') }}" method="POST" enctype="multipart/form-data" class="d-inline" id="upload-form">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="file" name="file" class="d-none" id="file-input">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('file-input').click()">
                                <i class="fas fa-upload"></i> آپلود فایل
                            </button>
                        </form>
                        <div class="d-inline ms-2">
                            <button type="button" class="btn btn-success" id="create-folder-btn">
                                <i class="fas fa-folder-plus"></i> پوشه جدید
                            </button>
                            <div class="input-group mt-2" id="folder-input" style="display: none;">
                                <input type="text" class="form-control" id="folder-name" placeholder="نام پوشه جدید">
                                <button type="button" class="btn btn-success" id="folder-submit">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-secondary" id="folder-cancel">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="media-breadcrumb mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('media-manager.index') }}">
                                        <i class="fas fa-home"></i> ریشه
                                    </a>
                                </li>
                                @if($path)
                                    @php
                                        $paths = explode('/', $path);
                                        $currentPath = '';
                                    @endphp
                                    @foreach($paths as $folder)
                                        @php
                                            $currentPath .= $folder . '/';
                                        @endphp
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('media-manager.index', ['path' => rtrim($currentPath, '/')]) }}">
                                                {{ $folder }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </nav>
                    </div>
                    <div class="media-grid">
                        <div class="row">
                            @foreach($items as $item)
                                <div class="col-md-2 col-sm-4 col-6 mb-4">
                                    <div class="media-item card">
                                        <div class="card-body text-center">
                                            @if($item['type'] === 'directory')
                                                <i class="fas fa-folder fa-3x text-warning mb-2"></i>
                                                <h6 class="card-title">{{ $item['name'] }}</h6>
                                                <a href="{{ $item['url'] }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-folder-open"></i> باز کردن
                                                </a>
                                            @else
                                                @if(in_array($item['extension'], ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ $item['url'] }}" class="img-fluid mb-2" style="max-height: 100px;">
                                                @elseif(in_array($item['extension'], ['mp4', 'webm']))
                                                    <i class="fas fa-video fa-3x text-danger mb-2"></i>
                                                @elseif(in_array($item['extension'], ['mp3', 'wav']))
                                                    <i class="fas fa-music fa-3x text-success mb-2"></i>
                                                @else
                                                    <i class="fas fa-file fa-3x text-secondary mb-2"></i>
                                                @endif
                                                <h6 class="card-title">{{ $item['name'] }}</h6>
                                                <p class="text-muted small">{{ $item['size'] }}</p>
                                                <button class="btn btn-sm btn-info copy-link" data-url="{{ $item['url'] }}">
                                                    <i class="fas fa-copy"></i> کپی لینک
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // تنظیم توکن CSRF برای تمام درخواست‌های AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // کپی لینک
    $('.copy-link').click(function() {
        const url = $(this).data('url');
        navigator.clipboard.writeText(url).then(function() {
            alert('لینک با موفقیت کپی شد');
        });
    });

    // آپلود فایل
    $('#file-input').change(function() {
        if (this.files.length > 0) {
            const formData = new FormData($('#upload-form')[0]);
            
            $.ajax({
                url: '{{ route("media-manager.upload") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.error || 'خطا در آپلود فایل';
                    alert(error);
                }
            });
        }
    });

    // نمایش/مخفی کردن فرم ایجاد پوشه
    $('#create-folder-btn').click(function() {
        $('#folder-input').slideToggle();
        $('#folder-name').focus();
    });

    $('#folder-cancel').click(function() {
        $('#folder-input').slideUp();
        $('#folder-name').val('');
    });

    // ایجاد پوشه
    $('#folder-submit').click(function() {
        const name = $('#folder-name').val();
        
        if (!name) {
            alert('لطفا نام پوشه را وارد کنید');
            return;
        }
        
        $.ajax({
            url: '{{ route("media-manager.create-folder") }}',
            type: 'POST',
            data: {
                name: name,
                path: '{{ $path }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.error || 'خطا در ایجاد پوشه';
                alert(error);
            }
        });
    });

    // ایجاد پوشه با کلید Enter
    $('#folder-name').keypress(function(e) {
        if (e.which == 13) {
            $('#folder-submit').click();
        }
    });
});
</script>
@endpush 