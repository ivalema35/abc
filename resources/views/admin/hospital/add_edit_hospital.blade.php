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

      .hospital-image-preview {
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
                      <i class="fa-solid {{ $hospital->exists ? 'fa-pen-to-square' : 'fa-hospital' }}"></i>
                      {{ $hospital->exists ? 'Edit Hospital' : 'Add Hospital' }}
                    </h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-hospital.index') }}">Manage Hospital</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                          <a href="{{ $hospital->exists ? route('manage-hospital.edit', $hospital->id) : route('manage-hospital.create') }}">{{ $hospital->exists ? 'Edit Hospital' : 'Add Hospital' }}</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-hospital.index') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card" id="project-information-card">
                  <div class="card-header">
                    <h4 class="card-title">Hospital Information</h4>
                  </div>
                  <div class="card-body">
                    <form id="hospitalForm" method="POST" enctype="multipart/form-data">
                      @csrf
                      @if($hospital->exists)
                        @method('PUT')
                        <input type="hidden" name="id" id="hospitalId" value="{{ $hospital->id }}">
                      @else
                        <input type="hidden" name="id" id="hospitalId" value="">
                      @endif
                      <div class="row g-4">
                        <div class="col-md-6">
                          <label class="form-label" for="hospitalName">Name <span class="text-danger">*</span></label>
                          <input type="text" id="hospitalName" name="name" class="form-control" value="{{ old('name', $hospital->name) }}" placeholder="Enter hospital name" />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="hospitalContact">Contact <span class="text-danger">*</span></label>
                          <input type="tel" id="hospitalContact" name="contact" class="form-control" value="{{ old('contact', $hospital->contact) }}" placeholder="Enter contact number" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="hospitalLoginPin">Login PIN <span class="text-danger">*</span></label>
                          <input type="text" id="hospitalLoginPin" name="login_pin" class="form-control" value="{{ old('login_pin', $hospital->login_pin) }}" placeholder="Enter 4-digit login PIN" maxlength="4" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="hospitalEmail">Email</label>
                          <input type="email" id="hospitalEmail" name="email" class="form-control" value="{{ old('email', $hospital->email) }}" placeholder="Enter email address" />
                        </div>

                        <div class="col-md-12">
                          <label class="form-label" for="hospitalAddress">Address</label>
                          <textarea id="hospitalAddress" name="address" class="form-control" rows="3" placeholder="Enter hospital address">{{ old('address', $hospital->address) }}</textarea>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="rfidStart">RFID Tag Number Start</label>
                          <input type="text" id="rfidStart" name="rfid_start" class="form-control" value="{{ old('rfid_start', $hospital->rfid_start) }}" placeholder="Enter start tag" />
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="rfidEnd">RFID Tag Number End</label>
                          <input type="text" id="rfidEnd" name="rfid_end" class="form-control" value="{{ old('rfid_end', $hospital->rfid_end) }}" placeholder="Enter end tag" />
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="netQuantity">Catching Net Quantity <span class="text-danger">*</span></label>
                          <input type="number" id="netQuantity" name="net_quantity" class="form-control" value="{{ old('net_quantity', $hospital->net_quantity ?? 0) }}" min="0" placeholder="Enter net quantity" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="hospitalCity">City <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="hospitalCity" name="city_id" class="form-select">
                              <option value="" disabled @selected(! old('city_id', $hospital->city_id))>Select city</option>
                              @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(old('city_id', $hospital->city_id) == $city->id)>{{ $city->city_name }}</option>
                              @endforeach
                            </select>
                            <button class="btn btn-outline-primary field-picker-btn" type="button" id="openCityModalBtn" data-bs-toggle="modal" data-bs-target="#cityModal">
                              <i class="fa-solid fa-plus"></i> City
                            </button>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="hospitalImage">Hospital Image</label>
                          <input type="file" name="image" id="hospitalImage" class="form-control" accept="image/*">
                          <img id="hospitalImagePreview" class="hospital-image-preview" src="" alt="Preview" style="display:none;">
                        </div>
                      </div>

                      <div class="d-flex flex-wrap gap-2 mt-4 form-action-row">
                        <button type="submit" class="btn bg-black text-white">{{ $hospital->exists ? 'Update Hospital' : 'Add Hospital' }}</button>
                        <a href="{{ route('manage-hospital.index') }}" class="btn btn-label-secondary">Cancel</a>
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

  var existingImage = "{{ $hospital->exists ? ($hospital->image ?? '') : '' }}";
  if (existingImage) {
    $('#hospitalImagePreview').attr('src', "{{ url('/') }}/" + existingImage).show();
  }

  $('#hospitalImage').on('change', function () {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#hospitalImagePreview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(file);
    } else if (existingImage) {
      $('#hospitalImagePreview').attr('src', "{{ url('/') }}/" + existingImage).show();
    } else {
      $('#hospitalImagePreview').attr('src', '').hide();
    }
  });

  $('#hospitalForm').on('submit', function (e) {
    e.preventDefault();

    var hospitalId = $('#hospitalId').val();
    var isEdit = hospitalId !== '';
    var url = isEdit ? "{{ url('manage-hospital') }}/" + hospitalId : "{{ route('manage-hospital.store') }}";
    var formData = new FormData(this);

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

        $('#hospitalForm')[0].reset();
        $('#hospitalId').val('');
        $('#hospitalImagePreview').attr('src', '').hide();
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
          $('#hospitalCity').append(option).val(response.city.id);
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