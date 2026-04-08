@extends('admin.layouts.layout')
@section('content')

@php
  $showStatusColumn = auth()->user()->can('edit bill master');
  $showActionColumn = auth()->user()->canany(['edit bill master', 'delete bill master']);
  $emptyColspan = 3 + ($showStatusColumn ? 1 : 0) + ($showActionColumn ? 1 : 0);
@endphp


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

      .bill-master-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .bill-master-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .bill-master-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .bill-master-top-bar .btn {
        min-width: 185px;
      }

      .manage-bill-master-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-bill-master-head-card .bill-master-top-bar {
        border-bottom: 0;
      }

      .manage-bill-master-head-card .bill-master-list-card {
        margin: 0 1rem 1rem;
      }

      .bill-master-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .bill-master-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .bill-master-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .bill-master-list-card .table td,
      .bill-master-list-card .table th {
        vertical-align: middle;
      }

      #manage-bill-master-table {
        margin-bottom: 0;
      }

      #manage-bill-master-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #000000;
        background-color: #ffffff;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-bill-master-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-bill-master-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #manage-bill-master-table tbody tr:hover {
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

      #manage-bill-master-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #manage-bill-master-table_wrapper .page-item.active .page-link:hover,
      #manage-bill-master-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      @media (max-width: 767.98px) {
        .bill-master-top-bar {
          padding: 0.9rem 1rem;
        }

        .bill-master-top-bar .page-title {
          font-size: 1.3rem;
        }

        .manage-bill-master-head-card .bill-master-list-card {
          margin: 0 0.75rem 0.75rem;
        }

      }
    </style>
@endpush


            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-bill-master-head-card">
                <div class="bill-master-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-receipt"></i> Manage Bill Master</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-bill-master.index') }}">Manage Bill Master</a></li>
                      </ol>
                    </nav>
                  </div>
                  @can('add bill master')
                  <a href="{{ route('manage-bill-master.create') }}" id="add-bill-master-btn" class="addbtn btn btn-dark">
                    <i class="fa-solid fa-plus me-1"></i> Add
                  </a>
                  @endcan
                </div>
                <div class="card bill-master-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Bill Master List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-bill-master-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Particular Name</th>
                            @can('edit bill master')
                            <th>Status</th>
                            @endcan
                            <th>Date</th>
                            @canany(['edit bill master', 'delete bill master'])
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
            <!-- / Content -->

@push('scripts')
<script>
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = $('#manage-bill-master-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-bill-master.index') }}",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' }
      @can('edit bill master')
      ,{ data: 'is_active', name: 'is_active', orderable: false, searchable: false }
      @endcan
      ,{ data: 'created_at', name: 'created_at' }
      @canany(['edit bill master', 'delete bill master'])
      ,{ data: 'action', name: 'action', orderable: false, searchable: false }
      @endcanany
    ]
  });

  $(document).on('click', '.item-delete', function () {
    var billMasterId = $(this).data('id');

    confirmDelete(function () {
      $.ajax({
        url: "{{ url('manage-bill-master') }}/" + billMasterId,
        method: 'POST',
        data: { _method: 'DELETE' },
        success: function (response) {
          showToast('success', response.message);
          table.ajax.reload(null, false);
        },
        error: function (xhr) {
          showToast('error', (xhr.responseJSON && xhr.responseJSON.message) || 'Unable to delete bill master.');
        }
      });
    });
  });

  $(document).on('change', '.toggle-status', function () {
    var billMasterId = $(this).data('id');

    $.ajax({
      url: "{{ url('manage-bill-master') }}/" + billMasterId + '/toggle-status',
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
            