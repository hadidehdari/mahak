@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">سازندگان/کارگردان‌ها</h3>
                    <a href="{{ route('admin.creators.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        افزودن سازنده/کارگردان
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
                                    <th>عکس</th>
                                    <th>نام</th>
                                    <th>توضیحات</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($creators as $creator)
                                    <tr>
                                        <td>
                                            @if($creator->photo)
                                                <img src="{{ $creator->photo_url }}" alt="{{ $creator->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-center" style="width: 50px; height: 50px; line-height: 50px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $creator->name }}</td>
                                        <td>{{ Str::limit($creator->description, 100) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.creators.edit', $creator) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.creators.destroy', $creator) }}" method="POST" class="d-inline">
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
                        {{ $creators->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 