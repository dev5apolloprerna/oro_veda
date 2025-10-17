@extends('layouts.front')
@section('title', 'Login')

@section('content')

    @include('common.frontmodalalert')

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 col-lg-4">
                <div class="otp-card">
                    <div class="otp-header">
                        <h2>Enter OTP</h2>
                        <p>We’ve sent a 4-digit code to your registered email.</p>
                    </div>

                    <form method="POST" action="{{ route('front.otp_store') }}">
                        @csrf

                        {{-- Hidden email field --}}
                        <input type="hidden" name="email" value="{{ session('front_login_email') }}">

                        {{-- Combined OTP input (hidden) --}}
                        <input type="hidden" name="otp" id="otp_value">

                        <div class="otp-inputs d-flex justify-content-between mb-3">
                            <input type="text" maxlength="1" class="otp-field" required>
                            <input type="text" maxlength="1" class="otp-field" required>
                            <input type="text" maxlength="1" class="otp-field" required>
                            <input type="text" maxlength="1" class="otp-field" required>
                        </div>
                        <button type="submit" class="btn btn-verify">Verify OTP</button>
                    </form>

                    <div class="resend-text">
                        <p>Didn’t receive the code? <a href="{{ route('front.resend_otp') }}">Resend OTP</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        const inputs = document.querySelectorAll('.otp-field');
        const otpValue = document.getElementById('otp_value');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Allow only digits
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Move to next field automatically
                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                // Update hidden combined OTP field
                otpValue.value = Array.from(inputs).map(i => i.value).join('');
            });

            input.addEventListener('keydown', (e) => {
                // Move back on Backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
@endsection
