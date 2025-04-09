@extends('layouts.shop')
@section('main')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('shop.product') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shoping Cart
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <span class="text-white">
                @php
                    // Join all error messages into a single string separated by a pipe.
                    $errorString = implode(' | ', $errors->all());
                    // Explode the string into an array using pipe separator.
                    $errorMessages = explode(' | ', $errorString);
                @endphp

                @foreach ($errorMessages as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </span>
        </div>
    @endif


    <!-- Shopping Cart Page -->
    <div class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                {{-- Update Cart Form --}}
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <form method="POST" action="{{ route('shop.cart.update') }}">
                        @csrf
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Price</th>
                                        <th class="column-4">Quantity</th>
                                        <th class="column-5">Total</th>
                                        <th class="column-5">Operation</th>
                                    </tr>

                                    @if (count($cart->items) > 0)
                                        @foreach ($cart->items as $cartitem)
                                            <tr class="table_row">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                        <img src="{{ asset('storage/' . $cartitem->itemable->product_image) }}"
                                                            alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2">{{ $cartitem->itemable->name }}</td>
                                                <td class="column-3">$ {{ number_format($cartitem->itemable->price, 2) }}
                                                </td>
                                                <td class="column-4">
                                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                                        </div>

                                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                            name="quantities[{{ $cartitem->id }}]"
                                                            value="{{ $cartitem->quantity }}" min="1" max="10">

                                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="column-5">$
                                                    {{ number_format($cartitem->quantity * $cartitem->itemable->price, 2) }}
                                                </td>
                                                <td class="column-5">
                                                    <a href="{{ route('shop.cart.destroy', ['id' => $cartitem->id]) }}"
                                                        class="btn btn-danger btn-sm" type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="table_row">
                                            <td class="text-center" colspan="6">No Products Added</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                @if (count($cart->items) > 0)
                                    <button type="submit"
                                        class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                        Update Cart
                                    </button>
                                @else
                                    <a href="{{ route('shop.product') }}"
                                        class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                        Do some Shopping
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>

                {{-- Checkout Form --}}
                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <form method="POST" action="{{ route('shop.orders.store') }}">
                        @csrf
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Cart Totals
                            </h4>

                            <div class="flex-w flex-t bor12 p-b-13">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        Subtotal:
                                    </span>
                                </div>

                                <div class="size-209">
                                    <span class="mtext-110 cl2">
                                        ${{ $cart->calculatedPriceByQuantity() }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Shipping:
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <p class="stext-111 cl6 p-t-2">
                                        There are no shipping methods available. Please double check your address, or
                                        contact us
                                        if you need any help.
                                    </p>

                                    <div class="p-t-15">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input type="tel" name="phone_number" id="phone_number"
                                                    class="form-control" placeholder="Enter phone number" required>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="postal_code" class="form-label">Postal Code</label>
                                                <input type="text" name="postal_code" id="postal_code"
                                                    class="form-control" placeholder="Enter postal code" required>
                                            </div>

                                            <div class="col-12">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control"
                                                    placeholder="Enter address" required>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" name="city" id="city" class="form-control"
                                                    placeholder="Enter city" required>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" name="state" id="state" class="form-control"
                                                    placeholder="Enter state" required>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="country" class="form-label">Country</label>
                                                <input type="text" name="country" id="country" class="form-control"
                                                    placeholder="Enter country" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-t p-t-27 p-b-33 justify-content-between w-full">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">
                                        Total:
                                    </span>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2">
                                        ${{ $cart->calculatedPriceByQuantity() }}
                                    </span>
                                </div>
                            </div>

                            @if (count($cart->items) > 0)
                                <button type="submit"
                                    class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                    Proceed to Checkout
                                </button>
                            @else
                                <a href="{{ route('shop.product') }}"
                                    class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                    Do some shopping
                                </a>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
