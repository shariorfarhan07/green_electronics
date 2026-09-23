import React from 'react';
import { Link } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import ProductCard from '../Components/ProductCard';
import Pagination from '../Components/Pagination';
import CategorySidebar from '../Components/CategorySidebar';

export default function Shop({ products, activeCategory, searchText }) {
    const title = activeCategory?.name || searchText || 'Shop All Products';
    const items = products?.data || [];

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">{title}</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Shop</span>
                    </nav>
                </div>
            </div>

            <div className="wb-shop">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-3">
                            <CategorySidebar activeCategory={activeCategory} />
                        </div>
                        <div className="col-lg-9">
                            <div className="wb-toolbar">
                                <span className="wb-toolbar__count">
                                    {products?.total
                                        ? `Showing ${products.from}–${products.to} of ${products.total} products`
                                        : 'No products found'}
                                </span>
                            </div>

                            {items.length > 0 ? (
                                <>
                                    <div className="wb-grid">
                                        {items.map((product) => <ProductCard key={product.id} product={product} />)}
                                    </div>
                                    <div className="mt-4 d-flex justify-content-center">
                                        <Pagination paginator={products} />
                                    </div>
                                </>
                            ) : (
                                <div className="wb-empty-state">
                                    <Icon name="box" size={44} />
                                    <h3>No products found</h3>
                                    <p>Try browsing a different category or check back soon.</p>
                                    <Link href="/shop" className="wb-btn wb-btn--accent">View All Products</Link>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Shop.layout = (page) => <Layout>{page}</Layout>;
