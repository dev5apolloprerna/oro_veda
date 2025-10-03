@extends('layouts.front')
@section('title', 'My Orders')

@section('content')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered</h3>
                    <nav class="breadcrumb mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">My Orders</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <section class="section-padding my-account bg-light" id="my-account">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5">
                <span class="bg-primary text-white pr-3 pl-2 py-1 rounded">My Account</span>
            </h5>

            <div class="row px-xl-5 justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body p-4 p-md-5">

                            @include('frontview.after_login.tabview')

                            <!-- Orders Content -->
                            <h5 class="fw-semibold mb-3 text-pink">Your Orders</h5>

                            @forelse ($orders as $order)
                                <div class="mb-4 border-bottom pb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Order #{{ $order->order_id }}</h6>
                                        {{--  <span class="badge bg-success">Delivered</span>  --}}
                                        @if ($order->isPayment == 1)
                                            <span class="badge bg-success">Paid</span>
                                        @elseif ($order->isPayment == 2)
                                            <span class="badge bg-warning text-dark">Failed</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </div>

                                    <table class="table table-light table-borderless table-hover text-center mb-0 mt-3">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Size</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td class="align-middle" style="width: 50px;">
                                                        <img src="{{ asset('uploads/product/' . $item->photo) }}"
                                                            width="50" alt="">
                                                    </td>
                                                    <td class="align-middle">{{ $item->productname }}</td>
                                                    <td class="align-middle">₹{{ $item->rate }}</td>
                                                    <td class="align-middle">
                                                        {{ $item->product_attribute_qty . ' (' . $item->name . ')' }}
                                                    </td>
                                                    <td class="align-middle">{{ $item->quantity }}</td>
                                                    <td class="align-middle">₹{{ $item->rate * $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <img src="{{ asset('assets/front/img/no-product.gif') }}" alt="No Orders"
                                        style="max-width: 300px;">
                                    <p class="mt-3">You have no orders yet.</p>
                                    <a href="{{ route('FrontIndex') }}" class="btn btn-primary">Back to Home</a>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
