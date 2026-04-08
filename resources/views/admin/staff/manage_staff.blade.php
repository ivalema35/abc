@extends('admin.layouts.layout')
@section('title', 'Manage Staff')
@section('content')

@push('styles')
    <style>
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
      }

      .manage-project-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      }

      .manage-project-head-card .project-list-card {
        margin: 0 1rem 1rem;
      }

      .page-title {
        color: #000000;
      }

      .addbtn {
        background-color: #000000;
      }

      .project-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .project-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .project-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      #manage-staff-table {
        margin-bottom: 0;
      }

      #manage-staff-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-staff-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
        vertical-align: middle;
      }

      #manage-staff-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .project-image {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
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
        font-size: 23px;
        line-height: 1;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .manage-project-head-card .project-list-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
@endpush

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card manage-project-head-card mb-4">
    <div class="project-top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="page-title d-flex align-items-center gap-2 mb-1">
          <i class="fa-solid fa-users-gear"></i> Master / Manage Staff
        </h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Staff</li>
          </ol>
        </nav>
      </div>
      <a href="{{ url('add-staff-preview') }}" class="addbtn btn btn-dark">
        <i class="fa-solid fa-plus me-1"></i> Add New Staff
      </a>
    </div>

    <div class="card project-list-card">
      <div class="card-header">
        <h4 class="card-title">Staff List</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table border-top" id="manage-staff-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Staff Type</th>
                <th>Name</th>
                <th>Hospital</th>
                <th>City</th>
                <th>Contact</th>
                <th>Vehicle Number</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><span class="badge bg-label-info">Vehicle</span></td>
                <td>Rahul Sharma</td>
                <td>ABC Animal Care Hospital</td>
                <td>Ahmedabad</td>
                <td>9876543210</td>
                <td>GJ01AB1234</td>
                <td>
                  <img
                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Crect width='48' height='48' rx='8' fill='%23eef2f7'/%3E%3Cpath d='M24 24c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8Zm0 4c-6.7 0-12 3.6-12 8v2h24v-2c0-4.4-5.3-8-12-8Z' fill='%2392a1b4'/%3E%3C/svg%3E"
                    alt="Staff Preview"
                    class="project-image"
                  >
                </td>
                <td>
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" checked>
                  </div>
                </td>
                <td>
                  <div class="action-icons d-flex align-items-center gap-2">
                    <a href="javascript:void(0)" class="action-icon-btn text-primary" title="Edit">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="javascript:void(0)" class="action-icon-btn text-danger" title="Delete">
                      <i class="fa-solid fa-trash"></i>
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

@endsection