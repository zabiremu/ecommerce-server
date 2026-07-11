<div class="wp-block-wd-container wd-dir-col wd-align wd-066a5243 wd-newsletter-section">
    <div class="wp-block-wd-image wd-block-image wd-9e91bcf0"><img loading="lazy" decoding="async"
            width="48" height="48" class="wp-image-1021"
            src="merchandise/wp-content/uploads/sites/31/2025/11/gms-mail-1.svg" alt="" /></div>

    <h2 class="wp-block-wd-title title wd-29c12066">Get 10% Off Your First Order</h2>

    <p class="wp-block-wd-paragraph wd-a5b20c44">Will be used in accordance with our&nbsp;<a
            href="{{ route('privacy-policy') }}"><span class="wd-highlight">Privacy Policy</span></a></p>

    <form id="newsletter-form" class="wd-custom-width" method="post" action="{{ route('newsletter.subscribe') }}">
        @csrf
        <div class="wd-grid-f-stretch" style="--wd-gap: 10px">
            <div class="wd-col"><input type="email" name="email" id="newsletter-email"
                    placeholder="Your email address" required /></div>
            <div class="wd-col-auto"><input type="submit" value="Sign up" /></div>
        </div>
        <div class="newsletter-message" style="margin-top:8px;font-size:14px;"></div>
    </form>
</div>
