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
                  <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-hourglass-end"></i> Expired Dog List</h2>
                  <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('expired-dog-list') }}">Expired Dog List</a></li>
                        
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
                        <option value="Central Zone">Central Zone</option>
                        <option value="North Zone">North Zone</option>
                        <option value="East Zone">East Zone</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Select Hospital</label>
                      <select class="form-select" id="hospitalSelect">
                        <option value="">---Select Hospital---</option>
                        <option value="City Care Hospital">City Care Hospital</option>
                        <option value="General Animal Hospital">General Animal Hospital</option>
                        <option value="Hope Vet Center">Hope Vet Center</option>
                      </select>
                    </div>
                  </div>

                  <div class="card catch-data-card mt-4 mb-0">
                    <h6 class="card-header mb-0">Related Catch Data</h6>
                    <div class="card-body p-3">
                      <div class="table-responsive catch-data-table-wrap table-anim-wrap">
                        <table class="table table-striped catch-data-table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Project</th>
                              <th>Hospital</th>
                              <th>Vehicle</th>
                              <th>Image</th>
                              <th>Tag</th>
                              <th>Address</th>
                              <th>Dog Type</th>
                              <th>Date</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody id="catchTableBody">
                            <tr>
                              <td colspan="10" class="text-center text-muted py-4">
                                Select Project / Hospital to view related data
                              </td>
                            </tr>
                          </tbody>
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
      const catchData = [
        {
          Id: "1001",
          project: "Central Zone",
          hospital: "City Care Hospital",
          Vehicle: "GJ 01 KT 6006",
          Image: "dog1.jpg",
          Tag:"Stray",
          Address: "123 Main St, Cityville",
          DogType: "Medium",
          date: "2026-03-07",
          Action:"View Details"
        },
        {
          Id: "1002",
          project: "Central Zone",
          hospital: "General Animal Hospital",
          Vehicle: "GJ 01 KT 6007",
          Image: "dog2.jpg",  
          Tag:"Stray",
          Address: "456 Elm St, Townsville",
          DogType: "Large",
          date: "2026-03-06",
          Action:"View Details"
        },
        {
          Id: "1003",
          project: "North Zone",
          hospital: "Hope Vet Center",
          Vehicle: "GJ 01 KT 6008",
          Image: "dog3.jpg",
          Tag:"Lost",
          Address: "789 Oak St, Villagetown",
          DogType: "Small",
          date: "2026-03-07",
          Action:"View Details"
        },
        {
          Id: "1004",
          project: "East Zone",
          hospital: "City Care Hospital",
          Vehicle: "GJ 01 KT 6009",
          Image: "dog4.jpg",
          Tag:"Found",
          Address: "101 Pine St, Forestville",
          DogType: "Medium",
          date: "2026-03-05",
          Action:"View Details"
        },
        {
          Id: "1005",
          project: "North Zone",
          hospital: "General Animal Hospital",
          Vehicle: "GJ 01 KT 6010",
          Image: "dog5.jpg",
          Tag:"Stray",
          Address: "202 Birch St, Lakeview",
          DogType: "Large",
          date: "2026-03-04",
          Action:"View Details"
        }
      ];

      const projectSelect = document.getElementById("projectSelect");
      const hospitalSelect = document.getElementById("hospitalSelect");
      const catchTableBody = document.getElementById("catchTableBody");
      const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

      function animateTableRows() {
        if (prefersReducedMotion) {
          return;
        }

        const rows = catchTableBody.querySelectorAll("tr");
        rows.forEach(function (row, index) {
          row.classList.remove("row-animate");
          row.style.animationDelay = index * 70 + "ms";

          // Restart animation when filters change repeatedly.
          void row.offsetWidth;
          row.classList.add("row-animate");
        });
      }

      function updateTable(html) {
        catchTableBody.innerHTML = html;
        animateTableRows();
      }

      function renderCatchRows() {
        const selectedProject = projectSelect.value;
        const selectedHospital = hospitalSelect.value;

        const filteredData = catchData.filter(function (item) {
          const projectMatch = !selectedProject || item.project === selectedProject;
          const hospitalMatch = !selectedHospital || item.hospital === selectedHospital;
          return projectMatch && hospitalMatch;
        });

        if (!selectedProject && !selectedHospital) {
          updateTable(
            '<tr><td colspan="10" class="text-center text-muted py-4">Select Project / Hospital to view related data</td></tr>'
          );
          return;
        }

        if (filteredData.length === 0) {
          updateTable(
            '<tr><td colspan="10" class="text-center text-warning py-4">No related data found for selected option</td></tr>'
          );
          return;
        }

        updateTable(
          filteredData
            .map(function (item) {
              const viewButton =
                '<a href="{{ route('view-expired-dog-list') }}" class="action-view-btn" title="View information" aria-label="View information for operation ' +
                item.Id +
                '"><i class="bx bx-show"></i></a>';

              return (
                "<tr>" +
                "<td>" + item.Id + "</td>" +
                "<td>" + item.project + "</td>" +
                "<td>" + item.hospital + "</td>" +
                "<td>" + item.Vehicle + "</td>" +
                "<td>" + item.Image + "</td>" +
                "<td>" + item.Tag + "</td>" +
                "<td>" + item.Address + "</td>" +
                "<td>" + item.DogType + "</td>" +
                "<td>" + item.date + "</td>" +
                "<td>" + viewButton + "</td>" +
                "</tr>"
              );
            })
            .join("")
        );
      }

      projectSelect.addEventListener("change", renderCatchRows);
      hospitalSelect.addEventListener("change", renderCatchRows);
    </script>

@endpush