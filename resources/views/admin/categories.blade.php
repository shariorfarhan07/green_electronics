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

<div class="wb-admin__fieldset" style="max-width:none;">
    <div class="wb-admin__fieldset-head">
        <x-icon name="plus" :size="18" />
        <div>
            <h4>Add Category</h4>
            <p>Leave the section blank to create a new top-level section.</p>
        </div>
    </div>
    <div class="wb-admin__fieldset-body">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="name">Name <span class="wb-admin__req">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Stepper Motor" required>
                </div>
                <div class="col-md-3 form-group">
                    <label for="parent_id">Section</label>
                    <select class="form-control" name="parent_id" id="parent_id" data-searchable data-search-placeholder="Search sections…">
                        <option value="">— New top-level section —</option>
                        @foreach($roots as $root)
                            <option value="{{ $root->id }}">{{ $root->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="blurb">Short Description</label>
                    <input type="text" class="form-control" name="blurb" id="blurb" placeholder="Shown in the mega menu">
                </div>
                <div class="col-md-2 form-group">
                    <label for="icon">Icon</label>
                    <select class="form-control" name="icon" id="icon" data-searchable data-search-placeholder="Search icons…">
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
</div>

<div class="wb-admin__panel">
    <div class="wb-admin__panel-head">
        <h4>Taxonomy &mdash; {{ $sections->count() }} sections, {{ $sections->sum(fn($s) => $s->children->count()) }} subcategories</h4>
    </div>

    @foreach($sections as $section)
        @php $editId = 'cat-edit-'.$section->id; @endphp
        <div class="wb-admin__cat-section">
            <div class="wb-admin__cat-head">
                <span class="wb-admin__cat-icon"><x-icon :name="$section->icon" :size="18" /></span>
                <input form="{{ $editId }}" type="text" name="name" value="{{ $section->name }}" class="form-control wb-admin__cat-name" required>
                <input form="{{ $editId }}" type="text" name="blurb" value="{{ $section->blurb }}" class="form-control" placeholder="Short description">
                <select form="{{ $editId }}" name="icon" class="form-control" style="max-width:130px;">
                    @foreach($icons as $icon)
                        <option value="{{ $icon }}" @selected($section->icon === $icon)>{{ $icon }}</option>
                    @endforeach
                </select>
                <input form="{{ $editId }}" type="number" name="sort_order" value="{{ $section->sort_order }}" class="form-control" style="max-width:80px;" title="Sort order">
                <input form="{{ $editId }}" type="hidden" name="parent_id" value="">
                <span class="wb-admin__badge">{{ $section->products_count }} direct</span>
                <button form="{{ $editId }}" type="submit" class="wb-admin__icon-btn" title="Save section"><x-icon name="check" :size="14" /></button>
                <form id="{{ $editId }}" action="{{ route('admin.categories.update', $section->id) }}" method="post" style="display:none;">
                    @csrf @method('PUT')
                </form>
                <form action="{{ route('admin.categories.destroy', $section->id) }}" method="post" onsubmit="return confirm('Delete this section?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete section"><x-icon name="trash" :size="14" /></button>
                </form>
            </div>

            @if($section->children->count())
                <div class="wb-admin__cat-children">
                    @foreach($section->children as $child)
                        @php $childEditId = 'cat-edit-'.$child->id; @endphp
                        <div class="wb-admin__cat-child">
                            <input form="{{ $childEditId }}" type="text" name="name" value="{{ $child->name }}" class="form-control" required>
                            <select form="{{ $childEditId }}" name="parent_id" class="form-control" style="max-width:200px;" title="Move to section">
                                @foreach($roots as $root)
                                    <option value="{{ $root->id }}" @selected($child->parent_id === $root->id)>{{ $root->name }}</option>
                                @endforeach
                            </select>
                            <input form="{{ $childEditId }}" type="number" name="sort_order" value="{{ $child->sort_order }}" class="form-control" style="max-width:80px;" title="Sort order">
                            <input form="{{ $childEditId }}" type="hidden" name="icon" value="{{ $child->icon }}">
                            <span class="wb-admin__badge">{{ $child->products_count }}</span>
                            <span class="mono" style="font-size:.72rem;color:var(--ink-faint);">{{ $child->slug }}</span>
                            <button form="{{ $childEditId }}" type="submit" class="wb-admin__icon-btn" title="Save"><x-icon name="check" :size="14" /></button>
                            <form id="{{ $childEditId }}" action="{{ route('admin.categories.update', $child->id) }}" method="post" style="display:none;">
                                @csrf @method('PUT')
                            </form>
                            <form action="{{ route('admin.categories.destroy', $child->id) }}" method="post" onsubmit="return confirm('Delete this subcategory?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete"><x-icon name="trash" :size="14" /></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>

@endsection
