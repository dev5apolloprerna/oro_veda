@extends('layouts.front')
@section('title', 'Login')

@section('content')

    @include('common.frontmodalalert')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">Login</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <section class="section-padding login">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5">
                <span class="bg-primary pr-3">Login to Your Account</span>
            </h5>
            <div class="row px-xl-5 justify-content-center">
                <div class="col-lg-6">
                    <h2>Login</h2>
                    <form method="post" action="{{ route('FrontLoginStore') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Mobile</label>
                            <input type="text" class="form-control" name="customermobile" id="customermobile"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                maxlength="10" minlength="10" placeholder="Enter your Mobile" required autocomplete="off"
                                value="{{ old('customermobile') }}">
                            {{--  <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                required>  --}}
                        </div>

                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter your password" required>
                                <div class="input-group-append">
                                <span class="input-group-text bg-transparent icon" onclick="togglePassword()" style="cursor: pointer;">
                                    <i class="fa fa-eye" id="toggleIcon"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-4 gap-3">
                        <a href="{{ route('forgotpassword') }}" style="color:#000; align-items:center">
                            Forgot Password
                        </a>
                        <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
