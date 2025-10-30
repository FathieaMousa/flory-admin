@extends('layouts.master')
@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->id)

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <h5 class="mb-3">Customer: {{ $order->customer->name ?? 'N/A' }}</h5>
        <p><b>Status:</b> {{ ucfirst($order->status) }}</p>
        <p><b>Total:</b> ${{ number_format($order->total, 2) }}</p>

        {{-- عرض عنوان التوصيل --}}
        @if($order->address)
            <div class="mt-3 p-3 border rounded bg-light">
                <h6 class="mb-2">Delivery Address:</h6>
                <p class="mb-1"><b>City:</b> {{ $order->address->city ?? '-' }}</p>
                <p class="mb-1"><b>Street:</b> {{ $order->address->street ?? '-' }}</p>
                <p class="mb-1"><b>Phone:</b> {{ $order->address->phone ?? '-' }}</p>
            </div>
        @else
            <div class="mt-3 p-3 border rounded bg-light text-muted">
                No address assigned for this order.
            </div>
        @endif

        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="my-4">
            @csrf
            <div class="d-flex gap-2 align-items-center">
                <select name="status" class="form-select w-auto">
                    <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped" {{ $order->status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ $order->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button class="btn btn-primary">Update Status</button>
            </div>
        </form>

        <h5 class="mb-3">Order Items</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->title ?? 'Deleted Product' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->qty * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
