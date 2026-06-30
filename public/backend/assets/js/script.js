// Hero Slider
let cur = 0;
const s = document.getElementById('heroSlides');
const d = document.querySelectorAll('.hero-dots .dot');
const t = document.querySelectorAll('.hero-slide').length;
function goToSlide(n){cur=n;s.style.transform='translateX(-'+(cur*100)+'%)';d.forEach((x,i)=>x.classList.toggle('active',i===cur))}
function slideHero(dir){cur=(cur+dir+t)%t;goToSlide(cur)}
setInterval(()=>slideHero(1),5000);

// Scroll effects
window.addEventListener('scroll',()=>{
    const btn=document.getElementById('btt');
    if(btn)btn.classList.toggle('show',window.scrollY>50);
});

// Scroll animations
const observer=new IntersectionObserver((e)=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('show')}})},{threshold:.1});
document.querySelectorAll('.fade-up').forEach(el=>observer.observe(el));

// --- Category Mega Dropdown ---
// Categories come from the server via window.NF_HEADER_CATEGORIES.

function initCatDropdown(){
    const btn=document.querySelector('.cat-btn');
    if(!btn||document.getElementById('catDropdown'))return;
    const data = window.NF_HEADER_CATEGORIES || [];
    if(!data.length)return;
    const baseUrl = window.NF_CAT_PRODUCTS_URL || 'category-products.html';
    const dd=document.createElement('div');
    dd.className='cat-dropdown';
    dd.id='catDropdown';
    const grid=document.createElement('div');
    grid.className='cat-dropdown-grid';
    grid.innerHTML=data.map(c=>`
        <a href="${baseUrl}?cat=${encodeURIComponent(c.slug)}" class="cat-drop-card" onclick="closeCatDropdown()">
            <div class="cd-icon"><i class="fas ${c.icon || 'fa-tag'}"></i></div>
            <div class="cd-info">
                <h4>${c.name}</h4>
                <span>${c.count} item${c.count===1?'':'s'}</span>
            </div>
        </a>
    `).join('');
    dd.appendChild(grid);
    btn.parentNode.appendChild(dd);
    btn.addEventListener('click',function(e){
        e.stopPropagation();
        dd.classList.toggle('open');
        this.classList.toggle('active');
    });
    document.addEventListener('click',function(e){
        if(!dd.contains(e.target)&&e.target!==btn)closeCatDropdown();
    });
}

function closeCatDropdown(){
    const dd=document.getElementById('catDropdown');
    const btn=document.querySelector('.cat-btn');
    if(dd)dd.classList.remove('open');
    if(btn)btn.classList.remove('active');
}

// Init on all pages
document.addEventListener('DOMContentLoaded',initCatDropdown);

// --- Mobile Drawer (WoodMart-style) ---
function initMobileDrawer(){
    const toggle=document.getElementById('mobileToggle');
    const drawer=document.getElementById('mDrawer');
    const overlay=document.getElementById('mDrawerOverlay');
    if(!toggle||!drawer||!overlay)return;

    function openDrawer(){
        drawer.classList.add('open');
        overlay.classList.add('open');
        document.body.classList.add('m-no-scroll');
    }
    function closeDrawer(){
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        document.body.classList.remove('m-no-scroll');
    }

    toggle.addEventListener('click',openDrawer);
    overlay.addEventListener('click',closeDrawer);

    // Close drawer when any link inside is clicked
    drawer.querySelectorAll('.m-link').forEach(a=>{
        a.addEventListener('click',closeDrawer);
    });

    // Tab switching
    const tabs=drawer.querySelectorAll('.m-tab');
    const panels=drawer.querySelectorAll('.m-tab-panel');
    tabs.forEach(tab=>{
        tab.addEventListener('click',function(){
            const target=this.dataset.tab;
            tabs.forEach(t=>t.classList.toggle('active',t===this));
            panels.forEach(p=>p.classList.toggle('active',p.dataset.panel===target));
        });
    });

    // Close on Escape
    document.addEventListener('keydown',e=>{
        if(e.key==='Escape'&&drawer.classList.contains('open'))closeDrawer();
    });
}
document.addEventListener('DOMContentLoaded',initMobileDrawer);

// --- Sync mobile bottom-nav & cart badges ---
function syncMobileBadges(){
    // cart badge
    const desktop=document.getElementById('cartBadge');
    const mobile=document.getElementById('mCartBadge');
    if(desktop&&mobile){
        const val=desktop.textContent||'0';
        mobile.textContent=val;
        mobile.style.display=(val==='0'||desktop.style.display==='none')?'none':'flex';
    }
    // wishlist count badge in bottom nav
    const wBadge=document.getElementById('mNavWishBadge');
    if(wBadge){
        try{
            const w=JSON.parse(localStorage.getItem('nfshop_wish'))||[];
            wBadge.textContent=w.length;
            wBadge.style.display=w.length>0?'flex':'none';
        }catch(e){wBadge.style.display='none'}
    }
    // compare count badge (currently no storage — keep at 0)
    const cBadge=document.getElementById('mNavCompareBadge');
    if(cBadge){
        try{
            const c=JSON.parse(localStorage.getItem('nfshop_compare'))||[];
            cBadge.textContent=c.length;
            cBadge.style.display=c.length>0?'flex':'none';
        }catch(e){cBadge.style.display='none'}
    }
}
document.addEventListener('DOMContentLoaded',syncMobileBadges);
// Re-sync periodically (cart updates from script may not fire an event)
setInterval(syncMobileBadges,1500);

// --- All Products Page ---
// Product data is injected by the server via window.NF_PRODUCTS.

const products = window.NF_PRODUCTS || [];
const PRODUCTS_FROM_SERVER = true;

const PER_PAGE = 12;
let filtered = [...products];
let currentPage = 1;
let activeFilters = {category:'all', priceMin:0, priceMax:Infinity, search:''};

function getDisc(pct){return Math.round((1-pct.cur/pct.old)*100)}

function renderProducts(){
    const grid=document.getElementById('productGrid');
    if(!grid)return;
    const start=(currentPage-1)*PER_PAGE;
    const page=filtered.slice(start,start+PER_PAGE);
    const totalPages=Math.ceil(filtered.length/PER_PAGE);

    if(page.length===0){
        grid.innerHTML='<div class="ap-empty"><i class="fas fa-search"></i><p>No products found matching your filters.</p><button class="btn-order-lg" onclick="clearFilters()">Clear Filters</button></div>';
        document.getElementById('resultCount').textContent='0';
        renderPagination(0);
        return;
    }

    grid.innerHTML=page.map(p=>{
        const disc=getDisc(p);
        const imgSrc = PRODUCTS_FROM_SERVER ? p.img : ('assets/images/products/' + p.img);
        const detailUrl = p.url || ('product-details.html?id=' + p.id);
        return `
            <div class="product-card fade-up show" data-id="${p.id}">
                ${disc>0?'<span class="badge">-'+disc+'%</span>':''}
                <button class="wish"><i class="far fa-heart"></i></button>
                <a href="${detailUrl}" class="img-wrap"><img src="${imgSrc}" alt="${p.title}"></a>
                <div class="info">
                    <div class="title">${p.title}</div>
                    <div class="stock"><i class="fas fa-check-circle"></i> ${p.stock} In Stock</div>
                    <div class="price">
                        <span class="cur">TK ${p.cur.toLocaleString()}</span>
                        ${disc>0?'<span class="old">TK '+p.old.toLocaleString()+'</span>':''}
                    </div>
                    <button class="btn-order"><i class="fas fa-shopping-cart"></i> Order Now</button>
                </div>
            </div>
        `;
    }).join('');

    document.getElementById('resultCount').textContent=filtered.length;
    renderPagination(totalPages);
    syncWishButtons();
}

function renderPagination(total){
    const el=document.getElementById('apPagination');
    if(!el)return;
    if(total<=1){el.innerHTML='';return}
    let html='';
    html+='<button onclick="goPage('+(currentPage-1)+')" '+(currentPage<=1?'disabled':'')+'><i class="fas fa-chevron-left"></i></button>';
    for(let i=1;i<=total;i++){
        html+='<button onclick="goPage('+i+')" '+(i===currentPage?'class="active"':'')+'>'+i+'</button>';
    }
    html+='<button onclick="goPage('+(currentPage+1)+')" '+(currentPage>=total?'disabled':'')+'><i class="fas fa-chevron-right"></i></button>';
    el.innerHTML=html;
}

function goPage(n){
    currentPage=n;
    renderProducts();
    window.scrollTo({top:document.querySelector('.ap-toolbar').offsetTop-150,behavior:'smooth'});
}

function filterProducts(){
    const inp=document.getElementById('searchInput');
    activeFilters.search=inp?inp.value.toLowerCase():'';
    applyFilters();
}

function setCategory(el, val){
    document.querySelectorAll('#filterCategory .filter-option').forEach(x=>x.classList.remove('active'));
    el.classList.add('active');
    activeFilters.category=val;
    applyFilters();
}

function setPriceRange(el, min, max){
    document.querySelectorAll('.filter-group:nth-child(2) .filter-option').forEach(x=>x.classList.remove('active'));
    el.classList.add('active');
    activeFilters.priceMin=min;
    activeFilters.priceMax=max;
    applyFilters();
}

function applyFilters(){
    filtered=products.filter(p=>{
        if(activeFilters.category!=='all' && p.cat!==activeFilters.category)return false;
        if(p.cur<activeFilters.priceMin||p.cur>activeFilters.priceMax)return false;
        if(activeFilters.search && !p.title.toLowerCase().includes(activeFilters.search))return false;
        return true;
    });
    currentPage=1;
    sortProducts(true);
}

function sortProducts(skipRender){
    const sel=document.getElementById('sortSelect');
    const val=sel?sel.value:'default';
    if(val==='price-asc')filtered.sort((a,b)=>a.cur-b.cur);
    else if(val==='price-desc')filtered.sort((a,b)=>b.cur-a.cur);
    else if(val==='name')filtered.sort((a,b)=>a.title.localeCompare(b.title));
    else if(val==='discount')filtered.sort((a,b)=>getDisc(b)-getDisc(a));
    else filtered.sort((a,b)=>a.id-b.id);
    if(!skipRender)renderProducts();
    else renderProducts();
}

function clearFilters(){
    document.querySelectorAll('.filter-option').forEach(x=>x.classList.remove('active'));
    const allCat=document.querySelector('#filterCategory .filter-option:first-child');
    if(allCat)allCat.classList.add('active');
    const allPrice=document.querySelector('.filter-group:nth-child(2) .filter-option:last-child');
    if(allPrice)allPrice.classList.add('active');
    const inp=document.getElementById('searchInput');
    if(inp)inp.value='';
    const sel=document.getElementById('sortSelect');
    if(sel)sel.value='default';
    activeFilters={category:'all', priceMin:0, priceMax:Infinity, search:''};
    filtered=[...products];
    currentPage=1;
    sortProducts(true);
}

function toggleSidebar(){
    const sb=document.getElementById('apSidebar');
    const ov=document.querySelector('.filter-overlay');
    if(!sb)return;
    sb.classList.toggle('open');
    if(ov)ov.classList.toggle('active');
}

// Init all-products page (only on all-products.html, not category page)
document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('productGrid') && !document.getElementById('catPageHeader')){
        const ov=document.createElement('div');
        ov.className='filter-overlay';
        ov.onclick=toggleSidebar;
        document.body.appendChild(ov);
        clearFilters();

        // Pre-fill from ?s= and apply
        const params=new URLSearchParams(window.location.search);
        const q=(params.get('s')||'').trim();
        if(q){
            const inp=document.getElementById('searchInput');
            const mInp=document.getElementById('mSearchInput');
            if(inp)inp.value=q;
            if(mInp)mInp.value=q;
            filterProducts();
        }

        // Live filter as the user types (no page reload)
        const desktop=document.getElementById('searchInput');
        const mobile=document.getElementById('mSearchInput');
        function bindLive(inp,other){
            if(!inp)return;
            const form=inp.closest('form');
            if(form){
                form.addEventListener('submit',e=>{e.preventDefault();if(other)other.value=inp.value;filterProducts();});
            }
            inp.addEventListener('input',()=>{if(other)other.value=inp.value;filterProducts();});
        }
        bindLive(desktop,mobile);
        bindLive(mobile,desktop);
    } else {
        // Outside the all-products page: keep the search form's default submit
        // behavior (navigate to /all-products?s=...). Nothing to wire up here.
    }
});

// --- Category Products Page ---

// Built from server-provided categories (window.NF_CATEGORIES) — real
// categories from the database only, no hardcoded demo data.
const catMeta = {};
(window.NF_CATEGORIES || []).forEach(function (c) {
    catMeta[c.slug] = { name: c.name, icon: c.icon || 'fa-tag', desc: 'Browse ' + c.name + ' products' };
});

let catFiltered = [];
let catPage = 1;

function initCategoryPage(){
    const grid=document.getElementById('productGrid');
    if(!grid)return;
    const params=new URLSearchParams(window.location.search);
    const cat=params.get('cat');
    if(!cat||!catMeta[cat]){document.querySelector('.ap-main').innerHTML='<div class="ap-empty"><i class="fas fa-exclamation-circle"></i><p>Category not found.</p><a href="all-products.html" class="btn-order-lg">Browse All Products</a></div>';return}
    const meta=catMeta[cat];
    document.getElementById('catTitle').innerHTML='<i class="fas '+meta.icon+'"></i> '+meta.name;
    document.getElementById('catDesc').textContent=meta.desc;
    document.getElementById('catBreadcrumb').textContent=meta.name;
    window._catKey=cat;
    catFiltered=products.filter(p=>p.cat===cat);
    catPage=1;
    renderCatProducts();
    const ov=document.createElement('div');
    ov.className='filter-overlay';
    ov.onclick=toggleCatSidebar;
    document.body.appendChild(ov);
}

function renderCatProducts(){
    const grid=document.getElementById('productGrid');
    if(!grid)return;
    const PER=12;
    const start=(catPage-1)*PER;
    const page=catFiltered.slice(start,start+PER);
    const total=Math.ceil(catFiltered.length/PER);
    if(page.length===0){
        grid.innerHTML='<div class="ap-empty"><i class="fas fa-search"></i><p>No products found.</p><button class="btn-order-lg" onclick="clearCatFilters()">Clear Filters</button></div>';
        document.getElementById('resultCount').textContent='0';
        renderCatPagination(0);
        return;
    }
    grid.innerHTML=page.map(p=>{
        const disc=Math.round((1-p.cur/p.old)*100);
        const imgSrc = PRODUCTS_FROM_SERVER ? p.img : ('assets/images/products/' + p.img);
        const detailUrl = p.url || ('product-details.html?id=' + p.id);
        return `
            <div class="product-card fade-up show" data-id="${p.id}">
                ${disc>0?'<span class="badge">-'+disc+'%</span>':''}
                <button class="wish"><i class="far fa-heart"></i></button>
                <a href="${detailUrl}" class="img-wrap"><img src="${imgSrc}" alt="${p.title}"></a>
                <div class="info">
                    <div class="title">${p.title}</div>
                    <div class="stock"><i class="fas fa-check-circle"></i> ${p.stock} In Stock</div>
                    <div class="price">
                        <span class="cur">TK ${p.cur.toLocaleString()}</span>
                        ${disc>0?'<span class="old">TK '+p.old.toLocaleString()+'</span>':''}
                    </div>
                    <button class="btn-order"><i class="fas fa-shopping-cart"></i> Order Now</button>
                </div>
            </div>
        `;
    }).join('');
    document.getElementById('resultCount').textContent=catFiltered.length;
    renderCatPagination(total);
    syncWishButtons();
}

function renderCatPagination(total){
    const el=document.getElementById('apPagination');
    if(!el)return;
    if(total<=1){el.innerHTML='';return}
    let h='';
    h+='<button onclick="catGoPage('+(catPage-1)+')"'+(catPage<=1?'disabled':'')+'><i class="fas fa-chevron-left"></i></button>';
    for(let i=1;i<=total;i++)h+='<button onclick="catGoPage('+i+')"'+(i===catPage?'class="active"':'')+'>'+i+'</button>';
    h+='<button onclick="catGoPage('+(catPage+1)+')"'+(catPage>=total?'disabled':'')+'><i class="fas fa-chevron-right"></i></button>';
    el.innerHTML=h;
}

function catGoPage(n){catPage=n;renderCatProducts();const t=document.querySelector('.ap-toolbar');if(t)window.scrollTo({top:t.offsetTop-150,behavior:'smooth'})}

let catPriceMin=0,catPriceMax=Infinity,catSearch='';
function filterCatProducts(){
    const inp=document.getElementById('searchInput');
    catSearch=inp?inp.value.toLowerCase():'';
    applyCatFilter();
}
function setCatPrice(el,mn,mx){
    document.querySelectorAll('#apSidebar .filter-group .filter-option').forEach(x=>x.classList.remove('active'));
    el.classList.add('active');
    catPriceMin=mn;catPriceMax=mx;
    applyCatFilter();
}
function applyCatFilter(){
    catFiltered=products.filter(p=>{
        if(p.cat!==window._catKey)return false;
        if(p.cur<catPriceMin||p.cur>catPriceMax)return false;
        if(catSearch&&!p.title.toLowerCase().includes(catSearch))return false;
        return true;
    });
    catPage=1;
    sortCatProducts(true);
}
function sortCatProducts(skip){
    const sel=document.getElementById('sortSelect');
    const v=sel?sel.value:'default';
    if(v==='price-asc')catFiltered.sort((a,b)=>a.cur-b.cur);
    else if(v==='price-desc')catFiltered.sort((a,b)=>b.cur-a.cur);
    else if(v==='name')catFiltered.sort((a,b)=>a.title.localeCompare(b.title));
    else if(v==='discount')catFiltered.sort((a,b)=>Math.round((1-b.cur/b.old)*100)-Math.round((1-a.cur/a.old)*100));
    else catFiltered.sort((a,b)=>a.id-b.id);
    renderCatProducts();
}
function clearCatFilters(){
    document.querySelectorAll('#apSidebar .filter-option').forEach(x=>x.classList.remove('active'));
    const ap=document.querySelector('#apSidebar .filter-group .filter-option:last-child');
    if(ap)ap.classList.add('active');
    const inp=document.getElementById('searchInput');
    if(inp)inp.value='';
    const sel=document.getElementById('sortSelect');
    if(sel)sel.value='default';
    catPriceMin=0;catPriceMax=Infinity;catSearch='';
    const k=window._catKey;
    catFiltered=products.filter(p=>p.cat===k);
    catPage=1;
    renderCatProducts();
}
function toggleCatSidebar(){
    const sb=document.getElementById('apSidebar');
    const ov=document.querySelector('.filter-overlay');
    if(!sb)return;
    sb.classList.toggle('open');
    if(ov)ov.classList.toggle('active');
}

// Init category page
document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('catPageHeader'))initCategoryPage();
});

// --- Toast notifications ---

function nfToast(message, type){
    let host = document.getElementById('nfToastHost');
    if(!host){
        host = document.createElement('div');
        host.id = 'nfToastHost';
        Object.assign(host.style, {
            position:'fixed', bottom:'24px', right:'24px', zIndex:'100000',
            display:'flex', flexDirection:'column', gap:'10px',
            pointerEvents:'none', maxWidth:'320px'
        });
        document.body.appendChild(host);
    }
    const colors = {
        success:{bg:'#10b981', icon:'fa-check-circle'},
        info:   {bg:'#3b82f6', icon:'fa-info-circle'},
        error:  {bg:'#ef4444', icon:'fa-times-circle'},
    };
    const c = colors[type] || colors.success;
    const el = document.createElement('div');
    el.innerHTML = '<i class="fas '+c.icon+'" style="margin-right:8px"></i>'+message;
    Object.assign(el.style, {
        background:c.bg, color:'#fff', padding:'12px 16px', borderRadius:'8px',
        fontSize:'14px', fontWeight:'500', boxShadow:'0 8px 24px rgba(0,0,0,.18)',
        transform:'translateX(120%)', transition:'transform .25s ease, opacity .25s ease',
        pointerEvents:'auto'
    });
    host.appendChild(el);
    requestAnimationFrame(()=>{ el.style.transform = 'translateX(0)'; });
    setTimeout(()=>{
        el.style.opacity = '0';
        el.style.transform = 'translateX(120%)';
        setTimeout(()=>el.remove(), 280);
    }, 2200);
}

// --- Wishlist ---

function getWishlist(){return JSON.parse(localStorage.getItem('nfshop_wish'))||[]}
function saveWishlist(w){localStorage.setItem('nfshop_wish',JSON.stringify(w))}

function updateWishBadge(){
    const count = getWishlist().length;
    const desktop = document.getElementById('wishBadge');
    if(desktop){
        desktop.textContent = count;
        desktop.style.display = count > 0 ? 'flex' : 'none';
    }
    // Bottom-nav badge on mobile is handled by syncMobileBadges
    if (typeof syncMobileBadges === 'function') syncMobileBadges();
}

function productNameFromBtn(btn){
    const card = btn ? btn.closest('.product-card') : null;
    if(!card) return 'Product';
    const t = card.querySelector('.title');
    return t ? t.textContent.trim() : 'Product';
}

function toggleWish(id,btn){
    let w=getWishlist();
    const i=w.indexOf(id);
    const name = productNameFromBtn(btn);
    if(i>-1){
        w.splice(i,1);
        if(btn){btn.classList.remove('active');btn.querySelector('i').className='far fa-heart'}
        saveWishlist(w);
        updateWishBadge();
        nfToast('Removed from wishlist: '+name, 'info');
    } else {
        w.push(id);
        if(btn){btn.classList.add('active');btn.querySelector('i').className='fas fa-heart'}
        saveWishlist(w);
        updateWishBadge();
        nfToast('Added to wishlist: '+name, 'success');
    }
}

function isWished(id){return getWishlist().indexOf(id)>-1}

function syncWishButtons(){
    const w=getWishlist();
    document.querySelectorAll('.product-card .wish').forEach(btn=>{
        const card=btn.closest('.product-card')||btn.closest('[data-id]');
        let id=null;
        if(card&&card.dataset&&card.dataset.id)id=parseInt(card.dataset.id);
        else{
            const img=card?card.querySelector('img'):null;
            const src=img?img.getAttribute('src'):'';
            const match=src.match(/(\d+)[^/]*\.(jpg|jpeg|webp|png)/);
            if(match)id=parseInt(match[1]);
        }
        if(id&&w.includes(id)){btn.classList.add('active');btn.querySelector('i').className='fas fa-heart'}
        else{btn.classList.remove('active');btn.querySelector('i').className='far fa-heart'}
        btn.onclick=function(e){e.stopPropagation();toggleWish(id,this)};
    });
}

document.addEventListener('DOMContentLoaded',()=>{ syncWishButtons(); updateWishBadge(); });

// Wishlist Page
function initWishlistPage(){
    const grid=document.getElementById('wishlistGrid');
    if(!grid)return;
    let w=getWishlist();
    const items=products.filter(p=>w.includes(p.id));
    // Remove stale ids (deleted/unpublished products) from the saved wishlist
    const validIds=items.map(p=>p.id);
    if(validIds.length!==w.length){
        w=validIds;
        saveWishlist(w);
        updateWishBadge();
    }
    document.getElementById('wishlistCount').textContent=items.length;
    if(items.length===0){
        grid.innerHTML='';
        document.getElementById('wishlistEmpty').style.display='block';
        document.getElementById('wishlistHeaderDesc').textContent='No saved items yet';
        return;
    }
    document.getElementById('wishlistEmpty').style.display='none';
    document.getElementById('wishlistHeaderDesc').textContent=items.length+' saved item(s)';
    grid.innerHTML=items.map(p=>{
        const disc=Math.round((1-p.cur/p.old)*100);
        const imgSrc = PRODUCTS_FROM_SERVER ? p.img : ('assets/images/products/' + p.img);
        const detailUrl = p.url || ('product-details.html?id=' + p.id);
        const oos = typeof p.stock === 'number' && p.stock <= 0;
        const stockLine = oos
            ? '<span style="color:#dc2626"><i class="fas fa-times-circle"></i> Out of Stock</span>'
            : (typeof p.stock === 'number' ? '<i class="fas fa-check-circle"></i> ' + p.stock + ' In Stock' : '<i class="fas fa-check-circle"></i> In Stock');
        const cartBtn = oos
            ? '<button class="btn-order" disabled style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af"><i class="fas fa-times-circle"></i> Out of Stock</button>'
            : '<button class="btn-order" onclick="event.stopPropagation();addToCart('+p.id+')"><i class="fas fa-shopping-cart"></i> Add to Cart</button>';
        return `
            <div class="product-card fade-up show" data-id="${p.id}">
                ${disc>0?'<span class="badge">-'+disc+'%</span>':''}
                ${oos?'<span class="badge" style="background:#dc2626;top:36px">Out of Stock</span>':''}
                <button class="wish active" onclick="event.stopPropagation();toggleWish(${p.id},this);initWishlistPage()"><i class="fas fa-heart"></i></button>
                <a href="${detailUrl}" class="img-wrap"><img src="${imgSrc}" alt="${p.title}"${oos?' style="opacity:.6"':''}></a>
                <div class="info">
                    <a href="${detailUrl}" class="title">${p.title}</a>
                    <div class="stock">${stockLine}</div>
                    <div class="price">
                        <span class="cur">TK ${p.cur.toLocaleString()}</span>
                        ${disc>0?'<span class="old">TK '+p.old.toLocaleString()+'</span>':''}
                    </div>
                    ${cartBtn}
                </div>
            </div>
        `;
    }).join('');
}

function productNameById(id){
    const card = document.querySelector('.product-card[data-id="'+id+'"]');
    if(!card) return 'Product';
    const t = card.querySelector('.title');
    return t ? t.textContent.trim() : 'Product';
}

// --- Server-side cart sync ---
let _cartSyncTimer = null;
function syncCartToServer() {
    clearTimeout(_cartSyncTimer);
    _cartSyncTimer = setTimeout(function () {
        const cart = JSON.parse(localStorage.getItem('nfshop_cart')) || [];
        const csrf = window.NF_CSRF || document.querySelector('meta[name="csrf-token"]')?.content || '';

        // Include logged-in user details if available
        const loggedUser = JSON.parse(localStorage.getItem('nfshop_logged')) || null;
        let userName = null, userEmail = null, userPhone = null;
        if (loggedUser) {
            userName  = loggedUser.name  || null;
            userEmail = loggedUser.email || null;
            // Phone is stored in nfshop_users array
            const allUsers = JSON.parse(localStorage.getItem('nfshop_users')) || [];
            const u = allUsers.find(function (x) { return x.email === userEmail; });
            userPhone = u ? (u.phone || null) : null;
        }

        fetch('/cart/sync', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ items: cart, user_name: userName, user_email: userEmail, user_phone: userPhone }),
        }).catch(function () {});
    }, 800);
}

function addToCart(id, redirectToCheckout){
    const p = products.find(x => x.id === id);
    if (p && typeof p.stock === 'number' && p.stock <= 0) {
        nfToast('"' + (p.title || 'This product') + '" is out of stock.', 'error');
        return;
    }
    let cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    const item=cart.find(x=>x.id===id && !x.variant_id);
    // Check requested qty vs available stock
    if (p && typeof p.stock === 'number') {
        const newQty = item ? item.qty + 1 : 1;
        if (newQty > p.stock) {
            nfToast('Only ' + p.stock + ' left in stock for "' + (p.title || 'this product') + '".', 'error');
            return;
        }
    }
    if(item)item.qty+=1;
    else cart.push({id:id,qty:1,variant_id:null,variant_label:null});
    localStorage.setItem('nfshop_cart',JSON.stringify(cart));
    updateCartBadge(cart.reduce((s,i)=>s+i.qty,0));
    if (redirectToCheckout) {
        syncCartToServer();
        window.location.href = window.NF_CHECKOUT_URL || '/checkout';
        return;
    }
    nfToast('Added to cart: ' + productNameById(id), 'success');
    syncCartToServer();
}

// Delegated click handler for "Order Now" / "Add to Cart" buttons on
// server-rendered product cards (home, product-details, related, etc.).
// Cards rendered by JS (wishlist, dashboard) already wire onclick inline.
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.product-card .btn-order, .product-card .btn-cart');
    if (!btn || btn.dataset.bound === '1') return;
    if (btn.hasAttribute('onclick')) return; // respect inline handlers
    if (btn.disabled) return; // skip disabled (out-of-stock) buttons
    const card = btn.closest('.product-card');
    const id = card ? parseInt(card.dataset.id) : NaN;
    if (!id) return;
    e.preventDefault();
    e.stopPropagation();
    const isOrderNow = btn.classList.contains('btn-order');
    addToCart(id, isOrderNow);
});

document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('wishlistGrid'))initWishlistPage();
});

// --- Auth Pages ---

function togglePass(id,btn){
    const inp=document.getElementById(id);
    if(!inp)return;
    if(inp.type==='password'){inp.type='text';btn.innerHTML='<i class="far fa-eye-slash"></i>'}
    else{inp.type='password';btn.innerHTML='<i class="far fa-eye"></i>'}
}

function handleLogin(e){
    e.preventDefault();
    const email=document.getElementById('loginEmail').value;
    const pass=document.getElementById('loginPassword').value;
    if(!email||!pass)return false;
    const users=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    const user=users.find(u=>u.email===email&&u.password===pass);
    if(user){
        localStorage.setItem('nfshop_logged',JSON.stringify({email:user.email,name:user.first+' '+user.last}));
        window.location.href='/dashboard';
    }else{
        alert('Invalid email or password. Please try again.');
    }
    return false;
}

function handleRegister(e){
    e.preventDefault();
    const first=document.getElementById('regFirst').value.trim();
    const last=document.getElementById('regLast').value.trim();
    const email=document.getElementById('regEmail').value.trim();
    const phone=document.getElementById('regPhone').value.trim();
    const pass=document.getElementById('regPassword').value;
    const confirm=document.getElementById('regConfirm').value;
    if(pass!==confirm){alert('Passwords do not match.');return false}
    if(pass.length<6){alert('Password must be at least 6 characters.');return false}
    let users=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    if(users.find(u=>u.email===email)){alert('An account with this email already exists.');return false}
    users.push({first,last,email,phone,password:pass});
    localStorage.setItem('nfshop_users',JSON.stringify(users));
    localStorage.setItem('nfshop_logged',JSON.stringify({email,name:first+' '+last}));
    alert('Account created successfully! Welcome, '+first+'.');
    window.location.href='/dashboard';
    return false;
}

function handleForgot(e){
    e.preventDefault();
    const email=document.getElementById('forgotEmail').value.trim();
    if(!email)return false;
    document.getElementById('forgotSentEmail').textContent=email;
    document.querySelector('.auth-form').style.display='none';
    document.getElementById('forgotSuccess').style.display='block';
    return false;
}

function handleReset(e){
    e.preventDefault();
    const pass=document.getElementById('resetPass').value;
    const confirm=document.getElementById('resetConfirm').value;
    if(pass!==confirm){alert('Passwords do not match.');return false}
    if(pass.length<6){alert('Password must be at least 6 characters.');return false}
    document.querySelector('.auth-form').style.display='none';
    document.getElementById('resetSuccess').style.display='block';
    return false;
}

document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('resetPass')){
        const check=()=>{
            const pass=document.getElementById('resetPass').value;
            const confirm=document.getElementById('resetConfirm').value;
            const elLen=document.getElementById('phLength');
            const elMatch=document.getElementById('phMatch');
            if(pass.length>=6){elLen.className='valid';elLen.innerHTML='<i class="fas fa-check-circle"></i> At least 6 characters'}
            else{elLen.className='';elLen.innerHTML='<i class="far fa-circle"></i> At least 6 characters'}
            if(confirm&&pass===confirm){elMatch.className='valid';elMatch.innerHTML='<i class="fas fa-check-circle"></i> Passwords match'}
            else if(confirm){elMatch.className='invalid';elMatch.innerHTML='<i class="fas fa-times-circle"></i> Passwords match'}
            else{elMatch.className='';elMatch.innerHTML='<i class="far fa-circle"></i> Passwords match'}
        };
        document.getElementById('resetPass').addEventListener('input',check);
        document.getElementById('resetConfirm').addEventListener('input',check);
    }
});

// Update header account link if logged in
document.addEventListener('DOMContentLoaded',()=>{
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    if(user){
        const links=document.querySelectorAll('.header-actions a');
        links.forEach(a=>{
            if(a.querySelector('.fa-user')){
                a.href='/dashboard';
                a.innerHTML='<i class="fas fa-user-circle"></i> <span>'+user.name.split(' ')[0]+'</span>';
            }
        });
    }
});

// Show login prompt if not logged in
document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('dashUserName')){
        const user=JSON.parse(localStorage.getItem('nfshop_logged'));
        if(!user){
            document.querySelector('.dash-layout').style.display='none';
            const msg=document.createElement('div');
            msg.className='dash-login-msg';
            msg.innerHTML=`
                <div class="auth-card" style="margin:60px auto;text-align:center">
                    <div class="auth-icon"><i class="fas fa-user-circle"></i></div>
                    <h2 style="font-size:22px;font-weight:800;color:var(--text);margin-bottom:6px">Please Login First</h2>
                    <p style="font-size:14px;color:var(--text-light);margin-bottom:24px">You need to sign in to access your dashboard.</p>
                    <a href="/login" class="btn-auth" style="display:inline-flex;text-decoration:none;width:auto;padding:12px 32px"><i class="fas fa-sign-in-alt"></i> Go to Login</a>
                    <div style="margin-top:14px;font-size:13px;color:var(--text-light)">Don't have an account? <a href="/register" style="color:var(--secondary);font-weight:600;text-decoration:none">Create Account</a></div>
                </div>
            `;
            document.querySelector('.dash-section .container').appendChild(msg);
            return;
        }
    }
});

// --- Dashboard ---

let dashCurrentTab='overview';
let dashOrders=[];
let dashOrderFilter='all';

function switchDashTab(tab,btn){
    document.querySelectorAll('.dash-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.dash-nav-item').forEach(b=>b.classList.remove('active'));
    document.getElementById('dash'+tab.charAt(0).toUpperCase()+tab.slice(1)).classList.add('active');
    if(btn)btn.classList.add('active');
    dashCurrentTab=tab;
    if(tab==='orders')renderDashOrders();
    if(tab==='wishlist')renderDashWishlist();
}

function initDashboard(){
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    if(!user)return;
    const name=user.name||'User';
    const email=user.email||'';
    const first=name.split(' ')[0]||name;
    document.getElementById('dashUserName').textContent=name;
    document.getElementById('dashUserEmail').textContent=email;
    document.getElementById('dashWelcomeName').textContent=first;
    document.getElementById('dashFirst').value=(user.name||'').split(' ')[0]||'';
    document.getElementById('dashLast').value=(user.name||'').split(' ').slice(1).join(' ')||'';
    document.getElementById('dashEmail').value=email;
    const allUsers=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    const u=allUsers.find(x=>x.email===email);
    if(u)document.getElementById('dashPhone').value=u.phone||'';
    updateDashStats();
    renderDashRecentOrders();
    renderDashOrders();
    updateDashBadges();
    fetchDashboardData();
}

async function fetchDashboardData(){
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    if(!user)return;
    const email=user.email||'';
    const allUsers=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    const u=allUsers.find(x=>x.email===email);
    const phone=user.phone||u?.phone||document.getElementById('dashPhone').value||'';

    const url=(window.NF_DASHBOARD_DATA_URL||'/dashboard/data')
        +'?email='+encodeURIComponent(email)
        +'&phone='+encodeURIComponent(phone);

    try{
        const res=await fetch(url,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
        if(!res.ok)throw new Error('HTTP '+res.status);
        const data=await res.json();
        window.NF_DASH=data;
        dashOrders=Array.isArray(data.orders)?data.orders:[];

        if(data.customer){
            const c=data.customer;
            if(c.name){
                const first=(c.name.split(' ')[0])||c.name;
                const last=c.name.split(' ').slice(1).join(' ')||'';
                document.getElementById('dashUserName').textContent=c.name;
                document.getElementById('dashWelcomeName').textContent=first;
                document.getElementById('dashFirst').value=first;
                document.getElementById('dashLast').value=last;
            }
            if(c.email){
                document.getElementById('dashUserEmail').textContent=c.email;
                document.getElementById('dashEmail').value=c.email;
            }
            if(c.phone){
                document.getElementById('dashPhone').value=c.phone;
            }
        }

        updateDashStats();
        renderDashRecentOrders();
        renderDashOrders();
        updateDashBadges();
    }catch(err){
        console.warn('Dashboard data load failed:',err);
    }
}

function updateDashStats(){
    const cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    const wish=getWishlist();
    let totalSpent=0;
    dashOrders.forEach(o=>{
        if(o.status!=='cancelled')totalSpent+=parseFloat(o.total||0);
    });
    document.getElementById('statOrders').textContent=dashOrders.length;
    document.getElementById('statSpent').textContent='TK '+totalSpent.toLocaleString();
    document.getElementById('statWishlist').textContent=wish.length;
    document.getElementById('statCart').textContent=cart.reduce((s,i)=>s+i.qty,0);
}

function updateDashBadges(){
    const wish=getWishlist();
    const ob=document.getElementById('orderCountBadge');
    if(ob)ob.textContent=dashOrders.length;
    const wb=document.getElementById('wishCountBadge');
    if(wb)wb.textContent=wish.length;
}

const dashStatusMeta={
    pending:   {label:'Pending',   color:'#b45309',bg:'#fef3c7',icon:'fa-clock'},
    confirmed: {label:'Confirmed', color:'#1d4ed8',bg:'#dbeafe',icon:'fa-check'},
    processing:{label:'Processing',color:'#4338ca',bg:'#e0e7ff',icon:'fa-cog'},
    shipped:   {label:'Shipped',   color:'#0891b2',bg:'#cffafe',icon:'fa-shipping-fast'},
    delivered: {label:'Delivered', color:'#15803d',bg:'#dcfce7',icon:'fa-check-circle'},
    cancelled: {label:'Cancelled', color:'#b91c1c',bg:'#fee2e2',icon:'fa-times-circle'},
    returned:  {label:'Returned',  color:'#475569',bg:'#f1f5f9',icon:'fa-undo'},
};

function dashEscape(s){return String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]))}

function renderDashOrdersTable(orders,tbodyId,emptyId,limit){
    const tbody=document.getElementById(tbodyId);
    const empty=document.getElementById(emptyId);
    if(!tbody)return;
    const list=limit?orders.slice(0,limit):orders;
    if(list.length===0){
        tbody.innerHTML='';
        if(empty)empty.style.display='block';
        return;
    }
    if(empty)empty.style.display='none';
    const ocUrl=window.NF_ORDER_COMPLETE_URL||'/order-complete';
    tbody.innerHTML=list.map(o=>{
        const sm=dashStatusMeta[o.status]||{label:o.status,color:'#64748b',bg:'#f1f5f9',icon:'fa-clock'};
        const total=parseFloat(o.total||0);
        const itemCount=Array.isArray(o.items)?o.items.reduce((s,i)=>s+parseFloat(i.qty||1),0):0;
        const href=ocUrl+'?id='+encodeURIComponent(o.id);
        return `
            <tr>
                <td><a href="${href}" class="dash-order-id">${dashEscape(o.id)}</a></td>
                <td>${dashEscape(o.date)}</td>
                <td>${itemCount}</td>
                <td><strong>TK ${total.toLocaleString()}</strong></td>
                <td><span class="dash-status" style="background:${sm.bg};color:${sm.color}"><i class="fas ${sm.icon}"></i> ${sm.label}</span></td>
                <td><a href="${href}" class="dash-view-btn">View</a></td>
            </tr>
        `;
    }).join('');
}

function renderDashRecentOrders(){
    renderDashOrdersTable(dashOrders,'recentOrdersBody','recentOrdersEmpty',5);
}

function renderDashOrders(){
    const list=dashOrderFilter==='all'
        ?dashOrders
        :dashOrders.filter(o=>o.status===dashOrderFilter);
    renderDashOrdersTable(list,'ordersBody','ordersEmpty');
}

function dashFilterOrders(status,btn){
    dashOrderFilter=status;
    document.querySelectorAll('.dfc').forEach(b=>b.classList.remove('active'));
    if(btn)btn.classList.add('active');
    renderDashOrders();
}

function renderDashWishlist(){
    const grid=document.getElementById('dashWishlistGrid');
    const empty=document.getElementById('dashWishlistEmpty');
    if(!grid)return;
    const w=getWishlist();
    const items=(typeof products!=='undefined'?products:[]).filter(p=>w.includes(p.id));
    if(items.length===0){
        grid.innerHTML='';
        empty.style.display='block';
        return;
    }
    empty.style.display='none';
    grid.innerHTML=items.map(p=>{
        const disc=Math.round((1-p.cur/p.old)*100);
        const imgSrc=PRODUCTS_FROM_SERVER?p.img:('assets/images/products/'+p.img);
        const detailsUrl=p.url||((PRODUCTS_FROM_SERVER?'/product-details':'product-details.html')+'?id='+p.id);
        const oos2 = typeof p.stock === 'number' && p.stock <= 0;
        const dashCartBtn = oos2
            ? '<button class="btn-order" disabled style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af"><i class="fas fa-times-circle"></i> Out of Stock</button>'
            : '<button class="btn-order" onclick="event.stopPropagation();addToCart('+p.id+')"><i class="fas fa-shopping-cart"></i> Add to Cart</button>';
        const dashStockLine = oos2
            ? '<span style="color:#dc2626"><i class="fas fa-times-circle"></i> Out of Stock</span>'
            : '<span style="color:#16a34a"><i class="fas fa-check-circle"></i> In Stock</span>';
        return `
            <div class="product-card fade-up show" data-id="${p.id}">
                ${disc>0?'<span class="badge">-'+disc+'%</span>':''}
                <button class="wish active" onclick="event.stopPropagation();toggleWish(${p.id},this);renderDashWishlist();updateDashBadges();updateDashStats()"><i class="fas fa-heart"></i></button>
                <a href="${detailsUrl}" class="img-wrap"><img src="${imgSrc}" alt="${dashEscape(p.title)}"></a>
                <div class="info">
                    <div class="title">${dashEscape(p.title)}</div>
                    <div class="stock">${dashStockLine}</div>
                    <div class="price">
                        <span class="cur">TK ${p.cur.toLocaleString()}</span>
                        ${disc>0?'<span class="old">TK '+p.old.toLocaleString()+'</span>':''}
                    </div>
                    ${dashCartBtn}
                </div>
            </div>
        `;
    }).join('');
}

async function updateProfile(e){
    e.preventDefault();
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    if(!user)return false;
    const first=document.getElementById('dashFirst').value.trim();
    const last=document.getElementById('dashLast').value.trim();
    const email=document.getElementById('dashEmail').value.trim();
    const phone=document.getElementById('dashPhone').value.trim();
    if(!first||!email){alert('Please fill in required fields.');return false}

    const newName=(first+' '+last).trim();

    let serverOk=true;
    let serverMsg='';
    try{
        const res=await fetch(window.NF_DASHBOARD_PROFILE_URL||'/dashboard/profile',{
            method:'PUT',
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':window.NF_CSRF||'',
                'X-Requested-With':'XMLHttpRequest',
            },
            body:JSON.stringify({
                identifier_email:user.email||'',
                identifier_phone:phone||'',
                name:newName,
                email:email||null,
                phone:phone||null,
            }),
        });
        const data=await res.json().catch(()=>({}));
        if(!res.ok){
            serverOk=false;
            serverMsg=data.message||'Could not sync to server.';
        }
    }catch(err){
        serverOk=false;
        serverMsg='Network error: could not sync profile.';
    }

    let users=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    const idx=users.findIndex(u=>u.email===user.email);
    if(idx>-1){
        users[idx].first=first;
        users[idx].last=last;
        users[idx].email=email;
        users[idx].phone=phone;
        localStorage.setItem('nfshop_users',JSON.stringify(users));
    }
    localStorage.setItem('nfshop_logged',JSON.stringify({email,name:newName}));
    document.getElementById('dashUserName').textContent=newName;
    document.getElementById('dashUserEmail').textContent=email;
    document.getElementById('dashWelcomeName').textContent=first;

    if(serverOk){
        alert('Profile updated successfully!');
        fetchDashboardData();
    }else{
        alert('Profile saved locally. '+serverMsg);
    }
    return false;
}

function changePassword(e){
    e.preventDefault();
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    if(!user)return false;
    const current=document.getElementById('dashCurrentPass').value;
    const newPass=document.getElementById('dashNewPass').value;
    const confirm=document.getElementById('dashConfirmPass').value;
    if(newPass!==confirm){alert('New passwords do not match.');return false}
    if(newPass.length<6){alert('Password must be at least 6 characters.');return false}
    let users=JSON.parse(localStorage.getItem('nfshop_users'))||[];
    const u=users.find(x=>x.email===user.email);
    if(!u||u.password!==current){alert('Current password is incorrect.');return false}
    u.password=newPass;
    localStorage.setItem('nfshop_users',JSON.stringify(users));
    document.getElementById('dashCurrentPass').value='';
    document.getElementById('dashNewPass').value='';
    document.getElementById('dashConfirmPass').value='';
    alert('Password changed successfully!');
    return false;
}

function handleLogout(){
    if(confirm('Are you sure you want to logout?')){
        localStorage.removeItem('nfshop_logged');
        const csrf = window.NF_CSRF || document.querySelector('meta[name="csrf-token"]')?.content || '';
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';
        form.innerHTML = '<input type="hidden" name="_token" value="'+csrf+'">';
        document.body.appendChild(form);
        form.submit();
    }
}

// Init dashboard page
document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('dashUserName'))initDashboard();
});

// --- Track Order ---

const statusMeta={
    pending:   {label:'Pending',   color:'#b45309',bg:'#fef3c7',icon:'fa-clock'},
    confirmed: {label:'Confirmed', color:'#1d4ed8',bg:'#dbeafe',icon:'fa-check'},
    processing:{label:'Processing',color:'#4338ca',bg:'#e0e7ff',icon:'fa-cog'},
    shipped:   {label:'Shipped',   color:'#0891b2',bg:'#cffafe',icon:'fa-shipping-fast'},
    delivered: {label:'Delivered', color:'#15803d',bg:'#dcfce7',icon:'fa-check-circle'},
    cancelled: {label:'Cancelled', color:'#b91c1c',bg:'#fee2e2',icon:'fa-times-circle'},
    returned:  {label:'Returned',  color:'#475569',bg:'#f1f5f9',icon:'fa-undo'},
};

function trackEscape(s){return String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]))}

async function trackOrder(){
    const inp=document.getElementById('orderInput');
    const id=inp?inp.value.trim().toUpperCase():'';
    const result=document.getElementById('trackResult');
    if(!id){alert('Please enter an order ID.');return}

    result.style.display='block';
    result.innerHTML=`
        <div class="track-search-card" style="max-width:560px;margin:0 auto">
            <div class="ts-card-icon"><i class="fas fa-circle-notch fa-spin"></i></div>
            <h2>Looking up your order...</h2>
            <p>Fetching the latest status for <strong>${trackEscape(id)}</strong></p>
        </div>
    `;

    const url=(window.NF_TRACK_LOOKUP_URL||'/track-order/lookup')+'?id='+encodeURIComponent(id);
    try{
        const res=await fetch(url,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
        const data=await res.json().catch(()=>({}));
        if(!res.ok||!data.success||!data.order){
            result.innerHTML=`
                <div class="track-search-card" style="max-width:560px;margin:0 auto">
                    <div class="ts-card-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 8px 30px rgba(239,68,68,.3)"><i class="fas fa-exclamation-circle"></i></div>
                    <h2>Order Not Found</h2>
                    <p>${trackEscape(data.message||('No order found with ID "'+id+'".'))}<br>Please check the ID and try again.</p>
                    <button class="btn-auth" onclick="document.getElementById('trackResult').style.display='none';document.getElementById('orderInput').value='';document.getElementById('orderInput').focus()"><i class="fas fa-redo"></i> Try Again</button>
                </div>
            `;
            window.scrollTo({top:result.offsetTop-140,behavior:'smooth'});
            return;
        }
        renderTrackResult(data.order);
    }catch(err){
        result.innerHTML=`
            <div class="track-search-card" style="max-width:560px;margin:0 auto">
                <div class="ts-card-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626)"><i class="fas fa-wifi"></i></div>
                <h2>Connection Error</h2>
                <p>Could not reach the server. Please check your connection and try again.</p>
                <button class="btn-auth" onclick="trackOrder()"><i class="fas fa-redo"></i> Retry</button>
            </div>
        `;
    }
}

function renderTrackResult(order){
    const result=document.getElementById('trackResult');
    const sm=statusMeta[order.status]||{label:order.status,color:'#64748b',bg:'#f1f5f9',icon:'fa-clock'};
    const total=parseFloat(order.total||0)||(parseFloat(order.subtotal||0)+parseFloat(order.shipping||0)-parseFloat(order.discount||0));
    const subtotal=parseFloat(order.subtotal||0);
    const shipping=parseFloat(order.shipping||0);
    const discount=parseFloat(order.discount||0);
    const itemQty=Array.isArray(order.items)?order.items.reduce((s,i)=>s+parseFloat(i.qty||0),0):0;
    let activeFound=false;
    result.style.display='block';
    result.innerHTML=`
        <div class="track-order-bar">
            <div class="ob-left">
                <h3>${trackEscape(order.id)}</h3>
                <p>Placed on ${trackEscape(order.date||'-')} &middot; ${itemQty} item(s)</p>
            </div>
            <div class="ob-right">
                <span class="status-badge" style="background:${sm.bg};color:${sm.color}"><i class="fas ${sm.icon}"></i> ${sm.label}</span>
                ${order.est?`<p style="font-size:12px;color:var(--text-light);margin-top:4px">Est. delivery: ${trackEscape(order.est)}</p>`:''}
            </div>
        </div>

        <div class="track-timeline">
            <h3><i class="fas fa-road"></i> Order Timeline</h3>
            <div class="timeline">
                ${(order.timeline||[]).map(t=>{
                    const cls=t.done?'done':(!activeFound?'active':'');
                    if(!activeFound&&!t.done)activeFound=true;
                    return `
                        <div class="timeline-step ${cls}">
                            <div class="tl-dot"><i class="fas ${t.icon}"></i></div>
                            <div class="tl-info">
                                <h4>${trackEscape(t.label)}</h4>
                                <p>${trackEscape(t.date)}</p>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        </div>

        <div class="track-items">
            <h3><i class="fas fa-box"></i> Order Items</h3>
            ${(order.items||[]).map(i=>{
                const lineTotal=parseFloat(i.total||0)||(parseFloat(i.price||0)*parseFloat(i.qty||0));
                const imgSrc=i.thumbnail||'';
                return `
                    <div class="track-item">
                        <div class="track-item-img">${imgSrc?`<img src="${imgSrc}" alt="${trackEscape(i.title)}">`:'<i class="fas fa-box" style="color:#cbd5e1;font-size:24px"></i>'}</div>
                        <div class="track-item-info">
                            <h4>${trackEscape(i.title)}</h4>
                            <p>Qty: ${parseFloat(i.qty).toLocaleString()} × TK ${parseFloat(i.price).toLocaleString()}</p>
                        </div>
                        <div class="track-item-total">TK ${lineTotal.toLocaleString()}</div>
                    </div>
                `;
            }).join('')}
            <div style="display:flex;justify-content:space-between;padding-top:12px;border-top:1px solid #f1f5f9;margin-top:8px;font-size:13px;color:var(--text-light)">
                <span>Subtotal</span><span style="font-weight:600;color:var(--text)">TK ${subtotal.toLocaleString()}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-light);padding:4px 0">
                <span>Shipping</span><span style="font-weight:600;color:var(--text)">${shipping===0?'FREE':'TK '+shipping.toLocaleString()}</span>
            </div>
            ${discount>0?`
            <div style="display:flex;justify-content:space-between;font-size:13px;color:#16a34a;padding:4px 0">
                <span>Discount</span><span style="font-weight:600">-TK ${discount.toLocaleString()}</span>
            </div>`:''}
            <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:900;color:var(--text);padding-top:8px;border-top:2px solid #f1f5f9;margin-top:4px">
                <span>Total</span><span style="color:var(--secondary)">TK ${total.toLocaleString()}</span>
            </div>
        </div>

        <div class="track-delivery">
            <h3><i class="fas fa-map-marker-alt"></i> Delivery Details</h3>
            <div class="track-delivery-item">
                <h4><i class="fas fa-user"></i> Customer</h4>
                <p>${trackEscape(order.address.name)}<br>${trackEscape(order.address.phone)}</p>
            </div>
            <div class="track-delivery-item">
                <h4><i class="fas fa-location-dot"></i> Shipping Address</h4>
                <p>${trackEscape(order.address.addr)}<br>${trackEscape(order.address.city)}</p>
            </div>
            <div class="track-delivery-item">
                <h4><i class="fas fa-credit-card"></i> Payment</h4>
                <p>${trackEscape(order.payment)}${order.payment_status?` <span style="font-size:11px;color:${order.payment_status==='paid'?'#16a34a':'#b45309'};font-weight:700;text-transform:uppercase">(${trackEscape(order.payment_status)})</span>`:''}</p>
            </div>
            ${order.est?`
            <div class="track-delivery-item">
                <h4><i class="fas fa-calendar"></i> Estimated Delivery</h4>
                <p>${trackEscape(order.est)}</p>
            </div>`:''}
        </div>
    `;
    window.scrollTo({top:result.offsetTop-140,behavior:'smooth'});
}

async function initTrackOrderPage(){
    const inp=document.getElementById('orderInput');
    if(!inp)return;

    if(inp.value.trim()){
        trackOrder();
    }

    const samplesWrap=document.getElementById('trackSamples');
    if(!samplesWrap)return;
    try{
        const user=JSON.parse(localStorage.getItem('nfshop_logged'));
        if(!user||!user.email)return;
        const allUsers=JSON.parse(localStorage.getItem('nfshop_users'))||[];
        const u=allUsers.find(x=>x.email===user.email);
        const phone=user.phone||u?.phone||'';
        const url=(window.NF_DASHBOARD_DATA_URL||'/dashboard/data')
            +'?email='+encodeURIComponent(user.email)
            +'&phone='+encodeURIComponent(phone);
        const res=await fetch(url,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
        if(!res.ok)return;
        const data=await res.json();
        const recent=(data.orders||[]).slice(0,3);
        if(recent.length===0)return;
        samplesWrap.style.display='flex';
        samplesWrap.innerHTML='<span>Your recent orders:</span>'+recent.map(o=>{
            const sm=statusMeta[o.status]||{icon:'fa-clock'};
            return `<button onclick="document.getElementById('orderInput').value='${trackEscape(o.id)}';trackOrder()"><i class="fas ${sm.icon}"></i> ${trackEscape(o.id)}</button>`;
        }).join('');
    }catch(err){/* silent */}
}

document.addEventListener('DOMContentLoaded',initTrackOrderPage);

// --- Contact Page ---

async function handleContact(e){
    e.preventDefault();
    const form=document.getElementById('contactForm')||document.querySelector('.contact-form');
    const btn=document.getElementById('contactSubmitBtn');
    const errBox=document.getElementById('contactError');
    if(errBox){errBox.style.display='none';errBox.textContent='';}

    const payload={
        name:    document.getElementById('conName').value.trim(),
        email:   document.getElementById('conEmail').value.trim(),
        phone:   (document.getElementById('conPhone')?.value||'').trim(),
        subject: (document.getElementById('conSubject')?.value||'').trim(),
        message: document.getElementById('conMsg').value.trim(),
    };

    if(!payload.name||!payload.email||!payload.message){
        if(errBox){errBox.textContent='Please fill in your name, email, and message.';errBox.style.display='block';}
        return false;
    }

    if(btn){btn.disabled=true;btn.dataset.origText=btn.innerHTML;btn.innerHTML='<i class="fas fa-circle-notch fa-spin"></i> Sending...';}

    try{
        const res=await fetch(window.NF_CONTACT_STORE_URL||'/contact',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':window.NF_CSRF||'',
                'X-Requested-With':'XMLHttpRequest',
            },
            body:JSON.stringify(payload),
        });
        const data=await res.json().catch(()=>({}));
        if(!res.ok||!data.success){
            const msg=data.message||(data.errors?Object.values(data.errors).flat()[0]:'Could not send your message.');
            throw new Error(msg);
        }
        form.style.display='none';
        const successMsg=document.getElementById('contactSuccessMsg');
        if(successMsg&&data.message)successMsg.textContent=data.message;
        document.getElementById('contactSuccess').style.display='block';
    }catch(err){
        if(errBox){errBox.textContent=err.message||'Something went wrong. Please try again.';errBox.style.display='block';}
    }finally{
        if(btn){btn.disabled=false;if(btn.dataset.origText)btn.innerHTML=btn.dataset.origText;}
    }
    return false;
}

function resetContactForm(){
    const form=document.getElementById('contactForm')||document.querySelector('.contact-form');
    form.style.display='flex';
    document.getElementById('contactSuccess').style.display='none';
    form.reset();
    const errBox=document.getElementById('contactError');
    if(errBox){errBox.style.display='none';errBox.textContent='';}
}

// --- Cart Page ---

function initCart(){
    const container=document.getElementById('cartItems');
    if(!container)return;
    let cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    // Drop any items whose product no longer exists in the catalog
    cart = cart.filter(i => products.find(p => p.id === i.id));
    localStorage.setItem('nfshop_cart',JSON.stringify(cart));
    updateCartBadge(cart.reduce((s,i)=>s+i.qty,0));
    if(cart.length===0){
        document.getElementById('cartLayout').style.display='none';
        document.getElementById('cartEmpty').style.display='block';
        document.getElementById('cartHeaderDesc').textContent='Your cart is empty';
        return;
    }
    document.getElementById('cartLayout').style.display='grid';
    document.getElementById('cartEmpty').style.display='none';
    document.getElementById('cartHeaderDesc').textContent=cart.reduce((s,i)=>s+i.qty,0)+' item(s) in your cart';
    let hasOutOfStock = false;
    container.innerHTML=cart.map((item,idx)=>{
        const p=products.find(x=>x.id===item.id);
        if(!p)return '';
        const disc=p.old>0?Math.round((1-p.cur/p.old)*100):0;
        const lineTotal=p.cur*item.qty;
        const imgSrc = PRODUCTS_FROM_SERVER ? p.img : ('assets/images/products/' + p.img);
        const detailUrl = p.url || ('product-details.html?id=' + p.id);
        const isOutOfStock = typeof p.stock === 'number' && p.stock <= 0;
        const isOverStock  = typeof p.stock === 'number' && p.stock > 0 && item.qty > p.stock;
        const stockBadge   = isOutOfStock
            ? '<span style="color:#dc2626;font-size:12px;font-weight:600"><i class="fas fa-times-circle"></i> Out of Stock</span>'
            : isOverStock
                ? '<span style="color:#d97706;font-size:12px;font-weight:600"><i class="fas fa-exclamation-circle"></i> Only ' + p.stock + ' left (reduce qty)</span>'
                : '<span style="color:#16a34a;font-size:12px"><i class="fas fa-check-circle"></i> ' + (p.stock > 0 ? p.stock + ' In Stock' : 'In Stock') + '</span>';
        if (isOutOfStock || isOverStock) hasOutOfStock = true;
        const plusDisabled = (typeof p.stock === 'number' && item.qty >= p.stock) ? 'disabled style="opacity:.4;cursor:not-allowed"' : '';
        const variantLine = item.variant_label ? `<div class="cart-item-variant" style="font-size:12px;color:#64748b">${item.variant_label}</div>` : '';
        return `
            <div class="cart-item${isOutOfStock || isOverStock ? ' style="border-left:3px solid #f59e0b"' : ''}" data-id="${p.id}">
                <a href="${detailUrl}" class="cart-item-img"><img src="${imgSrc}" alt="${p.title}"${isOutOfStock ? ' style="opacity:.5"' : ''}></a>
                <div class="cart-item-info">
                    <a href="${detailUrl}" class="cart-item-title">${p.title}</a>
                    ${variantLine}
                    <div class="cart-item-stock">${stockBadge}</div>
                    <div>
                        <span class="cart-item-price">TK ${p.cur.toLocaleString()}</span>
                        ${disc>0?'<span class="cart-item-old">TK '+p.old.toLocaleString()+'</span>':''}
                    </div>
                </div>
                <div class="cart-item-actions">
                    <div class="cart-qty">
                        <button onclick="cartQty(${idx},-1)"><i class="fas fa-minus"></i></button>
                        <input type="text" value="${item.qty}" readonly>
                        <button onclick="cartQty(${idx},1)" ${plusDisabled}><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="cart-item-total">TK ${lineTotal.toLocaleString()}</div>
                    <button class="cart-item-remove" onclick="cartRemove(${idx})"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
    }).join('');

    // Disable checkout button if any item is out of stock or over stock
    const checkoutBtn = document.querySelector('.btn-checkout');
    if (checkoutBtn) {
        if (hasOutOfStock) {
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.pointerEvents = 'none';
            checkoutBtn.style.cursor = 'not-allowed';
            checkoutBtn.title = 'Remove or reduce out-of-stock items before proceeding';
        } else {
            checkoutBtn.style.opacity = '';
            checkoutBtn.style.pointerEvents = '';
            checkoutBtn.style.cursor = '';
            checkoutBtn.title = '';
        }
    }

    updateCartSummary(cart);
    // Sync current cart to server on every cart page load
    syncCartToServer();
}

function cartQty(idx,delta){
    let cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    const item=cart[idx];
    if(!item)return;
    const p = products.find(x=>x.id===item.id);
    const newQty = Math.max(1, item.qty + delta);
    if (delta > 0 && p && typeof p.stock === 'number' && newQty > p.stock) {
        nfToast('Only ' + p.stock + ' left in stock.', 'error');
        return;
    }
    item.qty = newQty;
    localStorage.setItem('nfshop_cart',JSON.stringify(cart));
    updateCartBadge(cart.reduce((s,i)=>s+i.qty,0));
    initCart();
    syncCartToServer();
}

function cartRemove(idx){
    let cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    const item=cart[idx];
    if(!item)return;
    const name = productNameById(item.id);
    cart.splice(idx,1);
    localStorage.setItem('nfshop_cart',JSON.stringify(cart));
    updateCartBadge(cart.reduce((s,i)=>s+i.qty,0));
    nfToast('Removed from cart: ' + name, 'info');
    initCart();
    syncCartToServer();
}

// Active coupon — restored from sessionStorage so it carries across pages
// (cart → checkout) during the same browser session.
let appliedCoupon = null;
try {
    const _saved = sessionStorage.getItem('nfshop_coupon');
    if (_saved) appliedCoupon = JSON.parse(_saved);
} catch (e) { /* ignore */ }

function findCoupon(code){
    const list = window.NF_COUPONS || [];
    code = (code || '').trim().toUpperCase();
    return list.find(c => (c.code || '').toUpperCase() === code) || null;
}

function applyCoupon(){
    const inp=document.getElementById('couponInput');
    const msg=document.getElementById('couponMsg');
    const code=inp?inp.value.trim().toUpperCase():'';
    if(!code){
        msg.textContent='Please enter a coupon code';msg.className='coupon-msg error';
        appliedCoupon=null;sessionStorage.removeItem('nfshop_coupon');updateCartSummary();return;
    }
    const c = findCoupon(code);
    if(!c){
        msg.textContent='Invalid coupon code';msg.className='coupon-msg error';
        appliedCoupon=null;sessionStorage.removeItem('nfshop_coupon');updateCartSummary();return;
    }
    // Check minimum spend
    const cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    let subtotal=0;
    cart.forEach(item=>{const p=products.find(x=>x.id===item.id);if(p)subtotal+=p.cur*item.qty});
    if(c.minimum_spend && subtotal < c.minimum_spend){
        msg.textContent='Minimum spend for this coupon: TK '+c.minimum_spend.toLocaleString();
        msg.className='coupon-msg error';
        appliedCoupon=null;updateCartSummary();return;
    }
    appliedCoupon = c;
    try { sessionStorage.setItem('nfshop_coupon', JSON.stringify(c)); } catch (e) { /* ignore */ }
    const label = c.type === 'percentage'
        ? c.amount + '% off'
        : 'TK ' + c.amount.toLocaleString() + ' off';
    msg.textContent='Coupon applied! ' + label + (c.free_shipping ? ' + free shipping' : '');
    msg.className='coupon-msg success';
    updateCartSummary();
}

function calcCouponDiscount(subtotal){
    if(!appliedCoupon) return 0;
    if(appliedCoupon.minimum_spend && subtotal < appliedCoupon.minimum_spend) return 0;
    let d = appliedCoupon.type === 'percentage'
        ? Math.round(subtotal * (appliedCoupon.amount / 100))
        : appliedCoupon.amount;
    if(appliedCoupon.maximum_discount && d > appliedCoupon.maximum_discount){
        d = appliedCoupon.maximum_discount;
    }
    return Math.min(d, subtotal);
}

function updateCartSummary(){
    const cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    let subtotal=0;
    cart.forEach(item=>{const p=products.find(x=>x.id===item.id);if(p)subtotal+=p.cur*item.qty});
    const freeShip = (appliedCoupon && appliedCoupon.free_shipping) || subtotal >= 500;
    const shipping = freeShip ? 0 : 60;
    const discount = calcCouponDiscount(subtotal);
    const total = subtotal + shipping - discount;
    document.getElementById('subtotalAmt').textContent='TK '+subtotal.toLocaleString();
    document.getElementById('shippingAmt').textContent=shipping===0?'FREE':'TK '+shipping;
    const dr=document.getElementById('discountRow');
    if(discount>0){dr.style.display='flex';document.getElementById('discountAmt').textContent='-TK '+discount.toLocaleString()}
    else dr.style.display='none';
    document.getElementById('totalAmt').textContent='TK '+total.toLocaleString();
}

function updateCartBadge(n){
    const badge=document.getElementById('cartBadge');
    if(badge){badge.textContent=n;badge.style.display=n>0?'flex':'none'}
    const mBadge=document.getElementById('mCartBadge');
    if(mBadge){mBadge.textContent=n;mBadge.style.display=n>0?'flex':'none'}
}

// Init cart page
document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('cartItems'))initCart();
});

// --- Checkout Page ---

function selectPayment(el, method) {
    document.querySelectorAll('.co-payment-option').forEach(x => x.classList.remove('active'));
    el.classList.add('active');
}

function initCheckout() {
    const cart = JSON.parse(localStorage.getItem('nfshop_cart')) || [];
    if (cart.length === 0) {
        document.getElementById('checkoutLayout').style.display = 'none';
        document.getElementById('checkoutEmpty').style.display = 'block';
        return;
    }
    document.getElementById('checkoutLayout').style.display = 'grid';
    document.getElementById('checkoutEmpty').style.display = 'none';

    // Auto-fill form from logged-in user
    const logged = JSON.parse(localStorage.getItem('nfshop_logged'));
    if (logged) {
        const allUsers = JSON.parse(localStorage.getItem('nfshop_users')) || [];
        const u = allUsers.find(x => x.email === logged.email);
        const nameEl  = document.getElementById('coName');
        const phoneEl = document.getElementById('coPhone');
        const emailEl = document.getElementById('coEmail');
        if (nameEl  && !nameEl.value  && logged.name)  nameEl.value  = logged.name;
        if (emailEl && !emailEl.value && logged.email) emailEl.value = logged.email;
        const phone = logged.phone || (u && u.phone) || '';
        if (phoneEl && !phoneEl.value && phone) phoneEl.value = phone;
    }

    updateCheckoutSummary();
}

function updateCheckoutSummary() {
    const cart = JSON.parse(localStorage.getItem('nfshop_cart')) || [];
    const container = document.getElementById('coSummaryItems');
    let subtotal = 0;

    if (container) {
        container.innerHTML = cart.map(item => {
            const p = products.find(x => x.id === item.id);
            if (!p) return '';
            const lineTotal = p.cur * item.qty;
            subtotal += lineTotal;
            const imgSrc = PRODUCTS_FROM_SERVER ? p.img : ('assets/images/products/' + p.img);
            const variantMeta = item.variant_label ? ` &middot; ${item.variant_label}` : '';
            return `
                <div class="co-summary-item">
                    <div class="co-summary-item-img"><img src="${imgSrc}" alt="${p.title}"></div>
                    <div class="co-summary-item-info">
                        <div class="co-summary-item-title">${p.title}</div>
                        <div class="co-summary-item-meta">Qty: ${item.qty}${variantMeta}</div>
                    </div>
                    <div class="co-summary-item-total">TK ${lineTotal.toLocaleString()}</div>
                </div>
            `;
        }).join('');
    } else {
        cart.forEach(item => {
            const p = products.find(x => x.id === item.id);
            if (p) subtotal += p.cur * item.qty;
        });
    }

    const freeShip = (appliedCoupon && appliedCoupon.free_shipping) || subtotal >= 500;
    const shipping = freeShip ? 0 : 60;
    const discount = (typeof calcCouponDiscount === 'function') ? calcCouponDiscount(subtotal) : 0;
    const total = subtotal + shipping - discount;

    const ids = ['coSubtotal', 'coMobileSubtotal'];
    ids.forEach(id => { const el = document.getElementById(id); if (el) el.textContent = 'TK ' + subtotal.toLocaleString(); });
    const shippingIds = ['coShipping', 'coMobileShipping'];
    shippingIds.forEach(id => { const el = document.getElementById(id); if (el) el.textContent = shipping === 0 ? 'FREE' : 'TK ' + shipping; });

    const dr = document.getElementById('coDiscountRow');
    if (discount > 0 && dr) { dr.style.display = 'flex'; document.getElementById('coDiscount').textContent = '-TK ' + discount.toLocaleString(); }
    else if (dr) dr.style.display = 'none';

    const totalIds = ['coTotal', 'coMobileTotal'];
    totalIds.forEach(id => { const el = document.getElementById(id); if (el) el.textContent = 'TK ' + total.toLocaleString(); });

    updateCartBadge(cart.reduce((s, i) => s + i.qty, 0));
}

function placeOrder(e) {
    e.preventDefault();
    const name = document.getElementById('coName').value.trim();
    const phone = document.getElementById('coPhone').value.trim();
    const email = document.getElementById('coEmail').value.trim();
    const address = document.getElementById('coAddress').value.trim();
    const city = document.getElementById('coCity').value.trim();
    if (!name || !phone || !address || !city) {
        nfToast('Please fill in all required fields.', 'error');
        return false;
    }

    const payment = document.querySelector('input[name="payment"]:checked');
    const cart = JSON.parse(localStorage.getItem('nfshop_cart')) || [];
    if (cart.length === 0) {
        nfToast('Your cart is empty.', 'error');
        return false;
    }

    // Stock guard before submitting
    const stockIssues = [];
    cart.forEach(item => {
        const p = products.find(x => x.id === item.id);
        if (p && typeof p.stock === 'number') {
            if (p.stock <= 0) {
                stockIssues.push('"' + p.title + '" is out of stock');
            } else if (item.qty > p.stock) {
                stockIssues.push('"' + p.title + '" — only ' + p.stock + ' left (you have ' + item.qty + ')');
            }
        }
    });
    if (stockIssues.length > 0) {
        nfToast('Cannot place order: ' + stockIssues[0], 'error');
        return false;
    }

    const submitBtns = document.querySelectorAll('.btn-checkout, #checkoutForm button[type="submit"]');
    submitBtns.forEach(b => { b.disabled = true; b.dataset.origText = b.innerHTML; b.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Placing order...'; });

    const payload = {
        shipping_name:    name,
        shipping_phone:   phone,
        shipping_email:   email || null,
        shipping_address: address,
        shipping_city:    city,
        payment_method:   payment ? payment.value : 'cod',
        notes:            document.getElementById('coNote').value.trim() || null,
        coupon_code:      appliedCoupon ? appliedCoupon.code : null,
        items:            cart.map(i => ({ id: i.id, qty: i.qty, variant_id: i.variant_id || null })),
    };

    const doFetch = (token) => {
        if (token) payload.recaptcha_token = token;
        fetch(window.NF_ORDER_STORE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.NF_CSRF || '',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        })
    .then(async r => {
        const data = await r.json().catch(() => ({}));
        if (!r.ok) {
            const msg = data.message
                || (data.errors ? Object.values(data.errors).flat()[0] : 'Failed to place order.');
            throw new Error(msg);
        }
        return data;
    })
    .then(data => {
        localStorage.setItem('nfshop_cart', JSON.stringify([]));
        updateCartBadge(0);
        appliedCoupon = null;
        sessionStorage.removeItem('nfshop_coupon');

        // Save the phone used in checkout back to the logged-in user profile
        const usedPhone = payload.shipping_phone;
        if (usedPhone) {
            const logged = JSON.parse(localStorage.getItem('nfshop_logged'));
            if (logged) {
                logged.phone = usedPhone;
                localStorage.setItem('nfshop_logged', JSON.stringify(logged));

                const allUsers = JSON.parse(localStorage.getItem('nfshop_users')) || [];
                const idx = allUsers.findIndex(x => x.email === logged.email);
                if (idx !== -1) { allUsers[idx].phone = usedPhone; localStorage.setItem('nfshop_users', JSON.stringify(allUsers)); }
            }
        }

        window.location.href = data.redirect || ((window.NF_ORDER_COMPLETE_URL || '/order-complete') + '?id=' + data.order_no);
    })
        .catch(err => {
            nfToast(err.message || 'Something went wrong.', 'error');
            submitBtns.forEach(b => { b.disabled = false; if (b.dataset.origText) b.innerHTML = b.dataset.origText; });
        });
    };

    const siteKey = window.NF_RECAPTCHA_SITE_KEY;
    if (siteKey && typeof grecaptcha !== 'undefined') {
        grecaptcha.ready(() => {
            grecaptcha.execute(siteKey, { action: 'place_order' }).then(doFetch).catch(() => doFetch(null));
        });
    } else {
        doFetch(null);
    }

    return false;
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.checkout-section')) {
        initCheckout();
        // Capture partial contact info for abandoned cart tracking
        var _contactTimer = null;
        function syncContactToServer() {
            clearTimeout(_contactTimer);
            _contactTimer = setTimeout(function () {
                var nameEl = document.getElementById('coName');
                var phoneEl = document.getElementById('coPhone');
                var name = nameEl ? nameEl.value.trim() : '';
                var phone = phoneEl ? phoneEl.value.trim() : '';
                if (!name && !phone) return;
                var csrf = window.NF_CSRF || document.querySelector('meta[name="csrf-token"]')?.content || '';
                fetch('/cart/contact', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ name: name, phone: phone }),
                }).catch(function () {});
            }, 600);
        }
        ['coName', 'coPhone'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('blur', syncContactToServer);
        });
    }
});

// --- Order Complete Page ---

const paymentLabels = {
    cod: 'Cash on Delivery',
    bkash: 'bKash',
    nagad: 'Nagad',
    rocket: 'Rocket',
};

function initOrderComplete() {
    if (window.NF_ORDER_SERVER_RENDERED) return;
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (!id) { showOcEmpty(); return; }

    const orders = JSON.parse(localStorage.getItem('nfshop_orders')) || [];
    const order = orders.find(o => o.id === id);
    if (!order) { showOcEmpty(); return; }

    document.getElementById('ocContent').style.display = 'block';
    document.getElementById('ocEmpty').style.display = 'none';

    document.title = 'Order ' + id + ' - ROVENTEX';
    document.getElementById('ocOrderId').textContent = id;
    document.getElementById('ocDate').textContent = order.date;
    document.getElementById('ocEst').textContent = order.est;

    const payLabel = paymentLabels[order.payment] || order.payment;
    document.getElementById('ocPayment').textContent = payLabel;
    document.getElementById('ocPaymentMethod').textContent = payLabel;

    const addr = order.address;
    document.getElementById('ocAddress').innerHTML = addr.name + '<br>' + addr.phone + '<br>' + addr.addr + '<br>' + addr.city;

    let subtotal = 0;
    const container = document.getElementById('ocItems');
    container.innerHTML = order.items.map(item => {
        subtotal += item.price * item.qty;
        return `
            <div class="oc-item">
                <div class="oc-item-img"><img src="assets/images/products/${item.img}" alt="${item.title}"></div>
                <div class="oc-item-info">
                    <div class="oc-item-title">${item.title}</div>
                    <div class="oc-item-meta">Qty: ${item.qty} x TK ${item.price.toLocaleString()}</div>
                </div>
                <div class="oc-item-total">TK ${(item.price * item.qty).toLocaleString()}</div>
            </div>
        `;
    }).join('');

    document.getElementById('ocSubtotal').textContent = 'TK ' + (order.subtotal || subtotal).toLocaleString();
    document.getElementById('ocShipping').textContent = order.shipping === 0 ? 'FREE' : 'TK ' + order.shipping;

    const dr = document.getElementById('ocDiscountRow');
    if (order.discount && order.discount > 0 && dr) {
        dr.style.display = 'flex';
        document.getElementById('ocDiscount').textContent = '-TK ' + order.discount.toLocaleString();
    } else if (dr) dr.style.display = 'none';

    document.getElementById('ocTotal').textContent = 'TK ' + (order.total || order.subtotal + order.shipping - (order.discount || 0)).toLocaleString();

    const nw = document.getElementById('ocNoteWrap');
    const ne = document.getElementById('ocNote');
    if (order.note) { nw.style.display = 'block'; ne.textContent = order.note; }
    else nw.style.display = 'none';
}

function showOcEmpty() {
    document.getElementById('ocContent').style.display = 'none';
    document.getElementById('ocEmpty').style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('ocContent')) initOrderComplete();
});

// --- Product Details ---

// Initialize product-details page dynamically.
// When the server has already rendered the page (Laravel Blade), bail out —
// otherwise the client-side rewrites below would clobber real data with the
// hardcoded demo product list.
function initProductDetails() {
    if (window.NF_PRODUCT_SERVER_RENDERED) return;
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get('id'));
    if (!id) return;
    const p = products.find(x => x.id === id);
    if (!p) {
        const section = document.querySelector('.pd-section');
        if (section) section.innerHTML = '<div class="ap-empty" style="padding:80px 20px"><i class="fas fa-exclamation-circle"></i><p>Product not found.</p><a href="all-products.html" class="btn-order-lg">Browse Products</a></div>';
        return;
    }

    const disc = Math.round((1 - p.cur / p.old) * 100);
    const save = p.old - p.cur;
    const catName = catMeta && catMeta[p.cat] ? catMeta[p.cat].name : p.cat;
    const brand = p.title.split(' ')[0];

    document.title = p.title + ' - ROVENTEX';

    // Breadcrumb
    const bc = document.querySelector('.breadcrumb');
    if (bc) {
        const links = bc.querySelectorAll('a');
        const spans = bc.querySelectorAll('span');
        if (links.length > 1) { links[1].textContent = catName; links[1].href = 'category-products.html?cat=' + p.cat; }
        if (spans.length) spans[spans.length - 1].textContent = p.title;
    }

    // Badge
    const badge = document.querySelector('.pd-badge');
    if (badge) badge.textContent = disc > 0 ? '-' + disc + '%' : '';

    // Wish button
    const wishBtn = document.querySelector('.pd-wish');
    if (wishBtn) {
        wishBtn.onclick = function (e) { e.stopPropagation(); toggleWish(p.id, this); };
        if (isWished(p.id)) { wishBtn.classList.add('active'); wishBtn.querySelector('i').className = 'fas fa-heart'; }
    }

    // Main image
    const mainImg = document.getElementById('mainImg');
    if (mainImg) { mainImg.src = 'assets/images/products/' + p.img; mainImg.alt = p.title; }

    // Brand
    const brandEl = document.querySelector('.pd-brand');
    if (brandEl) brandEl.textContent = brand;

    // Title
    const titleEl = document.querySelector('.pd-title');
    if (titleEl) titleEl.textContent = p.title;

    // Price
    const curEl = document.querySelector('.pd-price .cur');
    if (curEl) curEl.textContent = 'TK ' + p.cur.toLocaleString();
    const oldEl = document.querySelector('.pd-price .old');
    if (oldEl) oldEl.textContent = 'TK ' + p.old.toLocaleString();
    const offEl = document.querySelector('.pd-price .off');
    if (offEl) offEl.textContent = disc > 0 ? '-' + disc + '%' : '';
    const saveEl = document.querySelector('.pd-save');
    if (saveEl) saveEl.innerHTML = save > 0 ? 'You save <strong>TK ' + save.toLocaleString() + '</strong>' : '';

    // Stock
    const stockEl = document.querySelector('.pd-stock');
    if (stockEl) stockEl.innerHTML = '<i class="fas fa-check-circle"></i> ' + p.stock + ' In Stock';

    // Description
    const descEl = document.querySelector('.pd-desc');
    if (descEl) {
        descEl.textContent = p.desc || p.title + ' — Premium quality product at the best price in Bangladesh. Order now and get fast delivery across the country with cash on delivery.';
    }
}

// Sync wish button state on product detail page (server-rendered)
document.addEventListener('DOMContentLoaded', function () {
    const id = window.NF_PD_ID;
    if (!id) return;
    const btn = document.getElementById('pdWishBtn');
    if (!btn) return;
    if (isWished(id)) {
        btn.classList.add('active');
        btn.querySelector('i').className = 'fas fa-heart';
    }
});

// Image gallery
function changeImg(el){
    const main=document.getElementById('mainImg');
    if(!main)return;
    main.src=el.src;
    document.querySelectorAll('#pdThumbs img').forEach(x=>x.classList.remove('active'));
    el.classList.add('active');
}

// Quantity selector
function qtyChange(delta){
    const inp=document.getElementById('qtyInput');
    if(!inp)return;
    let v=parseInt(inp.value)||1;
    const variant=pdSelectedVariant();
    const maxStock = variant ? variant.stock : (window.NF_PD_PRODUCT ? window.NF_PD_PRODUCT.stock : 999);
    v=Math.max(1,Math.min(maxStock,v+delta));
    inp.value=v;
}

// Returns the currently selected variant object (from NF_PD_VARIANTS), or null
function pdSelectedVariant(){
    const sel=document.getElementById('pdVariant');
    if(!sel||!window.NF_PD_VARIANTS)return null;
    const id=parseInt(sel.value);
    return window.NF_PD_VARIANTS.find(v=>v.id===id)||null;
}

// Update displayed price/stock when the variant selection changes
function pdVariantChange(){
    const variant=pdSelectedVariant();
    const p=window.NF_PD_PRODUCT||{};
    const curEl=document.getElementById('pdCur');
    if(curEl){
        const price=(variant && variant.price>0)?variant.price:p.cur;
        curEl.textContent='TK '+Math.round(price).toLocaleString();
    }
    const maxStock=variant?variant.stock:p.stock;
    const stockText=document.getElementById('pdStockText');
    const stockWrap=document.getElementById('pdStock');
    if(stockText){
        if(maxStock<=0){
            stockText.textContent='Out of Stock';
            if(stockWrap)stockWrap.style.color='#dc2626';
        }else{
            stockText.textContent=maxStock+' In Stock';
            if(stockWrap)stockWrap.style.color='';
        }
    }
    const qtyInput=document.getElementById('qtyInput');
    if(qtyInput){
        let v=parseInt(qtyInput.value)||1;
        qtyInput.value=Math.max(1,Math.min(maxStock||1,v));
    }
}

// Product detail page — Add to Cart with quantity
function pdAddToCart(id){
    const qty=parseInt(document.getElementById('qtyInput')?.value||1);
    const p=window.NF_PD_PRODUCT||{};
    const variant=pdSelectedVariant();
    const variantId=variant?variant.id:null;
    const variantLabel=variant?variant.label:null;
    const maxStock=variant?variant.stock:(typeof p.stock==='number'?p.stock:999);
    if(maxStock===0){nfToast('This product is out of stock.','error');return;}
    let cart=JSON.parse(localStorage.getItem('nfshop_cart'))||[];
    const item=cart.find(x=>x.id===id && (x.variant_id||null)===(variantId||null));
    const current=item?item.qty:0;
    const addQty=Math.min(qty,maxStock-current);
    if(addQty<=0){nfToast('You already have the maximum stock in your cart.','error');return;}
    if(item)item.qty+=addQty;
    else cart.push({id:id,qty:addQty,variant_id:variantId,variant_label:variantLabel});
    localStorage.setItem('nfshop_cart',JSON.stringify(cart));
    updateCartBadge(cart.reduce((s,i)=>s+i.qty,0));
    nfToast('Added '+addQty+' × '+(p.title||'product')+' to cart.','success');
    syncCartToServer();
}

// Product detail page — Order Now (add to cart then go to checkout)
function pdOrderNow(id){
    pdAddToCart(id);
    setTimeout(()=>{window.location.href=window.NF_CHECKOUT_URL||'/checkout';},300);
}

// Product tabs
function switchTab(btn, id){
    const parent=btn.closest('.pd-tabs-section');
    if(!parent)return;
    parent.querySelectorAll('.pd-tab').forEach(x=>x.classList.remove('active'));
    parent.querySelectorAll('.pd-tab-content').forEach(x=>x.classList.remove('active'));
    btn.classList.add('active');
    const content=document.getElementById('tab'+id.charAt(0).toUpperCase()+id.slice(1));
    if(content)content.classList.add('active');
}

// --- Product Comments ---

const COMMENTS_KEY='nfshop_product_comments';

function getComments(){
    return JSON.parse(localStorage.getItem(COMMENTS_KEY))||[];
}

function saveComments(comments){
    localStorage.setItem(COMMENTS_KEY,JSON.stringify(comments));
}

function renderComments(){
    const container=document.getElementById('userComments');
    if(!container)return;
    const comments=getComments();
    if(!comments.length){container.innerHTML='';return}
    container.innerHTML='<div style="margin-top:12px"><h4 style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:6px">User Reviews</h4></div>';
    comments.forEach(c=>{
        let stars='';
        for(let i=1;i<=5;i++){stars+=i<=c.rating?'<i class="fas fa-star"></i>':'<i class="far fa-star"></i>'}
        container.innerHTML+=`
            <div class="user-comment">
                <div class="review-header">
                    <span class="reviewer"><i class="fas fa-user-circle"></i> ${c.name}</span>
                    <span class="review-stars">${stars}</span>
                </div>
                <p>${c.text}</p>
                <span class="review-date">${c.date}</span>
            </div>
        `;
    });
}

function handleProductComment(e){
    e.preventDefault();
    const name=document.getElementById('commentName').value.trim();
    const text=document.getElementById('commentText').value.trim();
    const rating=parseInt(document.getElementById('commentRating').value);
    if(!rating){alert('Please select a star rating.');return false}
    if(!name||!text)return false;
    const comments=getComments();
    const user=JSON.parse(localStorage.getItem('nfshop_logged'));
    comments.unshift({
        name:user?user.name.split(' ')[0]:name,
        text,
        rating,
        date:new Date().toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}),
    });
    saveComments(comments);
    renderComments();
    e.target.reset();
    document.getElementById('commentRating').value='0';
    document.querySelectorAll('.star-rating i').forEach(s=>s.className='far fa-star');
    return false;
}

document.addEventListener('DOMContentLoaded',()=>{
    if(document.getElementById('starRating'))renderComments();
});

// Star rating interaction
document.addEventListener('DOMContentLoaded',()=>{
    const sr=document.getElementById('starRating');
    if(!sr)return;
    const stars=sr.querySelectorAll('i');
    const hidden=document.getElementById('commentRating');
    stars.forEach(s=>{
        s.addEventListener('mouseenter',()=>{
            const val=parseInt(s.dataset.star);
            stars.forEach((x,i)=>{
                x.className=i<val?'fas fa-star hover':'far fa-star hover';
            });
        });
        s.addEventListener('mouseleave',()=>{
            stars.forEach(x=>x.classList.remove('hover'));
            const val=parseInt(hidden.value);
            stars.forEach((x,i)=>{
                x.className=i<val?'fas fa-star active':'far fa-star';
            });
        });
        s.addEventListener('click',()=>{
            const val=parseInt(s.dataset.star);
            hidden.value=val;
            stars.forEach((x,i)=>{
                x.className=i<val?'fas fa-star active':'far fa-star';
            });
        });
    });
});

// Init product-details page
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.pd-section')) initProductDetails();
    initImageZoom();
});

// Cursor-tracking zoom on product main image
function initImageZoom(){
    const wrap=document.querySelector('.pd-main-img');
    const img=document.getElementById('mainImg');
    if(!wrap||!img)return;
    // Skip on touch devices
    if(window.matchMedia('(hover:none)').matches)return;
    wrap.addEventListener('mousemove',e=>{
        const r=wrap.getBoundingClientRect();
        const x=((e.clientX-r.left)/r.width)*100;
        const y=((e.clientY-r.top)/r.height)*100;
        img.style.transformOrigin=x+'% '+y+'%';
    });
    wrap.addEventListener('mouseleave',()=>{
        img.style.transformOrigin='center center';
    });
}

// Preloader
(function () {
    const hidePreloader = () => {
        const pl = document.getElementById('preloader');
        if (pl && !pl.classList.contains('hide')) {
            pl.classList.add('hide');
            setTimeout(() => { pl.style.display = 'none'; }, 500);
        }
    };
    if (document.readyState === 'complete') {
        hidePreloader();
    } else {
        window.addEventListener('load', hidePreloader);
        document.addEventListener('DOMContentLoaded', () => setTimeout(hidePreloader, 400));
        setTimeout(hidePreloader, 3000);
    }
})();
