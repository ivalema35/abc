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

      .dog-catcher-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .dog-catcher-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .dog-catcher-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .dog-catcher-top-bar .btn {
        min-width: 140px;
      }

      .dog-catcher-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .dog-catcher-head-card .dog-catcher-table-card {
        margin: 0 1rem 1rem;
      }

      .dog-catcher-table-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .dog-catcher-table-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .dog-catcher-table-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .dog-catcher-table-card .table td,
      .dog-catcher-table-card .table th {
        vertical-align: middle;
      }

      #dog-catcher-table {
        margin-bottom: 0;
      }

      #dog-catcher-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #000000;
        background-color: #ffffff;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #dog-catcher-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #dog-catcher-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #dog-catcher-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title {
        color: black;
      }

      .addbtn {
        background-color: black;
      }


      .table-action-btn {
        min-width: 90px;
      }

      .table-action-btn i {
        font-size: 1.2rem;
      }

      .action-icon-outline {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.45rem;
        border: 1px solid rgba(3, 169, 244, 0.5);
        background-color: #ffffff;
        color: #03a9f4;
      }

      #dog-catcher-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #dog-catcher-table_wrapper .page-item.active .page-link:hover,
      #dog-catcher-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      @media (max-width: 767.98px) {
        .dog-catcher-top-bar {
          padding: 0.9rem 1rem;
        }

        .dog-catcher-top-bar .page-title {
          font-size: 1.3rem;
        }

        .dog-catcher-head-card .dog-catcher-table-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
@endpush    

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card dog-catcher-head-card">
                <div class="dog-catcher-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-dog"></i> Complete operation</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('completed-operation-list') }}">complete operation list</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('complete-list') }}">completed operation</a></li>
                      </ol>
                    </nav>
                  </div>
                </div>
                <div class="card dog-catcher-table-card">
                  <div class="card-header">
                    <h4 class="card-title">Completed Operation List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="dog-catcher-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Tag No</th>
                            <th>Address</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>35</td>
                            <td>null,kotharia Gujarat -360022 India</td>
                            <td>
                              <div class="d-flex table-action-btn">
                                <a class="action-icon-outline" href="{{ route('view-completed-operation') }}" aria-label="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>286</td>
                            <td>mota mava,Rajkot Gujarat -360005 India</td>
                            <td>
                              <div class="d-flex table-action-btn">
                                <a class="action-icon-outline" href="{{ route('view-completed-operation') }}" aria-label="View">
                                  <i class="bx bx-show"></i>
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