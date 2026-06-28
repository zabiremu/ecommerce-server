<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - NF Shop 24</title>
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
        .input-wrap .toggle-pass{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            background:none;
            border:none;
            color:#9ca3af;
            cursor:pointer;
            padding:4px;
            left:auto;
        }
        .input-wrap .toggle-pass:hover{color:#5E2590}

        .form-options{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:24px;
            font-size:13px;
        }
        .remember-me{
            display:flex;
            align-items:center;
            gap:8px;
            color:#374151;
            cursor:pointer;
        }
        .remember-me input{
            width:16px;
            height:16px;
            accent-color:#5E2590;
            cursor:pointer;
        }
        .forgot-link{
            color:#5E2590;
            text-decoration:none;
            font-weight:600;
        }
        .forgot-link:hover{text-decoration:underline}

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
        }
        .btn-login:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 20px -5px rgba(94,37,144,.4);
        }

        .alert{
            padding:12px 14px;
            border-radius:10px;
            font-size:13px;
            margin-bottom:18px;
            display:flex;
            align-items:center;
            gap:8px;
        }
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
        <div class="brand-logo"><i class="fas fa-shield-halved"></i></div>
        <h1>NF Shop 24 Admin</h1>
        <p>Secure administrator access</p>
    </div>

    <div class="admin-login-card">
        <h2>Welcome back</h2>
        <p class="subtitle">Sign in to manage your store</p>

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

        @if (session('expired'))
            <div class="alert alert-error">
                <i class="fas fa-clock-rotate-left"></i>
                <span>{{ session('expired') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off" id="adminLoginForm">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword()">
                        <i class="fas fa-eye" id="togglePassIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>
                <a href="{{ route('admin.forgot-password') }}" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-right-to-bracket"></i>
                Sign In
            </button>
        </form>
    </div>

    <p class="admin-footer-note">
        &copy; {{ date('Y') }} NF Shop 24. <a href="{{ route('home') }}">Back to site</a>
    </p>

</div>

<script>
    function togglePassword(){
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePassIcon');
        if (input.type === 'password'){
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Prevent double-tap on mobile from firing two login submissions —
    // the second request arrives with a now-stale CSRF token (the first
    // request already regenerated the session) and triggers "Page Expired".
    document.getElementById('adminLoginForm').addEventListener('submit', function () {
        var btn = this.querySelector('.btn-login');
        if (btn.disabled) return false;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Signing in...';
    });
</script>

</body>
</html>
