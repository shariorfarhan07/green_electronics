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
                <td>{{$product['address']}}</td>
                <td class="mono">{{$product['phone']}}</td>
                <td>{{$product['date']}}</td>
                <td>{{$product['bkashnumber']}}<br><span style="font-size:.78rem;color:var(--ink-faint);">{{$product['txid']}}</span></td>
                <td><span class="wb-admin__badge">{{ $product['status'] }}</span></td>
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
