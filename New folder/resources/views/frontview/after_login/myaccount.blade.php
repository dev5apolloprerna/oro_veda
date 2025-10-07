@extends('layouts.front')

@section('title', 'My Account')

@section('content')

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('FrontIndex') }}">Home</a>
                        <span class="breadcrumb-item active">Sign up</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <section class="section-padding my-account bg-light" id="my-account">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5" data-aos="fade-down">
                <span class="bg-primary text-white pr-3 pl-2 py-1 rounded">My Account</span>
            </h5>

            <div class="row px-xl-5 justify-content-center mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="col-lg-10">
                    <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body p-4 p-md-5">

                            @include('frontview.after_login.tabview')

                            <!-- Tabs Content -->
                            <div class="tab-content" id="accountTabsContent">

                                <!-- Profile Tab -->
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <h5 class="fw-semibold mb-3 text-pink">Profile Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong> John Doe</p>
                                            <p><strong>Email:</strong> john@example.com</p>
                                            <p><strong>Phone:</strong> +91-9876543210</p>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary mt-3">Edit Profile</a>
                                </div>

                                <!-- Orders Tab -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <h5 class="fw-semibold mb-3 text-pink">Your Orders</h5>


                                    <h6 class="list-group-item d-flex justify-content-between align-items-center">
                                        Order #12345 <span class="badge bg-success">Delivered</span>
                                    </h6>
                                    <hr>
                                    <table class="table table-light table-borderless table-hover text-center mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th></th>
                                                <th>Products</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>

                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">

                                            <tr>
                                                <td class="align-middle" style="width: 50px;"><img src="img/product-1.jpg"
                                                        alt="" style="width: 50px;"></td>
                                                <td> Product Name</td>
                                                <td class="align-middle">₹150</td>
                                                <td class="align-middle">
                                                    5
                                                </td>
                                                <td class="align-middle">₹150</td>

                                            </tr>
                                            <tr>
                                                <td class="align-middle" style="width: 50px;"><img src="img/product-2.jpg"
                                                        alt="" style="width: 50px;"></td>
                                                <td> Product Name</td>
                                                <td class="align-middle">₹150</td>
                                                <td class="align-middle">
                                                    3
                                                </td>
                                                <td class="align-middle">₹150</td>

                                            </tr>
                                        </tbody>
                                    </table>

                                    <br>
                                    <br>
                                    <h6 class="list-group-item d-flex justify-content-between align-items-center">
                                        Order #12344 <span class="badge bg-warning text-dark">Pending</span>
                                    </h6>
                                    <hr>
                                    <table class="table table-light table-borderless table-hover text-center mb-0">
                                        <tr>
                                            <th></th>
                                            <th>Products</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-3.jpg"
                                                    alt="" style="width: 50px;"></td>
                                            <td> Product Name</td>
                                            <td class="align-middle">₹150</td>
                                            <td class="align-middle">
                                                6
                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-4.jpg"
                                                    alt="" style="width: 50px;"> </td>
                                            <td>Product Name</td>
                                            <td class="align-middle">₹150</td>
                                            <td class="align-middle">

                                                2
                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-5.jpg"
                                                    alt="" style="width: 50px;"> </td>
                                            <td> Name</td>
                                            <td class="align-middle">₹150</td>
                                            <td class="align-middle">
                                                5
                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <a href="#" class="btn btn-outline-primary mt-3">View All Orders</a>
                                </div>

                                <!-- Wishlist Tab -->
                                <div class="tab-pane fade" id="wishlist" role="tabpanel">
                                    <h5 class="fw-semibold mb-3 text-pink">Your Wishlist</h5>
                                    <table class="table table-light table-borderless table-hover text-center mb-0">
                                        <tr>
                                            <th></th>
                                            <th>Products</th>
                                            <th></th>
                                            <th></th>
                                            <th>Price</th>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-3.jpg"
                                                    alt="" style="width: 50px;"> </td>
                                            <td>Product Name</td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">

                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-4.jpg"
                                                    alt="" style="width: 50px;"> </td>
                                            <td> Product Name</td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">


                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><img src="img/product-5.jpg"
                                                    alt="" style="width: 50px;"> </td>
                                            <td> Product Name</td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">

                                            </td>
                                            <td class="align-middle">₹150</td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Logout -->
                            <div class="text-end mt-5">
                                <a href="#" class="btn btn-danger px-4">Logout</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
