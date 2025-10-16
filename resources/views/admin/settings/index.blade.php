@extends('layouts.master')
@section('title', 'Settings')
@section('page-title', 'Application Settings')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">General Settings</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">App Name</label>
                    <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $settings->app_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $settings->address) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if($settings->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" width="100" class="mt-2 rounded">
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label">Favicon</label>
                    <input type="file" name="favicon" class="form-control">
                    @if($settings->favicon)
                        <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" width="50" class="mt-2 rounded">
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save Changes</button>
        </form>
    </div>
</div>
@endsection
