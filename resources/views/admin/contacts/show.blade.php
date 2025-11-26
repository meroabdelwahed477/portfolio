@extends('layouts.admin')

@section('title', 'تفاصيل الرسالة')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-envelope"></i> تفاصيل الرسالة</h1>
    <p>عرض محتوى الرسالة</p>
</div>

<div class="card">
    <div style="margin-bottom: 1.5rem;">
        <strong>الاسم:</strong> {{ $contact->name }}
    </div>
    <div style="margin-bottom: 1.5rem;">
        <strong>البريد الإلكتروني:</strong> {{ $contact->email }}
    </div>
    <div style="margin-bottom: 1.5rem;">
        <strong>الموضوع:</strong> {{ $contact->subject }}
    </div>
    <div style="margin-bottom: 1.5rem;">
        <strong>الرسالة:</strong>
        <div style="background: var(--light); padding: 1rem; border-radius: 8px; margin-top: 0.5rem;">
            {{ $contact->message }}
        </div>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <strong>التاريخ:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> رجوع
        </a>
        @if(!$contact->is_read)
        <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" style="display: inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> تحديد كمقروء
            </button>
        </form>
        @endif
    </div>
</div>
@endsection

