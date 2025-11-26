@extends('layouts.admin')

@section('title', 'الخبرات العملية')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-briefcase"></i> الخبرات العملية</h1>
    <p>إدارة الخبرات العملية السابقة</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>قائمة الخبرات العملية</h2>
        <button onclick="document.getElementById('addExpForm').style.display='block'" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة خبرة عمل
        </button>
    </div>

    <div id="addExpForm" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--light); border-radius: 8px;">
        <h3 style="margin-bottom: 1rem;">إضافة خبرة عمل جديدة</h3>
        <form action="{{ route('admin.work-experiences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div class="form-group">
                    <label>اسم الشركة (عربي) *</label>
                    <input type="text" name="company_name_ar" required>
                </div>
                <div class="form-group">
                    <label>اسم الشركة (إنجليزي)</label>
                    <input type="text" name="company_name_en">
                </div>
                <div class="form-group">
                    <label>المنصب (عربي) *</label>
                    <input type="text" name="position_ar" required>
                </div>
                <div class="form-group">
                    <label>المنصب (إنجليزي)</label>
                    <input type="text" name="position_en">
                </div>
                <div class="form-group">
                    <label>نوع المنصب *</label>
                    <select name="type" id="type" required onchange="toggleExperienceLetter()">
                        <option value="job">عمل</option>
                        <option value="internship">تدريب</option>
                    </select>
                </div>
                <div class="form-group" id="experience_letter_group" style="grid-column: 1 / -1; display: block;">
                    <label>خطاب الخبرة (PDF) <small style="color: var(--text-light);">(فقط للخبرات من نوع 'عمل')</small></label>
                    <input type="file" name="experience_letter" accept=".pdf,application/pdf">
                    <small style="color: var(--text-light);">الحد الأقصى لحجم الملف: 10MB</small>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>الوصف (عربي)</label>
                    <textarea name="description_ar" rows="3"></textarea>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>الوصف (إنجليزي)</label>
                    <textarea name="description_en" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>تاريخ البدء *</label>
                    <input type="date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label>تاريخ الانتهاء</label>
                    <input type="date" name="end_date" id="end_date">
                    <small>اتركه فارغاً إذا كانت الوظيفة الحالية</small>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_current" value="1" id="is_current" onchange="toggleEndDate()"> وظيفة حالية
                    </label>
                </div>
                <div class="form-group">
                    <label>الترتيب</label>
                    <input type="number" name="order" value="0">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked> نشط
                    </label>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" onclick="document.getElementById('addExpForm').style.display='none'" class="btn btn-secondary">إلغاء</button>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>الشركة</th>
                    <th>المنصب</th>
                    <th>النوع</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workExperiences as $experience)
                <tr>
                    <td>
                        <strong>{{ $experience->company_name_ar }}</strong>
                        @if($experience->company_name_en)
                            <br><small style="color: var(--text-light);">{{ $experience->company_name_en }}</small>
                        @endif
                    </td>
                    <td>
                        {{ $experience->position_ar }}
                        @if($experience->position_en)
                            <br><small style="color: var(--text-light);">{{ $experience->position_en }}</small>
                        @endif
                    </td>
                    <td>
                        @if($experience->type == 'job')
                            <span class="badge badge-primary">عمل</span>
                        @else
                            <span class="badge badge-success">تدريب</span>
                        @endif
                    </td>
                    <td>{{ $experience->start_date->format('Y-m') }}</td>
                    <td>
                        @if($experience->is_current)
                            <span class="badge badge-primary">حالياً</span>
                        @elseif($experience->end_date)
                            {{ $experience->end_date->format('Y-m') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $experience->order }}</td>
                    <td>
                        @if($experience->is_active)
                            <span class="badge badge-success">نشط</span>
                        @else
                            <span class="badge badge-danger">غير نشط</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.work-experiences.edit', $experience) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <form action="{{ route('admin.work-experiences.destroy', $experience) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-light);">
                        لا توجد خبرات عمل
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
    toggleExperienceLetter();
});
</script>
@endsection

