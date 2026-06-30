@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Login</span>
    </div>
</section>

<!-- Auth Section -->
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon"><i class="fas fa-user-circle"></i></div>
            <h1>Welcome Back</h1>
            <p>Sign in to your ROVENTEX account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if (session('expired'))
            <div class="alert alert-error">
                <i class="fas fa-clock-rotate-left"></i>
                <span>{{ session('expired') }}</span>
            </div>
        @endif

        <form class="auth-form" id="customerLoginForm" method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="loginEmail"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="loginEmail" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="loginPassword"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrap">
                    <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-pass" onclick="togglePass('loginPassword',this)"><i class="far fa-eye"></i></button>
                </div>
            </div>

            <div class="form-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" value="1" checked> Remember me
                </label>
                <a href="{{ route('forgot-password') }}" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-auth"><i class="fas fa-sign-in-alt"></i> Sign In</button>

            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Create Account</a>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('customerLoginForm').addEventListener('submit', function () {
        var btn = this.querySelector('.btn-auth');
        if (btn.disabled) return false;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Signing in...';
    });
</script>
@endpush
@endsection
