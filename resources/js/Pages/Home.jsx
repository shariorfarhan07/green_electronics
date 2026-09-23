import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';
import ProductCard from '../Components/ProductCard';

export default function Home({ rails, newArrivals, bestSellers }) {
    const { navCategories = [] } = usePage().props;

    return (
        <>
            <div className="container">
                <div className="wb-hero">
                    <div className="wb-hero__inner">
                        <span className="wb-hero__eyebrow">Bangladesh's Electronics Component Store</span>
                        <h1 className="wb-hero__title">Everything you need to <span>build</span>, from Arduino to CNC.</h1>
                        <p className="wb-hero__sub">Genuine development boards, sensors, robotics parts and 3D printing supplies &mdash; shipped nationwide with cash on delivery.</p>
                        <Link href="/shop" className="wb-btn wb-btn--accent">Shop All Products <Icon name="chevron-right" size={16} /></Link>
                    </div>
                    <div className="wb-hero__media">
                        <picture>
                            <source srcSet="/images/hero/build-innovate.webp" type="image/webp" />
                            <img
                                src="/images/hero/build-innovate.jpg"
                                width="1200"
                                height="676"
                                alt="Engineer sketching a robotics blueprint at a workbench full of development boards, sensors and motors"
                                fetchPriority="high"
                            />
                        </picture>
                    </div>
                </div>

                <div className="wb-cat-strip">
                    <div className="wb-cat-track">
                        {[0, 1].map((copy) => navCategories.map((cat) => (
                            <Link
                                key={`${copy}-${cat.id}`}
                                href={`/shop?category=${cat.slug}`}
                                className="wb-cat-chip"
                                aria-hidden={copy === 1 ? 'true' : undefined}
                                tabIndex={copy === 1 ? -1 : undefined}
                            >
                                <Icon name={cat.icon} size={26} />
                                <span>{cat.name}</span>
                            </Link>
                        )))}
                    </div>
                </div>
            </div>

            {rails.map((rail) => rail.items.length > 0 && (
                <section className="wb-section" key={rail.slug}>
                    <div className="container">
                        <div className="wb-section__head">
                            <h2 className="wb-section__title">{rail.title}</h2>
                            <Link href={`/shop?category=${rail.slug}`} className="wb-section__link">View All <Icon name="chevron-right" size={14} /></Link>
                        </div>
                        <div className="wb-grid--5">
                            {rail.items.map((product) => <ProductCard key={product.id} product={product} />)}
                        </div>
                    </div>
                </section>
            ))}

            {newArrivals.length > 0 && (
                <section className="wb-section" style={{ background: 'var(--paper-alt)' }}>
                    <div className="container">
                        <div className="wb-section__head">
                            <h2 className="wb-section__title">New Arrivals</h2>
                        </div>
                        <div className="wb-grid--5">
                            {newArrivals.map((product) => <ProductCard key={product.id} product={product} />)}
                        </div>
                    </div>
                </section>
            )}

            {bestSellers.length > 0 && (
                <section className="wb-section">
                    <div className="container">
                        <div className="wb-section__head">
                            <h2 className="wb-section__title">Best Sellers</h2>
                        </div>
                        <div className="wb-grid--5">
                            {bestSellers.map((product) => <ProductCard key={product.id} product={product} />)}
                        </div>
                    </div>
                </section>
            )}

            {newArrivals.length === 0 && (
                <section className="wb-section">
                    <div className="container">
                        <div className="wb-empty-state">
                            <Icon name="box" size={40} />
                            <h3>No products yet</h3>
                            <p>The catalogue is being stocked &mdash; check back soon, or visit the admin panel to add products.</p>
                        </div>
                    </div>
                </section>
            )}
        </>
    );
}

Home.layout = (page) => <Layout>{page}</Layout>;
