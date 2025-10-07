<?php $__env->startSection('title', 'Product Detail'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('common.frontmodalalert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                            href="<?php echo e(route('product_list', $Category->slugname)); ?>"><?php echo e($Category->categoryname); ?></a>
                        <span class="breadcrumb-item active"><?php echo e($ProductDetail->productname); ?></span>
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
                                src="<?php echo e(asset('uploads/product/thumbnail') . '/' . $ProductDetail->photo); ?>" alt="Product"
                                class="main-image" />
                        </div>
                        <div class="thumbnails">
                            <?php $__currentLoopData = $Photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(asset('uploads/product/thumbnail') . '/' . $photos->strphoto); ?>"
                                    alt="Thumbnail 1" class="thumb active" onclick="updateMainImage(this)">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 h-auto py-5">
                    <div class="h-100 bg-light p-30">
                        <h3 class="text-secondary"><?php echo e($ProductDetail->productname); ?></h3>
                        <form action="<?php echo e(route('cart.store')); ?>" method="POST" enctype="multipart/form-data">
                            <div class="d-flex">
                                

                                <h3 class="font-weight-semi-bold mb-4 text-pink">
                                    ₹ <span id="product-price">
                                        <?php echo e($ProductDetail->rate); ?>

                                    </span>
                                </h3>
                                
                                <?php
                                  $displayPrice   = $ProductDetail->min_attr_price ?: $ProductDetail->rate;
                                  $selectedAttrId = $ProductDetail->min_attr_id ?? null;
                                ?>

                                <select id="attribute-select" class="form-control dropdown">
                                    <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($attribute->id); ?>"
                                            data-price="<?php echo e((float)$attribute->product_attribute_price); ?>"
                                            data-text="<?php echo e($attribute->product_attribute_qty . ' ' . $attribute->attribute_name); ?>"
                                            <?php echo e((int)$attribute->id === (int)$selectedAttrId ? 'selected' : ''); ?>>
                                            <?php echo e($attribute->product_attribute_qty . ' ' . $attribute->attribute_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="productid" value="<?php echo e($ProductDetail->id); ?>">
                            <input type="hidden" name="categoryId" value="<?php echo e($ProductDetail->categoryId); ?>">
                            <input type="hidden" name="productname" value="<?php echo e($ProductDetail->productname); ?>">
                            <input type="hidden" name="image" value="<?php echo e($ProductDetail->photo); ?>">
                            <input type="hidden" name="attribute_id" id="selected-attribute-id" value="">
                            <input type="hidden" name="price" id="hidden-price" value="<?php echo e($ProductDetail->rate); ?>">
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
                            <?php echo $ProductDetail->description; ?>


                           
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shop Detail End -->


    <?php if($RelatedProduct->count()): ?>
        <!-- Products Start -->
        <section class="section-padding">
            <div class="container-fluid ">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-primary pr-3">You
                        May Also Like</span></h2>
                <div class="row px-xl-5">
                    <div class="col">
                        <div class="owl-carousel related-carousel">

                            <?php $__currentLoopData = $RelatedProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="product-item bg-light">
                                    <div class="product-img position-relative overflow-hidden">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="<?php echo e(route('product_detail', [$Category->slugname, $related->slugname])); ?>"><img
                                                class="img-fluid w-100"
                                                src="<?php echo e(asset('uploads/product/thumbnail/') . '/' . $related->photo); ?>"
                                                alt=""></a>
                                        <!--<div class="product-action">-->
                                        <!--    <form action="<?php echo e(route('cart.store')); ?>" method="POST"-->
                                        <!--        enctype="multipart/form-data">-->
                                        <!--        <?php echo csrf_field(); ?>-->

                                        <!--        <input type="hidden" value="<?php echo e($related->id ?? 0); ?>" name="productid">-->
                                        <!--        <input type="hidden" value="<?php echo e($related->categoryId); ?>" name="categoryId">-->
                                        <!--        <input type="hidden" value="<?php echo e($related->productname); ?>"-->
                                        <!--            name="productname">-->
                                        <!--        <input type="hidden" value="<?php echo e($related->photo); ?>" name="image">-->
                                        <!--        <input type="hidden" name="price" value="<?php echo e($related->rate); ?>">-->
                                        <!--        <input type="hidden" name="quantity" value="1">-->

                                        <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                        <!--            <i class="fa fa-shopping-cart"></i>-->
                                        <!--        </button>-->
                                        <!--    </form>-->
                                        <!--    <form action="<?php echo e(route('wishlist.store')); ?>" method="POST">-->
                                        <!--        <?php echo csrf_field(); ?>-->
                                        <!--        <input type="hidden" value="<?php echo e($related->id ?? 0); ?>" name="productid">-->
                                        <!--        <input type="hidden" name="price" value="<?php echo e($related->rate); ?>">-->
                                        <!--        <button type="submit" class="btn btn-outline-dark btn-square">-->
                                        <!--            <i class="far fa-heart"></i>-->
                                        <!--        </button>-->
                                        <!--    </form>-->

                                        <!--</div>-->
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="<?php echo e(route('product_detail', [$Category->slugname, $related->slugname])); ?>">
                                            <?php echo e($related->productname); ?>

                                        </a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>₹<?php echo e($related->rate); ?></h5>
                                            <h6 class="text-muted ml-2"><del> &nbsp; ₹<?php echo e($related->cut_price); ?></del></h6>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Products End -->
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

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



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/productdetail.blade.php ENDPATH**/ ?>