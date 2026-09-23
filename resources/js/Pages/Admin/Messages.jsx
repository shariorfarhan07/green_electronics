import React from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import AdminLayout from '../../AdminLayout';
import Icon from '../../Components/Icon';
import Pagination from '../../Components/Pagination';

const limit = (text, max) => {
    const s = String(text || '');
    return s.length > max ? `${s.slice(0, max)}…` : s;
};

export default function Messages({ messages, unreadCount }) {
    const { flash } = usePage().props;
    const rows = messages?.data || [];

    function destroy(id) {
        if (window.confirm('Delete this message?')) {
            router.delete(`/admin/messages/${id}`, { preserveScroll: true });
        }
    }

    return (
        <>
            {flash?.success && <div className="alert alert-success">{flash.success}</div>}

            <div className="wb-admin__stat-grid">
                <div className="wb-admin__stat-card">
                    <span className="wb-admin__stat-value">{messages?.total ?? 0}</span>
                    <span className="wb-admin__stat-label">Total Messages</span>
                </div>
                <div className="wb-admin__stat-card">
                    <span className="wb-admin__stat-value">{unreadCount}</span>
                    <span className="wb-admin__stat-label">Unread</span>
                </div>
            </div>

            <div className="wb-admin__panel">
                <div className="wb-admin__panel-head">
                    <h4>Contact Form Submissions</h4>
                </div>

                {rows.length > 0 ? (
                    <div className="wb-admin__table-wrap">
                        <table className="wb-admin__table">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Received</th>
                                    <th>IP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {rows.map((message) => (
                                    <tr key={message.id} style={message.is_unread ? { background: 'var(--accent-soft)' } : undefined}>
                                        <td style={{ maxWidth: 200 }}>
                                            <div style={{ fontWeight: message.is_unread ? 700 : 600 }}>
                                                {message.name}
                                                {message.is_unread && <span className="wb-admin__badge" style={{ marginLeft: '.3rem' }}>New</span>}
                                            </div>
                                            <div style={{ fontSize: '.78rem', color: 'var(--ink-faint)' }}>{message.email}</div>
                                        </td>
                                        <td style={{ maxWidth: 280 }}>
                                            <div style={{ fontWeight: 600 }}>{limit(message.subject, 50)}</div>
                                            <div style={{ fontSize: '.78rem', color: 'var(--ink-faint)' }}>{limit(message.message, 60)}</div>
                                        </td>
                                        <td style={{ whiteSpace: 'nowrap', fontSize: '.82rem' }}>
                                            {new Date(message.created_at).toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                        </td>
                                        <td className="mono" style={{ fontSize: '.78rem', color: 'var(--ink-faint)' }}>{message.ip_address}</td>
                                        <td>
                                            <div className="wb-admin__actions">
                                                <Link href={`/admin/messages/${message.id}`} className="wb-btn wb-btn--sm wb-btn--ghost">Read</Link>
                                                <button type="button" onClick={() => destroy(message.id)} className="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Delete">
                                                    <Icon name="trash" size={14} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="wb-admin__empty">
                        <Icon name="mail" size={36} />
                        <p>No messages yet.</p>
                    </div>
                )}
            </div>

            <div className="mt-3"><Pagination paginator={messages} /></div>
        </>
    );
}

Messages.layout = (page) => <AdminLayout title="Messages">{page}</AdminLayout>;
