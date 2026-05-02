<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

<style>
    :root {
        --primary: #2563eb;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #dc2626;
        --bg-light: #f9fafb;
        --text-dark: #1f2937;
        --border: #e5e7eb;
    }

    body {
        background: var(--bg-light);
    }

    .custom-table-container {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .custom-table thead th {
        text-align: left;
        padding: 12px 18px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 1px solid var(--border);
    }

    .custom-table tbody tr {
        transition: transform 0.15s ease;
    }

    .custom-table tbody tr:hover {
        transform: translateY(-2px);
    }

    .custom-table tbody td {
        padding: 16px 18px;
        background: #ffffff;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        vertical-align: top;
    }

    .custom-table tbody td:first-child {
        border-left: 1px solid var(--border);
        border-radius: 10px 0 0 10px;
        font-weight: 600;
    }

    .custom-table tbody td:last-child {
        border-right: 1px solid var(--border);
        border-radius: 0 10px 10px 0;
    }

    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 6px;
        margin-right: 4px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .bg-warning { background: #fef3c7; color: #92400e; }
    .bg-primary { background: #dbeafe; color: #1e40af; }
    .bg-success { background: #dcfce7; color: #166534; }
    .bg-danger  { background: #fee2e2; color: #991b1b; }

    .card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .empty-state {
        text-align: center;
        padding: 30px;
        color: #6b7280;
    }

    .product-block {
        margin-bottom: 10px;
    }

    .product-name {
        font-weight: 600;
        font-size: 14px;
    }

    .qty {
        font-size: 12px;
        color: #6b7280;
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="card-wrapper">
            <div class="custom-table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            {{-- Order ID --}}
                            <td>#{{ $order->id }}</td>

                            {{-- Image Column: Show images of all products in the order --}}
                            <td>
                                @if($order->products && $order->products->count())
                                    @foreach($order->products as $product)
                                        <img src="{{ Storage::url($product->image) }}" class="product-img" alt="Product Image">
                                    @endforeach
                                @else
                                    <span style="color:#9ca3af;">No Image</span>
                                @endif
                            </td>

                            {{-- Product Name Column: List all product names with quantities --}}
                            <td>
                                @if($order->products && $order->products->count())
                                    @foreach($order->products as $product)
                                        <div class="product-block">
                                            <div class="product-name">{{ $product->product_name }}</div>
                                            <div class="qty">Qty: {{ $product->pivot->quantity ?? 1 }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <span style="color:#9ca3af;">No products</span>
                                @endif
                            </td>

                            {{-- Customer Name --}}
                            <td>{{ $order->full_name ?? 'N/A' }}</td>

                            {{-- Order Date --}}
                            <td>{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>

                            {{-- Status Badge --}}
                            <td>
                                <span class="status-badge 
                                    {{ $order->status == 'pending' ? 'bg-warning' : 
                                      ($order->status == 'shipped' ? 'bg-primary' : 
                                      ($order->status == 'completed' ? 'bg-success' : 'bg-danger')) }}">
                                    {{ ucfirst($order->status ?? 'Unknown') }}
                                </span>
                            </td>

                            {{-- Total Amount --}}
                            <td>${{ number_format($order->total_amount ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    No orders found
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>