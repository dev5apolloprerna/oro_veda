@extends('layouts.front')

@section('title', 'Product Listing')

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
                        {{--  <a class="breadcrumb-item text-dark" href="#">Product</a>  --}}
                        <span class="breadcrumb-item active">{{ $Category->categoryname }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <section class="section-padding">
        <div class="container-fluid">
            <div class="row px-xl-5">

                <!-- Shop Product Start -->
                <div class="col-lg-12 col-md-8">
                    <div class="row pb-3">

                        @if ($products->count())
                            @php
                                $currentSort = request('sort', 'latest');
                                $currentLimit = request('limit', 10);
                            @endphp
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    
                                    <div class="ml-2">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                                data-toggle="dropdown">Sorting: {{ ucfirst($currentSort) }}</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}">Latest</a>
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Popularity</a>
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}">Best
                                                    Rating</a>
                                            </div>
                                        </div>
                                        <div class="btn-group ml-2">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                                data-toggle="dropdown">Showing: {{ $currentLimit }}</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['limit' => 10, 'page' => 1]) }}">10</a>
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['limit' => 20, 'page' => 1]) }}">20</a>
                                                <a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['limit' => 30, 'page' => 1]) }}">30</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($products as $product)
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <a class=""
                                                href="{{ route('product_detail', [$Category->slugname, $product->slugname]) }}"> <img class="img-fluid w-100"
                                                src="{{ asset('uploads/product/thumbnail/') . '/' . $product->photo }}"
                                                alt="{{ $product->productname }}"></a>

                                            <!--<div class="product-action">-->

                                            <!--    <form action="{{ route('cart.store') }}" method="POST"-->
                                            <!--        enctype="multipart/form-data">-->
                                            <!--        @csrf-->
                                            <!--        <input type="hidden" value="{{ $product->id ?? 0 }}" name="productid">-->
                                            <!--        <input type="hidden" value="{{ $product->categoryId }}"-->
                                            <!--            name="categoryId">-->
                                            <!--        <input type="hidden" value="{{ $product->productname }}"-->
                                            <!--            name="productname">-->
                                            <!--        <input type="hidden" value="{{ $product->photo }}" name="image">-->
                                            <!--        <input type="hidden" name="price" value="{{ $product->rate }}">-->
                                            <!--        <input type="hidden" name="quantity" value="1">-->

                                                    <!-- Add to Cart Button -->
                                            <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                            <!--            <i class="fa fa-shopping-cart"></i>-->
                                            <!--        </button>-->
                                            <!--    </form>-->

                                            <!--    <form action="{{ route('wishlist.store') }}" method="POST">-->
                                            <!--        @csrf-->
                                            <!--        <input type="hidden" value="{{ $product->id ?? 0 }}" name="productid">-->
                                            <!--        <input type="hidden" name="price" value="{{ $product->rate }}">-->
                                            <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                            <!--            <i class="far fa-heart"></i>-->
                                            <!--        </button>-->
                                            <!--    </form>-->


                                            <!--</div>-->

                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="{{ route('product_detail', [$Category->slugname, $product->slugname]) }}">
                                                {{ $product->productname }}
                                            </a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>₹{{ $product->rate }}</h5> &nbsp;
                                                <h6 class="text-muted ml-2"><del>₹{{ $product->cut_price }}</del></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="col-lg-12 text-center py-5">
                                {{--  <h4 class="text-muted">No products available in this category.</h4>  --}}
                                <img src="{{ asset('assets/front/img/no-product.gif') }}" alt="No Products"
                                    style="max-width: 300px; margin-top: 20px;"> <br>
                                {{--  <p class="mt-3">Please check back later or browse other categories.</p>  --}}
                                <a href="{{ route('FrontIndex') }}" class="btn btn-primary mt-3">Back to Home</a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Shop Product End -->
            </div>
        </div>
    </section>
    <!-- Shop End -->

@endsection

@section('scripts')

@endsection
