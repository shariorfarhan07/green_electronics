import React from 'react';
import { Link } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';

export default function ComingSoon() {
    return (
        <div className="wb-coming-soon container">
            <Icon name="box" size={52} />
            <h2>Coming Soon</h2>
            <p style={{ color: 'var(--ink-soft)' }}>We&rsquo;re working on this page &mdash; check back shortly.</p>
            <Link href="/" className="wb-btn wb-btn--accent">Back to Home</Link>
        </div>
    );
}

ComingSoon.layout = (page) => <Layout>{page}</Layout>;
