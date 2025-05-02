<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'پنل مدیریت') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo-container d-flex justify-content-center mb-4">
                <img src="{{ asset('images/mahak-logo.png') }}" alt="Logo">
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-title="داشبورد">
                        <i class="bi bi-house-door"></i>
                        <span>داشبورد</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.videos.index') }}" class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}" data-title="ویدیوها">
                        <i class="bi bi-camera-video"></i>
                        <span>ویدیوها</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.audiobooks.index') }}" class="nav-link {{ request()->routeIs('admin.audiobooks.*') ? 'active' : '' }}" data-title="کتاب‌های صوتی">
                        <i class="bi bi-file-earmark-music"></i>
                        <span>کتاب‌های صوتی</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.campaigns.index') }}" class="nav-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}" data-title="پویش‌ها">
                        <i class="bi bi-trophy"></i>
                        <span>پویش‌ها</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-title="کاربران">
                        <i class="bi bi-people"></i>
                        <span>کاربران</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-title="دسته‌بندی‌ها">
                        <i class="bi bi-grid"></i>
                        <span>دسته‌بندی‌ها</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" data-title="اسلایدر">
                        <i class="bi bi-images"></i>
                        <span>اسلایدر</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" data-title="صفحات">
                        <i class="bi bi-file-text"></i>
                        <span>صفحات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}" data-title="کتابخانه رسانه">
                        <i class="fas fa-images"></i>
                        <span>کتابخانه رسانه</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.creators.index') }}" class="nav-link {{ request()->routeIs('admin.creators.*') ? 'active' : '' }}" data-title="سازندگان/کارگردان‌ها">
                        <i class="bi bi-people"></i>
                        <span>سازندگان/کارگردان‌ها</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-title="تنظیمات">
                        <i class="bi bi-gear"></i>
                        <span>تنظیمات</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="btn btn-link sidebar-toggler" type="button">
                    <i class="bi bi-list"></i>
                </button>

                <div class="d-flex align-items-center ms-auto">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/user.png') }}" alt="Profile" class="profile-img me-2" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>پروفایل</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

    @auth
    <script>
        // Toggle Sidebar
        document.querySelector('.sidebar-toggler').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const content = document.querySelector('.content');
            
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('expanded');
            content.classList.toggle('expanded');
            
            // ذخیره وضعیت منو در localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // بازیابی وضعیت منو از localStorage در هنگام بارگذاری صفحه
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const content = document.querySelector('.content');
            
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                navbar.classList.add('expanded');
                content.classList.add('expanded');
            }
        });

        // Active Link Highlight
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.classList.add('hover');
                }
            });
            link.addEventListener('mouseleave', function() {
                this.classList.remove('hover');
            });
        });

        // تنظیمات TinyMCE
        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help',
            directionality: 'rtl',
            language: 'fa_IR'
        });
    </script>
    @endauth
    @stack('scripts')
</body>
</html>