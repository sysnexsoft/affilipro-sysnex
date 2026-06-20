@extends('backEnd.layout.master')
@section('title', 'Comparison Fields Mapping')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Comparison Fields</h4>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Add & Map New Field</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.compare-fields.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Field Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. RAM, Battery, Fabric" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Assign to Categories</label>
                            <select name="category_ids[]" class="form-control category-select" multiple style="width: 100%;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">You can assign this field to multiple categories.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">Save & Link Field</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0 fw-bold">Comparison Fields Master List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Field Name</th>
                                <th>Assigned Categories</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fields as $key => $field)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $field->name }}</td>
                                    <td>
                                        @forelse($field->categories as $cat)
                                            <span class="badge bg-info text-dark mb-1">{{ $cat->name }}</span>
                                        @empty
                                            <span class="badge bg-light text-muted">Global / Unassigned</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"
                                                data-id="{{ $field->id }}"
                                                data-name="{{ $field->name }}"
                                                data-categories="{{ json_encode($field->categories->pluck('id')) }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.compare-fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $fields->links('backEnd.layout.paginate') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Comparison Field</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-content-body p-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Field Name *</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Assign to Categories</label>
                            <select name="category_ids[]" id="edit_categories" class="form-control select2-modal" multiple style="width: 100%;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            // ১. মেইন পেজের (নন-মডাল) Select2 যদি থাকে তার জন্য
            $('.category-select').select2({
                placeholder: 'Search Categories',
                width: '100%'
            });
            // ২. মডালের ভেতরের Select2 ফিক্সড (dropdownParent যুক্ত করা হয়েছে)
            $('.select2-modal').select2({
                placeholder: "Select Categories",
                allowClear: true,
                dropdownParent: $('#editModal') // এই লাইনটি মডালের ভেতর অপশন লিস্ট দেখাবে
            });

            // ৩. এডিট বাটন অ্যাকশন এবং মডাল ওপেন লজিক
            $('.edit-btn').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let selectedCats = $(this).data('categories');

                // ডায়নামিক ইউআরএল সেট করা
                let url = "{{ route('admin.compare-fields.update', ':id') }}".replace(':id', id);
                $('#editForm').attr('action', url);

                // ভ্যালু সেট করা
                $('#edit_name').val(name);
                $('#edit_categories').val(selectedCats).trigger('change'); // trigger('change') অবশ্যই লাগবে

                // মডাল শো করা
                var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                myModal.show();
            });
        });
    </script>
@endpush
