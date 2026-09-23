import React from 'react';
import { Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors } = useForm({ password: '' });

    function submit(e) {
        e.preventDefault();
        post('/password/confirm');
    }

    return (
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Confirm Password</div>
                    <div className="card-body">
                        Please confirm your password before continuing.

                        <form onSubmit={submit}>
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
                                        autoComplete="current-password"
                                    />
                                    {errors.password && <span className="invalid-feedback d-block" role="alert"><strong>{errors.password}</strong></span>}
                                </div>
                            </div>

                            <div className="form-group row mb-0">
                                <div className="col-md-8 offset-md-4">
                                    <button type="submit" className="btn btn-primary" disabled={processing}>Confirm Password</button>
                                    <Link className="btn btn-link" href="/password/reset">Forgot Your Password?</Link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

ConfirmPassword.layout = (page) => <AuthLayout>{page}</AuthLayout>;
