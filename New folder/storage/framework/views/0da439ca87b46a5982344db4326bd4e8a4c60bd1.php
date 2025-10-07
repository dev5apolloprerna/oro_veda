<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

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
                                            
                                        </div>

                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->



                            <div class="row">

                                <?php if(Auth::user()->role_id == 1): ?>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #7c1a3e;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Category</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                            <span class="counter-value"
                                                                data-target="<?php echo e($Category); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('category.index')); ?>"
                                                            class="text-decoration-underline text-white-50">View
                                                            Category</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Product</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($Product); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('product.index')); ?>"
                                                            class="text-decoration-underline text-white-50">View
                                                            Product</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Offer</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($Offer); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('offer.index')); ?>"
                                                            class="text-decoration-underline text-white-50">View
                                                            Offer</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Courier</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($Courier); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('courier.index')); ?>"
                                                            class="text-decoration-underline text-white-50">
                                                            View Courier</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Inquiry</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($Inquiry); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('Inquiry.index')); ?>"570f29
                                                            class="text-decoration-underline text-white-50">
                                                            View Inquiry</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Today's Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($TodaysOrder); ?>">0</span>
                                                        </h4>
                                                        <!--<a href="<?php echo e(route('Inquiry.index')); ?>"-->
                                                        <!--    class="text-decoration-underline text-white-50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Pending Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($PendingOrder); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('order.pending')); ?>"
                                                            class="text-decoration-underline text-white-50">
                                                            View Pending Order</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fa-solid fa-clock-rotate-left"></i>
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Dispatched Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($DispatchedOrder); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('order.dispatched')); ?>"
                                                            class="text-decoration-underline text-white-50">
                                                            View Dispatched Order</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
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
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Today's Collection</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($TodaysCollection); ?>">0</span>
                                                        </h4>
                                                        <!--<a href="<?php echo e(route('Inquiry.index')); ?>"-->
                                                        <!--    class="text-decoration-underline text-white-50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #570f29;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white text-truncate mb-0">
                                                            Pending Order Delivery</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="<?php echo e($PendingOrderDelivery); ?>">0</span>
                                                        </h4>
                                                        <a href="<?php echo e(route('order.userpending')); ?>"
                                                            class="text-decoration-underline text-white-50">
                                                            View Pending Order Delivery</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

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
                        </script> © <?php echo e(env('APP_NAME')); ?>

                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/home.blade.php ENDPATH**/ ?>