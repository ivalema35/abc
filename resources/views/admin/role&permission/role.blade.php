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

      #manage-role-table {
        margin-bottom: 0;
      }

      #manage-role-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-role-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-role-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #manage-role-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title{
        color: black;
      }
      .addbtn{
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

      #manage-role-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #manage-role-table_wrapper .page-item.active .page-link:hover,
      #manage-role-table_wrapper .page-item.active .page-link:focus {
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
 

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-city-head-card">
                <div class="city-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-user-shield"></i> Role</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Role &amp; Permission</li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('roles.index') }}">Role</a></li>
                      </ol>
                    </nav>
                  </div>
                  <button type="button" id="add-role-btn" class="addbtn btn btn-dark" data-bs-toggle="modal" data-bs-target="#roleModal">
                    
                    <i class="fa-solid fa-plus me-1"></i> Add Role
                    
                  </button>
                </div>
                <div class="card city-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Role List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-role-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>Sr No</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($roles as $role)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                              <div class="d-flex align-items-center gap-2">
                                <span class="badge {{ $role->is_active ? 'bg-label-success' : 'bg-label-danger' }} status-badge">
                                  {{ $role->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <button
                                  type="button"
                                  class="btn btn-sm action-icon-btn text-info js-toggle-role"
                                  title="Toggle Status"
                                  data-role-id="{{ $role->id }}"
                                >
                                  <i class="bx bx-power-off"></i>
                                </button>
                              </div>
                            </td>
                            <td class="action-icons">
                              <button
                                type="button"
                                class="btn btn-sm action-icon-btn action-edit text-warning js-edit-role"
                                title="Edit"
                                data-role-id="{{ $role->id }}"
                                data-role-name="{{ $role->name }}"
                                data-role-active="{{ (int) $role->is_active }}"
                                data-role-permissions='@json($role->permissions->pluck('id')->values())'
                              >
                                <i class="bx bx-edit"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm action-icon-btn action-delete text-danger js-delete-role"
                                title="Delete"
                                data-role-id="{{ $role->id }}"
                                data-role-name="{{ $role->name }}"
                              >
                                <i class="bx bx-trash"></i>
                              </button>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="4" class="text-center text-muted">No roles found. Add one above.</td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog">
                <div class="modal-content">
                  <div class="modal-header modal-header-black p-3">
                    <h5 class="modal-title text-white" id="roleModalTitle">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="addRoleForm">
                    <div class="modal-body">
                      <input type="hidden" name="id" id="role_id" />
                      <input type="hidden" name="_method" id="role_method" value="POST" />
                      <div class="row g-3">
                        <div class="col-md-8">
                          <label for="roleName" class="form-label">Role Name</label>
                          <input type="text" class="form-control" id="roleName" name="name" placeholder="Enter role name" required />
                        </div>
                        <div class="col-md-4">
                          <label for="roleStatus" class="form-label">Status</label>
                          <select class="form-select" id="roleStatus" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                      </div>

                      <div class="mt-4">
                        <h6 class="mb-2">Permissions</h6>
                        <div class="permissions-box">
                          <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="permissions-select-all" />
                            <label class="form-check-label fw-semibold" for="permissions-select-all">Select All Permissions</label>
                          </div>

                          @forelse($permissions as $module => $modulePermissions)
                          <div class="permission-module">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                              <span class="permission-module-title">{{ ucfirst($module) }} Module</span>
                              <div class="form-check">
                                <input class="form-check-input module-select-all" type="checkbox" id="module-{{ $module }}-all" data-module="{{ $module }}" />
                                <label class="form-check-label" for="module-{{ $module }}-all">Select All</label>
                              </div>
                            </div>
                            <div class="row g-2">
                              @foreach($modulePermissions as $perm)
                              <div class="col-md-4">
                                <div class="form-check">
                                  <input class="form-check-input permission-item" type="checkbox" id="perm-{{ $perm->id }}" name="permissions[]" value="{{ $perm->id }}" data-module="{{ $module }}" />
                                  <label class="form-check-label" for="perm-{{ $perm->id }}">{{ ucwords($perm->name) }}</label>
                                </div>
                              </div>
                              @endforeach
                            </div>
                          </div>
                          @empty
                          <p class="text-muted mb-0">No permissions defined yet. Add permissions first.</p>
                          @endforelse
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-dark">Save Role</button>
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

  var roleModalEl = document.getElementById('roleModal');
  var roleModal = bootstrap.Modal.getOrCreateInstance(roleModalEl);
  var roleBaseUrl = "{{ url('/roles') }}";

  function syncRoleCheckboxState() {
    $('.module-select-all').each(function () {
      var module = $(this).data('module');
      var $items = $('.permission-item[data-module="' + module + '"]');
      $(this).prop('checked', $items.length > 0 && $items.filter(':checked').length === $items.length);
    });

    $('#permissions-select-all').prop(
      'checked',
      $('.permission-item').length > 0 && $('.permission-item:checked').length === $('.permission-item').length
    );
  }

  function resetRoleForm() {
    $('#addRoleForm')[0].reset();
    $('#role_id').val('');
    $('#role_method').val('POST');
    $('#roleModalTitle').text('Add Role');
    $('.permission-item, .module-select-all, #permissions-select-all').prop('checked', false);
  }

  $('#add-role-btn').on('click', function () {
    resetRoleForm();
  });

    // Global select-all
    $('#permissions-select-all').on('change', function () {
        $('.permission-item, .module-select-all').prop('checked', this.checked);
    });

    // Per-module select-all
    $('.module-select-all').on('change', function () {
        var module = $(this).data('module');
        $('.permission-item[data-module="' + module + '"]').prop('checked', this.checked);
      syncRoleCheckboxState();
    });

    $('.permission-item').on('change', function () {
      syncRoleCheckboxState();
    });

    $(document).on('click', '.js-edit-role', function () {
      var permissionIds = JSON.parse($(this).attr('data-role-permissions') || '[]');

      resetRoleForm();
      $('#role_id').val($(this).data('role-id'));
      $('#role_method').val('PUT');
      $('#roleName').val($(this).data('role-name'));
      $('#roleStatus').val(String($(this).data('role-active')));
      $('#roleModalTitle').text('Edit Role');

      permissionIds.forEach(function (permissionId) {
        $('#perm-' + permissionId).prop('checked', true);
      });

      syncRoleCheckboxState();
      roleModal.show();
    });

    $(document).on('click', '.js-delete-role', function () {
      var roleId = $(this).data('role-id');

      if (!confirm('Delete this role?')) {
        return;
      }

      $.ajax({
        url: roleBaseUrl + '/' + roleId,
        method: 'DELETE',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          if (res.success) {
            setTimeout(function () {
              window.location.reload();
            }, 1500);
          }
        },
        error: function (xhr) {
          alert(xhr.responseJSON?.message || 'An error occurred. Please try again.');
        }
      });
    });

    $(document).on('click', '.js-toggle-role', function () {
      var roleId = $(this).data('role-id');

      $.ajax({
        url: roleBaseUrl + '/' + roleId + '/toggle-status',
        method: 'POST',
        success: function (res) {
          if (res.success) {
            setTimeout(function () {
              window.location.reload();
            }, 1500);
          }
        },
        error: function (xhr) {
          alert(xhr.responseJSON?.message || 'An error occurred. Please try again.');
        }
      });
    });

    $('#addRoleForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        var $btn  = $form.find('[type="submit"]').prop('disabled', true);
      var roleId = $('#role_id').val();
      var formData = new FormData(this);
      var url = roleId ? roleBaseUrl + '/' + roleId : "{{ route('roles.store') }}";

        $.ajax({
        url: url,
            method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
            success: function (res) {
                if (res.success) {
            roleModal.hide();
            resetRoleForm();
            setTimeout(function () {
              window.location.reload();
            }, 1500);
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

        roleModalEl.addEventListener('hidden.bs.modal', function () {
          resetRoleForm();
        });
});
</script>
@endpush

@endsection