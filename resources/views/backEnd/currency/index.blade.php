@extends('backEnd.layout.master')
@section('title', 'Currency Management')
@section('body')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-slate-900 mb-0">Currency Settings</h4>
                <p class="text-muted small mb-0">Manage system currency profiles, symbols, and standard conversion exchange rates.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold" onclick="openCreateModal()">
                    <i class="ri-add-line"></i> Add New Currency
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom text-slate-700">
                    <tr>
                        <th scope="col" class="ps-4 py-3">Currency Name</th>
                        <th scope="col" class="py-3">Code</th>
                        <th scope="col" class="py-3">Symbol</th>
                        <th scope="col" class="py-3">Exchange Rate</th>
                        <th scope="col" class="py-3">Type</th>
                        <th scope="col" class="py-3">Status</th>
                        <th scope="col" class="text-end pe-4 py-3" style="width: 150px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="border-top-0">
                    @forelse($currencies as $currency)
                        <tr>
                            <td class="ps-4 fw-bold text-slate-800 row-name">{{ $currency->name }}</td>
                            <td class="fw-semibold text-muted row-code">{{ $currency->code }}</td>
                            <td class="fs-5 text-slate-700 row-symbol">{{ $currency->symbol }}</td>
                            <td>
                                1 Base = <span class="fw-bold text-primary row-rate">{{ $currency->exchange_rate }}</span>
                            </td>
                            <td>
                                @if($currency->is_default == 1)
                                    <span class="badge bg-primary rounded-pill px-3 py-1.5 small row-default" data-default="1">Default</span>
                                @else
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1.5 small row-default" data-default="0">Alternative</span>
                                @endif
                            </td>
                            <td>
                                @if($currency->status == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 small fw-semibold row-status" data-status="1">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1.5 small fw-semibold row-status" data-status="0">Disabled</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <button type="button" class="btn btn-sm btn-success border text-white rounded-3 px-2.5 py-1.5"
                                            onclick="openEditModal(this, '{{ $currency->id }}')" title="Edit Currency">
                                        <i class="ri-pencil-line"></i>
                                    </button>

                                    @if(!$currency->is_default)
                                        <button type="button" class="btn btn-sm btn-danger border text-white rounded-3 px-2.5 py-1.5"
                                                onclick="deleteCurrency('{{ $currency->id }}')" title="Delete Currency">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                        <form id="delete-form-{{ $currency->id }}" action="{{ url('admin/currency/delete/'.$currency->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No currencies configured.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="currencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title fw-bold text-slate-800" id="modalTitle">Add New Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="currencyForm" action="" method="POST">
                    @csrf
                    <div id="methodPlaceholder"></div>

                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-slate-700">Currency Name *</label>
                                <input type="text" name="name" id="input_name" class="form-control" placeholder="e.g., US Dollar" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Currency Code *</label>
                                <input type="text" name="code" id="input_code" class="form-control" placeholder="e.g., USD" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Symbol *</label>
                                <input type="text" name="symbol" id="input_symbol" class="form-control" placeholder="e.g., $" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-slate-700">Exchange Rate *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">1 Base Unit =</span>
                                    <input type="number" step="0.0001" name="exchange_rate" id="input_rate" class="form-control" placeholder="e.g., 1.0000 or 118.50" required>
                                </div>
                                <small class="text-muted mt-1 d-block">Set 1.0000 if this currency is chosen as your system's Base Anchor.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Publication Status</label>
                                <select name="status" id="input_status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-auto mb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1" id="input_default">
                                    <label class="form-check-label fw-semibold text-slate-700" for="input_default">Set as Default</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top p-3 bg-light bg-opacity-50 d-flex gap-2">
                        <button type="button" class="btn btn-light border fw-semibold px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4" id="submitBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const cModal = new bootstrap.Modal(document.getElementById('currencyModal'));
        const form = document.getElementById('currencyForm');
        const modalTitle = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('submitBtn');
        const methodPlaceholder = document.getElementById('methodPlaceholder');

        function openCreateModal() {
            form.reset();
            methodPlaceholder.innerHTML = '';
            form.action = "{{ route('admin.currency.store') }}";
            modalTitle.innerText = "Add New Currency";
            submitBtn.innerText = "Save Currency";
            document.getElementById('input_default').disabled = false;
            cModal.show();
        }

        function openEditModal(button, id) {
            form.reset();
            methodPlaceholder.innerHTML = `@method('PUT')`;

            let baseUpdateUrl = "{{ route('admin.currency.update', ':id') }}";
            form.action = baseUpdateUrl.replace(':id', id);

            let row = button.closest('tr');
            let name = row.querySelector('.row-name').innerText;
            let code = row.querySelector('.row-code').innerText;
            let symbol = row.querySelector('.row-symbol').innerText;
            let rate = row.querySelector('.row-rate').innerText;
            let isDefault = row.querySelector('.row-default').getAttribute('data-default');
            let status = row.querySelector('.row-status').getAttribute('data-status');

            document.getElementById('input_name').value = name;
            document.getElementById('input_code').value = code;
            document.getElementById('input_symbol').value = symbol;
            document.getElementById('input_rate').value = rate;
            document.getElementById('input_status').value = status;

            let defaultCheckbox = document.getElementById('input_default');
            if (isDefault === "1") {
                defaultCheckbox.checked = true;
                // অলরেডি ডিফল্ট থাকলে আনচেক করা যাবে না, অন্য কারেন্সিকে ডিফল্ট করতে হবে
                defaultCheckbox.disabled = true;
            } else {
                defaultCheckbox.checked = false;
                defaultCheckbox.disabled = false;
            }

            modalTitle.innerText = "Update Currency Details";
            submitBtn.innerText = "Update Currency";
            cModal.show();
        }

        function deleteCurrency(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this currency profile.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
