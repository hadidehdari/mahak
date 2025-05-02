@extends('layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">داشبورد مدیریت</h2>
            <p class="text-muted">خوش آمدید {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- آمار کلی -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon primary">
                        <i class="bi bi-play-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">ویدیوها</h6>
                        <h3 class="mb-0">{{ $stats['videos_count'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon success">
                        <i class="bi bi-headphones"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">کتاب‌های صوتی</h6>
                        <h3 class="mb-0">{{ $stats['audio_books_count'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon warning">
                        <i class="bi bi-stars"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">پویش‌های فعال</h6>
                        <h3 class="mb-0">{{ $stats['active_campaigns'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon danger">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">کاربران</h6>
                        <h3 class="mb-0">{{ $stats['users_count'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نمودار فعالیت -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">فعالیت کاربران</h5>
                    <p class="text-muted">نمودار فعالیت کاربران در 7 روز گذشته</p>
                    <canvas id="activityChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">آخرین فعالیت‌ها</h5>
                    <div class="list-group list-group-flush">
                        @foreach(range(1, 5) as $i)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="bi bi-circle-fill text-primary" style="font-size: 0.5rem;"></i>
                                </div>
                                <div>
                                    <p class="mb-0">یک فعالیت جدید</p>
                                    <small class="text-muted">{{ now()->subHours($i)->diffForHumans() }}</small>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
            datasets: [{
                label: 'تعداد فعالیت‌ها',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: true,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection