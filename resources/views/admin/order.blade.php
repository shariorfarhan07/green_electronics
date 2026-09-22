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
                <td><a href="/admin/order/{{$product['id']}}" class="wb-btn wb-btn--sm wb-btn--ghost">View Invoice</a></td>
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
