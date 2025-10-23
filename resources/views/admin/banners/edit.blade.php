@extends('layouts.master')
@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')

@section('content')
<div class="card shadow-sm p-4">
    <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ $banner->title }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="{{ asset('storage/'.$banner->image) }}" width="150" class="rounded mb-3">
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="text" name="link" class="form-control" value="{{ $banner->link }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ $banner->is_active ? 'selected' : '' }}>Active ✅</option>
                <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>Inactive ❌</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update </button>
    </form>
</div>
@endsection
