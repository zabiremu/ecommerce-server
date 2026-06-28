@extends('Frontend.Layout.app')

@php
    $phone   = \App\Models\SiteSetting::get('contact_phone',   '+8801820834086');
    $email   = \App\Models\SiteSetting::get('contact_email',   '');
    $address = \App\Models\SiteSetting::get('contact_address', 'Bangladesh');
    $hours   = \App\Models\SiteSetting::get('contact_hours',   'Sat – Thu: 9AM – 10PM');
    $company = \App\Models\SiteSetting::get('company_name',    'NF Shop 24');
@endphp

@section('title', 'Contact Us — ' . $company)

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Contact Us</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-headset"></i> Contact Us</h1>
        <p>We'd love to hear from you. Get in touch with us.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-layout">
            <!-- Contact Info Cards -->
            <div class="contact-info">
                @if ($address)
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h4>Our Address</h4>
                    <p>{{ $address }}</p>
                </div>
                @endif
                @if ($phone)
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fas fa-phone-alt"></i></div>
                    <h4>Phone</h4>
                    <p><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>
                </div>
                @endif
                @if ($email)
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fas fa-envelope"></i></div>
                    <h4>Email</h4>
                    <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                </div>
                @endif
                @if ($hours)
                <div class="contact-card">
                    <div class="contact-card-icon"><i class="fas fa-clock"></i></div>
                    <h4>Working Hours</h4>
                    <p>{{ $hours }}</p>
                </div>
                @endif
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrap">
                <h3>Send us a Message</h3>
                <form class="contact-form" id="contactForm" onsubmit="return handleContact(event)">
                    @csrf
                    <div id="contactError" class="contact-error"
                         style="display:none;background:#fef2f2;border-left:4px solid #ef4444;color:#b91c1c;padding:10px 14px;border-radius:6px;font-size:13px;margin-bottom:12px"></div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="conName"><i class="fas fa-user"></i> Your Name</label>
                            <input type="text" id="conName" name="name" placeholder="Enter your name" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="conEmail"><i class="fas fa-envelope"></i> Your Email</label>
                            <input type="email" id="conEmail" name="email" placeholder="Enter your email" required maxlength="255">
                        </div>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="conPhone"><i class="fas fa-phone"></i> Phone <span style="color:#94a3b8;font-weight:400">(optional)</span></label>
                            <input type="tel" id="conPhone" name="phone" placeholder="Your phone number" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="conSubject"><i class="fas fa-tag"></i> Subject</label>
                            <input type="text" id="conSubject" name="subject" placeholder="What's this about?" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="conMsg"><i class="fas fa-comment"></i> Message</label>
                        <textarea id="conMsg" name="message" rows="5" placeholder="Write your message here..." required maxlength="5000"></textarea>
                    </div>
                    <button type="submit" class="btn-auth" id="contactSubmitBtn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
                <div id="contactSuccess" class="contact-success" style="display:none">
                    <i class="fas fa-check-circle"></i>
                    <h4>Message Sent!</h4>
                    <p id="contactSuccessMsg">Thank you for reaching out. We'll get back to you shortly.</p>
                    <button class="btn-auth" onclick="resetContactForm()">Send Another Message</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
@if ($address)
<section class="contact-map">
    <div class="container">
        <div class="map-placeholder">
            <i class="fas fa-map-marked-alt"></i>
            <h4>{{ $address }}</h4>
            <p>We serve customers across the country</p>
        </div>
    </div>
</section>
@endif

<script>
    window.NF_CSRF = @json(csrf_token());
    window.NF_CONTACT_STORE_URL = @json(route('contact.store'));
</script>
@endsection
