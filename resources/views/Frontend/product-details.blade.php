@extends('Frontend.Layout.app')


@push('styles')

  <style id='wp-img-auto-sizes-contain-inline-css' type='text/css'>
        img:is([sizes=auto i], [sizes^="auto," i]) {
            contain-intrinsic-size: 3000px 1500px
        }

        /*# sourceURL=wp-img-auto-sizes-contain-inline-css */
    </style>
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
    <style id='wd-header-base-inline-css' type='text/css'>
        .whb-flex-row {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between
        }

        .whb-column {
            display: flex;
            align-items: center;
            flex-direction: row;
            max-height: inherit
        }

        .whb-col-left,
        .whb-mobile-left {
            justify-content: flex-start;
            margin-left: -10px
        }

        .whb-col-right,
        .whb-mobile-right {
            justify-content: flex-end;
            margin-right: -10px
        }

        .whb-col-mobile {
            flex: 1 1 auto;
            justify-content: center;
            margin-inline: -10px
        }

        .whb-flex-flex-middle .whb-col-center {
            flex: 1 1 0%
        }

        .whb-flex-equal-sides :is(.whb-col-left, .whb-col-right) {
            flex: 1 1 0%
        }

        .whb-col-1 :is(.whb-flex-row, .whb-column) {
            max-width: calc(100% + 20px);
            justify-content: center
        }

        .whb-col-1 :is(.whb-col-left, .whb-mobile-left) {
            flex: 1 1 auto;
            margin-inline: -10px
        }

        .whb-col-1 .wd-header-html {
            max-width: 100%
        }

        .whb-general-header :is(.whb-mobile-left, .whb-mobile-right) {
            flex: 1 1 0%
        }

        .whb-empty-column+.whb-mobile-right {
            flex: 1 1 auto
        }

        .whb-with-shadow {
            box-shadow: 0 1px 8px rgba(0, 0, 0, .1)
        }

        .whb-main-header {
            position: relative;
            top: 0;
            right: 0;
            left: 0;
            z-index: 390;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden
        }

        .whb-sticky-prepared {
            padding-top: var(--wd-header-h)
        }

        .whb-sticky-prepared .whb-main-header {
            position: absolute
        }

        :root:has(.whb-sticky-prepared):not(:has(.whb-top-bar)) {
            --wd-top-bar-h: .00001px;
            --wd-top-bar-sm-h: .00001px
        }

        :root:has(.whb-sticky-prepared):not(:has(.whb-general-header)) {
            --wd-header-general-h: .00001px;
            --wd-header-general-sm-h: .00001px
        }

        :root:has(.whb-sticky-prepared):not(:has(.whb-header-bottom)) {
            --wd-header-bottom-h: .00001px;
            --wd-header-bottom-sm-h: .00001px;
            --wd-header-bottom-brd-w: .00001px
        }

        .whb-sticked .whb-row {
            transition: background-color .3s ease
        }

        .whb-sticked .whb-not-sticky-row {
            display: none
        }

        .whb-header.whb-sticked .whb-main-header {
            position: fixed
        }

        .whb-row {
            transition: background-color .2s ease
        }

        .whb-color-dark:not(.whb-with-bg) {
            background-color: #fff
        }

        .whb-color-light:not(.whb-with-bg) {
            background-color: #212121
        }

        body:not(.single-product) .whb-overcontent:not(.whb-sticked) .whb-row:not(.whb-with-bg) {
            background-color: rgba(0, 0, 0, 0)
        }

        .whb-row.whb-with-bdf,
        .whb-row.whb-with-bdf>.container {
            position: relative
        }

        .whb-row.whb-with-bdf:before {
            content: "";
            position: absolute;
            inset: 0
        }

        @keyframes wd-fadeInDownBig {
            from {
                transform: translate3d(0, -100%, 0)
            }

            to {
                transform: none
            }
        }

        @media(min-width: 1025px) {
            .whb-top-bar-inner {
                height: var(--wd-top-bar-h);
                max-height: var(--wd-top-bar-h)
            }

            .whb-sticked .whb-top-bar-inner {
                height: var(--wd-top-bar-sticky-h);
                max-height: var(--wd-top-bar-sticky-h)
            }

            .whb-general-header-inner {
                height: var(--wd-header-general-h);
                max-height: var(--wd-header-general-h)
            }

            .whb-sticked:not(.whb-clone) .whb-general-header-inner {
                height: var(--wd-header-general-sticky-h);
                max-height: var(--wd-header-general-sticky-h)
            }

            .whb-header-bottom-inner {
                height: var(--wd-header-bottom-h);
                max-height: var(--wd-header-bottom-h)
            }

            .whb-sticked .whb-header-bottom-inner {
                height: var(--wd-header-bottom-sticky-h);
                max-height: var(--wd-header-bottom-sticky-h)
            }

            .whb-hidden-lg,
            .whb-hidden-desktop {
                display: none
            }

            .whb-clone,
            .whb-sticked .whb-main-header {
                top: var(--wd-admin-bar-h)
            }

            .whb-full-width .whb-row>.container,
            .whb-full-width+.whb-clone .whb-row>.container {
                max-width: 100%;
                width: clamp(var(--wd-container-w), 95%, 100%)
            }
        }

        @media(max-width: 1024px) {
            .whb-top-bar-inner {
                height: var(--wd-top-bar-sm-h);
                max-height: var(--wd-top-bar-sm-h)
            }

            .whb-general-header-inner {
                height: var(--wd-header-general-sm-h);
                max-height: var(--wd-header-general-sm-h)
            }

            .whb-header-bottom-inner {
                height: var(--wd-header-bottom-sm-h);
                max-height: var(--wd-header-bottom-sm-h)
            }

            .whb-visible-lg,
            .whb-hidden-mobile {
                display: none
            }

            .whb-sticky-prepared {
                padding-top: var(--wd-header-sm-h)
            }
        }

        .wd-tools-element {
            position: relative;
            --wd-header-el-color: #333;
            --wd-header-el-color-hover: rgba(51, 51, 51, .6);
            --wd-tools-icon-base-width: 20px
        }

        .wd-tools-element>a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 40px;
            color: var(--wd-header-el-color);
            line-height: 1;
            text-decoration: none !important;
            padding-inline: 10px
        }

        .wd-tools-element [class*=wd-tools-text] {
            text-transform: var(--wd-header-el-transform);
            white-space: nowrap;
            font-weight: var(--wd-header-el-font-weight);
            font-style: var(--wd-header-el-font-style);
            font-size: var(--wd-header-el-font-size);
            font-family: var(--wd-header-el-font)
        }

        .wd-tools-element .wd-tools-count {
            z-index: 1;
            width: var(--wd-count-size, 15px);
            height: var(--wd-count-size, 15px);
            border-radius: 50%;
            text-align: center;
            letter-spacing: 0;
            font-weight: 400;
            line-height: var(--wd-count-size, 15px)
        }

        .wd-tools-element:hover>a {
            color: var(--wd-header-el-color-hover)
        }

        .whb-top-bar .wd-tools-element {
            --wd-count-size: 13px;
            --wd-tools-icon-base-width: 14px
        }

        .whb-top-bar .wd-tools-element .wd-tools-text {
            font-weight: 400;
            font-size: 12px
        }

        .whb-color-light .wd-tools-element {
            --wd-header-el-color: #FFF;
            --wd-header-el-color-hover: rgba(255, 255, 255, 0.8)
        }

        .wd-tools-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 0
        }

        .wd-tools-icon:before {
            content: var(--wd-tools-icon, unset);
            font-size: var(--wd-tools-icon-base-width);
            font-family: "woodmart-font"
        }

        .wd-tools-inner {
            position: relative;
            display: flex;
            align-items: center;
            gap: 7px
        }

        .wd-custom-icon,
        picture.wd-custom-icon img {
            max-width: var(--wd-tools-icon-width, 38px);
            width: var(--wd-tools-icon-width, revert-layer);
            transition: all .25s ease
        }

        .wd-tools-custom-icon .wd-tools-icon:before,
        .wd-tools-custom-icon .wd-tools-icon:after {
            display: none
        }

        .wd-tools-custom-icon:hover .wd-custom-icon {
            opacity: .6
        }

        .wd-tools-element:is(.wd-design-2, .wd-design-5).wd-with-count .wd-tools-icon {
            margin-inline-end: 6px
        }

        .wd-tools-element:is(.wd-design-2, .wd-design-5) .wd-tools-count {
            position: absolute;
            top: -5px;
            inset-inline-end: -9px;
            background-color: var(--wd-primary-color);
            color: #fff;
            font-size: 9px
        }

        .wd-tools-element[class*=wd-design-1] .wd-tools-count {
            width: auto;
            height: auto;
            text-transform: var(--wd-header-el-transform);
            font-weight: var(--wd-header-el-font-weight);
            font-style: var(--wd-header-el-font-style);
            font-size: var(--wd-header-el-font-size);
            font-family: var(--wd-header-el-font);
            line-height: inherit
        }

        .wd-tools-element[class*=wd-design-1] .subtotal-divider {
            display: inline
        }

        .wd-tools-element[class*=wd-design-4] {
            --wd-count-size: 19px
        }

        .wd-tools-element[class*=wd-design-4] .wd-tools-count {
            display: inline-block;
            padding: 0 2px;
            background-color: var(--wd-primary-color);
            color: #fff;
            font-weight: 600;
            font-size: 10px
        }

        .whb-top-bar .wd-tools-element[class*=wd-design-4] {
            --wd-count-size: 16px
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7], .wd-design-8) {
            --wd-count-size: 18px
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7], .wd-design-8) .wd-tools-inner .wd-tools-icon {
            position: static
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7], .wd-design-8) .wd-custom-icon {
            max-width: var(--wd-tools-icon-width, var(--wd-tools-icon-base-width))
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7], .wd-design-8) .wd-tools-count {
            position: absolute;
            top: -3px;
            inset-inline-end: -7px;
            background-color: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, .17);
            color: var(--wd-primary-color);
            font-size: 11px
        }

        .whb-top-bar .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7], .wd-design-8) {
            --wd-count-size: 13px
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) {
            --wd-tools-sp: 13px
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) :is(.wd-tools-inner, .wd-tools-icon) {
            height: 42px;
            border-radius: 42px
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) .wd-tools-inner {
            padding-inline: var(--wd-tools-sp)
        }

        .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]):not(.wd-with-wrap) .wd-tools-icon {
            width: 42px
        }

        .whb-top-bar .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) {
            --wd-tools-sp: 9px
        }

        .whb-top-bar .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) :is(.wd-tools-inner, .wd-tools-icon) {
            height: 28px
        }

        .whb-top-bar .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]):not(.wd-with-wrap) .wd-tools-icon {
            width: 28px
        }

        .whb-top-bar .wd-tools-element:is([class*=wd-design-6], [class*=wd-design-7]) .wd-tools-count {
            font-size: 9px
        }

        .wd-tools-element[class*=wd-design-6]>a>:is(.wd-tools-inner, .wd-tools-icon) {
            border: 1px solid rgba(0, 0, 0, 0.105)
        }

        .whb-color-light .wd-tools-element[class*=wd-design-6]>a>:is(.wd-tools-inner, .wd-tools-icon) {
            border-color: rgba(255, 255, 255, 0.25)
        }

        .wd-tools-element[class*=wd-design-7]>a>:is(.wd-tools-inner, .wd-tools-icon) {
            background-color: var(--wd-primary-color);
            color: #fff;
            transition: inherit
        }

        .wd-tools-element[class*=wd-design-7]:hover>a>:is(.wd-tools-inner, .wd-tools-icon) {
            color: hsla(0, 0%, 100%, .8)
        }

        .wd-header-nav {
            flex: 1 1 auto;
            padding-inline: 10px
        }

        .wd-header-nav.wd-inline {
            flex: 0 0 auto;
            max-width: 100%
        }

        .whb-color-light .wd-header-nav>span {
            color: hsla(0, 0%, 100%, .8)
        }

        .wd-nav-header>li>a {
            font-size: var(--wd-header-el-font-size);
            font-weight: var(--wd-header-el-font-weight);
            font-style: var(--wd-header-el-font-style);
            font-family: var(--wd-header-el-font);
            text-transform: var(--wd-header-el-transform)
        }

        .wd-nav-header>li.color-primary {
            --nav-color: var(--wd-primary-color);
            --nav-color-hover: var(--wd-primary-color)
        }

        .wd-nav-header:not(.wd-offsets-calculated)>li>.wd-dropdown:not(.wd-design-default) {
            opacity: 0;
            pointer-events: none
        }

        @supports(-webkit-touch-callout: none) {
            .wd-nav-header:not(.wd-offsets-calculated)>li>.wd-dropdown:not(.wd-design-default) {
                transform: translateY(15px) translateZ(0)
            }
        }

        .whb-color-light .wd-nav-header {
            --wd-navigation-color: 255, 255, 255
        }

        .whb-color-light .wd-nav-header.wd-style-default {
            --nav-color-hover: rgba(255, 255, 255, 0.7)
        }

        .whb-color-dark .wd-nav-header {
            --wd-navigation-color: 51, 51, 51
        }

        :is(.whb-top-bar, .whb-clone) .wd-nav-header>li>a .menu-label {
            position: static;
            margin-top: 0;
            margin-inline-start: 5px;
            opacity: 1;
            align-self: center
        }

        :is(.whb-top-bar, .whb-clone) .wd-nav-header>li>a .menu-label:before {
            content: none
        }

        .whb-top-bar .wd-nav-secondary>li>a {
            font-weight: 400;
            font-size: 12px
        }

        .wd-header-nav.wd-full-height,
        .wd-header-nav.wd-full-height :is(.wd-nav, .wd-nav>li, .wd-nav>li>a) {
            height: 100%
        }

        .wd-header-nav.wd-full-height .wd-nav>li>.wd-dropdown-menu {
            margin-top: 0 !important
        }

        .wd-header-nav.wd-full-height .wd-nav>li>.wd-dropdown-menu:after {
            width: auto !important;
            height: auto !important
        }

        .rtl .wd-header-nav .wd-nav.wd-icon-left>li>a .wd-nav-img {
            order: 1;
            margin: 0;
            margin-inline-start: 7px
        }

        .rtl .wd-header-nav .wd-nav.wd-icon-right>li>a .wd-nav-img {
            order: 0;
            margin: 0;
            margin-inline-end: 7px
        }

        .wd-header-sticky-nav {
            --wd-tools-icon: "\f15a"
        }

        .site-logo {
            max-height: inherit;
            padding-inline: 10px
        }

        .wd-logo {
            max-height: inherit;
            transition: none
        }

        .wd-logo picture {
            max-height: inherit
        }

        .wd-logo picture img {
            max-width: inherit
        }

        .wd-logo img {
            padding-top: 5px;
            padding-bottom: 5px;
            max-height: inherit;
            transform: translateZ(0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            perspective: 800px
        }

        .wd-logo img[src$=".svg"] {
            height: 100%
        }

        .wd-logo img[width]:not([src$=".svg"]) {
            width: auto;
            object-fit: contain
        }

        .whb-column>.info-box-wrapper {
            padding-inline: 10px
        }

        .whb-column>.info-box-wrapper .wd-info-box {
            --ib-icon-sp: 10px
        }

        .wd-header-text {
            --wd-tags-mb: 10px;
            flex: 1 1 auto;
            padding-inline: 10px
        }

        .wd-header-text p:first-child:empty {
            display: none
        }

        .wd-header-text.wd-inline {
            flex: 0 0 auto
        }

        .whb-top-bar .wd-header-text {
            font-size: 12px;
            line-height: 1.2
        }

        .whb-color-light .wd-header-text {
            --wd-text-color: rgba(255, 255, 255, 0.8);
            --wd-title-color: #FFF;
            --wd-link-color: rgba(255, 255, 255, 0.9);
            --wd-link-color-hover: #FFF;
            color: var(--wd-text-color)
        }

        .whb-column>.wd-button-wrapper {
            padding-inline: 10px
        }

        .whb-column>.wd-social-icons {
            padding-inline: 10px
        }

        .wd-header-html {
            padding-inline: 10px
        }

        .wd-header-mobile-nav {
            --wd-tools-icon: "\f15a"
        }

        .wd-header-wishlist {
            --wd-tools-icon: "\f106"
        }

        .wd-header-compare {
            --wd-tools-icon: "\f128"
        }

        .wd-dropdown-compare a {
            justify-content: space-between
        }

        .wd-dropdown-compare .count {
            margin-inline-start: 10px;
            color: var(--color-gray-300)
        }

        .wd-header-my-account {
            --wd-tools-icon: "\f124"
        }

        @media(max-width: 1024px) {
            .wd-header-my-account .wd-dropdown {
                display: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/header-base.css */
    </style>
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
    <style id='wd-woo-stripe-inline-css' type='text/css'>
        .wd-sticky-btn #wc-stripe-payment-request-wrapper,
        .wd-sticky-btn #wc-stripe-payment-request-button-separator {
            display: none !important
        }

        .payment_methods li .stripe-icon {
            max-width: 40px
        }

        .payment_methods li .stripe-bancontact-icon {
            max-height: 65px;
            max-width: 45px
        }

        .payment_methods li .stripe-p24-icon {
            max-width: 65px
        }

        .payment_methods li .stripe-sofort-icon {
            max-width: 55px
        }

        .payment_methods li .stripe-ideal-icon {
            max-height: 35px
        }

        .payment_methods li :is(.stripe-alipay-icon, .stripe-sepa-icon, .stripe-giropay-icon) {
            max-width: 50px
        }

        .payment_methods li :is(.stripe-multibanco-icon, .stripe-eps-icon) {
            max-height: 30px
        }

        .wc-payment-form .woocommerce-error {
            margin-top: 20px;
            margin-bottom: 0
        }

        .woocommerce-SavedPaymentMethods {
            --li-pl: 0;
            list-style: none
        }

        .woocommerce-SavedPaymentMethods:empty {
            display: none
        }

        .wc-stripe-elements-field,
        .wc-stripe-iban-element-field {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 15px;
            margin: 5px 0;
            height: 42px;
            border: var(--wd-form-brd-width) solid var(--wd-form-brd-color);
            border-radius: var(--wd-form-brd-radius);
            background-color: var(--wd-form-bg);
            cursor: text
        }

        .stripe-card-group {
            position: relative
        }

        .stripe-card-brand {
            position: absolute;
            top: 50%;
            inset-inline-end: 10px;
            margin-top: -10px;
            display: block;
            width: 30px;
            height: 24px
        }

        .stripe-credit-card-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/credit-card.svg)
        }

        .stripe-visa-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/visa.svg)
        }

        .stripe-amex-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/amex.svg)
        }

        .stripe-diners-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/diners.svg)
        }

        .stripe-discover-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/discover.svg)
        }

        .stripe-jcb-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/jcb.svg)
        }

        .stripe-maestro-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/maestro.svg)
        }

        .stripe-mastercard-brand {
            background: no-repeat url(merchandise/wp-content/themes/woodmart/css/parts/../../../../plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg)
        }

        #wc-stripe-custom-button {
            display: block;
            width: 100%
        }

        #stripe_boleto_tax_id {
            width: 100%
        }

        #wc-stripe-payment-request-button-separator {
            margin: 10px 0 !important;
            font-weight: 600;
            color: var(--color-gray-800)
        }

        #wc-stripe-payment-request-wrapper {
            padding-top: 0 !important
        }

        .wc-proceed-to-checkout #wc-stripe-payment-request-wrapper {
            margin-top: 0 !important
        }

        form.woocommerce-checkout:has(.wc-upe-form) input.input-text {
            padding-top: 8px;
            padding-bottom: 8px
        }

        form.woocommerce-checkout #wc-stripe-express-checkout-button-separator {
            margin: 0 !important
        }

        #wc-stripe-express-checkout-element .StripeElement {
            width: 100%
        }

        td.woocommerce-PaymentMethod--method {
            font-weight: 600;
            color: var(--color-gray-800)
        }

        td.woocommerce-PaymentMethod--actions>* {
            margin: 2px 0
        }

        td.woocommerce-PaymentMethod--actions .button.delete {
            float: right;
            margin-inline-start: 5px;
            background-color: #e01020;
            color: #fff
        }

        td.woocommerce-PaymentMethod--actions .button.delete:hover {
            background-color: #c60f1d;
            color: #fff
        }

        .rtl td.woocommerce-PaymentMethod--actions .button.delete {
            float: left
        }

        td.woocommerce-PaymentMethod--actions:after {
            content: "";
            display: block;
            clear: both
        }

        .woocommerce-PaymentMethods {
            --li-pl: 0;
            list-style: none
        }

        #add_payment_method #place_order {
            padding: 12px 20px;
            width: auto;
            font-size: 13px
        }

        #add_payment_method .payment_methods .payment_box {
            padding: 0;
            background-color: rgba(0, 0, 0, 0);
            box-shadow: none
        }

        #add_payment_method .payment_methods .payment_box:before {
            content: none
        }

        #add_payment_method .wc-payment-form {
            max-width: 330px
        }

        .single-product-page #wc-stripe-express-checkout-element {
            margin-bottom: var(--wd-mb)
        }

        form.cart div.quantity {
            order: 5
        }

        form.cart .single_add_to_cart_button {
            order: 10
        }

        form.cart .wd-buy-now-btn {
            order: 15
        }

        form.cart #wc-stripe-payment-request-button-separator {
            order: 20;
            margin: 5px 0 !important;
            text-align: var(--text-align) !important
        }

        form.cart #wc-stripe-payment-request-wrapper {
            order: 25
        }

        .wc-proceed-to-checkout #wc-stripe-express-checkout-element {
            margin-top: 0 !important
        }

        .wc-proceed-to-checkout #wc-stripe-express-checkout-element:last-child {
            margin-bottom: 0
        }

        .woocommerce-checkout #wc-stripe-express-checkout-element {
            margin: 0 !important
        }

        #wc-stripe-express-checkout__order-attribution-inputs {
            display: none
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/int-woo-stripe.css */
    </style>
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
    <style id='wd-woo-single-prod-el-base-inline-css' type='text/css'>
        .wd-product-brands {
            display: flex;
            justify-content: var(--content-align, var(--wd-align));
            align-items: center;
            flex-wrap: wrap;
            gap: 10px
        }

        .wd-product-brands img {
            max-width: 90px;
            width: 100%
        }

        .wd-product-brands a {
            display: inline-block
        }

        .wd-product-brands a:hover {
            opacity: .5
        }

        @media(max-width: 768.98px) {
            .wd-product-brands img {
                max-width: 70px
            }
        }

        .product_meta {
            --wd-link-color: var(--wd-text-color);
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            color: var(--wd-text-color);
            display: flex;
            align-items: center;
            justify-content: var(--wd-align);
            flex-wrap: wrap;
            gap: 10px
        }

        .product_meta>span {
            flex: 1 1 100%
        }

        .product_meta .meta-label {
            color: var(--color-gray-800);
            font-weight: 600
        }

        .product_meta.wd-layout-inline>span {
            flex: 0 1 auto
        }

        .product_title {
            font-size: 34px;
            line-height: 1.2;
            --page-title-display: block
        }

        @media(max-width: 1024px) {
            .product_title {
                font-size: 24px
            }
        }

        @media(max-width: 768.98px) {
            .product_title {
                font-size: 20px
            }
        }

        .woocommerce-product-rating .star-rating {
            margin-inline-end: 5px
        }

        .woocommerce-product-rating .woocommerce-review-link {
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            color: var(--color-gray-500);
            vertical-align: middle
        }

        .woocommerce-product-rating .woocommerce-review-link:hover {
            color: var(--color-gray-900)
        }

        @media(max-width: 1024px) {
            .woocommerce-breadcrumb .wd-last-link~span {
                display: none
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-el-base.css */
    </style>
    <style id='wd-woo-mod-stock-status-inline-css' type='text/css'>
        p.stock {
            font-weight: 600;
            line-height: 1.2
        }

        p.stock.out-of-stock {
            color: #b50808
        }

        p.stock.wd-style-default:is(.available-on-backorder, .in-stock) {
            color: var(--color-gray-800)
        }

        p.stock.wd-style-default.in-stock:before {
            margin-inline-end: .3em;
            color: var(--wd-primary-color);
            content: "\f107";
            font-family: "woodmart-font"
        }

        p.stock:is(.wd-style-bordered, .wd-style-with-bg) span {
            display: inline-flex;
            align-items: center;
            padding: .55em .8em;
            border-radius: calc(var(--wd-brd-radius)/1.5)
        }

        p.stock.wd-style-bordered span {
            border: 1px solid #85b951;
            color: var(--color-gray-800)
        }

        p.stock.wd-style-bordered span:before {
            content: "";
            margin-inline-end: .55em;
            width: .55em;
            height: .55em;
            border-radius: 50%;
            background-color: #85b951
        }

        p.stock.wd-style-bordered.out-of-stock span {
            border-color: #e22d2d
        }

        p.stock.wd-style-bordered.out-of-stock span:before {
            background-color: #e22d2d
        }

        p.stock.wd-style-with-bg:is(.available-on-backorder, .in-stock) span {
            background-color: #f1f7eb;
            color: #85b951
        }

        p.stock.wd-style-with-bg.in-stock span:before {
            margin-inline-end: .3em;
            content: "\f107";
            font-family: "woodmart-font"
        }

        p.stock.wd-style-with-bg.out-of-stock span {
            background-color: #f8e7e7
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-stock-status.css */
    </style>
    <style id='wd-woo-mod-shop-attributes-inline-css' type='text/css'>
        .shop_attributes {
            margin-bottom: 0;
            overflow: hidden
        }

        .shop_attributes tbody {
            display: grid;
            grid-template-columns: repeat(var(--wd-attr-col, 1), 1fr);
            margin-bottom: calc(-1*(var(--wd-attr-v-gap, 30px) + var(--wd-attr-brd-width, 1px)));
            column-gap: var(--wd-attr-h-gap, 30px)
        }

        .shop_attributes tr {
            display: flex;
            align-items: center;
            gap: 10px 20px;
            justify-content: space-between;
            padding-bottom: calc(var(--wd-attr-v-gap, 30px)/2);
            margin-bottom: calc(var(--wd-attr-v-gap, 30px)/2);
            border-bottom: var(--wd-attr-brd-width, 1px) var(--wd-attr-brd-style, solid) var(--wd-attr-brd-color, var(--brdcolor-gray-300))
        }

        .shop_attributes :is(th, td) {
            padding: 0;
            border: none;
            font-family: inherit
        }

        .shop_attributes td {
            --wd-link-color: var(--wd-text-color);
            --wd-link-color-hover: var(--color-gray-700);
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            text-align: end
        }

        .shop_attributes :is(.wd-attr-name, .wd-term-name, .wd-term-sep) {
            vertical-align: middle
        }

        .shop_attributes :is(.wd-attr-img, .wd-term-img):not(:last-child) {
            margin-inline-end: .2em
        }

        .shop_attributes :is(.wd-attr-name, .wd-term-name)+.wd-hint {
            margin-inline-start: .2em
        }

        .shop_attributes .wd-attr-label img {
            width: var(--wd-attr-img-width, 1.2em)
        }

        .shop_attributes .wd-term img {
            width: var(--wd-term-img-width, 1.2em)
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-shop-attributes.css */
    </style>
    <style id='woodmart-style-inline-css' type='text/css'>
        /* xz-system */
        html .product-image-summary-wrap .product_title,
        html .wd-single-title .product_title {
            font-weight: 600;
        }

        /*# sourceURL=woodmart-style-inline-css */
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
    <script type="text/javascript" src="merchandise/wp-includes/js/jquery/jquery.min.js" id="jquery-core-js"></script>
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
    <link rel="stylesheet" href="assets/gms-custom.css">
@endpush
@section('content')
<div class="wd-page-wrapper">
    <div class="container" style="padding-top:24px;padding-bottom:60px;">

        {{-- Breadcrumb --}}
        <div class="wd-breadcrumbs" style="margin-bottom:20px;font-size:13px;">
            <a href="{{ route('home') }}">Home</a>
            <span> / </span>
            <a href="{{ route('all-products') }}">Shop</a>
            @if($product->category)
                <span> / </span>
                <a href="{{ route('category-products') }}?cat={{ $product->category->slug }}">{{ $product->category->name }}</a>
            @endif
            <span> / </span>
            <span>{{ $product->name }}</span>
        </div>

        @php
            $resolveImage = function ($path) {
                if (!$path) return null;
                return \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
                    ? \Illuminate\Support\Facades\Storage::url($path)
                    : asset($path);
            };
            $mainImage = $resolveImage($product->thumbnail) ?: 'data:image/svg+xml;charset=UTF-8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600"><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" font-size="24" fill="#999" text-anchor="middle" dy=".3em">No image</text></svg>');
            $galleryImages = collect($product->gallery ?? [])
                ->map(fn ($g) => $resolveImage(is_array($g) ? ($g['path'] ?? null) : $g))
                ->filter()
                ->values();
            $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
            $displayPrice = $hasSale ? $product->sale_price : $product->selling_price;
            $inStock = $product->type !== 'physical' || $product->stock > 0;
        @endphp

        <div class="wp-block-wd-row wd-3c5dd53c" style="display:flex;flex-wrap:wrap;gap:40px;">

            {{-- Gallery --}}
            <div style="flex:1 1 420px;min-width:280px;">
                <div class="wd-single-gallery">
                    <img id="pd-main-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                        style="width:100%;border-radius:8px;object-fit:cover;aspect-ratio:1/1;" />

                    @if($galleryImages->isNotEmpty())
                    <div style="display:flex;gap:10px;margin-top:12px;flex-wrap:wrap;">
                        <img src="{{ $mainImage }}" onclick="document.getElementById('pd-main-image').src=this.src"
                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid #e5533d;" />
                        @foreach($galleryImages as $img)
                        <img src="{{ $img }}" onclick="document.getElementById('pd-main-image').src=this.src"
                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid transparent;" />
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Summary --}}
            <div style="flex:1 1 420px;min-width:280px;">
                <h1 class="product_title entry-title wd-entities-title">{{ $product->name }}</h1>

                @if($avgRating > 0)
                <div class="woocommerce-product-rating" style="margin:8px 0;">
                    <div class="star-rating" role="img" aria-label="Rated {{ $avgRating }} out of 5">
                        <span style="width:{{ $avgRating / 5 * 100 }}%">Rated <strong class="rating">{{ $avgRating }}</strong> out of 5</span>
                    </div>
                    <a href="#" id="pd-review-link" class="woocommerce-review-link">({{ $totalReviews }} customer review{{ $totalReviews === 1 ? '' : 's' }})</a>
                </div>
                @endif

                <div class="wd-single-stock-status" style="margin-bottom:8px;">
                    @if($inStock)
                        <p class="stock in-stock wd-style-default">
                            {{ $product->type === 'physical' ? (int) $product->stock . ' in stock' : 'In stock' }}
                        </p>
                    @else
                        <p class="stock out-of-stock wd-style-default">Out of stock</p>
                    @endif
                </div>

                @if($product->sku)
                <div class="product_meta" style="margin-bottom:10px;font-size:13px;color:#666;">
                    <span class="sku_wrapper"><span class="meta-label">SKU: </span><span class="sku">{{ $product->sku }}</span></span>
                </div>
                @endif

                @if($product->short_description)
                <div class="wd-single-short-desc">
                    <p>{{ $product->short_description }}</p>
                </div>
                @endif

                <div class="wd-single-price" style="margin:16px 0;">
                    <p class="price" style="font-size:26px;">
                        @if($hasSale)
                            <del aria-hidden="true"><span class="woocommerce-Price-amount amount">৳{{ number_format($product->selling_price, 2) }}</span></del>
                            <ins aria-hidden="true"><span class="woocommerce-Price-amount amount">৳{{ number_format($displayPrice, 2) }}</span></ins>
                        @else
                            <span class="woocommerce-Price-amount amount">৳{{ number_format($displayPrice, 2) }}</span>
                        @endif
                    </p>
                </div>

                <form id="pd-add-to-cart-form" class="cart" onsubmit="return false;">
                    @if($product->variants->isNotEmpty())
                    <div class="wd-single-variation" style="margin-bottom:16px;">
                        <label for="pd-variant-select" style="display:block;margin-bottom:6px;font-weight:600;">Options</label>
                        <select id="pd-variant-select" class="input-text" style="padding:10px;border:1px solid #ddd;border-radius:6px;min-width:220px;">
                            @foreach($product->variants as $variant)
                                @php
                                    $label = trim(implode(' / ', array_filter([$variant->color, $variant->size])) ?: $variant->name);
                                    $vPrice = $variant->price > 0 ? $variant->price : $displayPrice;
                                @endphp
                                <option value="{{ $variant->id }}" data-price="{{ $vPrice }}" data-stock="{{ $variant->stock }}"
                                    {{ $variant->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $label }} — ৳{{ number_format($vPrice, 2) }}{{ $variant->stock <= 0 ? ' (out of stock)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="wd-single-add-cart" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <div class="quantity" style="display:flex;align-items:center;border:1px solid #ddd;border-radius:6px;overflow:hidden;">
                            <button type="button" class="minus btn" aria-label="Decrease quantity"
                                onclick="document.getElementById('pd-qty').stepDown(); document.getElementById('pd-qty').dispatchEvent(new Event('change'))"
                                style="padding:10px 14px;border:none;background:#f5f5f5;cursor:pointer;">−</button>
                            <input type="number" id="pd-qty" class="input-text qty text" value="1" min="1"
                                max="{{ $product->type === 'physical' ? max(1, (int) $product->stock) : 999 }}"
                                style="width:50px;border:none;text-align:center;padding:10px 0;" />
                            <button type="button" class="plus btn" aria-label="Increase quantity"
                                onclick="document.getElementById('pd-qty').stepUp(); document.getElementById('pd-qty').dispatchEvent(new Event('change'))"
                                style="padding:10px 14px;border:none;background:#f5f5f5;cursor:pointer;">+</button>
                        </div>

                        <button type="button" id="pd-add-to-cart-btn" class="single_add_to_cart_button button alt"
                            data-product-id="{{ $product->id }}" {{ $inStock ? '' : 'disabled' }}
                            style="padding:12px 28px;background:#e5533d;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                            {{ $inStock ? 'Add to cart' : 'Out of stock' }}
                        </button>

                        <button type="button" id="pd-buy-now-btn" class="wd-buy-now-btn btn button alt btn-accent" {{ $inStock ? '' : 'disabled' }}
                            style="padding:12px 28px;background:#222;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                            Buy now
                        </button>
                    </div>
                </form>

                <div class="wd-single-action-btn wd-single-wishlist-btn" style="margin-top:16px;">
                    <div class="wd-wishlist-btn wd-action-btn wd-wishlist-icon wd-style-text">
                        <a href="{{ route('wishlist') }}" data-product-id="{{ $product->id }}" rel="nofollow">
                            <span class="wd-action-icon"><span class="wd-check-icon"></span></span>
                            <span class="wd-action-text">Add to wishlist</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description / Reviews tabs --}}
        <div style="margin-top:50px;">
            <div class="wd-tabs-nav" style="display:flex;gap:24px;border-bottom:2px solid #eee;margin-bottom:24px;">
                <button type="button" class="pd-tab-btn active" data-tab="pd-tab-description"
                    style="padding:12px 0;border:none;background:none;font-weight:700;font-size:15px;cursor:pointer;border-bottom:2px solid #e5533d;margin-bottom:-2px;">Description</button>
                <button type="button" class="pd-tab-btn" data-tab="pd-tab-reviews"
                    style="padding:12px 0;border:none;background:none;font-weight:700;font-size:15px;cursor:pointer;color:#777;">Reviews ({{ $totalReviews }})</button>
            </div>

            <div id="pd-tab-description" class="pd-tab-panel">
                <div class="woocommerce-product-details__description">
                    {!! nl2br(e($product->long_description ?: $product->description ?: 'No description available.')) !!}
                </div>
            </div>

            <div id="pd-tab-reviews" class="pd-tab-panel" style="display:none;">
                <a id="pd-reviews"></a>
                <div id="pd-reviews-list">
                    @forelse($reviews as $review)
                    <div class="pd-review" style="padding:16px 0;border-bottom:1px solid #eee;">
                        <div class="star-rating" role="img" aria-label="Rated {{ $review->rating }} out of 5">
                            <span style="width:{{ $review->rating / 5 * 100 }}%">Rated {{ $review->rating }} out of 5</span>
                        </div>
                        <strong>{{ $review->name }}</strong>
                        <span style="color:#999;font-size:13px;"> — {{ $review->created_at->format('d M Y') }}</span>
                        <p style="margin-top:6px;">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <p id="pd-no-reviews">There are no reviews yet.</p>
                    @endforelse
                </div>

                <h4 style="margin-top:30px;">Add a review</h4>
                <form id="pd-review-form" style="max-width:520px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="margin-bottom:12px;">
                        <label style="display:block;margin-bottom:4px;">Your rating *</label>
                        <select name="rating" required style="padding:8px;border:1px solid #ddd;border-radius:6px;">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Average</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;margin-bottom:4px;">Name *</label>
                        <input type="text" name="name" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;margin-bottom:4px;">Email (optional)</label>
                        <input type="email" name="email" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block;margin-bottom:4px;">Review *</label>
                        <textarea name="comment" rows="4" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;"></textarea>
                    </div>
                    <p id="pd-review-msg" style="display:none;margin-bottom:10px;"></p>
                    <button type="submit" class="button alt" style="padding:10px 24px;background:#e5533d;color:#fff;border:none;border-radius:6px;cursor:pointer;">Submit review</button>
                </form>
            </div>
        </div>

        {{-- Related products --}}
        @if($related->isNotEmpty())
        <div style="margin-top:60px;">
            <h2 class="wp-block-wd-title title" style="margin-bottom:20px;">You may also like…</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;">
                @foreach($related as $rp)
                @php
                    $rHasSale = $rp->sale_price && $rp->sale_price < $rp->selling_price;
                    $rPrice = $rHasSale ? $rp->sale_price : $rp->selling_price;
                    $rImg = $resolveImage($rp->thumbnail);
                    $rUrl = route('product-details') . '?slug=' . $rp->slug;
                @endphp
                <div class="wd-product wd-hover-quick product-grid-item" data-id="{{ $rp->id }}">
                    <a href="{{ $rUrl }}"><img src="{{ $rImg }}" alt="{{ $rp->name }}" style="width:100%;aspect-ratio:1/1;object-fit:cover;border-radius:6px;"></a>
                    <h3 class="wd-entities-title" style="font-size:14px;margin:8px 0 4px;"><a href="{{ $rUrl }}">{{ $rp->name }}</a></h3>
                    <span class="price">
                        @if($rHasSale)
                            <del><span class="woocommerce-Price-amount amount">৳{{ number_format($rp->selling_price, 2) }}</span></del>
                            <ins><span class="woocommerce-Price-amount amount">৳{{ number_format($rPrice, 2) }}</span></ins>
                        @else
                            <span class="woocommerce-Price-amount amount">৳{{ number_format($rPrice, 2) }}</span>
                        @endif
                    </span>
                    <div class="wd-add-btn" style="margin-top:8px;">
                        <button type="button" class="button add_to_cart_button" data-product_id="{{ $rp->id }}"
                            onclick="ShopCart.addToCart({{ $rp->id }}, 1, null); this.textContent='Added ✓'; setTimeout(()=>this.textContent='Add to cart', 1200)"
                            style="width:100%;padding:8px;background:#f5f5f5;border:none;border-radius:6px;cursor:pointer;">Add to cart</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tabs
    document.querySelectorAll('.pd-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pd-tab-btn').forEach(b => { b.classList.remove('active'); b.style.borderBottom = 'none'; b.style.color = '#777'; });
            document.querySelectorAll('.pd-tab-panel').forEach(p => p.style.display = 'none');
            btn.classList.add('active');
            btn.style.borderBottom = '2px solid #e5533d';
            btn.style.color = '#000';
            document.getElementById(btn.getAttribute('data-tab')).style.display = 'block';
        });
    });

    var reviewLink = document.getElementById('pd-review-link');
    if (reviewLink) {
        reviewLink.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('.pd-tab-btn[data-tab="pd-tab-reviews"]').click();
            document.getElementById('pd-reviews').scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Variant price sync
    var variantSelect = document.getElementById('pd-variant-select');
    function currentVariantId() {
        return variantSelect ? parseInt(variantSelect.value, 10) : null;
    }

    // Add to cart
    document.getElementById('pd-add-to-cart-btn').addEventListener('click', function () {
        var qty = parseInt(document.getElementById('pd-qty').value, 10) || 1;
        ShopCart.addToCart({{ $product->id }}, qty, currentVariantId());
        var original = this.textContent;
        this.textContent = 'Added to cart ✓';
        setTimeout(() => { this.textContent = original; }, 1500);
    });

    // Buy now — add to cart then jump straight to checkout
    document.getElementById('pd-buy-now-btn').addEventListener('click', function () {
        var qty = parseInt(document.getElementById('pd-qty').value, 10) || 1;
        ShopCart.addToCart({{ $product->id }}, qty, currentVariantId());
        window.location.href = "{{ route('checkout') }}";
    });

    // Review submission
    var reviewForm = document.getElementById('pd-review-form');
    reviewForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var msg = document.getElementById('pd-review-msg');
        var formData = new FormData(reviewForm);
        var payload = Object.fromEntries(formData.entries());

        fetch("{{ route('product-reviews.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ShopCart.csrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data: data })))
        .then(function (res) {
            msg.style.display = 'block';
            if (res.ok && res.data.success) {
                msg.style.color = 'green';
                msg.textContent = 'Thanks for your review!';

                var noReviews = document.getElementById('pd-no-reviews');
                if (noReviews) noReviews.remove();

                var r = res.data.review;
                var div = document.createElement('div');
                div.className = 'pd-review';
                div.style.cssText = 'padding:16px 0;border-bottom:1px solid #eee;';

                var ratingDiv = document.createElement('div');
                ratingDiv.className = 'star-rating';
                ratingDiv.setAttribute('role', 'img');
                ratingDiv.setAttribute('aria-label', 'Rated ' + r.rating + ' out of 5');
                ratingDiv.innerHTML = '<span style="width:' + (r.rating / 5 * 100) + '%">Rated ' + r.rating + ' out of 5</span>';

                var nameEl = document.createElement('strong');
                nameEl.textContent = r.name;

                var dateEl = document.createElement('span');
                dateEl.style.cssText = 'color:#999;font-size:13px;';
                dateEl.textContent = ' — ' + r.created_at;

                var commentEl = document.createElement('p');
                commentEl.style.marginTop = '6px';
                commentEl.textContent = r.comment;

                div.append(ratingDiv, nameEl, dateEl, commentEl);
                document.getElementById('pd-reviews-list').prepend(div);

                reviewForm.reset();
            } else {
                msg.style.color = 'red';
                msg.textContent = (res.data.message) || 'Please check the form and try again.';
            }
        })
        .catch(function () {
            msg.style.display = 'block';
            msg.style.color = 'red';
            msg.textContent = 'Something went wrong. Please try again.';
        });
    });
});
</script>
@endsection
