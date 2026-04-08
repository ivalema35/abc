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

      .project-top-bar {
        padding: 12px 1.5rem;
      }

      .manage-project-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-project-head-card .project-list-card {
        margin: 0 1rem 1rem;
      }

      .manage-project-head-card .login-details-card {
        margin: 11px 2rem 1rem;
      }

      .page-title {
        color: #000000;
        font-size: 26px;
        margin-bottom: 0.2rem;
      }

      .page-subtitle {
        font-size: 20px;
      }

      .btn-back {
        min-width: 140px;
        font-size: 1rem;
        font-weight: 600;
        background-color: #7d8da1;
        border-color: #7d8da1;
        color: #ffffff;
      }

      .btn-back:hover,
      .btn-back:focus {
        background-color: #6d7d92;
        border-color: #6d7d92;
      }

      .project-list-card {
        background-color: #ffffff;
        border: 2px solid #1e1e22;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .project-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .project-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff;
      }

      .project-list-card .card-body {
        padding: 1.85rem 1.5rem 1.6rem;
      }

      .login-details-card {
        background: #ffffff;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
        display: none;
      }

      .login-details-card.is-visible {
        display: block;
      }

      .login-details-head {
        background-color: #0f0f13;
        color: #ffffff !important;
        padding: 1rem 1.25rem;
      }

      .login-details-head h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color:#ffffff !important;
      }

      .login-details-body {
        padding: 1.15rem 1.25rem 1.35rem;
      }

      .permission-title {
        text-align: center;
        color: #4b5563;
        font-size: 1.5rem;
        font-weight: 500;
        margin: 1rem 0 1.2rem;
      }

      .permission-grid-head,
      .permission-row {
        display: grid;
        grid-template-columns: minmax(170px, 1.2fr) minmax(230px, 1fr) minmax(220px, 1fr);
        column-gap: 1rem;
        align-items: center;
      }

      .permission-grid-head {
        color: #4b5563;
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 0.35rem;
      }

      .permission-grid-head div {
        text-align: center;
      }

      .permission-row {
        border-top: 1px dashed #d9dee7;
        padding: 0.95rem 0;
      }

      .permission-row:first-of-type {
        border-top: 0;
      }

      .permission-label {
        color: #4b5563;
        font-size: 1.08rem;
        font-weight: 600;
      }

      .permission-options {
        display: flex;
        justify-content: center;
        gap: 1.25rem;
        color: #4b5563;
        font-size: 1.04rem;
        font-weight: 600;
      }

      .permission-options .form-check-input {
        margin-top: 0.2em;
      }

      .login-details-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.65rem;
        margin-top: 1.45rem;
      }

      .btn-update-login {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
        min-width: 130px;
      }

      .btn-update-login:hover,
      .btn-update-login:focus {
        background-color: #1f2937;
        border-color: #1f2937;
        color: #ffffff;
      }

      .btn-cancel-login {
        min-width: 130px;
      }

      .form-subheading {
        color: #5d6778;
        font-size: 1.55rem;
        font-weight: 600;
        margin-bottom: 1.2rem;
      }

      .form-subheading i {
        color: #232323;
      }

      .project-list-card .form-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #3f4a59;
      }

      .project-list-card .form-control,
      .project-list-card .form-select {
        min-height: 3.1rem;
        font-size: 1.05rem;
      }

      .project-list-card .input-group .btn {
        min-width: 5.8rem;
      }

      .project-list-card .input-group {
        display: flex;
        flex-wrap: nowrap;
        overflow: hidden;
        border-radius: 0.5rem;
        border: 1px solid #d8dde8;
        background-color: #ffffff;
      }

      .project-list-card .input-group.project-field-group {
        gap: 0.45rem;
        border: 0;
        background-color: transparent;
        overflow: visible;
      }

      .project-list-card .input-group.project-field-group > .form-select {
        border: 1px solid #d8dde8;
        border-radius: 0.5rem;
      }

      .project-list-card .input-group > .form-select {
        flex: 1 1 auto;
        border: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 1px solid #d8dde8;
        margin-right: 0 !important;
        box-shadow: none;
      }

      .project-list-card .input-group > .form-select:focus {
        box-shadow: none;
      }

      .field-picker-btn {
        min-width: 5.6rem !important;
        padding: 0.4rem 0.8rem;
        font-size: 0.95rem;
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border: 0 !important;
        margin-left: 0 !important;
        box-shadow: none !important;
      }

      .project-list-card .input-group.project-field-group .field-picker-btn {
        min-height: 3.1rem;
        border-radius: 0.5rem !important;
      }

      .field-picker-btn:hover,
      .field-picker-btn:focus {
        background-color: #45ab97;
        border-color: #45ab97;
        color: #ffffff;
        box-shadow: none;
      }

      .btn-select-all {
        min-height: 3.1rem;
        min-width: 9rem;
        width: auto !important;
        padding-left: 1.1rem;
        padding-right: 1.1rem;
        font-weight: 600;
      }

      .project-select-all-col {
        display: flex;
        align-items: flex-end;
      }

      .form-action-row {
        justify-content: flex-end;
      }

      .form-action-row .btn {
        min-width: 128px;
        min-height: 2.8rem;
        font-weight: 600;
      }

      .project-list-card form {
        padding-bottom: 0.35rem;
      }
      
      .modal-header {
        background-color: #000000;
        color: #ffffff;
        border-bottom: 1px solid #000000;
      }

      .modal-title {
        color: #ffffff;
      }

    .modal-header .btn-close {
        background-color: #ffffff;
        border-radius: 0.35rem;
        opacity: 1;
        filter: none;
        padding: 0.45rem;
      }

       .modal-header .btn-close:hover,
       .modal-header .btn-close:focus {
        background-color: #f2f2f2;
        box-shadow: none;
      }

      #ngoModal #saveNgoBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #ngoModal #saveNgoBtn:hover,
      #ngoModal #saveNgoBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #cityModal #saveCityBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #cityModal #saveCityBtn:hover,
      #cityModal #saveCityBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #hospitalModal #saveHospitalBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #hospitalModal #saveHospitalBtn:hover,
      #hospitalModal #saveHospitalBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      #vehicleModal #saveVehicleBtn {
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
      }

      #vehicleModal #saveVehicleBtn:hover,
      #vehicleModal #saveVehicleBtn:focus {
        background-color: #1f1f1f;
        border-color: #1f1f1f;
        color: #ffffff;
      }

      .card-body{
        padding-top:27px !important;
      }
      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .project-select-all-col {
          align-items: stretch;
        }

        .page-title {
          font-size: 1.55rem;
        }

        .page-subtitle {
          font-size: 1rem;
        }

        .manage-project-head-card .project-list-card {
          margin: 0 0.75rem 0.75rem;
        }

        .manage-project-head-card .login-details-card {
          margin: 0 0.75rem 0.75rem;
        }

        .permission-grid-head,
        .permission-row {
          grid-template-columns: 1fr;
          row-gap: 0.55rem;
        }

        .permission-grid-head {
          display: none;
        }

        .permission-label,
        .permission-options {
          justify-content: flex-start;
          text-align: left;
        }
      }
    </style>
  @endpush
           
  
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-project-head-card">
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-regular fa-folder-open"></i> Add Project</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-project') }}">Manage Project</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('add-project') }}">Add Project</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-project') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card" id="project-information-card">
                  <div class="card-header">
                    <h4 class="card-title">Project Information</h4>
                  </div>
                  <div class="card-body">
                    
                    <form>
                      <div class="row g-4">
                        <div class="col-md-6">
                          <label class="form-label" for="projectName">Name <span class="text-danger">*</span></label>
                          <input type="text" id="projectName" class="form-control" placeholder="Enter project name" />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="ngoField">NGO Field <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="ngoField" class="form-select">
                              <option value="" selected>Select NGO</option>
                              <option>NGO One</option>
                              <option>NGO Two</option>
                            </select>
                            <button
                              class="btn btn-outline-primary field-picker-btn"
                              type="button"
                              id="openNgoModalBtn"
                              data-bs-toggle="modal"
                              data-bs-target="#ngoModal">
                              <i class="fa-solid fa-plus"></i> NGO
                            </button>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="cityField">City <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="cityField" class="form-select">
                              <option value="" selected>Select city</option>
                              <option>Surat</option>
                              <option>Ahmedabad</option>
                            </select>
                            <button
                              class="btn btn-outline-primary field-picker-btn"
                              type="button"
                              id="openCityModalBtn"
                              data-bs-toggle="modal"
                              data-bs-target="#cityModal">
                              <i class="fa-solid fa-plus"></i> City
                            </button>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="hospitalField">Hospital <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="hospitalField" class="form-select">
                              <option value="" selected>Select hospital</option>
                              <option>Civil Hospital</option>
                              <option>General Hospital</option>
                            </select>
                            <button
                              class="btn btn-outline-primary field-picker-btn"
                              type="button"
                              id="openHospitalModalBtn"
                              data-bs-toggle="modal"
                              data-bs-target="#hospitalModal">
                              <i class="fa-solid fa-plus"></i> Hospital
                            </button>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="vehicleField">Vehicle <span class="text-danger">*</span></label>
                          <div class="input-group project-field-group">
                            <select id="vehicleField" class="form-select">
                              <option value="" selected>Select vehicle</option>
                              <option>GJ-01-AB-1234</option>
                              <option>GJ-05-CD-9876</option>
                            </select>
                            <button
                              class="btn btn-outline-primary field-picker-btn"
                              type="button"
                              id="openVehicleModalBtn"
                              data-bs-toggle="modal"
                              data-bs-target="#vehicleModal">
                              <i class="fa-solid fa-plus"></i> Vehicle
                            </button>
                          </div>
                        </div>
                        <div class="col-md-6 project-select-all-col">
                          
                          <button type="button" class="btn btn-dark w-100 btn-select-all ">Select All</button>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="rfidStatus">RFID Status <span class="text-danger">*</span></label>
                          <select id="rfidStatus" class="form-select">
                            <option value="" selected>Select status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="contactNo">Contact <span class="text-danger">*</span></label>
                          <input type="tel" id="contactNo" class="form-control" placeholder="Enter contact number" />
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="pinCode">4 Digit Pin <span class="text-danger">*</span></label>
                          <input type="password" id="pinCode" class="form-control" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" placeholder="0000" />
                        </div>
                      </div>

                      <div class="d-flex flex-wrap gap-2 mt-4 form-action-row">
                        <button type="submit" class="btn bg-black text-white">Add Project</button>
                        <a href="manage_project.html" class="btn btn-label-secondary">Cancel</a>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="login-details-card" id="set-login-details-section">
                  <div class="login-details-head">
                    <h4>Set Login Details</h4>
                  </div>
                  <div class="login-details-body">
                    <div class="row g-3">
                      <div class="col-12 col-md-4">
                        <label class="form-label" for="projectContact">Contact <span class="text-danger">*</span></label>
                        <input type="text" id="projectContact" class="form-control" value="9687680216" />
                      </div>
                      <div class="col-12 col-md-4">
                        <label class="form-label" for="projectPin">4 Digit Pin <span class="text-danger">*</span></label>
                        <input type="text" id="projectPin" class="form-control" value="0216" maxlength="4" />
                      </div>
                      <div class="col-12 col-md-4">
                        <label class="form-label" for="projectArvMonth">ARV Month <span class="text-danger">*</span></label>
                        <input type="number" id="projectArvMonth" class="form-control" value="6" min="0" />
                      </div>
                    </div>

                    <h5 class="permission-title">Set Permission for Client</h5>

                    <div class="permission-grid-head">
                      <div></div>
                      <div>Visibility</div>
                      <div>Count/List Type</div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Catching Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="catchingVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="catchingVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="catchingType" /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="catchingType" checked /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Receive Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="receiveVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="receiveVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="receiveType" checked /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="receiveType" /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Process Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="processVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="processVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="processType" checked /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="processType" /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Observation Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="observationVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="observationVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="observationType" checked /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="observationType" /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">R4R Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="r4rVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="r4rVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="r4rType" checked /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="r4rType" /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Complete Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="completeVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="completeVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="completeType" /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="completeType" checked /> List</label>
                      </div>
                    </div>

                    <div class="permission-row">
                      <div class="permission-label">Reject Details</div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="rejectVisibility" checked /> Visible</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="rejectVisibility" /> Hidden</label>
                      </div>
                      <div class="permission-options">
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="rejectType" checked /> Count</label>
                        <label class="form-check form-check-inline m-0"><input class="form-check-input" type="radio" name="rejectType" /> List</label>
                      </div>
                    </div>

                    <div class="login-details-actions">
                      <button type="button" class="btn btn-dark btn-update-login">Update</button>
                      <a href="manage_project.html" class="btn btn-label-secondary btn-cancel-login">Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->


    <!-- City Modal -->
    <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="cityModalLabel">Add City</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="cityModalForm" novalidate>
              <label for="cityNameInput" class="form-label">City Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="cityNameInput" placeholder="Enter city name" required />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveCityBtn">Add City</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Hospital Modal -->
    <div class="modal fade" id="hospitalModal" tabindex="-1" aria-labelledby="hospitalModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="hospitalModalLabel">Add Hospital</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="hospitalModalForm" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="hospitalNameInput" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="hospitalNameInput" placeholder="Enter hospital name" required />
                </div>
                <div class="col-md-6">
                  <label for="hospitalContactInput" class="form-label">Hospital Contact <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" id="hospitalContactInput" placeholder="Enter contact number" required />
                </div>
                <div class="col-md-6">
                  <label for="hospitalEmailInput" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="hospitalEmailInput" placeholder="Enter email" required />
                </div>
                <div class="col-md-6">
                  <label for="hospitalCityInput" class="form-label">City <span class="text-danger">*</span></label>
                  <select class="form-select" id="hospitalCityInput" required>
                    <option value="" selected>Select city</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="hospitalTagStartInput" class="form-label">Tag Number Start <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="hospitalTagStartInput" placeholder="Enter tag number start" required />
                </div>
                <div class="col-md-6">
                  <label for="hospitalTagEndInput" class="form-label">Tag Number End <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="hospitalTagEndInput" placeholder="Enter tag number end" required />
                </div>
                <div class="col-md-6">
                  <label for="hospitalNetQtyInput" class="form-label">Catching Net Quantity <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="hospitalNetQtyInput" min="0" placeholder="Enter catching net quantity" required />
                </div>
                <div class="col-12">
                  <label for="hospitalAddressInput" class="form-label">Address <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="hospitalAddressInput" rows="3" placeholder="Enter hospital address" required></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveHospitalBtn">Add Hospital</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Vehicle Modal -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="vehicleModalLabel">Add Vehicle</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="vehicleModalForm" novalidate>
              <div class="row g-3">
                <div class="col-12">
                  <label for="vehicleCityInput" class="form-label">City <span class="text-danger">*</span></label>
                  <select class="form-select" id="vehicleCityInput" required>
                    <option value="" selected>Select city</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="vehicleHospitalInput" class="form-label">Hospital <span class="text-danger">*</span></label>
                  <select class="form-select" id="vehicleHospitalInput" required>
                    <option value="" selected>Select hospital</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="vehicleNumberPlateInput" class="form-label">Vehicle Number Plate <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="vehicleNumberPlateInput" placeholder="Enter vehicle number plate" required />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveVehicleBtn">Add Vehicle</button>
          </div>
        </div>
      </div>
    </div>

    <!-- NGO Modal -->
    <div class="modal fade" id="ngoModal" tabindex="-1" aria-labelledby="ngoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="ngoModalLabel">Add NGO</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="ngoModalForm" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="ngoNameInput" class="form-label">NGO Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="ngoNameInput" placeholder="Enter NGO name" required />
                </div>
                <div class="col-md-6">
                  <label for="ngoContactInput" class="form-label">NGO Contact <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" id="ngoContactInput" placeholder="Enter contact number" required />
                </div>
                <div class="col-md-6">
                  <label for="ngoEmailInput" class="form-label">NGO Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="ngoEmailInput" placeholder="Enter email" required />
                </div>
                <div class="col-md-6">
                  <label for="ngoCityInput" class="form-label">NGO City <span class="text-danger">*</span></label>
                  <select class="form-select" id="ngoCityInput" required>
                    <option value="" selected>Select city</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="ngoAddressInput" class="form-label">NGO Address <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="ngoAddressInput" rows="3" placeholder="Enter NGO address" required></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveNgoBtn">Save NGO</button>
          </div>
        </div>
      </div>
    </div>

     @endsection

    