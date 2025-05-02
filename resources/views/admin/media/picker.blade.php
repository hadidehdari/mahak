<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-folder-open me-2"></i>
                            <span id="currentPath">{{ $path ?: 'ریشه' }}</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                                <i class="fas fa-folder-plus"></i> پوشه جدید
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                                <i class="fas fa-upload"></i> آپلود فایل
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($path)
                        <div class="mb-3">
                            <a href="javascript:void(0)" onclick="navigateToFolder('{{ dirname($path) }}')" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-up"></i> بازگشت
                            </a>
                        </div>
                    @endif

                    <div class="row">
                        @if(count($folders) > 0)
                            @foreach($folders as $folder)
                                <div class="col-md-2 col-sm-4 mb-3">
                                    <div class="folder-item text-center p-3 border rounded" 
                                         onclick="navigateToFolder('{{ $folder['path'] }}')"
                                         style="cursor: pointer;">
                                        <i class="fas fa-folder fa-3x text-warning"></i>
                                        <p class="mt-2 mb-0">{{ $folder['name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-center text-muted">هیچ پوشه‌ای وجود ندارد</p>
                            </div>
                        @endif
                    </div>

                    <div class="row mt-4">
                        @if(count($files) > 0)
                            @foreach($files as $file)
                                <div class="col-md-2 col-sm-4 mb-3">
                                    <div class="file-item text-center p-3 border rounded">
                                        <img src="{{ $file['url'] }}" 
                                             alt="{{ $file['name'] }}" 
                                             class="img-fluid mb-2"
                                             style="max-height: 100px; object-fit: cover;">
                                        <p class="mb-0">{{ $file['name'] }}</p>
                                        <button class="btn btn-sm btn-primary mt-2" 
                                                onclick="selectImage('{{ $file['path'] }}')">
                                            انتخاب
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-center text-muted">هیچ فایلی وجود ندارد</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ایجاد پوشه -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ایجاد پوشه جدید</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createFolderForm">
                    <div class="mb-3">
                        <label for="folderName" class="form-label">نام پوشه</label>
                        <input type="text" class="form-control" id="folderName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary" onclick="createFolder()">ایجاد</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal آپلود فایل -->
<div class="modal fade" id="uploadFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">آپلود فایل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadFileForm">
                    <div class="mb-3">
                        <label for="file" class="form-label">انتخاب فایل</label>
                        <input type="file" class="form-control" id="file" accept="image/*" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary" onclick="uploadFile()">آپلود</button>
            </div>
        </div>
    </div>
</div>

<script>
    function navigateToFolder(folderPath) {
        const url = new URL('{{ route("admin.media.picker") }}');
        url.searchParams.set('path', folderPath);
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('mediaLibrary').innerHTML = html;
                document.getElementById('currentPath').textContent = folderPath || 'ریشه';
            })
            .catch(error => console.error('Error:', error));
    }

    function selectImage(imagePath) {
        if (window.parent && window.parent.selectImage) {
            window.parent.selectImage(imagePath);
        }
    }

    function createFolder() {
        const folderName = document.getElementById('folderName').value;
        const currentPath = '{{ $path }}';
        
        fetch('{{ route("admin.media.folder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: folderName,
                path: currentPath
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                navigateToFolder(currentPath);
                bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
                document.getElementById('folderName').value = '';
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function uploadFile() {
        const fileInput = document.getElementById('file');
        const file = fileInput.files[0];
        const currentPath = '{{ $path }}';
        
        if (!file) {
            alert('لطفا یک فایل انتخاب کنید');
            return;
        }
        
        const formData = new FormData();
        formData.append('file', file);
        formData.append('path', currentPath);
        
        fetch('{{ route("admin.media.upload") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                navigateToFolder(currentPath);
                bootstrap.Modal.getInstance(document.getElementById('uploadFileModal')).hide();
                document.getElementById('file').value = '';
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // اضافه کردن event listener برای فرم‌ها
    document.getElementById('createFolderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        createFolder();
    });

    document.getElementById('uploadFileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        uploadFile();
    });
</script> 