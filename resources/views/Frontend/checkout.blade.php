@extends('Frontend.Layout.app')
@push('styles')
    <link rel="preload" as="font" href="merchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2"
        type="font/woff2" crossorigin>
    <style id='wp-img-auto-sizes-contain-inline-css' type='text/css'>
        img:is([sizes=auto i], [sizes^="auto," i]) {
            contain-intrinsic-size: 3000px 1500px
        }

        /*# sourceURL=wp-img-auto-sizes-contain-inline-css */
    </style>
    <link rel='stylesheet' id='select2-css' href='merchandise/wp-content/plugins/woocommerce/assets/css/select2.css'
        type='text/css' media='all' />
    <style id='woocommerce-inline-inline-css' type='text/css'>
        .woocommerce form .form-row .required {
            visibility: visible;
        }

        /*# sourceURL=woocommerce-inline-inline-css */
    </style>
    <link rel='stylesheet' id='wd-style-base-css' href='merchandise/wp-content/themes/woodmart/css/parts/base.css'
        type='text/css' media='all' />
    <style id='wd-style-base-inline-css' type='text/css'>
        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: "woodmart-font";
            src: url("merchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2") format("woff2");
        }

        /* Mobile logo fix */
        .whb-cqgb8qgsj8fpo4qz9frx .wd-logo img {
            transform: scale(1.3) !important;
            transform-origin: center center !important;
        }

        /*# sourceURL=wd-style-base-inline-css */
    </style>
    <link rel='stylesheet' id='wd-header-base-css' href='merchandise/wp-content/themes/woodmart/css/parts/header-base.css'
        type='text/css' media='all' />
    <style id='wd-int-yoast-inline-css' type='text/css'>
        .yoast-breadcrumb>span {
            color: var(--wd-bcrumb-delim-color)
        }

        .yoast-breadcrumb .breadcrumb_last {
            --wd-link-color: var(--wd-bcrumb-color-active);
            --wd-link-color-hover: color-mix(in srgb, var(--wd-bcrumb-color-active), transparent 25%);
            color: var(--wd-bcrumb-color-active)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/int-yoast.css */
    </style>
    <link rel='stylesheet' id='wd-woo-stripe-css' href='merchandise/wp-content/themes/woodmart/css/parts/int-woo-stripe.css'
        type='text/css' media='all' />
    <style id='wd-int-wordfence-inline-css' type='text/css'>
        .wfls-login-message {
            scroll-margin-top: 150px;
            max-width: calc(var(--wd-container-w) - 30px);
            margin-inline: auto;
            padding-block: 15px
        }

        .wfls-login-message ul {
            margin-bottom: 0
        }

        #wfls-prompt-overlay {
            margin-top: 20px;
            border: none !important
        }

        #wfls-prompt-overlay .submit {
            margin-bottom: 0
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/int-wordfence.css */
    </style>
    <link rel='stylesheet' id='wd-woocommerce-base-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woocommerce-base.css' type='text/css' media='all' />
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
    <link rel='stylesheet' id='wd-select2-css' href='merchandise/wp-content/themes/woodmart/css/parts/woo-lib-select2.css'
        type='text/css' media='all' />
    <link rel='stylesheet' id='wd-woo-mod-shop-table-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-mod-shop-table.css' type='text/css' media='all' />
    <style id='wd-woo-mod-grid-inline-css' type='text/css'>
        .col2-set {
            display: flex;
            flex-wrap: wrap;
            gap: 30px
        }

        .col2-set :is(.col-1, .col-2) {
            flex: 1 0 0;
            max-width: 100%;
            padding-inline: 0
        }

        @media(min-width: 1025px) {
            p:where(.form-row-first, .form-row-last) {
                overflow: visible;
                width: 48%
            }

            p.form-row-first {
                float: left
            }

            p.form-row-last {
                float: right
            }

            p.form-row-wide {
                clear: both
            }
        }

        @media(max-width: 768.98px) {
            .col2-set :is(.col-1, .col-2) {
                flex-basis: 100%
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-grid.css */
    </style>
    <link rel='stylesheet' id='wd-page-checkout-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-page-checkout.css' type='text/css' media='all' />
    <style id='wd-page-checkout-payment-methods-inline-css' type='text/css'>
        .payment_methods {
            --li-mb: 15px;
            --li-pl: 0;
            list-style: none
        }

        .payment_methods li img {
            margin-inline-start: 5px;
            margin-inline-end: 5px;
            max-height: 40px
        }

        .payment_methods li>label {
            display: inline;
            margin-bottom: 0
        }

        .payment_methods .payment_box {
            --wd-tags-mb: 10px;
            position: relative;
            margin-top: 15px;
            padding: 15px;
            background-color: var(--bgcolor-white);
            box-shadow: 1px 1px 2px rgba(0, 0, 0, .05);
            border-radius: var(--wd-brd-radius)
        }

        .payment_methods .payment_box p:last-child {
            margin-bottom: 0
        }

        .payment_methods .payment_box:before {
            content: "";
            position: absolute;
            inset-inline-start: 25px;
            bottom: 100%;
            background-color: inherit;
            width: 15px;
            height: 15px;
            clip-path: polygon(50% 50%, 0% 103%, 100% 103%)
        }

        .payment_methods fieldset {
            margin: 5px 0 0 0;
            padding: 0;
            border: none
        }

        .woocommerce-terms-and-conditions-wrapper {
            padding-top: 20px;
            border-top: 1px solid var(--brdcolor-gray-300)
        }

        .woocommerce-terms-and-conditions-wrapper a {
            font-weight: 600
        }

        .woocommerce-checkout-payment .woocommerce-privacy-policy-text:not(:last-child) {
            margin-bottom: 20px;
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        .woocommerce-checkout-payment .woocommerce-privacy-policy-text:empty {
            display: none
        }

        .place-order .woocommerce-form__label span {
            vertical-align: middle
        }

        .place-order .woocommerce-invalid .woocommerce-form__label :is(span, a) {
            color: #ca1919
        }

        .woocommerce-terms-and-conditions {
            margin-bottom: 20px;
            padding: 20px;
            background-color: var(--bgcolor-white);
            box-shadow: 1px 1px 2px rgba(0, 0, 0, .05);
            border-radius: var(--wd-brd-radius)
        }

        #place_order {
            padding: 5px 28px;
            min-height: 48px;
            font-size: 14px;
            border-radius: var(--btn-accented-brd-radius);
            color: var(--btn-accented-color);
            box-shadow: var(--btn-accented-box-shadow);
            background-color: var(--btn-accented-bgcolor);
            text-transform: var(--btn-accented-transform, var(--btn-transform, uppercase));
            font-weight: var(--btn-accented-font-weight, var(--btn-font-weight, 600));
            font-family: var(--btn-accented-font-family, var(--btn-font-family, inherit));
            font-style: var(--btn-accented-font-style, var(--btn-font-style, unset))
        }

        #place_order:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        #place_order:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-checkout-el-payment-methods.css */
    </style>
    <style id='wd-woo-page-checkout-builder-inline-css' type='text/css'>
        .wd-checkout-form {
            --wd-row-gap: 20px;
            display: flex;
            flex-direction: column;
            row-gap: var(--wd-row-gap)
        }

        :root .wd-checkout-form>* {
            margin-bottom: 0
        }

        [class*=__field-wrapper] {
            --wd-col: 4;
            --wd-gap: 20px;
            display: grid;
            grid-template-columns: repeat(var(--wd-col), minmax(0, 1fr));
            gap: var(--wd-gap)
        }

        [class*=__field-wrapper]>* {
            grid-column: auto/span var(--wd-col);
            margin-bottom: 0;
            width: unset
        }

        @media(min-width: 1025px) {
            [class*=__field-wrapper]>:is(.form-row-first, .form-row-last) {
                --wd-col: 2
            }
        }

        :is(.wd-checkout-login, .wd-checkout-coupon) {
            display: flex;
            flex-direction: column;
            align-items: var(--wd-align)
        }

        :is(.wd-checkout-login, .wd-checkout-coupon) :is(.woocommerce-form-coupon-toggle, .woocommerce-form-login-toggle)>div {
            margin-bottom: 0;
            justify-content: var(--wd-align)
        }

        :is(.wd-checkout-login, .wd-checkout-coupon) :is(.woocommerce-form-coupon, .woocommerce-form-login.hidden-form) {
            width: 100%;
            margin-block: 20px 0
        }

        :is(.wd-checkout-login, .wd-checkout-coupon)>[role=alert] {
            margin-block: 20px 0
        }

        .wd-billing-details>*:not(:last-child) {
            margin-bottom: 20px
        }

        .e-con .wd-billing-details>div>*:not(:last-child) {
            margin-bottom: 20px
        }

        .wd-billing-details:not(.wd-title-show) .woocommerce-billing-fields>h3 {
            display: none
        }

        .wd-shipping-details>*:not(:last-child) {
            margin-bottom: 20px
        }

        .e-con .wd-shipping-details>div>*:not(:last-child) {
            margin-bottom: 20px
        }

        .wd-shipping-details:not(.wd-title-show) .woocommerce-additional-fields>h3 {
            display: none
        }

        .wd-payment-methods .place-order {
            display: flex;
            flex-direction: column
        }

        .wd-payment-methods #place_order {
            align-self: var(--wd-btn-align, start)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-checkout-builder.css */
    </style>
    <style id='wd-woo-opt-manage-checkout-prod-inline-css' type='text/css'>
        .wd-checkout-prod {
            position: relative;
            display: flex;
            flex-grow: 1;
            align-items: center
        }

        .wd-checkout-prod-img {
            margin-inline-end: 10px
        }

        .wd-checkout-prod-img img {
            min-width: 65px;
            max-width: 65px;
            border-radius: calc(var(--wd-brd-radius)/1.5)
        }

        .wd-checkout-prod-cont {
            display: flex;
            flex-grow: 1;
            align-items: center;
            justify-content: space-between;
            text-align: start
        }

        .wd-checkout-prod-cont .quantity {
            --wd-form-height: 32px;
            order: 1
        }

        .wd-checkout-prod-title {
            display: flex;
            flex-wrap: wrap;
            margin-inline-end: 10px
        }

        .wd-checkout-prod-title>.cart-product-label-link {
            color: var(--wd-entities-title-color);
            text-decoration: none
        }

        .wd-checkout-prod-title>.cart-product-label-link:hover {
            color: var(--wd-entities-title-color-hover)
        }

        .wd-checkout-prod-title>:is(.cart-product-label-link, .cart-product-label) {
            margin-inline-end: 5px
        }

        .wd-checkout-prod-title>*:not(:is(.cart-product-label-link, .cart-product-label, .product-quantity)) {
            margin-top: 10px;
            width: 100%;
            max-width: 100% !important
        }

        .wd-checkout-prod-total {
            text-align: end
        }

        .wd-checkout-remove-btn-wrapp {
            margin-inline: -5px 5px;
            width: 25px;
            flex-shrink: 0
        }

        .wd-checkout-remove-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 25px;
            color: var(--color-gray-800);
            font-weight: 600;
            font-size: 10px;
            text-decoration: none !important
        }

        .wd-checkout-remove-btn:hover {
            color: var(--color-gray-500)
        }

        .wd-checkout-remove-btn:after {
            content: "\f112";
            font-family: "woodmart-font"
        }

        @media(max-width: 576px) {
            .wd-manage-on thead .product-total {
                display: none
            }

            .wd-checkout-prod-cont {
                display: block
            }

            .wd-checkout-prod-title {
                margin-inline-end: 0;
                margin-bottom: 10px
            }

            .wd-checkout-prod-total {
                text-align: start
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-opt-manage-checkout-prod.css */
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
    <style id='wd-woo-opt-fbt-cart-inline-css' type='text/css'>
        .product_list_widget li[class*=wd-fbt-item]:not(.wd-fbt-item-last) {
            margin-bottom: 0;
            border-bottom: 0
        }

        .cart-widget-side .woocommerce-mini-cart .mini_cart_item.wd-fbt-item {
            padding-block: 8px
        }

        .cart-widget-side .woocommerce-mini-cart .mini_cart_item.wd-fbt-item-first {
            padding-bottom: 8px
        }

        .cart-widget-side .woocommerce-mini-cart .mini_cart_item.wd-fbt-item-last {
            padding-top: 8px
        }

        .woocommerce-checkout-review-order-table .cart_item:is(.wd-fbt-item-first, .wd-fbt-item) {
            border-bottom: none
        }

        .woocommerce-checkout-review-order-table .cart_item:is(.wd-fbt-item-first, .wd-fbt-item) td {
            padding-bottom: 0
        }

        .woocommerce-table--order-details .order_item:is(.wd-fbt-item-first, .wd-fbt-item) td {
            padding-bottom: 0;
            border-bottom: none
        }

        @media(min-width: 769px) {
            .shop_table_responsive .cart_item.wd-fbt-item-first .product-remove a {
                margin-top: 15px
            }

            .shop_table_responsive .cart_item[class*=wd-fbt-item]:not(.wd-fbt-item-last) td {
                padding-bottom: 0;
                border-bottom: none
            }
        }

        @media(max-width: 768.98px) {
            .shop_table_responsive .cart_item[class*=wd-fbt-item]:not(.wd-fbt-item-last) {
                margin-bottom: 10px;
                padding-bottom: 0;
                border-bottom: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-opt-fbt-cart.css */
    </style>
    <style id='wd-woo-mod-cart-labels-inline-css' type='text/css'>
        .wd-cart-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            text-align: center;
            font-weight: 400;
            font-size: 0
        }

        .wd-cart-label:before {
            color: var(--color-gray-300);
            font-size: calc(var(--wd-text-font-size) - 2px);
            transition: all .25s ease;
            font-family: "woodmart-font"
        }

        .wd-cart-label:hover:before {
            color: var(--color-gray-500)
        }

        .wd-fbt-label:before {
            content: "\f182"
        }

        .wd-fg-label:before {
            content: "\f11e"
        }

        .shop_table .product-name:has(.wd-cart-label) a:not(:last-child) {
            margin-inline-end: 3px
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-cart-labels.css */
    </style>
    <style id='child-style-inline-css' type='text/css'>
        /*
         Theme Name:   Woodmart Child
         Description:  Woodmart Child Theme
         Author:       XTemos
         Author URI:   http://xtemos.com
         Template:     woodmart
         Version:      1.0.0
         Text Domain:  woodmart
        */

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
    <style id='wd-mod-nav-style-bg-inline-css' type='text/css'>
        .wd-nav:where(.wd-style-bg) {
            --nav-pd: 5px 12px;
            --nav-color-hover: var(--wd-primary-color);
            --nav-bg-hover: color-mix(in srgb, var(--wd-primary-color), transparent 75%);
            --nav-radius: 40px;
            gap: var(--nav-gap-v) calc(var(--nav-gap) - 15px)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-nav-style-bg.css */
    </style>
    <style id='wd-mod-nav-style-bordered-separated-inline-css' type='text/css'>
        .wd-nav:is(.wd-style-bordered, .wd-style-separated)>li {
            display: flex;
            flex-direction: row
        }

        .wd-nav:is(.wd-style-bordered, .wd-style-separated)>li:not(:last-child):after {
            content: "";
            position: relative;
            inset-inline-end: calc(var(--nav-gap)/2*-1);
            border-right: 1px solid rgba(0, 0, 0, .105)
        }

        :is(.color-scheme-light, .whb-color-light) .wd-nav:is(.wd-style-bordered, .wd-style-separated)>li:not(:last-child):after {
            border-color: hsla(0, 0%, 100%, .25)
        }

        .wd-nav.wd-style-separated>li {
            align-items: center
        }

        .wd-nav.wd-style-separated>li:not(:last-child):after {
            height: 18px
        }

        .wd-nav.wd-style-bordered>li {
            align-items: stretch
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-nav-style-bordered-separated.css */
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
    <style id='wd-tabs-style-aside-inline-css' type='text/css'>
        @media(min-width: 1025px) {
            .wd-tabs.tabs-design-aside {
                position: relative;
                display: grid;
                align-items: flex-start;
                grid-template-columns: var(--wd-side-width, 300px) 1fr;
                gap: var(--wd-row-gap)
            }

            .wd-tabs.tabs-design-aside .wd-tabs-header {
                --text-align: start
            }

            .wd-tabs.tabs-design-aside .wd-nav-tabs {
                flex-direction: column;
                align-items: flex-start;
                --nav-gap: 5px;
                --nav-gap-v: var(--nav-gap)
            }

            .wd-tabs.tabs-design-aside .wd-nav-tabs>li {
                cursor: pointer
            }

            .wd-tabs.tabs-design-aside .wd-nav-tabs>li>a {
                display: inline-flex
            }

            .wd-tabs.tabs-design-aside .wd-tabs-content-wrapper {
                min-width: 1px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-tabs-style-aside.css */
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
    <style id='wd-tabs-style-bordered-inline-css' type='text/css'>
        .wd-tabs.tabs-design-simple .tabs-name {
            position: relative;
            z-index: 1;
            margin-bottom: -2px;
            padding-block: 5px;
            border-bottom: 2px solid var(--wd-primary-color);
            vertical-align: middle
        }

        .wd-tabs.tabs-design-simple .tabs-name>span {
            vertical-align: bottom
        }

        .wd-tabs.tabs-design-simple .tabs-name .img-wrapper {
            margin-inline-start: 4px
        }

        .wd-tabs.tabs-design-simple .wd-nav-tabs li a {
            font-size: 14px
        }

        @media(min-width: 1025px) {
            .wd-tabs.tabs-design-simple .wd-tabs-header {
                flex-direction: row;
                align-items: flex-end;
                gap: 25px;
                border-bottom: 2px solid var(--brdcolor-gray-300)
            }
        }

        @media(max-width: 1024px) {
            .wd-tabs.tabs-design-simple .wd-tabs-header {
                --text-align: start;
                align-items: flex-start;
                gap: 0
            }

            .wd-tabs.tabs-design-simple .wd-nav-tabs-wrapper {
                flex: 1 1 auto;
                max-width: 100%;
                width: 100%;
                border-top: 2px solid var(--brdcolor-gray-300)
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-tabs-style-bordered.css */
    </style>
    <style id='wd-block-menu-list-inline-css' type='text/css'>
        .wp-block-wd-menu-list {
            --wd-row-gap: 0.001px
        }

        .wp-block-wd-menu-list li:not(:last-child) {
            margin-bottom: var(--wd-row-gap)
        }

        .wp-block-wd-menu-list>li>a {
            margin-bottom: var(--wd-row-gap)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-menu-list.css */
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
    <link rel='stylesheet' id='wd-block-container-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/block-container.css' type='text/css' media='all' />
    <style id='wd-block-banner-inline-css' type='text/css'>
        .wp-block-wd-cover {
            --wd-justify-content: start;
            --wd-align-items: start;
            --wd-otl-offset: calc(var(--wd-otl-width) * -1);
            position: relative;
            display: flex;
            overflow: hidden;
            padding: 30px;
            border-radius: var(--wd-brd-radius);
            aspect-ratio: var(--wd-aspect-ratio);
            justify-content: var(--wd-justify-content);
            align-items: var(--wd-align-items)
        }

        .wp-block-wd-cover>.wd-bg-overlay {
            z-index: 2
        }

        .wp-block-wd-cover>.wp-block-wd-container {
            pointer-events: none;
            z-index: 4;
            --wd-width: fit-content;
            --wd-row-gap: 10px;
            max-width: 100%
        }

        .wp-block-wd-cover .wp-block-wd-button {
            pointer-events: auto
        }

        .wd-dropdown:not(:hover) .wp-block-wd-cover .wp-block-wd-button {
            pointer-events: none
        }

        .wd-block-cover-img {
            --wd-trans-main: all .5s cubic-bezier(0, 0, .44, 1.18);
            position: absolute;
            inset: 0;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            perspective: 800px;
            -webkit-perspective: 800px;
            transition: var(--wd-trans-main)
        }

        .wd-block-cover-img :is(img, picture) {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center
        }

        .wp-block-wd-cover.wd-hover-zoom-in .wd-block-cover-img {
            transform: scale(1) translate3d(0, 0, 0)
        }

        .wp-block-wd-cover.wd-hover-zoom-in:hover .wd-block-cover-img {
            transform: scale(1.09) translate3d(0, 0, 0)
        }

        .wp-block-wd-cover.wd-hover-zoom-out .wd-block-cover-img {
            transform: scale(1.09) translate3d(0, 0, 0)
        }

        .wp-block-wd-cover.wd-hover-zoom-out:hover .wd-block-cover-img {
            transform: scale(1) translate3d(0, 0, 0)
        }

        .wp-block-wd-cover>:where(.wp-block-wd-container)>*:not([class*=wd-bg-]) {
            z-index: 6
        }

        .wp-block-wd-cover>:where(.wp-block-wd-container):not(.wd-transform) {
            transform: translate3d(0, 0, 0)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-banner.css */
    </style>
    <style id='wd-header-search-inline-css' type='text/css'>
        .wd-header-search {
            --wd-tools-icon: "\f130"
        }

        .wd-header-search .wd-tools-icon img,
        .wd-header-search .wd-tools-icon:before {
            transition: opacity .3s ease
        }

        .wd-header-search .wd-tools-icon:after {
            position: absolute;
            top: 50%;
            left: 50%;
            display: block;
            font-size: var(--wd-tools-icon-width, var(--wd-tools-icon-base-width));
            opacity: 0;
            transform: translate(-50%, -50%);
            content: "\f112";
            font-family: "woodmart-font"
        }

        .wd-header-search:is(.wd-design-6.wd-with-wrap, .wd-design-7.wd-with-wrap, .wd-design-8) {
            min-width: var(--wd-tools-icon-base-width)
        }

        .wd-header-search:is(.wd-design-6.wd-with-wrap, .wd-design-7.wd-with-wrap, .wd-design-8) .wd-tools-icon:after {
            inset-inline-start: var(--wd-tools-sp);
            inset-inline-end: auto;
            transform: translateY(-50%)
        }

        .wd-search-opened .wd-header-search .wd-tools-icon:after {
            opacity: 1;
            transition: opacity .3s ease
        }

        .wd-search-opened .wd-header-search .wd-tools-icon img,
        .wd-search-opened .wd-header-search .wd-tools-icon:before {
            opacity: 0;
            transition: none
        }

        .wd-search-dropdown {
            width: 300px
        }

        .wd-search-dropdown input[type=text] {
            height: 70px !important;
            border: none
        }

        .whb-col-right .wd-search-dropdown {
            right: 0;
            left: auto;
            margin-left: 0;
            margin-right: calc(var(--nav-gap, 0.001px)/2*-1)
        }

        .wd-search-dropdown .wd-dropdown-results {
            inset-inline: calc(var(--wd-brd-radius)/1.5)
        }

        .form-style-underlined .wd-search-dropdown input[type=text] {
            padding-left: 15px
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/header-el-search.css */
    </style>
    <style id='wd-header-cart-inline-css' type='text/css'>
        .wd-header-cart {
            --wd-tools-icon: "\f105"
        }

        .wd-header-cart .wd-tools-icon.wd-icon-alt {
            --wd-tools-icon: "\f126"
        }

        .wd-header-cart :is(.wd-cart-subtotal, .subtotal-divider, .wd-tools-count) {
            vertical-align: middle
        }

        .wd-header-cart .wd-cart-number>span,
        .wd-header-cart .subtotal-divider {
            display: none
        }

        .wd-header-cart .wd-cart-subtotal .amount {
            color: inherit;
            font-weight: inherit;
            font-size: inherit
        }

        .wd-tools-text-cart {
            display: flex;
            align-items: center;
            gap: 7px
        }

        .wd-header-cart:is(.wd-design-2, .wd-design-5) .wd-tools-icon {
            margin-inline-end: 6px
        }

        .wd-header-cart:is(.wd-design-6-text, .wd-design-7-text)>a>.wd-tools-text-cart {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid rgba(0, 0, 0, .105);
            height: 42px;
            border-radius: 42px;
            padding-inline: var(--wd-tools-sp)
        }

        .wd-header-cart.wd-design-6-text>a>.wd-tools-text-cart {
            border: 1px solid rgba(0, 0, 0, 0.105)
        }

        .whb-color-light .wd-header-cart.wd-design-5-text>a>.wd-tools-text-cart {
            border-color: rgba(255, 255, 255, 0.25)
        }

        .wd-header-cart.wd-design-7-text>a>.wd-tools-text-cart {
            background-color: var(--wd-primary-color);
            color: #fff;
            transition: inherit
        }

        .wd-header-cart.wd-design-7-text:hover>a>.wd-tools-text-cart {
            color: hsla(0, 0%, 100%, .8)
        }

        .wd-dropdown-cart {
            padding: 20px;
            width: 330px
        }

        .whb-col-right .wd-dropdown-cart {
            right: 0;
            left: auto;
            margin-left: 0;
            margin-right: calc(var(--nav-gap, 0.001px)/2*-1)
        }

        :is(.woocommerce-cart, .woocommerce-checkout) :is(.cart-widget-side, .wd-dropdown-cart) {
            display: none
        }

        @media(max-width: 1024px) {
            .wd-dropdown-cart {
                display: none
            }
        }

        .wd-custom-dropdown {
            padding-inline: 10px
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/header-el-cart.css */
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
    <style id='wd-block-opt-sticky-inline-css' type='text/css'>
        @media(min-width: 1025px) {
            .wd-sticky-on-lg {
                align-self: flex-start
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            .wd-sticky-on-md-sm {
                align-self: flex-start
            }
        }

        @media(max-width: 768.98px) {
            .wd-sticky-on-sm {
                align-self: flex-start
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-opt-sticky.css */
    </style>
    <style id='wd-el-page-title-builder-inline-css' type='text/css'>
        .wd-page-title-el .wd-page-title {
            border-radius: inherit
        }

        .wd-page-title-el.wd-stretched {
            position: relative;
            width: calc(100vw - var(--wd-scroll-w) - var(--wd-sticky-nav-w));
            inset-inline-start: calc(50% - 50vw + var(--wd-scroll-w)/2 + var(--wd-sticky-nav-w)/2)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-page-title-builder.css */
    </style>
    <style id='wd-page-title-inline-css' type='text/css'>
        .wd-page-title {
            --wd-align: start;
            --wd-title-sp: 15px;
            --wd-title-font-s: 36px;
            position: relative;
            padding-block: var(--wd-title-sp)
        }

        .wd-page-title .container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: var(--wd-align);
            text-align: var(--wd-align);
            gap: 10px
        }

        .wd-page-title .title {
            font-size: var(--wd-title-font-s);
            line-height: 1.2;
            margin-bottom: 0
        }

        .wd-page-title-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .title-design-centered {
            --wd-align: center
        }

        @media(min-width: 1025px) {
            .title-size-small {
                --wd-title-sp: 20px;
                --wd-title-font-s: 44px
            }

            .title-size-default {
                --wd-title-sp: 60px;
                --wd-title-font-s: 68px
            }

            .title-size-large {
                --wd-title-sp: 100px;
                --wd-title-font-s: 78px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/page-title.css */
    </style>
    <style id='wd-woo-mod-checkout-steps-inline-css' type='text/css'>
        .wd-checkout-steps {
            --wd-link-color: initial;
            --wd-link-color-hover: initial;
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            --list-mb: 0;
            --li-pl: 0;
            --li-mb: 0;
            display: flex;
            justify-content: var(--wd-align);
            flex-wrap: wrap;
            gap: 10px 15px;
            font-size: 22px;
            text-transform: uppercase;
            color: var(--wd-title-color);
            font-weight: var(--wd-title-font-weight);
            font-style: var(--wd-title-font-style);
            font-family: var(--wd-title-font);
            list-style: none
        }

        .wd-checkout-steps li {
            display: flex;
            align-items: center;
            gap: 15px
        }

        @media(min-width: 769px) {
            .wd-checkout-steps li>:is(a, span) {
                opacity: .7
            }

            .wd-checkout-steps li a:hover {
                opacity: 1
            }

            .wd-checkout-steps li:not(:last-child):after {
                font-weight: 400;
                font-size: 85%;
                opacity: .7;
                content: "\f120";
                font-family: "woodmart-font"
            }

            .wd-checkout-steps .step-active>:is(a, span) {
                opacity: 1;
                text-decoration: underline 2px solid var(--wd-primary-color);
                text-underline-offset: 6px
            }
        }

        @media(max-width: 768.98px) {
            .wd-checkout-steps .step-inactive {
                display: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-checkout-steps.css */
    </style>
    <style id='wd-woo-el-notices-builder-inline-css' type='text/css'>
        .wd-wc-notices .woocommerce-notices-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        .wd-wc-notices .woocommerce-notices-wrapper>* {
            margin-bottom: 0
        }

        .wd-wc-notices:has(.woocommerce-notices-wrapper:empty) {
            display: none
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-el-notices-builder.css */
    </style>
    <style id='wd-woo-mod-login-form-inline-css' type='text/css'>
        .woocommerce-form-login>*:last-child {
            margin-bottom: 0
        }

        .woocommerce-form-login:not(.hidden-form) {
            display: block !important
        }

        .password-input {
            position: relative;
            display: block
        }

        .password-input input {
            padding-inline-end: var(--wd-form-height) !important
        }

        .show-password-input {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            inset-inline-end: 0;
            width: var(--wd-form-height);
            height: var(--wd-form-height);
            cursor: pointer;
            font-size: 16px;
            color: var(--color-gray-600);
            transition: all .25s ease;
            padding: 0 !important;
            border: none !important;
            background: none !important;
            box-shadow: none !important;
            min-height: unset !important
        }

        .show-password-input:hover {
            color: var(--color-gray-400)
        }

        .show-password-input:before {
            font-family: "woodmart-font";
            content: "\f11a"
        }

        .show-password-input.display-password:before {
            content: "\f11b"
        }

        .login-form-footer {
            --wd-link-color: var(--wd-primary-color);
            --wd-link-color-hover: var(--wd-primary-color);
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px
        }

        .login-form-footer .lost_password {
            order: 2
        }

        .login-form-footer .lost_password:hover {
            opacity: .7
        }

        .login-form-footer .woocommerce-form-login__rememberme {
            order: 1;
            margin-bottom: 0
        }

        :is(.register, .woocommerce-form-login) .button {
            width: 100%
        }

        .wd-login-divider {
            display: flex;
            align-items: center;
            text-transform: uppercase
        }

        .wd-login-divider span {
            margin-inline: 20px
        }

        .wd-login-divider:after,
        .wd-login-divider:before {
            content: "";
            flex: 1 0 0;
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-login-form.css */
    </style>
    <style id='wd-woo-mod-quantity-inline-css' type='text/css'>
        div.quantity {
            --wd-form-height: 42px;
            display: inline-flex;
            vertical-align: top;
            white-space: nowrap
        }

        div.quantity input[type=number]::-webkit-inner-spin-button,
        div.quantity input[type=number]::-webkit-outer-spin-button,
        div.quantity input[type=number] {
            margin: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none
        }

        div.quantity :is(input[type=number], input[type=text], input[type=button]) {
            display: inline-block;
            color: var(--wd-form-color);
            min-height: var(--wd-form-height);
            height: unset
        }

        div.quantity input[type=number] {
            width: 30px;
            border-radius: 0;
            border-right: none;
            border-left: none
        }

        div.quantity input[type=text] {
            width: var(--quantity-space, 80px);
            text-align: center
        }

        div.quantity input[type=button] {
            padding: 0 5px;
            min-width: 25px;
            border: var(--wd-form-brd-width) solid var(--wd-form-brd-color);
            background: var(--wd-form-bg);
            box-shadow: none
        }

        div.quantity input[type=button]:hover {
            color: #fff;
            background-color: var(--wd-primary-color);
            border-color: var(--wd-primary-color)
        }

        div.quantity .minus {
            border-start-start-radius: var(--wd-form-brd-radius);
            border-end-start-radius: var(--wd-form-brd-radius)
        }

        div.quantity .plus {
            border-start-end-radius: var(--wd-form-brd-radius);
            border-end-end-radius: var(--wd-form-brd-radius)
        }

        div.quantity.hidden {
            display: none !important
        }

        .form-style-underlined div.quantity input[type=number],
        .form-style-underlined div.quantity input[type=text] {
            border-top-style: solid
        }

        @-moz-document url-prefix() {
            div.quantity input[type=number] {
                -webkit-appearance: textfield;
                -moz-appearance: textfield;
                appearance: textfield
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-quantity.css */
    </style>
    <style id='wd-footer-base-inline-css' type='text/css'>
        .footer-sidebar {
            padding-block: 40px
        }

        .footer-column>*:not(.widget) {
            margin-block: 0 var(--wd-block-spacing)
        }

        .footer-column>*:not(.widget):last-child {
            margin-bottom: 0
        }

        .wd-prefooter {
            padding-bottom: 40px;
            background-color: var(--wd-main-bgcolor)
        }

        .wd-copyrights {
            --wd-tags-mb: 10px;
            padding-block: 20px;
            border-top: 1px solid var(--brdcolor-gray-300)
        }

        .wd-copyrights.wd-layout-two-columns>.wd-grid-g {
            --wd-col-lg: 2;
            --wd-col-md: 1
        }

        .wd-copyrights.wd-layout-centered {
            text-align: center
        }

        @media(min-width: 1025px) {
            .sticky-footer-on :is(.wd-page-content, .wd-prefooter) {
                position: relative;
                z-index: 2
            }

            .sticky-footer-on .wd-footer {
                position: sticky;
                bottom: 0
            }
        }

        @media(min-width: 1025px) {
            .wd-copyrights.wd-layout-two-columns .wd-col-end {
                text-align: end
            }
        }

        @media(max-width: 1024px) {
            .wd-copyrights.wd-layout-two-columns {
                text-align: center
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/footer-base.css */
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
    <style id='wd-block-toggle-inline-css' type='text/css'>
        .wd-toggle .wd-toggle-head.wd-dir-row {
            align-items: center;
            justify-content: space-between
        }

        .wd-toggle-head .wp-block-wd-title.title {
            font-size: 1.1em
        }

        .wd-toggle-icon {
            --wd-icon-w: 12px;
            fill: var(--color-gray-800);
            transition: all .25s ease
        }

        .wd-toggle-content {
            margin-top: 20px
        }

        .wd-toggle-content-inner {
            --wd-row-gap: 20px;
            display: flex;
            flex-direction: column;
            row-gap: var(--wd-row-gap);
            opacity: 0;
            transition: all .25s ease
        }

        :root .wd-toggle-content-inner>* {
            margin-bottom: 0
        }

        @media(min-width: 1025px) {
            .wd-toggle.wd-state-static-lg .wp-block-wd-icon {
                display: none
            }

            .wd-toggle:is(.wd-state-closed-lg, .wd-state-opened-lg) .wd-toggle-head {
                cursor: pointer
            }

            .wd-toggle.wd-state-closed-lg .wd-toggle-content {
                display: none
            }

            .wd-toggle.wd-active-lg.wd-icon-rotate .wd-toggle-icon {
                transform: rotate(180deg)
            }

            .wd-toggle.wd-active-lg .wd-toggle-content-inner {
                opacity: 1
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            .wd-toggle.wd-state-static-md-sm .wp-block-wd-icon {
                display: none
            }

            .wd-toggle.wd-state-closed-md-sm .wd-toggle-content {
                display: none
            }

            .wd-toggle.wd-active-md-sm.wd-icon-rotate .wd-toggle-icon {
                transform: rotate(180deg)
            }

            .wd-toggle.wd-active-md-sm .wd-toggle-content-inner {
                opacity: 1
            }
        }

        @media(max-width: 768.98px) {
            .wd-toggle.wd-state-static-sm .wp-block-wd-icon {
                display: none
            }

            .wd-toggle.wd-state-closed-sm .wd-toggle-content {
                display: none
            }

            .wd-toggle.wd-active-sm.wd-icon-rotate .wd-toggle-icon {
                transform: rotate(180deg)
            }

            .wd-toggle.wd-active-sm .wd-toggle-content-inner {
                opacity: 1
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/block-toggle.css */
    </style>
    <style id='wd-list-inline-css' type='text/css'>
        .wd-list {
            --list-mb: 0;
            --li-mb: 15px;
            --li-pl: 0;
            --wd-row-gap: var(--li-mb);
            display: flex;
            flex-direction: column;
            justify-content: var(--wd-align);
            gap: var(--wd-row-gap);
            list-style: none
        }

        .wd-list li {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: inherit;
            gap: 10px;
            margin-bottom: 0 !important;
            transition: all .25s ease
        }

        .wd-list .wd-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: var(--color-gray-800);
            line-height: 1;
            transition: all .25s ease;
            font-size: var(--li-icon-s, 1em)
        }

        .wd-list.wd-design-bordered li:not(:first-child):before {
            content: "";
            position: absolute;
            top: calc(var(--wd-row-gap)/2*-1);
            inset-inline: 0px;
            border-top: 1px solid var(--brdcolor-gray-300)
        }

        .wd-list .wd-icon :is(img, svg) {
            width: var(--li-icon-s, revert-layer);
            min-width: var(--li-icon-s, 6px);
            max-width: 150px;
            fill: currentColor
        }

        .wd-list .wd-icon:has(:is(img, svg)):before {
            display: none
        }

        .wd-list.wd-type-ordered {
            counter-reset: item
        }

        .wd-list.wd-type-ordered .wd-icon {
            font-weight: 600
        }

        .wd-list.wd-type-ordered .wd-icon:before {
            content: counter(item) ".";
            counter-increment: item
        }

        .wd-list.wd-type-unordered .wd-icon:before {
            font-size: .6em;
            content: "\f113";
            font-family: "woodmart-font"
        }

        .wd-list.wd-type-unordered-2 .wd-icon:before {
            content: "";
            width: 1em;
            height: 1em;
            font-size: calc(var(--li-icon-s, 10px)/2);
            background: currentColor;
            border-radius: 50%
        }

        .wd-list.wd-shape-icon .wd-icon {
            background-color: var(--color-gray-200);
            width: var(--li-icon-s, 2em);
            height: var(--li-icon-s, 2em);
            font-size: calc(var(--li-icon-s, 2em)/2)
        }

        .wd-list.wd-shape-icon .wd-icon :is(img, svg) {
            width: calc(var(--li-icon-s, 2em)/2);
            height: calc(var(--li-icon-s, 2em)/2);
            min-width: calc(var(--li-icon-s, 14px)/2);
            object-fit: contain
        }

        .wd-list.wd-style-rounded .wd-icon {
            border-radius: 50%
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-list.css */
    </style>
    <style id='wd-scroll-top-inline-css' type='text/css'>
        .scrollToTop {
            position: fixed;
            inset-inline-end: 20px;
            bottom: 20px;
            z-index: 350;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(var(--bgcolor-white-rgb), 0.9);
            box-shadow: 0 0 5px rgba(0, 0, 0, .17);
            color: var(--color-gray-800);
            font-size: 16px;
            opacity: 0;
            pointer-events: none;
            text-decoration: none !important;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateX(100%)
        }

        .scrollToTop.button-show {
            opacity: 1;
            transform: none;
            pointer-events: auto
        }

        .scrollToTop:after {
            content: "\f115";
            font-family: "woodmart-font"
        }

        .scrollToTop:hover {
            color: var(--color-gray-500)
        }

        .wd-search-opened .scrollToTop {
            display: none
        }

        @media(max-width: 1024px) {
            .scrollToTop {
                inset-inline-end: 12px;
                bottom: 12px;
                width: 40px;
                height: 40px;
                font-size: 14px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/opt-scrolltotop.css */
    </style>
    <style id='wd-mod-animations-transform-inline-css' type='text/css'>
        .wd-animation {
            --wd-anim-duration: 1s;
            --wd-anim-timing-f: cubic-bezier(0, 0.87, 0.58, 1);
            --wd-anim-delay: 0s;
            --wd-anim-opa-timing-f: ease;
            --wd-trans-main: all .25s ease;
            --wd-trans-last: transform var(--wd-anim-duration) var(--wd-anim-timing-f) var(--wd-anim-delay), opacity .25s var(--wd-anim-opa-timing-f) var(--wd-anim-delay);
            opacity: 0
        }

        .wd-animation:not(.wd-animated) {
            transition: none !important
        }

        .wd-animation.wd-animated {
            transition: var(--wd-trans-main), var(--wd-trans-last)
        }

        .wd-animation.wd-in {
            opacity: 1
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/mod-animations-transform.css */
    </style>
    <link rel='stylesheet' id='wd-button-css' href='merchandise/wp-content/themes/woodmart/css/parts/el-button.css'
        type='text/css' media='all' />
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
    <link rel='stylesheet' id='wd-header-search-fullscreen-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/header-el-search-fullscreen-general.css' type='text/css'
        media='all' />
    <link rel='stylesheet' id='wd-header-search-fullscreen-1-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/header-el-search-fullscreen-1.css' type='text/css'
        media='all' />
    <style id='wd-wd-search-form-inline-css' type='text/css'>
        .searchform {
            position: relative;
            --wd-search-btn-w: var(--wd-form-height);
            --wd-form-height: 46px;
            --wd-search-clear-sp: .001px
        }

        .searchform input[type=text] {
            padding-inline-end: calc(var(--wd-search-btn-w) + 30px)
        }

        .searchform .searchsubmit {
            --btn-color: var(--wd-form-color, currentColor);
            --btn-bgcolor: transparent;
            --btn-bgcolor-hover: transparent;
            position: absolute;
            gap: 0;
            inset-block: 0;
            inset-inline-end: 0;
            padding: 0;
            width: var(--wd-search-btn-w);
            min-height: unset;
            border: none;
            box-shadow: none;
            font-weight: 400;
            font-size: 0;
            font-style: unset
        }

        .searchform .searchsubmit:hover:after,
        .searchform .searchsubmit:hover img {
            opacity: .7
        }

        .searchform .searchsubmit:after {
            font-size: calc(var(--wd-form-height)/2.3);
            transition: opacity .2s ease;
            content: "\f130";
            font-family: "woodmart-font"
        }

        .searchform .searchsubmit img {
            max-width: var(--wd-tools-icon-width, 24px);
            transition: opacity .2s ease
        }

        .searchform .searchsubmit:before {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: calc(var(--wd-form-height)/2.5/-2);
            margin-left: calc(var(--wd-form-height)/2.5/-2);
            opacity: 0;
            transition: opacity .1s ease;
            content: "";
            display: inline-block;
            width: calc(var(--wd-form-height)/2.5);
            height: calc(var(--wd-form-height)/2.5);
            border: 1px solid rgba(0, 0, 0, 0);
            border-left-color: currentColor;
            border-radius: 50%;
            vertical-align: middle;
            animation: wd-rotate 450ms infinite linear var(--wd-anim-state, paused)
        }

        .searchform .searchsubmit.wd-with-img:after {
            content: none
        }

        .searchform.wd-search-loading .searchsubmit {
            transform: translateZ(0)
        }

        .searchform.wd-search-loading .searchsubmit:before {
            opacity: 1;
            transition-duration: .2s;
            --wd-anim-state: running
        }

        .searchform.wd-search-loading .searchsubmit:after,
        .searchform.wd-search-loading .searchsubmit img {
            opacity: 0;
            transition-duration: .1s
        }

        .searchform .wd-clear-search {
            position: absolute;
            top: calc(50% - 12px);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 24px;
            inset-inline-end: calc(var(--wd-search-cat-w, 0.001px) + var(--wd-search-btn-w) + var(--wd-search-clear-sp));
            color: var(--wd-form-color, currentColor);
            cursor: pointer
        }

        .searchform .wd-clear-search:before {
            font-size: calc(var(--wd-form-height)/3);
            line-height: 1;
            transition: opacity .2s ease;
            content: "\f112";
            font-family: "woodmart-font"
        }

        .searchform .wd-clear-search:hover:before {
            opacity: .7
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/wd-search-form.css */
    </style>
    <link rel='stylesheet' id='wd-wd-search-results-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/wd-search-results.css' type='text/css' media='all' />
    <style id='wd-search-style-default-inline-css' type='text/css'>
        @media(min-width: 769px) {
            .searchform.wd-style-default:not(.wd-with-cat) .wd-clear-search {
                padding-inline-end: 10px;
                border-inline-end: 1px solid var(--wd-form-brd-color)
            }

            .searchform.wd-style-default.wd-cat-style-default {
                --wd-search-clear-sp: 7px
            }
        }

        @media(max-width: 768.98px) {
            .searchform.wd-style-default .wd-clear-search {
                padding-inline-end: 10px;
                border-inline-end: 1px solid var(--wd-form-brd-color)
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-search-style-default.css */
    </style>
    <link rel='stylesheet' id='wd-wd-search-dropdown-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/wd-search-dropdown.css' type='text/css' media='all' />
    <style id='wd-widget-general-inline-css' type='text/css'>
        :is(.widget, .wd-widget, div[class^=vc_wp]) {
            line-height: 1.4;
            --wd-link-color: var(--color-gray-500);
            --wd-link-color-hover: var(--color-gray-800);
            --wd-link-decor: none;
            --wd-link-decor-hover: none
        }

        :is(.widget, .wd-widget, div[class^=vc_wp])>:is(ul, ol) {
            margin-top: 0
        }

        :is(.widget, .wd-widget, div[class^=vc_wp]) :is(ul, ol) {
            list-style: none;
            --list-mb: 0;
            --li-mb: 15px;
            --li-pl: 0
        }

        .widgettitle,
        .widget-title {
            margin-bottom: 20px;
            color: var(--wd-widget-title-color);
            text-transform: var(--wd-widget-title-transform);
            font-weight: var(--wd-widget-title-font-weight);
            font-style: var(--wd-widget-title-font-style);
            font-size: var(--wd-widget-title-font-size);
            font-family: var(--wd-widget-title-font)
        }

        .widget .wp-block-heading {
            font-size: var(--wd-widget-title-font-size)
        }

        .widget {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        .widget:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/widget-general.css */
    </style>
    <link rel='stylesheet' id='wd-widget-shopping-cart-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-widget-shopping-cart.css' type='text/css'
        media='all' />
    <style id='wd-widget-product-list-inline-css' type='text/css'>
        .product_list_widget>li {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        .product_list_widget>li>a {
            display: block;
            margin-bottom: 8px
        }

        .product_list_widget>li img {
            float: inline-start;
            margin-inline-end: 15px;
            min-width: 65px;
            max-width: 65px;
            border-radius: calc(var(--wd-brd-radius)/1.5)
        }

        .product_list_widget>li .widget-product-wrap {
            display: flex
        }

        .product_list_widget>li .widget-product-img {
            flex: 0 0 auto;
            overflow: hidden;
            margin-inline-end: 15px
        }

        .product_list_widget>li .widget-product-img img {
            float: none;
            margin-inline-end: 0
        }

        .product_list_widget>li .widget-product-info {
            flex: 1 1 auto
        }

        .product_list_widget>li .widget-product-info .price {
            display: block
        }

        .product_list_widget>li .wd-entities-title {
            margin-bottom: 8px;
            font-size: inherit
        }

        .product_list_widget>li .star-rating {
            margin-bottom: 4px;
            margin-inline-end: 5px
        }

        .product_list_widget>li .reviewer {
            display: block;
            color: var(--color-gray-300)
        }

        .product_list_widget>li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none
        }

        .product_list_widget>li:after {
            content: "";
            display: block;
            clear: both
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-widget-product-list.css */
    </style>
    <style id='wd-bottom-toolbar-inline-css' type='text/css'>
        .wd-toolbar {
            position: fixed;
            inset-inline: 0;
            bottom: 0;
            z-index: 350;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding: 5px;
            height: 55px;
            background-color: var(--bgcolor-white);
            box-shadow: 0 0 9px rgba(0, 0, 0, .12)
        }

        .wd-toolbar>a {
            display: flex;
            align-items: center;
            justify-content: center
        }

        .wd-toolbar>a,
        .wd-toolbar>div {
            flex: 1 0 20%
        }

        .wd-toolbar>a,
        .wd-toolbar>div a {
            height: 45px
        }

        .wd-toolbar .wd-header-cart.wd-design-5 .wd-tools-icon {
            margin: 0
        }

        .wd-toolbar.wd-toolbar-label-show>a,
        .wd-toolbar.wd-toolbar-label-show>div a {
            position: relative;
            padding-bottom: 15px
        }

        .wd-toolbar.wd-toolbar-label-show .wd-toolbar-label {
            display: block
        }

        .global-color-scheme-light .wd-toolbar a {
            color: #fff
        }

        .global-color-scheme-light .wd-toolbar a:hover {
            color: hsla(0, 0%, 100%, .8)
        }

        .wd-toolbar-label {
            position: absolute;
            inset-inline: 10px;
            bottom: 3px;
            display: none;
            overflow: hidden;
            text-align: center;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 600;
            font-size: 11px;
            line-height: 1;
            padding: 1px 0
        }

        .wd-toolbar-shop {
            --wd-tools-icon: "\f146"
        }

        .wd-toolbar-blog {
            --wd-tools-icon: "\f145"
        }

        .wd-toolbar-home {
            --wd-tools-icon: "\f144"
        }

        .wd-toolbar-sidebar,
        .wd-toolbar-shop-cat {
            --wd-tools-icon: "\f15a"
        }

        .wd-toolbar-sidebar.wd-filter-icon {
            --wd-tools-icon: "\f118"
        }

        .wd-toolbar-link {
            --wd-tools-icon: "\f140"
        }

        .wd-toolbar-link .wd-custom-icon img {
            width: auto;
            height: 20px
        }

        body:not(:has(.wd-nav-side-hidden-mb-on)) .wd-toolbar-shop-cat {
            display: none
        }

        @media(min-width: 1025px) {
            .wd-toolbar {
                display: none
            }
        }

        @media(max-width: 1024px) {
            .sticky-toolbar-on {
                padding-bottom: 55px
            }

            .sticky-toolbar-on .wd-sticky-btn {
                bottom: 55px
            }

            .sticky-toolbar-on .scrollToTop {
                bottom: 67px
            }

            .sticky-toolbar-on .wd-sticky-btn-shown.scrollToTop {
                bottom: calc(12px + 55px + var(--wd-sticky-btn-height))
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            .sticky-toolbar-on.wd-sticky-btn-on {
                padding-bottom: calc(55px + var(--wd-sticky-btn-height))
            }
        }

        @media(max-width: 768.98px) {
            .sticky-toolbar-on.wd-sticky-btn-on-mb {
                padding-bottom: calc(55px + var(--wd-sticky-btn-height))
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/opt-bottom-toolbar.css */
    </style>
    <script type="text/javascript" src="merchandise/wp-includes/js/jquery/jquery.min.js" id="jquery-core-js"></script>
    <script type="text/javascript"
        src="merchandise/wp-content/plugins/woocommerce/assets/js/frontend/utils/custom-place-order-button.min.js"
        id="wc-custom-place-order-button-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript" src="merchandise/wp-content/themes/woodmart/js/scripts/global/scrollBar.min.js"
        id="wd-scrollbar-js"></script>
    <meta name="theme-color" content="rgb(245,245,245)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-45x45.png" sizes="32x32" />
    <link rel="icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
    <meta name="msapplication-TileImage"
        content="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
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

        body,
        [class*=color-scheme-light],
        [class*=color-scheme-dark],
        .wd-search-form[class*="wd-header-search-form"] form.searchform,
        .wd-el-search .searchform {
            --wd-form-bg: rgb(255, 255, 255);
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
    <style id="wd-style-theme_settings_1-inline-css" data-type="wd-style-theme_settings_1">
        body,
        [class*=color-scheme-light],
        [class*=color-scheme-dark],
        .wd-search-form[class*="wd-header-search-form"] form.searchform,
        .wd-el-search .searchform {
            --wd-form-bg: rgb(255, 255, 255);
        }
    </style>
    <style id="wd-style-local-google-fonts-inline-css" data-type="wd-style-local-google-fonts">
        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-d972ba76.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-3e4fce5c.woff2) format('woff2');
            unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lexend Deca';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(merchandise/wp-content/uploads/sites/31/woodmart/google-fonts/fonts/lexenddeca-fcf1177e.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
@endpush
@section('content')
    <div class="wd-page-content main-page-wrapper">
        <main id="main-content" class="wd-content-layout content-layout-wrapper container wd-builder-on" role="main">
            <div class="wd-content-area site-content">
                <div class="woocommerce entry-content">
                    <style id="wd-style-blocks-919-inline-css" data-type="wd-style-blocks-919">
                        #wd-34cd14d7 {
                            margin-top: -40px;
                            margin-bottom: 40px;
                        }

                        #wd-999680d0 {
                            margin-bottom: 30px;
                        }

                        #wd-6c8a3740 .woocommerce-form-login {
                            background-color: #f5f5f5;
                            border-style: none;
                        }

                        #wd-800af568 .woocommerce-form-coupon {
                            background-color: #f5f5f5;
                            border-style: none;
                        }

                        #wd-05d36b9d {
                            font-size: 32px;
                        }

                        #wd-98553bf9 {
                            margin-bottom: 10px;
                        }

                        #wd-68812e6d {
                            font-size: 32px;
                        }

                        #wd-8b94df23 .payment_box {
                            background-color: #f5f5f5;
                        }

                        #wd-8b94df23 .payment_box:before {
                            color: #f5f5f5;
                        }

                        #wd-8b94df23 .woocommerce-terms-and-conditions {
                            background-color: #f5f5f5;
                        }

                        #wd-8b94df23 {
                            --wd-btn-align: var(--wd-stretch);
                        }

                        #wd-8a449f60 {
                            margin-top: 30px;
                        }

                        #wd-1d306d06 {
                            font-size: 32px;
                        }

                        #wd-9eda25d5 {
                            padding: 30px;
                            background-color: #f5f5f5;
                            border-radius: 16px;
                            align-self: start;
                        }

                        @media (min-width: 769px) {
                            #wd-8a449f60 {
                                flex: 0 1 calc(65% - var(--wd-col-gap) * 1 / 2);
                            }

                            #wd-9eda25d5 {
                                flex: 0 1 calc(35% - var(--wd-col-gap) * 1 / 2);
                            }
                        }

                        @media (max-width: 1024px) {
                            #wd-05d36b9d {
                                font-size: 28px;
                            }

                            #wd-68812e6d {
                                font-size: 28px;
                            }

                            #wd-1d306d06 {
                                font-size: 28px;
                            }
                        }

                        @media (min-width: 769px) and (max-width: 1024px) {
                            #wd-8a449f60 {
                                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
                            }

                            #wd-9eda25d5 {
                                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
                            }
                        }

                        @media (max-width: 768.98px) {
                            #wd-8a449f60 {
                                margin-top: 0px;
                                order: 1;
                            }

                            #wd-9eda25d5 {
                                padding: 20px;
                            }
                        }
                    </style>
                    <div id="wd-34cd14d7" class="wd-page-title-el wd-34cd14d7 wd-stretched">
                        <div class="wd-page-title page-title  page-title-default title-size-small title-design-centered color-scheme-default"
                            style="">
                            <div class="wd-page-title-bg wd-fill">
                            </div>
                            <div class="container">
                                <ul class="wd-checkout-steps">
                                    <li class="step-cart step-inactive">
                                        <a href="cart.html">
                                            <span>Shopping cart</span>
                                        </a>
                                    </li>
                                    <li class="step-checkout step-active">
                                        <a href="checkout.html">
                                            <span>Checkout</span>
                                        </a>
                                    </li>
                                    <li class="step-complete step-inactive">
                                        <span>Order complete</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div id="wd-999680d0" class="wd-wc-notices wd-999680d0">
                        <div class="woocommerce-notices-wrapper"></div>
                    </div>


                    <div id="wd-238e4c83" class="wp-block-wd-container wd-dir-col">

                        <div id="wd-800af568" class="wd-checkout-coupon wd-800af568">
                            <div class="woocommerce-form-coupon-toggle">

                                <div class="woocommerce-info" role="status">
                                    Have a coupon? <a href="#" role="button" aria-label="Enter your coupon code"
                                        aria-controls="woocommerce-checkout-form-coupon" aria-expanded="false"
                                        class="showcoupon">Click here to enter your code</a> </div>
                            </div>

                            <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none"
                                id="woocommerce-checkout-form-coupon">

                                <p class="form-row form-row-first">
                                    <label for="coupon_code" class="screen-reader-text">Coupon:</label>
                                    <input type="text" name="coupon_code" class="input-text"
                                        placeholder="Coupon code" id="coupon_code" value="" />
                                </p>

                                <p class="form-row form-row-last">
                                    <button type="submit" class="button" name="apply_coupon" value="Apply coupon">Apply
                                        coupon</button>
                                </p>

                                <div class="clear"></div>
                            </form>
                        </div>


                    </div>

                    <form id="wd-eeeb6d90" name="checkout" method="post"
                        class="checkout woocommerce-checkout wd-checkout-form wd-eeeb6d90" action="checkout.html"
                        enctype="multipart/form-data" aria-label="Checkout">


                        <div id="wd-1c1b8bf4" class="wp-block-wd-row">
                            <div id="wd-8a449f60" class="wp-block-wd-column">
                                <h2 id="wd-05d36b9d" class="wp-block-wd-title title">Billing details</h2>

                                <div id="wd-8a34d9e8" class="wd-billing-details wd-8a34d9e8">
                                    <div class="woocommerce-billing-fields">

                                        <h3>Billing details</h3>



                                        <div class="woocommerce-billing-fields__field-wrapper">
                                            <p class="form-row form-row-first validate-required"
                                                id="billing_first_name_field" data-priority="10"><label
                                                    for="billing_first_name" class="required_field">First
                                                    name&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="text"
                                                        class="input-text " name="billing_first_name"
                                                        id="billing_first_name" placeholder="" value=""
                                                        aria-required="true"
                                                        autocomplete="section-billing billing given-name" /></span>
                                            </p>
                                            <p class="form-row form-row-last validate-required"
                                                id="billing_last_name_field" data-priority="20"><label
                                                    for="billing_last_name" class="required_field">Last
                                                    name&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="text"
                                                        class="input-text " name="billing_last_name"
                                                        id="billing_last_name" placeholder="" value=""
                                                        aria-required="true"
                                                        autocomplete="section-billing billing family-name" /></span>
                                            </p>
                                            <p class="form-row form-row-first validate-required validate-phone"
                                                id="billing_phone_field" data-priority="30"><label for="billing_phone"
                                                    class="required_field">Phone&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="tel"
                                                        class="input-text " name="billing_phone" id="billing_phone"
                                                        placeholder="" value="" aria-required="true"
                                                        autocomplete="section-billing billing tel" /></span></p>
                                            <p class="form-row form-row-last stripe-gateway-checkout-email-field validate-required validate-email"
                                                id="billing_email_field" data-priority="40"><label for="billing_email"
                                                    class="required_field">Email
                                                    address&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="email"
                                                        class="input-text " name="billing_email" id="billing_email"
                                                        placeholder="" value="zabirraihan570@gmail.com"
                                                        aria-required="true"
                                                        autocomplete="section-billing billing email" /></span></p>
                                            <p class="form-row form-row-first address-field validate-required"
                                                id="billing_address_1_field" data-priority="50"><label
                                                    for="billing_address_1" class="required_field">Street
                                                    address&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="text"
                                                        class="input-text " name="billing_address_1"
                                                        id="billing_address_1" placeholder="House number and street name"
                                                        value="" aria-required="true"
                                                        autocomplete="section-billing billing address-line1" /></span>
                                            </p>
                                            <p class="form-row form-row-last address-field validate-required"
                                                id="billing_city_field" data-priority="60"><label for="billing_city"
                                                    class="required_field">Town / City&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="text"
                                                        class="input-text " name="billing_city" id="billing_city"
                                                        placeholder="" value="" aria-required="true"
                                                        autocomplete="section-billing billing address-level2" /></span>
                                            </p>
                                            <p class="form-row form-row-first address-field update_totals_on_change validate-required"
                                                id="billing_country_field" data-priority="70"><label
                                                    for="billing_country" class="required_field">Country /
                                                    Region&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><select name="billing_country"
                                                        id="billing_country" class="country_to_state country_select "
                                                        aria-required="true"
                                                        autocomplete="section-billing billing country"
                                                        data-placeholder="Select a country / region&hellip;"
                                                        data-label="Country / Region">
                                                        <option value="">Select a country / region&hellip;
                                                        </option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="AX">Åland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="PW">Belau</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia</option>
                                                        <option value="BQ">Bonaire, Saint Eustatius and Saba
                                                        </option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="CG">Congo (Brazzaville)</option>
                                                        <option value="CD">Congo (Kinshasa)</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="HR">Croatia</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CW">Cura&ccedil;ao</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="SZ">Eswatini</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE" selected='selected'>Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GG">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard Island and McDonald Islands
                                                        </option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="CI">Ivory Coast</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JE">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="XK">Kosovo</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Laos</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macao</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia</option>
                                                        <option value="MD">Moldova</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="ME">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="KP">North Korea</option>
                                                        <option value="MK">North Macedonia</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PS">Palestinian Territory</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Reunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russia</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="ST">S&atilde;o Tom&eacute; and
                                                            Pr&iacute;ncipe</option>
                                                        <option value="BL">Saint Barth&eacute;lemy</option>
                                                        <option value="SH">Saint Helena</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="SX">Saint Martin (Dutch part)</option>
                                                        <option value="MF">Saint Martin (French part)</option>
                                                        <option value="PM">Saint Pierre and Miquelon</option>
                                                        <option value="VC">Saint Vincent and the Grenadines
                                                        </option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="RS">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SK">Slovakia</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="GS">South Georgia/Sandwich Islands</option>
                                                        <option value="KR">South Korea</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syria</option>
                                                        <option value="TW">Taiwan</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TL">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Türkiye</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="GB">United Kingdom (UK)</option>
                                                        <option value="US">United States (US)</option>
                                                        <option value="UM">United States (US) Minor Outlying
                                                            Islands
                                                        </option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VA">Vatican</option>
                                                        <option value="VE">Venezuela</option>
                                                        <option value="VN">Vietnam</option>
                                                        <option value="VG">Virgin Islands (British)</option>
                                                        <option value="VI">Virgin Islands (US)</option>
                                                        <option value="WF">Wallis and Futuna</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select><noscript><button type="submit"
                                                            name="woocommerce_checkout_update_totals"
                                                            value="Update country / region">Update country /
                                                            region</button></noscript></span></p>
                                            <p class="form-row form-row-last address-field validate-required validate-postcode"
                                                id="billing_postcode_field" data-priority="80"><label
                                                    for="billing_postcode" class="required_field">Postcode /
                                                    ZIP&nbsp;<span class="required"
                                                        aria-hidden="true">*</span></label><span
                                                    class="woocommerce-input-wrapper"><input type="text"
                                                        class="input-text " name="billing_postcode" id="billing_postcode"
                                                        placeholder="" value="" aria-required="true"
                                                        autocomplete="section-billing billing postal-code" /></span>
                                            </p>
                                        </div>

                                        <wc-order-attribution-inputs></wc-order-attribution-inputs>
                                    </div>

                                </div>


                                <div id="wd-98553bf9" class="wd-shipping-details wd-98553bf9">
                                    <div class="woocommerce-shipping-fields">

                                        <h3 id="ship-to-different-address">
                                            <label
                                                class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                                <input id="ship-to-different-address-checkbox"
                                                    class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                                                    type="checkbox" name="ship_to_different_address" value="1" />
                                                <span>Ship to a different address?</span>
                                            </label>
                                        </h3>

                                        <div class="shipping_address">


                                            <div class="woocommerce-shipping-fields__field-wrapper">
                                                <p class="form-row form-row-first validate-required"
                                                    id="shipping_first_name_field" data-priority="10"><label
                                                        for="shipping_first_name" class="required_field">First
                                                        name&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><input type="text"
                                                            class="input-text " name="shipping_first_name"
                                                            id="shipping_first_name" placeholder="" value=""
                                                            aria-required="true"
                                                            autocomplete="section-shipping shipping given-name" /></span>
                                                </p>
                                                <p class="form-row form-row-last validate-required"
                                                    id="shipping_last_name_field" data-priority="20"><label
                                                        for="shipping_last_name" class="required_field">Last
                                                        name&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><input type="text"
                                                            class="input-text " name="shipping_last_name"
                                                            id="shipping_last_name" placeholder="" value=""
                                                            aria-required="true"
                                                            autocomplete="section-shipping shipping family-name" /></span>
                                                </p>
                                                <p class="form-row form-row-first address-field validate-required"
                                                    id="shipping_address_1_field" data-priority="30"><label
                                                        for="shipping_address_1" class="required_field">Street
                                                        address&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><input type="text"
                                                            class="input-text " name="shipping_address_1"
                                                            id="shipping_address_1"
                                                            placeholder="House number and street name" value=""
                                                            aria-required="true"
                                                            autocomplete="section-shipping shipping address-line1" /></span>
                                                </p>
                                                <p class="form-row form-row-last address-field validate-required"
                                                    id="shipping_city_field" data-priority="40"><label
                                                        for="shipping_city" class="required_field">Town /
                                                        City&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><input type="text"
                                                            class="input-text " name="shipping_city" id="shipping_city"
                                                            placeholder="" value="" aria-required="true"
                                                            autocomplete="section-shipping shipping address-level2" /></span>
                                                </p>
                                                <p class="form-row form-row-first address-field update_totals_on_change validate-required"
                                                    id="shipping_country_field" data-priority="50"><label
                                                        for="shipping_country" class="required_field">Country /
                                                        Region&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><select name="shipping_country"
                                                            id="shipping_country" class="country_to_state country_select "
                                                            aria-required="true"
                                                            autocomplete="section-shipping shipping country"
                                                            data-placeholder="Select a country / region&hellip;"
                                                            data-label="Country / Region">
                                                            <option value="">Select a country / region&hellip;
                                                            </option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AX">Åland Islands</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="PW">Belau</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia</option>
                                                            <option value="BQ">Bonaire, Saint Eustatius and Saba
                                                            </option>
                                                            <option value="BA">Bosnia and Herzegovina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory
                                                            </option>
                                                            <option value="BN">Brunei</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos (Keeling) Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo (Brazzaville)</option>
                                                            <option value="CD">Congo (Kinshasa)</option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="HR">Croatia</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CW">Cura&ccedil;ao</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="SZ">Eswatini</option>
                                                            <option value="ET">Ethiopia</option>
                                                            <option value="FK">Falkland Islands</option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories
                                                            </option>
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE" selected='selected'>Germany
                                                            </option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GG">Guernsey</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard Island and McDonald Islands
                                                            </option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong</option>
                                                            <option value="HU">Hungary</option>
                                                            <option value="IS">Iceland</option>
                                                            <option value="IN">India</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran</option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IM">Isle of Man</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                            <option value="CI">Ivory Coast</option>
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JE">Jersey</option>
                                                            <option value="JO">Jordan</option>
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="XK">Kosovo</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                            <option value="LA">Laos</option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                            <option value="MO">Macao</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="FM">Micronesia</option>
                                                            <option value="MD">Moldova</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="ME">Montenegro</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar</option>
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="KP">North Korea</option>
                                                            <option value="MK">North Macedonia</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="NO">Norway</option>
                                                            <option value="OM">Oman</option>
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PS">Palestinian Territory</option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="QA">Qatar</option>
                                                            <option value="RE">Reunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russia</option>
                                                            <option value="RW">Rwanda</option>
                                                            <option value="ST">S&atilde;o Tom&eacute; and
                                                                Pr&iacute;ncipe</option>
                                                            <option value="BL">Saint Barth&eacute;lemy</option>
                                                            <option value="SH">Saint Helena</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint Lucia</option>
                                                            <option value="SX">Saint Martin (Dutch part)</option>
                                                            <option value="MF">Saint Martin (French part)</option>
                                                            <option value="PM">Saint Pierre and Miquelon</option>
                                                            <option value="VC">Saint Vincent and the Grenadines
                                                            </option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="RS">Serbia</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SK">Slovakia</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia/Sandwich Islands
                                                            </option>
                                                            <option value="KR">South Korea</option>
                                                            <option value="SS">South Sudan</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syria</option>
                                                            <option value="TW">Taiwan</option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania</option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TL">Timor-Leste</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Türkiye</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="GB">United Kingdom (UK)</option>
                                                            <option value="US">United States (US)</option>
                                                            <option value="UM">United States (US) Minor Outlying
                                                                Islands</option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VA">Vatican</option>
                                                            <option value="VE">Venezuela</option>
                                                            <option value="VN">Vietnam</option>
                                                            <option value="VG">Virgin Islands (British)</option>
                                                            <option value="VI">Virgin Islands (US)</option>
                                                            <option value="WF">Wallis and Futuna</option>
                                                            <option value="EH">Western Sahara</option>
                                                            <option value="YE">Yemen</option>
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </select><noscript><button type="submit"
                                                                name="woocommerce_checkout_update_totals"
                                                                value="Update country / region">Update country /
                                                                region</button></noscript></span></p>
                                                <p class="form-row form-row-last address-field validate-required validate-postcode"
                                                    id="shipping_postcode_field" data-priority="60"><label
                                                        for="shipping_postcode" class="required_field">Postcode /
                                                        ZIP&nbsp;<span class="required"
                                                            aria-hidden="true">*</span></label><span
                                                        class="woocommerce-input-wrapper"><input type="text"
                                                            class="input-text " name="shipping_postcode"
                                                            id="shipping_postcode" placeholder="" value=""
                                                            aria-required="true"
                                                            autocomplete="section-shipping shipping postal-code" /></span>
                                                </p>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="woocommerce-additional-fields">



                                        <div class="woocommerce-additional-fields__field-wrapper">
                                            <p class="form-row notes" id="order_comments_field" data-priority="">
                                                <label for="order_comments" class="">Order notes&nbsp;<span
                                                        class="optional">(optional)</span></label><span
                                                    class="woocommerce-input-wrapper">
                                                    <textarea name="order_comments" class="input-text " id="order_comments"
                                                        placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                                </span>
                                            </p>
                                        </div>


                                        <wc-order-attribution-inputs></wc-order-attribution-inputs>
                                    </div>
                                </div>


                                <h2 id="wd-68812e6d" class="wp-block-wd-title title">Payment Information</h2>

                                <div id="wd-8b94df23" class="wd-payment-methods wd-8b94df23">
                                    <div id="payment" class="woocommerce-checkout-payment">
                                        <ul class="wc_payment_methods payment_methods methods">
                                            <li class="wc_payment_method payment_method_bacs">
                                                <input id="payment_method_bacs" type="radio" class="input-radio"
                                                    name="payment_method" value="bacs" data-order_button_text="" />

                                                <label for="payment_method_bacs">
                                                    Direct bank transfer </label>
                                                <div class="payment_box payment_method_bacs" style="display:none;">
                                                    <p>Make your payment directly into our bank account. Please use
                                                        your Order ID as the payment reference. Your order will not
                                                        be shipped until the funds have cleared in our account.</p>
                                                </div>
                                            </li>
                                            <li class="wc_payment_method payment_method_cheque">
                                                <input id="payment_method_cheque" type="radio" class="input-radio"
                                                    name="payment_method" value="cheque" data-order_button_text="" />

                                                <label for="payment_method_cheque">
                                                    Check payments </label>
                                                <div class="payment_box payment_method_cheque" style="display:none;">
                                                    <p>Please send a check to Store Name, Store Street, Store Town,
                                                        Store State / County, Store Postcode.</p>
                                                </div>
                                            </li>
                                            <li class="wc_payment_method payment_method_cod">
                                                <input id="payment_method_cod" type="radio" class="input-radio"
                                                    name="payment_method" value="cod" checked='checked'
                                                    data-order_button_text="" />

                                                <label for="payment_method_cod">
                                                    Cash on delivery </label>
                                                <div class="payment_box payment_method_cod">
                                                    <p>Pay with cash upon delivery.</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="form-row place-order">
                                            <noscript>
                                                Since your browser does not support JavaScript, or it is disabled,
                                                please ensure you click the <em>Update Totals</em> button before
                                                placing your order. You may be charged more than the amount stated
                                                above if you fail to do so. <br /><button type="submit"
                                                    class="button alt" name="woocommerce_checkout_update_totals"
                                                    value="Update totals">Update totals</button>
                                            </noscript>

                                            <div class="woocommerce-terms-and-conditions-wrapper">
                                                <div class="woocommerce-privacy-policy-text"></div>
                                            </div>


                                            <button type="submit" class="button alt"
                                                name="woocommerce_checkout_place_order" id="place_order"
                                                value="Place order" data-value="Place order">Place order</button>

                                            <input type="hidden" id="woocommerce-process-checkout-nonce"
                                                name="woocommerce-process-checkout-nonce" value="15f67dd913" /><input
                                                type="hidden" name="_wp_http_referer"
                                                value="/merchandise/checkout/" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="wd-9eda25d5"
                                class="wp-block-wd-column wd-sticky-on-lg wd-sticky-on-md-sm wd-align-s-start">
                                <h2 id="wd-1d306d06" class="wp-block-wd-title title">Your order</h2>

                                <div id="wd-83e4d11d" class="wd-order-table wd-83e4d11d wd-manage-on">
                                    <table class="shop_table woocommerce-checkout-review-order-table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="cart_item">
                                                <td class="wd-checkout-prod">
                                                    <div class="wd-checkout-remove-btn-wrapp">
                                                        <a href="cart.html" class="remove wd-checkout-remove-btn"
                                                            aria-label="Remove this item" data-product_id="458"
                                                            data-cart_item_key="d07e70efcfab08731a97e7b91be644de"
                                                            data-product_sku="GM-PL-8"></a>
                                                    </div>

                                                    <div class="wd-checkout-prod-img">
                                                        <a href="product_details.html"><img width="430"
                                                                height="492"
                                                                src="merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-600x686.jpeg.webp"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="Dune Desert Mouse Plush" decoding="async"
                                                                fetchpriority="high"
                                                                srcset="merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-600x686.jpeg.webp 600w, merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-263x300.jpeg.webp 263w, merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-88x100.jpeg.webp 88w, merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-150x171.jpeg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush.jpeg.webp 700w"
                                                                sizes="(max-width: 430px) 100vw, 430px" /></a>
                                                    </div>

                                                    <div class="wd-checkout-prod-cont">
                                                        <div class="wd-checkout-prod-title">
                                                            <a class="cart-product-label-link"
                                                                href="product_details.html"><span
                                                                    class="cart-product-label">Dune Desert Mouse
                                                                    Plush</span></a>

                                                            <div class="quantity">

                                                                <input type="button" value="-" class="minus btn"
                                                                    aria-label="Decrease quantity" />

                                                                <label class="screen-reader-text"
                                                                    for="quantity_6a356fcf5fc16">Dune Desert Mouse
                                                                    Plush quantity</label>
                                                                <input type="number" id="quantity_6a356fcf5fc16"
                                                                    class="input-text qty text" value="1"
                                                                    aria-label="Product quantity" min="0"
                                                                    name="cart[d07e70efcfab08731a97e7b91be644de][qty]"
                                                                    step="1" placeholder="" inputmode="numeric"
                                                                    autocomplete="off">

                                                                <input type="button" value="+" class="plus btn"
                                                                    aria-label="Increase quantity" />

                                                            </div>


                                                        </div>

                                                        <div class="wd-checkout-prod-total product-total">
                                                            <span class="woocommerce-Price-amount amount"><bdi><span
                                                                        class="woocommerce-Price-currencySymbol">&#36;</span>28,48</bdi></span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>

                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>28,48</bdi></span>
                                                </td>
                                            </tr>




                                            <tr class="woocommerce-shipping-totals shipping">
                                                <th>Shipment</th>
                                                <td data-title="Shipment">
                                                    <ul id="shipping_method" class="woocommerce-shipping-methods">
                                                        <li>
                                                            <input type="radio" name="shipping_method[0]"
                                                                data-index="0" id="shipping_method_0_free_shipping1"
                                                                value="free_shipping:1" class="shipping_method"
                                                                checked='checked' /><label
                                                                for="shipping_method_0_free_shipping1">Free
                                                                shipping</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" name="shipping_method[0]"
                                                                data-index="0" id="shipping_method_0_flat_rate2"
                                                                value="flat_rate:2" class="shipping_method" /><label
                                                                for="shipping_method_0_flat_rate2">Flat rate: <span
                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>12,00</bdi></span></label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" name="shipping_method[0]"
                                                                data-index="0" id="shipping_method_0_local_pickup3"
                                                                value="local_pickup:3" class="shipping_method" /><label
                                                                for="shipping_method_0_local_pickup3">Local pickup:
                                                                <span class="woocommerce-Price-amount amount"><bdi><span
                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>25,00</bdi></span></label>
                                                        </li>
                                                    </ul>


                                                </td>
                                            </tr>






                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong><span class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>28,48</bdi></span></strong>
                                                </td>
                                            </tr>


                                        </tfoot>
                                    </table>
                                    <wc-order-attribution-inputs></wc-order-attribution-inputs>
                                </div>


                                <div id="wd-f310ad00" class="wd-shipping-progress-bar wd-f310ad00">
                                    <div class="wd-progress-bar wd-free-progress-bar">
                                        <div class="progress-msg">
                                            <p>Add <span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>971,52</bdi></span>
                                                to cart and get free shipping!</p>
                                        </div>
                                        <div class="progress-area">
                                            <div class="progress-bar" style="width: 2%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection
