@extends('admin.layouts.layout')
@section('content')


@push('styles')
    <style>
      /* â”€â”€â”€ Sidebar full-label fix â”€â”€â”€ */
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

      /* â”€â”€â”€ Content background â”€â”€â”€ */
      .content-wrapper {
        background: linear-gradient(180deg, #f7f8fb 0%, #eef1f5 100%);
      }

      /* â”€â”€â”€ Main card â”€â”€â”€ */
      .catch-main-card {
        border-radius: 0.65rem;
        overflow: hidden;
        box-shadow: 0 0.55rem 1.1rem rgba(15, 23, 42, 0.1);
      }
      .catch-main-card .card-header {
        background: #fff;
        color: #000;
        border-bottom: 1px solid #dfe3ea;
        padding: 0.9rem 1rem;
        margin-bottom: 1rem;
      }
      .view-head-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
      }
      .view-head-breadcrumb .breadcrumb-item,
      .view-head-breadcrumb .breadcrumb-item a {
        font-size: 0.92rem;
        color: #8c95a3;
      }
      .view-head-breadcrumb .breadcrumb-item.active {
        color: #4b5563;
      }

      /* â”€â”€â”€ Back button â”€â”€â”€ */
      .btn-back-catch {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 0.375rem;
        padding: 0.48rem 1.15rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: opacity 0.2s;
      }
      .btn-back-catch:hover {
        opacity: 0.85;
        color: #fff;
      }

      /* â”€â”€â”€ Search panel â”€â”€â”€ */
      .search-panel {
        background: #fff;
        border: 1px solid #e0e4ea;
        border-radius: 0.55rem;
        padding: 1rem 1.1rem;
        margin-bottom: 1.2rem;
      }

      /* â”€â”€â”€ Total count card â”€â”€â”€ */
      .total-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.55rem;
        overflow: hidden;
        box-shadow: 0 0.3rem 0.8rem rgba(15, 23, 42, 0.07);
        margin-bottom: 1.2rem;
      }
      .total-card-header {
        background: #000;
        color: #fff;
        font-weight: 700;
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.45rem 1rem;
      }
      .total-card-body {
        padding: 0.85rem 1.2rem;
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
      }
      .total-card-value {
        font-size: 2rem;
        font-weight: 800;
        color: #111;
        line-height: 1;
      }
      .total-card-label {
        font-size: 0.85rem;
        color: #6b7280;
      }

      /* â”€â”€â”€ Results card â”€â”€â”€ */
      .results-card {
        background: #fff;
        border: 2px solid #000;
        border-radius: 0.55rem;
        overflow: hidden;
        box-shadow: 0 0.3rem 0.8rem rgba(15, 23, 42, 0.07);
      }
      .results-card .results-card-header {
        background: #000;
        color: #fff;
        padding: 0.65rem 1rem;
        font-weight: 700;
        font-size: 1rem;
      }

      /* â”€â”€â”€ DataTable styles â”€â”€â”€ */
      #completed-op-table thead th {
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #374151;
        white-space: nowrap;
        border-bottom-width: 1px;
      }
      #completed-op-table tbody td {
        font-size: 0.88rem;
        color: #4b5563;
        vertical-align: middle;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
      }
      #completed-op-table tbody tr:hover {
        background: #f7f9fc;
      }
      .action-icon-btn {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        box-shadow: none !important;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: opacity 0.2s;
      }
      .action-icon-btn:hover {
        opacity: 0.7;
      }
      .action-icon-btn i {
        font-size: 1.3rem;
        line-height: 1;
      }

      #completed-op-table_wrapper .page-item.active .page-link {
        background-color: #000 !important;
        border-color: #000 !important;
        color: #fff !important;
      }

      @media (max-width: 991.98px) {
        .catch-main-card .card-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 0.75rem;
        }
      }
    </style>

@endpush
            <!-- / Content -->
             <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card catch-main-card">
                <!-- Card header: title + breadcrumb + back button -->
                <div class="card-header d-flex align-items-start justify-content-between gap-2 flex-wrap">
                  <div>
                    <h5 class="view-head-title"><i class="bx bx-check-circle me-2"></i>Completed Operation Dog List</h5>
                    <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manage-catch-process') }}">Catch Process</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('project-summary') }}">Project Summary</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('manage-completed-operation-dog-list') }}">Completed Operation Dog List</a></li>
                      </ol>
                    </nav>
                  </div>
                  <div class="mb-2">
                    <a href="{{ route('project-summary') }}" class="btn-back-catch">
                      <i class="bx bx-arrow-back"></i> Back
                    </a>
                  </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                  <!-- Search panel -->
                  <div class="search-panel">
                    <div class="row g-3 align-items-end">
                      <div class="col-12 col-md-4">
                        <label for="start-date" class="form-label fw-semibold">Start Date</label>
                        <input type="date" id="start-date" class="form-control" />
                      </div>
                      <div class="col-12 col-md-4">
                        <label for="end-date" class="form-label fw-semibold">End Date</label>
                        <input type="date" id="end-date" class="form-control" />
                      </div>
                      <div class="col-12 col-md-4 d-flex gap-2">
                        <button type="button" id="search-btn" class="btn btn-dark w-100">
                          <i class="bx bx-search me-1"></i> Search
                        </button>
                        <button type="button" id="reset-btn" class="btn btn-outline-secondary w-100">
                          <i class="bx bx-reset me-1"></i> Reset
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Total count card (always visible) -->
                  <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4 col-xl-3">
                      <div class="total-card">
                        <div class="total-card-header">Total Records</div>
                        <div class="total-card-body">
                          <span class="total-card-value" id="total-count">0</span>
                          <span class="total-card-label">dogs</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Results datatable (hidden until search) -->
                  <div id="results-section" class="results-card d-none">
                    <div class="results-card-header d-flex align-items-center gap-2">
                      <i class="bx bx-table"></i> Search Results
                    </div>
                    <div class="p-3">
                      <div class="table-responsive">
                        <table id="completed-operation-dog-table" class="table table-striped border-top" style="width: 100%">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Vehicle</th>
                              <th>Tag</th>
                              <th>Project Name</th>
                              <th>Dog Type</th>
                              <th>Gender</th>
                              <th>Catch Date</th>
                              <th>Pick Location</th>
                              <th>Drop Location</th>
                              <th>Drop By</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>GJ17Y1389</td>
                              <td>277</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Street</td>
                              <td>Male</td>
                              <td>2026-03-11</td>
                              <td>Maruti Nagar, Rajkot</td>
                              <td>ABC Colony, Rajkot</td>
                              <td>Dr. Raisuddin Badi</td>
                              <td>
                                <a
                                  href="{{ route('view-completed-operation-dog-list') }}"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>GJ01KT6006</td>
                              <td>32</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Street</td>
                              <td>Female</td>
                              <td>2026-03-12</td>
                              <td>GIDC, Rajkot</td>
                              <td>Aji Dam Road, Rajkot</td>
                              <td>Dr. Kishan Kathiriya</td>
                              <td>
                                <a
                                  href="view_completed_operation_dog_list.html"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>GJ17Y1389</td>
                              <td>305</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Pet</td>
                              <td>Male</td>
                              <td>2026-03-10</td>
                              <td>Bhaktinagar, Rajkot</td>
                              <td>Kalawad Road, Rajkot</td>
                              <td>Dr. Raisuddin Badi</td>
                              <td>
                                <a
                                  href="view_completed_operation_dog_list.html"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>GJ01KT6006</td>
                              <td>198</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Street</td>
                              <td>Female</td>
                              <td>2026-03-09</td>
                              <td>Yagnik Road, Rajkot</td>
                              <td>150 Ft Ring Road, Rajkot</td>
                              <td>Dr. Kishan Kathiriya</td>
                              <td>
                                <a
                                  href="view_completed_operation_dog_list.html"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>GJ17Y1389</td>
                              <td>421</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Street</td>
                              <td>Male</td>
                              <td>2026-03-08</td>
                              <td>Kothariya Road, Rajkot</td>
                              <td>Mavdi, Rajkot</td>
                              <td>Dr. Raisuddin Badi</td>
                              <td>
                                <a
                                  href="view_completed_operation_dog_list.html"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>GJ01KT6006</td>
                              <td>88</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Pet</td>
                              <td>Male</td>
                              <td>2026-03-07</td>
                              <td>Raiya Road, Rajkot</td>
                              <td>University Road, Rajkot</td>
                              <td>Dr. Kishan Kathiriya</td>
                              <td>
                                <a
                                  href="view_completed_operation_dog_list.html"
                                  class="action-icon-btn text-info"
                                  title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>GJ17Y1389</td>
                              <td>512</td>
                              <td>Rajkot Municipal Corporation</td>
                              <td>Street</td>
                              <td>Female</td>
                              <td>2026-03-06</td>
                              <td>Gondal Road, Rajkot</td>
                              <td>Kalavad Road, Rajkot</td>
                              <td>Dr. Raisuddin Badi</td>
                              <td>
                                <a href="project_summary.html" class="action-icon-btn text-info" title="View">
                                  <i class="bx bx-show"></i>
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- / Results datatable -->
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection


@push('scripts')

<script>
      $(function () {
        // Initialise DataTable (hidden, so paging handled silently)
        var table = $('#completed-operation-dog-table').DataTable({
          responsive: true,
          columnDefs: [{ orderable: false, targets: 10 }],
          language: {
            search: 'Filter records:'
          }
        });

        var resultsSection = document.getElementById('results-section');
        var totalCountEl = document.getElementById('total-count');

        // â”€â”€ Search â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        document.getElementById('search-btn').addEventListener('click', function () {
          console.log('Search clicked');
          var startDate = document.getElementById('start-date').value;
          var endDate = document.getElementById('end-date').value;

          // Show results
          resultsSection.classList.remove('d-none');
          table.columns.adjust().draw(false);

          // Count total rows in the table (all pages)
          var total = table.rows({ search: 'applied' }).count();
          totalCountEl.textContent = total;
        });

        // â”€â”€ Reset â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        document.getElementById('reset-btn').addEventListener('click', function () {
          document.getElementById('start-date').value = '';
          document.getElementById('end-date').value = '';
          resultsSection.classList.add('d-none');
          totalCountEl.textContent = '0';
          table.search('').columns().search('').draw();
        });

        // Keep total in sync when DataTable internal search/filter changes
        $('#completed-operation-dog-table').on('search.dt', function () {
          if (!resultsSection.classList.contains('d-none')) {
            totalCountEl.textContent = table.rows({ search: 'applied' }).count();
          }
        });
      });
    </script>
@endpush