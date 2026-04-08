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
        padding: 1rem 1rem 0.95rem;
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
        margin-bottom: 0.25rem;
      }

      .arv-form-grid {
        row-gap: 0.3rem !important;
      }

      .switch-col {
        display: flex;
        align-items: flex-end;
      }

      .switch-panel {
        min-height: 2.55rem;
        border: 1px dashed #d8dde8;
        border-radius: 0.6rem;
        background: #f8faff;
        padding: 0.35rem 0.7rem;
        display: flex;
        align-items: center;
        width: 100%;
      }

      .switch-panel .form-check {
        margin: 0;
      }

      .switch-panel .form-check-label {
        color: #374151;
        font-size: 1rem;
      }

      .switch-panel .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
      }

      .project-list-card .form-control,
      .project-list-card .form-select {
        min-height: 2.75rem;
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
        min-height: 2.55rem;
        font-weight: 600;
      }

      .project-list-card form {
        padding-bottom: 0.35rem;
      }

      .arv-image-dropzone {
        position: relative;
        width: min(100%, 420px);
        min-height: 240px;
        border: 2px dashed #c7cfdd !important;
        border-radius: 0.85rem;
        background: linear-gradient(145deg, #f8fafc 0%, #eef2f7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        transition: all 0.25s ease;
      }

      .arv-image-dropzone:hover,
      .arv-image-dropzone.dz-drag-hover {
        border-color: #45ab97 !important;
        background: linear-gradient(145deg, #f4fdfb 0%, #e8f7f3 100%);
        box-shadow: 0 0.35rem 1rem rgba(69, 171, 151, 0.2);
      }

      .arv-image-dropzone .arv-upload-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.45rem;
      }

      .arv-image-dropzone .arv-upload-icon {
        font-size: 2.4rem;
        color: #45ab97;
      }

      .arv-image-dropzone .arv-upload-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #364152;
      }

      .arv-image-dropzone .arv-upload-subtitle {
        font-size: 0.78rem;
        color: #6b7280;
      }

      .arv-image-dropzone .dz-preview {
        margin: 0;
        width: 100%;
        min-height: 208px;
      }

      .arv-image-dropzone .dz-preview .dz-image {
        width: 100%;
        height: 208px;
        border-radius: 0.65rem;
        overflow: hidden;
      }

      .arv-image-dropzone .dz-preview .dz-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .arv-image-dropzone .dz-preview .dz-remove {
        position: absolute;
        top: 0.7rem;
        right: 0.7rem;
        z-index: 12;
        background-color: rgba(17, 24, 39, 0.72);
        color: #ffffff;
        border-radius: 0.45rem;
        padding: 0.32rem 0.55rem;
        font-size: 0.72rem;
        text-decoration: none;
      }

      .arv-image-dropzone.has-preview .arv-upload-prompt {
        display: none;
      }

      .arv-image-dropzone.dz-started .dz-message {
        display: none;
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

        .arv-image-dropzone {
          width: 100%;
          min-height: 200px;
        }

        .arv-image-dropzone .dz-preview,
        .arv-image-dropzone .dz-preview .dz-image {
          height: 180px;
          min-height: 180px;
        }
      }
    </style>
  @endpush
    <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-project-head-card">
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-syringe"></i> Add ARV</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-arv') }}">Manage ARV</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('add-arv') }}">Add ARV</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-arv') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                  </a>
                </div>

                <div class="card project-list-card" id="project-information-card">
                  <div class="card-header">
                    <h4 class="card-title">ARV Information</h4>
                  </div>
                  <div class="card-body">
                    
                    <form>
                      <div class="row g-2 arv-form-grid">
                        <div class="col-md-6">
                          <label class="form-label" for="arvImage">Image <span class="text-danger">*</span></label>
                          <div class="dropzone arv-image-dropzone" id="arvImageDropzone" data-target-input="#arvImage" data-folder="arv-dogs">
                            <div class="arv-upload-prompt">
                              <i class="bx bx-cloud-upload arv-upload-icon"></i>
                              <span class="arv-upload-title">Click to upload or drag and drop</span>
                              <small class="arv-upload-subtitle">Recommended: square image, max 5MB</small>
                            </div>
                          </div>
                          <input type="hidden" id="arvImage" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="rfid">RFID <span class="text-danger">*</span></label>
                          <input type="text" id="rfid" class="form-control" placeholder="Enter RFID" />
                        </div>

                        <div class="col-md-6 switch-col">
                          <div class="switch-panel">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="arvCheck" checked />
                            <label class="form-check-label fw-semibold" for="arvCheck">ARV</label>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvDate">ARV Date </label>
                          <input type="date" id="arvDate" class="form-control" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvHospital">Hospital <span class="text-danger">*</span></label>
                          <select id="arvHospital" class="form-select">
                            <option value="" selected>Select hospital</option>
                            <option>City Civil Hospital</option>
                            <option>Shree Health Center</option>
                            <option>Apollo Care Center</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="subProject">Sub Project <span class="text-danger">*</span></label>
                          <select id="subProject" class="form-select">
                            <option value="" selected>Select sub project</option>
                            <option>ABC-Urban ARV</option>
                            <option>Ward-5 Sterilization</option>
                            <option>NGO Outreach Drive</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="arvStaff">ARV Staff <span class="text-danger">*</span></label>
                          <select id="arvStaff" class="form-select">
                            <option value="" selected>Select ARV staff</option>
                            <option>Rahul Prajapati</option>
                            <option>Pooja Shah</option>
                            <option>Amit Solanki</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="vaccinator">Vaccinator <span class="text-danger">*</span></label>
                          <select id="vaccinator" class="form-select">
                            <option value="" selected>Select vaccinator</option>
                            <option>Dr. Nisha Patel</option>
                            <option>Dr. Amit Soni</option>
                            <option>Dr. Rakesh Modi</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogColor">Color <span class="text-danger">*</span></label>
                          <select id="dogColor" class="form-select">
                            <option value="" selected>Select color</option>
                            <option>Black</option>
                            <option>Brown</option>
                            <option>White</option>
                            <option>Mixed</option>
                          </select>
                        </div>

                        <div class="col-md-6 switch-col">
                          <div class="switch-panel">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="medicareCheck" />
                            <label class="form-check-label fw-semibold" for="medicareCheck">Medicare</label>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 d-none" id="underProjectWrap">
                          <label class="form-label" for="underProject">Under Project <span class="text-danger">*</span></label>
                          <select id="underProject" class="form-select">
                            <option value="" selected>Select under project</option>
                            <option>Rescue Camp - North Zone</option>
                            <option>Street Care Mission</option>
                            <option>Emergency Medicare Task</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="note">Note</label>
                          <textarea id="note" class="form-control" rows="3" placeholder="Add note"></textarea>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="address">Address</label>
                          <input type="text" id="address" class="form-control" autocomplete="off" placeholder="Enter address manually" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="address2">Address 2</label>
                          <input type="text" id="address2" class="form-control" autocomplete="off" placeholder="Enter address 2 manually" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogDob">Dog DOB</label>
                          <input type="date" id="dogDob" class="form-control" />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogAge">Age</label>
                          <input type="text" id="dogAge" class="form-control" placeholder="Age will be calculated" readonly />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogStage">Dog Category</label>
                          <select id="dogStage" class="form-select">
                            <option value="" selected>Select category</option>
                            <option>Pup</option>
                            <option>Adult</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogGender">Gender</label>
                          <select id="dogGender" class="form-select">
                            <option value="" selected>Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label" for="dogType">Ownership</label>
                          <select id="dogType" class="form-select">
                            <option value="" selected>Select type</option>
                            <option>Stray</option>
                            <option>Owner</option>
                          </select>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Map</label>
                          <div class="ratio ratio-21x9 border rounded">
                            <iframe
                              title="Dog location map"
                              src="https://maps.google.com/maps?q=21.1702,72.8311&z=14&output=embed"
                              loading="lazy"
                              referrerpolicy="no-referrer-when-downgrade"></iframe>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex flex-wrap gap-2 mt-3 form-action-row">
                        <button type="submit" class="btn bg-black text-white">Add ARV</button>
                        <a href="manage_arv.html" class="btn btn-label-secondary">Cancel</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
    <!-- / Content -->

            <!-- Hospital Modal -->
    <div class="modal fade" id="hospitalModal" tabindex="-1" aria-labelledby="hospitalModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header p-3">
            <h5 class="modal-title" id="hospitalModalLabel">Add Hospital</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="hospitalModalForm" novalidate>
              <label for="hospitalNameInput" class="form-label">Hospital Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="hospitalNameInput" placeholder="Enter hospital name" required />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveHospitalBtn">Add Hospital</button>
          </div>
        </div>
      </div>
    </div>

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
@endsection

@push('scripts')
    <script>
      (function () {
        var medicareCheck = document.getElementById('medicareCheck');
        var underProjectWrap = document.getElementById('underProjectWrap');
        var dogDobInput = document.getElementById('dogDob');
        var dogAgeInput = document.getElementById('dogAge');

        function toggleUnderProject() {
          if (!medicareCheck || !underProjectWrap) return;
          underProjectWrap.classList.toggle('d-none', !medicareCheck.checked);
        }

        function updateAge() {
          if (!dogDobInput || !dogAgeInput || !dogDobInput.value) {
            if (dogAgeInput) dogAgeInput.value = '';
            return;
          }

          var dob = new Date(dogDobInput.value);
          var today = new Date();
          var years = today.getFullYear() - dob.getFullYear();
          var monthDiff = today.getMonth() - dob.getMonth();

          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            years--;
          }

          dogAgeInput.value = years >= 0 ? years + ' years' : '';
        }

        if (medicareCheck) {
          medicareCheck.addEventListener('change', toggleUnderProject);
          toggleUnderProject();
        }

        if (dogDobInput) {
          dogDobInput.addEventListener('change', updateAge);
        }
      })();
    </script>
    
@endpush