@extends('Frontend.Layout.app')
@push("styles")

<link rel="preload" as="font"
        href="merchandise/wp-content/themes/woodmart/fonts/woodmart-font-2-700.woff2"
        type="font/woff2" crossorigin>
    <style id='wp-img-auto-sizes-contain-inline-css' type='text/css'>
        img:is([sizes=auto i], [sizes^="auto," i]) {
            contain-intrinsic-size: 3000px 1500px
        }

        /*# sourceURL=wp-img-auto-sizes-contain-inline-css */
    </style>
    <link rel='stylesheet' id='select2-css'
        href='merchandise/wp-content/plugins/woocommerce/assets/css/select2.css'
        type='text/css' media='all' />
    <style id='woocommerce-inline-inline-css' type='text/css'>
        .woocommerce form .form-row .required {
            visibility: visible;
        }

        /*# sourceURL=woocommerce-inline-inline-css */
    </style>
    <link rel='stylesheet' id='wd-style-base-css'
        href='merchandise/wp-content/themes/woodmart/css/parts/base.css'
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
        href='merchandise/wp-content/themes/woodmart/css/parts/header-base.css'
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
    <style id='wd-select2-inline-css' type='text/css'>
        body .select2-container--default {
            min-height: 42px
        }

        body .select2-container--default .select2-selection {
            border: var(--wd-form-brd-width) solid var(--wd-form-brd-color);
            border-radius: var(--wd-form-brd-radius);
            background-color: var(--wd-form-bg);
            transition: border-color .4s ease
        }

        body .select2-container--default .select2-selection:focus {
            outline: none
        }

        body .select2-container--default .select2-selection--single {
            height: var(--wd-form-height);
            text-align: start;
            font-size: 14px
        }

        body .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-inline: 15px 30px;
            color: var(--wd-form-color);
            line-height: calc(var(--wd-form-height) - var(--wd-form-brd-width)*2)
        }

        body .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: inherit
        }

        body .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0;
            right: 0;
            height: var(--wd-form-height);
            width: 42px;
            background-image: var(--wd-form-chevron);
            background-position: right 50% top 50%;
            background-size: auto 18px;
            background-repeat: no-repeat
        }

        body .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none
        }

        body .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            top: calc(50% - 6px);
            inset-inline-end: 35px;
            font-size: 0;
            line-height: 1;
            z-index: 10
        }

        body .select2-container--default .select2-selection--single .select2-selection__clear:before {
            color: #bbb;
            font-weight: 400;
            font-size: 12px;
            content: "\f112";
            font-family: "woodmart-font"
        }

        body .select2-container--default .select2-selection--multiple {
            min-height: 42px
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: block;
            margin-bottom: 9px;
            padding: 0 15px
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
            margin-top: 9px;
            margin-inline-end: 10px;
            padding-block: 2px;
            padding-inline: 6px 8px;
            border: none;
            border-radius: 0;
            background-color: rgba(0, 0, 0, .05);
            color: var(--wd-form-color);
            font-weight: 600;
            font-size: 12px
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice__remove {
            margin-top: -4px;
            margin-inline-end: 4px;
            color: inherit;
            vertical-align: middle;
            font-weight: 400;
            font-size: 16px;
            line-height: 12px
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search--inline {
            display: inline-block;
            margin: 0;
            margin-top: 9px;
            line-height: 1
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search--inline:first-child {
            width: 100%
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search--inline input {
            height: auto;
            outline: none !important;
            font-size: 14px
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search--inline input[style="width: 0px;"] {
            width: 100% !important
        }

        body .select2-container--default .select2-search--dropdown {
            position: relative;
            padding: 18px;
            border-bottom: var(--wd-form-brd-width) solid var(--wd-form-brd-color);
            background-color: var(--wd-form-bg)
        }

        body .select2-container--default .select2-search--dropdown .select2-search__field {
            position: relative;
            z-index: 2;
            padding: 0 15px;
            height: 42px;
            border: var(--wd-form-brd-width) solid var(--wd-form-brd-color);
            background-color: var(--bgcolor-white);
            background-image: none;
            color: #767676
        }

        body .select2-container--default .select2-search--dropdown:before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, .05)
        }

        body .select2-container--default .select2-search--dropdown:after {
            position: absolute;
            top: calc(50% - 9px);
            z-index: 3;
            inset-inline-end: 30px;
            color: var(--color-gray-300);
            font-size: 18px;
            line-height: 1;
            content: "\f130";
            font-family: "woodmart-font"
        }

        body .select2-container--default .select2-results {
            background-color: var(--wd-form-bg)
        }

        body .select2-container--default .select2-dropdown {
            z-index: 1500;
            border-width: var(--wd-form-brd-width);
            border-color: var(--wd-form-brd-color);
            border-radius: 0;
            background-color: var(--bgcolor-white);
            color: var(--wd-form-color)
        }

        body .select2-container--default .select2-results__option {
            padding: 10px 18px;
            transition: all .1s ease
        }

        body .select2-container--default .select2-results__option:focus {
            outline: none
        }

        body .select2-container--default .select2-results__option[data-selected=true] {
            background-color: rgba(0, 0, 0, .05);
            color: var(--wd-form-color);
            font-weight: 600
        }

        body .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--wd-primary-color);
            color: #fff
        }

        body .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-width: var(--wd-form-brd-width);
            border-color: var(--wd-form-brd-color)
        }

        body .select2-results__options {
            --li-mb: 0
        }

        .form-style-underlined .select2-container--default .select2-selection {
            padding-inline: 0;
            border-top-style: none;
            border-right-style: none;
            border-left-style: none
        }

        .form-style-underlined .select2-container--default .select2-selection .select2-selection__arrow {
            width: 18px
        }

        .form-style-underlined .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-inline: 2px 15px;
            line-height: calc(var(--wd-form-height) - var(--wd-form-brd-width))
        }

        .form-style-underlined .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding-inline: 2px
        }

        .form-style-underlined .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-top: none;
            border-right: none;
            border-left: none
        }

        .form-style-underlined .select2-container--open .select2-dropdown--above {
            border-bottom-style: solid
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-lib-select2.css */
    </style>
    <style id='wd-woo-mod-shop-table-inline-css' type='text/css'>
        .shop_table tr :is(td, th):first-child {
            padding-inline-start: 0
        }

        .shop_table tr :is(td, th):last-child {
            padding-inline-end: 0;
            text-align: end
        }

        tr.cart_item .product-total>.amount {
            color: var(--wd-text-color);
            font-weight: 400
        }

        tr.order-total strong .amount {
            font-size: 1.3em
        }

        tr.order-total td strong {
            display: block
        }

        th:is(.product-remove, .product-thumbnail) {
            font-size: 0
        }

        th.product-name {
            text-align: start
        }

        th.product-thumbnail {
            width: 10px
        }

        th.product-remove {
            width: 40px
        }

        td.product-name {
            text-align: start
        }

        td.product-name a:not(:where(.button)) {
            text-decoration: none;
            --wd-link-decor: none;
            --wd-link-decor-hover: none;
            display: inline-block;
            color: var(--wd-entities-title-color);
            word-wrap: break-word;
            font-weight: var(--wd-entities-title-font-weight);
            font-style: var(--wd-entities-title-font-style);
            font-family: var(--wd-entities-title-font);
            text-transform: var(--wd-entities-title-transform);
            line-height: 1.4
        }

        td.product-name a:not(:where(.button)):hover {
            color: var(--wd-entities-title-color-hover)
        }

        td.product-name p {
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: .9em
        }

        td.product-name ul.variation {
            margin-top: 5px;
            width: 100%
        }

        td.product-sku {
            word-break: break-all
        }

        td.product-price>.amount {
            color: var(--wd-text-color);
            font-weight: 400
        }

        td.product-quantity input[type=text] {
            max-width: 80px;
            text-align: center
        }

        td.product-thumbnail>a {
            display: block;
            overflow: hidden
        }

        td.product-thumbnail img {
            min-width: 80px;
            max-width: 80px;
            border-radius: calc(var(--wd-brd-radius)/1.5)
        }

        td:is(.product-btn, .woocommerce-orders-table__cell-order-actions) a {
            padding: 5px 14px;
            min-height: 36px;
            font-size: 12px;
            border-radius: var(--btn-accented-brd-radius);
            color: var(--btn-accented-color);
            box-shadow: var(--btn-accented-box-shadow);
            background-color: var(--btn-accented-bgcolor);
            text-transform: var(--btn-accented-transform, var(--btn-transform, uppercase));
            font-weight: var(--btn-accented-font-weight, var(--btn-font-weight, 600));
            font-family: var(--btn-accented-font-family, var(--btn-font-family, inherit));
            font-style: var(--btn-accented-font-style, var(--btn-font-style, unset))
        }

        td:is(.product-btn, .woocommerce-orders-table__cell-order-actions) a:hover {
            color: var(--btn-accented-color-hover);
            box-shadow: var(--btn-accented-box-shadow-hover);
            background-color: var(--btn-accented-bgcolor-hover)
        }

        td:is(.product-btn, .woocommerce-orders-table__cell-order-actions) a:active {
            box-shadow: var(--btn-accented-box-shadow-active);
            bottom: var(--btn-accented-bottom-active, 0)
        }

        td:is(.product-btn, .woocommerce-orders-table__cell-order-actions) a.wd-disabled {
            opacity: .4;
            pointer-events: none
        }

        td.product-remove {
            padding: 0;
            text-align: center
        }

        .woocommerce-remove-coupon {
            margin-inline-end: -10px
        }

        td.product-remove a,
        .woocommerce-remove-coupon {
            --wd-link-color: var(--color-gray-800);
            --wd-link-color-hover: var(--color-gray-500);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            font-size: 0;
            text-decoration: none !important
        }

        td.product-remove a:before,
        .woocommerce-remove-coupon:before {
            font-size: calc(var(--wd-text-font-size, 14px)/1.2);
            content: "\f112";
            font-family: "woodmart-font"
        }

        @media(min-width: 769px) {
            td.product-quantity>span {
                display: inline-block;
                min-width: 80px;
                text-align: center
            }
        }

        @media(max-width: 768.98px) {
            .shop_table_responsive {
                display: block
            }

            .shop_table_responsive :is(thead, th) {
                display: none
            }

            .shop_table_responsive :is(tbody, tfoot) {
                display: block
            }

            .shop_table_responsive tr {
                position: relative;
                display: flex;
                flex-direction: column;
                gap: 5px;
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid var(--brdcolor-gray-300)
            }

            .shop_table_responsive tr:last-child {
                margin-bottom: 0
            }

            .shop_table_responsive td {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 5px;
                padding: 0;
                border-bottom: none
            }

            .shop_table_responsive td:not(:last-child) {
                padding-bottom: 5px;
                border-bottom: 1px dashed var(--brdcolor-gray-300)
            }

            .shop_table_responsive td:before {
                content: attr(data-title);
                margin-inline-end: auto
            }

            .shop_table_responsive .product-name a:first-child {
                margin-inline-end: 0 !important
            }

            .shop_table_responsive .product-name :is(.wd-product-detail, .variation) {
                margin-top: 0
            }

            .shop-table-with-img tr {
                padding-inline-start: 115px;
                min-height: 136px
            }

            .shop-table-with-img td:is(.product-thumbnail, .product-remove, .product-name):before {
                content: none
            }

            .shop-table-with-img td.product-thumbnail {
                position: absolute;
                top: 0;
                inset-inline-start: 0;
                overflow: hidden;
                max-height: 115px;
                border: none;
                border-radius: calc(var(--wd-brd-radius)/1.5)
            }

            .shop-table-with-img td.product-thumbnail img {
                min-width: 100px;
                max-width: 100px
            }

            .shop-table-with-img td.product-remove {
                position: absolute;
                top: -4px;
                inset-inline-end: -7px;
                z-index: 1;
                border: none
            }

            .shop-table-with-img td.product-name {
                padding-inline-end: 20px;
                border-bottom: none
            }

            .shop-table-with-img div.quantity {
                --wd-form-height: 30px
            }
        }

        /*# sourceURL=merchandise/wp-content/themes/woodmart/css/parts/woo-mod-shop-table.css */
    </style>
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
<script type="text/javascript"
        src="merchandise/wp-includes/js/jquery/jquery.min.js"
        id="jquery-core-js"></script>
<script type="text/javascript"
        src="merchandise/wp-content/plugins/woocommerce/assets/js/frontend/account-i18n.min.js"
        id="wc-account-i18n-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
        src="merchandise/wp-content/themes/woodmart/js/scripts/global/scrollBar.min.js"
        id="wd-scrollbar-js"></script>
<meta name="theme-color" content="rgb(245,245,245)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="icon"
        href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-45x45.png"
        sizes="32x32" />
    <link rel="icon"
        href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="wp-content/uploads/2021/06/cropped-woodmart-favicon-512px-290x290.png" />
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

            <main id="main-content" class="wd-content-layout content-layout-wrapper container wd-builder-on"
                role="main">
                <div class="wd-content-area site-content">
                    <div class="woocommerce entry-content">
                        <link rel="stylesheet" id="wd-mod-nav-vertical-css"
                            href="merchandise/wp-content/themes/woodmart/css/parts/mod-nav-vertical.css"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-mod-nav-vertical-design-simple-css"
                            href="merchandise/wp-content/themes/woodmart/css/parts/mod-nav-vertical-design-simple.css"
                            type="text/css" media="all" />
                        <style id="wd-style-blocks-1026-inline-css" data-type="wd-style-blocks-1026">
                            #wd-8a5cc588 {
                                margin-top: -40px;
                                margin-bottom: 40px;
                            }

                            #wd-db34d310 {
                                padding: 25px 30px 25px 30px;
                                background-color: #f5f5f5;
                                border-radius: 16px;
                                align-self: start;
                            }

                            @media (min-width: 769px) {
                                #wd-db34d310 {
                                    flex: 0 1 calc(25% - var(--wd-col-gap) * 1 / 2);
                                }

                                #wd-78bc329a {
                                    flex: 0 1 calc(75% - var(--wd-col-gap) * 1 / 2);
                                }
                            }

                            @media (min-width: 769px) and (max-width: 1024px) {
                                #wd-db34d310 {
                                    flex: 0 1 calc(35% - var(--wd-col-gap) * 1 / 2);
                                }

                                #wd-78bc329a {
                                    flex: 0 1 calc(65% - var(--wd-col-gap) * 1 / 2);
                                }
                            }

                            @media (max-width: 768.98px) {
                                #wd-db34d310 {
                                    padding: 15px 30px 15px 30px;
                                    border-width: 0px;
                                }

                                #wd-e3644b91 {
                                    --wd-col-gap: 20px;
                                }
                            }
                        </style>
                        <link rel="stylesheet" id="wd-el-page-title-builder-css"
                            href="merchandise/wp-content/themes/woodmart/css/parts/el-page-title-builder.css"
                            type="text/css" media="all" />
                        <div id="wd-8a5cc588" class="wd-page-title-el wd-8a5cc588 wd-stretched">
                            <link rel="stylesheet" id="wd-page-title-css"
                                href="merchandise/wp-content/themes/woodmart/css/parts/page-title.css"
                                type="text/css" media="all" />
                            <div class="wd-page-title page-title  page-title-default title-size-small title-design-centered color-scheme-default"
                                style="">
                                <div class="wd-page-title-bg wd-fill">
                                </div>
                                <div class="container">
                                    <h1 class="entry-title title">
                                        My account </h1>

                                    <nav class="wd-breadcrumbs"><a
                                            href="{{ route('home') }}">Home</a><span
                                            class="wd-delimiter">/</span><span class="wd-last">My account</span></nav>
                                </div>
                            </div>
                        </div>

                        <div id="wd-e3644b91" class="wp-block-wd-row">
                            <div id="wd-db34d310" class="wp-block-wd-column wd-align-s-start">
                                <div id="wd-6aee5deb" class="wd-el-my-acc-nav wd-6aee5deb">

                                    <nav class="woocommerce-MyAccount-navigation" aria-label="Account pages">
                                        <ul
                                            class="wd-nav-my-acc wd-nav wd-nav-vertical wd-design-simple wd-gap-m wd-icon-left">
                                            <li
                                                class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard is-active wd-my-acc-dashboard wd-active">
                                                <a href="{{ route('dashboard') }}"
                                                    aria-current="page">
                                                    <span class="wd-nav-icon"></span>
                                                    <span class="nav-link-text">
                                                        Dashboard </span>
                                                </a>
                                            </li>
                                            <li
                                                class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders wd-my-acc-orders">
                                                <a href="{{ route('dashboard') }}#orders">
                                                    <span class="wd-nav-icon"></span>
                                                    <span class="nav-link-text">
                                                        Orders </span>
                                                </a>
                                            </li>
                                            <li
                                                class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account wd-my-acc-edit-account">
                                                <a href="{{ route('dashboard') }}#account-details">
                                                    <span class="wd-nav-icon"></span>
                                                    <span class="nav-link-text">
                                                        Account details </span>
                                                </a>
                                            </li>
                                            <li
                                                class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--wishlist wd-my-acc-wishlist">
                                                <a href="{{ route('wishlist') }}">
                                                    <span class="wd-nav-icon"></span>
                                                    <span class="nav-link-text">
                                                        Wishlist </span>
                                                </a>
                                            </li>
                                            <li
                                                class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout wd-my-acc-customer-logout">
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <span class="wd-nav-icon"></span>
                                                    <span class="nav-link-text">
                                                        Logout </span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                                            </li>
                                        </ul>
                                    </nav>

                                </div>
                            </div>

                            <div id="wd-78bc329a" class="wp-block-wd-column">
                                <div id="wd-9020d6b2"
                                    class="wd-el-my-acc-content wd-9020d6b2 woocommerce-MyAccount-content">
                                    <div class="woocommerce-notices-wrapper"></div>
                                    <p>
                                        Hello <strong>{{ $authUser->name ?? 'Guest' }}</strong> (not <strong>{{ $authUser->name ?? '' }}</strong>? <a
                                            href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log
                                            out</a>)</p>

                                    <p>
                                        From your account dashboard you can view your <a
                                            href="{{ route('dashboard') }}#orders">recent
                                            orders</a>, manage your <a
                                            href="{{ route('dashboard') }}">shipping
                                            and billing addresses</a>, and <a
                                            href="{{ route('dashboard') }}">edit
                                            your password and account details</a>.</p>

                                    {{-- Dashboard Stats --}}
                                    <div id="dashboard-stats" style="margin-top: 20px;">
                                        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
                                            <div style="flex:1; min-width: 200px; padding: 20px; background: #f5f5f5; border-radius: 12px; text-align: center;">
                                                <div style="font-size: 28px; font-weight: 600; color: var(--wd-primary-color);" id="stat-total-orders">0</div>
                                                <div style="color: #767676; font-size: 14px; margin-top: 5px;">Total Orders</div>
                                            </div>
                                            <div style="flex:1; min-width: 200px; padding: 20px; background: #f5f5f5; border-radius: 12px; text-align: center;">
                                                <div style="font-size: 28px; font-weight: 600; color: var(--wd-primary-color);" id="stat-total-spent">TK 0</div>
                                                <div style="color: #767676; font-size: 14px; margin-top: 5px;">Total Spent</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Recent Orders --}}
                                    <div id="orders" style="margin-top: 20px;">
                                        <h3 style="margin-bottom: 15px;">Recent Orders</h3>
                                        <div id="orders-loading" style="text-align:center; padding: 30px; color: #767676;">
                                            Loading orders...
                                        </div>
                                        <div id="orders-empty" style="display:none; text-align:center; padding: 30px; color: #767676;">
                                            <p>No orders yet.</p>
                                            <a href="{{ route('all-products') }}" class="button btn btn-accent" >Browse Products</a>
                                        </div>
                                        <div id="orders-table-wrap" style="display:none;">
                                            <table class="woocommerce-orders-table shop_table shop_table_responsive" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="orders-tbody"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Account Details --}}
                                    <div id="account-details" style="margin-top: 40px; max-width: 480px;">
                                        <h3 style="margin-bottom: 15px;">Account Details</h3>
                                        <div id="account-details-msg" style="display:none; margin-bottom: 15px; padding: 12px 16px; border-radius: 8px; font-size: 14px;"></div>
                                        <form id="account-details-form">
                                            @csrf
                                            <p class="form-row form-row-first">
                                                <label for="acc-name">Name <span class="required">*</span></label>
                                                <input type="text" class="input-text" id="acc-name" name="name" value="{{ $authUser->name ?? '' }}" required />
                                            </p>
                                            <p class="form-row form-row-last">
                                                <label for="acc-email">Email address <span class="required">*</span></label>
                                                <input type="email" class="input-text" id="acc-email" name="email" value="{{ $authUser->email ?? '' }}" required />
                                            </p>
                                            <p class="form-row form-row-wide">
                                                <label for="acc-phone">Phone</label>
                                                <input type="text" class="input-text" id="acc-phone" name="phone" value="{{ $authUser->phone ?? '' }}" />
                                            </p>

                                            <fieldset style="border: none; padding: 0; margin: 25px 0 0;">
                                                <legend style="font-size: 15px; font-weight: 600; margin-bottom: 10px; padding: 0;">Password change</legend>
                                                <p style="color:#767676; font-size:13px; margin-bottom:15px;">Leave blank to keep your current password.</p>
                                                <p class="form-row form-row-first">
                                                    <label for="acc-current-password">Current password</label>
                                                    <input type="password" class="input-text" id="acc-current-password" name="current_password" autocomplete="current-password" />
                                                </p>
                                                <p class="form-row form-row-last">
                                                    <label for="acc-new-password">New password</label>
                                                    <input type="password" class="input-text" id="acc-new-password" name="new_password" autocomplete="new-password" />
                                                </p>
                                                <p class="form-row form-row-wide">
                                                    <label for="acc-new-password-confirm">Confirm new password</label>
                                                    <input type="password" class="input-text" id="acc-new-password-confirm" name="new_password_confirmation" autocomplete="new-password" />
                                                </p>
                                            </fieldset>

                                            <p class="form-row">
                                                <button type="submit" id="account-details-submit" class="button btn btn-accent">Save changes</button>
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const email = @json($authUser->email ?? '');
    const phone = @json($authUser->phone ?? '');
    if (!email && !phone) {
        document.getElementById('orders-loading').style.display = 'none';
        document.getElementById('orders-empty').style.display = 'block';
        return;
    }

    const params = new URLSearchParams();
    if (email) params.set('email', email);
    if (phone) params.set('phone', phone);

    fetch("{{ route('dashboard.data') }}?" + params.toString(), {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('orders-loading').style.display = 'none';

        // Stats
        document.getElementById('stat-total-orders').textContent = data.stats?.total_orders ?? 0;
        document.getElementById('stat-total-spent').textContent = 'TK ' + (data.stats?.total_spent ?? 0).toLocaleString();

        // Orders
        const orders = data.orders || [];
        if (orders.length === 0) {
            document.getElementById('orders-empty').style.display = 'block';
            return;
        }

        document.getElementById('orders-table-wrap').style.display = 'block';
        const tbody = document.getElementById('orders-tbody');
        const statusColors = {
            pending: '#E0B252', confirmed: '#3B82F6', processing: '#8B5CF6',
            shipped: '#06B6D4', delivered: '#459647', cancelled: '#EF4444', returned: '#6B7280'
        };

        orders.forEach(o => {
            const color = statusColors[o.status] || '#767676';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td data-title="Order"><strong>#${o.order_no}</strong></td>
                <td data-title="Date">${o.date}</td>
                <td data-title="Status"><span style="color:${color}; font-weight:600; text-transform:capitalize;">${o.status}</span></td>
                <td data-title="Total"><span class="amount">TK ${o.total.toLocaleString()}</span> (${o.items.length} item${o.items.length > 1 ? 's' : ''})</td>
                <td data-title="Actions"><a href="{{ route('track-order') }}?id=${o.order_no}" class="button btn btn-accent" style="padding:5px 14px; min-height:36px; font-size:12px;">View</a></td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(() => {
        document.getElementById('orders-loading').textContent = 'Failed to load data.';
    });

    // ── Account details form ──────────────────────────────────────
    const accForm   = document.getElementById('account-details-form');
    const accMsg    = document.getElementById('account-details-msg');
    const accSubmit = document.getElementById('account-details-submit');

    function showAccMsg(text, ok) {
        accMsg.textContent = text;
        accMsg.style.display = 'block';
        accMsg.style.background = ok ? '#e9f7ef' : '#fdecea';
        accMsg.style.color = ok ? '#1e7e34' : '#c9401d';
    }

    function clearFieldErrors() {
        accForm.querySelectorAll('.gms-field-error').forEach(el => el.remove());
    }

    function showFieldErrors(errors) {
        clearFieldErrors();
        Object.keys(errors).forEach(field => {
            const input = accForm.querySelector(`[name="${field}"]`);
            if (!input) return;
            const small = document.createElement('small');
            small.className = 'gms-field-error';
            small.style.color = '#c9401d';
            small.style.display = 'block';
            small.style.marginTop = '4px';
            small.textContent = errors[field][0];
            input.insertAdjacentElement('afterend', small);
        });
    }

    accForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearFieldErrors();
        accMsg.style.display = 'none';
        accSubmit.disabled = true;
        accSubmit.textContent = 'Saving...';

        const fd = new FormData(accForm);
        const payload = Object.fromEntries(fd.entries());

        fetch("{{ route('dashboard.account.update') }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                if (res.status === 422 && data.errors) {
                    showFieldErrors(data.errors);
                    showAccMsg('Please fix the errors below.', false);
                } else {
                    showAccMsg(data.message || 'Something went wrong.', false);
                }
                return;
            }
            showAccMsg(data.message || 'Account details updated.', true);
            accForm.querySelector('#acc-current-password').value = '';
            accForm.querySelector('#acc-new-password').value = '';
            accForm.querySelector('#acc-new-password-confirm').value = '';
        })
        .catch(() => showAccMsg('Something went wrong. Please try again.', false))
        .finally(() => {
            accSubmit.disabled = false;
            accSubmit.textContent = 'Save changes';
        });
    });
});
</script>
@endsection
