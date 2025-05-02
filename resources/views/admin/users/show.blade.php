@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">جزئیات کاربر</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i>
                        بازگشت
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>نام:</label>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>ایمیل:</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="form-group">
                                <label>شماره تماس:</label>
                                <p>{{ $user->phone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>وضعیت:</label>
                                <p>
                                    @if($user->is_active)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </p>
                            </div>
                            <div class="form-group">
                                <label>تاریخ ثبت‌نام:</label>
                                <p>{{ verta($user->created_at)->format('Y/m/d H:i') }}</p>
                            </div>
                            <div class="form-group">
                                <label>آخرین ورود:</label>
                                <p>{{ $user->last_login_at ? verta($user->last_login_at)->format('Y/m/d H:i') : 'نامشخص' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 