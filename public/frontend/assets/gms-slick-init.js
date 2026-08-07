/* ============================================================
   Slick carousel init — mobile-only product sliders
   ============================================================
   Featured Products, Best Sellers and Special Sections all share the
   same .wd-products-element carousel markup, which relies on the
   theme's Swiper JS to page past the first --wd-col items — that init
   never reliably fires on this build (see gms-custom.css §16b), so on
   phones only the first --wd-col-sm products were ever reachable.
   Slick replaces that for mobile only: it un-initializes itself above
   the 768.98px breakpoint via the "unslick" setting, leaving the
   desktop/tablet grid exactly as the theme renders it. On mobile it
   always shows 1 product per slide, regardless of the --wd-col-sm the
   theme sets for its own (non-JS) grid — one full-width card per swipe
   reads better on phones than 2 cramped ones. Kept in its own file
   (not gms-custom.js) since it's the one jQuery-dependent script on
   the site — gms-custom.js is documented as vanilla-only. */
jQuery(function ($) {
  $('.wd-products-element .wd-carousel-wrap').each(function () {
    $(this).slick({
      mobileFirst: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      infinite: false,
      responsive: [
        { breakpoint: 769, settings: 'unslick' }
      ]
    });
  });
});
