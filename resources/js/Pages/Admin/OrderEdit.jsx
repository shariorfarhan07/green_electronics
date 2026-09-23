import React from 'react';
import { Link, router, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import ErrorAlert from '../../Components/Admin/ErrorAlert';
import SearchableSelect from '../../Components/Admin/SearchableSelect';
import { money } from '../../money';

export default function OrderEdit({ order, items = [], images = {}, products = [], statuses = [] }) {
    const { flash } = usePage().props;
    const grandTotal = Number(order.payment) + Number(order.shipping) - Number(order.discount || 0);

    const { data, setData, put, processing, errors } = useForm({
        status: order.status || '',
        name: order.name || '',
        phone: order.phone || '',
        email: order.email || '',
        address: order.address || '',
        city: order.city || '',
        division: order.division || '',
        zip: order.zip || '',
        shipping: order.shipping ?? '',
        discount: order.discount ?? '',
        payment_method: order.payment_method || 'cod',
        cod_amount: order.cod_amount ?? '',
        paid: order.paid ?? '',
        bkashnumber: order.bkashnumber || '',
        txid: order.txid || '',
        message: order.message || '',
    });

    const itemForm = useForm({ product_id: '', qty: 1 });

    function submit(e) {
        e.preventDefault();
        put(`/admin/orders/${order.id}`);
    }

    function addItem(e) {
        e.preventDefault();
        itemForm.post(`/admin/orders/${order.id}/items`, {
            preserveScroll: true,
            onSuccess: () => itemForm.reset(),
        });
    }

    function removeItem(itemId) {
        if (window.confirm('Remove this item from the order?')) {
            router.delete(`/admin/orders/${order.id}/items/${itemId}`, { preserveScroll: true });
        }
    }

    const statusOptions = statuses.includes(order.status) ? statuses : [...statuses, order.status];

    return (
        <>
            <div className="wb-admin__actions mb-3">
                <Link href={`/admin/orders/${order.id}`} className="wb-btn wb-btn--ghost wb-btn--sm">
                    <Icon name="chevron-left" size={15} /> Back to Invoice #{order.id}
                </Link>
                <Link href="/admin/orders" className="wb-btn wb-btn--ghost wb-btn--sm">All Orders</Link>
                <a href={`tel:${String(order.phone || '').replace(/[^0-9+]/g, '')}`} className="wb-btn wb-btn--accent wb-btn--sm">
                    <Icon name="phone" size={14} /> Call Customer &middot; {order.phone}
                </a>
            </div>

            {flash?.success && <div className="alert alert-success">{flash.success}</div>}
            <ErrorAlert errors={{ ...errors, ...itemForm.errors }} />

            <div className="wb-admin__form-wrap">
                <div className="wb-admin__fieldset">
                    <div className="wb-admin__fieldset-head">
                        <Icon name="box" size={18} />
                        <div>
                            <h4>Order Items</h4>
                            <p>The order subtotal recalculates automatically when items change.</p>
                        </div>
                    </div>
                    <div className="wb-admin__fieldset-body">
                        {items.length > 0 ? (
                            <div className="wb-admin__table-wrap mb-3">
                                <table className="wb-admin__table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th>Line Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {items.map((item) => (
                                            <tr key={item.id}>
                                                <td>
                                                    <div style={{ display: 'flex', alignItems: 'center', gap: '.7rem' }}>
                                                        <span className="wb-order-thumb" style={{ width: 44, height: 44 }}>
                                                            {images[item.item_id]
                                                                ? <img src={images[item.item_id]} alt={item.item_name} />
                                                                : <Icon name="image" size={16} />}
                                                        </span>
                                                        <span style={{ fontWeight: 600 }}>{item.item_name}</span>
                                                    </div>
                                                </td>
                                                <td className="mono">&#2547;{money(item.item_price)}</td>
                                                <td>{item.qty}</td>
                                                <td className="mono">&#2547;{money(item.qty * item.item_price)}</td>
                                                <td>
                                                    <button type="button" className="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Remove item" onClick={() => removeItem(item.id)}>
                                                        <Icon name="trash" size={14} />
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <p style={{ color: 'var(--ink-soft)' }}>This order has no items. The subtotal will be &#2547;0.00 until you add one.</p>
                        )}

                        <form onSubmit={addItem}>
                            <div className="row">
                                <div className="col-md-7 form-group">
                                    <label htmlFor="product_id">Add Product</label>
                                    <SearchableSelect
                                        groups={[{ label: 'Products', options: products.map((p) => ({ value: p.id, label: `${p.name} — ৳${money(p.price)}` })) }]}
                                        value={itemForm.data.product_id}
                                        onChange={(v) => itemForm.setData('product_id', v)}
                                        placeholder="Select a product…"
                                        searchPlaceholder="Search products…"
                                        required
                                    />
                                    <small className="wb-admin__hint">Price is captured from the product&rsquo;s current price.</small>
                                </div>
                                <div className="col-md-3 form-group">
                                    <label htmlFor="qty">Quantity</label>
                                    <input type="number" className="form-control" id="qty" min="1" value={itemForm.data.qty} onChange={(e) => itemForm.setData('qty', e.target.value)} required />
                                </div>
                                <div className="col-md-2 form-group d-flex align-items-end">
                                    <button type="submit" className="wb-btn wb-btn--accent" style={{ width: '100%' }} disabled={itemForm.processing || !itemForm.data.product_id}>Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <form onSubmit={submit}>
                    <div className="wb-admin__fieldset">
                        <div className="wb-admin__fieldset-head">
                            <Icon name="truck" size={18} />
                            <div>
                                <h4>Fulfilment Status</h4>
                                <p>Shown on the invoice and in the orders list.</p>
                            </div>
                        </div>
                        <div className="wb-admin__fieldset-body">
                            <div className="row">
                                <div className="col-md-6 form-group">
                                    <label htmlFor="status">Order Status <span className="wb-admin__req">*</span></label>
                                    <select className="form-control" id="status" value={data.status} onChange={(e) => setData('status', e.target.value)}>
                                        {statusOptions.map((s) => (
                                            <option key={s} value={s}>{s.charAt(0).toUpperCase() + s.slice(1)}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="wb-admin__fieldset">
                        <div className="wb-admin__fieldset-head">
                            <Icon name="user" size={18} />
                            <div>
                                <h4>Customer &amp; Delivery</h4>
                                <p>Where this order is going.</p>
                            </div>
                        </div>
                        <div className="wb-admin__fieldset-body">
                            <div className="row">
                                <div className="col-md-6 form-group">
                                    <label htmlFor="name">Customer Name <span className="wb-admin__req">*</span></label>
                                    <input type="text" className="form-control" id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                                </div>
                                <div className="col-md-6 form-group">
                                    <label htmlFor="phone">Phone <span className="wb-admin__req">*</span></label>
                                    <input type="text" className="form-control" id="phone" value={data.phone} onChange={(e) => setData('phone', e.target.value)} required />
                                </div>
                            </div>
                            <div className="form-group">
                                <label htmlFor="email">Email</label>
                                <input type="email" className="form-control" id="email" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                            </div>
                            <div className="form-group">
                                <label htmlFor="address">Address <span className="wb-admin__req">*</span></label>
                                <input type="text" className="form-control" id="address" value={data.address} onChange={(e) => setData('address', e.target.value)} required />
                            </div>
                            <div className="row">
                                <div className="col-md-4 form-group">
                                    <label htmlFor="city">City <span className="wb-admin__req">*</span></label>
                                    <input type="text" className="form-control" id="city" value={data.city} onChange={(e) => setData('city', e.target.value)} required />
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="division">Division <span className="wb-admin__req">*</span></label>
                                    <input type="text" className="form-control" id="division" value={data.division} onChange={(e) => setData('division', e.target.value)} required />
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="zip">Zip <span className="wb-admin__req">*</span></label>
                                    <input type="text" className="form-control" id="zip" value={data.zip} onChange={(e) => setData('zip', e.target.value)} required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="wb-admin__fieldset">
                        <div className="wb-admin__fieldset-head">
                            <Icon name="cart" size={18} />
                            <div>
                                <h4>Totals &amp; Payment</h4>
                                <p>Grand total is currently &#2547;{money(grandTotal)}.</p>
                            </div>
                        </div>
                        <div className="wb-admin__fieldset-body">
                            <div className="row">
                                <div className="col-md-4 form-group">
                                    <label>Subtotal (&#2547;)</label>
                                    <input type="text" className="form-control" value={money(order.payment)} disabled />
                                    <small className="wb-admin__hint">Calculated from the order items above.</small>
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="shipping">Shipping (&#2547;) <span className="wb-admin__req">*</span></label>
                                    <input type="number" step="0.01" min="0" className="form-control" id="shipping" value={data.shipping} onChange={(e) => setData('shipping', e.target.value)} required />
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="discount">Discount (&#2547;)</label>
                                    <input type="number" step="0.01" min="0" className="form-control" id="discount" value={data.discount} onChange={(e) => setData('discount', e.target.value)} />
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-md-4 form-group">
                                    <label htmlFor="payment_method">Payment Method <span className="wb-admin__req">*</span></label>
                                    <select className="form-control" id="payment_method" value={data.payment_method} onChange={(e) => setData('payment_method', e.target.value)}>
                                        <option value="cod">Cash on Delivery</option>
                                        <option value="bkash">bKash</option>
                                    </select>
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="cod_amount">Cash to Collect (&#2547;)</label>
                                    <input type="number" step="0.01" min="0" className="form-control" id="cod_amount" value={data.cod_amount} onChange={(e) => setData('cod_amount', e.target.value)} placeholder={money(grandTotal)} />
                                    <small className="wb-admin__hint">Only used for Cash on Delivery.</small>
                                </div>
                                <div className="col-md-4 form-group">
                                    <label htmlFor="paid">Amount Already Paid (&#2547;)</label>
                                    <input type="number" step="0.01" min="0" className="form-control" id="paid" value={data.paid} onChange={(e) => setData('paid', e.target.value)} />
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-md-6 form-group">
                                    <label htmlFor="bkashnumber">bKash / Payment Number</label>
                                    <input type="text" className="form-control" id="bkashnumber" value={data.bkashnumber} onChange={(e) => setData('bkashnumber', e.target.value)} />
                                </div>
                                <div className="col-md-6 form-group">
                                    <label htmlFor="txid">Transaction ID</label>
                                    <input type="text" className="form-control" id="txid" value={data.txid} onChange={(e) => setData('txid', e.target.value)} />
                                </div>
                            </div>
                            <div className="form-group">
                                <label htmlFor="message">Internal Note</label>
                                <textarea className="form-control" rows="3" id="message" value={data.message} onChange={(e) => setData('message', e.target.value)} placeholder="Not shown to the customer" />
                            </div>
                        </div>
                    </div>

                    <div className="wb-admin__form-actions">
                        <button type="submit" className="wb-btn wb-btn--accent" disabled={processing}>
                            {processing ? 'Saving…' : 'Save Changes'}
                        </button>
                        <Link href={`/admin/orders/${order.id}`} className="wb-btn wb-btn--ghost">Cancel</Link>
                        <span>Order #{order.id} &middot; {items.length} item(s)</span>
                    </div>
                </form>
            </div>
        </>
    );
}

OrderEdit.layout = (page) => <AdminLayout title="Edit Order">{page}</AdminLayout>;
