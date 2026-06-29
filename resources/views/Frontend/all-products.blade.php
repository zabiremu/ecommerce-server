@extends('Frontend.Layout.app')

@section('content')
<div class="wd-page-content main-page-wrapper">

			<link rel="stylesheet" id="wd-page-title-css"
				href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/page-title.css') }}"
				type="text/css" media="all" />
			<div class="wd-page-title page-title  page-title-default title-size-small title-design-centered color-scheme-default"
				style="">
				<div class="wd-page-title-bg wd-fill">
				</div>
				<div class="container">
					<div class="wd-title-wrapp">

						<h1 class="entry-title title">
							Shop </h1>

					</div>

				</div>
			</div>

			<main id="main-content"
				class="wd-content-layout content-layout-wrapper container wd-grid-g wd-sidebar-hidden-md-sm wd-sidebar-hidden-sm wd-builder-off"
				role="main" style="--wd-col-lg:12;--wd-gap-lg:30px;--wd-gap-sm:20px;">

				<link rel="stylesheet" id="wd-off-canvas-sidebar-critical-css"
					href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/opt-off-canvas-sidebar-critical.css') }}"
					type="text/css" media="all" />
				<aside class="wd-sidebar sidebar-container wd-grid-col sidebar-left"
					style="--wd-col-lg:3;--wd-col-md:12;--wd-col-sm:12;">
					<div class="wd-heading">
						<div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon">
							<a href="#" rel="nofollow noopener">
								<span class="wd-action-icon"></span>
								<span class="wd-action-text">
									Close </span>
							</a>
						</div>
					</div>
					<div class="widget-area">
						<link rel="stylesheet" id="wd-widget-general-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/widget-general.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-widget-wd-layered-nav-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-widget-wd-layered-nav.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-mod-swatches-base-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-swatches-base.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-mod-swatches-filter-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-swatches-filter.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-widget-slider-price-filter-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-widget-slider-price-filter.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-filter-search-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/mod-filter-search.css') }}"
							type="text/css" media="all" />
						<div id="woodmart-woocommerce-layered-nav-2"
							class="wd-widget widget sidebar-widget woodmart-woocommerce-layered-nav">
							<h5 class="widget-title">Franchise</h5>
							<link rel="stylesheet" id="wd-woo-mod-swatches-style-1-css"
								href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-swatches-style-1.css') }}"
								type="text/css" media="all" />
							<div class="wd-filter-wrapper">
								<div class="wd-filter-search wd-search">
									<input type="text" placeholder="Find a Franchise" aria-label="Find a Franchise">
									<span class="wd-filter-search-clear wd-action-btn wd-style-icon wd-cross-icon">
										<a href="#" aria-label="Clear search"><span class="wd-action-icon"></span></a>
									</span>
								</div>
								<div class="wd-scroll">
									<ul
										class="wd-swatches-filter wd-filter-list wd-labels-on wd-size-normal wd-layout-list wd-text-style-1 wd-bg-style-1 wd-shape-round wd-scroll-content">
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Astro Bot"><span
													class="wd-filter-lable layer-term-lable">Astro Bot</span></a> <span
												class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Back to the Future"><span
													class="wd-filter-lable layer-term-lable">Back to the
													Future</span></a> <span class="count">4</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Borderlands"><span
													class="wd-filter-lable layer-term-lable">Borderlands</span></a>
											<span class="count">4</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Control"><span
													class="wd-filter-lable layer-term-lable">Control</span></a> <span
												class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link"
												aria-label="Filter by Deadpool &amp; Wolverine"><span
													class="wd-filter-lable layer-term-lable">Deadpool &amp;
													Wolverine</span></a> <span class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Dune"><span
													class="wd-filter-lable layer-term-lable">Dune</span></a> <span
												class="count">4</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Fallout"><span
													class="wd-filter-lable layer-term-lable">Fallout</span></a> <span
												class="count">6</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Final Fantasy"><span
													class="wd-filter-lable layer-term-lable">Final Fantasy</span></a>
											<span class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Friends"><span
													class="wd-filter-lable layer-term-lable">Friends</span></a> <span
												class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by God Of War"><span
													class="wd-filter-lable layer-term-lable">God Of War</span></a> <span
												class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Hollow Knight"><span
													class="wd-filter-lable layer-term-lable">Hollow Knight</span></a>
											<span class="count">4</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Huntdown"><span
													class="wd-filter-lable layer-term-lable">Huntdown</span></a> <span
												class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by League of Legends"><span
													class="wd-filter-lable layer-term-lable">League of
													Legends</span></a> <span class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Marvel"><span
													class="wd-filter-lable layer-term-lable">Marvel</span></a> <span
												class="count">1</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Mass Effect"><span
													class="wd-filter-lable layer-term-lable">Mass Effect</span></a>
											<span class="count">4</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Minecraft"><span
													class="wd-filter-lable layer-term-lable">Minecraft</span></a> <span
												class="count">7</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Pokémon"><span
													class="wd-filter-lable layer-term-lable">Pokémon</span></a> <span
												class="count">3</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Portal"><span
													class="wd-filter-lable layer-term-lable">Portal</span></a> <span
												class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link"
												aria-label="Filter by Red Dead Redemption"><span
													class="wd-filter-lable layer-term-lable">Red Dead
													Redemption</span></a> <span class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Retro Consoles"><span
													class="wd-filter-lable layer-term-lable">Retro Consoles</span></a>
											<span class="count">10</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Spider-Man"><span
													class="wd-filter-lable layer-term-lable">Spider-Man</span></a> <span
												class="count">3</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Star Wars"><span
													class="wd-filter-lable layer-term-lable">Star Wars</span></a> <span
												class="count">8</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Stardew Valley"><span
													class="wd-filter-lable layer-term-lable">Stardew Valley</span></a>
											<span class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Super Mario"><span
													class="wd-filter-lable layer-term-lable">Super Mario</span></a>
											<span class="count">5</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by The Last of Us"><span
													class="wd-filter-lable layer-term-lable">The Last of Us</span></a>
											<span class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link"
												aria-label="Filter by The Legend of Zelda"><span
													class="wd-filter-lable layer-term-lable">The Legend of
													Zelda</span></a> <span class="count">7</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link"
												aria-label="Filter by The Lord of the Rings"><span
													class="wd-filter-lable layer-term-lable">The Lord of the
													Rings</span></a> <span class="count">5</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by The Witcher"><span
													class="wd-filter-lable layer-term-lable">The Witcher</span></a>
											<span class="count">2</span></li>
										<li class="wc-layered-nav-term"><a rel="nofollow noopener"
												href="products.html"
												class="layered-nav-link" aria-label="Filter by Xbox"><span
													class="wd-filter-lable layer-term-lable">Xbox</span></a> <span
												class="count">1</span></li>
									</ul>
								</div>
							</div>
						</div>

						<div id="woodmart-woocommerce-layered-nav-4"
							class="wd-widget widget sidebar-widget woodmart-woocommerce-layered-nav">
							<h5 class="widget-title">Size</h5>
							<link rel="stylesheet" id="wd-woo-mod-swatches-style-4-css"
								href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-swatches-style-4.css') }}"
								type="text/css" media="all" />
							<div class="wd-scroll">
								<ul
									class="wd-swatches-filter wd-filter-list wd-labels-on wd-size-normal wd-layout-list wd-text-style-1 wd-bg-style-4 wd-shape-round wd-scroll-content">
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by A2"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">A2</span></span><span
												class="wd-filter-lable layer-term-lable">A2</span></a> <span
											class="count">12</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by A3"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">A3</span></span><span
												class="wd-filter-lable layer-term-lable">A3</span></a> <span
											class="count">12</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by A4"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">A4</span></span><span
												class="wd-filter-lable layer-term-lable">A4</span></a> <span
											class="count">12</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by L"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">L</span></span><span
												class="wd-filter-lable layer-term-lable">L</span></a> <span
											class="count">9</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by M"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">M</span></span><span
												class="wd-filter-lable layer-term-lable">M</span></a> <span
											class="count">14</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by S"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">S</span></span><span
												class="wd-filter-lable layer-term-lable">S</span></a> <span
											class="count">12</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by XS"><span
												class="wd-swatch wd-text"><span
													class="wd-swatch-text">XS</span></span><span
												class="wd-filter-lable layer-term-lable">XS</span></a> <span
											class="count">5</span></li>
								</ul>
							</div>
						</div>
						<div id="woodmart-woocommerce-layered-nav-3"
							class="wd-widget widget sidebar-widget woodmart-woocommerce-layered-nav">
							<h5 class="widget-title">Color</h5>
							<div class="wd-scroll">
								<ul
									class="wd-swatches-filter wd-filter-list wd-labels-on wd-size-normal wd-layout-list wd-text-style-1 wd-bg-style-4 wd-shape-round wd-scroll-content">
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Black"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(28,28,28);"></span><span
													class="wd-swatch-text">Black</span></span><span
												class="wd-filter-lable layer-term-lable">Black</span></a> <span
											class="count">15</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Blue"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(24,75,212);"></span><span
													class="wd-swatch-text">Blue</span></span><span
												class="wd-filter-lable layer-term-lable">Blue</span></a> <span
											class="count">4</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Gray"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(161,161,161);"></span><span
													class="wd-swatch-text">Gray</span></span><span
												class="wd-filter-lable layer-term-lable">Gray</span></a> <span
											class="count">3</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Green"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(134,214,105);"></span><span
													class="wd-swatch-text">Green</span></span><span
												class="wd-filter-lable layer-term-lable">Green</span></a> <span
											class="count">2</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Navy"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(0,0,104);"></span><span
													class="wd-swatch-text">Navy</span></span><span
												class="wd-filter-lable layer-term-lable">Navy</span></a> <span
											class="count">4</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Pink"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(255,141,161);"></span><span
													class="wd-swatch-text">Pink</span></span><span
												class="wd-filter-lable layer-term-lable">Pink</span></a> <span
											class="count">1</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Red"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(212,40,40);"></span><span
													class="wd-swatch-text">Red</span></span><span
												class="wd-filter-lable layer-term-lable">Red</span></a> <span
											class="count">1</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Sand"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(203,189,147);"></span><span
													class="wd-swatch-text">Sand</span></span><span
												class="wd-filter-lable layer-term-lable">Sand</span></a> <span
											class="count">2</span></li>
									<li class="wc-layered-nav-term wd-swatch-wrap"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by White"><span
												class="wd-swatch wd-bg wd-tooltip"><span class="wd-swatch-bg"
													style="background-color: rgb(243,243,243);"></span><span
													class="wd-swatch-text">White</span></span><span
												class="wd-filter-lable layer-term-lable">White</span></a> <span
											class="count">4</span></li>
								</ul>
							</div>
						</div>
						<div id="woodmart-woocommerce-layered-nav-5"
							class="wd-widget widget sidebar-widget woodmart-woocommerce-layered-nav">
							<h5 class="widget-title">Brand</h5>
							<div class="wd-scroll">
								<ul
									class="wd-swatches-filter wd-filter-list wd-labels-on wd-size-normal wd-layout-list wd-text-style-1 wd-swatches-brands wd-scroll-content">
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by 8-Bit Legends"><span
												class="wd-filter-lable layer-term-lable">8-Bit Legends</span></a> <span
											class="count">16</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Crafter Designs"><span
												class="wd-filter-lable layer-term-lable">Crafter Designs</span></a>
										<span class="count">6</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by GameVault"><span
												class="wd-filter-lable layer-term-lable">GameVault</span></a> <span
											class="count">13</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by HeroCraft Studios"><span
												class="wd-filter-lable layer-term-lable">HeroCraft Studios</span></a>
										<span class="count">28</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by LootVerse Merch"><span
												class="wd-filter-lable layer-term-lable">LootVerse Merch</span></a>
										<span class="count">8</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by Power-Up"><span
												class="wd-filter-lable layer-term-lable">Power-Up</span></a> <span
											class="count">1</span></li>
									<li class="wc-layered-nav-term"><a rel="nofollow noopener"
											href="products.html"
											class="layered-nav-link" aria-label="Filter by ScreenPlay Goods"><span
												class="wd-filter-lable layer-term-lable">ScreenPlay Goods</span></a>
										<span class="count">24</span></li>
								</ul>
							</div>
						</div>
					</div>
				</aside>

				<div class="wd-content-area site-content wd-grid-col"
					style="--wd-col-lg:9;--wd-col-md:12;--wd-col-sm:12;">
					<div class="woocommerce-notices-wrapper"></div>

					<div class="shop-loop-head">
						<div class="wd-shop-tools">
							<nav class="wd-breadcrumbs woocommerce-breadcrumb" aria-label="Breadcrumb"> <a
									href="index.htmlmerchandise" class="wd-last-link">
									Home </a>
								<span class="wd-delimiter">/</span> <span class="wd-last">
									Shop </span>
							</nav>
							<p class="woocommerce-result-count" role="alert" aria-relevant="all"
								data-is-sorted-by="true">
								Showing 1&ndash;16 of 96 results<span class="screen-reader-text">Sorted by latest</span>
							</p>
						</div>
						<div class="wd-shop-tools">
							<div class="wd-show-sidebar-btn wd-action-btn wd-style-text wd-burger-icon">
								<a href="#" rel="nofollow">
									<span class="wd-action-icon"></span>
									<span class="wd-action-text">
										Show sidebar </span>
								</a>
							</div>

							<div class="wd-products-per-page">
								<span class="wd-label per-page-title">
									Show </span>

								<a rel="nofollow noopener"
									href="products.html"
									class="per-page-variation">
									<span>
										9 </span>
								</a>
								<span class="per-page-border"></span>
								<a rel="nofollow noopener"
									href="products.html"
									class="per-page-variation">
									<span>
										12 </span>
								</a>
								<span class="per-page-border"></span>
								<a rel="nofollow noopener"
									href="products.html"
									class="per-page-variation">
									<span>
										18 </span>
								</a>
								<span class="per-page-border"></span>
								<a rel="nofollow noopener"
									href="products.html"
									class="per-page-variation">
									<span>
										24 </span>
								</a>
								<span class="per-page-border"></span>
							</div>
							<div class="wd-products-shop-view products-view-grid">

								<a rel="nofollow noopener"
									href="products.html"
									class="shop-view per-row-2" aria-label="Grid view 2"></a>

								<a rel="nofollow noopener"
									href="products.html"
									class="shop-view per-row-3" aria-label="Grid view 3"></a>

								<a rel="nofollow noopener"
									href="products.html"
									class="shop-view current-variation per-row-4" aria-label="Grid view 4"></a>
							</div>
							<form class="woocommerce-ordering wd-style-underline wd-ordering-mb-icon" method="get">
								<select name="orderby" class="orderby" aria-label="Shop order">
									<option value="menu_order">Default sorting</option>
									<option value="popularity">Sort by popularity</option>
									<option value="rating">Sort by average rating</option>
									<option value="date" selected='selected'>Sort by latest</option>
									<option value="price">Sort by price: low to high</option>
									<option value="price-desc">Sort by price: high to low</option>
								</select>
								<input type="hidden" name="paged" value="1" />
							</form>
						</div>
					</div>

					<div class="wd-products-element">
						<link rel="stylesheet" id="wd-woo-categories-loop-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-categories-loop-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop-old.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-product-loop-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-loop-prod-el-base-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-el-base.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-loop-prod-predefined-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-predefined.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-product-loop-quick-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop-quick.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-mod-loop-prod-add-btn-replace-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-loop-prod-add-btn-replace.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-opt-title-limit-predefined-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-title-limit-predefined.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-opt-stretch-cont-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-woo-opt-stretch-cont-predefined-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont-predefined.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-bordered-product-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product.css') }}"
							type="text/css" media="all" />
						<link rel="stylesheet" id="wd-bordered-product-predefined-css"
							href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product-predefined.css') }}"
							type="text/css" media="all" />
						<div class="wd-sticky-loader wd-deferred wd-content-loader"><span class="wd-loader"></span>
						</div>

						<div class="products wd-products wd-grid-g grid-columns-4 elements-grid pagination-pagination wd-loop-builder-off title-line-one wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins"
							data-source="main_loop" data-min_price="" data-max_price="" data-columns="4"
							style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-462 status-publish instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="1" data-id="462">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Dogpool Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" fetchpriority="high"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-150x171.jpeg') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush.jpeg.webp') }} 700w"
												sizes="(max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-263x300.jpeg') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1.jpeg.webp') }} 700w"
												sizes="(max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<link rel="stylesheet" id="wd-mod-animations-transform-css"
												href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/mod-animations-transform.css') }}"
												type="text/css" media="all" />
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="462">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="462" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=462"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="462" data-product_sku="GM-PL-12"
												aria-label="Add to cart: &ldquo;Dogpool Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Dogpool Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Dogpool
												Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>19,40</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-461 status-publish instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="2" data-id="461">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Liara Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="461">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="461" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=461"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="461" data-product_sku="GM-PL-11"
												aria-label="Add to cart: &ldquo;Liara Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Liara Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Liara
												Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>27,95</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-460 status-publish last instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="3" data-id="460">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Plush Traveling Korok">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-600x686.jpeg') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-600x686.jpeg') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-150x171.jpeg') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="460">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="460" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=460"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="460" data-product_sku="GM-PL-10"
												aria-label="Add to cart: &ldquo;Plush Traveling Korok&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Plush Traveling Korok&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Plush
												Traveling Korok</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>34,50</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-459 status-publish first instock product_cat-plushes has-post-thumbnail sale shipping-taxable purchasable product-type-simple"
								data-loop="4" data-id="459">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Grogu Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<link rel="stylesheet" id="wd-woo-mod-product-labels-default-css"
											href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-product-labels-default.css') }}"
											type="text/css" media="all" />
										<link rel="stylesheet" id="wd-woo-mod-product-labels-css"
											href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-product-labels.css') }}"
											type="text/css" media="all" />
										<div class="product-labels labels-rounded-sm">
											<span class="onsale product-label wd-shape-round-sm">-38%</span>
										</div>
										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="459">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="459" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=459"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="459" data-product_sku="GM-PL-9"
												aria-label="Add to cart: &ldquo;Grogu Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Grogu Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Grogu
												Plush</a></h3>

										<span class="price"><del aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>39,99</bdi></span></del>
											<span class="screen-reader-text">Original price was: &#036;39,99.</span><ins
												aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>24,98</bdi></span></ins><span
												class="screen-reader-text">Current price is: &#036;24,98.</span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-458 status-publish instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="5" data-id="458">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Dune Desert Mouse Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="458">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="458" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=458"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="458" data-product_sku="GM-PL-8"
												aria-label="Add to cart: &ldquo;Dune Desert Mouse Plush&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Dune Desert Mouse Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Dune
												Desert Mouse Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>28,48</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-457 status-publish instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="6" data-id="457">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Yoshi Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="457">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="457" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=457"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="457" data-product_sku="GM-PL-7"
												aria-label="Add to cart: &ldquo;Yoshi Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Yoshi Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Yoshi
												Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>20,48</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-456 status-publish last instock product_cat-plushes has-post-thumbnail sale shipping-taxable purchasable product-type-simple"
								data-loop="7" data-id="456">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Vault Boy Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="product-labels labels-rounded-sm">
											<span class="onsale product-label wd-shape-round-sm">-39%</span>
										</div>
										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="456">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="456" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=456"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="456" data-product_sku="GM-PL-6"
												aria-label="Add to cart: &ldquo;Vault Boy Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Vault Boy Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Vault
												Boy Plush</a></h3>

										<span class="price"><del aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>29,99</bdi></span></del>
											<span class="screen-reader-text">Original price was: &#036;29,99.</span><ins
												aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>18,20</bdi></span></ins><span
												class="screen-reader-text">Current price is: &#036;18,20.</span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-427 status-publish first instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="8" data-id="427">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Claptrap Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="427">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="427" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=427"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="427" data-product_sku="GM-PL-5"
												aria-label="Add to cart: &ldquo;Claptrap Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Claptrap Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Claptrap
												Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>29,99</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-426 status-publish instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="9" data-id="426">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Ciri Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="426">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="426" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=426"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="426" data-product_sku="GM-PL-4"
												aria-label="Add to cart: &ldquo;Ciri Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Ciri Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Ciri
												Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>29,99</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-425 status-publish instock product_cat-plushes has-post-thumbnail sale shipping-taxable purchasable product-type-simple"
								data-loop="10" data-id="425">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Chicken Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="product-labels labels-rounded-sm">
											<span class="onsale product-label wd-shape-round-sm">-29%</span>
										</div>
										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-263x300.jpeg') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1.jpeg') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="425">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="425" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=425"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="425" data-product_sku="GM-PL-3"
												aria-label="Add to cart: &ldquo;Chicken Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Chicken Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Chicken
												Plush</a></h3>

										<span class="price"><del aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>40,00</bdi></span></del>
											<span class="screen-reader-text">Original price was: &#036;40,00.</span><ins
												aria-hidden="true"><span
													class="woocommerce-Price-amount amount"><bdi><span
															class="woocommerce-Price-currencySymbol">&#36;</span>28,47</bdi></span></ins><span
												class="screen-reader-text">Current price is: &#036;28,47.</span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-424 status-publish last instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="11" data-id="424">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Companion Cube Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="424">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="424" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=424"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="424" data-product_sku="GM-PL-2"
												aria-label="Add to cart: &ldquo;Companion Cube Plush&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Companion Cube Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Companion
												Cube Plush</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>14,58</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-423 status-publish first instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="12" data-id="423">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Astro Bot Plush">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-150x171.jpeg') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="423">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="423" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=423"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="423" data-product_sku="GM-PL-1"
												aria-label="Add to cart: &ldquo;Astro Bot Plush&rdquo;" rel="nofollow"
												data-success_message="&ldquo;Astro Bot Plush&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Astro
												Bot Plush</a></h3>

										<div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
											<span style="width:80%">
												Rated <strong class="rating">4.00</strong> out of 5 </span>
										</div>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>12,99</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-422 status-publish instock product_cat-figures has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="13" data-id="422">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Minecraft Creeper Vinyl Figure">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="422">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="422" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=422"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="422" data-product_sku="GM-FG-12"
												aria-label="Add to cart: &ldquo;Minecraft Creeper Vinyl Figure&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Minecraft Creeper Vinyl Figure&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Minecraft
												Creeper Vinyl Figure</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>32,95</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-421 status-publish instock product_cat-figures has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="14" data-id="421">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Super Mario Figures">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-600x686.jpeg') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-600x686.jpeg') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="421">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="421" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=421"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="421" data-product_sku="GM-FG-11"
												aria-label="Add to cart: &ldquo;Super Mario Figures&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Super Mario Figures&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Super
												Mario Figures</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>14,99</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-420 status-publish last instock product_cat-figures has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="15" data-id="420">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Marty Mcfly Figure">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="420">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="420" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=420"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="420" data-product_sku="GM-FG-10"
												aria-label="Add to cart: &ldquo;Marty Mcfly Figure&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Marty Mcfly Figure&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Marty
												Mcfly Figure</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>39,99</bdi></span></span>

									</div>
								</div>
							</div>

							<div class="wd-product wd-col wd-hover-quick product-grid-item product type-product post-387 status-publish first instock product_cat-figures has-post-thumbnail shipping-taxable purchasable product-type-simple"
								data-loop="16" data-id="387">

								<div class="wd-product-wrapper product-wrapper">
									<div class="wd-product-thumb product-element-top wd-quick-shop">
										<a href="product_details.html"
											class="wd-product-img-link product-image-link" tabindex="-1"
											aria-label="Frodo Baggins Figure">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" /> </a>

										<div class="wd-product-img-hover hover-img">
											<img width="430" height="492"
												src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-600x686.jpeg.webp') }}"
												class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
												alt="" decoding="async" loading="lazy"
												srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-600x686.jpeg.webp') }} 600w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-263x300.jpeg.webp') }} 263w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-88x100.jpeg.webp') }} 88w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-150x171.jpeg.webp') }} 150w,  {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1.jpeg.webp') }} 700w"
												sizes="auto, (max-width: 430px) 100vw, 430px" />
										</div>
										<div class="wd-buttons wd-pos-r-t">
											<div
												class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
												<a href="product_details.html"
													class="open-quick-view" rel="nofollow" data-id="387">
													<span class="wd-action-icon"></span>
													<span class="wd-action-text">
														Quick view </span>
												</a>
											</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
												<a class="" href="wishtlist.html"
													data-key="d5b554e37e" data-product-id="387" rel="nofollow">
													<span class="wd-action-icon">
														<span class="wd-check-icon"></span>
													</span>
													<span class="wd-action-text">Add to wishlist</span>
												</a>
											</div>
										</div>

										<div class="wd-add-btn wd-add-btn-replace">

											<a href="/merchandise/shop/?orderby=date&#038;add-to-cart=387"
												data-quantity="1"
												class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
												data-product_id="387" data-product_sku="GM-FG-9"
												aria-label="Add to cart: &ldquo;Frodo Baggins Figure&rdquo;"
												rel="nofollow"
												data-success_message="&ldquo;Frodo Baggins Figure&rdquo; has been added to your cart"
												role="button"><span class="wd-action-icon"><span
														class="wd-check-icon"></span></span><span
													class="wd-action-text">Add to cart</span></a>
										</div>
									</div>
									<div class="product-element-bottom">
										<h3 class="wd-entities-title"><a
												href="product_details.html">Frodo
												Baggins Figure</a></h3>

										<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span
														class="woocommerce-Price-currencySymbol">&#36;</span>44,99</bdi></span></span>

									</div>
								</div>
							</div>

						</div>

						<div class="wd-loop-footer products-footer">
							<nav class="woocommerce-pagination wd-pagination" aria-label="Product Pagination">
								<ul class='page-numbers'>
									<li><span aria-label="Page 1" aria-current="page"
											class="page-numbers current">1</span></li>
									<li><a aria-label="Page 2" class="page-numbers"
											href="products.html">2</a>
									</li>
									<li><a aria-label="Page 3" class="page-numbers"
											href="products.html">3</a>
									</li>
									<li><a aria-label="Page 4" class="page-numbers"
											href="products.html">4</a>
									</li>
									<li><a aria-label="Page 5" class="page-numbers"
											href="products.html">5</a>
									</li>
									<li><a aria-label="Page 6" class="page-numbers"
											href="products.html">6</a>
									</li>
									<li><a class="next page-numbers"
											href="products.html">&rarr;</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>

				</div>

			</main>

		</div>
@endsection
