@extends('admin.layouts.layout')
@section('content')

@php
  $isEdit = isset($staff) && $staff->exists;
  $hasWebLogin = old('has_web_login', $staff->has_web_login ?? 0);
@endphp

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
        border-radius: 0.5rem !important;
        border: 0 !important;
        box-shadow: none !important;
      }

      .field-picker-btn:hover,
      .field-picker-btn:focus {
        background-color: #45ab97;
        border-color: #45ab97;
        color: #ffffff;
        box-shadow: none;
      }

      .form-action-row {
        justify-content: flex-end;
      }

      .form-action-row .btn {
        min-width: 128px;
        min-height: 2.8rem;
        font-weight: 600;
      }

      .staff-image-preview {
        max-height: 160px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        display: block;
        margin-top: 0.75rem;
      }

      .invalid-feedback.d-block {
        font-size: 0.85rem;
      }

      .modal-header {
        background-color: #000000;
        color: #ffffff;
        border-bottom: 1px solid #000000;
      }

      .modal-header .btn-close {
        background-color: #ffffff;
        border-radius: 0.35rem;
        opacity: 1;
        filter: none;
        padding: 0.45rem;
      }

      #cityModal #saveCityBtn,
      #hospitalModal #saveHospitalBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #cityModal #saveCityBtn:hover,
      #cityModal #saveCityBtn:focus,
      #hospitalModal #saveHospitalBtn:hover,
      #hospitalModal #saveHospitalBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
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
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-id-card"></i> {{ $isEdit ? 'Edit ARV Staff' : 'Add ARV Staff' }}</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-arv-staff.index') }}">Manage ARV Staff</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ $isEdit ? route('manage-arv-staff.edit', $staff->id) : route('manage-arv-staff.create') }}">{{ $isEdit ? 'Edit ARV Staff' : 'Add ARV Staff' }}</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-arv-staff.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card" id="project-information-card">
                  <div class="card-header">
                    <h4 class="card-title">ARV Staff Information</h4>
                  </div>
                  <div class="card-body">
                    <form id="arvStaffForm" action="{{ $isEdit ? route('manage-arv-staff.update', $staff->id) : route('manage-arv-staff.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @if($isEdit)
                        @method('PUT')
                      @endif

                      <div class="row g-4">
                        <div class="col-md-6">
                          <label class="form-label" for="arvHospital">Hospital <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="arvHospital" name="hospital_id" class="form-select">
                              <option value="" disabled @selected(! old('hospital_id', $staff->hospital_id))>Select hospital</option>
                              @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" @selected(old('hospital_id', $staff->hospital_id) == $hospital->id)>{{ $hospital->name }}</option>
                              @endforeach
                            </select>
                            <button class="btn btn-outline-primary field-picker-btn" type="button" id="openHospitalModalBtn" data-bs-toggle="modal" data-bs-target="#hospitalModal">
                              <i class="fa-solid fa-plus"></i> Hospital
                            </button>
                          </div>
                          <div class="invalid-feedback d-block" id="hospital_id_error"></div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvCity">City <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="arvCity" name="city_id" class="form-select">
                              <option value="" disabled @selected(! old('city_id', $staff->city_id))>Select city</option>
                              @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(old('city_id', $staff->city_id) == $city->id)>{{ $city->city_name }}</option>
                              @endforeach
                            </select>
                            <button class="btn btn-outline-primary field-picker-btn" type="button" id="openCityModalBtn" data-bs-toggle="modal" data-bs-target="#cityModal">
                              <i class="fa-solid fa-plus"></i> City
                            </button>
                          </div>
                          <div class="invalid-feedback d-block" id="city_id_error"></div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvName">Name <span class="text-danger">*</span></label>
                          <input type="text" id="arvName" name="name" class="form-control" value="{{ old('name', $staff->name) }}" placeholder="Enter ARV staff name" />
                          <div class="invalid-feedback d-block" id="name_error"></div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvLoginId">ARV Login ID <span class="text-danger">*</span></label>
                          <input type="text" id="arvLoginId" name="login_id" class="form-control" value="{{ old('login_id', $staff->login_id) }}" placeholder="Enter ARV login ID" />
                          <div class="invalid-feedback d-block" id="login_id_error"></div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvLoginPass">ARV Login Pass{{ $isEdit ? '' : ' *' }}</label>
                          <input type="password" id="arvLoginPass" name="login_password" class="form-control" placeholder="{{ $isEdit ? 'Leave blank to keep current password' : 'Enter ARV login password' }}" />
                          <div class="invalid-feedback d-block" id="login_password_error"></div>
                        </div>

                        <div class="col-12">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="webLoginCheck" name="has_web_login" value="1" @checked($hasWebLogin) />
                            <label class="form-check-label fw-semibold" for="webLoginCheck">Web Login</label>
                          </div>
                        </div>

                        <div class="col-12 {{ $hasWebLogin ? '' : 'd-none' }}" id="webLoginFields">
                          <div class="row g-4">
                            <div class="col-md-6">
                              <label class="form-label" for="webEmail">Email <span class="text-danger">*</span></label>
                              <input type="email" id="webEmail" name="web_email" class="form-control" value="{{ old('web_email', $staff->web_email) }}" placeholder="Enter web login email" />
                              <div class="invalid-feedback d-block" id="web_email_error"></div>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label" for="webPass">Pass <span class="text-danger">*</span></label>
                              <input type="password" id="webPass" name="web_password" class="form-control" placeholder="{{ $isEdit ? 'Leave blank to keep current web password' : 'Enter web login password' }}" />
                              <div class="invalid-feedback d-block" id="web_password_error"></div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvImage">Image</label>
                          <input type="file" id="arvImage" name="image" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp" />
                          <div class="invalid-feedback d-block" id="image_error"></div>
                          @if($staff->image)
                            <img src="{{ asset($staff->image) }}" alt="{{ $staff->name }}" class="staff-image-preview" />
                          @endif
                        </div>
                      </div>

                      <div class="d-flex flex-wrap gap-2 mt-4 form-action-row">
                        <button type="submit" id="submitBtn" class="btn bg-black text-white">{{ $isEdit ? 'Update ARV Staff' : 'Add ARV Staff' }}</button>
                        <a href="{{ route('manage-arv-staff.index') }}" class="btn btn-label-secondary">Cancel</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    <!-- / Content -->

    <div class="modal fade" id="hospitalModal" tabindex="-1" aria-labelledby="hospitalModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="hospitalModalLabel">Add Hospital</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="hospitalModalForm" novalidate>
              <label for="hospitalNameInput" class="form-label">Hospital Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="hospitalNameInput" placeholder="Enter hospital name" required />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveHospitalBtn">Add Hospital</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="cityModalLabel">Add City</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="cityModalForm" novalidate>
              <label for="cityNameInput" class="form-label">City Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="cityNameInput" placeholder="Enter city name" required />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveCityBtn">Add City</button>
          </div>
        </div>
      </div>
    </div>

@push('scripts')
<script>
$(function () {
  function syncWebLoginFields() {
    var hasWebLogin = $('#webLoginCheck').is(':checked');
    $('#webLoginFields').toggleClass('d-none', !hasWebLogin);

    if (!hasWebLogin) {
      $('#webEmail').val('');
      $('#webPass').val('');
    }
  }

  $('#webLoginCheck').on('change', syncWebLoginFields);
  syncWebLoginFields();

  $('#arvStaffForm').on('submit', function (event) {
    event.preventDefault();

    $('.invalid-feedback').text('');
    $('#submitBtn').prop('disabled', true);

    var form = this;
    var formData = new FormData(form);

    if (!$('#webLoginCheck').is(':checked')) {
      formData.delete('has_web_login');
      formData.delete('web_email');
      formData.delete('web_password');
    }

    $.ajax({
      url: $(form).attr('action'),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        showToast('success', response.message);
        setTimeout(function () {
          window.location.href = response.redirect_url;
        }, 1500);
      },
      error: function (xhr) {
        $('#submitBtn').prop('disabled', false);

        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
          $.each(xhr.responseJSON.errors, function (key, value) {
            $('#' + key + '_error').text(value[0]);
          });
          return;
        }

        showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to save ARV staff.');
      },
      complete: function (xhr) {
        if (xhr.status !== 200) {
          $('#submitBtn').prop('disabled', false);
        }
      }
    });
  });
});
</script>
@endpush

@endsection