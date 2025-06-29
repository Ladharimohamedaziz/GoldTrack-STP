<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome</title>
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
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center transparent-box">
        <img src="{{ asset('GoldTrackWhite.png') }}" alt="Logo" class="img-fluid mb-4" style="max-width: 180px;" />
        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="{{ url('/login') }}" class="btn w-100" style="background-color: #C8AA6E; color: black;">
                <i class="bi bi-lock-fill"></i> Sign In
            </a>
            <a href="{{ route('register.custom') }}" class="btn  w-100" style="background-color: black; color: #C8AA6E;">
                <i class="bi bi-person-plus-fill"></i> Create Account
            </a>
        </div>
    </div>

</body>

</html>