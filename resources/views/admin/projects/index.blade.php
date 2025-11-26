@extends('layouts.admin')

@section('title', 'المشاريع')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-project-diagram"></i> المشاريع</h1>
    <p>إدارة المشاريع</p>
</div>

<div class="card">
    <div class="card-header">
        <h2>قائمة المشاريع</h2>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة مشروع جديد
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>العنوان</th>
                <th>الفئة</th>
                <th>الحالة</th>
                <th>الترتيب</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title_ar }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div style="width: 80px; height: 60px; background: var(--light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-light);">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $project->title_ar }}</td>
                <td>
                    <span class="badge badge-primary">
                        @if($project->category == 'web') Web
                        @elseif($project->category == 'api-web') API Web
                        @else API Mobile
                        @endif
                    </span>
                </td>
                <td>
                    @if($project->is_active)
                        <span class="badge badge-success">نشط</span>
                    @else
                        <span class="badge badge-danger">غير نشط</span>
                    @endif
                </td>
                <td>{{ $project->order }}</td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    لا توجد مشاريع
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

