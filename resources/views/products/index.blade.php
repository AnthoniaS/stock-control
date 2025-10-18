@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Products</h2>
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success mb-2">New Product</a>
        <a href="{{ route('report.stock') }}" class="btn btn-secondary mb-2">Stock Report</a>
        <a href="{{ route('report.topExits') }}" class="btn btn-secondary mb-2">Top 10 Exits</a>
    </div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Photo</th>
                <th>SKU</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Expiration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->photo)
                        <img src="{{ asset('storage/products/' . $product->photo) }}" alt="{{ $product->name }}" width="60">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->expiration_date ?? '-' }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
