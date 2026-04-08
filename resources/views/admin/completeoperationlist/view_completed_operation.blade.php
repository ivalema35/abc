@extends('admin.layouts.layout')
@section('content')


@push('styles')

    <style>
      /* â”€â”€â”€ Sidebar full-label fix â”€â”€â”€ */
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

      /* â”€â”€â”€ Main card â”€â”€â”€ */
      .content-wrapper {
        background: linear-gradient(180deg, #f7f8fb 0%, #eef1f5 100%);
      }

      .catch-main-card {
        border-radius: 0.65rem;
        overflow: hidden;
        box-shadow: 0 0.55rem 1.1rem rgba(15, 23, 42, 0.1);
      }

      .catch-main-card .card-header {
        background: #fff;
        color: #000;
        border-bottom: 1px solid #dfe3ea;
        padding: 0.9rem 1rem;
        margin-bottom: 2rem;
      }

      .view-head-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
      }

      .view-head-breadcrumb .breadcrumb-item,
      .view-head-breadcrumb .breadcrumb-item a {
        font-size: 0.92rem;
        color: #8c95a3;
      }

      .view-head-breadcrumb .breadcrumb-item.active {
        color: #4b5563;
      }
      .btn-export-pdf {
        background: #000;
        color: #fff;
        border: none;
        border-radius: 0.375rem;
        padding: 0.48rem 1.15rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition:
          opacity 0.2s,
          transform 0.2s;
        cursor: pointer;
      }
      .btn-export-pdf:hover {
        opacity: 0.86;
        color: #fff;
        transform: translateY(-1px);
      }

      /* â”€â”€â”€ Dog image card â”€â”€â”€ */
      .catch-img-card {
        background: #fff;
        border: 1px solid #e0e4ea;
        border-radius: 0.5rem;
        overflow: hidden;
        height: auto;
        box-shadow: 0 1px 4px rgba(67, 89, 113, 0.08);
      }
      .catch-img-card .dog-photo {
        width: 100%;
        height: 275px;
        object-fit: cover;
        display: block;
      }
      .catch-img-meta {
        padding: 0.7rem 1rem;
        background: #ffffff;
        color: #000000;
        font-size: 0.84rem;
        line-height: 1.6;
      }
      .catch-img-meta .cam-info {
        opacity: 0.65;
        font-size: 0.76rem;
        margin-top: 0.25rem;
      }

      .dog-extra-gallery {
        margin-top: 0.75rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.6rem;
      }

      .dog-extra-thumb {
        width: 100%;
        height: 112px;
        object-fit: cover;
        border-radius: 0.45rem;
        border: 1px solid #d8dde8;
        box-shadow: 0 0.2rem 0.5rem rgba(15, 23, 42, 0.08);
      }

      .catch-page-layout {
        display: grid;
        grid-template-columns: minmax(300px, 34%) minmax(0, 66%);
        gap: 1rem;
        align-items: start;
      }

      .catch-left-stack,
      .catch-right-stack {
        display: flex;
        flex-direction: column;
        gap: 0.95rem;
      }

      .catch-right-stack .catch-section-heading {
        text-align: left;
        margin: 0 0 0.45rem 0.15rem;
      }

      .catch-vehicle-row {
        margin-top: 0.35rem;
        margin-bottom: 1rem;
      }

      .catch-details-row {
        margin-top: 0.15rem;
      }

      /* â”€â”€â”€ Info table card â”€â”€â”€ */
      .catch-info-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        height: auto;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 0.875rem;
      }
      .catch-info-table td {
        padding: 0.5rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
      }
      .catch-info-table tbody tr:nth-child(even) td {
        background: #f8f9fb;
      }
      .catch-info-table td.lbl {
        font-weight: 600;
        color: #000;
        white-space: nowrap;
        width: 18%;
        background: #f0f2f6;
      }
      .catch-info-table td.val {
        color: #435971;
      }

      /* â”€â”€â”€ Vehicle card â”€â”€â”€ */
      .catch-vehicle-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-vehicle-header {
        background: #000;
        color: #fff;
        padding: 0.52rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        text-align: center;
        letter-spacing: 0.01em;
      }
      .catch-vehicle-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
      }
      .catch-vehicle-table td {
        padding: 0.5rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
      }
      .catch-vehicle-table td.lbl {
        font-weight: 600;
        color: #000;
        width: 38%;
      }
      .catch-vehicle-table td.val {
        color: #435971;
      }

      /* â”€â”€â”€ Section headings â”€â”€â”€ */
      .catch-section-heading {
        color: #000;
        font-size: 1.15rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 0.6rem;
      }

      /* â”€â”€â”€ Sub-tables (treatment + datewise) â”€â”€â”€ */
      .catch-sub-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-sub-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
      }
      .catch-sub-table thead tr {
        background: #000;
      }
      .catch-sub-table thead th {
        padding: 0.5rem 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: 700;
        color: #fff;
        font-size: 0.875rem;
      }
      .catch-sub-table tbody td {
        padding: 0.45rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
        color: #435971;
      }
      .catch-sub-table tbody tr:nth-child(even) td {
        background: #f8f9fb;
      }
      .catch-sub-table tbody td.sub-lbl {
        font-weight: 600;
        color: #000;
      }
      .catch-sub-table tbody td.date-cell {
        white-space: nowrap;
      }
      .date-icon {
        color: #8592a3;
        margin-right: 0.28rem;
        font-size: 0.95rem;
        vertical-align: -1px;
      }
      .process-icon {
        margin-left: 0.5rem;
        color: #aab2bc;
        font-size: 1rem;
        vertical-align: -2px;
      }

      /* â”€â”€â”€ Back button â”€â”€â”€ */
      .btn-back-catch {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 0.375rem;
        padding: 0.48rem 1.15rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s;
      }
      .btn-back-catch:hover {
        opacity: 0.85;
        color: #fff;
      }

      @media (max-width: 991.98px) {
        .catch-main-card .card-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 0.75rem;
        }
        .catch-page-layout {
          grid-template-columns: 1fr;
        }
        .catch-right-stack .catch-section-heading {
          text-align: center;
          margin-left: 0;
        }
      }

      @media (max-width: 767.98px) {
        .dog-extra-thumb {
          height: 96px;
        }
        .catch-info-table {
          font-size: 0.8rem;
        }
        .catch-info-table td {
          padding: 0.42rem 0.55rem;
        }
        .catch-sub-table {
          font-size: 0.8rem;
        }
      }
    </style>
@endpush

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card catch-main-card">
                <div class="card-header d-flex align-items-start justify-content-between gap-2 flex-wrap">
                  <div>
                    <h5 class="view-head-title"><i class="bx bx-show me-2"></i>View completed operation Details</h5>
                    <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item">
                          <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                          <a href="{{ route('completed-operation-list') }}">Completed Operations List</a>
                        </li>

                        <li class="breadcrumb-item">
                          <a href="{{ route('complete-list') }}">Complete List</a>
                        </li>
                        <li class="breadcrumb-item active">
                          <a href="{{ route('view-completed-operation') }}">View completed operation Details</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                  <button class="btn-export-pdf" onclick="window.print()">
                    <i class="bx bx-download"></i> Export PDF
                  </button>
                </div>

                <div class="card-body">
                  <div class="catch-page-layout mb-4">
                    <!-- Left side: all images -->
                    <div class="catch-left-stack">
                      <div class="catch-img-card">
                        <img src="../../assets/img/avatars/1.png" alt="Caught Dog #32" class="dog-photo" />
                        <div class="catch-img-meta">
                          <div class="fw-bold">GIDC, Rajkot</div>
                          <div>Gujarat â€“ 360002</div>
                          <div>India</div>
                          <div class="cam-info">2026-03-12 &nbsp;11:13:37</div>
                        </div>
                      </div>

                      <div class="dog-extra-gallery">
                        <img src="../../assets/img/avatars/2.png" alt="Dog view 2" class="dog-extra-thumb" />
                        <img src="../../assets/img/avatars/3.png" alt="Dog view 3" class="dog-extra-thumb" />
                      </div>
                    </div>

                    <!-- Right side: all tables -->
                    <div class="catch-right-stack">
                      <div class="catch-info-card">
                        <table class="catch-info-table">
                          <tbody>
                            <tr>
                              <td class="lbl">Project</td>
                              <td class="val" colspan="5">Rajkot Municipal Corporation</td>
                            </tr>
                            <tr>
                              <td class="lbl">NGO</td>
                              <td class="val" colspan="5">Goal Foundation</td>
                            </tr>
                            <tr>
                              <td class="lbl">Location</td>
                              <td class="val" colspan="5">GIDC, Rajkot Gujarat â€“ 360002 India</td>
                            </tr>
                            <tr>
                              <td class="lbl">Tag Number</td>
                              <td class="val">35</td>
                              <td class="lbl">Gender</td>
                              <td class="val">female</td>
                              <td class="lbl">Owner Name</td>
                              <td class="val">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="lbl">Street / Owner</td>
                              <td class="val">street</td>
                              <td class="lbl">Age of Dog</td>
                              <td class="val">&nbsp;</td>
                              <td class="lbl">Pup / Adult</td>
                              <td class="val">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="lbl">Color of Dog</td>
                              <td class="val">&nbsp;</td>
                              <td class="lbl">Temp</td>
                              <td class="val">&nbsp;</td>
                              <td class="lbl">Weight of Dog</td>
                              <td class="val">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="lbl">Treatment</td>
                              <td class="val" colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="lbl">RFID</td>
                              <td class="val" colspan="5">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="catch-vehicle-card">
                        <div class="catch-vehicle-header">Vehicle Details</div>
                        <table class="catch-vehicle-table">
                          <tbody>
                            <tr>
                              <td class="lbl">Vehicle Number</td>
                              <td class="val">GJ 01 KT 6006</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div>
                        <h6 class="catch-section-heading">Treatment Details</h6>
                        <div class="catch-sub-card">
                          <table class="catch-sub-table">
                            <thead>
                              <tr>
                                <th>Medicine Name</th>
                                <th>Dose</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="sub-lbl">Aetropine</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Xylazine</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Propofol</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">meloxicam</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">bcomplex</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Ivermectin</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Vitamin</td>
                                <td>-</td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Enrofloxacin</td>
                                <td>-</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div>
                        <h6 class="catch-section-heading">Datewise Details</h6>
                        <div class="catch-sub-card">
                          <table class="catch-sub-table">
                            <thead>
                              <tr>
                                <th colspan="2" class="text-center">Datewise Details</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="sub-lbl">Catched on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  2026-03-12 11:13:51
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Received on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Operation on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Observation on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">R4R Marking on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Released on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Rejected on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                              <tr>
                                <td class="sub-lbl">Expired on</td>
                                <td class="date-cell">
                                  <i class="bx bx-calendar date-icon"></i>
                                  0000-00-00 00:00:00
                                  <i class="bx bx-run process-icon"></i>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Back button -->
                  <div class="mb-2">
                    <a href="{{ route('complete-list') }}" class="btn-back-catch">
                      <i class="bx bx-arrow-back"></i> Back to List
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection           