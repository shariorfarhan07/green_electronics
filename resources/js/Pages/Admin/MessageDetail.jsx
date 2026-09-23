import React from 'react';
import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';

export default function MessageDetail({ message }) {
    function destroy() {
        if (window.confirm('Delete this message?')) {
            router.delete(`/admin/messages/${message.id}`);
        }
    }

    return (
        <>
            <div className="wb-admin__actions mb-3">
                <Link href="/admin/messages" className="wb-btn wb-btn--ghost wb-btn--sm">
                    <Icon name="chevron-left" size={15} /> Back to Messages
                </Link>
            </div>

            <div className="wb-admin__form-wrap">
                <div className="wb-admin__fieldset">
                    <div className="wb-admin__fieldset-head">
                        <Icon name="mail" size={18} />
                        <div>
                            <h4>{message.subject}</h4>
                            <p>
                                Received {new Date(message.created_at).toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                {' '}&middot; IP {message.ip_address || 'unknown'}
                            </p>
                        </div>
                    </div>
                    <div className="wb-admin__fieldset-body">
                        <div className="row">
                            <div className="col-md-6 form-group">
                                <label>From</label>
                                <div style={{ fontWeight: 600 }}>{message.name}</div>
                            </div>
                            <div className="col-md-6 form-group">
                                <label>Email</label>
                                <div><a href={`mailto:${message.email}`}>{message.email}</a></div>
                            </div>
                        </div>
                        <div className="form-group">
                            <label>Message</label>
                            <div style={{ whiteSpace: 'pre-wrap', lineHeight: 1.7, padding: '1rem', background: 'var(--paper-alt)', borderRadius: 'var(--radius-sm)' }}>
                                {message.message}
                            </div>
                        </div>
                    </div>
                </div>

                <div className="wb-admin__form-actions">
                    <a href={`mailto:${message.email}?subject=RE: ${encodeURIComponent(message.subject)}`} className="wb-btn wb-btn--accent">
                        <Icon name="reply" size={15} /> Reply by Email
                    </a>
                    <button type="button" className="wb-btn wb-btn--ghost" onClick={destroy}>Delete</button>
                    <span>Message #{message.id}</span>
                </div>
            </div>
        </>
    );
}

MessageDetail.layout = (page) => <AdminLayout title="Message">{page}</AdminLayout>;
