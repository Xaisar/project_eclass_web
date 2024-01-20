const staticCachesName = 'site-static-n0qWpPDlYy'

var assets = [
    'assets/images/favicon.ico',
    'assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css',
    'assets/css/preloader.min.css',
    'assets/css/bootstrap.min.css',
    'assets/css/icons.min.css',
    'assets/css/app.min.css',
    'assets/libs/jquery/jquery.min.js',
    'assets/libs/bootstrap/js/bootstrap.bundle.min.js',
    'assets/libs/metismenu/metisMenu.min.js',
    'assets/libs/simplebar/simplebar.min.js',
    'assets/libs/node-waves/waves.min.js',
    'assets/libs/feather-icons/feather.min.js',
    'assets/libs/pace-js/pace.min.js',
    'assets/libs/apexcharts/apexcharts.min.js',
    'assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js',
    'assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js',
    'assets/js/app.js',
    'error/fallback',
    'assets/images/error-img.png',
    'assets/libs/sweetalert2/sweetalert2.min.css',
    
]

self.addEventListener('install', (evt) => {
    evt.waitUntil(
        caches.open(staticCachesName).then(cache => {
            console.log('caching shell assets')
            cache.addAll(assets)
        })
    )
})

self.addEventListener('fetch', (evt) => {
    evt.respondWith(
        caches.open(staticCachesName).then(cache => {
            return cache.match(evt.request).then(cacheRes => {
                return cacheRes || fetch(evt.request)
            }).catch(() => caches.match('error/fallback'))
        })
    )
})