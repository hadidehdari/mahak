@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">ویرایش فرزند</h3>
                    <a href="{{ route('admin.users.children.index', $user) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i>
                        بازگشت
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.children.update', [$user, $child]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">نام <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $child->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="birth_date">تاریخ تولد <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" name="birth_date" 
                                           value="{{ old('birth_date', $child->birth_date->format('Y-m-d')) }}" required>
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gender">جنسیت <span class="text-danger">*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="male" {{ old('gender', $child->gender) == 'male' ? 'selected' : '' }}>پسر</option>
                                        <option value="female" {{ old('gender', $child->gender) == 'female' ? 'selected' : '' }}>دختر</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="age_group">گروه سنی <span class="text-danger">*</span></label>
                                    <select class="form-control @error('age_group') is-invalid @enderror" 
                                            id="age_group" name="age_group" required>
                                        <option value="6_and_below" {{ old('age_group', $child->age_group) == '6_and_below' ? 'selected' : '' }}>
                                            6 سال و پایین‌تر
                                        </option>
                                        <option value="7_to_9" {{ old('age_group', $child->age_group) == '7_to_9' ? 'selected' : '' }}>
                                            7 تا 9 سال
                                        </option>
                                        <option value="10_to_12" {{ old('age_group', $child->age_group) == '10_to_12' ? 'selected' : '' }}>
                                            10 تا 12 سال
                                        </option>
                                    </select>
                                    @error('age_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="city">شهر <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $child->city) }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="profile_photo">تصویر پروفایل</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('profile_photo') is-invalid @enderror" 
                                               id="profile_photo" name="profile_photo" 
                                               value="{{ old('profile_photo', $child->profile_photo) }}" readonly>
                                        <button type="button" class="btn btn-primary" onclick="openMediaManager('profile_photo')">
                                            <i class="bi bi-image"></i>
                                            انتخاب تصویر
                                        </button>
                                    </div>
                                    @error('profile_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($child->profile_photo)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($child->profile_photo) }}" 
                                                 alt="تصویر پروفایل" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 150px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" 
                                       id="is_active" name="is_active" 
                                       {{ old('is_active', $child->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">فعال</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i>
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.media-manager.modal')

@endsection

@push('scripts')
<script>
function openMediaManager(inputId) {
    // اینجا کد مربوط به باز کردن مدال مدیریت فایل‌ها قرار می‌گیرد
    // و پس از انتخاب فایل، مقدار آن در input مربوطه قرار می‌گیرد
}
</script>
@endpush 