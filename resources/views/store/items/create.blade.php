@extends('layouts.store')


@section('main')
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Product / Create</h1>
    </div>

    <div class="container py-4">
        <div class="alert alert-info small" role="alert">
            Please choose you image of ratio of 4x4 + maximum size 5MB . The platforms low quality stock will be 10 quantity
            remaining
        </div>

        <!-- Product Form -->
        <form action={{ route('store.product.store') }} method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Row for Product Name, Category, and Stock -->
            <div class="row mb-3">
                <!-- Product Name -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter Product Name" required>
                </div>

                <!-- Product Category (category_id) -->
                <div class="col-md-4">
                    <label for="category_id" class="form-label">Product Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->slug }}</option>
                        @endforeach

                        <!-- Add more categories as needed -->
                    </select>
                </div>

                <!-- Stock -->
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock"
                        placeholder="Enter stock quantity" required>
                </div>
            </div>

            <!-- Row for Price -->
            <div class="row d-flex justify-content-center mb-3">
                <div class=" col-md-10">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                        placeholder="Enter price" required>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <!-- File Input for Product Image -->
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input class="form-control" type="file" id="product_image" name="product_image">
            </div>

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
@endsection
