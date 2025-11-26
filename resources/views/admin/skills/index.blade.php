@extends('layouts.admin')

@section('title', 'المهارات')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-code"></i> المهارات</h1>
    <p>إدارة المهارات والتقنيات</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>قائمة المهارات</h2>
        <button onclick="document.getElementById('addSkillForm').style.display='block'" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة مهارة
        </button>
    </div>

    <div id="addSkillForm" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--light); border-radius: 8px;">
        <h3 style="margin-bottom: 1rem;">إضافة مهارة جديدة</h3>
        <form action="{{ route('admin.skills.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
                <div class="form-group">
                    <label>اسم المهارة (عربي) *</label>
                    <input type="text" name="name_ar" id="add_name_ar" required>
                </div>
                <div class="form-group">
                    <label>اسم المهارة (إنجليزي)</label>
                    <input type="text" name="name_en" placeholder="Skill Name (English)">
                </div>
                <div class="form-group">
                    <label>الأيقونة (Font Awesome)</label>
                    <input type="text" name="icon" id="add_icon" placeholder="سيتم تعيينها تلقائياً">
                    <small id="icon_preview_text" style="display: none; margin-top: 0.5rem; color: var(--text-light);">
                        معاينة: <i id="icon_preview" class=""></i>
                    </small>
                    <small style="display: block; margin-top: 0.5rem; color: var(--text-secondary);">
                        للأيقونات في فئة Backend و Frameworks، سيتم تعيينها تلقائياً عند الحفظ
                    </small>
                </div>
                <div class="form-group">
                    <label>النسبة المئوية *</label>
                    <input type="number" name="percentage" min="0" max="100" required>
                </div>
                <div class="form-group">
                    <label>الفئة *</label>
                    <select name="category" id="add_category" required>
                        <option value="backend">Backend</option>
                        <option value="frameworks">Frameworks</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>الترتيب</label>
                    <input type="number" name="order" min="0" value="0" placeholder="0">
                    <small>الترتيب يبدأ من 0 (تصاعدي)</small>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" onclick="document.getElementById('addSkillForm').style.display='none'" class="btn btn-secondary">إلغاء</button>
            </div>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>الاسم (عربي)</th>
                <th>الاسم (إنجليزي)</th>
                <th>الأيقونة</th>
                <th>النسبة</th>
                <th>الفئة</th>
                <th>الترتيب</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skills as $skill)
            <tr>
                <td>{{ $skill->name_ar }}</td>
                <td>{{ $skill->name_en ?? '-' }}</td>
                <td><i class="{{ $skill->icon ?? 'fas fa-code' }}"></i></td>
                <td>{{ $skill->percentage }}%</td>
                <td>
                    @if($skill->category == 'backend') Backend
                    @elseif($skill->category == 'frameworks') Frameworks
                    @else أخرى
                    @endif
                </td>
                <td>{{ $skill->order }}</td>
                <td>
                    <button onclick="editSkill({{ $skill->id }}, {{ json_encode($skill->name_ar) }}, {{ json_encode($skill->name_en ?? '') }}, {{ json_encode($skill->icon ?? '') }}, {{ $skill->percentage }}, {{ json_encode($skill->category) }}, {{ $skill->order }})" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; margin-left: 0.5rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem;">لا توجد مهارات</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Edit Skill Modal -->
    <div id="editSkillForm" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto;">
        <div style="position: relative; margin: 2rem auto; padding: 1.5rem; background: white; border-radius: 8px; width: 90%; max-width: 800px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">تعديل المهارة</h3>
            <form id="editSkillFormData" method="POST">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label>اسم المهارة (عربي) *</label>
                        <input type="text" name="name_ar" id="edit_name_ar" required>
                    </div>
                    <div class="form-group">
                        <label>اسم المهارة (إنجليزي)</label>
                        <input type="text" name="name_en" id="edit_name_en" placeholder="Skill Name (English)">
                    </div>
                    <div class="form-group">
                        <label>الأيقونة (Font Awesome)</label>
                        <input type="text" name="icon" id="edit_icon" placeholder="سيتم تعيينها تلقائياً">
                        <small id="edit_icon_preview_text" style="display: none; margin-top: 0.5rem; color: var(--text-light);">
                            معاينة: <i id="edit_icon_preview" class=""></i>
                        </small>
                        <small style="display: block; margin-top: 0.5rem; color: var(--text-secondary);">
                            للأيقونات في فئة Backend و Frameworks، سيتم تعيينها تلقائياً عند الحفظ
                        </small>
                    </div>
                    <div class="form-group">
                        <label>النسبة المئوية *</label>
                        <input type="number" name="percentage" id="edit_percentage" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label>الفئة *</label>
                        <select name="category" id="edit_category" required>
                            <option value="backend">Backend</option>
                            <option value="frameworks">Frameworks</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="order" id="edit_order" min="0" value="0" placeholder="0">
                        <small>الترتيب يبدأ من 0 (تصاعدي)</small>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <button type="button" onclick="closeEditSkill()" class="btn btn-secondary">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const skillIcons = @json($skillIcons ?? []);
        
        // دالة للبحث عن أيقونة تلقائياً
        function findIconForSkill(skillName, category) {
            if (category === 'other') return null;
            
            const skillLower = skillName.toLowerCase().trim();
            
            // البحث المباشر
            if (skillIcons[skillLower]) {
                return skillIcons[skillLower];
            }
            
            // البحث الجزئي
            for (const [key, icon] of Object.entries(skillIcons)) {
                if (skillLower.includes(key) || key.includes(skillLower)) {
                    return icon;
                }
            }
            
            return null;
        }
        
        // تحديث معاينة الأيقونة
        function updateIconPreview(inputId, previewId, previewTextId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const previewText = document.getElementById(previewTextId);
            
            if (input && preview && previewText) {
                const iconValue = input.value.trim();
                if (iconValue) {
                    preview.className = iconValue;
                    previewText.style.display = 'block';
                } else {
                    previewText.style.display = 'none';
                }
            }
        }
        
        // تحديث الأيقونة تلقائياً عند تغيير اسم المهارة
        function autoUpdateIcon(nameInputId, iconInputId, categorySelectId, previewId, previewTextId) {
            const nameInput = document.getElementById(nameInputId);
            const iconInput = document.getElementById(iconInputId);
            const categorySelect = document.getElementById(categorySelectId);
            
            if (nameInput && iconInput && categorySelect) {
                nameInput.addEventListener('blur', function() {
                    const category = categorySelect.value;
                    if ((category === 'backend' || category === 'frameworks') && !iconInput.value.trim()) {
                        const autoIcon = findIconForSkill(this.value, category);
                        if (autoIcon) {
                            iconInput.value = autoIcon;
                            updateIconPreview(iconInputId, previewId, previewTextId);
                        }
                    }
                });
            }
        }
        
        function editSkill(id, nameAr, nameEn, icon, percentage, category, order) {
            document.getElementById('editSkillFormData').action = '{{ url("admin/skills") }}/' + id;
            document.getElementById('edit_name_ar').value = nameAr;
            document.getElementById('edit_name_en').value = nameEn || '';
            document.getElementById('edit_icon').value = icon || '';
            document.getElementById('edit_percentage').value = percentage;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_order').value = order;
            
            // تحديث معاينة الأيقونة
            updateIconPreview('edit_icon', 'edit_icon_preview', 'edit_icon_preview_text');
            
            document.getElementById('editSkillForm').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeEditSkill() {
            document.getElementById('editSkillForm').style.display = 'none';
            document.body.style.overflow = '';
        }

        // Close edit form when clicking on overlay
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editSkillForm');
            if (editForm) {
                editForm.addEventListener('click', function(event) {
                    if (event.target === this) {
                        closeEditSkill();
                    }
                });
            }
            
            // تحديث معاينة الأيقونة عند الكتابة
            const addIconInput = document.getElementById('add_icon');
            if (addIconInput) {
                addIconInput.addEventListener('input', function() {
                    updateIconPreview('add_icon', 'icon_preview', 'icon_preview_text');
                });
            }
            
            const editIconInput = document.getElementById('edit_icon');
            if (editIconInput) {
                editIconInput.addEventListener('input', function() {
                    updateIconPreview('edit_icon', 'edit_icon_preview', 'edit_icon_preview_text');
                });
            }
            
            // تحديث الأيقونة تلقائياً عند تغيير اسم المهارة
            autoUpdateIcon('add_name_ar', 'add_icon', 'add_category', 'icon_preview', 'icon_preview_text');
            autoUpdateIcon('edit_name_ar', 'edit_icon', 'edit_category', 'edit_icon_preview', 'edit_icon_preview_text');
        });
    </script>
</div>
@endsection

