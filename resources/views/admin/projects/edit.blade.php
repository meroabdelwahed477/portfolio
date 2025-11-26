@extends('layouts.admin')

@section('title', 'تعديل المشروع')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit"></i> تعديل المشروع</h1>
    <p>تحديث معلومات المشروع</p>
</div>

<div class="card">
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div class="form-group">
                <label>العنوان (عربي) *</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $project->title_ar) }}" required>
            </div>

            <div class="form-group">
                <label>العنوان (إنجليزي)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $project->title_en) }}">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (عربي) *</label>
                <textarea name="description_ar" rows="4" required>{{ old('description_ar', $project->description_ar) }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (إنجليزي)</label>
                <textarea name="description_en" rows="4">{{ old('description_en', $project->description_en) }}</textarea>
            </div>

            <div class="form-group">
                <label>الفئة *</label>
                <select name="category" required>
                    <option value="web" {{ $project->category == 'web' ? 'selected' : '' }}>Web</option>
                    <option value="api-web" {{ $project->category == 'api-web' ? 'selected' : '' }}>API Web</option>
                    <option value="api-mobile" {{ $project->category == 'api-mobile' ? 'selected' : '' }}>API Mobile</option>
                </select>
            </div>

            <div class="form-group">
                <label>الرابط</label>
                <input type="url" name="link" value="{{ old('link', $project->link) }}">
            </div>

            <div class="form-group">
                <label>صورة المشروع</label>
                <input type="file" name="thumbnail" accept="image/*">
                @if($project->thumbnail)
                    <div style="margin-top: 0.5rem;">
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="Thumbnail" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>الترتيب</label>
                <input type="number" name="order" value="{{ old('order', $project->order) }}">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ $project->is_active ? 'checked' : '' }}> نشط
                </label>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>المميزات (عربي) - كل سطر يمثل ميزة</label>
                <textarea name="features_ar_text" rows="5">{{ old('features_ar_text', $project->features_ar ? implode("\n", $project->features_ar) : '') }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>المميزات (إنجليزي) - كل سطر يمثل ميزة</label>
                <textarea name="features_en_text" rows="5">{{ old('features_en_text', $project->features_en ? implode("\n", $project->features_en) : '') }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>التقنيات - مفصولة بفواصل</label>
                <input type="text" name="technologies_text" value="{{ old('technologies_text', $project->technologies ? implode(', ', $project->technologies) : '') }}" placeholder="PHP, Laravel, MySQL">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>صور المشروع الإضافية (يمكن اختيار أكثر من صورة)</label>
                <input type="file" name="images[]" accept="image/*" multiple>
                @if($project->images->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
                        @foreach($project->images as $image)
                            <div style="position: relative;">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Project Image" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px;">
                                <form action="{{ route('admin.projects.images.destroy', $image) }}" method="POST" style="position: absolute; top: 5px; left: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="return confirm('حذف هذه الصورة؟');">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
