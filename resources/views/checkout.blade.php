@extends('majordesign')

@section('content')
<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Checkout</h2>
        </div>
            @if(session('checkout_message'))
                        <div class="alert alert-success text-center py-2">
                            {{ session('checkout_message') }}
                        </div>
                    @endif

        <div class="row">
            <!-- Left Side: Order Summary -->
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">Order Summary</h5>
                        
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <div>
                                <strong>{{ $item->product->product_name }}</strong><br>
                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                            </div>
                            <div>
                                ${{ number_format($item->quantity * $item->product->price, 2) }}
                            </div>
                        </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <h5>Total Amount</h5>
                            <h5 class="text-success fw-bold">
                                ${{ number_format($total, 2) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Shipping Form -->
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">Shipping Details</h5>

                        <form action="{{ route('checkout.place') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" 
                                       class="form-control" 
                                       value="{{ Auth::user()->name ?? '' }}" 
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" 
                                       class="form-control" 
                                       placeholder="Enter your phone number" 
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Shipping Address</label>
                                <textarea name="shipping_address" 
                                          class="form-control" 
                                          rows="4" 
                                          placeholder="Enter your full delivery address" 
                                          required></textarea>
                            </div>

                            <button type="submit" 
                                    class="btn btn-success btn-lg w-100 mt-3"
                                    onclick="return confirm('Are you sure you want to place this order?')">
                                <i class="fa fa-credit-card"></i> Place Order
                            </button>
                        </form>

                        <a href="{{ route('cartproducts') }}" class="btn btn-secondary w-100 mt-3">
                            ← Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection