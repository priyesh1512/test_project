@extends('layouts.app')

@section('content')
    <h1>User Details</h1>
    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Created At:</strong> {{ $user->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $user->updated_at }}</p>
        </div>
    </div>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning mt-3">Edit User</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
@endsection