@extends('admin.layouts.layout')
@section('title', 'Add/Edit Staff')
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

      .staff-image-preview {
        max-height: 100px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        display: block;
      }

      .form-action-row {
        justify-content: flex-end;
      }

      .form-action-row .btn {
        min-width: 128px;
        min-height: 2.8rem;
        font-weight: 600;
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
      }
    </style>
@endpush

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card manage-project-head-card">
    <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <h2 class="page-title d-flex align-items-center gap-2">
          <i class="fa-solid fa-user-plus"></i> Master / Staff / Add New
        </h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('manage-staff-preview') }}">Manage Staff</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New</li>
          </ol>
        </nav>
      </div>
      <a href="{{ url('manage-staff-preview') }}" class="btn btn-back">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
    </div>

    <div class="card project-list-card" id="project-information-card">
      <div class="card-header">
        <h4 class="card-title">Staff Information</h4>
      </div>
      <div class="card-body">
        <form id="staffForm" action="javascript:void(0)" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label" for="city_id">City <span class="text-danger">*</span></label>
              <select id="city_id" name="city_id" class="form-select">
                <option value="" selected disabled>Select city</option>
                <option value="1">Ahmedabad</option>
                <option value="2">Surat</option>
                <option value="3">Vadodara</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="hospital_id">Hospital <span class="text-danger">*</span></label>
              <select id="hospital_id" name="hospital_id" class="form-select">
                <option value="" selected disabled>Select hospital</option>
                <option value="1">ABC Animal Care Hospital</option>
                <option value="2">City Veterinary Center</option>
                <option value="3">Rescue Support Hospital</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
              <select id="role" name="role" class="form-select">
                <option value="" selected disabled>Select role</option>
                <option value="doctor">Doctor</option>
                <option value="arv_staff">ARV Staff</option>
                <option value="catching_staff">Catching Staff</option>
                <option value="vehicle">Vehicle</option>
              </select>
            </div>

            <div class="col-md-6 d-none" id="vehicle_number_wrapper">
              <label class="form-label" for="vehicle_number">Vehicle Number</label>
              <input type="text" id="vehicle_number" name="vehicle_number" class="form-control" placeholder="Enter vehicle number">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Enter staff name">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="contact">Contact <span class="text-danger">*</span></label>
              <input type="text" id="contact" name="contact" class="form-control" placeholder="Enter contact number">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="login_pin">Login PIN <span class="text-danger">*</span></label>
              <input type="password" id="login_pin" name="login_pin" class="form-control" placeholder="Enter 4-digit PIN" maxlength="4">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="login_password">Login Password <span class="text-danger">*</span></label>
              <input type="password" id="login_password" name="login_password" class="form-control" placeholder="Enter login password">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="image">Image</label>
              <input type="file" id="image" name="image" class="form-control" accept="image/*">
              <img
                id="image_preview"
                class="staff-image-preview mt-2 rounded"
                width="100"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='14' fill='%23eef2f7'/%3E%3Cpath d='M50 50c9.941 0 18-8.059 18-18S59.941 14 50 14s-18 8.059-18 18 8.059 18 18 18Zm0 9c-15.464 0-28 8.507-28 19v5h56v-5c0-10.493-12.536-19-28-19Z' fill='%2392a1b4'/%3E%3C/svg%3E"
                alt="Preview"
              >
            </div>

            <div class="col-12">
              <label class="form-label" for="address">Address</label>
              <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter address"></textarea>
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-4 form-action-row">
            <button type="submit" class="btn bg-black text-white">Save Staff</button>
            <a href="{{ url('manage-staff-preview') }}" class="btn btn-label-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#role').on('change', function() {
        let isVehicle = $(this).val() === 'vehicle';
        $('#vehicle_number_wrapper').toggleClass('d-none', !isVehicle);
        if (!isVehicle) {
            $('#vehicle_number').val('');
        }
    });

    $('#image').on('change', function() {
        const file = this.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });

    $('#role').trigger('change');
});
</script>
@endpush

@endsection