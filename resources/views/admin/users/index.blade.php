@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">لیست کاربران</h3>
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
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>ایمیل</th>
                                    <th>شماره تماس</th>
                                    <th>تعداد کودکان</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->children_count }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">فعال</span>
                                            @else
                                                <span class="badge bg-danger">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.children.index',$user)}}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-people"></i>
                                                </a>
                                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                                                        <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">هیچ کاربری یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 