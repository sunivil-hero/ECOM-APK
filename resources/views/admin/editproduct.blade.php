@extends('admin.index')

<base href="/public">
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 600px;">
        <div class="card shadow-lg border-0">
    
            <div class="card-header bg-success text-white text-center fw-bold">
                Edit Product - #{{ $product->id }}
            </div>

            <div class="card-body p-4">
                <!-- Success Message -->
                @if(session('product_message'))
                    <div class="alert alert-success text-center py-2">
                        {{ session('product_message') }}
                    </div>
                @endif

                
                <form action="{{ route('admin.updateproduct', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" 
                               class="form-control" 
                               name="product_name" 
                               value="{{ old('product_name', $product->product_name) }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-control" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Price</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   name="price" 
                                   value="{{ old('price', $product->price) }}" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="quantity" 
                                   value="{{ old('quantity', $product->quantity) }}" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Description</label>
                        <textarea class="form-control" 
                                  name="product_description" 
                                  rows="4">{{ old('product_description', $product->product_description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Image</label><br>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="Current Image" 
                                 class="img-thumbnail mb-2" 
                                 style="max-height: 150px;">
                        @endif
                        
                        <label class="form-label fw-semibold">Upload New Image (Optional)</label>
                        <input type="file" 
                               class="form-control" 
                               name="image" 
                               accept="image/*">
                        <small class="text-muted">Leave empty if you don't want to change the image</small>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3">
                        Update Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
     body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
        background: #ffffff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        font-size: 18px;
    }

    h4 {
        font-weight: 700;
        color: #212529;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25,135,84,.25);
    }

    .btn-success {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px;
        font-size: 15px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 10px;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 10px;
        }
    }
</style>
@endsection
