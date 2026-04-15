@extends('admin.layouts.layout')
@section('title', 'Manage Catching Records')
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

    .project-top-bar .breadcrumb .breadcrumb-item,
    .project-top-bar .breadcrumb .breadcrumb-item a {
      color: #6b7280;
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

    .btn-back,
    .addbtn {
      min-width: 140px;
      font-size: 1rem;
      font-weight: 600;
    }

    .addbtn {
      background-color: #000000;
      border-color: #000000;
      color: #ffffff;
    }

    .addbtn:hover,
    .addbtn:focus {
      background-color: #111827;
      border-color: #111827;
      color: #ffffff;
    }

    .project-list-card {
      background-color: #ffffff !important;
      border: 2px solid #000000;
      border-radius: 0.9rem;
      box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      overflow: hidden;
    }

    .project-list-card .card-header {
      background-color: #0f0f13 !important;
      color: #ffffff !important;
      border-bottom: 0;
      padding: 1rem 1.25rem;
    }

    .project-list-card .card-title {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 600;
      color: #ffffff !important;
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

    #catching-records-table {
      margin-bottom: 0;
    }

    #catching-records-table thead th {
      font-size: 0.84rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      color: #4b5563;
      white-space: nowrap;
      border-bottom-width: 1px;
      background-color: #f3f4f6;
    }

    #catching-records-table tbody td {
      font-size: 0.95rem;
      color: #4b5563;
      padding-top: 0.95rem;
      padding-bottom: 0.95rem;
      vertical-align: middle;
    }

    #catching-records-table tbody tr:hover {
      background-color: #f7f9fc;
    }

    .project-image {
      width: 48px;
      height: 48px;
      object-fit: cover;
      border-radius: 0.5rem;
      border: 1px solid #e5e7eb;
    }

    .action-icons {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      white-space: nowrap;
    }

    .action-icon-btn {
      width: 2rem;
      height: 2rem;
      padding: 0 !important;
      border-radius: 0.45rem;
      border: 1px solid rgba(0, 0, 0, 0.08) !important;
      background: #fff !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: none !important;
      transition: all 0.2s ease;
    }

    .action-icon-btn i {
      font-size: 1.15rem;
      line-height: 1;
    }

    #catching-records-table td:last-child {
      white-space: nowrap;
    }

    .modal-header-black {
      background-color: #000000;
      color: #ffffff;
    }

    #catchingRecordModal .modal-content {
      border-radius: 0.9rem;
      border: 1px solid #dfe3eb;
      box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.12);
      overflow: hidden;
    }

    #catchingRecordModal .modal-body {
      padding: 1.5rem;
    }

    #catchingRecordModal .form-label {
      font-weight: 600;
      color: #3f4a59;
    }

    #catchingRecordModal .form-control,
    #catchingRecordModal .form-select {
      min-height: 2.8rem;
      font-size: 0.98rem;
    }

    #catchingRecordModal .modal-footer .btn {
      min-width: 128px;
      min-height: 2.8rem;
      font-weight: 600;
    }

    .modal-header-black .btn-close {
      background-color: #e8e7e7 !important;
      border: 0 !important;
      box-shadow: none !important;
      margin-left: auto;
      opacity: 1 !important;
      filter: none !important;
    }

    @media (max-width: 767.98px) {
      .project-top-bar {
        padding: 0.9rem 1rem;
      }

      .page-title {
        font-size: 1.3rem;
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
          <i class="fa-solid fa-dog"></i> Dog Catching Records
        </h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dog Catching Records</li>
          </ol>
        </nav>
      </div>
      @can('add catching record')
        <button type="button" class="addbtn btn btn-dark" data-bs-toggle="modal" data-bs-target="#catchingRecordModal" id="addCatchingRecordBtn">
          <i class="fa-solid fa-plus me-1"></i> Add Record
        </button>
      @endcan
    </div>

    <div class="card project-list-card">
      <div class="card-header bg-dark text-white border-bottom-0">
        <h4 class="card-title">Catching Records List</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="catching-records-table" class="table table-striped border-top">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tag No</th>
                <th>Project</th>
                <th>Dog Type</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Image</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="catchingRecordModal" tabindex="-1" aria-labelledby="catchingRecordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header modal-header-black bg-dark text-white p-3">
        <h5 class="modal-title text-white" id="catchingRecordModalLabel">Add Catching Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="catchingRecordForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="catchingRecordId" name="id" value="">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="city_filter_id">City <span class="text-danger">*</span></label>
              <select id="city_filter_id" class="form-select">
                <option value="" selected>Select city</option>
                @foreach($cities as $city)
                  <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="project_id">Project <span class="text-danger">*</span></label>
              <select id="project_id" name="project_id" class="form-select" disabled>
                <option value="" selected>Select project</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="hospital_id">Hospital <span class="text-danger">*</span></label>
              <select id="hospital_id" name="hospital_id" class="form-select" disabled>
                <option value="" selected>Select hospital</option>
                @foreach($hospitals as $hospital)
                  <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="catching_staff_id">Catching Staff <span class="text-danger">*</span></label>
              <select id="catching_staff_id" name="catching_staff_id" class="form-select" disabled>
                <option value="" selected>Select staff</option>
                @foreach($staff as $person)
                  <option value="{{ $person->id }}">{{ $person->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
              <select id="vehicle_id" name="vehicle_id" class="form-select">
                <option value="" selected disabled>Select vehicle</option>
                @foreach($vehicles as $vehicle)
                  <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_number }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="catch_date">Catch Date <span class="text-danger">*</span></label>
              <input type="date" id="catch_date" name="catch_date" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="tag_no">Tag No</label>
              <input type="text" id="tag_no" name="tag_no" class="form-control" placeholder="Enter tag number">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="dog_type">Dog Type <span class="text-danger">*</span></label>
              <select id="dog_type" name="dog_type" class="form-select">
                <option value="stray">Stray</option>
                <option value="pet">Pet</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="gender">Gender</label>
              <select id="gender" name="gender" class="form-select">
                <option value="" selected>Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="street">Street</label>
              <input type="text" id="street" name="street" class="form-control" placeholder="Enter street name">
            </div>

            <div class="col-md-6">
              <label class="form-label" for="owner_name">Owner</label>
              <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Enter owner name">
            </div>

            <div class="col-12">
              <label class="form-label" for="address">Address</label>
              <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter address"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="image">Image</label>
              <input type="file" id="image" name="image" class="form-control" accept="image/*">
              <img id="catchingRecordImagePreview" class="mt-2 rounded" width="100" alt="Preview" style="display:none;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-dark" id="catchingRecordSubmitBtn">Save Record</button>
        </div>
      </form>
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

  var table = $('#catching-records-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('catching-records.index') }}",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'tag_no', name: 'tag_no' },
      { data: 'project_name', name: 'project.name' },
      { data: 'dog_type', name: 'dog_type' },
      { data: 'gender', name: 'gender', orderable: false, searchable: false },
      { data: 'address', name: 'address', orderable: false, searchable: false },
      { data: 'image', name: 'image', orderable: false, searchable: false },
      { data: 'catch_date', name: 'catch_date' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
  });

  function resetModal() {
    $('#catchingRecordForm')[0].reset();
    $('#catchingRecordId').val('');
    $('#catchingRecordModalLabel').text('Add Catching Record');
    $('#catchingRecordSubmitBtn').text('Save Record');
    $('#catchingRecordImagePreview').attr('src', '').hide();
    clearValidationErrors();
    resetDependentSelect($('#project_id'), 'Select project', true);
    resetDependentSelect($('#hospital_id'), 'Select hospital', true);
    resetDependentSelect($('#catching_staff_id'), 'Select staff', true);
  }

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
      },
      error: function () {
        showToast('error', 'Unable to load staff for selected project.');
      }
    });
  });

  $('#addCatchingRecordBtn').on('click', function () {
    resetModal();
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

    var recordId = $('#catchingRecordId').val();
    var isEdit = recordId !== '';
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
        showToast('success', response.message);
        $('#catchingRecordModal').modal('hide');
        resetModal();
        table.ajax.reload(null, false);
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

  $(document).on('click', '.item-edit', function () {
    var recordId = $(this).data('id');

    $.ajax({
      url: "{{ url('catching-records') }}/" + recordId + '/edit',
      method: 'GET',
      success: function (response) {
        if (response && response.data) {
          var record = response.data;

          $('#catchingRecordId').val(record.id);
          $('#city_filter_id').val('');
          $('#project_id').val(record.project_id);
          $('#hospital_id').val(record.hospital_id);
          $('#catching_staff_id').val(record.catching_staff_id);
          $('#vehicle_id').val(record.vehicle_id);
          $('#project_id, #hospital_id, #catching_staff_id').prop('disabled', false);
          $('#catch_date').val(record.catch_date ? String(record.catch_date).substring(0, 10) : '');
          $('#tag_no').val(record.tag_no);
          $('#dog_type').val(record.dog_type);
          $('#gender').val(record.gender);
          $('#street').val(record.street);
          $('#owner_name').val(record.owner_name);
          $('#address').val(record.address);
          $('#catchingRecordModalLabel').text('Edit Catching Record');
          $('#catchingRecordSubmitBtn').text('Update Record');

          if (record.image) {
            $('#catchingRecordImagePreview').attr('src', "{{ url('/') }}/" + record.image).show();
          } else {
            $('#catchingRecordImagePreview').attr('src', '').hide();
          }

          $('#catchingRecordModal').modal('show');
        }
      },
      error: function () {
        showToast('error', 'Unable to load catching record details.');
      }
    });
  });

  $(document).on('click', '.item-delete', function () {
    var recordId = $(this).data('id');

    confirmDelete(function () {
      $.ajax({
        url: "{{ url('catching-records') }}/" + recordId,
        method: 'POST',
        data: { _method: 'DELETE' },
        success: function (response) {
          showToast('success', response.message);
          table.ajax.reload(null, false);
        },
        error: function (xhr) {
          showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to delete catching record.');
        }
      });
    });
  });

  $('#catchingRecordModal').on('hidden.bs.modal', function () {
    resetModal();
  });
});
</script>
@endpush

@endsection