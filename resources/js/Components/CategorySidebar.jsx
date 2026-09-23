import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Icon from './Icon';

export default function CategorySidebar({ activeCategory }) {
    const { navCategories = [] } = usePage().props;
    const activeSlug = activeCategory?.slug || null;

    let activeParent = null;
    for (const c of navCategories) {
        if (c.slug === activeSlug || c.children?.some((ch) => ch.slug === activeSlug)) {
            activeParent = c.slug;
            break;
        }
    }

    return (
        <div className="wb-sidebar">
            <div className="wb-sidebar__title">Browse Categories</div>
            <ul className="wb-sidebar__list">
                <li className={`wb-sidebar__item ${!activeSlug ? 'is-active' : ''}`}>
                    <Link href="/shop"><span>All Products</span> <Icon name="chevron-right" size={15} /></Link>
                </li>
                {navCategories.map((cat) => (
                    <React.Fragment key={cat.id}>
                        <li className={`wb-sidebar__item ${activeSlug === cat.slug ? 'is-active' : ''}`}>
                            <Link href={`/shop?category=${cat.slug}`}>
                                <span><Icon name={cat.icon} size={15} /> {cat.name}</span>
                                <Icon name="chevron-right" size={15} />
                            </Link>
                        </li>
                        {activeParent === cat.slug && cat.children?.length > 0 && (
                            <li className="wb-sidebar__children">
                                <ul>
                                    {cat.children.map((child) => (
                                        <li key={child.id}>
                                            <Link
                                                href={`/shop?category=${child.slug}`}
                                                className={activeSlug === child.slug ? 'is-active' : ''}
                                            >
                                                {child.name}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </li>
                        )}
                    </React.Fragment>
                ))}
            </ul>
        </div>
    );
}
