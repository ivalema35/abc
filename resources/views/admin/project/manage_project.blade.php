@extends('admin.layouts.layout')
@section('title', 'Manage Project')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card manage-project-head-card">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <h2 class="h3 mb-1 d-flex align-items-center gap-2">
          <i class="fa-regular fa-folder-open"></i> Manage Project
        </h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-project.index') }}">Manage Project</a></li>
          </ol>
        </nav>
      </div>
      <a href="{{ route('manage-project.create') }}" class="btn btn-dark btn-add-project">
        <i class="bx bx-plus me-1"></i> Add Project
      </a>
    </div>

    <div class="card project-list-card m-3">
      <div class="card-header bg-dark text-white border-bottom-0">
        <h4 class="card-title">Project List</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="manage-project-table" class="table table-striped border-top">
            <thead>
              <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Status</th>
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

@push('styles')
<style>
  .manage-project-head-card {
    background-color: #ffffff;
    border: 1px solid #dfe3eb;
    border-radius: 0.9rem;
    box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
    margin-bottom: 1rem;
  }

  .manage-project-head-card .card-body {
    padding: 1.25rem 1.5rem;
  }

  .btn-add-project {
    min-width: 140px;
    font-weight: 600;
  }

  .project-list-card {
    background-color: #ffffff;
    border: 2px solid #1e1e22;
    border-radius: 0.9rem;
    box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
    overflow: hidden;
  }

  .project-list-card .card-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #ffffff;
  }

  .action-icons {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    visibility: visible;
    opacity: 1;
  }

  .action-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 0.45rem;
    border: 1px solid rgba(0, 0, 0, 0.08);
    background: #fff;
    visibility: visible;
    opacity: 1;
  }

  #manage-project-table td:last-child {
    white-space: nowrap;
  }
</style>
@endpush

@push('scripts')
<script>
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = $('#manage-project-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-project.index') }}",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'status', name: 'status', orderable: false, searchable: false },
      { data: 'created_at', name: 'created_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
  });

  $(document).on('click', '.item-delete', function () {
    var projectId = $(this).data('id');

    confirmDelete(function () {
      $.ajax({
        url: "{{ url('manage-project') }}/" + projectId,
        method: 'POST',
        data: { _method: 'DELETE' },
        success: function (response) {
          showToast('success', response.message);
          table.ajax.reload(null, false);
        },
        error: function (xhr) {
          showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to delete project.');
        }
      });
    });
  });

  $(document).on('change', '.toggle-status', function () {
    var $toggle = $(this);
    var projectId = $toggle.data('id');

    $.ajax({
      url: "{{ route('manage-project.toggle-status') }}",
      method: 'POST',
      data: { id: projectId },
      success: function (response) {
        showToast('success', response.message);
        table.ajax.reload(null, false);
      },
      error: function () {
        showToast('error', 'Unable to update project status.');
        table.ajax.reload(null, false);
      }
    });
  });
});
</script>
@endpush

@endsection

