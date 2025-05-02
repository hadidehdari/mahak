@extends('layouts.app')

@section('title', 'مدیریت کتاب‌های صوتی')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">کتاب‌های صوتی</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.audiobooks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> افزودن کتاب صوتی جدید
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>دسته‌بندی</th>
                                    <th>خالق</th>
                                    <th>گروه سنی</th>
                                    <th>وضعیت</th>
                                    <th>اسلاید ساز</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($audioBooks as $audioBook)
                                    <tr>
                                        <td>
                                            <img src="{{ Str::startsWith($audioBook->cover_image, 'http') ? $audioBook->cover_image : asset('storage/' . $audioBook->cover_image) }}" 
                                                 alt="{{ $audioBook->title }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;">
                                        </td>
                                        <td>{{ $audioBook->title }}</td>
                                        <td>{{ $audioBook->category->name }}</td>
                                        <td>{{ $audioBook->creator->name }}</td>
                                        <td>{{ $audioBook->ageGroup->name }}</td>
                                        <td>
                                            @if($audioBook->is_active)
                                                <span class="badge badge-success">فعال</span>
                                            @else
                                                <span class="badge badge-danger">غیرفعال</span>
                                            @endif
                                            @if($audioBook->is_featured)
                                                <span class="badge badge-info">ویژه</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.audiobooks.slides.index', $audioBook) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-images"></i> مدیریت اسلایدها
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.audiobooks.edit', $audioBook) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.audiobooks.destroy', $audioBook) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('آیا از حذف این کتاب صوتی اطمینان دارید؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">هیچ کتاب صوتی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $audioBooks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 