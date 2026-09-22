@extends('lay.admin')
@section('page-title', 'Edit Order')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to Invoice #{{ $order->id }}
    </a>
</div>

<div class="wb-admin__form">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="status">Order Status</label>
                <select class="form-control" name="status" id="status">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                    @if(!in_array($order->status, $statuses))
                        <option value="{{ $order->status }}" selected>{{ $order->status }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name">Customer Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $order->name }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $order->phone }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ $order->email }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ $order->address }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ $order->city }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="division">Division</label>
                <input type="text" class="form-control" name="division" id="division" value="{{ $order->division }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" name="zip" id="zip" value="{{ $order->zip }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="payment">Order Total (&#2547;)</label>
                <input type="text" class="form-control" name="payment" id="payment" value="{{ $order->payment }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="shipping">Shipping (&#2547;)</label>
                <input type="text" class="form-control" name="shipping" id="shipping" value="{{ $order->shipping }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="discount">Discount (&#2547;, optional)</label>
                <input type="text" class="form-control" name="discount" id="discount" value="{{ $order->discount }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="paid">Amount Paid (&#2547;, optional)</label>
                <input type="text" class="form-control" name="paid" id="paid" value="{{ $order->paid }}">
            </div>
            <div class="col-md-4 form-group">
                <label for="bkashnumber">bKash / Payment Number</label>
                <input type="text" class="form-control" name="bkashnumber" id="bkashnumber" value="{{ $order->bkashnumber }}">
            </div>
            <div class="col-md-4 form-group">
                <label for="txid">Transaction ID</label>
                <input type="text" class="form-control" name="txid" id="txid" value="{{ $order->txid }}">
            </div>
        </div>

        <div class="form-group">
            <label for="message">Internal Note (optional)</label>
            <textarea class="form-control" rows="3" name="message" id="message">{{ $order->message }}</textarea>
        </div>

        <button type="submit" name="submit" class="wb-btn wb-btn--accent">Save Changes</button>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost">Cancel</a>
    </form>
</div>

@endsection
