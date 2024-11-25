@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $hotel->name }}</h1>
    <p><strong>Location:</strong> {{ $hotel->location }}</p>
    <p><strong>Price per Night:</strong> ${{ number_format($hotel->price, 2) }}</p>
    {{-- Add other details if necessary --}}
    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this hotel?')">Delete</button>
    </form>
    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">Back to Hotels</a>
</div>
@endsection