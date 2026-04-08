@extends('admin.layouts.layout')
@section('content')


@push('styles')
    <style>
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

      .dog-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .dog-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .dog-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .dog-top-bar .btn {
        min-width: 185px;
      }

      .dog-master-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .dog-master-head-card .dog-top-bar {
        border-bottom: 0;
      }

      .dog-master-head-card .dog-list-card {
        margin: 0 1rem 1rem;
      }

      .dog-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .dog-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .dog-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .dog-list-card .table td,
      .dog-list-card .table th {
        vertical-align: middle;
      }

      #catch-dog-master-table {
        margin-bottom: 0;
      }

      #catch-dog-master-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #000000;
        background-color: #ffffff;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #catch-dog-master-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #catch-dog-master-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #catch-dog-master-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title {
        color: black;
      }

      .btn-back {
        min-width: 140px;
        font-size: 1rem;
        font-weight: 600;
        background-color: #7d8da1;
        border-color: #7d8da1;
        color: #ffffff;
      }

      .btn-back:hover,
      .btn-back:focus {
        background-color: #6d7d92;
        border-color: #6d7d92;
        color: #ffffff;
      }

      .city-image {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 0.4rem;
        border: 1px solid #e5e7eb;
      }

      .action-icons a {
        font-size: 1.15rem;
      }

      .action-icons {
        white-space: nowrap;
      }

      .action-icon-btn {
        width: auto;
        height: auto;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0;
        background: transparent !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: none !important;
        transition: color 0.2s ease;
      }

      .action-icon-btn i {
        font-size: 25px;
        line-height: 1;
      }

      .action-icon-btn:hover {
        transform: none;
        box-shadow: none;
      }

      #catch-dog-master-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #catch-dog-master-table_wrapper .page-item.active .page-link:hover,
      #catch-dog-master-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      .modal-header-black {
        background-color: #000000;
        color: #ffffff;
      }

      .modal-header-black .btn-close {
        background-color: #e8e7e7 !important;
        border: 0 !important;
        box-shadow: none !important;
        margin-left: auto;
        opacity: 1 !important;
        filter: none !important;
      }

      .doctor-radio-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
      }

      .doctor-radio-card {
        display: inline-block;
        min-width: 280px;
        max-width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        background-color: #f8fafc;
        border: 1px solid #dfe3eb;
        font-size: 1rem;
        font-weight: 600;
        color: #364152;
        cursor: pointer;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.1);
        transition: all 0.2s ease;
      }

      .doctor-radio-input:checked + .doctor-radio-card {
        border-color: #45ab97;
        background-color: #eefaf7;
        color: #1f3b35;
      }

      @media (max-width: 767.98px) {
        .dog-top-bar {
          padding: 0.9rem 1rem;
        }

        .dog-top-bar .page-title {
          font-size: 1.3rem;
        }

        .dog-master-head-card .dog-list-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
@endpush
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card dog-master-head-card">
                <div
                  class="dog-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3"
                >
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2">
                      <i class="fa-solid fa-receipt"></i> Catched Dog List
                    </h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manage-catch-process') }}">Catch Process</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                          <a href="{{ route('catched-dog-list') }}">Catched Dog List</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-catch-process') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>
                <div class="card dog-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Catch Dog List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="catch-dog-master-table"
                        class="table table-striped border-top"
                      >
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Tag No</th>
                            <th>Project</th>
                            <th>Dog Type</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>221</td>
                            <td>Rajkot Municipan Corporation</td>
                            <td>Street</td>
                            <td>Male</td>
                            <td>Bhagavti para,Rajkot Gujarat-360003 India</td>
                            <td>
                              <img src="dog1.jpg" alt="Dog Image" width="50" />
                            </td>
                            <td>2023-01-01</td>
                            <td class="action-icons">
                              <button
                                type="button"
                                class="btn btn-sm action-icon-btn action-receive text-success js-receive-dog"
                                title="Receive"
                                data-dog-id="1"
                                data-dog-tag="221"
                                data-bs-toggle="modal"
                                data-bs-target="#receiveModal"
                              >
                                <i class="fas fa-check-circle"></i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>222</td>
                            <td>Rajkot Municipan Corporation</td>
                            <td>street</td>
                            <td>male</td>
                            <td>Bhagavti para,Rajkot Gujarat-360003 India</td>
                            <td>
                              <img src="dog2.jpg" alt="Dog Image" width="50" />
                            </td>
                            <td>2023-02-01</td>
                            <td class="action-icons">
                              <button
                                type="button"
                                class="btn btn-sm action-icon-btn action-receive text-success js-receive-dog"
                                title="Receive"
                                data-dog-id="2"
                                data-dog-tag="222"
                                data-bs-toggle="modal"
                                data-bs-target="#receiveModal"
                              >
                                <i class="fas fa-check-circle"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Receive Modal -->
              <div
                class="modal fade"
                id="receiveModal"
                tabindex="-1"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header modal-header-black p-3">
                      <h5 class="modal-title text-white" id="receiveModalTitle">
                        Select Doctor
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <form id="receiveForm">
                      <div class="modal-body">
                        <input type="hidden" id="receiveId" />

                        <div class="mb-4">
                          <label class="form-label"
                            >Doctor Name
                            <span class="text-danger">*</span></label
                          >
                          <input
                            class="doctor-radio-input"
                            type="radio"
                            name="doctorSelect"
                            id="doctor1"
                            checked
                          />
                          <label class="doctor-radio-card" for="doctor1"
                            >Rakesh Vora (IIT Gandhinagar)</label
                          >
                        </div>

                        <div class="mb-0">
                          <label for="receiveDatetime" class="form-label"
                            >Date &amp; Time
                            <span class="text-danger">*</span></label
                          >
                          <input
                            type="datetime-local"
                            class="form-control"
                            id="receiveDatetime"
                            required
                          />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-label-secondary"
                          data-bs-dismiss="modal"
                        >
                          Cancel
                        </button>
                        <button
                          type="submit"
                          class="btn btn-dark"
                          id="receiveSubmitBtn"
                        >
                          Select
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection