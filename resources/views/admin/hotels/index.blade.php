@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div class="d-flex justify-content-between mb-3">
        <h1 style="color: #2c3e50;">Hotels</h1>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary" style="background-color: #3498db; border: none; padding: 10px 20px;">Add New Hotel</a>
    </div>

    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        {{-- Search and Filter Form --}}
        <form method="GET" action="{{ route('admin.hotels.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price_min" class="form-control" placeholder="Min Price" value="{{ request('price_min') }}">
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price_max" class="form-control" placeholder="Max Price" value="{{ request('price_max') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary">Search</button>
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-link">Clear</a>
                </div>
            </div>
        </form>

        @if($hotels->count())
            <table class="table table-bordered" style="background-color: #fff;">
                <thead style="background-color: #34495e; color: #fff;">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Price per Night</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hotels as $hotel)
                        <tr style="transition: background-color 0.3s;">
                            <td>{{ $hotel->id }}</td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->location }}</td>
                            <td>${{ number_format($hotel->price, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-sm btn-warning" style="margin-right: 5px;">Edit</a>
                                <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-sm btn-info" style="margin-right: 5px;">View</a>
                                <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="background-color: #e74c3c; border: none;">Delete</button>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection