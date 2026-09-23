import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '../../Layout';
import Icon from '../../Components/Icon';
import { money } from '../../money';

// The customer's account overview (route: /account).
export default function Dashboard({ recentOrders = [], orderItems = {}, images = {}, orderCount, wishlistCount }) {
    const { auth, flash, store } = usePage().props;
    const user = auth?.user;

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">My Account</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Account</span>
                    </nav>
                </div>
            </div>

            <div className="container" style={{ padding: '2.5rem 15px 4rem' }}>
                {flash?.status && <div className="alert alert-success">{flash.status}</div>}

                <div className="wb-account-grid">
                    <aside className="wb-account-side">
                        <div className="wb-account-profile">
                            <div className="wb-account-avatar">{(user?.name || '?').charAt(0).toUpperCase()}</div>
                            <div className="wb-account-profile__name">{user?.name}</div>
                            <div className="wb-account-profile__email">{user?.email}</div>
                        </div>

                        <div className="wb-account-stats">
                            <div className="wb-account-stat">
                                <div className="wb-account-stat__num">{orderCount}</div>
                                <div className="wb-account-stat__label">Orders</div>
                            </div>
                            <div className="wb-account-stat">
                                <div className="wb-account-stat__num">{wishlistCount}</div>
                                <div className="wb-account-stat__label">Wishlist</div>
                            </div>
                        </div>

                        <nav className="wb-account-nav">
                            <Link href="/account" className="wb-account-nav__link is-active"><Icon name="user" size={16} /> Overview</Link>
                            <Link href="/account/orders" className="wb-account-nav__link"><Icon name="box" size={16} /> My Orders</Link>
                            <Link href="/wishlist" className="wb-account-nav__link"><Icon name="heart" size={16} /> Wishlist</Link>
                            {auth?.isAdmin && (
                                <Link href="/admin/products" className="wb-account-nav__link"><Icon name="shield" size={16} /> Admin Panel</Link>
                            )}
                        </nav>

                        <Link href="/logout" method="post" as="button" className="wb-btn wb-btn--ghost wb-btn--block">
                            <Icon name="reply" size={16} /> Log out
                        </Link>
                    </aside>

                    <div className="wb-account-main">
                        <div className="wb-account-welcome">
                            <div>
                                <h3>Welcome back, {(user?.name || '').split(' ')[0]}</h3>
                                <p>Track your orders and manage your account from here.</p>
                            </div>
                            <Link href="/shop" className="wb-btn wb-btn--accent"><Icon name="grid" size={16} /> Continue Shopping</Link>
                        </div>

                        <div className="wb-summary">
                            <div className="wb-summary__title" style={{ display: 'flex', alignItems: 'center', gap: '.75rem' }}>
                                Recent Orders
                                {orderCount > 0 && (
                                    <Link href="/account/orders" style={{ marginLeft: 'auto', fontSize: '.82rem', fontWeight: 600, display: 'inline-flex', alignItems: 'center', gap: '.2rem' }}>
                                        View all <Icon name="chevron-right" size={12} />
                                    </Link>
                                )}
                            </div>

                            {recentOrders.length > 0 ? recentOrders.map((order) => {
                                const items = orderItems[order.id] || [];
                                const firstItem = items[0];
                                const thumb = firstItem ? images[firstItem.item_id] : null;

                                return (
                                    <div className="wb-order-card" key={order.id}>
                                        <div className="wb-order-thumb">
                                            {thumb ? <img src={thumb} alt={firstItem.item_name} /> : <Icon name="box" size={20} />}
                                        </div>
                                        <div>
                                            <div className="wb-order-card__id">Order #{order.id}</div>
                                            <div className="wb-order-card__meta">
                                                {items.length} item{items.length === 1 ? '' : 's'}
                                                {' '}&middot; &#2547;{money(order.grand_total)}
                                                {' '}&middot; {order.created_at ? new Date(order.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : order.date}
                                            </div>
                                        </div>
                                        <div className="wb-order-card__right">
                                            <span className={`wb-status wb-status--${String(order.status).toLowerCase().replace(/\s+/g, '-')}`}>{order.status}</span>
                                            <Link href={`/account/orders/${order.id}`} className="wb-btn wb-btn--ghost wb-btn--sm">
                                                View <Icon name="chevron-right" size={14} />
                                            </Link>
                                        </div>
                                    </div>
                                );
                            }) : (
                                <div style={{ textAlign: 'center', padding: '2.5rem 1rem' }}>
                                    <Icon name="box" size={36} />
                                    <p style={{ margin: '.8rem 0 1.2rem', color: 'var(--ink-soft)' }}>You haven&rsquo;t placed any orders yet.</p>
                                    <Link href="/shop" className="wb-btn wb-btn--accent">Start Shopping</Link>
                                </div>
                            )}
                        </div>

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
                </div>
            </div>
        </>
    );
}

Dashboard.layout = (page) => <Layout>{page}</Layout>;
