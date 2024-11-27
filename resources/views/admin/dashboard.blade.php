@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="mb-3">
        <a href="{{ route('admin.hotels.index') }}" class="btn btn-primary">Manage Hotels</a>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-success">Add New Hotel</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Manage Bookings</a>
    </div>
</div>
@endsection