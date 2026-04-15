@extends('admin.layouts.layout')
@section('content')


@push('styles')
    <style>
      :root {
        --gf-cream: #f2e5dc;
        --gf-charcoal: #373435;
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
    </style>
@endpush

            <!-- Cards with unicons & charts -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6 compact-cards">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-6 metric-card">
                  <div class="card metric-click-card h-100">
                    <a href="#" class="text-decoration-none text-body d-block h-100">
                      <div class="card-body">
                        <span class="badge rounded-pill bg-label-dark metric-value-badge">14</span>
                        <div class="avatar metric-icon mb-2 fs-3">
                          <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <p class="metric-title mb-0">Total Catched DOG List</p>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-6 metric-card">
                  <div class="card metric-click-card h-100">
                    <a href="{{ route('manage-completed-operation-dog-list') }}" class="text-decoration-none text-body d-block h-100">
                      <div class="card-body">
                        <span class="badge rounded-pill bg-label-dark metric-value-badge">14</span>
                        <div class="avatar metric-icon mb-2 fs-3">
                          <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <p class="metric-title mb-0">Complete Operation Dog List</p>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-6 metric-card">
                  <div class="card metric-click-card h-100">
                    <a href="{{ route('total-expired-dog-list') }}" class="text-decoration-none text-body d-block h-100">
                      <div class="card-body">
                        <span class="badge rounded-pill bg-label-dark metric-value-badge">12</span>
                        <div class="avatar metric-icon mb-2 fs-3">
                          <i class="fa-solid fa-clock"></i>
                        </div>
                        <p class="metric-title mb-0">Total Expired Dog List</p>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-6 metric-card">
                  <div class="card metric-click-card h-100">
                    <a href="{{ route('total-rejected-dog-list') }}" class="text-decoration-none text-body d-block h-100">
                      <div class="card-body">
                        <span class="badge rounded-pill bg-label-dark metric-value-badge">19</span>
                        <div class="avatar metric-icon mb-2 fs-3">
                          <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <p class="metric-title mb-0">Total Rejected Dog List</p>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Cards with unicons & charts -->

            <div class="d-flex justify-content-end mt-4">
              <a href="{{ route('export.project_summary') }}" class="btn btn-success" id="btn-export-excel-project-summary" data-base-url="{{ route('export.project_summary') }}">
                <i class="fas fa-file-excel"></i> Export to Excel
              </a>
            </div>

            <div class="card catch-animated-card mt-4">
              <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-white">Project Summary Report</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="project-summary-table" class="table table-striped border-top align-middle">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Project</th>
                        <th>Total Caught</th>
                        <th>Operated</th>
                        <th>Released</th>
                        <th>Expired</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
@endsection            

@push('scripts')
<script>
  $(function () {
    function updateProjectSummaryExportLink() {
      var exportLink = document.getElementById('btn-export-excel-project-summary');
      var exportUrl = new URL(exportLink.dataset.baseUrl, window.location.origin);
      var currentParams = new URLSearchParams(window.location.search);

      currentParams.forEach(function (value, key) {
        exportUrl.searchParams.set(key, value);
      });

      exportLink.href = exportUrl.toString();
    }

    $('#project-summary-table').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth: false,
      ajax: {
        url: '{{ route('project-summary') }}'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'project_name', name: 'project_name' },
        { data: 'total_caught', name: 'total_caught' },
        { data: 'operated_count', name: 'operated_count' },
        { data: 'released_count', name: 'released_count' },
        { data: 'expired_count', name: 'expired_count' }
      ]
    });

    updateProjectSummaryExportLink();
  });
</script>
@endpush