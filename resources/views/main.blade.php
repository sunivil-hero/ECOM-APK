@extends('majordesign')


@section('content')
 <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div>
      <div class="row">
       @foreach($products as $product)
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="box">
            <a href="{{ route('product.detail', $product->id) }}">
                <div class="img-box">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                </div>
                <div class="detail-box">
                    <h6>{{ $product->product_name }}</h6>
                    <h6>
                        Price
                        <span>${{ $product->price }}</span>
                    </h6>
                </div>
                @if($product->quantity > 0)
                    <div class="new">
                        <span>New</span>
                    </div>
                @else
                    <div class="new bg-danger">
                        <span>Out of Stock</span>
                    </div>
                @endif
            </a>
        </div>
    </div>
@endforeach
      </div>
      <div class="btn-box">
        <a href="{{route('main')}}">
          View All Products
        </a>
      </div>
    </div>
  </section>

@endsection