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

      .city-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .city-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .city-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .city-top-bar .btn {
        min-width: 185px;
      }

      .manage-city-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-city-head-card .city-top-bar {
        border-bottom: 0;
      }

      .manage-city-head-card .city-list-card {
        margin: 0 1rem 1rem;
      }

      .city-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .city-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .city-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .city-list-card .table td,
      .city-list-card .table th {
        vertical-align: middle;
      }

      #manage-permission-table {
        margin-bottom: 0;
      }

      #manage-permission-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-permission-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-permission-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #manage-permission-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title {
        color: black;
      }
      .addbtn {
        background-color: black;
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

      /* .action-icon-btn.action-edit {
        background: linear-gradient(180deg, #f7aa2b 0%, #ea8a05 100%);
        box-shadow: 0 8px 18px rgba(234, 138, 5, 0.3);
      } */

      .action-icon-btn i {
        font-size: 25px;
        line-height: 1;
      }

      .action-icon-btn:hover {
        transform: none;
        box-shadow: none;
      }

      .status-badge {
        font-size: 0.78rem;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
      }

      .permissions-box {
        border: 1px solid #e5e7eb;
        border-radius: 0.65rem;
        padding: 1rem;
        background-color: #fafbfc;
      }

      .permission-module {
        border: 1px solid #e9edf3;
        border-radius: 0.5rem;
        padding: 0.8rem;
        background-color: #ffffff;
      }

      .permission-module + .permission-module {
        margin-top: 0.65rem;
      }

      .permission-module-title {
        font-weight: 600;
        color: #374151;
      }

      #manage-permission-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #manage-permission-table_wrapper .page-item.active .page-link:hover,
      #manage-permission-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      .modal-header-black {
        background-color: #000000;
        color: #ffffff;
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
        .city-top-bar {
          padding: 0.9rem 1rem;
        }

        .city-top-bar .page-title {
          font-size: 1.3rem;
        }

        .manage-city-head-card .city-list-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
    
    @endpush
    
             <!--Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-city-head-card">
                <div
                  class="city-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3"
                >
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2">
                      <i class="fa-solid fa-key"></i> Permission
                    </h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                          <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">Role &amp; Permission</li>
                        <li class="breadcrumb-item active" aria-current="page">
                          <a href="{{ route('permissions.index') }}">Permission</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                  <button
                    type="button"
                    id="add-permission-btn"
                    class="addbtn btn btn-dark"
                    data-bs-toggle="modal"
                    data-bs-target="#permissionModal"
                  >
                    <i class="fa-solid fa-plus me-1"></i> Add Permission
                  </button>
                </div>
                <div class="card city-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Permission List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="manage-permission-table"
                        class="table table-striped border-top"
                      >
                        <thead>
                          <tr>
                            <th>Sr No</th>
                            <th>Permission Name</th>
                            <th>Used In Pages</th>
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

            <div
              class="modal fade"
              id="permissionModal"
              tabindex="-1"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-lg modal-dialog">
                <div class="modal-content">
                  <div class="modal-header modal-header-black p-3">
                    <h5
                      class="modal-title text-white"
                      id="permissionModalTitle"
                    >
                      Add Permission
                    </h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <form id="addPermissionForm">
                    <div class="modal-body">
                      <input type="hidden" name="id" id="permission_id" />
                      <input type="hidden" name="_method" id="permission_method" value="POST" />
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="permissionName" class="form-label">Permission Name</label>
                          <input
                            type="text"
                            class="form-control"
                            id="permissionName"
                            name="name"
                            placeholder="e.g. user-view"
                            required
                          />
                        </div>
                        <div class="col-md-6">
                          <label for="permissionModule" class="form-label">Module</label>
                          <input
                            type="text"
                            class="form-control"
                            id="permissionModule"
                            name="module"
                            placeholder="e.g. user"
                            required
                          />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-label-secondary"
                        data-bs-dismiss="modal"
                      >
                        Cancel
                      </button>
                      <button type="submit" class="btn btn-dark">
                        Save Permission
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

@push('scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

  var permissionModalEl = document.getElementById('permissionModal');
  var permissionModal = bootstrap.Modal.getOrCreateInstance(permissionModalEl);
  var permissionBaseUrl = "{{ url('/permissions') }}";

  // DataTable — server-side via same index route (AJAX detection)
  var table = $('#manage-permission-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('permissions.index') }}",
      type: 'GET'
    },
    columns: [
      { data: 0, orderable: false, searchable: false },
      { data: 1 },
      { data: 2 },
      { data: 3, orderable: false, searchable: false }
    ],
    order: [[1, 'asc']],
    pageLength: 10
  });

  function resetPermissionForm() {
    $('#addPermissionForm')[0].reset();
    $('#permission_id').val('');
    $('#permission_method').val('POST');
    $('#permissionModalTitle').text('Add Permission');
  }

  $('#add-permission-btn').on('click', function () {
    resetPermissionForm();
  });

  $(document).on('click', '.js-edit-permission', function () {
    $('#permission_id').val($(this).data('permission-id'));
    $('#permission_method').val('PUT');
    $('#permissionName').val($(this).data('permission-name'));
    $('#permissionModule').val($(this).data('permission-module'));
    $('#permissionModalTitle').text('Edit Permission');
    permissionModal.show();
  });

  $(document).on('click', '.js-delete-permission', function () {
    var permissionId = $(this).data('permission-id');

    if (!confirm('Delete this permission?')) {
      return;
    }

    $.ajax({
      url: permissionBaseUrl + '/' + permissionId,
      method: 'DELETE',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (res) {
        if (res.success) {
          table.ajax.reload(null, false);
        }
      },
      error: function (xhr) {
        alert(xhr.responseJSON?.message || 'An error occurred. Please try again.');
      }
    });
  });

  $('#addPermissionForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        var $btn  = $form.find('[type="submit"]').prop('disabled', true);
    var permissionId = $('#permission_id').val();
    var formData = new FormData(this);
    var url = permissionId ? permissionBaseUrl + '/' + permissionId : "{{ route('permissions.store') }}";

        $.ajax({
      url: url,
            method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
            success: function (res) {
                if (res.success) {
          permissionModal.hide();
          resetPermissionForm();
          table.ajax.reload(null, false);
                }
            },
            error: function (xhr) {
                var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
                var messages = [];
                $.each(errors, function (field, msgs) { messages = messages.concat(msgs); });
                alert(messages.join('\n') || 'An error occurred. Please try again.');
            },
            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });

        permissionModalEl.addEventListener('hidden.bs.modal', function () {
          resetPermissionForm();
        });
});
</script>
@endpush

@endsection