@extends('admin.layouts.layout')
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
        border-bottom: 1px solid #e9edf3;
      }

      .project-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .project-top-bar .btn {
        min-width: 185px;
      }

      .manage-project-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-project-head-card .project-top-bar {
        border-bottom: 0;
      }

      .manage-project-head-card .project-list-card {
        margin: 0 1rem 1rem;
      }

      .project-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .project-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .project-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .project-list-card .table td,
      .project-list-card .table th {
        vertical-align: middle;
      }

      #manage-hospital-table {
        margin-bottom: 0;
      }

      #manage-hospital-table thead th {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-hospital-table tbody td {
        font-size: 0.9rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-hospital-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title {
        color: black;
      }

      .addbtn {
        background-color: black;
      }

      .project-image {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 0.4rem;
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
        font-size: 24px;
        line-height: 1;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .project-top-bar .page-title {
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
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-hospital"></i> Manage Hospital</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-hospital.index') }}">Manage Hospital</a></li>
                      </ol>
                    </nav>
                  </div>
                  @can('add hospital')
                  <a href="{{ route('manage-hospital.create') }}" class="addbtn btn btn-dark">
                    <i class="fa-solid fa-plus me-1"></i> Add Hospital
                  </a>
                  @endcan
                </div>
                <div class="card project-list-card">
                  <div class="card-header">
                    <h4 class="card-title">Hospital List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-hospital-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Hospital</th>
                            <th>City</th>
                            <th>Contact</th>
                            <th>Login PIN</th>
                            <th>RFID Range</th>
                            <th>Net Quantity</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Date</th>
                            @canany(['edit hospital', 'delete hospital'])
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

          var table = $('#manage-hospital-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage-hospital.index') }}",
            columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              { data: 'image', name: 'image', orderable: false, searchable: false },
              { data: 'name', name: 'name' },
              { data: 'city_name', name: 'city.city_name' },
              { data: 'contact', name: 'contact' },
              { data: 'login_pin', name: 'login_pin' },
              { data: 'rfid_range', name: 'rfid_range', orderable: false, searchable: false },
              { data: 'net_quantity', name: 'net_quantity' },
              { data: 'email', name: 'email' },
              { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
              { data: 'created_at', name: 'created_at' }
              @canany(['edit hospital', 'delete hospital'])
              ,{ data: 'action', name: 'action', orderable: false, searchable: false }
              @endcanany
            ]
          });

          $(document).on('click', '.item-delete', function () {
            var hospitalId = $(this).data('id');

            confirmDelete(function () {
              $.ajax({
                url: "{{ url('manage-hospital') }}/" + hospitalId,
                method: 'POST',
                data: { _method: 'DELETE' },
                success: function (response) {
                  showToast('success', response.message);
                  table.ajax.reload(null, false);
                },
                error: function (xhr) {
                  var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unable to delete hospital.';
                  showToast('error', message);
                }
              });
            });
          });

          $(document).on('change', '.toggle-status', function () {
            var hospitalId = $(this).data('id');

            $.ajax({
              url: "{{ url('manage-hospital') }}/" + hospitalId + "/toggle-status",
              method: 'POST',
              data: { _method: 'POST' },
              success: function (response) {
                showToast('success', response.message);
                table.ajax.reload(null, false);
              },
              error: function () {
                showToast('error', 'Something went wrong!');
                table.ajax.reload(null, false);
              }
            });
          });
        });
        </script>
        @endpush
@endsection
           