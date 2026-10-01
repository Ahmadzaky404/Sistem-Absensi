<!-- PWA & Mobile Web App Meta Tags -->
<meta name="theme-color" content="#2563EB" id="meta-theme-color">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Presensi BABEN">
<meta name="application-name" content="PT.BABEN Presensi">
<meta name="msapplication-TileColor" content="#2563EB">

<!-- PWA Manifest & Icons -->
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

<!-- PWA Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('{{ asset('sw.js') }}')
                .then(function (registration) {
                    console.log('[PWA] ServiceWorker registered with scope:', registration.scope);
                })
                .catch(function (error) {
                    console.warn('[PWA] ServiceWorker registration failed:', error);
                });
        });
    }

    // Dynamic theme-color sync for standalone PWA mode
    (function () {
        function updateThemeColor() {
            var theme = document.documentElement.dataset.theme || 'light';
            var meta = document.getElementById('meta-theme-color');
            if (meta) {
                meta.setAttribute('content', theme === 'dark' ? '#1E293B' : '#2563EB');
            }
        }
        updateThemeColor();
        var observer = new MutationObserver(updateThemeColor);
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    })();
</script>
