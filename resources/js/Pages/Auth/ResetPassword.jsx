import React from 'react';
import { useForm } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors } = useForm({
        token: token || '',
        email: email || '',
        password: '',
        password_confirmation: '',
    });

    function submit(e) {
        e.preventDefault();
        post('/password/reset');
    }

    return (
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Reset Password</div>
                    <div className="card-body">
                        <form onSubmit={submit}>
                            <div className="form-group row">
                                <label htmlFor="email" className="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div className="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        required
                                        autoComplete="email"
                                        autoFocus
                                    />
                                    {errors.email && <span className="invalid-feedback d-block" role="alert"><strong>{errors.email}</strong></span>}
                                </div>
                            </div>

                            <div className="form-group row">
                                <label htmlFor="password" className="col-md-4 col-form-label text-md-right">Password</label>
                                <div className="col-md-6">
                                    <input
                                        id="password"
                                        type="password"
                                        className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        required
                                        autoComplete="new-password"
                                    />
                                    {errors.password && <span className="invalid-feedback d-block" role="alert"><strong>{errors.password}</strong></span>}
                                </div>
                            </div>

                            <div className="form-group row">
                                <label htmlFor="password-confirm" className="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div className="col-md-6">
                                    <input
                                        id="password-confirm"
                                        type="password"
                                        className="form-control"
                                        value={data.password_confirmation}
                                        onChange={(e) => setData('password_confirmation', e.target.value)}
                                        required
                                        autoComplete="new-password"
                                    />
                                </div>
                            </div>

                            <div className="form-group row mb-0">
                                <div className="col-md-6 offset-md-4">
                                    <button type="submit" className="btn btn-primary" disabled={processing}>Reset Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

ResetPassword.layout = (page) => <AuthLayout>{page}</AuthLayout>;
