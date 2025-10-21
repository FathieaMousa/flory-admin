@extends('layouts.master')

@section('title', 'Firebase Users')
@section('page-title', 'Firebase Users')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">📋 Registered Users from Firebase</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>UID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Verified</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user['uid'] }}</td>
                        <td>{{ $user['name'] ?? 'N/A' }}</td>
                        <td>{{ $user['email'] ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $user['verified'] == 'Yes' ? 'bg-success' : 'bg-danger' }}">
                                {{ $user['verified'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No users found in Firebase</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
