@extends('Frontend.Layout.app')

@section('content')
<section class="breadcrumb">
        <div class="container">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('login') }}">Login</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('forgot-password') }}">Forgot Password</a>
            <i class="fas fa-chevron-right"></i>
            <span>Reset Password</span>
        </div>
    </section>

    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon"><i class="fas fa-lock-open"></i></div>
                <h1>Reset Password</h1>
                <p>Choose a strong password for your account</p>
            </div>

            <form class="auth-form" onsubmit="return handleReset(event)">
                <div class="form-group">
                    <label for="resetPass"><i class="fas fa-lock"></i> New Password</label>
                    <div class="password-wrap">
                        <input type="password" id="resetPass" placeholder="At least 6 characters" required
                            minlength="6">
                        <button type="button" class="toggle-pass" onclick="togglePass('resetPass',this)"><i
                                class="far fa-eye"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="resetConfirm"><i class="fas fa-check-circle"></i> Confirm Password</label>
                    <div class="password-wrap">
                        <input type="password" id="resetConfirm" placeholder="Re-enter new password" required>
                        <button type="button" class="toggle-pass" onclick="togglePass('resetConfirm',this)"><i
                                class="far fa-eye"></i></button>
                    </div>
                </div>

                <div class="password-hints" id="passHints">
                    <span id="phLength"><i class="far fa-circle"></i> At least 6 characters</span>
                    <span id="phMatch"><i class="far fa-circle"></i> Passwords match</span>
                </div>

                <button type="submit" class="btn-auth"><i class="fas fa-check"></i> Reset Password</button>

                <div class="auth-footer">
                    <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            </form>

            <div class="auth-success" id="resetSuccess" style="display:none">
                <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                <h3>Password Reset!</h3>
                <p>Your password has been updated successfully. You can now sign in with your new password.</p>
                <a href="{{ route('login') }}" class="btn-auth"
                    style="text-decoration:none;margin-top:18px;display:inline-flex"><i class="fas fa-sign-in-alt"></i>
                    Sign In Now</a>
            </div>
        </div>
    </section>
@endsection
