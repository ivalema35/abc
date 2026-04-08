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

      .profile-top-bar {
        padding: 12px 1.5rem;
      }

      .profile-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .profile-head-card .profile-card {
        margin: 0 1rem 1rem;
      }

      .page-title {
        color: #000000;
        font-size: 26px;
        margin-bottom: 0.2rem;
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
      }

      .profile-card {
        background-color: #ffffff;
        border: 2px solid #1e1e22;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .profile-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .profile-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff;
      }

      .profile-card .card-body {
        padding: 1.85rem 1.5rem 1.6rem;
      }

      .staff-profile {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
      }

      .staff-profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        background: #f9fbff;
      }

      .staff-avatar-lg {
        width: 92px;
        height: 92px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid #d9e2ef;
      }

      .staff-avatar-empty {
        width: 92px;
        height: 92px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #d9e2ef;
        background: #eef2f7;
        color: #64748b;
        font-weight: 700;
      }

      .staff-name {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 700;
      }

      .staff-subtext {
        margin: 0.25rem 0 0;
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

      @media (max-width: 767.98px) {
        .profile-top-bar {
          padding: 0.9rem 1rem;
        }

        .page-title {
          font-size: 1.55rem;
        }

        .profile-head-card .profile-card {
          margin: 0 0.75rem 0.75rem;
        }

        .staff-profile-header,
        .staff-info-grid {
          grid-template-columns: 1fr;
          flex-direction: column;
          align-items: flex-start;
        }
      }
    </style>
@endpush

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card profile-head-card">
                <div class="profile-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-id-card"></i> View Catching Staff</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-catching-staff.index') }}">Manage Catching Staff</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-catching-staff.show', $staff->id) }}">View Catching Staff</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-catching-staff.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card profile-card">
                  <div class="card-header">
                    <h4 class="card-title">Catching Staff Profile</h4>
                  </div>
                  <div class="card-body">
                    <div class="staff-profile">
                      <div class="staff-profile-header">
                        @if($staff->image)
                          <img src="{{ asset($staff->image) }}" alt="{{ $staff->name }}" class="staff-avatar-lg" />
                        @else
                          <div class="staff-avatar-empty">{{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                        @endif

                        <div>
                          <h3 class="staff-name">{{ $staff->name }}</h3>
                          <p class="staff-subtext">{{ $staff->hospital->name ?? 'No hospital assigned' }}</p>
                          <span class="badge {{ $staff->is_active ? 'bg-success' : 'bg-danger' }}">{{ $staff->is_active ? 'Active' : 'Inactive' }}</span>
                        </div>
                      </div>

                      <div class="staff-info-grid">
                        <div class="staff-info-item">
                          <span class="staff-info-label">Hospital</span>
                          <div class="staff-info-value">{{ $staff->hospital->name ?? '-' }}</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">City</span>
                          <div class="staff-info-value">{{ $staff->city->city_name ?? '-' }}</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Contact</span>
                          <div class="staff-info-value">{{ $staff->contact }}</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Email</span>
                          <div class="staff-info-value">{{ $staff->email ?? '-' }}</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Address</span>
                          <div class="staff-info-value">{{ $staff->address ?: '-' }}</div>
                        </div>
                        <div class="staff-info-item">
                          <span class="staff-info-label">Created On</span>
                          <div class="staff-info-value">{{ $staff->created_at->format('d M Y h:i A') }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection