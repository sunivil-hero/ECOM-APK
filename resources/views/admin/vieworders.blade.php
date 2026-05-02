@extends('admin.index')

<base href="/public">
@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">All Orders</h2>

    @if(session('order_message') || session('success'))
        <div class="alert alert-success">
            {{ session('order_message') ?? session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <td>{{ $order->full_name ?? 'N/A' }}</td>
                    <td>{{ $order->created_at ? $order->created_at->format('Y-m-d') : 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 
                                           ($order->status == 'shipped' ? 'primary' : 
                                           ($order->status == 'completed' ? 'success' : 'danger')) }}">
                            {{ ucfirst($order->status ?? 'Unknown') }}
                        </span>
                    </td>
                    <td>${{ number_format($order->total_amount ?? 0, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.editorder', $order->id) }}" 
                           class="btn btn-info btn-sm">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- Enhanced CSS Styles -->
<style>
.table {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.table thead th {
    background-color: #343a40;
    color: #fff;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    padding: 0.4em 0.8em;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
}

.bg-warning { background-color: #ffc107; color: #212529; }
.bg-primary { background-color: #007bff; color: #fff; }
.bg-success { background-color: #28a745; color: #fff; }
.bg-danger  { background-color: #dc3545; color: #fff; }

.btn {
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
</style>
@endsection