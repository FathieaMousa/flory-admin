@extends('layouts.master')
@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Coupon Code</label>
                <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select">
                        <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Value</label>
                    <input type="number" name="value" step="0.01" class="form-control" value="{{ $coupon->value }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
