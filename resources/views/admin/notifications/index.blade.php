@extends('layouts.master')
@section('title', 'Notifications')
@section('page-title', 'Notifications List')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>All Notifications</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendNotificationModal">Send Notification</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Status</th>
                    <th>Sent At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr>
                        <td>{{ $notification->id }}</td>
                        <td>{{ $notification->customer->name ?? 'N/A' }}</td>
                        <td><strong>{{ $notification->title }}</strong></td>
                        <td>{{ Str::limit($notification->body, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $notification->is_read ? 'secondary' : 'success' }}">
                                {{ $notification->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td>{{ $notification->sent_at ? $notification->sent_at->format('Y-m-d H:i') : '-' }}</td>
                        <td>
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="GET" class="d-inline">
                                    <button class="btn btn-sm btn-info">Mark as Read</button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this notification?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No notifications found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">{{ $notifications->links() }}</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('notifications.send') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Send Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="body" class="form-control" rows="3" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success">Send</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
  </div>
</div>
@endsection
