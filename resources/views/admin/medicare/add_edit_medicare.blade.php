@extends('admin.layouts.layout')
@section('content')

@php
  $isEdit = isset($medicare) && $medicare->exists;
@endphp

@push('styles')
    <style>
      .medicare-form-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      }

      .medicare-form-title {
        color: #111827;
        font-weight: 700;
      }

      .medicare-form-card .card-header {
        border-bottom: 1px solid #eef1f6;
        background: linear-gradient(135deg, #0f172a 0%, #1f2937 100%);
        border-top-left-radius: 0.9rem;
        border-top-right-radius: 0.9rem;
      }

      .medicare-form-card .card-header h4 {
        color: #ffffff;
        margin: 0;
      }

      .medicare-form-card .form-label {
        font-weight: 600;
        color: #374151;
      }

      .medicare-form-card .form-control {
        border-radius: 0.7rem;
        padding: 0.7rem 0.85rem;
      }

      .medicare-form-card .form-control:focus {
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
                  <h2 class="medicare-form-title mb-1">{{ $isEdit ? 'Edit Medicare' : 'Add Medicare' }}</h2>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('manage-medicare.index') }}">Manage Medicare</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $isEdit ? 'Edit Medicare' : 'Add Medicare' }}</li>
                    </ol>
                  </nav>
                </div>
                <a href="{{ route('manage-medicare.index') }}" class="btn btn-outline-secondary">
                  <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
              </div>

              <div class="card medicare-form-card">
                <div class="card-header py-3 px-4">
                  <h4>{{ $isEdit ? 'Update Medicare Details' : 'Create Medicare' }}</h4>
                </div>
                <div class="card-body p-4">
                  <form id="medicareForm" action="{{ $isEdit ? route('manage-medicare.update', $medicare->id) : route('manage-medicare.store') }}" method="POST">
                    @csrf
                    @if($isEdit)
                      @method('PUT')
                    @endif

                    <input type="hidden" id="medicareId" value="{{ $medicare->id ?? '' }}">

                    <div class="row g-4">
                      <div class="col-md-6">
                        <label for="medicareName" class="form-label">Medicare Name <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          class="form-control"
                          id="medicareName"
                          name="name"
                          value="{{ $medicare->name ?? '' }}"
                          placeholder="Enter medicare name"
                        >
                        <div class="invalid-feedback d-block" id="name_error"></div>
                      </div>

                      <div class="col-12 d-flex gap-2 pt-2">
                        <button type="submit" id="submitBtn" class="btn btn-dark-solid text-white">
                          {{ $isEdit ? 'Update Medicare' : 'Save Medicare' }}
                        </button>
                        <a href="{{ route('manage-medicare.index') }}" class="btn btn-outline-secondary">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

@push('scripts')
<script>
$(function () {
  $('#medicareForm').on('submit', function (event) {
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

        showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to save medicare.');
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