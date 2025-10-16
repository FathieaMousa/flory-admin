@extends('layouts.master')
@section('title', 'Customers')
@section('page-title', 'All Customers')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Customers List</h5>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name ?? '—' }}</td>
                        <td>{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this customer?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
