@extends('layouts.front')

@section('title', 'Product Detail')

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
                        <a class="breadcrumb-item text-dark" href="#">Home</a>
                        <a class="breadcrumb-item text-dark"
                            href="{{ route('product_list', $Category->slugname) }}">{{ $Category->categoryname }}</a>
                        <span class="breadcrumb-item active">{{ $ProductDetail->productname }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <section class="section-padding">
        <div class="container-fluid ">
            <div class="row px-xl-5">
                <div class="col-lg-5 mb-30">
                    <div class="product-gallery">
                        <div class="main-image-container">
                            <img id="main-image"
                                src="{{ asset('uploads/product/thumbnail') . '/' . $ProductDetail->photo }}" alt="Product"
                                class="main-image" />
                        </div>
                        <div class="thumbnails">
                            @foreach ($Photos as $photos)
                                <img src="{{ asset('uploads/product/thumbnail') . '/' . $photos->strphoto }}"
                                    alt="Thumbnail 1" class="thumb active" onclick="updateMainImage(this)">
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 h-auto py-5">
                    <div class="h-100 bg-light p-30">
                        <h3 class="text-secondary">{{ $ProductDetail->productname }}</h3>
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="d-flex">
                                {{--  <h3 class="font-weight-semi-bold mb-4 text-pink">₹ {{ $ProductDetail->rate }}</h3>  --}}

                                <h3 class="font-weight-semi-bold mb-4 text-pink">
                                    ₹ <span id="product-price">
                                        {{ $ProductDetail->rate }}
                                    </span>
                                </h3>
                                
                                @php
                                  $displayPrice   = $ProductDetail->min_attr_price ?: $ProductDetail->rate;
                                  $selectedAttrId = $ProductDetail->min_attr_id ?? null;
                                @endphp

                                <select id="attribute-select" class="form-control dropdown">
                                    @foreach ($attributes as $attribute)
                                        <option value="{{ $attribute->id }}"
                                            data-price="{{ (float)$attribute->product_attribute_price }}"
                                            data-text="{{ $attribute->product_attribute_qty . ' ' . $attribute->attribute_name }}"
                                            {{ (int)$attribute->id === (int)$selectedAttrId ? 'selected' : '' }}>
                                            {{ $attribute->product_attribute_qty . ' ' . $attribute->attribute_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            @csrf

                            <input type="hidden" name="productid" value="{{ $ProductDetail->id }}">
                            <input type="hidden" name="categoryId" value="{{ $ProductDetail->categoryId }}">
                            <input type="hidden" name="productname" value="{{ $ProductDetail->productname }}">
                            <input type="hidden" name="image" value="{{ $ProductDetail->photo }}">
                            <input type="hidden" name="attribute_id" id="selected-attribute-id" value="">
                            <input type="hidden" name="price" id="hidden-price" value="{{ $ProductDetail->rate }}">
                            <input type="hidden" name="attribute_text" id="selected-attribute-text" value="">



                            <div class="d-flex align-items-center mb-4 pt-2">
                                <div class="input-group quantity mr-3" style="width: 130px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus" type="button">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                    <input type="text" name="quantity" id="product-qty"
                                        class="form-control bg-secondary border-0 text-center" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                </div> &nbsp; &nbsp;
                                 <button type="submit" class="btn btn-primary px-3 ">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                Add To Cart
                            </button>
                            </div>
                            {!! $ProductDetail->description !!}

                           
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shop Detail End -->


    @if ($RelatedProduct->count())
        <!-- Products Start -->
        <section class="section-padding">
            <div class="container-fluid ">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-primary pr-3">You
                        May Also Like</span></h2>
                <div class="row px-xl-5">
                    <div class="col">
                        <div class="owl-carousel related-carousel">

                            @foreach ($RelatedProduct as $related)
                                <div class="product-item bg-light">
                                    <div class="product-img position-relative overflow-hidden">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="{{ route('product_detail', [$Category->slugname, $related->slugname]) }}"><img
                                                class="img-fluid w-100"
                                                src="{{ asset('uploads/product/thumbnail/') . '/' . $related->photo }}"
                                                alt=""></a>
                                        <!--<div class="product-action">-->
                                        <!--    <form action="{{ route('cart.store') }}" method="POST"-->
                                        <!--        enctype="multipart/form-data">-->
                                        <!--        @csrf-->

                                        <!--        <input type="hidden" value="{{ $related->id ?? 0 }}" name="productid">-->
                                        <!--        <input type="hidden" value="{{ $related->categoryId }}" name="categoryId">-->
                                        <!--        <input type="hidden" value="{{ $related->productname }}"-->
                                        <!--            name="productname">-->
                                        <!--        <input type="hidden" value="{{ $related->photo }}" name="image">-->
                                        <!--        <input type="hidden" name="price" value="{{ $related->rate }}">-->
                                        <!--        <input type="hidden" name="quantity" value="1">-->

                                        <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                        <!--            <i class="fa fa-shopping-cart"></i>-->
                                        <!--        </button>-->
                                        <!--    </form>-->
                                        <!--    <form action="{{ route('wishlist.store') }}" method="POST">-->
                                        <!--        @csrf-->
                                        <!--        <input type="hidden" value="{{ $related->id ?? 0 }}" name="productid">-->
                                        <!--        <input type="hidden" name="price" value="{{ $related->rate }}">-->
                                        <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                        <!--            <i class="far fa-heart"></i>-->
                                        <!--        </button>-->
                                        <!--    </form>-->

                                        <!--</div>-->
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="{{ route('product_detail', [$Category->slugname, $related->slugname]) }}">
                                            {{ $related->productname }}
                                        </a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>₹{{ $related->rate }}</h5>
                                            <h6 class="text-muted ml-2"><del> &nbsp; ₹{{ $related->cut_price }}</del></h6>
                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Products End -->
    @endif

@endsection

@section('scripts')

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                navText: [
                    '<span class="custom-prev"> <i class="fa fa-arrow-left"></i> </span>',
                    '<span class="custom-next"><i class="fa fa-arrow-right"></i></span>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });
        $(".service-slider.owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            autoplay: true,
            navText: [
                '<span class="custom-prev"> <i class="fa fa-arrow-left"></i> </span>',
                '<span class="custom-next"><i class="fa fa-arrow-right"></i></span>'
            ],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 4
                }
            }
        });
    </script>

    <script>
        function updateMainImage(thumb) {
            const mainImage = document.getElementById('main-image');
            mainImage.src = thumb.src;

            // Update active thumbnail
            document.querySelectorAll('.thumb').forEach(el => el.classList.remove('active'));
            thumb.classList.add('active');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-plus').unbind().click(function() {
                let qtyInput = $(this).closest('.quantity').find('input[name="quantity"]');
                let currentVal = parseInt(qtyInput.val()) || 1;
                qtyInput.val(currentVal + 1);
            });

            $('.btn-minus').unbind().click(function() {
                let qtyInput = $(this).closest('.quantity').find('input[name="quantity"]');
                let currentVal = parseInt(qtyInput.val()) || 1;
                if (currentVal > 1) {
                    qtyInput.val(currentVal - 1);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Set initial price based on selected attribute
            let initialPrice = document.querySelector('#attribute-select option:checked');
            document.getElementById('product-price').innerText = initialPrice.getAttribute('data-price');
            document.getElementById('selected-attribute-id').value = initialPrice.value;
            document.getElementById('hidden-price').value = initialPrice.getAttribute('data-price'); // ✅ fixed
            document.getElementById('selected-attribute-text').value = initialPrice.getAttribute('data-text');
        });

        document.getElementById('attribute-select').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let newPrice = selectedOption.getAttribute('data-price');
            let selectedId = selectedOption.value;
            let attributeText = selectedOption.getAttribute('data-text');

            document.getElementById('product-price').innerText = newPrice;
            document.getElementById('hidden-price').value = newPrice;
            document.getElementById('selected-attribute-id').value = selectedId;
            document.getElementById('selected-attribute-text').value = attributeText;
        });
    </script>



@endsection
