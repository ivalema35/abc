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
        padding: 14px 1.5rem 12px;
      }

      .page-title {
        color: #000000;
        font-size: 1.65rem;
        margin-bottom: 0.2rem;
      }

      .manage-project-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
        overflow: hidden;
      }

      .settings-forms-wrapper {
        padding: 0 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
      }

      .settings-form-card {
        background-color: #ffffff;
        border: 2px solid #1e1e22;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .settings-form-card .form-card-header {
        background-color: #0f0f13;
        color: #ffffff;
        padding: 0.9rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
      }

      .settings-form-card .form-card-header h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #ffffff;
      }

      .settings-form-card .form-card-header .header-icon {
        width: 2.2rem;
        height: 2.2rem;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 0.45rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
      }

      .settings-form-card .form-card-body {
        padding: 1.6rem 1.4rem 1.4rem;
      }

      .settings-form-card .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #3f4a59;
        margin-bottom: 0.45rem;
      }

      .settings-form-card .form-control,
      .settings-form-card .form-select {
        min-height: 3rem;
        font-size: 1rem;
        border-color: #d8dde8;
        border-radius: 0.5rem;
      }

      .settings-form-card .form-control:focus,
      .settings-form-card .form-select:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15);
      }

      .settings-form-card textarea.form-control {
        min-height: 7.5rem;
        resize: vertical;
      }

      .upload-area {
        border: 2px dashed #c8cfe0;
        border-radius: 0.6rem;
        padding: 1.2rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #f9fafb;
        position: relative;
      }

      .upload-area:hover {
        border-color: #696cff;
        background: #f4f4ff;
      }

      .upload-area input[type='file'] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
      }

      .upload-area .upload-icon {
        font-size: 1.8rem;
        color: #696cff;
        margin-bottom: 0.45rem;
      }

      .upload-area .upload-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #3f4a59;
        margin-bottom: 0.15rem;
      }

      .upload-area .upload-hint {
        font-size: 0.8rem;
        color: #8592a3;
      }

      .upload-preview {
        display: none;
        margin-top: 0.7rem;
        align-items: center;
        gap: 0.7rem;
        padding: 0.55rem 0.75rem;
        background: #f0f0ff;
        border-radius: 0.5rem;
        border: 1px solid #d0d0ff;
      }

      .upload-preview.show {
        display: flex;
      }

      .upload-preview img {
        width: 3rem;
        height: 3rem;
        object-fit: cover;
        border-radius: 0.35rem;
        border: 1px solid #c8cfe0;
      }

      .upload-preview .preview-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: #3f4a59;
        word-break: break-all;
      }

      .upload-preview .preview-remove {
        margin-left: auto;
        background: none;
        border: none;
        color: #ea5455;
        font-size: 1rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
      }

      .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.65rem;
        margin-top: 1.5rem;
        padding-top: 1.1rem;
        border-top: 1px solid #eef0f4;
      }

      .form-actions .btn {
        min-width: 130px;
        min-height: 2.75rem;
        font-weight: 600;
        font-size: 0.95rem;
      }

      .btn-save-settings {
        background-color: #0f0f13;
        border-color: #0f0f13;
        color: #ffffff;
      }

      .btn-save-settings:hover,
      .btn-save-settings:focus {
        background-color: #2d2d38;
        border-color: #2d2d38;
        color: #ffffff;
      }

      .req {
        color: #ea5455;
      }

      .invalid-feedback.d-block {
        font-size: 0.85rem;
      }

      .settings-toast-wrap {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1080;
      }

      .card-body {
        padding-top: 27px !important;
      }

      @media (max-width: 767.98px) {
        .project-top-bar {
          padding: 0.9rem 1rem;
        }

        .settings-forms-wrapper {
          padding: 0 0.75rem 1rem;
        }

        .page-title {
          font-size: 1.35rem;
        }

        .settings-form-card .form-card-body {
          padding: 1.1rem 1rem 1rem;
        }
      }
    </style>
@endpush

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="settings-toast-wrap">
                <div id="settingsSuccessToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
                  <div class="d-flex">
                    <div class="toast-body" id="settingsSuccessToastBody">Settings saved successfully.</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                </div>
              </div>

              <div class="card manage-project-head-card">
                <div class="project-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2">
                      <i class="fa-solid fa-gear"></i> Settings
                    </h2>
                    <nav aria-label="breadcrumb" class="view-head-breadcrumb">
                      <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('settings.index') }}">Setting</a></li>
                      </ol>
                    </nav>
                  </div>
                </div>

                <div class="settings-forms-wrapper">
                  <div class="settings-form-card">
                    <div class="form-card-header">
                      <div class="header-icon"><i class="fa-solid fa-circle-info"></i></div>
                      <h4>Basic Details</h4>
                    </div>
                    <div class="form-card-body">
                      <form id="formBasicDetails" action="{{ route('settings.basic') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row g-4">
                          <div class="col-md-6">
                            <label class="form-label" for="bd_title">Title </label>
                            <input type="text" id="bd_title" name="bd_title" class="form-control" value="{{ old('bd_title', $setting->bd_title) }}" placeholder="Enter organisation title" />
                            <div class="invalid-feedback d-block" id="bd_title_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="bd_logo">Logo <span class="req">*</span></label>
                            <div class="upload-area" id="uploadArea1">
                              <input type="file" id="bd_logo" name="bd_logo" accept="image/*" onchange="handleUpload(this, 'preview1')" />
                              <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                              <div class="upload-label">Click to upload image</div>
                              <div class="upload-hint">PNG, JPG, WEBP up to 5 MB</div>
                            </div>
                            <div class="upload-preview {{ $setting->bd_logo ? 'show' : '' }}" id="preview1" data-existing-src="{{ $setting->bd_logo ? asset($setting->bd_logo) : '' }}" data-existing-name="{{ $setting->bd_logo ? basename($setting->bd_logo) : '' }}">
                              <img id="preview1Img" src="{{ $setting->bd_logo ? asset($setting->bd_logo) : '#' }}" alt="preview" />
                              <span class="preview-name" id="preview1Name">{{ $setting->bd_logo ? basename($setting->bd_logo) : '' }}</span>
                              <button type="button" class="preview-remove" onclick="removeUpload('bd_logo', 'preview1')" title="Remove">
                                <i class="fa-solid fa-xmark"></i>
                              </button>
                            </div>
                            <div class="invalid-feedback d-block" id="bd_logo_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="bd_email">Email </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-envelope text-muted"></i></span>
                              <input type="email" id="bd_email" name="bd_email" class="form-control border-0 ps-0 shadow-none" value="{{ old('bd_email', $setting->bd_email) }}" placeholder="organisation@example.com" />
                            </div>
                            <div class="invalid-feedback d-block" id="bd_email_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="bd_contact">Contact </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-phone text-muted"></i></span>
                              <input type="tel" id="bd_contact" name="bd_contact" class="form-control border-0 ps-0 shadow-none" value="{{ old('bd_contact', $setting->bd_contact) }}" placeholder="+91 00000 00000" />
                            </div>
                            <div class="invalid-feedback d-block" id="bd_contact_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="bd_address">Address </label>
                            <textarea id="bd_address" name="bd_address" class="form-control" rows="3" placeholder="Enter full address">{{ old('bd_address', $setting->bd_address) }}</textarea>
                            <div class="invalid-feedback d-block" id="bd_address_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="bd_location">Location </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-location-dot text-muted"></i></span>
                              <input type="text" id="bd_location" name="bd_location" class="form-control border-0 ps-0 shadow-none" value="{{ old('bd_location', $setting->bd_location) }}" placeholder="City / State / Country" />
                            </div>
                            <div class="invalid-feedback d-block" id="bd_location_error"></div>
                          </div>

                          <div class="col-md-12">
                            <label class="form-label" for="bd_support_mail">Admin Support Mail </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-headset text-muted"></i></span>
                              <input type="email" id="bd_support_mail" name="bd_support_mail" class="form-control border-0 ps-0 shadow-none" value="{{ old('bd_support_mail', $setting->bd_support_mail) }}" placeholder="support@example.com" />
                            </div>
                            <div class="invalid-feedback d-block" id="bd_support_mail_error"></div>
                          </div>
                        </div>

                        <div class="form-actions">
                          <button type="reset" class="btn btn-label-secondary">Reset</button>
                          @can('edit settings')
                          <button type="submit" class="btn btn-save-settings" id="saveBasicBtn">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Basic Details
                          </button>
                          @endcan
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="settings-form-card">
                    <div class="form-card-header" style="background-color: #1a1a2e">
                      <div class="header-icon"><i class="fa-solid fa-message"></i></div>
                      <h4>SMS Details</h4>
                    </div>
                    <div class="form-card-body">
                      <form id="formSmsDetails" action="{{ route('settings.sms') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row g-4">
                          <div class="col-md-6">
                            <label class="form-label" for="sms_meta">Meta </label>
                            <input type="text" id="sms_meta" name="sms_meta" class="form-control" value="{{ old('sms_meta', $setting->sms_meta) }}" placeholder="Enter SMS meta / sender ID" />
                            <div class="invalid-feedback d-block" id="sms_meta_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="sms_logo">Logo <span class="req">*</span></label>
                            <div class="upload-area" id="uploadArea2">
                              <input type="file" id="sms_logo" name="sms_logo" accept="image/*" onchange="handleUpload(this, 'preview2')" />
                              <div class="upload-icon"><i class="fa-solid fa-image"></i></div>
                              <div class="upload-label">Click to upload image</div>
                              <div class="upload-hint">PNG, JPG, WEBP up to 5 MB</div>
                            </div>
                            <div class="upload-preview {{ $setting->sms_logo ? 'show' : '' }}" id="preview2" data-existing-src="{{ $setting->sms_logo ? asset($setting->sms_logo) : '' }}" data-existing-name="{{ $setting->sms_logo ? basename($setting->sms_logo) : '' }}">
                              <img id="preview2Img" src="{{ $setting->sms_logo ? asset($setting->sms_logo) : '#' }}" alt="preview" />
                              <span class="preview-name" id="preview2Name">{{ $setting->sms_logo ? basename($setting->sms_logo) : '' }}</span>
                              <button type="button" class="preview-remove" onclick="removeUpload('sms_logo', 'preview2')" title="Remove">
                                <i class="fa-solid fa-xmark"></i>
                              </button>
                            </div>
                            <div class="invalid-feedback d-block" id="sms_logo_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="sms_email">Email </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-envelope text-muted"></i></span>
                              <input type="email" id="sms_email" name="sms_email" class="form-control border-0 ps-0 shadow-none" value="{{ old('sms_email', $setting->sms_email) }}" placeholder="sms-service@example.com" />
                            </div>
                            <div class="invalid-feedback d-block" id="sms_email_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="sms_contact">Contact </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-phone text-muted"></i></span>
                              <input type="tel" id="sms_contact" name="sms_contact" class="form-control border-0 ps-0 shadow-none" value="{{ old('sms_contact', $setting->sms_contact) }}" placeholder="+91 00000 00000" />
                            </div>
                            <div class="invalid-feedback d-block" id="sms_contact_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="sms_address">Address </label>
                            <textarea id="sms_address" name="sms_address" class="form-control" rows="3" placeholder="Enter SMS service address">{{ old('sms_address', $setting->sms_address) }}</textarea>
                            <div class="invalid-feedback d-block" id="sms_address_error"></div>
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="sms_location">Location </label>
                            <div class="input-group" style="border: 1px solid #d8dde8; border-radius: 0.5rem; overflow: hidden">
                              <span class="input-group-text border-0 bg-transparent"><i class="fa-solid fa-location-dot text-muted"></i></span>
                              <input type="text" id="sms_location" name="sms_location" class="form-control border-0 ps-0 shadow-none" value="{{ old('sms_location', $setting->sms_location) }}" placeholder="City / State / Country" />
                            </div>
                            <div class="invalid-feedback d-block" id="sms_location_error"></div>
                          </div>
                        </div>

                        <div class="form-actions">
                          <button type="reset" class="btn btn-label-secondary">Reset</button>
                          @can('edit settings')
                          <button type="submit" class="btn btn-save-settings" id="saveSmsBtn" style="background-color: #1a1a2e; border-color: #1a1a2e">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save SMS Details
                          </button>
                          @endcan
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@push('scripts')
<script>
function showSettingsToast(message) {
  var toastElement = document.getElementById('settingsSuccessToast');
  var toastBody = document.getElementById('settingsSuccessToastBody');

  if (!toastElement || !toastBody || typeof bootstrap === 'undefined') {
    alert(message);
    return;
  }

  toastBody.textContent = message;
  bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 2000 }).show();
}

function setPreview(previewId, source, fileName) {
  var preview = document.getElementById(previewId);
  var image = document.getElementById(previewId + 'Img');
  var name = document.getElementById(previewId + 'Name');

  if (!preview || !image || !name) {
    return;
  }

  if (source) {
    image.src = source;
    name.textContent = fileName || '';
    preview.classList.add('show');
    return;
  }

  image.src = '#';
  name.textContent = '';
  preview.classList.remove('show');
}

function handleUpload(input, previewId) {
  if (!input.files || !input.files[0]) {
    return;
  }

  var file = input.files[0];
  var reader = new FileReader();

  reader.onload = function (event) {
    setPreview(previewId, event.target.result, file.name);
  };

  reader.readAsDataURL(file);
}

function removeUpload(inputId, previewId) {
  var input = document.getElementById(inputId);
  var preview = document.getElementById(previewId);

  if (input) {
    input.value = '';
  }

  if (preview) {
    preview.dataset.existingSrc = '';
    preview.dataset.existingName = '';
  }

  setPreview(previewId, '', '');
}

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  ['preview1', 'preview2'].forEach(function (previewId) {
    var preview = document.getElementById(previewId);
    if (preview && preview.dataset.existingSrc) {
      setPreview(previewId, preview.dataset.existingSrc, preview.dataset.existingName);
    }
  });

  function submitSettingsForm(formSelector, buttonSelector) {
    $(formSelector).on('submit', function (event) {
      event.preventDefault();

      $('.invalid-feedback').text('');
      $(buttonSelector).prop('disabled', true);

      var form = this;
      var formData = new FormData(form);

      $.ajax({
        url: $(form).attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          showSettingsToast(response.message || 'Settings saved successfully.');
        },
        error: function (xhr) {
          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            $.each(xhr.responseJSON.errors, function (key, value) {
              $('#' + key + '_error').text(value[0]);
            });
            return;
          }

          alert((xhr.responseJSON && xhr.responseJSON.message) || 'Unable to save settings.');
        },
        complete: function () {
          $(buttonSelector).prop('disabled', false);
        }
      });
    });
  }

  submitSettingsForm('#formBasicDetails', '#saveBasicBtn');
  submitSettingsForm('#formSmsDetails', '#saveSmsBtn');
});
</script>
@endpush

@endsection