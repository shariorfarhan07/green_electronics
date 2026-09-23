import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '../../Layout';
import Icon from '../../Components/Icon';
import { money } from '../../money';

export default function OrderDetail({ order, items = [], images = {}, timeline = [], stage = 0, isCancelled }) {
    const { flash, store } = usePage().props;

    const stageCopy = stage <= 1
        ? 'We have received your order and our representative will confirm it with you shortly.'
        : stage === 2
            ? 'Your order is on its way. Keep your phone reachable for the delivery call.'
            : 'This order has been delivered. Thank you for shopping with us.';

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">Order #{order.id}</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span>
                        <Link href="/account/orders" style={{ color: 'inherit' }}>My Orders</Link> <span className="brd-separetor">/</span>
                        <span className="active">#{order.id}</span>
                    </nav>
                </div>
            </div>

            <div className="container" style={{ padding: '2.5rem 15px 4rem' }}>
                {flash?.success && <div className="alert alert-success">{flash.success}</div>}

                <div className="row">
                    <div className="col-lg-8 mb-4">
                        <div className="wb-summary mb-4">
                            <div className="wb-summary__title" style={{ display: 'flex', alignItems: 'center', gap: '.75rem', flexWrap: 'wrap' }}>
                                Order Status
                                <span className={`wb-status wb-status--${String(order.status).toLowerCase().replace(/\s+/g, '-')}`} style={{ marginLeft: 'auto' }}>{order.status}</span>
                            </div>

                            {isCancelled ? (
                                <p style={{ color: 'var(--danger)', fontWeight: 600, margin: 0 }}>This order was cancelled. Call us if you think this is a mistake.</p>
                            ) : (
                                <>
                                    <div className="wb-timeline">
                                        {timeline.map((step, i) => {
                                            const n = i + 1;
                                            const state = n < stage ? 'is-done' : n === stage ? 'is-current' : '';
                                            return (
                                                <div className={`wb-timeline__step ${state}`} key={step}>
                                                    <div className="wb-timeline__dot">
                                                        {n < stage ? <Icon name="check" size={15} /> : n === stage ? <Icon name="truck" size={15} /> : <Icon name="box" size={15} />}
                                                    </div>
                                                    <div className="wb-timeline__label">{step}</div>
                                                </div>
                                            );
                                        })}
                                    </div>
                                    <p style={{ fontSize: '.85rem', color: 'var(--ink-soft)', margin: 0 }}>{stageCopy}</p>
                                </>
                            )}
                        </div>

                        <div className="wb-summary">
                            <div className="wb-summary__title">Items ({items.length})</div>
                            {items.map((item) => (
                                <div className="wb-order-item" key={item.id}>
                                    <div className="wb-order-thumb">
                                        {images[item.item_id]
                                            ? <img src={images[item.item_id]} alt={item.item_name} />
                                            : <Icon name="image" size={18} />}
                                    </div>
                                    <div style={{ flex: 1, minWidth: 0 }}>
                                        <div style={{ fontWeight: 600 }}>{item.item_name}</div>
                                        <div style={{ fontSize: '.8rem', color: 'var(--ink-faint)' }}>
                                            Qty {item.qty} &times; &#2547;{money(item.item_price)}
                                        </div>
                                    </div>
                                    <div style={{ fontWeight: 600, whiteSpace: 'nowrap' }}>&#2547;{money(item.qty * item.item_price)}</div>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="col-lg-4">
                        <div className="wb-summary mb-4">
                            <div className="wb-summary__title">Payment Summary</div>
                            <div className="wb-summary__row"><span>Subtotal</span><span>&#2547;{money(order.payment)}</span></div>
                            <div className="wb-summary__row"><span>Shipping</span><span>&#2547;{money(order.shipping)}</span></div>
                            {order.discount > 0 && (
                                <div className="wb-summary__row"><span>Discount</span><span>&minus;&#2547;{money(order.discount)}</span></div>
                            )}
                            <div className="wb-summary__row wb-summary__row--total"><span>Total</span><span>&#2547;{money(order.grand_total)}</span></div>
                            <div className="wb-summary__row">
                                <span>Payment</span>
                                <span>{order.payment_method === 'bkash' ? 'bKash' : 'Cash on Delivery'}</span>
                            </div>
                            {order.payment_method === 'cod' && order.cod_amount && (
                                <div className="wb-summary__row"><span>Cash to pay</span><span style={{ fontWeight: 700, color: 'var(--ink)' }}>&#2547;{money(order.cod_amount)}</span></div>
                            )}
                        </div>

                        <div className="wb-summary mb-4">
                            <div className="wb-summary__title">Delivery Address</div>
                            <p style={{ margin: 0, lineHeight: 1.7, fontSize: '.9rem' }}>
                                <strong>{order.name}</strong><br />
                                {order.address}<br />
                                {order.city}, {order.division} &mdash; {order.zip}<br />
                                <span style={{ color: 'var(--ink-soft)' }}>{order.phone}</span>
                            </p>
                        </div>

                        <div className="wb-summary">
                            <div className="wb-summary__title">Questions about this order?</div>
                            <p style={{ fontSize: '.85rem', color: 'var(--ink-soft)' }}>
                                Quote order <strong>#{order.id}</strong> when you call and we can help straight away.
                            </p>
                            <a href={`tel:${store?.phone}`} className="wb-btn wb-btn--accent wb-btn--block">
                                <Icon name="phone" size={16} /> Call Green Electronics
                            </a>
                            <p style={{ textAlign: 'center', margin: '.6rem 0 0', fontSize: '.8rem', color: 'var(--ink-faint)' }}>
                                {store?.phoneDisplay}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

OrderDetail.layout = (page) => <Layout>{page}</Layout>;
