<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('admin-assets') }}/"
  data-template="vertical-menu-template-no-customizer"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo : Dashboard - Analytics | sneat - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin-assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css') }}" />

     <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/dropzone/dropzone.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
      :root {
        --gf-cream: #f2e5dc;
        --gf-charcoal: #373435;
        --gf-sand: #e0c7b8;
        --gf-taupe: #b8927e;
        --gf-paper: #fbf7f3;
        --gf-ink: #2a2728;
      }

      @keyframes cardReveal {
        0% {
          opacity: 0;
          transform: translateY(16px) scale(0.97);
        }
        100% {
          opacity: 1;
          transform: translateY(0) scale(1);
        }
      }

      @keyframes softGlow {
        0%,
        100% {
          box-shadow: 0 0.2rem 0.75rem rgba(55, 52, 53, 0.12);
        }
        50% {
          box-shadow: 0 0.35rem 1rem rgba(55, 52, 53, 0.22);
        }
      }

      @keyframes badgePulse {
        0%,
        100% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.06);
        }
      }

      @keyframes iconFloat {
        0%,
        100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-3px);
        }
      }

      @keyframes gradientSpin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      @keyframes ripplePop {
        0% {
          transform: scale(0.25);
          opacity: 0.45;
        }
        100% {
          transform: scale(1.35);
          opacity: 0;
        }
      }

      @keyframes iconOrbit {
        0%,
        100% {
          transform: translateY(0) rotate(0deg);
        }
        50% {
          transform: translateY(-4px) rotate(4deg);
        }
      }

      @keyframes statCardGlow {
        0%,
        100% {
          box-shadow: 0 0.65rem 1.5rem rgba(55, 52, 53, 0.1);
        }
        50% {
          box-shadow: 0 0.95rem 1.9rem rgba(184, 146, 126, 0.18);
        }
      }

      @keyframes statHighlightSweep {
        0% {
          transform: translateX(-160%) rotate(18deg);
        }
        100% {
          transform: translateX(260%) rotate(18deg);
        }
      }

      @keyframes statIconBob {
        0%,
        100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-3px);
        }
      }

      .compact-cards .card {
        border-radius: 0.75rem;
        border: 1px solid rgba(55, 52, 53, 0.16);
        background: linear-gradient(180deg, #ffffff 0%, var(--gf-cream) 100%);
        box-shadow: 0 0.2rem 0.75rem rgba(55, 52, 53, 0.12);
        position: relative;
        overflow: hidden;
        isolation: isolate;
        animation:
          cardReveal 0.45s ease both,
          softGlow 4.2s ease-in-out infinite;
      }

      .compact-cards .card::before {
        content: '';
        position: absolute;
        inset: -55%;
        background: conic-gradient(
          from 0deg,
          rgba(242, 229, 220, 0),
          rgba(242, 229, 220, 0.92),
          rgba(205, 178, 161, 0.72),
          rgba(242, 229, 220, 0)
        );
        animation: gradientSpin 6.5s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
      }

      .compact-cards .card::after {
        content: '';
        position: absolute;
        top: -140%;
        left: -35%;
        width: 55%;
        height: 300%;
        background: linear-gradient(
          110deg,
          rgba(255, 255, 255, 0) 0%,
          rgba(255, 255, 255, 0.45) 48%,
          rgba(255, 255, 255, 0) 100%
        );
        transform: rotate(16deg);
        transition: left 0.55s ease;
        pointer-events: none;
      }

      .compact-cards .metric-click-card .card-body::after {
        content: '';
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        right: -22px;
        top: -28px;
        background: radial-gradient(circle, rgba(242, 229, 220, 0.78), rgba(205, 178, 161, 0));
        opacity: 0;
        pointer-events: none;
      }

      .compact-cards .card-body {
        padding: 0.72rem;
      }

      .compact-cards .metric-card .card-body {
        position: relative;
        padding-top: 1.45rem;
        padding-bottom: 0.42rem;
      }

      .compact-cards .metric-card .card {
        overflow: hidden;
      }

      .compact-cards .metric-value-badge {
        position: absolute;
        top: 0.52rem;
        right: 0.52rem;
        transform: none;
        z-index: 5;
        font-size: 0.9rem;
        font-weight: 700;
        width: 2.15rem;
        height: 2.15rem;
        min-width: 2.15rem;
        min-height: 2.15rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        text-align: center;
        padding: 0;
        border-radius: 50%;
        background: #000000 !important;
        color: #ffffff !important;
        border: 2px solid #000000;
        box-shadow:
          0 0.35rem 0.85rem rgba(0, 0, 0, 0.45),
          0 0 0 3px rgba(255, 255, 255, 0.9);
      }

      .compact-cards .metric-card .card-title {
        margin-bottom: 0.25rem !important;
      }

      .compact-cards .metric-card .card-body .card-title.d-flex {
        margin-bottom: 0.55rem !important;
      }

      .compact-cards .metric-click-card {
        transition:
          transform 0.2s ease,
          box-shadow 0.2s ease;
      }

      .compact-cards .metric-click-card:hover {
        transform: translateY(-6px) rotateX(2deg) rotateY(-2deg);
        box-shadow: 0 0.55rem 1.2rem rgba(55, 52, 53, 0.28);
        border-top-color: #000000 !important;
        border-top-width: 2px;
      }

      .compact-cards .metric-click-card:hover::before {
        opacity: 1;
      }

      .compact-cards .metric-click-card:hover .card-body::after {
        opacity: 1;
        animation: ripplePop 0.75s ease-out;
      }

      .compact-cards .metric-click-card:hover::after {
        left: 120%;
      }

      .compact-cards .metric-click-card:active {
        transform: translateY(-1px) scale(0.99);
      }

      .compact-cards .metric-icon {
        width: 3.4rem;
        height: 3.4rem;
        animation:
          iconFloat 2.8s ease-in-out infinite,
          iconOrbit 3.8s ease-in-out infinite;
      }

      .compact-cards .avatar.metric-icon {
        width: 3.55rem !important;
        height: 3.55rem !important;
      }

      .compact-cards .metric-icon.avatar {
        background: transparent !important;
        box-shadow: none !important;
      }

      .compact-cards .metric-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: none !important;
        mix-blend-mode: normal !important;
        opacity: 1 !important;
      }

      .compact-cards .metric-title {
        font-weight: 1000;
        color: var(--gf-charcoal);
        font-size: 15px;
      }

      .compact-cards .metric-click-card .card-body {
        cursor: pointer;
      }

      .compact-cards .lower-metric-card .card {
        border-radius: 0.75rem;
      }

      .compact-cards .lower-metric-card .card-body {
        position: relative;
        padding-top: 1.7rem;
        padding-bottom: 0.6rem;
      }

      .compact-cards .lower-metric-card .card-title {
        position: absolute;
        top: 0.65rem;
        right: 0.65rem;
        margin: 0 !important;
        font-size: 0.72rem;
        font-weight: 700;
        line-height: 1;
        padding: 0.36rem 0.58rem;
        border-radius: 999px;
        background: rgba(242, 229, 220, 0.9);
        color: var(--gf-charcoal);
      }

      .compact-cards .lower-metric-card .metric-title {
        font-weight: 600;
        color: var(--gf-charcoal);
        font-size: 0.88rem;
      }

      .compact-cards .lower-metric-card .metric-click-card {
        transition:
          transform 0.2s ease,
          box-shadow 0.2s ease;
      }

      .compact-cards .lower-metric-card .metric-click-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.35rem 1rem rgba(55, 52, 53, 0.22);
        border-top-color: #000000 !important;
        border-top-width: 3px;
      }

      .compact-cards .lower-metric-card .metric-click-card:active {
        transform: translateY(-1px) scale(0.99);
      }

      .compact-cards .lower-metric-card .metric-link {
        text-decoration: none;
        color: inherit;
        display: block;
      }

      /* force all dashboard cards to exactly same size */
      .compact-cards .metric-card .card {
        height: 144px;
        min-height: 144px;
      }

      .compact-cards .metric-card .card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
      }

      .compact-cards .metric-title {
        line-height: 1.2;
        min-height: 1.8rem;
        display: -webkit-box;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
      }

      /* strict non-destructive: hide extra lower-card internals without deleting markup */
      .compact-cards .lower-metric-card .metric-link > div:not(.card-body) {
        display: none !important;
      }

      .compact-cards .lower-metric-card .card-body > :not(.avatar):not(.metric-title):not(.card-title) {
        display: none !important;
      }

      .compact-cards .lower-metric-card .card-title {
        background: rgba(242, 229, 220, 0.92);
        animation: badgePulse 2.8s ease-in-out infinite;
      }

      .compact-cards .metric-value-badge {
        animation: badgePulse 2.8s ease-in-out infinite;
      }

      .compact-cards .col-xl-2:nth-child(1) .card {
        animation-delay: 0.04s, 0s;
      }
      .compact-cards .col-xl-2:nth-child(2) .card {
        animation-delay: 0.08s, 0.12s;
      }
      .compact-cards .col-xl-2:nth-child(3) .card {
        animation-delay: 0.12s, 0.2s;
      }
      .compact-cards .col-xl-2:nth-child(4) .card {
        animation-delay: 0.16s, 0.3s;
      }
      .compact-cards .col-xl-2:nth-child(5) .card {
        animation-delay: 0.2s, 0.4s;
      }
      .compact-cards .col-xl-2:nth-child(6) .card {
        animation-delay: 0.24s, 0.5s;
      }
      .compact-cards .col-xl-2:nth-child(7) .card {
        animation-delay: 0.28s, 0.6s;
      }
      .compact-cards .col-xl-2:nth-child(8) .card {
        animation-delay: 0.32s, 0.7s;
      }
      .compact-cards .col-xl-2:nth-child(9) .card {
        animation-delay: 0.36s, 0.8s;
      }
      .compact-cards .col-xl-2:nth-child(10) .card {
        animation-delay: 0.4s, 0.9s;
      }
      .compact-cards .col-xl-2:nth-child(11) .card {
        animation-delay: 0.44s, 1s;
      }
      .compact-cards .col-xl-2:nth-child(12) .card {
        animation-delay: 0.48s, 1.1s;
      }

      /* Show full sidebar menu labels instead of truncating with ellipsis */
      #layout-menu .menu-inner .menu-link .text-truncate {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
        line-height: 1.25;
        display: block;
      }

      #layout-menu .menu-inner .menu-link {
        height: auto !important;
        min-height: 2.7rem;
        align-items: flex-start;
        padding-top: 0.55rem;
        padding-bottom: 0.55rem;
      }

      #layout-menu .menu-inner .menu-link .menu-icon,
      #layout-menu .menu-inner .menu-link .menu-toggle-icon {
        margin-top: 0.1rem;
      }

      .admin-hero-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(55, 52, 53, 0.12);
        color: var(--gf-charcoal);
        background:
          radial-gradient(circle at top right, rgba(255, 255, 255, 0.9), transparent 26%),
          linear-gradient(135deg, #ffffff 0%, var(--gf-cream) 58%, #ead8cb 100%);
        box-shadow: 0 1rem 2rem rgba(55, 52, 53, 0.12);
      }

      .admin-hero-card::after {
        content: '';
        position: absolute;
        inset: auto -4rem -4rem auto;
        width: 15rem;
        height: 15rem;
        border-radius: 50%;
        /* background: rgba(184, 146, 126, 0.14); */
      }

      .admin-hero-card .chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.8rem;
        border-radius: 999px;
        background: rgba(55, 52, 53, 0.08);
        color: var(--gf-charcoal);
        font-size: 0.82rem;
        font-weight: 600;
      }

      .modal-header-black {
        background-color: #000000;
        color: #ffffff;
      }

      .modal-header-black .btn-close {
        background-color: #ffffff;
        opacity: 1;
      }

      .swal2-popup.sneat-toast-popup {
        border-radius: 0.9rem;
        border: 1px solid rgba(105, 108, 255, 0.18);
        background: linear-gradient(135deg, #ffffff 0%, #f5f5ff 100%);
        color: #566a7f;
        box-shadow: 0 0.5rem 1.25rem rgba(67, 89, 113, 0.16);
      }

      .swal2-popup.sneat-toast-popup .swal2-title {
        color: #566a7f;
        font-weight: 600;
      }

      .swal2-popup.sneat-toast-popup .swal2-timer-progress-bar {
        background: #696cff;
      }

      .admin-stat-card {
        border: 1px solid rgba(55, 52, 53, 0.1);
        border-radius: 1rem;
        background: linear-gradient(180deg, #ffffff 0%, var(--gf-paper) 100%);
        box-shadow: 0 0.65rem 1.5rem rgba(55, 52, 53, 0.1);
        position: relative;
        overflow: hidden;
        transition:
          transform 0.2s ease,
          box-shadow 0.2s ease;
        animation: statCardGlow 4s ease-in-out infinite;
      }

      .admin-stat-card::before {
        content: '';
        position: absolute;
        inset: -35% auto auto -30%;
        width: 70%;
        height: 180%;
        background: linear-gradient(
          120deg,
          rgba(255, 255, 255, 0) 0%,
          rgba(224, 199, 184, 0.16) 45%,
          rgba(255, 255, 255, 0) 100%
        );
        pointer-events: none;
        animation: statHighlightSweep 5.8s linear infinite;
      }

      .admin-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.9rem 1.8rem rgba(55, 52, 53, 0.16);
      }

      .admin-stat-card .stat-icon {
        width: 3.25rem;
        height: 3.25rem;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        animation: statIconBob 2.8s ease-in-out infinite;
      }

      .admin-stat-card .stat-label {
        color: #7a6d67;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-transform: uppercase;
      }

      .admin-stat-card .stat-value {
        color: var(--gf-ink);
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1;
      }

      .admin-stat-card .stat-trend {
        font-size: 0.74rem;
        font-weight: 600;
      }

      .admin-stat-card .card-body {
        padding: 0.95rem;
        position: relative;
        z-index: 1;
      }

      .admin-stat-card .stat-meta {
        color: #8a7d76;
        font-size: 0.73rem;
      }

      .dashboard-panel {
        border: 1px solid rgba(55, 52, 53, 0.1);
        border-radius: 1.1rem;
        box-shadow: 0 0.85rem 2rem rgba(55, 52, 53, 0.1);
      }

      .dashboard-panel .card-header {
        background: transparent;
        border-bottom: 0;
        padding-bottom: 0;
      }

      .dashboard-subtitle {
        color: #7a6d67;
        font-size: 0.9rem;
      }

      .overview-kpi {
        padding: 0.85rem 1rem;
        border-radius: 1rem;
        background: linear-gradient(180deg, #fffdfb 0%, var(--gf-cream) 100%);
        border: 1px solid rgba(55, 52, 53, 0.08);
      }

      .overview-kpi small {
        display: block;
        color: #7a6d67;
        margin-bottom: 0.25rem;
      }

      .overview-kpi strong {
        color: var(--gf-ink);
        font-size: 1.15rem;
      }

      .overview-project-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.85rem;
      }

      .overview-project-item {
        padding: 0.85rem 0.95rem;
        border-radius: 0.95rem;
        background: rgba(255, 255, 255, 0.72);
        border: 1px solid rgba(55, 52, 53, 0.08);
      }

      .overview-project-item span {
        display: block;
        color: #7a6d67;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
      }

      .overview-project-item strong {
        color: var(--gf-ink);
        font-size: 1rem;
      }

      .signal-list {
        display: grid;
        gap: 0.9rem;
      }

      .signal-item {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
      }

      .signal-item .signal-dot {
        width: 0.8rem;
        height: 0.8rem;
        border-radius: 50%;
        margin-top: 0.35rem;
        flex-shrink: 0;
      }

      .ops-table thead th {
        font-size: 0.76rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #64748b;
        border-bottom-width: 1px;
      }

      .ops-table tbody td {
        vertical-align: middle;
      }

      .queue-item,
      .inventory-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.85rem 0;
      }

      .queue-item + .queue-item,
      .inventory-item + .inventory-item {
        border-top: 1px dashed rgba(148, 163, 184, 0.45);
      }

      .queue-meta,
      .inventory-meta {
        color: #7a6d67;
        font-size: 0.86rem;
      }

      .mini-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.32rem 0.65rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
      }

      .field-team-card {
        background: linear-gradient(180deg, #fffaf6 0%, #ffffff 100%);
      }

      @media (max-width: 767.98px) {
        .admin-hero-card .card-body {
          padding: 1.25rem;
        }

        .admin-stat-card .stat-value {
          font-size: 1.25rem;
        }

        .overview-project-list {
          grid-template-columns: 1fr;
        }
      }
    </style>
    <!-- Helpers -->
    <script src="{{ asset('admin-assets/vendor/js/helpers.js') }}"></script>
    
    <script src="{{ asset('admin-assets/js/config.js') }}"></script>
    @stack('styles')

    
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo d-flex justify-content-center h-auto">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="{{  asset('admin-assets/img/logo.png') }}" alt="Goalf Logo" width="150" />
              </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-item active open">
              <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Role & Permission">Role &amp; Permission</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div class="text-truncate" data-i18n="Role & Permission">Role &amp; Permission</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('roles.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Role">Role</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('permissions.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Permission">Permission</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Today List">Today List</span>
            </li>
            <li class="menu-item">
              <a href="{{ route('today-catch-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div class="text-truncate" data-i18n="Today's Catch List">Today's Catch List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('completed-operation-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div class="text-truncate" data-i18n="Completed Operations List">Completed Operations List</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="New Project">New Project</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div class="text-truncate" data-i18n="Create New Project">Create New Project</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('manage-project.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-folder"></i>
                    <div class="text-truncate" data-i18n="Manage Project">Manage Project</div>
                  </a>
                </li>
                @can('view city')
                <li class="menu-item">
                  <a href="{{ route('manage-city') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-buildings"></i>
                    <div class="text-truncate" data-i18n="Manage City">Manage City</div>
                  </a>
                </li>
                @endcan
                @can('view ngo')
                <li class="menu-item">
                  <a href="{{ route('manage-ngo') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div class="text-truncate" data-i18n="Manage NGO">Manage NGO</div>
                  </a>
                </li>
                @endcan
                @can('view hospital')
                <li class="menu-item">
                  <a href="{{ route('manage-hospital.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-clinic"></i>
                    <div class="text-truncate" data-i18n="Manage Hospital">Manage Hospital</div>
                  </a>
                </li>
                @endcan
                @can('view doctor')
                <li class="menu-item">
                  <a href="{{ route('manage-doctor.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div class="text-truncate" data-i18n="Manage Doctor">Manage Doctor</div>
                  </a>
                </li>
                @endcan
                @can('view vehicle')
                <li class="menu-item">
                  <a href="{{ route('manage-vehicle.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-car"></i>
                    <div class="text-truncate" data-i18n="Manage Vehicle">Manage Vehicle</div>
                  </a>
                </li>
                @endcan
                <li class="menu-item {{ request()->is('manage-staff-preview*') || request()->is('add-staff-preview*') ? 'active' : '' }}">
                  <a href="{{ url('manage-staff-preview') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Staff Master">Staff Master</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Staff">Staff</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div class="text-truncate" data-i18n="Manage Staff ARV/ABC">Manage Staff ARV/ABC</div>
              </a>
              <ul class="menu-sub">
                @can('view arv staff')
                <li class="menu-item">
                  <a href="{{ route('manage-arv-staff.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-id-card"></i>
                    <div class="text-truncate" data-i18n="Manage ARV Staff">Manage ARV Field Staff</div>
                  </a>
                </li>
                @endcan
                @can('view catching staff')
                <li class="menu-item">
                  <a href="{{ route('manage-catching-staff.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-voice"></i>
                    <div class="text-truncate" data-i18n="Manage Catching Staff">Manage Catching Staff</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Hospitals">Hospitals</span>
            </li>
            <li class="menu-item">
              <a href="{{ route('manage-arv') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-injection"></i>
                <div class="text-truncate" data-i18n="Manage ARV">Manage ARV</div>
              </a>
            </li>
            @can('view medicare')
            <li class="menu-item">
              <a href="{{ route('manage-medicare.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-medical"></i>
                <div class="text-truncate" data-i18n="Manage Medicare">Manage Medicare</div>
              </a>
            </li>
            @endcan
            @can('view medicine')
            <li class="menu-item">
              <a href="{{ route('manage-medicine.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-capsule"></i>
                <div class="text-truncate" data-i18n="Manage Medicine">Manage Medicine</div>
              </a>
            </li>
            @endcan
            @can('view bill master')
            <li class="menu-item">
              <a href="{{ route('manage-bill-master.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div class="text-truncate" data-i18n="Manage Bill Master">Manage Bill Master</div>
              </a>
            </li>
            @endcan
            <li class="menu-item">
              <a href="{{ route('catching-records.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div class="text-truncate" data-i18n="Catching Records">Catching Records</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('manage-catch-process') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-loader-circle"></i>
                <div class="text-truncate" data-i18n="Catch Process">Catch Process</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Surgery">Surgery</span>
            </li>
            <li class="menu-item">
              <a href="{{ route('expired-dog-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div class="text-truncate" data-i18n="Expired Dog List">Expired Dog List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('R4R-operation-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div class="text-truncate" data-i18n="R4R Operation List">R4R Operation List</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Setting">Setting</span>
            </li>
            @can('view settings')
            <li class="menu-item">
              <a href="{{ route('settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate" data-i18n="Settings">Settings</div>
              </a>
            </li>
            @endcan
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                    <i class="bx bx-search bx-md"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal ms-4">Search (Ctrl+/)</span>
                  </a>
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar">
                      <img src="{{ asset('admin-assets/img/logo.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <img src="{{ asset('admin-assets/img/logo.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0">John Doe</h6>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    @can('view settings')
                    <li>
                      <a class="dropdown-item" href="{{ route('settings.index') }}">
                        <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                      </a>
                    </li>
                    @endcan
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                       @csrf
                    <li>
                      <a class="dropdown-item" href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                      </a>
                    </li>
                    </form>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="bx bx-x bx-md search-toggler cursor-pointer"></i>
            </div>
          </nav>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            
                @yield('content')

          </div>
          <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="modal fade" id="stockAccessModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header modal-header-black p-3">
                <h5 class="modal-title text-white">Stock Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="stockAccessForm">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="stockPassword" class="form-label">Stock Password</label>
                    <input type="password" class="form-control" id="stockPassword" name="stockPassword" required />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-dark">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
      </div>
      <!-- / Layout wrapper -->
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>


    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin-assets/js/main.js') }}"></script>
     <script src="{{ asset('admin-assets/js/dashboards-analytics.js') }}"></script>
       <script src="{{ asset('admin-assets/js/tables-datatables-basic.js') }}"></script>
<!-- Dropzone -->
    <script src="{{ asset('admin-assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <!-- Form Validation -->
    <script src="{{ asset('admin-assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'sneat-toast-popup'
        },
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });

      function showToast(icon, title) {
        let themeColor = '#696cff';
        if (icon === 'success') themeColor = '#71dd37';
        if (icon === 'error') themeColor = '#ff3e1d';
        if (icon === 'warning') themeColor = '#ffab00';
        if (icon === 'info') themeColor = '#03c3ec';

        Toast.fire({
          icon: icon,
          title: title,
          iconColor: themeColor,
          color: '#566a7f',
          background: '#ffffff',
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;

            const progressBar = toast.querySelector('.swal2-timer-progress-bar');
            if (progressBar) {
              progressBar.style.backgroundColor = themeColor;
            }
          }
        });
      }

      function confirmDelete(callback) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#696cff',
          cancelButtonColor: '#ff3e1d',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            callback();
          }
        });
      }
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var stockAccessForm = document.getElementById('stockAccessForm');
        if (stockAccessForm) {
          stockAccessForm.addEventListener('submit', function (event) {
            event.preventDefault();
            window.location.href = '../stock/stock_index.html';
          });
        }

        var chartTextColor = '#7a6d67';
        var chartBorderColor = 'rgba(55, 52, 53, 0.12)';
        var dashboardChartData = window.dashboardChartData || {};
        var weeklyData = dashboardChartData.weekly || {};
        var monthlyMixData = dashboardChartData.monthlyMix || {};

        var dailyOverviewChart = document.querySelector('#dailyOverviewChart');
        if (dailyOverviewChart && typeof ApexCharts !== 'undefined') {
          new ApexCharts(dailyOverviewChart, {
            chart: {
              height: 330,
              type: 'line',
              toolbar: { show: false },
              parentHeightOffset: 0
            },
            series: [
              {
                name: 'Caught',
                type: 'column',
                data: weeklyData.caught || [0, 0, 0, 0, 0, 0, 0]
              },
              {
                name: 'Released',
                type: 'line',
                data: weeklyData.released || [0, 0, 0, 0, 0, 0, 0]
              },
              {
                name: 'Expired',
                type: 'line',
                data: weeklyData.expired || [0, 0, 0, 0, 0, 0, 0]
              }
            ],
            stroke: {
              width: [0, 3, 3],
              curve: 'smooth'
            },
            colors: ['#373435', '#b8927e', '#e0c7b8'],
            fill: {
              opacity: [0.92, 1, 1],
              gradient: {
                shade: 'light',
                type: 'vertical',
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 90, 100]
              }
            },
            dataLabels: { enabled: false },
            plotOptions: {
              bar: {
                borderRadius: 8,
                columnWidth: '38%'
              }
            },
            grid: {
              borderColor: chartBorderColor,
              strokeDashArray: 5,
              padding: {
                top: -8,
                left: 0,
                right: 0,
                bottom: -8
              }
            },
            xaxis: {
              categories: weeklyData.labels || ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
              axisBorder: { show: false },
              axisTicks: { show: false },
              labels: { style: { colors: chartTextColor, fontSize: '12px' } }
            },
            yaxis: {
              labels: { style: { colors: chartTextColor, fontSize: '12px' } }
            },
            legend: {
              position: 'top',
              horizontalAlign: 'left',
              labels: { colors: chartTextColor }
            },
            tooltip: {
              shared: true,
              intersect: false
            }
          }).render();
        }

        var operationMixChart = document.querySelector('#operationMixChart');
        if (operationMixChart && typeof ApexCharts !== 'undefined') {
          new ApexCharts(operationMixChart, {
            chart: {
              height: 260,
              type: 'donut'
            },
            labels: monthlyMixData.labels || ['In Process', 'Observation', 'R4R', 'Released', 'Expired'],
            series: monthlyMixData.series || [0, 0, 0, 0, 0],
            colors: ['#373435', '#8f6f62', '#b8927e', '#d7b9aa', '#ead8cb'],
            stroke: {
              width: 0
            },
            dataLabels: {
              enabled: false
            },
            legend: {
              position: 'bottom',
              labels: { colors: chartTextColor }
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '68%',
                  labels: {
                    show: true,
                    value: {
                      show: true,
                      fontSize: '1.5rem',
                      fontWeight: 700,
                      color: '#2a2728'
                    },
                    total: {
                      show: true,
                      label: 'This Month',
                      color: chartTextColor,
                      formatter: function () {
                        var series = monthlyMixData.series || [0, 0, 0, 0, 0];
                        return series.reduce(function (sum, value) { return sum + value; }, 0).toString();
                      }
                    }
                  }
                }
              }
            }
          }).render();
        }
      });
    </script>
    @stack('scripts')
  </body>
</html>
