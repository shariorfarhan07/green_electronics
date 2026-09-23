import React from 'react';
import { Link } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import { addToCart } from '../cart';
import { money } from '../money';

export default function Wishlist({ products = [] }) {
    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">Wishlist</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Wishlist</span>
                    </nav>
                </div>
            </div>

            <div className="wb-wishlist">
                <div className="container">
                    {products.length > 0 ? (
                        <div className="table-responsive">
                            <table className="wb-line-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {products.map((product) => (
                                        <tr key={product.id}>
                                            <td>
                                                <div className="wb-line__thumb">
                                                    <img src={product.primary_image_url} alt={product.name} />
                                                </div>
                                            </td>
                                            <td><Link href={`/products/${product.id}`} className="wb-line__name">{product.name}</Link></td>
                                            <td className="wb-line__price">&#2547;{money(product.price)}</td>
                                            <td><span className={product.stock > 0 ? 'wb-card__stock--in' : 'wb-card__stock--out'}>{product.stock > 0 ? 'In stock' : 'Out of stock'}</span></td>
                                            <td><button type="button" onClick={() => addToCart(product.id)} className="wb-btn wb-btn--sm wb-btn--accent">Add to Cart</button></td>
                                            <td><Link href={`/wishlist/remove/${product.id}`} className="wb-line__remove" aria-label="Remove" preserveScroll><Icon name="trash" size={17} /></Link></td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    ) : (
                        <div className="wb-empty-state">
                            <Icon name="heart" size={44} />
                            <h3>Your wishlist is empty</h3>
                            <p>Save products you like and find them here later.</p>
                            <Link href="/shop" className="wb-btn wb-btn--accent">Browse Products</Link>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}

Wishlist.layout = (page) => <Layout>{page}</Layout>;
