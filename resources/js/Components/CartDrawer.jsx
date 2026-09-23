import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Icon from './Icon';
import { setCartQuantity } from '../cart';
import { money } from '../money';

// Mini cart: shows the actual line items, which come from the shared `cart`
// prop so the drawer works on every page.
export default function CartDrawer({ open, onClose }) {
    const { cart } = usePage().props;
    const items = cart?.items || [];

    return (
        <>
            <div className={`wb-offcanvas__backdrop ${open ? 'is-open' : ''}`} onClick={onClose} />
            <div className={`wb-offcanvas wb-offcanvas--right ${open ? 'is-open' : ''}`}>
                <div className="wb-offcanvas__head">
                    <span>Your Cart {cart?.totalQuantity > 0 ? `(${cart.totalQuantity})` : ''}</span>
                    <button type="button" className="wb-offcanvas__close" aria-label="Close cart" onClick={onClose}>
                        <Icon name="close" />
                    </button>
                </div>
                <div className="wb-offcanvas__body" style={{ display: 'flex', flexDirection: 'column' }}>
                    {items.length > 0 ? (
                        <>
                            <div style={{ flex: 1, overflowY: 'auto' }}>
                                {items.map((item) => (
                                    <div className="wb-cart-drawer__item" key={item.id}>
                                        <div className="wb-cart-drawer__thumb">
                                            <img src={item.image} alt={item.name} />
                                        </div>
                                        <div className="wb-cart-drawer__info">
                                            <h6>{item.name}</h6>
                                            <span className="mono" style={{ fontSize: '.78rem', color: 'var(--ink-soft)' }}>
                                                Qty: {item.quantity}
                                            </span>
                                            <div className="wb-cart-drawer__price">&#2547;{money(item.price * item.quantity)}</div>
                                        </div>
                                        <button
                                            type="button"
                                            className="wb-cart-drawer__remove"
                                            aria-label={`Remove ${item.name}`}
                                            onClick={() => setCartQuantity(item.id, 0)}
                                        >
                                            <Icon name="close" size={16} />
                                        </button>
                                    </div>
                                ))}
                            </div>
                            <div className="wb-cart-drawer__foot">
                                <div className="wb-cart-drawer__total">
                                    <span>Subtotal</span><span>&#2547;{money(cart.totalPrice)}</span>
                                </div>
                                <Link href="/cart" onClick={onClose} className="wb-btn wb-btn--ghost wb-btn--block mb-2">View Cart</Link>
                                <Link href="/checkout" onClick={onClose} className="wb-btn wb-btn--accent wb-btn--block">Checkout</Link>
                            </div>
                        </>
                    ) : (
                        <div className="wb-empty-state" style={{ padding: '3rem 1rem' }}>
                            <Icon name="cart" size={40} />
                            <p>Your cart is empty.</p>
                            <Link href="/shop" onClick={onClose} className="wb-btn wb-btn--accent">Start Shopping</Link>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
