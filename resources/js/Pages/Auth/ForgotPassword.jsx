import React from 'react';
import { useForm, usePage } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';

export default function ForgotPassword() {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({ email: '' });

    function submit(e) {
        e.preventDefault();
        post('/password/email');
    }

    return (
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Reset Password</div>
                    <div className="card-body">
                        {flash?.status && <div className="alert alert-success" role="alert">{flash.status}</div>}

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

                            <div className="form-group row mb-0">
                                <div className="col-md-6 offset-md-4">
                                    <button type="submit" className="btn btn-primary" disabled={processing}>Send Password Reset Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

ForgotPassword.layout = (page) => <AuthLayout>{page}</AuthLayout>;
