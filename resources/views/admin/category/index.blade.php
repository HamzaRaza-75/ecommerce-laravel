@extends('layouts.admin')

@section('main')
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Category</h1>
        <a href="#" data-toggle="modal" data-target="#add-category"
            class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary">+
            New Category</a>
    </div>

    <div class="panel-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Total Products Count</th>
                    <th>Total Stores Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->stores_count }}</td>
                            <td>
                                <ul class="action-list">
                                    <li><a href="#" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                                    <form action="{{ route('superadmin.category.destroy', $category->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-tip="delete"
                                            style="border: none; background: transparent; cursor: pointer;">
                                            <i class="fa fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif


            </tbody>
        </table>
    </div>
    <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm" action={{ route('superadmin.category.store') }} method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" id="categoryName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
