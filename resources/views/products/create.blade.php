<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- HEADER / NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Product Manager</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Add New Product</h2>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">← Back to Products</a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm rounded bg-light">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Product Name : <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label fw-semibold">Price (₹) : <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price" value="{{ old('price') }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <table class="table table-bordered p-3" id="dynamicBannerImageTable">
                <thead>
                    <tr>
                        <th>Upload Product Image  : <span class="text-danger">*</span></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="col-sm-12 col-md-12">
                                <div id="banner-container-0">
                                    <div id="file-banner-0"></div>
                                </div>
                                <input type="file" onchange="imagePreviewFiles(0)" accept=".png, .jpg, .jpeg" name="images[]" id="images_0" class="form-control @error('images.*') is-invalid @enderror" required>
                                    <small class="text-secondary"><b>Note : The file size should be less than 2MB.</b></small>
                                <br>
                                <small class="text-secondary"><b>Note : Only files in .jpg, .jpeg, .png format can be uploaded .</b></small>
                                <br>
                                @error('images.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" id="addBannerImageRow">Add More</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Save Product</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (needed for add/remove image row) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {
            let rowId = 0;

            // Restore old inputs if validation fails
            let oldBannerImages = @json(old('images', []));
            oldBannerImages.forEach(function(_, index) {
                if (index > 0) {
                    rowId++;
                    $('#addBannerImageRow').click(); // Simulates adding a new row
                }
            });

            // Add a new row with validation
            $('#addBannerImageRow').click(function() {
                rowId++;
                var newRow = `<tr>
                <td>
                    <div class="col-sm-12 col-md-12">
                        <div id="banner-container-${rowId}">
                            <div id="file-banner-${rowId}"></div>
                        </div>
                        <input type="file" onchange="imagePreviewFiles(${rowId})" accept=".png, .jpg, .jpeg" name="images[]" id="images_${rowId}" class="form-control @error('images.*') is-invalid @enderror">
                        <small class="text-secondary"><b>Note : The file size  should be less than 2MB .</b></small>
                        <br>
                        <small class="text-secondary"><b>Note : Only files in .jpg, .jpeg, .png format can be uploaded .</b></small>
                        <br>
                        @error('images.${rowId}')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </td>
                <td><button type="button" class="btn btn-danger removeBannerImageRow">Remove</button></td>
            </tr>`;
                $('#dynamicBannerImageTable tbody').append(newRow);
            });

            // Remove a row
            $(document).on('click', '.removeBannerImageRow', function() {
                $(this).closest('tr').remove();
            });
        });


    </script>
</body>

</html>

