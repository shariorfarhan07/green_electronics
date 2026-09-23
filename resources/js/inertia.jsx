import 'regenerator-runtime/runtime';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

createInertiaApp({
    // The template literal makes webpack build a context of everything under
    // ./Pages, so a new page component is resolvable by name (including nested
    // ones like 'Auth/Login' or 'Admin/Products') without touching this file.
    resolve: (name) => require(`./Pages/${name}`).default,
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});
