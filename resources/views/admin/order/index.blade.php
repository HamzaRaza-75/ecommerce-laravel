@extends('layouts.admin')

@section('main')
    <div class="container">
        <h4 class="my-4">My Orders</h4>

        <form method="GET" class="mb-4 row g-3">
            {{-- action="{{ route('shop.orders.filter') }}" --}}
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" placeholder="From Date" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" placeholder="To Date" value="{{ request('to') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <table class="table align-middle mb-5 bg-white shadow rounded">
            <thead class="bg-light">
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_num }}</td>
                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                        <td>
                            <span
                                class="badge
                            {{ $order->status === 'completed' ? 'bg-success' : '' }}
                            {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                            {{ $order->status === 'processing' ? 'bg-info' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}
                        ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('superadmin.order.show', $order->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
