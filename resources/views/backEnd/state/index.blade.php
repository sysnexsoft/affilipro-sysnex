@extends('backEnd.layout.master')
@section('title','State')
@section('body')
    <div class="container-fluid pt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">State / Region Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStateModal">
                <i class="fa fa-plus me-1"></i> Add New State
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>State / City Name</th>
                        <th>Belongs To Country</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($states as $state)
                        <tr>
                            <td>{{ $state->id }}</td>
                            <td class="fw-bold">{{ $state->name }}</td>
                            <td><span class="badge bg-info text-dark">{{ $state->country->name }} ({{ $state->country->code }})</span></td>
                            <td>
                            <span class="badge {{ $state->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $state->status ? 'Active' : 'Inactive' }}
                            </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editStateModal{{ $state->id }}">Edit</button>
                                <form action="{{ route('admin.states.destroy', $state->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit State Modal -->
                        <div class="modal fade" id="editStateModal{{ $state->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.states.update', $state->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header"><h5>Edit State</h5></div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select Country</label>
                                                <select name="country_id" class="form-control" required>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $state->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">State / City Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $state->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{ $state->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$state->status ? 'selected' : '' }}>Inactive</option>
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
        <div class="mt-3">{{ $states->links() }}</div>
    </div>

    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.states.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header"><h5>Add New State</h5></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Country</label>
                            <select name="country_id" class="form-control" required>
                                <option value="">-- Choose Country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State / City Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. California or New York" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save State</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
