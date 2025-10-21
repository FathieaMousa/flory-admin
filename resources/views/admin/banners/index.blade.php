@extends('layouts.master')

@section('title', 'Manage Banners')
@section('page-title', 'Banners')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Banner List</h5>
        <a href="{{ route('banners.create') }}" class="btn btn-primary"> <i class="bi bi-plus-circle me-1"></i> Add Banner</a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$banner->image) }}" width="80">
                        </td>
                        <td>{{ $banner->title ?? '---' }}</td>
                        <td>
                            <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-primary btn-sm">✏ Edit</a>
                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this banner?')">🗑 Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No banners found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">{{ $banners->links() }}</div>
    </div>
</div>
@endsection
