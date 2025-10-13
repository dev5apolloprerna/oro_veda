@extends('layouts.front')
@section('title', 'Checkout')
@section('content')

    @include('common.frontmodalalert')

    <section class="page-header" style="background: linear-gradient(135deg, #2a7d3e, #8bc34a)">
        <div class="header-overlay"></div>

        <div class="header-content">
            <h1>Checkout</h1>

            <nav class="bredcrum">
                <ul>
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </nav>
        </div>
    </section>

    <section class="checkout-container container">
        <div class="row g-4">
            <!-- Billing Details -->
            <div class="col-lg-7">
                <div class="billing-details">
                    <h4>Billing Details</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name *</label>
                                <input type="text" name="billFirstName" class="form-control"
                                    value="{{ old('billFirstName') }}" required="required" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name *</label>
                                <input type="text" name="billLastName" class="form-control"
                                    value="{{ old('billLastName') }}" required="required" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="text" name="billPhone" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="10" minlength="10" required="required" autocomplete="off"
                                    value="{{ old('billPhone') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Address *</label>
                                <input type="email" name="billEmail" id="billEmail" class="form-control"
                                    value="{{ old('billEmail') }}" required="required" autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Street Address *</label>
                            <input type="text" name="billStreetAddress1" class="form-control mb-2"
                                placeholder="House number and street name" required="required" autocomplete="off"
                                value="{{ old('billStreetAddress1') }}">
                            <input type="text" name="billStreetAddress2" class="form-control"
                                placeholder="Apartment, suite, etc. (optional)" required="required" autocomplete="off"
                                value="{{ old('billStreetAddress2') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Country *</label>
                                <select class="form-select" required>
                                    <option value="">Select Country</option>
                                    <!-- <option>Gujarat</option> -->
                                    <!-- <option>Maharashtra</option> -->
                                    <!-- <option>Rajasthan</option> -->
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>State *</label>
                                <select class="form-select" required>
                                    <option value="">Select State</option>
                                    <option>Gujarat</option>
                                    <option>Maharashtra</option>
                                    <option>Rajasthan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Town / City *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>PIN Code *</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Order Notes (optional)</label>
                            <textarea class="form-control" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="order-summary">

                    <h5>Your Order</h5>
                    <table class="table">
                        <tbody>
                            @php
                                $cartItems = \Cart::getContent();
                                $subtotal = \Cart::getSubTotal();
                                $discount = session('discount', 0);
                                $grandTotal = $subtotal - $discount;
                            @endphp

                            @foreach ($cartItems as $item)
                                <tr>
                                    <td> {{ $item->name . ' (' . $item->attribute_text . ')' }} </td>
                                    <td> Qty : {{ $item->quantity }} </td>
                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="fw-bold">Subtotal</td>
                                <td></td>
                                <td>₹{{ number_format($subtotal, 2) }}</td>
                            </tr>

                            @if ($discount > 0)
                                <tr>
                                    <td>Discount</td>
                                    <td></td>
                                    <td>- ₹₹{{ number_format($discount, 2) }}</td>
                                </tr>
                            @endif

                            {{--  <tr>
                                <td class="fw-bold">Shipping</td>
                                <td></td>
                                <td>₹0.00</td>
                            </tr>  --}}

                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
                            </tr>

                        </tbody>
                    </table>
                    <button class="btn-place-order">Place Order</button>
                </div>
            </div>
        </div>
    </section>



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

                        $('#billFirstName').val(data.firstname);
                        $('#billLastName').val(data.lastname);
                        $('#billEmail').val(data.customeremail);
                        $('#billStreetAddress1').val(data.address);
                        $('#billStreetAddress2').val(data.address1);
                        $('#billState').val(data.state);

                        $('#shipping_city').val(data.city);
                        // $('#strCountry').val(obj.country);
                        $('#billPinCode').val(data.pincode);
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
                                    // Hide the processing modal
                                    $('#processingModal').modal('hide');
                                    // Mark payment as failed
                                    $.post("{{ route('razorpay.payment_cancel_by_user') }}", {
                                        orderId: response.order_id,
                                    }, function() {
                                        window.location.href =
                                            "{{ route('razorpay.RazorFail') }}";
                                    }).fail(function() {
                                        hideLoader();
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
