@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">جزئیات فرزند</h3>
                    <div>
                        <a href="{{ route('users.children.edit', [$user, $child]) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i>
                            ویرایش
                        </a>
                        <a href="{{ route('', $user) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-right"></i>
                            بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px">نام:</th>
                                    <td>{{ $child->name }}</td>
                                </tr>
                                <tr>
                                    <th>سن:</th>
                                    <td>{{ $child->age }}</td>
                                </tr>
                                <tr>
                                    <th>جنسیت:</th>
                                    <td>{{ $child->gender == 'male' ? 'پسر' : 'دختر' }}</td>
                                </tr>
                                <tr>
                                    <th>وضعیت:</th>
                                    <td>
                                        @if($child->is_active)
                                            <span class="badge bg-success">فعال</span>
                                        @else
                                            <span class="badge bg-danger">غیرفعال</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاریخ ثبت:</th>
                                    <td>{{ verta($child->created_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخرین بروزرسانی:</th>
                                    <td>{{ verta($child->updated_at)->format('Y/m/d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-3">فعالیت‌های اخیر</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>نوع فعالیت</th>
                                            <th>مدت زمان</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($child->activities()->latest()->take(5)->get() as $activity)
                                            <tr>
                                                <td>{{ $activity->activity_type }}</td>
                                                <td>{{ $activity->duration }} دقیقه</td>
                                                <td>
                                                    @if($activity->status == 'completed')
                                                        <span class="badge bg-success">تکمیل شده</span>
                                                    @elseif($activity->status == 'in_progress')
                                                        <span class="badge bg-warning">در حال انجام</span>
                                                    @else
                                                        <span class="badge bg-danger">لغو شده</span>
                                                    @endif
                                                </td>
                                                <td>{{ verta($activity->created_at)->format('Y/m/d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">هیچ فعالیتی یافت نشد.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 