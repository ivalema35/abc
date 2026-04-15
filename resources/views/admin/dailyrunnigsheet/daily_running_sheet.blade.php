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

      .daily-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .daily-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .daily-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .daily-top-bar .btn {
        min-width: 185px;
      }

      .daily-running-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .daily-running-head-card .daily-top-bar {
        border-bottom: 0;
      }

      .daily-running-head-card .daily-list-card {
        margin: 0 1rem 1rem;
      }

      .daily-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .daily-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .daily-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .daily-list-card .table td,
      .daily-list-card .table th {
        vertical-align: middle;
      }

      .search-panel {
        border: 1px solid #dfe3eb;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
      }

      .summary-card {
        border: 1px solid #dfe3eb;
        border-radius: 0.75rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
      }

      .summary-label {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.35rem;
      }

      .summary-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
      }

      #daily-running-table {
        margin-bottom: 0;
      }

      #daily-running-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #daily-running-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #daily-running-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #daily-running-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title{
        color: black;
      }
      .addbtn{
        background-color: black;
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

      #daily-running-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #daily-running-table_wrapper .page-item.active .page-link:hover,
      #daily-running-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      @media (max-width: 767.98px) {
        .daily-top-bar {
          padding: 0.9rem 1rem;
        }

        .daily-top-bar .page-title {
          font-size: 1.3rem;
        }

        .daily-running-head-card .daily-list-card {
          margin: 0 0.75rem 0.75rem;
        }

      }
    </style>
@endpush   

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card daily-running-head-card">
                <div class="daily-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-calendar-days"></i> Daily Running Sheet</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daily Running Sheet</li>
                      </ol>
                    </nav>
                  </div>
                  <button type="button" id="back-btn" class="addbtn btn btn-dark">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </button>
                </div>

                <div class="px-3 px-md-4 pb-3 pb-md-4">
                  <div class="search-panel">
                    <div class="row g-3 align-items-end">
                      <div class="col-12 col-md-5">
                        <label for="project-search" class="form-label">Search Project</label>
                        <select id="project-search" class="form-select">
                          <option value="">Select Project</option>
                          @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="running-date" class="form-label">Date</label>
                        <input type="text" id="running-date" class="form-control" autocomplete="off" />
                      </div>
                      <div class="col-12 col-md-4 d-flex gap-2 flex-wrap">
                        <button type="button" id="search-btn" class="btn btn-dark flex-fill">Search</button>
                        <button type="button" id="reset-btn" class="btn btn-outline-secondary flex-fill">Reset</button>
                        <a href="{{ route('export.daily_running_sheet') }}" class="btn btn-success flex-fill" id="btn-export-excel" data-base-url="{{ route('export.daily_running_sheet') }}">
                          <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                      </div>
                    </div>
                  </div>

                  <div id="summary-section" class="row g-3 mb-3 d-none">
                    <div class="col-12 col-sm-6 col-xl-3">
                      <div class="card summary-card h-100">
                        <div class="card-body">
                          <p class="summary-label">Male</p>
                          <p class="summary-value" id="male-count">28</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                      <div class="card summary-card h-100">
                        <div class="card-body">
                          <p class="summary-label">Female</p>
                          <p class="summary-value" id="female-count">18</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                      <div class="card summary-card h-100">
                        <div class="card-body">
                          <p class="summary-label">Total</p>
                          <p class="summary-value" id="total-count">46</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                      <div class="card summary-card h-100">
                        <div class="card-body">
                          <p class="summary-label">Monthly Total</p>
                          <p class="summary-value" id="monthly-total-count">412</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="results-section" class="card daily-list-card d-none">
                  <div class="card-header">
                    <h4 class="card-title">Daily Running List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="daily-running-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Project</th>
                            <th>Hospital</th>
                            <th>Tag No</th>
                            <th>Catch Date</th>
                            <th>Status</th>
                            <th>Body Weight</th>
                            <th>Surgery Date</th>
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
            <!-- / Content -->
@endsection

@push('scripts')

<script src="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script>
      $(function () {
        var projectSearch = document.getElementById('project-search');
        var runningDate = document.getElementById('running-date');
        var summarySection = document.getElementById('summary-section');
        var resultsSection = document.getElementById('results-section');

        if (window.flatpickr) {
          flatpickr('#running-date', {
            dateFormat: 'Y-m-d',
            allowInput: true
          });
        }

        var dailyRunningTable = $('#daily-running-table').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('daily-running-sheet') }}',
            data: function (d) {
              d.project_id = projectSearch.value;
              d.running_date = runningDate.value;
            }
          },
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'project_name', name: 'project_name' },
            { data: 'hospital_name', name: 'hospital_name' },
            { data: 'tag_no', name: 'catching_records.tag_no' },
            { data: 'catch_date_formatted', name: 'catching_records.catch_date' },
            { data: 'status', name: 'catching_records.status' },
            { data: 'body_weight', name: 'dog_operations.body_weight' },
            { data: 'surgery_date_formatted', name: 'dog_operations.operation_date' },
            { data: 'surgery_remarks', name: 'dog_operations.remarks' }
          ]
        });

        function reloadDailyTable() {
          summarySection.classList.remove('d-none');
          resultsSection.classList.remove('d-none');
          dailyRunningTable.ajax.reload(null, false);
          dailyRunningTable.columns.adjust().draw(false);
        }

        document.getElementById('back-btn').addEventListener('click', function () {
          window.history.back();
        });

        document.getElementById('search-btn').addEventListener('click', function () {
          reloadDailyTable();
        });

        function updateExportLink() {
          var exportLink = document.getElementById('btn-export-excel');
          var exportUrl = new URL(exportLink.dataset.baseUrl, window.location.origin);

          if (projectSearch.value) {
            exportUrl.searchParams.set('project_id', projectSearch.value);
          }

          if (runningDate.value) {
            exportUrl.searchParams.set('running_date', runningDate.value);
          }

          exportLink.href = exportUrl.toString();
        }

        projectSearch.addEventListener('change', function () {
          updateExportLink();
          reloadDailyTable();
        });

        runningDate.addEventListener('change', function () {
          updateExportLink();
          reloadDailyTable();
        });

        document.getElementById('reset-btn').addEventListener('click', function () {
          projectSearch.value = '';
          runningDate.value = '';
          summarySection.classList.add('d-none');
          resultsSection.classList.add('d-none');
          dailyRunningTable.ajax.reload(null, false);
          updateExportLink();
        });

        updateExportLink();
      });
    </script>

@endpush