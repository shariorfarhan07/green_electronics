@extends('lay.admin')
@section('page-title', 'Settings')
@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="wb-admin__fieldset" style="max-width:720px;">
    <div class="wb-admin__fieldset-head">
        <x-icon name="phone" :size="18" />
        <div>
            <h4>Ordering</h4>
            <p>Control how customers can place orders on the storefront.</p>
        </div>
    </div>
    <div class="wb-admin__fieldset-body">
        <form action="{{ route('admin.settings.update') }}" method="post">
            @csrf
            @method('PUT')

            <div class="wb-switch-row">
                <div>
                    <div class="wb-switch-row__label">Contact-only ordering</div>
                    <p class="wb-switch-row__hint">
                        When enabled, customers can still browse and add items to their cart, but
                        the checkout page is replaced with a message asking them to
                        <strong>call {{ config('store.phone_display') }}</strong> or
                        <strong>WhatsApp</strong> their order instead. A notice banner also appears
                        across the site so customers know before they reach checkout.
                    </p>
                </div>
                <label class="wb-switch">
                    <input type="checkbox" name="orders_disabled" value="1" @checked($ordersDisabled)>
                    <span class="wb-switch__track"></span>
                </label>
            </div>

            <div class="wb-admin__form-actions" style="position:static;box-shadow:none;border:none;padding:1.1rem 0 0;background:none;backdrop-filter:none;">
                <button type="submit" class="wb-btn wb-btn--accent">Save Settings</button>
                @if($ordersDisabled)
                    <span style="color:var(--accent-dark);font-weight:600;">
                        <x-icon name="check" :size="14" /> Currently contact-only
                    </span>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection
