@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Top 10 Products by Exits</h1>

    <canvas id="topExitsChart" width="400" height="200"></canvas>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('topExitsChart').getContext('2d');

    const products = @json($products->pluck('name'));
    const quantities = @json($products->pluck('exits_count'));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: products,
            datasets: [{
                label: 'Quantity Exited',
                data: quantities,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
@endsection
