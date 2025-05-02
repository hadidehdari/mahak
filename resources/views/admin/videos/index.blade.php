@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">ویدیوها</h3>
                    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        افزودن ویدیو
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
                                    <th>تصویر بندانگشتی</th>
                                    <th>عنوان</th>
                                    <th>دسته‌بندی</th>
                                    <th>سازنده</th>
                                    <th>گروه سنی</th>
                                    <th>مدت زمان</th>
                                    <th>وضعیت</th>
                                    <th>نمایش فیلم</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $video)
                                    <tr>
                                        <td>
                                            @if($video->thumbnail)
                                                <img src="{{ Str::startsWith($video->thumbnail, 'http') ? $video->thumbnail : asset('storage/' . $video->thumbnail) }}" 
                                                     alt="{{ $video->title }}" 
                                                     style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <div class="bg-light text-center" style="width: 100px; height: 60px; line-height: 60px; border-radius: 5px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $video->title }}</td>
                                        <td>{{ $video->category->name }}</td>
                                        <td>{{ $video->creator ? $video->creator->name : '-' }}</td>
                                        <td>{{ $video->ageGroup->name }}</td>
                                        <td>{{ gmdate("H:i:s", $video->duration) }}</td>
                                        <td>
                                            @if($video->is_active)
                                                <span class="badge bg-success">فعال</span>
                                            @else
                                                <span class="badge bg-danger">غیرفعال</span>
                                            @endif
                                            @if($video->is_featured)
                                                <span class="badge bg-warning">ویژه</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                                <i class="bi bi-play-circle"></i>
                                                نمایش
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="d-inline">
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
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal برای نمایش فیلم -->
@foreach($videos as $video)
<div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $video->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel{{ $video->id }}">{{ $video->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $video->video_url }}" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection 