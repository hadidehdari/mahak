@extends('layouts.app')

@section('title', 'آثار ارسالی به پویش ' . $campaign->title)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">آثار ارسالی به پویش {{ $campaign->title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('campaigns.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-right"></i> بازگشت به لیست پویش‌ها
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($submissions->isEmpty())
                            <div class="alert alert-info">
                                هیچ اثری برای این پویش ارسال نشده است.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نام کاربر</th>
                                            <th>عنوان اثر</th>
                                            <th>توضیحات</th>
                                            <th>فایل</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($submissions as $submission)
                                            <tr>
                                                <td>{{ $submission->id }}</td>
                                                <td>{{ $submission->user->name }}</td>
                                                <td>{{ $submission->title }}</td>
                                                <td>{{ Str::limit($submission->description, 50) }}</td>
                                                <td>
                                                    @if($submission->file)
                                                        <a href="{{ Storage::url($submission->file) }}" target="_blank" class="btn btn-sm btn-info">
                                                            مشاهده فایل
                                                        </a>
                                                    @else
                                                        <span class="text-muted">بدون فایل</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('campaign-submissions.toggle-winner', $submission) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm {{ $submission->is_winner ? 'btn-success' : 'btn-secondary' }}">
                                                            {{ $submission->is_winner ? 'برنده' : 'غیر برنده' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#submissionModal{{ $submission->id }}">
                                                        جزئیات
                                                    </button>
                                                    <form action="{{ route('campaign-submissions.destroy', $submission) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این اثر اطمینان دارید؟')">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="submissionModal{{ $submission->id }}" tabindex="-1" role="dialog" aria-labelledby="submissionModalLabel{{ $submission->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="submissionModalLabel{{ $submission->id }}">جزئیات اثر</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>نام کاربر:</strong> {{ $submission->user->name }}</p>
                                                                    <p><strong>عنوان اثر:</strong> {{ $submission->title }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>تاریخ ارسال:</strong> {{ $submission->created_at->format('Y/m/d H:i') }}</p>
                                                                    <p><strong>وضعیت:</strong> {{ $submission->is_winner ? 'برنده' : 'غیر برنده' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <p><strong>توضیحات:</strong></p>
                                                                    <p>{{ $submission->description }}</p>
                                                                </div>
                                                            </div>
                                                            @if($submission->file)
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <p><strong>فایل:</strong></p>
                                                                        <a href="{{ Storage::url($submission->file) }}" target="_blank" class="btn btn-info">
                                                                            مشاهده فایل
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $submissions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 