@extends('layouts.front')
@section('title', 'Cart')
@section('content')

    @include('common.frontmodalalert')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">Cart</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->


    @if (\Cart::isEmpty())
        <div class="col-lg-12 text-center py-5">
            <img src="{{ asset('assets/front/img/no-product.gif') }}" alt="No Products"
                style="max-width: 300px; margin-top: 20px;"> <br>
            <a href="{{ route('FrontIndex') }}" class="btn btn-primary mt-3">Back to Home</a>
        </div>
    @else
        <!-- Cart Start -->
        <section class="section-padding">
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-8 table-responsive mb-5">
                        <table class="table table-light table-borderless table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">

                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="align-middle">
                                            <img src="{{ asset('uploads/product') . '/' . $item->attributes->image }}"
                                                alt="" style="width: 50px;">
                                            {{ $item->name }}
                                        </td>
                                        <td class="align-middle">₹{{ $item->price }}</td>
                                        <td class="align-middle">
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-secondary btn-minus"
                                                        onclick="decreaseCount(this, {{ $item->id }})">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm bg-secondary border-0 text-center"
                                                    value="{{ $item->quantity }}" id="quantity_{{ $item->id }}"
                                                    data-price="{{ $item->price }}" readonly>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-secondary btn-plus"
                                                        onclick="increaseCount(this, {{ $item->id }})">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        {{--  <td class="align-middle">₹{{ $item->price * $item->quantity }}</td>  --}}
                                        <td class="align-middle">₹<span
                                                id="total_{{ $item->id }}">{{ $item->price * $item->quantity }}</span>
                                        </td>

                                        <td class="align-middle">
                                            <form action="{{ route('cart.remove') }}" method="post" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">

                        <form class="mb-30" action="{{ route('couponcodeapply') }}" method="post">
                            @csrf
                            <input type="hidden" name="totalAmount" value="{{ \Cart::getTotal() }}">
                            <div class="input-group">
                                <input type="text" name="coupon" class="form-control"
                                    placeholder="Coupon Code" required autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </div>
                        </form>

                        <h5 class="section-title position-relative text-uppercase my-3"><span class="bg-primary pr-3">Cart
                                Summary</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6 id="subtotal">₹{{ \Cart::getSubTotal() }}</h6>
                                </div>
                                @if (Session::has('discount'))
                                    <div class="d-flex justify-content-between mb-3">
                                        <h6>Coupon Discount</h6>
                                        <h6>- ₹{{ Session::get('discount') }}</h6>
                                    </div>
                                @endif
                            </div>
                            <div class="pt-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5>Total</h5>
                                    @php
                                        $subtotal = \Cart::getSubTotal();
                                        $discount = Session::get('discount', 0);
                                        $total = $subtotal - $discount;
                                    @endphp
                                    <h5 id="total">₹{{ $total }}</h5>
                                </div>
                                {{--  <button class="btn btn-block btn-primary font-weight-bold my-3">  --}}
                                <a class="btn btn-block btn-primary font-weight-bold my-3 {{ \Cart::isEmpty() ? 'disabled' : '' }}"
                                    href="{{ route('checkout') }}">
                                    Proceed To Checkout
                                </a>
                                {{--  </button>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cart End -->
    @endif


@endsection

@section('scripts')

    <script>
        function increaseCount(a, itemId) {
            var input = document.getElementById('quantity_' + itemId);
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;

            updateCart(itemId, value);
        }

        function decreaseCount(a, itemId) {
            var input = document.getElementById('quantity_' + itemId);
            var value = parseInt(input.value, 10);
            if (value > 1) {
                value--;

                updateCart(itemId, value);
            }
        }

        function updateCart(itemId, quantity) {
            let token = '{{ csrf_token() }}';

            fetch("{{ route('cart.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        id: itemId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let price = document.getElementById('quantity_' + itemId).getAttribute('data-price');
                        let total = price * quantity;
                        document.getElementById('quantity_' + itemId).value = quantity;
                        document.getElementById('total_' + itemId).innerText = total;

                        // Optionally update subtotal/total
                        if (data.cart_summary) {
                            document.getElementById('subtotal').innerText = `₹${data.cart_summary.subtotal}`;
                            document.getElementById('total').innerText = `₹${data.cart_summary.total}`;
                        }
                    }
                });
        }
    </script>

@endsection
