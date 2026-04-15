@extends('admin.layouts.layout')
@section('content')


@push('styles')
    <style>
      .catch-animated-card {
        opacity: 0;
        transform: translateY(16px);
        animation: catchCardIntro 0.55s ease-out 0.1s forwards;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
      }

      .catch-animated-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.75rem 1.5rem rgba(67, 89, 113, 0.18);
      }

      .table-anim-wrap tbody tr {
        opacity: 0;
      }

      .table-anim-wrap tbody tr.row-animate {
        animation: catchRowIn 0.4s ease forwards;
      }

      @keyframes catchCardIntro {
        from {
          opacity: 0;
          transform: translateY(16px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes catchRowIn {
        from {
          opacity: 0;
          transform: translateY(10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

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
      .project-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
        margin-bottom: 1rem;
      }
      .project-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
        margin-bottom: 1rem;
      }

      .project-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #000000;
      }

      .project-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .catch-data-card {
        border: 2px solid #000;
      }

      .catch-data-card .card-header {
        background-color: #000;
        color: #fff;
        border-bottom: 2px solid #000;
        font-weight: 600;
      }

      .catch-data-table-wrap {
        
        border-radius: 0.375rem;
      }

      .catch-data-table {
        margin-bottom: 0;
      }

      .catch-data-table thead th {
        white-space: nowrap;
      }
      /* ACTION BUTTON */
      .action-view-btn {
        width: 2.1rem;
        height: 2.1rem;
        border: none;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #03a9f4;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 0.25rem 0.7rem rgba(3, 169, 244, 0.32);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
      }

      .action-view-btn i {
        font-size: 1rem;
      }

      .action-view-btn:hover {
        background: #0288d1;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 0.4rem 0.9rem rgba(2, 136, 209, 0.35);
      }

      .action-view-btn:focus-visible {
        outline: 2px solid #81d4fa;
        outline-offset: 2px;
      }
      /* / ACTION BUTTON */
      @media (prefers-reduced-motion: reduce) {
        .catch-animated-card,
        .catch-animated-card:hover,
        .table-anim-wrap tbody tr,
        .table-anim-wrap tbody tr.row-animate {
          animation: none !important;
          transition: none !important;
          opacity: 1 !important;
          transform: none !important;
          box-shadow: none !important;
        }
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .project-top-bar .page-title {
          font-size: 1.3rem;
        }
      }
    </style>
@endpush

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card catch-animated-card">
              <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                  <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check"></i> Completed Operations List</h2>
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('completed-operation-list') }}">Completed Operations List</a></li>
                       
                      </ol>
                    </nav>
                </div>
              </div>  
                <div class="card-body">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <label class="form-label">Select Project</label>
                      <select class="form-select" id="projectSelect">
                        <option value="">---Select Project---</option>
                        @foreach ($projects as $project)
                          <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Select Hospital</label>
                      <select class="form-select" id="hospitalSelect">
                        <option value="">---Select Hospital---</option>
                        @foreach ($hospitals as $hospital)
                          <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('export.completed_operation_list') }}" class="btn btn-success" id="btn-export-excel-completed" data-base-url="{{ route('export.completed_operation_list') }}">
                      <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                  </div>

                  <div class="card catch-data-card mt-4 mb-0">
                    <h6 class="card-header mb-0">Related Catch Data</h6>
                    <div class="card-body p-3">
                      <div class="table-responsive catch-data-table-wrap table-anim-wrap">
                        <table id="completed-operation-table" class="table table-striped catch-data-table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Project</th>
                              <th>Hospital</th>
                              <th>Tag</th>
                              <th>Dog Type</th>
                              <th>Gender</th>
                              <th>Status</th>
                              <th>Catch Date</th>
                              <th>Surgery Date</th>
                              <th>Doctor</th>
                              <th>Remarks</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
      
@endsection
@push('scripts')
<script>
      $(function () {
        var projectSelect = document.getElementById('projectSelect');
        var hospitalSelect = document.getElementById('hospitalSelect');

        function updateCompletedExportLink() {
          var exportLink = document.getElementById('btn-export-excel-completed');
          var exportUrl = new URL(exportLink.dataset.baseUrl, window.location.origin);

          if (projectSelect.value) {
            exportUrl.searchParams.set('project_id', projectSelect.value);
          }

          if (hospitalSelect.value) {
            exportUrl.searchParams.set('hospital_id', hospitalSelect.value);
          }

          exportLink.href = exportUrl.toString();
        }

        var completedOperationTable = $('#completed-operation-table').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('completed-operation-list') }}',
            data: function (d) {
              d.project_id = projectSelect.value;
              d.hospital_id = hospitalSelect.value;
            }
          },
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'project_name', name: 'project_name' },
            { data: 'hospital_name', name: 'hospital_name' },
            { data: 'tag_no', name: 'catching_records.tag_no' },
            { data: 'dog_type', name: 'catching_records.dog_type' },
            { data: 'gender', name: 'catching_records.gender' },
            { data: 'status', name: 'catching_records.status' },
            { data: 'catch_date_formatted', name: 'catching_records.catch_date' },
            { data: 'operation_date', name: 'dog_operations.operation_date' },
            { data: 'doctor_name', name: 'doctor_name' },
            { data: 'remarks', name: 'remarks', orderable: false, searchable: false }
          ]
        });

        function reloadCompletedTable() {
          completedOperationTable.ajax.reload(null, false);
          updateCompletedExportLink();
        }

        projectSelect.addEventListener('change', reloadCompletedTable);
        hospitalSelect.addEventListener('change', reloadCompletedTable);

        updateCompletedExportLink();
      });
    </script>
@endpush
