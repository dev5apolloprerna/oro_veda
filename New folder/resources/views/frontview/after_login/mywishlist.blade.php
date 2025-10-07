@extends('layouts.front')

@section('title', 'My Wishlist')

@section('content')

    @include('common.frontmodalalert')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered</h3>
                    <nav class="breadcrumb mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">My Wishlist</span>
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

                            <!-- Wishlist Content -->
                            <h5 class="fw-semibold mb-3 text-pink">Your Wishlist</h5>
                            @if ($wishlist->count())
                                <table class="table table-light table-borderless table-hover text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wishlist as $list)
                                            <tr>
                                                <td style="width: 50px;">
                                                    <img src="{{ asset('uploads/product/' . $list->photo) }}" alt=""
                                                        width="50">
                                                </td>
                                                <td class="align-middle">{{ $list->productname }}</td>
                                                <td class="align-middle">₹{{ $list->rate }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5">
                                    <img src="{{ asset('assets/front/img/no-product.gif') }}" alt="No Products"
                                        style="max-width: 300px;">
                                    <p class="mt-3">Your wishlist is empty.</p>
                                    <a href="{{ route('FrontIndex') }}" class="btn btn-primary">Back to Home</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
