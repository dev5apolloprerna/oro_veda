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
                            <a class="text-white me-2" href="{{ route('switch.currency','USD') }}">Show USD</a> | 
                            <a class="text-white  me-2" href="{{ route('switch.currency','INR') }}"> Show INR</a>


                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-user mr-1"></i> My Account
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                @if (isset($session))
                                    <a class="dropdown-item" href="{{ route('myorders') }}">
                                        <i class="ti-lock mr-1"></i> My Account
                                    </a>
                                    <a class="dropdown-item" href="{{ route('Frontlogout') }}">
                                        <i class="ti-lock mr-1"></i> Logout
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('FrontLogin') }}">
                                        <i class="ti-lock mr-1"></i> Sign in</button>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Icons for Wishlist and Cart (Mobile Only) -->
                    <div class="d-inline-flex align-items-center d-block d-lg-none ml-3">
                        <a href="{{ route('mywishlist.index') }}" class="btn px-1  ml-2 position-relative mt-2 pb-0">
                            <i class="ti-heart text-white"></i>
                            <span
                                class="badge  border border-white rounded-circle position-absolute top-0 start-100 translate-middle"
                                style="padding: 3px 6px; font-size: 10px;">{{ $wishlist_count }}</span>
                        </a>
                        <a href="{{ route('cart.list') }}" class="btn px-1  ml-2 position-relative  mt-2 pb-0">
                            <i class="ti-shopping-cart text-white"></i>
                            <span
                                class="badge  border border-white rounded-circle position-absolute top-0 start-100 translate-middle"
                                style="padding: 3px 6px; font-size: 10px;">{{ $count }}</span>
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
                    <a href="{{ route('FrontIndex') }}" class="text-decoration-none logo">
                        <img src="{{ asset('assets/front/img/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-5 col-6 text-left">
                    <form action="{{ route('HeaderSearch') }}" method="GET" role="search">
                        @csrf

                        <div class="input-group">
                            <input type="text" name="headersearch" class="form-control"
                                placeholder="Search for products" aria-label="Search for products" autocomplete="off"
                                required value="{{ request('headersearch') }}">
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

                            <img src="{{ asset('assets/front/img/logo.png') }}" alt="">

                        </a>
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="{{ route('FrontIndex') }}"
                                    class="nav-item nav-link @if (request()->routeIs('FrontIndex')) {{ 'active' }} @endif">Home</a>
                                <a href="{{ route('frontabout') }}"
                                    class="nav-item nav-link @if (request()->routeIs('frontabout')) {{ 'active' }} @endif">About
                                    us</a>

                                @php
                                    $categories = \App\Models\Category::orderBy('strSequence', 'asc')
                                        ->where('iStatus', 1)
                                        ->get();
                                    $currentCategorySlug =
                                        request()->route('categoryid') ?? request()->route('category_id');

                                @endphp
                                @foreach ($categories as $category)
                                    <a href="{{ route('product_list', $category->slugname) }}"
                                        class="nav-item nav-link
                                        {{ (request()->routeIs('product_list') && $currentCategorySlug == $category->slugname) ||
                                        (request()->routeIs('product_detail') && $currentCategorySlug == $category->slugname)
                                            ? 'active'
                                            : '' }}">{{ $category->categoryname }}</a>
                                @endforeach

                                <a href="{{ route('FrontContactUs') }}"
                                    class="nav-item nav-link @if (request()->routeIs('FrontContactUs')) {{ 'active' }} @endif">Contact
                                    us</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                                
                                <a href="{{ route('mywishlist.index') }}" class="btn px-0">
                                    <i class="fas fa-heart text-white"></i>
                                    <span class="badge text-white border border-white rounded-circle"
                                        style="padding-bottom: 2px;">{{ $wishlist_count }}</span>
                                </a>
                                <a href="{{ route('cart.list') }}" class="btn px-0 ml-3">
                                    <i class="fas fa-shopping-cart text-white"></i>
                                    <span class="badge text-white border border-white rounded-circle"
                                        style="padding-bottom: 2px;">{{ $count }}</span>
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