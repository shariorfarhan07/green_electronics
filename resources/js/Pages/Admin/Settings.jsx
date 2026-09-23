import React from 'react';
import { useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';

export default function Settings({ ordersDisabled: initialOrdersDisabled }) {
    const { flash, store } = usePage().props;
    const { data, setData, put, processing } = useForm({
        orders_disabled: initialOrdersDisabled ? 1 : 0,
    });

    function submit(e) {
        e.preventDefault();
        put('/admin/settings');
    }

    return (
        <>
            {flash?.success && <div className="alert alert-success">{flash.success}</div>}

            <div className="wb-admin__fieldset" style={{ maxWidth: 720 }}>
                <div className="wb-admin__fieldset-head">
                    <Icon name="phone" size={18} />
                    <div>
                        <h4>Ordering</h4>
                        <p>Control how customers can place orders on the storefront.</p>
                    </div>
                </div>
                <div className="wb-admin__fieldset-body">
                    <form onSubmit={submit}>
                        <div className="wb-switch-row">
                            <div>
                                <div className="wb-switch-row__label">Contact-only ordering</div>
                                <p className="wb-switch-row__hint">
                                    When enabled, customers can still browse and add items to their cart, but
                                    the checkout page is replaced with a message asking them to
                                    {' '}<strong>call {store?.phoneDisplay}</strong> or
                                    {' '}<strong>WhatsApp</strong> their order instead. A notice banner also appears
                                    across the site so customers know before they reach checkout.
                                </p>
                            </div>
                            <label className="wb-switch">
                                <input
                                    type="checkbox"
                                    checked={!!data.orders_disabled}
                                    onChange={(e) => setData('orders_disabled', e.target.checked ? 1 : 0)}
                                />
                                <span className="wb-switch__track" />
                            </label>
                        </div>

                        <div className="wb-admin__form-actions" style={{ position: 'static', boxShadow: 'none', border: 'none', padding: '1.1rem 0 0', background: 'none', backdropFilter: 'none' }}>
                            <button type="submit" className="wb-btn wb-btn--accent" disabled={processing}>
                                {processing ? 'Saving…' : 'Save Settings'}
                            </button>
                            {initialOrdersDisabled && (
                                <span style={{ color: 'var(--accent-dark)', fontWeight: 600 }}>
                                    <Icon name="check" size={14} /> Currently contact-only
                                </span>
                            )}
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

Settings.layout = (page) => <AdminLayout title="Settings">{page}</AdminLayout>;
