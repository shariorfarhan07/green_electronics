@extends('lay.admin')
@section('page-title', 'Orders')
@section('content')

<div class="wb-admin__panel">
    <div class="wb-admin__panel-head">
        <h4>All Orders</h4>
    </div>

    @if($products->count())
    <div class="wb-admin__table-wrap">
        <table class="wb-admin__table">
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Payment</th>
                <th>Status</th>
                <th></th>
            </tr>
            @foreach($products as $product)
            <tr>
                <td class="mono">#{{$product['id']}}</td>
                <td style="font-weight:600;">{{$product['name']}}</td>
                <td><div class="wb-admin__cell-clamp" title="{{ $product['address'] }}">{{ $product['address'] }}</div></td>
                <td>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $product['phone']) }}" class="wb-btn wb-btn--sm wb-btn--ghost" title="Call {{ $product['name'] }}">
                        <x-icon name="phone" :size="13" /> {{ $product['phone'] }}
                    </a>
                </td>
                <td>{{$product['date']}}</td>
                <td>
                    <div style="font-weight:600;">{{ $product->payment_method === 'bkash' ? 'bKash' : 'Cash on Delivery' }}</div>
                    <div style="font-size:.78rem;color:var(--ink-faint);">&#2547;{{ number_format($product->grand_total, 2) }}</div>
                </td>
                <td><span class="wb-status wb-status--{{ \Illuminate\Support\Str::slug($product->status) }}">{{ $product->status }}</span></td>
                <td>
                    <div class="wb-admin__actions">
                        <a href="{{ route('admin.orders.show', $product['id']) }}" class="wb-admin__icon-btn" title="View Invoice"><x-icon name="box" :size="14" /></a>
                        <a href="{{ route('admin.orders.edit', $product['id']) }}" class="wb-admin__icon-btn" title="Edit"><x-icon name="edit" :size="14" /></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @else
        <div class="wb-admin__empty">
            <x-icon name="box" :size="36" />
            <p>No orders yet.</p>
        </div>
    @endif
</div>

<div class="mt-3">{{$products->links()}}</div>

@endsection
