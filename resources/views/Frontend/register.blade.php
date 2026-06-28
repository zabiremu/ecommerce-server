@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Create Account</span>
    </div>
</section>

<!-- Auth Section -->
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon"><i class="fas fa-user-plus"></i></div>
            <h1>Create Account</h1>
            <p>Join NF Shop 24 and start shopping</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form class="auth-form" id="customerRegisterForm" method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="form-row-2">
                <div class="form-group">
                    <label for="regFirst"><i class="fas fa-user"></i> First Name</label>
                    <input type="text" id="regFirst" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                </div>
                <div class="form-group">
                    <label for="regLast"><i class="fas fa-user"></i> Last Name</label>
                    <input type="text" id="regLast" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="regEmail"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="regEmail" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="regPhone"><i class="fas fa-phone"></i> Phone Number</label>
                <input type="tel" id="regPhone" name="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX" required>
            </div>

            <div class="form-group">
                <label for="regPassword"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrap">
                    <input type="password" id="regPassword" name="password" placeholder="Create a password" required minlength="6">
                    <button type="button" class="toggle-pass" onclick="togglePass('regPassword',this)"><i class="far fa-eye"></i></button>
                </div>
            </div>

            <div class="form-group">
                <label for="regConfirm"><i class="fas fa-check-circle"></i> Confirm Password</label>
                <div class="password-wrap">
                    <input type="password" id="regConfirm" name="password_confirmation" placeholder="Confirm your password" required>
                    <button type="button" class="toggle-pass" onclick="togglePass('regConfirm',this)"><i class="far fa-eye"></i></button>
                </div>
            </div>

            <label class="checkbox-label terms">
                <input type="checkbox" required> I agree to the <a href="{{ route('terms-conditions') }}">Terms & Conditions</a> and <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
            </label>

            <button type="submit" class="btn-auth"><i class="fas fa-user-plus"></i> Create Account</button>

            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </form>

        @push('scripts')
        <script>
            document.getElementById('customerRegisterForm').addEventListener('submit', function () {
                var btn = this.querySelector('.btn-auth');
                if (btn.disabled) return false;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Creating account...';
            });
        </script>
        @endpush
    </div>
</section>
@endsection
