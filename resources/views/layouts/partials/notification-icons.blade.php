<style>
    /* Visual-only SweetAlert2 status icons. Keep the existing alert API and behaviour unchanged. */
    .swal2-icon.swal2-success,
    .swal2-icon.swal2-error {
        display: flex !important;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        overflow: visible;
        animation: notification-icon-pop 320ms cubic-bezier(.2, .8, .25, 1) both !important;
    }

    .swal2-icon.swal2-success {
        border: 0.14em solid #b8e7a9 !important;
    }

    .swal2-icon.swal2-error {
        border: 0.14em solid #f2a6a6 !important;
    }

    /* SweetAlert2 draws its native mark with positioned line elements.
       Hide only those lines and render one centered status glyph instead. */
    .swal2-icon.swal2-success .swal2-success-ring,
    .swal2-icon.swal2-success [class^='swal2-success-line'],
    .swal2-icon.swal2-success .swal2-success-fix,
    .swal2-icon.swal2-error .swal2-x-mark {
        display: none !important;
    }

    .swal2-icon.swal2-success::after,
    .swal2-icon.swal2-error::after {
        display: block;
        font-family: Arial, sans-serif;
        font-weight: 700;
        line-height: 1;
        transform-origin: center;
        animation: notification-symbol-in 360ms 120ms cubic-bezier(.2, .8, .25, 1) both !important;
    }

    .swal2-icon.swal2-success::after {
        content: '✓';
        color: #76c764;
        font-size: 2.35em;
        transform: translateY(-.02em);
    }

    .swal2-icon.swal2-error::after {
        content: '✕';
        color: #dc4f4f;
        font-size: 2.1em;
        transform: translateY(-.03em);
    }

    @keyframes notification-icon-pop {
        from { opacity: 0; transform: scale(.72); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes notification-symbol-in {
        from { opacity: 0; transform: scale(.45) rotate(-8deg); }
        to { opacity: 1; transform: scale(1) rotate(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .swal2-icon.swal2-success,
        .swal2-icon.swal2-error,
        .swal2-icon.swal2-success::after,
        .swal2-icon.swal2-error::after {
            animation: none !important;
        }
    }
</style>