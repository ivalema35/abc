@extends('admin.layouts.layout')
@section('content')

@php
  $showStatusColumn = auth()->user()->can('edit medicare');
  $showActionColumn = auth()->user()->canany(['edit medicare', 'delete medicare']);
  $emptyColspan = 3 + ($showStatusColumn ? 1 : 0) + ($showActionColumn ? 1 : 0);
@endphp

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

      .medicare-top-bar {
        padding: 12px 1.5rem;
      }

      .manage-medicare-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-medicare-head-card .medicare-list-card {
        margin: 0 1rem 1rem;
      }

      .page-title {
        color: #000000;
      }

      .addbtn {
        background-color: #000000;
      }

      .medicare-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .medicare-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .medicare-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      #manage-medicare-table {
        margin-bottom: 0;
      }

      #manage-medicare-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-medicare-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
        vertical-align: middle;
      }

      #manage-medicare-table tbody tr:hover {
        background-color: #f7f9fc;
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

      @media (max-width: 767.98px) {
        .medicare-top-bar {
          padding: 0.9rem 1rem;
        }

        .manage-medicare-head-card .medicare-list-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
@endpush

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-medicare-head-card">
                <div class="medicare-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-notes-medical"></i> Manage Medicare</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-medicare.index') }}">Manage Medicare</a></li>
                      </ol>
                    </nav>
                  </div>
                  @can('add medicare')
                  <a href="{{ route('manage-medicare.create') }}" id="add-medicare-btn" class="addbtn btn btn-dark">
                    <i class="fa-solid fa-plus me-1"></i> Add Medicare
                  </a>
                  @endcan
                </div>
                <div class="card medicare-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Medicare List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-medicare-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Medicare</th>
                            @can('edit medicare')
                            <th>Status</th>
                            @endcan
                            <th>Date</th>
                            @canany(['edit medicare', 'delete medicare'])
                            <th>Action</th>
                            @endcanany
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = $('#manage-medicare-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-medicare.index') }}",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' }
      @can('edit medicare')
      ,{ data: 'is_active', name: 'is_active', orderable: false, searchable: false }
      @endcan
      ,{ data: 'created_at', name: 'created_at' }
      @canany(['edit medicare', 'delete medicare'])
      ,{ data: 'action', name: 'action', orderable: false, searchable: false }
      @endcanany
    ]
  });

  $(document).on('click', '.item-delete', function () {
    var medicareId = $(this).data('id');

    confirmDelete(function () {
      $.ajax({
        url: "{{ url('manage-medicare') }}/" + medicareId,
        method: 'POST',
        data: { _method: 'DELETE' },
        success: function (response) {
          showToast('success', response.message);
          table.ajax.reload(null, false);
        },
        error: function (xhr) {
          showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to delete medicare.');
        }
      });
    });
  });

  $(document).on('change', '.toggle-status', function () {
    var medicareId = $(this).data('id');

    $.ajax({
      url: "{{ url('manage-medicare') }}/" + medicareId + '/toggle-status',
      method: 'POST',
      success: function (response) {
        showToast('success', response.message);
        table.ajax.reload(null, false);
      },
      error: function (xhr) {
        showToast('error', 'Something went wrong!');
        table.ajax.reload(null, false);
      }
    });
  });
});
</script>
@endpush

@endsection