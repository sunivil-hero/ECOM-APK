@extends('admin.index')

<base href="/public">
@section('content')
<div class="container mt-4">
    <!-- Centered heading -->
    <h2 class="mb-4 text-center">Categories</h2>

    @if(session('category_message'))
        <div class="alert alert-success">
            {{ session('category_message') }}
        </div>
    @endif

    <!-- Responsive table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->category }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('admin.editcategory', $category->id) }}" 
                           class="btn btn-warning btn-sm me-1">
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.deletecategory', $category->id) }}" 
                              method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No categories found</td>
                </tr>
                @endforelse

            {{$categories->links()}}
            </tbody>
        </table>
    </div>
</div>

<!-- Inline CSS -->
<style>
    .table {
        background-color: #fff;
        border-radius: 6px;
        overflow: hidden;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 12px 15px;
    }

    .table thead th {
        background-color: #343a40;
        color: #fff;
        font-weight: 500;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    h2 {
        font-weight: 600;
    }

    .btn-danger, .btn-warning {
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 13px;
    }

    .btn-warning {
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #00e038;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
@endsection