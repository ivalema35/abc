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

      .ngo-image-preview {
        max-height: 160px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        display: block;
        margin-top: 0.5rem;
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
                      <i class="fa-solid {{ $ngo->exists ? 'fa-pen-to-square' : 'fa-hand-holding-heart' }}"></i>
                      {{ $ngo->exists ? 'Edit NGO' : 'Add NGO' }}
                    </h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-ngo') }}">Manage NGO</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                          <a href="{{ $ngo->exists ? route('manage-ngo.edit', $ngo->id) : route('add-ngo') }}">{{ $ngo->exists ? 'Edit NGO' : 'Add NGO' }}</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-ngo') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card" id="project-information-card">
                  <div class="card-header">
                    <h4 class="card-title">NGO Information</h4>
                  </div>
                  <div class="card-body">
                    <form id="ngoForm">
                      <input type="hidden" id="ngoId" name="id" value="{{ $ngo->id }}" />
                      <div class="row g-4">
                        <div class="col-md-6">
                          <label class="form-label" for="ngoName">Name <span class="text-danger">*</span></label>
                          <input type="text" id="ngoName" name="name" class="form-control" value="{{ old('name', $ngo->name) }}" placeholder="Enter NGO name" />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="ngoContact">Contact <span class="text-danger">*</span></label>
                          <input type="tel" id="ngoContact" name="contact" class="form-control" value="{{ old('contact', $ngo->contact) }}" placeholder="Enter contact number" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="ngoEmail">Email </label>
                          <input type="email" id="ngoEmail" name="email" class="form-control" value="{{ old('email', $ngo->email) }}" placeholder="Enter email address" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="ngoCity">City </label>
                          <div class="input-group project-field-group">
                            <select id="ngoCity" name="city_id" class="form-select">
                              <option value="" disabled @selected(! old('city_id', $ngo->city_id))>Select city</option>
                              @foreach($cities as $city)
                                  <option value="{{ $city->id }}" @selected(old('city_id', $ngo->city_id) == $city->id)>{{ $city->city_name }}</option>
                              @endforeach
                            </select>
                            <button class="btn btn-outline-primary field-picker-btn" type="button" id="openCityModalBtn" data-bs-toggle="modal" data-bs-target="#cityModal">
                              <i class="fa-solid fa-plus"></i> City
                            </button>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="ngoAddress">Address </label>
                          <textarea id="ngoAddress" name="address" class="form-control" rows="3" placeholder="Enter NGO address">{{ old('address', $ngo->address) }}</textarea>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="ngoImage">Image</label>
                          <input type="file" class="form-control" id="ngoImage" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" />
                          <img id="ngoImagePreview" class="ngo-image-preview" src="" alt="Preview" style="display:none;" />
                        </div>
                      </div>

                      <div class="d-flex flex-wrap gap-2 mt-4 form-action-row">
                        <button type="submit" class="btn bg-black text-white">{{ $ngo->exists ? 'Update NGO' : 'Add NGO' }}</button>
                        <a href="{{ route('manage-ngo') }}" class="btn btn-label-secondary">Cancel</a>
                      </div>
                    </form>
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
              <input type="text" class="form-control" id="cityNameInput" name="city_name" placeholder="Enter city name" required />
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Show existing image on edit page load
  var existingImage = "{{ $ngo->exists ? ($ngo->image ?? '') : '' }}";
  if (existingImage) {
    $('#ngoImagePreview').attr('src', "{{ url('/') }}/" + existingImage).show();
  }

  $('#ngoImage').on('change', function () {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#ngoImagePreview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(file);
    } else {
      $('#ngoImagePreview').attr('src', '').hide();
    }
  });

  $('#ngoForm').on('submit', function (e) {
    e.preventDefault();

    var ngoId = $('#ngoId').val();
    var isEdit = ngoId !== '';
    var url = isEdit ? "{{ url('manage-ngo') }}/" + ngoId : "{{ route('add-ngo.store') }}";
    var formData = new FormData(this);

    if (isEdit) {
      formData.append('_method', 'PUT');
    }

    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        showToast('success', response.message);

        if (response.redirect_url) {
          setTimeout(function () {
            window.location.href = response.redirect_url;
          }, 1500);
          return;
        }

        $('#ngoForm')[0].reset();
        $('#ngoId').val('');
        $('#ngoImagePreview').attr('src', '').hide();
      },
      error: function (xhr) {
        var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
        var messages = [];

        $.each(errors, function (key, value) {
          messages = messages.concat(value);
        });

        showToast('error', messages.join('\n') || (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.');
      }
    });
  });

  function submitCityModal() {
    $.ajax({
      url: "{{ route('manage-city.store') }}",
      method: 'POST',
      data: $('#cityModalForm').serialize(),
      success: function (response) {
        if (response.success && response.city) {
          var option = new Option(response.city.city_name, response.city.id, true, true);
          $('#ngoCity').append(option).val(response.city.id);
          $('#cityModal').modal('hide');
          $('#cityModalForm')[0].reset();
        }

        showToast('success', response.message);
      },
      error: function (xhr) {
        var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
        var messages = [];

        $.each(errors, function (key, value) {
          messages = messages.concat(value);
        });

        showToast('error', messages.join('\n') || 'Unable to add city.');
      }
    });
  }

  $('#cityModalForm').on('submit', function (e) {
    e.preventDefault();
    submitCityModal();
  });

  $('#saveCityBtn').on('click', function () {
    submitCityModal();
  });

  $('#cityModal').on('hidden.bs.modal', function () {
    $('#cityModalForm')[0].reset();
  });
});
</script>
@endpush

@endsection