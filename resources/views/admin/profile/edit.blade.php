@extends('layouts.admin')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user"></i> تعديل الملف الشخصي</h1>
    <p>تحديث المعلومات الشخصية</p>
</div>

<div class="card">
    <form action="{{ route('admin.profile.update', $profile) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div class="form-group">
                <label>الاسم (عربي) *</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $profile->name_ar) }}" required>
                @error('name_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الاسم (إنجليزي)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $profile->name_en) }}">
                @error('name_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>اللقب (عربي) *</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $profile->title_ar) }}" required>
                @error('title_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>اللقب (إنجليزي)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $profile->title_en) }}">
                @error('title_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (عربي) *</label>
                <textarea name="description_ar" rows="4" required>{{ old('description_ar', $profile->description_ar) }}</textarea>
                @error('description_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (إنجليزي)</label>
                <textarea name="description_en" rows="4">{{ old('description_en', $profile->description_en) }}</textarea>
                @error('description_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>البريد الإلكتروني *</label>
                <input type="email" name="email" value="{{ old('email', $profile->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الموقع (عربي)</label>
                <input type="text" name="location_ar" value="{{ old('location_ar', $profile->location_ar) }}">
                @error('location_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الموقع (إنجليزي)</label>
                <input type="text" name="location_en" value="{{ old('location_en', $profile->location_en) }}">
                @error('location_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الخبرة (عربي)</label>
                <input type="text" name="experience_ar" value="{{ old('experience_ar', $profile->experience_ar) }}">
                @error('experience_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الخبرة (إنجليزي)</label>
                <input type="text" name="experience_en" value="{{ old('experience_en', $profile->experience_en) }}">
                @error('experience_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>التوفر (عربي)</label>
                <input type="text" name="availability_ar" value="{{ old('availability_ar', $profile->availability_ar) }}">
                @error('availability_ar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>التوفر (إنجليزي)</label>
                <input type="text" name="availability_en" value="{{ old('availability_en', $profile->availability_en) }}">
                @error('availability_en')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الصورة الشخصية</label>
                <input type="file" name="photo" accept="image/*">
                <small>الصيغ المدعومة: JPEG, PNG, JPG, GIF (حد أقصى 2MB)</small>
                @if($profile->photo)
                    <div style="margin-top: 0.5rem;">
                        <img src="{{ Storage::url($profile->photo) }}" alt="Current Photo" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
                @error('photo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>ملف السيرة الذاتية (PDF)</label>
                <input type="file" name="cv_file" accept=".pdf">
                <small>صيغة PDF فقط (حد أقصى 5MB)</small>
                @if($profile->cv_file)
                    <div style="margin-top: 0.5rem;">
                        <a href="{{ Storage::url($profile->cv_file) }}" target="_blank" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                            <i class="fas fa-file-pdf"></i> عرض السيرة الذاتية
                        </a>
                    </div>
                @endif
                @error('cv_file')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> إلغاء
            </a>
        </div>
    </form>
</div>
@endsection

