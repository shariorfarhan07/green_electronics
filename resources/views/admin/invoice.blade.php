<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $customer->id }} &middot; Green Electronics</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <style>
        :root {
            --ink: #111113;
            --ink-soft: #5b5e66;
            --ink-faint: #9a9ca3;
            --paper-alt: #f6f6f7;
            --line: #e8e8ea;
            --accent: #157a4d;
            --accent-soft: #e7f5ee;
            --danger: #d9463a;
            --radius-sm: 10px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--ink);
            background: #ececee;
        }
        .invoice-toolbar {
            max-width: 210mm;
            margin: 16px auto 0;
            padding: 0 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-toolbar a, .invoice-toolbar button {
            font-family: inherit;
            font-size: .85rem;
            font-weight: 600;
            border-radius: 999px;
            padding: .55rem 1.1rem;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }
        .invoice-toolbar .btn-accent { background: var(--accent); border-color: var(--accent); color: #fff; }
        .invoice-toolbar-actions { display: flex; gap: .6rem; }

        .invoice-page {
            width: 210mm;
            min-height: 297mm;
            margin: 16px auto 40px;
            background: #fff;
            padding: 16mm;
            box-shadow: 0 8px 30px rgba(17,17,19,.12);
            border-radius: var(--radius-sm);
        }
        .invoice-head { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 20px; border-bottom: 2px solid var(--ink); margin-bottom: 24px; }
        .invoice-brand { font-size: 1.5rem; font-weight: 800; letter-spacing: -.02em; }
        .invoice-brand span { color: var(--accent); }
        .invoice-brand-meta { margin-top: 6px; font-size: .8rem; color: var(--ink-soft); line-height: 1.6; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { margin: 0; font-size: 1.4rem; letter-spacing: .04em; text-transform: uppercase; }
        .invoice-title .invoice-id { font-size: .85rem; color: var(--ink-soft); margin-top: 4px; }
        .invoice-status { display: inline-block; margin-top: 8px; padding: .3rem .8rem; border-radius: 999px; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; background: var(--accent-soft); color: var(--accent); }

        .invoice-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
        .invoice-meta-block h4 { margin: 0 0 8px; font-size: .72rem; text-transform: uppercase; letter-spacing: .06em; color: var(--ink-faint); }
        .invoice-meta-block p { margin: 0 0 3px; font-size: .88rem; color: var(--ink); line-height: 1.5; }
        .invoice-meta-block p.muted { color: var(--ink-soft); }

        table.invoice-items { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        table.invoice-items thead th { text-align: left; font-size: .72rem; text-transform: uppercase; letter-spacing: .04em; color: #fff; background: var(--ink); padding: 10px 12px; }
        table.invoice-items thead th:last-child, table.invoice-items tbody td:last-child { text-align: right; }
        table.invoice-items tbody td { padding: 12px; font-size: .88rem; border-bottom: 1px solid var(--line); }
        table.invoice-items tbody tr:last-child td { border-bottom: none; }

        .invoice-item { display: flex; align-items: center; gap: .6rem; }
        .invoice-thumb {
            width: 38px; height: 38px; flex-shrink: 0; border-radius: 7px;
            border: 1px solid var(--line); background: var(--paper-alt); overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .invoice-thumb img { width: 100%; height: 100%; object-fit: contain; padding: 3px; }

        .invoice-totals { margin-left: auto; width: 280px; }
        .invoice-totals .row { display: flex; justify-content: space-between; padding: 7px 0; font-size: .88rem; color: var(--ink-soft); }
        .invoice-totals .row.grand { border-top: 2px solid var(--ink); margin-top: 6px; padding-top: 12px; font-size: 1.1rem; font-weight: 800; color: var(--ink); }

        .invoice-footnote { margin-top: 40px; padding-top: 16px; border-top: 1px solid var(--line); font-size: .78rem; color: var(--ink-faint); text-align: center; }

        @media print {
            body { background: #fff; }
            .invoice-toolbar { display: none; }
            .invoice-page { box-shadow: none; margin: 0; border-radius: 0; width: auto; min-height: auto; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<div class="invoice-toolbar">
    <a href="{{ route('admin.orders.index') }}">&larr; Back to Orders</a>
    <div class="invoice-toolbar-actions">
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $customer->phone) }}">&#9742; Call Customer &middot; {{ $customer->phone }}</a>
        <a href="{{ route('admin.orders.edit', $customer->id) }}">Edit Order</a>
        <button type="button" class="btn-accent" onclick="window.print()">Print Invoice</button>
    </div>
</div>

<div class="invoice-page">
    <div class="invoice-head">
        <div>
            <div class="invoice-brand">Green<span>Electronics</span></div>
            <div class="invoice-brand-meta">
                Call: 01875589192<br>
                greenelectronicsbd@gmail.com
            </div>
        </div>
        <div class="invoice-title">
            <h1>Invoice</h1>
            <div class="invoice-id">#{{ str_pad($customer->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-id">{{ $customer->date }}</div>
            <div class="invoice-status">{{ $customer->status }}</div>
        </div>
    </div>

    <div class="invoice-meta-grid">
        <div class="invoice-meta-block">
            <h4>Bill To</h4>
            <p style="font-weight:600;">{{ $customer->name }}</p>
            <p>{{ $customer->address }}</p>
            <p>{{ $customer->city }}, {{ $customer->division }} &mdash; {{ $customer->zip }}</p>
            <p class="muted">{{ $customer->phone }}</p>
            @if($customer->email)
                <p class="muted">{{ $customer->email }}</p>
            @endif
        </div>
        <div class="invoice-meta-block">
            <h4>Payment</h4>
            <p>
                @if($customer->payment_method === 'bkash')
                    Paid via bKash
                @else
                    Cash on Delivery
                @endif
            </p>
            @if($customer->bkashnumber && $customer->bkashnumber != 'cash on delevery')
                <p class="muted">Number: {{ $customer->bkashnumber }}</p>
            @endif
            @if($customer->txid && $customer->txid != 'cash on delevery')
                <p class="muted">Transaction ID: {{ $customer->txid }}</p>
            @endif
        </div>
    </div>

    <table class="invoice-items">
        <thead>
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $index => $product)
            <tr>
                <td class="muted">{{ $index + 1 }}</td>
                <td>
                    <div class="invoice-item">
                        <span class="invoice-thumb">
                            @if($images[$product['item_id']] ?? null)
                                <img src="{{ Storage::disk('local')->url('product_images/'.$images[$product['item_id']]) }}" alt="{{ $product['item_name'] }}">
                            @endif
                        </span>
                        <span style="font-weight:600;">{{ $product['item_name'] }}</span>
                    </div>
                </td>
                <td>{{ $product['qty'] }}</td>
                <td>&#2547;{{ number_format($product['item_price'], 2) }}</td>
                <td>&#2547;{{ number_format($product['qty'] * $product['item_price'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="invoice-totals">
        <div class="row"><span>Subtotal</span><span>&#2547;{{ number_format($customer->payment, 2) }}</span></div>
        <div class="row"><span>Shipping</span><span>&#2547;{{ number_format($customer->shipping, 2) }}</span></div>
        @if($customer->discount)
            <div class="row"><span>Discount</span><span>&minus;&#2547;{{ number_format($customer->discount, 2) }}</span></div>
        @endif
        <div class="row grand"><span>Grand Total</span><span>&#2547;{{ number_format($customer->payment + $customer->shipping - ($customer->discount ?: 0), 2) }}</span></div>
        @if($customer->paid)
            <div class="row"><span>Already Paid</span><span>&minus;&#2547;{{ number_format($customer->paid, 2) }}</span></div>
        @endif
        @if($customer->payment_method === 'cod' && $customer->cod_amount)
            <div class="row" style="font-weight:700;color:var(--ink);"><span>Collect on Delivery</span><span>&#2547;{{ number_format($customer->cod_amount, 2) }}</span></div>
        @endif
    </div>

    <div class="invoice-footnote">
        Thank you for shopping with Green Electronics &mdash; Bangladesh's store for Arduino, sensors, robotics &amp; 3D printing.
    </div>
</div>

</body>
</html>
