@extends('admin.index')

<base href="/public">
@section('content')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-envelope"></i> Customer Messages
            </h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $key => $msg)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $msg->name }}</strong></td>
                            <td>{{ $msg->email }}</td>
                            <td>{{ $msg->phone ?? 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($msg->message, 50) }}</td>
                            <td class="text-center">
                                <small>{{ $msg->created_at->format('d M, Y') }}</small>
                            </td>
                            <td class="text-center">
                                <form action="{{ url('admin/messages/'.$msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No messages found.</td>
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
    .card { border-radius: 12px; }
    .table th { font-size: 0.85rem; text-transform: uppercase; }
</style>
@endpush
@endsection