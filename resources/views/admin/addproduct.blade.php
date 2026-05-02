@extends('admin.index')

<base href="/public">
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <!-- Header -->
                    <h4 class="text-center mb-4 fw-bold">Add New Product</h4>

                    <!-- Success Message -->
                    @if(session('product_message'))
                        <div class="alert alert-success text-center py-2">
                            {{ session('product_message') }}
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.postaddproduct') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" 
                                   name="product_name" 
                                   class="form-control" 
                                   placeholder="Enter product name" 
                                   required>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Price (TZS)</label>
                            <input type="number" 
                                   name="price" 
                                   class="form-control" 
                                   placeholder="Enter price" 
                                   min="0" 
                                   required>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Quantity (Stock)</label>
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control" 
                                   placeholder="Enter available quantity" 
                                   value="0" 
                                   min="0" 
                                   required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="product_description" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Short description"></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" 
                                   name="image" 
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            Add Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f4f6f9; }
    .card { border-radius: 12px; }
    .form-control {
        border-radius: 8px;
        font-size: 14px;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.1rem rgba(13,110,253,.15);
    }
    .btn-primary {
        border-radius: 8px;
        padding: 12px;
    }
    .alert { border-radius: 8px; }
</style>
@endsection