
@extends('majordesign')

@section('content')
<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>All Products</h2>
        </div>

         @if(session('product_message'))
                    <div class="alert alert-success text-center py-2">
                        {{ session('product_message') }}
                    </div>
                @endif
        <div class="row">
            @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="box">
                    <a href="{{ route('product.detail', $product->id) }}">
                        
                        <!-- Image Box -->
                        <div class="img-box">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->product_name }}"
                                     style="height: 220px; object-fit: contain;">
                            @else
                                <div class="no-image d-flex align-items-center justify-content-center bg-light" 
                                     style="height: 220px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="detail-box">
                            <h6 class="product-name">{{ $product->product_name }}</h6>
                            
                            <div class="price-box">
                                <h6>
                                    Price 
                                    <span class="price">${{ number_format($product->price, 2) }}</span>
                                </h6>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        @if($product->quantity > 0)
                            <div class="new">
                                <span>In Stock</span>
                            </div>
                        @else
                            <div class="new bg-danger">
                                <span>Out of Stock</span>
                            </div>
                        @endif

                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h5 class="text-muted">No products available at the moment.</h5>
            </div>
            @endforelse
        </div>

        <!-- Pagination (if using paginator) -->
        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
        @endif
<div class="btn-box">
        <a href="{{route('main')}}">
          View Latest Products
        </a>
      </div>
        <!-- View All is not needed here since this is already the full list -->
    </div>
</section>
@endsection

<!-- Additional Professional Styles -->
<style>
    .shop_section .box {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .shop_section .box:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.12);
    }
    
    .shop_section .img-box {
        padding: 20px;
        background: #fff;
        text-align: center;
    }
    
    .shop_section .img-box img {
        transition: transform 0.4s ease;
    }
    
    .shop_section .box:hover .img-box img {
        transform: scale(1.05);
    }
    
    .shop_section .detail-box {
        padding: 15px 20px;
        background: #fff;
    }
    
    .product-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }
    
    .price-box h6 {
        margin: 0;
        font-size: 1.1rem;
    }
    
    .price {
        color: #28a745;
        font-weight: 700;
    }
    
    .new {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 20px;
        background: #28a745;
        color: white;
    }
    
    .new.bg-danger {
        background: #dc3545;
    }
    
    .no-image {
        border: 2px dashed #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
    }
    
    .heading_container h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
    }
</style>
