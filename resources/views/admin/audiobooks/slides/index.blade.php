@extends('layouts.app')

@section('title', 'مدیریت اسلایدهای ' . $audioBook->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">اسلایدهای {{ $audioBook->title }}</h3>
                    <div>
                        <a href="{{ route('admin.audiobooks.slides.create', $audioBook) }}"  class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i>
                            افزودن اسلاید
                        </a>
                        <a href="{{ route('admin.audiobooks.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-right"></i>
                            بازگشت
                        </a>
                    </div>
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
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
                                    <th>مدت زمان</th>
                                    <th>ترتیب</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach($slides as $slide)
                                    <tr data-id="{{ $slide->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($slide->image)
                                                <img src="{{ asset('storage/' . $slide->image) }}" 
                                                     alt="{{ $slide->title }}" 
                                                     style="width: 100px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-center" style="width: 100px; height: 60px; line-height: 60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $slide->title }}</td>
                                        <td>{{ Str::limit($slide->description, 50) }}</td>
                                        <td>{{ gmdate("H:i:s", $slide->duration) }}</td>
                                        <td>{{ $slide->order }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.audiobooks.slides.edit', [$audioBook, $slide]) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.audiobooks.slides.destroy', [$audioBook, $slide]) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('آیا از حذف این اسلاید اطمینان دارید؟')">
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
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(function() {
    $("#sortable").sortable({
        update: function(event, ui) {
            let slides = [];
            $("#sortable tr").each(function(index) {
                slides.push($(this).data('id'));
            });
            
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    slides: slides
                },
                success: function(response) {
                    toastr.success('ترتیب اسلایدها با موفقیت بروزرسانی شد.');
                },
                error: function() {
                    toastr.error('خطا در بروزرسانی ترتیب اسلایدها.');
                }
            });
        }
    });
});
</script>
@endpush
@endsection 