@extends('layout.app')

@section('content')

<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Contact US</h2>
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb-item active">Contact US</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Contact Area -->
<section class="htc__contact__area ptb--120 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="htc__contact__container">
                    <div class="htc__contact__address">
                        <h2 class="contact__title">contact info</h2>
                        <div class="contact__address__inner">
                            <!-- Start Single Adress -->
                            <div class="single__contact__address">
                                <div class="contact__icon">
                                    <span class="ti-location-pin"></span>
                                </div>
                                <div class="contact__details">
                                    <p>Location : <br> Haji Elias Market.<br>1st Floor,Shop No:16,62,<br>Patuatuli,Dhaka-1100,Bangladesh</p>
                                </div>
                            </div>
                            <!-- End Single Adress -->
                        </div>
                        <div class="contact__address__inner">
                            <!-- Start Single Adress -->
                            <div class="single__contact__address">
                                <div class="contact__icon">
                                    <span class="ti-mobile"></span>
                                </div>
                                <div class="contact__details">
                                    <p> Phone : <br><a href="#">01912150390<br>01875589192<br>01756949732</a></p>
                                </div>
                            </div>
                            <!-- End Single Adress -->
                            <!-- Start Single Adress -->
                            <div class="single__contact__address">
                                <div class="contact__icon">
                                    <span class="ti-email"></span>
                                </div>
                                <div class="contact__details">
                                    <p> Mail :<br><a href="#">greenelectronicsbd@gmail.com</a></p>
                                </div>
                            </div>
                            <!-- End Single Adress -->
                        </div>
                    </div>


                    <div class="contact-form-wrap">
                        <div class="contact-title">
                            <h2 class="contact__title">Get In Touch</h2>
                        </div>
                        <form id="contact-form" action="mail.php" method="post">
                            <div class="single-contact-form">
                                <div class="contact-box name">
                                    <input type="text" name="name" placeholder="Your Nme*">
                                    <input type="email" name="email" placeholder="Mail*">
                                </div>
                            </div>
                            <div class="single-contact-form">
                                <div class="contact-box subject">
                                    <input type="text" name="subject" placeholder="Subject*">
                                </div>
                            </div>
                            <div class="single-contact-form">
                                <div class="contact-box message">
                                    <textarea name="message"  placeholder="Massage*"></textarea>
                                </div>
                            </div>
                            <div class="contact-btn">
                                <button type="submit" class="fv-btn">SEND</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-output">
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>











            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3653.088893398099!2d90.40664161429605!3d23.708519396293394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b906a8d62d5d%3A0x703a189882be42d8!2sGreen%20Electronics%20BD!5e0!3m2!1sen!2sbd!4v1595188894387!5m2!1sen!2sbd" width="100%" height="600" frameborder="5" style="border:1;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Area -->



@endsection
