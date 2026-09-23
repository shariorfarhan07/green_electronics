import React from 'react';
import { Link, useForm, usePage } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import { money } from '../money';

const DIVISIONS = ['Dhaka', 'Khulna', 'Mymensingh', 'Rajshahi', 'Barisal', 'Rangpur', 'Chittagong'];

// variant (which is now a branch on the `ordersDisabled` shared prop rather
// than a separate server-rendered view).
export default function Checkout({ cartItems }) {
    const { ordersDisabled, store } = usePage().props;
    const items = Object.values(cartItems?.items || {});
    const subtotal = cartItems?.totalPrice || 0;

    const { data, setData, post, processing, errors } = useForm({
        firstname: '', lastname: '', phone: '', email: '',
        address: '', flat: '', city: '', division: 'Dhaka', zip: '',
        paymentmethod: 'cash on delivery', paymentnumber: '', txid: '',
    });

    const shipping = data.division === 'Dhaka' ? 60 : 100;

    function submit(e) {
        e.preventDefault();
        post('/checkout');
    }

    const header = (
        <div className="wb-page-header">
            <div className="container">
                <h2 className="wb-page-header__title">Checkout</h2>
                <nav className="wb-page-header__crumb">
                    <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Checkout</span>
                </nav>
            </div>
        </div>
    );

    const summaryItems = (
        <div className="wb-checkout-items mb-3">
            {items.map((item) => (
                <div className="wb-checkout-items__row" key={item.data.id}>
                    <div className="wb-checkout-items__thumb">
                        <img src={item.data.primary_image_url} alt={item.data.name} />
                        <span className="wb-checkout-items__qty">{item.quantity}</span>
                    </div>
                    <div className="wb-checkout-items__name">{item.data.name}</div>
                    <div className="wb-checkout-items__price">&#2547;{money(item.price * item.quantity)}</div>
                </div>
            ))}
        </div>
    );

    if (ordersDisabled) {
        const waMessage = [
            "Hi Green Electronics, I'd like to order:",
            ...items.map((item) => `- ${item.data.name} x${item.quantity}`),
            `Total: ৳${subtotal}`,
        ].join('\n');

        return (
            <>
                {header}
                <div className="container" style={{ padding: '2.5rem 15px 4rem' }}>
                    <div className="row">
                        <div className="col-lg-7 mb-4">
                            <div className="wb-summary" style={{ textAlign: 'center', padding: '2.5rem 1.75rem' }}>
                                <div className="wb-order-closed__icon"><Icon name="phone" size={30} /></div>
                                <h3 style={{ margin: '1.1rem 0 .5rem' }}>We&rsquo;re taking orders by phone right now</h3>
                                <p style={{ color: 'var(--ink-soft)', maxWidth: 440, margin: '0 auto 1.75rem' }}>
                                    Online checkout is paused for a moment. Call us or send your order on WhatsApp
                                    and our team will confirm it with you directly &mdash; same prices, same delivery.
                                </p>
                                <div style={{ display: 'flex', gap: '.85rem', flexWrap: 'wrap', justifyContent: 'center' }}>
                                    <a href={`tel:${store?.phone}`} className="wb-btn wb-btn--accent">
                                        <Icon name="phone" size={16} /> Call {store?.phoneDisplay}
                                    </a>
                                    <a href={`https://wa.me/${store?.whatsapp}?text=${encodeURIComponent(waMessage)}`} target="_blank" rel="noopener noreferrer" className="wb-btn wb-btn--primary">
                                        <Icon name="whatsapp" size={16} /> WhatsApp Your Order
                                    </a>
                                </div>
                                <p style={{ margin: '1.5rem 0 0', fontSize: '.82rem', color: 'var(--ink-faint)' }}>
                                    Available 10am&ndash;8pm, Saturday to Thursday.
                                </p>
                            </div>
                        </div>
                        <div className="col-lg-5">
                            <div className="wb-summary" style={{ position: 'sticky', top: 'calc(var(--header-h) + 16px)' }}>
                                <div className="wb-summary__title">Your Cart</div>
                                {summaryItems}
                                <div className="wb-summary__row wb-summary__row--total"><span>Subtotal</span><span>&#2547;{money(subtotal)}</span></div>
                                <p style={{ margin: '.8rem 0 0', fontSize: '.8rem', color: 'var(--ink-faint)' }}>Final total includes delivery, confirmed by phone.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }

    return (
        <>
            {header}
            <div className="wb-checkout">
                <div className="container">
                    <form onSubmit={submit}>
                        <div className="row">
                            <div className="col-lg-7 mb-4">
                                <div className="wb-summary mb-4">
                                    <div className="wb-summary__title">Contact Details</div>
                                    <div className="row">
                                        <div className="col-md-6 wb-field">
                                            <label>First name <span className="required">*</span></label>
                                            <input type="text" className="form-control" placeholder="First name" value={data.firstname} onChange={(e) => setData('firstname', e.target.value)} required />
                                            {errors.firstname && <span className="invalid-feedback d-block">{errors.firstname}</span>}
                                        </div>
                                        <div className="col-md-6 wb-field">
                                            <label>Last name <span className="required">*</span></label>
                                            <input type="text" className="form-control" placeholder="Last name" value={data.lastname} onChange={(e) => setData('lastname', e.target.value)} required />
                                        </div>
                                        <div className="col-md-6 wb-field">
                                            <label>Phone <span className="required">*</span></label>
                                            <input type="text" className="form-control" placeholder="017XXXXXXXX" value={data.phone} onChange={(e) => setData('phone', e.target.value)} required />
                                        </div>
                                        <div className="col-md-6 wb-field">
                                            <label>Email <span className="required">*</span></label>
                                            <input type="email" className="form-control" placeholder="Email" value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                                        </div>
                                    </div>
                                </div>

                                <div className="wb-summary mb-4">
                                    <div className="wb-summary__title">Shipping Address</div>
                                    <div className="wb-field">
                                        <label>Address <span className="required">*</span></label>
                                        <input type="text" className="form-control" placeholder="House number and street name" value={data.address} onChange={(e) => setData('address', e.target.value)} required />
                                    </div>
                                    <div className="wb-field">
                                        <label>Apartment / suite (optional)</label>
                                        <input type="text" className="form-control" placeholder="Apartment, suite, unit, etc." value={data.flat} onChange={(e) => setData('flat', e.target.value)} />
                                    </div>
                                    <div className="row">
                                        <div className="col-md-4 wb-field">
                                            <label>City <span className="required">*</span></label>
                                            <input type="text" className="form-control" value={data.city} onChange={(e) => setData('city', e.target.value)} required />
                                        </div>
                                        <div className="col-md-4 wb-field">
                                            <label>Division <span className="required">*</span></label>
                                            <select className="form-control" value={data.division} onChange={(e) => setData('division', e.target.value)} required>
                                                {DIVISIONS.map((d) => <option key={d} value={d}>{d}</option>)}
                                            </select>
                                        </div>
                                        <div className="col-md-4 wb-field">
                                            <label>Zip <span className="required">*</span></label>
                                            <input type="text" className="form-control" value={data.zip} onChange={(e) => setData('zip', e.target.value)} required />
                                        </div>
                                    </div>
                                    <p className="mono" style={{ fontSize: '.8rem', color: 'var(--ink-soft)' }}>Country: <strong>Bangladesh</strong></p>
                                </div>

                                <div className="wb-summary">
                                    <div className="wb-summary__title">Payment Method</div>
                                    <label className="wb-payment-option d-block">
                                        <div className="wb-payment-option__head">
                                            <input
                                                type="radio"
                                                name="paymentmethod"
                                                value="cash on delivery"
                                                checked={data.paymentmethod === 'cash on delivery'}
                                                onChange={(e) => setData('paymentmethod', e.target.value)}
                                            /> Cash on Delivery
                                        </div>
                                        <div className="wb-payment-option__body">Pay with cash at the time of delivery.</div>
                                    </label>
                                    <label className="wb-payment-option d-block">
                                        <div className="wb-payment-option__head">
                                            <input
                                                type="radio"
                                                name="paymentmethod"
                                                value="bkash"
                                                checked={data.paymentmethod === 'bkash'}
                                                onChange={(e) => setData('paymentmethod', e.target.value)}
                                            /> Pay with bKash
                                        </div>
                                        <div className="wb-payment-option__body">
                                            Send payment first, then fill in the details below. A 1.85% bKash &ldquo;Send Money&rdquo; fee applies.<br />
                                            bKash Personal Number: <strong>019XXXXXXXX</strong> or <strong>016XXXXXXXXXX</strong>
                                            <div className="wb-field mt-3">
                                                <label>Your bKash Number</label>
                                                <input type="text" className="form-control" placeholder="017XXXXXXXX" value={data.paymentnumber} onChange={(e) => setData('paymentnumber', e.target.value)} />
                                            </div>
                                            <div className="wb-field">
                                                <label>bKash Transaction ID</label>
                                                <input type="text" className="form-control" placeholder="f5df4g9h8ryt9g6" value={data.txid} onChange={(e) => setData('txid', e.target.value)} />
                                            </div>
                                        </div>
                                    </label>
                                    <div className="wb-note-bn">আপনার অবগতির জন্য জানানো যাচ্ছে যে ঢাকা শহরের বাহিরে যেকোনো অর্ডার এর জন্য পূর্বে বিকাশ পেমেন্ট করতে হবে।</div>
                                </div>
                            </div>

                            <div className="col-lg-5">
                                <div className="wb-summary" style={{ position: 'sticky', top: 'calc(var(--header-h) + 16px)' }}>
                                    <div className="wb-summary__title">Order Summary</div>
                                    {summaryItems}
                                    <div className="wb-summary__row"><span>Subtotal</span><span>&#2547;{money(subtotal)}</span></div>
                                    <div className="wb-summary__row"><span>Shipping</span><span>&#2547;{money(shipping)}</span></div>
                                    <div className="wb-summary__row wb-summary__row--total"><span>Total</span><span>&#2547;{money(subtotal + shipping)}</span></div>
                                    <button type="submit" className="wb-btn wb-btn--accent wb-btn--block mt-3" disabled={processing}>
                                        {processing ? 'Placing order…' : 'Confirm Order'}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

Checkout.layout = (page) => <Layout>{page}</Layout>;
