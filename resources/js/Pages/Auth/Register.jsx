import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';
import Icon from '../../Components/Icon';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '', email: '', password: '', password_confirmation: '',
    });

    function submit(e) {
        e.preventDefault();
        post('/register');
    }

    return (
        <div className="wb-auth-card">
            <div className="wb-auth-card__logo">
                <div style={{ width: 52, height: 52, borderRadius: '50%', background: 'var(--accent-soft)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    <Icon name="user" size={24} />
                </div>
            </div>
            <h1 className="wb-auth-card__title">Create your account</h1>
            <p className="wb-auth-card__sub">Join Green Electronics to track orders and save your wishlist</p>

            <form onSubmit={submit}>
                <div className="form-group">
                    <label htmlFor="name">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                        autoComplete="name"
                        autoFocus
                        placeholder="Your name"
                    />
                    {errors.name && <span className="invalid-feedback d-block" role="alert"><strong>{errors.name}</strong></span>}
                </div>

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
                        autoComplete="new-password"
                        placeholder="••••••••"
                    />
                    {errors.password && <span className="invalid-feedback d-block" role="alert"><strong>{errors.password}</strong></span>}
                </div>

                <div className="form-group">
                    <label htmlFor="password-confirm">Confirm Password</label>
                    <input
                        id="password-confirm"
                        type="password"
                        className="form-control"
                        value={data.password_confirmation}
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        required
                        autoComplete="new-password"
                        placeholder="••••••••"
                    />
                </div>

                <button type="submit" className="wb-btn wb-btn--accent wb-btn--block" disabled={processing}>
                    {processing ? 'Creating account…' : 'Create Account'}
                </button>
            </form>

            <p className="wb-auth-footer">Already have an account? <Link href="/login">Sign in</Link></p>
        </div>
    );
}

Register.layout = (page) => <AuthLayout>{page}</AuthLayout>;
