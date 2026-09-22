@extends('lay.admin')
@section('page-title', 'Message')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.messages.index') }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to Messages
    </a>
</div>

<div class="wb-admin__form-wrap">
    <div class="wb-admin__fieldset">
        <div class="wb-admin__fieldset-head">
            <x-icon name="mail" :size="18" />
            <div>
                <h4>{{ $message->subject }}</h4>
                <p>Received {{ $message->created_at->format('d M Y \a\t H:i') }} &middot; IP {{ $message->ip_address ?: 'unknown' }}</p>
            </div>
        </div>
        <div class="wb-admin__fieldset-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>From</label>
                    <div style="font-weight:600;">{{ $message->name }}</div>
                </div>
                <div class="col-md-6 form-group">
                    <label>Email</label>
                    <div><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div>
                </div>
            </div>
            <div class="form-group">
                <label>Message</label>
                <div style="white-space:pre-wrap;line-height:1.7;padding:1rem;background:var(--paper-alt);border-radius:var(--radius-sm);">{{ $message->message }}</div>
            </div>
        </div>
    </div>

    <div class="wb-admin__form-actions">
        <a href="mailto:{{ $message->email }}?subject=RE: {{ urlencode($message->subject) }}" class="wb-btn wb-btn--accent">
            <x-icon name="reply" :size="15" /> Reply by Email
        </a>
        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="post" onsubmit="return confirm('Delete this message?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="wb-btn wb-btn--ghost">Delete</button>
        </form>
        <span>Message #{{ $message->id }}</span>
    </div>
</div>

@endsection
