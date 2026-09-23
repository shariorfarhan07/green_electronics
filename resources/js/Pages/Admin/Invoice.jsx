import React, { useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { money } from '../../money';

// Deliberately has no layout: the invoice is a standalone print document.
// Its styles (including the @page rules) live in app.scss.
export default function Invoice({ order, items = [], images = {} }) {
    useEffect(() => {
        document.body.classList.add('invoice-body');
        return () => document.body.classList.remove('invoice-body');
    }, []);

    const grandTotal = Number(order.payment) + Number(order.shipping) - Number(order.discount || 0);

    return (
        <>
            <div className="invoice-toolbar">
                <Link href="/admin/orders">&larr; Back to Orders</Link>
                <div className="invoice-toolbar-actions">
                    <a href={`tel:${String(order.phone || '').replace(/[^0-9+]/g, '')}`}>&#9742; Call Customer &middot; {order.phone}</a>
                    <Link href={`/admin/orders/${order.id}/edit`}>Edit Order</Link>
                    <button type="button" className="btn-accent" onClick={() => window.print()}>Print Invoice</button>
                </div>
            </div>

            <div className="invoice-page">
                <div className="invoice-head">
                    <div>
                        <div className="invoice-brand">Green<span>Electronics</span></div>
                        <div className="invoice-brand-meta">
                            Call: 01875589192<br />
                            greenelectronicsbd@gmail.com
                        </div>
                    </div>
                    <div className="invoice-title">
                        <h1>Invoice</h1>
                        <div className="invoice-id">#{String(order.id).padStart(6, '0')}</div>
                        <div className="invoice-id">{order.date}</div>
                        <div className="invoice-status">{order.status}</div>
                    </div>
                </div>

                <div className="invoice-meta-grid">
                    <div className="invoice-meta-block">
                        <h4>Bill To</h4>
                        <p style={{ fontWeight: 600 }}>{order.name}</p>
                        <p>{order.address}</p>
                        <p>{order.city}, {order.division} &mdash; {order.zip}</p>
                        <p className="muted">{order.phone}</p>
                        {order.email && <p className="muted">{order.email}</p>}
                    </div>
                    <div className="invoice-meta-block">
                        <h4>Payment</h4>
                        <p>{order.payment_method === 'bkash' ? 'Paid via bKash' : 'Cash on Delivery'}</p>
                        {order.bkashnumber && order.bkashnumber !== 'cash on delevery' && (
                            <p className="muted">Number: {order.bkashnumber}</p>
                        )}
                        {order.txid && order.txid !== 'cash on delevery' && (
                            <p className="muted">Transaction ID: {order.txid}</p>
                        )}
                    </div>
                </div>

                <table className="invoice-items">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {items.map((item, index) => (
                            <tr key={item.id}>
                                <td className="muted">{index + 1}</td>
                                <td>
                                    <div className="invoice-item">
                                        <span className="invoice-thumb">
                                            {images[item.item_id] && <img src={images[item.item_id]} alt={item.item_name} />}
                                        </span>
                                        <span style={{ fontWeight: 600 }}>{item.item_name}</span>
                                    </div>
                                </td>
                                <td>{item.qty}</td>
                                <td>&#2547;{money(item.item_price)}</td>
                                <td>&#2547;{money(item.qty * item.item_price)}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <div className="invoice-totals">
                    <div className="row"><span>Subtotal</span><span>&#2547;{money(order.payment)}</span></div>
                    <div className="row"><span>Shipping</span><span>&#2547;{money(order.shipping)}</span></div>
                    {order.discount > 0 && (
                        <div className="row"><span>Discount</span><span>&minus;&#2547;{money(order.discount)}</span></div>
                    )}
                    <div className="row grand"><span>Grand Total</span><span>&#2547;{money(grandTotal)}</span></div>
                    {order.paid > 0 && (
                        <div className="row"><span>Already Paid</span><span>&minus;&#2547;{money(order.paid)}</span></div>
                    )}
                    {order.payment_method === 'cod' && order.cod_amount > 0 && (
                        <div className="row" style={{ fontWeight: 700, color: 'var(--ink)' }}>
                            <span>Collect on Delivery</span><span>&#2547;{money(order.cod_amount)}</span>
                        </div>
                    )}
                </div>

                <div className="invoice-footnote">
                    Thank you for shopping with Green Electronics &mdash; Bangladesh&rsquo;s store for Arduino, sensors, robotics &amp; 3D printing.
                </div>
            </div>
        </>
    );
}
