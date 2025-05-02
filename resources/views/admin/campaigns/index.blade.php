@extends('layouts.app')

@section('title', 'مدیریت پویش‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست پویش‌ها</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> ایجاد پویش جدید
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ شروع</th>
                                    <th>تاریخ پایان</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                <tr>
                                    <td>{{ $campaign->id }}</td>
                                    <td>
                                        <img src="{{ Storage::url($campaign->banner_image) }}" 
                                             alt="{{ $campaign->title }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 100px;">
                                    </td>
                                    <td>{{ $campaign->title }}</td>
                                    <td>
                                        @if($campaign->is_active)
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-danger">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td>{{ verta($campaign->start_date)->format('Y/m/d') }}</td>
                                    <td>{{ verta($campaign->end_date)->format('Y/m/d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('campaigns.submissions', $campaign) }}" 
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-list"></i> آثار
                                            </a>
                                            <form action="{{ route('campaigns.destroy', $campaign) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('آیا از حذف این پویش اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">هیچ پویشی یافت نشد.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 