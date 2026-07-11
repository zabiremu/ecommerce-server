@if($instagramPosts->isNotEmpty())
<div class="wp-block-wd-container wd-dir-col wd-align wd-cdd11e25 wd-hide-mobile-insta">
    <h2 class="wp-block-wd-title title wd-ac487a7f">Connect to our Instagram</h2>

    <p class="wp-block-wd-paragraph wd-1bfa0982">Follow us on Instagram, keep up to date with
        new products and share your impressions</p>

    <a class="wp-block-wd-button btn btn-style-bordered btn-size-default btn-shape-round wd-172b7370"
        href="{{ \App\Models\SiteSetting::get('instagram_url', 'https://www.instagram.com/') }}"><span>{{ \App\Models\SiteSetting::get('instagram_handle', 'Follow us') }}</span></a>

    <link rel="stylesheet" id="wd-instagram-css"
        href="merchandise/wp-content/themes/woodmart/css/parts/el-instagram.css" type="text/css"
        media="all" />
    <div class="wd-insta  wd-0c7ef44c data-source-images">

        <div class=" wd-grid-g"
            style="--wd-col-lg:6;--wd-col-md:3;--wd-col-sm:3;--wd-gap-lg:20px;--wd-gap-sm:10px;">

            @foreach($instagramPosts as $post)
            <div class="wd-insta-item wd-col">
                <a href="{{ $post->link ?: \App\Models\SiteSetting::get('instagram_url', 'https://www.instagram.com/') }}"
                    target="_blank" rel="noopener" aria-label="Instagram picture"></a>

                <img loading="lazy" decoding="async" width="256" height="256"
                    src="{{ Storage::url($post->image) }}"
                    class="attachment-medium size-medium" alt="" />
                <div class="wd-insta-meta wd-grid-g">
                    <span class="wd-insta-likes instagram-likes"><span>{{ $post->likes_count }}</span></span>
                    <span class="wd-insta-comm instagram-comments"><span>{{ $post->comments_count }}</span></span>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</div>
@endif
