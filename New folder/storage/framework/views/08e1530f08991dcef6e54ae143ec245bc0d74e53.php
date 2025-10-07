<?php $__env->startSection('title', '<?php echo e($datas->pagename); ?>'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="<?php echo e(route('FrontIndex')); ?>">Home</a>
                        <span class="breadcrumb-item active"><?php echo e($datas->pagename); ?></span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Start Contact -->
    <section class="blog-single section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $datas->description; ?>

                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/cms_pages.blade.php ENDPATH**/ ?>