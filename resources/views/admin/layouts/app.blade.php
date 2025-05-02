<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل مدیریت') - ماهک</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark text-light">
            <div class="sidebar-header">
                <h3>پنل مدیریت ماهک</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        داشبورد
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-grid"></i>
                        دسته‌بندی‌ها
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.creators.index') }}">
                        <i class="bi bi-person"></i>
                        سازندگان
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.videos.index') }}">
                        <i class="bi bi-camera-video"></i>
                        ویدیوها
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.audiobooks.index') }}">
                        <i class="bi bi-book"></i>
                        کتاب‌های صوتی
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.campaigns.index') }}">
                        <i class="bi bi-megaphone"></i>
                        پویش‌ها
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.media.index') }}">
                        <i class="bi bi-images"></i>
                        مدیریت فایل‌ها
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear"></i>
                        تنظیمات
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person"></i>
                                        پروفایل
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i>
                                            خروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 