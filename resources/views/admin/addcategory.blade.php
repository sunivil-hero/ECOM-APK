@extends('admin.index')

<base href="/public">
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 500px;">

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Heading -->
                <h4 class="text-center mb-4">Add Category</h4>

                <!-- Success Message -->
                @if(session('category_message'))
                    <div class="alert alert-success text-center py-2">
                        {{ session('category_message') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.addcategory') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="categoryName" class="form-label fw-semibold">Category Name</label>
                        <input type="text"
                               class="form-control"
                               id="categoryName"
                               name="category"
                               placeholder="Enter category name"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Add Category
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<!-- Inline CSS -->
<style>
    body {
        background-color: #f5f7fa;
    }

    .card {
        border-radius: 12px;
        background: #ffffff;
    }

    h4 {
        font-weight: 600;
        color: #343a40;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.1rem rgba(13,110,253,.15);
    }

    .btn-primary {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px;
        transition: 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .alert {
        border-radius: 8px;
        font-size: 14px;
    }
</style>

@endsection