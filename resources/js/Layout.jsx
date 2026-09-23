import React, { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import Header from './Components/Header';
import OffCanvasMenu from './Components/OffCanvasMenu';
import CartDrawer from './Components/CartDrawer';
import QuickViewModal from './Components/QuickViewModal';
import Footer from './Components/Footer';

// Persistent Inertia layout (set as `Page.layout` on every page component) so
// the header/nav/cart-drawer/footer chrome mounts once and never unmounts
// across client-side navigations — previously this chrome was a Blade partial
// re-rendered on every full page load, which is what forced full reloads.
export default function Layout({ children }) {
    const [menuOpen, setMenuOpen] = useState(false);
    const [cartOpen, setCartOpen] = useState(false);
    const [quickViewProduct, setQuickViewProduct] = useState(null);

    useEffect(() => {
        window.__openQuickView = (product) => setQuickViewProduct(product);
        return () => { delete window.__openQuickView; };
    }, []);

    useEffect(() => {
        return router.on('navigate', () => {
            setMenuOpen(false);
            setCartOpen(false);
        });
    }, []);

    return (
        <>
            <Header onOpenMenu={() => setMenuOpen(true)} onOpenCart={() => setCartOpen(true)} />
            <OffCanvasMenu open={menuOpen} onClose={() => setMenuOpen(false)} />
            <CartDrawer open={cartOpen} onClose={() => setCartOpen(false)} />
            <QuickViewModal product={quickViewProduct} onClose={() => setQuickViewProduct(null)} />
            {children}
            <Footer />
        </>
    );
}
