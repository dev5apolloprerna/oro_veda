<?php $__env->startSection('title', 'Product Listing'); ?>

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
                        <a class="breadcrumb-item text-dark" href="<?php echo e(route('FrontIndex')); ?>">Home</a>
                        
                        <span class="breadcrumb-item active"><?php echo e($Category->categoryname); ?></span>
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

                        <?php if($products->count()): ?>
                            <?php
                                $currentSort = request('sort', 'latest');
                                $currentLimit = request('limit', 10);
                            ?>
                            

                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <a class=""
                                                href="<?php echo e(route('product_detail', [$Category->slugname, $product->slugname])); ?>">
                                                <img class="img-fluid w-100"
                                                    src="<?php echo e(asset('uploads/product/thumbnail/') . '/' . $product->photo); ?>"
                                                    alt="<?php echo e($product->productname); ?>"></a>

                                            <!--<div class="product-action">-->

                                            <!--    <form action="<?php echo e(route('cart.store')); ?>" method="POST"-->
                                            <!--        enctype="multipart/form-data">-->
                                            <!--        <?php echo csrf_field(); ?>-->
                                            <!--        <input type="hidden" value="<?php echo e($product->id ?? 0); ?>" name="productid">-->
                                            <!--        <input type="hidden" value="<?php echo e($product->categoryId); ?>"-->
                                            <!--            name="categoryId">-->
                                            <!--        <input type="hidden" value="<?php echo e($product->productname); ?>"-->
                                            <!--            name="productname">-->
                                            <!--        <input type="hidden" value="<?php echo e($product->photo); ?>" name="image">-->
                                            <!--        <input type="hidden" name="price" value="<?php echo e($product->rate); ?>">-->
                                            <!--        <input type="hidden" name="quantity" value="1">-->

                                            <!-- Add to Cart Button -->
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
                                                href="<?php echo e(route('product_detail', [$Category->slugname, $product->slugname])); ?>">
                                                <?php echo e($product->productname); ?>

                                            </a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>₹<?php echo e($product->rate); ?></h5> &nbsp;
                                                <h6 class="text-muted ml-2"><del>₹<?php echo e($product->cut_price); ?></del></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                <?php echo e($products->appends(request()->query())->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="col-lg-12 text-center py-5">
                                
                                <img src="<?php echo e(asset('assets/front/img/no-product.gif')); ?>" alt="No Products"
                                    style="max-width: 300px; margin-top: 20px;"> <br>
                                
                                <a href="<?php echo e(route('FrontIndex')); ?>" class="btn btn-primary mt-3">Back to Home</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Shop Product End -->
            </div>
        </div>
    </section>
    <!-- Shop End -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/products.blade.php ENDPATH**/ ?>