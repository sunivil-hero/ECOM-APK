@extends('admin.index')

<base href="/public">
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 500px;">

        <!-- Card -->
        <div class="card shadow-lg border-0">
            <!-- Card Header -->
            <div class="card-header bg-success text-white text-center fw-bold">
                Edit Category
            </div>

            <div class="card-body p-4">

                <!-- Success Message -->
                @if(session('category_message'))
                    <div class="alert alert-success text-center py-2">
        {{ session('category_message') }}
    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.updatecategory', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="categoryName" class="form-label fw-semibold">Category Name</label>
                        <input type="text"
                               class="form-control"
                               id="categoryName"
                               name="category"
                               value="{{ old('category', $category->category) }}"
                               placeholder="Enter category name"
                               required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Update Category
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<!-- Inline CSS -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
        background: #ffffff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        font-size: 18px;
    }

    h4 {
        font-weight: 700;
        color: #212529;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25,135,84,.25);
    }

    .btn-success {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px;
        font-size: 15px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 10px;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 10px;
        }
    }
</style>
@endsection