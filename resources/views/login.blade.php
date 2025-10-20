{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="" type="image/x-icon">
    <link href="{{ asset('templatelogin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templatelogin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4e73df, #224abe);
            font-family: 'Nunito', sans-serif;
        }

        .login-card {
            max-width: 450px;
            margin: auto;
            margin-top: 8%;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        .login-card .card-body {
            padding: 3rem;
        }

        .brand-logo {
            width: 60px;
            height: 20px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}
                <button type="button" class="close text-white align-items-center" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}
                <button type="button" class="close text-white align-items-center" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card login-card">
            <div class="card-body text-center">
                {{-- <img src="{{ asset('assets/images/double-box.png') }}" alt="Logo" class="brand-logo"> --}}
                <h3 class="text-gray-900 mb-4">Login User</h3>

                @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close text-white align-items-center" data-dismiss="alert">&times;</button>
    </div>
@endif


                <form method="POST" action="{{ url('login') }}">
                    @csrf
                    <div class="form-group text-left">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group text-left">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                            required>
                    </div>
                    <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('templatelogin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templatelogin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templatelogin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('templatelogin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
