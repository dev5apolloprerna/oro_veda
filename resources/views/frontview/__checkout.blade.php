@extends('layouts.front')
@section('title', 'Checkout')
@section('content')

    @include('common.frontmodalalert')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        {{--  <a class="breadcrumb-item text-dark" href="#">Product</a>  --}}
                        <span class="breadcrumb-item active">Checkout</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <section class="section-padding">
        <div class="container-fluid">
            {{--  <form action="{{ route('checkoutstore') }}" method="post">  --}}
            <form id="checkout-form">
                @csrf

                <div class="row px-xl-5">
                    <div class="col-lg-8">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-primary pr-3">Billing
                                Address</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input name="billFirstName" id="billFirstName" class="form-control" type="text"
                                        placeholder="John" value="{{ old('billFirstName') }}" required="required"
                                        autocomplete="off">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="billLastName" id="billLastName" type="text"
                                        placeholder="Doe" value="{{ old('billLastName') }}" required="required"
                                        autocomplete="off">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="billEmail" id="billEmail"
                                        placeholder="example@email.com" value="{{ old('billEmail') }}" required="required"
                                        autocomplete="off">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" name="billPhone" id="billPhone"
                                        onkeydown="checkcustomer();"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        maxlength="10" minlength="10" required="required" autocomplete="off"
                                        value="{{ old('billPhone') }}" placeholder="+123 456 789">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Address Line 1</label>
                                    <input class="form-control" type="text" name="billStreetAddress1"
                                        id="billStreetAddress1" placeholder="123 Street" required="required"
                                        autocomplete="off" value="{{ old('billStreetAddress1') }}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Address Line 2</label>
                                    <input class="form-control" type="text" name="billStreetAddress2"
                                        id="billStreetAddress2" placeholder="123 Street" required="required"
                                        autocomplete="off" value="{{ old('billStreetAddress2') }}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <input class="form-control" type="text" name="strCountry" id="strCountry"
                                        required="required" readonly value="India">
                                    {{--  <select class="custom-select">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>  --}}
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <select class="custom-select" name="billState" required>
                                        <option value="">Select state</option>
                                        @foreach ($State as $state)
                                            <option value="{{ $state->stateId }}"
                                                {{ old('billState') == $state->stateId ? 'selected' : '' }}>
                                                {{ $state->stateName }}</option>
                                        @endforeach
                                    </select>
                                    {{--  <input class="form-control" type="text" placeholder="New York">  --}}
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control" type="text" name="shipping_city" id="shipping_city"
                                        placeholder="Ahmedabad" required="required" value="{{ old('shipping_city') }}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>ZIP Code</label>
                                    <input class="form-control" type="text" name="billPinCode" id="billPinCode"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        minlength="6" maxlength="6" placeholder="123" required="required"
                                        value="{{ old('billPinCode') }}" autocomplete="off">
                                </div>
                                {{--  <div class="col-md-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="newaccount">
                                    <label class="custom-control-label" for="newaccount">Create an account</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="shipto">
                                    <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                        data-target="#shipping-address">Ship to different address</label>
                                </div>
                            </div>  --}}
                            </div>
                        </div>
                        <div class="collapse mb-5" id="shipping-address">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span
                                    class="bg-primary pr-3">Shipping Address</span></h5>
                            <div class="bg-light p-30">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" placeholder="John">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" placeholder="Doe">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" placeholder="example@email.com">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" placeholder="+123 456 789">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Address Line 1</label>
                                        <input class="form-control" type="text" placeholder="123 Street">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Address Line 2</label>
                                        <input class="form-control" type="text" placeholder="123 Street">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country</label>
                                        <select class="custom-select">
                                            <option selected>United States</option>
                                            <option>Afghanistan</option>
                                            <option>Albania</option>
                                            <option>Algeria</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" placeholder="New York">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text" placeholder="New York">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>ZIP Code</label>
                                        <input class="form-control" type="text" placeholder="123">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <h5 class="section-title position-relative text-uppercase mb-3">
                            <span class="bg-primary pr-3">Order Total</span>
                        </h5>
                        <div class="bg-light p-30 mb-3">
                            <div class="border-bottom">
                                <h6 class="mb-3">Products</h6>
                                <?php
                                $cartItems = \Cart::getContent();
                                $subtotal = \Cart::getSubTotal();
                                $discount = session('discount', 0);
                                $grandTotal = $subtotal - $discount;
                                ?>
                                @foreach ($cartItems as $item)
                                    <div class="d-flex justify-content-between">
                                        <p>{{ $item->name }}</p>
                                        <p>₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-bottom pt-3 ">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6>₹{{ number_format($subtotal, 2) }}</h6>
                                </div>

                                @if ($discount > 0)
                                    <div class="d-flex justify-content-between mb-3 text-success">
                                        <h6>Coupon Discount</h6>
                                        <h6>- ₹{{ number_format($discount, 2) }}</h6>
                                    </div>
                                @endif

                            </div>
                            <div class="pt-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5>Total</h5>
                                    <h5>₹{{ number_format($grandTotal, 2) }}</h5>
                                </div>
                            </div>

                        </div>

                        <div class="mb-5">
                            <button type="submit"
                                class="btn btn-block btn-primary {{ \Cart::isEmpty() ? 'disabled' : '' }}">Place
                                Order</button>
                        </div>

                    </div>

                    <input type="hidden" name="discount" value="{{ $discount }}">

                </div>
            </form>
        </div>
    </section>
    <!-- Checkout End -->

    <!-- Razorpay Loader Overlay -->
    <div class="overlay" id="overlay"
        style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
        <div class="loader"
            style="border: 8px solid #f3f3f3; border-top: 8px solid #8c563d; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite;">
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="processingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <!--<h4>Thank you!</h4>-->
                <p>Your order is being processed. Please wait...</p>
                <div class="spinner-border text-primary mx-auto" role="status"></div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        function checkcustomer() {

            var phone = $('#billPhone').val();
            var url = "{{ route('checkmobile') }}";

            if (phone.length == 10) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        phone: phone,
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        $('#billFirstName').val(obj.firstname);
                        $('#billLastName').val(obj.lastname);
                        $('#billEmail').val(obj.customeremail);
                        $('#billStreetAddress1').val(obj.address);
                        $('#billStreetAddress2').val(obj.address1);

                        $('#state_province').val(obj.state);

                        $('#shipping_city').val(obj.city);
                        // $('#strCountry').val(obj.country);
                        $('#billPinCode').val(obj.pincode);
                    }
                });
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        // ✅ CSRF Setup for all AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showLoader() {
            document.getElementById('overlay').style.display = 'flex';
        }

        function hideLoader() {
            document.getElementById('overlay').style.display = 'none';
        }

        $('#checkout-form').submit(function(e) {
            e.preventDefault();
            showLoader();

            $.ajax({
                url: "{{ route('checkoutstore') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {

                        // Show modal
                        $('#processingModal').modal('show');

                        const options = {
                            "key": "{{ config('app.razorpay_key') }}",
                            "amount": response.amount * 100,
                            "currency": "INR",
                            "order_id": response.razorpay_order_id,
                            "name": "Sparsh Cosmo Group",
                            "description": "Order Payment",
                            "handler": function(r) {
                                $.post("{{ route('razprpay.success') }}", {
                                    razorpay_payment_id: r.razorpay_payment_id,
                                    razorpay_order_id: r.razorpay_order_id,
                                    razorpay_signature: r.razorpay_signature,
                                    orderId: response.order_id
                                }, function(res) {
                                    // Use res.id instead of res directly
                                    window.location.href =
                                        "{{ route('razorpay.thankyou', ':id') }}"
                                        .replace(':id', res.id);
                                });
                            },
                            "prefill": {
                                "name": response.customer_name,
                                "email": response.email,
                                "contact": response.mobile
                            },
                            "theme": {
                                "color": "#eb268f"
                            },
                            modal: {
                                ondismiss: function() {
                                    // Mark payment as failed
                                    $.post("{{ route('razorpay.payment_cancel_by_user') }}", {
                                        orderId: response.order_id,
                                    }, function() {
                                        window.location.href =
                                            "{{ route('razorpay.RazorFail') }}";
                                    });
                                }
                            }
                        };
                        const rzp = new Razorpay(options);
                        rzp.open();
                        hideLoader();
                    } else {
                        alert('Something went wrong.');
                        hideLoader();
                    }
                },
                error: function(err) {
                    alert('Checkout failed. Please try again.');
                    hideLoader();
                }
            });
        });
    </script>

@endsection
