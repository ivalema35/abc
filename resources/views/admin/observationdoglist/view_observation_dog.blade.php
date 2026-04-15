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
        margin-bottom: 2rem;
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

      /* â”€â”€â”€ Dog image card â”€â”€â”€ */
      .catch-img-card {
        background: #fff;
        border: 1px solid #e0e4ea;
        border-radius: 0.5rem;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 1px 4px rgba(67, 89, 113, 0.08);
      }
      .catch-img-card .img-select-wrap {
        padding: 0.7rem 0.9rem 0.5rem;
        border-bottom: 1px solid #e9edf3;
        background: #fafbfc;
      }
      .catch-img-card .img-select-wrap label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #435971;
        margin-bottom: 0.3rem;
        display: block;
      }
      .catch-img-card .img-select-wrap .form-select {
        font-size: 0.84rem;
      }
      .catch-img-card .dog-photo {
        width: 100%;
        height: 255px;
        object-fit: cover;
        display: block;
      }
      .catch-img-caption {
        padding: 0.5rem 0.9rem;
        font-size: 0.8rem;
        color: #8592a3;
        background: #fff;
      }

      /* â”€â”€â”€ Info table card â”€â”€â”€ */
      .catch-info-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 0.875rem;
      }
      .catch-info-table td {
        padding: 0.5rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
      }
      .catch-info-table tbody tr:nth-child(even) td {
        background: #f8f9fb;
      }
      .catch-info-table td.lbl {
        font-weight: 600;
        color: #000;
        white-space: nowrap;
        width: 18%;
        background: #f0f2f6;
      }
      .catch-info-table td.val {
        color: #435971;
      }

      /* â”€â”€â”€ Vehicle card â”€â”€â”€ */
      .catch-vehicle-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-vehicle-header {
        background: #000;
        color: #fff;
        padding: 0.52rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        text-align: center;
        letter-spacing: 0.01em;
      }
      .catch-vehicle-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
      }
      .catch-vehicle-table td {
        padding: 0.5rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
      }
      .catch-vehicle-table td.lbl {
        font-weight: 600;
        color: #000;
        width: 38%;
      }
      .catch-vehicle-table td.val {
        color: #435971;
      }

      /* â”€â”€â”€ Section headings â”€â”€â”€ */
      .catch-section-heading {
        color: #000;
        font-size: 1.15rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 0.6rem;
      }

      /* â”€â”€â”€ Sub-tables (treatment + datewise) â”€â”€â”€ */
      .catch-sub-card {
        background: #fff;
        border: 1px solid #000;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.45rem 1rem rgba(15, 23, 42, 0.08);
      }
      .catch-sub-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
      }
      .catch-sub-table thead tr {
        background: #000;
      }
      .catch-sub-table thead th {
        padding: 0.5rem 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: 700;
        color: #fff;
        font-size: 0.875rem;
      }
      .catch-sub-table tbody td {
        padding: 0.45rem 0.8rem;
        border: 1px solid #e0e4ea;
        vertical-align: middle;
        color: #435971;
      }
      .catch-sub-table tbody tr:nth-child(even) td {
        background: #f8f9fb;
      }
      .catch-sub-table tbody td.sub-lbl {
        font-weight: 600;
        color: #000;
      }
      .catch-sub-table tbody td.date-cell {
        white-space: nowrap;
      }
      .date-icon {
        color: #8592a3;
        margin-right: 0.28rem;
        font-size: 0.95rem;
        vertical-align: -1px;
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
        transition: opacity 0.2s;
      }
      .btn-back-catch:hover {
        opacity: 0.85;
        color: #fff;
      }

      @media (max-width: 991.98px) {
        .catch-main-card .card-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 0.75rem;
        }
      }
      @media (max-width: 767.98px) {
        .catch-info-table {
          font-size: 0.8rem;
        }
        .catch-info-table td {
          padding: 0.42rem 0.55rem;
        }
        .catch-sub-table {
          font-size: 0.8rem;
        }
      }
    </style>
@endpush
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card catch-main-card">
                <div class="card-header d-flex align-items-start justify-content-between gap-2 flex-wrap">
                  <div>
                    <h5 class="view-head-title"><i class="bx bx-show me-2"></i>View Observation Dog</h5>
                    <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item">
                          <a href="{{ route('manage-catch-process') }}">Catch Process</a>
                        </li>
                        <li class="breadcrumb-item">
                          <a href="{{ route('manage-observation-dog-list') }}">Observation Dog List</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="{{ route('view-observation-dog-list') }}">View Observation Dog</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-observation-dog-list') }}" class="btn-back-catch">
                    <i class="bx bx-arrow-back"></i> Back to List
                  </a>
                </div>

                <div class="card-body">
                  <!-- â”€â”€ Row 1: Dog image selector + Dog Details table â”€â”€ -->
                  <div class="row g-3 mb-3">
                    <!-- Dog image with selector -->
                    <div class="col-xl-4 col-md-5">
                      <div class="catch-img-card">
                        <div class="img-select-wrap">
                          <label for="dog-image-select">Dog Image</label>
                          <select id="dog-image-select" class="form-select form-select-sm">
                            <option value="../../assets/img/avatars/9.png" selected>Front Image</option>
                            <option value="../../assets/img/avatars/10.png">Side Image</option>
                            <option value="../../assets/img/avatars/11.png">Observation Image</option>
                          </select>
                        </div>
                        <img
                          id="dog-preview-image"
                          src="../../assets/img/avatars/1.png"
                          alt="Dog observation image"
                          class="dog-photo" />
                        <div class="catch-img-caption" id="dog-preview-caption">Front Image selected</div>
                      </div>
                    </div>

                    <!-- Dog Details table -->
                    <div class="col-xl-8 col-md-7">
                      <div class="catch-info-card">
                        <table class="catch-info-table">
                          <tbody>
                            <tr>
                              <td class="lbl">Tag Number</td>
                              <td class="val">{{ $record->tag_no ?? '-' }}</td>
                              <td class="lbl">Gender</td>
                              <td class="val">{{ $record->gender ?? '-' }}</td>
                              <td class="lbl">Dog Type</td>
                              <td class="val">{{ $record->dog_type ?? '-' }}</td>
                            </tr>
                            <tr>
                              <td class="lbl">Project Name</td>
                              <td class="val" colspan="5">{{ $record->project->project_name ?? '-' }}</td>
                            </tr>
                            <tr>
                              <td class="lbl">Location</td>
                              <td class="val" colspan="5">{{ $record->address ?? '-' }}</td>
                            </tr>
                            <tr>
                              <td class="lbl">Hospital</td>
                              <td class="val">{{ $record->hospital->name ?? '-' }}</td>
                              <td class="lbl">Doctor</td>
                              <td class="val" colspan="3">{{ $record->operation->doctor->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                              <td class="lbl">Color</td>
                              <td class="val">{{ $record->dog_color ?? '-' }}</td>
                              <td class="lbl">Temp</td>
                              <td class="val">{{ $record->operation->temperature ?? '-' }}</td>
                              <td class="lbl">Weight</td>
                              <td class="val">{{ $record->operation->body_weight ?? '-' }}</td>
                            </tr>
                            <tr>
                              <td class="lbl">Age Status</td>
                              <td class="val" colspan="5">{{ $record->age_status ?? '-' }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- / Row 1 -->

                  <!-- â”€â”€ Row 2: Treatment Details + Datewise Details â”€â”€ -->
                  <div class="row g-3 mb-3">
                    <!-- Treatment Details -->
                    <div class="col-xl-4 col-lg-5 col-md-6">
                      <h6 class="catch-section-heading">Treatment Details</h6>
                      <div class="catch-sub-card">
                        <table class="catch-sub-table">
                          <thead>
                            <tr>
                              <th>Medicine Name</th>
                              <th>Dose</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($record->operation->medicines ?? [] as $med)
                              <tr>
                                <td class="sub-lbl">{{ $med->name }}</td>
                                <td>{{ $med->pivot->qty ?? '-' }}</td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="2" class="text-center text-muted">No medicines prescribed</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Datewise Details -->
                    <div class="col-xl-8 col-lg-7 col-md-6">
                      <h6 class="catch-section-heading">Datewise Details</h6>
                      <div class="catch-sub-card">
                        <table class="catch-sub-table">
                          <thead>
                            <tr>
                              <th>Event Name</th>
                              <th>Date &amp; Time</th>
                              <th>User Name</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($record->stageLogs as $log)
                              <tr>
                                <td class="sub-lbl">{{ ucfirst($log->stage) }}</td>
                                <td class="date-cell"><i class="bx bx-calendar date-icon"></i>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $log->actionBy->name ?? 'N/A' }}</td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="3" class="text-center text-muted">No stage transitions recorded</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- / Row 2 -->

                  <!-- â”€â”€ Row 3: Vehicle Details â”€â”€ -->
                  <div class="row g-3 mb-3 justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                      <div class="catch-vehicle-card">
                        <div class="catch-vehicle-header">Vehicle Details</div>
                        <table class="catch-vehicle-table">
                          <tbody>
                            <tr>
                              <td class="lbl">Number Plate</td>
                              <td class="val">{{ $record->vehicle->vehicle_no ?? '-' }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- / Row 3 -->

                  <!-- Back button -->
                  <div class="mb-2">
                    <a href="{{ route('manage-observation-dog-list') }}" class="btn-back-catch">
                      <i class="bx bx-arrow-back"></i> Back to List
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection          