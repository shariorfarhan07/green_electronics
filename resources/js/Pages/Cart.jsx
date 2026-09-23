import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import { setCartQuantity } from '../cart';
import { money } from '../money';

// Indicative only — checkout derives the real shipping cost from the division.
const SHIPPING_OPTIONS = [
    { cost: 60, label: 'Inside Dhaka city' },
    { cost: 100, label: 'Outside Dhaka city (Sundarban courier)' },
];

export default function Cart({ cartItems }) {
    const items = Object.values(cartItems?.items || {});
    const subtotal = cartItems?.totalPrice || 0;
    const [shipping, setShipping] = useState(null);

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">Your Cart</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Cart</span>
                    </nav>
                </div>
            </div>

            <div className="wb-cart">
                <div className="container">
                    <div className="table-responsive mb-4">
                        <table className="wb-line-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {items.map((item) => (
                                    <tr key={item.data.id}>
                                        <td>
                                            <div className="wb-line__thumb">
                                                <img src={item.data.primary_image_url} alt={item.data.name} />
                                            </div>
                                        </td>
                                        <td><Link href={`/products/${item.data.id}`} className="wb-line__name">{item.data.name}</Link></td>
                                        <td className="wb-line__price">&#2547;{money(item.price)}</td>
                                        <td>
                                            <div className="wb-qty">
                                                <button
                                                    type="button"
                                                    aria-label="Decrease"
                                                    onClick={() => setCartQuantity(item.data.id, item.quantity - 1, ['cartItems'])}
                                                >
                                                    <Icon name="minus" size={14} />
                                                </button>
                                                <input type="text" value={item.quantity} readOnly />
                                                <button
                                                    type="button"
                                                    aria-label="Increase"
                                                    onClick={() => setCartQuantity(item.data.id, item.quantity + 1, ['cartItems'])}
                                                >
                                                    <Icon name="plus" size={14} />
                                                </button>
                                            </div>
                                        </td>
                                        <td className="wb-line__price">&#2547;{money(item.price * item.quantity)}</td>
                                        <td>
                                            <button
                                                type="button"
                                                className="wb-line__remove"
                                                aria-label="Remove"
                                                onClick={() => setCartQuantity(item.data.id, 0, ['cartItems'])}
                                            >
                                                <Icon name="trash" size={17} />
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="row">
                        <div className="col-md-7 mb-4">
                            <div className="wb-summary">
                                <div className="wb-summary__title">Shipping</div>
                                {SHIPPING_OPTIONS.map((option) => (
                                    <label className="wb-shipping-option" key={option.cost}>
                                        <input
                                            type="radio"
                                            name="shippingmethod"
                                            value={option.cost}
                                            checked={shipping === option.cost}
                                            onChange={() => setShipping(option.cost)}
                                        />
                                        {' '}{option.label} &mdash; &#2547;{money(option.cost)}
                                    </label>
                                ))}
                            </div>
                        </div>
                        <div className="col-md-5">
                            <div className="wb-summary">
                                <div className="wb-summary__title">Cart Totals</div>
                                <div className="wb-summary__row"><span>Subtotal</span><span>&#2547;{money(subtotal)}</span></div>
                                <div className="wb-summary__row"><span>Shipping</span><span>{shipping ? `৳${money(shipping)}` : 'Select shipping'}</span></div>
                                <div className="wb-summary__row wb-summary__row--total"><span>Total</span><span>&#2547;{money(subtotal + (shipping || 0))}</span></div>
                                <Link href="/checkout" className="wb-btn wb-btn--accent wb-btn--block mt-3">Proceed to Checkout <Icon name="chevron-right" size={16} /></Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Cart.layout = (page) => <Layout>{page}</Layout>;
