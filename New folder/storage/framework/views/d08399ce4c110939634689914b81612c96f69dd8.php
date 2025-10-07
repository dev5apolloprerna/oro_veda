<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('common.frontmodalalert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Carousel Start -->
    <section class="hero">
        <div class="container-fluid mb-3 py-3">

            <div class="owl-carousel owl-theme">
                <div class="item"><img src="<?php echo e(asset('assets/front/img/slide-3.jpg')); ?>" alt="3">
                    <div class="carousel-caption">
                        <h2>Crafted for Those Who Value More.</h2>
                        <h4 class="text-dark col-lg-8 mx-auto">For those who seek more than just function—refinement,
                            purpose, and enduring style.
                            Every detail reflects a higher standard, tailored to your expectations.</h4>
                    </div>
                </div>
                <div class="item"><img src="<?php echo e(asset('assets/front/img/slide-1.jpg')); ?>" alt="1">
                    <div class="carousel-caption">
                        <h2>True Quality Comes At Price</h2>
                        <h4 class="text-dark col-lg-8 mx-auto">Experience unmatched craftsmanship where excellence isn't
                            compromised.
                            Because when it comes to quality, we believe it's worth every penny.</h4>
                    </div>
                </div>
                <div class="item"><img src="<?php echo e(asset('assets/front/img/slide-2.jpg')); ?>" alt="2">
                    <div class="carousel-caption">
                        <h2>Quality Made Trust Delivered</h2>
                        <h4 class="text-dark col-lg-8 mx-auto">Our commitment to precision creates products you can rely
                            on.
                            Built with care, delivered with integrity—trust is our promise.</h4>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Carousel End -->

    <?php if($featuredProduct->count()): ?>
        <!-- Products Start -->
        <section class="featured-products">
            <div class="container-fluid pt-5 pb-3">
                <h5 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-primary px-3 text-white">
                        Featured Products</span>
                </h5>
                <div class="px-xl-5 product-carousel owl-carousel owl-theme  pb-1">

                    <?php $__currentLoopData = $featuredProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <div class="product-item bg-light mb-4">

                                <div class="product-img position-relative overflow-hidden">
                                    <a class=""
                                        href="<?php echo e(route('product_detail', [$products->category_slug, $products->slugname])); ?>"><img
                                            class="img-fluid w-100"
                                            src="<?php echo e(asset('uploads/product/thumbnail/') . '/' . $products->photo); ?>"
                                            alt=""></a>
                                    <!--<div class="product-action">-->
                                    <!--    <form action="<?php echo e(route('cart.store')); ?>" method="POST"-->
                                    <!--        enctype="multipart/form-data">-->
                                    <!--        <?php echo csrf_field(); ?>-->
                                    <!--        <input type="hidden" value="<?php echo e($products->id ?? 0); ?>" name="productid">-->
                                    <!--        <input type="hidden" value="<?php echo e($products->categoryId); ?>" name="categoryId">-->
                                    <!--        <input type="hidden" value="<?php echo e($products->productname); ?>" name="productname">-->
                                    <!--        <input type="hidden" value="<?php echo e($products->photo); ?>" name="image">-->
                                    <!--        <input type="hidden" name="price" value="<?php echo e($products->rate); ?>">-->
                                    <!--        <input type="hidden" name="quantity" value="1">-->
                                    <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                    <!--            <i class="fa fa-shopping-cart"></i>-->
                                    <!--        </button>-->
                                    <!--    </form>-->

                                    <!--    <form action="<?php echo e(route('wishlist.store')); ?>" method="POST">-->
                                    <!--        <?php echo csrf_field(); ?>-->
                                    <!--        <input type="hidden" value="<?php echo e($products->id ?? 0); ?>" name="productid">-->
                                    <!--        <input type="hidden" name="price" value="<?php echo e($products->rate); ?>">-->
                                    <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                    <!--            <i class="far fa-heart"></i>-->
                                    <!--        </button>-->
                                    <!--    </form>-->

                                    <!--</div>-->
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="<?php echo e(route('product_detail', [$products->category_slug, $products->slugname])); ?>"><?php echo e($products->productname); ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted ml-2 px-1">
                                            <h5> ₹<?php echo e($products->rate); ?></h5>
                                        </h6>
                                            <del>₹<?php echo e($products->cut_price); ?></del> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </section>
        <!-- Products End -->
    <?php endif; ?>

    <!-- Offer Start -->
    <section class="offer">
        <div class="container-fluid pt-5 pb-3">
            <div class="row px-xl-5">
                
                <?php
                    $category = \App\Models\Category::orderBy('strSequence', 'asc')
                        ->where('iStatus', 1)
                        ->where('id', 18)
                        ->first();
                ?>

                <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <img class="img-fluid" src="<?php echo e(asset('uploads/offer') . '/' . $offer->photo); ?>" alt="">
                            <div class="offer-text">
                                <p class="text-white">
                                    (Get <?php echo e($offer->percentage); ?> % OFF)
                                    On Minimum Purchase of Rs. <?php echo e($offer->minvalue); ?>

                                </p>
                                <p class="text-white">Use the Offer Code:-
                                    <strong><?php echo e($offer->offercode); ?></strong>
                                </p>
                                <p class="text-white mb-3"> Offer Valid Till
                                    <?php echo e(date('d-m-Y', strtotime($offer->enddate))); ?></p>
                                
                                
                                <a href="<?php echo e(route('product_list', $category->slugname)); ?>" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(!empty($Video->url)): ?>
                        <?php
                            function getYoutubeEmbedUrl($url) {
                                if (strpos($url, 'shorts/') !== false) {
                                    preg_match('/shorts\/([^?]+)/', $url, $matches);
                                    return 'https://www.youtube.com/embed/' . ($matches[1] ?? '');
                                } elseif (strpos($url, 'watch?v=') !== false) {
                                    parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                    return 'https://www.youtube.com/embed/' . ($query['v'] ?? '');
                                } elseif (strpos($url, 'embed/') !== false) {
                                    return $url; // already embed format
                                }
                                return null;
                            }
                    
                            $embedUrl = getYoutubeEmbedUrl($Video->url);
                        ?>
                        
                        <?php if($embedUrl): ?>
                            <div class="col-md-6">
                                <div class="product-offer mb-30" style="height: 300px;">
                                    <iframe width="100%" height="100%" 
                                        src="<?php echo e($embedUrl); ?>" 
                                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

            </div>
        </div>
    </section>
    <!-- Offer End -->

    <?php if($recentproducts->count()): ?>
        <!-- Products Start -->
        <section class="recent-products">
            <div class="container-fluid pt-5 pb-3">
                <h5 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-primary px-3 text-white">
                        Recent Products
                    </span>
                </h5>
                <div class="row px-xl-5">

                    <?php $__currentLoopData = $recentproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">

                                    <?php if($product->photo): ?>
                                        <a class=""
                                            href="<?php echo e(route('product_detail', [$product->category_slug, $product->slugname])); ?>">
                                            <img class="img-fluid w-100"
                                                src="<?php echo e(asset('/uploads/product/thumbnail/') . '/' . $product->photo); ?>"
                                                alt=""></a>
                                    <?php else: ?>
                                        <a class=""
                                            href="<?php echo e(route('product_detail', [$product->category_slug, $product->slugname])); ?>">
                                            <img class="img-fluid w-100" src="<?php echo e(asset('assets/images/noimage.png')); ?>"
                                                alt=""></a>
                                    <?php endif; ?>
                                    <!--<div class="product-action">-->
                                    <!--    <form action="<?php echo e(route('cart.store')); ?>" method="POST"-->
                                    <!--        enctype="multipart/form-data">-->
                                    <!--        <?php echo csrf_field(); ?>-->
                                    <!--        <input type="hidden" value="<?php echo e($product->id ?? 0); ?>" name="productid">-->
                                    <!--        <input type="hidden" value="<?php echo e($product->categoryId); ?>" name="categoryId">-->
                                    <!--        <input type="hidden" value="<?php echo e($product->productname); ?>"-->
                                    <!--            name="productname">-->
                                    <!--        <input type="hidden" value="<?php echo e($product->photo); ?>" name="image">-->
                                    <!--        <input type="hidden" name="price" value="<?php echo e($product->rate); ?>">-->
                                    <!--        <input type="hidden" name="quantity" value="1">-->
                                    <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                    <!--            <i class="fa fa-shopping-cart"></i>-->
                                    <!--        </button>-->
                                    <!--    </form>-->


                                    <!--    <form action="<?php echo e(route('wishlist.store')); ?>" method="POST">-->
                                    <!--        <?php echo csrf_field(); ?>-->
                                    <!--        <input type="hidden" value="<?php echo e($product->id ?? 0); ?>" name="productid">-->
                                    <!--        <input type="hidden" name="price" value="<?php echo e($product->rate); ?>">-->
                                    <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                    <!--            <i class="far fa-heart"></i>-->
                                    <!--        </button>-->
                                    <!--    </form>-->

                                    <!--</div>-->
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="<?php echo e(route('product_detail', [$product->category_slug, $product->slugname])); ?>">
                                        <?php echo e($product->productname); ?>

                                    </a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted ml-2 px-1">
                                            <?php if($product->product_attribute_price): ?>
                                                <h5>₹<?php echo e($product->product_attribute_price); ?></h5>
                                            <?php else: ?>    
                                                <h5>₹<?php echo e($product->min_attr_price); ?></h5>
                                            <?php endif; ?>    
                                        </h6> &nbsp;
                                            <del>₹<?php echo e($product->cut_price); ?></del> 

                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </section>
        <!-- Products End -->
    <?php endif; ?>


    <!-- Featured Start -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme service-slider">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-truck"></i>
                        <h4>Free Domestic Shipping</h4>
                        <p> Shipping Worldwide</p>
                        <!--<p>Orders over &#x20B9;  100</p>-->
                    </div>
                    <!-- End Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% Secure Payment</p>
                    </div>

                    <div class="single-service noborder">
                        <i class="ti-tag"></i>
                        <h4>Best price</h4>
                        <p>Guaranteed Price</p>
                    </div>
                    <div class="single-service">
                        <i class=" ti-gift"></i>
                        <h4>HANDCRAFTED WITH LOVE</h4>

                        <!--<p>Within 30 days returns</p>-->
                    </div>
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <!--<h4>X</h4>-->
                        <i class="ti-na"></i>


                        <h4>No Return </h4>
                        <h4>No Refund </h4>

                        <!--<p>Within 30 days returns</p>-->
                    </div>
                    <!-- End Single Service -->

                    <!-- Start Single Service -->
                    <!-- End Single Service -->

                    <!-- Start Single Service -->
                    <!-- End Single Service -->

                </div>
            </div>
        </div>
    </section>
    <!-- Featured End -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
                        items: 1
                    },
                    1000: {
                        items: 1
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/index.blade.php ENDPATH**/ ?>