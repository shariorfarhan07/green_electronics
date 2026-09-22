@extends('lay.admin')
@section('page-title', 'Messages')
@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="wb-admin__stat-grid">
    <div class="wb-admin__stat-card">
        <span class="wb-admin__stat-value">{{ $messages->total() }}</span>
        <span class="wb-admin__stat-label">Total Messages</span>
    </div>
    <div class="wb-admin__stat-card">
        <span class="wb-admin__stat-value">{{ $unreadCount }}</span>
        <span class="wb-admin__stat-label">Unread</span>
    </div>
</div>

<div class="wb-admin__panel">
    <div class="wb-admin__panel-head">
        <h4>Contact Form Submissions</h4>
    </div>

    @if($messages->count())
    <div class="wb-admin__table-wrap">
        <table class="wb-admin__table">
            <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Received</th>
                <th>IP</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr style="{{ $message->isUnread() ? 'background:var(--accent-soft);' : '' }}">
                    <td style="max-width:200px;">
                        <div style="font-weight:{{ $message->isUnread() ? '700' : '600' }};">
                            {{ $message->name }}
                            @if($message->isUnread())
                                <span class="wb-admin__badge" style="margin-left:.3rem;">New</span>
                            @endif
                        </div>
                        <div style="font-size:.78rem;color:var(--ink-faint);">{{ $message->email }}</div>
                    </td>
                    <td style="max-width:280px;">
                        <div style="font-weight:600;">{{ \Illuminate\Support\Str::limit($message->subject, 50) }}</div>
                        <div style="font-size:.78rem;color:var(--ink-faint);">{{ \Illuminate\Support\Str::limit($message->message, 60) }}</div>
                    </td>
                    <td style="white-space:nowrap;font-size:.82rem;">{{ $message->created_at->format('d M Y, H:i') }}</td>
                    <td class="mono" style="font-size:.78rem;color:var(--ink-faint);">{{ $message->ip_address }}</td>
                    <td>
                        <div class="wb-admin__actions">
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="wb-btn wb-btn--sm wb-btn--ghost">Read</a>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="post" onsubmit="return confirm('Delete this message?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete"><x-icon name="trash" :size="14" /></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="wb-admin__empty">
            <x-icon name="mail" :size="36" />
            <p>No messages yet.</p>
        </div>
    @endif
</div>

<div class="mt-3">{{ $messages->links() }}</div>

@endsection
