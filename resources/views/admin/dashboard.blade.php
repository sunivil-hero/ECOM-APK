@extends('admin.index')

<base href="/public">
{{-- @ts-nocheck --}}

@section('content')

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h3 text-primary">E-commerce Dashboard</h1>
            <p class="text-muted">Real-time overview of your store performance in Dar es Salaam.</p>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 mr-3">
                            <i class="fa fa-dollar-sign"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase font-weight-bold">Total Revenue</small>
                            <h3 class="mb-0">${{ number_format($totalAmount ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 mr-3">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase font-weight-bold">Total Orders</small>
                            <h3 class="mb-0">{{ $totalOrders ?? '0' }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 mr-3">
                            <i class="fa fa-users"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase font-weight-bold">Total Customers</small>
                            <h3 class="mb-0">{{ $totalCustomers ?? '0' }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 mr-3">
                            <i class="fa fa-boxes"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase font-weight-bold">In Stock</small>
                            <h3 class="mb-0">{{ number_format($productsInStock ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="mb-3">Sales Performance (Weekly)</h5>
                    <div style="height: 300px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="mb-3">Top Products</h5>
                    <div style="height: 300px;">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h5 class="border-bottom pb-2">Recent Orders</h5>
                    <div class="list-group list-group-flush">
                        @forelse($recentOrders ?? [] as $order)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <strong>Order #{{ $order->id }}</strong>
                                    <span class="text-success">${{ number_format($order->total_amount ?? 0, 2) }}</span>
                                </div>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <p class="text-muted mt-2">No recent orders.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h5 class="border-bottom pb-2">New Customers</h5>
                    <ul class="list-unstyled">
                        @forelse($recentCustomers ?? [] as $customer)
                            <li class="py-2 border-bottom">
                                <i class="fa fa-user-circle text-muted mr-2"></i>
                                {{ $customer->name ?? 'Unknown' }}
                                <div class="small text-muted">{{ $customer->created_at->format('M d, Y') }}</div>
                            </li>
                        @empty
                            <p class="text-muted mt-2">No new customers.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h5 class="border-bottom pb-2">Store Location</h5>
                    <div class="rounded overflow-hidden mt-2" style="height: 250px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126781.042398579!2d39.1869811!3d-6.7923985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4bae1697462f%3A0x35081075775f0f3!2sDar%20es%20Salaam!5e0!3m2!1sen!2stz!4v1715424567890!5m2!1sen!2stz"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                    <small class="text-muted mt-2"><i class="fa fa-map-marker-alt"></i> Posta Town, Dar es Salaam</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ==== SAFE DATA FROM LARAVEL ====
    const salesLabels = JSON.parse('@json($salesLabels ?? ["Mon", "Tue", "Wed"])');
    const salesData   = JSON.parse('@json($salesData ?? [0])');

    const productNames = JSON.parse('@json($productNames ?? ["No Data"])');
    const productSales = JSON.parse('@json($productSales ?? [0])');

    // ==== SALES LINE CHART ====
    const salesCtx = document.getElementById('salesChart');

    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Revenue',
                    data: salesData,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: '#28a745',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // ==== TOP PRODUCTS BAR CHART ====
    const productsCtx = document.getElementById('topProductsChart');

    if (productsCtx) {
        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Units Sold',
                    data: productSales,
                    backgroundColor: [
                        '#28a745',
                        '#17a2b8',
                        '#ffc107',
                        '#dc3545',
                        '#6610f2'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});
</script>

@endsection