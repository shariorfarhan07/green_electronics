import React from 'react';
import { Link } from '@inertiajs/react';
import Icon from './Icon';

// Built from the paginator's serialized shape: Laravel includes `links` — an
// array of {url, label, active} — on every paginate() response's JSON form.
export default function Pagination({ paginator }) {
    if (!paginator || paginator.last_page <= 1) return null;

    return (
        <nav className="wb-pagination" aria-label="Pagination Navigation">
            <div className="wb-pagination__meta">
                Showing <strong>{paginator.from}</strong> to <strong>{paginator.to}</strong> of{' '}
                <strong>{paginator.total}</strong> results
            </div>
            <ul className="wb-pagination__list">
                {paginator.links.map((link, i) => {
                    const isPrev = i === 0;
                    const isNext = i === paginator.links.length - 1;
                    const label = isPrev ? <Icon name="chevron-left" size={15} /> : isNext ? <Icon name="chevron-right" size={15} /> : (
                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                    );

                    if (link.active) {
                        return <li key={i} className="wb-pagination__item wb-pagination__item--current" aria-current="page">{label}</li>;
                    }
                    if (!link.url) {
                        const disabledClass = (isPrev || isNext)
                            ? 'wb-pagination__item wb-pagination__item--disabled'
                            : 'wb-pagination__item wb-pagination__item--ellipsis';
                        return <li key={i} className={disabledClass} aria-disabled="true">{label}</li>;
                    }
                    return (
                        <li key={i}>
                            <Link href={link.url} className="wb-pagination__item" preserveScroll>{label}</Link>
                        </li>
                    );
                })}
            </ul>
        </nav>
    );
}
