@extends('Frontend.Layout.app')

@php
    use Illuminate\Support\Facades\Storage;

    $paymentLabels = [
        'cod' => 'Cash on Delivery',
        'bkash' => 'bKash',
        'nagad' => 'Nagad',
        'rocket' => 'Rocket',
        'bank' => 'Bank Transfer',
        'uddoktapay' => 'UddoktaPay',
    ];

    if (!empty($order)) {
        $placedAt = $order->placed_at ?? $order->created_at;
        $estDate = $placedAt ? $placedAt->copy()->addDays($order->status === 'delivered' ? 0 : 5) : null;
        $paymentLabel = $paymentLabels[$order->payment_method] ?? $order->payment_method;
        $cityLine = trim(
            ($order->shipping_area ? $order->shipping_area . ', ' : '') . ($order->shipping_city ?? ''),
            ', ',
        );
    }
@endphp
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
.whb-cqgb8qgsj8fpo4qz9frx .wd-logo img { transform: scale(1.3) !important; transform-origin: center center !important; }
/*# sourceURL=wd-style-base-inline-css */
    </style>
    <link rel='stylesheet' id='wd-header-base-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/header-base.css' type='text/css' media='all' />
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
    <link rel='stylesheet' id='wd-woo-stripe-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/int-woo-stripe.css' type='text/css' media='all' />
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
    <link rel='stylesheet' id='wd-select2-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-lib-select2.css' type='text/css' media='all' />
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
    <link rel='stylesheet' id='wd-page-checkout-payment-methods-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-page-checkout-el-payment-methods.css' type='text/css'
        media='all' />
    <style id='wd-woo-page-checkout-predefined-inline-css' type='text/css'>
        form.woocommerce-checkout {
            --wd-row-gap: 30px;
            --wd-col-gap: 30px;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            gap: var(--wd-row-gap) var(--wd-col-gap)
        }

        form.woocommerce-checkout>* {
            order: -1;
            flex: 1 1 100%;
            width: 100%
        }

        form.woocommerce-checkout>:is(.customer-details, .checkout-order-review) {
            order: unset;
            flex: 1 0 0;
            width: auto;
            max-width: 50%
        }

        :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review) {
            position: relative;
            padding: 30px;
            background-color: var(--bgcolor-gray-200)
        }

        :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review):before,
        :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review):after {
            content: "";
            position: absolute;
            inset-inline: 0;
            height: 10px;
            background-image: radial-gradient(farthest-side, transparent 6px, var(--bgcolor-gray-200) 0);
            background-size: 15px 15px
        }

        :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review):before {
            top: -10px;
            background-position: -2px -6px, 0 0
        }

        :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review):after {
            bottom: -10px;
            background-position: -2px 1px, 0 0
        }

        .woocommerce-order-pay #order_review {
            margin: 0 auto;
            max-width: 600px
        }

        @media(max-width: 768.98px) {
            form.woocommerce-checkout>:is(.customer-details, .checkout-order-review) {
                flex-basis: 100%;
                width: 100%;
                max-width: 100%
            }
        }

        @media(max-width: 576px) {
            :is(.woocommerce-checkout>.checkout-order-review, .woocommerce-order-pay #order_review) {
                padding: 20px
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            form.woocommerce-checkout>.checkout-order-review {
                flex-grow: 1.2;
                max-width: 60%
            }
        }

        @media(min-width: 769px) {
            .woocommerce-checkout>.customer-details .woocommerce-billing-fields {
                margin-top: 30px
            }
        }

        #order_review_heading {
            text-align: center;
            text-transform: uppercase
        }

        .checkout-order-review>.woocommerce-checkout-review-order .wd-table-wrapper {
            overflow-x: auto;
            margin-bottom: 20px;
            padding: 5px 25px;
            border-radius: var(--wd-brd-radius);
            background-color: var(--bgcolor-white);
            box-shadow: 1px 1px 2px rgba(0, 0, 0, .05)
        }

        .wd-builder-off #place_order {
            width: 100%
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-checkout-predefined.css */
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
    <style id='wd-woo-thank-you-page-inline-css' type='text/css'>
        :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) {
            --list-mb: .001px;
            --li-mb: .001px;
            --li-pl: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            list-style: none
        }

        :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1 1 0%
        }

        :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li:not(:last-child) {
            padding-inline-end: 20px;
            border-inline-end: 1px solid var(--brdcolor-gray-300)
        }

        :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) :is(strong, .amount) {
            color: var(--color-gray-900)
        }

        .wc-bacs-bank-details li {
            text-align: center
        }

        :is(.wd-el-tp-order-message, .wd-el-tp-payment-instructions) p:last-child {
            margin-bottom: 0
        }

        .wd-el-tp-order-details .woocommerce-order-downloads {
            margin-bottom: 30px
        }

        @media(max-width: 768.98px) {
            :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li {
                flex-basis: 250px;
                max-width: 50%
            }

            :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li:nth-child(even) {
                border-inline-end: none
            }
        }

        @media(max-width: 576px) {
            :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li {
                padding-bottom: 20px;
                max-width: 100%;
                border-bottom: 1px solid var(--brdcolor-gray-300)
            }

            :is(.woocommerce-thankyou-order-details, .wc-bacs-bank-details) li:not(:last-child) {
                padding-inline-end: 0;
                border-inline-end: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-thank-you-page.css */
    </style>
    <style id='wd-woo-thank-you-page-predefined-inline-css' type='text/css'>
        .wd-builder-off .woocommerce-order>*:not(:last-child) {
            margin-bottom: 30px
        }

        .wd-builder-off .woocommerce-order:not(.wd-with-extra-content) {
            margin: 0 auto;
            max-width: 800px
        }

        .wd-builder-off :is(.woocommerce-thankyou-order-details li, .woocommerce-thankyou-order-failed-actions) {
            text-align: center
        }

        .wd-builder-off :is(.woocommerce-thankyou-order-received, .woocommerce-thankyou-order-failed) {
            padding: 3%;
            width: 100%;
            color: #7a9c59;
            border: 2px dashed #7a9c59;
            border-radius: var(--wd-brd-radius);
            text-align: center;
            font-weight: 600;
            font-size: 22px;
            line-height: 1.4
        }

        .wd-builder-off .woocommerce-thankyou-order-failed {
            color: #fbbc34;
            border-color: #fbbc34
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-thank-you-page-predefined.css */
    </style>
    <style id='wd-woo-mod-order-details-inline-css' type='text/css'>
        .woocommerce-OrderUpdates {
            --wd-tags-mb: 10px
        }

        :is(.woocommerce-order-downloads, .woocommerce-order-details) .shop_table:last-child {
            margin-bottom: 0
        }

        :is(.woocommerce-order-downloads, .woocommerce-order-details) .button {
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

        :is(.woocommerce-order-downloads, .woocommerce-order-details) .button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        :is(.woocommerce-order-downloads, .woocommerce-order-details) .button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .woocommerce-table--order-details :is(th, td) {
            max-width: 50%;
            width: 50%
        }

        .woocommerce-table--order-details .button:first-child {
            margin-inline-end: 5px
        }

        .woocommerce-order-details .responsive-table:last-child {
            margin-bottom: 0
        }

        .woocommerce-order-details :is(address, .woocommerce-column__title) {
            text-align: start
        }

        .woocommerce-customer-details address {
            --wd-tags-mb: .001px;
            margin-bottom: 0
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-order-details.css */
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
    <link rel='stylesheet' id='wd-wd-search-form-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/wd-search-form.css' type='text/css' media='all' />
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

        <div class="wd-page-title page-title page-title-default title-size-small title-design-centered color-scheme-default">
            <div class="wd-page-title-bg wd-fill"></div>
            <div class="container">
                <ul class="wd-checkout-steps">
                    <li class="step-cart step-inactive">
                        <a href="{{ route('cart') }}"><span>Shopping cart</span></a>
                    </li>
                    <li class="step-checkout step-inactive">
                        <a href="{{ route('checkout') }}"><span>Checkout</span></a>
                    </li>
                    <li class="step-complete step-active">
                        <span>Order complete</span>
                    </li>
                </ul>
            </div>
        </div>

        <main id="main-content" class="wd-content-layout content-layout-wrapper container wd-builder-off" role="main">
            <div class="wd-content-area site-content">
                <article class="entry-content page type-page status-publish hentry">
                    <div class="woocommerce">
                        <div class="woocommerce-order">

                            @if(!$order)
                                <div style="padding:60px 20px;text-align:center;">
                                    <i class="fas fa-circle-exclamation" style="font-size:48px;color:var(--gms-line,#ececec);margin-bottom:16px;display:block;"></i>
                                    <h3 style="margin-bottom:8px;">Order not found</h3>
                                    <p style="margin-bottom:20px;color:#777;">We couldn't find an order matching that ID. Please check your order confirmation email or contact us.</p>
                                    <a href="{{ route('all-products') }}" class="button btn btn-accent">Continue shopping</a>
                                </div>
                            @else
                                @php
                                    $paymentLabels = [
                                        'cod'        => 'Cash on Delivery',
                                        'bkash'      => 'bKash',
                                        'nagad'      => 'Nagad',
                                        'rocket'     => 'Rocket',
                                        'bank'       => 'Bank Transfer',
                                        'uddoktapay' => 'Online Payment',
                                    ];
                                    $placedAt = $order->placed_at ?? $order->created_at;
                                @endphp

                                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                                    Thank you. Your order has been received.
                                </p>

                                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                                    <li class="woocommerce-order-overview__order order">
                                        <span>Order number:</span>
                                        <strong>{{ $order->order_no }}</strong>
                                    </li>

                                    <li class="woocommerce-order-overview__date date">
                                        <span>Date:</span>
                                        <strong>{{ optional($placedAt)->format('F j, Y') }}</strong>
                                    </li>

                                    @if($order->shipping_email)
                                        <li class="woocommerce-order-overview__email email">
                                            <span>Email:</span>
                                            <strong>{{ $order->shipping_email }}</strong>
                                        </li>
                                    @endif

                                    <li class="woocommerce-order-overview__total total">
                                        <span>Total:</span>
                                        <strong><span class="woocommerce-Price-amount amount">{{ \App\Support\Money::format($order->total) }}</span></strong>
                                    </li>

                                    <li class="woocommerce-order-overview__payment-method method">
                                        <span>Payment method:</span>
                                        <strong>{{ $paymentLabels[$order->payment_method] ?? $order->payment_method }}</strong>
                                    </li>
                                </ul>

                                <section class="woocommerce-order-details">
                                    <h2 class="woocommerce-order-details__title">Order details</h2>

                                    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                        <thead>
                                            <tr>
                                                <th class="woocommerce-table__product-name product-name">Product</th>
                                                <th class="woocommerce-table__product-table product-total">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr class="woocommerce-table__line-item order_item">
                                                    <td class="woocommerce-table__product-name product-name">
                                                        {{ $item->product_name }}{{ $item->variant_label ? ' — '.$item->variant_label : '' }}
                                                        <strong class="product-quantity">&times;&nbsp;{{ (int) $item->quantity }}</strong>
                                                    </td>
                                                    <td class="woocommerce-table__product-total product-total">
                                                        <span class="woocommerce-Price-amount amount">{{ \App\Support\Money::format($item->total) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th scope="row">Subtotal:</th>
                                                <td><span class="woocommerce-Price-amount amount">{{ \App\Support\Money::format($order->subtotal) }}</span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Shipping:</th>
                                                <td>{{ (float) $order->shipping_charge > 0 ? \App\Support\Money::format($order->shipping_charge) : 'Free shipping' }}</td>
                                            </tr>
                                            @if((float) $order->discount > 0)
                                                <tr>
                                                    <th scope="row">Discount:</th>
                                                    <td>-{{ \App\Support\Money::format($order->discount) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th scope="row">Total:</th>
                                                <td><span class="woocommerce-Price-amount amount">{{ \App\Support\Money::format($order->total) }}</span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Payment method:</th>
                                                <td>{{ $paymentLabels[$order->payment_method] ?? $order->payment_method }}</td>
                                            </tr>
                                            @if($order->notes)
                                                <tr>
                                                    <th>Note:</th>
                                                    <td>{{ $order->notes }}</td>
                                                </tr>
                                            @endif
                                        </tfoot>
                                    </table>
                                </section>

                                <section class="woocommerce-customer-details">
                                    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
                                        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                                            <h2 class="woocommerce-column__title">Shipping details</h2>
                                            <address>
                                                {{ $order->shipping_name }}<br />
                                                {{ $order->shipping_address }}<br />
                                                {{ trim(($order->shipping_area ? $order->shipping_area.', ' : '').($order->shipping_city ?? ''), ', ') }}
                                                <p class="woocommerce-customer-details--phone">{{ $order->shipping_phone }}</p>
                                                @if($order->shipping_email)
                                                    <p class="woocommerce-customer-details--email">{{ $order->shipping_email }}</p>
                                                @endif
                                            </address>
                                        </div>
                                    </section>
                                </section>
                            @endif

                        </div>
                    </div>
                </article>
            </div>
        </main>

    </div>

<script>
    localStorage.removeItem('gms_cart');
    window.dispatchEvent(new Event('gms:cart-updated'));
</script>
@endsection
