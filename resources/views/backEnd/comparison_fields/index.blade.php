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
                    <h5 class="mb-0 fw-bold">Add & Map New Fields</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.compare-fields.store') }}" method="POST">
                    @csrf

                    <!-- 💡 Input area update format with dynamic dynamic tag tags container wrapper -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Field Names (Type & press Enter) *</label>
                            <div id="tagContainer" class="form-control d-flex flex-wrap gap-1 align-items-center" style="min-height: 40px; cursor: text;">
                                <input type="text" id="tagInput" class="border-0 flex-grow-1" placeholder="e.g. RAM, Battery, Fabric" style="outline: none;">
                            </div>
                            <!-- Hidden values input row pass parsing tags tracking target array container -->
                            <div id="hiddenInputsContainer"></div>
                            <small class="text-muted">Type a name and press **Enter** or **, (comma)** to add multiple fields.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Assign to Categories</label>
                            <select name="category_ids[]" class="form-control category-select" multiple style="width: 100%;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">You can assign these fields to multiple categories.</small>
                        </div>

                        <button type="submit" id="btnSubmitForm" class="btn btn-success w-100 fw-bold" disabled>Save & Link Fields</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tagContainer = document.getElementById('tagContainer');
            const tagInput = document.getElementById('tagInput');
            const hiddenContainer = document.getElementById('hiddenInputsContainer');
            const btnSubmit = document.getElementById('btnSubmitForm');
            let tagsSet = new Set();

            // Container box click korle input a focus hobe
            tagContainer.addEventListener('click', function (e) {
                // Tag ba delete button bade baki empty space e click porle focus hobe
                if (e.target === tagContainer || e.target === tagInput) {
                    tagInput.focus();
                }
            });

            tagInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    let value = tagInput.value.trim().replace(/,/g, '');

                    if (value && !tagsSet.has(value)) {
                        tagsSet.add(value);
                        createTagUI(value);
                        updateHiddenInputs();
                        tagInput.value = '';
                    }
                }

                // 💡 Backspace chepeo jeno bhetor theke last tag clear kora jai tar safety standard rules option:
                if (e.key === 'Backspace' && tagInput.value === '' && tagsSet.size > 0) {
                    const currentTagsArray = Array.from(tagsSet);
                    const lastTagVal = currentTagsArray[currentTagsArray.length - 1];
                    tagsSet.delete(lastTagVal);

                    // View structural child update clear layer
                    const badges = tagContainer.querySelectorAll('.badge');
                    if (badges.length > 0) {
                        badges[badges.length - 1].remove();
                    }
                    updateHiddenInputs();
                }
            });

            function createTagUI(text) {
                const tag = document.createElement('span');
                // Bootstrap standard design styling structure configuration properties line
                tag.className = 'badge bg-primary text-white d-flex align-items-center gap-2 p-2 rounded remove-tag-target';
                tag.style.fontSize = '13px';
                tag.style.userSelect = 'none';

                // Text node inner text layout configuration
                tag.innerHTML = `
            <span>${text}</span>
            <span class="btn-close btn-close-white remove-tag-trigger" style="font-size: 9px; cursor: pointer;" title="Remove this field"></span>
        `;

                // 💡 Dynamic clear tracking execution element point selection rule mapping standard:
                tag.querySelector('.remove-tag-trigger').addEventListener('click', function (e) {
                    e.stopPropagation(); // Parent focus configuration intercept parameters pause kore dibe
                    tagsSet.delete(text);
                    tag.remove();
                    updateHiddenInputs();
                });

                tagContainer.insertBefore(tag, tagInput);
            }

            function updateHiddenInputs() {
                hiddenContainer.innerHTML = '';
                tagsSet.forEach(tagVal => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'names[]';
                    hiddenInput.value = tagVal;
                    hiddenContainer.appendChild(hiddenInput);
                });

                // Form trigger action active elements parameter tracking control checks
                btnSubmit.disabled = tagsSet.size === 0;
            }
        });
    </script>
@endpush
