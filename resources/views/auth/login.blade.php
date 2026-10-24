
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Sign In | StockPilot</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #f2f5f1;
            color: #203328;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            background: #234b38;
            color: white;
            border-radius: 14px;
            font-size: 27px;
            font-weight: bold;
        }

        .brand h1 {
            font-size: 28px;
            letter-spacing: -1px;
        }

        .brand p {
            margin-top: 8px;
            color: #77847a;
            font-size: 13px;
        }

        .login-card {
            padding: 32px;
            background: white;
            border: 1px solid #e1e7e0;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(30, 50, 38, 0.06);
        }

        .login-card h2 {
            font-size: 23px;
            margin-bottom: 9px;
        }

        .intro {
            color: #7b857e;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 27px;
        }

        .form-group {
            margin-bottom: 21px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce3dc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #315d43;
            box-shadow: 0 0 0 3px rgba(49, 93, 67, 0.1);
        }

        .password-box {
            position: relative;
        }

        .password-box input {
            padding-right: 65px;
        }

        .show-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #315d43;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #667168;
            font-size: 13px;
            margin: 2px 0 24px;
        }

        .remember input {
            accent-color: #315d43;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #234b38;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background: #193b2a;
        }

        
        .create-account-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 12px;
            padding: 13px;
            border: 1px solid #234b38;
            border-radius: 8px;
            background: #ffffff;
            color: #234b38;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .create-account-btn:hover {
            background: #234b38;
            color: #ffffff;
        }

        .create-account-btn span {
            transition: transform 0.2s;
        }

        .create-account-btn:hover span {
            transform: translateX(4px);
        }

        .error-message {
            padding: 12px;
            margin-bottom: 20px;
            background: #fff0f0;
            border-radius: 8px;
            color: #b32d2d;
            font-size: 13px;
        }

        .field-error {
            color: #b32d2d;
            font-size: 12px;
            margin-top: 7px;
        }

        footer {
            text-align: center;
            color: #8a948b;
            font-size: 12px;
            margin-top: 24px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 24px;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">

        <header class="brand">
            <div class="brand-icon"><i class="bi bi-box-seam"></i></div>
            <h1>StockPilot</h1>
            <p>Restaurant Inventory Management</p>
        </header>

        <section class="login-card">
            <h2>Welcome back</h2>

            <p class="intro">
                Sign in to access your inventory dashboard.
            </p>

            @if ($errors->any())
                <div class="error-message" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="password-box">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="show-password"
                            id="togglePassword"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <label class="remember">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >
                    Remember me
                </label>

                <button type="submit" class="submit-btn">
                    Sign in
                </button>
                
                <a href="{{ route('register') }}" class="create-account-btn">
                    Create an account
                    <span aria-hidden="true">&rarr;</span>
                </a>

            </form>
        </section>

        <footer>
            &copy; {{ date('Y') }} StockPilot. All rights reserved.
        </footer>

    </main>

    <script>
        const password = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');

        toggle.addEventListener('click', function () {
            if (password.type === 'password') {
                password.type = 'text';
                toggle.textContent = 'Hide';
            } else {
                password.type = 'password';
                toggle.textContent = 'Show';
            }
        });
    </script>
</body>
</html>
