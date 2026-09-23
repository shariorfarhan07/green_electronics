import React from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import Pagination from '../../Components/Pagination';
import { money } from '../../money';

export default function Products({ products }) {
    const { flash } = usePage().props;
    const rows = products?.data || [];

    function destroy(id) {
        if (window.confirm('Delete this product?')) {
            router.delete(`/admin/products/${id}`, { preserveScroll: true });
        }
    }

    return (
        <>
            <div className="wb-admin__stat-grid">
                <div className="wb-admin__stat-card">
                    <span className="wb-admin__stat-value">{products?.total ?? 0}</span>
                    <span className="wb-admin__stat-label">Total Products</span>
                </div>
            </div>

            {flash?.success && <div className="alert alert-success">{flash.success}</div>}

            <div className="wb-admin__panel">
                <div className="wb-admin__panel-head">
                    <h4>All Products</h4>
                    <Link href="/admin/products/create" className="wb-btn wb-btn--accent wb-btn--sm">
                        <Icon name="plus" size={15} /> Add New Product
                    </Link>
                </div>

                {rows.length > 0 ? (
                    <div className="wb-admin__table-wrap">
                        <table className="wb-admin__table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {rows.map((product) => (
                                    <tr key={product.id}>
                                        <td className="mono">#{product.id}</td>
                                        <td>
                                            {product.primary_image_url
                                                ? <img className="wb-admin__thumb" src={product.primary_image_url} alt={product.name} />
                                                : <div className="wb-admin__thumb" />}
                                        </td>
                                        <td style={{ maxWidth: 220 }}>
                                            <div style={{ fontWeight: 600 }}>{product.name}</div>
                                            <div style={{ fontSize: '.78rem', color: 'var(--ink-faint)' }}>
                                                {(product.description || '').slice(0, 50)}{(product.description || '').length > 50 ? '…' : ''}
                                            </div>
                                        </td>
                                        <td><span className="wb-admin__badge">{product.category?.name || 'Uncategorized'}</span></td>
                                        <td className="mono">&#2547;{money(product.price)}</td>
                                        <td>
                                            {product.stock > 0
                                                ? <span style={{ color: 'var(--accent)', fontWeight: 600 }}>{product.stock}</span>
                                                : <span style={{ color: 'var(--danger)', fontWeight: 600 }}>Out of stock</span>}
                                        </td>
                                        <td>
                                            <div className="wb-admin__actions">
                                                <Link href={`/admin/products/${product.id}/edit`} className="wb-admin__icon-btn" title="Edit product & images">
                                                    <Icon name="edit" size={14} />
                                                </Link>
                                                <button type="button" onClick={() => destroy(product.id)} className="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete">
                                                    <Icon name="trash" size={14} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="wb-admin__empty">
                        <Icon name="box" size={36} />
                        <p>No products yet.</p>
                        <Link href="/admin/products/create" className="wb-btn wb-btn--accent">Add your first product</Link>
                    </div>
                )}
            </div>

            <div className="mt-3"><Pagination paginator={products} /></div>
        </>
    );
}

Products.layout = (page) => <AdminLayout title="Products">{page}</AdminLayout>;
