@extends('layouts.master')

@section('title', 'Customer Details')
@section('page-title', 'Customer Information')

@php use Illuminate\Support\Str; @endphp

@section('content')

<!-- 👤 معلومات العميل -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Customer Details</h5>
        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary">⬅ Back to Customers</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name ?? 'User') }}&background=random"
                     alt="avatar" class="rounded-circle mb-3" width="100" height="100">
                <h5>{{ $customer->name ?? 'Unknown' }}</h5>
                <p class="text-muted mb-1">{{ $customer->email ?? '—' }}</p>
                <p class="text-muted mb-1">{{ $customer->phone ?? '—' }}</p>
                <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                    {{ $customer->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 shadow-sm p-3">
                            <div class="fs-4 fw-bold text-primary">{{ $totalOrders }}</div>
                            <div class="text-muted">Total Orders</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 shadow-sm p-3">
                            <div class="fs-4 fw-bold text-success">${{ number_format($totalSpent, 2) }}</div>
                            <div class="text-muted">Total Spent</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 shadow-sm p-3">
                            <div class="fs-4 fw-bold text-info">{{ $customer->created_at->format('Y-m-d') }}</div>
                            <div class="text-muted">Joined At</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 💬 إرسال إشعار -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Send Notification</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('customers.notify', $customer->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Notification Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Notification Body</label>
                <textarea name="body" class="form-control" rows="3" placeholder="Message content..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">💌 Save Notification</button>
        </form>
    </div>
</div>

<!-- 🔔 إشعارات العميل -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Customer Notifications</h5>
        <span class="badge bg-secondary">{{ $notifications->count() }} Total</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $note)
                    <tr>
                        <td>{{ $note->title }}</td>
                        <td>{{ Str::limit($note->body, 60) }}</td>
                        <td>{{ $note->sent_at ? $note->sent_at->format('Y-m-d H:i') : '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-4">No notifications found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 🧾 آخر الطلبات -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lastOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <span class="badge bg-{{
                                $order->status === 'Delivered' ? 'success' :
                                ($order->status === 'Pending' ? 'warning' : 'info')
                            }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
