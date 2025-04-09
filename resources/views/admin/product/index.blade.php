@extends('layouts.admin')

@section('main')
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Products</h1>
    </div>

    <div class="panel-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-flex align-items-center">
                                <div class="table-img"
                                    style="background-image: url('{{ asset('storage/' . $item->product_image) }}'); width: 40px; height: 40px; background-size: cover; background-position: center; border-radius: 4px;">
                                </div>
                                <div class="pl-3 email d-flex flex-column">
                                    <span>{{ $item->name }}</span>
                                    <span>{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                            </td>

                            </td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>
                                <ul class="action-list list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{ route('superadmin.product.show', ['id' => $item->id]) }}"
                                            data-tip="view">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>
    {{ $products->links() }}

@endsection
