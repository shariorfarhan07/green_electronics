import React from 'react';
import { Link } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import Pagination from '../../Components/Pagination';
import { money } from '../../money';

export default function Orders({ orders }) {
    const rows = orders?.data || [];

    return (
        <>
            <div className="wb-admin__panel">
                <div className="wb-admin__panel-head">
                    <h4>All Orders</h4>
                </div>

                {rows.length > 0 ? (
                    <div className="wb-admin__table-wrap">
                        <table className="wb-admin__table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {rows.map((order) => (
                                    <tr key={order.id}>
                                        <td className="mono">#{order.id}</td>
                                        <td style={{ fontWeight: 600 }}>{order.name}</td>
                                        <td><div className="wb-admin__cell-clamp" title={order.address}>{order.address}</div></td>
                                        <td>
                                            <a href={`tel:${String(order.phone || '').replace(/[^0-9+]/g, '')}`} className="wb-btn wb-btn--sm wb-btn--ghost" title={`Call ${order.name}`}>
                                                <Icon name="phone" size={13} /> {order.phone}
                                            </a>
                                        </td>
                                        <td>{order.date}</td>
                                        <td>
                                            <div style={{ fontWeight: 600 }}>{order.payment_method === 'bkash' ? 'bKash' : 'Cash on Delivery'}</div>
                                            <div style={{ fontSize: '.78rem', color: 'var(--ink-faint)' }}>&#2547;{money(order.grand_total)}</div>
                                        </td>
                                        <td><span className={`wb-status wb-status--${String(order.status).toLowerCase().replace(/\s+/g, '-')}`}>{order.status}</span></td>
                                        <td>
                                            <div className="wb-admin__actions">
                                                <Link href={`/admin/orders/${order.id}`} className="wb-admin__icon-btn" title="View Invoice"><Icon name="box" size={14} /></Link>
                                                <Link href={`/admin/orders/${order.id}/edit`} className="wb-admin__icon-btn" title="Edit"><Icon name="edit" size={14} /></Link>
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
                        <p>No orders yet.</p>
                    </div>
                )}
            </div>

            <div className="mt-3"><Pagination paginator={orders} /></div>
        </>
    );
}

Orders.layout = (page) => <AdminLayout title="Orders">{page}</AdminLayout>;
