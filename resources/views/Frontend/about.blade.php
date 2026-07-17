@extends('Frontend.Layout.app')

@section('title', 'About Us')

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
    <link rel='stylesheet' id='wd-style-base-css'
        href='{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/base.css') }}' type='text/css'
        media='all' />
    <style id='wd-style-base-inline-css' type='text/css'>
        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: "woodmart-font";
            src: url("{{ asset('frontendmerchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2') }}") format("woff2");
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
    <style id='wd-accordion-inline-css' type='text/css'>
        .wd-accordion {
            --wd-accordion-spacing: 20px;
            --wd-row-gap: 0.001px;
            display: flex;
            flex-direction: column;
            gap: var(--wd-row-gap)
        }

        .wd-accordion .wd-scroll {
            height: auto
        }

        .wd-accordion .wd-scroll-content {
            padding-inline-end: 10px
        }

        .wd-accordion:where(.wd-style-default)>.wd-accordion-item:first-of-type,
        .wd-accordion:where(.wd-style-default)>.wd-nav-wrapper+.wd-accordion-item {
            border-top: 2px solid var(--brdcolor-gray-300)
        }

        .wd-accordion:where(.wd-style-default)>.wd-accordion-item {
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        .wd-accordion:where(.wd-style-default).wd-border-off>.wd-accordion-item:first-of-type {
            border-top: none
        }

        .wd-accordion:where(.wd-style-default).wd-border-off>.wd-accordion-item:last-child {
            border-bottom: none
        }

        .wd-accordion.wd-style-simple {
            --wd-accordion-spacing: 10px
        }

        .wd-accordion.wd-style-shadow {
            --wd-row-gap: 12px
        }

        .wd-accordion:where(.wd-style-shadow)>.wd-accordion-item {
            border-radius: var(--wd-brd-radius);
            box-shadow: 0 1px 8px rgba(0, 0, 0, .1)
        }

        .wd-accordion:where(.wd-style-shadow)>.wd-accordion-item>:is(.wd-accordion-title, .wd-accordion-content) {
            padding-inline: var(--wd-accordion-spacing)
        }

        .global-color-scheme-light .wd-accordion:where(.wd-style-shadow)>.wd-accordion-item {
            background-color: var(--bgcolor-gray-200)
        }

        .wd-accordion-title {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-block: var(--wd-accordion-spacing);
            cursor: pointer;
            transition: all .25s ease;
            user-select: none
        }

        .wd-accordion-title:is(.wd-active, :hover)>.wd-accordion-title-text {
            color: var(--wd-primary-color)
        }

        .wd-accordion-title .img-wrapper {
            display: flex
        }

        .wd-accordion-title-text {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 5px;
            color: var(--wd-title-color);
            font-weight: var(--wd-title-font-weight);
            font-size: var(--wd-accordion-font-size, 16px);
            transition: inherit
        }

        .wd-accordion-opener {
            position: relative;
            color: var(--color-gray-300);
            text-align: center;
            font-size: 10px;
            line-height: 1;
            transition: inherit
        }

        .wd-accordion.wd-opener-style-arrow>.wd-accordion-item>.wd-accordion-title .wd-accordion-opener:before {
            content: "\f129";
            font-family: "woodmart-font"
        }

        .wd-accordion.wd-opener-style-arrow>.wd-accordion-item>.wd-accordion-title.wd-active .wd-accordion-opener {
            transform: rotate(180deg)
        }

        .wd-accordion.wd-opener-style-plus>.wd-accordion-item>.wd-accordion-title .wd-accordion-opener:before {
            content: "\f143";
            font-family: "woodmart-font"
        }

        .wd-accordion.wd-opener-style-plus>.wd-accordion-item>.wd-accordion-title.wd-active .wd-accordion-opener {
            transform: rotate(45deg)
        }

        .wd-accordion-content {
            padding-bottom: var(--wd-accordion-spacing);
            transition: opacity .25s ease;
            display: none;
            opacity: 0
        }

        .wd-accordion-content.wd-active {
            display: block;
            opacity: 1
        }

        .wd-accordion-content-inner {
            --wd-row-gap: 20px;
            display: flex;
            flex-direction: column;
            row-gap: var(--wd-row-gap)
        }

        :root .wd-accordion-content-inner>* {
            margin-bottom: 0
        }

        @media(max-width: 1024px) {
            .wd-accordion .wd-scroll-content {
                overflow: visible;
                padding-inline-end: 0;
                max-height: none !important
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-accordion.css */
    </style>
    <style id='wd-block-accordion-inline-css' type='text/css'>
        .wd-accordion.wd-titles-start>.wd-accordion-item>.wd-accordion-title>div {
            justify-content: start
        }

        .wd-accordion.wd-titles-end>.wd-accordion-item>.wd-accordion-title>div {
            justify-content: end
        }

        .wd-accordion.wd-opener-pos-start>.wd-accordion-item>.wd-accordion-title {
            flex-direction: row-reverse
        }

        .wd-accordion.wd-opener-pos-end>.wd-accordion-item>.wd-accordion-title {
            flex-direction: row
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/el-accordion-block.css */
    </style>
    <script type="text/javascript"
        src="{{ asset('frontend/merchandise/wp-includes/js/jquery/jquery.min.js" id="jquery-core-js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('frontend/merchandise/wp-content/themes/woodmart/js/scripts/global/scrollBar.min.js') }}"
        id="wd-scrollbar-js"></script>
    <meta name="theme-color" content="rgb(245,245,245)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-45x45.png" sizes="32x32" />
    <link rel="icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
    <meta name="msapplication-TileImage" content="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
    <style id="wd-style-blocks-593-inline-css" data-type="wd-style-blocks-593">
        #wd-fd0a44cb {
            margin-top: -40px;
            margin-bottom: 0px;
            background-color: var(--wd-primary-color);
            min-height: 220px;
        }

        #wd-2581e6d1 {
            justify-content: center;
        }

        #wd-c0be48ff {
            justify-content: center;
        }

        #wd-03cc1817 {
            justify-content: center;
        }

        #wd-7f0748e6 {
            --wd-col-gap: 20px;
            margin-top: -180px;
            margin-bottom: 120px;
        }

        #wd-edf56ef8 {
            font-size: 32px;
            line-height: 1.2em;
        }

        #wd-d03d3c89 {
            --wd-col-gap: 20px;
            margin-bottom: 120px;
        }

        #wd-e5334d67 {
            font-size: 14px;
        }

        #wd-23aea4a6 {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        #wd-cf910214 {
            font-size: 14px;
        }

        #wd-537a081e {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        #wd-bb7c8f76 {
            font-size: 14px;
        }

        #wd-39af9d48 {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        #wd-4ed153df {
            font-size: 14px;
        }

        #wd-245259dd {
            --wd-align: var(--wd-center);
            padding: 30px;
            background-color: #f5f5f5;
        }

        #wd-090647c4 {
            margin-bottom: 90px;
        }

        #wd-5bb70873 {
            padding: 0px 20px 0px 20px;
            border: 1px solid rgba(0, 0, 0, 0.11);
            border-radius: 16px;
        }

        #wd-cf961f5b {
            padding-right: 20px;
            padding-left: 20px;
            margin-top: 20px;
            border: 1px solid rgba(0, 0, 0, 0.11);
            border-radius: 16px;
        }

        #wd-64820e43 {
            padding-right: 20px;
            padding-left: 20px;
            margin-top: 20px;
            border: 1px solid rgba(0, 0, 0, 0.11);
            border-radius: 16px;
        }

        #wd-a744194b {
            padding-right: 20px;
            padding-left: 20px;
            margin-top: 20px;
            border: 1px solid rgba(0, 0, 0, 0.11);
            border-radius: 16px;
        }

        #wd-88c1cfa7 {
            padding-right: 20px;
            padding-left: 20px;
            margin-top: 20px;
            border: 1px solid rgba(0, 0, 0, 0.11);
            border-radius: 16px;
        }

        #wd-984402e3>.wd-accordion-item>.wd-accordion-title>.wd-accordion-title-text {
            font-size: 20px;
        }

        #wd-984402e3>.wd-accordion-item>.wd-accordion-title:hover>.wd-accordion-title-text {
            color: #242424;
        }

        #wd-984402e3>.wd-accordion-item>.wd-accordion-title.wd-active>.wd-accordion-title-text {
            color: #242424;
        }

        #wd-984402e3>.wd-accordion-item>.wd-accordion-title>.wd-accordion-opener {
            font-size: 18px;
        }

        @media (max-width: 1024px) {
            #wd-fd0a44cb {
                min-height: 120px;
            }

            #wd-7f0748e6 {
                margin-top: -100px;
                margin-bottom: 70px;
            }

            #wd-d03d3c89 {
                margin-bottom: 70px;
            }

            #wd-090647c4 {
                margin-bottom: 70px;
            }

            #wd-984402e3>.wd-accordion-item>.wd-accordion-title>.wd-accordion-title-text {
                font-size: 18px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            #wd-534516a1 {
                flex: 0 1 calc(100% - var(--wd-col-gap) * 0 / 1);
            }

            #wd-99339827 {
                flex: 0 1 calc(100% - var(--wd-col-gap) * 0 / 1);
            }
        }

        @media (max-width: 768.98px) {
            :root #wd-2581e6d1 {
                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
            }

            :root #wd-bde209e7 {
                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
            }

            :root #wd-c0be48ff {
                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
            }

            #wd-c0be48ff {
                order: 4;
            }

            :root #wd-03cc1817 {
                flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
            }

            #wd-03cc1817 {
                order: 3;
            }

            #wd-7f0748e6 {
                margin-bottom: 50px;
            }

            #wd-edf56ef8 {
                font-size: 28px;
            }

            #wd-d03d3c89 {
                margin-bottom: 50px;
            }

            #wd-090647c4 {
                margin-bottom: 50px;
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
    <link rel="stylesheet" href="{{ asset('frontend/assets/gms-custom.css') }}">
@endpush

@section('content')

		<div class="wd-page-content main-page-wrapper">

			<link rel="stylesheet" id="wd-page-title-css"
				href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/page-title.css') }}" type="text/css" media="all" />
			<div class="wd-page-title page-title  page-title-default title-size-small title-design-centered color-scheme-default"
				style="">
				<div class="wd-page-title-bg wd-fill">
				</div>
				<div class="container">
					<h1 class="entry-title title">
						About us </h1>


					<nav class="wd-breadcrumbs"><a href="{{ route('home') }}">Home</a><span class="wd-delimiter">/</span><span
							class="wd-last">About us</span></nav>
				</div>
			</div>

			<main id="main-content" class="wd-content-layout content-layout-wrapper container" role="main">


				<div class="wd-content-area site-content">
					<article id="post-593" class="entry-content post-593 page type-page status-publish hentry">

						<div id="wd-fd0a44cb" class="wp-block-wd-section"></div>

						<div id="wd-7f0748e6" class="wp-block-wd-row">
							<div id="wd-2581e6d1" class="wp-block-wd-column">
								<div id="wd-bf3d7474" class="wp-block-wd-image wd-block-image"><img fetchpriority="high"
										decoding="async" width="316" height="316" class="wp-image-807"
										src="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1.jpg.webp" alt=""
										srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1.jpg.webp 316w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1-300x300.jpg.webp 300w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1-290x290.jpg.webp 290w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-1-100x100.jpg.webp 100w"
										sizes="(max-width: 316px) 100vw, 316px" /></div>
							</div>

							<div id="wd-bde209e7" class="wp-block-wd-column">
								<div id="wd-33932e98" class="wp-block-wd-image wd-block-image"><img decoding="async"
										width="316" height="380" class="wp-image-809"
										src="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2.jpg.webp" alt=""
										srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2.jpg.webp 316w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2-249x300.jpg.webp 249w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2-274x330.jpg.webp 274w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2-83x100.jpg.webp 83w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-2-150x180.jpg.webp 150w"
										sizes="(max-width: 316px) 100vw, 316px" /></div>
							</div>

							<div id="wd-c0be48ff" class="wp-block-wd-column">
								<div id="wd-45900e23" class="wp-block-wd-image wd-block-image"><img decoding="async"
										width="316" height="284" class="wp-image-806"
										src="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3.jpg.webp" alt=""
										srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3.jpg.webp 316w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3-300x270.jpg.webp 300w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3-290x261.jpg.webp 290w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3-100x90.jpg.webp 100w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-3-150x135.jpg.webp 150w"
										sizes="(max-width: 316px) 100vw, 316px" /></div>
							</div>

							<div id="wd-03cc1817" class="wp-block-wd-column">
								<div id="wd-06623b74" class="wp-block-wd-image wd-block-image"><img loading="lazy"
										decoding="async" width="316" height="348" class="wp-image-808"
										src="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4.jpg.webp" alt=""
										srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4.jpg.webp 316w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4-272x300.jpg.webp 272w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4-290x319.jpg.webp 290w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4-91x100.jpg.webp 91w, merchandise/wp-content/uploads/sites/31/2025/11/gms-img-4-150x165.jpg.webp 150w"
										sizes="auto, (max-width: 316px) 100vw, 316px" /></div>
							</div>
						</div>

						<h2 id="wd-edf56ef8" class="wp-block-wd-title title">Born from a Passion for Gaming</h2>

						<div id="wd-d03d3c89" class="wp-block-wd-row">
							<div id="wd-534516a1" class="wp-block-wd-column">
								<p id="wd-3bc0284c" class="wp-block-wd-paragraph">At [Merchandise], we’re more than just
									a store—we’re gamers like you, driven by a shared passion for the world of video
									games. Our journey began with a simple yet powerful idea: to create a place where
									gamers can find high-quality, officially licensed merchandise that truly reflects
									their love for gaming. Whether you’re reliving the nostalgia of retro classics or
									immersing yourself in the worlds of the latest blockbusters, we believe that every
									fan deserves merch that feels authentic, unique, and meaningful.</p>
							</div>

							<div id="wd-99339827" class="wp-block-wd-column">
								<p id="wd-d68718e2" class="wp-block-wd-paragraph">We’re proud to be your go-to
									destination for gamer merch, and we’re excited to keep growing, innovating, and
									leveling up with you on this journey. Whether you’re here for a collectible that
									completes your setup or an apparel piece that speaks to your inner gamer, we’re here
									to make sure you find exactly what you’re looking for. Happy gaming!</p>
							</div>
						</div>

						<div id="wd-090647c4" class="wp-block-wd-carousel wd-carousel-container">
							<div class="wd-carousel-inner">
								<div class="wd-carousel wd-grid"
									style="--wd-col-lg:4;--wd-col-md:3;--wd-col-sm:1;--wd-gap-lg:20px;--wd-gap-sm:10px"
									data-scroll_per_page="yes">
									<div class="wd-carousel-wrap">
										<div id="wd-c020cd16" class="wp-block-wd-carousel-item wd-carousel-item">
											<div id="wd-23aea4a6"
												class="wp-block-wd-infobox wd-hover-parent wd-align wd-icon-top">
												<div id="wd-9d7b892a" class="wp-block-wd-icon"><img loading="lazy"
														decoding="async" width="68" height="68" class="wp-image-839"
														src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inbx-gamepad.jpg.webp"
														alt="" /></div>

												<div id="wd-d4863966" class="wp-block-wd-container wd-dir-col">
													<h2 id="wd-b1e12cec" class="wp-block-wd-title title">Apparel &amp;
														Accessories</h2>

													<p id="wd-e5334d67" class="wp-block-wd-paragraph">Show off your
														favorite gaming franchises in style, both in and out of the game
													</p>
												</div>
											</div>
										</div>

										<div id="wd-2e710a3b" class="wp-block-wd-carousel-item wd-carousel-item">
											<div id="wd-537a081e"
												class="wp-block-wd-infobox wd-hover-parent wd-align wd-icon-top">
												<div id="wd-0da377f0" class="wp-block-wd-icon"><img loading="lazy"
														decoding="async" width="68" height="68" class="wp-image-840"
														src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inbx-puzzle.jpg.webp"
														alt="" /></div>

												<div id="wd-3edf8750" class="wp-block-wd-container wd-dir-col">
													<h2 id="wd-eb1803de" class="wp-block-wd-title title">Collectibles
														&amp; Decor</h2>

													<p id="wd-cf910214" class="wp-block-wd-paragraph">Bring your
														favorite game worlds to life with high-quality collectibles and
														home decor</p>
												</div>
											</div>
										</div>

										<div id="wd-bdd43ee0" class="wp-block-wd-carousel-item wd-carousel-item">
											<div id="wd-39af9d48"
												class="wp-block-wd-infobox wd-hover-parent wd-align wd-icon-top">
												<div id="wd-5c1d0fd4" class="wp-block-wd-icon"><img loading="lazy"
														decoding="async" width="68" height="68" class="wp-image-841"
														src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inbx-art.jpg.webp"
														alt="" /></div>

												<div id="wd-eb316032" class="wp-block-wd-container wd-dir-col">
													<h2 id="wd-034f199a" class="wp-block-wd-title title">Posters &amp;
														Art Prints</h2>

													<p id="wd-bb7c8f76" class="wp-block-wd-paragraph">Decorate your
														walls with posters and art prints featuring iconic characters
													</p>
												</div>
											</div>
										</div>

										<div id="wd-913cee8e" class="wp-block-wd-carousel-item wd-carousel-item">
											<div id="wd-245259dd"
												class="wp-block-wd-infobox wd-hover-parent wd-align wd-icon-top">
												<div id="wd-afd3b010" class="wp-block-wd-icon"><img loading="lazy"
														decoding="async" width="68" height="68" class="wp-image-842"
														src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inbx-gift.jpg.webp"
														alt="" /></div>

												<div id="wd-5809a874" class="wp-block-wd-container wd-dir-col">
													<h2 id="wd-53543541" class="wp-block-wd-title title">Unique Gifts
														&amp; Bundles</h2>

													<p id="wd-4ed153df" class="wp-block-wd-paragraph">Find the perfect
														gift for gamers with our exclusive bundles and unique merch</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
									<div class="wd-btn-arrow wd-prev">
										<div class="wd-arrow-inner"></div>
									</div>
									<div class="wd-btn-arrow wd-next">
										<div class="wd-arrow-inner"></div>
									</div>
								</div>
							</div>
							<div class="wd-nav-scroll wd-hide-lg"></div>
						</div>

						<div id="wd-984402e3"
							class="wp-block-wd-accordion wd-accordion wd-style-default wd-titles-start wd-opener-style-plus wd-opener-pos-end"
							data-state="all">
							<div id="wd-5bb70873" class="wp-block-wd-accordion-pane wd-accordion-item">
								<div class="wd-accordion-title wd-role-btn" tabindex="0">
									<div class="wd-accordion-title-text"><span>What types of products do you
											offer?</span></div><span class="wd-accordion-opener"></span>
								</div>
								<div class="wd-accordion-content">
									<div class="wd-accordion-content-inner">
										<p id="wd-a339f8d6" class="wp-block-wd-paragraph">Keep the product in its
											original packaging along with all documents confirming the purchase and
											refund. You will need this for further communication with the seller and the
											payment system.</p>
									</div>
								</div>
							</div>

							<div id="wd-cf961f5b" class="wp-block-wd-accordion-pane wd-accordion-item">
								<div class="wd-accordion-title wd-role-btn" tabindex="0">
									<div class="wd-accordion-title-text"><span>Do you sell officially licensed
											merchandise?</span></div><span class="wd-accordion-opener"></span>
								</div>
								<div class="wd-accordion-content">
									<div class="wd-accordion-content-inner">
										<p id="wd-61db26da" class="wp-block-wd-paragraph">Check the email you received
											after placing your order. It should contain information about the status of
											your order and the expected delivery date.</p>
									</div>
								</div>
							</div>

							<div id="wd-64820e43" class="wp-block-wd-accordion-pane wd-accordion-item">
								<div class="wd-accordion-title wd-role-btn" tabindex="0">
									<div class="wd-accordion-title-text"><span>How long does shipping take?</span></div>
									<span class="wd-accordion-opener"></span>
								</div>
								<div class="wd-accordion-content">
									<div class="wd-accordion-content-inner">
										<p id="wd-b8c6d5ac" class="wp-block-wd-paragraph">Keep the product in its
											original packaging along with all documents confirming the purchase and
											refund. You will need this for further communication with the seller and the
											payment system.</p>
									</div>
								</div>
							</div>

							<div id="wd-a744194b" class="wp-block-wd-accordion-pane wd-accordion-item">
								<div class="wd-accordion-title wd-role-btn" tabindex="0">
									<div class="wd-accordion-title-text"><span>What is your return policy?</span></div>
									<span class="wd-accordion-opener"></span>
								</div>
								<div class="wd-accordion-content">
									<div class="wd-accordion-content-inner">
										<p id="wd-06e7df84" class="wp-block-wd-paragraph">If the contents of the parcel
											are suspicious to customs officers (for example, many identical goods), it
											may be further checked.</p>
									</div>
								</div>
							</div>

							<div id="wd-88c1cfa7" class="wp-block-wd-accordion-pane wd-accordion-item">
								<div class="wd-accordion-title wd-role-btn" tabindex="0">
									<div class="wd-accordion-title-text"><span>Do you offer discounts or special
											deals?</span></div><span class="wd-accordion-opener"></span>
								</div>
								<div class="wd-accordion-content">
									<div class="wd-accordion-content-inner">
										<p id="wd-a99b7635" class="wp-block-wd-paragraph">Keep the product in its
											original packaging along with all documents confirming the purchase and
											refund. You will need this for further communication with the seller and the
											payment system.</p>
									</div>
								</div>
							</div>
						</div>


					</article>



				</div>

			</main>

		</div>
@endsection
