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

      .city-top-bar {
        padding: 12px 1.5rem;
        border-bottom: 1px solid #e9edf3;
      }

      .city-top-bar .page-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .city-top-bar .page-subtitle {
        font-size: 1rem;
        margin-bottom: 0;
      }

      .city-top-bar .btn {
        min-width: 185px;
      }

      .manage-city-head-card {
        background-color: #ffffff;
        border: 1px solid #dfe3eb;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        margin-bottom: 1rem;
      }

      .manage-city-head-card .city-top-bar {
        border-bottom: 0;
      }

      .manage-city-head-card .city-list-card {
        margin: 0 1rem 1rem;
      }

      .city-list-card .card-header {
        background-color: #0f0f13 !important;
        color: #ffffff !important;
        border-bottom: 0;
        padding: 1rem 1.25rem;
      }

      .city-list-card {
        background-color: #ffffff !important;
        border: 2px solid #000000;
        border-radius: 0.9rem;
        box-shadow: 0 0.2rem 0.8rem rgba(67, 89, 113, 0.08);
        overflow: hidden;
      }

      .city-list-card .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #ffffff !important;
      }

      .city-list-card .table td,
      .city-list-card .table th {
        vertical-align: middle;
      }

      #manage-city-table {
        margin-bottom: 0;
      }

      #manage-city-table thead th {
        font-size: 0.84rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #4b5563;
        white-space: nowrap;
        border-bottom-width: 1px;
      }

      #manage-city-table tbody td {
        font-size: 0.95rem;
        color: #4b5563;
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
      }

      #manage-city-table tbody tr {
        transition: background-color 0.2s ease;
      }

      #manage-city-table tbody tr:hover {
        background-color: #f7f9fc;
      }

      .page-title{
        color: black;
      }
      .addbtn{
        background-color: black;
      }
      .city-image {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 0.4rem;
        border: 1px solid #e5e7eb;
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

      #manage-city-table_wrapper .page-item.active .page-link {
        background-color: #0f0f13 !important;
        border-color: #0f0f13 !important;
        color: #ffffff !important;
      }

      #manage-city-table_wrapper .page-item.active .page-link:hover,
      #manage-city-table_wrapper .page-item.active .page-link:focus {
        background-color: #0a0a0d !important;
        border-color: #0a0a0d !important;
        color: #ffffff !important;
      }

      .modal-header-black {
        background-color: #000000;
        color: #ffffff;
      }

      .modal-header-black .btn-close {
        
        background-color: #e8e7e7 !important;
        border: 0 !important;
        box-shadow: none !important;
        margin-left: auto;
        opacity: 1 !important;
        filter: none !important;
      }

      .city-image-preview {
        max-height: 160px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        object-fit: cover;
        display: block;
        margin-top: 0.5rem;
      }

      @media (max-width: 767.98px) {
        .city-top-bar {
          padding: 0.9rem 1rem;
        }

        .city-top-bar .page-title {
          font-size: 1.3rem;
        }

        .manage-city-head-card .city-list-card {
          margin: 0 0.75rem 0.75rem;
        }
      }
    </style>
    
@endpush
             <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card manage-city-head-card">
                <div class="city-top-bar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <div>
                    <h2 class="page-title d-flex align-items-center gap-2"><i class="fa-solid fa-city"></i> Manage City</h2>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('manage-city') }}">Manage City</a></li>
                      </ol>
                    </nav>
                  </div>
                  @can('add city')
                  <button type="button" id="add-city-btn" class="addbtn btn btn-dark" data-bs-toggle="modal" data-bs-target="#cityModal">
                    <i class="fa-solid fa-plus me-1"></i> Add City
                  </button>
                  @endcan
                </div>
                <div class="card city-list-card">
                  <div class="card-header">
                    <h4 class="card-title">City List</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="manage-city-table" class="table table-striped border-top">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Date</th>
                            @canany(['edit city', 'delete city'])
                            <th>Action</th>
                            @endcanany
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="cityModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header modal-header-black p-3">
                      <h5 class="modal-title text-white" id="cityModalTitle">Add City</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="cityForm">
                      <div class="modal-body">
                        <input type="hidden" id="cityId" name="id" />
                        <div class="mb-3">
                          <label for="cityTitle" class="form-label">Title<span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="cityTitle" name="city_name" placeholder="Enter city title" required />
                        </div>
                        <div class="mb-0">
                          <label for="cityImage" class="form-label">Image</label>
                          <input type="file" class="form-control" id="cityImage" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" />
                          <img id="cityImagePreview" class="city-image-preview" src="" alt="Preview" style="display:none;" />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark" id="citySubmitBtn">Add City</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
        @push('scripts')
        <script>
        $(function () {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          var table = $('#manage-city-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manage-city') }}",
            columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              { data: 'image', name: 'image', orderable: false, searchable: false },
              { data: 'city_name', name: 'city_name' },
              { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
              { data: 'created_at', name: 'created_at' }
              @canany(['edit city', 'delete city'])
              ,{ data: 'action', name: 'action', orderable: false, searchable: false }
              @endcanany
            ]
          });

          function resetCityModal() {
            $('#cityForm')[0].reset();
            $('#cityId').val('');
            $('#cityModalTitle').text('Add City');
            $('#citySubmitBtn').text('Add City');
            $('#cityImagePreview').attr('src', '').hide();
          }

          $('#cityImage').on('change', function () {
            var file = this.files[0];
            if (file) {
              var reader = new FileReader();
              reader.onload = function (e) {
                $('#cityImagePreview').attr('src', e.target.result).show();
              };
              reader.readAsDataURL(file);
            } else {
              $('#cityImagePreview').attr('src', '').hide();
            }
          });

          $('#cityForm').on('submit', function (e) {
            e.preventDefault();

            var cityId = $('#cityId').val();
            var isEdit = cityId !== '';
            var url = isEdit ? "{{ url('manage-city') }}/" + cityId : "{{ url('manage-city') }}";
            var formData = new FormData(this);

            if (isEdit) {
              formData.append('_method', 'PUT');
            }

            $.ajax({
              url: url,
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                showToast('success', response.message);
                $('#cityModal').modal('hide');
                table.ajax.reload(null, false);
              },
              error: function (xhr) {
                var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
                var messages = [];

                $.each(errors, function (key, value) {
                  messages = messages.concat(value);
                });

                showToast('error', messages.join('\n') || 'Something went wrong.');
              }
            });
          });

          $(document).on('click', '.item-edit', function () {
            var cityImage = $(this).data('image') || '';

            $('#cityId').val($(this).data('id'));
            $('#cityTitle').val($(this).data('name'));
            $('#cityModalTitle').text('Edit City');
            $('#citySubmitBtn').text('Update City');

            if (cityImage) {
              $('#cityImagePreview').attr('src', "{{ url('/') }}/" + cityImage).show();
            } else {
              $('#cityImagePreview').attr('src', '').hide();
            }

            $('#cityModal').modal('show');
          });

          $(document).on('click', '.item-delete', function () {
            var cityId = $(this).data('id');

            confirmDelete(function () {
              $.ajax({
                url: "{{ url('manage-city') }}/" + cityId,
                method: 'POST',
                data: { _method: 'DELETE' },
                success: function (response) {
                  showToast('success', response.message);
                  table.ajax.reload(null, false);
                },
                error: function () {
                  showToast('error', 'Something went wrong!');
                }
              });
            });
          });

          $(document).on('change', '.toggle-status', function () {
            var cityId = $(this).data('id');

            $.ajax({
              url: "{{ url('manage-city') }}/" + cityId + "/toggle-status",
              method: 'POST',
              data: { _method: 'PATCH' },
              success: function (response) {
                showToast('success', response.message);
                table.ajax.reload(null, false);
              },
              error: function () {
                showToast('error', 'Something went wrong!');
                table.ajax.reload(null, false);
              }
            });
          });

          $('#cityModal').on('hidden.bs.modal', function () {
            resetCityModal();
          });
        });
        </script>
        @endpush
@endsection