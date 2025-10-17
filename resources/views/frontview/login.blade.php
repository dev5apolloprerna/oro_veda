@extends('layouts.front')
@section('title', 'Login')

@section('content')

    @include('common.frontmodalalert')

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 col-lg-5">
                <div class="login-card text-center">
                    <div class="login-header mb-4">
                        <h2>Welcome to Oroveda</h2>
                        <p>Enter your email to get OTP in your mail</p>
                    </div>
                    <form method="post" action="{{ route('front.login_store') }}">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-login">Get OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
