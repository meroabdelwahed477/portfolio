@extends('layouts.admin')

@section('title', 'تفاصيل المشروع')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-eye"></i> تفاصيل المشروع</h1>
    <p>عرض معلومات المشروع</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ $project->title_ar }}</h2>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        @if($project->thumbnail)
            <div>
                <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title_ar }}" style="width: 100%; border-radius: 12px;">
            </div>
        @endif
        <div>
            <h3 style="margin-bottom: 1rem;">{{ $project->title_ar }}</h3>
            <p style="margin-bottom: 1rem;">{{ $project->description_ar }}</p>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1.5rem;">
                <div>
                    <strong>الفئة:</strong><br>
                    @if($project->category == 'web') Web
                    @elseif($project->category == 'api-web') API Web
                    @else API Mobile
                    @endif
                </div>
                <div>
                    <strong>الحالة:</strong><br>
                    {{ $project->is_active ? 'نشط' : 'غير نشط' }}
                </div>
                @if($project->link)
                <div>
                    <strong>الرابط:</strong><br>
                    <a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($project->images->count() > 0)
    <div style="margin-top: 2rem;">
        <h3 style="margin-bottom: 1rem;">صور المشروع</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($project->images as $image)
                <div>
                    <img src="{{ Storage::url($image->image_path) }}" alt="Project Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
