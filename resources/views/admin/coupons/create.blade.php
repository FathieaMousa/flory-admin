@extends('layouts.master')
@section('title', 'Add Coupon')
@section('page-title', 'Create New Coupon')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('coupons.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Coupon Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Value</label>
                    <input type="number" name="value" step="0.01" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
