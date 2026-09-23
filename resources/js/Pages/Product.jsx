import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import { addToCart } from '../cart';
import { money } from '../money';

// Gallery, quantity and tab state are all local to this component — global
// listeners bound once at page load wouldn't rebind after a client-side
// navigation.
export default function Product({ product }) {
    const { auth } = usePage().props;
    const images = product.images?.length ? product.images : [];
    const [activeImage, setActiveImage] = useState(product.primary_image_url);
    const [qty, setQty] = useState(1);
    const [activeTab, setActiveTab] = useState('description');
    const inStock = product.stock > 0;

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">{product.name}</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span>
                        <Link href="/shop" style={{ color: 'inherit' }}>Shop</Link> <span className="brd-separetor">/</span>
                        <span className="active">{product.name}</span>
                    </nav>
                </div>
            </div>

            <div className="wb-pd">
                <div className="container">
                    <div className="row">
                        <div className="col-md-6 mb-4">
                            <div className="wb-pd__gallery">
                                {images.length > 1 && (
                                    <div className="wb-pd__thumbs">
                                        {images.map((img, i) => (
                                            <div
                                                key={img.id}
                                                className={`wb-pd__thumb ${activeImage === img.url ? 'is-active' : ''}`}
                                                onClick={() => setActiveImage(img.url)}
                                            >
                                                <img src={img.url} alt={`${product.name} thumbnail ${i + 1}`} />
                                            </div>
                                        ))}
                                    </div>
                                )}
                                <div className="wb-pd__main">
                                    <img src={activeImage} alt={product.name} />
                                </div>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <span className="wb-pd__cat">{product.category?.name || 'Component'}</span>
                            <h1 className="wb-pd__title">{product.name}</h1>
                            <div className="wb-pd__meta">
                                <span className={inStock ? 'wb-card__stock--in' : 'wb-card__stock--out'}>{inStock ? 'In stock' : 'Out of stock'}</span>
                                <span>Stock: {product.stock}</span>
                                <span>Sold: {product.sold}</span>
                                {product.brand && <span>Brand: {product.brand}</span>}
                            </div>
                            <div className="wb-pd__price">&#2547;{money(product.price)}</div>
                            {product.short_description && <p className="wb-pd__desc">{product.short_description}</p>}

                            <label className="mono" style={{ fontSize: '.8rem', fontWeight: 600, display: 'block', marginBottom: '.5rem' }}>Quantity</label>
                            <div className="wb-qty">
                                <button type="button" aria-label="Decrease" onClick={() => setQty((q) => Math.max(1, q - 1))}>
                                    <Icon name="minus" size={15} />
                                </button>
                                <input type="text" value={qty} readOnly />
                                <button type="button" aria-label="Increase" onClick={() => setQty((q) => q + 1)}>
                                    <Icon name="plus" size={15} />
                                </button>
                            </div>

                            <div className="wb-pd__actions">
                                <button type="button" onClick={() => addToCart(product.id)} className="wb-btn wb-btn--primary">
                                    <Icon name="cart" size={17} /> Add to Cart
                                </button>
                                <Link href={auth?.user ? `/wishlist/add/${product.id}` : '/login'} className="wb-btn wb-btn--ghost">
                                    <Icon name="heart" size={17} /> Wishlist
                                </Link>
                            </div>

                            <div className="wb-trust">
                                <div className="wb-trust__item"><Icon name="truck" size={18} /> Nationwide delivery</div>
                                <div className="wb-trust__item"><Icon name="shield" size={18} /> Genuine parts</div>
                                <div className="wb-trust__item"><Icon name="whatsapp" size={18} /> Cash on delivery</div>
                            </div>
                        </div>
                    </div>

                    <div className="wb-tabs">
                        <div className="wb-tabs__nav">
                            <button
                                type="button"
                                className={`wb-tabs__btn ${activeTab === 'description' ? 'is-active' : ''}`}
                                onClick={() => setActiveTab('description')}
                            >
                                Description
                            </button>
                            <button
                                type="button"
                                className={`wb-tabs__btn ${activeTab === 'datasheet' ? 'is-active' : ''}`}
                                onClick={() => setActiveTab('datasheet')}
                            >
                                Specifications
                            </button>
                        </div>
                        <div className={`wb-tabs__panel ${activeTab === 'description' ? 'is-active' : ''}`} style={{ display: activeTab === 'description' ? 'block' : 'none' }}>
                            {product.description || 'No description provided yet.'}
                        </div>
                        <div className={`wb-tabs__panel ${activeTab === 'datasheet' ? 'is-active' : ''}`} style={{ display: activeTab === 'datasheet' ? 'block' : 'none' }}>
                            {product.specifications || 'No specifications provided yet.'}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Product.layout = (page) => <Layout>{page}</Layout>;
