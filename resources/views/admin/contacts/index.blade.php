@extends('layouts.admin')

@section('title', 'الرسائل')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-envelope"></i> الرسائل</h1>
    <p>إدارة الرسائل الواردة</p>
</div>

<div class="card">
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
            @forelse($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ Str::limit($contact->subject, 30) }}</td>
                <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    @if($contact->is_read)
                        <span class="badge badge-success">مقروء</span>
                    @else
                        <span class="badge badge-danger">غير مقروء</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-eye"></i> عرض
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
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
                    لا توجد رسائل
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

