<div class="modal fade" id="mediaManagerModal" tabindex="-1" aria-labelledby="mediaManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaManagerModalLabel">مدیریت رسانه</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="media-manager-container">
                    <div class="media-toolbar mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="media-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item">
                                            <a href="#" class="media-path" data-path="">ریشه</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="media-actions">
                                <form id="media-upload-form" class="d-inline">
                                    <input type="file" name="file" class="d-none" id="media-file-input">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('media-file-input').click()">
                                        <i class="fas fa-upload"></i> آپلود فایل
                                    </button>
                                </form>
                                <button type="button" class="btn btn-success btn-sm ms-2" id="create-folder-btn">
                                    <i class="fas fa-folder-plus"></i> پوشه جدید
                                </button>
                            </div>
                        </div>
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
                    <div class="media-grid">
                        <div class="row" id="media-items">
                            <!-- محتوای رسانه‌ها اینجا لود می‌شود -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-primary" id="select-media">انتخاب</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.media-manager-container {
    min-height: 400px;
}

.media-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card.active {
    background: #d1f2ff;
    border-radius: 15px;
    box-shadow: 0px 1px 10px #928c8c;
}

.media-item .card-body {
    padding: 0.5rem;
}

.media-item img {
    max-height: 100px;
    object-fit: contain;
}

.media-item .file-name {
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.media-item .file-size {
    font-size: 0.7rem;
    color: #6c757d;
}

.media-breadcrumb .breadcrumb {
    margin-bottom: 0;
    background: none;
}

.media-breadcrumb .breadcrumb-item a {
    color: #0d6efd;
    text-decoration: none;
}

.media-breadcrumb .breadcrumb-item a:hover {
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentPath = '';
    let selectedItem = null;
    let targetInput = null;

    // تنظیم توکن CSRF برای تمام درخواست‌های AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // تابع برای لود محتوای پوشه
    function loadMediaContent(path = '') {
        console.log('{{ route("media-manager.index") }}');
        $.get('{{ route("media-manager.index") }}', { path: path }, function(response) {
            const html = $(response);
            $('#media-items').html(html.find('#media-items').html());
            updateBreadcrumb(path);
            currentPath = path;
        });
    }

    // تابع برای به‌روزرسانی نوار مسیر
    function updateBreadcrumb(path) {
        const breadcrumb = $('.media-breadcrumb .breadcrumb');
        breadcrumb.empty();
        
        breadcrumb.append('<li class="breadcrumb-item"><a href="#" class="media-path" data-path="">ریشه</a></li>');
        
        if (path) {
            const parts = path.split('/');
            let currentPath = '';
            
            parts.forEach(part => {
                currentPath += (currentPath ? '/' : '') + part;
                breadcrumb.append(`<li class="breadcrumb-item"><a href="#" class="media-path" data-path="${currentPath}">${part}</a></li>`);
            });
        }
    }

    // کلیک روی مسیر در نوار مسیر
    $(document).on('click', '.media-path', function(e) {
        e.preventDefault();
        const path = $(this).data('path');
        loadMediaContent(path);
    });

    // انتخاب آیتم
    $(document).on('click', '.media-item', function() {
        $('.media-item').removeClass('active');
        $(this).addClass('active');
        selectedItem = $(this).data('url');
        
        // به‌روزرسانی پیش‌نمایش تصویر بلافاصله پس از انتخاب
        if (targetInput && targetInput.attr('id') === 'profile_photo') {
            $('#profile-preview').attr('src', selectedItem);
        } else if (targetInput && targetInput.attr('id') === 'splash_image') {
            $('#splash-preview').attr('src', selectedItem);
        }
    });

    // دوبار کلیک روی پوشه
    $(document).on('dblclick', '.media-item.directory', function() {
        const path = $(this).data('path');
        loadMediaContent(path);
    });

    // آپلود فایل
    $('#media-file-input').change(function() {
        if (this.files.length > 0) {
            const formData = new FormData();
            formData.append('file', this.files[0]);
            formData.append('path', currentPath);
            
            $.ajax({
                url: '{{ route("media-manager.upload") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    loadMediaContent(currentPath);
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
                path: currentPath
            },
            success: function(response) {
                loadMediaContent(currentPath);
                $('#folder-input').slideUp();
                $('#folder-name').val('');
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

    // انتخاب فایل و بستن مودال
    $('#select-media').click(function() {
        if (selectedItem && targetInput) {
            $(targetInput).val(selectedItem);
            // به‌روزرسانی پیش‌نمایش تصویر
            if (targetInput.attr('id') === 'profile_photo') {
                $('#profile-preview').attr('src', selectedItem);
            } else if (targetInput.attr('id') === 'splash_image') {
                $('#splash-preview').attr('src', selectedItem);
            }
            $('#mediaManagerModal').modal('hide');
        }
    });

    // تابع برای باز کردن مودال
    window.openMediaManager = function(inputId) {
        console.log(inputId);
        targetInput = $('#' + inputId);
        selectedItem = null;
        $('.media-item').removeClass('active');
        loadMediaContent();
        $('#mediaManagerModal').modal('show');
    };
});
</script>
@endpush 