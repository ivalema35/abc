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

      #total-expired-dog-master-table {
        margin-bottom: 0;
      }

      #total-expired-dog-master-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #000000;
        background-color: #ffffff;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #total-expired-dog-master-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #total-expired-dog-master-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #total-expired-dog-master-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title{
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

      #total-expired-dog-master-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #total-expired-dog-master-table_wrapper .page-item.active .page-link:hover,
      #total-expired-dog-master-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
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
                <div class="dog-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-receipt"></i>Total Expired Dog List</h2>
                    <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manage-catch-process') }}">Catch Process</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('project-summary') }}">Project Summary</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('total-expired-dog-list') }}">Total Expired Dog List</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('project-summary') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>
                <div class="card dog-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Total Expired Dog List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="total-expired-dog-master-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Tag No</th>
                            <th>Project</th>
                            <th>Dog Type</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>vehicle</th>
                            <th>Catch Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>35</td>
                            <td>Rajkot Municipan Corporation</td>
                            <td>Street</td>
                            <td>Male</td>
                            <td>123 Main St</td>
                            <td>GJ 01 KT 1234</td>
                            <td>2023-01-01</td>
                            <td class="action-icons">
                              <a href="{{ route('view-expired-dog-list') }}" class="btn btn-sm action-icon-btn action-view text-info" title="View">
                                <i class="bx bx-show"></i>
                              </a>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>47</td>
                            <td>Rajkot Municipan Corporation</td>
                            <td>Street</td>
                            <td>Female</td>
                            <td>456 Oak Ave</td>
                            <td>GJ 01 KT 5678</td>
                            <td>2023-02-01</td>
                            <td class="action-icons">
                              <a href="{{ route('view-expired-dog-list') }}" class="btn btn-sm action-icon-btn action-view text-info" title="View">
                                <i class="bx bx-show"></i>
                              </a>
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