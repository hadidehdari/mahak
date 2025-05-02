@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ویدیوها</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['videos_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-camera-video fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                کتاب‌های صوتی</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['audio_books_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                پویش‌ها</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['campaigns_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-megaphone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                کاربران</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Latest Videos -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">آخرین ویدیوها</h6>
                    <a href="" class="btn btn-sm btn-primary">مشاهده همه</a>
                </div>
                <div class="card-body">
                    @forelse($latestVideos as $video)
                        <div class="mb-3">
                            <h6 class="font-weight-bold">{{ $video->title }}</h6>
                            <small class="text-muted">{{ $video->created_at->format('Y/m/d') }}</small>
                        </div>
                    @empty
                        <p class="text-center">هیچ ویدیویی یافت نشد.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Latest Audio Books -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">آخرین کتاب‌های صوتی</h6>
                    <a href="{{ route('admin.audiobooks.index') }}" class="btn btn-sm btn-success">مشاهده همه</a>
                </div>
                <div class="card-body">
                    @forelse($latestAudioBooks as $audioBook)
                        <div class="mb-3">
                            <h6 class="font-weight-bold">{{ $audioBook->title }}</h6>
                            <small class="text-muted">{{ $audioBook->created_at->format('Y/m/d') }}</small>
                        </div>
                    @empty
                        <p class="text-center">هیچ کتاب صوتی یافت نشد.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Latest Campaigns -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">آخرین پویش‌ها</h6>
                    <a href="" class="btn btn-sm btn-info">مشاهده همه</a>
                </div>
                <div class="card-body">
                    @forelse($latestCampaigns as $campaign)
                        <div class="mb-3">
                            <h6 class="font-weight-bold">{{ $campaign->title }}</h6>
                            <small class="text-muted">{{ $campaign->created_at->format('Y/m/d') }}</small>
                        </div>
                    @empty
                        <p class="text-center">هیچ پویشی یافت نشد.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 