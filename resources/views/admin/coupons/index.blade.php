@extends('layouts.master')
@section('title', 'Coupons')
@section('page-title', 'Coupons List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Coupons</h4>
    <a href="{{ route('coupons.create') }}" class="btn btn-primary">Add Coupon</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Valid Until</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td><b>{{ $coupon->code }}</b></td>
                    <td>{{ ucfirst($coupon->type) }}</td>
                    <td>{{ $coupon->value }}{{ $coupon->type === 'percentage' ? '%' : '$' }}</td>
                    <td>{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $coupon->is_active ? 'success' : 'secondary' }}">
                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-primary btn-sm">✏ Edit</a>
                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this coupon?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No coupons found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $coupons->links() }}</div>
    </div>
</div>
@endsection
