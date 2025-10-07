@extends('layouts.front')

@section('title', 'Forgot Password')

@section('content')

    @include('common.frontmodalalert')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made, Trust Delivered</h3>
                    <nav class="breadcrumb mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">Forgot Password</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Forgot Password Section Start -->
    <section class="section-padding login">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5">
                <span class="bg-primary pr-3">Reset Your Password</span>
            </h5>
            <div class="row px-xl-5 justify-content-center">
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('forgotpasswordsubmit') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Registered Email Address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter your email address" required autocomplete="off"
                                value="{{ old('email') }}">
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Send Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Forgot Password Section End -->

@endsection

@section('scripts')
@endsection
