<?php $__env->startSection('title', 'About Us'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">

                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="<?php echo e(route('FrontIndex')); ?>">Home</a>
                        <span class="breadcrumb-item active">About us</span>
                    </nav>
                </div>

            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Contact Start -->
    <section class="section-padding about">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5 "><span class="bg-primary pr-3">Welcome to
                    Sparsh Cosmo Group</span></h5>
            <div class="row px-xl-5 justify-content-center d-flex">
                <div class="col-lg-5 mb-5">

                    <img src="<?php echo e(asset('assets/front/img/about.jpg')); ?>" alt="" class="img-fluid">


                </div>
                <div class="col-lg-7 ">
                    <h2 class="text-pink">About Us</h2>
                    <p>
                        <strong>Sparsh Cosmo Group</strong> is a trusted name in natural and cosmetic wellness, dedicated to
                        bringing you the purity of nature with a modern touch. Founded with a passion for quality and a
                        commitment
                        to sustainability, we specialize in the production and distribution of premium <strong>Neem
                            Oil</strong> and
                        <strong>Perfume</strong> — each crafted to
                        nourish,
                        protect, and enhance your natural beauty.
                    </p>
                    <br>
                    <p>
                        At Sparsh, which means “touch” in Sanskrit, we believe that every product should not only feel good
                        on the
                        skin but also be kind to the environment. Our ingredients are carefully selected for their purity
                        and
                        effectiveness, blending traditional wisdom with contemporary science to deliver results you can
                        trust.
                    </p>
                    <br>
                    <p>
                        Whether it's the healing power of cold-pressed neem oil, the long-lasting charm of our perfumes, the
                        gentle
                        richness of handmade kajal, or the soothing touch of our herbal soaps — Sparsh Cosmo Group ensures
                        that
                        every product reflects our promise of quality, authenticity, and care.
                    </p>
                    <br>
                    <p>
                        Join us in embracing a more natural way to care for yourself — because beauty begins with a pure
                        touch.
                    </p>
                    <br>
                    <p>
                        The proprietor is PARAS HANSAJI PRAJAPATI
                    </p>
                    <P>
                        GSTIN : 24AHXPP7329P3Z6
                    </P>
                    <P>
                        They have registered the trademark for the SPARSH brand
                    </P>
                </div>

            </div>
        </div>
    </section>
    <!-- Contact End -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/about.blade.php ENDPATH**/ ?>