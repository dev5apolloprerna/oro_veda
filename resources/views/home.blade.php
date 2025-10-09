@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col">

                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            {{--  <h4 class="fs-16 mb-1">Admin Login</h4>  --}}
                                        </div>

                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->



                            <div class="row">

                                @if (Auth::user()->role_id == 1)
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate bg" >
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Category</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4">
                                                            <span class="counter-value"
                                                                data-target="{{ $Category }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('category.index') }}"
                                                            class="text-decoration-underline -50">View
                                                            Category</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-regular fa-rectangle-list"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Product</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $Product }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('product.index') }}"
                                                            class="text-decoration-underline -50">View
                                                            Product</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-box-open"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Offer</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $Offer }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('offer.index') }}"
                                                            class="text-decoration-underline -50">View
                                                            Offer</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-box-open"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Courier</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $Courier }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('courier.index') }}"
                                                            class="text-decoration-underline -50">
                                                            View Courier</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-users"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>







                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Inquiry</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $Inquiry }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('Inquiry.index') }}"570f29
                                                            class="text-decoration-underline -50">
                                                            View Inquiry</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Today's Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $TodaysOrder }}">0</span>
                                                        </h4>
                                                        <!--<a href="{{ route('Inquiry.index') }}"-->
                                                        <!--    class="text-decoration-underline -50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Pending Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrder }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('order.pending') }}"
                                                            class="text-decoration-underline -50">
                                                            View Pending Order</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--  <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Pending Order Tirupati</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrderTirupati }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('order.tirupati') }}"
                                                            class="text-decoration-underline -50">
                                                            View Pending Order Tirupati</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <!--<i class="fa-solid fa-circle-question"></i>-->
                                                            <img style="width: 52px;height: 45px;"
                                                                src="{{ asset('images/favicon.ico') }}">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  --}}

                                    {{--  <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Pending Order Delivery</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrderDelivery }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('order.delivery') }}"
                                                            class="text-decoration-underline -50">
                                                            View Pending Order Delivery</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  --}}

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Dispatched Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $DispatchedOrder }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('order.dispatched') }}"
                                                            class="text-decoration-underline -50">
                                                            View Dispatched Order</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-truck-fast"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Today's Collection</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $TodaysCollection }}">0</span>
                                                        </h4>
                                                        <!--<a href="{{ route('Inquiry.index') }}"-->
                                                        <!--    class="text-decoration-underline -50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold  text-truncate mb-0">
                                                            Pending Order Delivery</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary  mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrderDelivery }}">0</span>
                                                        </h4>
                                                        <a href="{{ route('order.userpending') }}"
                                                            class="text-decoration-underline -50">
                                                            View Pending Order Delivery</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-dashboard rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ env('APP_NAME') }}
                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->


@endsection
