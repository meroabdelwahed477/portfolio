@extends('layouts.admin')

@section('title', 'إضافة مشروع')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-plus"></i> إضافة مشروع جديد</h1>
    <p>إنشاء مشروع جديد</p>
</div>

<div class="card">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div class="form-group">
                <label>العنوان (عربي) *</label>
                <input type="text" name="title_ar" value="{{ old('title_ar') }}" required>
            </div>

            <div class="form-group">
                <label>العنوان (إنجليزي)</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (عربي) *</label>
                <textarea name="description_ar" rows="4" required>{{ old('description_ar') }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (إنجليزي)</label>
                <textarea name="description_en" rows="4">{{ old('description_en') }}</textarea>
            </div>

            <div class="form-group">
                <label>الفئة *</label>
                <select name="category" required>
                    <option value="web">Web</option>
                    <option value="api-web">API Web</option>
                    <option value="api-mobile">API Mobile</option>
                </select>
            </div>

            <div class="form-group">
                <label>الرابط</label>
                <input type="url" name="link" value="{{ old('link') }}">
            </div>

            <div class="form-group">
                <label>صورة المشروع</label>
                <input type="file" name="thumbnail" accept="image/*">
            </div>

            <div class="form-group">
                <label>الترتيب</label>
                <input type="number" name="order" value="0">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> نشط
                </label>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>المميزات (عربي) - كل سطر يمثل ميزة</label>
                <textarea name="features_ar_text" rows="5" placeholder="ميزة 1&#10;ميزة 2&#10;ميزة 3">{{ old('features_ar_text') }}</textarea>
                <small>اكتب كل ميزة في سطر منفصل</small>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>المميزات (إنجليزي) - كل سطر يمثل ميزة</label>
                <textarea name="features_en_text" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3">{{ old('features_en_text') }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>التقنيات - مفصولة بفواصل</label>
                <input type="text" name="technologies_text" value="{{ old('technologies_text') }}" placeholder="PHP, Laravel, MySQL">
                <small>اكتب التقنيات مفصولة بفواصل</small>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>صور المشروع (يمكن اختيار أكثر من صورة)</label>
                <input type="file" name="images[]" accept="image/*" multiple>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ
            </button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> إلغاء
            </a>
        </div>
    </form>
</div>
@endsection

