@extends('Frontend.Layout.app')

@section('content')
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('login') }}">Login</a>
        <i class="fas fa-chevron-right"></i>
        <span>Forgot Password</span>
    </div>
</section>

<section class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon"><i class="fas fa-key"></i></div>
            <h1>Forgot Password?</h1>
            <p>Enter your email and we'll send you a reset link</p>
        </div>

        <form class="auth-form" onsubmit="return handleForgot(event)">
            <div class="form-group">
                <label for="forgotEmail"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="forgotEmail" placeholder="Enter your registered email" required>
            </div>

            <button type="submit" class="btn-auth"><i class="fas fa-paper-plane"></i> Send Reset Link</button>

            <div class="auth-footer">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </form>

        <div class="auth-success" id="forgotSuccess" style="display:none">
            <div class="success-icon"><i class="fas fa-check-circle"></i></div>
            <h3>Email Sent!</h3>
            <p>We've sent a password reset link to <strong id="forgotSentEmail">your email</strong>. Please check your inbox and follow the instructions.</p>
            <p style="font-size:12px;color:#94a3b8;margin-top:6px">Didn't receive the email? Check your spam folder or <a href="#" onclick="document.getElementById('forgotSuccess').style.display='none';document.querySelector('.auth-form').style.display='flex';return false" style="color:var(--secondary);font-weight:600;text-decoration:none">try again</a>.</p>
            <a href="{{ route('login') }}" class="btn-auth" style="text-decoration:none;margin-top:18px;display:inline-flex"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>
    </div>
</section>
@endsection
