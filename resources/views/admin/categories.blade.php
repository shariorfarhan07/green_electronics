@extends('lay.admin')
@section('page-title', 'Categories')
@section('content')

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

<div class="wb-admin__panel" style="padding:1.5rem;margin-bottom:1.5rem;">
    <h4 class="mb-3">Add Category</h4>
    <form action="{{ route('admin.categories.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Development Boards" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="blurb">Short Description</label>
                <input type="text" class="form-control" name="blurb" id="blurb" placeholder="Shown under the category name">
            </div>
            <div class="col-md-3 form-group">
                <label for="icon">Icon</label>
                <select class="form-control" name="icon" id="icon">
                    @foreach($icons as $icon)
                        <option value="{{ $icon }}">{{ $icon }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 form-group d-flex align-items-end">
                <button type="submit" class="wb-btn wb-btn--accent" style="width:100%;">Add</button>
            </div>
        </div>
    </form>
</div>

<div class="wb-admin__panel">
    <div class="wb-admin__panel-head">
        <h4>All Categories ({{ $categories->count() }})</h4>
    </div>

    @if($categories->count())
    <div class="wb-admin__table-wrap">
        <table class="wb-admin__table">
            <thead>
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Short Description</th>
                <th>Products</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                @php $editFormId = 'cat-edit-'.$category->id; @endphp
                <tr>
                    <td style="width:70px;"><x-icon :name="$category->icon" :size="20" /></td>
                    <td style="min-width:160px;"><input form="{{ $editFormId }}" type="text" class="form-control" name="name" value="{{ $category->name }}" required></td>
                    <td class="mono" style="color:var(--ink-faint);">{{ $category->slug }}</td>
                    <td style="min-width:200px;"><input form="{{ $editFormId }}" type="text" class="form-control" name="blurb" value="{{ $category->blurb }}"></td>
                    <td><span class="wb-admin__badge">{{ $category->products_count }}</span></td>
                    <td>
                        <div class="wb-admin__actions">
                            <select form="{{ $editFormId }}" class="form-control" name="icon" style="width:auto;display:inline-block;">
                                @foreach($icons as $icon)
                                    <option value="{{ $icon }}" @selected($category->icon === $icon)>{{ $icon }}</option>
                                @endforeach
                            </select>
                            <button form="{{ $editFormId }}" type="submit" class="wb-admin__icon-btn" title="Save"><x-icon name="check" :size="14" /></button>
                            <form id="{{ $editFormId }}" action="{{ route('admin.categories.update', $category->id) }}" method="post" style="display:none;">
                                @csrf
                                @method('PUT')
                            </form>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" onsubmit="return confirm('Delete this category?');" style="display:inline;">
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
            <x-icon name="grid" :size="36" />
            <p>No categories yet. Add your first one above.</p>
        </div>
    @endif
</div>

@endsection
