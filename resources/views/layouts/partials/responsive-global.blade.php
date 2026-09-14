<style>
    /* Aturan responsif bersama untuk seluruh tampilan aplikasi. */
    *, *::before, *::after {
        box-sizing: border-box;
    }

    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    img,
    svg,
    video,
    canvas,
    iframe {
        max-width: 100%;
        height: auto;
    }

    .table-scroll,
    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-scroll > table,
    .table-responsive > table {
        min-width: max-content;
    }

    @media (max-width: 768px) {
        .container {
            padding-right: 1rem;
            padding-left: 1rem;
        }

        .card,
        .soft-card,
        .attendance-card,
        .dashboard-side-card {
            border-radius: 10px;
        }

        .card-body,
        .card.p-4,
        .soft-card.p-4,
        .attendance-card {
            padding: 0.85rem !important;
        }

        .row.g-4,
        .row.g-3 {
            --bs-gutter-y: 0.85rem;
        }

        .row > * {
            width: 100%;
        }

        .d-grid {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .d-flex:not(.login-page):not(.navbar):not(.navbar-nav):not(.input-group):not(.btn-group):not(.swal2-actions) {
            flex-direction: column;
            align-items: stretch !important;
        }

        button:not(.navbar-toggler):not(.theme-toggle):not(.swal2-confirm):not(.swal2-cancel),
        input:not([type='checkbox']):not([type='radio']):not([type='hidden']),
        select,
        textarea {
            width: 100%;
            min-height: 44px;
        }

        .input-group > .form-control,
        .input-group > .form-select {
            min-width: 0;
        }
    }

    /* Penyempurnaan navigasi, dialog, dan formulir untuk tablet serta ponsel. */
    @media (max-width: 768px) {
        .navbar > .container { flex-wrap: nowrap; }
        .navbar-brand { max-width: calc(100% - 3.5rem); min-width: 0; }
        .navbar-brand > span:last-child,
        .admin-profile > span:last-child { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .navbar-toggler { flex-shrink: 0; }
        .navbar-collapse { padding-top: 0.75rem; }
        .navbar-nav { align-items: stretch !important; gap: 0.25rem !important; }
        .navbar-nav .nav-link { padding-block: 0.65rem; }
        .navbar-nav .admin-profile { max-width: 100%; min-width: 0; }
        .navbar-nav .nav-item > form > .btn { min-height: 44px; width: 100%; }
        .modal-dialog { margin: 0.75rem; }
        .modal-footer { gap: 0.5rem; }
        .modal-footer .btn { flex: 1 1 auto; min-height: 44px; }
    }

    @media (max-width: 575.98px) {
        .login-page { padding: 1rem !important; }
        .login-card { width: 100%; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('table').forEach((table) => {
            if (table.closest('.table-scroll, .table-responsive')) {
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.className = 'table-scroll';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
    });
</script>
