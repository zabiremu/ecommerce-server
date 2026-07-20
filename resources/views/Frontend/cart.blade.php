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
    <link rel='stylesheet' id='wd-page-cart-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/woo-page-cart.css' type='text/css' media='all' />
    <style id='wd-woo-page-cart-builder-inline-css' type='text/css'>
        .wd-cart-totals:not(.wd-title-show) .cart-totals-inner>h2 {
            display: none
        }

        .wd-cart-totals .wc-proceed-to-checkout {
            display: flex;
            flex-direction: column
        }

        .wd-cart-totals .wc-proceed-to-checkout .checkout-button {
            align-self: var(--wd-btn-align, start)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-cart-builder.css */
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
    <style id='wd-header-search-fullscreen-inline-css' type='text/css'>
        [class*=wd-search-full-screen] {
            --wd-search-font-size: 1.08em;
            position: fixed;
            z-index: 400;
            visibility: hidden;
            opacity: 0;
            outline: none !important
        }

        [class*=wd-search-full-screen] :is(.wd-search-history, .wd-search-requests, .wd-search-info-text):not(:last-child) {
            margin-bottom: var(--wd-search-sp)
        }

        [class*=wd-search-full-screen] .wd-scroll-content:not(.wd-dropdown) {
            --wd-scroll-h: 100%
        }

        .wd-search-form[class*=wd-display-full-screen] {
            cursor: pointer
        }

        .wd-search-form[class*=wd-display-full-screen] .searchform {
            pointer-events: none;
            user-select: none
        }

        .wd-search-form[class*=wd-display-full-screen] .wd-clear-search {
            display: none
        }

        [class*=wd-search-full-screen] .wd-search-suggestions {
            animation: wd-fadeInBottomShort .6s cubic-bezier(0.19, 1, 0.22, 1) both
        }

        [class*=wd-search-full-screen] .wd-search-suggestions .wd-search-title {
            margin-top: var(--wd-search-sp)
        }

        [class*=wd-search-full-screen] .wd-search-suggestions .wd-search-title:first-child {
            margin-top: 0
        }

        [class*=wd-search-full-screen] .wd-suggestion {
            flex-direction: column
        }

        [class*=wd-search-full-screen] .wd-suggestion-thumb {
            margin-bottom: 10px
        }

        [class*=wd-search-full-screen] .wd-not-found-msg {
            font-size: var(--wd-search-font-size)
        }

        [class*=wd-search-full-screen] .wd-suggestions-group.wd-type-categories .wd-suggestion {
            flex-direction: row;
            flex-basis: unset
        }

        [class*=wd-search-full-screen] .wd-suggestions-group.wd-type-categories .wd-suggestion .wd-suggestion-thumb {
            margin-bottom: 0
        }

        [class*=wd-search-full-screen] .wd-suggestions-group.wd-type-categories .wd-suggestion .wd-entities-title {
            transition: all .25s ease
        }

        [class*=wd-search-full-screen] .wd-suggestions-group.wd-type-categories .wd-suggestion:hover .wd-entities-title {
            opacity: .6
        }

        [class*=wd-search-full-screen].wd-searched :is(.wd-search-history, .wd-search-requests, .wd-search-info-text) {
            display: none
        }

        [class*=wd-search-full-screen] .wd-search-history ul {
            flex-direction: row;
            flex-wrap: wrap
        }

        [class*=wd-search-full-screen] .wd-sh-head {
            display: block
        }

        [class*=wd-search-full-screen] .wd-sh-head .wd-sh-clear {
            display: none
        }

        [class*=wd-search-full-screen] .wd-sh-link:before {
            display: none
        }

        [class*=wd-search-full-screen].wd-opened {
            visibility: visible;
            opacity: 1
        }

        .wd-search-opened {
            overflow: hidden
        }

        @media(max-width: 1024px) {
            [class*=wd-search-full-screen] {
                --wd-search-font-size: .92em;
                --wd-search-sp: 15px
            }

            [class*=wd-search-full-screen] .wd-search-requests {
                --wd-requests-pd: 8px 12px;
                --wd-requests-fs: 10px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/header-el-search-fullscreen-general.css */
    </style>
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
    <style id='wd-wd-search-results-inline-css' type='text/css'>
        .wd-search-results-wrapper {
            position: relative
        }

        .wd-search-title.title {
            margin-bottom: 0;
            text-transform: uppercase;
            font-size: var(--wd-search-font-size);
            line-height: 1
        }

        .wd-suggestions-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr))
        }

        .wd-suggestion {
            position: relative;
            display: flex;
            line-height: 1;
            transition: all .25s ease
        }

        .wd-suggestion .wd-entities-title {
            font-size: .92em
        }

        .wd-suggestion .wd-entities-title strong {
            text-decoration: underline;
            font-weight: bolder
        }

        .wd-suggestion-thumb img {
            border-radius: calc(var(--wd-brd-radius)/1.5)
        }

        .wd-suggestion-content {
            --wd-mb: 10px
        }

        .wd-suggestion-sku {
            font-size: .8em
        }

        .wd-suggestions-group.wd-type-categories .wd-suggestion-thumb {
            margin-inline-end: 7px
        }

        .wd-suggestions-group.wd-type-categories .wd-suggestion-thumb img {
            max-height: 18px;
            max-width: 18px;
            object-fit: contain;
            object-position: 50% 50%
        }

        .wd-suggestions-group.wd-type-categories .wd-suggestion-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            width: 100%
        }

        .wd-suggestions-group.wd-type-categories .wd-suggestion-content .wd-entities-title {
            flex-grow: 1
        }

        .wd-not-found {
            grid-column: 1/-1
        }

        .wd-all-results {
            --wd-link-color: var(--color-gray-800);
            --wd-link-color-hover: var(--color-gray-800);
            display: block;
            border-block: 1px solid var(--brdcolor-gray-300);
            padding-inline: var(--wd-search-sp);
            text-align: center;
            text-transform: uppercase;
            font-weight: 600;
            font-size: var(--wd-search-font-size);
            line-height: 50px;
            transition: all .25s ease;
            text-decoration: none !important
        }

        .wd-all-results:hover {
            background-color: var(--bgcolor-gray-100) !important
        }

        .wd-search-area {
            position: relative;
            transition: all .25s ease
        }

        .wd-ajax-search-content:not(.wd-content-loaded) .wd-search-area {
            min-height: 70px
        }

        .wd-ajax-search-content:not(.wd-content-loaded) .wd-search-loader {
            opacity: 1;
            pointer-events: auto
        }

        .wd-ajax-search-content:not(.wd-content-loaded) .wd-search-loader:after {
            --wd-anim-state: running
        }

        .wd-search-loader {
            z-index: 410;
            opacity: 0;
            pointer-events: none;
            background-color: rgba(var(--bgcolor-white-rgb), 0.8);
            transition: all .25s cubic-bezier(0.19, 1, 0.22, 1);
            overflow: hidden
        }

        .wd-search-loader:after {
            position: absolute;
            top: calc(50% - 16px);
            left: calc(50% - 16px);
            content: "";
            display: inline-block;
            width: 32px;
            height: 32px;
            border: 1px solid rgba(0, 0, 0, 0);
            border-left-color: var(--color-gray-900);
            border-radius: 50%;
            vertical-align: middle;
            animation: wd-rotate 450ms infinite linear var(--wd-anim-state, paused)
        }

        @media(max-width: 1024px) {
            .wd-suggestions-group {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr))
            }

            .wd-suggestion :is(.wd-entities-title, .price) {
                font-size: .9em
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/wd-search-results.css */
    </style>
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
    <script type="text/javascript" id="wc-country-select-js-extra">
        /* <![CDATA[ */
        var wc_country_select_params = { "countries": "{\"AF\":[],\"AL\":{\"AL-01\":\"Berat\",\"AL-09\":\"Dib\\u00ebr\",\"AL-02\":\"Durr\\u00ebs\",\"AL-03\":\"Elbasan\",\"AL-04\":\"Fier\",\"AL-05\":\"Gjirokast\\u00ebr\",\"AL-06\":\"Kor\\u00e7\\u00eb\",\"AL-07\":\"Kuk\\u00ebs\",\"AL-08\":\"Lezh\\u00eb\",\"AL-10\":\"Shkod\\u00ebr\",\"AL-11\":\"Tirana\",\"AL-12\":\"Vlor\\u00eb\"},\"AO\":{\"BGO\":\"Bengo\",\"BLU\":\"Benguela\",\"BIE\":\"Bi\\u00e9\",\"CAB\":\"Cabinda\",\"CNN\":\"Cunene\",\"HUA\":\"Huambo\",\"HUI\":\"Hu\\u00edla\",\"CCU\":\"Kuando Kubango\",\"CNO\":\"Kwanza-Norte\",\"CUS\":\"Kwanza-Sul\",\"LUA\":\"Luanda\",\"LNO\":\"Lunda-Norte\",\"LSU\":\"Lunda-Sul\",\"MAL\":\"Malanje\",\"MOX\":\"Moxico\",\"NAM\":\"Namibe\",\"UIG\":\"U\\u00edge\",\"ZAI\":\"Zaire\"},\"AR\":{\"C\":\"Ciudad Aut\\u00f3noma de Buenos Aires\",\"B\":\"Buenos Aires\",\"K\":\"Catamarca\",\"H\":\"Chaco\",\"U\":\"Chubut\",\"X\":\"C\\u00f3rdoba\",\"W\":\"Corrientes\",\"E\":\"Entre R\\u00edos\",\"P\":\"Formosa\",\"Y\":\"Jujuy\",\"L\":\"La Pampa\",\"F\":\"La Rioja\",\"M\":\"Mendoza\",\"N\":\"Misiones\",\"Q\":\"Neuqu\\u00e9n\",\"R\":\"R\\u00edo Negro\",\"A\":\"Salta\",\"J\":\"San Juan\",\"D\":\"San Luis\",\"Z\":\"Santa Cruz\",\"S\":\"Santa Fe\",\"G\":\"Santiago del Estero\",\"V\":\"Tierra del Fuego\",\"T\":\"Tucum\\u00e1n\"},\"AT\":[],\"AU\":{\"ACT\":\"Australian Capital Territory\",\"NSW\":\"New South Wales\",\"NT\":\"Northern Territory\",\"QLD\":\"Queensland\",\"SA\":\"South Australia\",\"TAS\":\"Tasmania\",\"VIC\":\"Victoria\",\"WA\":\"Western Australia\"},\"AX\":[],\"BD\":{\"BD-05\":\"Bagerhat\",\"BD-01\":\"Bandarban\",\"BD-02\":\"Barguna\",\"BD-06\":\"Barishal\",\"BD-07\":\"Bhola\",\"BD-03\":\"Bogura\",\"BD-04\":\"Brahmanbaria\",\"BD-09\":\"Chandpur\",\"BD-10\":\"Chattogram\",\"BD-12\":\"Chuadanga\",\"BD-11\":\"Cox's Bazar\",\"BD-08\":\"Cumilla\",\"BD-13\":\"Dhaka\",\"BD-14\":\"Dinajpur\",\"BD-15\":\"Faridpur \",\"BD-16\":\"Feni\",\"BD-19\":\"Gaibandha\",\"BD-18\":\"Gazipur\",\"BD-17\":\"Gopalganj\",\"BD-20\":\"Habiganj\",\"BD-21\":\"Jamalpur\",\"BD-22\":\"Jashore\",\"BD-25\":\"Jhalokati\",\"BD-23\":\"Jhenaidah\",\"BD-24\":\"Joypurhat\",\"BD-29\":\"Khagrachhari\",\"BD-27\":\"Khulna\",\"BD-26\":\"Kishoreganj\",\"BD-28\":\"Kurigram\",\"BD-30\":\"Kushtia\",\"BD-31\":\"Lakshmipur\",\"BD-32\":\"Lalmonirhat\",\"BD-36\":\"Madaripur\",\"BD-37\":\"Magura\",\"BD-33\":\"Manikganj \",\"BD-39\":\"Meherpur\",\"BD-38\":\"Moulvibazar\",\"BD-35\":\"Munshiganj\",\"BD-34\":\"Mymensingh\",\"BD-48\":\"Naogaon\",\"BD-43\":\"Narail\",\"BD-40\":\"Narayanganj\",\"BD-42\":\"Narsingdi\",\"BD-44\":\"Natore\",\"BD-45\":\"Nawabganj\",\"BD-41\":\"Netrakona\",\"BD-46\":\"Nilphamari\",\"BD-47\":\"Noakhali\",\"BD-49\":\"Pabna\",\"BD-52\":\"Panchagarh\",\"BD-51\":\"Patuakhali\",\"BD-50\":\"Pirojpur\",\"BD-53\":\"Rajbari\",\"BD-54\":\"Rajshahi\",\"BD-56\":\"Rangamati\",\"BD-55\":\"Rangpur\",\"BD-58\":\"Satkhira\",\"BD-62\":\"Shariatpur\",\"BD-57\":\"Sherpur\",\"BD-59\":\"Sirajganj\",\"BD-61\":\"Sunamganj\",\"BD-60\":\"Sylhet\",\"BD-63\":\"Tangail\",\"BD-64\":\"Thakurgaon\"},\"BE\":[],\"BG\":{\"BG-01\":\"Blagoevgrad\",\"BG-02\":\"Burgas\",\"BG-08\":\"Dobrich\",\"BG-07\":\"Gabrovo\",\"BG-26\":\"Haskovo\",\"BG-09\":\"Kardzhali\",\"BG-10\":\"Kyustendil\",\"BG-11\":\"Lovech\",\"BG-12\":\"Montana\",\"BG-13\":\"Pazardzhik\",\"BG-14\":\"Pernik\",\"BG-15\":\"Pleven\",\"BG-16\":\"Plovdiv\",\"BG-17\":\"Razgrad\",\"BG-18\":\"Ruse\",\"BG-27\":\"Shumen\",\"BG-19\":\"Silistra\",\"BG-20\":\"Sliven\",\"BG-21\":\"Smolyan\",\"BG-23\":\"Sofia District\",\"BG-22\":\"Sofia\",\"BG-24\":\"Stara Zagora\",\"BG-25\":\"Targovishte\",\"BG-03\":\"Varna\",\"BG-04\":\"Veliko Tarnovo\",\"BG-05\":\"Vidin\",\"BG-06\":\"Vratsa\",\"BG-28\":\"Yambol\"},\"BH\":[],\"BI\":[],\"BJ\":{\"AL\":\"Alibori\",\"AK\":\"Atakora\",\"AQ\":\"Atlantique\",\"BO\":\"Borgou\",\"CO\":\"Collines\",\"KO\":\"Kouffo\",\"DO\":\"Donga\",\"LI\":\"Littoral\",\"MO\":\"Mono\",\"OU\":\"Ou\\u00e9m\\u00e9\",\"PL\":\"Plateau\",\"ZO\":\"Zou\"},\"BO\":{\"BO-B\":\"Beni\",\"BO-H\":\"Chuquisaca\",\"BO-C\":\"Cochabamba\",\"BO-L\":\"La Paz\",\"BO-O\":\"Oruro\",\"BO-N\":\"Pando\",\"BO-P\":\"Potos\\u00ed\",\"BO-S\":\"Santa Cruz\",\"BO-T\":\"Tarija\"},\"BR\":{\"AC\":\"Acre\",\"AL\":\"Alagoas\",\"AP\":\"Amap\\u00e1\",\"AM\":\"Amazonas\",\"BA\":\"Bahia\",\"CE\":\"Cear\\u00e1\",\"DF\":\"Distrito Federal\",\"ES\":\"Esp\\u00edrito Santo\",\"GO\":\"Goi\\u00e1s\",\"MA\":\"Maranh\\u00e3o\",\"MT\":\"Mato Grosso\",\"MS\":\"Mato Grosso do Sul\",\"MG\":\"Minas Gerais\",\"PA\":\"Par\\u00e1\",\"PB\":\"Para\\u00edba\",\"PR\":\"Paran\\u00e1\",\"PE\":\"Pernambuco\",\"PI\":\"Piau\\u00ed\",\"RJ\":\"Rio de Janeiro\",\"RN\":\"Rio Grande do Norte\",\"RS\":\"Rio Grande do Sul\",\"RO\":\"Rond\\u00f4nia\",\"RR\":\"Roraima\",\"SC\":\"Santa Catarina\",\"SP\":\"S\\u00e3o Paulo\",\"SE\":\"Sergipe\",\"TO\":\"Tocantins\"},\"CA\":{\"AB\":\"Alberta\",\"BC\":\"British Columbia\",\"MB\":\"Manitoba\",\"NB\":\"New Brunswick\",\"NL\":\"Newfoundland and Labrador\",\"NT\":\"Northwest Territories\",\"NS\":\"Nova Scotia\",\"NU\":\"Nunavut\",\"ON\":\"Ontario\",\"PE\":\"Prince Edward Island\",\"QC\":\"Quebec\",\"SK\":\"Saskatchewan\",\"YT\":\"Yukon Territory\"},\"CH\":{\"AG\":\"Aargau\",\"AR\":\"Appenzell Ausserrhoden\",\"AI\":\"Appenzell Innerrhoden\",\"BL\":\"Basel-Landschaft\",\"BS\":\"Basel-Stadt\",\"BE\":\"Bern\",\"FR\":\"Fribourg\",\"GE\":\"Geneva\",\"GL\":\"Glarus\",\"GR\":\"Graub\\u00fcnden\",\"JU\":\"Jura\",\"LU\":\"Luzern\",\"NE\":\"Neuch\\u00e2tel\",\"NW\":\"Nidwalden\",\"OW\":\"Obwalden\",\"SH\":\"Schaffhausen\",\"SZ\":\"Schwyz\",\"SO\":\"Solothurn\",\"SG\":\"St. Gallen\",\"TG\":\"Thurgau\",\"TI\":\"Ticino\",\"UR\":\"Uri\",\"VS\":\"Valais\",\"VD\":\"Vaud\",\"ZG\":\"Zug\",\"ZH\":\"Z\\u00fcrich\"},\"CL\":{\"CL-AI\":\"Ais\\u00e9n del General Carlos Iba\\u00f1ez del Campo\",\"CL-AN\":\"Antofagasta\",\"CL-AP\":\"Arica y Parinacota\",\"CL-AR\":\"La Araucan\\u00eda\",\"CL-AT\":\"Atacama\",\"CL-BI\":\"Biob\\u00edo\",\"CL-CO\":\"Coquimbo\",\"CL-LI\":\"Libertador General Bernardo O'Higgins\",\"CL-LL\":\"Los Lagos\",\"CL-LR\":\"Los R\\u00edos\",\"CL-MA\":\"Magallanes\",\"CL-ML\":\"Maule\",\"CL-NB\":\"\\u00d1uble\",\"CL-RM\":\"Regi\\u00f3n Metropolitana de Santiago\",\"CL-TA\":\"Tarapac\\u00e1\",\"CL-VS\":\"Valpara\\u00edso\"},\"CN\":{\"CN1\":\"Yunnan / \\u4e91\\u5357\",\"CN2\":\"Beijing / \\u5317\\u4eac\",\"CN3\":\"Tianjin / \\u5929\\u6d25\",\"CN4\":\"Hebei / \\u6cb3\\u5317\",\"CN5\":\"Shanxi / \\u5c71\\u897f\",\"CN6\":\"Inner Mongolia / \\u5167\\u8499\\u53e4\",\"CN7\":\"Liaoning / \\u8fbd\\u5b81\",\"CN8\":\"Jilin / \\u5409\\u6797\",\"CN9\":\"Heilongjiang / \\u9ed1\\u9f99\\u6c5f\",\"CN10\":\"Shanghai / \\u4e0a\\u6d77\",\"CN11\":\"Jiangsu / \\u6c5f\\u82cf\",\"CN12\":\"Zhejiang / \\u6d59\\u6c5f\",\"CN13\":\"Anhui / \\u5b89\\u5fbd\",\"CN14\":\"Fujian / \\u798f\\u5efa\",\"CN15\":\"Jiangxi / \\u6c5f\\u897f\",\"CN16\":\"Shandong / \\u5c71\\u4e1c\",\"CN17\":\"Henan / \\u6cb3\\u5357\",\"CN18\":\"Hubei / \\u6e56\\u5317\",\"CN19\":\"Hunan / \\u6e56\\u5357\",\"CN20\":\"Guangdong / \\u5e7f\\u4e1c\",\"CN21\":\"Guangxi Zhuang / \\u5e7f\\u897f\\u58ee\\u65cf\",\"CN22\":\"Hainan / \\u6d77\\u5357\",\"CN23\":\"Chongqing / \\u91cd\\u5e86\",\"CN24\":\"Sichuan / \\u56db\\u5ddd\",\"CN25\":\"Guizhou / \\u8d35\\u5dde\",\"CN26\":\"Shaanxi / \\u9655\\u897f\",\"CN27\":\"Gansu / \\u7518\\u8083\",\"CN28\":\"Qinghai / \\u9752\\u6d77\",\"CN29\":\"Ningxia Hui / \\u5b81\\u590f\",\"CN30\":\"Macao / \\u6fb3\\u95e8\",\"CN31\":\"Tibet / \\u897f\\u85cf\",\"CN32\":\"Xinjiang / \\u65b0\\u7586\"},\"CO\":{\"CO-AMA\":\"Amazonas\",\"CO-ANT\":\"Antioquia\",\"CO-ARA\":\"Arauca\",\"CO-ATL\":\"Atl\\u00e1ntico\",\"CO-BOL\":\"Bol\\u00edvar\",\"CO-BOY\":\"Boyac\\u00e1\",\"CO-CAL\":\"Caldas\",\"CO-CAQ\":\"Caquet\\u00e1\",\"CO-CAS\":\"Casanare\",\"CO-CAU\":\"Cauca\",\"CO-CES\":\"Cesar\",\"CO-CHO\":\"Choc\\u00f3\",\"CO-COR\":\"C\\u00f3rdoba\",\"CO-CUN\":\"Cundinamarca\",\"CO-DC\":\"Capital District\",\"CO-GUA\":\"Guain\\u00eda\",\"CO-GUV\":\"Guaviare\",\"CO-HUI\":\"Huila\",\"CO-LAG\":\"La Guajira\",\"CO-MAG\":\"Magdalena\",\"CO-MET\":\"Meta\",\"CO-NAR\":\"Nari\\u00f1o\",\"CO-NSA\":\"Norte de Santander\",\"CO-PUT\":\"Putumayo\",\"CO-QUI\":\"Quind\\u00edo\",\"CO-RIS\":\"Risaralda\",\"CO-SAN\":\"Santander\",\"CO-SAP\":\"San Andr\\u00e9s & Providencia\",\"CO-SUC\":\"Sucre\",\"CO-TOL\":\"Tolima\",\"CO-VAC\":\"Valle del Cauca\",\"CO-VAU\":\"Vaup\\u00e9s\",\"CO-VID\":\"Vichada\"},\"CR\":{\"CR-A\":\"Alajuela\",\"CR-C\":\"Cartago\",\"CR-G\":\"Guanacaste\",\"CR-H\":\"Heredia\",\"CR-L\":\"Lim\\u00f3n\",\"CR-P\":\"Puntarenas\",\"CR-SJ\":\"San Jos\\u00e9\"},\"CZ\":[],\"DE\":{\"DE-BW\":\"Baden-W\\u00fcrttemberg\",\"DE-BY\":\"Bavaria\",\"DE-BE\":\"Berlin\",\"DE-BB\":\"Brandenburg\",\"DE-HB\":\"Bremen\",\"DE-HH\":\"Hamburg\",\"DE-HE\":\"Hesse\",\"DE-MV\":\"Mecklenburg-Vorpommern\",\"DE-NI\":\"Lower Saxony\",\"DE-NW\":\"North Rhine-Westphalia\",\"DE-RP\":\"Rhineland-Palatinate\",\"DE-SL\":\"Saarland\",\"DE-SN\":\"Saxony\",\"DE-ST\":\"Saxony-Anhalt\",\"DE-SH\":\"Schleswig-Holstein\",\"DE-TH\":\"Thuringia\"},\"DK\":[],\"DO\":{\"DO-01\":\"Distrito Nacional\",\"DO-02\":\"Azua\",\"DO-03\":\"Baoruco\",\"DO-04\":\"Barahona\",\"DO-33\":\"Cibao Nordeste\",\"DO-34\":\"Cibao Noroeste\",\"DO-35\":\"Cibao Norte\",\"DO-36\":\"Cibao Sur\",\"DO-05\":\"Dajab\\u00f3n\",\"DO-06\":\"Duarte\",\"DO-08\":\"El Seibo\",\"DO-37\":\"El Valle\",\"DO-07\":\"El\\u00edas Pi\\u00f1a\",\"DO-38\":\"Enriquillo\",\"DO-09\":\"Espaillat\",\"DO-30\":\"Hato Mayor\",\"DO-19\":\"Hermanas Mirabal\",\"DO-39\":\"Hig\\u00fcamo\",\"DO-10\":\"Independencia\",\"DO-11\":\"La Altagracia\",\"DO-12\":\"La Romana\",\"DO-13\":\"La Vega\",\"DO-14\":\"Mar\\u00eda Trinidad S\\u00e1nchez\",\"DO-28\":\"Monse\\u00f1or Nouel\",\"DO-15\":\"Monte Cristi\",\"DO-29\":\"Monte Plata\",\"DO-40\":\"Ozama\",\"DO-16\":\"Pedernales\",\"DO-17\":\"Peravia\",\"DO-18\":\"Puerto Plata\",\"DO-20\":\"Saman\\u00e1\",\"DO-21\":\"San Crist\\u00f3bal\",\"DO-31\":\"San Jos\\u00e9 de Ocoa\",\"DO-22\":\"San Juan\",\"DO-23\":\"San Pedro de Macor\\u00eds\",\"DO-24\":\"S\\u00e1nchez Ram\\u00edrez\",\"DO-25\":\"Santiago\",\"DO-26\":\"Santiago Rodr\\u00edguez\",\"DO-32\":\"Santo Domingo\",\"DO-41\":\"Valdesia\",\"DO-27\":\"Valverde\",\"DO-42\":\"Yuma\"},\"DZ\":{\"DZ-01\":\"Adrar\",\"DZ-02\":\"Chlef\",\"DZ-03\":\"Laghouat\",\"DZ-04\":\"Oum El Bouaghi\",\"DZ-05\":\"Batna\",\"DZ-06\":\"B\\u00e9ja\\u00efa\",\"DZ-07\":\"Biskra\",\"DZ-08\":\"B\\u00e9char\",\"DZ-09\":\"Blida\",\"DZ-10\":\"Bouira\",\"DZ-11\":\"Tamanghasset\",\"DZ-12\":\"T\\u00e9bessa\",\"DZ-13\":\"Tlemcen\",\"DZ-14\":\"Tiaret\",\"DZ-15\":\"Tizi Ouzou\",\"DZ-16\":\"Algiers\",\"DZ-17\":\"Djelfa\",\"DZ-18\":\"Jijel\",\"DZ-19\":\"S\\u00e9tif\",\"DZ-20\":\"Sa\\u00efda\",\"DZ-21\":\"Skikda\",\"DZ-22\":\"Sidi Bel Abb\\u00e8s\",\"DZ-23\":\"Annaba\",\"DZ-24\":\"Guelma\",\"DZ-25\":\"Constantine\",\"DZ-26\":\"M\\u00e9d\\u00e9a\",\"DZ-27\":\"Mostaganem\",\"DZ-28\":\"M\\u2019Sila\",\"DZ-29\":\"Mascara\",\"DZ-30\":\"Ouargla\",\"DZ-31\":\"Oran\",\"DZ-32\":\"El Bayadh\",\"DZ-33\":\"Illizi\",\"DZ-34\":\"Bordj Bou Arr\\u00e9ridj\",\"DZ-35\":\"Boumerd\\u00e8s\",\"DZ-36\":\"El Tarf\",\"DZ-37\":\"Tindouf\",\"DZ-38\":\"Tissemsilt\",\"DZ-39\":\"El Oued\",\"DZ-40\":\"Khenchela\",\"DZ-41\":\"Souk Ahras\",\"DZ-42\":\"Tipasa\",\"DZ-43\":\"Mila\",\"DZ-44\":\"A\\u00efn Defla\",\"DZ-45\":\"Naama\",\"DZ-46\":\"A\\u00efn T\\u00e9mouchent\",\"DZ-47\":\"Gharda\\u00efa\",\"DZ-48\":\"Relizane\"},\"EE\":[],\"EC\":{\"EC-A\":\"Azuay\",\"EC-B\":\"Bol\\u00edvar\",\"EC-F\":\"Ca\\u00f1ar\",\"EC-C\":\"Carchi\",\"EC-H\":\"Chimborazo\",\"EC-X\":\"Cotopaxi\",\"EC-O\":\"El Oro\",\"EC-E\":\"Esmeraldas\",\"EC-W\":\"Gal\\u00e1pagos\",\"EC-G\":\"Guayas\",\"EC-I\":\"Imbabura\",\"EC-L\":\"Loja\",\"EC-R\":\"Los R\\u00edos\",\"EC-M\":\"Manab\\u00ed\",\"EC-S\":\"Morona-Santiago\",\"EC-N\":\"Napo\",\"EC-D\":\"Orellana\",\"EC-Y\":\"Pastaza\",\"EC-P\":\"Pichincha\",\"EC-SE\":\"Santa Elena\",\"EC-SD\":\"Santo Domingo de los Ts\\u00e1chilas\",\"EC-U\":\"Sucumb\\u00edos\",\"EC-T\":\"Tungurahua\",\"EC-Z\":\"Zamora-Chinchipe\"},\"EG\":{\"EGALX\":\"Alexandria\",\"EGASN\":\"Aswan\",\"EGAST\":\"Asyut\",\"EGBA\":\"Red Sea\",\"EGBH\":\"Beheira\",\"EGBNS\":\"Beni Suef\",\"EGC\":\"Cairo\",\"EGDK\":\"Dakahlia\",\"EGDT\":\"Damietta\",\"EGFYM\":\"Faiyum\",\"EGGH\":\"Gharbia\",\"EGGZ\":\"Giza\",\"EGIS\":\"Ismailia\",\"EGJS\":\"South Sinai\",\"EGKB\":\"Qalyubia\",\"EGKFS\":\"Kafr el-Sheikh\",\"EGKN\":\"Qena\",\"EGLX\":\"Luxor\",\"EGMN\":\"Minya\",\"EGMNF\":\"Monufia\",\"EGMT\":\"Matrouh\",\"EGPTS\":\"Port Said\",\"EGSHG\":\"Sohag\",\"EGSHR\":\"Al Sharqia\",\"EGSIN\":\"North Sinai\",\"EGSUZ\":\"Suez\",\"EGWAD\":\"New Valley\"},\"ES\":{\"C\":\"A Coru\\u00f1a\",\"VI\":\"Araba/\\u00c1lava\",\"AB\":\"Albacete\",\"A\":\"Alicante\",\"AL\":\"Almer\\u00eda\",\"O\":\"Asturias\",\"AV\":\"\\u00c1vila\",\"BA\":\"Badajoz\",\"PM\":\"Baleares\",\"B\":\"Barcelona\",\"BU\":\"Burgos\",\"CC\":\"C\\u00e1ceres\",\"CA\":\"C\\u00e1diz\",\"S\":\"Cantabria\",\"CS\":\"Castell\\u00f3n\",\"CE\":\"Ceuta\",\"CR\":\"Ciudad Real\",\"CO\":\"C\\u00f3rdoba\",\"CU\":\"Cuenca\",\"GI\":\"Girona\",\"GR\":\"Granada\",\"GU\":\"Guadalajara\",\"SS\":\"Gipuzkoa\",\"H\":\"Huelva\",\"HU\":\"Huesca\",\"J\":\"Ja\\u00e9n\",\"LO\":\"La Rioja\",\"GC\":\"Las Palmas\",\"LE\":\"Le\\u00f3n\",\"L\":\"Lleida\",\"LU\":\"Lugo\",\"M\":\"Madrid\",\"MA\":\"M\\u00e1laga\",\"ML\":\"Melilla\",\"MU\":\"Murcia\",\"NA\":\"Navarra\",\"OR\":\"Ourense\",\"P\":\"Palencia\",\"PO\":\"Pontevedra\",\"SA\":\"Salamanca\",\"TF\":\"Santa Cruz de Tenerife\",\"SG\":\"Segovia\",\"SE\":\"Sevilla\",\"SO\":\"Soria\",\"T\":\"Tarragona\",\"TE\":\"Teruel\",\"TO\":\"Toledo\",\"V\":\"Valencia\",\"VA\":\"Valladolid\",\"BI\":\"Biscay\",\"ZA\":\"Zamora\",\"Z\":\"Zaragoza\"},\"ET\":[],\"FI\":[],\"FR\":[],\"GF\":[],\"GH\":{\"AF\":\"Ahafo\",\"AH\":\"Ashanti\",\"BA\":\"Brong-Ahafo\",\"BO\":\"Bono\",\"BE\":\"Bono East\",\"CP\":\"Central\",\"EP\":\"Eastern\",\"AA\":\"Greater Accra\",\"NE\":\"North East\",\"NP\":\"Northern\",\"OT\":\"Oti\",\"SV\":\"Savannah\",\"UE\":\"Upper East\",\"UW\":\"Upper West\",\"TV\":\"Volta\",\"WP\":\"Western\",\"WN\":\"Western North\"},\"GP\":[],\"GR\":{\"I\":\"Attica\",\"A\":\"East Macedonia and Thrace\",\"B\":\"Central Macedonia\",\"C\":\"West Macedonia\",\"D\":\"Epirus\",\"E\":\"Thessaly\",\"F\":\"Ionian Islands\",\"G\":\"West Greece\",\"H\":\"Central Greece\",\"J\":\"Peloponnese\",\"K\":\"North Aegean\",\"L\":\"South Aegean\",\"M\":\"Crete\"},\"GT\":{\"GT-AV\":\"Alta Verapaz\",\"GT-BV\":\"Baja Verapaz\",\"GT-CM\":\"Chimaltenango\",\"GT-CQ\":\"Chiquimula\",\"GT-PR\":\"El Progreso\",\"GT-ES\":\"Escuintla\",\"GT-GU\":\"Guatemala\",\"GT-HU\":\"Huehuetenango\",\"GT-IZ\":\"Izabal\",\"GT-JA\":\"Jalapa\",\"GT-JU\":\"Jutiapa\",\"GT-PE\":\"Pet\\u00e9n\",\"GT-QZ\":\"Quetzaltenango\",\"GT-QC\":\"Quich\\u00e9\",\"GT-RE\":\"Retalhuleu\",\"GT-SA\":\"Sacatep\\u00e9quez\",\"GT-SM\":\"San Marcos\",\"GT-SR\":\"Santa Rosa\",\"GT-SO\":\"Solol\\u00e1\",\"GT-SU\":\"Suchitep\\u00e9quez\",\"GT-TO\":\"Totonicap\\u00e1n\",\"GT-ZA\":\"Zacapa\"},\"HK\":{\"HONG KONG\":\"Hong Kong Island\",\"KOWLOON\":\"Kowloon\",\"NEW TERRITORIES\":\"New Territories\"},\"HN\":{\"HN-AT\":\"Atl\\u00e1ntida\",\"HN-IB\":\"Bay Islands\",\"HN-CH\":\"Choluteca\",\"HN-CL\":\"Col\\u00f3n\",\"HN-CM\":\"Comayagua\",\"HN-CP\":\"Cop\\u00e1n\",\"HN-CR\":\"Cort\\u00e9s\",\"HN-EP\":\"El Para\\u00edso\",\"HN-FM\":\"Francisco Moraz\\u00e1n\",\"HN-GD\":\"Gracias a Dios\",\"HN-IN\":\"Intibuc\\u00e1\",\"HN-LE\":\"Lempira\",\"HN-LP\":\"La Paz\",\"HN-OC\":\"Ocotepeque\",\"HN-OL\":\"Olancho\",\"HN-SB\":\"Santa B\\u00e1rbara\",\"HN-VA\":\"Valle\",\"HN-YO\":\"Yoro\"},\"HR\":{\"HR-01\":\"Zagreb County\",\"HR-02\":\"Krapina-Zagorje County\",\"HR-03\":\"Sisak-Moslavina County\",\"HR-04\":\"Karlovac County\",\"HR-05\":\"Vara\\u017edin County\",\"HR-06\":\"Koprivnica-Kri\\u017eevci County\",\"HR-07\":\"Bjelovar-Bilogora County\",\"HR-08\":\"Primorje-Gorski Kotar County\",\"HR-09\":\"Lika-Senj County\",\"HR-10\":\"Virovitica-Podravina County\",\"HR-11\":\"Po\\u017eega-Slavonia County\",\"HR-12\":\"Brod-Posavina County\",\"HR-13\":\"Zadar County\",\"HR-14\":\"Osijek-Baranja County\",\"HR-15\":\"\\u0160ibenik-Knin County\",\"HR-16\":\"Vukovar-Srijem County\",\"HR-17\":\"Split-Dalmatia County\",\"HR-18\":\"Istria County\",\"HR-19\":\"Dubrovnik-Neretva County\",\"HR-20\":\"Me\\u0111imurje County\",\"HR-21\":\"Zagreb City\"},\"HU\":{\"BK\":\"B\\u00e1cs-Kiskun\",\"BE\":\"B\\u00e9k\\u00e9s\",\"BA\":\"Baranya\",\"BZ\":\"Borsod-Aba\\u00faj-Zempl\\u00e9n\",\"BU\":\"Budapest\",\"CS\":\"Csongr\\u00e1d-Csan\\u00e1d\",\"FE\":\"Fej\\u00e9r\",\"GS\":\"Gy\\u0151r-Moson-Sopron\",\"HB\":\"Hajd\\u00fa-Bihar\",\"HE\":\"Heves\",\"JN\":\"J\\u00e1sz-Nagykun-Szolnok\",\"KE\":\"Kom\\u00e1rom-Esztergom\",\"NO\":\"N\\u00f3gr\\u00e1d\",\"PE\":\"Pest\",\"SO\":\"Somogy\",\"SZ\":\"Szabolcs-Szatm\\u00e1r-Bereg\",\"TO\":\"Tolna\",\"VA\":\"Vas\",\"VE\":\"Veszpr\\u00e9m\",\"ZA\":\"Zala\"},\"ID\":{\"AC\":\"Daerah Istimewa Aceh\",\"SU\":\"Sumatera Utara\",\"SB\":\"Sumatera Barat\",\"RI\":\"Riau\",\"KR\":\"Kepulauan Riau\",\"JA\":\"Jambi\",\"SS\":\"Sumatera Selatan\",\"BB\":\"Bangka Belitung\",\"BE\":\"Bengkulu\",\"LA\":\"Lampung\",\"JK\":\"DKI Jakarta\",\"JB\":\"Jawa Barat\",\"BT\":\"Banten\",\"JT\":\"Jawa Tengah\",\"JI\":\"Jawa Timur\",\"YO\":\"Daerah Istimewa Yogyakarta\",\"BA\":\"Bali\",\"NB\":\"Nusa Tenggara Barat\",\"NT\":\"Nusa Tenggara Timur\",\"KB\":\"Kalimantan Barat\",\"KT\":\"Kalimantan Tengah\",\"KI\":\"Kalimantan Timur\",\"KS\":\"Kalimantan Selatan\",\"KU\":\"Kalimantan Utara\",\"SA\":\"Sulawesi Utara\",\"ST\":\"Sulawesi Tengah\",\"SG\":\"Sulawesi Tenggara\",\"SR\":\"Sulawesi Barat\",\"SN\":\"Sulawesi Selatan\",\"GO\":\"Gorontalo\",\"MA\":\"Maluku\",\"MU\":\"Maluku Utara\",\"PA\":\"Papua\",\"PB\":\"Papua Barat\"},\"IE\":{\"CW\":\"Carlow\",\"CN\":\"Cavan\",\"CE\":\"Clare\",\"CO\":\"Cork\",\"DL\":\"Donegal\",\"D\":\"Dublin\",\"G\":\"Galway\",\"KY\":\"Kerry\",\"KE\":\"Kildare\",\"KK\":\"Kilkenny\",\"LS\":\"Laois\",\"LM\":\"Leitrim\",\"LK\":\"Limerick\",\"LD\":\"Longford\",\"LH\":\"Louth\",\"MO\":\"Mayo\",\"MH\":\"Meath\",\"MN\":\"Monaghan\",\"OY\":\"Offaly\",\"RN\":\"Roscommon\",\"SO\":\"Sligo\",\"TA\":\"Tipperary\",\"WD\":\"Waterford\",\"WH\":\"Westmeath\",\"WX\":\"Wexford\",\"WW\":\"Wicklow\"},\"IN\":{\"AN\":\"Andaman and Nicobar Islands\",\"AP\":\"Andhra Pradesh\",\"AR\":\"Arunachal Pradesh\",\"AS\":\"Assam\",\"BR\":\"Bihar\",\"CH\":\"Chandigarh\",\"CT\":\"Chhattisgarh\",\"DD\":\"Daman and Diu\",\"DH\":\"D\\u0101dra and Nagar Haveli and Dam\\u0101n and Diu\",\"DL\":\"Delhi\",\"DN\":\"Dadra and Nagar Haveli\",\"GA\":\"Goa\",\"GJ\":\"Gujarat\",\"HP\":\"Himachal Pradesh\",\"HR\":\"Haryana\",\"JH\":\"Jharkhand\",\"JK\":\"Jammu and Kashmir\",\"KA\":\"Karnataka\",\"KL\":\"Kerala\",\"LA\":\"Ladakh\",\"LD\":\"Lakshadweep\",\"MH\":\"Maharashtra\",\"ML\":\"Meghalaya\",\"MN\":\"Manipur\",\"MP\":\"Madhya Pradesh\",\"MZ\":\"Mizoram\",\"NL\":\"Nagaland\",\"OD\":\"Odisha\",\"PB\":\"Punjab\",\"PY\":\"Pondicherry (Puducherry)\",\"RJ\":\"Rajasthan\",\"SK\":\"Sikkim\",\"TS\":\"Telangana\",\"TN\":\"Tamil Nadu\",\"TR\":\"Tripura\",\"UP\":\"Uttar Pradesh\",\"UK\":\"Uttarakhand\",\"WB\":\"West Bengal\"},\"IR\":{\"KHZ\":\"Khuzestan (\\u062e\\u0648\\u0632\\u0633\\u062a\\u0627\\u0646)\",\"THR\":\"Tehran (\\u062a\\u0647\\u0631\\u0627\\u0646)\",\"ILM\":\"Ilaam (\\u0627\\u06cc\\u0644\\u0627\\u0645)\",\"BHR\":\"Bushehr (\\u0628\\u0648\\u0634\\u0647\\u0631)\",\"ADL\":\"Ardabil (\\u0627\\u0631\\u062f\\u0628\\u06cc\\u0644)\",\"ESF\":\"Isfahan (\\u0627\\u0635\\u0641\\u0647\\u0627\\u0646)\",\"YZD\":\"Yazd (\\u06cc\\u0632\\u062f)\",\"KRH\":\"Kermanshah (\\u06a9\\u0631\\u0645\\u0627\\u0646\\u0634\\u0627\\u0647)\",\"KRN\":\"Kerman (\\u06a9\\u0631\\u0645\\u0627\\u0646)\",\"HDN\":\"Hamadan (\\u0647\\u0645\\u062f\\u0627\\u0646)\",\"GZN\":\"Ghazvin (\\u0642\\u0632\\u0648\\u06cc\\u0646)\",\"ZJN\":\"Zanjan (\\u0632\\u0646\\u062c\\u0627\\u0646)\",\"LRS\":\"Luristan (\\u0644\\u0631\\u0633\\u062a\\u0627\\u0646)\",\"ABZ\":\"Alborz (\\u0627\\u0644\\u0628\\u0631\\u0632)\",\"EAZ\":\"East Azarbaijan (\\u0622\\u0630\\u0631\\u0628\\u0627\\u06cc\\u062c\\u0627\\u0646 \\u0634\\u0631\\u0642\\u06cc)\",\"WAZ\":\"West Azarbaijan (\\u0622\\u0630\\u0631\\u0628\\u0627\\u06cc\\u062c\\u0627\\u0646 \\u063a\\u0631\\u0628\\u06cc)\",\"CHB\":\"Chaharmahal and Bakhtiari (\\u0686\\u0647\\u0627\\u0631\\u0645\\u062d\\u0627\\u0644 \\u0648 \\u0628\\u062e\\u062a\\u06cc\\u0627\\u0631\\u06cc)\",\"SKH\":\"South Khorasan (\\u062e\\u0631\\u0627\\u0633\\u0627\\u0646 \\u062c\\u0646\\u0648\\u0628\\u06cc)\",\"RKH\":\"Razavi Khorasan (\\u062e\\u0631\\u0627\\u0633\\u0627\\u0646 \\u0631\\u0636\\u0648\\u06cc)\",\"NKH\":\"North Khorasan (\\u062e\\u0631\\u0627\\u0633\\u0627\\u0646 \\u0634\\u0645\\u0627\\u0644\\u06cc)\",\"SMN\":\"Semnan (\\u0633\\u0645\\u0646\\u0627\\u0646)\",\"FRS\":\"Fars (\\u0641\\u0627\\u0631\\u0633)\",\"QHM\":\"Qom (\\u0642\\u0645)\",\"KRD\":\"Kurdistan (\\u06a9\\u0631\\u062f\\u0633\\u062a\\u0627\\u0646)\",\"KBD\":\"Kohgiluyeh and BoyerAhmad (\\u06a9\\u0647\\u06af\\u06cc\\u0644\\u0648\\u06cc\\u06cc\\u0647 \\u0648 \\u0628\\u0648\\u06cc\\u0631\\u0627\\u062d\\u0645\\u062f)\",\"GLS\":\"Golestan (\\u06af\\u0644\\u0633\\u062a\\u0627\\u0646)\",\"GIL\":\"Gilan (\\u06af\\u06cc\\u0644\\u0627\\u0646)\",\"MZN\":\"Mazandaran (\\u0645\\u0627\\u0632\\u0646\\u062f\\u0631\\u0627\\u0646)\",\"MKZ\":\"Markazi (\\u0645\\u0631\\u06a9\\u0632\\u06cc)\",\"HRZ\":\"Hormozgan (\\u0647\\u0631\\u0645\\u0632\\u06af\\u0627\\u0646)\",\"SBN\":\"Sistan and Baluchestan (\\u0633\\u06cc\\u0633\\u062a\\u0627\\u0646 \\u0648 \\u0628\\u0644\\u0648\\u0686\\u0633\\u062a\\u0627\\u0646)\"},\"IS\":[],\"IT\":{\"AG\":\"Agrigento\",\"AL\":\"Alessandria\",\"AN\":\"Ancona\",\"AO\":\"Aosta\",\"AR\":\"Arezzo\",\"AP\":\"Ascoli Piceno\",\"AT\":\"Asti\",\"AV\":\"Avellino\",\"BA\":\"Bari\",\"BT\":\"Barletta-Andria-Trani\",\"BL\":\"Belluno\",\"BN\":\"Benevento\",\"BG\":\"Bergamo\",\"BI\":\"Biella\",\"BO\":\"Bologna\",\"BZ\":\"Bolzano\",\"BS\":\"Brescia\",\"BR\":\"Brindisi\",\"CA\":\"Cagliari\",\"CL\":\"Caltanissetta\",\"CB\":\"Campobasso\",\"CE\":\"Caserta\",\"CT\":\"Catania\",\"CZ\":\"Catanzaro\",\"CH\":\"Chieti\",\"CO\":\"Como\",\"CS\":\"Cosenza\",\"CR\":\"Cremona\",\"KR\":\"Crotone\",\"CN\":\"Cuneo\",\"EN\":\"Enna\",\"FM\":\"Fermo\",\"FE\":\"Ferrara\",\"FI\":\"Firenze\",\"FG\":\"Foggia\",\"FC\":\"Forl\\u00ec-Cesena\",\"FR\":\"Frosinone\",\"GE\":\"Genova\",\"GO\":\"Gorizia\",\"GR\":\"Grosseto\",\"IM\":\"Imperia\",\"IS\":\"Isernia\",\"SP\":\"La Spezia\",\"AQ\":\"L'Aquila\",\"LT\":\"Latina\",\"LE\":\"Lecce\",\"LC\":\"Lecco\",\"LI\":\"Livorno\",\"LO\":\"Lodi\",\"LU\":\"Lucca\",\"MC\":\"Macerata\",\"MN\":\"Mantova\",\"MS\":\"Massa-Carrara\",\"MT\":\"Matera\",\"ME\":\"Messina\",\"MI\":\"Milano\",\"MO\":\"Modena\",\"MB\":\"Monza e della Brianza\",\"NA\":\"Napoli\",\"NO\":\"Novara\",\"NU\":\"Nuoro\",\"OR\":\"Oristano\",\"PD\":\"Padova\",\"PA\":\"Palermo\",\"PR\":\"Parma\",\"PV\":\"Pavia\",\"PG\":\"Perugia\",\"PU\":\"Pesaro e Urbino\",\"PE\":\"Pescara\",\"PC\":\"Piacenza\",\"PI\":\"Pisa\",\"PT\":\"Pistoia\",\"PN\":\"Pordenone\",\"PZ\":\"Potenza\",\"PO\":\"Prato\",\"RG\":\"Ragusa\",\"RA\":\"Ravenna\",\"RC\":\"Reggio Calabria\",\"RE\":\"Reggio Emilia\",\"RI\":\"Rieti\",\"RN\":\"Rimini\",\"RM\":\"Roma\",\"RO\":\"Rovigo\",\"SA\":\"Salerno\",\"SS\":\"Sassari\",\"SV\":\"Savona\",\"SI\":\"Siena\",\"SR\":\"Siracusa\",\"SO\":\"Sondrio\",\"SU\":\"Sud Sardegna\",\"TA\":\"Taranto\",\"TE\":\"Teramo\",\"TR\":\"Terni\",\"TO\":\"Torino\",\"TP\":\"Trapani\",\"TN\":\"Trento\",\"TV\":\"Treviso\",\"TS\":\"Trieste\",\"UD\":\"Udine\",\"VA\":\"Varese\",\"VE\":\"Venezia\",\"VB\":\"Verbano-Cusio-Ossola\",\"VC\":\"Vercelli\",\"VR\":\"Verona\",\"VV\":\"Vibo Valentia\",\"VI\":\"Vicenza\",\"VT\":\"Viterbo\"},\"IL\":[],\"IM\":[],\"JM\":{\"JM-01\":\"Kingston\",\"JM-02\":\"Saint Andrew\",\"JM-03\":\"Saint Thomas\",\"JM-04\":\"Portland\",\"JM-05\":\"Saint Mary\",\"JM-06\":\"Saint Ann\",\"JM-07\":\"Trelawny\",\"JM-08\":\"Saint James\",\"JM-09\":\"Hanover\",\"JM-10\":\"Westmoreland\",\"JM-11\":\"Saint Elizabeth\",\"JM-12\":\"Manchester\",\"JM-13\":\"Clarendon\",\"JM-14\":\"Saint Catherine\"},\"JP\":{\"JP01\":\"Hokkaido\",\"JP02\":\"Aomori\",\"JP03\":\"Iwate\",\"JP04\":\"Miyagi\",\"JP05\":\"Akita\",\"JP06\":\"Yamagata\",\"JP07\":\"Fukushima\",\"JP08\":\"Ibaraki\",\"JP09\":\"Tochigi\",\"JP10\":\"Gunma\",\"JP11\":\"Saitama\",\"JP12\":\"Chiba\",\"JP13\":\"Tokyo\",\"JP14\":\"Kanagawa\",\"JP15\":\"Niigata\",\"JP16\":\"Toyama\",\"JP17\":\"Ishikawa\",\"JP18\":\"Fukui\",\"JP19\":\"Yamanashi\",\"JP20\":\"Nagano\",\"JP21\":\"Gifu\",\"JP22\":\"Shizuoka\",\"JP23\":\"Aichi\",\"JP24\":\"Mie\",\"JP25\":\"Shiga\",\"JP26\":\"Kyoto\",\"JP27\":\"Osaka\",\"JP28\":\"Hyogo\",\"JP29\":\"Nara\",\"JP30\":\"Wakayama\",\"JP31\":\"Tottori\",\"JP32\":\"Shimane\",\"JP33\":\"Okayama\",\"JP34\":\"Hiroshima\",\"JP35\":\"Yamaguchi\",\"JP36\":\"Tokushima\",\"JP37\":\"Kagawa\",\"JP38\":\"Ehime\",\"JP39\":\"Kochi\",\"JP40\":\"Fukuoka\",\"JP41\":\"Saga\",\"JP42\":\"Nagasaki\",\"JP43\":\"Kumamoto\",\"JP44\":\"Oita\",\"JP45\":\"Miyazaki\",\"JP46\":\"Kagoshima\",\"JP47\":\"Okinawa\"},\"KE\":{\"KE01\":\"Baringo\",\"KE02\":\"Bomet\",\"KE03\":\"Bungoma\",\"KE04\":\"Busia\",\"KE05\":\"Elgeyo-Marakwet\",\"KE06\":\"Embu\",\"KE07\":\"Garissa\",\"KE08\":\"Homa Bay\",\"KE09\":\"Isiolo\",\"KE10\":\"Kajiado\",\"KE11\":\"Kakamega\",\"KE12\":\"Kericho\",\"KE13\":\"Kiambu\",\"KE14\":\"Kilifi\",\"KE15\":\"Kirinyaga\",\"KE16\":\"Kisii\",\"KE17\":\"Kisumu\",\"KE18\":\"Kitui\",\"KE19\":\"Kwale\",\"KE20\":\"Laikipia\",\"KE21\":\"Lamu\",\"KE22\":\"Machakos\",\"KE23\":\"Makueni\",\"KE24\":\"Mandera\",\"KE25\":\"Marsabit\",\"KE26\":\"Meru\",\"KE27\":\"Migori\",\"KE28\":\"Mombasa\",\"KE29\":\"Murang\\u2019a\",\"KE30\":\"Nairobi County\",\"KE31\":\"Nakuru\",\"KE32\":\"Nandi\",\"KE33\":\"Narok\",\"KE34\":\"Nyamira\",\"KE35\":\"Nyandarua\",\"KE36\":\"Nyeri\",\"KE37\":\"Samburu\",\"KE38\":\"Siaya\",\"KE39\":\"Taita-Taveta\",\"KE40\":\"Tana River\",\"KE41\":\"Tharaka-Nithi\",\"KE42\":\"Trans Nzoia\",\"KE43\":\"Turkana\",\"KE44\":\"Uasin Gishu\",\"KE45\":\"Vihiga\",\"KE46\":\"Wajir\",\"KE47\":\"West Pokot\"},\"KN\":{\"KNK\":\"Saint Kitts\",\"KNN\":\"Nevis\",\"KN01\":\"Christ Church Nichola Town\",\"KN02\":\"Saint Anne Sandy Point\",\"KN03\":\"Saint George Basseterre\",\"KN04\":\"Saint George Gingerland\",\"KN05\":\"Saint James Windward\",\"KN06\":\"Saint John Capisterre\",\"KN07\":\"Saint John Figtree\",\"KN08\":\"Saint Mary Cayon\",\"KN09\":\"Saint Paul Capisterre\",\"KN10\":\"Saint Paul Charlestown\",\"KN11\":\"Saint Peter Basseterre\",\"KN12\":\"Saint Thomas Lowland\",\"KN13\":\"Saint Thomas Middle Island\",\"KN15\":\"Trinity Palmetto Point\"},\"KR\":[],\"KW\":[],\"LA\":{\"AT\":\"Attapeu\",\"BK\":\"Bokeo\",\"BL\":\"Bolikhamsai\",\"CH\":\"Champasak\",\"HO\":\"Houaphanh\",\"KH\":\"Khammouane\",\"LM\":\"Luang Namtha\",\"LP\":\"Luang Prabang\",\"OU\":\"Oudomxay\",\"PH\":\"Phongsaly\",\"SL\":\"Salavan\",\"SV\":\"Savannakhet\",\"VI\":\"Vientiane Province\",\"VT\":\"Vientiane\",\"XA\":\"Sainyabuli\",\"XE\":\"Sekong\",\"XI\":\"Xiangkhouang\",\"XS\":\"Xaisomboun\"},\"LB\":[],\"LI\":[],\"LR\":{\"BM\":\"Bomi\",\"BN\":\"Bong\",\"GA\":\"Gbarpolu\",\"GB\":\"Grand Bassa\",\"GC\":\"Grand Cape Mount\",\"GG\":\"Grand Gedeh\",\"GK\":\"Grand Kru\",\"LO\":\"Lofa\",\"MA\":\"Margibi\",\"MY\":\"Maryland\",\"MO\":\"Montserrado\",\"NM\":\"Nimba\",\"RV\":\"Rivercess\",\"RG\":\"River Gee\",\"SN\":\"Sinoe\"},\"LU\":[],\"MA\":{\"maagd\":\"Agadir-Ida Ou Tanane\",\"maazi\":\"Azilal\",\"mabem\":\"B\\u00e9ni-Mellal\",\"maber\":\"Berkane\",\"mabes\":\"Ben Slimane\",\"mabod\":\"Boujdour\",\"mabom\":\"Boulemane\",\"mabrr\":\"Berrechid\",\"macas\":\"Casablanca\",\"mache\":\"Chefchaouen\",\"machi\":\"Chichaoua\",\"macht\":\"Chtouka A\\u00eft Baha\",\"madri\":\"Driouch\",\"maedi\":\"Essaouira\",\"maerr\":\"Errachidia\",\"mafah\":\"Fahs-Beni Makada\",\"mafes\":\"F\\u00e8s-Dar-Dbibegh\",\"mafig\":\"Figuig\",\"mafqh\":\"Fquih Ben Salah\",\"mague\":\"Guelmim\",\"maguf\":\"Guercif\",\"mahaj\":\"El Hajeb\",\"mahao\":\"Al Haouz\",\"mahoc\":\"Al Hoce\\u00efma\",\"maifr\":\"Ifrane\",\"maine\":\"Inezgane-A\\u00eft Melloul\",\"majdi\":\"El Jadida\",\"majra\":\"Jerada\",\"maken\":\"K\\u00e9nitra\",\"makes\":\"Kelaat Sraghna\",\"makhe\":\"Khemisset\",\"makhn\":\"Kh\\u00e9nifra\",\"makho\":\"Khouribga\",\"malaa\":\"La\\u00e2youne\",\"malar\":\"Larache\",\"mamar\":\"Marrakech\",\"mamdf\":\"M\\u2019diq-Fnideq\",\"mamed\":\"M\\u00e9diouna\",\"mamek\":\"Mekn\\u00e8s\",\"mamid\":\"Midelt\",\"mammd\":\"Marrakech-Medina\",\"mammn\":\"Marrakech-Menara\",\"mamoh\":\"Mohammedia\",\"mamou\":\"Moulay Yacoub\",\"manad\":\"Nador\",\"manou\":\"Nouaceur\",\"maoua\":\"Ouarzazate\",\"maoud\":\"Oued Ed-Dahab\",\"maouj\":\"Oujda-Angad\",\"maouz\":\"Ouezzane\",\"marab\":\"Rabat\",\"mareh\":\"Rehamna\",\"masaf\":\"Safi\",\"masal\":\"Sal\\u00e9\",\"masef\":\"Sefrou\",\"maset\":\"Settat\",\"masib\":\"Sidi Bennour\",\"masif\":\"Sidi Ifni\",\"masik\":\"Sidi Kacem\",\"masil\":\"Sidi Slimane\",\"maskh\":\"Skhirat-T\\u00e9mara\",\"masyb\":\"Sidi Youssef Ben Ali\",\"mataf\":\"Tarfaya (EH-partial)\",\"matai\":\"Taourirt\",\"matao\":\"Taounate\",\"matar\":\"Taroudant\",\"matat\":\"Tata\",\"mataz\":\"Taza\",\"matet\":\"T\\u00e9touan\",\"matin\":\"Tinghir\",\"matiz\":\"Tiznit\",\"matng\":\"Tangier-Assilah\",\"matnt\":\"Tan-Tan\",\"mayus\":\"Youssoufia\",\"mazag\":\"Zagora\"},\"MD\":{\"C\":\"Chi\\u0219in\\u0103u\",\"BL\":\"B\\u0103l\\u021bi\",\"AN\":\"Anenii Noi\",\"BS\":\"Basarabeasca\",\"BR\":\"Briceni\",\"CH\":\"Cahul\",\"CT\":\"Cantemir\",\"CL\":\"C\\u0103l\\u0103ra\\u0219i\",\"CS\":\"C\\u0103u\\u0219eni\",\"CM\":\"Cimi\\u0219lia\",\"CR\":\"Criuleni\",\"DN\":\"Dondu\\u0219eni\",\"DR\":\"Drochia\",\"DB\":\"Dub\\u0103sari\",\"ED\":\"Edine\\u021b\",\"FL\":\"F\\u0103le\\u0219ti\",\"FR\":\"Flore\\u0219ti\",\"GE\":\"UTA G\\u0103g\\u0103uzia\",\"GL\":\"Glodeni\",\"HN\":\"H\\u00eence\\u0219ti\",\"IL\":\"Ialoveni\",\"LV\":\"Leova\",\"NS\":\"Nisporeni\",\"OC\":\"Ocni\\u021ba\",\"OR\":\"Orhei\",\"RZ\":\"Rezina\",\"RS\":\"R\\u00ee\\u0219cani\",\"SG\":\"S\\u00eengerei\",\"SR\":\"Soroca\",\"ST\":\"Str\\u0103\\u0219eni\",\"SD\":\"\\u0218old\\u0103ne\\u0219ti\",\"SV\":\"\\u0218tefan Vod\\u0103\",\"TR\":\"Taraclia\",\"TL\":\"Telene\\u0219ti\",\"UN\":\"Ungheni\"},\"MF\":[],\"MQ\":[],\"MT\":[],\"MX\":{\"DF\":\"Ciudad de M\\u00e9xico\",\"JA\":\"Jalisco\",\"NL\":\"Nuevo Le\\u00f3n\",\"AG\":\"Aguascalientes\",\"BC\":\"Baja California\",\"BS\":\"Baja California Sur\",\"CM\":\"Campeche\",\"CS\":\"Chiapas\",\"CH\":\"Chihuahua\",\"CO\":\"Coahuila\",\"CL\":\"Colima\",\"DG\":\"Durango\",\"GT\":\"Guanajuato\",\"GR\":\"Guerrero\",\"HG\":\"Hidalgo\",\"MX\":\"Estado de M\\u00e9xico\",\"MI\":\"Michoac\\u00e1n\",\"MO\":\"Morelos\",\"NA\":\"Nayarit\",\"OA\":\"Oaxaca\",\"PU\":\"Puebla\",\"QT\":\"Quer\\u00e9taro\",\"QR\":\"Quintana Roo\",\"SL\":\"San Luis Potos\\u00ed\",\"SI\":\"Sinaloa\",\"SO\":\"Sonora\",\"TB\":\"Tabasco\",\"TM\":\"Tamaulipas\",\"TL\":\"Tlaxcala\",\"VE\":\"Veracruz\",\"YU\":\"Yucat\\u00e1n\",\"ZA\":\"Zacatecas\"},\"MY\":{\"JHR\":\"Johor\",\"KDH\":\"Kedah\",\"KTN\":\"Kelantan\",\"LBN\":\"Labuan\",\"MLK\":\"Malacca (Melaka)\",\"NSN\":\"Negeri Sembilan\",\"PHG\":\"Pahang\",\"PNG\":\"Penang (Pulau Pinang)\",\"PRK\":\"Perak\",\"PLS\":\"Perlis\",\"SBH\":\"Sabah\",\"SWK\":\"Sarawak\",\"SGR\":\"Selangor\",\"TRG\":\"Terengganu\",\"PJY\":\"Putrajaya\",\"KUL\":\"Kuala Lumpur\"},\"MZ\":{\"MZP\":\"Cabo Delgado\",\"MZG\":\"Gaza\",\"MZI\":\"Inhambane\",\"MZB\":\"Manica\",\"MZL\":\"Maputo Province\",\"MZMPM\":\"Maputo\",\"MZN\":\"Nampula\",\"MZA\":\"Niassa\",\"MZS\":\"Sofala\",\"MZT\":\"Tete\",\"MZQ\":\"Zamb\\u00e9zia\"},\"NA\":{\"ER\":\"Erongo\",\"HA\":\"Hardap\",\"KA\":\"Karas\",\"KE\":\"Kavango East\",\"KW\":\"Kavango West\",\"KH\":\"Khomas\",\"KU\":\"Kunene\",\"OW\":\"Ohangwena\",\"OH\":\"Omaheke\",\"OS\":\"Omusati\",\"ON\":\"Oshana\",\"OT\":\"Oshikoto\",\"OD\":\"Otjozondjupa\",\"CA\":\"Zambezi\"},\"NG\":{\"AB\":\"Abia\",\"FC\":\"Abuja\",\"AD\":\"Adamawa\",\"AK\":\"Akwa Ibom\",\"AN\":\"Anambra\",\"BA\":\"Bauchi\",\"BY\":\"Bayelsa\",\"BE\":\"Benue\",\"BO\":\"Borno\",\"CR\":\"Cross River\",\"DE\":\"Delta\",\"EB\":\"Ebonyi\",\"ED\":\"Edo\",\"EK\":\"Ekiti\",\"EN\":\"Enugu\",\"GO\":\"Gombe\",\"IM\":\"Imo\",\"JI\":\"Jigawa\",\"KD\":\"Kaduna\",\"KN\":\"Kano\",\"KT\":\"Katsina\",\"KE\":\"Kebbi\",\"KO\":\"Kogi\",\"KW\":\"Kwara\",\"LA\":\"Lagos\",\"NA\":\"Nasarawa\",\"NI\":\"Niger\",\"OG\":\"Ogun\",\"ON\":\"Ondo\",\"OS\":\"Osun\",\"OY\":\"Oyo\",\"PL\":\"Plateau\",\"RI\":\"Rivers\",\"SO\":\"Sokoto\",\"TA\":\"Taraba\",\"YO\":\"Yobe\",\"ZA\":\"Zamfara\"},\"NL\":[],\"NO\":[],\"NP\":{\"BAG\":\"Bagmati\",\"BHE\":\"Bheri\",\"DHA\":\"Dhaulagiri\",\"GAN\":\"Gandaki\",\"JAN\":\"Janakpur\",\"KAR\":\"Karnali\",\"KOS\":\"Koshi\",\"LUM\":\"Lumbini\",\"MAH\":\"Mahakali\",\"MEC\":\"Mechi\",\"NAR\":\"Narayani\",\"RAP\":\"Rapti\",\"SAG\":\"Sagarmatha\",\"SET\":\"Seti\"},\"NI\":{\"NI-AN\":\"Atl\\u00e1ntico Norte\",\"NI-AS\":\"Atl\\u00e1ntico Sur\",\"NI-BO\":\"Boaco\",\"NI-CA\":\"Carazo\",\"NI-CI\":\"Chinandega\",\"NI-CO\":\"Chontales\",\"NI-ES\":\"Estel\\u00ed\",\"NI-GR\":\"Granada\",\"NI-JI\":\"Jinotega\",\"NI-LE\":\"Le\\u00f3n\",\"NI-MD\":\"Madriz\",\"NI-MN\":\"Managua\",\"NI-MS\":\"Masaya\",\"NI-MT\":\"Matagalpa\",\"NI-NS\":\"Nueva Segovia\",\"NI-RI\":\"Rivas\",\"NI-SJ\":\"R\\u00edo San Juan\"},\"NZ\":{\"NTL\":\"Northland\",\"AUK\":\"Auckland\",\"WKO\":\"Waikato\",\"BOP\":\"Bay of Plenty\",\"TKI\":\"Taranaki\",\"GIS\":\"Gisborne\",\"HKB\":\"Hawke\\u2019s Bay\",\"MWT\":\"Manawatu-Whanganui\",\"WGN\":\"Wellington\",\"NSN\":\"Nelson\",\"MBH\":\"Marlborough\",\"TAS\":\"Tasman\",\"WTC\":\"West Coast\",\"CAN\":\"Canterbury\",\"OTA\":\"Otago\",\"STL\":\"Southland\"},\"PA\":{\"PA-1\":\"Bocas del Toro\",\"PA-2\":\"Cocl\\u00e9\",\"PA-3\":\"Col\\u00f3n\",\"PA-4\":\"Chiriqu\\u00ed\",\"PA-5\":\"Dari\\u00e9n\",\"PA-6\":\"Herrera\",\"PA-7\":\"Los Santos\",\"PA-8\":\"Panam\\u00e1\",\"PA-9\":\"Veraguas\",\"PA-10\":\"West Panam\\u00e1\",\"PA-EM\":\"Ember\\u00e1\",\"PA-KY\":\"Guna Yala\",\"PA-NB\":\"Ng\\u00f6be-Bugl\\u00e9\"},\"PE\":{\"CAL\":\"El Callao\",\"LMA\":\"Municipalidad Metropolitana de Lima\",\"AMA\":\"Amazonas\",\"ANC\":\"Ancash\",\"APU\":\"Apur\\u00edmac\",\"ARE\":\"Arequipa\",\"AYA\":\"Ayacucho\",\"CAJ\":\"Cajamarca\",\"CUS\":\"Cusco\",\"HUV\":\"Huancavelica\",\"HUC\":\"Hu\\u00e1nuco\",\"ICA\":\"Ica\",\"JUN\":\"Jun\\u00edn\",\"LAL\":\"La Libertad\",\"LAM\":\"Lambayeque\",\"LIM\":\"Lima\",\"LOR\":\"Loreto\",\"MDD\":\"Madre de Dios\",\"MOQ\":\"Moquegua\",\"PAS\":\"Pasco\",\"PIU\":\"Piura\",\"PUN\":\"Puno\",\"SAM\":\"San Mart\\u00edn\",\"TAC\":\"Tacna\",\"TUM\":\"Tumbes\",\"UCA\":\"Ucayali\"},\"PH\":{\"ABR\":\"Abra\",\"AGN\":\"Agusan del Norte\",\"AGS\":\"Agusan del Sur\",\"AKL\":\"Aklan\",\"ALB\":\"Albay\",\"ANT\":\"Antique\",\"APA\":\"Apayao\",\"AUR\":\"Aurora\",\"BAS\":\"Basilan\",\"BAN\":\"Bataan\",\"BTN\":\"Batanes\",\"BTG\":\"Batangas\",\"BEN\":\"Benguet\",\"BIL\":\"Biliran\",\"BOH\":\"Bohol\",\"BUK\":\"Bukidnon\",\"BUL\":\"Bulacan\",\"CAG\":\"Cagayan\",\"CAN\":\"Camarines Norte\",\"CAS\":\"Camarines Sur\",\"CAM\":\"Camiguin\",\"CAP\":\"Capiz\",\"CAT\":\"Catanduanes\",\"CAV\":\"Cavite\",\"CEB\":\"Cebu\",\"COM\":\"Compostela Valley\",\"NCO\":\"Cotabato\",\"DAV\":\"Davao del Norte\",\"DAS\":\"Davao del Sur\",\"DAC\":\"Davao Occidental\",\"DAO\":\"Davao Oriental\",\"DIN\":\"Dinagat Islands\",\"EAS\":\"Eastern Samar\",\"GUI\":\"Guimaras\",\"IFU\":\"Ifugao\",\"ILN\":\"Ilocos Norte\",\"ILS\":\"Ilocos Sur\",\"ILI\":\"Iloilo\",\"ISA\":\"Isabela\",\"KAL\":\"Kalinga\",\"LUN\":\"La Union\",\"LAG\":\"Laguna\",\"LAN\":\"Lanao del Norte\",\"LAS\":\"Lanao del Sur\",\"LEY\":\"Leyte\",\"MAG\":\"Maguindanao\",\"MAD\":\"Marinduque\",\"MAS\":\"Masbate\",\"MSC\":\"Misamis Occidental\",\"MSR\":\"Misamis Oriental\",\"MOU\":\"Mountain Province\",\"NEC\":\"Negros Occidental\",\"NER\":\"Negros Oriental\",\"NSA\":\"Northern Samar\",\"NUE\":\"Nueva Ecija\",\"NUV\":\"Nueva Vizcaya\",\"MDC\":\"Occidental Mindoro\",\"MDR\":\"Oriental Mindoro\",\"PLW\":\"Palawan\",\"PAM\":\"Pampanga\",\"PAN\":\"Pangasinan\",\"QUE\":\"Quezon\",\"QUI\":\"Quirino\",\"RIZ\":\"Rizal\",\"ROM\":\"Romblon\",\"WSA\":\"Samar\",\"SAR\":\"Sarangani\",\"SIQ\":\"Siquijor\",\"SOR\":\"Sorsogon\",\"SCO\":\"South Cotabato\",\"SLE\":\"Southern Leyte\",\"SUK\":\"Sultan Kudarat\",\"SLU\":\"Sulu\",\"SUN\":\"Surigao del Norte\",\"SUR\":\"Surigao del Sur\",\"TAR\":\"Tarlac\",\"TAW\":\"Tawi-Tawi\",\"ZMB\":\"Zambales\",\"ZAN\":\"Zamboanga del Norte\",\"ZAS\":\"Zamboanga del Sur\",\"ZSI\":\"Zamboanga Sibugay\",\"00\":\"Metro Manila\"},\"PK\":{\"JK\":\"Azad Kashmir\",\"BA\":\"Balochistan\",\"TA\":\"FATA\",\"GB\":\"Gilgit Baltistan\",\"IS\":\"Islamabad Capital Territory\",\"KP\":\"Khyber Pakhtunkhwa\",\"PB\":\"Punjab\",\"SD\":\"Sindh\"},\"PL\":[],\"PR\":[],\"PT\":[],\"PY\":{\"PY-ASU\":\"Asunci\\u00f3n\",\"PY-1\":\"Concepci\\u00f3n\",\"PY-2\":\"San Pedro\",\"PY-3\":\"Cordillera\",\"PY-4\":\"Guair\\u00e1\",\"PY-5\":\"Caaguaz\\u00fa\",\"PY-6\":\"Caazap\\u00e1\",\"PY-7\":\"Itap\\u00faa\",\"PY-8\":\"Misiones\",\"PY-9\":\"Paraguar\\u00ed\",\"PY-10\":\"Alto Paran\\u00e1\",\"PY-11\":\"Central\",\"PY-12\":\"\\u00d1eembuc\\u00fa\",\"PY-13\":\"Amambay\",\"PY-14\":\"Canindey\\u00fa\",\"PY-15\":\"Presidente Hayes\",\"PY-16\":\"Alto Paraguay\",\"PY-17\":\"Boquer\\u00f3n\"},\"RE\":[],\"RO\":{\"AB\":\"Alba\",\"AR\":\"Arad\",\"AG\":\"Arge\\u0219\",\"BC\":\"Bac\\u0103u\",\"BH\":\"Bihor\",\"BN\":\"Bistri\\u021ba-N\\u0103s\\u0103ud\",\"BT\":\"Boto\\u0219ani\",\"BR\":\"Br\\u0103ila\",\"BV\":\"Bra\\u0219ov\",\"B\":\"Bucure\\u0219ti\",\"BZ\":\"Buz\\u0103u\",\"CL\":\"C\\u0103l\\u0103ra\\u0219i\",\"CS\":\"Cara\\u0219-Severin\",\"CJ\":\"Cluj\",\"CT\":\"Constan\\u021ba\",\"CV\":\"Covasna\",\"DB\":\"D\\u00e2mbovi\\u021ba\",\"DJ\":\"Dolj\",\"GL\":\"Gala\\u021bi\",\"GR\":\"Giurgiu\",\"GJ\":\"Gorj\",\"HR\":\"Harghita\",\"HD\":\"Hunedoara\",\"IL\":\"Ialomi\\u021ba\",\"IS\":\"Ia\\u0219i\",\"IF\":\"Ilfov\",\"MM\":\"Maramure\\u0219\",\"MH\":\"Mehedin\\u021bi\",\"MS\":\"Mure\\u0219\",\"NT\":\"Neam\\u021b\",\"OT\":\"Olt\",\"PH\":\"Prahova\",\"SJ\":\"S\\u0103laj\",\"SM\":\"Satu Mare\",\"SB\":\"Sibiu\",\"SV\":\"Suceava\",\"TR\":\"Teleorman\",\"TM\":\"Timi\\u0219\",\"TL\":\"Tulcea\",\"VL\":\"V\\u00e2lcea\",\"VS\":\"Vaslui\",\"VN\":\"Vrancea\"},\"SN\":{\"SNDB\":\"Diourbel\",\"SNDK\":\"Dakar\",\"SNFK\":\"Fatick\",\"SNKA\":\"Kaffrine\",\"SNKD\":\"Kolda\",\"SNKE\":\"K\\u00e9dougou\",\"SNKL\":\"Kaolack\",\"SNLG\":\"Louga\",\"SNMT\":\"Matam\",\"SNSE\":\"S\\u00e9dhiou\",\"SNSL\":\"Saint-Louis\",\"SNTC\":\"Tambacounda\",\"SNTH\":\"Thi\\u00e8s\",\"SNZG\":\"Ziguinchor\"},\"SG\":[],\"SK\":[],\"SI\":[],\"SV\":{\"SV-AH\":\"Ahuachap\\u00e1n\",\"SV-CA\":\"Caba\\u00f1as\",\"SV-CH\":\"Chalatenango\",\"SV-CU\":\"Cuscatl\\u00e1n\",\"SV-LI\":\"La Libertad\",\"SV-MO\":\"Moraz\\u00e1n\",\"SV-PA\":\"La Paz\",\"SV-SA\":\"Santa Ana\",\"SV-SM\":\"San Miguel\",\"SV-SO\":\"Sonsonate\",\"SV-SS\":\"San Salvador\",\"SV-SV\":\"San Vicente\",\"SV-UN\":\"La Uni\\u00f3n\",\"SV-US\":\"Usulut\\u00e1n\"},\"TH\":{\"TH-37\":\"Amnat Charoen\",\"TH-15\":\"Ang Thong\",\"TH-14\":\"Ayutthaya\",\"TH-10\":\"Bangkok\",\"TH-38\":\"Bueng Kan\",\"TH-31\":\"Buri Ram\",\"TH-24\":\"Chachoengsao\",\"TH-18\":\"Chai Nat\",\"TH-36\":\"Chaiyaphum\",\"TH-22\":\"Chanthaburi\",\"TH-50\":\"Chiang Mai\",\"TH-57\":\"Chiang Rai\",\"TH-20\":\"Chonburi\",\"TH-86\":\"Chumphon\",\"TH-46\":\"Kalasin\",\"TH-62\":\"Kamphaeng Phet\",\"TH-71\":\"Kanchanaburi\",\"TH-40\":\"Khon Kaen\",\"TH-81\":\"Krabi\",\"TH-52\":\"Lampang\",\"TH-51\":\"Lamphun\",\"TH-42\":\"Loei\",\"TH-16\":\"Lopburi\",\"TH-58\":\"Mae Hong Son\",\"TH-44\":\"Maha Sarakham\",\"TH-49\":\"Mukdahan\",\"TH-26\":\"Nakhon Nayok\",\"TH-73\":\"Nakhon Pathom\",\"TH-48\":\"Nakhon Phanom\",\"TH-30\":\"Nakhon Ratchasima\",\"TH-60\":\"Nakhon Sawan\",\"TH-80\":\"Nakhon Si Thammarat\",\"TH-55\":\"Nan\",\"TH-96\":\"Narathiwat\",\"TH-39\":\"Nong Bua Lam Phu\",\"TH-43\":\"Nong Khai\",\"TH-12\":\"Nonthaburi\",\"TH-13\":\"Pathum Thani\",\"TH-94\":\"Pattani\",\"TH-82\":\"Phang Nga\",\"TH-93\":\"Phatthalung\",\"TH-56\":\"Phayao\",\"TH-67\":\"Phetchabun\",\"TH-76\":\"Phetchaburi\",\"TH-66\":\"Phichit\",\"TH-65\":\"Phitsanulok\",\"TH-54\":\"Phrae\",\"TH-83\":\"Phuket\",\"TH-25\":\"Prachin Buri\",\"TH-77\":\"Prachuap Khiri Khan\",\"TH-85\":\"Ranong\",\"TH-70\":\"Ratchaburi\",\"TH-21\":\"Rayong\",\"TH-45\":\"Roi Et\",\"TH-27\":\"Sa Kaeo\",\"TH-47\":\"Sakon Nakhon\",\"TH-11\":\"Samut Prakan\",\"TH-74\":\"Samut Sakhon\",\"TH-75\":\"Samut Songkhram\",\"TH-19\":\"Saraburi\",\"TH-91\":\"Satun\",\"TH-17\":\"Sing Buri\",\"TH-33\":\"Sisaket\",\"TH-90\":\"Songkhla\",\"TH-64\":\"Sukhothai\",\"TH-72\":\"Suphan Buri\",\"TH-84\":\"Surat Thani\",\"TH-32\":\"Surin\",\"TH-63\":\"Tak\",\"TH-92\":\"Trang\",\"TH-23\":\"Trat\",\"TH-34\":\"Ubon Ratchathani\",\"TH-41\":\"Udon Thani\",\"TH-61\":\"Uthai Thani\",\"TH-53\":\"Uttaradit\",\"TH-95\":\"Yala\",\"TH-35\":\"Yasothon\"},\"TR\":{\"TR01\":\"Adana\",\"TR02\":\"Ad\\u0131yaman\",\"TR03\":\"Afyon\",\"TR04\":\"A\\u011fr\\u0131\",\"TR05\":\"Amasya\",\"TR06\":\"Ankara\",\"TR07\":\"Antalya\",\"TR08\":\"Artvin\",\"TR09\":\"Ayd\\u0131n\",\"TR10\":\"Bal\\u0131kesir\",\"TR11\":\"Bilecik\",\"TR12\":\"Bing\\u00f6l\",\"TR13\":\"Bitlis\",\"TR14\":\"Bolu\",\"TR15\":\"Burdur\",\"TR16\":\"Bursa\",\"TR17\":\"\\u00c7anakkale\",\"TR18\":\"\\u00c7ank\\u0131r\\u0131\",\"TR19\":\"\\u00c7orum\",\"TR20\":\"Denizli\",\"TR21\":\"Diyarbak\\u0131r\",\"TR22\":\"Edirne\",\"TR23\":\"Elaz\\u0131\\u011f\",\"TR24\":\"Erzincan\",\"TR25\":\"Erzurum\",\"TR26\":\"Eski\\u015fehir\",\"TR27\":\"Gaziantep\",\"TR28\":\"Giresun\",\"TR29\":\"G\\u00fcm\\u00fc\\u015fhane\",\"TR30\":\"Hakkari\",\"TR31\":\"Hatay\",\"TR32\":\"Isparta\",\"TR33\":\"\\u0130\\u00e7el\",\"TR34\":\"\\u0130stanbul\",\"TR35\":\"\\u0130zmir\",\"TR36\":\"Kars\",\"TR37\":\"Kastamonu\",\"TR38\":\"Kayseri\",\"TR39\":\"K\\u0131rklareli\",\"TR40\":\"K\\u0131r\\u015fehir\",\"TR41\":\"Kocaeli\",\"TR42\":\"Konya\",\"TR43\":\"K\\u00fctahya\",\"TR44\":\"Malatya\",\"TR45\":\"Manisa\",\"TR46\":\"Kahramanmara\\u015f\",\"TR47\":\"Mardin\",\"TR48\":\"Mu\\u011fla\",\"TR49\":\"Mu\\u015f\",\"TR50\":\"Nev\\u015fehir\",\"TR51\":\"Ni\\u011fde\",\"TR52\":\"Ordu\",\"TR53\":\"Rize\",\"TR54\":\"Sakarya\",\"TR55\":\"Samsun\",\"TR56\":\"Siirt\",\"TR57\":\"Sinop\",\"TR58\":\"Sivas\",\"TR59\":\"Tekirda\\u011f\",\"TR60\":\"Tokat\",\"TR61\":\"Trabzon\",\"TR62\":\"Tunceli\",\"TR63\":\"\\u015eanl\\u0131urfa\",\"TR64\":\"U\\u015fak\",\"TR65\":\"Van\",\"TR66\":\"Yozgat\",\"TR67\":\"Zonguldak\",\"TR68\":\"Aksaray\",\"TR69\":\"Bayburt\",\"TR70\":\"Karaman\",\"TR71\":\"K\\u0131r\\u0131kkale\",\"TR72\":\"Batman\",\"TR73\":\"\\u015e\\u0131rnak\",\"TR74\":\"Bart\\u0131n\",\"TR75\":\"Ardahan\",\"TR76\":\"I\\u011fd\\u0131r\",\"TR77\":\"Yalova\",\"TR78\":\"Karab\\u00fck\",\"TR79\":\"Kilis\",\"TR80\":\"Osmaniye\",\"TR81\":\"D\\u00fczce\"},\"TZ\":{\"TZ01\":\"Arusha\",\"TZ02\":\"Dar es Salaam\",\"TZ03\":\"Dodoma\",\"TZ04\":\"Iringa\",\"TZ05\":\"Kagera\",\"TZ06\":\"Pemba North\",\"TZ07\":\"Zanzibar North\",\"TZ08\":\"Kigoma\",\"TZ09\":\"Kilimanjaro\",\"TZ10\":\"Pemba South\",\"TZ11\":\"Zanzibar South\",\"TZ12\":\"Lindi\",\"TZ13\":\"Mara\",\"TZ14\":\"Mbeya\",\"TZ15\":\"Zanzibar West\",\"TZ16\":\"Morogoro\",\"TZ17\":\"Mtwara\",\"TZ18\":\"Mwanza\",\"TZ19\":\"Coast\",\"TZ20\":\"Rukwa\",\"TZ21\":\"Ruvuma\",\"TZ22\":\"Shinyanga\",\"TZ23\":\"Singida\",\"TZ24\":\"Tabora\",\"TZ25\":\"Tanga\",\"TZ26\":\"Manyara\",\"TZ27\":\"Geita\",\"TZ28\":\"Katavi\",\"TZ29\":\"Njombe\",\"TZ30\":\"Simiyu\"},\"LK\":[],\"RS\":{\"RS00\":\"Belgrade\",\"RS14\":\"Bor\",\"RS11\":\"Brani\\u010devo\",\"RS02\":\"Central Banat\",\"RS10\":\"Danube\",\"RS23\":\"Jablanica\",\"RS09\":\"Kolubara\",\"RS08\":\"Ma\\u010dva\",\"RS17\":\"Morava\",\"RS20\":\"Ni\\u0161ava\",\"RS01\":\"North Ba\\u010dka\",\"RS03\":\"North Banat\",\"RS24\":\"P\\u010dinja\",\"RS22\":\"Pirot\",\"RS13\":\"Pomoravlje\",\"RS19\":\"Rasina\",\"RS18\":\"Ra\\u0161ka\",\"RS06\":\"South Ba\\u010dka\",\"RS04\":\"South Banat\",\"RS07\":\"Srem\",\"RS12\":\"\\u0160umadija\",\"RS21\":\"Toplica\",\"RS05\":\"West Ba\\u010dka\",\"RS15\":\"Zaje\\u010dar\",\"RS16\":\"Zlatibor\",\"RS25\":\"Kosovo\",\"RS26\":\"Pe\\u0107\",\"RS27\":\"Prizren\",\"RS28\":\"Kosovska Mitrovica\",\"RS29\":\"Kosovo-Pomoravlje\",\"RSKM\":\"Kosovo-Metohija\",\"RSVO\":\"Vojvodina\"},\"RW\":[],\"SE\":[],\"UA\":{\"UA05\":\"Vinnychchyna\",\"UA07\":\"Volyn\",\"UA09\":\"Luhanshchyna\",\"UA12\":\"Dnipropetrovshchyna\",\"UA14\":\"Donechchyna\",\"UA18\":\"Zhytomyrshchyna\",\"UA21\":\"Zakarpattia\",\"UA23\":\"Zaporizhzhya\",\"UA26\":\"Prykarpattia\",\"UA30\":\"Kyiv\",\"UA32\":\"Kyivshchyna\",\"UA35\":\"Kirovohradschyna\",\"UA40\":\"Sevastopol\",\"UA43\":\"Crimea\",\"UA46\":\"Lvivshchyna\",\"UA48\":\"Mykolayivschyna\",\"UA51\":\"Odeshchyna\",\"UA53\":\"Poltavshchyna\",\"UA56\":\"Rivnenshchyna\",\"UA59\":\"Sumshchyna\",\"UA61\":\"Ternopilshchyna\",\"UA63\":\"Kharkivshchyna\",\"UA65\":\"Khersonshchyna\",\"UA68\":\"Khmelnychchyna\",\"UA71\":\"Cherkashchyna\",\"UA74\":\"Chernihivshchyna\",\"UA77\":\"Chernivtsi Oblast\"},\"UG\":{\"UG314\":\"Abim\",\"UG301\":\"Adjumani\",\"UG322\":\"Agago\",\"UG323\":\"Alebtong\",\"UG315\":\"Amolatar\",\"UG324\":\"Amudat\",\"UG216\":\"Amuria\",\"UG316\":\"Amuru\",\"UG302\":\"Apac\",\"UG303\":\"Arua\",\"UG217\":\"Budaka\",\"UG218\":\"Bududa\",\"UG201\":\"Bugiri\",\"UG235\":\"Bugweri\",\"UG420\":\"Buhweju\",\"UG117\":\"Buikwe\",\"UG219\":\"Bukedea\",\"UG118\":\"Bukomansimbi\",\"UG220\":\"Bukwa\",\"UG225\":\"Bulambuli\",\"UG416\":\"Buliisa\",\"UG401\":\"Bundibugyo\",\"UG430\":\"Bunyangabu\",\"UG402\":\"Bushenyi\",\"UG202\":\"Busia\",\"UG221\":\"Butaleja\",\"UG119\":\"Butambala\",\"UG233\":\"Butebo\",\"UG120\":\"Buvuma\",\"UG226\":\"Buyende\",\"UG317\":\"Dokolo\",\"UG121\":\"Gomba\",\"UG304\":\"Gulu\",\"UG403\":\"Hoima\",\"UG417\":\"Ibanda\",\"UG203\":\"Iganga\",\"UG418\":\"Isingiro\",\"UG204\":\"Jinja\",\"UG318\":\"Kaabong\",\"UG404\":\"Kabale\",\"UG405\":\"Kabarole\",\"UG213\":\"Kaberamaido\",\"UG427\":\"Kagadi\",\"UG428\":\"Kakumiro\",\"UG101\":\"Kalangala\",\"UG222\":\"Kaliro\",\"UG122\":\"Kalungu\",\"UG102\":\"Kampala\",\"UG205\":\"Kamuli\",\"UG413\":\"Kamwenge\",\"UG414\":\"Kanungu\",\"UG206\":\"Kapchorwa\",\"UG236\":\"Kapelebyong\",\"UG126\":\"Kasanda\",\"UG406\":\"Kasese\",\"UG207\":\"Katakwi\",\"UG112\":\"Kayunga\",\"UG407\":\"Kibaale\",\"UG103\":\"Kiboga\",\"UG227\":\"Kibuku\",\"UG432\":\"Kikuube\",\"UG419\":\"Kiruhura\",\"UG421\":\"Kiryandongo\",\"UG408\":\"Kisoro\",\"UG305\":\"Kitgum\",\"UG319\":\"Koboko\",\"UG325\":\"Kole\",\"UG306\":\"Kotido\",\"UG208\":\"Kumi\",\"UG333\":\"Kwania\",\"UG228\":\"Kween\",\"UG123\":\"Kyankwanzi\",\"UG422\":\"Kyegegwa\",\"UG415\":\"Kyenjojo\",\"UG125\":\"Kyotera\",\"UG326\":\"Lamwo\",\"UG307\":\"Lira\",\"UG229\":\"Luuka\",\"UG104\":\"Luwero\",\"UG124\":\"Lwengo\",\"UG114\":\"Lyantonde\",\"UG223\":\"Manafwa\",\"UG320\":\"Maracha\",\"UG105\":\"Masaka\",\"UG409\":\"Masindi\",\"UG214\":\"Mayuge\",\"UG209\":\"Mbale\",\"UG410\":\"Mbarara\",\"UG423\":\"Mitooma\",\"UG115\":\"Mityana\",\"UG308\":\"Moroto\",\"UG309\":\"Moyo\",\"UG106\":\"Mpigi\",\"UG107\":\"Mubende\",\"UG108\":\"Mukono\",\"UG334\":\"Nabilatuk\",\"UG311\":\"Nakapiripirit\",\"UG116\":\"Nakaseke\",\"UG109\":\"Nakasongola\",\"UG230\":\"Namayingo\",\"UG234\":\"Namisindwa\",\"UG224\":\"Namutumba\",\"UG327\":\"Napak\",\"UG310\":\"Nebbi\",\"UG231\":\"Ngora\",\"UG424\":\"Ntoroko\",\"UG411\":\"Ntungamo\",\"UG328\":\"Nwoya\",\"UG331\":\"Omoro\",\"UG329\":\"Otuke\",\"UG321\":\"Oyam\",\"UG312\":\"Pader\",\"UG332\":\"Pakwach\",\"UG210\":\"Pallisa\",\"UG110\":\"Rakai\",\"UG429\":\"Rubanda\",\"UG425\":\"Rubirizi\",\"UG431\":\"Rukiga\",\"UG412\":\"Rukungiri\",\"UG111\":\"Sembabule\",\"UG232\":\"Serere\",\"UG426\":\"Sheema\",\"UG215\":\"Sironko\",\"UG211\":\"Soroti\",\"UG212\":\"Tororo\",\"UG113\":\"Wakiso\",\"UG313\":\"Yumbe\",\"UG330\":\"Zombo\"},\"UM\":{\"81\":\"Baker Island\",\"84\":\"Howland Island\",\"86\":\"Jarvis Island\",\"67\":\"Johnston Atoll\",\"89\":\"Kingman Reef\",\"71\":\"Midway Atoll\",\"76\":\"Navassa Island\",\"95\":\"Palmyra Atoll\",\"79\":\"Wake Island\"},\"US\":{\"AL\":\"Alabama\",\"AK\":\"Alaska\",\"AZ\":\"Arizona\",\"AR\":\"Arkansas\",\"CA\":\"California\",\"CO\":\"Colorado\",\"CT\":\"Connecticut\",\"DE\":\"Delaware\",\"DC\":\"District of Columbia\",\"FL\":\"Florida\",\"GA\":\"Georgia\",\"HI\":\"Hawaii\",\"ID\":\"Idaho\",\"IL\":\"Illinois\",\"IN\":\"Indiana\",\"IA\":\"Iowa\",\"KS\":\"Kansas\",\"KY\":\"Kentucky\",\"LA\":\"Louisiana\",\"ME\":\"Maine\",\"MD\":\"Maryland\",\"MA\":\"Massachusetts\",\"MI\":\"Michigan\",\"MN\":\"Minnesota\",\"MS\":\"Mississippi\",\"MO\":\"Missouri\",\"MT\":\"Montana\",\"NE\":\"Nebraska\",\"NV\":\"Nevada\",\"NH\":\"New Hampshire\",\"NJ\":\"New Jersey\",\"NM\":\"New Mexico\",\"NY\":\"New York\",\"NC\":\"North Carolina\",\"ND\":\"North Dakota\",\"OH\":\"Ohio\",\"OK\":\"Oklahoma\",\"OR\":\"Oregon\",\"PA\":\"Pennsylvania\",\"RI\":\"Rhode Island\",\"SC\":\"South Carolina\",\"SD\":\"South Dakota\",\"TN\":\"Tennessee\",\"TX\":\"Texas\",\"UT\":\"Utah\",\"VT\":\"Vermont\",\"VA\":\"Virginia\",\"WA\":\"Washington\",\"WV\":\"West Virginia\",\"WI\":\"Wisconsin\",\"WY\":\"Wyoming\",\"AA\":\"Armed Forces (AA)\",\"AE\":\"Armed Forces (AE)\",\"AP\":\"Armed Forces (AP)\"},\"UY\":{\"UY-AR\":\"Artigas\",\"UY-CA\":\"Canelones\",\"UY-CL\":\"Cerro Largo\",\"UY-CO\":\"Colonia\",\"UY-DU\":\"Durazno\",\"UY-FS\":\"Flores\",\"UY-FD\":\"Florida\",\"UY-LA\":\"Lavalleja\",\"UY-MA\":\"Maldonado\",\"UY-MO\":\"Montevideo\",\"UY-PA\":\"Paysand\\u00fa\",\"UY-RN\":\"R\\u00edo Negro\",\"UY-RV\":\"Rivera\",\"UY-RO\":\"Rocha\",\"UY-SA\":\"Salto\",\"UY-SJ\":\"San Jos\\u00e9\",\"UY-SO\":\"Soriano\",\"UY-TA\":\"Tacuaremb\\u00f3\",\"UY-TT\":\"Treinta y Tres\"},\"VE\":{\"VE-A\":\"Capital\",\"VE-B\":\"Anzo\\u00e1tegui\",\"VE-C\":\"Apure\",\"VE-D\":\"Aragua\",\"VE-E\":\"Barinas\",\"VE-F\":\"Bol\\u00edvar\",\"VE-G\":\"Carabobo\",\"VE-H\":\"Cojedes\",\"VE-I\":\"Falc\\u00f3n\",\"VE-J\":\"Gu\\u00e1rico\",\"VE-K\":\"Lara\",\"VE-L\":\"M\\u00e9rida\",\"VE-M\":\"Miranda\",\"VE-N\":\"Monagas\",\"VE-O\":\"Nueva Esparta\",\"VE-P\":\"Portuguesa\",\"VE-R\":\"Sucre\",\"VE-S\":\"T\\u00e1chira\",\"VE-T\":\"Trujillo\",\"VE-U\":\"Yaracuy\",\"VE-V\":\"Zulia\",\"VE-W\":\"Federal Dependencies\",\"VE-X\":\"La Guaira (Vargas)\",\"VE-Y\":\"Delta Amacuro\",\"VE-Z\":\"Amazonas\"},\"VN\":[],\"YT\":[],\"ZA\":{\"EC\":\"Eastern Cape\",\"FS\":\"Free State\",\"GP\":\"Gauteng\",\"KZN\":\"KwaZulu-Natal\",\"LP\":\"Limpopo\",\"MP\":\"Mpumalanga\",\"NC\":\"Northern Cape\",\"NW\":\"North West\",\"WC\":\"Western Cape\"},\"ZM\":{\"ZM-01\":\"Western\",\"ZM-02\":\"Central\",\"ZM-03\":\"Eastern\",\"ZM-04\":\"Luapula\",\"ZM-05\":\"Northern\",\"ZM-06\":\"North-Western\",\"ZM-07\":\"Southern\",\"ZM-08\":\"Copperbelt\",\"ZM-09\":\"Lusaka\",\"ZM-10\":\"Muchinga\"}}", "i18n_select_state_text": "Select an option\u2026", "i18n_no_matches": "No matches found", "i18n_ajax_error": "Loading failed", "i18n_input_too_short_1": "Please enter 1 or more characters", "i18n_input_too_short_n": "Please enter %qty% or more characters", "i18n_input_too_long_1": "Please delete 1 character", "i18n_input_too_long_n": "Please delete %qty% characters", "i18n_selection_too_long_1": "You can only select 1 item", "i18n_selection_too_long_n": "You can only select %qty% items", "i18n_load_more": "Loading more results\u2026", "i18n_searching": "Searching\u2026" };
        //# sourceURL=wc-country-select-js-extra
        /* ]]> */
    </script>
    <script type="text/javascript"
        src="merchandise/wp-content/plugins/woocommerce/assets/js/frontend/country-select.min.js"
        id="wc-country-select-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript" id="wc-address-i18n-js-extra">
        /* <![CDATA[ */
        var wc_address_i18n_params = { "locale": "{\"AE\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"required\":false}},\"AF\":{\"state\":{\"required\":false,\"hidden\":true}},\"AL\":{\"state\":{\"label\":\"County\"}},\"AO\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"label\":\"Province\"}},\"AT\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"AU\":{\"city\":{\"label\":\"Suburb\"},\"postcode\":{\"label\":\"Postcode\"},\"state\":{\"label\":\"State\"}},\"AX\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"BA\":{\"postcode\":[],\"state\":{\"label\":\"Canton\",\"required\":false,\"hidden\":true}},\"BD\":{\"postcode\":{\"required\":false},\"state\":{\"label\":\"District\"}},\"BE\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"BG\":{\"state\":{\"required\":false}},\"BH\":{\"postcode\":{\"required\":false},\"state\":{\"required\":false,\"hidden\":true}},\"BI\":{\"state\":{\"required\":false,\"hidden\":true}},\"BO\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"label\":\"Department\"}},\"BS\":{\"postcode\":{\"required\":false,\"hidden\":true}},\"BW\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"required\":false,\"hidden\":true,\"label\":\"District\"}},\"BZ\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"required\":false}},\"CA\":{\"postcode\":{\"label\":\"Postal code\"},\"state\":{\"label\":\"Province\"}},\"CH\":{\"postcode\":[],\"state\":{\"label\":\"Canton\",\"required\":false}},\"CL\":{\"city\":{\"required\":true},\"postcode\":{\"required\":false,\"hidden\":false},\"state\":{\"label\":\"Region\"}},\"CN\":{\"state\":{\"label\":\"Province\"}},\"CO\":{\"postcode\":{\"required\":false},\"state\":{\"label\":\"Department\"}},\"CR\":{\"state\":{\"label\":\"Province\"}},\"CW\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"required\":false}},\"CY\":{\"state\":{\"required\":false,\"hidden\":true}},\"CZ\":{\"state\":{\"required\":false,\"hidden\":true}},\"DE\":{\"postcode\":[],\"state\":{\"required\":false}},\"DK\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"DO\":{\"state\":{\"label\":\"Province\"}},\"EC\":{\"state\":{\"label\":\"Province\"}},\"EE\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"ET\":{\"state\":{\"required\":false,\"hidden\":true}},\"FI\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"FR\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"GG\":{\"state\":{\"required\":false,\"label\":\"Parish\"}},\"GH\":{\"postcode\":{\"required\":false},\"state\":{\"label\":\"Region\"}},\"GP\":{\"state\":{\"required\":false,\"hidden\":true}},\"GF\":{\"state\":{\"required\":false,\"hidden\":true}},\"GR\":{\"state\":{\"required\":false}},\"GT\":{\"postcode\":{\"required\":false},\"state\":{\"label\":\"Department\"}},\"HK\":{\"postcode\":{\"required\":false},\"city\":{\"label\":\"Town / District\"},\"state\":{\"label\":\"Region\"}},\"HN\":{\"state\":{\"label\":\"Department\"}},\"HU\":{\"last_name\":[],\"first_name\":[],\"postcode\":[],\"city\":[],\"address_1\":[],\"address_2\":[],\"state\":{\"label\":\"County\",\"required\":false}},\"ID\":{\"state\":{\"label\":\"Province\"}},\"IE\":{\"postcode\":{\"required\":true,\"label\":\"Eircode\"},\"state\":{\"label\":\"County\"}},\"IS\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"IL\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"IM\":{\"state\":{\"required\":false,\"hidden\":true}},\"IN\":{\"postcode\":{\"label\":\"PIN Code\"},\"state\":{\"label\":\"State\"}},\"IR\":{\"state\":[],\"city\":[],\"address_1\":[],\"address_2\":[]},\"IT\":{\"postcode\":[],\"state\":{\"required\":true,\"label\":\"Province\"}},\"JM\":{\"city\":{\"label\":\"Town / City / Post Office\"},\"postcode\":{\"required\":false,\"label\":\"Postal Code\"},\"state\":{\"required\":true,\"label\":\"Parish\"}},\"JP\":{\"last_name\":[],\"first_name\":[],\"postcode\":[],\"state\":{\"label\":\"Prefecture\"},\"city\":[],\"address_1\":[],\"address_2\":[]},\"KN\":{\"postcode\":{\"required\":false,\"label\":\"Postal code\"},\"state\":{\"required\":true,\"label\":\"Parish\"}},\"KR\":{\"state\":{\"required\":false,\"hidden\":true}},\"KW\":{\"state\":{\"required\":false,\"hidden\":true}},\"LV\":{\"state\":{\"label\":\"Municipality\",\"required\":false}},\"LB\":{\"state\":{\"required\":false,\"hidden\":true}},\"MF\":{\"state\":{\"required\":false,\"hidden\":true}},\"MQ\":{\"state\":{\"required\":false,\"hidden\":true}},\"MT\":{\"state\":{\"required\":false,\"hidden\":true}},\"MZ\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"label\":\"Province\"}},\"NI\":{\"state\":{\"label\":\"Department\"}},\"NL\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"NG\":{\"postcode\":{\"label\":\"Postcode\",\"required\":false,\"hidden\":true},\"state\":{\"label\":\"State\"}},\"NZ\":{\"postcode\":{\"label\":\"Postcode\"},\"state\":{\"required\":false,\"label\":\"Region\"}},\"NO\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"NP\":{\"state\":{\"label\":\"State / Zone\"},\"postcode\":{\"required\":false}},\"PA\":{\"state\":{\"label\":\"Province\"}},\"PL\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"PR\":{\"city\":{\"label\":\"Municipality\"},\"state\":{\"required\":false,\"hidden\":true}},\"PT\":{\"state\":{\"required\":false,\"hidden\":true}},\"PY\":{\"state\":{\"label\":\"Department\"}},\"RE\":{\"state\":{\"required\":false,\"hidden\":true}},\"RO\":{\"state\":{\"label\":\"County\",\"required\":true}},\"RS\":{\"city\":{\"required\":true},\"postcode\":{\"required\":true},\"state\":{\"label\":\"District\",\"required\":false}},\"RW\":{\"state\":{\"required\":false,\"hidden\":true}},\"SG\":{\"state\":{\"required\":false,\"hidden\":true},\"city\":{\"required\":false}},\"SK\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"SI\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"SR\":{\"postcode\":{\"required\":false,\"hidden\":true}},\"SV\":{\"state\":{\"label\":\"Department\"}},\"ES\":{\"postcode\":[],\"state\":{\"label\":\"Province\"}},\"LI\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"LK\":{\"state\":{\"required\":false,\"hidden\":true}},\"LU\":{\"state\":{\"required\":false,\"hidden\":true}},\"MD\":{\"state\":{\"label\":\"Municipality / District\"}},\"SE\":{\"postcode\":[],\"state\":{\"required\":false,\"hidden\":true}},\"TR\":{\"postcode\":[],\"state\":{\"label\":\"Province\"}},\"UG\":{\"postcode\":{\"required\":false,\"hidden\":true},\"city\":{\"label\":\"Town / Village\",\"required\":true},\"state\":{\"label\":\"District\",\"required\":true}},\"US\":{\"postcode\":{\"label\":\"ZIP Code\"},\"state\":{\"label\":\"State\"}},\"UY\":{\"state\":{\"label\":\"Department\"}},\"GB\":{\"postcode\":{\"label\":\"Postcode\"},\"state\":{\"label\":\"County\",\"required\":false}},\"ST\":{\"postcode\":{\"required\":false,\"hidden\":true},\"state\":{\"label\":\"District\"}},\"VN\":{\"state\":{\"required\":false,\"hidden\":true},\"postcode\":{\"required\":false,\"hidden\":false},\"address_2\":{\"required\":false,\"hidden\":false}},\"WS\":{\"postcode\":{\"required\":false,\"hidden\":true}},\"YT\":{\"state\":{\"required\":false,\"hidden\":true}},\"ZA\":{\"state\":{\"label\":\"Province\"}},\"ZW\":{\"postcode\":{\"required\":false,\"hidden\":true}},\"default\":{\"first_name\":{\"label\":\"First name\",\"required\":true,\"autocomplete\":\"given-name\"},\"last_name\":{\"label\":\"Last name\",\"required\":true,\"autocomplete\":\"family-name\"},\"company\":{\"label\":\"Company name\",\"autocomplete\":\"organization\",\"required\":false},\"country\":{\"type\":\"country\",\"label\":\"Country / Region\",\"required\":true,\"autocomplete\":\"country\"},\"address_1\":{\"label\":\"Street address\",\"placeholder\":\"House number and street name\",\"required\":true,\"autocomplete\":\"address-line1\"},\"address_2\":{\"label\":\"Apartment, suite, unit, etc.\",\"label_class\":[\"screen-reader-text\"],\"placeholder\":\"Apartment, suite, unit, etc. (optional)\",\"autocomplete\":\"address-line2\",\"required\":false},\"city\":{\"label\":\"Town / City\",\"required\":true,\"autocomplete\":\"address-level2\"},\"state\":{\"type\":\"state\",\"label\":\"State / County\",\"required\":true,\"validate\":[\"state\"],\"autocomplete\":\"address-level1\"},\"postcode\":{\"label\":\"Postcode / ZIP\",\"required\":true,\"validate\":[\"postcode\"],\"autocomplete\":\"postal-code\"}}}", "locale_fields": "{\"address_1\":\"#billing_address_1_field, #shipping_address_1_field\",\"address_2\":\"#billing_address_2_field, #shipping_address_2_field\",\"state\":\"#billing_state_field, #shipping_state_field, #calc_shipping_state_field\",\"postcode\":\"#billing_postcode_field, #shipping_postcode_field, #calc_shipping_postcode_field\",\"city\":\"#billing_city_field, #shipping_city_field, #calc_shipping_city_field\"}", "i18n_required_text": "required", "i18n_optional_text": "optional" };
        //# sourceURL=wc-address-i18n-js-extra
        /* ]]> */
    </script>
    <script type="text/javascript"
        src="merchandise/wp-content/plugins/woocommerce/assets/js/frontend/address-i18n.min.js" id="wc-address-i18n-js"
        defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
        src="merchandise/wp-content/plugins/woocommerce/assets/js/selectWoo/selectWoo.full.min.js" id="selectWoo-js"
        defer="defer" data-wp-strategy="defer"></script>
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

                    <div class="wd-page-title page-title page-title-default title-size-small title-design-centered color-scheme-default">
                        <div class="wd-page-title-bg wd-fill"></div>
                        <div class="container">
                            <ul class="wd-checkout-steps">
                                <li class="step-cart step-active">
                                    <a href="{{ route('cart') }}"><span>Shopping cart</span></a>
                                </li>
                                <li class="step-checkout step-inactive">
                                    <a href="{{ route('checkout') }}"><span>Checkout</span></a>
                                </li>
                                <li class="step-complete step-inactive">
                                    <span>Order complete</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="gmsCartEmpty" class="gms-empty" style="display:none;padding:60px 20px;text-align:center;">
                        <i class="fas fa-shopping-cart" style="font-size:48px;color:var(--gms-line,#ececec);margin-bottom:16px;display:block;"></i>
                        <h3 style="margin-bottom:8px;">Your cart is empty</h3>
                        <p style="margin-bottom:20px;color:#777;">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('all-products') }}" class="button btn btn-accent">Continue shopping</a>
                    </div>

                    <div id="gmsCartWrap" class="wp-block-wd-row">
                        <div class="wp-block-wd-column" style="flex:0 1 calc(66.33% - 10px);">
                            <div class="wd-cart-table">
                                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents shop-table-with-img">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="gmsCartBody"></tbody>
                                </table>

                                <div class="cart-actions" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-top:16px;">
                                    <div class="coupon wd-coupon-form" style="display:flex;gap:8px;">
                                        <input type="text" id="gmsCouponCode" class="input-text" placeholder="Coupon code" />
                                        <button type="button" id="gmsApplyCoupon" class="button btn btn-accent">Apply coupon</button>
                                    </div>
                                </div>
                                <p id="gmsCouponMsg" style="margin-top:8px;font-size:13px;"></p>
                            </div>
                        </div>

                        <div class="wp-block-wd-column wd-align-s-start" style="flex:0 1 calc(33.33% - 10px);padding:30px;background-color:#f5f5f5;border-radius:16px;">
                            <h2 class="wp-block-wd-title title">Cart totals</h2>

                            <div class="wd-cart-totals">
                                <table cellspacing="0" class="shop_table shop_table_responsive">
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td data-title="Subtotal"><span id="gmsCartSubtotal" class="woocommerce-Price-amount amount">{{ \App\Support\Money::format(0) }}</span></td>
                                    </tr>
                                    <tr id="gmsCartDiscountRow" class="cart-discount" style="display:none;">
                                        <th>Discount</th>
                                        <td data-title="Discount"><span id="gmsCartDiscount" class="woocommerce-Price-amount amount"></span></td>
                                    </tr>
                                    <tr class="woocommerce-shipping-totals shipping">
                                        <th>Shipping</th>
                                        <td data-title="Shipping"><span id="gmsCartShipping">{{ \App\Support\Money::format(0) }}</span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td data-title="Total"><strong><span id="gmsCartTotal" class="woocommerce-Price-amount amount">{{ \App\Support\Money::format(0) }}</span></strong></td>
                                    </tr>
                                </table>

                                <div class="wc-proceed-to-checkout">
                                    <a href="{{ route('checkout') }}" class="checkout-button button alt wc-forward">Proceed to checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

    </div>

<script>
window.NF_PRODUCTS = @json($products);
window.NF_COUPONS  = @json($coupons);

(function () {
    let appliedCoupon = null;

    function getCart() {
        let cart = [];
        try { cart = JSON.parse(localStorage.getItem('gms_cart') || '[]'); } catch (e) { cart = []; }
        return Array.isArray(cart) ? cart : [];
    }

    function setCart(cart) {
        localStorage.setItem('gms_cart', JSON.stringify(cart));
        window.dispatchEvent(new Event('gms:cart-updated'));
    }

    function findProduct(id) {
        return (window.NF_PRODUCTS || []).find(p => p.id === id);
    }

    function syncCart(cart) {
        fetch('{{ route('cart.sync') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: cart.map(c => ({ id: c.id, qty: c.qty, variant_id: null })) })
        }).catch(function () {});
    }

    function computeSubtotal(cart) {
        return cart.reduce(function (sum, item) {
            const p = findProduct(item.id);
            return p ? sum + p.cur * item.qty : sum;
        }, 0);
    }

    function computeDiscount(subtotal) {
        if (!appliedCoupon || subtotal <= 0) return 0;
        if (appliedCoupon.minimum_spend > 0 && subtotal < appliedCoupon.minimum_spend) return 0;
        let discount = appliedCoupon.type === 'percentage' ? (subtotal * appliedCoupon.amount / 100) : appliedCoupon.amount;
        if (appliedCoupon.maximum_discount > 0) discount = Math.min(discount, appliedCoupon.maximum_discount);
        return Math.min(discount, subtotal);
    }

    function updateTotals(cart) {
        const subtotal = computeSubtotal(cart);
        const discount = computeDiscount(subtotal);
        const freeShipping = cart.length > 0 && ((appliedCoupon && appliedCoupon.free_shipping) || subtotal >= 500);
        const shipping = cart.length === 0 ? 0 : (freeShipping ? 0 : 60);
        const total = Math.max(0, subtotal + shipping - discount);

        document.getElementById('gmsCartSubtotal').textContent = window.formatPrice(subtotal);
        document.getElementById('gmsCartShipping').textContent = shipping === 0 ? 'Free shipping' : window.formatPrice(shipping);
        document.getElementById('gmsCartTotal').textContent = window.formatPrice(total);

        const discountRow = document.getElementById('gmsCartDiscountRow');
        if (discount > 0) {
            discountRow.style.display = '';
            document.getElementById('gmsCartDiscount').textContent = '-' + window.formatPrice(discount);
        } else {
            discountRow.style.display = 'none';
        }
    }

    function render() {
        let cart = getCart();
        const valid = cart.filter(function (c) { return findProduct(c.id); });
        if (valid.length !== cart.length) {
            cart = valid;
            setCart(cart);
        }

        const wrapEl  = document.getElementById('gmsCartWrap');
        const emptyEl = document.getElementById('gmsCartEmpty');

        if (cart.length === 0) {
            wrapEl.style.display = 'none';
            emptyEl.style.display = '';
            updateTotals(cart);
            syncCart(cart);
            return;
        }

        wrapEl.style.display = '';
        emptyEl.style.display = 'none';

        const tbody = document.getElementById('gmsCartBody');
        tbody.innerHTML = cart.map(function (item) {
            const p = findProduct(item.id);
            const lineTotal = p.cur * item.qty;
            return '<tr class="woocommerce-cart-form__cart-item cart_item" data-id="' + p.id + '">' +
                '<td class="product-remove"><a href="#" class="remove" aria-label="Remove ' + p.title + ' from cart" onclick="gmsCartRemove(event,' + p.id + ')">&times;</a></td>' +
                '<td class="product-thumbnail"><a href="' + p.url + '"><img width="120" height="137" src="' + (p.img || '') + '" alt="' + p.title + '" loading="lazy" /></a></td>' +
                '<td class="product-name" data-title="Product"><a href="' + p.url + '">' + p.title + '</a></td>' +
                '<td class="product-price" data-title="Price"><span class="woocommerce-Price-amount amount">' + window.formatPrice(p.cur) + '</span></td>' +
                '<td class="product-quantity" data-title="Quantity"><div class="quantity">' +
                    '<input type="button" value="-" class="minus btn" aria-label="Decrease quantity" onclick="gmsCartQty(' + p.id + ',-1)" />' +
                    '<input type="number" class="input-text qty text" value="' + item.qty + '" min="1" aria-label="Product quantity" onchange="gmsCartSetQty(' + p.id + ',this.value)" />' +
                    '<input type="button" value="+" class="plus btn" aria-label="Increase quantity" onclick="gmsCartQty(' + p.id + ',1)" />' +
                '</div></td>' +
                '<td class="product-subtotal" data-title="Subtotal"><span class="woocommerce-Price-amount amount">' + window.formatPrice(lineTotal) + '</span></td>' +
                '</tr>';
        }).join('');

        updateTotals(cart);
        syncCart(cart);
    }

    window.gmsCartRemove = function (e, id) {
        e.preventDefault();
        setCart(getCart().filter(function (c) { return c.id !== id; }));
        render();
    };

    window.gmsCartQty = function (id, delta) {
        const cart = getCart();
        const item = cart.find(function (c) { return c.id === id; });
        if (!item) return;
        item.qty = Math.max(1, (parseInt(item.qty, 10) || 1) + delta);
        setCart(cart);
        render();
    };

    window.gmsCartSetQty = function (id, value) {
        const cart = getCart();
        const item = cart.find(function (c) { return c.id === id; });
        if (!item) return;
        item.qty = Math.max(1, parseInt(value, 10) || 1);
        setCart(cart);
        render();
    };

    function init() {
        const applyBtn = document.getElementById('gmsApplyCoupon');
        applyBtn.addEventListener('click', function () {
            const code = (document.getElementById('gmsCouponCode').value || '').trim().toUpperCase();
            const msgEl = document.getElementById('gmsCouponMsg');
            if (!code) return;
            const coupon = (window.NF_COUPONS || []).find(function (c) { return c.code.toUpperCase() === code; });
            if (!coupon) {
                appliedCoupon = null;
                msgEl.textContent = 'Invalid coupon code.';
                msgEl.style.color = '#c9401d';
            } else {
                appliedCoupon = coupon;
                msgEl.textContent = 'Coupon applied: ' + coupon.code;
                msgEl.style.color = '#2f8f4e';
            }
            render();
        });

        window.addEventListener('gms:cart-updated', render);
        render();
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endsection
