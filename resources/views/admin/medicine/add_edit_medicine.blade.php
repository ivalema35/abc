@extends('admin.layouts.layout')
@section('content')

@php
  $isEdit = isset($medicine) && $medicine->exists;
@endphp

@push('styles')
    <style>
      .medicine-form-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      }

      .medicine-form-title {
        color: #111827;
        font-weight: 700;
      }

      .medicine-form-card .card-header {
        border-bottom: 1px solid #eef1f6;
        background: linear-gradient(135deg, #0f172a 0%, #1f2937 100%);
        border-top-left-radius: 0.9rem;
        border-top-right-radius: 0.9rem;
      }

      .medicine-form-card .card-header h4 {
        color: #ffffff;
        margin: 0;
      }

      .medicine-form-card .form-label {
        font-weight: 600;
        color: #374151;
      }

      .medicine-form-card .form-control,
      .medicine-form-card .form-select {
        border-radius: 0.7rem;
        padding: 0.7rem 0.85rem;
      }

      .medicine-form-card .form-control:focus,
      .medicine-form-card .form-select:focus {
        border-color: #111827;
        box-shadow: 0 0 0 0.2rem rgba(17, 24, 39, 0.12);
      }

      .btn-dark-solid {
        background-color: #111827;
        border-color: #111827;
      }

      .btn-dark-solid:hover,
      .btn-dark-solid:focus {
        background-color: #000000;
        border-color: #000000;
      }

      .invalid-feedback.d-block {
        font-size: 0.85rem;
      }
    </style>
@endpush

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                  <h2 class="medicine-form-title mb-1">{{ $isEdit ? 'Edit Medicine' : 'Add Medicine' }}</h2>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('manage-medicine.index') }}">Manage Medicine</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $isEdit ? 'Edit Medicine' : 'Add Medicine' }}</li>
                    </ol>
                  </nav>
                </div>
                <a href="{{ route('manage-medicine.index') }}" class="btn btn-outline-secondary">
                  <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
              </div>

              <div class="card medicine-form-card">
                <div class="card-header py-3 px-4">
                  <h4>{{ $isEdit ? 'Update Medicine Details' : 'Create Medicine' }}</h4>
                </div>
                <div class="card-body p-4">
                  <form id="medicineForm" action="{{ $isEdit ? route('manage-medicine.update', $medicine->id) : route('manage-medicine.store') }}" method="POST">
                    @csrf
                    @if($isEdit)
                      @method('PUT')
                    @endif

                    <input type="hidden" id="medicineId" value="{{ $medicine->id ?? '' }}">

                    <div class="row g-4">
                      <div class="col-md-6">
                        <label for="name" class="form-label">Medicine Name <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name="name"
                          value="{{ $medicine->name ?? '' }}"
                          placeholder="Enter medicine name"
                        >
                        <div class="invalid-feedback d-block" id="name_error"></div>
                      </div>

                      <div class="col-md-3">
                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          class="form-control"
                          id="unit"
                          name="unit"
                          value="{{ $medicine->unit ?? '' }}"
                          placeholder="e.g. Tablet"
                        >
                        <div class="invalid-feedback d-block" id="unit_error"></div>
                      </div>

                      <div class="col-md-3">
                        <label for="dose" class="form-label">Dose <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          class="form-control"
                          id="dose"
                          name="dose"
                          value="{{ $medicine->dose ?? '' }}"
                          placeholder="e.g. 500mg"
                        >
                        <div class="invalid-feedback d-block" id="dose_error"></div>
                      </div>

                      <div class="col-12 d-flex gap-2 pt-2">
                        <button type="submit" id="submitBtn" class="btn btn-dark-solid text-white">
                          {{ $isEdit ? 'Update Medicine' : 'Save Medicine' }}
                        </button>
                        <a href="{{ route('manage-medicine.index') }}" class="btn btn-outline-secondary">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

@push('scripts')
<script>
$(function () {
  $('#medicineForm').on('submit', function (event) {
    event.preventDefault();

    $('.invalid-feedback').text('');
    $('#submitBtn').prop('disabled', true);

    var form = this;
    var formData = new FormData(form);

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

        showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to save medicine.');
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