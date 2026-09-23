import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AuthLayout from '../../AuthLayout';

export default function VerifyEmail() {
    const { flash } = usePage().props;

    return (
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Verify Your Email Address</div>
                    <div className="card-body">
                        {flash?.resent && (
                            <div className="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        )}

                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email,{' '}
                        <Link href="/email/resend" method="post" as="button" className="btn btn-link p-0 m-0 align-baseline">
                            click here to request another
                        </Link>.
                    </div>
                </div>
            </div>
        </div>
    );
}

VerifyEmail.layout = (page) => <AuthLayout>{page}</AuthLayout>;
