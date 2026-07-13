@extends('backEnd.layout.master')
@section('title','Country & State Management')
@section('body')
    <div class="container-fluid pt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Country & State Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                <i class="fa fa-plus me-1"></i> Add New Country
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Country Name</th>
                        <th>Country Code</th>
                        <th>States Module</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{ $country->id }}</td>
                            <td class="fw-bold">{{ $country->name }}</td>
                            <td><span class="badge bg-secondary">{{ $country->code }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-dark open-state-modal"
                                        data-id="{{ $country->id }}"
                                        data-name="{{ $country->name }}">
                                    <i class="fa-solid fa-tree-city me-1"></i> States
                                    <span class="badge bg-primary ms-1 state-count-badge-{{ $country->id }}">{{ $country->states_count }}</span>
                                </button>
                            </td>
                            <td>
                                <span class="badge {{ $country->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $country->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editCountryModal{{ $country->id }}">Edit</button>
                                <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Country Modal -->
                        <div class="modal fade" id="editCountryModal{{ $country->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header"><h5>Edit Country</h5></div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $country->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Code</label>
                                                <input type="text" name="code" class="form-control" value="{{ $country->code }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{ $country->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$country->status ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $countries->links() }}</div>
    </div>

    <!-- Add Country Modal -->
    <div class="modal fade" id="addCountryModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.countries.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header"><h5>Add New Country</h5></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. United States" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country Code</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g. US" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Country</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Dynamic State Manager Modal -->
    <div class="modal fade" id="stateManagerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">States / Regions of <span id="modalCountryName" class="text-warning"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- মাল্টিপল স্টেট একবারে যোগ করার ফর্ম -->
                    <form id="addStateForm" class="row g-2 mb-4 align-items-end">
                        @csrf
                        <input type="hidden" id="modalCountryId" name="country_id">
                        <div class="col-md-9">
                            <label class="form-label fw-bold">Add Multiple States / Cities</label>
                            <textarea id="stateNameInput" name="names" class="form-control" rows="2" placeholder="কমা (,) দিয়ে আলাদা করে লিখুন। যেমন: California, Texas, New York" required></textarea>
                            <small class="text-muted">* একাধিক স্টেট একবারে এড করতে প্রতিটির পর কমা (,) দিন।</small>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-3">
                                <i class="fa fa-plus me-1"></i> Save All
                            </button>
                        </div>
                    </form>

                    <hr>

                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light sticky-top">
                            <tr>
                                <th>State / Region Name</th>
                                <th class="text-center" style="width: 180px;">Action</th>
                            </tr>
                            </thead>
                            <tbody id="stateTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // ১. স্টেট বাটন ক্লিক করলে মোডাল ওপেন করা ও ডাইনামিক রাউট ব্যবহার করে ডাটা আনা
            $('.open-state-modal').on('click', function () {
                let countryId = $(this).data('id');
                let countryName = $(this).data('name');

                $('#modalCountryId').val(countryId);
                $('#modalCountryName').text(countryName);
                $('#stateNameInput').val('');

                loadStates(countryId);
                $('#stateManagerModal').modal('show');
            });

            // ২. ডাইনামিকালি স্টেট ডাটা লোড করার ফাংশন
            function loadStates(countryId) {
                $('#stateTableBody').html('<tr><td colspan="2" class="text-center text-muted">Loading states...</td></tr>');

                let fetchUrl = "{{ route('admin.countries.get_states', ':id') }}".replace(':id', countryId);

                $.get(fetchUrl, function (states) {
                    let rows = '';
                    if (states.length === 0) {
                        rows = '<tr><td colspan="2" class="text-center text-muted">No states added yet!</td></tr>';
                    } else {
                        states.forEach(function (state) {
                            rows += `
                                <tr id="state-row-${state.id}">
                                    <td>
                                        <!-- নরমাল ভিউ -->
                            <span class="fw-bold state-display-name">${state.name}</span>
                                <!-- এডিট করার হিডেন ইনপুট -->
                            <input type="text" class="form-control form-control-sm state-edit-input d-none" value="${state.name}">
                            </td>
                            <td class="text-center">
                                <!-- অ্যাকশন বাটন কন্ট্রোল গ্রুপ -->
                            <div class="normal-buttons">
                            <button class="btn btn-sm btn-outline-primary edit-state-btn" data-id="${state.id}">
                            Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-state-btn" data-id="${state.id}">
                            Delete
                            </button>
                            </div>
                            <div class="edit-buttons d-none">
                            <button class="btn btn-sm btn-success save-state-btn" data-id="${state.id}">
                            Save
                            </button>
                            <button class="btn btn-sm btn-secondary cancel-state-btn" data-id="${state.id}">
                            Cancel
                            </button>
                            </div>
                            </td>
                            </tr>
                            `;
                        });
                    }
                    $('#stateTableBody').html(rows);
                });
            }

            // ৩. নতুন একাধিক স্টেট সেভ করা (AJAX Submit)
            $('#addStateForm').on('submit', function (e) {
                e.preventDefault();
                let countryId = $('#modalCountryId').val();

                $.ajax({
                    url: "{{ route('admin.states.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#stateNameInput').val('');
                        loadStates(countryId);
                        $(`.state-count-badge-${countryId}`).text(response.total_count);
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Error adding states.");
                    }
                });
            });

            // ৪. এডিট মোড অন করার টগল লজিক
            $(document).on('click', '.edit-state-btn', function () {
                let stateId = $(this).data('id');
                let row = $(`#state-row-${stateId}`);

                row.find('.state-display-name, .normal-buttons').addClass('d-none');
                row.find('.state-edit-input, .edit-buttons').removeClass('d-none');
            });

            // ৫. এডিট ক্যানসেল করার লজিক
            $(document).on('click', '.cancel-state-btn', function () {
                let stateId = $(this).data('id');
                let row = $(`#state-row-${stateId}`);

                // আগের ভ্যালু রিসেট
                let originalValue = row.find('.state-display-name').text();
                row.find('.state-edit-input').val(originalValue);

                row.find('.state-edit-input, .edit-buttons').addClass('d-none');
                row.find('.state-display-name, .normal-buttons').removeClass('d-none');
            });

            // ৬. এডিট করা স্টেট সেভ করার লজিক (AJAX Update)
            $(document).on('click', '.save-state-btn', function () {
                let stateId = $(this).data('id');
                let row = $(`#state-row-${stateId}`);
                let updatedName = row.find('.state-edit-input').val();
                let countryId = $('#modalCountryId').val();

                if (!updatedName.trim()) {
                    alert('State name cannot be empty!');
                    return;
                }

                let updateUrl = "{{ route('admin.states.update', ':id') }}".replace(':id', stateId);

                $.ajax({
                    url: updateUrl,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        name: updatedName
                    },
                    success: function (response) {
                        row.find('.state-display-name').text(updatedName);
                        row.find('.state-edit-input, .edit-buttons').addClass('d-none');
                        row.find('.state-display-name, .normal-buttons').removeClass('d-none');
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Error updating state.");
                    }
                });
            });

            // ৭. নির্দিষ্ট স্টেট ডিলিট করা (AJAX Delete)
            $(document).on('click', '.delete-state-btn', function () {
                if (!confirm('Are you sure you want to delete this state?')) return;

                let stateId = $(this).data('id');
                let countryId = $('#modalCountryId').val();
                let deleteUrl = "{{ route('admin.states.destroy', ':id') }}".replace(':id', stateId);

                $.ajax({
                    url: deleteUrl,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function (response) {
                        loadStates(countryId);
                        $(`.state-count-badge-${countryId}`).text(response.total_count);
                    },
                    error: function () {
                        alert("Error deleting state.");
                    }
                });
            });
        });
    </script>
@endsection
