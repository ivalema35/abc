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

      .amount-with-action {
        display: flex;
        align-items: center;
        gap: 0.65rem;
      }

      .amount-with-action .form-control {
        flex: 1;
      }

      .bill-overview-title {
        margin: 0 0 1rem;
        text-align: center;
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        color: #000000;
      }

      .bill-meta-panel {
        background: #ffffff;
        border: 1px solid rgba(var(--vp-secondary-rgb), 0.35);
        border-radius: 0.6rem;
        padding: 0.75rem 1.1rem;
        height: 100%;
      }

      .bill-info-grid {
        width: 100%;
        border-collapse: collapse;
      }

      .bill-info-grid td {
        padding: 0.45rem 0;
        font-size: 0.95rem;
        color: #4b5563;
        vertical-align: top;
      }

      .bill-info-grid .key {
        width: 42%;
        font-weight: 700;
        color: #4b5563;
      }

      .bill-info-grid .sep {
        width: 6%;
        text-align: center;
        font-weight: 700;
      }

      .bill-info-grid .val {
        width: 52%;
        font-weight: 500;
      }

      .bill-section-heading {
        margin: 1.5rem 0 0.7rem;
        color: #4b5563;
        font-size: 1.3rem;
        font-weight: 700;
        letter-spacing: 0.01em;
      }

      .bill-table-card {
        border: 1px solid rgba(var(--vp-secondary-rgb), 0.28);
        border-radius: 0;
        overflow: hidden;
        background: #ffffff;
      }

      .bill-table-card .table-title {
        background: #f3f4f6;
        color: #4b5563;
        text-align: center;
        font-weight: 700;
        padding: 0.6rem 0.75rem;
        font-size: 1rem;
        border-bottom: 1px solid rgba(var(--vp-secondary-rgb), 0.2);
      }

      .bill-data-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
      }

      .bill-data-table th,
      .bill-data-table td {
        border: 1px solid rgba(var(--vp-secondary-rgb), 0.2);
        padding: 0.58rem 0.55rem;
        font-size: 0.93rem;
        color: #4b5563;
        vertical-align: middle;
      }

      .bill-data-table th {
        font-weight: 700;
        background: #f8fafc;
        white-space: nowrap;
      }

      .bill-data-table td {
        font-weight: 500;
      }

      .total-action-btn {
        width: 2.35rem;
        height: 2.35rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        flex: 0 0 auto;
      }

      #oldParticularsBlock {
        display: none;
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

        .bill-overview-title {
          font-size: 1.2rem;
        }

        .bill-section-heading {
          font-size: 1rem;
        }

        .bill-data-table th,
        .bill-data-table td,
        .bill-table-card .table-title,
        .bill-info-grid td {
          font-size: 0.82rem;
        }

        .bill-data-table th,
        .bill-data-table td {
          padding: 0.48rem 0.42rem;
        }
      }
    </style>
@endpush   

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card view-project-card">
                <div class="view-project-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2 text-white"><i class="fa-solid fa-file-invoice"></i> <span id="bill-page-title">View Bill</span></h2>
                    <p class="page-subtitle">Dashboard <span class="mx-1">/</span> Manage Project <span class="mx-1">/</span> View Bill</p>
                  </div>
                  <a href="{{ route('view-project') }}" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card-body p-3 p-md-4">
                  <h3 class="bill-overview-title">Rajkot Municipal Corporation</h3>

                  <div class="row g-3">
                    <div class="col-12 col-lg-6">
                      <div class="bill-meta-panel">
                        <table class="bill-info-grid">
                          <tbody>
                            <tr>
                              <td class="key">NGO Name</td>
                              <td class="sep">:</td>
                              <td class="val">Goal Foundation</td>
                            </tr>
                            <tr>
                              <td class="key">Hospital Name</td>
                              <td class="sep">:</td>
                              <td class="val">Madhapar Hospital</td>
                            </tr>
                            <tr>
                              <td class="key">City Name</td>
                              <td class="sep">:</td>
                              <td class="val">Rajkot</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-12 col-lg-6">
                      <div class="bill-meta-panel">
                        <table class="bill-info-grid">
                          <tbody>
                            <tr>
                              <td class="key">RFID Status</td>
                              <td class="sep">:</td>
                              <td class="val">Without RFID</td>
                            </tr>
                            <tr>
                              <td class="key">Contact</td>
                              <td class="sep">:</td>
                              <td class="val">5387</td>
                            </tr>
                            <tr>
                              <td class="key">PIN</td>
                              <td class="sep">:</td>
                              <td class="val">5387</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <h4 class="bill-section-heading">BILLING DETAILS</h4>

                  <div class="row g-3">
                    <div class="col-12 col-xl-3">
                      <div class="bill-table-card">
                        <div class="table-title">BILLING DETAILS</div>
                        <table class="bill-data-table">
                          <tbody>
                            <tr><th>Bill NO</th><td>1</td></tr>
                            <tr><th>Bill Date</th><td>03-11-2023</td></tr>
                            <tr><th>Start Date</th><td>23-10-2023</td></tr>
                            <tr><th>End Date</th><td>31-10-2023</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-12 col-xl-6">
                      <div class="bill-table-card">
                        <div class="table-title">BILLING PARTICULARS</div>
                        <table class="bill-data-table">
                          <thead>
                            <tr>
                              <th>PARTICULARS</th>
                              <th>No of Dogs</th>
                              <th>Rate/Dog</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Animal Birth Control (ABC)</td>
                              <td>37</td>
                              <td>2992.50</td>
                              <td>110722.50</td>
                            </tr>
                            <tr>
                              <td>Anti-Rabies Vaccination (ARV)</td>
                              <td>298</td>
                              <td>299.25</td>
                              <td>89176.50</td>
                            </tr>
                            <tr>
                              <td>Dog Friendly Centre (DFC)</td>
                              <td>61</td>
                              <td>159.60</td>
                              <td>9735.60</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-12 col-xl-3">
                      <div class="bill-table-card">
                        <div class="table-title">PAYMENT DETAILS</div>
                        <table class="bill-data-table">
                          <tbody>
                            <tr><th>TDS</th><td>0</td></tr>
                            <tr><th>OTHER DEDUCTION</th><td>0</td></tr>
                            <tr><th>TOTAL CHARGE</th><td>209634.60</td></tr>
                            <tr><th>REMAINING AMOUNT</th><td>209634.6</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 mt-1">
                    <div class="col-12 col-xl-4">
                      <div class="bill-table-card">
                        <div class="table-title">RECEIVED PAYMENT HISTORY</div>
                        <table class="bill-data-table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>DATE</th>
                              <th>AMOUNT</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="3" class="text-center">No payment received yet</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection            