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
    <style id='wd-page-wishlist-inline-css' type='text/css'>
        .wd-wishlist-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px 15px;
            margin-bottom: 15px
        }

        .wd-wishlist-head .title {
            margin-bottom: 0;
            text-transform: uppercase;
            font-size: 18px
        }

        .wd-wishlist-head:not(.wd-border-off) {
            padding-bottom: 10px;
            border-bottom: 1px solid var(--brdcolor-gray-300)
        }

        .wd-wishlist-product-actions {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
            height: 14px
        }

        .wd-wishlist-product-remove {
            font-size: .9em
        }

        .wd-wishlist-product-checkbox {
            flex: 1 1 auto;
            text-align: end;
            font-size: 0
        }

        .wd-wishlist-product-checkbox input {
            margin-inline-end: 0
        }

        .wd-wishlist-content:not(.wd-wishlist-preview) .wd-wishlist-btn {
            opacity: .3 !important;
            pointer-events: none
        }

        .wd-wishlist-content:not(.wd-wishlist-preview) .wd-loop-builder-off .wd-product {
            display: flex;
            flex-direction: column
        }

        .wd-wishlist-content:not(.wd-wishlist-preview) .wd-loop-builder-off .wd-product:not(.wd-hover-base) .wd-wishlist-btn {
            display: none
        }

        .wd-product:hover .wd-wishlist-product-actions {
            z-index: 30
        }

        .wd-wishlist-content .wd-loop-builder-off .wd-product-card-bg {
            top: -35px
        }

        .wd-wishlist-content .wd-loop-builder-off.products-bordered-grid .wd-product-card-bg {
            top: calc(var(--wd-gap)/2*-1 - 30px)
        }

        .wd-wishlist-content .wd-loop-builder-off:is(.products-bordered-grid-ins, .wd-products-with-bg:not(.products-bordered-grid), .wd-products-with-shadow:not(.products-bordered-grid)) .wd-product-card-bg {
            top: -1px
        }

        .wd-loop-builder-on .wd-wishlist-product-actions {
            margin-top: 8px;
            margin-bottom: 8px !important;
            margin-inline: 8px
        }

        .wd-wishlist-product-actions+.wp-block-wd-li-product-card {
            margin-top: 5px
        }

        .wd-wishlist-product-actions+.wp-block-wd-li-product-card .wd-product-card-bg {
            top: calc(var(--wd-prod-card-pt-cl)*-1 - .9em - 5px)
        }

        .wd-empty-wishlist {
            --wd-empty-block-icon: "\f106"
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-wishlist.css */
    </style>
    <style id='wd-page-my-account-inline-css' type='text/css'>
        .wd-nav-my-acc>li>a {
            justify-content: var(--wd-align, start);
            font-size: unset;
            text-transform: unset
        }

        .wd-nav-my-acc.wd-grid-g {
            display: grid;
            gap: var(--wd-gap)
        }

        .wd-nav-my-acc>li>a .wd-nav-icon {
            width: 1em;
            line-height: 1;
            text-align: center;
            transition: all .25s ease
        }

        .wd-nav-my-acc>li>a .wd-nav-icon:before {
            content: var(--wd-my-acc-nav-icon, "\f140");
            display: block;
            font-weight: 400;
            font-family: "woodmart-font"
        }

        .wd-nav-my-acc.wd-icon-top>li>a {
            flex-direction: column;
            align-items: var(--wd-align, start);
            text-align: var(--wd-align, start)
        }

        .wd-nav-my-acc.wd-icon-top>li>a .wd-nav-icon {
            margin-inline-end: 0;
            margin-bottom: 10px
        }

        .wd-my-acc-wishlist {
            --wd-my-acc-nav-icon: "\f134"
        }

        .wd-my-acc-waitlist {
            --wd-my-acc-nav-icon: "\f185"
        }

        .wd-my-acc-edit-account {
            --wd-my-acc-nav-icon: "\f135"
        }

        .wd-my-acc-orders {
            --wd-my-acc-nav-icon: "\f138"
        }

        .wd-my-acc-downloads {
            --wd-my-acc-nav-icon: "\f136"
        }

        .wd-my-acc-payment-methods {
            --wd-my-acc-nav-icon: "\f142"
        }

        .wd-my-acc-edit-address {
            --wd-my-acc-nav-icon: "\f139"
        }

        .wd-my-acc-customer-logout {
            --wd-my-acc-nav-icon: "\f137"
        }

        .wd-my-acc-price-tracker {
            --wd-my-acc-nav-icon: "\f18a"
        }

        .woocommerce-MyAccount-content>*:not(:last-child) {
            margin-bottom: 20px
        }

        .woocommerce-MyAccount-content p:not(.form-row):last-child {
            --wd-tags-mb: .001px
        }

        .woocommerce-MyAccount-content>.button {
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

        .woocommerce-MyAccount-content>.button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .woocommerce-MyAccount-content>.button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .woocommerce-MyAccount-content :is(address, .woocommerce-Message, .woocommerce-info, .woocommerce-orders-table):last-child {
            margin-bottom: 0
        }

        .woocommerce-MyAccount-content .wd-wtl-table {
            margin-bottom: 0
        }

        .elementor-element.woocommerce-MyAccount-content>div>*:not(:last-child) {
            margin-bottom: 20px
        }

        .elementor-element.woocommerce-MyAccount-content>div>.button {
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

        .elementor-element.woocommerce-MyAccount-content>div>.button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .elementor-element.woocommerce-MyAccount-content>div>.button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .woocommerce-orders-table th {
            --wd-link-color: var(--color-gray-800);
            --wd-link-color-hover: var(--color-gray-500);
            --wd-link-decor: none;
            --wd-link-decor-hover: none
        }

        .woocommerce-orders-table td:before {
            color: var(--color-gray-800);
            font-weight: 600
        }

        .woocommerce-pagination .button {
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

        .woocommerce-pagination .button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .woocommerce-pagination .button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .account-payment-methods-table .button {
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

        .account-payment-methods-table .button:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        .account-payment-methods-table .button:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        .woocommerce-Address-title .edit {
            color: var(--wd-link-color);
            font-weight: var(--wd-text-font-weight);
            font-style: var(--wd-text-font-style);
            font-family: var(--wd-text-font);
            font-size: 1.1em
        }

        .woocommerce-Address-title .edit:before {
            margin-inline-end: 7px;
            font-weight: 400;
            content: "\f116";
            font-family: "woodmart-font"
        }

        .woocommerce-EditAccountForm fieldset {
            margin-top: 40px
        }

        .wd-email-sub-main {
            margin-top: 25px
        }

        .wd-email-sub-main~.wd-email-sub {
            margin-inline-start: 10px
        }

        button[name=save_account_details],
        button[name=save_address] {
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

        button[name=save_account_details]:hover,
        button[name=save_address]:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        button[name=save_account_details]:active,
        button[name=save_address]:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        @media(min-width: 1025px) {
            .woocommerce-MyAccount-content {
                --wd-empty-block-size: 30px
            }

            .woocommerce-orders-table td.woocommerce-orders-table__cell-order-actions a:not(:last-child) {
                margin-inline-end: 5px
            }
        }

        @media(min-width: 769px)and (max-width: 1024px) {
            .woocommerce-orders-table {
                display: block
            }

            .woocommerce-orders-table thead {
                display: none
            }

            .woocommerce-orders-table :is(tbody, tfoot) {
                display: block
            }

            .woocommerce-orders-table tr {
                position: relative;
                display: flex;
                flex-direction: column;
                gap: 5px;
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid var(--brdcolor-gray-300)
            }

            .woocommerce-orders-table tr:last-child {
                margin-bottom: 0
            }

            .woocommerce-orders-table :is(th, td) {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 5px;
                padding: 0;
                border-bottom: none
            }

            .woocommerce-orders-table :is(th, td):not(:last-child) {
                padding-bottom: 5px;
                border-bottom: 1px dashed var(--brdcolor-gray-300)
            }

            .woocommerce-orders-table :is(th, td):before {
                content: attr(data-title);
                margin-inline-end: auto
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-page-my-account.css */
    </style>
    <style id='child-style-inline-css' type='text/css'>
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
    <meta name="msapplication-TileImage" content="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
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
<div class="wd-page-wrapper">
    <div class="container" style="padding-top:24px;padding-bottom:60px;">

        <div class="wd-breadcrumbs" style="margin-bottom:20px;font-size:13px;">
            <a href="{{ route('home') }}">Home</a>
            <span> / </span>
            <span>Wishlist</span>
        </div>

        <h1 style="margin-bottom:20px;">My Wishlist</h1>

        <div id="wl-empty" style="display:none;padding:40px 0;text-align:center;color:#777;">
            <p>Your wishlist is empty.</p>
            <a href="{{ route('all-products') }}" class="button alt"
                style="display:inline-block;margin-top:10px;padding:10px 24px;background:#e5533d;color:#fff;border-radius:6px;text-decoration:none;">
                Browse products
            </a>
        </div>

        <div id="wl-loading" style="padding:40px 0;text-align:center;color:#777;">Loading your wishlist…</div>

        <div id="wl-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var ids = ShopCart.getWishlist();
    var loading = document.getElementById('wl-loading');
    var empty = document.getElementById('wl-empty');
    var grid = document.getElementById('wl-grid');

    function money(n) {
        return '৳' + Number(n).toFixed(2);
    }

    function render(products) {
        loading.style.display = 'none';

        if (!products.length) {
            empty.style.display = 'block';
            return;
        }

        grid.style.display = 'grid';
        grid.innerHTML = products.map(function (p) {
            var priceHtml = p.old_price
                ? '<del><span class="woocommerce-Price-amount amount">' + money(p.old_price) + '</span></del> ' +
                  '<ins><span class="woocommerce-Price-amount amount">' + money(p.price) + '</span></ins>'
                : '<span class="woocommerce-Price-amount amount">' + money(p.price) + '</span>';

            return (
                '<div class="wd-product wd-hover-quick product-grid-item" data-id="' + p.id + '">' +
                    '<a href="' + p.url + '"><img src="' + (p.image || '') + '" alt="' + p.name + '" ' +
                        'style="width:100%;aspect-ratio:1/1;object-fit:cover;border-radius:6px;"></a>' +
                    '<h3 class="wd-entities-title" style="font-size:14px;margin:8px 0 4px;"><a href="' + p.url + '">' + p.name + '</a></h3>' +
                    '<span class="price">' + priceHtml + '</span>' +
                    '<div style="display:flex;gap:8px;margin-top:8px;">' +
                        '<button type="button" class="button add_to_cart_button wl-add-cart" data-id="' + p.id + '" ' +
                            (p.stock <= 0 && p.type === 'physical' ? 'disabled' : '') +
                            ' style="flex:1;padding:8px;background:#e5533d;color:#fff;border:none;border-radius:6px;cursor:pointer;">' +
                            (p.stock <= 0 && p.type === 'physical' ? 'Out of stock' : 'Add to cart') +
                        '</button>' +
                        '<button type="button" class="wl-remove" data-id="' + p.id + '" ' +
                            'style="padding:8px 12px;background:#f5f5f5;border:none;border-radius:6px;cursor:pointer;" ' +
                            'aria-label="Remove from wishlist">&times;</button>' +
                    '</div>' +
                '</div>'
            );
        }).join('');

        grid.querySelectorAll('.wl-add-cart').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var id = parseInt(btn.getAttribute('data-id'), 10);
                ShopCart.addToCart(id, 1, null);
                var original = btn.textContent;
                btn.textContent = 'Added ✓';
                setTimeout(function () { btn.textContent = original; }, 1200);
            });
        });

        grid.querySelectorAll('.wl-remove').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var id = parseInt(btn.getAttribute('data-id'), 10);
                ShopCart.removeFromWishlist(id);
                btn.closest('[data-id]').remove();
                if (ShopCart.getWishlist().length === 0) {
                    grid.style.display = 'none';
                    empty.style.display = 'block';
                }
            });
        });
    }

    if (!ids.length) {
        loading.style.display = 'none';
        empty.style.display = 'block';
    } else {
        ShopCart.fetchProducts(ids).then(render).catch(function () {
            loading.textContent = 'Could not load your wishlist. Please try again.';
        });
    }
});
</script>
@endsection
