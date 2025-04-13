@extends('layouts.store')

@section('main')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-0 text-gray-800 h3">Orders</h1>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Client</th>
                            <th>Order Date</th>
                            <th>Quantity</th>
                            <th>Net Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($orders) > 0)
                            @foreach ($orders as $order)
                                <tr class="{{ $order->status == 'pending' ? 'bg-secondary' : '' }}">
                                    <td>{{ $order->order->order_num }}</td>
                                    <td><a href="{{ route('store.product.show', ['id' => $order->product->id]) }}"><img
                                                src="{{ asset('storage/' . $order->product->product_image) }}" class="avatar"
                                                alt="Avatar" style="width: 23px">
                                            {{ $order->product->name }}</a></td>
                                    <td>{{ $order->order->user->name }}</td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>${{ $order->total_price }}</td>
                                    <td>
                                        {!! $order->status == 'pending'
                                            ? '<a href="' . route('store.orders.store', ['id' => $order->id]) . '" class="btn btn-outline-danger">Proceed</a>'
                                            : '<span class="btn btn-outline-success">Done</span>' !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Record Found</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>

        {{ $orders->links() }}
    </div>
@endsection
