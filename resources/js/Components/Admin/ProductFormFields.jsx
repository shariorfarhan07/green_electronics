import React from 'react';
import { Link } from '@inertiajs/react';
import Icon from '../Icon';
import SearchableSelect from './SearchableSelect';

// The Basic/Categorisation/Pricing/Specs fieldsets are identical between the
// create and edit product screens; only the images block differs.
export default function ProductFormFields({ data, setData, categories = [] }) {
    const categoryGroups = categories.map((section) => ({
        label: section.name,
        options: [
            { value: section.id, label: `${section.name} (general)` },
            ...(section.children || []).map((child) => ({ value: child.id, label: child.name })),
        ],
    }));

    return (
        <>
            <div className="wb-admin__fieldset">
                <div className="wb-admin__fieldset-head">
                    <Icon name="edit" size={18} />
                    <div>
                        <h4>Basic Details</h4>
                        <p>What the customer sees first on the product page.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <div className="form-group">
                        <label htmlFor="name">Product Name <span className="wb-admin__req">*</span></label>
                        <input type="text" className="form-control" id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="e.g. Arduino Uno R3" required />
                    </div>
                    <div className="form-group">
                        <label htmlFor="short_description">Short Description</label>
                        <input type="text" className="form-control" id="short_description" value={data.short_description || ''} onChange={(e) => setData('short_description', e.target.value)} placeholder="One-line summary shown in listings" />
                        <small className="wb-admin__hint">One line shown on product cards and listings.</small>
                    </div>
                    <div className="form-group">
                        <label htmlFor="description">Full Description</label>
                        <textarea className="form-control" rows="5" id="description" value={data.description || ''} onChange={(e) => setData('description', e.target.value)} placeholder="Full product description" />
                    </div>
                </div>
            </div>

            <div className="wb-admin__fieldset">
                <div className="wb-admin__fieldset-head">
                    <Icon name="filter" size={18} />
                    <div>
                        <h4>Categorisation</h4>
                        <p>Where this product appears when customers browse.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <div className="form-group">
                        <label htmlFor="category_id">Category <span className="wb-admin__req">*</span></label>
                        <SearchableSelect
                            groups={categoryGroups}
                            value={data.category_id}
                            onChange={(v) => setData('category_id', v)}
                            placeholder="Select category…"
                            searchPlaceholder="Search categories…"
                            required
                        />
                        <small className="wb-admin__hint">Start typing to filter. <Link href="/admin/categories">Manage categories</Link></small>
                    </div>
                    <div className="row">
                        <div className="col-md-6 form-group">
                            <label htmlFor="subcategory">Sub-category Label</label>
                            <input type="text" className="form-control" id="subcategory" value={data.subcategory || ''} onChange={(e) => setData('subcategory', e.target.value)} placeholder="e.g. Arduino Board" />
                            <small className="wb-admin__hint">Free-text label shown on the product card.</small>
                        </div>
                        <div className="col-md-6 form-group">
                            <label htmlFor="brand">Brand</label>
                            <input type="text" className="form-control" id="brand" value={data.brand || ''} onChange={(e) => setData('brand', e.target.value)} placeholder="Optional" />
                        </div>
                    </div>
                </div>
            </div>

            <div className="wb-admin__fieldset">
                <div className="wb-admin__fieldset-head">
                    <Icon name="box" size={18} />
                    <div>
                        <h4>Pricing &amp; Inventory</h4>
                        <p>Stock of zero shows the product as out of stock.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <div className="row">
                        <div className="col-md-4 form-group">
                            <label htmlFor="price">Price (&#2547;) <span className="wb-admin__req">*</span></label>
                            <input type="number" step="0.01" min="0" className="form-control" id="price" value={data.price} onChange={(e) => setData('price', e.target.value)} placeholder="450" required />
                        </div>
                        <div className="col-md-4 form-group">
                            <label htmlFor="stock">Stock Quantity <span className="wb-admin__req">*</span></label>
                            <input type="number" min="0" className="form-control" id="stock" value={data.stock} onChange={(e) => setData('stock', e.target.value)} placeholder="20" required />
                        </div>
                        <div className="col-md-4 form-group">
                            <label htmlFor="sku">SKU</label>
                            <input type="text" className="form-control" id="sku" value={data.sku || ''} onChange={(e) => setData('sku', e.target.value)} placeholder="Auto-generated if blank" />
                        </div>
                    </div>
                </div>
            </div>

            <div className="wb-admin__fieldset">
                <div className="wb-admin__fieldset-head">
                    <Icon name="grid" size={18} />
                    <div>
                        <h4>Specifications &amp; Links</h4>
                        <p>Optional extras shown on the product detail tabs.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <div className="form-group">
                        <label htmlFor="specifications">Specifications</label>
                        <textarea className="form-control" rows="4" id="specifications" value={data.specifications || ''} onChange={(e) => setData('specifications', e.target.value)} placeholder="Specifications text" />
                    </div>
                    <div className="row">
                        <div className="col-md-6 form-group">
                            <label htmlFor="video_url">Product Video Link</label>
                            <input type="url" className="form-control" id="video_url" value={data.video_url || ''} onChange={(e) => setData('video_url', e.target.value)} placeholder="https://youtube.com/..." />
                        </div>
                        <div className="col-md-6 form-group">
                            <label htmlFor="slug">URL Slug</label>
                            <input type="text" className="form-control" id="slug" value={data.slug || ''} onChange={(e) => setData('slug', e.target.value)} placeholder="Auto-generated if blank" />
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
