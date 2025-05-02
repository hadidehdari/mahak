@extends('layouts.app')

@section('title', 'صفحات ثابت')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">صفحات ثابت</h3>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        افزودن صفحه
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>مسیر</th>
                                    <th>نام مسیر</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pages as $page)
                                    <tr>
                                        <td>{{ $page->title }}</td>
                                        <td>{{ $page->route_path }}</td>
                                        <td>{{ $page->route_name }}</td>
                                        <td>
                                            @if($page->is_active)
                                                <span class="badge badge-success">فعال</span>
                                            @else
                                                <span class="badge badge-danger">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pages.edit', $page) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.pages.destroy', $page) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('آیا از حذف این صفحه اطمینان دارید؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">هیچ صفحه‌ای یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $pages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 