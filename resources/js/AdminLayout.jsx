import React, { useEffect, useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import Icon from './Components/Icon';

export default function AdminLayout({ children, title = 'Dashboard' }) {
    const { auth, unreadMessages = 0, url } = usePage().props;
    const page = usePage();
    const [sidebarOpen, setSidebarOpen] = useState(false);

    useEffect(() => {
        return router.on('navigate', () => setSidebarOpen(false));
    }, []);

    const path = (page.url || url || '').split('?')[0];
    const isActive = (href, exact = true) => (exact ? path === href : path.startsWith(href));
    const navClass = (active) => `wb-admin__nav-link ${active ? 'is-active' : ''}`;

    return (
        <div className="wb-admin">
            <div className={`wb-offcanvas__backdrop ${sidebarOpen ? 'is-open' : ''}`} onClick={() => setSidebarOpen(false)} />

            <aside className={`wb-admin__sidebar ${sidebarOpen ? 'is-open' : ''}`}>
                <div className="wb-admin__brand">
                    <Link href="/admin/products" style={{ color: '#fff' }}>Green<span>Electronics</span></Link>
                    <button
                        type="button"
                        className="wb-offcanvas__close"
                        aria-label="Close menu"
                        style={{ background: 'rgba(255,255,255,.1)', color: '#fff' }}
                        onClick={() => setSidebarOpen(false)}
                    >
                        <Icon name="close" size={16} />
                    </button>
                </div>
                <nav className="wb-admin__nav">
                    <div className="wb-admin__nav-group-title">Catalogue</div>
                    <Link href="/admin/products" className={navClass(isActive('/admin/products'))}>
                        <Icon name="grid" size={17} /> All Products
                    </Link>
                    <Link href="/admin/products/create" className={navClass(isActive('/admin/products/create'))}>
                        <Icon name="plus" size={17} /> Add New Product
                    </Link>
                    <Link href="/admin/categories" className={navClass(isActive('/admin/categories', false))}>
                        <Icon name="filter" size={17} /> Categories
                    </Link>
                    <Link href="/admin/products/bulk" className={navClass(isActive('/admin/products/bulk'))}>
                        <Icon name="printer" size={17} /> Bulk Products
                    </Link>
                    <div className="wb-admin__nav-group-title">Sales</div>
                    <Link href="/admin/orders" className={navClass(isActive('/admin/orders', false))}>
                        <Icon name="box" size={17} /> Orders
                    </Link>
                    <div className="wb-admin__nav-group-title">Inbox</div>
                    <Link href="/admin/messages" className={navClass(isActive('/admin/messages', false))}>
                        <Icon name="mail" size={17} /> Messages
                        {unreadMessages > 0 && <span className="wb-admin__nav-count">{unreadMessages}</span>}
                    </Link>
                    <div className="wb-admin__nav-group-title">Store</div>
                    <Link href="/admin/settings" className={navClass(isActive('/admin/settings', false))}>
                        <Icon name="wrench" size={17} /> Settings
                    </Link>
                </nav>
                <div className="wb-admin__sidebar-foot">
                    <Link href="/"><Icon name="chevron-left" size={15} /> Back to Store</Link>
                    <Link
                        href="/logout"
                        method="post"
                        as="button"
                        style={{ border: 'none', background: 'none', padding: 0, font: 'inherit', color: 'inherit', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '.5rem', marginTop: '.5rem' }}
                    >
                        <Icon name="reply" size={15} /> Log out
                    </Link>
                </div>
            </aside>

            <div className="wb-admin__main">
                <header className="wb-admin__topbar">
                    <button type="button" className="wb-admin__toggle" aria-label="Open menu" onClick={() => setSidebarOpen(true)}>
                        <Icon name="menu" size={20} />
                    </button>
                    <h1 className="wb-admin__topbar-title">{title}</h1>
                    <div style={{ marginLeft: 'auto', display: 'flex', alignItems: 'center', gap: '.6rem' }}>
                        <span style={{ fontSize: '.85rem', color: 'var(--ink-soft)' }} className="d-none d-sm-inline">{auth?.user?.name || 'Admin'}</span>
                        <div style={{ width: 34, height: 34, borderRadius: '50%', background: 'var(--accent-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                            <Icon name="user" size={16} />
                        </div>
                    </div>
                </header>

                <div className="wb-admin__content">{children}</div>
            </div>
        </div>
    );
}
