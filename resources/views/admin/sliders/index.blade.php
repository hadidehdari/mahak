@extends('layouts.app')

@section('title', 'مدیریت اسلایدر')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مدیریت اسلایدر</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> افزودن اسلایدر جدید
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
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>لینک</th>
                                    <th>ترتیب</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $slider->image) }}" 
                                                 alt="{{ $slider->title }}" 
                                                 style="max-width: 100px; max-height: 100px;">
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            @if($slider->link)
                                                <a href="{{ $slider->link }}" target="_blank">
                                                    {{ $slider->link }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $slider->order }}</td>
                                        <td>
                                            @if($slider->is_active)
                                                <span class="badge badge-success">فعال</span>
                                            @else
                                                <span class="badge badge-danger">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('آیا از حذف این اسلایدر اطمینان دارید؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
@endsection 