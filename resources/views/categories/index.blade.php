@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Categories</h2>
    <form method="GET" action="{{ route('categories.index') }}" class="mb-3 d-flex" role="search">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search by name">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </form>
    <a href="{{ route('categories.create') }}" class="btn btn-success mb-2">New Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete??')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
