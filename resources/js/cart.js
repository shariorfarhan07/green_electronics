import { router } from '@inertiajs/react';

// Cart mutations are GET routes that mutate the session and redirect back.
// Visiting them as a normal Inertia link re-fetches every prop of the current
// page (the homepage alone re-queries ~45 products) and resets scroll, which
// reads as a full page load. These are partial visits instead: only the shared
// `cart` prop comes back, scroll and component state are left alone, so the
// badge and drawer update without the page appearing to reload.
// `also` names any page-level props that must refresh too — the Cart page's
// own `cartItems` prop, for instance, since there the line items are the page.
function options(also = []) {
    return {
        only: ['cart', 'flash', ...also],
        preserveScroll: true,
        preserveState: true,
    };
}

export function addToCart(productId, also) {
    router.visit(`/cart/add/${productId}`, options(also));
}

export function setCartQuantity(productId, quantity, also) {
    router.visit(`/cart/items/${productId}/${quantity}`, options(also));
}
