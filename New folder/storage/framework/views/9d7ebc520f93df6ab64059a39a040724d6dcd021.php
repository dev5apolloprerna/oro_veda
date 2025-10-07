<?php
    $session = Session::get('customerid');
    $count = \Cart::getContent()->count();
    $cartItems = \Cart::getContent();
    
    $wishlist_count = App\Models\Wishlist::where([
        'iStatus' => 1,
        'isDelete' => 0,
        'customerid' => $session,
    ])->count();
?>

                                
<header>

    <!-- Topbar Start -->
    <div class="container-fluid topbar ">
        <div class="container">
            <div class="row py-1 px-xl-5">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="d-inline-flex align-items-center h-100">
                        <!--<p>30% OFF ON ALL PRODUCTS ENTER CODE: beshop2020</p>-->
                    </div>
                </div>
                
                <div class="col-lg-6 right">
                    <!-- My Account Dropdown -->
                    <div class="d-inline-flex align-items-center">
                        <div class="btn-group">
                            <a class="text-white me-2" href="<?php echo e(route('switch.currency','USD')); ?>">Show USD</a> | 
                            <a class="text-white  me-2" href="<?php echo e(route('switch.currency','INR')); ?>"> Show INR</a>


                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-user mr-1"></i> My Account
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if(isset($session)): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('myorders')); ?>">
                                        <i class="ti-lock mr-1"></i> My Account
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('Frontlogout')); ?>">
                                        <i class="ti-lock mr-1"></i> Logout
                                    </a>
                                <?php else: ?>
                                    <a class="dropdown-item" href="<?php echo e(route('FrontLogin')); ?>">
                                        <i class="ti-lock mr-1"></i> Sign in</button>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <!-- Icons for Wishlist and Cart (Mobile Only) -->
                    <div class="d-inline-flex align-items-center d-block d-lg-none ml-3">
                        <a href="<?php echo e(route('mywishlist.index')); ?>" class="btn px-1  ml-2 position-relative mt-2 pb-0">
                            <i class="ti-heart text-white"></i>
                            <span
                                class="badge  border border-white rounded-circle position-absolute top-0 start-100 translate-middle"
                                style="padding: 3px 6px; font-size: 10px;"><?php echo e($wishlist_count); ?></span>
                        </a>
                        <a href="<?php echo e(route('cart.list')); ?>" class="btn px-1  ml-2 position-relative  mt-2 pb-0">
                            <i class="ti-shopping-cart text-white"></i>
                            <span
                                class="badge  border border-white rounded-circle position-absolute top-0 start-100 translate-middle"
                                style="padding: 3px 6px; font-size: 10px;"><?php echo e($count); ?></span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid  ">
        <div class="container">
            <div class="row align-items-center bg-light  d-none d-lg-flex">
                <div class="col-lg-4">
                    <a href="<?php echo e(route('FrontIndex')); ?>" class="text-decoration-none logo">
                        <img src="<?php echo e(asset('assets/front/img/logo.png')); ?>" alt="">
                    </a>
                </div>
                <div class="col-lg-5 col-6 text-left">
                    <form action="<?php echo e(route('HeaderSearch')); ?>" method="GET" role="search">
                        <?php echo csrf_field(); ?>

                        <div class="input-group">
                            <input type="text" name="headersearch" class="form-control"
                                placeholder="Search for products" aria-label="Search for products" autocomplete="off"
                                required value="<?php echo e(request('headersearch')); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" title="Search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 col-6 text-right">
                    <h5 class="m-0 text-pink">
                        <i class="ti-headphone-alt mr-1 text-pink"></i> Customer Service
                    </h5>
                    <h5 class="m-0"><i class="ti-mobile mr-1 text-dark"></i> 81560 88203</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid  mb-30 nav">
        <div class="container">
            <div class="row ">

                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg py-3 py-lg-0 px-0 w-100">
                        <a href="" class="text-decoration-none d-block d-lg-none">

                            <img src="<?php echo e(asset('assets/front/img/logo.png')); ?>" alt="">

                        </a>
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="<?php echo e(route('FrontIndex')); ?>"
                                    class="nav-item nav-link <?php if(request()->routeIs('FrontIndex')): ?> <?php echo e('active'); ?> <?php endif; ?>">Home</a>
                                <a href="<?php echo e(route('frontabout')); ?>"
                                    class="nav-item nav-link <?php if(request()->routeIs('frontabout')): ?> <?php echo e('active'); ?> <?php endif; ?>">About
                                    us</a>

                                <?php
                                    $categories = \App\Models\Category::orderBy('strSequence', 'asc')
                                        ->where('iStatus', 1)
                                        ->get();
                                    $currentCategorySlug =
                                        request()->route('categoryid') ?? request()->route('category_id');

                                ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('product_list', $category->slugname)); ?>"
                                        class="nav-item nav-link
                                        <?php echo e((request()->routeIs('product_list') && $currentCategorySlug == $category->slugname) ||
                                        (request()->routeIs('product_detail') && $currentCategorySlug == $category->slugname)
                                            ? 'active'
                                            : ''); ?>"><?php echo e($category->categoryname); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <a href="<?php echo e(route('FrontContactUs')); ?>"
                                    class="nav-item nav-link <?php if(request()->routeIs('FrontContactUs')): ?> <?php echo e('active'); ?> <?php endif; ?>">Contact
                                    us</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                                
                                <a href="<?php echo e(route('mywishlist.index')); ?>" class="btn px-0">
                                    <i class="fas fa-heart text-white"></i>
                                    <span class="badge text-white border border-white rounded-circle"
                                        style="padding-bottom: 2px;"><?php echo e($wishlist_count); ?></span>
                                </a>
                                <a href="<?php echo e(route('cart.list')); ?>" class="btn px-0 ml-3">
                                    <i class="fas fa-shopping-cart text-white"></i>
                                    <span class="badge text-white border border-white rounded-circle"
                                        style="padding-bottom: 2px;"><?php echo e($count); ?></span>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
</header>
<?php /**PATH C:\wamp64\www\oro_veda\resources\views/common/front/frontheader.blade.php ENDPATH**/ ?>