@extends('lay.admin')
@section('page-title', 'Product Images')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('editProductForm', $product->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to {{ $product->name }}
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="wb-admin__panel" style="padding:1.5rem;">
    <h4 class="mb-3">Current Images ({{ $product->images->count() }})</h4>

    @if($product->images->count())
        <div class="wb-admin__image-grid">
            @foreach($product->images as $image)
                <div class="wb-admin__image-tile">
                    @if($loop->first)
                        <span class="wb-admin__badge wb-admin__image-primary">Primary</span>
                    @endif
                    <img src="{{ Storage::disk('local')->url('product_images/'.$image->path) }}" alt="{{ $product->name }}">
                    <a href="{{ route('deleteProductImage', $image->id) }}" class="wb-admin__icon-btn wb-admin__icon-btn--danger wb-admin__image-remove" title="Remove" onclick="return confirm('Remove this image?');">
                        <x-icon name="close" :size="14" />
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p style="color:var(--ink-soft);">No images uploaded yet. The first image you add becomes the primary image shown in listings.</p>
    @endif

    <form action="{{ route('uploadProductImage', $product->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="wb-admin__dropzone">
            <x-icon name="image" :size="28" />
            <p class="mb-0" style="margin-top:.5rem;">Upload one or more images (JPG, PNG or WebP, up to 2MB each)</p>
            <input type="file" name="images[]" multiple accept="image/png,image/jpeg,image/webp" required>
        </div>
        <button type="submit" class="wb-btn wb-btn--accent mt-3">Upload</button>
    </form>
</div>

@endsection
