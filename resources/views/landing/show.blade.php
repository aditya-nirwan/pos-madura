<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $product->name }}</title>
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
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Section Produk di luar fixed-top -->
    <section class="py-5 bg-light" style="margin-top: 120px;">
        <div class="container">
            <div class="row g-5 align-items-start">
                <!-- Foto Produk -->
                <div class="col-lg-6">
                    <div class="position-relative bg-white p-4 rounded-4 shadow-sm text-center">
                        <img src="{{ $product->image ? asset('images/' . $product->image) : asset('templatelanding/img/product-1.jpg') }}"
                            alt="{{ $product->name }}" class="img-fluid rounded-3 product-img"
                            style="max-height: 250px; object-fit: contain; width: 100%;">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex flex-column h-100">
                        <h2 class="fw-bold mb-3 text-primary">{{ $product->name }}</h2>
                        <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                            <h5 class="fw-semibold mb-3 text-dark">Deskripsi Produk</h5>
                            <p class="mb-0" style="line-height: 1.7; white-space: pre-line;">
                                {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                            </p>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('landing') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templatelanding/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('templatelanding/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('templatelanding/js/main.js') }}"></script>

</body>

</html>
