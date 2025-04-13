@extends('layouts.store')

@section('main')
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Dashboard</h1>
    </div>

    <!-- Content Row -->

    <div class=" row">
        <!-- Area Chart -->
        <div class="mb-4 shadow card">
            <!-- Card Header - Dropdown -->
            <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="text-gray-400 fas fa-ellipsis-v fa-sm fa-fw"></i>
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body ">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table">
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
                @if (!empty($orderItems))
                    @foreach ($orderItems as $order)
                        <tr class="{{ $order->status == 'pending' ? 'bg-secondary' : '' }}">
                            <td>{{ $order->order->order_num }}</td>
                            <td>
                                <a href="{{ route('store.product.show', $product) }}">
                                    <img src="{{ asset('storage/' . $product->product_image) }}" class="avatar"
                                        alt="Avatar" style="width: 23px">
                                    {{ $product->name }}
                                </a>
                            </td>
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

        {{ $orderItems->links() }}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === Area Chart: Monthly Earnings ===
            const labels = @json($earningLabels);
            const data = @json($earningValues);

            const ctx = document.getElementById('myAreaChart').getContext('2d');
            new Chart(ctx, {
                type: 'line', // Area chart
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Earnings (USD)',
                        data: data,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => `$. ${value}`
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
