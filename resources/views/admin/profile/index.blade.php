@extends('layouts.admin')

@section('title', 'الملف الشخصي')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user"></i> الملف الشخصي</h1>
    <p>إدارة المعلومات الشخصية</p>
</div>

<div class="card">
    @if($profile)
        <div class="card-header">
            <h2>تعديل الملف الشخصي</h2>
            <a href="{{ route('admin.profile.edit', $profile) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> تعديل
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            @if($profile->photo)
                <div>
                    <img src="{{ Storage::url($profile->photo) }}" alt="Profile Photo" style="width: 100%; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                </div>
            @endif
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--dark);">{{ $profile->name_ar }}</h3>
                <p style="color: var(--text-light); margin-bottom: 1rem;">{{ $profile->title_ar }}</p>
                <p style="margin-bottom: 1rem;">{{ $profile->description_ar }}</p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1.5rem;">
                    <div>
                        <strong>البريد الإلكتروني:</strong><br>
                        {{ $profile->email }}
                    </div>
                    <div>
                        <strong>الهاتف:</strong><br>
                        {{ $profile->phone ?? 'غير محدد' }}
                    </div>
                    <div>
                        <strong>الموقع:</strong><br>
                        {{ $profile->location_ar ?? 'غير محدد' }}
                    </div>
                    <div>
                        <strong>الخبرة:</strong><br>
                        {{ $profile->experience_ar ?? 'غير محدد' }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 3rem;">
            <p style="color: var(--text-light); margin-bottom: 1.5rem;">لم يتم إنشاء ملف شخصي بعد</p>
            <a href="{{ route('admin.profile.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إنشاء ملف شخصي
            </a>
        </div>
    @endif
</div>
@endsection

