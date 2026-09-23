import React from 'react';
import { Link } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';

export default function About() {
    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">About Us</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">About</span>
                    </nav>
                </div>
            </div>

            <div className="wb-page">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-7 mb-4">
                            <h3 className="mb-3">Bangladesh&rsquo;s electronics component store</h3>
                            <p style={{ color: 'var(--ink-soft)', lineHeight: 1.8 }}>
                                Green Electronics is one of the largest electronics component wholesalers in Bangladesh, supplying
                                makers, students, hobbyists and engineers with genuine parts at the best price in town &mdash;
                                from Arduino boards and sensors to robotics parts, CNC &amp; 3D printing supplies, and passive components.
                            </p>
                            <p style={{ color: 'var(--ink-soft)', lineHeight: 1.8 }}>
                                Whether you&rsquo;re prototyping a final year project, building a robot, or stocking up on
                                resistors and connectors, our shop in Patuatuli, Dhaka and this website exist to get you the
                                right part, fast.
                            </p>
                        </div>
                        <div className="col-lg-5">
                            <div className="wb-info-card"><Icon name="pin" size={22} /><p>Haji Elias Market, 1st Floor, Shop No. 16 &amp; 62, Patuatuli, Dhaka-1100, Bangladesh</p></div>
                            <div className="wb-info-card"><Icon name="phone" size={22} /><p>01912-150390, 01875-589192, 01756-949732</p></div>
                            <div className="wb-info-card"><Icon name="mail" size={22} /><p>greenelectronicsbd@gmail.com</p></div>
                        </div>
                    </div>

                    <div style={{ marginTop: '2rem', paddingTop: '1.3rem', borderTop: '1px solid var(--line)', textAlign: 'center', fontSize: '.8rem', color: 'var(--ink-faint)' }}>
                        Owned by <a href="https://www.facebook.com/parvez.jahid.2024" target="_blank" rel="noopener noreferrer">Parvez Jahid</a>
                        {' '}&middot; Developed by <a href="https://shariorfarhan.com" target="_blank" rel="noopener noreferrer">Sharior Farhan</a>
                    </div>
                </div>
            </div>
        </>
    );
}

About.layout = (page) => <Layout>{page}</Layout>;
