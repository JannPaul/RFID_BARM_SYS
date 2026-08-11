<!DOCTYPE html>
<html lang="en">
<head>   
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RFID BARM Login</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        .login-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 60px;

            /*
            Add your background image later:

            background-image:
                linear-gradient(
                    rgba(238, 162, 185, 0.55),
                    rgba(217, 93, 145, 0.62)
                ),
                url('{{ asset("images/login-background.jpg") }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            */

            background:
                radial-gradient(
                    circle at 25% 55%,
                    rgba(255, 255, 255, 0.28),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #e9d8e5 0%,
                    #e7b9cc 45%,
                    #d988aa 100%
                );
        }

        .login-page::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 190, 210, 0.16);
            pointer-events: none;
        }

        .page-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1600px;
        }

        .left-section {
            min-height: 650px;
            display: flex;
            align-items: flex-end;
            padding: 40px;
        }

        .school-message {
            color: #ffffff;
            text-shadow: 0 4px 18px rgba(95, 30, 65, 0.3);
        }

        .school-message h1 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(3.8rem, 7vw, 7.3rem);
            font-style: italic;
            font-weight: 700;
            line-height: 0.95;
            letter-spacing: -4px;
        }

        .message-line {
            display: block;
        }

        .established {
            margin-top: 28px;
            margin-left: 95px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 13px;
            text-transform: lowercase;
        }

        .login-card-section {
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 42px 38px;
            border: 1px solid rgba(255, 255, 255, 0.58);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.64);
            box-shadow: 0 22px 55px rgba(93, 36, 67, 0.22);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
        }

        .logo-placeholder {
            width: 105px;
            height: 105px;
            margin: 0 auto 18px;
            border: 3px solid #d83c82;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d83c82;
            background: rgba(255, 255, 255, 0.72);
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
        }

        .login-title {
            margin-bottom: 30px;
            color: #303030;
            font-size: 2rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-align: center;
        }

        .form-group-custom {
            position: relative;
            margin-bottom: 18px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 17px;
            z-index: 2;
            color: #888888;
            font-size: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .form-control.login-input {
            height: 52px;
            padding: 10px 48px;
            border: 1px solid rgba(215, 215, 215, 0.95);
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.93);
            color: #333333;
            font-size: 0.95rem;
            box-shadow: none;
        }

        .form-control.login-input:focus {
            border-color: #d84f8e;
            background: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(216, 79, 142, 0.15);
        }

        .form-control.login-input::placeholder {
            color: #8a8a8a;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: 48px;
            background-image: none;
        }

        .password-input {
            padding-right: 52px !important;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 17px;
            z-index: 3;
            border: 0;
            padding: 0;
            color: #888888;
            background: transparent;
            font-size: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #d83c82;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 22px;
            font-size: 0.85rem;
        }

        .form-check-input:checked {
            border-color: #d83c82;
            background-color: #d83c82;
        }

        .form-check-input:focus {
            border-color: #d83c82;
            box-shadow: 0 0 0 0.2rem rgba(216, 60, 130, 0.15);
        }

        .forgot-password {
            color: #b72e6e;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #8d1f55;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            height: 51px;
            border: none;
            border-radius: 7px;
            background: #2e8737;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }

        .login-button:hover {
            background: #246f2d;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .alert {
            font-size: 0.88rem;
            text-align: left;
        }

        .invalid-feedback {
            margin-top: 6px;
            font-size: 0.8rem;
            text-align: left;
        }

        @media (max-width: 991.98px) {
            .login-page {
                padding: 35px 20px;
            }

            .left-section {
                min-height: auto;
                justify-content: center;
                padding: 20px 10px 45px;
                text-align: center;
            }

            .school-message h1 {
                font-size: clamp(3rem, 13vw, 5.7rem);
                letter-spacing: -2px;
            }

            .established {
                margin-left: 0;
                letter-spacing: 8px;
            }

            .login-card-section {
                min-height: auto;
            }
        }

        @media (max-width: 575.98px) {
            .login-page {
                padding: 25px 15px;
            }

            .left-section {
                padding-bottom: 30px;
            }

            .school-message h1 {
                letter-spacing: -1px;
            }

            .established {
                font-size: 0.8rem;
                letter-spacing: 5px;
            }

            .login-card {
                padding: 32px 22px;
                border-radius: 17px;
            }

            .logo-placeholder {
                width: 88px;
                height: 88px;
            }

            .login-title {
                font-size: 1.55rem;
            }

            .form-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

<section class="login-page">
    <div class="page-content">
        <div class="row align-items-center">

            <!-- Left side -->
            <div class="col-lg-7">
                <div class="left-section">
                    <div class="school-message">
                        <h1>
                            <span class="message-line">Faith.</span>
                            <span class="message-line">Excellence.</span>
                            <span class="message-line">Service.</span>
                        </h1>

                        <div class="established">
                            est. 1928
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login card -->
            <div class="col-lg-5">
                <div class="login-card-section">
                    <div class="login-card">

                        <!-- Replace this with your logo later -->
                        <div class="logo-placeholder">
                            SCHOOL<br>
                            LOGO
                        </div>

                        <!-- Example logo code:
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="School Logo"
                            class="d-block mx-auto mb-3"
                            style="width: 105px; height: 105px; object-fit: contain;"
                        >
                        -->

                        <h2 class="login-title">
                            RFID BARM LOGIN
                        </h2>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form
    action="{{ route('login.authenticate') }}"
    method="POST"
>
    @csrf

    <!-- Employee ID -->
    <div class="form-group-custom">
        <i class="bi bi-person-circle input-icon"></i>

        <input
            type="text"
            name="employeeid"
            id="employeeid"
            class="form-control login-input @error('employeeid') is-invalid @enderror"
            placeholder="Employee ID Number"
            value="{{ old('employeeid') }}"
            autocomplete="username"
            required
            autofocus
        >

        @error('employeeid')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group-custom">
        <i class="bi bi-lock-fill input-icon"></i>

        <input
            type="password"
            name="password"
            id="password"
            class="form-control login-input password-input @error('password') is-invalid @enderror"
            placeholder="Password"
            autocomplete="current-password"
            required
        >

        <button
            type="button"
            class="password-toggle"
            id="togglePassword"
            aria-label="Show or hide password"
        >
            <i class="bi bi-eye" id="passwordIcon"></i>
        </button>

        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Remember me -->
    <div class="form-options">
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember"
                value="1"
                {{ old('remember') ? 'checked' : '' }}
            >

            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>
    </div>

    <!-- Login button -->
    <button type="submit" class="btn login-button">
        <i class="bi bi-box-arrow-in-right me-2"></i>
        LOG IN
    </button>
</form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        if (togglePassword && passwordInput && passwordIcon) {
            togglePassword.addEventListener('click', function () {
                const passwordIsHidden =
                    passwordInput.getAttribute('type') === 'password';

                passwordInput.setAttribute(
                    'type',
                    passwordIsHidden ? 'text' : 'password'
                );

                passwordIcon.classList.toggle(
                    'bi-eye',
                    !passwordIsHidden
                );

                passwordIcon.classList.toggle(
                    'bi-eye-slash',
                    passwordIsHidden
                );
            });
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>