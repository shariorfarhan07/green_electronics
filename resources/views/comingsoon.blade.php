@extends('layout.app')
@section('content')

<div class="wb-coming-soon container">
    <x-icon name="box" :size="52" />
    <h2>Coming Soon</h2>
    <p style="color:var(--ink-soft);">We're working on this page &mdash; check back shortly.</p>
    <a href="{{ url('/') }}" class="wb-btn wb-btn--accent">Back to Home</a>
</div>

@endsection
