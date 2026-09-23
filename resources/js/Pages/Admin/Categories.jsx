import React, { useState } from 'react';
import { router, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import ErrorAlert from '../../Components/Admin/ErrorAlert';
import SearchableSelect from '../../Components/Admin/SearchableSelect';

// Each row keeps its own draft state and saves itself — the Blade version wired
// inputs to hidden sibling forms via the `form="..."` attribute to get the same
// effect.
function SectionRow({ section, icons, children }) {
    const [draft, setDraft] = useState({
        name: section.name || '',
        blurb: section.blurb || '',
        icon: section.icon || '',
        sort_order: section.sort_order ?? 0,
        parent_id: '',
    });

    function save() {
        router.put(`/admin/categories/${section.id}`, draft, { preserveScroll: true });
    }

    function destroy() {
        if (window.confirm('Delete this section?')) {
            router.delete(`/admin/categories/${section.id}`, { preserveScroll: true });
        }
    }

    return (
        <div className="wb-admin__cat-section">
            <div className="wb-admin__cat-head">
                <span className="wb-admin__cat-icon"><Icon name={draft.icon} size={18} /></span>
                <input type="text" value={draft.name} onChange={(e) => setDraft({ ...draft, name: e.target.value })} className="form-control wb-admin__cat-name" required />
                <input type="text" value={draft.blurb} onChange={(e) => setDraft({ ...draft, blurb: e.target.value })} className="form-control" placeholder="Short description" />
                <select value={draft.icon} onChange={(e) => setDraft({ ...draft, icon: e.target.value })} className="form-control" style={{ maxWidth: 130 }}>
                    {icons.map((icon) => <option key={icon} value={icon}>{icon}</option>)}
                </select>
                <input type="number" value={draft.sort_order} onChange={(e) => setDraft({ ...draft, sort_order: e.target.value })} className="form-control" style={{ maxWidth: 80 }} title="Sort order" />
                <span className="wb-admin__badge">{section.products_count} direct</span>
                <button type="button" className="wb-admin__icon-btn" title="Save section" onClick={save}><Icon name="check" size={14} /></button>
                <button type="button" className="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete section" onClick={destroy}><Icon name="trash" size={14} /></button>
            </div>
            {children}
        </div>
    );
}

function ChildRow({ child, roots }) {
    const [draft, setDraft] = useState({
        name: child.name || '',
        parent_id: child.parent_id || '',
        sort_order: child.sort_order ?? 0,
        icon: child.icon || '',
    });

    function save() {
        router.put(`/admin/categories/${child.id}`, draft, { preserveScroll: true });
    }

    function destroy() {
        if (window.confirm('Delete this subcategory?')) {
            router.delete(`/admin/categories/${child.id}`, { preserveScroll: true });
        }
    }

    return (
        <div className="wb-admin__cat-child">
            <input type="text" value={draft.name} onChange={(e) => setDraft({ ...draft, name: e.target.value })} className="form-control" required />
            <select value={draft.parent_id} onChange={(e) => setDraft({ ...draft, parent_id: e.target.value })} className="form-control" style={{ maxWidth: 200 }} title="Move to section">
                {roots.map((root) => <option key={root.id} value={root.id}>{root.name}</option>)}
            </select>
            <input type="number" value={draft.sort_order} onChange={(e) => setDraft({ ...draft, sort_order: e.target.value })} className="form-control" style={{ maxWidth: 80 }} title="Sort order" />
            <span className="wb-admin__badge" title={`${child.products_count} product(s) in this subcategory`}>{child.products_count}</span>
            <span className="mono" style={{ fontSize: '.72rem', color: 'var(--ink-faint)' }}>{child.slug}</span>
            <button type="button" className="wb-admin__icon-btn" title="Save" onClick={save}><Icon name="check" size={14} /></button>
            <button type="button" className="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete" onClick={destroy}><Icon name="trash" size={14} /></button>
        </div>
    );
}

export default function Categories({ sections = [], roots = [], icons = [] }) {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', parent_id: '', blurb: '', icon: icons[0] || '',
    });

    function submit(e) {
        e.preventDefault();
        post('/admin/categories', { preserveScroll: true, onSuccess: () => reset() });
    }

    const subcategoryCount = sections.reduce((sum, s) => sum + (s.children?.length || 0), 0);

    return (
        <>
            {flash?.success && <div className="alert alert-success">{flash.success}</div>}
            <ErrorAlert errors={errors} />

            <div className="wb-admin__fieldset" style={{ maxWidth: 'none' }}>
                <div className="wb-admin__fieldset-head">
                    <Icon name="plus" size={18} />
                    <div>
                        <h4>Add Category</h4>
                        <p>Leave the section blank to create a new top-level section.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <form onSubmit={submit}>
                        <div className="row">
                            <div className="col-md-3 form-group">
                                <label htmlFor="name">Name <span className="wb-admin__req">*</span></label>
                                <input type="text" className="form-control" id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="e.g. Stepper Motor" required />
                            </div>
                            <div className="col-md-3 form-group">
                                <label htmlFor="parent_id">Section</label>
                                <SearchableSelect
                                    groups={[{ label: 'Sections', options: [{ value: '', label: '— New top-level section —' }, ...roots.map((r) => ({ value: r.id, label: r.name }))] }]}
                                    value={data.parent_id}
                                    onChange={(v) => setData('parent_id', v)}
                                    placeholder="— New top-level section —"
                                    searchPlaceholder="Search sections…"
                                />
                            </div>
                            <div className="col-md-3 form-group">
                                <label htmlFor="blurb">Short Description</label>
                                <input type="text" className="form-control" id="blurb" value={data.blurb} onChange={(e) => setData('blurb', e.target.value)} placeholder="Shown in the mega menu" />
                            </div>
                            <div className="col-md-2 form-group">
                                <label htmlFor="icon">Icon</label>
                                <SearchableSelect
                                    groups={[{ label: 'Icons', options: icons.map((i) => ({ value: i, label: i })) }]}
                                    value={data.icon}
                                    onChange={(v) => setData('icon', v)}
                                    searchPlaceholder="Search icons…"
                                />
                            </div>
                            <div className="col-md-1 form-group d-flex align-items-end">
                                <button type="submit" className="wb-btn wb-btn--accent" style={{ width: '100%' }} disabled={processing}>Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div className="wb-admin__panel">
                <div className="wb-admin__panel-head">
                    <h4>Taxonomy &mdash; {sections.length} sections, {subcategoryCount} subcategories</h4>
                </div>

                {sections.map((section) => (
                    <SectionRow key={section.id} section={section} icons={icons}>
                        {section.children?.length > 0 && (
                            <div className="wb-admin__cat-children">
                                {section.children.map((child) => (
                                    <ChildRow key={child.id} child={child} roots={roots} />
                                ))}
                            </div>
                        )}
                    </SectionRow>
                ))}
            </div>
        </>
    );
}

Categories.layout = (page) => <AdminLayout title="Categories">{page}</AdminLayout>;
