import React from 'react';
import { addToCart } from '../cart';
import { money } from '../money';

// Product quick-view. Controlled entirely by React state — the app no longer
// loads jQuery or Bootstrap's JS plugins, only Bootstrap's CSS classes.
export default function QuickViewModal({ product, onClose }) {
    if (!product) return null;

    return (
        <div className="modal fade show" style={{ display: 'block' }} tabIndex="-1" role="dialog" onClick={onClose}>
            <div className="modal-dialog modal-lg" role="document" onClick={(e) => e.stopPropagation()}>
                <div className="modal-content">
                    <div className="modal-header">
                        <button type="button" className="close" aria-label="Close" onClick={onClose}><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div className="modal-body">
                        <div className="row">
                            <div className="col-md-5">
                                <img src={product.primary_image_url} alt={product.name} style={{ width: '100%', objectFit: 'contain' }} />
                            </div>
                            <div className="col-md-7">
                                <h4>{product.name}</h4>
                                <p className="wb-pd__price">&#2547;{money(product.price)}</p>
                                <p className="text-muted" style={{ fontSize: '.85rem' }}>{(product.short_description || '').slice(0, 250)}</p>
                                <p style={{ fontSize: '.8rem' }} className="mono">Stock: {product.stock} &middot; Sold: {product.sold}</p>
                                <button
                                    type="button"
                                    className="wb-btn wb-btn--accent"
                                    onClick={() => { addToCart(product.id); onClose(); }}
                                >
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
