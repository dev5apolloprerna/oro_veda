<?php $__env->startSection('title', 'Search Results'); ?>

<?php $__env->startSection('content'); ?>
    <section class="search-results py-5">
        <div class="container">
            <h4>Search Results for "<?php echo e($headerSearch); ?>" (<?php echo e($productCount); ?> results)</h4>

            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            
                                            <a class=""
                                                href="<?php echo e(route('product_detail', [$product->category_slug, $product->slugname])); ?>">
                                                <img class="img-fluid w-100"
                                                    src="<?php echo e(asset('uploads/product/thumbnail/') . '/' . $product->photo); ?>"
                                                    alt="<?php echo e($product->productname); ?>"></a>

                                            
                            </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="<?php echo e(route('product_detail', [$product->category_slug, $product->slugname])); ?>">
                                                <?php echo e($product->productname); ?>

                                            </a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>₹<?php echo e($product->rate); ?></h5> &nbsp;
                                                <h6 class="text-muted ml-2"><del>₹<?php echo e($product->cut_price); ?></del></h6>
                                            </div>
                                        </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <p>No products found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-center">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/Searchdata.blade.php ENDPATH**/ ?>