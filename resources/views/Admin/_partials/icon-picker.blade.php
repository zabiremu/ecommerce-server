{{--
    Reusable Icon Picker
    Props: $name (input name), $id (unique DOM prefix), $value (current full class e.g. 'fas fa-truck'), $label (optional)
--}}
@php
    $pickerId   = $id ?? ('ip_' . str_replace(['[',']','.','-'], '_', $name));
    $curValue   = $value ?? '';
    $curLabel   = $curValue ? str_replace(['fas ', 'far ', 'fab ', 'fa-', '-'], ['', '', '', '', ' '], $curValue) : 'Select an icon';
    $curLabel   = trim($curLabel) ?: 'Select an icon';

    $icons = [
        // Shopping & E-commerce
        'fas fa-bag-shopping', 'fas fa-cart-shopping', 'fas fa-cart-plus', 'fas fa-tag', 'fas fa-tags',
        'fas fa-percent', 'fas fa-dollar-sign', 'fas fa-credit-card', 'fas fa-wallet', 'fas fa-receipt',
        'fas fa-store', 'fas fa-shop', 'fas fa-barcode', 'fas fa-qrcode', 'fas fa-gift',
        // Delivery & Shipping
        'fas fa-truck', 'fas fa-truck-fast', 'fas fa-truck-ramp-box', 'fas fa-box', 'fas fa-boxes-stacked',
        'fas fa-warehouse', 'fas fa-map-pin', 'fas fa-location-dot', 'fas fa-route', 'fas fa-plane',
        'fas fa-ship', 'fas fa-motorcycle', 'fas fa-car',
        // Communication & Support
        'fas fa-headset', 'fas fa-phone', 'fas fa-mobile-screen', 'fas fa-envelope', 'fas fa-message',
        'fas fa-comments', 'fas fa-comment', 'fas fa-bell', 'fas fa-paper-plane', 'fas fa-at',
        'fas fa-bullhorn', 'fas fa-share-nodes', 'fas fa-satellite-dish',
        // Security & Trust
        'fas fa-shield-halved', 'fas fa-shield', 'fas fa-lock', 'fas fa-unlock', 'fas fa-key',
        'fas fa-certificate', 'fas fa-award', 'fas fa-medal', 'fas fa-trophy', 'fas fa-crown',
        'fas fa-star', 'fas fa-thumbs-up', 'fas fa-handshake', 'fas fa-circle-check', 'fas fa-check-double',
        'fas fa-check', 'fas fa-user-shield',
        // Technology
        'fas fa-laptop', 'fas fa-computer', 'fas fa-tablet-screen-button', 'fas fa-headphones',
        'fas fa-camera', 'fas fa-tv', 'fas fa-print', 'fas fa-keyboard', 'fas fa-mouse',
        'fas fa-microchip', 'fas fa-hard-drive', 'fas fa-memory', 'fas fa-server',
        'fas fa-wifi', 'fas fa-battery-full', 'fas fa-plug', 'fas fa-power-off',
        // Fashion & Accessories
        'fas fa-shirt', 'fas fa-shoe-prints', 'fas fa-gem', 'fas fa-watch', 'fas fa-glasses',
        'fas fa-hat-cowboy', 'fas fa-ring', 'fas fa-scissors',
        // Health & Beauty
        'fas fa-spa', 'fas fa-heart-pulse', 'fas fa-leaf', 'fas fa-hand-holding-heart',
        'fas fa-kit-medical', 'fas fa-pills', 'fas fa-stethoscope', 'fas fa-face-smile',
        'fas fa-dumbbell', 'fas fa-person-running', 'fas fa-bicycle',
        // Food & Kitchen
        'fas fa-utensils', 'fas fa-pizza-slice', 'fas fa-burger', 'fas fa-apple-whole',
        'fas fa-mug-hot', 'fas fa-wine-glass', 'fas fa-blender', 'fas fa-kitchen-set',
        'fas fa-plate-wheat', 'fas fa-cookie', 'fas fa-bowl-food',
        // Home & Tools
        'fas fa-house', 'fas fa-couch', 'fas fa-bed', 'fas fa-bath', 'fas fa-lightbulb',
        'fas fa-broom', 'fas fa-soap', 'fas fa-spray-can-sparkles', 'fas fa-screwdriver-wrench',
        'fas fa-wrench', 'fas fa-hammer', 'fas fa-paintbrush', 'fas fa-paint-roller', 'fas fa-ruler',
        // Nature & Weather
        'fas fa-tree', 'fas fa-seedling', 'fas fa-droplet', 'fas fa-snowflake',
        'fas fa-sun', 'fas fa-moon', 'fas fa-cloud', 'fas fa-wind', 'fas fa-fire',
        'fas fa-bolt', 'fas fa-mountain', 'fas fa-globe', 'fas fa-earth-asia', 'fas fa-feather',
        'fas fa-water', 'fas fa-rainbow',
        // Animals & Pets
        'fas fa-cat', 'fas fa-dog', 'fas fa-paw', 'fas fa-fish', 'fas fa-dove',
        'fas fa-horse', 'fas fa-frog', 'fas fa-crow', 'fas fa-spider', 'fas fa-worm',
        // Education & Culture
        'fas fa-book', 'fas fa-book-open', 'fas fa-graduation-cap', 'fas fa-school',
        'fas fa-pen', 'fas fa-pencil', 'fas fa-palette', 'fas fa-music', 'fas fa-film',
        'fas fa-microphone', 'fas fa-headphones',
        // Business & Finance
        'fas fa-building', 'fas fa-briefcase', 'fas fa-chart-line', 'fas fa-chart-bar',
        'fas fa-chart-pie', 'fas fa-chart-simple', 'fas fa-coins', 'fas fa-money-bill',
        'fas fa-money-bill-wave', 'fas fa-landmark', 'fas fa-scale-balanced',
        'fas fa-id-card', 'fas fa-users', 'fas fa-user-tie', 'fas fa-user-group',
        // People & Emotions
        'fas fa-user', 'fas fa-heart', 'fas fa-face-smile', 'fas fa-face-grin-stars',
        'fas fa-baby', 'fas fa-child', 'fas fa-person', 'fas fa-people-group',
        // Badges & Highlights
        'fas fa-rocket', 'fas fa-wand-magic-sparkles', 'fas fa-fire-flame-curved',
        'fas fa-flag', 'fas fa-ban', 'fas fa-rotate-left', 'fas fa-rotate-right',
        'fas fa-link', 'fas fa-magnifying-glass', 'fas fa-filter', 'fas fa-clock',
        'fas fa-calendar', 'fas fa-bookmark', 'fas fa-thumbtack', 'fas fa-exclamation',
        'fas fa-circle-info', 'fas fa-circle-question', 'fas fa-circle-exclamation',
        'fas fa-circle-xmark', 'fas fa-circle-check', 'fas fa-arrow-right',
        'fas fa-arrow-up', 'fas fa-arrow-down', 'fas fa-up-right-from-square',
        'fas fa-rotate', 'fas fa-repeat', 'fas fa-infinity', 'fas fa-plus',
    ];
@endphp

@once
<style>
.ip-wrap { position: relative; }
.ip-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 10px; font-size: 13px;
    border: 1px solid #8c8f94; border-radius: 4px;
    background: #fff; cursor: pointer; width: 100%; text-align: left;
    transition: border-color .15s;
}
.ip-btn:hover, .ip-btn:focus { border-color: #2271b1; outline: none; }
.ip-btn .ip-preview { font-size: 15px; width: 20px; text-align: center; color: #50575e; flex-shrink: 0; }
.ip-btn .ip-label { color: #50575e; flex: 1; text-transform: capitalize; }
.ip-btn .ip-clear { color: #b32d2e; font-size: 12px; margin-left: auto; display: none; }
.ip-dropdown {
    position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: #fff; border: 1px solid #c3c4c7; border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0,0,0,.12); z-index: 99;
    display: none;
}
.ip-search-wrap { padding: 8px; border-bottom: 1px solid #f0f0f1; }
.ip-search {
    width: 100%; padding: 5px 8px; font-size: 12px;
    border: 1px solid #c3c4c7; border-radius: 3px; outline: none;
}
.ip-search:focus { border-color: #2271b1; }
.ip-grid {
    display: grid; grid-template-columns: repeat(8, 1fr);
    gap: 2px; padding: 6px; max-height: 220px; overflow-y: auto;
}
.ip-grid button {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    border: 1px solid transparent; background: transparent;
    border-radius: 3px; cursor: pointer; color: #50575e;
    font-size: 14px; transition: all .12s;
}
.ip-grid button:hover { background: #f0f6ff; color: #2271b1; border-color: #c3c4c7; }
.ip-grid button.ip-selected { background: #e8f4fd; color: #2271b1; border-color: #2271b1; }
.ip-empty { padding: 16px; text-align: center; font-size: 12px; color: #787c82; }
</style>
@endonce

<div class="ip-wrap" data-picker="{{ $pickerId }}">
    <button type="button" class="ip-btn" id="{{ $pickerId }}_btn" onclick="ipToggle('{{ $pickerId }}')">
        <span class="ip-preview" id="{{ $pickerId }}_preview">
            @if ($curValue)
                <i class="{{ $curValue }}"></i>
            @else
                <i class="fas fa-icons" style="color:#c3c4c7"></i>
            @endif
        </span>
        <span class="ip-label" id="{{ $pickerId }}_label">{{ $curLabel }}</span>
        @if ($curValue)
            <span class="ip-clear" id="{{ $pickerId }}_clear" style="display:inline" onclick="ipClear(event, '{{ $pickerId }}')"><i class="fas fa-xmark"></i></span>
        @else
            <span class="ip-clear" id="{{ $pickerId }}_clear" onclick="ipClear(event, '{{ $pickerId }}')"><i class="fas fa-xmark"></i></span>
        @endif
    </button>

    <input type="hidden" name="{{ $name }}" id="{{ $pickerId }}_input" value="{{ $curValue }}">

    <div class="ip-dropdown" id="{{ $pickerId }}_dropdown">
        <div class="ip-search-wrap">
            <input type="text" class="ip-search" placeholder="Search icons…"
                   oninput="ipSearch('{{ $pickerId }}', this.value)" autocomplete="off">
        </div>
        <div class="ip-grid" id="{{ $pickerId }}_grid">
            @foreach ($icons as $ic)
                @php $icSlug = str_replace(['fas ', 'far ', 'fab ', 'fa-', '-'], ['','','','','-'], $ic); $icSlug = trim($icSlug, '-'); @endphp
                <button type="button"
                        data-icon="{{ $ic }}"
                        data-label="{{ str_replace('-', ' ', $icSlug) }}"
                        title="{{ str_replace('-', ' ', $icSlug) }}"
                        class="{{ $curValue === $ic ? 'ip-selected' : '' }}"
                        onclick="ipSelect('{{ $pickerId }}', this)">
                    <i class="{{ $ic }}"></i>
                </button>
            @endforeach
        </div>
        <div class="ip-empty" id="{{ $pickerId }}_empty" style="display:none">No icons match your search.</div>
    </div>
</div>

@once
<script>
function ipToggle(pid) {
    var dd = document.getElementById(pid + '_dropdown');
    var isVisible = dd.style.display === 'block';
    // close all
    document.querySelectorAll('.ip-dropdown').forEach(function(d) { d.style.display = 'none'; });
    if (!isVisible) {
        dd.style.display = 'block';
        var si = dd.querySelector('.ip-search');
        if (si) { si.value = ''; ipSearch(pid, ''); si.focus(); }
    }
}

function ipSelect(pid, btn) {
    var icon  = btn.dataset.icon;
    var label = btn.dataset.label;
    document.getElementById(pid + '_input').value   = icon;
    document.getElementById(pid + '_preview').innerHTML = '<i class="' + icon + '"></i>';
    document.getElementById(pid + '_label').textContent = label;
    var clr = document.getElementById(pid + '_clear');
    if (clr) clr.style.display = 'inline';
    // mark selected
    document.querySelectorAll('[data-picker="' + pid + '"] .ip-grid button').forEach(function(b) {
        b.classList.toggle('ip-selected', b === btn);
    });
    document.getElementById(pid + '_dropdown').style.display = 'none';
    // fire a custom event so JS can react
    document.getElementById(pid + '_input').dispatchEvent(new Event('change', { bubbles: true }));
}

function ipClear(e, pid) {
    e.stopPropagation();
    document.getElementById(pid + '_input').value = '';
    document.getElementById(pid + '_preview').innerHTML = '<i class="fas fa-icons" style="color:#c3c4c7"></i>';
    document.getElementById(pid + '_label').textContent = 'Select an icon';
    var clr = document.getElementById(pid + '_clear');
    if (clr) clr.style.display = 'none';
    document.querySelectorAll('[data-picker="' + pid + '"] .ip-grid button').forEach(function(b) {
        b.classList.remove('ip-selected');
    });
}

function ipSearch(pid, q) {
    var grid  = document.getElementById(pid + '_grid');
    var empty = document.getElementById(pid + '_empty');
    var term  = q.toLowerCase().replace(/\s+/g, '-');
    var visible = 0;
    grid.querySelectorAll('button').forEach(function(b) {
        var match = !term || b.dataset.icon.toLowerCase().includes(term) || b.dataset.label.toLowerCase().includes(q.toLowerCase());
        b.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    empty.style.display = visible === 0 ? 'block' : 'none';
}

// Programmatic setter — call from editItem/reset JS
function ipSetValue(pid, iconClass) {
    var input   = document.getElementById(pid + '_input');
    var preview = document.getElementById(pid + '_preview');
    var labelEl = document.getElementById(pid + '_label');
    var clr     = document.getElementById(pid + '_clear');
    if (!input) return;
    input.value = iconClass || '';
    if (iconClass) {
        var lbl = iconClass.replace(/fas |far |fab |fa-/g, '').replace(/-/g, ' ').trim();
        preview.innerHTML = '<i class="' + iconClass + '"></i>';
        labelEl.textContent = lbl;
        if (clr) clr.style.display = 'inline';
    } else {
        preview.innerHTML = '<i class="fas fa-icons" style="color:#c3c4c7"></i>';
        labelEl.textContent = 'Select an icon';
        if (clr) clr.style.display = 'none';
    }
    document.querySelectorAll('[data-picker="' + pid + '"] .ip-grid button').forEach(function(b) {
        b.classList.toggle('ip-selected', b.dataset.icon === iconClass);
    });
}

// Close picker on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('.ip-wrap')) {
        document.querySelectorAll('.ip-dropdown').forEach(function(d) { d.style.display = 'none'; });
    }
});
</script>
@endonce
