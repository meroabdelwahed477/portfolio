@extends('layouts.admin')

@section('title', 'الشهادات')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-certificate"></i> الشهادات</h1>
    <p>إدارة الشهادات</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>قائمة الشهادات</h2>
        <button onclick="document.getElementById('addCertForm').style.display='block'" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة شهادة
        </button>
    </div>

    <div id="addCertForm" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--light); border-radius: 8px;">
        <h3 style="margin-bottom: 1rem;">إضافة شهادة جديدة</h3>
        <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div class="form-group">
                    <label>العنوان (عربي) *</label>
                    <input type="text" name="title_ar" required>
                </div>
                <div class="form-group">
                    <label>العنوان (إنجليزي)</label>
                    <input type="text" name="title_en">
                </div>
                <div class="form-group">
                    <label>صورة الشهادة *</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>ملف PDF</label>
                    <input type="file" name="pdf_file" accept=".pdf">
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
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" onclick="document.getElementById('addCertForm').style.display='none'" class="btn btn-secondary">إلغاء</button>
            </div>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($certificates as $certificate)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @if($certificate->image)
                <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title_ar }}" style="width: 100%; height: 200px; object-fit: cover;">
            @endif
            <div style="padding: 1rem;">
                <h3 style="margin-bottom: 0.5rem;">{{ $certificate->title_ar }}</h3>
                <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                    <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-light);">
            لا توجد شهادات
        </div>
        @endforelse
    </div>
</div>
@endsection

