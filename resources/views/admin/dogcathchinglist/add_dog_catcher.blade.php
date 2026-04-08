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

      .dog-catcher-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .dog-catcher-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .dog-catcher-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .dog-catcher-top-bar .btn {
        min-width: 140px;
        background-color: #7d8da1;
        border-color:#7d8da1;
        color: #ffffff;
      }

      .dog-catcher-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .dog-catcher-head-card .dog-catcher-table-card {
        margin: 0 1rem 1rem;
      }

      .dog-catcher-table-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .dog-catcher-table-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .dog-catcher-table-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .dog-catcher-table-card .table td,
      .dog-catcher-table-card .table th {
        vertical-align: middle;
      }

      #dog-catcher-table {
        margin-bottom: 0;
      }

      #dog-catcher-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #ffffff;
        background-color: #000000;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #dog-catcher-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #dog-catcher-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #dog-catcher-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title {
        color: black;
      }

      .addbtn {
        background-color: black;
      }

      .table-folder {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-weight: 500;
        color: #0f0f13;
      }

      .table-action-btn {
        min-width: 90px;
      }

      #dog-catcher-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #dog-catcher-table_wrapper .page-item.active .page-link:hover,
      #dog-catcher-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      .dog-image-dropzone {
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

      .dog-image-dropzone:hover,
      .dog-image-dropzone.dz-drag-hover {
        border-color: #45ab97 !important;
        background: linear-gradient(145deg, #f4fdfb 0%, #e8f7f3 100%);
        box-shadow: 0 0.35rem 1rem rgba(69, 171, 151, 0.2);
      }

      .dog-image-dropzone .dog-upload-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.45rem;
      }

      .dog-image-dropzone .dog-upload-icon {
        font-size: 2.4rem;
        color: #45ab97;
      }

      .dog-image-dropzone .dog-upload-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #364152;
      }

      .dog-image-dropzone .dog-upload-subtitle {
        font-size: 0.78rem;
        color: #6b7280;
      }

      .dog-image-dropzone .dz-preview {
        margin: 0;
        width: 100%;
        min-height: 208px;
      }

      .dog-image-dropzone .dz-preview .dz-image {
        width: 100%;
        height: 208px;
        border-radius: 0.65rem;
        overflow: hidden;
      }

      .dog-image-dropzone .dz-preview .dz-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .dog-image-dropzone .dz-preview .dz-remove {
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

      .dog-image-dropzone.has-preview .dog-upload-prompt {
        display: none;
      }

      .dog-image-dropzone.dz-started .dz-message {
        display: none;
      }

      @media (max-width: 767.98px) {
        .dog-catcher-top-bar {
          padding: 0.9rem 1rem;
        }

        .dog-catcher-top-bar .page-title {
          font-size: 1.3rem;
        }

        .dog-catcher-head-card .dog-catcher-table-card {
          margin: 0 0.75rem 0.75rem;
        }

        .dog-image-dropzone {
          width: 100%;
          min-height: 200px;
        }

        .dog-image-dropzone .dz-preview,
        .dog-image-dropzone .dz-preview .dz-image {
          height: 180px;
          min-height: 180px;
        }
      }
    </style>
@endpush    

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card dog-catcher-head-card">
                <div class="dog-catcher-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-dog"></i> Add Dog Catcher</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb page-subtitle mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manage-dog-catcher') }}">Dog Catcher</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('add-dog-catcher') }}">Add Dog Catcher</a></li>
                      </ol>
                    </nav>
                  </div>
                  <a href="{{ route('manage-dog-catcher') }}" class="btn btn-outline-dark d-flex align-items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Back
                  </a>
                </div>
                <div class="card dog-catcher-table-card">
                  <div class="card-header">
                    <h4 class="card-title">Add New Catch Entry</h4>
                  </div>
                <div class="card-body">
                  <form class="row g-3">
                    <div class="col-12">
                      <label class="form-label" for="addAddress">Address<span class="text-danger">*</span></label>
                      <textarea id="addAddress" class="form-control" rows="3" placeholder="Enter the capture address"></textarea>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="hospitalSelect">Hospital<span class="text-danger">*</span></label>
                      <select id="hospitalSelect" class="form-select">
                        <option selected>Select hospital</option>
                        <option>City Animal Hospital</option>
                        <option>SafePaws Clinic</option>
                        <option>Healthy Tails Center</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="projectSelect">Project<span class="text-danger">*</span></label>
                      <select id="projectSelect" class="form-select">
                        <option selected>Select project</option>
                        <option>Urban Rescue</option>
                        <option>Spay &amp; Neuter Drive</option>
                        <option>Community Vaccination</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="tagNo">Tag No<span class="text-danger">*</span></label>
                      <input id="tagNo" type="text" class="form-control" placeholder="e.g. DC-1023" />
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="catchDate">Date<span class="text-danger">*</span></label>
                      <input id="catchDate" type="date" class="form-control" />
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="dogCatcherStaff">Dog Catcher Staff<span class="text-danger">*</span></label>
                      <select id="dogCatcherStaff" class="form-select">
                        <option selected>Select staff</option>
                        <option>Ravi Kumar</option>
                        <option>Priya Nair</option>
                        <option>Samir Shah</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="vehicleSelectAdd">Vehicle</label>
                      <select id="vehicleSelectAdd" class="form-select">
                        <option selected>Select vehicle</option>
                        <option>Van - 12 Seater</option>
                        <option>Bike - Royal Enfield</option>
                        <option>Car - SUV</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="genderSelect">Gender<span class="text-danger">*</span></label>
                      <select id="genderSelect" class="form-select">
                        <option selected>Male</option>
                        <option>Female</option>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="streetField">Street<span class="text-danger">*</span></label>
                      <input id="streetField" type="text" class="form-control" placeholder="Enter street name" />
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <label class="form-label" for="ownerField">Owner<span class="text-danger">*</span></label>
                      <input id="ownerField" type="text" class="form-control" placeholder="Owner name" />
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label" for="imageUpload">Image (File Folder)<span class="text-danger">*</span></label>
                      <div class="dropzone dog-image-dropzone" id="dogImageDropzone" data-target-input="#imageUpload" data-folder="dogs">
                        <div class="dog-upload-prompt">
                          <i class="bx bx-cloud-upload dog-upload-icon"></i>
                          <span class="dog-upload-title">Click to upload or drag and drop</span>
                          <small class="dog-upload-subtitle">Recommended: square image, max 5MB</small>
                        </div>
                      </div>
                      <input type="hidden" id="imageUpload" />
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <label class="form-label">Map</label>
                      <div class="ratio ratio-4x3 rounded overflow-hidden border">
                        <iframe
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14006.095230438797!2d77.2090185!3d28.6139391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd33b8c5f1cf%3A0x35c8629f4e9331d1!2sNew%20Delhi!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
                          frameborder="0"
                          allowfullscreen=""
                          aria-hidden="false"
                          tabindex="0"
                          loading="lazy"
                          referrerpolicy="no-referrer-when-downgrade"></iframe>
                      </div>
                    </div>
                    <div class="col-12 text-end">
                      <button type="submit" class="btn btn-dark">Save Catch Entry</button>
                    </div>
                  </form>
                </div>
                </div>
              </div>            <!-- / Content -->
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

                    <a
                      href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                      target="_blank"
                      class="footer-link me-4"
                      >Documentation</a
                    >

                    <a
                      href="https://themeselection.com/support/"
                      target="_blank"
                      class="footer-link d-none d-sm-inline-block"
                      >Support</a
                    >
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          
          <!-- Content -->
@endsection