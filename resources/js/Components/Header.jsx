import React, { useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import Icon from './Icon';

// Every destination is an Inertia Link (and the search submits through the
// router) so navigating from the header never triggers a full page reload.
export default function Header({ onOpenMenu, onOpenCart }) {
    const { auth, cart, navCategories = [], ordersDisabled } = usePage().props;
    const [searchText, setSearchText] = useState('');

    function submitSearch(e) {
        e.preventDefault();
        router.get('/shop', searchText ? { searchText } : {});
    }

    return (
        <>
            {ordersDisabled ? (
                <div className="wb-topbar wb-topbar--notice">
                    Online ordering is paused right now &mdash; please call or WhatsApp us to place your order
                </div>
            ) : (
                <div className="wb-topbar d-none d-md-block">Free delivery inside Dhaka on orders above &#2547;2000 &middot; Cash on delivery available nationwide</div>
            )}

            <header className="wb-header">
                <div className="wb-header__bar">
                    <button type="button" className="wb-mobile-toggle" aria-label="Open menu" onClick={onOpenMenu}>
                        <Icon name="menu" size={26} />
                    </button>

                    <Link href="/" className="wb-logo">Green<span>Electronics</span></Link>

                    <form className="wb-header__search" onSubmit={submitSearch}>
                        <input
                            type="text"
                            name="searchText"
                            placeholder="Search for Arduino, sensors, modules&hellip;"
                            autoComplete="off"
                            value={searchText}
                            onChange={(e) => setSearchText(e.target.value)}
                        />
                        <button type="submit" aria-label="Search"><Icon name="search" /></button>
                    </form>

                    <div className="wb-header__actions">
                        <Link href={auth?.user ? '/wishlist' : '/login'} className="wb-header__action">
                            <Icon name="heart" />
                            <span className="wb-header__action-label">Wishlist</span>
                        </Link>
                        <Link href={auth?.user ? '/account' : '/login'} className="wb-header__action">
                            <Icon name="user" />
                            <span className="wb-header__action-label">{auth?.user ? auth.user.name : 'Account'}</span>
                        </Link>
                        {auth?.user && (
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                className="wb-header__action d-none d-lg-inline-flex"
                                style={{ border: 'none', background: 'none' }}
                                title="Log out"
                            >
                                <Icon name="reply" />
                                <span className="wb-header__action-label">Logout</span>
                            </Link>
                        )}
                        <button type="button" className="wb-header__action" style={{ border: 'none', background: 'none' }} onClick={onOpenCart}>
                            <Icon name="cart" />
                            {cart && cart.totalQuantity > 0 && <span className="wb-badge">{cart.totalQuantity}</span>}
                            <span className="wb-header__action-label">Cart</span>
                        </button>
                    </div>
                </div>

                <nav className="wb-nav">
                    <ul className="wb-nav__list">
                        <li className="wb-mega">
                            <Link href="/shop" className="wb-nav__link wb-nav__categories-btn">
                                <Icon name="grid" size={17} /> All Categories
                            </Link>
                            <div className="wb-mega__panel">
                                {navCategories.map((cat) => (
                                    <div className="wb-mega__section" key={cat.id}>
                                        <Link href={`/shop?category=${cat.slug}`} className="wb-mega__item">
                                            <Icon name={cat.icon} size={18} />
                                            <span>{cat.name}</span>
                                            {cat.children?.length > 0 && <Icon name="chevron-right" size={14} className="wb-mega__chev" />}
                                        </Link>
                                        {cat.children?.length > 0 && (
                                            <div className="wb-mega__sub">
                                                <div className="wb-mega__sub-head">
                                                    <Icon name={cat.icon} size={18} />
                                                    <span>{cat.name}<small>{cat.blurb}</small></span>
                                                </div>
                                                <div className="wb-mega__sub-grid">
                                                    {cat.children.map((child) => (
                                                        <Link key={child.id} href={`/shop?category=${child.slug}`} className="wb-mega__sub-link">{child.name}</Link>
                                                    ))}
                                                </div>
                                                <Link href={`/shop?category=${cat.slug}`} className="wb-mega__sub-all">View all {cat.name} <Icon name="chevron-right" size={13} /></Link>
                                            </div>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </li>
                        <li><Link href="/" className="wb-nav__link">Home</Link></li>
                        <li><Link href="/shop" className="wb-nav__link">Shop</Link></li>
                        <li><Link href="/about" className="wb-nav__link">About</Link></li>
                        <li><Link href="/contact" className="wb-nav__link">Contact</Link></li>
                    </ul>
                </nav>
            </header>
        </>
    );
}
