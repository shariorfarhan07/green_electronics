import React from 'react';
import { Link } from '@inertiajs/react';
import Icon from './Components/Icon';
import SonarGrid from './Components/SonarGrid';

// Standalone auth shell — no storefront header/cart chrome.
export default function AuthLayout({ children }) {
    return (
        <div className="wb-auth-shell">
            <SonarGrid />

            <nav className="wb-auth-nav">
                <div className="container">
                    <div className="d-flex align-items-center justify-content-between" style={{ padding: '1.1rem 0' }}>
                        <Link href="/" className="wb-logo">Green<span>Electronics</span></Link>
                        <Link href="/" className="wb-btn wb-btn--ghost wb-btn--sm">
                            <Icon name="chevron-left" size={15} /> Back to Shop
                        </Link>
                    </div>
                </div>
            </nav>

            <main className="wb-auth-main">
                <div className="container">{children}</div>
            </main>
        </div>
    );
}
