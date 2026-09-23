import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Icon from './Icon';

// Mobile navigation drawer, shown under the header's hamburger below 992px.
export default function OffCanvasMenu({ open, onClose }) {
    const { auth, navCategories = [] } = usePage().props;

    return (
        <>
            <div className={`wb-offcanvas__backdrop ${open ? 'is-open' : ''}`} onClick={onClose} />
            <div className={`wb-offcanvas ${open ? 'is-open' : ''}`}>
                <div className="wb-offcanvas__head">
                    <span>Menu</span>
                    <button type="button" className="wb-offcanvas__close" aria-label="Close menu" onClick={onClose}><Icon name="close" /></button>
                </div>
                <div className="wb-offcanvas__body">
                    <nav>
                        <Link href="/" onClick={onClose}><span>Home</span> <Icon name="chevron-right" size={16} /></Link>
                        <Link href="/shop" onClick={onClose}><span>Shop All</span> <Icon name="chevron-right" size={16} /></Link>
                        <Link href={auth?.user ? '/wishlist' : '/login'} onClick={onClose}><span>Wishlist</span> <Icon name="chevron-right" size={16} /></Link>
                        <Link href="/about" onClick={onClose}><span>About</span> <Icon name="chevron-right" size={16} /></Link>
                        <Link href="/contact" onClick={onClose}><span>Contact</span> <Icon name="chevron-right" size={16} /></Link>
                        {auth?.user ? (
                            <>
                                <Link href="/account/orders" onClick={onClose}><span>My Orders</span> <Icon name="chevron-right" size={16} /></Link>
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    style={{ border: 'none', background: 'none', width: '100%', textAlign: 'left', padding: 0, font: 'inherit', color: 'inherit', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}
                                >
                                    <span>Logout</span> <Icon name="reply" size={16} />
                                </Link>
                            </>
                        ) : (
                            <Link href="/login" onClick={onClose}><span>Login / Register</span> <Icon name="chevron-right" size={16} /></Link>
                        )}
                    </nav>
                    <div style={{ marginTop: '1rem' }}>
                        <h6 className="mono" style={{ textTransform: 'uppercase', fontSize: '.72rem', letterSpacing: '.05em', color: 'var(--ink-faint)', margin: '1rem 0 .25rem' }}>Categories</h6>
                        {navCategories.map((cat) => (
                            <details className="wb-offcanvas__cat-group" key={cat.id}>
                                <summary>
                                    <span style={{ display: 'flex', alignItems: 'center', gap: '.5rem' }}><Icon name={cat.icon} size={17} /> {cat.name}</span>
                                    <Icon name="chevron-down" size={16} />
                                </summary>
                                <ul>
                                    {cat.children?.map((child) => (
                                        <li key={child.id}><Link href={`/shop?category=${child.slug}`} onClick={onClose}>{child.name}</Link></li>
                                    ))}
                                    <li><Link href={`/shop?category=${cat.slug}`} onClick={onClose} style={{ fontWeight: 600, color: 'var(--accent)' }}>View all {cat.name}</Link></li>
                                </ul>
                            </details>
                        ))}
                    </div>
                </div>
            </div>
        </>
    );
}
