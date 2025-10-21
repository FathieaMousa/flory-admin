@extends('layouts.master')

@section('title', 'Address Details')
@section('page-title', 'Address #' . $address->id)

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">📍 Address Information</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- ✅ معلومات العميل -->
            <div class="col-md-6">
                <h6 class="text-secondary">👤 Customer Info</h6>
                <p><strong>Name:</strong> {{ $address->customer->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $address->customer->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $address->phone ?? 'N/A' }}</p>
            </div>

            <!-- ✅ تفاصيل العنوان -->
            <div class="col-md-6">
                <h6 class="text-secondary">🏠 Address Details</h6>
                <p><strong>Street:</strong> {{ $address->street }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>State/Region:</strong> {{ $address->state }}</p>
                <p><strong>Postal Code:</strong> {{ $address->postal_code }}</p>
                <p><strong>Country:</strong> {{ $address->country }}</p>

                <p>
                    <strong>Default Address:</strong>
                    @if($address->selected)
                        <span class="badge bg-success">Yes ✅</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary">
            ← Back to Addresses
        </a>

        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST">
            @csrf @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this address?')">
                🗑 Delete Address
            </button>
        </form>
    </div>
</div>
@endsection
