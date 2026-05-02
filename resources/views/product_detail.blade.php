@extends('majordesign')

<base href="/public">

@section('content')

 <!-- Success Message -->
                    @if(session('cart_message'))
                        <div class="alert alert-success text-center py-2">
                            {{ session('cart_message') }}
                        </div>
                    @endif
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Back Button -->
            <a href="{{route('main')}}" 
               class="btn btn-secondary mb-4">
                ← Back to Products
            </a>

            <div class="row">
                <!-- Product Image -->
                <div class="col-md-5">
                    <div class="product-image-box text-center p-4 border">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->product_name }}"
                                 class="img-fluid rounded"
                                 style="max-height: 420px; object-fit: contain;">
                        @else
                            <div class="no-image-placeholder d-flex align-items-center justify-content-center bg-light rounded"
                                 style="height: 420px; border: 2px dashed #ddd;">
                                <h5 class="text-muted">No Image Available</h5>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-7">
                    <h2 class="fw-bold mb-3">{{ $product->product_name }}</h2>
                    
                    <div class="mb-4">
                        <span class="badge bg-info px-3 py-2">
                            {{ optional($product->category)->category ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <p class="text-muted mb-2">
                        <strong>Product ID:</strong> #{{ $product->id }}
                    </p>

                    <hr class="my-4">

                    <h5 class="fw-semibold mb-3">Description</h5>
                    <p class="text-secondary" style="line-height: 1.8;">
                        {{ $product->product_description ?? 'No description provided for this product.' }}
                    </p>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h4 class="text-success fw-bold">
                                ${{ number_format($product->price, 2) }}
                            </h4>
                            <small class="text-muted">Price</small>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <div class="mt-5">
                   <form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary btn-lg px-5">
        <i class="fa fa-shopping-cart"></i> Add to Cart
    </button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extra Styles to match Giftos theme -->
<style>
    .product-image-box {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
   
    .no-image-placeholder {
        font-size: 1.1rem;
    }
   
    h2 {
        color: #2c3e50;
        font-weight: 700;
    }
   
    .badge {
        font-size: 1rem;
        font-weight: 500;
    }
   
    .btn-lg {
        padding: 12px 30px;
        border-radius: 6px;
        font-size: 1.05rem;
    }
   
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0069d9;
    }
   
    hr {
        border-top: 2px solid #eee;
    }
</style>
@endsection