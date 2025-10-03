@extends('layouts.front')

@section('title', 'Set New Password')

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
                        <span class="breadcrumb-item active">Set New Password</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <section class="section-padding login">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5">
                <span class="bg-primary pr-3">Reset Your Password</span>
            </h5>
            <div class="row px-xl-5 justify-content-center">
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('set_new_password_submit') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter new password" required>
                                <div class="input-group-append">
                                <span class="input-group-text bg-transparent icon"  onclick="togglePassword('password', 'toggleIcon1')" style="cursor: pointer;">
                                <i class="fa fa-eye" id="toggleIcon1"></i>
                            </span> </div>   </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm New Password</label>
                            <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm your new password" required>
                                
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent icon"  onclick="togglePassword('password_confirmation', 'toggleIcon2')" style="cursor: pointer;">
                                <i class="fa fa-eye" id="toggleIcon2"></i>
                            </span>    </div></div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
