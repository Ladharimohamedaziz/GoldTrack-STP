<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            /* height: 100%; */
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

        input::placeholder {
            color: #ccc;
            opacity: 1;
        }

        .btn-white {
            background-color: aliceblue;
            color: black;
        }

        .btn-grey {
            background-color: grey;
            color: white;
        }

        .btn-white:hover {
            background-color: #f0f0f0;
            color: black;
        }

        .btn-grey:hover {
            background-color: #555;
            color: white;
        }

        .login-sectionx {
            color: white;
            width: 100%;
            background: none;
            border: none;
            border-bottom: 2px solid white;
        }

        .login-sectionx::placeholder {
            color: #ccc;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center ">
        <div class="transparent-box text-center">
            <img src="{{ asset('GoldTrackWhite.png') }}" alt="Logo" class="img-fluid mb-4" style="max-width: 180px;" />
            <form method="POST" action="{{ route('register.custom') }}" enctype="multipart/form-data">

                @csrf
                <div class="mb-3">
                    <input type="text" name="first_name" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="First Name" required />
                </div>
                <div class="mb-3">
                    <input type="text" name="last_name" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="Last Name" required />
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="Email" required />
                </div>
                <div class="mb-3">
                    <input type="tel" name="phone" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="Phone" required />
                </div>
                <div class="mb-3">
                    <input type="date" name="dob" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="Date of Birth" required />
                </div>
                <div class="mb-3">
                    <input type="file" name="profile_image" class="form-control bg-transparent border-bottom login-sectionx text-white" accept="image/*" />
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control bg-transparent border-bottom login-sectionx text-white" placeholder="Password" required />
                </div>
                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control bg-transparent border-bottom  login-sectionx text-white" placeholder="Confirm Password" required />
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-white p-2">Register</button>
                    <button type="button" class="btn btn-grey p-2"><i class="bi bi-google"></i> Sign Up with Google</button>
                    <div class="text-center mt-3">
                        <p class="text-white">
                            <a href="{{ url('/login') }}"><i class="bi bi-arrow-left"></i> Back to Login</a>
                            <a href="{{ url('/') }}"><i class="bi bi-house"></i> Back to Home</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>