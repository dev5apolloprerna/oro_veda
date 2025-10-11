@php
    $session = Session::get('customerid');
    $count = \Cart::getContent()->count();
    $cartItems = \Cart::getContent();

    $wishlist_count = App\Models\Wishlist::where([
        'iStatus' => 1,
        'isDelete' => 0,
        'customerid' => $session,
    ])->count();
@endphp





<!-- Header with Top Bar and Navigation -->
<header class="header-2025" id="mainHeader">
    <!-- Top Bar Section -->
    <section class="top-bar-section">
        <div class="top-bar">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="contact-info">
                    <a href="tel:+919876543210">
                        <i class="bi bi-telephone-fill"></i> +91 98765 43210
                    </a>
                    <span class="mx-3">|</span>
                    <a href="mailto:info@oroveda.com">
                        <i class="bi bi-envelope-fill"></i> info@oroveda.com
                    </a>
                </div>
                <!-- ===== NEW CURRENCY SWITCHER ===== -->
                <!-- <div class="currency-switcher dropdown">
            <div class="currency-trigger" role="button" id="currencyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-currency-exchange"></i>
                <span class="currency-code">USD</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
                <li><a class="dropdown-item active" href="#" data-currency="USD" data-symbol="$">USD ($)</a></li>
                <li><a class="dropdown-item" href="#" data-currency="EUR" data-symbol="€">EUR (€)</a></li>
                <li><a class="dropdown-item" href="#" data-currency="GBP" data-symbol="£">GBP (£)</a></li>
                <li><a class="dropdown-item" href="#" data-currency="INR" data-symbol="₹">INR (₹)</a></li>
            </ul>
        </div> -->
                <div class="social-links">
                    <a href="#" class="social-icon facebook" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-icon instagram" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon twitter" aria-label="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="social-icon youtube" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <nav class="navbar-2025" id="navbar">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="{{ route('front.index') }}" class="logo-container">
                <img src="https://z-cdn-media.chatglm.cn/files/ebf4f35e-4670-409e-9919-fce52af2755c_VArli%20art%20logo%20%282%29.png?auth_key=1791268795-d8f64ca02b6d4db397c7da0deff53a2d-0-ab1c221906f5e997a247bf82da051826"
                    alt="Oroveda Logo" class="logo-image">
            </a>

            <!-- Navigation Links -->
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item"><a href="{{ route('front.index') }}" class="nav-link">Home</a></li>

                @php
                    $categories = \App\Models\Category::orderBy('strSequence', 'asc')->where('iStatus', 1)->get();
                    $currentCategorySlug = request()->route('categoryid') ?? request()->route('category_id');

                @endphp

                <li class="nav-item">
                    <a href="products.html" class="nav-link">
                        Products <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu-2025">

                        @foreach ($categories as $category)
                            <a href="{{ route('front.product_list', $category->slugname) }}" class="dropdown-item-2025">
                                <div class="dropdown-icon">
                                    <i class="bi bi-flower1"></i>
                                </div>
                                <div class="dropdown-content">
                                    <div class="dropdown-title">{{ $category->categoryname }}</div>
                                </div>
                                {{--  <span class="dropdown-badge">Bestseller</span>  --}}
                            </a>
                        @endforeach

                    </div>
                </li>
                <li class="nav-item"><a href="{{ route('front.about') }}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
                <li class="nav-item"><a href="{{ route('front.contact_us') }}" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="products.html" class="nav-cta">Shop Now</a></li>

                <!-- 🛒 Cart Menu -->
                <li class="nav-item cart-menu">
                    <a href="{{ route('cart.list') }}" class="nav-link cart-icon">
                        <i class="bi bi-cart3"></i>
                        <span class="cart-count" id="cartCount">{{ $count }}</span>
                    </a>
                    <div class="cart-dropdown" id="cartDropdown">
                        <div class="cart-item">
                            <img src="assets/images/product/1ltr.png" alt="Ghee" class="cart-item-img">
                            <div class="cart-item-details">
                                <div class="cart-item-name">A2 Desi Cow Ghee</div>
                                <div class="cart-item-price">₹999</div>
                            </div>
                        </div>
                        <div class="cart-item">
                            <img src="assets/images/product/garlic.png" alt="Flavored Ghee" class="cart-item-img">
                            <div class="cart-item-details">
                                <div class="cart-item-name">Garlic Ghee</div>
                                <div class="cart-item-price">₹499</div>
                            </div>
                        </div>
                        <div class="cart-footer d-flex justify-content-between">
                            <a href="cart.html" class="view-cart-btn">View Cart</a>
                            <div class="cart-total">Total: ₹1,498</div>

                        </div>
                    </div>
                </li>
            </ul>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileToggle">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>


    <!-- Mobile Menu Overlay -->
    <!-- <div class="menu-overlay" id="menuOverlay"></div> -->
</header>

<!-- Header Placeholder (appears when header is fixed) -->
<div class="header-placeholder" id="headerPlaceholder"></div>
