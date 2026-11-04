// Offline support for the admin POS (registered with scope /admin/pos).
// - The POS page itself: network first, last good copy when offline.
// - Scripts / styles / fonts / images (incl. Tailwind + Alpine CDNs): served from cache, refreshed in the background.
// Product data and queued sales live in the page (localStorage), not here.

const CACHE = 'pos-offline-v1';

self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        const keys = await caches.keys();
        await Promise.all(keys.filter((k) => k.startsWith('pos-offline-') && k !== CACHE).map((k) => caches.delete(k)));
        await self.clients.claim();
    })());
});

self.addEventListener('fetch', (event) => {
    const req = event.request;
    if (req.method !== 'GET') return;

    if (req.mode === 'navigate') {
        event.respondWith(networkFirst(req));
        return;
    }

    if (['script', 'style', 'font', 'image'].includes(req.destination)) {
        event.respondWith(staleWhileRevalidate(event, req));
    }
});

async function networkFirst(req) {
    const cache = await caches.open(CACHE);
    try {
        const res = await fetch(req);
        // Only keep a real POS page — not a login redirect or an error page.
        if (res.ok && !res.redirected) cache.put(req, res.clone());
        return res;
    } catch (e) {
        const cached = await cache.match(req, { ignoreSearch: true });
        return cached || new Response('<h2 style="font-family:sans-serif">Offline — open the POS once while online so it can be used offline.</h2>',
            { status: 503, headers: { 'Content-Type': 'text/html; charset=utf-8' } });
    }
}

async function staleWhileRevalidate(event, req) {
    const cache = await caches.open(CACHE);
    const cached = await cache.match(req);
    const network = fetch(req)
        .then((res) => {
            if (res.ok || res.type === 'opaque') cache.put(req, res.clone());
            return res;
        })
        .catch(() => cached || Response.error());
    if (cached) {
        event.waitUntil(network.catch(() => {}));
        return cached;
    }
    return network;
}
