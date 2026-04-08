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

      .project-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .project-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .project-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .project-top-bar .btn {
        min-width: 185px;
      }

      .manage-project-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-project-head-card .project-top-bar {
        border-bottom: 0;
      }

      .manage-project-head-card .project-list-card {
        margin: 0 1rem 1rem;
      }

      .project-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .project-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .project-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .project-list-card .table td,
      .project-list-card .table th {
        vertical-align: middle;
      }

      #manage-project-table {
        margin-bottom: 0;
      }

      #manage-project-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-project-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-project-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #manage-project-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      #manage-project-table .badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.4rem 0.55rem;
      }

      .page-title{
        color: black;
      }
      .addbtn{
        background-color: black;
      }
      .project-image {
        width: 68px;
        height: 68px;
        object-fit: cover;
        border-radius: 0.4rem;
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

      /* .action-icon-btn.action-edit {
        background: linear-gradient(180deg, #f7aa2b 0%, #ea8a05 100%);
        box-shadow: 0 8px 18px rgba(234, 138, 5, 0.3);
      } */

      .action-icon-btn i {
        font-size: 29px;
        line-height: 1;
      }

      .action-icon-btn:hover {
        transform: none;
        box-shadow: none;
      }

      .action-set-login {
        padding: 0.33rem 0.8rem;
        border-radius: 0.45rem;
        font-size: 0.82rem;
        font-weight: 600;
        background-color: #22c55e;
        border-color: #22c55e;
        color: #ffffff;
      }

      .action-set-login:hover,
      .action-set-login:focus {
        background-color: #16a34a;
        border-color: #16a34a;
        color: #ffffff;
      }


      #manage-project-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #manage-project-table_wrapper .page-item.active .page-link:hover,
      #manage-project-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .project-top-bar .page-title {
          font-size: 1.3rem;
        }

        .manage-project-head-card .project-list-card {
          margin: 0 0.75rem 0.75rem;
        }

      }
    </style>

  @endpush

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-project-head-card">
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-regular fa-folder-open"></i> Manage Project</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-project') }}">Manage Project</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('add-project') }}" class="addbtn btn btn-dark">
                    <i class="fa-solid fa-plus me-1"></i> Add Project
                  </a>
                </div>
                <div class="card project-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Related Catch Data</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-project-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Project</th>
                            <th>NGO</th>
                            <th>City</th>
                            <th>Hospital</th>
                            <th>Vehicle</th>
                            <th>Visibility</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Marwadi Chandarana Educare Foundation</td>
                            <td>Goal Foundation</td>
                            <td>Gauridad Rajkot</td>
                            <td>Marwadi Chandarana Educare Foundation</td>
                            <td>GJ-01-JT-2002</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="action-icons">
                              <a href="edit_project.html" class="btn action-icon-btn action-edit text-warning me-2" title="Edit">
                                <i class="bx bx-edit"></i>
                              </a>
                              <a href="{{ route('view-project') }}" class="btn action-icon-btn action-view text-info me-2" title="View">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="javascript:void(0)" class="btn btn-sm action-set-login" title="Set Login Details">Set Login Details</a>
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
            
                    