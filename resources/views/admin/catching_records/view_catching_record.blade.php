@extends('admin.layouts.layout')
@section('title', 'View Dog Catcher')
@section('content')

@php
  $mapLat = $record->latitude ?: 23.0225;
  $mapLng = $record->longitude ?: 72.5714;
  $imageUrl = $record->image ? url($record->image) : null;
@endphp

@push('styles')
<style>
  .view-head-card {
    background: #ffffff;
    border: 1px solid #dfe3eb;
    border-radius: 0.9rem;
    box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
    margin-bottom: 1rem;
  }

  .view-top-bar {
    padding: 12px 1.5rem;
    border-bottom: 1px solid #e9edf3;
  }

  .page-title {
    color: #000000;
    font-size: 26px;
    margin-bottom: 0.2rem;
  }

  .profile-card {
    margin: 1rem;
    background: #ffffff;
    border: 2px solid #000000;
    border-radius: 0.9rem;
    box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
    overflow: hidden;
  }

  .profile-card .card-header {
    background-color: #0f0f13 !important;
    color: #ffffff !important;
    border-bottom: 0;
    padding: 1rem 1.25rem;
  }

  .profile-card .card-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #ffffff !important;
  }

  .profile-card .card-body {
    padding: 1.5rem;
  }

  .dog-preview {
    width: 100%;
    max-width: 280px;
    height: 220px;
    object-fit: cover;
    border-radius: 0.6rem;
    border: 1px solid #e5e7eb;
    background: #f8fafc;
  }

  .meta-label {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 0.2rem;
  }

  .meta-value {
    font-size: 1.05rem;
    font-weight: 600;
    color: #111827;
  }

  #catching-record-map {
    width: 100%;
    height: 280px;
    border: 1px solid #d9dee3;
    border-radius: 8px;
  }
</style>
@endpush

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card view-head-card">
    <div class="view-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-eye"></i> View Dog Catcher</h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catching-records.index') }}">Dog Catcher List</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Dog Catcher</li>
          </ol>
        </nav>
      </div>
      <a href="{{ route('catching-records.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back
      </a>
    </div>

    <div class="card profile-card">
      <div class="card-header">
        <h4 class="card-title">Catcher Profile</h4>
      </div>
      <div class="card-body">
        <form id="viewUpdateForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="project_id" value="{{ $record->project_id }}">
          <input type="hidden" name="hospital_id" value="{{ $record->hospital_id }}">
          <input type="hidden" name="catching_staff_id" value="{{ $record->catching_staff_id }}">
          <input type="hidden" name="catch_date" value="{{ $record->catch_date ? \Illuminate\Support\Carbon::parse($record->catch_date)->format('Y-m-d') : '' }}">
          <input type="hidden" name="dog_type" value="{{ $record->dog_type }}">
          <input type="hidden" name="latitude" value="{{ $record->latitude }}">
          <input type="hidden" name="longitude" value="{{ $record->longitude }}">

        <div class="row g-3 align-items-start mb-3">
          <div class="col-md-6">
            <label class="form-label">Dog Image</label>
            @if($imageUrl)
              <img src="{{ $imageUrl }}" alt="Dog Image" class="dog-preview">
            @else
              <div class="dog-preview d-flex align-items-center justify-content-center text-muted">No image available</div>
            @endif
          </div>
          <div class="col-md-6">
            <div class="meta-label">Tag No.</div>
            <div class="meta-value">{{ $record->tag_no ?: '-' }}</div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender">
              <option value="" @selected(empty($record->gender))>Select gender</option>
              <option value="male" @selected($record->gender === 'male')>Male</option>
              <option value="female" @selected($record->gender === 'female')>Female</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Street</label>
            <input type="text" class="form-control" name="street" value="{{ $record->street }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Owner</label>
            <input type="text" class="form-control" name="owner_name" value="{{ $record->owner_name }}">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label" for="view_upload_image">Upload Dog Image (Optional)</label>
            <input type="file" id="view_upload_image" name="image" class="form-control" accept="image/*">
          </div>
          <div class="col-md-6">
            <label class="form-label" for="view_vehicle_id">Vehicle</label>
            <select id="view_vehicle_id" class="form-select" name="vehicle_id">
              <option value="">Select vehicle</option>
              @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" @selected($record->vehicle_id == $vehicle->id)>{{ $vehicle->vehicle_number }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label" for="view_address_1">Address 1</label>
            <textarea id="view_address_1" class="form-control" name="address" rows="3">{{ $record->address ?: '' }}</textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="view_address_2">Address 2</label>
            <textarea id="view_address_2" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Map Location</label>
          <iframe
            id="catching-record-map"
            src="https://maps.google.com/maps?q={{ $mapLat }},{{ $mapLng }}&z=15&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-warning" id="updateBtn">
            <i class="bx bx-edit me-1"></i> Update
          </button>
          <button type="button" class="btn btn-success" id="releaseBtn">
            <i class="bx bx-share me-1"></i> Release
          </button>
        </div>
        </form>
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

  $('#updateBtn').on('click', function (e) {
    e.preventDefault();

    var formData = new FormData(document.getElementById('viewUpdateForm'));
    formData.append('_method', 'PUT');

    $.ajax({
      url: "{{ url('catching-records/' . $record->id) }}",
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Record Updated',
          text: response.message || 'Catching record updated successfully.'
        });
      },
      error: function (xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Update Failed',
          text: (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to update record.'
        });
      }
    });
  });

  $('#releaseBtn').on('click', function () {
    Swal.fire({
      title: 'Are you sure you want to release this dog directly?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Release',
      cancelButtonText: 'Cancel'
    }).then(function (result) {
      if (!result.isConfirmed) {
        return;
      }

      $.ajax({
        url: "{{ route('catching-records.quick-release', $record->id) }}",
        type: 'POST',
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Released',
            text: response.message || 'Dog released successfully.'
          }).then(function () {
            window.location.href = "{{ route('catching-records.index') }}";
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Release Failed',
            text: (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to release dog.'
          });
        }
      });
    });
  });
});
</script>
@endpush

@endsection
