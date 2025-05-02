@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">دسته‌بندی‌ها</h3>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        افزودن دسته‌بندی
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
                                    <th>پوستر</th>
                                    <th>نام</th>
                                    <th>نوع محتوا</th>
                                    <th>رنگ پس‌زمینه</th>
                                    <th>رنگ متن</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            @if($category->poster)
                                                <img src="{{ $category->poster_url }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-center" style="width: 50px; height: 50px; line-height: 50px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if($category->content_type === 'video')
                                                <span class="badge bg-primary">ویدیو</span>
                                            @else
                                                <span class="badge bg-success">کتاب صوتی</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-box me-2" style="width: 20px; height: 20px; background-color: {{ $category->background_color }}; border: 1px solid #ddd;"></div>
                                                {{ $category->background_color }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-box me-2" style="width: 20px; height: 20px; background-color: {{ $category->text_color }}; border: 1px solid #ddd;"></div>
                                                {{ $category->text_color }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 