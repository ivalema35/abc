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

      .dog-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .dog-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .dog-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .dog-top-bar .btn {
        min-width: 185px;
      }

      .dog-master-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .dog-master-head-card .dog-top-bar {
        border-bottom: 0;
      }

      .dog-master-head-card .dog-list-card {
        margin: 0 1rem 1rem;
      }

      .dog-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .dog-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .dog-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .dog-list-card .table td,
      .dog-list-card .table th {
        vertical-align: middle;
      }

      #process-dog-master-table {
        margin-bottom: 0;
      }

      #process-dog-master-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #000000;
        background-color: #ffffff;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #process-dog-master-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #process-dog-master-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #process-dog-master-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title{
        color: black;
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
        color: #ffffff;
      }
      .city-image {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 0.4rem;
        border: 1px solid #e5e7eb;
      }

      .action-icons a {
        font-size: 1.15rem;
      }

      .action-icons {
        white-space: nowrap;
      }

      .action-icon-btn {
        width: auto;
        height: auto;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0;
        background: transparent !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: none !important;
        transition: color 0.2s ease;
      }
      
      .action-icon-btn i {
        font-size: 25px;
        line-height: 1;
      }

      .action-icon-btn:hover {
        transform: none;
        box-shadow: none;
      }

      #process-dog-master-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #process-dog-master-table_wrapper .page-item.active .page-link:hover,
      #process-dog-master-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      @media (max-width: 767.98px) {
        .dog-top-bar {
          padding: 0.9rem 1rem;
        }

        .dog-top-bar .page-title {
          font-size: 1.3rem;
        }

        .dog-master-head-card .dog-list-card {
          margin: 0 0.75rem 0.75rem;
        }

      }
    </style>
@endpush  

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card dog-master-head-card">
                <div class="dog-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-receipt"></i> Process Dog List</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manage-catch-process') }}">Catch Process</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-process-dog-list') }}">Process Dog List</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-catch-process') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>
                <div class="card dog-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Process Dog List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="process-dog-master-table" class="table table-striped border-top">
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
            <!-- / Content -->

            <div id="operationModal" class="modal fade" tabindex="-1" aria-labelledby="operationModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header modal-header-black bg-dark text-white p-3">
                    <h5 class="modal-title text-white" id="operationModalLabel">Add Operation / Move to Observation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="operationForm" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="operation_catching_record_id" name="catching_record_id">
                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="operation_tag_no">Dog Tag No <span class="text-danger">*</span></label>
                          <input type="text" id="operation_tag_no" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="operation_date">Operation Date <span class="text-danger">*</span></label>
                          <input type="date" id="operation_date" name="operation_date" class="form-control" value="{{ now()->toDateString() }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="doctor_id">Doctor Name <span class="text-danger">*</span></label>
                          <select id="doctor_id" name="doctor_id" class="form-select">
                            <option value="" selected>Select doctor</option>
                            @foreach(($doctors ?? []) as $doctor)
                              <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="body_weight">Body Weight</label>
                          <input type="number" step="0.01" id="body_weight" name="body_weight" class="form-control" placeholder="Enter body weight">
                        </div>
                        <div class="col-12">
                          <label class="form-label" for="remarks">Remarks</label>
                          <textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Enter operation remarks"></textarea>
                        </div>
                      </div>

                      <div class="d-flex align-items-center justify-content-between mt-4 mb-2">
                        <h6 class="mb-0">Medicines</h6>
                        <button type="button" class="btn btn-sm btn-dark" id="addMedicineRowBtn">+ Add Medicine</button>
                      </div>

                      <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="medicineRowsTable">
                          <thead>
                            <tr>
                              <th>Medicine</th>
                              <th>Qty</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="medicineRowsBody"></tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-dark" id="operationSubmitBtn">Save & Move</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
@endsection          

@push('scripts')
<script>
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var medicineIndex = 0;
  var medicineOptionsHtml = `
    <option value="" selected>Select medicine</option>
    @foreach(($medicines ?? []) as $medicine)
      <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
    @endforeach
  `;

  function clearOperationValidationErrors() {
    $('#operationForm .is-invalid').removeClass('is-invalid');
    $('#operationForm .invalid-feedback.dynamic-validation').remove();
  }

  function renderOperationValidationErrors(errors) {
    clearOperationValidationErrors();
    $.each(errors || {}, function (key, messages) {
      var fieldSelector = '[name="' + key + '"]';
      if (key.match(/^medicines\./)) {
        var parts = key.split('.');
        var normalized = parts[0] + '[' + parts[1] + '][' + parts[2] + ']';
        fieldSelector = '[name="' + normalized + '"]';
      }

      var $field = $('#operationForm').find(fieldSelector).first();
      if (!$field.length) {
        return;
      }

      $field.addClass('is-invalid');
      $field.after('<div class="invalid-feedback dynamic-validation">' + messages[0] + '</div>');
    });
  }

  function addMedicineRow() {
    var rowHtml = '' +
      '<tr>' +
        '<td>' +
          '<select class="form-select" name="medicines[' + medicineIndex + '][medicine_id]">' + medicineOptionsHtml + '</select>' +
        '</td>' +
        '<td>' +
          '<input type="number" min="1" class="form-control" name="medicines[' + medicineIndex + '][qty]" placeholder="Qty">' +
        '</td>' +
        '<td>' +
          '<button type="button" class="btn btn-sm btn-outline-danger remove-medicine-row">Remove</button>' +
        '</td>' +
      '</tr>';

    $('#medicineRowsBody').append(rowHtml);
    medicineIndex++;
  }

  function resetOperationForm() {
    $('#operationForm')[0].reset();
    $('#operation_catching_record_id').val('');
    $('#operation_tag_no').val('');
    $('#operation_date').val('{{ now()->toDateString() }}');
    $('#medicineRowsBody').empty();
    medicineIndex = 0;
    addMedicineRow();
    clearOperationValidationErrors();
  }

  $('#addMedicineRowBtn').on('click', function () {
    addMedicineRow();
  });

  $(document).on('click', '.remove-medicine-row', function () {
    $(this).closest('tr').remove();
  });

  $(document).on('click', '.action-accept', function () {
    var recordId = $(this).data('record-id');
    var tagNo = $(this).data('tag-no');

    resetOperationForm();
    $('#operation_catching_record_id').val(recordId || '');
    $('#operation_tag_no').val(tagNo || '');
  });

  $('#operationForm').on('submit', function (e) {
    e.preventDefault();
    clearOperationValidationErrors();

    var submitBtn = $('#operationSubmitBtn');
    var originalText = submitBtn.text();
    var formData = new FormData(this);

    submitBtn.text('Saving...').prop('disabled', true);

    $.ajax({
      url: "{{ route('dog-operations.store') }}",
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        submitBtn.text(originalText).prop('disabled', false);
        $('#operationModal').modal('hide');
        resetOperationForm();

        if (typeof showToast === 'function') {
          showToast('success', response.message || 'Operation saved successfully.');
        }
      },
      error: function (xhr) {
        submitBtn.text(originalText).prop('disabled', false);
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          renderOperationValidationErrors(xhr.responseJSON.errors);
        }

        if (typeof showToast === 'function') {
          showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Please fix highlighted fields.');
        }
      }
    });
  });

  $('#operationModal').on('hidden.bs.modal', function () {
    resetOperationForm();
  });

  addMedicineRow();

  // DataTables Initialization for Process Dog List
  var processDogTable = $('#process-dog-master-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-process-dog-list') }}",
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
    ],
    order: [[7, 'desc']],
    retrieve: true
  });
});
</script>
@endpush