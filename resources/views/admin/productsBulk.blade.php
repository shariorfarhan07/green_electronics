@extends('lay.admin')
@section('page-title', 'Bulk Products')
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
@if (session('importErrorCount', 0) > 0)
    <div class="alert alert-danger">
        <strong>{{ session('importErrorCount') }} row(s) could not be updated:</strong>
        <ul class="mb-0">
            @foreach (session('importErrors', []) as $line)
                <li>{{ $line }}</li>
            @endforeach
        </ul>
        @if (session('importErrorCount') > count(session('importErrors', [])))
            <div>&hellip; and {{ session('importErrorCount') - count(session('importErrors', [])) }} more.</div>
        @endif
    </div>
@endif

<div class="wb-admin__fieldset" style="max-width:720px;">
    <div class="wb-admin__fieldset-head">
        <x-icon name="box" :size="18" />
        <div>
            <h4>Download Products</h4>
            <p>Export every product as a CSV — useful as a backup or to edit prices in bulk.</p>
        </div>
    </div>
    <div class="wb-admin__fieldset-body">
        <a href="{{ route('admin.products.export') }}" class="wb-btn wb-btn--accent">
            <x-icon name="box" :size="16" /> Download All Products (CSV)
        </a>
    </div>
</div>

<div class="wb-admin__fieldset" style="max-width:720px;">
    <div class="wb-admin__fieldset-head">
        <x-icon name="edit" :size="18" />
        <div>
            <h4>Bulk Update Prices</h4>
            <p>Edit the <strong>price</strong> column of the downloaded CSV, then upload it here — every other column is ignored.</p>
        </div>
    </div>
    <div class="wb-admin__fieldset-body">
        <form action="{{ route('admin.products.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="csv">CSV file</label>
                <div class="wb-admin__dropzone" data-file-dropzone>
                    <input type="file" name="csv" id="csv" accept=".csv,text/csv,application/vnd.ms-excel" required hidden>
                    <div data-file-dropzone-prompt>
                        <x-icon name="box" :size="26" />
                        <p style="margin:.6rem 0 0;"><strong>Click to choose</strong> or drag and drop your CSV file here</p>
                    </div>
                    <div data-file-dropzone-selected class="wb-admin__dropzone-selected" style="display:none;">
                        <x-icon name="check" :size="18" />
                        <span data-file-dropzone-name></span>
                        <button type="button" data-file-dropzone-clear class="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Remove file">
                            <x-icon name="close" :size="13" />
                        </button>
                    </div>
                </div>
                <span class="wb-admin__hint">
                    Must include an <strong>id</strong> column and a <strong>price</strong> column
                    (exactly as exported above). Rows with an unknown id or an invalid price are
                    skipped and reported — nothing else is changed.
                </span>
            </div>
            <button type="submit" class="wb-btn wb-btn--accent">
                <x-icon name="check" :size="16" /> Upload &amp; Update Prices
            </button>
        </form>
    </div>
</div>

@endsection
