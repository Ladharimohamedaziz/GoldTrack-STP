<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-image: url("{{ asset('background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .transparent-box {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.07);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            margin: auto;
            color: white;
        }

        input.form-control {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
        }

        input.form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            box-shadow: none;
            border: none;
        }

        .btn-custom {
            background-color: #C8AA6E;
            color: black;
        }

        .btn-custom:hover {
            background-color: #b79757;
            color: black;
        }

        .btn-custom-alt {
            background-color: black;
            color: #C8AA6E;
        }

        .btn-custom-alt:hover {
            background-color: #333;
            color: #d3b978;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="transparent-box text-center">
        <img src="{{ asset('GoldTrackWhite.png') }}" alt="Logo" class="img-fluid mb-4" style="max-width: 180px;" />
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus />
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>

            <button type="submit" class="btn btn-custom w-100 mb-3">
                <i class="bi bi-lock-fill"></i> Login
            </button>

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>

        <a href="{{ route('register.custom') }}" class="btn btn-custom-alt w-100">
            <i class="bi bi-person-plus-fill"></i> Create Account
        </a>
    </div>
</body>

</html>
