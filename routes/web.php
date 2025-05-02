<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController, CategoryController, MovieController, AudioBookController,
    CampaignController, UserController, SliderController, PageController,
    MediaController, CreatorController, SettingController, VideoController,
     CampaignSubmissionController, MediaManagerController
};
use App\Http\Controllers\Auth\{
    LoginController, RegisterController, ForgotPasswordController, ResetPasswordController
};
use App\Http\Controllers\{
    ProfileController, FileController, AppController
};
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─────────────── Guest Routes ───────────────
Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.post');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->name('register.post');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
        Route::post('password/reset', 'reset')->name('password.update');
    });
});

// ─────────────── Public Routes ───────────────
Route::get('/', [AppController::class, 'index'])->name('home');

// ─────────────── Authenticated Routes ───────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    // File Uploads
    Route::prefix('files')->name('files.')->controller(FileController::class)->group(function () {
        Route::post('upload', 'upload')->name('upload');
        Route::delete('delete', 'delete')->name('delete');
    });
});

// ─────────────── Admin Routes ───────────────
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Media
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('files', [MediaController::class, 'getFiles'])->name('files');
        Route::post('upload', [MediaController::class, 'upload'])->name('upload');
        Route::delete('delete', [MediaController::class, 'delete'])->name('delete');
        Route::post('folder', [MediaController::class, 'createFolder'])->name('folder');
        Route::get('picker', [MediaController::class, 'picker'])->name('picker');
    });

    // Resources
    Route::resources([
        'categories' => CategoryController::class,
        'creators' => CreatorController::class,
        'pages' => PageController::class,
        'videos' => VideoController::class,
        'audiobooks' => AudioBookController::class,
        'campaigns' => CampaignController::class,
        'sliders' => SliderController::class,
    ]);

    // Video Management
    Route::prefix('videos')->name('videos.')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('create', [VideoController::class, 'create'])->name('create');
        Route::post('/', [VideoController::class, 'store'])->name('store');
        Route::get('{video}/edit', [VideoController::class, 'edit'])->name('edit');
        Route::put('{video}', [VideoController::class, 'update'])->name('update');
        Route::delete('{video}', [VideoController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('audiobooks')->name('audiobooks.')->group(function () {
        // Audio Book CRUD Routes
        Route::get('/', [AudioBookController::class, 'index'])->name('index');
        Route::get('create', [AudioBookController::class, 'create'])->name('create');
        Route::post('/', [AudioBookController::class, 'store'])->name('store');
        Route::get('{audiobook}/edit', [AudioBookController::class, 'edit'])->name('edit');
        Route::put('{audiobook}', [AudioBookController::class, 'update'])->name('update');
        Route::delete('{audiobook}', [AudioBookController::class, 'destroy'])->name('destroy');

        // Slide Management Routes
        Route::get('{audiobook}/slides', [AudioBookController::class, 'slides'])->name('slides.index');
        Route::get('{audiobook}/slides/create', [AudioBookController::class, 'createSlide'])->name('slides.create');
        Route::post('{audiobook}/slides', [AudioBookController::class, 'storeSlide'])->name('slides.store');
        Route::get('{audiobook}/slides/{slide}/edit', [AudioBookController::class, 'editSlide'])->name('slides.edit');
        Route::put('{audiobook}/slides/{slide}', [AudioBookController::class, 'updateSlide'])->name('slides.update');
        Route::delete('{audiobook}/slides/{slide}', [AudioBookController::class, 'deleteSlide'])->name('slides.destroy');
        Route::post('{audiobook}/slides/reorder', [AudioBookController::class, 'reorderSlides'])->name('slides.reorder');
    });


    // Pages
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('create', [PageController::class, 'create'])->name('create');
        Route::post('/', [PageController::class, 'store'])->name('store');
        Route::get('{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('{page}', [PageController::class, 'update'])->name('update');
        Route::delete('{page}', [PageController::class, 'destroy'])->name('destroy');
    });

    // Campaign Submissions
    Route::prefix('campaigns')->name('campaigns.')->group(function () {
        Route::get('{campaign}/submissions', [CampaignController::class, 'submissions'])->name('submissions');
        Route::post('{campaign}/winners', [CampaignController::class, 'setWinners'])->name('winners');
    });

    // Users & Children
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::post('{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');

        Route::prefix('{user}/children')->name('children.')->group(function () {
            Route::get('/', [UserController::class, 'children'])->name('index');
            Route::get('create', [UserController::class, 'createChild'])->name('create');
            Route::post('/', [UserController::class, 'storeChild'])->name('store');
            Route::get('{child}/edit', [UserController::class, 'editChild'])->name('edit');
            Route::put('{child}', [UserController::class, 'updateChild'])->name('update');
            Route::delete('{child}', [UserController::class, 'destroyChild'])->name('destroy');
        });
    });

    // Children Activities
    Route::get('children/{child}/activities', [UserController::class, 'activities'])->name('children.activities');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });
});

// ─────────────── File/Media Manager Routes ───────────────
Route::get('storage/{path}', [FileController::class, 'show'])
    ->where('path', '.*')
    ->name('storage.show');

Route::prefix('laravel-filemanager')->middleware(['web', 'auth'])->group(function () {
    Lfm::routes();
});

Route::prefix('media-manager')->name('media-manager.')->controller(MediaManagerController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('upload', 'upload')->name('upload');
    Route::post('create-folder', 'createFolder')->name('create-folder');
});

// ─────────────── Static Page Routes ───────────────
Route::get('/{route_path}', [PageController::class, 'show'])
    ->where('route_path', '^(?!admin|login|register|password|media-manager|laravel-filemanager).*$')
    ->name('page.show');
