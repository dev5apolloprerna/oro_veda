<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role_id == 1): ?>
                        <li class="menu-title"><span data-key="t-menu"></span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if(request()->routeIs('home')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                href="<?php echo e(route('home')); ?>">
                                <i class="mdi mdi-speedometer"></i>
                                <span data-key="t-dashboards">Dashboards</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="sidebarMore">
                                <i class="ri-database-2-line"></i> Master Entry </a>
                            <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                                <ul class="nav nav-sm flex-column">

                                    

                                    

                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('category.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('category.index')); ?>">
                                            <i class="fa-regular fa-rectangle-list"></i>
                                            <span data-key="t-dashboards">Category</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('product.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('product.index')); ?>">
                                            <i class="fa-solid fa-box-open"></i>
                                            <span data-key="t-dashboards">Product</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('offer.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('offer.index')); ?>">
                                            <i class="fa-solid fa-gift"></i>
                                            <span data-key="t-dashboards">Offer</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('courier.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('courier.index')); ?>">
                                            <i class="fa-solid fa-truck-ramp-box"></i>
                                            <span data-key="t-dashboards">Courier</span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('video.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('video.index')); ?>">
                                            <i class="fa-solid fa-truck-ramp-box"></i>
                                            <span data-key="t-dashboards">Video</span>
                                        </a>
                                    </li>

                                    <!--<li class="nav-item">-->
                                    <!--    <a class="nav-link menu-link <?php if(request()->routeIs('metaData.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"-->
                                    <!--        href="<?php echo e(route('metaData.index')); ?>">-->
                                    <!--        <i class="fa-solid fa-magnifying-glass"></i>-->
                                    <!--        <span data-key="t-dashboards">Seo</span>-->
                                    <!--    </a>-->
                                    <!--</li>-->

                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('order.pending')); ?>" data-bs-toggle="collapse"
                                role="button" aria-expanded="true" aria-controls="sidebarMore">
                                <i class="ri-briefcase-2-line"></i> Order </a>
                            <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('order.pending')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('order.pending')); ?>">
                                            <i class="fa-solid fa-clock"></i>
                                            <span data-key="t-dashboards">Order</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('order.pendingOrder')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('order.pendingOrder')); ?>">
                                            <i class="fa-solid fa-hourglass-half"></i>
                                            <span data-key="t-dashboards">Payment Pending</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if(request()->routeIs('Inquiry.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                href="<?php echo e(route('Inquiry.index')); ?>">
                                <i class="fa-solid fa-circle-question"></i>
                                <span data-key="t-dashboards">Inquiry</span>
                            </a>
                        </li>

                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link menu-link <?php if(request()->routeIs('metaData.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"-->
                        <!--        href="<?php echo e(route('metaData.index')); ?>">-->
                        <!--        <i class="fa-solid fa-magnifying-glass"></i>-->
                        <!--        <span data-key="t-dashboards">Seo</span>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="sidebarMore">
                                <i class="ri-briefcase-2-line"></i> Setting </a>
                            <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                                <ul class="nav nav-sm flex-column">
                                    

                                    <li class="nav-item">
                                        <a class="nav-link menu-link <?php if(request()->routeIs('otherpages.index')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                            href="<?php echo e(route('otherpages.index')); ?>">
                                            <i class="fa-solid fa-star"></i>
                                            <span data-key="t-dashboards">Other Pages </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        

                        
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if(request()->routeIs('order.userpending')): ?> <?php echo e('active'); ?> <?php endif; ?>"
                                href="<?php echo e(route('order.userpending')); ?>">
                                <i class="ri-briefcase-2-line"></i>
                                <span data-key="t-dashboards">Order</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\wamp64\www\oro_veda\resources\views/common/admin/sidebar.blade.php ENDPATH**/ ?>