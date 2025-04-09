@extends('layouts.store')

@section('main')
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Products</h1>
        <a href="{{ route('store.product.create') }}" class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">+
            Add New Product</a>
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
                                    style="background-image: url('{{ asset('storage/' . $item->product_image) }}'">
                                </div>
                                <div class="pl-3 email">
                                    <span>{{ $item->name }}</span>
                                    <span>Added: {{ $item->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>
                                <ul class="action-list list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{ route('store.product.edit', $item) }}" data-tip="edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form action="{{ route('store.product.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-tip="delete"
                                                style="border: none; background: transparent; cursor: pointer;">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                        </form>
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
