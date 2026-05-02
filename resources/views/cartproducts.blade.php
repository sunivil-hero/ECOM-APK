@extends('majordesign')

@section('content')
<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>My Shopping Cart</h2>
        </div>

         @if(session('cart_message'))
                    <div class="alert alert-success text-center py-2">
                        {{ session('cart_message') }}
                    </div>
                @endif


        @if($cart->isEmpty())
            <div class="text-center py-5">
                <h4>Your cart is empty</h4>
                <a href="{{ route('main') }}" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             width="60" height="60" style="object-fit: contain;" class="me-3">
                                        {{ $item->product->product_name }}
                                    </td>
                                    <td>${{ number_format($item->product->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->quantity * $item->product->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item from your cart?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <h4>Total: <strong>${{ number_format($total, 2) }}</strong></h4>
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg mt-3">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection