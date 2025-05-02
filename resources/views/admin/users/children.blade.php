@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">فرزندان {{ $user->name }}</h3>
                    <div>
                        <a href="{{ route('admin.users.children.create', $user) }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i>
                            افزودن فرزند
                        </a>
                        <a href="{{ route('admin.users.index', $user) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-right"></i>
                            بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>سن</th>
                                    <th>جنسیت</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($children as $child)
                                    <tr>
                                        <td>{{ $child->id }}</td>
                                        <td>{{ $child->name }}</td>
                                        <td>{{ $child->age }}</td>
                                        <td>{{ $child->gender == 'male' ? 'پسر' : 'دختر' }}</td>
                                        <td>
                                            @if($child->is_active)
                                                <span class="badge bg-success">فعال</span>
                                            @else
                                                <span class="badge bg-danger">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.children.index', [$user, $child]) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.children.edit', [$user, $child]) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.users.children.destroy', [$user, $child]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این فرزند اطمینان دارید؟')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">هیچ فرزندی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $children->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 