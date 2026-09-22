@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Contact Us</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Contact</span></nav>
    </div>
</div>

<div class="wb-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="wb-info-card"><x-icon name="pin" :size="22" /><p>Haji Elias Market, 1st Floor, Shop No. 16 & 62, Patuatuli, Dhaka-1100, Bangladesh</p></div>
                <div class="wb-info-card"><x-icon name="phone" :size="22" /><p>01912-150390, 01875-589192, 01756-949732</p></div>
                <div class="wb-info-card"><x-icon name="mail" :size="22" /><p>greenelectronicsbd@gmail.com</p></div>
                <div class="wb-map mt-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3653.088893398099!2d90.40664161429605!3d23.708519396293394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b906a8d62d5d%3A0x703a189882be42d8!2sGreen%20Electronics%20BD!5e0!3m2!1sen!2sbd!4v1595188894387!5m2!1sen!2sbd" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="wb-summary wb-contact-form">
                    <div class="wb-summary__title">Send Us a Message</div>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-6 wb-field">
                                <label>Your Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Your name" required>
                            </div>
                            <div class="col-md-6 wb-field">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                        </div>
                        <div class="wb-field">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="wb-field">
                            <label>Message</label>
                            <textarea name="message" rows="5" class="form-control" placeholder="Write your message"></textarea>
                        </div>
                        <button type="submit" class="wb-btn wb-btn--accent">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
