@extends('admin.index')

<base href="/public">
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-envelope"></i> Customer Messages
            </h4>
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                ← Back to Dashboard
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th class="text-center">Date Received</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $key => $msg)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $msg->name }}</strong></td>
                            <td>{{ $msg->email }}</td>
                            <td>{{ $msg->phone ?? 'N/A' }}</td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($msg->message, 60) }}
                            </td>
                            <td class="text-center">
                                {{ $msg->created_at->format('d M, Y') }}<br>
                                <small class="text-muted">{{ $msg->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm text-white" title="View Full Message">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <form action="#" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                No customer messages found in the database.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 4px !important;
    }
</style>
@endpush

@endsection