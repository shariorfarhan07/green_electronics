import React from 'react';
import { Link, router, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import ErrorAlert from '../../Components/Admin/ErrorAlert';
import ImageDropzone from '../../Components/Admin/ImageDropzone';
import ProductFormFields from '../../Components/Admin/ProductFormFields';

export default function ProductEdit({ product, categories = [] }) {
    const { flash } = usePage().props;

    const { data, setData, put, processing, errors } = useForm({
        name: product.name || '',
        short_description: product.short_description || '',
        description: product.description || '',
        category_id: product.category_id || '',
        subcategory: product.subcategory || '',
        brand: product.brand || '',
        price: product.price ?? '',
        stock: product.stock ?? '',
        sku: product.sku || '',
        specifications: product.specifications || '',
        video_url: product.video_url || '',
        slug: product.slug || '',
    });

    const imageForm = useForm({ images: [] });

    function submit(e) {
        e.preventDefault();
        put(`/admin/products/${product.id}`);
    }

    function uploadImages(e) {
        e.preventDefault();
        imageForm.post(`/admin/products/${product.id}/images`, {
            forceFormData: true,
            onSuccess: () => imageForm.setData('images', []),
        });
    }

    function removeImage(imageId) {
        if (window.confirm('Remove this image?')) {
            router.delete(`/admin/products/images/${imageId}`, { preserveScroll: true });
        }
    }

    return (
        <>
            <div className="wb-admin__actions mb-3">
                <Link href="/admin/products" className="wb-btn wb-btn--ghost wb-btn--sm">
                    <Icon name="chevron-left" size={15} /> Back to Products
                </Link>
            </div>

            {flash?.success && <div className="alert alert-success">{flash.success}</div>}
            <ErrorAlert errors={{ ...errors, ...imageForm.errors }} />

            <div className="wb-admin__form-wrap">
                <div className="wb-admin__fieldset">
                    <div className="wb-admin__fieldset-head">
                        <Icon name="image" size={18} />
                        <div>
                            <h4>Product Images</h4>
                            <p>The first image is used as the primary image in listings.</p>
                        </div>
                    </div>
                    <div className="wb-admin__fieldset-body">
                        {product.images?.length > 0 ? (
                            <div className="wb-admin__image-grid">
                                {product.images.map((image, i) => (
                                    <div className="wb-admin__image-tile" key={image.id}>
                                        {i === 0 && <span className="wb-admin__badge wb-admin__image-primary">Primary</span>}
                                        <img src={image.url} alt={product.name} />
                                        <button
                                            type="button"
                                            className="wb-admin__icon-btn wb-admin__icon-btn--danger wb-admin__image-remove"
                                            title="Remove"
                                            onClick={() => removeImage(image.id)}
                                        >
                                            <Icon name="close" size={14} />
                                        </button>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p style={{ color: 'var(--ink-soft)', marginBottom: '1rem' }}>No images yet — add one below.</p>
                        )}

                        <form onSubmit={uploadImages}>
                            <ImageDropzone files={imageForm.data.images} onChange={(files) => imageForm.setData('images', files)} />
                            <button type="submit" className="wb-btn wb-btn--accent wb-btn--sm mt-3" disabled={imageForm.processing}>
                                {imageForm.processing ? 'Uploading…' : 'Upload Images'}
                            </button>
                        </form>
                    </div>
                </div>

                <form onSubmit={submit}>
                    <ProductFormFields data={data} setData={setData} categories={categories} />

                    <div className="wb-admin__form-actions">
                        <button type="submit" className="wb-btn wb-btn--accent" disabled={processing}>
                            {processing ? 'Saving…' : 'Save Changes'}
                        </button>
                        <Link href="/admin/products" className="wb-btn wb-btn--ghost">Cancel</Link>
                        <span>Product #{product.id} &middot; {product.images?.length || 0} image(s)</span>
                    </div>
                </form>
            </div>
        </>
    );
}

ProductEdit.layout = (page) => <AdminLayout title="Edit Product">{page}</AdminLayout>;
