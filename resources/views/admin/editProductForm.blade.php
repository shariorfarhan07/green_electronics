@extends('lay.admin')
@section('page-title', 'Edit Product')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.products.images.index', $product->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="image" :size="15" /> Manage Images ({{ $product->images->count() }})
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

    <form action="{{ route('admin.products.update', $product->id) }}" method="post">
        {{csrf_field()}}
        @method('PUT')

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="4" name="description" id="description">{{$product->description}}</textarea>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea class="form-control" rows="2" name="short_description" id="short_description">{{$product->short_description}}</textarea>
        </div>

        <div class="form-group">
            <label for="specifications">Specifications / Data Sheet Notes</label>
            <textarea class="form-control" rows="3" name="specifications" id="specifications">{{$product->specifications}}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="price">Price (&#2547;)</label>
                <input type="text" class="form-control" name="price" id="price" value="{{$product->price}}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="stock">Stock Quantity</label>
                <input type="text" class="form-control" name="stock" id="stock" value="{{$product->stock}}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="category_id">Category <a href="{{ route('admin.categories.index') }}" style="font-weight:400;font-size:.8rem;">(manage categories)</a></label>
                <select class="form-control" name="category_id" id="category_id" required>
                    @foreach($categories as $section)
                        <optgroup label="{{ $section->name }}">
                            <option value="{{ $section->id }}" @selected($product->category_id === $section->id)>{{ $section->name }} (general)</option>
                            @foreach($section->children as $child)
                                <option value="{{ $child->id }}" @selected($product->category_id === $child->id)>{{ $child->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label for="subcategory">Sub-category</label>
                <input type="text" class="form-control" name="subcategory" id="subcategory" value="{{$product->subcategory}}">
            </div>
            <div class="col-md-4 form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" name="brand" id="brand" value="{{$product->brand}}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" name="sku" id="sku" value="{{$product->sku}}">
            </div>
            <div class="col-md-6 form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" id="slug" value="{{$product->slug}}">
            </div>
        </div>

        <div class="form-group">
            <label for="video_url">Product Video Link (optional)</label>
            <input type="url" class="form-control" id="video_url" name="video_url" value="{{$product->video_url}}">
        </div>

        <button type="submit" name="submit" class="wb-btn wb-btn--accent">Save Changes</button>
        <a href="{{ route('admin.products.index') }}" class="wb-btn wb-btn--ghost">Cancel</a>
    </form>
</div>

@endsection
