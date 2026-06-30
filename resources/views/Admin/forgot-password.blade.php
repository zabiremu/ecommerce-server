<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - ROVENTEX Admin</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome-all.min.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Inter',system-ui,-apple-system,sans-serif;
            min-height:100vh;
            background:linear-gradient(135deg,#2D1B69 0%,#5E2590 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            color:#1f2937;
        }

        .admin-login-wrap{
            width:100%;
            max-width:440px;
        }

        .admin-brand{
            text-align:center;
            margin-bottom:24px;
        }
        .admin-brand .brand-logo{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:64px;
            height:64px;
            border-radius:16px;
            background:rgba(255,255,255,.1);
            backdrop-filter:blur(10px);
            margin-bottom:16px;
            color:#fbbf24;
            font-size:28px;
        }
        .admin-brand h1{
            color:#fff;
            font-size:24px;
            font-weight:700;
            letter-spacing:.5px;
        }
        .admin-brand p{
            color:rgba(255,255,255,.6);
            font-size:14px;
            margin-top:4px;
        }

        .admin-login-card{
            background:#fff;
            border-radius:16px;
            padding:40px 32px;
            box-shadow:0 25px 50px -12px rgba(0,0,0,.25);
        }
        .admin-login-card h2{
            font-size:22px;
            font-weight:700;
            color:#111827;
            margin-bottom:6px;
        }
        .admin-login-card .subtitle{
            color:#6b7280;
            font-size:14px;
            margin-bottom:28px;
            line-height:1.5;
        }

        .form-group{margin-bottom:18px}
        .form-group label{
            display:block;
            font-size:13px;
            font-weight:600;
            color:#374151;
            margin-bottom:8px;
        }
        .input-wrap{
            position:relative;
        }
        .input-wrap i{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            color:#9ca3af;
            font-size:14px;
        }
        .input-wrap input{
            width:100%;
            padding:12px 14px 12px 42px;
            border:1.5px solid #e5e7eb;
            border-radius:10px;
            font-size:14px;
            background:#f9fafb;
            transition:all .2s ease;
            font-family:inherit;
        }
        .input-wrap input:focus{
            outline:none;
            border-color:#5E2590;
            background:#fff;
            box-shadow:0 0 0 3px rgba(94,37,144,.1);
        }

        .btn-login{
            width:100%;
            padding:13px;
            background:linear-gradient(135deg,#2D1B69,#5E2590);
            color:#fff;
            border:none;
            border-radius:10px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
            transition:all .2s ease;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            font-family:inherit;
            margin-top:8px;
        }
        .btn-login:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 20px -5px rgba(94,37,144,.4);
        }

        .back-to-login{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:6px;
            margin-top:20px;
            color:#5E2590;
            text-decoration:none;
            font-size:14px;
            font-weight:600;
        }
        .back-to-login:hover{text-decoration:underline}

        .alert{
            padding:12px 14px;
            border-radius:10px;
            font-size:13px;
            margin-bottom:18px;
            display:flex;
            align-items:flex-start;
            gap:8px;
            line-height:1.5;
        }
        .alert i{margin-top:2px;flex-shrink:0}
        .alert-error{
            background:#fef2f2;
            color:#b91c1c;
            border:1px solid #fecaca;
        }
        .alert-success{
            background:#f0fdf4;
            color:#15803d;
            border:1px solid #bbf7d0;
        }
        .alert-info{
            background:#eff6ff;
            color:#1d4ed8;
            border:1px solid #bfdbfe;
        }

        .admin-footer-note{
            text-align:center;
            color:rgba(255,255,255,.5);
            font-size:12px;
            margin-top:24px;
        }
        .admin-footer-note a{
            color:rgba(255,255,255,.8);
            text-decoration:none;
        }
        .admin-footer-note a:hover{text-decoration:underline}

        @media (max-width:480px){
            .admin-login-card{padding:32px 24px}
            .admin-brand h1{font-size:20px}
        }
    </style>
</head>
<body>

<div class="admin-login-wrap">

    <div class="admin-brand">
        <div class="brand-logo"><i class="fas fa-key"></i></div>
        <h1>Forgot Password?</h1>
        <p>We'll help you recover your account</p>
    </div>

    <div class="admin-login-card">
        <h2>Reset your password</h2>
        <p class="subtitle">Enter your registered email address and we'll send you a link to reset your password.</p>

        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.forgot-password.submit') }}" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-paper-plane"></i>
                Send Reset Link
            </button>
        </form>

        <a href="{{ route('admin.login') }}" class="back-to-login">
            <i class="fas fa-arrow-left"></i>
            Back to login
        </a>
    </div>

    <p class="admin-footer-note">
        &copy; {{ date('Y') }} ROVENTEX. <a href="{{ route('home') }}">Back to site</a>
    </p>

</div>

</body>
</html>
