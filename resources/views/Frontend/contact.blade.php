@extends('Frontend.Layout.app')

@php
    $phone = \App\Models\SiteSetting::get('contact_phone', '+8801820834086');
    $email = \App\Models\SiteSetting::get('contact_email', '');
    $address = \App\Models\SiteSetting::get('contact_address', 'Bangladesh');
    $hours = \App\Models\SiteSetting::get('contact_hours', 'Sat – Thu: 9AM – 10PM');
    $company = \App\Models\SiteSetting::get('company_name', 'ROVENTEX');
    $socialFacebook = \App\Models\SiteSetting::get('social_facebook', '');
    $socialInstagram = \App\Models\SiteSetting::get('social_instagram', '');
    $socialYoutube = \App\Models\SiteSetting::get('social_youtube', '');
    $socialWhatsapp = \App\Models\SiteSetting::get('social_whatsapp', '');
@endphp

@section('title', 'Contact Us — ' . $company)

@section('content')
    <link rel="stylesheet" id="wd-page-title-css"
        href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/page-title.css') }}" />
    <div class="wd-page-title page-title  page-title-default title-size-small title-design-centered color-scheme-default">
        <div class="wd-page-title-bg wd-fill">
        </div>
        <div class="container">
            <h1 class="entry-title title">
                Contact us </h1>
            <nav class="wd-breadcrumbs"><a href="{{ route('home') }}">Home</a><span class="wd-delimiter">/</span><span
                    class="wd-last">Contact us</span></nav>
        </div>
    </div>

    <main id="main-content" class="wd-content-layout content-layout-wrapper container" role="main">
        <div class="wd-content-area site-content">
            <article id="post-595" class="entry-content post-595 page type-page status-publish hentry">

                <div id="wd-6f134382" class="wp-block-wd-section">
                    <div id="wd-675b1206" class="wp-block-wd-row">
                        <div id="wd-790e14bf" class="wp-block-wd-column wd-align">
                            <h2 id="wd-ec0d6ae3" class="wp-block-wd-title title">Phone:</h2>

                            <p id="wd-92d381d3" class="wp-block-wd-paragraph">{{ $phone }}</p>
                        </div>

                        <div id="wd-5fbdbcae" class="wp-block-wd-column wd-align">
                            <h2 id="wd-e1fbe778" class="wp-block-wd-title title">Email:</h2>

                            <p id="wd-1d2447d8" class="wp-block-wd-paragraph">{{ $email ?: '—' }}</p>
                        </div>

                        <div id="wd-a0ee08aa" class="wp-block-wd-column wd-align">
                            <h2 id="wd-2735733b" class="wp-block-wd-title title">Address:</h2>

                            <p id="wd-c5459fdc" class="wp-block-wd-paragraph wd-custom-width">{{ $address }}</p>
                        </div>

                        @if ($socialFacebook || $socialInstagram || $socialYoutube || $socialWhatsapp)
                        <div id="wd-bf44abcb" class="wp-block-wd-column wd-align">
                            <h2 id="wd-645b3c2b" class="wp-block-wd-title title">Social Links:</h2>

                            <div id="wd-c3a0b007"
                                class=" wd-social-icons wd-style-default wd-size-default social-follow wd-shape-circle  wd-c3a0b007">
                                <link rel="stylesheet" id="wd-social-icons-css"
                                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/el-social-icons.css') }}"
                                    type="text/css" media="all" />

                                @if ($socialFacebook)
                                <a rel="noopener noreferrer nofollow" href="{{ $socialFacebook }}"
                                    target="_blank" class=" wd-social-icon social-facebook"
                                    aria-label="Facebook social link">
                                    <span class="wd-icon"></span>
                                </a>
                                @endif

                                @if ($socialInstagram)
                                <a rel="noopener noreferrer nofollow" href="{{ $socialInstagram }}"
                                    target="_blank" class=" wd-social-icon social-instagram"
                                    aria-label="Instagram social link">
                                    <span class="wd-icon"></span>
                                </a>
                                @endif

                                @if ($socialYoutube)
                                <a rel="noopener noreferrer nofollow" href="{{ $socialYoutube }}" target="_blank"
                                    class=" wd-social-icon social-youtube" aria-label="YouTube social link">
                                    <span class="wd-icon"></span>
                                </a>
                                @endif

                                @if ($socialWhatsapp)
                                <a rel="noopener noreferrer nofollow" href="https://wa.me/{{ preg_replace('/\D/', '', $socialWhatsapp) }}" target="_blank"
                                    class=" wd-social-icon social-whatsapp" aria-label="WhatsApp social link">
                                    <span class="wd-icon"></span>
                                </a>
                                @endif
                            </div>

                        </div>
                        @endif
                    </div>
                </div>

                <div id="wd-6152329d" class="wp-block-wd-container wd-dir-col wd-align wd-custom-width">
                    <h2 id="wd-3237cd08" class="wp-block-wd-title title">Get In Touch</h2>

                    @if (session('success'))
                        <p class="wpcf7-response-output" role="status" style="border:1px solid #46b450;color:#1d2327;padding:10px 14px;margin-bottom:15px">
                            {{ session('success') }}
                        </p>
                    @endif

                    <div id="wd-8b53b095" class="wd-cf7 wd-8b53b095">
                        <div class="wpcf7" id="gms-contact-form-wrap" lang="en-US" dir="ltr">
                            <div class="screen-reader-response">
                                <p role="status" aria-live="polite" aria-atomic="true"></p>
                                <ul></ul>
                            </div>
                            <form id="gms-contact-form" action="{{ route('contact.store') }}" method="post"
                                class="wpcf7-form init" aria-label="Contact form">
                                @csrf

                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="name"><input
                                            size="40" maxlength="100"
                                            class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                            aria-required="true" placeholder="Your name"
                                            value="{{ old('name') }}" type="text" name="name" required /></span>
                                    @error('name')<span class="wpcf7-not-valid-tip">{{ $message }}</span>@enderror
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="email"><input
                                            size="40" maxlength="255"
                                            class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                            aria-required="true" placeholder="Email"
                                            value="{{ old('email') }}" type="email" name="email" required /></span>
                                    @error('email')<span class="wpcf7-not-valid-tip">{{ $message }}</span>@enderror
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="phone"><input
                                            size="40" maxlength="30"
                                            class="wpcf7-form-control wpcf7-text"
                                            placeholder="Phone (optional)"
                                            value="{{ old('phone') }}" type="text" name="phone" /></span>
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="subject"><input
                                            size="40" maxlength="255"
                                            class="wpcf7-form-control wpcf7-text"
                                            placeholder="Subject (optional)"
                                            value="{{ old('subject') }}" type="text" name="subject" /></span>
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="message">
                                        <textarea cols="40" rows="10" maxlength="5000" class="wpcf7-form-control wpcf7-textarea"
                                            placeholder="Your Message" name="message" required>{{ old('message') }}</textarea>
                                    </span>
                                    @error('message')<span class="wpcf7-not-valid-tip">{{ $message }}</span>@enderror
                                </p>
                                <p class="wd-col"><button type="submit"
                                        class="wpcf7-form-control wpcf7-submit has-spinner btn btn-color-primary">
                                        Send Message </button>
                                </p>
                                <div class="gms-contact-form-message" style="display:none;margin-top:10px;font-size:13px;"></div>

                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>
@endsection
