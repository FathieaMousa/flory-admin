@extends('layouts.master')
@section('title', 'Add Banner')
@section('page-title', 'Add New Banner')

@section('content')
<div class="card shadow-sm p-4">
    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title (optional)</label>
            <input type="text" name="title" class="form-control" placeholder="Banner title...">
        </div>

        <div class="mb-3">
            <label class="form-label">Banner Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Link (optional)</label>
            <input type="text" name="link" class="form-control" placeholder="https://example.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Active?</label>
            <select name="is_active" class="form-control">
                <option value="1" selected>Active ✅</option>
                <option value="0">Inactive ❌</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Banner ✅</button>
    </form>
</div>
@endsection
