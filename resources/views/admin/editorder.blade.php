@extends('admin.index')
<base href="/public">

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-shopping-bag"></i> Edit Order - #{{ $order->id }}
            </h4>
            <a href="{{ route('admin.vieworders') }}" class="btn btn-light btn-sm">
                ← Back to Orders
            </a>
        </div>
        
        <div class="card-body">
            
            <!-- Order & Customer Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Customer Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $order->full_name ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Order Summary</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y - h:i A') }}</li>
                        <li class="list-group-item">
                            <strong>Current Status:</strong>
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' :
                                                      ($order->status == 'shipped' ? 'primary' :
                                                      ($order->status == 'completed' ? 'success' : 'danger')) }}">
                                {{ ucfirst($order->status ?? 'Unknown') }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Total Amount:</strong> 
                            <span class="fw-bold">${{ number_format($order->total_amount ?? 0, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr>

            <!-- Order Items -->
            <h5 class="mb-3">Ordered Items</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <!-- Image - Fixed (No Duplication + No JS Error) -->
                            <td>
                                @php
                                    $image = $item->product->image ?? null;
                                @endphp
                                @if($image)
                                    <img src="{{ Storage::url($image) }}" 
                                         alt="{{ $item->product->product_name ?? 'Product' }}"
                                         style="width: 65px; height: 65px; object-fit: cover; border-radius: 6px;"
                                         loading="lazy">
                                @else
                                    <div style="width: 65px; height: 65px; background:#f8f9fa; border-radius:6px; 
                                                display:flex; align-items:center; justify-content:center; color:#adb5bd; font-size:11px;">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <!-- Product Name -->
                            <td class="fw-medium">
                                {{ $item->product->product_name ?? 
                                   $item->product->name ?? 
                                   $item->product->title ?? 
                                   'Unknown Product' }}
                            </td>

                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price ?? 0, 2) }}</td>
                            <td class="text-end fw-bold">
                                ${{ number_format(($item->price * $item->quantity) ?? 0, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            <!-- Update Order Status -->
            <div class="mt-4">
                <h5>Update Order Status</h5>
                <form action="{{ route('admin.updatestatus', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PUT')
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <select name="status" class="form-select form-select-lg" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                Update Status
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-3">
                    <a href="{{ route('admin.downloadInvoice', $order->id) }}" 
                       class="btn btn-success" target="_blank">
                        <i class="fas fa-file-download"></i> Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
@push('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .list-group-item {
        border: none;
        padding: 10px 0;
    }
    .badge {
        padding: 0.5em 1.2em;
        font-size: 1rem;
    }
</style>
@endpush
@endsection