@extends('layouts.admin')

@section('title', 'روابط التواصل')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-share-alt"></i> روابط التواصل</h1>
    <p>إدارة روابط التواصل الاجتماعي</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>قائمة الروابط</h2>
        <button onclick="document.getElementById('addLinkForm').style.display='block'" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة رابط
        </button>
    </div>

    <div id="addLinkForm" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--light); border-radius: 8px;">
        <h3 style="margin-bottom: 1rem;">إضافة رابط جديد</h3>
        <form action="{{ route('admin.social-links.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div class="form-group">
                    <label>المنصة *</label>
                    <select name="platform" id="add_platform" required>
                        <option value="">اختر المنصة</option>
                        @foreach($allowedPlatforms as $key => $platform)
                            <option value="{{ $key }}" data-icon="{{ $platform['icon'] }}">
                                {{ $platform['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <small>الأيقونة ستُضبط تلقائياً حسب المنصة المختارة</small>
                </div>
                <div class="form-group">
                    <label id="add_url_label">الرابط (URL) *</label>
                    <input type="url" name="url" id="add_url" placeholder="https://..." required>
                    <small id="add_url_hint"></small>
                </div>
                <div class="form-group">
                    <label>الأيقونة</label>
                    <div style="padding: 0.75rem; background: white; border: 2px solid var(--border); border-radius: 8px; text-align: center;">
                        <i id="add_icon_preview" class="fas fa-link" style="font-size: 1.5rem; color: var(--text-light);"></i>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: var(--text-light);">سيتم تعيين الأيقونة تلقائياً</p>
                    </div>
                </div>
                <div class="form-group">
                    <label>الترتيب</label>
                    <input type="number" name="order" value="0" min="0">
                    <small>الترتيب يبدأ من 0 (تصاعدي)</small>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked> نشط
                    </label>
                    <small>إذا كان غير نشط، لن يظهر في البرتوفوليو</small>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" onclick="document.getElementById('addLinkForm').style.display='none'" class="btn btn-secondary">إلغاء</button>
            </div>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>المنصة</th>
                <th>الرابط</th>
                <th>الأيقونة</th>
                <th>الترتيب</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($socialLinks as $link)
            <tr>
                <td>
                    @if(isset($allowedPlatforms[$link->platform]))
                        {{ $allowedPlatforms[$link->platform]['name'] }}
                    @else
                        {{ $link->platform }}
                    @endif
                </td>
                <td><a href="{{ $link->url }}" target="_blank">{{ Str::limit($link->url, 40) }}</a></td>
                <td><i class="{{ $link->icon ?? 'fas fa-link' }}" style="font-size: 1.5rem;"></i></td>
                <td>{{ $link->order }}</td>
                <td>
                    @if($link->is_active)
                        <span class="badge badge-success">نشط</span>
                    @else
                        <span class="badge badge-danger">غير نشط</span>
                    @endif
                </td>
                <td>
                    <button onclick="editLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', {{ $link->order }}, {{ $link->is_active ? 'true' : 'false' }})" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; margin-left: 0.5rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
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
                <td colspan="6" style="text-align: center; padding: 2rem;">لا توجد روابط</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Edit Link Modal -->
    <div id="editLinkForm" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto;">
        <div style="position: relative; margin: 2rem auto; padding: 1.5rem; background: white; border-radius: 8px; width: 90%; max-width: 600px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">تعديل الرابط</h3>
            <form id="editLinkFormData" method="POST">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label>المنصة *</label>
                        <select name="platform" id="edit_platform" required>
                            <option value="">اختر المنصة</option>
                            @foreach($allowedPlatforms as $key => $platform)
                                <option value="{{ $key }}" data-icon="{{ $platform['icon'] }}">
                                    {{ $platform['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group">
                    <label id="edit_url_label">الرابط (URL) *</label>
                    <input type="url" name="url" id="edit_url" placeholder="https://..." required>
                    <small id="edit_url_hint"></small>
                </div>
                    <div class="form-group">
                        <label>الأيقونة</label>
                        <div style="padding: 0.75rem; background: var(--light); border: 2px solid var(--border); border-radius: 8px; text-align: center;">
                            <i id="edit_icon_preview" class="fas fa-link" style="font-size: 1.5rem; color: var(--text-light);"></i>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: var(--text-light);">سيتم تحديث الأيقونة تلقائياً</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="order" id="edit_order" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"> نشط
                        </label>
                        <small>إذا كان غير نشط، لن يظهر في البرتوفوليو</small>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <button type="button" onclick="closeEditLink()" class="btn btn-secondary">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const allowedPlatforms = @json($allowedPlatforms);
        const urlHints = {
            'linkedin': 'مثال: https://www.linkedin.com/in/your-profile',
            'facebook': 'مثال: https://www.facebook.com/your-profile',
            'gmail': 'مثال: your.email@gmail.com (سيتم إضافة mailto: تلقائياً)',
            'github': 'مثال: https://github.com/your-username',
            'whatsapp': 'مثال: +201234567890 (سيتم إنشاء رابط WhatsApp تلقائياً)'
        };

        function updateIconPreview(formType) {
            const platformSelect = document.getElementById(formType + '_platform');
            const iconPreview = document.getElementById(formType + '_icon_preview');
            const urlHint = document.getElementById(formType + '_url_hint');
            const urlInput = document.getElementById(formType + '_url');
            const urlLabel = document.getElementById(formType + '_url_label');
            
            if (platformSelect && iconPreview) {
                const selectedOption = platformSelect.options[platformSelect.selectedIndex];
                const icon = selectedOption.getAttribute('data-icon');
                const platform = platformSelect.value;
                
                if (icon) {
                    iconPreview.className = icon;
                    iconPreview.style.color = 'var(--primary)';
                } else {
                    iconPreview.className = 'fas fa-link';
                    iconPreview.style.color = 'var(--text-light)';
                }
                
                // Update input type and placeholder based on platform
                if (urlInput && urlLabel) {
                    if (platform === 'gmail') {
                        urlInput.type = 'email';
                        urlInput.placeholder = 'your.email@gmail.com';
                        urlLabel.textContent = 'البريد الإلكتروني *';
                        // Remove mailto: if present
                        if (urlInput.value.startsWith('mailto:')) {
                            urlInput.value = urlInput.value.replace('mailto:', '');
                        }
                    } else if (platform === 'whatsapp') {
                        urlInput.type = 'tel';
                        urlInput.placeholder = '+201234567890';
                        urlLabel.textContent = 'رقم الهاتف *';
                        // Remove WhatsApp link if present
                        if (urlInput.value.startsWith('https://wa.me/')) {
                            urlInput.value = urlInput.value.replace('https://wa.me/', '');
                        }
                    } else {
                        urlInput.type = 'url';
                        urlInput.placeholder = 'https://...';
                        urlLabel.textContent = 'الرابط (URL) *';
                    }
                }
            }
            
            if (urlHint && platformSelect.value) {
                urlHint.textContent = urlHints[platformSelect.value] || '';
                urlHint.style.display = 'block';
            } else if (urlHint) {
                urlHint.style.display = 'none';
            }
        }
        
        // Update form when platform changes for add form
        document.addEventListener('DOMContentLoaded', function() {
            const addPlatform = document.getElementById('add_platform');
            if (addPlatform) {
                addPlatform.addEventListener('change', function() {
                    updateIconPreview('add');
                });
            }
            
            const editPlatform = document.getElementById('edit_platform');
            if (editPlatform) {
                editPlatform.addEventListener('change', function() {
                    updateIconPreview('edit');
                });
            }
        });

        function editLink(id, platform, url, order, isActive) {
            const editForm = document.getElementById('editLinkFormData');
            const platformSelect = document.getElementById('edit_platform');
            const urlInput = document.getElementById('edit_url');
            const orderInput = document.getElementById('edit_order');
            const isActiveCheckbox = document.getElementById('edit_is_active');
            
            editForm.action = '{{ url("admin/social-links") }}/' + id;
            platformSelect.value = platform;
            
            // For Gmail, remove mailto: prefix for editing
            if (platform === 'gmail' && url.startsWith('mailto:')) {
                urlInput.value = url.replace('mailto:', '');
            } else if (platform === 'whatsapp' && url.startsWith('https://wa.me/')) {
                // For WhatsApp, extract phone number from URL
                urlInput.value = url.replace('https://wa.me/', '');
            } else {
                urlInput.value = url;
            }
            
            orderInput.value = order;
            isActiveCheckbox.checked = isActive === 'true' || isActive === true || isActive === 1;
            if (isActiveCheckbox.checked) {
                isActiveCheckbox.setAttribute('checked', 'checked');
            } else {
                isActiveCheckbox.removeAttribute('checked');
            }
            
            // Trigger change event to update icon preview and input type
            setTimeout(() => {
                platformSelect.dispatchEvent(new Event('change'));
            }, 50);
            
            document.getElementById('editLinkForm').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeEditLink() {
            document.getElementById('editLinkForm').style.display = 'none';
            document.body.style.overflow = '';
        }

        // Close edit form when clicking on overlay
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editLinkForm');
            if (editForm) {
                editForm.addEventListener('click', function(event) {
                    if (event.target === this) {
                        closeEditLink();
                    }
                });
            }
        });
    </script>
</div>
@endsection

