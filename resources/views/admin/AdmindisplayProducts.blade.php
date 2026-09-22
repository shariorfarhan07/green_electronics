@extends('lay.admin')
@section('page-title', 'Products')
@section('content')

<div class="wb-admin__stat-grid">
    <div class="wb-admin__stat-card">
        <span class="wb-admin__stat-value">{{ $products->total() }}</span>
        <span class="wb-admin__stat-label">Total Products</span>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="wb-admin__panel">
    <div class="wb-admin__panel-head">
        <h4>All Products</h4>
        <a href="{{ route('admin.products.create') }}" class="wb-btn wb-btn--accent wb-btn--sm">
            <x-icon name="plus" :size="15" /> Add New Product
        </a>
    </div>

    @if($products->count())
    <div class="wb-admin__table-wrap">
        <table class="wb-admin__table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="mono">#{{ $product->id }}</td>
                    <td>
                        @if($product->primary_image)
                            <img class="wb-admin__thumb" src="{{ Storage::disk('local')->url('product_images/'.$product->primary_image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="wb-admin__thumb"></div>
                        @endif
                    </td>
                    <td style="max-width:220px;">
                        <div style="font-weight:600;">{{ $product->name }}</div>
                        <div style="font-size:.78rem;color:var(--ink-faint);">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</div>
                    </td>
                    <td><span class="wb-admin__badge">{{ $product->category->name ?? 'Uncategorized' }}</span></td>
                    <td class="mono">&#2547;{{ $product->price }}</td>
                    <td>
                        @if($product->stock > 0)
                            <span style="color:var(--accent);font-weight:600;">{{ $product->stock }}</span>
                        @else
                            <span style="color:var(--danger);font-weight:600;">Out of stock</span>
                        @endif
                    </td>
                    <td>
                        <div class="wb-admin__actions">
                            <a href="{{route('admin.products.edit',$product->id)}}" class="wb-admin__icon-btn" title="Edit product &amp; images"><x-icon name="edit" :size="14" /></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" onsubmit="return confirm('Delete this product?');" style="display:inline;">
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
            <x-icon name="box" :size="36" />
            <p>No products yet.</p>
            <a href="{{ route('admin.products.create') }}" class="wb-btn wb-btn--accent">Add your first product</a>
        </div>
    @endif
</div>

<div class="mt-3">{{ $products->links() }}</div>

@endsection
