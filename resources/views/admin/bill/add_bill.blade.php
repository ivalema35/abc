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
      }
    </style>
@endpush

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card view-project-card">
                <div class="view-project-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2 text-white"><i class="fa-solid fa-file-circle-plus"></i> <span id="bill-page-title">Add New Bill</span></h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-hospital.index') }}">Manage Hospital</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Bill</li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('view-project') }}" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card-body p-3 p-md-4">
                  <form id="add-bill-form" enctype="multipart/form-data">
                    <div class="row g-3">
                      <div class="col-12 col-lg-6">
                        <div class="bill-section-title">Bill Details</div>
                        <div class="mb-3">
                          <label class="form-label" for="billNo">Bill No<span class="text-danger">*</span></label>
                          <input type="text" id="billNo" class="form-control" placeholder="Enter bill number" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="billDate">Bill Date<span class="text-danger">*</span></label>
                          <input type="date" id="billDate" class="form-control" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="startDate">Start Date<span class="text-danger">*</span></label>
                          <input type="date" id="startDate" class="form-control" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="endDate">End Date<span class="text-danger">*</span></label>
                          <input type="date" id="endDate" class="form-control" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="tdsAmount">TDS Amount<span class="text-danger">*</span></label>
                          <input type="number" id="tdsAmount" class="form-control" placeholder="Enter TDS amount" min="0" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="otherDeduction">Other Deduction<span class="text-danger">*</span></label>
                          <input type="number" id="otherDeduction" class="form-control" placeholder="Enter deduction" min="0" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="otherDeductionDetails">Other Deduction Details<span class="text-danger">*</span></label>
                          <textarea id="otherDeductionDetails" class="form-control" rows="3" placeholder="Enter deduction details"></textarea>
                        </div>
                        <div class="mb-0">
                          <label class="form-label">Bill Documents <span class="text-danger">*</span></label>
                          <div class="border border-dashed rounded-2 text-center bg-light" id="billDropzone" style="cursor: pointer; transition: all 0.3s ease; width: 140px; height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <i class="bx bx-cloud-upload" style="font-size: 2rem; color: #6366f1; margin-bottom: 0.5rem;"></i>
                            <small class="text-muted" style="font-size: 0.75rem;">Click or drop</small>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-lg-6">
                        <div id="oldParticularsBlock">
                          <div class="bill-section-title">Old Particulars Details</div>
                          <div class="mb-3">
                            <label class="form-label" for="oldBillType">Select Bill Type<span class="text-danger">*</span></label>
                            <select id="oldBillType" class="form-select">
                              <option value="">Select bill type</option>
                              <option value="catching">Catching Bill</option>
                              <option value="operation" selected>Operation Bill</option>
                              <option value="arv">ARV Bill</option>
                              <option value="other">Other Bill</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="oldDogCount">Dog Count<span class="text-danger">*</span></label>
                            <input type="number" id="oldDogCount" class="form-control" value="37" min="0" />
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="oldRatePerDog">Rate Per Dog<span class="text-danger">*</span></label>
                            <input type="number" id="oldRatePerDog" class="form-control" value="2992.50" min="0" />
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="oldTotalAmount">Total Amount</label>
                            <div class="amount-with-action">
                              <input type="number" id="oldTotalAmount" class="form-control" value="110722.50" readonly />
                              <button type="button" class="btn btn-danger total-action-btn" aria-label="Delete old particulars" title="Delete old particulars">
                                <i class="bx bx-trash"></i>
                              </button>
                            </div>
                          </div>
                        </div>

                        <div class="bill-section-title">Bill Particular Details</div>
                        <div class="mb-3">
                          <label class="form-label" for="billType">Select Bill Type<span class="text-danger">*</span></label>
                          <select id="billType" class="form-select">
                            <option value="">Select bill type</option>
                            <option value="catching">Catching Bill</option>
                            <option value="operation">Operation Bill</option>
                            <option value="arv">ARV Bill</option>
                            <option value="other">Other Bill</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="dogCount">Dog Count<span class="text-danger">*</span></label>
                          <input type="number" id="dogCount" class="form-control" placeholder="Enter dog count" min="0" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ratePerDog">Rate Per Dog<span class="text-danger">*</span></label>
                          <input type="number" id="ratePerDog" class="form-control" placeholder="Enter rate" min="0" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="totalAmount">Total Amount</label>
                          <div class="amount-with-action">
                            <input type="number" id="totalAmount" class="form-control" placeholder="Auto calculated" readonly />
                            <button type="button" class="btn btn-success total-action-btn" aria-label="Add particulars" title="Add particulars">
                              <i class="bx bx-plus"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                      <a href="view_project.html" class="btn btn-label-secondary">Close</a>
                      <button type="submit" class="btn btn-dark" id="bill-submit-btn">Save Bill</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection         