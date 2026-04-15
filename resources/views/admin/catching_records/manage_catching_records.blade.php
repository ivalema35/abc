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
        <a href="{{ route('catching-records.create') }}" class="addbtn btn btn-dark">
          <i class="fa-solid fa-plus me-1"></i> Add Record
        </a>
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

@push('scripts')
<script>
$(function () {
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
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          var viewButton = '<button type="button" class="btn action-icon-btn text-info me-2 item-view" data-id="' + row.id + '" title="View"><i class="bx bx-show"></i></button>';
          return '<div class="d-inline-block action-icons">' + viewButton + (data || '') + '</div>';
        }
      }
    ]
  });

  $(document).on('click', '.item-view', function () {
    var recordId = $(this).data('id');
    window.location.href = '/catching-records/' + recordId;
  });

  $(document).on('click', '.item-edit', function () {
    var recordId = $(this).data('id');
    window.location.href = '/catching-records/' + recordId + '/edit';
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

});
</script>
@endpush

@endsection