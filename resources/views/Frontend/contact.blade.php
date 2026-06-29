@extends('Frontend.Layout.app')

@php
    $phone = \App\Models\SiteSetting::get('contact_phone', '+8801820834086');
    $email = \App\Models\SiteSetting::get('contact_email', '');
    $address = \App\Models\SiteSetting::get('contact_address', 'Bangladesh');
    $hours = \App\Models\SiteSetting::get('contact_hours', 'Sat – Thu: 9AM – 10PM');
    $company = \App\Models\SiteSetting::get('company_name', 'NF Shop 24');
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
            <nav class="wd-breadcrumbs"><a href="index.html">Home</a><span class="wd-delimiter">/</span><span
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

                            <p id="wd-92d381d3" class="wp-block-wd-paragraph">+1 202-853-9050</p>
                        </div>

                        <div id="wd-5fbdbcae" class="wp-block-wd-column wd-align">
                            <h2 id="wd-e1fbe778" class="wp-block-wd-title title">Email:</h2>

                            <p id="wd-1d2447d8" class="wp-block-wd-paragraph">xtemos.studio@gmail.com</p>
                        </div>

                        <div id="wd-a0ee08aa" class="wp-block-wd-column wd-align">
                            <h2 id="wd-2735733b" class="wp-block-wd-title title">Address:</h2>

                            <p id="wd-c5459fdc" class="wp-block-wd-paragraph wd-custom-width">13 Ridge Square
                                NW, Washington, DC 20016</p>
                        </div>

                        <div id="wd-bf44abcb" class="wp-block-wd-column wd-align">
                            <h2 id="wd-645b3c2b" class="wp-block-wd-title title">Social Links:</h2>

                            <div id="wd-c3a0b007"
                                class=" wd-social-icons wd-style-default wd-size-default social-follow wd-shape-circle  wd-c3a0b007">
                                <link rel="stylesheet" id="wd-social-icons-css"
                                    href="merchandise/wp-content/themes/woodmart/css/parts/el-social-icons.css"
                                    type="text/css" media="all" />

                                <a rel="noopener noreferrer nofollow" href="https://www.facebook.com/xtemos.studio"
                                    target="_blank" class=" wd-social-icon social-facebook"
                                    aria-label="Facebook social link">
                                    <span class="wd-icon"></span>
                                </a>

                                <a rel="noopener noreferrer nofollow" href="https://x.com/xtemos_studio" target="_blank"
                                    class=" wd-social-icon social-twitter" aria-label="X social link">
                                    <span class="wd-icon"></span>
                                </a>



                                <a rel="noopener noreferrer nofollow" href="https://www.instagram.com/xtemos.studio/"
                                    target="_blank" class=" wd-social-icon social-instagram"
                                    aria-label="Instagram social link">
                                    <span class="wd-icon"></span>
                                </a>


                                <a rel="noopener noreferrer nofollow"
                                    href="https://www.youtube.com/channel/UCu3loFwqqOQ9z-YTcnplK8w" target="_blank"
                                    class=" wd-social-icon social-youtube" aria-label="YouTube social link">
                                    <span class="wd-icon"></span>
                                </a>




















                            </div>

                        </div>
                    </div>
                </div>

                <div id="wd-6152329d" class="wp-block-wd-container wd-dir-col wd-align wd-custom-width">
                    <h2 id="wd-3237cd08" class="wp-block-wd-title title">Get In Touch</h2>

                    <div id="wd-8b53b095" class="wd-cf7 wd-8b53b095">
                        <div class="wpcf7 no-js" id="wpcf7-f863-p595-o1" lang="en-US" dir="ltr" data-wpcf7-id="863">
                            <div class="screen-reader-response">
                                <p role="status" aria-live="polite" aria-atomic="true"></p>
                                <ul></ul>
                            </div>
                            <form action="/merchandise/contact-us/#wpcf7-f863-p595-o1" method="post"
                                class="wpcf7-form init" aria-label="Contact form" novalidate="novalidate"
                                data-status="init">

                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="First"><input
                                            size="40" maxlength="400"
                                            class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                            aria-required="true" aria-invalid="false" placeholder="First name"
                                            value="" type="text" name="First" /></span>
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="Last"><input
                                            size="40" maxlength="400"
                                            class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                            aria-required="true" aria-invalid="false" placeholder="Last name"
                                            value="" type="text" name="Last" /></span>
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="Last"><input
                                            size="40" maxlength="400"
                                            class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                            aria-required="true" aria-invalid="false" placeholder="Email" value=""
                                            type="text" name="Last" /></span>
                                </p>
                                <p class="wd-col"><span class="wpcf7-form-control-wrap" data-name="your-message">
                                        <textarea cols="40" rows="10" maxlength="2000" class="wpcf7-form-control wpcf7-textarea"
                                            aria-invalid="false" placeholder="Your Message" name="your-message"></textarea>
                                    </span>
                                </p>
                                <p class="wd-col"><input
                                        class="wpcf7-form-control wpcf7-submit has-spinner btn btn-color-primary"
                                        type="submit" value="Send Message" />
                                </p>

                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>
@endsection
