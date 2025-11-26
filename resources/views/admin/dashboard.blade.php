@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-chart-line"></i> لوحة التحكم</h1>
    <p>نظرة عامة على إحصائيات الموقع</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>إجمالي المشاريع</h3>
        <div class="value">{{ $stats['projects'] }}</div>
        <div class="icon">
            <i class="fas fa-project-diagram"></i>
        </div>
    </div>

    <div class="stat-card">
        <h3>المشاريع النشطة</h3>
        <div class="value">{{ $stats['active_projects'] }}</div>
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>

    <div class="stat-card">
        <h3>الشهادات</h3>
        <div class="value">{{ $stats['certificates'] }}</div>
        <div class="icon">
            <i class="fas fa-certificate"></i>
        </div>
    </div>

    <div class="stat-card">
        <h3>المهارات</h3>
        <div class="value">{{ $stats['skills'] }}</div>
        <div class="icon">
            <i class="fas fa-code"></i>
        </div>
    </div>

    <div class="stat-card">
        <h3>الرسائل غير المقروءة</h3>
        <div class="value">{{ $stats['unread_contacts'] }}</div>
        <div class="icon">
            <i class="fas fa-envelope"></i>
        </div>
    </div>

    <div class="stat-card">
        <h3>إجمالي الرسائل</h3>
        <div class="value">{{ $stats['total_contacts'] }}</div>
        <div class="icon">
            <i class="fas fa-inbox"></i>
        </div>
    </div>
</div>

<!-- Recent Contacts -->
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-envelope"></i> آخر الرسائل</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">عرض الكل</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الموضوع</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ Str::limit($contact->subject, 30) }}</td>
                <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                <td>
                    @if($contact->is_read)
                        <span class="badge badge-success">مقروء</span>
                    @else
                        <span class="badge badge-danger">غير مقروء</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-eye"></i> عرض
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    لا توجد رسائل
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Recent Projects -->
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-project-diagram"></i> آخر المشاريع</h2>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">عرض الكل</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الفئة</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_projects as $project)
            <tr>
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
                <td>{{ $project->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    لا توجد مشاريع
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

