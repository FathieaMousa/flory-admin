@extends('layouts.master')

@section('title', 'Addresses')
@section('page-title', 'Customer Addresses')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">📍All Addresses</h5>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Phone</th>
                    <th>Default?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($addresses as $address)
                    <tr>
                        <td>{{ $address->id }}</td>
                        <td>{{ $address->customer->name ?? 'N/A' }}</td>
                        <td>{{ $address->city }}</td>
                        <td>{{ $address->street }}</td>
                        <td>{{ $address->phone }}</td>

                        {{-- ✅ عرض حالة العنوان الافتراضي --}}
                        <td>
                            @if($address->selected)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('addresses.show', $address->id) }}" class="btn btn-sm btn-primary">View</a>

                            {{-- ✅ زر تعيين العنوان كافتراضي (فقط إن لم يكن افتراضي) --}}
                            @if(!$address->selected)
                                <form action="{{ route('addresses.setDefault', $address->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning" onclick="return confirm('Set this address as default?')">
                                        Set Default
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this address?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $addresses->links() }}
        </div>
    </div>
</div>
@endsection
