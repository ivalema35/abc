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

      .hospital-profile {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
      }

      .hospital-profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        background: #f9fbff;
      }

      .hospital-avatar-lg {
        width: 92px;
        height: 92px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid #d9e2ef;
      }

      .hospital-avatar-empty {
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

      .hospital-name {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 700;
      }

      .hospital-subtext {
        margin: 0.25rem 0 0;
        color: #64748b;
        font-size: 0.95rem;
      }

      .hospital-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
      }

      .hospital-info-item {
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        padding: 0.9rem 1rem;
        background: #ffffff;
      }

      .hospital-info-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.35rem;
      }

      .hospital-info-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 600;
        word-break: break-word;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .page-title {
          font-size: 1.55rem;
        }

        .manage-project-head-card .project-list-card {
          margin: 0 0.75rem 0.75rem;
        }

        .hospital-profile-header {
          flex-direction: column;
          align-items: flex-start;
        }

        .hospital-info-grid {
          grid-template-columns: 1fr;
        }
      }
    </style>
@endpush

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-project-head-card">
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-hospital"></i> View Hospital</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-hospital.index') }}">Manage Hospital</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('view-hospital', $hospital->id) }}">View Hospital</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-hospital.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Hospital Details</h4>
                  </div>
                  <div class="card-body">
                    <div class="hospital-profile">
                      <div class="hospital-profile-header">
                        @if($hospital->image)
                          <img src="{{ asset($hospital->image) }}" alt="{{ $hospital->name }}" class="hospital-avatar-lg">
                        @else
                          <div class="hospital-avatar-empty">NA</div>
                        @endif
                        <div>
                          <h3 class="hospital-name">{{ $hospital->name }}</h3>
                          <p class="hospital-subtext">{{ $hospital->city->city_name ?? 'No city assigned' }}</p>
                          <span class="badge {{ $hospital->is_active ? 'bg-success' : 'bg-danger' }} mt-2">{{ $hospital->is_active ? 'Active' : 'Inactive' }}</span>
                        </div>
                      </div>

                      <div class="hospital-info-grid">
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Contact</span>
                          <span class="hospital-info-value">{{ $hospital->contact }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Email</span>
                          <span class="hospital-info-value">{{ $hospital->email ?? '-' }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Login PIN</span>
                          <span class="hospital-info-value">{{ $hospital->login_pin }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Net Quantity</span>
                          <span class="hospital-info-value">{{ $hospital->net_quantity }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">RFID Tag Number Start</span>
                          <span class="hospital-info-value">{{ $hospital->rfid_start ?? '-' }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">RFID Tag Number End</span>
                          <span class="hospital-info-value">{{ $hospital->rfid_end ?? '-' }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Address</span>
                          <span class="hospital-info-value">{{ $hospital->address ?? '-' }}</span>
                        </div>
                        <div class="hospital-info-item">
                          <span class="hospital-info-label">Created At</span>
                          <span class="hospital-info-value">{{ $hospital->created_at->format('d M Y h:i A') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection