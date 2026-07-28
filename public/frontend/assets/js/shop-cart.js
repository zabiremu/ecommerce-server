/* ============================================================
   ShopCart — Vanilla JS cart + wishlist engine
   - Cart & wishlist live in localStorage (source of truth in the browser)
   - Cart is pushed to the server via POST /cart/sync (abandoned-cart
     tracking + used as reference when placing an order)
   - Activates any existing "Add to cart" / "Add to wishlist" markup
     across the site via event delegation, so product cards on the
     home page, category pages, etc. work without editing every view.
   ============================================================ */

(function () {
    const CART_KEY = 'gms_cart';
    const WISHLIST_KEY = 'gms_wishlist';

    function csrfToken() {
        const tag = document.querySelector('meta[name="csrf-token"]');
        return tag ? tag.getAttribute('content') : '';
    }

    function readJson(key, fallback) {
        try {
            const raw = localStorage.getItem(key);
            return raw ? JSON.parse(raw) : fallback;
        } catch (e) {
            return fallback;
        }
    }

    function writeJson(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (e) { /* storage unavailable — fail silently */ }
    }

    /* ---------------- Cart ---------------- */

    function getCart() {
        return readJson(CART_KEY, []);
    }

    function saveCart(items) {
        writeJson(CART_KEY, items);
        renderCartBadge();
        document.dispatchEvent(new CustomEvent('shopcart:cart-changed', { detail: { items } }));
    }

    function findLine(items, productId, variantId) {
        return items.findIndex(function (it) {
            return it.id === productId && (it.variant_id || null) === (variantId || null);
        });
    }

    function addToCart(productId, qty, variantId) {
        qty = parseInt(qty, 10) || 1;
        variantId = variantId ? parseInt(variantId, 10) : null;
        const items = getCart();
        const idx = findLine(items, productId, variantId);
        if (idx > -1) {
            items[idx].qty += qty;
        } else {
            items.push({ id: productId, variant_id: variantId, qty: qty });
        }
        saveCart(items);
        syncCartToServer();
        return items;
    }

    function updateQty(productId, variantId, qty) {
        qty = parseInt(qty, 10);
        const items = getCart();
        const idx = findLine(items, productId, variantId);
        if (idx === -1) return items;
        if (qty <= 0) {
            items.splice(idx, 1);
        } else {
            items[idx].qty = qty;
        }
        saveCart(items);
        syncCartToServer();
        return items;
    }

    function removeFromCart(productId, variantId) {
        return updateQty(productId, variantId, 0);
    }

    function clearCart() {
        saveCart([]);
        syncCartToServer();
    }

    function cartCount() {
        return getCart().reduce(function (sum, it) { return sum + it.qty; }, 0);
    }

    function renderCartBadge() {
        const count = cartCount();
        document.querySelectorAll('[data-cart-count]').forEach(function (el) {
            el.textContent = count;
            el.style.display = count > 0 ? '' : 'none';
        });
    }

    let syncTimer = null;
    function syncCartToServer(contact) {
        clearTimeout(syncTimer);
        syncTimer = setTimeout(function () {
            fetch('/cart/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(Object.assign({ items: getCart() }, contact || {})),
            }).catch(function () { /* best-effort — ignore network errors */ });
        }, 400);
    }

    /* ---------------- Wishlist ---------------- */

    function getWishlist() {
        return readJson(WISHLIST_KEY, []);
    }

    function saveWishlist(ids) {
        writeJson(WISHLIST_KEY, ids);
        renderWishlistBadge();
        document.dispatchEvent(new CustomEvent('shopcart:wishlist-changed', { detail: { ids } }));
    }

    function isWishlisted(productId) {
        return getWishlist().indexOf(productId) > -1;
    }

    function toggleWishlist(productId) {
        const ids = getWishlist();
        const idx = ids.indexOf(productId);
        if (idx > -1) {
            ids.splice(idx, 1);
        } else {
            ids.push(productId);
        }
        saveWishlist(ids);
        return ids.indexOf(productId) > -1;
    }

    function removeFromWishlist(productId) {
        const ids = getWishlist().filter(function (id) { return id !== productId; });
        saveWishlist(ids);
    }

    function renderWishlistBadge() {
        const count = getWishlist().length;
        document.querySelectorAll('[data-wishlist-count]').forEach(function (el) {
            el.textContent = count;
            el.style.display = count > 0 ? '' : 'none';
        });
    }

    /* ---------------- Product data lookup ---------------- */

    function fetchProducts(ids) {
        if (!ids || ids.length === 0) return Promise.resolve([]);
        return fetch('/api/products?ids=' + ids.join(','), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        }).then(function (r) { return r.json(); });
    }

    function fetchQuote(items, couponCode) {
        return fetch('/api/cart/quote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ items: items, coupon_code: couponCode || null }),
        }).then(function (r) { return r.json(); });
    }

    /* ---------------- Sitewide button wiring ---------------- */

    function markWishlistIcons() {
        document.querySelectorAll('[data-product-id]').forEach(function (el) {
            const id = parseInt(el.getAttribute('data-product-id'), 10);
            if (!id) return;
            el.classList.toggle('wd-active', isWishlisted(id));
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderCartBadge();
        renderWishlistBadge();
        markWishlistIcons();

        document.addEventListener('click', function (e) {
            // Wishlist toggle — any link/button carrying data-product-id inside a wishlist control
            const wishBtn = e.target.closest('.wd-wishlist-btn [data-product-id], [data-wishlist-toggle]');
            if (wishBtn) {
                const id = parseInt(wishBtn.getAttribute('data-product-id'), 10);
                if (id) {
                    e.preventDefault();
                    const active = toggleWishlist(id);
                    wishBtn.classList.toggle('wd-active', active);
                    const label = wishBtn.querySelector('.wd-action-text');
                    if (label) label.textContent = active ? 'Remove from wishlist' : 'Add to wishlist';
                }
                return;
            }

            // Quick add-to-cart on product cards (simple products only — variable
            // products keep their normal link through to the product page so the
            // shopper can pick a variant).
            const addBtn = e.target.closest('.add_to_cart_button[data-product_id], .ajax_add_to_cart[data-product_id]');
            if (addBtn && !addBtn.closest('form')) {
                const isVariable = /select options/i.test(addBtn.textContent || '');
                if (!isVariable) {
                    const id = parseInt(addBtn.getAttribute('data-product_id'), 10);
                    if (id) {
                        e.preventDefault();
                        addToCart(id, 1, null);
                        const label = addBtn.querySelector('.wd-action-text') || addBtn;
                        const original = label.textContent;
                        label.textContent = 'Added ✓';
                        setTimeout(function () { label.textContent = original; }, 1200);
                    }
                }
            }
        });
    });

    window.ShopCart = {
        getCart: getCart,
        addToCart: addToCart,
        updateQty: updateQty,
        removeFromCart: removeFromCart,
        clearCart: clearCart,
        cartCount: cartCount,
        syncCartToServer: syncCartToServer,
        getWishlist: getWishlist,
        toggleWishlist: toggleWishlist,
        removeFromWishlist: removeFromWishlist,
        isWishlisted: isWishlisted,
        fetchProducts: fetchProducts,
        fetchQuote: fetchQuote,
        csrfToken: csrfToken,
        renderCartBadge: renderCartBadge,
        renderWishlistBadge: renderWishlistBadge,
    };
})();
