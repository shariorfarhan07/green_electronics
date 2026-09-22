@extends('lay.admin')
@section('page-title', 'Add New Product')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.products.index') }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to Products
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="wb-admin__form-wrap">
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="image" :size="18" />
                <div>
                    <h4>Product Images <span class="wb-admin__req">*</span></h4>
                    <p>The first image becomes the primary image. You can add more after saving.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="wb-admin__dropzone" data-image-dropzone>
                    <x-icon name="image" :size="28" />
                    <p class="mb-0" style="margin-top:.5rem;">Drag &amp; drop images here, or click to browse</p>
                    <small style="color:var(--ink-faint);">JPG, PNG or WebP, up to 2MB each.</small>
                    <input type="file" name="images[]" id="images" multiple accept="image/png,image/jpeg,image/webp" hidden>
                </div>
                <div class="wb-admin__image-grid mt-3" data-image-preview></div>
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="edit" :size="18" />
                <div>
                    <h4>Basic Details</h4>
                    <p>What the customer sees first on the product page.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="form-group">
                    <label for="name">Product Name <span class="wb-admin__req">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Arduino Uno R3" required>
                </div>
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <input type="text" class="form-control" name="short_description" id="short_description" value="{{ old('short_description') }}" placeholder="One-line summary shown in listings">
                </div>
                <div class="form-group">
                    <label for="description">Full Description</label>
                    <textarea class="form-control" rows="5" name="description" id="description" placeholder="Full product description">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="filter" :size="18" />
                <div>
                    <h4>Categorisation</h4>
                    <p>Where this product appears when customers browse.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="form-group">
                    <label for="category_id">Category <span class="wb-admin__req">*</span></label>
                    <select class="form-control" name="category_id" id="category_id" required
                            data-searchable data-search-placeholder="Search categories…">
                        <option value="">Select category&hellip;</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section->name }}">
                                <option value="{{ $section->id }}" @selected(old('category_id') == $section->id)>{{ $section->name }} (general)</option>
                                @foreach($section->children as $child)
                                    <option value="{{ $child->id }}" @selected(old('category_id') == $child->id)>{{ $child->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <small class="wb-admin__hint">Start typing to filter. <a href="{{ route('admin.categories.index') }}">Manage categories</a></small>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="subcategory">Sub-category Label</label>
                        <input type="text" class="form-control" name="subcategory" id="subcategory" value="{{ old('subcategory') }}" placeholder="e.g. Arduino Board">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control" name="brand" id="brand" value="{{ old('brand') }}" placeholder="Optional">
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="box" :size="18" />
                <div>
                    <h4>Pricing &amp; Inventory</h4>
                    <p>Stock of zero shows the product as out of stock.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="price">Price (&#2547;) <span class="wb-admin__req">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="{{ old('price') }}" placeholder="450" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="stock">Stock Quantity <span class="wb-admin__req">*</span></label>
                        <input type="number" min="0" class="form-control" name="stock" id="stock" value="{{ old('stock') }}" placeholder="20" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" name="sku" id="sku" value="{{ old('sku') }}" placeholder="Auto-generated if blank">
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="grid" :size="18" />
                <div>
                    <h4>Specifications &amp; Links</h4>
                    <p>Optional extras shown on the product detail tabs.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="form-group">
                    <label for="specifications">Specifications</label>
                    <textarea class="form-control" rows="4" name="specifications" id="specifications" placeholder="Specifications text">{{ old('specifications') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="video_url">Product Video Link</label>
                        <input type="url" class="form-control" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="slug">URL Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" placeholder="Auto-generated if blank">
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-admin__form-actions">
            <button type="submit" class="wb-btn wb-btn--accent">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="wb-btn wb-btn--ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
