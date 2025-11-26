@extends('layouts.admin')

@section('title', 'تعديل الخبرة العملية')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit"></i> تعديل الخبرة العملية</h1>
    <p>تحديث معلومات الخبرة العملية</p>
</div>

<div class="card">
    <form action="{{ route('admin.work-experiences.update', $workExperience) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div class="form-group">
                <label>اسم الشركة (عربي) *</label>
                <input type="text" name="company_name_ar" value="{{ old('company_name_ar', $workExperience->company_name_ar) }}" required>
            </div>

            <div class="form-group">
                <label>اسم الشركة (إنجليزي)</label>
                <input type="text" name="company_name_en" value="{{ old('company_name_en', $workExperience->company_name_en) }}">
            </div>

            <div class="form-group">
                <label>المنصب (عربي) *</label>
                <input type="text" name="position_ar" value="{{ old('position_ar', $workExperience->position_ar) }}" required>
            </div>

            <div class="form-group">
                <label>المنصب (إنجليزي)</label>
                <input type="text" name="position_en" value="{{ old('position_en', $workExperience->position_en) }}">
            </div>

            <div class="form-group">
                <label>نوع المنصب *</label>
                <select name="type" id="type" required onchange="toggleExperienceLetter()">
                    <option value="job" {{ old('type', $workExperience->type) == 'job' ? 'selected' : '' }}>عمل</option>
                    <option value="internship" {{ old('type', $workExperience->type) == 'internship' ? 'selected' : '' }}>تدريب</option>
                </select>
            </div>

            <div class="form-group" id="experience_letter_group" style="grid-column: 1 / -1; {{ old('type', $workExperience->type) == 'job' ? 'display: block;' : 'display: none;' }}">
                <label>خطاب الخبرة (PDF) <small style="color: var(--text-light);">(فقط للخبرات من نوع 'عمل')</small></label>
                @if($workExperience->experience_letter)
                    <div style="margin-bottom: 0.5rem; padding: 0.75rem; background: var(--light); border-radius: 6px;">
                        <a href="{{ Storage::url($workExperience->experience_letter) }}" target="_blank" style="color: var(--primary-color); text-decoration: none;">
                            <i class="fas fa-file-pdf"></i> عرض الملف الحالي
                        </a>
                    </div>
                    <small style="color: var(--text-light); display: block; margin-bottom: 0.5rem;">للتغيير: اختر ملف جديد</small>
                @endif
                <input type="file" name="experience_letter" accept=".pdf,application/pdf">
                <small style="color: var(--text-light); display: block; margin-top: 0.5rem;">الحد الأقصى لحجم الملف: 10MB</small>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (عربي)</label>
                <textarea name="description_ar" rows="4">{{ old('description_ar', $workExperience->description_ar) }}</textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>الوصف (إنجليزي)</label>
                <textarea name="description_en" rows="4">{{ old('description_en', $workExperience->description_en) }}</textarea>
            </div>

            <div class="form-group">
                <label>تاريخ البدء *</label>
                <input type="date" name="start_date" value="{{ old('start_date', $workExperience->start_date->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label>تاريخ الانتهاء</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $workExperience->end_date ? $workExperience->end_date->format('Y-m-d') : '') }}">
                <small>اتركه فارغاً إذا كانت الوظيفة الحالية</small>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_current" value="1" id="is_current" {{ $workExperience->is_current ? 'checked' : '' }} onchange="toggleEndDate()"> وظيفة حالية
                </label>
            </div>

            <div class="form-group">
                <label>الترتيب</label>
                <input type="number" name="order" value="{{ old('order', $workExperience->order) }}">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ $workExperience->is_active ? 'checked' : '' }}> نشط
                </label>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.work-experiences.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> إلغاء
            </a>
        </div>
    </form>
</div>

<script>
function toggleEndDate() {
    const isCurrent = document.getElementById('is_current').checked;
    const endDateInput = document.getElementById('end_date');
    if (isCurrent) {
        endDateInput.disabled = true;
        endDateInput.value = '';
    } else {
        endDateInput.disabled = false;
    }
}

function toggleExperienceLetter() {
    const type = document.getElementById('type').value;
    const experienceLetterGroup = document.getElementById('experience_letter_group');
    if (type === 'job') {
        experienceLetterGroup.style.display = 'block';
    } else {
        experienceLetterGroup.style.display = 'none';
        // Clear file input when hidden
        const fileInput = experienceLetterGroup.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.value = '';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleEndDate();
    toggleExperienceLetter();
});
</script>
@endsection

