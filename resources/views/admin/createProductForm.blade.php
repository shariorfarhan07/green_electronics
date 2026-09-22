@extends('lay.admin')
@section('page-title', 'Add New Product')
@section('content')

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

    <form action="{{route('adminsendcreateproductform')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
            <label for="images">Product Images</label>
            <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/png,image/jpeg,image/webp" required>
            <small style="color:var(--ink-faint);">The first image becomes the primary image. You can add more later from the product list.</small>
        </div>

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Arduino Uno R3" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="4" name="description" id="description" placeholder="Full product description"></textarea>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea class="form-control" rows="2" name="short_description" id="short_description" placeholder="One-line summary shown in listings"></textarea>
        </div>

        <div class="form-group">
            <label for="specifications">Specifications / Data Sheet Notes</label>
            <textarea class="form-control" rows="3" name="specifications" id="specifications" placeholder="Specifications text"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="price">Price (&#2547;)</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="450" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="stock">Stock Quantity</label>
                <input type="text" class="form-control" name="stock" id="stock" placeholder="20" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" id="category_id" required>
                    <option value="">Select category&hellip;</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label for="subcategory">Sub-category</label>
                <input type="text" class="form-control" name="subcategory" id="subcategory" placeholder="e.g. Arduino">
            </div>
            <div class="col-md-4 form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" name="brand" id="brand" placeholder="Optional">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="sku">SKU (optional, auto-generated if blank)</label>
                <input type="text" class="form-control" name="sku" id="sku" placeholder="e.g. ARD-1001">
            </div>
            <div class="col-md-6 form-group">
                <label for="slug">Slug (optional, auto-generated if blank)</label>
                <input type="text" class="form-control" name="slug" id="slug" placeholder="auto-friendly-url-name">
            </div>
        </div>

        <div class="form-group">
            <label for="video_url">Product Video Link (optional)</label>
            <input type="url" class="form-control" id="video_url" name="video_url" placeholder="https://youtube.com/...">
        </div>

        <button type="submit" name="submit" class="wb-btn wb-btn--accent">Create Product</button>
    </form>
</div>

@endsection
