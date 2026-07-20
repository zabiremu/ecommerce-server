/* ============================================================
   GMS Custom Scripts — Vanilla JS, no jQuery dependency
   ============================================================ */

/* --- CONFIG: all editable values in one place --- */
const GMS_CONFIG = {
  whatsapp: '1234567890',            // WhatsApp number (digits only)
  messenger: 'YourPageName',         // Facebook Messenger m.me/ slug
  couponCode: 'SAVE15',             // Discount popup coupon code
  couponDiscount: '15% OFF',        // Discount text shown in popup
  ctaLink: 'products.html',         // CTA button destination
  popupDelay: 1500,                 // ms before popup shows
  popupFrequency: 'session',        // 'session' or 'daily'
  sliderInterval: 5000,             // ms between slide transitions
};

document.addEventListener('DOMContentLoaded', function () {

  /* ==========================================================
     1. DISCOUNT POPUP
     ========================================================== */
  (function initDiscountPopup() {
    var storageKey = 'gms_popup_shown';
    var shouldShow = false;

    if (GMS_CONFIG.popupFrequency === 'daily') {
      var last = localStorage.getItem(storageKey);
      var today = new Date().toDateString();
      shouldShow = last !== today;
    } else {
      shouldShow = !sessionStorage.getItem(storageKey);
    }

    if (!shouldShow) return;

    var overlay = document.createElement('div');
    overlay.className = 'gms-popup-overlay';
    overlay.innerHTML =
      '<div class="gms-popup">' +
        '<button class="gms-popup-close" aria-label="Close">&times;</button>' +
        '<div class="gms-popup-icon">🎉</div>' +
        '<h2>Exclusive Discount1!</h2>' +
        '<p>Use the code below at checkout and enjoy <strong>' + GMS_CONFIG.couponDiscount + '</strong> your order.</p>' +
        '<div class="gms-coupon-code">' + GMS_CONFIG.couponCode + '</div><br>' +
        '<a href="' + GMS_CONFIG.ctaLink + '" class="gms-popup-cta">Shop Now</a>' +
      '</div>';

    document.body.appendChild(overlay);

    function closePopup() {
      overlay.classList.remove('gms-visible');
      if (GMS_CONFIG.popupFrequency === 'daily') {
        localStorage.setItem(storageKey, new Date().toDateString());
      } else {
        sessionStorage.setItem(storageKey, '1');
      }
    }

    setTimeout(function () {
      overlay.classList.add('gms-visible');
    }, GMS_CONFIG.popupDelay);

    overlay.querySelector('.gms-popup-close').addEventListener('click', closePopup);
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closePopup();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && overlay.classList.contains('gms-visible')) closePopup();
    });
  })();

  /* ==========================================================
     2. DIRECT MESSAGE BUTTON
     ========================================================== */
  (function initDMButton() {
    var wrap = document.createElement('div');
    wrap.className = 'gms-dm-wrap';
    wrap.innerHTML =
      '<div class="gms-dm-links">' +
        '<a href="https://wa.me/' + GMS_CONFIG.whatsapp + '" target="_blank" rel="noopener">' +
          '<svg viewBox="0 0 32 32"><path fill="#25D366" d="M16.004 0C7.165 0 .004 7.161.004 16c0 2.822.737 5.578 2.137 8.004L0 32l8.188-2.088A15.93 15.93 0 0016.004 32C24.841 32 32 24.839 32 16S24.841 0 16.004 0zm0 29.116a13.08 13.08 0 01-6.67-1.824l-.478-.284-4.957 1.3 1.325-4.835-.312-.496A13.05 13.05 0 012.89 16c0-7.234 5.886-13.116 13.114-13.116S29.116 8.766 29.116 16 23.232 29.116 16.004 29.116zm7.187-9.822c-.393-.197-2.329-1.149-2.69-1.28-.361-.131-.624-.197-.886.197-.262.394-1.017 1.28-1.247 1.543-.23.262-.459.295-.853.098-.393-.197-1.661-.612-3.165-1.953-1.17-1.043-1.96-2.332-2.19-2.726-.23-.394-.025-.607.173-.803.178-.176.393-.459.59-.689.197-.23.262-.394.394-.656.131-.263.066-.492-.033-.69-.098-.196-.886-2.137-1.214-2.924-.32-.77-.645-.665-.886-.678l-.755-.013c-.262 0-.689.098-1.05.492s-1.378 1.346-1.378 3.283c0 1.937 1.411 3.808 1.608 4.07.197.263 2.778 4.24 6.73 5.946.94.406 1.674.649 2.246.83.944.3 1.803.258 2.482.157.757-.113 2.329-.952 2.657-1.872.328-.919.328-1.707.23-1.872-.098-.164-.361-.262-.755-.459z"/></svg>' +
          'WhatsApp' +
        '</a>' +
        '<a href="https://m.me/' + GMS_CONFIG.messenger + '" target="_blank" rel="noopener">' +
          '<svg viewBox="0 0 32 32"><path fill="#0084FF" d="M16 0C7.163 0 0 6.724 0 15.02c0 4.738 2.33 8.958 5.97 11.72V32l5.087-2.793A17.15 17.15 0 0016 30.04c8.837 0 16-6.724 16-15.02S24.837 0 16 0zm1.588 20.228l-4.073-4.342-7.95 4.342 8.743-9.28 4.173 4.342 7.85-4.342-8.743 9.28z"/></svg>' +
          'Messenger' +
        '</a>' +
      '</div>' +
      '<button class="gms-dm-toggle" aria-label="Contact us">' +
        '<svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.2L4 17.2V4h16v12z"/></svg>' +
      '</button>';

    document.body.appendChild(wrap);

    wrap.querySelector('.gms-dm-toggle').addEventListener('click', function () {
      wrap.classList.toggle('gms-dm-open');
    });

    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) {
        wrap.classList.remove('gms-dm-open');
      }
    });
  })();

  /* ==========================================================
     4. PRICE FILTER (client-side range slider)
     ========================================================== */
  (function initPriceFilter() {
    // Only run on shop/product-listing pages that have a proper shop layout
    var hasShopContext = document.querySelector('.wd-sidebar') ||
                        document.querySelector('.wd-shop-content') ||
                        document.querySelector('.woocommerce-products-header') ||
                        document.querySelector('.wd-shop-page');
    if (!hasShopContext) return;

    var productGrid = document.querySelector('.products .wd-grid .wd-carousel-wrap') ||
                      document.querySelector('.products-grid') ||
                      document.querySelector('.wd-shop-product .wd-products');
    if (!productGrid) {
      var shopProducts = document.querySelector('.wd-products');
      if (shopProducts) productGrid = shopProducts;
    }

    var cards = document.querySelectorAll('.wd-product.product-grid-item');
    if (cards.length === 0) return;

    function parsePrice(card) {
      var ins = card.querySelector('.price ins .woocommerce-Price-amount bdi');
      var single = card.querySelector('.price .woocommerce-Price-amount bdi');
      var el = ins || single;
      if (!el) return null;
      var text = el.textContent.replace(/[^\d.,]/g, '');
      text = text.replace(',', '.');
      return parseFloat(text) || null;
    }

    var prices = [];
    cards.forEach(function (card) {
      var p = parsePrice(card);
      if (p !== null) {
        card._gmsPrice = p;
        prices.push(p);
      }
    });

    if (prices.length === 0) return;

    var minPrice = Math.floor(Math.min.apply(null, prices));
    var maxPrice = Math.ceil(Math.max.apply(null, prices));
    if (minPrice === maxPrice) return;

    var container = document.createElement('div');
    container.className = 'gms-price-filter';
    container.innerHTML =
      '<h4>Filter by Price</h4>' +
      '<div class="gms-price-filter-sliders">' +
        '<div class="gms-price-filter-track"></div>' +
        '<div class="gms-price-filter-range"></div>' +
        '<input type="range" class="gms-range-min" min="' + minPrice + '" max="' + maxPrice + '" value="' + minPrice + '" step="1">' +
        '<input type="range" class="gms-range-max" min="' + minPrice + '" max="' + maxPrice + '" value="' + maxPrice + '" step="1">' +
      '</div>' +
      '<div class="gms-price-filter-values">' +
        '<span class="gms-val-min">$' + minPrice + '</span>' +
        '<span class="gms-val-max">$' + maxPrice + '</span>' +
      '</div>';

    var sidebar = document.querySelector('.wd-sidebar');
    var widgetArea = sidebar ? sidebar.querySelector('.widget-area') : null;
    var shopContent = document.querySelector('.wd-shop-content');
    if (widgetArea) {
      widgetArea.insertBefore(container, widgetArea.firstChild);
    } else if (sidebar) {
      sidebar.insertBefore(container, sidebar.firstChild);
    } else if (shopContent) {
      shopContent.parentNode.insertBefore(container, shopContent);
    } else {
      var firstCard = cards[0];
      var parent = firstCard.parentNode;
      parent.parentNode.insertBefore(container, parent);
    }

    var emptyState = document.createElement('div');
    emptyState.className = 'gms-empty-state';
    emptyState.innerHTML =
      '<div class="gms-empty-state-icon">🛒</div>' +
      '<h3>No products found</h3>' +
      '<p>Try adjusting the price range to find what you\'re looking for.</p>';
    var gridParent = cards[0].parentNode;
    gridParent.appendChild(emptyState);

    var rangeMin = container.querySelector('.gms-range-min');
    var rangeMax = container.querySelector('.gms-range-max');
    var rangeFill = container.querySelector('.gms-price-filter-range');
    var valMin = container.querySelector('.gms-val-min');
    var valMax = container.querySelector('.gms-val-max');

    function updateFilter() {
      var lo = parseInt(rangeMin.value);
      var hi = parseInt(rangeMax.value);

      if (lo > hi) {
        var tmp = lo; lo = hi; hi = tmp;
        rangeMin.value = lo;
        rangeMax.value = hi;
      }

      var pct1 = ((lo - minPrice) / (maxPrice - minPrice)) * 100;
      var pct2 = ((hi - minPrice) / (maxPrice - minPrice)) * 100;
      rangeFill.style.left = pct1 + '%';
      rangeFill.style.width = (pct2 - pct1) + '%';

      valMin.textContent = '$' + lo;
      valMax.textContent = '$' + hi;

      var visible = 0;
      cards.forEach(function (card) {
        if (card._gmsPrice === undefined) return;
        if (card._gmsPrice >= lo && card._gmsPrice <= hi) {
          card.style.display = '';
          visible++;
        } else {
          card.style.display = 'none';
        }
      });

      if (visible === 0) {
        emptyState.classList.add('gms-visible');
      } else {
        emptyState.classList.remove('gms-visible');
      }
    }

    rangeMin.addEventListener('input', updateFilter);
    rangeMax.addEventListener('input', updateFilter);
    updateFilter();
  })();

  /* ==========================================================
     5. NAVBAR DROPDOWN ARROWS — click/tap toggle
     ========================================================== */
  (function initNavArrows() {
    var items = document.querySelectorAll('.wd-nav-header .menu-item-has-children');

    items.forEach(function (li) {
      var link = li.querySelector(':scope > a');
      if (!link) return;

      var arrow = li.querySelector(':scope > .gms-dropdown-arrow');
      if (!arrow) {
        arrow = document.createElement('span');
        arrow.className = 'gms-dropdown-arrow';
        arrow.setAttribute('role', 'button');
        arrow.setAttribute('aria-label', 'Toggle submenu');
        link.parentNode.insertBefore(arrow, link.nextSibling);
      }

      arrow.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var isOpen = li.classList.contains('gms-dropdown-open');

        items.forEach(function (other) {
          other.classList.remove('gms-dropdown-open');
          var otherArrow = other.querySelector('.gms-dropdown-arrow');
          if (otherArrow) otherArrow.classList.remove('gms-arrow-open');
        });

        if (!isOpen) {
          li.classList.add('gms-dropdown-open');
          arrow.classList.add('gms-arrow-open');
        }
      });
    });

    // Mobile nav: inject toggle arrows on parent items with children
    var mobileParents = document.querySelectorAll('.wd-nav-mobile .menu-item-has-children');
    mobileParents.forEach(function (li) {
      var link = li.querySelector(':scope > a');
      if (!link) return;

      var arrow = document.createElement('span');
      arrow.className = 'gms-dropdown-arrow';
      arrow.setAttribute('role', 'button');
      arrow.setAttribute('aria-label', 'Toggle submenu');
      link.after(arrow);

      arrow.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var sub = li.querySelector(':scope > .wd-sub-menu, :scope > .sub-sub-menu');
        if (sub) {
          var isOpen = sub.style.display === 'block';
          sub.style.display = isOpen ? 'none' : 'block';
          arrow.classList.toggle('gms-arrow-open', !isOpen);
        }
      });
    });

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.wd-nav-header')) {
        items.forEach(function (li) {
          li.classList.remove('gms-dropdown-open');
          var a = li.querySelector('.gms-dropdown-arrow');
          if (a) a.classList.remove('gms-arrow-open');
        });
      }
    });
  })();

  /* ==========================================================
     7. SLIDER AUTOPLAY (self-contained, no Swiper dependency)
     ========================================================== */
  (function initSlider() {
    var slider = document.querySelector('.wd-slider');
    if (!slider) return;

    var slides = slider.querySelectorAll('.wd-slide.wd-carousel-item');
    if (slides.length < 2) return;

    var carousel = slider.querySelector('.wd-carousel');
    if (carousel) carousel.classList.add('wd-fade');

    var wrap = slides[0].parentNode;
    var current = 0;
    var timer = null;

    // Initialize: set first slide active
    slides.forEach(function (s, i) {
      s.classList.remove('wd-active', 'wd-slide-prev', 'wd-slide-next');
      if (i === 0) {
        s.classList.add('gms-slide-active');
      } else {
        s.classList.remove('gms-slide-active');
      }
    });

    function goTo(index) {
      if (index === current) return;
      slides[current].classList.remove('gms-slide-active');
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('gms-slide-active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAutoplay() {
      stopAutoplay();
      timer = setInterval(next, GMS_CONFIG.sliderInterval);
    }
    function stopAutoplay() {
      if (timer) clearInterval(timer);
    }

    // Inject nav buttons
    var sliderContainer = slider.querySelector('.wd-carousel-inner') || slider;
    sliderContainer.style.position = 'relative';

    var prevBtn = document.createElement('button');
    prevBtn.className = 'gms-slider-nav gms-slider-prev';
    prevBtn.setAttribute('aria-label', 'Previous slide');

    var nextBtn = document.createElement('button');
    nextBtn.className = 'gms-slider-nav gms-slider-next';
    nextBtn.setAttribute('aria-label', 'Next slide');

    sliderContainer.appendChild(prevBtn);
    sliderContainer.appendChild(nextBtn);

    prevBtn.addEventListener('click', function () { prev(); startAutoplay(); });
    nextBtn.addEventListener('click', function () { next(); startAutoplay(); });

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
  })();

  /* ==========================================================
     8a. LOADING SKELETON for product images
     ========================================================== */
  (function initSkeletons() {
    var productCards = document.querySelectorAll('.wd-product.product-grid-item');
    productCards.forEach(function (card) {
      var wrapper = card.querySelector('.wd-product-wrapper');
      if (!wrapper) return;

      wrapper.classList.add('gms-skeleton');

      var mainImg = card.querySelector('.wd-product-thumb > a > img');
      if (mainImg) {
        if (mainImg.complete && mainImg.naturalWidth > 0) {
          wrapper.classList.add('gms-loaded');
        } else {
          mainImg.addEventListener('load', function () {
            wrapper.classList.add('gms-loaded');
          });
          mainImg.addEventListener('error', function () {
            wrapper.classList.add('gms-loaded');
          });
        }
      } else {
        wrapper.classList.add('gms-loaded');
      }
    });
  })();

  /* ==========================================================
     9. SEARCH SUGGESTIONS / AUTOCOMPLETE
     ========================================================== */
  (function initSearchSuggestions() {
    var forms = document.querySelectorAll('.searchform.woodmart-ajax-search');
    if (forms.length === 0) return;

    function renderProductList(heading, products) {
      var html = '<div class="gms-search-heading">' + heading + '</div><ul class="gms-search-list">';
      products.forEach(function (p) {
        html +=
          '<li class="gms-search-item">' +
            '<a href="' + p.url + '">' +
              (p.img ? '<img src="' + p.img + '" alt="" loading="lazy">' : '') +
              '<span class="gms-search-item-info">' +
                '<span class="gms-search-item-title">' + p.title + '</span>' +
                '<span class="gms-search-item-price">$' + p.price.toFixed(2) + '</span>' +
              '</span>' +
            '</a>' +
          '</li>';
      });
      html += '</ul>';
      return html;
    }

    function renderResults(container, data, input) {
      var hasTerms = data.popular && data.popularTerms && data.popularTerms.length > 0;
      var hasProducts = data.products && data.products.length > 0;

      if (!hasTerms && !hasProducts) {
        container.innerHTML = '<div class="gms-search-empty">No products found.</div>';
        return;
      }

      var html = '';

      if (hasTerms) {
        html += '<div class="gms-search-heading">Popular searches</div><div class="gms-search-terms">';
        data.popularTerms.forEach(function (term) {
          html += '<button type="button" class="gms-search-term">' + term + '</button>';
        });
        html += '</div>';
      }

      if (hasProducts) {
        html += renderProductList(data.popular ? 'Trending products' : 'Search results', data.products);
      }

      container.innerHTML = html;

      container.querySelectorAll('.gms-search-term').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var term = btn.textContent;
          input.value = term;
          runSearchFor(input, container, term);
        });
      });
    }

    function runSearchFor(input, container, q) {
      fetch('/search/suggestions?q=' + encodeURIComponent(q))
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data.success) renderResults(container, data, input);
        })
        .catch(function () {});
    }

    forms.forEach(function (form) {
      var input = form.querySelector('.s');
      if (!input) return;

      var resultsBox = form.parentNode.querySelector('.wd-search-results');
      if (!resultsBox) return;
      var target = resultsBox.querySelector('.wd-scroll-content') || resultsBox;

      var timer = null;

      function runSearch(q) {
        runSearchFor(input, target, q);
      }

      input.addEventListener('focus', function () {
        if (input.value.trim() === '') runSearch('');
      });

      input.addEventListener('input', function () {
        clearTimeout(timer);
        var q = input.value.trim();
        timer = setTimeout(function () { runSearch(q); }, 250);
      });
    });
  })();

  /* ==========================================================
     10. NEWSLETTER SIGNUP
     ========================================================== */
  (function initNewsletterForm() {
    var form = document.getElementById('newsletter-form');
    if (!form) return;

    var msgBox = form.querySelector('.newsletter-message');
    var tokenInput = form.querySelector('input[name="_token"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var email = form.querySelector('#newsletter-email').value.trim();
      if (!email) return;

      msgBox.textContent = 'Subscribing…';
      msgBox.style.color = '';

      fetch(form.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': tokenInput ? tokenInput.value : ''
        },
        body: JSON.stringify({ email: email })
      })
        .then(function (res) { return res.json().then(function (data) { return { status: res.status, data: data }; }); })
        .then(function (result) {
          if (result.status >= 200 && result.status < 300) {
            msgBox.style.color = '#2f8f4e';
            msgBox.textContent = result.data.message || 'Thanks for subscribing!';
            form.reset();
          } else {
            msgBox.style.color = '#c9401d';
            var errors = result.data.errors ? Object.values(result.data.errors).flat().join(' ') : null;
            msgBox.textContent = errors || result.data.message || 'Something went wrong. Please try again.';
          }
        })
        .catch(function () {
          msgBox.style.color = '#c9401d';
          msgBox.textContent = 'Something went wrong. Please try again.';
        });
    });
  })();

  /* ==========================================================
     8c. LAZY LOAD IMAGES — add loading="lazy" + decoding="async"
     ========================================================== */
  (function initLazyLoad() {
    var images = document.querySelectorAll('img');
    images.forEach(function (img) {
      if (!img.hasAttribute('loading')) {
        img.setAttribute('loading', 'lazy');
      }
      if (!img.hasAttribute('decoding')) {
        img.setAttribute('decoding', 'async');
      }
    });
  })();

  /* ==========================================================
     9. QUICK VIEW MODAL
     ========================================================== */
  (function initQuickView() {
    var overlay = document.getElementById('gms-quick-view-overlay');
    if (!overlay) return;

    var closeBtn = document.getElementById('gms-quick-view-close');
    var imgEl = document.getElementById('gms-quick-view-img');
    var badgesEl = document.getElementById('gms-quick-view-badges');
    var titleEl = document.getElementById('gms-quick-view-title');
    var ratingEl = document.getElementById('gms-quick-view-rating');
    var priceEl = document.getElementById('gms-quick-view-price');
    var stockEl = document.getElementById('gms-quick-view-stock');
    var descEl = document.getElementById('gms-quick-view-desc');
    var linkEl = document.getElementById('gms-quick-view-link');

    function openModal() {
      overlay.classList.add('gms-visible');
    }

    function closeModal() {
      overlay.classList.remove('gms-visible');
    }

    function renderProduct(data) {
      imgEl.src = data.image || '';
      imgEl.alt = data.name || '';
      titleEl.textContent = data.name || '';
      linkEl.href = data.url || '#';

      badgesEl.innerHTML = '';
      (data.badges || []).forEach(function (badge) {
        var span = document.createElement('span');
        span.className = 'product-label wd-shape-round-sm ' + badge.class;
        span.textContent = badge.label;
        badgesEl.appendChild(span);
      });

      if (data.avgRating > 0) {
        ratingEl.innerHTML = '<span style="width:' + (data.avgRating / 5 * 100) + '%">Rated ' +
          '<strong class="rating">' + data.avgRating + '</strong> out of 5</span>' +
          (data.reviewsCount > 0 ? ' <span style="font-size:12px;color:#888">(' + data.reviewsCount + ')</span>' : '');
        ratingEl.style.display = '';
      } else {
        ratingEl.innerHTML = '';
        ratingEl.style.display = 'none';
      }

      if (data.price) {
        if (data.price.hasSale) {
          priceEl.innerHTML = '<del>$' + Number(data.price.old).toFixed(2) + '</del> <ins>$' + Number(data.price.current).toFixed(2) + '</ins>';
        } else {
          priceEl.innerHTML = '$' + Number(data.price.current).toFixed(2);
        }
      }

      if (data.stockStatus) {
        stockEl.textContent = data.stockStatus.text;
        stockEl.className = 'wd-stock-status ' + data.stockStatus.class;
      }

      descEl.textContent = data.shortDescription || '';
    }

    document.addEventListener('click', function (e) {
      var trigger = e.target.closest('.open-quick-view');
      if (!trigger) return;
      var url = trigger.getAttribute('data-quick-view-url');
      if (!url) return;

      e.preventDefault();

      fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          renderProduct(data);
          openModal();
        })
        .catch(function () {
          window.location.href = trigger.getAttribute('href');
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeModal();
    });
  })();

});
