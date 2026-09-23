import React from 'react';
import { useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import ErrorAlert from '../../Components/Admin/ErrorAlert';
import FileDropzone from '../../Components/Admin/FileDropzone';

export default function ProductsBulk() {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({ csv: null });

    const importErrors = flash?.importErrors || [];
    const importErrorCount = flash?.importErrorCount || 0;

    function submit(e) {
        e.preventDefault();
        post('/admin/products/import', { forceFormData: true });
    }

    return (
        <>
            {flash?.success && <div className="alert alert-success">{flash.success}</div>}
            <ErrorAlert errors={errors} />

            {importErrorCount > 0 && (
                <div className="alert alert-danger">
                    <strong>{importErrorCount} row(s) could not be updated:</strong>
                    <ul className="mb-0">
                        {importErrors.map((line, i) => <li key={i}>{line}</li>)}
                    </ul>
                    {importErrorCount > importErrors.length && (
                        <div>&hellip; and {importErrorCount - importErrors.length} more.</div>
                    )}
                </div>
            )}

            <div className="wb-admin__fieldset" style={{ maxWidth: 720 }}>
                <div className="wb-admin__fieldset-head">
                    <Icon name="box" size={18} />
                    <div>
                        <h4>Download Products</h4>
                        <p>Export every product as a CSV &mdash; useful as a backup or to edit prices in bulk.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    {/* A real <a>, not an Inertia Link: this is a file download, not a page visit. */}
                    <a href="/admin/products/export" className="wb-btn wb-btn--accent">
                        <Icon name="box" size={16} /> Download All Products (CSV)
                    </a>
                </div>
            </div>

            <div className="wb-admin__fieldset" style={{ maxWidth: 720 }}>
                <div className="wb-admin__fieldset-head">
                    <Icon name="edit" size={18} />
                    <div>
                        <h4>Bulk Update Prices</h4>
                        <p>Edit the <strong>price</strong> column of the downloaded CSV, then upload it here &mdash; every other column is ignored.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <form onSubmit={submit}>
                        <div className="form-group">
                            <label htmlFor="csv">CSV file</label>
                            <FileDropzone file={data.csv} onChange={(file) => setData('csv', file)} />
                            <span className="wb-admin__hint">
                                Must include an <strong>id</strong> column and a <strong>price</strong> column
                                (exactly as exported above). Rows with an unknown id or an invalid price are
                                skipped and reported &mdash; nothing else is changed.
                            </span>
                        </div>
                        <button type="submit" className="wb-btn wb-btn--accent" disabled={processing || !data.csv}>
                            <Icon name="check" size={16} /> {processing ? 'Uploading…' : 'Upload & Update Prices'}
                        </button>
                    </form>
                </div>
            </div>
        </>
    );
}

ProductsBulk.layout = (page) => <AdminLayout title="Bulk Products">{page}</AdminLayout>;
