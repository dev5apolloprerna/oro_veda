<?php
    $session = Session::get('customerid');
?>

<!-- Footer Start -->
<section class="footer  mt-5">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="container footer-container">
                <div class="row">
                    <!-- About the Shop -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer about">
                            <h4 class="footer-title"> About The Shop</h4>
                            <p>
                                At Sparsh Cosmo Group, we believe beauty begins with purity. Rooted in the power of
                                nature, we craft organic cosmetics, handmade soaps, and pure natural oils designed
                                to nourish your skin, uplift your senses, and promote wellness—inside and out.
                            </p>
                        </div>
                    </div>

                    <?php
                        $pages = App\Models\OtherPages::get();
                    ?>
                    <!-- Footer Menu -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer links">
                            <h4 class="footer-title"> Footer Menu</h4>
                            <ul class="footer-links">
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <i class="ti-lock"></i>
                                        <a href="<?php echo e(route('cms_pages', $page->slugname)); ?>"><?php echo e($page->pagename); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer links">
                            <h4 class="footer-title"> Quick Links</h4>
                            <ul class="footer-links">
                                <li><i class="ti-home"></i> <a href="<?php echo e(route('FrontIndex')); ?>">Home</a></li>
                                <?php if(isset($session)): ?>
                                    <li><i class="ti-unlock"></i> <a href="<?php echo e(route('Frontlogout')); ?>">Logout</a></li>
                                <?php else: ?>    
                                    <li><i class="ti-unlock"></i> <a href="<?php echo e(route('FrontLogin')); ?>">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer contact">
                            <h4 class="footer-title"></i> Get In Touch</h4>
                            <ul class="footer-contact">
                                <li><strong><i class="ti-location-pin"></i> Sparsh cosmo Group</strong></li>
                                <li>4TH FLOOR, A - 419</li>
                                <li> ABHISHEK-2 COMMERCIAL COMPLEX,</li>
                                <li>HARIPURA GAM,ASARWA</li>
                                <li> Ahmedabad, Gujarat, 380013</li>
                                <li><i class="ti-email"></i> <a href="#">Contact@sparshcosmo-group.com</a></li>
                                <li><i class="ti-mobile"></i> <a href="#">+91 81560 88203</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row  mx-xl-5 py-4" style="border-top:1px solid var(--primary-color) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-secondary">
                    Copyright © <?php echo e(date('Y')); ?> All rights reserved
                </p>
            </div>

        </div>
    </div>
</section>
<!-- Footer End -->
<?php /**PATH C:\wamp64\www\oro_veda\resources\views/common/front/frontfooter.blade.php ENDPATH**/ ?>