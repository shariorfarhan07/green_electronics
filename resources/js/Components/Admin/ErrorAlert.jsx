import React from 'react';

// Replaces the repeated `@if ($errors->any())` alert block across admin views.
export default function ErrorAlert({ errors }) {
    const list = Object.values(errors || {}).filter(Boolean);
    if (!list.length) return null;

    return (
        <div className="alert alert-danger">
            <ul className="mb-0">
                {list.map((message, i) => <li key={i}>{message}</li>)}
            </ul>
        </div>
    );
}
