<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Control</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        footer {
            margin-top: 40px;
            padding: 15px 0;
            text-align: center;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Stock Control</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('movements.index') }}">Movements</a></li>
                </ul>
            </div>
            <div class="ms-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('error'))
        <!-- Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

        <script>
            var myModal = new bootstrap.Modal(document.getElementById('errorModal'))
            myModal.show();
        </script>
        @endif
        @yield('content')
        @yield('scripts')

    </main>

    <footer>
        <p>Stock Control System © {{ date('Y') }}</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
