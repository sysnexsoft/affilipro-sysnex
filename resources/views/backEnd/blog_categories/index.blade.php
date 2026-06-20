@extends('backEnd.layout.master')
@section('title', 'Blog Categories')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Blog Categories</h5>
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        + Add Category
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-wrap align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key => $cat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td><code>{{ $cat->slug }}</code></td>
                                    <td class="text-wrap">{{ $cat->description }}</td>
                                    <td><span class="badge {{ $cat->status ? 'bg-success' : 'bg-danger' }}">{{ $cat->status ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-info text-white edit-category-btn"
                                                data-id="{{ $cat->id }}"
                                                data-name="{{ $cat->name }}"
                                                data-slug="{{ $cat->slug }}"
                                                data-description="{{ $cat->description }}"
                                                data-status="{{ $cat->status }}"
                                                data-toggle="modal"
                                                data-target="#editCategoryModal"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.blogs-categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createModalLabel">Add New Blog Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.blogs-categories.store') }}" method="POST" id="createCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Name *</label>
                            <input type="text" name="name" id="create_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug *</label>
                            <input type="text" name="slug" id="create_slug" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="create_status" checked>
                                <label class="form-check-label" for="create_status">Active / Publish</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Name *</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug *</label>
                            <input type="text" name="slug" id="edit_slug" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="edit_status">
                                <label class="form-check-label" for="edit_status">Active / Publish</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info text-white">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            // 🔄 ৩. ক্রিয়েট মোডালের অটো স্লাগ জেনারেটর লজিক
            $('#create_name').on('keyup', function() {
                let name = $(this).val();
                let slug = name.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#create_slug').val(slug);
            });

            // 🔄 ৪. এডিট মোডালের অটো স্লাগ জেনারেটর লজিক
            $('#edit_name').on('keyup', function() {
                let name = $(this).val();
                let slug = name.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#edit_slug').val(slug);
            });

            // 🛠️ ৫. এডিট বাটনে ক্লিক করলে মোডালে ডাটা পুশ ও ওপেন করার লজিক
            $('.edit-category-btn').on('click', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let slug = $(this).data('slug');
                let description = $(this).data('description');
                let status = $(this).data('status');

                // ফর্মের অ্যাকশন ইউআরএল ডাইনামিকালি সেট করা হচ্ছে
                let actionUrl = "{{ route('admin.blogs-categories.update', ':id') }}".replace(':id', id);
                $('#editCategoryForm').attr('action', actionUrl);

                // মোডালের ফিল্ডগুলোতে ভ্যালু বসানো হচ্ছে
                $('#edit_name').val(name);
                $('#edit_slug').val(slug);
                $('#edit_description').val(description);

                // স্ট্যাটাস সুইচ অন/অফ চেক করা
                if (status == 1) {
                    $('#edit_status').prop('checked', true);
                } else {
                    $('#edit_status').prop('checked', false);
                }

                // মোডাল পপআপ শো করা
                $('#editCategoryModal').modal('show');
            });

            // 🔴 ৬. ভ্যালিডেশন স্কিমাস (ভুল ইনপুটে এরর দেখাবে)
            $("#createCategoryForm").validate({ errorClass: "is-invalid", validClass: "is-valid" });
            $("#editCategoryForm").validate({ errorClass: "is-invalid", validClass: "is-valid" });
        });
    </script>
@endpush
