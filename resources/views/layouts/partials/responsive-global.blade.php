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

    /* General Form & Card Responsive */
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

        /* Prevent breaking flex inside navbars and dialogs */
        .d-flex:not(.login-page):not(.navbar):not(.navbar-nav):not(.navbar-action-buttons):not(.navbar-collapse):not(.admin-profile):not(.input-group):not(.btn-group):not(.swal2-actions) {
            flex-direction: column;
            align-items: stretch !important;
        }

        /* Form elements full-width on mobile except navbar items and switches */
        button:not(.navbar-toggler):not(.theme-toggle):not(.navbar button):not(.swal2-confirm):not(.swal2-cancel),
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

        .modal-dialog {
            margin: 0.75rem;
        }

        .modal-footer {
            gap: 0.5rem;
        }

        .modal-footer .btn {
            flex: 1 1 auto;
            min-height: 44px;
        }
    }

    /* Navbar Responsive Fix (Below 992px Bootstrap lg breakpoint) */
    @media (max-width: 991.98px) {
        .navbar > .container,
        .navbar > .container-fluid {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            position: relative;
        }

        .navbar-brand {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            max-width: calc(100% - 58px) !important;
            min-width: 0 !important;
            margin: 0 !important;
            font-size: 1.12rem;
            font-weight: 700;
        }

        .navbar-brand > span:last-child {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .navbar-toggler {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-left: auto !important;
            flex-shrink: 0 !important;
            width: 42px !important;
            height: 38px !important;
            padding: 4px 8px !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-soft, #e2e8f0) !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .navbar-collapse {
            flex-basis: 100% !important;
            width: 100% !important;
            padding: 0.85rem 0.25rem 0.5rem !important;
            margin-top: 0.65rem !important;
            border-top: 1px solid var(--border-soft, #e2e8f0);
        }

        .navbar-nav {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 0.35rem !important;
            align-items: stretch !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .navbar-nav .nav-item {
            width: 100% !important;
            list-style: none;
        }

        .navbar-nav .nav-link {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            padding: 0.7rem 0.95rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
            font-size: 0.94rem !important;
            text-align: left !important;
            text-decoration: none !important;
            color: var(--text-main, #1e293b);
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            background: rgba(37, 99, 235, 0.06);
            color: var(--primary-blue, #2563eb) !important;
        }

        .navbar-nav .nav-link.active {
            background: rgba(37, 99, 235, 0.1) !important;
            color: var(--primary-blue, #2563eb) !important;
            font-weight: 600 !important;
        }

        .navbar-nav .admin-profile {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 0.65rem 0.95rem !important;
            border-radius: 8px !important;
            background: rgba(15, 23, 42, 0.03);
            border: 1px solid var(--border-soft, #e2e8f0);
            width: 100% !important;
            margin: 0.25rem 0 !important;
        }

        .navbar-nav .admin-profile > span:last-child {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .navbar-action-buttons {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 0.5rem !important;
            width: 100% !important;
            margin-top: 0.35rem !important;
        }

        .navbar-action-buttons .theme-toggle {
            flex: 1 1 50% !important;
            min-height: 42px !important;
            height: 42px !important;
            border-radius: 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.4rem !important;
            font-weight: 500 !important;
            font-size: 0.88rem !important;
            width: auto !important;
        }

        .navbar-action-buttons form {
            flex: 1 1 50% !important;
            width: auto !important;
            margin: 0 !important;
        }

        .navbar-action-buttons form .btn,
        .navbar-action-buttons .logout-btn {
            width: 100% !important;
            min-height: 42px !important;
            height: 42px !important;
            border-radius: 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.4rem !important;
            font-weight: 600 !important;
            font-size: 0.88rem !important;
        }
    }

    /* Dark Mode Navbar Specifics */
    html[data-theme="dark"] .navbar-collapse {
        border-top-color: #334155 !important;
    }

    html[data-theme="dark"] .navbar-toggler {
        border-color: #475569 !important;
        background: rgba(255, 255, 255, 0.05) !important;
    }

    html[data-theme="dark"] .navbar-toggler-icon {
        filter: invert(1) brightness(2);
    }

    html[data-theme="dark"] .navbar-nav .nav-link {
        color: #CBD5E1 !important;
    }

    html[data-theme="dark"] .navbar-nav .nav-link:hover,
    html[data-theme="dark"] .navbar-nav .nav-link:focus {
        background: rgba(255, 255, 255, 0.06) !important;
        color: #FFFFFF !important;
    }

    html[data-theme="dark"] .navbar-nav .nav-link.active {
        background: rgba(37, 99, 235, 0.25) !important;
        color: #60A5FA !important;
    }

    html[data-theme="dark"] .navbar-nav .admin-profile {
        background: rgba(15, 23, 42, 0.5) !important;
        border-color: #334155 !important;
        color: #E2E8F0 !important;
    }

    html[data-theme="dark"] .navbar-action-buttons .theme-toggle {
        border-color: #475569 !important;
        color: #CBD5E1 !important;
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
