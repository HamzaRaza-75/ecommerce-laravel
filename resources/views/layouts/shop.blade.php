@php
    use Binafy\LaravelCart\Models\Cart;

    $regiesterCategory = \App\Models\Category::all();

    $cart = Cart::where('user_id', auth()->id())
        ->latest()
        ->first();

    $cartItemsCount = $cart && $cart->items ? $cart->items->count() : 0;
    $totalprice = $cart && method_exists($cart, 'calculatedPriceByQuantity') ? $cart->calculatedPriceByQuantity() : 0;
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <!--===============================================================================================-->

    @vite(['resources/js/app.js'])


    <link rel="stylesheet" type="text/css" href={{ asset('shop/font-awesome-4.7.0/css/font-awesome.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/fonts/iconic/css/material-design-iconic-font.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/fonts/linearicons-v1.0.0/icon-font.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/animate/animate.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/css-hamburgers/hamburgers.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/animsition/css/animsition.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/select2/select2.min.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/daterangepicker/daterangepicker.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/slick/slick.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/MagnificPopup/magnific-popup.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/vendor/perfect-scrollbar/perfect-scrollbar.css') }}>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href={{ asset('shop/css/util.css') }}>
    <link rel="stylesheet" type="text/css" href={{ asset('shop/css/main.css') }}>
    <!--===============================================================================================-->
    <style>
        /* Hide default radio */
        input[type="radio"] {
            appearance: none;
            opacity: 0;
            position: absolute;
        }

        /* Custom radio button */
        .custom-radio {
            position: relative;
            cursor: pointer;
            padding-left: 25px;
            /* Space for custom circle */
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        /* Custom circle */
        .custom-radio::before {
            content: '';
            position: absolute;
            left: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid #ff0404;
            background: transparent;
            transition: 0.3s;
        }

        /* When selected, change circle & text color */
        input[type="radio"]:checked+.custom-radio::before {
            background: #ff0404;
        }

        input[type="radio"]:checked+.custom-radio {
            color: #5c15ce;
            /* Change text color */
            font-weight: bold;
        }

        .custom-price-radio {
            position: relative;
            cursor: pointer;
            padding-left: 25px;
            /* Space for custom circle */
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        /* Custom circle */
        .custom-price-radio::before {
            content: '';
            position: absolute;
            left: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid #1e4eeb;
            background: transparent;
            transition: 0.3s;
        }

        /* When selected, change circle & text color */
        input[type="radio"]:checked+.custom-price-radio::before {
            background: #401eeb;
        }

        input[type="radio"]:checked+.custom-price-radio {
            color: #f00f0f;
            /* Change text color */
            font-weight: bold;
        }

        .custom-category-radio {
            position: relative;
            cursor: pointer;
            padding-left: 30px;
            /* Space for custom circle */
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        /* Custom circle */
        .custom-category-radio::before {
            content: '';
            position: absolute;
            left: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid transparent;
            background: var(--color);
            /* Dynamic color */
            transition: 0.3s;
        }

        /* When selected, change border & text color */
        input[type="radio"]:checked+.custom-category-radio::before {
            border-color: #000;
            /* Black border */
        }

        input[type="radio"]:checked+.custom-category-radio {
            font-weight: bold;
        }

        .not-found-message {
            color: #6c757d;
            font-size: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body class="animsition">
    @if (session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <small> <strong>Hi {{ auth()->user()->name }} ,</strong> {{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>{{ implode(' | ', $errors->all()) }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Register Your Store...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if (!(auth()->user()->hasrole('super-admin') || auth()->user()->hasrole('store-owner')))
                    <form id="store-register-modal" action="{{ route('store.register') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Store Name Input -->
                            <div class="form-group">
                                <label for="store-name" class="col-form-label">Store Name:</label>
                                <input type="text" class="form-control" id="store-name" name="name"
                                    placeholder="Enter your store name" required>
                            </div>
                            <!-- Category Dropdown -->
                            <div class="form-group">
                                <label for="category" class="col-form-label">Choose Category:</label>
                                <select class="form-control" id="category" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($regiesterCategory as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Store Registration Details Textbar -->
                            <div class="form-group">
                                <label for="store-description" class="col-form-label">Store Registration
                                    Details:</label>
                                <textarea class="form-control" id="store-description" name="description" placeholder="Enter registration details"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">Register Store</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <div class="top-bar">
                <div class="container h-full content-topbar flex-sb-m">
                    <div class="left-top-bar">
                        Free shipping for standard order over $100
                    </div>

                    <div class="h-full right-top-bar flex-w">
                        @if (!(auth()->user()->hasrole('super-admin') || auth()->user()->hasrole('store-owner')))
                            <a href="#" data-toggle="modal" data-target="#exampleModal"
                                class="flex-c-m trans-04 p-lr-25">
                                Register My Store
                            </a>
                        @elseif (auth()->user()->hasrole('store-owner'))
                            <a class="flex-c-m trans-04 p-lr-25" href={{ route('check.dashboard') }}>Go to
                                Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" class="text-white flex-c-m trans-04" method="POST">
                            @csrf
                            <button type="submit" class="flex-c-m text-light trans-04 p-lr-25">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop">
                <nav class="container limiter-menu-desktop">

                    <!-- Logo desktop -->
                    <a href="#" class="logo">
                        <img src={{ asset('assets/img/icons/logo-01.png') }} alt="IMG-LOGO">
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>

                            <li
                                class="{{ request()->routeIs('shop.product', 'shop.product.*') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.product') }}">Shop</a>
                            </li>

                            <li class="label1 {{ request()->routeIs('shop.cart.*') ? 'active-menu' : '' }}"
                                data-label1="{{ $cartItemsCount }}">
                                <a href="{{ route('shop.cart.index') }}">View Cart</a>
                            </li>

                            <li class="{{ request()->routeIs('shop.orders.*') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.orders.index') }}">Orders</a>
                            </li>

                            <li class="{{ request()->routeIs('shop.about') ? 'active-menu' : '' }}">
                                <a href="{{ route('shop.about') }}">About</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>

                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="{{ $cartItemsCount }}">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>

                        <a href="#"
                            class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                            data-notify="0">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html"><img src={{ asset('assets/img/icons/logo-01.png') }} alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>

                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                    data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>

                <a href="#"
                    class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                    data-notify="0">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li>
                    <div class="left-top-bar">
                        Free shipping for standard order over $100
                    </div>
                </li>

                <li>
                    <div class="h-full right-top-bar flex-w flex-column">
                        @if (!(auth()->user()->hasrole('super-admin') || auth()->user()->hasrole('store-owner')))
                            <a href="#" class="flex-c-m p-lr-10 trans-04" data-toggle="modal"
                                data-target="#exampleModal">
                                Register My Store
                            </a>
                        @elseif (auth()->user()->hasrole('store-owner'))
                            <a href="{{ route('check.dashboard') }}" class="flex-c-m p-lr-10 trans-04">
                                Go to Dashboard
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="flex-c-m p-lr-10 trans-04">
                            @csrf
                            <button type="submit" class="flex-c-m text-light trans-04">
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>


            <ul class="main-menu-m">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>

                <li>
                    <a href="{{ route('shop.product') }}">Shop</a>
                </li>

                <li>
                    <a href="{{ route('shop.cart.index') }}" class="label1 rs1"
                        data-label1="{{ $cartItemsCount }}">View Cart</a>
                </li>

                <li>
                    <a href="{{ route('shop.orders.index') }}">Orders</a>
                </li>

                <li>
                    <a href="{{ route('shop.about') }}">About</a>
                </li>
            </ul>

        </div>

        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src={{ asset('assets/img/icons/icon-close2.png') }} alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div>
    </header>

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="w-full header-cart-wrapitem">
                    @if ($cartItemsCount > 0)
                        @foreach ($cart->items as $cartItems)
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src={{ asset('storage/' . $cartItems->itemable->product_image) }}
                                        alt="IMG">
                                </div>

                                <div class="header-cart-item-txt p-t-8">
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        {{ $cartItems->itemable->name }}
                                    </a>

                                    <span class="header-cart-item-info">
                                        {{ $cartItems->quantity }} x {{ $cartItems->price }}$
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <span class="header-cart-item-info">
                                No Item Are Added
                            </span>
                        </li>
                </ul>
            </div>
            @endif

            <div class="w-full">
                <div class="w-full header-cart-total p-tb-40">
                    {{ $totalprice }} {{ '$' }}
                </div>

                <div class="w-full header-cart-buttons flex-w">
                    <a href={{ route('shop.cart.index') }}
                        class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    @yield('main')

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Categories
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Women
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Men
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shoes
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Watches
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Help
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Track Order
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Returns
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shipping
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                FAQs
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        GET IN TOUCH
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
                        on (+1) 96 716 6879
                    </p>

                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Newsletter
                    </h4>

                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src={{ asset('assets/img/icons/icon-pay-01.png') }} alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src={{ asset('assets/img/icons/icon-pay-02.png') }} alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src={{ asset('assets/img/icons/icon-pay-03.png') }} alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src={{ asset('assets/img/icons/icon-pay-04.png') }} alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src={{ asset('assets/img/icons/icon-pay-05.png') }} alt="ICON-PAY">
                    </a>
                </div>

                <p class="stext-107 cl6 txt-center">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | Made with <i class="fa fa-heart-o"
                        aria-hidden="true"></i> by <a href="" target="_blank">Venkata Krishna Konuri</a> &amp;
                    Made By <a href="#" target="_blank">Venkata Krishna Konuri</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                </p>
            </div>
        </div>
    </footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <script src={{ asset('shop/vendor/jquery/jquery-3.2.1.min.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/animsition/js/animsition.min.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/bootstrap/js/popper.js') }}></script>
    <script src={{ asset('shop/vendor/bootstrap/js/bootstrap.min.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/select2/select2.min.js') }}></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/daterangepicker/moment.min.js') }}></script>
    <script src={{ asset('shop/vendor/daterangepicker/daterangepicker.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/slick/slick.min.js') }}></script>
    <script src={{ asset('shop/js/slick-custom.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/parallax100/parallax100.js') }}></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/isotope/isotope.pkgd.min.js') }}></script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/sweetalert/sweetalert.min.js') }}></script>
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
        $('#myModal').on('shown.bs.modal', function() {
            $('#myInput').trigger('focus')
        })
    </script>
    <!--===============================================================================================-->
    <script src={{ asset('shop/js/main.js') }}></script>

</body>

</html>
