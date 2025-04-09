@php
    $allProceeded = $order->orderitems->every(fn($item) => $item->status === 'proceeded');
@endphp


@extends('layouts.admin')

@section('main')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                My Orders / Tracking
            </div>
            <div class="card-body">
                <h6>Order ID: <span class="text-muted">{{ $order->order_num }}</span></h6>

                <div class="card my-3">
                    <div class="card-body row text-center">
                        <div class="col-md-3">
                            <strong>Estimated Delivery:</strong><br>
                            <span class="text-muted">{{ $order->created_at->addDays(10)->diffForHumans() }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Total Price:</strong><br>
                            <span class="text-muted">Cart | {{ $order->total_amount }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong><br>
                            <span class="text-muted">{{ $order->status }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Total Products #:</strong><br>
                            <span class="text-muted">{{ $order->orderitems->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center my-2 position-relative">
                    <!-- Progress line behind the steps -->
                    <div class="w-100 position-absolute top-100 start-0 translate-middle-y border-top border-2 border-secondary"
                        style="z-index: 0;"></div>

                    <!-- Step 1 -->
                    <div class="text-center z-1">
                        <div class="d-flex justify-content-center align-items-center bg-danger text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-check"></i>
                        </div>
                        <small>Placed</small>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center z-1">
                        <div class="d-flex justify-content-center align-items-center bg-danger text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-user"></i>
                        </div>
                        <small>Order Processing</small>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center z-1">
                        <div class="d-flex justify-content-center align-items-center text-white rounded-circle mx-auto mb-2 {{ $allProceeded ? 'bg-danger' : 'bg-secondary' }} "
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-truck"></i>
                        </div>
                        <small>All items Proceeded</small>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center z-1">
                        <div class="d-flex justify-content-center align-items-center {{ $allProceeded ? 'bg-danger' : 'bg-secondary' }} text-white rounded-circle mx-auto mb-2"
                            style="width: 50px; height: 50px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18" height="18"
                                fill="white"> <!-- This sets the color to white -->
                                <path
                                    d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32 354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z" />
                            </svg>

                        </div>
                        <small>Order completed</small>
                    </div>
                </div>


                <!-- Products -->
                <div class="row gy-3 mt-5">
                    @foreach ($order->orderitems as $orderitems)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center border rounded p-2">
                                <img src="{{ asset('storage/' . $orderitems->product->product_image) }}" class="img-fluid"
                                    style="width: 80px;">
                                <div class="ms-3">
                                    <p class="mb-1 fw-semibold">
                                        {{ $orderitems->product->name }}<br>Quantity : {{ $orderitems->quantity }}</p>
                                    <span class="text-muted">{{ $orderitems->total_price }} |
                                        {{ $orderitems->status ? $orderitems->status : 'Status Not found' }} </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>
                <a href="{{ route('superadmin.order.index') }}" class="btn btn-danger mt-3">
                    <i class="fa fa-chevron-left"></i> Back to orders
                </a>
            </div>
        </div>
    </div>
@endsection
