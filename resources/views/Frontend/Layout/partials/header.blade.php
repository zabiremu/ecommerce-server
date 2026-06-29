<head>
    <meta charset="UTF-8">
    <link rel="preload" as="font" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2') }}"
        type="font/woff2"
        crossorigin>
    <link rel="preload" as="image" href="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt.jpg.webp') }}"
        imagesrcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt.jpg.webp') }} 1294w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-300x139.jpg.webp') }} 300w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-1024x475.jpg.webp') }} 1024w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-768x356.jpg.webp') }} 768w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-290x134.jpg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-100x46.jpg.webp') }} 100w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-600x278.jpg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-slide-1-opt-150x70.jpg.webp') }} 150w"
        imagesizes="(max-width: 1294px) 100vw, 1294px" fetchpriority="high" />
    <link rel='stylesheet' id='wd-style-base-css' href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/base.css') }}"
        type='text/css' media='all' />
    <style id='wd-style-base-inline-css' type='text/css'>
        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: "woodmart-font";
            src: url("{{ asset('frontend/merchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2') }}") format("woff2");
        }

        /* Mobile logo fix */
        .whb-cqgb8qgsj8fpo4qz9frx .wd-logo img {
            transform: scale(1.3) !important;
            transform-origin: center center !important;
        }

        /*# sourceURL=wd-style-base-inline-css */
    </style>
    <link rel='stylesheet' id='wd-header-base-css'
        href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/header-base.css') }}" type='text/css' media='all' />
    <style id='wd-woocommerce-base-inline-css' type='text/css'>
        .amount {
            color: var(--wd-primary-color);
            font-weight: 600
        }

        .price {
            color: var(--wd-primary-color);
            font-weight: 600
        }

        .price .amount {
            color: inherit;
            font-size: inherit;
            font-weight: inherit
        }

        .price del {
            color: var(--color-gray-300);
            font-size: 90%;
            font-weight: 400
        }

        .price ins {
            padding: 0;
            background-color: rgba(0, 0, 0, 0);
            text-decoration: none;
            opacity: 1
        }

        .woocommerce-price-suffix {
            color: var(--color-gray-500);
            font-weight: 400
        }

        .woocommerce-notices-wrapper:empty {
            display: none
        }

        ul:is(.woocommerce-error, .woocommerce-message, .woocommerce-info) {
            list-style: none;
            --li-pl: 0;
            --li-mb: 5px;
            align-items: stretch;
            flex-direction: column;
            justify-content: center
        }

        ul.variation {
            font-size: 90%;
            --li-mb: 5px;
            --list-mb: 0;
            --wd-tags-mb: 0;
            --li-pl: 0;
            list-style: none
        }

        ul.variation p {
            display: inline
        }

        ul.variation .item-variation-name {
            color: var(--color-gray-800);
            font-weight: 600
        }

        .wc-item-meta {
            --li-pl: 0;
            --list-mb: 0;
            --li-mb: 0;
            margin-top: 10px;
            font-size: 90%;
            list-style: none
        }

        .wc-item-meta li>* {
            display: inline-block;
            margin-top: 0 !important;
            margin-bottom: 5px;
            vertical-align: middle
        }

        .wc-item-meta strong {
            color: var(--color-gray-800)
        }

        .single_add_to_cart_button {
            padding: var(--btn-accented-padding, var(--btn-padding, 5px 20px));
            min-height: var(--btn-accented-height, var(--btn-height, 42px));
            font-size: var(--btn-accented-font-size, var(--btn-font-size, 13px));
            border-radius: var(--btn-accented-brd-radius);
            color: var(--btn-accented-color);
            box-shadow: var(--btn-accented-box-shadow);
            background-color: var(--btn-accented-bgcolor);
            text-transform: var(--btn-accented-transform, var(--btn-transform, uppercase));
            font-weight: var(--btn-accented-font-weight, var(--btn-font-weight, 600));
            font-family: var(--btn-accented-font-family, var(--btn-font-family, inherit));
            font-style: var(--btn-accented-font-style, var(--btn-font-style, unset))
        }

        .single_add_to_cart_button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .single_add_to_cart_button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .single_add_to_cart_button:before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0;
            z-index: 1;
            border-radius: inherit;
            background-color: inherit;
            box-shadow: inherit;
            transition: opacity 0s ease
        }

        .single_add_to_cart_button:after {
            position: absolute;
            top: calc(50% - 9px);
            inset-inline-start: calc(50% - 9px);
            opacity: 0;
            z-index: 2;
            transition: opacity 0s ease;
            content: "";
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 1px solid rgba(0, 0, 0, 0);
            border-left-color: currentColor;
            border-radius: 50%;
            vertical-align: middle;
            animation: wd-rotate 450ms infinite linear var(--wd-anim-state, paused)
        }

        .single_add_to_cart_button.loading:before {
            opacity: 1;
            transition: opacity .25s ease
        }

        .single_add_to_cart_button.loading:after {
            opacity: 1;
            transition: opacity .25s ease;
            --wd-anim-state: running
        }

        .single_add_to_cart_button+.added_to_cart {
            display: none
        }

        form.cart {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: var(--content-align)
        }

        form.cart>* {
            flex: 1 1 100%
        }

        form.cart :where(.single_add_to_cart_button, .wd-buy-now-btn, .quantity) {
            flex: 0 0 auto
        }

        .woocommerce-product-details__short-description {
            margin-bottom: 20px
        }

        .woocommerce-product-details__short-description>*:last-child {
            margin-bottom: 0
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woocommerce-base.css */
    </style>
    <style id='wd-mod-star-rating-inline-css' type='text/css'>
        .star-rating {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            white-space: nowrap;
            letter-spacing: 2px;
            font-weight: 400;
            color: var(--wd-star-color, #EABE12);
            width: fit-content;
            font-family: "woodmart-font"
        }

        .star-rating:before {
            content: "\f149" "\f149" "\f149" "\f149" "\f149";
            color: var(--wd-empty-star-color, var(--color-gray-300))
        }

        .star-rating span {
            position: absolute;
            inset-block: 0;
            inset-inline-start: 0;
            overflow: hidden;
            width: 100%;
            text-indent: 99999px
        }

        .star-rating span:before {
            content: "\f148" "\f148" "\f148" "\f148" "\f148";
            position: absolute;
            top: 0;
            inset-inline-start: 0;
            text-indent: 0
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-star-rating.css */
    </style>
    <style id='wd-woo-opt-free-progress-bar-inline-css' type='text/css'>
        .wd-free-progress-bar {
            --wd-progress-height: 10px
        }

        .wd-free-progress-bar .progress-bar {
            margin-top: 10px;
            background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
            background-size: 15px 15px
        }

        .wd-free-progress-bar.wd-progress-hide .progress-area {
            display: none
        }

        .wd-shipping-progress-bar.wd-style-bordered .wd-free-progress-bar {
            padding: 20px;
            border: 2px dashed var(--brdcolor-gray-300);
            border-radius: var(--wd-brd-radius)
        }

        .widget_shopping_cart .wd-free-progress-bar {
            margin-bottom: 0;
            padding-block: 15px;
            border-top: 1px solid var(--brdcolor-gray-300)
        }

        .wd-builder-off .wd-shipping-progress-bar {
            margin-bottom: 20px
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-opt-free-progress-bar.css */
    </style>
    <style id='wd-woo-mod-progress-bar-inline-css' type='text/css'>
        .wd-progress-bar p:last-child {
            --wd-tags-mb: 0
        }

        .wd-progress-bar .stock-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--color-gray-500);
            line-height: 1
        }

        .wd-progress-bar .stock-info span {
            margin-inline-start: 3px;
            color: var(--color-gray-800);
            font-weight: 600
        }

        .wd-progress-bar :is(.progress-area, .progress-bar) {
            height: var(--wd-progress-height, 7px);
            border-radius: var(--wd-brd-radius)
        }

        .wd-progress-bar .progress-area {
            width: 100%;
            background-color: rgba(var(--bgcolor-black-rgb), 0.06);
            transition: background-color .25s ease
        }

        .wd-progress-bar .progress-bar {
            background-color: var(--wd-primary-color)
        }

        @media(max-width: 576px) {
            .wd-product .wd-progress-bar .stock-info {
                justify-content: center
            }

            .wd-product .wd-progress-bar .total-sold {
                display: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-progress-bar.css */
    </style>
    <style id='child-style-inline-css' type='text/css'>
        /**** WORDFANCE Fix login plugin notice ****/

        .woocommerce-account .wfls-login-message {
            /*VALID*/
            margin-block: 20px -40px;
        }

        /**** WORDFANCE Fix login notice (remove on 8.6) ****/

        .wd-header-overlap .wfls-login-message {
            /*VALID*/
            position: absolute;
            top: calc(var(--wd-header-h) + var(--wd-header-boxed-sp, .0001px));
            z-index: 388;
            inset-inline: 0;
        }

        .wd-header-overlap:not(.single-product) .wfls-login-message+.wd-content-layout {
            padding-top: 0;
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart-child/style.css */
    </style>
    <style id='wd-block-title-inline-css' type='text/css'>
        .wp-block-wd-title {
            --wd-trans-main: all .25s ease;
            transition: var(--wd-trans-main)
        }

        .wp-block-wd-title.title {
            font-size: 1.6em;
            color: var(--wd-title-color)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-title.css */
    </style>
    <style id='wd-mod-transform-inline-css' type='text/css'>
        .wd-transform {
            --wd-transform-perspective: 0;
            --wd-transform-rotateX: 0;
            --wd-transform-rotateY: 0;
            --wd-transform-rotateZ: 0;
            --wd-transform-translateX: 0;
            --wd-transform-translateY: 0;
            --wd-transform-scaleX: 1;
            --wd-transform-scaleY: 1;
            --wd-transform-skewX: 0;
            --wd-transform-skewY: 0;
            --wd-transform-origin-y: center;
            --wd-transform-origin-x: center;
            transform: perspective(var(--wd-transform-perspective)) translateX(var(--wd-transform-translateX)) translateY(var(--wd-transform-translateY)) scaleX(var(--wd-transform-scaleX)) scaleY(var(--wd-transform-scaleY)) rotateX(var(--wd-transform-rotateX)) rotateY(var(--wd-transform-rotateY)) rotateZ(var(--wd-transform-rotateZ)) skewX(var(--wd-transform-skewX)) skewY(var(--wd-transform-skewY));
            transform-origin: var(--wd-transform-origin-y) var(--wd-transform-origin-x)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-transform.css */
    </style>
    <style id='wd-block-layout-inline-css' type='text/css'>
        .wp-block-wd-row {
            --wd-width: 100%;
            display: flex;
            max-width: calc(var(--wd-container-w) - 30px);
            width: var(--wd-width);
            --wd-col-gap: 30px;
            gap: var(--wd-col-gap)
        }

        :is(.entry-content, .wd-entry-content)>.wp-block-wd-row {
            margin-inline: auto
        }

        @media(max-width: 1024px) {
            .wp-block-wd-row {
                flex-wrap: wrap
            }
        }

        .wp-block-wd-column {
            display: flex;
            flex: 1 0 0;
            min-width: 1px;
            --wd-row-gap: 20px;
            flex-direction: column;
            row-gap: var(--wd-row-gap);
            align-items: var(--wd-align)
        }

        .wp-block-wd-column:not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
            width: 100%
        }

        :root .wp-block-wd-column>* {
            margin-bottom: 0
        }

        @media(max-width: 1024px) {
            .wp-block-wd-column:not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: 100%
            }
        }

        @media(max-width: 768.98px) {
            .wp-block-wd-column:not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: 100%
            }

            .wp-block-wd-column {
                flex: 1 1 100%
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-layout.css */
    </style>
    <style id='wd-block-image-inline-css' type='text/css'>
        .wd-block-image {
            --wd-width: initial;
            position: relative;
            max-width: 100%;
            width: var(--wd-width)
        }

        .wd-block-image :is(img, .wd-block-image-link) {
            border-radius: var(--wd-brd-radius);
            min-width: 8px;
            aspect-ratio: var(--wd-aspect-ratio, revert-layer);
            object-fit: cover
        }

        .wd-block-image.wd-custom-width :is(img, .wd-block-image-link) {
            width: var(--wd-img-width, var(--wd-width))
        }

        .wd-caption-under figcaption {
            margin-top: 10px
        }

        .wd-caption-mask figcaption {
            --wd-link-color: rgba(255, 255, 255, 0.8);
            --wd-link-color-hover: #FFF;
            position: absolute;
            text-align: center;
            bottom: 0;
            padding: 10px;
            inset-inline: 0;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
            color: hsla(0, 0%, 100%, .8)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-image.css */
    </style>
    <style id='wd-block-paragraph-inline-css' type='text/css'>
        .wp-block-wd-paragraph {
            --wd-trans-main: all .25s ease;
            transition: var(--wd-trans-main)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-paragraph.css */
    </style>
    <style id='wd-button-inline-css' type='text/css'>
        .btn.btn-style-3d {
            --btn-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.15);
            --btn-box-shadow-hover: inset 0 -2px 0 rgba(0, 0, 0, 0.15)
        }

        .btn.btn-style-3d:active {
            box-shadow: none;
            top: 1px
        }

        .btn.btn-style-bordered {
            --btn-bgcolor: transparent;
            --btn-bgcolor-hover: transparent;
            --btn-brd-width: 2px;
            --btn-box-shadow-hover: none
        }

        .btn.btn-style-link {
            --btn-bgcolor: transparent;
            --btn-bgcolor-hover: transparent;
            --btn-brd-width: 2px;
            --btn-box-shadow-hover: none;
            --btn-height: none;
            --btn-padding: 0;
            border-top: 0;
            border-inline: 0
        }

        .btn-color-primary {
            --btn-color: #FFF;
            --btn-color-hover: #FFF;
            --btn-bgcolor: var(--wd-primary-color);
            --btn-bgcolor-hover: var(--wd-primary-color);
            --btn-brd-color: var(--wd-primary-color);
            --btn-brd-color-hover: var(--wd-primary-color);
            --btn-box-shadow-hover: inset 0 0 0 1000px rgba(0, 0, 0, 0.1)
        }

        .btn-color-primary.btn-style-bordered {
            --btn-color: var(--wd-primary-color);
            --btn-bgcolor-hover: var(--wd-primary-color)
        }

        .btn-color-primary.btn-style-link {
            --btn-color: var(--color-gray-800);
            --btn-color-hover: var(--color-gray-500)
        }

        .btn-color-alt {
            --btn-color: #FFF;
            --btn-color-hover: #FFF;
            --btn-bgcolor: var(--wd-alternative-color);
            --btn-bgcolor-hover: var(--wd-alternative-color);
            --btn-brd-color: var(--wd-alternative-color);
            --btn-brd-color-hover: var(--wd-alternative-color);
            --btn-box-shadow-hover: inset 0 0 0 1000px rgba(0, 0, 0, 0.1)
        }

        .btn-color-alt.btn-style-bordered {
            --btn-color: var(--wd-alternative-color);
            --btn-bgcolor-hover: var(--wd-alternative-color)
        }

        .btn-color-alt.btn-style-link {
            --btn-color: var(--color-gray-800);
            --btn-color-hover: var(--color-gray-500)
        }

        .btn-color-black {
            --btn-color: #FFF;
            --btn-color-hover: #FFF;
            --btn-bgcolor: #212121;
            --btn-bgcolor-hover: #212121;
            --btn-brd-color: #212121;
            --btn-brd-color-hover: #212121;
            --btn-box-shadow-hover: inset 0 0 0 1000px rgba(0, 0, 0, 0.1)
        }

        .btn-color-black.btn-style-bordered {
            --btn-color: #333;
            --btn-bgcolor-hover: #212121
        }

        .btn-color-black.btn-style-link {
            --btn-color: var(--color-gray-800);
            --btn-color-hover: var(--color-gray-500)
        }

        .btn-color-white {
            --btn-color: #333;
            --btn-color-hover: #333;
            --btn-bgcolor: #FFF;
            --btn-bgcolor-hover: #FFF;
            --btn-brd-color: rgba(255, 255, 255, 0.5);
            --btn-brd-color-hover: #FFF;
            --btn-box-shadow-hover: inset 0 0 0 1000px rgba(0, 0, 0, 0.1)
        }

        .btn-color-white.btn-style-bordered {
            --btn-color: #FFF;
            --btn-bgcolor-hover: #FFF
        }

        .btn-color-white.btn-style-link {
            --btn-color: #FFF;
            --btn-color-hover: #FFF
        }

        .btn-size-extra-small {
            --btn-padding: 5px 10px;
            --btn-height: 28px;
            --btn-font-size: 11px
        }

        .btn-size-small {
            --btn-padding: 5px 14px;
            --btn-height: 36px;
            --btn-font-size: 12px
        }

        .btn-shape-round,
        .btn-style-round {
            --btn-brd-radius: 35px
        }

        .btn-shape-semi-round,
        .btn-style-semi-round {
            --btn-brd-radius: 5px
        }

        .btn-icon-pos-left {
            flex-direction: row-reverse
        }

        .btn-icon-pos-right {
            flex-direction: row
        }

        @media(min-width: 1025px) {
            .btn-size-large {
                --btn-padding: 5px 28px;
                --btn-height: 48px;
                --btn-font-size: 14px
            }

            .btn-size-extra-large {
                --btn-padding: 5px 40px;
                --btn-height: 56px;
                --btn-font-size: 16px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-button.css */
    </style>
    <style id='wd-block-button-inline-css' type='text/css'>
        .wp-block-wd-button {
            --wd-width: fit-content;
            --wd-trans-main: all .25s ease;
            max-width: var(--wd-width);
            height: fit-content
        }

        .wp-block-wd-button>span {
            flex-shrink: 0
        }

        .btn :where(.wp-block-wd-icon):not(.wd-with-text) {
            --wd-icon-w: 18px
        }

        .btn svg {
            fill: currentColor;
            transition: fill .25s ease
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-button.css */
    </style>
    <style id='wd-swiper-inline-css' type='text/css'>
        .wd-carousel-container {
            --wd-width: 100%;
            position: relative;
            width: var(--wd-width)
        }

        .wd-carousel-inner {
            position: relative;
            margin: -15px 0
        }

        .wd-carousel {
            position: relative;
            overflow-x: var(--wd-carousel-overflow, clip);
            overflow-y: var(--wd-carousel-overflow, unset);
            padding: 15px 0;
            margin-inline: calc(var(--wd-gap)/-2);
            touch-action: pan-y
        }

        @supports not (overflow: clip) {
            .wd-carousel {
                overflow: var(--wd-carousel-overflow, hidden)
            }
        }

        .wd-carousel-wrap {
            position: relative;
            width: 100%;
            height: 100%;
            z-index: 1;
            display: flex;
            transition-property: transform;
            transition-timing-function: initial;
            box-sizing: content-box;
            transform: translate3d(0px, 0, 0)
        }

        .wd-carousel-item {
            position: relative;
            height: 100%;
            flex: 0 0 calc(100%/var(--wd-col));
            max-width: calc(100%/var(--wd-col));
            padding: 0 calc(var(--wd-gap)/2);
            transition-property: transform;
            transform: translate3d(0px, 0, 0)
        }

        .wd-backface-hidden .wd-carousel-item {
            transform: translateZ(0);
            backface-visibility: hidden
        }

        .wd-carousel[data-center_mode=yes] .wd-carousel-wrap:not([style]) {
            transform: translate3d(calc(50% - 100% / var(--wd-col) / 2), 0, 0)
        }

        .wd-autoheight,
        .wd-autoheight .wd-carousel-item {
            height: auto
        }

        .wd-autoheight .wd-carousel-wrap {
            align-items: flex-start;
            transition-property: transform, height
        }

        @media(min-width: 1025px) {
            .wd-carousel-container: not(.wd-off-lg) [style*="col-lg:1;"]:not(.wd-initialized)>.wd-carousel-wrap>.wd-carousel-item:nth-child(n+2) {
                display: none
            }
        }

        @media(max-width: 768.98px) {
            .wd-carousel-container: not(.wd-off-sm) [style*="col-sm:1;"]:not(.wd-initialized)>.wd-carousel-wrap>.wd-carousel-item:nth-child(n+2) {
                display: none
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            .wd-carousel-container: not(.wd-off-md) [style*="col-md:1;"]:not(.wd-initialized)>.wd-carousel-wrap>.wd-carousel-item:nth-child(n+2) {
                display: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/lib-swiper.css */
    </style>
    <style id='wd-block-slider-inline-css' type='text/css'>
        .wd-slide-bg {
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat
        }

        .wd-slide-bg :is(img, picture) {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center
        }

        .wd-slide-link {
            z-index: 2
        }

        .wd-slider-arrows.wd-pos-sep {
            --wd-arrow-offset-h: calc(var(--wd-arrow-width, var(--wd-arrow-size, 50px)) / -1)
        }

        .wd-slider-pagin {
            position: absolute;
            inset-inline: 15px;
            bottom: 15px;
            z-index: 2
        }

        .wd-slider.wd-container-full-width .wd-slide-container {
            max-width: none
        }

        .wd-slider>.wd-carousel-inner>.wd-carousel:not(.wd-fade)>.wd-carousel-wrap {
            transition-timing-function: cubic-bezier(0.22, 0.61, 0.36, 1)
        }

        .wd-carousel.wd-fade>.wd-carousel-wrap>.wd-carousel-item {
            pointer-events: none;
            transition-property: opacity
        }

        .wd-carousel.wd-fade>.wd-carousel-wrap>.wd-carousel-item.wd-active {
            pointer-events: auto
        }

        .swiper-notification {
            position: absolute;
            display: flex;
            justify-self: center;
            inset: 15px 0 auto 0;
            padding: 5px 10px;
            color: var(--color-gray-800);
            background: rgba(var(--bgcolor-white-rgb), 0.6);
            border-radius: var(--wd-brd-radius);
            z-index: 2
        }

        .swiper-notification:empty {
            display: none
        }

        .wd-slider>.wd-carousel-inner {
            margin: 0;
            border-radius: inherit
        }

        .wd-slider>.wd-carousel-inner>.wd-carousel {
            --wd-gap: 0.001px;
            padding: 0;
            border-radius: inherit;
            overflow: var(--wd-carousel-overflow, clip)
        }

        .wd-slide {
            display: flex;
            justify-content: center;
            overflow: hidden;
            padding: 40px;
            aspect-ratio: var(--wd-aspect-ratio)
        }

        .wd-slide>[class*=wd-bg-] {
            z-index: 1
        }

        .wd-slide-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: calc(var(--wd-container-w) - 30px);
            --wd-align-items: center;
            --wd-justify-content: center;
            --wd-row-gap: 20px;
            display: flex;
            flex-direction: column;
            align-items: var(--wd-align-items);
            justify-content: var(--wd-justify-content);
            row-gap: var(--wd-row-gap);
            transform: translate3d(0, 0, 0)
        }

        .wd-slide-container>* {
            --wd-width: fit-content;
            width: var(--wd-width);
            margin-bottom: 0
        }

        .wd-slide-container>:is(.wp-block-wd-row, .wp-block-wd-container, .wd-carousel-container) {
            --wd-width: 100%
        }

        .wd-slide:not(.woodmart-loaded):not(:first-child)>:is(.wd-slide-bg, .wd-bg-overlay) {
            background-image: none !important
        }

        .wd-slider.wd-stretched {
            width: calc(100vw - var(--wd-scroll-w) - var(--wd-sticky-nav-w));
            inset-inline-start: calc(50% - 50vw + var(--wd-scroll-w)/2 + var(--wd-sticky-nav-w)/2)
        }

        .wd-slider:not(.wd-stretched) {
            border-radius: var(--wd-brd-radius)
        }

        .wd-slider .wd-slide:is(.wd-slide-prev, .wd-slide-next):not(.wd-active) [class*=wd-animation] {
            opacity: 0;
            transform: none;
            transition-property: opacity, transform !important;
            transition-timing-function: ease, cubic-bezier(0, 0.87, 0.58, 1) !important
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-slider-block.css */
    </style>
    <style id='wd-swiper-pagin-critical-inline-css' type='text/css'>
        .wd-nav-pagin-wrap {
            display: flex;
            min-height: var(--wd-pagin-size, 10px);
            margin-top: 20px;
            justify-content: var(--wd-align, var(--wd-center));
            font-size: 0;
            opacity: 1
        }

        .wd-nav-pagin {
            --list-mb: 0;
            --li-mb: 0 !important;
            --li-pl: 0;
            list-style: none;
            display: inline-flex;
            align-items: center;
            justify-content: var(--wd-align, var(--wd-center));
            flex-wrap: wrap;
            gap: 10px var(--wd-pagin-gap, 10px);
            transition: all .25s ease
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/lib-swiper-pagin-critical.css */
    </style>
    <style id='wd-slider-dots-style-3-inline-css' type='text/css'>
        .wd-slider-pagin.wd-style-shape-3 {
            --wd-pagin-gap: calc(var(--wd-pagin-size, 15px) / 2);
            --wd-pagin-bg: var(--color-gray-300);
            --wd-pagin-bg-hover: var(--color-gray-800);
            --wd-pagin-bg-act: var(--color-gray-800);
            --wd-pagin-brd-width: 0
        }

        .wd-slider-pagin.wd-style-shape-3 ul {
            padding-block: calc(var(--wd-pagin-size, 10px) - 3px);
            padding-inline: var(--wd-pagin-size, 10px);
            border-radius: var(--wd-pagin-radius, var(--wd-pagin-size, 15px));
            background-color: var(--wd-pagin-wrap-bg, var(--color-white))
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-slider-dots-style-3.css */
    </style>
    <style id='wd-block-gallery-inline-css' type='text/css'>
        .wp-block-wd-gallery {
            --wd-justify-content: start;
            --wd-align-items: start
        }

        .wp-block-wd-gallery-item {
            display: flex;
            align-items: var(--wd-align-items);
            justify-content: var(--wd-justify-content);
            height: auto
        }

        .wp-block-wd-gallery-item.wd-carousel-item {
            height: auto
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-gallery.css */
    </style>
    <style id='wd-swiper-arrows-critical-inline-css' type='text/css'>
        .wd-btn-arrow.wd-lock,
        .wd-carousel:not(.wd-initialized)~.wd-nav-arrows .wd-btn-arrow {
            opacity: 0 !important;
            pointer-events: none !important
        }

        @media(min-width: 1025px) {
            .wd-nav-arrows[class*=wd-hover].wd-pos-sep .wd-btn-arrow {
                opacity: 0;
                pointer-events: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/lib-swiper-arrows-critical.css */
    </style>
    <style id='wd-block-icon-inline-css' type='text/css'>
        .wp-block-wd-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: var(--wd-icon-w, unset);
            vertical-align: middle;
            max-width: var(--wd-icon-w, 100px);
            overflow: hidden
        }

        .wp-block-wd-icon :is(img, svg, .wd-svg-icon) {
            display: block;
            width: var(--wd-icon-w, revert-layer);
            height: inherit;
            object-fit: contain;
            transition: all .25s ease
        }

        .wp-block-wd-icon.wd-with-text {
            font-size: 4em;
            line-height: 1;
            font-weight: 600;
            max-width: var(--wd-icon-w, fit-content);
            transition: all .25s ease
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-icon.css */
    </style>
    <style id='wd-block-container-inline-css' type='text/css'>
        .wp-block-wd-container {
            --wd-width: 100%;
            --wd-row-gap: 20px;
            --wd-col-gap: 20px;
            display: flex;
            width: var(--wd-width);
            align-items: flex-start;
            row-gap: var(--wd-row-gap);
            column-gap: var(--wd-col-gap)
        }

        :root .wp-block-wd-container>* {
            margin-bottom: 0;
            min-width: 1px
        }

        .wp-block-wd-container.wd-dir-col>* {
            flex-shrink: 0
        }

        :is(.entry-content, .wd-entry-content)>.wp-block-wd-container {
            margin-inline: auto
        }

        .wp-block-wd-container:is(.wd-dir-row, .wd-dir-row-rev) {
            justify-content: var(--wd-align);
            align-content: flex-start
        }

        .wp-block-wd-container.wd-dir-row {
            flex-direction: row
        }

        .wp-block-wd-container.wd-dir-row-rev {
            flex-direction: row-reverse
        }

        .wp-block-wd-container:is(.wd-dir-col, .wd-dir-col-rev) {
            align-items: var(--wd-align)
        }

        .wp-block-wd-container:is(.wd-dir-col, .wd-dir-col-rev):not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
            width: 100%
        }

        .wp-block-wd-container.wd-dir-col {
            flex-direction: column
        }

        .wp-block-wd-container.wd-dir-col-rev {
            flex-direction: column-reverse
        }

        @media(max-width: 1024px) {
            .wp-block-wd-container:is(.wd-dir-row-md, .wd-dir-row-rev-md) {
                justify-content: var(--wd-align);
                align-content: flex-start
            }

            .wp-block-wd-container:is(.wd-dir-row-md, .wd-dir-row-rev-md)[class*=wd-dir-col]:not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: unset;
                flex-shrink: unset
            }

            .wp-block-wd-container.wd-dir-row-md {
                flex-direction: row
            }

            .wp-block-wd-container.wd-dir-row-rev-md {
                flex-direction: row-reverse
            }

            .wp-block-wd-container:is(.wd-dir-col-md, .wd-dir-col-rev-md) {
                align-items: var(--wd-align)
            }

            .wp-block-wd-container:is(.wd-dir-col-md, .wd-dir-col-rev-md):not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: 100%
            }

            .wp-block-wd-container.wd-dir-col-md {
                flex-direction: column
            }

            .wp-block-wd-container.wd-dir-col-rev-md {
                flex-direction: column-reverse
            }
        }

        @media(max-width: 768.98px) {
            .wp-block-wd-container:is(.wd-dir-row-sm, .wd-dir-row-rev-sm) {
                justify-content: var(--wd-align);
                align-content: flex-start
            }

            .wp-block-wd-container:is(.wd-dir-row-sm, .wd-dir-row-rev-sm)[class*=wd-dir-col]:not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: unset;
                flex-shrink: unset
            }

            .wp-block-wd-container.wd-dir-row-sm {
                flex-direction: row
            }

            .wp-block-wd-container.wd-dir-row-rev-sm {
                flex-direction: row-reverse
            }

            .wp-block-wd-container:is(.wd-dir-col-sm, .wd-dir-col-rev-sm) {
                align-items: var(--wd-align)
            }

            .wp-block-wd-container:is(.wd-dir-col-sm, .wd-dir-col-rev-sm):not([class*=wd-align-is-])>*:not(:is(.wd-custom-width, [class*=wd-align-s-])) {
                width: 100%
            }

            .wp-block-wd-container.wd-dir-col-sm {
                flex-direction: column
            }

            .wp-block-wd-container.wd-dir-col-rev-sm {
                flex-direction: column-reverse
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-container.css */
    </style>
    <style id='wd-block-fw-section-inline-css' type='text/css'>
        .wp-block-wd-section {
            padding-inline: 15px;
            --wd-row-gap: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            row-gap: var(--wd-row-gap);
            width: calc(100vw - var(--wd-scroll-w) - var(--wd-sticky-nav-w));
            inset-inline-start: calc(50% - 50vw + var(--wd-scroll-w)/2 + var(--wd-sticky-nav-w)/2)
        }

        :root .wp-block-wd-section>* {
            margin-bottom: 0
        }

        .wp-block-wd-section>:is(.wp-block-wd-row, .wp-block-wd-container) {
            align-self: center
        }

        .wp-block-wd-section>.wp-block-wd-container:not(.wd-custom-width) {
            max-width: calc(var(--wd-container-w) - 30px)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-fw-section.css */
    </style>
    <style id='wd-mod-nav-style-underline-inline-css' type='text/css'>
        .wd-nav[class*=wd-style-underline] .nav-link-text {
            position: relative;
            display: inline-block;
            padding-block: 1px;
            line-height: 1.2
        }

        .wd-nav[class*=wd-style-underline] .nav-link-text:after {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--wd-primary-color);
            transition: width .4s cubic-bezier(0.19, 1, 0.22, 1)
        }

        .wd-nav[class*=wd-style-underline]>li:is(:hover, .current-menu-item, .wd-active, .active)>a .nav-link-text:after {
            width: 100%
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-nav-style-underline.css */
    </style>
    <style id='wd-tabs-style-space-between-inline-css' type='text/css'>
        @media(min-width: 1025px) {
            .wd-tabs.tabs-design-alt .wd-tabs-header {
                align-items: center;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-tabs-style-space-between.css */
    </style>
    <style id='wd-tabs-base-inline-css' type='text/css'>
        .wd-tabs {
            --wd-row-gap: 20px;
            --wd-header-padding: .001px;
            display: flex;
            flex-direction: column;
            gap: var(--wd-row-gap)
        }

        .wd-tabs .tabs-name {
            text-transform: uppercase;
            font-size: 22px;
            margin-bottom: 0
        }

        .wd-tabs .tabs-name>span {
            vertical-align: middle
        }

        .wd-tabs .tabs-name .img-wrapper {
            display: inline-flex;
            margin-right: 10px
        }

        .wd-tabs-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: var(--wd-header-padding)
        }

        .wd-tabs-header.wp-block .tabs-text {
            display: inline-block
        }

        .wd-nav-tabs {
            --nav-gap: 30px;
            align-items: center
        }

        .wd-nav-tabs>li>a {
            font-size: 16px;
            font-weight: var(--wd-title-font-weight);
            font-style: var(--wd-title-font-style);
            font-family: var(--wd-title-font)
        }

        .wd-tabs.tabs-design-default:not(.wd-header-with-bg) {
            --wd-row-gap: 10px
        }

        .wd-tabs.wd-header-with-bg {
            --wd-header-padding: 15px
        }

        .wd-tabs.wd-header-with-bg .wd-tabs-header {
            background-color: var(--bgcolor-gray-100);
            border-radius: var(--wd-brd-radius)
        }

        .wd-tabs:where(:not(.wd-inited)) .wd-nav-tabs>li:first-child>a {
            color: var(--nav-color-active);
            background-color: var(--nav-bg-active);
            box-shadow: var(--nav-shadow-active);
            border: var(--nav-border-active)
        }

        .wd-tabs:where(:not(.wd-inited)) .wd-nav-tabs[class*=wd-style-underline]>li:first-child>a .nav-link-text:after {
            width: 100%
        }

        .wd-nav-tabs[class*=wd-style-underline] {
            --nav-color: rgba(var(--wd-navigation-color), .7);
            --nav-color-hover: rgba(var(--wd-navigation-color), 1)
        }

        .wd-nav-tabs a {
            gap: 10px
        }

        .wd-nav-tabs .img-wrapper {
            min-width: max-content
        }

        .wd-nav-tabs.wd-icon-pos-start a {
            flex-direction: row
        }

        .wd-nav-tabs.wd-icon-pos-top {
            align-items: flex-end
        }

        .wd-nav-tabs.wd-icon-pos-top a {
            flex-direction: column;
            justify-content: center
        }

        .wd-nav-tabs.wd-icon-pos-end a {
            flex-direction: row-reverse
        }

        .wd-nav-tabs.wd-icon-pos-left a {
            flex-direction: row
        }

        .wd-nav-tabs.wd-icon-pos-right a {
            flex-direction: row-reverse
        }

        .wd-tabs:not(.wd-inited) .wd-tab-content:first-child {
            display: flex;
            opacity: 1;
            transform: none
        }

        .wd-tabs .wd-tabs-content-wrapper {
            position: relative
        }

        .wd-tabs .wd-tab-content {
            display: none;
            opacity: 0;
            transition: all .25s ease;
            transform: translateY(30px)
        }

        .wd-tabs .wd-tab-content>div:not(:is(.wd-nav-arrows, .grid-masonry)) {
            --wd-width: 100%;
            width: var(--wd-width)
        }

        .wd-tabs .wd-tab-content.wd-active {
            display: flex
        }

        .wd-tabs .wd-tab-content.wd-in {
            opacity: 1;
            transform: none
        }

        .wd-tabs .wd-tab-content>.elementor {
            min-width: 1px
        }

        .wp-block-wd-tabs .wd-tab-content {
            --wd-row-gap: 20px;
            flex-direction: column;
            row-gap: var(--wd-row-gap)
        }

        :root .wp-block-wd-tabs .wd-tab-content>* {
            margin-bottom: 0
        }

        @media(max-width: 1024px) {
            .wd-tabs {
                --wd-row-gap: 10px
            }

            .wd-tabs .wd-tabs-header .svg-icon {
                width: 25px !important;
                height: 25px !important
            }

            .wd-tabs .wd-tabs-header .img-wrapper img {
                max-height: 25px;
                width: auto
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-tabs.css */
    </style>
    <style id='wd-product-tabs-inline-css' type='text/css'>
        .wd-products-tabs .wd-wpb {
            margin-bottom: 0
        }

        .wd-products-tabs .wd-tab-content:not(.wd-in) .wd-nav-arrows {
            opacity: 0;
            transition: none
        }

        .wd-products-tabs .wd-tab-content.wd-active {
            display: block
        }

        .wd-products-tabs .wd-nav-arrows {
            transition: opacity .25s ease .25s
        }

        .wd-products-tabs .wd-nav-arrows:where(.wd-pos-together) {
            --wd-arrow-offset-v: calc(var(--wd-row-gap) + -8px)
        }

        .wd-products-tabs .wd-ajax-arrows:where(.wd-pos-together) {
            --wd-arrow-offset-v: calc(var(--wd-row-gap) + 7px)
        }

        .wd-products-tabs .products-bordered-grid :where(.wd-nav-arrows.wd-pos-together) {
            --wd-arrow-offset-v: calc(var(--wd-row-gap) + 7px)
        }

        @media(max-width: 1024px) {
            .wd-products-tabs.tabs-design-simple :where(.wd-nav-arrows.wd-pos-together) {
                --wd-arrow-offset-v: calc(var(--wd-row-gap) + 33px)
            }

            .wd-products-tabs.tabs-design-simple :where(.wd-ajax-arrows.wd-pos-together) {
                --wd-arrow-offset-v: calc(var(--wd-row-gap) + 49px)
            }

            .wd-products-tabs.tabs-design-simple :where(.products-bordered-grid .wd-nav-arrows.wd-pos-together) {
                --wd-arrow-offset-v: calc(var(--wd-row-gap) + 49px)
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-product-tabs.css */
    </style>
    <style id='wd-block-infobox-inline-css' type='text/css'>
        .wp-block-wd-infobox {
            position: relative;
            border-radius: var(--wd-brd-radius);
            display: flex;
            gap: var(--wd-row-gap);
            --wd-row-gap: 15px
        }

        .wp-block-wd-infobox :is(.wp-block-wd-button, .wd-block-infobox-link) {
            z-index: 4
        }

        .wp-block-wd-infobox .wp-block-wd-title.title {
            font-size: 1.2em
        }

        .wp-block-wd-infobox.wd-icon-top {
            flex-direction: column;
            align-items: var(--wd-align)
        }

        .wp-block-wd-infobox.wd-icon-start {
            flex-direction: row
        }

        .wp-block-wd-infobox>.wp-block-wd-icon {
            flex: 0 0 auto;
            z-index: 2
        }

        .wp-block-wd-infobox>.wp-block-wd-container {
            flex: 1 1 auto;
            --wd-row-gap: 10px
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-infobox.css */
    </style>
    <style id='wd-block-carousel-inline-css' type='text/css'>
        .wp-block-wd-carousel-item {
            --wd-row-gap: 20px;
            display: flex;
            flex-direction: column;
            row-gap: var(--wd-row-gap);
            height: auto
        }

        :root .wp-block-wd-carousel-item>* {
            margin-bottom: 0
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-carousel.css */
    </style>
    <style id='wd-swiper-scrollbar-inline-css' type='text/css'>
        .wd-nav-scroll {
            position: relative;
            height: var(--wd-nscroll-height, 5px);
            width: var(--wd-nscroll-width, 100%);
            margin: 20px auto 0;
            border-radius: var(--wd-brd-radius);
            background: var(--wd-nscroll-bg, rgba(var(--bgcolor-black-rgb), 0.07));
            touch-action: none;
            cursor: pointer;
            transition: all .25s ease
        }

        .wd-nav-scroll:not(.wd-horizontal) {
            opacity: 0
        }

        .wd-nav-scroll:after {
            content: "";
            position: absolute;
            inset: -15px
        }

        .wd-nav-scroll.wd-lock {
            display: none
        }

        .wd-nav-scroll-drag {
            position: relative;
            z-index: 1;
            cursor: grab
        }

        .wd-nav-scroll-drag:before {
            content: "";
            display: block;
            height: var(--wd-nscroll-height, 5px);
            width: 100%;
            background: var(--wd-nscroll-drag-bg, rgba(var(--bgcolor-black-rgb), 0.2));
            border-radius: var(--wd-brd-radius);
            transition: all .25s ease
        }

        .wd-nav-scroll-drag:after {
            content: "";
            position: absolute;
            inset: -15px
        }

        .wd-nav-scroll-drag:hover:before,
        .wd-grabbing>.wd-nav-scroll-drag:before {
            background: var(--wd-nscroll-drag-bg-hover, rgba(var(--bgcolor-black-rgb), 0.3))
        }

        .wd-grabbing>.wd-nav-scroll-drag {
            cursor: grabbing
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/lib-swiper-scrollbar.css */
    </style>
    <style id='wd-mc4wp-inline-css' type='text/css'>
        .mc4wp-form {
            --wd-width: 100%;
            width: var(--wd-width)
        }

        .mc4wp-form .wd-grid-f-stretch {
            --wd-f-basis: 150px
        }

        .mc4wp-form .row {
            --wd-gap: 10px;
            display: flex;
            flex-wrap: wrap;
            margin: 0 calc(var(--wd-gap)/-2) calc(var(--wd-gap)*-1)
        }

        .mc4wp-form .row [class*=col] {
            padding-inline: calc(var(--wd-gap)/2);
            margin-bottom: var(--wd-gap)
        }

        .mc4wp-form .row .col {
            flex: 1 1 200px
        }

        .mc4wp-form .row .col-auto {
            flex: 0 0 auto
        }

        .mc4wp-form input[type=submit] {
            padding: var(--btn-accented-padding, var(--btn-padding, 5px 20px));
            min-height: var(--btn-accented-height, var(--btn-height, 42px));
            font-size: var(--btn-accented-font-size, var(--btn-font-size, 13px));
            border-radius: var(--btn-accented-brd-radius);
            color: var(--btn-accented-color);
            box-shadow: var(--btn-accented-box-shadow);
            background-color: var(--btn-accented-bgcolor);
            text-transform: var(--btn-accented-transform, var(--btn-transform, uppercase));
            font-weight: var(--btn-accented-font-weight, var(--btn-font-weight, 600));
            font-family: var(--btn-accented-font-family, var(--btn-font-family, inherit));
            font-style: var(--btn-accented-font-style, var(--btn-font-style, unset))
        }

        .mc4wp-form input[type=submit]:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .mc4wp-form input[type=submit]:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .mc4wp-form-fields {
            display: inline-block;
            width: 100%;
            max-width: var(--wd-max-width)
        }

        body:not(.notifications-sticky) .mc4wp-alert {
            margin-block: 20px 0
        }

        .mc4wp-alert>p {
            margin-bottom: 0
        }

        @media(min-width: 1025px) {
            .mc4wp-form input[type=submit] {
                padding-inline: 35px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/int-mc4wp.css */
    </style>
    <script type="text/javascript" src="{{ asset('frontend/merchandise/wp-includes/js/jquery/jquery.min.js') }}" id="jquery-core-js"></script>
    <script type="text/javascript" src="{{ asset('frontend/merchandise/wp-content/themes/woodmart/js/scripts/global/scrollBar.min.js') }}"
        id="wd-scrollbar-js"></script>
    <meta name="theme-color" content="rgb(245,245,245)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <noscript>
        <style>
            .woocommerce-product-gallery {
                opacity: 1 !important;
            }
        </style>
    </noscript>
    <link rel="icon" href="{{ asset('frontend/wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-45x45.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('frontend/wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('frontend/wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png') }}" />
    <meta name="msapplication-TileImage"
        content="{{ asset('frontend/wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png') }}" />
    <style>

    </style>
    <style id="wd-style-blocks-591-inline-css" data-type="wd-style-blocks-591">
        .wd.wd .wd-47de8d1e {
            font-size: 32px;
        }

        .wd.wd .wd-56e5e720 {
            font-size: 20px;
            --wd-width: 535px;
        }

        .wd.wd .wd-1083b687 {
            --wd-row-gap: 10px;
            justify-content: center;
        }

        .wd.wd .wd-37bdf58d {
            --wd-cat-img-width: 110px;
        }

        .wd.wd .wd-37bdf58d div.product-category .wd-entities-title {
            font-size: 14px;
            text-transform: none;
        }

        .wd.wd .wd-7ae8bcf1 {
            margin-top: -10px;
            margin-bottom: 30px;
        }

        .wd.wd .wd-3f08b74b img {
            border-radius: 0px;
        }

        .wd.wd .wd-df1534d5 {
            font-size: 60px;
            line-height: 1.2em;
            --wd-width: 427px;
        }

        .wd.wd .wd-fe4d192b {
            margin-bottom: 10px;
        }

        .wd.wd .wd-1470b733 {
            color: #333333;
        }

        .wd.wd .wd-853a328b .wd-slide-container {
            --wd-justify-content: flex-end;
            --wd-align-items: flex-start;
        }

        .wd.wd .wd-853a328b .wd-slide-bg img {
            object-position: center left;
        }

        .wd.wd .wd-853a328b .wd-slide-bg {
            background-color: #09175b;
        }

        .wd.wd .wd-1044f57f img {
            border-radius: 0px;
        }

        .wd.wd .wd-f8c4ce99 {
            font-size: 60px;
            line-height: 1.2em;
            --wd-width: 688px;
        }

        .wd.wd .wd-d76f4b8d {
            margin-bottom: 10px;
        }

        .wd.wd .wd-5ac838f6 {
            color: #333333;
        }

        .wd.wd .wd-9a416bd4 .wd-slide-container {
            --wd-justify-content: flex-end;
            --wd-align-items: flex-start;
        }

        .wd.wd .wd-9a416bd4 .wd-slide-bg img {
            object-position: center left;
        }

        .wd.wd .wd-9a416bd4 .wd-slide-bg {
            background-color: #f0cd9b;
        }

        .wd.wd .wd-4f999482 {
            --wd-img-width: 163px;
            --wd-width: 163px;
        }

        .wd.wd .wd-4f999482 img {
            border-radius: 0px;
        }

        .wd.wd .wd-2736457d {
            font-size: 60px;
            line-height: 1.2em;
            margin-bottom: 10px;
            --wd-width: 610px;
        }

        .wd.wd .wd-d7e717ac {
            margin-bottom: 20px;
        }

        .wd.wd .wd-f1c43cb0 {
            color: #333333;
        }

        .wd.wd .wd-93931277 .wd-slide-container {
            --wd-row-gap: 10px;
            --wd-justify-content: flex-end;
            --wd-align-items: flex-start;
        }

        .wd.wd .wd-93931277 .wd-slide-bg img {
            object-position: center left;
        }

        .wd.wd .wd-93931277 .wd-slide-bg {
            background-color: #F3F3F3;
        }

        .wd.wd .wd-14565c68 .wd-slide {
            min-height: 600px;
        }

        .wd.wd .wd-14565c68 .wd-nav-pagin-wrap {
            --wd-align: var(--wd-end);
        }

        .wd.wd .wd-14565c68 {
            margin-bottom: 20px;
        }

        .wd.wd .wd-5c0b6672 {
            margin-bottom: 90px;
        }

        .wd.wd .wd-8155d366 {
            font-size: 40px;
            line-height: 1.2em;
        }

        .wd.wd .wd-12db7e54 {
            flex: 0 0 auto;
        }

        .wd.wd .wd-fedb8996 {
            justify-content: space-between;
            align-items: center;
            align-content: center;
            flex-wrap: wrap;
            --wd-row-gap: 10px;
        }

        .wd.wd .wd-e77fab64 {
            margin-bottom: 70px;
        }

        .wd.wd .wd-7b572e8c img {
            border-radius: 0px;
        }

        .wd.wd .wd-b0b336a8 {
            font-size: 26px;
        }

        .wd.wd .wd-669acf7c {
            color: #333333;
        }

        .wd.wd .wd-dcd1f159 {
            justify-content: center;
        }

        .wd.wd .wd-6b34d997 .wd-products-with-bg,
        .wd.wd .wd-6b34d997 .wd-products-with-bg .wd-product,
        .wd.wd .wd-6b34d997.wd-products-with-bg,
        .wd.wd .wd-6b34d997.wd-products-with-bg .wd-product {
            --wd-prod-bg: #ffffff;
            --wd-bordered-bg: #ffffff;
        }

        .wd.wd .wd-a9f0276a {
            padding-top: 70px;
            padding-bottom: 70px;
            margin-bottom: 70px;
            background-image: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-cubes-bg.jpg') }});
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .wd.wd .wd-7b62efb2 .tabs-name {
            font-size: 40px;
            line-height: 1.2em;
            text-transform: none;
        }

        .wd.wd .wd-7b62efb2 .wd-nav-tabs>li>a {
            text-transform: none;
        }

        .wd.wd .wd-309bab9b {
            margin-bottom: 120px;
        }

        .wd.wd .wd-e5334d67 {
            font-size: 14px;
        }

        .wd.wd .wd-23aea4a6 {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        .wd.wd .wd-cf910214 {
            font-size: 14px;
        }

        .wd.wd .wd-537a081e {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        .wd.wd .wd-bb7c8f76 {
            font-size: 14px;
        }

        .wd.wd .wd-39af9d48 {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        .wd.wd .wd-4ed153df {
            font-size: 14px;
        }

        .wd.wd .wd-245259dd {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        .wd.wd .wd-090647c4 {
            margin-bottom: 90px;
        }

        .wd.wd .wd-9e91bcf0 img {
            border-radius: 0px;
        }

        .wd.wd .wd-29c12066 {
            font-size: 32px;
            line-height: 1.2em;
        }

        .wd.wd .wd-a5b20c44 .wd-highlight {
            text-decoration: underline;
        }

        .wd.wd .wd-9b3568f9 {
            --wd-form-bg: #fefefe;
            --wd-width: 520px;
        }

        .wd.wd .wd-066a5243 {
            --wd-align: var(--wd-center);
            padding: 50px 30px 50px 30px;
            margin-bottom: 90px;
            background-color: #f5f5f5;
            border-radius: 16px;
        }

        .wd.wd .wd-ac487a7f {
            font-size: 40px;
            line-height: 1.2em;
        }

        .wd.wd .wd-0c7ef44c {
            --wd-aspect-ratio: 1/1;
            margin-top: 10px;
        }

        .wd.wd .wd-cdd11e25 {
            --wd-align: var(--wd-center);
            margin-bottom: 20px;
        }

        @media (min-width: 769px) {
            .wd.wd .wd-dcd1f159 {
                flex: 0 1 calc(30% - var(--wd-col-gap) * 1 / 2);
            }

            .wd.wd .wd-a01cba50 {
                flex: 0 1 calc(70% - var(--wd-col-gap) * 1 / 2);
            }
        }

        @media (max-width: 1024px) {
            .wd.wd .wd-47de8d1e {
                font-size: 28px;
            }

            .wd.wd .wd-56e5e720 {
                font-size: 18px;
            }

            .wd.wd .wd-7ae8bcf1 {
                margin-top: -20px;
            }

            .wd.wd .wd-df1534d5 {
                font-size: 48px;
                --wd-width: 320px;
            }

            .wd.wd .wd-f8c4ce99 {
                font-size: 48px;
                --wd-width: 522px;
            }

            .wd.wd .wd-9a416bd4 .wd-slide-bg img {
                object-position: center left;
            }

            .wd.wd .wd-2736457d {
                font-size: 48px;
                --wd-width: 400px;
            }

            .wd.wd .wd-14565c68 .wd-slide {
                min-height: 500px;
            }

            .wd.wd .wd-5c0b6672 {
                margin-bottom: 70px;
            }

            .wd.wd .wd-8155d366 {
                font-size: 32px;
            }

            .wd.wd .wd-b0b336a8 {
                font-size: 24px;
                --wd-width: 263px;
            }

            .wd.wd .wd-7b62efb2 .tabs-name {
                font-size: 32px;
            }

            .wd.wd .wd-309bab9b {
                margin-bottom: 70px;
            }

            .wd.wd .wd-090647c4 {
                margin-bottom: 70px;
            }

            .wd.wd .wd-29c12066 {
                font-size: 28px;
            }

            .wd.wd .wd-066a5243 {
                margin-bottom: 70px;
            }

            .wd.wd .wd-ac487a7f {
                font-size: 32px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .wd.wd .wd-1083b687 {
                flex: 0 1 calc(100% - var(--wd-col-gap) * 0 / 1);
            }

            .wd.wd .wd-03826530 {
                flex: 0 1 calc(100% - var(--wd-col-gap) * 0 / 1);
            }

            .wd.wd .wd-dcd1f159 {
                flex: 0 1 calc(40% - var(--wd-col-gap) * 1 / 2);
            }

            .wd.wd .wd-a01cba50 {
                flex: 0 1 calc(60% - var(--wd-col-gap) * 1 / 2);
            }
        }

        @media (max-width: 768.98px) {
            .wd.wd .wd-47de8d1e {
                font-size: 24px;
            }

            .wd.wd .wd-56e5e720 {
                font-size: 16px;
            }

            .wd.wd .wd-7ae8bcf1 {
                margin-bottom: 20px;
            }

            .wd.wd .wd-df1534d5 {
                font-size: 32px;
            }

            .wd.wd .wd-853a328b .wd-slide-bg img {
                object-position: -290px 0px;
            }

            .wd.wd .wd-f8c4ce99 {
                font-size: 32px;
            }

            .wd.wd .wd-9a416bd4 .wd-slide-bg img {
                object-position: -320px 0px;
            }

            .wd.wd .wd-4f999482 {
                --wd-img-width: 130px;
                --wd-width: 130px;
            }

            .wd.wd .wd-2736457d {
                font-size: 32px;
            }

            .wd.wd .wd-93931277 .wd-slide-bg img {
                object-position: -370px 0px;
            }

            .wd.wd .wd-5c0b6672 {
                margin-bottom: 50px;
            }

            .wd.wd .wd-8155d366 {
                font-size: 28px;
            }

            .wd.wd .wd-e77fab64 {
                margin-bottom: 50px;
            }

            .wd.wd .wd-b0b336a8 {
                font-size: 18px;
                --wd-width: 100%;
            }

            .wd.wd .wd-a9f0276a {
                padding-top: 50px;
                padding-bottom: 50px;
                margin-bottom: 50px;
            }

            .wd.wd .wd-7b62efb2 .tabs-name {
                font-size: 28px;
            }

            .wd.wd .wd-309bab9b {
                margin-bottom: 50px;
            }

            .wd.wd .wd-090647c4 {
                margin-bottom: 50px;
            }

            .wd.wd .wd-29c12066 {
                font-size: 22px;
            }

            .wd.wd .wd-066a5243 {
                padding-top: 30px;
                padding-bottom: 30px;
                margin-bottom: 50px;
            }

            .wd.wd .wd-ac487a7f {
                font-size: 28px;
            }

            .wd.wd .wd-cdd11e25 {
                margin-bottom: 0px;
            }
        }
    </style>
    <style id="wd-style-header_747230-inline-css" data-type="wd-style-header_747230">
        :root {
            --wd-top-bar-h: .00001px;
            --wd-top-bar-sm-h: .00001px;
            --wd-top-bar-sticky-h: .00001px;
            --wd-top-bar-brd-w: .00001px;

            --wd-header-general-h: 70px;
            --wd-header-general-sm-h: 70px;
            --wd-header-general-sticky-h: 70px;
            --wd-header-general-brd-w: .00001px;

            --wd-header-bottom-h: .00001px;
            --wd-header-bottom-sm-h: .00001px;
            --wd-header-bottom-sticky-h: .00001px;
            --wd-header-bottom-brd-w: .00001px;

            --wd-header-clone-h: .00001px;

            --wd-header-brd-w: calc(var(--wd-top-bar-brd-w) + var(--wd-header-general-brd-w) + var(--wd-header-bottom-brd-w));
            --wd-header-h: calc(var(--wd-top-bar-h) + var(--wd-header-general-h) + var(--wd-header-bottom-h) + var(--wd-header-brd-w));
            --wd-header-sticky-h: calc(var(--wd-top-bar-sticky-h) + var(--wd-header-general-sticky-h) + var(--wd-header-bottom-sticky-h) + var(--wd-header-clone-h) + var(--wd-header-brd-w));
            --wd-header-sm-h: calc(var(--wd-top-bar-sm-h) + var(--wd-header-general-sm-h) + var(--wd-header-bottom-sm-h) + var(--wd-header-brd-w));
        }

        .whb-sticked .whb-general-header .wd-dropdown:not(.sub-sub-menu) {
            margin-top: 14px;
        }

        .whb-sticked .whb-general-header .wd-dropdown:not(.sub-sub-menu):after {
            height: 25px;
        }

        .whb-d3ki4iaou697ll19rjk8>ul>li>.wd-dropdown-menu,
        .whb-d3ki4iaou697ll19rjk8 .wd-design-default .wd-dropdown {
            --wd-dropdown-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.11);
        }

        .whb-row .whb-25hasyb8l3nqyybphmhc.wd-tools-element .wd-tools-inner,
        .whb-row .whb-25hasyb8l3nqyybphmhc.wd-tools-element>a>.wd-tools-icon {
            color: rgba(255, 255, 255, 1);
            background-color: rgba(17, 18, 17, 1);
        }

        .whb-row .whb-25hasyb8l3nqyybphmhc.wd-tools-element:hover .wd-tools-inner,
        .whb-row .whb-25hasyb8l3nqyybphmhc.wd-tools-element:hover>a>.wd-tools-icon {
            color: rgba(255, 255, 255, 1);
            background-color: rgba(43, 44, 43, 1);
        }

        .whb-general-header {
            background-color: rgba(245, 245, 245, 1);

        }
    </style>
    <style id="wd-style-theme_settings_default-inline-css" data-type="wd-style-theme_settings_default">
        :root {
            --wd-cat-brd-radius: 50%;
            --wd-text-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-text-font-weight: 400;
            --wd-text-color: #767676;
            --wd-text-font-size: 16px;
            --wd-title-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-title-font-weight: 600;
            --wd-title-color: #242424;
            --wd-entities-title-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-entities-title-font-weight: 500;
            --wd-entities-title-color: #333333;
            --wd-entities-title-color-hover: rgba(51, 51, 51, 0.65);
            --wd-alternative-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-widget-title-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-widget-title-font-weight: 600;
            --wd-widget-title-transform: none;
            --wd-widget-title-color: #333;
            --wd-widget-title-font-size: 20px;
            --wd-header-el-font: "Lexend Deca", Arial, Helvetica, sans-serif;
            --wd-header-el-font-weight: 600;
            --wd-header-el-transform: none;
            --wd-header-el-font-size: 16px;
            --wd-brd-radius: 16px;
            --wd-otl-style: dotted;
            --wd-otl-width: 2px;
            --wd-primary-color: rgb(230, 57, 70);
            --wd-alternative-color: rgb(17, 18, 17);
            --btn-default-bgcolor: rgb(17, 18, 17);
            --btn-default-bgcolor-hover: rgb(51, 51, 51);
            --btn-accented-bgcolor: rgb(230, 57, 70);
            --btn-accented-bgcolor-hover: rgb(237, 173, 23);
            --btn-transform: capitalize;
            --wd-form-brd-width: 1px;
            --notices-success-bg: #459647;
            --notices-success-color: #fff;
            --notices-warning-bg: #E0B252;
            --notices-warning-color: #fff;
            --wd-link-color: #333333;
            --wd-link-color-hover: #242424;
        }

        .wd-age-verify-wrap {
            --wd-popup-width: 500px;
        }

        .wd-popup.wd-promo-popup {
            background-color: #111111;
            background-image: none;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: left center;
        }

        .wd-promo-popup-wrap {
            --wd-popup-width: 800px;
        }

        :is(.woodmart-woocommerce-layered-nav, .wd-product-category-filter) .wd-scroll-content {
            max-height: 223px;
        }

        .wd-page-title .wd-page-title-bg img {
            object-fit: cover;
            object-position: center center;
        }

        .wd-footer {
            background-color: rgb(245, 245, 244);
            background-image: none;
        }

        html .wd-checkout-steps {
            font-size: 16px;
            text-transform: none;
        }

        html table th {
            text-transform: none;
        }

        html .wd-nav-mobile>li>a,
        html .wd-nav.wd-layout-drilldown>li>a,
        html .wd-nav.wd-layout-drilldown>li [class*="sub-menu"]> :is(.menu-item, .wd-drilldown-back)>a,
        html .wd-nav.wd-layout-drilldown .woocommerce-MyAccount-navigation-link>a {
            text-transform: none;
        }

        html .btn.wd-buy-now-btn {
            color: rgb(255, 255, 255);
            background: rgb(17, 18, 17);
        }

        html .btn.wd-buy-now-btn:hover {
            color: rgb(255, 255, 255);
            background: rgb(51, 51, 51);
        }

        .wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style)) {
            --wd-arrow-size: 40px;
            --wd-arrow-icon-size: 16px;
            --wd-arrow-offset-h: 15px;
            --wd-arrow-color: rgb(36, 36, 36);
            --wd-arrow-color-hover: rgb(255, 255, 255);
            --wd-arrow-color-dis: rgb(36, 36, 36);
            --wd-arrow-bg: rgb(244, 244, 244);
            --wd-arrow-bg-hover: rgb(230, 57, 70);
            --wd-arrow-bg-dis: rgb(244, 244, 244);
            --wd-arrow-radius: 20px;
            --wd-arrow-brd-color: rgba(0, 0, 0, 0.11);
            --wd-arrow-brd: 1px solid;
        }

        .wd-nav-scroll {
            --wd-nscroll-drag-bg: rgb(17, 18, 17);
            --wd-nscroll-drag-bg-hover: rgb(17, 18, 17);
        }

        .wd .product-label.onsale {
            background-color: rgb(77, 172, 153);
            color: rgb(255, 255, 255);
        }

        .wd .product-label.new {
            background-color: rgb(77, 172, 153);
            color: rgb(255, 255, 255);
        }

        .wd .product-label.featured {
            background-color: rgb(77, 172, 153);
            color: rgb(255, 255, 255);
        }

        .mfp-wrap.wd-popup-quick-view-wrap {
            --wd-popup-width: 920px;
        }

        @media (max-width: 1024px) {
            :root {
                --wd-widget-title-font-size: 18px;
            }

            .wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style)) {
                --wd-arrow-offset-h: -30px;
            }

        }

        @media (max-width: 768.98px) {
            .wd-nav-arrows.wd-pos-sep:not(:where(.wd-custom-style)) {
                --wd-arrow-offset-h: 15px;
            }

        }

        :root {
            --wd-container-w: 1324px;
            --wd-form-brd-radius: 5px;
            --btn-default-color: #fff;
            --btn-default-color-hover: #fff;
            --btn-accented-color: #333;
            --btn-accented-color-hover: #333;
            --btn-default-brd-radius: 5px;
            --btn-default-box-shadow: none;
            --btn-default-box-shadow-hover: none;
            --btn-accented-brd-radius: 5px;
            --btn-accented-box-shadow: none;
            --btn-accented-box-shadow-hover: none;
        }

        .wd-page-title {
            background-color: rgb(230, 57, 70);
        }
    </style>
    <style id="wd-style-local-google-fonts-inline-css" data-type="wd-style-local-google-fonts">
        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2') }}) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2') }}) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2') }}) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2') }}) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2') }}) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2') }}) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2') }}) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2') }}) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('frontend/merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2') }}) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('frontend/assets/gms-custom.css') }}">
    @stack('styles')
</head>
