import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '../../Layout';
import Icon from '../../Components/Icon';
import Pagination from '../../Components/Pagination';
import { money } from '../../money';

export default function Orders({ orders }) {
    const { flash, store } = usePage().props;
    const rows = orders?.data || [];

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">My Orders</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span>
                        <Link href="/account" style={{ color: 'inherit' }}>Account</Link> <span className="brd-separetor">/</span>
                        <span className="active">Orders</span>
                    </nav>
                </div>
            </div>

            <div className="container" style={{ padding: '2.5rem 15px 4rem' }}>
                {flash?.success && <div className="alert alert-success">{flash.success}</div>}

                {rows.length > 0 ? (
                    <>
                        {rows.map((order) => (
                            <div className="wb-order-card" key={order.id}>
                                <div>
                                    <div className="wb-order-card__id">Order #{order.id}</div>
                                    <div className="wb-order-card__meta">
                                        Placed {order.created_at ? new Date(order.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : order.date}
                                        {' '}&middot; &#2547;{money(order.grand_total)}
                                    </div>
                                </div>
                                <div className="wb-order-card__right">
                                    <span className={`wb-status wb-status--${String(order.status).toLowerCase().replace(/\s+/g, '-')}`}>{order.status}</span>
                                    <Link href={`/account/orders/${order.id}`} className="wb-btn wb-btn--ghost wb-btn--sm">
                                        View Details <Icon name="chevron-right" size={14} />
                                    </Link>
                                </div>
                            </div>
                        ))}

                        <div className="mt-4"><Pagination paginator={orders} /></div>
                    </>
                ) : (
                    <div className="wb-summary" style={{ textAlign: 'center', padding: '3rem 1.5rem' }}>
                        <Icon name="box" size={38} />
                        <h4 style={{ marginTop: '1rem' }}>No orders yet</h4>
                        <p style={{ color: 'var(--ink-soft)' }}>When you place an order it will show up here with live status updates.</p>
                        <Link href="/shop" className="wb-btn wb-btn--accent mt-2">Start Shopping</Link>
                    </div>
                )}

                <div className="wb-summary mt-4" style={{ display: 'flex', alignItems: 'center', gap: '1rem', flexWrap: 'wrap' }}>
                    <div>
                        <div style={{ fontWeight: 700 }}>Need help with an order?</div>
                        <div style={{ fontSize: '.85rem', color: 'var(--ink-soft)' }}>Our team is available 10am&ndash;8pm, Saturday to Thursday.</div>
                    </div>
                    <a href={`tel:${store?.phone}`} className="wb-btn wb-btn--accent" style={{ marginLeft: 'auto' }}>
                        <Icon name="phone" size={16} /> Call Green Electronics
                    </a>
                </div>
            </div>
        </>
    );
}

Orders.layout = (page) => <Layout>{page}</Layout>;
