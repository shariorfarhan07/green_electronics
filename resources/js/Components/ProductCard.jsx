import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Icon from './Icon';
import { addToCart } from '../cart';
import { money } from '../money';

// The shared product card used by the home rails and the shop grid.
export default function ProductCard({ product }) {
    const { auth } = usePage().props;
    const inStock = product.stock > 0;

    function openQuickView(e) {
        e.preventDefault();
        window.__openQuickView?.(product);
    }

    return (
        <div className="wb-card">
            <Link href={`/products/${product.id}`} className="wb-card__media">
                <img src={product.primary_image_url} alt={product.name} loading="lazy" />
            </Link>
            <div className="wb-card__actions">
                <Link
                    href={auth?.user ? `/wishlist/add/${product.id}` : '/login'}
                    className="wb-card__action"
                    title="Wishlist"
                    aria-label="Add to wishlist"
                >
                    <Icon name="heart" size={15} />
                </Link>
                <a
                    href="#"
                    className="wb-card__action"
                    title="Quick View"
                    onClick={openQuickView}
                >
                    <Icon name="search" size={15} />
                </a>
            </div>
            <div className="wb-card__body">
                <span className="wb-card__cat">{product.category?.name || 'Component'}</span>
                <Link href={`/products/${product.id}`} className="wb-card__title">{product.name}</Link>
                <div className="wb-card__foot">
                    <span className="wb-card__price">&#2547;{money(product.price)}</span>
                    <button
                        type="button"
                        onClick={() => addToCart(product.id)}
                        className="wb-card__cart-btn"
                        title="Add to cart"
                        aria-label="Add to cart"
                    >
                        <Icon name="cart" size={16} />
                    </button>
                </div>
                <span className={`wb-card__stock ${inStock ? 'wb-card__stock--in' : 'wb-card__stock--out'}`}>
                    {inStock ? 'In stock' : 'Out of stock'}
                </span>
            </div>
        </div>
    );
}
