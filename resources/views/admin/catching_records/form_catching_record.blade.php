@extends('admin.layouts.layout')
@section('title', isset($record) ? 'Edit Catching Record' : 'Add Catching Record')
@section('content')

@php
  $isEdit = isset($record);
  $recordCityId = $record->project->city_id ?? $record->hospital->city_id ?? $record->catchingStaff->city_id ?? null;
@endphp

@push('styles')
  <style>
    .form-head-card {
      background-color: #ffffff;
      border: 1px solid #dfe3eb;
      border-radius: 0.9rem;
      box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      margin-bottom: 1rem;
    }

    .top-bar {
      padding: 12px 1.5rem;
      border-bottom: 1px solid #e9edf3;
    }

    .page-title {
      color: #000000;
      font-size: 26px;
      margin-bottom: 0.2rem;
    }

    .form-card {
      margin: 1rem;
      background-color: #ffffff;
      border: 2px solid #000000;
      border-radius: 0.9rem;
      box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      overflow: hidden;
    }

    .form-card .card-header {
      background-color: #0f0f13 !important;
      color: #ffffff !important;
      border-bottom: 0;
      padding: 1rem 1.25rem;
    }

    .form-card .card-title {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 600;
      color: #ffffff !important;
    }

    .form-card .card-body {
      padding: 1.5rem;
    }

    .image-preview {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 0.5rem;
      border: 1px solid #e5e7eb;
      display: none;
      margin-top: 0.5rem;
    }

  </style>
@endpush

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card form-head-card">
    <div class="top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <h2 class="page-title d-flex align-items-center gap-2">
          <i class="fa-solid fa-dog"></i>
          {{ $isEdit ? 'Edit Catching Record' : 'Add Catching Record' }}
        </h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catching-records.index') }}">Catching Records List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add/Edit Catching Record</li>
          </ol>
        </nav>
      </div>
      <a href="{{ route('catching-records.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
    </div>

    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Add/Edit Catching Record</h4>
      </div>
      <div class="card-body">
        <form id="catchingRecordForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="catchingRecordId" name="id" value="{{ $record->id ?? '' }}">
          <input type="hidden" name="latitude" id="latitude" value="">
          <input type="hidden" name="longitude" id="longitude" value="">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="city_filter_id">City <span class="text-danger">*</span></label>
              <select id="city_filter_id" class="form-select">
                <option value="">Select city</option>
                @foreach($cities as $city)
                  <option value="{{ $city->id }}" @selected($recordCityId == $city->id)>{{ $city->city_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="project_id">Project <span class="text-danger">*</span></label>
              <select id="project_id" name="project_id" class="form-select" disabled>
                <option value="">Select project</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="hospital_id">Hospital <span class="text-danger">*</span></label>
              <select id="hospital_id" name="hospital_id" class="form-select" disabled>
                <option value="">Select hospital</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="catching_staff_id">Catching Staff <span class="text-danger">*</span></label>
              <select id="catching_staff_id" name="catching_staff_id" class="form-select" disabled>
                <option value="">Select staff</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
              <select id="vehicle_id" name="vehicle_id" class="form-select">
                <option value="" disabled {{ isset($record) ? '' : 'selected' }}>Select vehicle</option>
                @foreach($vehicles as $vehicle)
                  <option value="{{ $vehicle->id }}" @selected(($record->vehicle_id ?? null) == $vehicle->id)>{{ $vehicle->vehicle_number }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="catch_date">Catch Date <span class="text-danger">*</span></label>
              <input type="date" id="catch_date" name="catch_date" class="form-control" value="{{ old('catch_date', isset($record) && $record->catch_date ? \Illuminate\Support\Carbon::parse($record->catch_date)->format('Y-m-d') : '') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="tag_no">Tag No</label>
              <input type="text" id="tag_no" name="tag_no" class="form-control" placeholder="Enter tag number" value="{{ old('tag_no', $record->tag_no ?? '') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="dog_type">Dog Type <span class="text-danger">*</span></label>
              <select id="dog_type" name="dog_type" class="form-select">
                <option value="stray" @selected(old('dog_type', $record->dog_type ?? 'stray') === 'stray')>Stray</option>
                <option value="pet" @selected(old('dog_type', $record->dog_type ?? 'stray') === 'pet')>Pet</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="gender">Gender</label>
              <select id="gender" name="gender" class="form-select">
                <option value="" @selected(empty(old('gender', $record->gender ?? ''))) >Select gender</option>
                <option value="male" @selected(old('gender', $record->gender ?? '') === 'male')>Male</option>
                <option value="female" @selected(old('gender', $record->gender ?? '') === 'female')>Female</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="street">Street</label>
              <input type="text" id="street" name="street" class="form-control" placeholder="Enter street name" value="{{ old('street', $record->street ?? '') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="owner_name">Owner</label>
              <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Enter owner name" value="{{ old('owner_name', $record->owner_name ?? '') }}">
            </div>

            <div class="col-md-12">
              <label class="form-label" for="address">Address</label>
              <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter address">{{ old('address', $record->address ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="image">Image</label>
              <input type="file" id="image" name="image" class="form-control" accept="image/*">
              <img id="catchingRecordImagePreview" class="image-preview" alt="Preview">
            </div>

            <div class="col-md-6">
              <label class="form-label">Map View</label>
              <div id="catching-map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #d9dee3; z-index: 1;"></div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
              <a href="{{ route('catching-records.index') }}" class="btn btn-label-secondary">Cancel</a>
              <button type="submit" class="btn btn-dark" id="catchingRecordSubmitBtn">{{ $isEdit ? 'Update Record' : 'Save Record' }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
<script>
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var isEdit = {{ $isEdit ? 'true' : 'false' }};
  var recordId = $('#catchingRecordId').val();
  var initialRecord = {
    city_id: @json($recordCityId),
    project_id: @json($record->project_id ?? null),
    hospital_id: @json($record->hospital_id ?? null),
    catching_staff_id: @json($record->catching_staff_id ?? null),
    image: @json(isset($record) ? ($record->image ? url($record->image) : null) : null),
    latitude: @json($record->latitude ?? null),
    longitude: @json($record->longitude ?? null)
  };

  var defaultLat = 23.0225;
  var defaultLng = 72.5714;
  var map;
  var marker;

  function updateCoordinateInputs(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
  }

  function placeMarker(position) {
    if (marker) {
      marker.setMap(null);
    }

    marker = new google.maps.Marker({
      position: position,
      map: map,
      draggable: true
    });

    updateCoordinateInputs(position.lat, position.lng);

    google.maps.event.addListener(marker, 'dragend', function (event) {
      updateCoordinateInputs(event.latLng.lat(), event.latLng.lng());
    });
  }

  function initGoogleMap() {
    if (typeof google === 'undefined' || !google.maps) {
      showToast('error', 'Google Maps failed to load. Please verify API key configuration.');
      return;
    }

    var hasSavedCoordinates = initialRecord.latitude !== null && initialRecord.longitude !== null &&
      !Number.isNaN(parseFloat(initialRecord.latitude)) && !Number.isNaN(parseFloat(initialRecord.longitude));

    var startPosition = hasSavedCoordinates
      ? { lat: parseFloat(initialRecord.latitude), lng: parseFloat(initialRecord.longitude) }
      : { lat: defaultLat, lng: defaultLng };

    map = new google.maps.Map(document.getElementById('catching-map'), {
      center: startPosition,
      zoom: 13,
      mapTypeControl: false,
      streetViewControl: false
    });

    if (hasSavedCoordinates) {
      placeMarker(startPosition);
      return;
    }

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var currentPosition = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          map.setCenter(currentPosition);
          map.setZoom(13);
          placeMarker(currentPosition);
        },
        function () {
          placeMarker(startPosition);
        }
      );
    } else {
      placeMarker(startPosition);
    }
  }

  initGoogleMap();

  function resetDependentSelect($select, placeholder, shouldDisable) {
    $select.empty().append('<option value="">' + placeholder + '</option>');
    $select.prop('disabled', !!shouldDisable);
  }

  function populateSelect($select, items, placeholder, textKey) {
    resetDependentSelect($select, placeholder, false);
    $.each(items || [], function (_, item) {
      $select.append('<option value="' + item.id + '">' + item[textKey] + '</option>');
    });
  }

  function clearValidationErrors() {
    $('#catchingRecordForm .is-invalid').removeClass('is-invalid');
    $('#catchingRecordForm .invalid-feedback.dynamic-validation').remove();
  }

  function renderValidationErrors(errors) {
    clearValidationErrors();

    $.each(errors || {}, function (field, messages) {
      var $field = $('#catchingRecordForm').find('[name="' + field + '"]');
      if (!$field.length) {
        return;
      }

      $field.addClass('is-invalid');
      $field.after('<div class="invalid-feedback dynamic-validation">' + messages[0] + '</div>');
    });
  }

  $('#city_filter_id').on('change', function () {
    var cityId = $(this).val();

    resetDependentSelect($('#project_id'), 'Select project', true);
    resetDependentSelect($('#hospital_id'), 'Select hospital', true);
    resetDependentSelect($('#catching_staff_id'), 'Select staff', true);

    if (!cityId) {
      return;
    }

    $.ajax({
      url: "{{ route('catching-records.city-masters') }}",
      method: 'GET',
      data: { city_id: cityId },
      success: function (response) {
        populateSelect($('#project_id'), response.projects || [], 'Select project', 'name');
        populateSelect($('#hospital_id'), response.hospitals || [], 'Select hospital', 'name');

        if (initialRecord.project_id) {
          $('#project_id').val(String(initialRecord.project_id));
          $('#project_id').trigger('change');
        }

        if (initialRecord.hospital_id) {
          $('#hospital_id').val(String(initialRecord.hospital_id));
        }
      },
      error: function () {
        showToast('error', 'Unable to load projects and hospitals for selected city.');
      }
    });
  });

  $('#project_id').on('change', function () {
    var projectId = $(this).val();

    resetDependentSelect($('#catching_staff_id'), 'Select staff', true);

    if (!projectId) {
      return;
    }

    $.ajax({
      url: "{{ route('catching-records.project-staff') }}",
      method: 'GET',
      data: { project_id: projectId },
      success: function (response) {
        populateSelect($('#catching_staff_id'), response.staff || [], 'Select staff', 'name');

        if (initialRecord.catching_staff_id) {
          $('#catching_staff_id').val(String(initialRecord.catching_staff_id));
          initialRecord.catching_staff_id = null;
        }
      },
      error: function () {
        showToast('error', 'Unable to load staff for selected project.');
      }
    });
  });

  $('#image').on('change', function () {
    var file = this.files[0];

    if (!file) {
      return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
      $('#catchingRecordImagePreview').attr('src', e.target.result).show();
    };
    reader.readAsDataURL(file);
  });

  $('#catchingRecordForm').on('submit', function (e) {
    e.preventDefault();
    clearValidationErrors();

    var url = isEdit ? "{{ url('catching-records') }}/" + recordId : "{{ route('catching-records.store') }}";
    var formData = new FormData(this);
    var submitBtn = $('#catchingRecordSubmitBtn');
    var originalText = submitBtn.text();

    submitBtn.text('Saving...').prop('disabled', true);

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
        submitBtn.text(originalText).prop('disabled', false);
        showToast('success', response.message || 'Record saved successfully.');
        window.location.href = "{{ route('catching-records.index') }}";
      },
      error: function (xhr) {
        submitBtn.text(originalText).prop('disabled', false);
        var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : null;

        if (errors) {
          renderValidationErrors(errors);
        }

        showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Please fix the highlighted fields.');
      }
    });
  });

  if (initialRecord.image) {
    $('#catchingRecordImagePreview').attr('src', initialRecord.image).show();
  }

  if (initialRecord.city_id) {
    $('#city_filter_id').val(String(initialRecord.city_id)).trigger('change');
  }
});
</script>
@endpush

@endsection
