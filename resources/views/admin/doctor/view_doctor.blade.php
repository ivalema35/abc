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

      .doctor-profile {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
      }

      .doctor-profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        background: #f9fbff;
      }

      .doctor-avatar-lg {
        width: 92px;
        height: 92px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid #d9e2ef;
      }

      .doctor-avatar-empty {
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

      .doctor-name {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 700;
      }

      .doctor-subtext {
        margin: 0.25rem 0 0;
        color: #64748b;
        font-size: 0.95rem;
      }

      .doctor-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
      }

      .doctor-info-item {
        border: 1px solid #e8edf5;
        border-radius: 0.75rem;
        padding: 0.9rem 1rem;
        background: #ffffff;
      }

      .doctor-info-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.35rem;
      }

      .doctor-info-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 600;
        word-break: break-word;
      }

      .form-subheading {
        color: #5d6778;
        font-size: 1.55rem;
        font-weight: 600;
        margin-bottom: 1.2rem;
      }

      .form-subheading i {
        color: #232323;
      }

      .project-list-card .form-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #3f4a59;
      }

      .project-list-card .form-control,
      .project-list-card .form-select {
        min-height: 3.1rem;
        font-size: 1.05rem;
      }

      .project-list-card .input-group .btn {
        min-width: 5.8rem;
      }

      .project-list-card .input-group {
        display: flex;
        flex-wrap: nowrap;
        overflow: hidden;
        border-radius: 0.5rem;
        border: 1px solid #d8dde8;
        background-color: #ffffff;
      }

      .project-list-card .input-group.project-field-group {
        gap: 0.45rem;
        border: 0;
        background-color: transparent;
        overflow: visible;
      }

      .project-list-card .input-group.project-field-group > .form-select {
        border: 1px solid #d8dde8;
        border-radius: 0.5rem;
      }

      .project-list-card .input-group > .form-select {
        flex: 1 1 auto;
        border: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 1px solid #d8dde8;
        margin-right: 0 !important;
        box-shadow: none;
      }

      .project-list-card .input-group > .form-select:focus {
        box-shadow: none;
      }

      .field-picker-btn {
        min-width: 5.6rem !important;
        padding: 0.4rem 0.8rem;
        font-size: 0.95rem;
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border: 0 !important;
        margin-left: 0 !important;
        box-shadow: none !important;
      }

      .project-list-card .input-group.project-field-group .field-picker-btn {
        min-height: 3.1rem;
        border-radius: 0.5rem !important;
      }

      .field-picker-btn:hover,
      .field-picker-btn:focus {
        background-color: #45ab97;
        border-color: #45ab97;
        color: #ffffff;
        box-shadow: none;
      }

      .btn-select-all {
        min-height: 3.1rem;
        min-width: 9rem;
        width: auto !important;
        padding-left: 1.1rem;
        padding-right: 1.1rem;
        font-weight: 600;
      }

      .project-select-all-col {
        display: flex;
        align-items: flex-end;
      }

      .form-action-row {
        justify-content: flex-end;
      }

      .form-action-row .btn {
        min-width: 128px;
        min-height: 2.8rem;
        font-weight: 600;
      }

      .project-list-card form {
        padding-bottom: 0.35rem;
      }
      
      .modal-header {
        background-color: #000000;
        color: #ffffff;
        border-bottom: 1px solid #000000;
      }

      .modal-title {
        color: #ffffff;
      }

    .modal-header .btn-close {
        background-color: #ffffff;
        border-radius: 0.35rem;
        opacity: 1;
        filter: none;
        padding: 0.45rem;
      }

       .modal-header .btn-close:hover,
       .modal-header .btn-close:focus {
        background-color: #f2f2f2;
        box-shadow: none;
      }

      #ngoModal #saveNgoBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #ngoModal #saveNgoBtn:hover,
      #ngoModal #saveNgoBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #cityModal #saveCityBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #cityModal #saveCityBtn:hover,
      #cityModal #saveCityBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #hospitalModal #saveHospitalBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #hospitalModal #saveHospitalBtn:hover,
      #hospitalModal #saveHospitalBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #vehicleModal #saveVehicleBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #vehicleModal #saveVehicleBtn:hover,
      #vehicleModal #saveVehicleBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      .card-body{
        padding-top:27px !important;
      }
      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .ngo-profile-header {
          flex-direction: column;
          align-items: flex-start;
        }

        .ngo-info-grid {
          grid-template-columns: 1fr;
        }

        .project-select-all-col {
          align-items: stretch;
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
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-eye"></i> View Doctor</h2>
                     <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-doctor.index') }}">Manage Doctor</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-doctor.show', $doctor->id) }}">View Doctor</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-doctor.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Doctor Information</h4>
                  </div>
                    <div class="doctor-profile">
                      <div class="doctor-profile-header">
                        @if($doctor->image)
                          <img src="{{ asset($doctor->image) }}" alt="{{ $doctor->name }}" class="doctor-avatar-lg" />
                        @else
                          <div class="doctor-avatar-empty">NA</div>
                        @endif
                        <img src="#" alt="Dr. Mehul Patel" class="ngo-avatar-lg" />
                          <h5 class="doctor-name">{{ $doctor->name }}</h5>
                          <p class="doctor-subtext">{{ $doctor->hospital->name ?? 'No hospital assigned' }}</p>
                          <span class="badge {{ $doctor->is_active ? 'bg-success' : 'bg-danger' }} mt-2">{{ $doctor->is_active ? 'Active' : 'Inactive' }}</span>
                          <p class="ngo-subtext">General Physician</p>
                        </div>
                      </div>
                      <div class="doctor-info-grid">
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Name</span>
                          <div class="doctor-info-value">{{ $doctor->name }}</div>
                          <div class="ngo-info-value">City Civil Hospital</div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Contact</span>
                          <div class="doctor-info-value">{{ $doctor->contact }}</div>
                          <div class="ngo-info-value">Dr. Mehul Patel</div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Email</span>
                          <div class="doctor-info-value">{{ $doctor->email ?? '-' }}</div>
                          <div class="ngo-info-value">+91 98765 43210</div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Address</span>
                          <div class="doctor-info-value">{{ $doctor->address ?? '-' }}</div>
                          <div class="ngo-info-value">mehul.patel@citycivil.org</div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Hospital</span>
                          <div class="doctor-info-value">{{ $doctor->hospital->name ?? '-' }}</div>
                        </div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">City</span>
                          <div class="doctor-info-value">{{ $doctor->city->city_name ?? '-' }}</div>
                        </div>
                        <div class="doctor-info-item">
                          <span class="doctor-info-label">Created At</span>
                          <div class="doctor-info-value">{{ $doctor->created_at->format('d M Y h:i A') }}</div>
                          <div class="ngo-info-value">Surat</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection