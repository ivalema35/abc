@extends('admin.layouts.layout')
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
        margin-bottom: 1rem;
      }

      .manage-project-head-card .project-list-card {
        margin: 0 1rem 1rem;
      }

      .page-title {
        color: #000000;
        font-size: 26px;
        margin-bottom: 0.2rem;
      }

      .page-subtitle {
        font-size: 20px;
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

      .project-list-card {
        background-color: #ffffff;
        border: 2px solid #1e1e22;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .project-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .project-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff;
      }

      .project-list-card .card-body {
        padding: 1.85rem 1.5rem 1.6rem;
      }

      /* Profile view styles */
      .staff-profile {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
      }

      .staff-profile-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem;
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        background: #f9fbff;
      }

      .staff-avatar-lg {
        width: 100px;
        height: 100px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid #d9e2ef;
        flex-shrink: 0;
      }

      .staff-name {
        margin: 0;
        font-size: 1.35rem;
        color: #1f2937;
        font-weight: 700;
      }

      .staff-subtext {
        margin: 0.3rem 0 0;
        color: #64748b;
        font-size: 0.95rem;
      }

      .staff-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
      }

      .staff-info-item {
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        padding: 0.9rem 1rem;
        background: #ffffff;
      }

      .staff-info-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.35rem;
      }

      .staff-info-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 600;
        word-break: break-word;
      }

      .card-body {
        padding-top: 27px !important;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .staff-profile-header {
          flex-direction: column;
          align-items: flex-start;
        }

        .staff-info-grid {
          grid-template-columns: 1fr;
        }

        .page-title {
          font-size: 1.55rem;
        }

        .page-subtitle {
          font-size: 1rem;
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
                <div
                  class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2">
                      <i class="fa-solid fa-person-running"></i> View Catching Staff
                    </h2>
                     <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-catching-staff.index') }}">Manage Catching Staff</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('view-catching-staff') }}">View Catching Staff</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-catching-staff.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Catching Staff Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="staff-profile">
                      <!-- Profile header with photo -->
                      <div class="staff-profile-header">
                        <img src="../../assets/img/avatars/6.png" alt="Ramesh Sharma" class="staff-avatar-lg" />
                        <div>
                          <h5 class="staff-name">Ramesh Sharma</h5>
                          <p class="staff-subtext">Catching Staff &mdash; City Civil Hospital</p>
                        </div>
                      </div>

                      <!-- Info grid -->
                      <div class="staff-info-grid">
                        <div class="staff-info-item">
                          <span class="staff-info-label">Hospital</span>
                          <div class="staff-info-value">City Civil Hospital</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Full Name</span>
                          <div class="staff-info-value">Ramesh Sharma</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Contact</span>
                          <div class="staff-info-value">+91 98765 43210</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Email ID</span>
                          <div class="staff-info-value">ramesh.sharma@abs.org</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Address</span>
                          <div class="staff-info-value">42, Varachha Road, Near Udhna Darwaja, Surat - 395006</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">City</span>
                          <div class="staff-info-value">Surat</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

 @endsection          