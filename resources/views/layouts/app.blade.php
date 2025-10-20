<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/logo.png') }}">

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #preloader {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .96);
            /* gelap; ganti ke #fff utk light */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity .3s ease;
        }

        #preloader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .preloader-inner {
            text-align: center;
            color: #cbd5e1;
        }

        .preloader-logo {
            height: 42px;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, .35));
        }

        /* Pulse (opsional jika pakai logo) */
        .pulse {
            width: 16px;
            height: 16px;
            margin: 14px auto 0;
            border-radius: 50%;
            background: #60a5fa;
            animation: pulse 1s infinite ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(.9);
                opacity: .6
            }

            50% {
                transform: scale(1.15);
                opacity: 1
            }
        }
    </style>

</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main-panel">
            @include('layouts.header')

            <div class="content">
                <div class="inner-content mt-4">
                    <div class="main-body">

                        <div class="container-fluid py-6" style="padding-top: 70px;">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Preloader --}}
    @include('layouts.preloader')

    @include('layouts.footer')
</body>


</html>
