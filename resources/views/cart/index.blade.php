<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cart Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & DataTables --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    {{-- Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Cart Overview</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                        href="{{ route('cart.index') }}">
                            Cart
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Cart Items (Products)</h2>
        </div>

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">Cart is empty.</div>
        @else
            <div class="table-responsive">
                <table id="cartTable" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                                <td>
                                    @if ($item->product && $item->product->images->count())
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($item->product->images as $image)
                                                <img src="{{ asset($image->image_path) }}"
                                                    alt="Product Image"
                                                    width="60" height="60"
                                                    style="object-fit: cover; border-radius: 4px;">
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>₹{{ number_format($item->product->price ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Footer Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#cartTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });
        });
    </script>
</body>

</html>
