@extends('admin.index')
<base href="/public">

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid py-5 px-4">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-white mb-1">Product Inventory</h1>
                <p class="text-light opacity-75">All Products ({{ $products->total() }})</p>
            </div>
            <a href="{{ route('admin.addproduct') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i> Add New Product
            </a>
        </div>

        <!-- Filter Section -->
        <div class="card border-0 shadow-lg bg-dark rounded-4 mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.viewproduct') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-light opacity-75 small">Filter by Category</label>
                        <select name="category_id" class="form-select bg-dark text-light border-secondary">
                            <option value="">-- All Categories --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                    @if(request('category_id'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.viewproduct') }}" class="btn btn-outline-light w-100">
                            Clear Filter
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card border-0 shadow-lg bg-dark rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Product</th>
                            <th>Category</th>
                            <th class="text-end">Price (TZS)</th>
                            <th class="text-center">Stock Quantity</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <!-- Product Image + Info -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <!-- Image -->
                                    <div class="me-3 flex-shrink-0">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                                             alt="{{ $product->product_name }}"
                                             width="75"
                                             height="75"
                                             class="rounded border border-secondary shadow-sm"
                                             style="object-fit: cover;"
                                             loading="lazy">
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-white">{{ $product->product_name }}</div>
                                        <small class="text-light opacity-75">
                                            {{ \Illuminate\Support\Str::limit($product->product_description ?? 'No description available', 80) }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="align-middle">
                                <span class="badge bg-secondary px-3 py-2">
                                    {{ $product->category->category ?? 'No Category' }}
                                </span>
                            </td>

                            <!-- Price -->
                            <td class="text-end align-middle fw-semibold text-success">
                                {{ number_format($product->price) }}
                            </td>

                            <!-- Stock Quantity -->
                            <td class="text-center align-middle">
                                <span class="fw-bold {{ $product->quantity <= 5 ? 'text-warning' : 'text-info' }}">
                                    {{ $product->quantity }}
                                </span>
                                @if($product->quantity <= 5 && $product->quantity > 0)
                                    <br><small class="text-warning">Low Stock</small>
                                @elseif($product->quantity == 0)
                                    <br><small class="text-danger">Out of Stock</small>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4 align-middle">
                                <a href="{{ route('admin.viewproduct', $product->id) }}" 
                                   class="btn btn-sm btn-outline-light me-1" 
                                   title="View Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-light">
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center py-4 border-top border-secondary">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        background: linear-gradient(135deg, #0f172a 0%, #1e2937 100%);
        min-height: 100vh;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .table {
        color: #e2e8f0;
    }
    .table thead th {
        background-color: #1e2937;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.82rem;
        letter-spacing: 0.6px;
        padding: 18px 12px;
    }
    .table td {
        padding: 18px 12px;
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: #334155 !important;
    }
    .badge {
        font-size: 0.9rem;
    }
</style>
@endsection