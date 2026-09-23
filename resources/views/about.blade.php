@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">About Us</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">About</span></nav>
    </div>
</div>

<div class="wb-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mb-4">
                <h3 class="mb-3">Bangladesh's electronics component store</h3>
                <p style="color:var(--ink-soft);line-height:1.8;">
                    Green Electronics is one of the largest electronics component wholesalers in Bangladesh, supplying
                    makers, students, hobbyists and engineers with genuine parts at the best price in town &mdash;
                    from Arduino boards and sensors to robotics parts, CNC & 3D printing supplies, and passive components.
                </p>
                <p style="color:var(--ink-soft);line-height:1.8;">
                    Whether you're prototyping a final year project, building a robot, or stocking up on
                    resistors and connectors, our shop in Patuatuli, Dhaka and this website exist to get you the
                    right part, fast.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="wb-info-card"><x-icon name="pin" :size="22" /><p>Haji Elias Market, 1st Floor, Shop No. 16 & 62, Patuatuli, Dhaka-1100, Bangladesh</p></div>
                <div class="wb-info-card"><x-icon name="phone" :size="22" /><p>01912-150390, 01875-589192, 01756-949732</p></div>
                <div class="wb-info-card"><x-icon name="mail" :size="22" /><p>greenelectronicsbd@gmail.com</p></div>
            </div>
        </div>

        <div style="margin-top:2rem;padding-top:1.3rem;border-top:1px solid var(--line);text-align:center;font-size:.8rem;color:var(--ink-faint);">
            Owned by <a href="https://www.facebook.com/parvez.jahid.2024" target="_blank" rel="noopener">Parvez Jahid</a>
            &middot; Developed by <a href="https://shariorfarhan.com" target="_blank" rel="noopener">Sharior Farhan</a>
        </div>
    </div>
</div>

@endsection
