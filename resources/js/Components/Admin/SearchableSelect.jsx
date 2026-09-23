import React, { useEffect, useMemo, useRef, useState } from 'react';
import Icon from '../Icon';

// Filterable select — the category tree is ~150 entries, so a plain <select>
// is unusable. `groups` is [{ label, options: [{value, label}] }].
export default function SearchableSelect({ groups = [], value, onChange, placeholder = 'Select…', searchPlaceholder = 'Search…', required }) {
    const [open, setOpen] = useState(false);
    const [query, setQuery] = useState('');
    const wrapRef = useRef(null);
    const searchRef = useRef(null);

    const selectedLabel = useMemo(() => {
        for (const group of groups) {
            const hit = group.options.find((o) => String(o.value) === String(value));
            if (hit) return hit.label;
        }
        return null;
    }, [groups, value]);

    const filtered = useMemo(() => {
        const q = query.trim().toLowerCase();
        if (!q) return groups;
        return groups
            .map((g) => ({ ...g, options: g.options.filter((o) => o.label.toLowerCase().includes(q)) }))
            .filter((g) => g.options.length > 0);
    }, [groups, query]);

    useEffect(() => {
        function onDocClick(e) {
            if (wrapRef.current && !wrapRef.current.contains(e.target)) setOpen(false);
        }
        document.addEventListener('click', onDocClick);
        return () => document.removeEventListener('click', onDocClick);
    }, []);

    useEffect(() => {
        if (open) {
            setQuery('');
            searchRef.current?.focus();
        }
    }, [open]);

    function pick(optionValue) {
        onChange(optionValue);
        setOpen(false);
    }

    return (
        <div className={`wb-select ${open ? 'is-open' : ''}`} ref={wrapRef}>
            {/* Keeps the value in the DOM as a real form control for required-field validation. */}
            <input type="hidden" value={value ?? ''} required={required} readOnly />
            <button type="button" className="wb-select__toggle" onClick={() => setOpen((o) => !o)}>
                <span className={selectedLabel ? '' : 'wb-select__placeholder'}>{selectedLabel || placeholder}</span>
                <Icon name="chevron-down" size={16} />
            </button>
            <div className="wb-select__panel">
                <input
                    ref={searchRef}
                    type="text"
                    className="wb-select__search"
                    placeholder={searchPlaceholder}
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                    onKeyDown={(e) => {
                        if (e.key === 'Escape') setOpen(false);
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const first = filtered[0]?.options[0];
                            if (first) pick(first.value);
                        }
                    }}
                />
                <div className="wb-select__list">
                    {filtered.length > 0 ? filtered.map((group) => (
                        <React.Fragment key={group.label}>
                            <div className="wb-select__group">{group.label}</div>
                            {group.options.map((option) => (
                                <button
                                    key={option.value}
                                    type="button"
                                    className={`wb-select__option ${String(option.value) === String(value) ? 'is-selected' : ''}`}
                                    onClick={() => pick(option.value)}
                                >
                                    {option.label}
                                </button>
                            ))}
                        </React.Fragment>
                    )) : <div className="wb-select__empty">No matches</div>}
                </div>
            </div>
        </div>
    );
}
