@extends('layouts.shop')

@section('main')
    <!-- Product -->
    <div class="bg0 m-t-20 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <a href="#" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                        Products
                    </a>

                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>
                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <form action="{{ route('shop.product') }}" method="GET">
                        <div class="bor8 dis-flex p-l-15">
                            <button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>

                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search_product"
                                placeholder="Search" required>
                        </div>
                    </form>
                </div>


                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <form action="{{ route('shop.product') }}" method="GET">
                        <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                            <div class="filter-col1 p-r-15 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">Sort By</div>
                                <ul>
                                    @php
                                        $sortOptions = [
                                            '' => 'Default',
                                            'popularity' => 'Popularity',
                                            'rating' => 'Average rating',
                                            'newest' => 'Newness',
                                            'price_asc' => 'Price: Low to High',
                                            'price_desc' => 'Price: High to Low',
                                        ];
                                    @endphp

                                    @foreach ($sortOptions as $value => $label)
                                        <li class="p-b-6">
                                            <input type="radio" name="sort_by" id="sort_{{ $value }}"
                                                value="{{ $value }}"
                                                {{ request('sort_by') == $value ? 'checked' : '' }}>
                                            <label for="sort_{{ $value }}"
                                                class="filter-link custom-radio stext-106 trans-04">
                                                {{ $label }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="filter-col2 p-r-15 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">Price</div>
                                <ul>
                                    @php
                                        $priceRanges = [
                                            '' => 'All',
                                            '0-50' => '$0.00 - $50.00',
                                            '50-100' => '$50.00 - $100.00',
                                            '100-150' => '$100.00 - $150.00',
                                            '150-200' => '$150.00 - $200.00',
                                            '200+' => '$200.00+',
                                        ];
                                    @endphp

                                    @foreach ($priceRanges as $value => $label)
                                        <li class="p-b-6">
                                            <input type="radio" name="price_range" id="price_{{ $value }}"
                                                value="{{ $value }}"
                                                {{ request('price_range') == $value ? 'checked' : '' }}>
                                            <label for="price_{{ $value }}"
                                                class="filter-link custom-price-radio stext-106 trans-04">
                                                {{ $label }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="filter-col3 p-r-15 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">Categories</div>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li class="p-b-6">
                                            <input type="radio" name="category_id" id="category_{{ $category->id }}"
                                                value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'checked' : '' }}>
                                            <label for="category_{{ $category->id }}"
                                                class="filter-link custom-category-radio stext-106 trans-04"
                                                style="--color: {{ $category->color }};">
                                                {{ $category->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="filter-col4 p-b-27">
                                <button type="submit" class="btn btn-primary text-light cl2 p-2">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row isotope-grid">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src={{ asset('storage/' . $product->product_image) }} alt="IMG-PRODUCT">

                                    <a href={{ route('shop.product.view', ['id' => $product->id]) }}
                                        class="block2-btn flex-c-m stext-103 cl2 size-102 b g0 bor2 hov-btn1 p-lr-15 trans-04">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="product-detail.html"
                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->name }}
                                        </a>

                                        <span class="stext-105 cl3">
                                            {{ $product->price }}
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04"
                                                src={{ asset('assets/img/icons/iconheart01.png') }} alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                src={{ asset('assets/img/icons/iconheart02.png') }} alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="min-vh-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                            <h2 class="not-found-message">No Records Found</h2>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Load more -->
            {{ $products->links() }}
        </div>
    </div>
@endsection
