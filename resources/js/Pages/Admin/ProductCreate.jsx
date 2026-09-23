import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import ErrorAlert from '../../Components/Admin/ErrorAlert';
import ImageDropzone from '../../Components/Admin/ImageDropzone';
import ProductFormFields from '../../Components/Admin/ProductFormFields';

export default function ProductCreate({ categories = [] }) {
    const { data, setData, post, processing, errors } = useForm({
        images: [],
        name: '', short_description: '', description: '',
        category_id: '', subcategory: '', brand: '',
        price: '', stock: '', sku: '',
        specifications: '', video_url: '', slug: '',
    });

    function submit(e) {
        e.preventDefault();
        // forceFormData: the File objects need a multipart body, which Inertia
        // only switches to automatically once a File is present at the top level.
        post('/admin/products', { forceFormData: true });
    }

    return (
        <>
            <div className="wb-admin__actions mb-3">
                <Link href="/admin/products" className="wb-btn wb-btn--ghost wb-btn--sm">
                    <Icon name="chevron-left" size={15} /> Back to Products
                </Link>
            </div>

            <ErrorAlert errors={errors} />

            <div className="wb-admin__form-wrap">
                <form onSubmit={submit}>
                    <div className="wb-admin__fieldset">
                        <div className="wb-admin__fieldset-head">
                            <Icon name="image" size={18} />
                            <div>
                                <h4>Product Images <span className="wb-admin__req">*</span></h4>
                                <p>The first image becomes the primary image. You can add more after saving.</p>
                            </div>
                        </div>
                        <div className="wb-admin__fieldset-body">
                            <ImageDropzone files={data.images} onChange={(files) => setData('images', files)} />
                        </div>
                    </div>

                    <ProductFormFields data={data} setData={setData} categories={categories} />

                    <div className="wb-admin__form-actions">
                        <button type="submit" className="wb-btn wb-btn--accent" disabled={processing}>
                            {processing ? 'Creating…' : 'Create Product'}
                        </button>
                        <Link href="/admin/products" className="wb-btn wb-btn--ghost">Cancel</Link>
                    </div>
                </form>
            </div>
        </>
    );
}

ProductCreate.layout = (page) => <AdminLayout title="Add New Product">{page}</AdminLayout>;
