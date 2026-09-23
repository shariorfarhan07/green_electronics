import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Icon from './Icon';

export default function Footer() {
    const { navCategories = [] } = usePage().props;

    return (
        <footer className="wb-footer">
            <div className="container">
                <div className="row">
                    <div className="col-lg-4 col-md-6 mb-4">
                        <Link href="/" className="wb-footer__logo">Green<span>Electronics</span></Link>
                        <div className="wb-footer__addr"><Icon name="pin" size={16} /><span>Haji Elias Market, Patuatuli, Dhaka-1100, Bangladesh</span></div>
                        <div className="wb-footer__addr"><Icon name="mail" size={16} /><span>greenelectronicsbd@gmail.com</span></div>
                        <div className="wb-footer__addr"><Icon name="phone" size={16} /><span>01912-150390</span></div>
                        <div className="wb-footer__social">
                            <a href="#" aria-label="Facebook"><Icon name="facebook" size={16} /></a>
                            <a href="#" aria-label="YouTube"><Icon name="youtube" size={16} /></a>
                            <a href="#" aria-label="Instagram"><Icon name="instagram" size={16} /></a>
                        </div>
                    </div>
                    <div className="col-lg-2 col-md-6 mb-4">
                        <h4>Categories</h4>
                        <ul>
                            {navCategories.slice(0, 6).map((cat) => (
                                <li key={cat.id}><Link href={`/shop?category=${cat.slug}`}>{cat.name}</Link></li>
                            ))}
                        </ul>
                    </div>
                    <div className="col-lg-3 col-md-6 mb-4">
                        <h4>Information</h4>
                        <ul>
                            <li><Link href="/about">About Us</Link></li>
                            <li><Link href="/contact">Contact Us</Link></li>
                            <li><Link href="/cart">Cart</Link></li>
                            <li><Link href="/checkout">Checkout</Link></li>
                        </ul>
                    </div>
                    <div className="col-lg-3 col-md-6 mb-4">
                        <h4>Why Green Electronics</h4>
                        <p style={{ fontSize: '.85rem', lineHeight: 1.7 }}>Bangladesh&rsquo;s electronics component store &mdash; genuine parts for makers, students and engineers at the best price in town.</p>
                    </div>
                </div>
                <div className="wb-footer__bottom">&copy; {new Date().getFullYear()} Green Electronics &mdash; All rights reserved.</div>
            </div>
        </footer>
    );
}
