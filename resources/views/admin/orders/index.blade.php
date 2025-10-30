@extends('layouts.master')
@section('title', 'Orders')
@section('page-title', 'Orders List')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">All Orders</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Address</th> {{-- العنوان --}}
                    <th>Status</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? 'N/A' }}</td>

                        {{--  عرض العنوان --}}
                        <td>
                            @if($order->address)
                                {{ $order->address->city ?? '-' }},
                                {{ $order->address->street ?? '-' }}<br>
                                <small class="text-muted">{{ $order->address->phone ?? '' }}</small>
                            @else
                                <span class="text-muted">No Address</span>
                            @endif
                        </td>

                        <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->is_payment ? 'Paid' : 'Unpaid' }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
