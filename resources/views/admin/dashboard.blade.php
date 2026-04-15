@extends('admin.layouts.layout')
@section('content')
         
          <!-- Content wrapper -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6 mb-6">
                <div class="col-12">
                  <div class="card admin-hero-card">
                    <div class="card-body p-4">
                      <div class="row align-items-center g-4">
                        <div class="col-xl-7">
                          <span class="chip mb-3"><i class="bx bx-pulse"></i> Goal Foundation overview</span>
                          <h3 class="mb-2" style="color: var(--gf-charcoal)">Project overview for admin daily monitoring</h3>
                          <p class="mb-4" style="color: #6f625d">
                            This dashboard summarizes the live master data currently available in the system.
                            Transactional modules that are not implemented yet are intentionally shown as zero.
                          </p>
                          <div class="d-flex flex-wrap gap-2">
                            <span class="chip"><i class="bx bx-map"></i> {{ $cityCount }} active city zones</span>
                            <span class="chip"><i class="bx bx-clinic"></i> {{ $hospitalCount }} hospital partners</span>
                            <span class="chip"><i class="bx bx-user-voice"></i> {{ $staffCount }} registered staff members</span>
                          </div>
                        </div>
                        <div class="col-xl-5">
                          <div class="overview-project-list">
                            <div class="overview-project-item">
                              <span>Master Data Records</span>
                              <strong>{{ $masterDataCount }} active records</strong>
                            </div>
                            <div class="overview-project-item">
                              <span>Manage NGO</span>
                              <strong>{{ $ngoCount }} NGO partnerships</strong>
                            </div>
                            <div class="overview-project-item">
                              <span>Manage Hospital</span>
                              <strong>{{ $hospitalCount }} hospital centers</strong>
                            </div>
                            <div class="overview-project-item">
                              <span>Manage Doctor / ARV Staff</span>
                              <strong>{{ $doctorCount + $staffCount }} medical staff</strong>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row g-6 mb-6">
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a
                    href="javascript:void(0);"
                    class="d-block h-100 text-decoration-none text-reset"
                    data-bs-toggle="modal"
                    data-bs-target="#stockAccessModal">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">Stocks</div>
                            <div class="stat-value">0</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(224, 199, 184, 0.45)"><i class="bx bx-folder"></i></span>
                        </div>
                        <div class="stat-meta">Inventory module not connected yet</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a href="manage_city.html" class="d-block h-100 text-decoration-none text-reset">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">Cities</div>
                            <div class="stat-value">{{ $cityCount }}</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(242, 229, 220, 0.9)"><i class="bx bx-buildings"></i></span>
                        </div>
                        <div class="stat-meta">Ward-wise operations under active coverage</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a href="manage_ngo.html" class="d-block h-100 text-decoration-none text-reset">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">NGOs</div>
                            <div class="stat-value">{{ $ngoCount }}</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(184, 146, 126, 0.18)"><i class="bx bx-group"></i></span>
                        </div>
                        <div class="stat-meta">Partner NGOs supporting rescue and release</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a href="manage_hospital.html" class="d-block h-100 text-decoration-none text-reset">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">Hospitals</div>
                            <div class="stat-value">{{ $hospitalCount }}</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(224, 199, 184, 0.45)"><i class="bx bx-clinic"></i></span>
                        </div>
                        <div class="stat-meta">Surgery, recovery and emergency touchpoints</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a href="manage_doctor.html" class="d-block h-100 text-decoration-none text-reset">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">Doctors</div>
                            <div class="stat-value">{{ $doctorCount }}</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(242, 229, 220, 0.9)"><i class="bx bx-user-plus"></i></span>
                        </div>
                        <div class="stat-meta">OT doctors and consulting vets on roster</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                  <a href="manage_vehicle.html" class="d-block h-100 text-decoration-none text-reset">
                    <div class="card admin-stat-card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <div class="stat-label mb-1">Vehicles</div>
                            <div class="stat-value">{{ $vehicleCount }}</div>
                          </div>
                          <span class="stat-icon text-dark" style="background: rgba(184, 146, 126, 0.18)"><i class="bx bx-car"></i></span>
                        </div>
                        <div class="stat-meta">Field movement and transfer fleet</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="row g-6 mb-6">
                <div class="col-xxl-8">
                  <div class="card dashboard-panel h-100">
                    <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                      <div>
                        <h5 class="mb-1">Daily overview</h5>
                        <p class="dashboard-subtitle mb-0">
                          Transactional dashboards will populate here after catch, operation, and release flows are connected.
                        </p>
                      </div>
                      <div class="d-flex flex-wrap gap-2">
                        <span class="mini-badge" style="background: rgba(224, 199, 184, 0.45); color: var(--gf-charcoal)">0% release rate</span>
                        <span class="mini-badge" style="background: rgba(242, 229, 220, 0.95); color: var(--gf-charcoal)">0 hotspots monitored</span>
                      </div>
                    </div>
                    <div class="card-body pt-4">
                      <div class="row g-3 mb-4">
                        <div class="col-md-4">
                          <div class="overview-kpi h-100">
                            <small>Average pickup time</small>
                            <strong>0 min</strong>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="overview-kpi h-100">
                            <small>Medicine readiness</small>
                            <strong>0%</strong>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="overview-kpi h-100">
                            <small>Repeat complaint ratio</small>
                            <strong>0%</strong>
                          </div>
                        </div>
                      </div>
                      <div id="dailyOverviewChart" style="min-height: 330px"></div>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4">
                  <div class="card dashboard-panel h-100">
                    <div class="card-header">
                      <h5 class="mb-1">Operation mix</h5>
                      <p class="dashboard-subtitle mb-0">Operational split will appear here when live workflow data becomes available.</p>
                    </div>
                    <div class="card-body pt-4">
                      <div id="operationMixChart" style="min-height: 260px"></div>
                      <div class="signal-list mt-4">
                        <div class="signal-item">
                          <span class="signal-dot bg-success"></span>
                          <div>
                            <div class="fw-semibold">Sterilization pipeline pending</div>
                            <div class="queue-meta">0 theatres reported because operation data is not connected yet.</div>
                          </div>
                        </div>
                        <div class="signal-item">
                          <span class="signal-dot bg-warning"></span>
                          <div>
                            <div class="fw-semibold">Medicine restock pending</div>
                            <div class="queue-meta">0 restock alerts are available until inventory transactions are implemented.</div>
                          </div>
                        </div>
                        <div class="signal-item">
                          <span class="signal-dot bg-info"></span>
                          <div>
                            <div class="fw-semibold">NGO coordination pending</div>
                            <div class="queue-meta">{{ $ngoCount }} NGOs are registered, but live workload tracking is still at 0.</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row g-6">
                <div class="col-xl-8">
                  <div class="card dashboard-panel h-100">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                      <div>
                        <h5 class="mb-1">Today's operational updates</h5>
                        <p class="dashboard-subtitle mb-0">Transactional movement will appear here after the operations modules are completed.</p>
                      </div>
                      <span class="mini-badge bg-label-dark text-dark">Updated at 0:00</span>
                    </div>
                    <div class="card-body pt-4">
                      <div class="table-responsive">
                        <table class="table ops-table align-middle mb-0">
                          <thead>
                            <tr>
                              <th>Ward / Case</th>
                              <th>Assigned team</th>
                              <th>Stage</th>
                              <th>Hospital / NGO</th>
                              <th>ETA</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <div class="fw-semibold">No operational cases available</div>
                                <div class="queue-meta">Catch, release, and field workflow data will appear here later.</div>
                              </td>
                              <td>0 assigned teams</td>
                              <td><span class="badge bg-label-secondary">Pending integration</span></td>
                              <td>0 linked partners</td>
                              <td>0 min</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4">
                  <div class="d-flex flex-column gap-6 h-100">
                    <div class="card dashboard-panel">
                      <div class="card-header">
                        <h5 class="mb-1">Response queue</h5>
                        <p class="dashboard-subtitle mb-0">Next cases that need admin attention today.</p>
                      </div>
                      <div class="card-body pt-4">
                        <div class="queue-item pt-0">
                          <div>
                            <div class="fw-semibold">No queued response items</div>
                            <div class="queue-meta">Response workflow data is currently 0.</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                        <div class="queue-item">
                          <div>
                            <div class="fw-semibold">Roster approvals</div>
                            <div class="queue-meta">0 pending approvals available.</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                        <div class="queue-item">
                          <div>
                            <div class="fw-semibold">NGO invoice validation</div>
                            <div class="queue-meta">0 invoices are pending transactional review.</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                      </div>
                    </div>

                    <div class="card dashboard-panel field-team-card flex-grow-1">
                      <div class="card-header">
                        <h5 class="mb-1">Inventory and field teams</h5>
                        <p class="dashboard-subtitle mb-0">Quick stock watch with live team capacity.</p>
                      </div>
                      <div class="card-body pt-4">
                        <div class="inventory-item pt-0">
                          <div>
                            <div class="fw-semibold">ARV vaccine stock</div>
                            <div class="inventory-meta">0 doses remaining</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                        <div class="inventory-item">
                          <div>
                            <div class="fw-semibold">Antibiotic kit stock</div>
                            <div class="inventory-meta">0 kits left for OT teams</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                        <div class="inventory-item">
                          <div>
                            <div class="fw-semibold">Catcher nets and crates</div>
                            <div class="inventory-meta">0% deployment readiness</div>
                          </div>
                          <span class="badge bg-label-secondary">0</span>
                        </div>
                        <hr class="my-4" />
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <span class="fw-semibold">Active field teams</span>
                          <span class="mini-badge bg-label-dark text-dark">0 live</span>
                        </div>
                        <div class="progress mb-3" style="height: 0.7rem">
                          <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="queue-meta">0 teams on catch route, 0 in hospital transfer, 0 on emergency standby.</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body">
                    Â©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with â¤ï¸ by
                    <a href="https://ivinfotech.com/" target="_blank" class="footer-link">IV Infotech</a>
                  </div>
                  <div class="d-none d-lg-inline-block">
                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

                    <a href="https://themeselection.com/support/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>

    @push('scripts')
      <script>
        window.dashboardLifecycleCounts = {
          totalCaught: @json($totalCaughtCount ?? 0),
          todaysCatch: @json($todaysCatchCount ?? 0),
          inProcess: @json($inProcessCount ?? 0),
          observation: @json($observationCount ?? 0),
          released: @json($releasedCount ?? 0),
          expired: @json($expiredCount ?? 0)
        };

        window.dashboardChartData = {
          weekly: {
            labels: @json($weeklyLabels ?? []),
            caught: @json($weeklyCaught ?? []),
            released: @json($weeklyReleased ?? []),
            expired: @json($weeklyExpired ?? [])
          },
          monthlyMix: {
            labels: ['In Process', 'Observation', 'R4R', 'Released', 'Expired'],
            series: [
              @json($monthlyMix['inProcess'] ?? 0),
              @json($monthlyMix['observation'] ?? 0),
              @json($monthlyMix['r4r'] ?? 0),
              @json($monthlyMix['released'] ?? 0),
              @json($monthlyMix['expired'] ?? 0)
            ]
          }
        };
      </script>
    @endpush

    @endsection