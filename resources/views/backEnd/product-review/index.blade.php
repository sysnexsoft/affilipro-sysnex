@extends('backEnd.layout.master')
@section('title', 'Product Reviews')

@section('body')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product Reviews Management</h5>
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#createReviewModal" data-toggle="modal" data-target="#createReviewModal">
                + Add New Review
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>User Info</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $key => $rev)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><span class="badge bg-secondary">{{ $rev->product->title }}</span></td>
                            <td>
                                <strong>{{ $rev->name }}</strong><br>
                                <small class="text-muted">{{ $rev->email }}</small>
                            </td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-warning">{{ $i <= $rev->rating ? '★' : '☆' }}</span>
                                @endfor
                            </td>
                            <td>{{ Str::limit($rev->review, 60) }}</td>
                            <td>
                                    <span class="badge {{ $rev->approved ? 'bg-success' : 'bg-warning' }}">
                                        {{ $rev->approved ? 'Approved' : 'Pending' }}
                                    </span>
                            </td>
                            <td>
                                <button type="button"
                                        class="btn btn-sm btn-info text-white edit-review-btn"
                                        data-id="{{ $rev->id }}"
                                        data-product="{{ $rev->product_id }}"
                                        data-name="{{ $rev->name }}"
                                        data-email="{{ $rev->email }}"
                                        data-rating="{{ $rev->rating }}"
                                        data-review="{{ $rev->review }}"
                                        data-approved="{{ $rev->approved }}"
                                        data-toggle="modal" data-target="#editReviewModal"
                                        data-bs-toggle="modal" data-bs-target="#editReviewModal">
                                    Edit
                                </button>

                                <form action="{{ route('admin.cms.reviews.destroy', $rev->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                {{ $reviews->links('backEnd.layout.paginate') }}
        </div>
    </div>

    <div class="modal fade" id="createReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Add New Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.cms.reviews.store') }}" method="POST" id="createReviewForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Product *</label>
                            <select name="product_id" id="create_product_id" class="form-control select2" required>
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">User Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">User Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating *</label>
                            <select name="rating" class="form-control" required>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Review *</label>
                            <textarea name="review" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Approval Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="approved" value="1" id="create_approved" checked>
                                <label class="form-check-label" for="create_approved">Approved / Live</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Edit Product Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editReviewForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Product *</label>
                            <select name="product_id" id="edit_product_id" class="form-control" required>
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">User Name *</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">User Email *</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating *</label>
                            <select name="rating" id="edit_rating" class="form-control" required>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Review *</label>
                            <textarea name="review" id="edit_review" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Approval Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="approved" value="1" id="edit_approved">
                                <label class="form-check-label" for="edit_approved">Approved / Live</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info text-white">Update Review</button>
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

            // 🛠️ এডিট বাটনে ডাটা পুশ ও মোডাল ইউআরএল ফিক্স লজিক
            $(document).on('click', '.edit-review-btn', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let product_id = $(this).data('product');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let rating = $(this).data('rating');
                let review = $(this).data('review');
                let approved = $(this).data('approved');

                // ১০০% একুরেট ইউআরএল জেনারেশন (কোনো সাবমিট রিলোড প্রবলেম হবে না)
                let actionUrl = "{{ route('admin.cms.reviews.update', ':id') }}".replace(':id', id);
                $('#editReviewForm').attr('action', actionUrl);

                // ফিল্ডে ডাটা অ্যাসাইন
                $('#edit_product_id').val(product_id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_rating').val(rating);
                $('#edit_review').val(review);

                // অ্যাপ্রুভড চেকবক্স হ্যান্ডলিং
                if (parseInt(approved) === 1) {
                    $('#edit_approved').prop('checked', true);
                } else {
                    $('#edit_approved').prop('checked', false);
                }

                // মোডাল শো
                $('#editReviewModal').modal('show');
            });

            // জেকোয়েরি ভ্যালিডেশন অ্যান্ড ফোর্সড সাবমিট হ্যান্ডলার
            $("#createReviewForm").validate({
                errorClass: "is-invalid",
                validClass: "is-valid",
                submitHandler: function(form) { form.submit(); }
            });

            $("#editReviewForm").validate({
                errorClass: "is-invalid",
                validClass: "is-valid",
                submitHandler: function(form) { form.submit(); }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // 💡 মোডালের ভেতরে Select2 কাজ করানোর জন্য 'dropdownParent' প্রপার্টি ব্যবহার করা আবশ্যক
            // ক্রিয়েট মোডালের জন্য
            $('#createReviewModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                    theme: 'bootstrap-5', // থিম সুন্দর করার জন্য
                    dropdownParent: $('#createReviewModal'),
                    placeholder: "-- Choose Product --",
                    allowClear: true
                });
            });

            // এডিট মোডালের জন্য
            $('#editReviewModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#editReviewModal'),
                    placeholder: "-- Choose Product --",
                    allowClear: true
                });
            });

            // ⚠️ এডিট বাটনে ক্লিক করলে যেন Select2 এর ভ্যালুও রিয়েল-টাইমে আপডেট হয় (Edit Button Click Handler-এ এই লাইনটি যোগ করবেন)
            $(document).on('click', '.edit-review-btn', function() {
                let product_id = $(this).data('product');

                // ভ্যালু সেট করে Select2 কে রিফ্রেশ/ট্রিগার করা
                $('#edit_product_id').val(product_id).trigger('change');
            });

        });
    </script>
@endpush
