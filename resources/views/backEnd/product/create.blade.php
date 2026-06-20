@extends('backEnd.layout.master')
@section('title', 'Add Article')

@section('body')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add New Affiliate Product</h5>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-light">Back to List</a>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="productAddForm">
                            @csrf

                            <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
                                <li class="nav-item"><button class="nav-link active text-success" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">General Info</button></li>
                                <li class="nav-item"><button class="nav-link text-success" id="affiliate-tab" data-bs-toggle="tab" data-bs-target="#affiliate" type="button">Pricing & Affiliate</button></li>
                                <li class="nav-item"><button class="nav-link text-success" id="dynamic-tab" data-bs-toggle="tab" data-bs-target="#dynamic" type="button">Specs & FAQs</button></li>
                                <li class="nav-item"><button class="nav-link text-success" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button">SEO & Flags</button></li>
                            </ul>

                            <div class="tab-content" id="productTabContent">

                                <div class="tab-pane fade show active" id="general">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Product Title *</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Slug (Unique URL) *</label>
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Categories (Dynamic Field Load) *</label>
                                            <select name="category_ids[]" id="category_select_id" class="form-control category-select" multiple required style="height: 100px;">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Hold Ctrl to select multiple</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Brand</label>
                                            <select name="brand_id" class="form-control">
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">SKU Code</label>
                                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Full Description</label>
                                            <textarea name="description" class="form-control summernote" rows="6">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-success">Pros (Good Points)</label>
                                            <textarea name="pros" class="form-control summernote" rows="4" placeholder="One point per line..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-danger">Cons (Bad Points)</label>
                                            <textarea name="cons" class="form-control summernote" rows="4" placeholder="One point per line..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="affiliate">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Regular Price</label>
                                            <input type="number" step="0.01" name="regular_price" class="form-control" value="{{ old('regular_price') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Sale Price</label>
                                            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-primary">Affiliate URL *</label>
                                            <input type="url" name="affiliate_url" class="form-control" placeholder="https://amazon.com/..." value="{{ old('affiliate_url') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Affiliate Network</label>
                                            <input type="text" name="affiliate_network" class="form-control" placeholder="e.g. Amazon, AliExpress" value="{{ old('affiliate_network') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Commission Rate (%)</label>
                                            <input type="number" step="0.01" name="commission_rate" class="form-control" value="{{ old('commission_rate') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Featured Image (Main Thumbnail)</label>
                                            <input type="file" name="featured_image" class="form-control imageInput" accept="image/*">
                                            <div class="mt-2">
                                                <img class="previewImage" style="max-height:120px;display:none;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Gallery Images (Multiple Upload)</label>
                                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="dynamic">
                                    <div class="row">
                                        <div class="col-md-6 border-end">
                                            <h6 class="fw-bold mb-3 text-secondary">Product Specifications (Auto-loaded by Category)</h6>
                                            <div id="spec-container">
                                                <div class="text-muted small p-2 id="no-cat-alert">Please select categories first to load specific fields.</div>
                                        </div>
                                        <button type="button" id="add-spec-btn" class="btn btn-sm btn-outline-primary mt-2">+ Add Custom Specification</button>
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3 text-secondary">Product FAQs</h6>
                                        <div id="faq-container">
                                            <div class="card card-body bg-light mb-2 p-2 faq-row">
                                                <input type="text" name="faqs[0][question]" class="form-control form-control-sm mb-1" placeholder="Question">
                                                <textarea name="faqs[0][answer]" class="form-control form-control-sm" rows="2" placeholder="Answer"></textarea>
                                                <div class="text-end mt-1"><button type="button" class="btn btn-xs btn-danger remove-row btn-sm">Remove</button></div>
                                            </div>
                                        </div>
                                        <button type="button" id="add-faq-btn" class="btn btn-sm btn-outline-primary mt-2">+ Add FAQ</button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="seo">
                                <div class="row g-3">
                                    <div class="col-12 bg-light p-3 rounded mb-3">
                                        <h6 class="fw-bold text-muted mb-3">Product Visibility & Badges</h6>
                                        <div class="d-flex flex-wrap gap-4">
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="allow_compare" checked value="1"><label class="form-check-label">Allow Comparison</label></div>
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="featured" value="1"><label class="form-check-label">Featured Product</label></div>
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="trending" value="1"><label class="form-check-label">Trending</label></div>
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="best_seller" value="1"><label class="form-check-label">Best Seller</label></div>
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="editors_choice" value="1"><label class="form-check-label">Editors Choice</label></div>
                                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked value="1"><label class="form-check-label">Active / Published</label></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Canonical URL</label>
                                        <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Meta Keywords</label>
                                        <textarea name="meta_keywords" class="form-control" rows="3" placeholder="keyword1, keyword2..."></textarea>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <hr class="my-4">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-5">Save Product</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            // 🔴 ১. ক্যাটাগরি চেঞ্জ হলে Ajax দিয়ে ফিল্ড লোড করার মূল ম্যাজিক লজিক
            let specIndex = 0;

            $('#category_select_id').on('change', function() {
                let categoryIds = $(this).val();

                if(categoryIds && categoryIds.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.products.getFieldsByCategories') }}",
                        type: "GET",
                        data: { category_ids: categoryIds },
                        success: function(response) {
                            $('#spec-container').html(''); // কন্টেইনার ফাস্টে খালি করা হলো

                            if(response.length > 0) {
                                $.each(response, function(index, field) {
                                    let html = `
                                    <div class="row g-2 mb-2 spec-row">
                                        <div class="col-5">
                                            <input type="text" name="specs[${specIndex}][name]" class="form-control form-control-sm bg-light" value="${field.name}" readonly>
                                        </div>
                                        <div class="col-5">
                                            <input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value for ${field.name}" required>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </div>`;
                                    $('#spec-container').append(html);
                                    specIndex++;
                                });
                            } else {
                                $('#spec-container').html('<div class="text-warning small p-2">No specific mapping fields found for chosen categories. You can add manually.</div>');
                            }
                        }
                    });
                } else {
                    $('#spec-container').html('<div class="text-muted small p-2">Please select categories first to load specific fields.</div>');
                }
            });

            // ২. ম্যানুয়ালি কাস্টম স্পেসিফিকেশন রিল বাটন লজিক
            $('#add-spec-btn').click(function() {
                // নো-ক্যাটাগরি বা ওয়ার্নিং মেসেজ টেক্সট থাকলে তা রিমুভ করার জন্য
                if($('#spec-container').find('.text-muted, .text-warning').length > 0) {
                    $('#spec-container').html('');
                }

                let html = `
                <div class="row g-2 mb-2 spec-row">
                    <div class="col-5"><input type="text" name="specs[${specIndex}][name]" class="form-control form-control-sm" placeholder="Specification Name"></div>
                    <div class="col-5"><input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value"></div>
                    <div class="col-2"><button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="ri-delete-bin-line"></i></button></div>
                </div>`;
                $('#spec-container').append(html);
                specIndex++;
            });

            // ৩. ফর্ম ভ্যালিডেশন লজিক
            $("#productAddForm").validate({
                errorClass: "is-invalid",
                validClass: "is-valid",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback fw-bold");
                    if (element.hasClass('category-select')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    if ($(element).hasClass('category-select')) {
                        $(element).next('.select2-container').find('.select2-selection').addClass('border-danger');
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    if ($(element).hasClass('category-select')) {
                        $(element).next('.select2-container').find('.select2-selection').removeClass('border-danger');
                    }
                },
                rules: {
                    title: "required",
                    slug: "required",
                    "category_ids[]": "required",
                    affiliate_url: { required: true, url: true }
                },
                invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var firstInvalidElement = $(validator.errorList[0].element);
                        var tabContent = firstInvalidElement.closest('.tab-pane');
                        if (tabContent.length) {
                            var tabId = tabContent.attr('id');
                            $('#productTab button[data-bs-target="#' + tabId + '"]').tab('show');
                        }
                    }
                }
            });

            // ৪. অটো স্লাগ জেনারেটর লজিক
            $('#title').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
                $(this).valid();
            });

            // ৫. ডাইনামিক এফএকিউ (FAQ) অ্যাড র লজিক
            let faqIndex = 1;
            $('#add-faq-btn').click(function() {
                let html = `
                <div class="card card-body bg-light mb-2 p-2 faq-row">
                    <input type="text" name="faqs[${faqIndex}][question]" class="form-control form-control-sm mb-1" placeholder="Question">
                    <textarea name="faqs[${faqIndex}][answer]" class="form-control form-control-sm" rows="2" placeholder="Answer"></textarea>
                    <div class="text-end mt-1"><button type="button" class="btn btn-xs btn-danger remove-row btn-sm">Remove</button></div>
                </div>`;
                $('#faq-container').append(html);
                faqIndex++;
            });

            // ৬. রিমুভ বাটন লজিক (specs & faqs)
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.spec-row, .faq-row').remove();
            });

            // ৭. সামারনোট ইনিশিয়ালাইজেশন
            if ($('.summernote').length > 0) {
                $('.summernote').summernote({
                    height: 300,
                    placeholder: 'Write product description...',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture']],
                        ['view', ['codeview']]
                    ]
                });
            }

            // ৮. ক্যাটাগরি সিলেক্ট (Select2)
            $('.category-select').select2({
                placeholder: 'Search Categories',
                width: '100%'
            }).on('change', function() {
                $(this).valid(); // Select2 চেঞ্জ হলে এরর চলে যাবে
            });

            // ৯. ইমেজ প্রিভিউ লজিক
            $('.imageInput').on('change', function () {
                let reader = new FileReader();
                let preview = $('.previewImage');
                reader.onload = function(e) {
                    preview.attr('src', e.target.result);
                    preview.show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
