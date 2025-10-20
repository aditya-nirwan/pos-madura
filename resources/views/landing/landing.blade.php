<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $setting->brand_name }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('templatelanding/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templatelanding/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('templatelanding/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('templatelanding/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>{{ $setting->address }}</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>{{ $setting->email }}</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <a class="text-body ms-3" href="{{ $setting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href="{{ $setting->twitter }}"><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href="{{ $setting->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href="{{ $setting->instagram }}"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">
                    {!! str_replace(
                        $setting->brand_highlight,
                        '<span class="text-secondary">' . $setting->brand_highlight . '</span>',
                        $setting->brand_name,
                    ) !!}
                </h1>

            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="" class="nav-item nav-link active">Home</a>
                </div>
                <a href="" class="nav-item nav-link">Contact Us</a>
            </div>
            {{-- <div class="d-none d-lg-flex ms-2">
                <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                    <small class="fa fa-search text-body"></small>
                </a>
                <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                    <small class="fa fa-user text-body"></small>
                </a>
                <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                    <small class="fa fa-shopping-bag text-body"></small>
                </a>
            </div> --}}
    </div>
    </nav>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($carousels as $key => $c)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="w-100" src="{{ asset('images/' . $c->image) }}" alt="Image">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-start">
                                    <div class="col-lg-7">
                                        <h1 class="display-2 mb-5 animated slideInDown">{{ $c->title }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Carousel End -->




    <div class="container-fluid bg-light bg-icon my-5 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px;">
                <h1 class="display-5 mb-3">Categories</h1>
                <p>Pilih kategori produk yang tersedia</p>
            </div>
            <div class="row g-4">
                @foreach ($categories as $index => $category)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6 wow fadeInUp"
                        data-wow-delay="{{ 0.1 + $index * 0.2 }}s">
                        <div class="bg-white text-center h-100 p-4 p-xl-5">
                            <h4 class="mb-3">{{ $category->name }}</h4>
                            <p class="mb-4">{{ $category->description ?? 'Kategori ' . $category->name }}</p>
                            <a href="javascript:void(0)"
                                class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill btn-category"
                                data-id="{{ $category->id }}">
                                View Products
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Category End -->


    <!-- Product Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="max-width: 500px;">
                        <h1 class="display-5 mb-3">
                            {{ isset($activeCategory) ? 'Products in ' . $activeCategory->name : 'All Products' }}
                        </h1>
                        <p>Temukan produk terbaik dengan harga terjangkau.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4" id="product-list">
                @forelse($products as $index => $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6 wow fadeInUp"
                        data-wow-delay="{{ 0.1 + $index * 0.2 }}s">
                        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                            <div class="product-item h-100 shadow-sm rounded overflow-hidden">

                                @php
                                    $originalPrice = $product->sell_price + $product->discount_amount;
                                    $discountPercent =
                                        $product->discount_amount > 0
                                            ? round(($product->discount_amount / $originalPrice) * 100)
                                            : 0;
                                @endphp

                                <div class="position-relative d-flex justify-content-center align-items-center"
                                    style="height: 250px;">
                                    <img src="{{ $product->image ? asset('images/' . $product->image) : asset('landing/img/product-1.jpg') }}"
                                        alt="{{ $product->name }}" class="img-fluid"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 12px;">

                                    @if ($discountPercent > 0)
                                        <div
                                            class="bg-danger rounded text-white position-absolute start-0 top-0 m-2 py-1 px-3">
                                            -{{ $discountPercent }}%
                                        </div>
                                    @endif
                                </div>

                                @php
                                    // Hitung diskon
                                    $discount =
                                        $product->discount_type === 'percent'
                                            ? ($product->sell_price * $product->discount_percent) / 100
                                            : $product->discount_amount;

                                    // Hitung pajak
                                    $tax =
                                        $product->tax_type === 'percent'
                                            ? (($product->sell_price - $discount) * $product->tax_percent) / 100
                                            : $product->tax_amount;

                                    // Harga akhir
                                    $finalPrice = $product->sell_price - $discount + $tax;
                                @endphp

                                <div class="text-center p-4">
                                    <h5 class="mb-2">{{ $product->name }}</h5>
                                    <span class="text-primary fw-bold">
                                        Rp{{ number_format($finalPrice, 0, ',', '.') }}
                                    </span>

                                    @if ($discount > 0)
                                        <br>
                                        <small class="text-muted text-decoration-line-through">
                                            Rp{{ number_format($product->sell_price, 0, ',', '.') }}
                                        </small>
                                    @endif
                                </div>

                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center">Produk belum tersedia.</p>
                @endforelse
            </div>

        </div>
    </div>
    <!-- Product End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templatelanding/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('templatelanding/js/main.js') }}"></script>

    <script>
        $(document).on('click', '.btn-category', function() {
            let categoryId = $(this).data('id');

            $.get("{{ url('/categories') }}/" + categoryId + "/products", function(data) {
                let productHtml = '';

                if (data.length > 0) {
                    data.forEach((product, index) => {
                        // Hitung harga asli sebelum diskon
                        let originalPrice = product.discount > 0 ?
                            (product.sell_price / (1 - product.discount / 100)) :
                            product.sell_price;

                        productHtml += `
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6 wow fadeInUp"
                            <a href="{{ url('product') }}/${product.id}" class="text-decoration-none text-dark">
                                <div class="product-item h-100 shadow-sm rounded overflow-hidden">

                                    <div class="position-relative d-flex justify-content-center align-items-center" style="height: 250px;">
                                        <img src="${product.image ? '/images/' + product.image : '{{ asset('landing/img/product-1.jpg') }}'}" 
                                             alt="${product.name}" class="img-fluid"
                                             style="max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 12px;">

                                        ${product.discount > 0 ? `
                                                                                                                                        <div class="bg-danger rounded text-white position-absolute start-0 top-0 m-2 py-1 px-3">
                                                                                                                                            -${product.discount}%
                                                                                                                                        </div>` : ''}
                                    </div>

                                    <div class="text-center p-4">
                                        <h5 class="mb-2">${product.name}</h5>
                                        <span class="text-primary me-1">
                                            Rp${Number(product.sell_price).toLocaleString('id-ID')}
                                        </span>
                                        ${product.discount > 0 ? `
                                                                                                                                        <span class="text-body text-decoration-line-through">
                                                                                                                                            Rp${Number(originalPrice).toLocaleString('id-ID')}
                                                                                                                                        </span>` : ''}
                                    </div>
                                </div>
                            </a>
                        </div>`;
                    });
                } else {
                    productHtml = `<p class="text-center">Produk belum tersedia.</p>`;
                }

                $('#product-list').html(productHtml);
            });
        });
    </script>


</body>

</html>
