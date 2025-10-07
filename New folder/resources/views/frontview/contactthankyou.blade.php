@extends('layouts.front')
@section('title', 'Thank You')

@section('content')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">Thank You</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <section class="section-padding thank-you">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5">
                <span class="bg-primary pr-3">Thank You</span>
            </h5>
            <div class="row px-xl-5 justify-content-between d-flex">
                <div class="col-lg-4 thank-you-img ">
                    <img src="{{ asset('assets/front/img/thankyou.gif') }}" alt="Thank You" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2 class="text-pink">Thank You for Connecting with Sparsh Cosmo Group</h2>
                    <p>
                        We appreciate your interest in <strong>Sparsh Cosmo Group</strong>. Your message has been received,
                        and our
                        team will get back to you shortly.
                    </p>
                    <p>
                        Whether you're looking for more information about our products, exploring partnership opportunities,
                        or
                        simply reaching out with a question — your trust means everything to us.
                    </p>
                    <p>
                        In the meantime, feel free to browse our offerings in <strong>Neem Oil</strong>,
                        <strong>Perfume</strong>,
                        <strong>Kajal</strong>, and <strong>Soap</strong>, and discover how our products can support your
                        journey to
                        natural wellness.
                    </p>
                    <p class="text-pink">
                        Thank you once again for choosing Sparsh. We look forward to staying in touch.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
