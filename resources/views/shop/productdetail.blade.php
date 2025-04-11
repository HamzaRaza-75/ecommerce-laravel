@extends('layouts.shop')

@section('main')
    <!-- Product Detail -->
    <section class="sec-product-detail bg0 m-t-20 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                            <div class="slick3">
                                <img src={{ asset('storage/' . $product->product_image) }} class="p-t-30" alt="IMG-PRODUCT">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>

                        <span class="mtext-106 cl2">
                            ${{ $product->price }}
                        </span>

                        <!--  -->
                        <div class="p-t-33">
                            <form action="{{ route('shop.cart.store', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="quantity" id="num-product" value="1" min="1"
                                                max="10">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--  -->
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                    data-tooltip="Add to Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews
                                ({{ $product->reviews_count }})</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- - -->

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        @if (count($product->reviews) > 0)
                                            @foreach ($product->reviews as $reviews)
                                                <!-- Review -->
                                                <div class="flex-w flex-t p-b-68">
                                                    <span class="rounded-pill bg-primary px-2 text-white">
                                                        {{ strtoupper(substr($reviews->user->name, 0, 1)) }}
                                                    </span>

                                                    <div class="size-207">
                                                        <div class="flex-w flex-sb-m p-b-17">
                                                            <span class="mtext-107 cl2 p-r-20">
                                                                {{ $reviews->user->name }}
                                                            </span>

                                                            <span class="fs-18 cl11">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $reviews->rating)
                                                                        <i class="zmdi zmdi-star text-warning"></i>
                                                                        {{-- filled star --}}
                                                                    @else
                                                                        <i class="zmdi zmdi-star-outline"></i>
                                                                        {{-- empty star --}}
                                                                    @endif
                                                                @endfor
                                                            </span>
                                                        </div>

                                                        <p class="stext-102 cl6">
                                                            {{ $reviews->comment ? $reviews->comment : 'No text found for this review' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Add review -->
                                            @endforeach
                                        @else
                                            <div class="container text-secondary d-flex justify-content-center">
                                                No Review Added
                                            </div>
                                        @endif
                                        @php
                                            $user = auth()->user();

                                            $hasPurchased = \App\Models\OrderItem::where('product_id', $product->id)
                                                ->where('status', 'proceeded')
                                                ->whereHas('order', function ($q) use ($user) {
                                                    $q->where('user_id', $user->id); // adjust status according to your logic
                                                })
                                                ->exists();

                                            $hasReviewed = \App\Models\Review::where('product_id', $product->id)
                                                ->where('user_id', $user->id)
                                                ->exists();

                                        @endphp

                                        @if ($hasPurchased && !$hasReviewed)
                                            <form action="{{ route('shop.product.review', $product) }}" method="POST"
                                                class="w-full">
                                                @csrf
                                                <h5 class="mtext-108 cl2 p-b-7">
                                                    Add a review
                                                </h5>

                                                <p class="stext-102 cl6">
                                                    Your email address will not be published. Required fields are marked
                                                    *
                                                </p>

                                                <div class="flex-w flex-m p-t-50 p-b-23">
                                                    <span class="stext-102 cl3 m-r-16">
                                                        Your Rating
                                                    </span>

                                                    <span class="wrap-rating fs-18 cl11 pointer">
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <input class="dis-none" type="number" name="rating">
                                                    </span>
                                                </div>

                                                <div class="row p-b-25">
                                                    <div class="col-12 p-b-5">
                                                        <label class="stext-102 cl3" for="review">Your
                                                            review</label>
                                                        <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="comment"></textarea>
                                                    </div>
                                                </div>

                                                <button
                                                    class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                    Submit
                                                </button>
                                            </form>
                                        @elseif(!$hasPurchased)
                                            <p class="text-danger">You must purchase this product to leave a review.</p>
                                        @elseif($hasReviewed)
                                            <p class="text-warning">You have already submitted a review for this product.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                SKU: JAK-01
            </span>

            <span class="stext-107 cl6 p-lr-25">
                Categories: Jacket, Men
            </span>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">
                    @if (count($moreproducts) > 0)
                        @foreach ($moreproducts as $item)
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img src="{{ asset('storage/' . $item->product_image) }}" alt="IMG-PRODUCT">

                                        <a href="#"
                                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                            Quick View
                                        </a>
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="product-detail.html"
                                                class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{ $item->name }}
                                            </a>

                                            <span class="stext-105 cl3">
                                                {{ $item->price }}
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
                        <div class="d-flex justify-content-center">No more items</div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <script>
        var element = document.getElementById("num-product")
        element.addEventListener("change", function(e) {
            if (this.value > 10) {
                console.log(e)
                this.value = 10 // Reset to max allowed value
            } else if (this.value <= 0) {
                this.value = 1 // Reset to min allowed value
            }
        })

        console.log(element)
    </script>
@endsection
