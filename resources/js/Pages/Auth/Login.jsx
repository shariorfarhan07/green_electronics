import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';
import Icon from '../../Components/Icon';

export default function Login({ canResetPassword }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '', password: '', remember: false,
    });

    function submit(e) {
        e.preventDefault();
        post('/login');
    }

    return (
        <div className="wb-auth-card">
            <div className="wb-auth-card__logo">
                <div style={{ width: 52, height: 52, borderRadius: '50%', background: 'var(--accent-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    <Icon name="lock" size={24} />
                </div>
            </div>
            <h1 className="wb-auth-card__title">Welcome back</h1>
            <p className="wb-auth-card__sub">Sign in to your Green Electronics account</p>

            <form onSubmit={submit}>
                <div className="form-group">
                    <label htmlFor="email">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                        autoComplete="email"
                        autoFocus
                        placeholder="you@example.com"
                    />
                    {errors.email && <span className="invalid-feedback d-block" role="alert"><strong>{errors.email}</strong></span>}
                </div>

                <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                        value={data.password}
                        onChange={(e) => setData('password', e.target.value)}
                        required
                        autoComplete="current-password"
                        placeholder="••••••••"
                    />
                    {errors.password && <span className="invalid-feedback d-block" role="alert"><strong>{errors.password}</strong></span>}
                </div>

                <div className="d-flex align-items-center justify-content-between mb-3">
                    <label className="wb-auth-check mb-0">
                        <input type="checkbox" checked={data.remember} onChange={(e) => setData('remember', e.target.checked)} />
                        Remember me
                    </label>
                    {canResetPassword && <Link href="/password/reset" style={{ fontSize: '.85rem' }}>Forgot password?</Link>}
                </div>

                <button type="submit" className="wb-btn wb-btn--accent wb-btn--block" disabled={processing}>
                    {processing ? 'Signing in…' : 'Sign In'}
                </button>
            </form>

            <div className="wb-auth-divider">or continue with</div>
            <div className="wb-auth-social">
                <a href="/login/github" className="wb-btn wb-btn--ghost"><Icon name="github" size={16} /> GitHub</a>
                <a href="/login/google" className="wb-btn wb-btn--ghost">Google</a>
            </div>

            <p className="wb-auth-footer">New here? <Link href="/register">Create an account</Link></p>
        </div>
    );
}

Login.layout = (page) => <AuthLayout>{page}</AuthLayout>;
