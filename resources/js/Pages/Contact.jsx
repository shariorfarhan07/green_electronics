import React from 'react';
import { Link, useForm, usePage } from '@inertiajs/react';
import Layout from '../Layout';
import Icon from '../Components/Icon';

export default function Contact() {
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', email: '', subject: '', message: '',
    });

    function submit(e) {
        e.preventDefault();
        post('/contact', { onSuccess: () => reset() });
    }

    const errorList = Object.values(errors);

    return (
        <>
            <div className="wb-page-header">
                <div className="container">
                    <h2 className="wb-page-header__title">Contact Us</h2>
                    <nav className="wb-page-header__crumb">
                        <Link href="/" style={{ color: 'inherit' }}>Home</Link> <span className="brd-separetor">/</span> <span className="active">Contact</span>
                    </nav>
                </div>
            </div>

            <div className="wb-page">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-5 mb-4">
                            <div className="wb-info-card"><Icon name="pin" size={22} /><p>Haji Elias Market, 1st Floor, Shop No. 16 &amp; 62, Patuatuli, Dhaka-1100, Bangladesh</p></div>
                            <div className="wb-info-card"><Icon name="phone" size={22} /><p>01912-150390, 01875-589192, 01756-949732</p></div>
                            <div className="wb-info-card"><Icon name="mail" size={22} /><p>greenelectronicsbd@gmail.com</p></div>
                            <div className="wb-map mt-4">
                                <iframe
                                    title="Green Electronics BD location"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3653.088893398099!2d90.40664161429605!3d23.708519396293394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b906a8d62d5d%3A0x703a189882be42d8!2sGreen%20Electronics%20BD!5e0!3m2!1sen!2sbd!4v1595188894387!5m2!1sen!2sbd"
                                    allowFullScreen
                                    loading="lazy"
                                />
                            </div>
                        </div>
                        <div className="col-lg-7">
                            <div className="wb-summary wb-contact-form">
                                <div className="wb-summary__title">Send Us a Message</div>

                                {flash?.success && <div className="alert alert-success">{flash.success}</div>}
                                {errorList.length > 0 && (
                                    <div className="alert alert-danger">
                                        <ul className="mb-0">
                                            {errorList.map((err, i) => <li key={i}>{err}</li>)}
                                        </ul>
                                    </div>
                                )}

                                <form onSubmit={submit}>
                                    <div className="row">
                                        <div className="col-md-6 wb-field">
                                            <label>Your Name</label>
                                            <input type="text" className="form-control" placeholder="Your name" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                                        </div>
                                        <div className="col-md-6 wb-field">
                                            <label>Email</label>
                                            <input type="email" className="form-control" placeholder="you@example.com" value={data.email} onChange={(e) => setData('email', e.target.value)} required />
                                        </div>
                                    </div>
                                    <div className="wb-field">
                                        <label>Subject</label>
                                        <input type="text" className="form-control" placeholder="Subject" value={data.subject} onChange={(e) => setData('subject', e.target.value)} required />
                                    </div>
                                    <div className="wb-field">
                                        <label>Message</label>
                                        <textarea rows="5" className="form-control" placeholder="Write your message" value={data.message} onChange={(e) => setData('message', e.target.value)} required />
                                    </div>
                                    <button type="submit" className="wb-btn wb-btn--accent" disabled={processing}>
                                        {processing ? 'Sending…' : 'Send Message'}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Contact.layout = (page) => <Layout>{page}</Layout>;
