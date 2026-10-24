
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | StockPilot</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        /* Page background */
        body {
            min-height: 100vh;
            margin: 0;
            padding: 35px 16px;
            background: linear-gradient(135deg, #f1f4ef, #e8eee7);
            font-family: Arial, sans-serif;
            color: #172b23;
        }

        /* StockPilot header */
        .brand {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            margin: 0 auto 10px;
            border-radius: 15px;
            background-color: #214e3b;
            color: #ffffff;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 5px 12px rgba(33, 78, 59, 0.15);
        }

        .brand h1 {
            margin: 0;
            color: #172b23;
            font-size: 29px;
            font-weight: 700;
            letter-spacing: -0.7px;
        }

        .brand p {
            margin: 5px 0 0;
            color: #68756e;
            font-size: 14px;
        }

        /* Registration card */
        .register-card {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 32px;
            background-color: #ffffff;
            border: 1px solid #dce3dc;
            border-radius: 17px;
            box-shadow: 0 15px 40px rgba(24, 53, 39, 0.07);
        }

        /* Card heading */
        .register-heading {
            margin-bottom: 7px;
            color: #172b23;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: -0.4px;
        }

        .register-subtitle {
            margin-bottom: 22px;
            color: #748078;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Original table structure */
        .register-table {
            width: 100%;
            margin-bottom: 0;
            --bs-table-bg: transparent;
        }

        .register-table td {
            padding: 10px 5px;
            border: none;
            vertical-align: middle;
        }

        .register-table td:first-child {
            width: 34%;
        }

        .register-table td:last-child {
            width: 66%;
        }

        /* Form labels */
        .form-label {
            margin-bottom: 0;
            color: #24382e;
            font-size: 13px;
            font-weight: 600;
        }

        /* Input fields */
        .form-control {
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid #d7e0d7;
            border-radius: 9px;
            background-color: #ffffff;
            color: #172b23;
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control::placeholder {
            color: #9aa49d;
        }

        .form-control:focus {
            border-color: #285b43;
            box-shadow: 0 0 0 3px rgba(40, 91, 67, 0.12);
        }

        /* Register button */
        .register-btn {
            min-height: 47px;
            margin-top: 5px;
            border: none;
            border-radius: 9px;
            background-color: #214e3b;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.2s;
        }

        .register-btn:hover {
            background-color: #183d2d;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .register-btn:focus-visible {
            outline: 3px solid rgba(40, 91, 67, 0.3);
            outline-offset: 3px;
        }

        /* Sign-in link */
        .login-link {
            margin: 23px 0 0;
            text-align: center;
            color: #748078;
            font-size: 14px;
        }

        .login-link a {
            color: #214e3b;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Validation messages */
        .alert {
            border-radius: 9px;
            font-size: 14px;
        }

        /* Mobile layout */
        @media (max-width: 576px) {
            body {
                padding: 25px 14px;
            }

            .register-card {
                padding: 25px 16px;
            }

            .brand h1 {
                font-size: 26px;
            }

            .register-heading {
                font-size: 23px;
            }

            .register-table td {
                padding: 9px 3px;
            }

            .form-label {
                font-size: 12px;
            }
        }
        
        /* Password field with Show/Hide button */
        .password-box {
            position: relative;
        }

        .password-box .form-control {
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
    </style>
</head>

<body>

    <!-- StockPilot Header -->
    <header class="brand">
        <div class="brand-icon"><i class="bi bi-box-seam"></i></div>
        <h1>StockPilot</h1>
        <p>Restaurant Inventory Management</p>
    </header>

    <!-- Registration Card -->
    <div class="register-card">

        <h2 class="register-heading">Create your account</h2>

        <p class="register-subtitle">
            Register to get started with your inventory dashboard.
        </p>

        <!-- Display Laravel validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <table class="table table-borderless register-table">

                <!-- First Name -->
                <tr>
                    <td>
                        <label for="F_name" class="form-label">
                            First Name
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            class="form-control"
                            id="F_name"
                            name="F_name"
                            placeholder="Enter First Name"
                            value="{{ old('F_name') }}"
                            autocomplete="given-name"
                            required
                        >
                    </td>
                </tr>

                <!-- Last Name -->
                <tr>
                    <td>
                        <label for="L_name" class="form-label">
                            Last Name
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            class="form-control"
                            id="L_name"
                            name="L_name"
                            placeholder="Enter Last Name"
                            value="{{ old('L_name') }}"
                            autocomplete="family-name"
                            required
                        >
                    </td>
                </tr>

                <!-- Email -->
                <tr>
                    <td>
                        <label for="email" class="form-label">
                            Email
                        </label>
                    </td>
                    <td>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Enter Email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                    </td>
                </tr>

                
                <!-- Password -->
                <tr>
                    <td>
                        <label for="password" class="form-label">
                            Password
                        </label>
                    </td>
                    <td>
                        <div class="password-box">
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Enter Password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="show-password"
                                id="togglePassword"
                            >Show</button>
                        </div>
                    </td>
                </tr>



                <!-- Confirm Password -->
                <tr>
                    <td>
                        <label for="password_confirmation" class="form-label">
                            Confirm Password
                        </label>
                    </td>
                    <td>
                        <div class="password-box">
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="show-password"
                                id="toggleConfirmPassword"
                            >Show</button>
                        </div>
                    </td>
                </tr>

                <!-- Submit Button -->
                <tr>
                    <td></td>
                    <td>
                        <button
                            type="submit"
                            class="btn register-btn w-100"
                        >
                            Create account
                        </button>
                    </td>
                </tr>

            </table>
        </form>

        <!-- Link to Login Page -->
        <p class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Sign in</a>
        </p>

    </div>
 
    <script>
        function setupPasswordToggle(inputId, buttonId) {
            const password = document.getElementById(inputId);
            const toggle = document.getElementById(buttonId);

            toggle.addEventListener('click', function () {
                if (password.type === 'password') {
                    password.type = 'text';
                    toggle.textContent = 'Hide';
                } else {
                    password.type = 'password';
                    toggle.textContent = 'Show';
                }
            });
        }

        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle(
            'password_confirmation',
            'toggleConfirmPassword'
        );
    </script>
</body>
</html>

