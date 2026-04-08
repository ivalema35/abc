@extends('admin.layouts.layout')
@section('content')
   
    @push('styles')
    <style>
      :root {
        --vp-primary: #000000;
        --vp-primary-rgb: 0, 0, 0;
        --vp-secondary: #4b5563;
        --vp-secondary-rgb: 75, 85, 99;
        --vp-primary-soft: rgba(var(--vp-secondary-rgb), 0.12);
        --vp-surface: #ffffff;
        --vp-muted: #4b5563;
      }

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

      .view-project-card {
        border: 1px solid #000000;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 14px 38px rgba(var(--vp-primary-rgb), 0.12);
      }

      .view-project-header {
        background: black;
        color: #ffffff;
        padding: 1.3rem 1.5rem;
      }

      .view-project-header .page-title {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: 0.01em;
      }

      .view-project-header .page-subtitle {
        margin: 0.4rem 0 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 0.93rem;
      }

      .project-summary {
        background: linear-gradient(180deg, #ffffff 0%, rgba(var(--vp-secondary-rgb), 0.08) 100%);
        border-top: 1px solid rgba(var(--vp-secondary-rgb), 0.28);
        border-bottom: 1px solid rgba(var(--vp-secondary-rgb), 0.28);
        padding: 1rem 1.4rem;
      }

      .project-summary .hospital-name {
        margin: 0;
        font-size: 1.4rem;
        color: #000000;
        font-weight: 700;
        text-align: center;
      }

      .info-panel {
        background: var(--vp-surface);
        border: 1px solid rgba(var(--vp-secondary-rgb), 0.28);
        border-radius: 0.9rem;
        height: 100%;
      }

      .info-panel .panel-head {
        padding: 0.82rem 1rem;
        border-bottom: 1px solid rgba(var(--vp-secondary-rgb), 0.22);
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ffffff;
        background-color: #000000;
      }

      .info-panel .panel-body {
        padding: 0.8rem 1rem;
      }

      .detail-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.48rem 0;
        border-bottom: 1px dashed rgba(var(--vp-secondary-rgb), 0.22);
      }

      .detail-row:last-child {
        border-bottom: 0;
      }

      .detail-label {
        flex: 0 0 118px;
        color: #000000;
        font-weight: 700;
      }

      .detail-sep {
        color: #4b5563;
        font-weight: 600;
      }

      .detail-value {
        color: var(--vp-muted);
        font-weight: 500;
      }

      .billing-card {
        margin-top: 1.15rem;
        border: 1px solid rgba(var(--vp-secondary-rgb), 0.28);
        border-radius: 0.9rem;
        overflow: hidden;
      }

      .billing-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.95rem 1rem;
        background: #000000;
        border-bottom: 1px solid rgba(var(--vp-secondary-rgb), 0.26);
      }

      .billing-head h5 {
        margin: 0;
        color: #ffffff;
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: 0.01em;
      }

      .add-bill-btn {
        border: 0;
        border-radius: 0.6rem;
        font-weight: 600;
        background: #ffffff;
        color:#000000;
        box-shadow: 0 10px 20px rgba(var(--vp-secondary-rgb), 0.32);
      }

      .add-bill-btn:hover,
      .add-bill-btn:focus {
        background: #4b5563;
      }

      #billing-details-table {
        margin-bottom: 0;
      }

      #billing-details-table thead th {
        background-color: rgba(var(--vp-secondary-rgb), 0.1);
        color: #4b5563;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
      }

      #billing-details-table tbody td {
        color: var(--vp-muted);
        vertical-align: middle;
      }

      .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.28rem 0.62rem;
        border-radius: 999px;
        font-size: 0.73rem;
        font-weight: 700;
      }

      .status-pill.received {
        background: rgba(var(--vp-secondary-rgb), 0.2);
        color: #000000;
      }

      .action-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.34rem;
        color: #4b5563;
        font-weight: 600;
        text-decoration: none;
      }

      .action-chip:hover {
        color: #000000;
      }

      .bill-action-group {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
      }

      .bill-action-btn {
        width: 1.95rem;
        height: 1.95rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
      }

      .bill-modal-header {
        background-color: #000000;
        color: #ffffff;
      }

      .bill-modal-close {
        background: transparent !important;
        border: 0;
        box-shadow: none;
        opacity: 1;
        padding: 0;
      }

      .bill-modal-close:hover {
        background: transparent !important;
        opacity: 1;
      }

      .bill-section-title {
        background-color: #000000;
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.55rem 0.75rem;
        border-radius: 0.45rem;
        margin-bottom: 0.85rem;
      }

      @media (max-width: 767.98px) {
        .view-project-header {
          padding: 1.1rem 1rem;
        }

        .project-summary {
          padding: 0.9rem 1rem;
        }

        .project-summary .hospital-name {
          font-size: 1.08rem;
          line-height: 1.45;
        }

        .detail-row {
          flex-wrap: wrap;
          gap: 0.2rem 0.5rem;
        }

        .detail-label {
          flex-basis: 100%;
          margin-bottom: 0.1rem;
        }
      }
    </style>
    @endpush

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card view-project-card">
                <div class="view-project-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2 text-white"><i class="fa-regular fa-folder-open"></i> View Project</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-project') }}">Manage Project</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('view-project') }}">View Project</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-project') }}" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="project-summary">
                  <h4 class="hospital-name">Marwadi Chandarana Educare Foundation</h4>
                </div>

                <div class="card-body p-3 p-md-4">
                  <div class="row g-3">
                    <div class="col-12 col-lg-6">
                      <div class="info-panel">
                        <div class="panel-head">Project Information</div>
                        <div class="panel-body">
                          <div class="detail-row">
                            <span class="detail-label">NGO Name</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">Goal Foundation</span>
                          </div>
                          <div class="detail-row">
                            <span class="detail-label">Hospital Name</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">Marwadi Chandarana Educare Foundation</span>
                          </div>
                          <div class="detail-row">
                            <span class="detail-label">City Name</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">Gauridad - Rajkot</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-lg-6">
                      <div class="info-panel">
                        <div class="panel-head">Additional Details</div>
                        <div class="panel-body">
                          <div class="detail-row">
                            <span class="detail-label">RFID Status</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">With RFID</span>
                          </div>
                          <div class="detail-row">
                            <span class="detail-label">Contact</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">9687680216</span>
                          </div>
                          <div class="detail-row">
                            <span class="detail-label">PIN</span>
                            <span class="detail-sep">:</span>
                            <span class="detail-value">0216</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="billing-card">
                    <div class="billing-head">
                      <h5>Billing Details</h5>
                      <a href="{{ route('add-bill') }}" class="btn btn-primary add-bill-btn btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Add New Bill
                      </a>
                    </div>

                    <div class="table-responsive">
                      <table id="billing-details-table" class="table table-striped mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Bill No</th>
                            <th>Bill Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>TDS</th>
                            <th>Deduction</th>
                            <th>Charge</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>111</td>
                            <td>06-11-2023</td>
                            <td>06-11-2023</td>
                            <td>15-11-2023</td>
                            <td>1000</td>
                            <td>2000</td>
                            <td>102100.00</td>
                            <td>0</td>
                            <td><span class="status-pill received">Received</span></td>
                            <td>
                              <div class="bill-action-group">
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm bill-action-btn" title="Edit" aria-label="Edit">
                                  <i class="bx bx-edit-alt"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm bill-action-btn" title="Delete" aria-label="Delete">
                                  <i class="bx bx-trash"></i>
                                </a>
                                <a href="{{ route('view-bill') }}" class="btn btn-info btn-sm bill-action-btn" title="View" aria-label="View">
                                  <i class="bx bx-show"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-success btn-sm bill-action-btn" title="Check" aria-label="Check">
                                  <i class="bx bx-check"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

    @endsection