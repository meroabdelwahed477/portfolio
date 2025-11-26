@extends('layouts.admin')

@section('title', 'الإعدادات')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-cog"></i> الإعدادات</h1>
    <p>إعدادات الموقع والثيمات</p>
</div>

<div class="card">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <h2 style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid var(--border);">
            <i class="fas fa-palette"></i> إعدادات الثيم
        </h2>

        <div class="form-group">
            <label>الثيم *</label>
            <select name="theme" required>
                <option value="light" {{ $theme == 'light' ? 'selected' : '' }}>فاتح (Light)</option>
                <option value="dark" {{ $theme == 'dark' ? 'selected' : '' }}>داكن (Dark)</option>
                <option value="blue" {{ $theme == 'blue' ? 'selected' : '' }}>أزرق (Blue)</option>
                <option value="green" {{ $theme == 'green' ? 'selected' : '' }}>أخضر (Green)</option>
                <option value="purple" {{ $theme == 'purple' ? 'selected' : '' }}>بنفسجي (Purple)</option>
            </select>
            <small>اختر الثيم الذي سيظهر في الموقع</small>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-top: 1.5rem;">
            <div class="form-group">
                <label>اللون الأساسي *</label>
                <input type="color" name="primary_color" value="{{ $primaryColor }}" required>
                <small>اللون الأساسي للثيم</small>
            </div>

            <div class="form-group">
                <label>اللون الثانوي *</label>
                <input type="color" name="secondary_color" value="{{ $secondaryColor }}" required>
                <small>اللون الثانوي للثيم</small>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection
