@extends('backEnd.layout.master')
@section('title', 'Add Article')

@section('body')
    <div class="py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-cube me-2"></i>Create New Product</h5>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-light fw-bold">Back to List</a>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="productAddForm">
                        @csrf

                        <!-- 💡 Nav-tabs layout optimized and navigation tabs made look step disabled pointers -->
                            <ul class="nav nav-pills nav-justified mb-4 border p-2 rounded bg-light" id="productTab" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active fw-bold step-nav-btn" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">1. General Info</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link fw-bold step-nav-btn" id="affiliate-tab" data-bs-toggle="tab" data-bs-target="#affiliate" type="button" role="tab">2. Pricing & Affiliate</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link fw-bold step-nav-btn" id="dynamic-tab" data-bs-toggle="tab" data-bs-target="#dynamic" type="button" role="tab">3. Specs & FAQs</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link fw-bold step-nav-btn" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">4. SEO & Flags</button>
                                </li>
                            </ul>

                            <div class="tab-content border p-4 rounded bg-white" id="productTabContent" style="min-height: 400px;">

                                <!-- STEP 1: GENERAL INFO -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Product Title *</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Slug (Unique URL) *</label>
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
                                        </div>
                                        <!-- Category Field Layout -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Categories *</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <!-- select2 container-এর উইডথ ১০০% রাখার জন্য wrapper div -->
                                                <div class="flex-grow-1">
                                                    <select name="category_ids[]" id="category_select_id" class="form-control category-select" multiple required>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#quickAddCategory" title="Quick Add Category" style="height: 32px;">
                                                    <i class="ri-add-fill"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Brand Field Layout -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Brand</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <select name="brand_id" id="brand_select_id" class="form-control brand-select">
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#quickAddBrand" title="Quick Add Brand" style="height: 32px;">
                                                    <i class="ri-add-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <style>
                                            /* input-group এর ভেতরে select2 থাকলে তার লেআউট ফিক্স */
                                            .input-group > .select2-container--default {
                                                flex: 1 1 auto;
                                                width: 1% !important;
                                            }

                                            .input-group > .select2-container--default .select2-selection--single,
                                            .input-group > .select2-container--default .select2-selection--multiple {
                                                height: 32px !important;
                                                border-top-right-radius: 0 !important;
                                                border-bottom-right-radius: 0 !important;
                                            }
                                        </style>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">SKU Code</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <input type="text" name="sku" id="sku_code" class="form-control" value="{{ old('sku') }}" placeholder="e.g., PROD-X89F2" autocomplete="off">
                                                </div>
                                                <button type="button" id="generate_sku_btn" class="btn btn-dark" title="Generate SKU" style="height: 38px;">
                                                    <i class="ri-refresh-line me-1"></i> Generate
                                                </button>
                                            </div>
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
                                            <textarea name="pros" class="form-control summernote" rows="4"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-danger">Cons (Bad Points)</label>
                                            <textarea name="cons" class="form-control summernote" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <!-- 💡 Step 1 Actions footer control buttons panel wrapper -->
                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 2: PRICING & AFFILIATE -->
                                <div class="tab-pane fade" id="affiliate" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Regular Price</label>
                                            <input type="number" step="0.01" name="regular_price" class="form-control" value="{{ old('regular_price') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Sale Price</label>
                                            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Coupon</label>
                                            <input type="text" name="coupon" class="form-control" value="{{ old('coupon') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-primary">Affiliate URL *</label>
                                            <input type="url" name="affiliate_url" class="form-control" value="{{ old('affiliate_url') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Affiliate Network</label>
                                            <select name="affiliate_network" id="" class="form-control">
                                                <option value="">Select Network</option>
                                                <option value="Amazon" {{ old('affiliate_network') == 'Amazon' ? 'selected':'' }}>Amazon</option>
                                                <option value="AliExpress" {{ old('affiliate_network') == 'AliExpress' ? 'selected':'' }}>AliExpress</option>
                                                <option value="Alibaba" {{ old('affiliate_network') == 'Alibaba' ? 'selected':'' }}>Alibaba</option>
                                                <option value="ClickBank" {{ old('affiliate_network') == 'ClickBank' ? 'selected':'' }}>ClickBank</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Commission Rate (%)</label>
                                            <input type="number" step="0.01" name="commission_rate" class="form-control" value="{{ old('commission_rate') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Featured Image (Main Thumbnail)</label>
                                            <input type="file" name="featured_image" class="form-control imageInput" accept="image/*">
                                            <div class="mt-2"><img class="previewImage" style="max-height:120px;display:none;"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Gallery Images (Multiple Upload)</label>
                                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                                        </div>
                                    </div>

                                    <!-- 💡 Step 2 Actions footer buttons layout section -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 3: SPECS & FAQS -->
                                <div class="tab-pane fade" id="dynamic" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 border-end">
                                            <h6 class="fw-bold mb-3 text-secondary">Product Specifications (Auto-loaded by Category)</h6>
                                            <div id="spec-container">
                                                <div class="text-muted small p-2" id="no-cat-alert">Please select categories first to load specific fields.</div>
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

                                    <!-- 💡 Step 3 Actions navigation element wrapper block -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 4: SEO & FLAGS (FINAL STEP) -->
                                <div class="tab-pane fade" id="seo" role="tabpanel">
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
                                        {{--<div class="col-md-6">
                                            <label class="form-label fw-bold">Canonical URL</label>
                                            <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url') }}">
                                        </div>--}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Meta Keywords</label>
                                            <textarea name="meta_keywords" class="form-control" rows="3" placeholder="keyword1, keyword2..."></textarea>
                                        </div>
                                    </div>

                                    <!-- 💡 Final Step Actions - Submit Button appears here -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="submit" class="btn btn-success px-5 fw-bold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Save Product</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Add Category Modal -->
    <div class="modal fade" id="quickAddCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Quick Add Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="quickCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Name *</label>
                            <input type="text" id="quick_cat_name" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug *</label>
                            <input type="text" id="quick_cat_slug" name="slug" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Parent Category</label>
                            <select name="parent_id" class="form-select">
                                <option value="">Main Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveQuickCatBtn">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Add Brand Modal -->
    <div class="modal fade" id="quickAddBrand" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Quick Add Brand</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="quickBrandForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Brand Name *</label>
                            <input type="text" id="quick_brand_name" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug *</label>
                            <input type="text" id="quick_brand_slug" name="slug" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveQuickBrandBtn">Save Brand</button>
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

            // ==========================================
            // 💡 WIZARD BACK / NEXT STEP ROUTING LOGIC
            // ==========================================

            // Next Step Button Click
            $('.next-step-btn').on('click', function() {
                let currentTabPane = $(this).closest('.tab-pane');
                let form = $('#productAddForm');

                // Form input parameter tracking field configuration validation rule check:
                // Sudhu matro ekhonkar visible active step-er elements valid kina ta pipeline a validation check hbe
                let isValid = true;
                currentTabPane.find('input, select, textarea').each(function() {
                    if (!form.validate().element($(this))) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    // Next step routing matching target selection logic
                    let nextTabButton = $('#productTab .nav-link.active').parent().next().find('.step-nav-btn');
                    if (nextTabButton.length > 0) {
                        nextTabButton.tab('show');
                        window.scrollTo(0, 0); // Window offset scroll back to top bounds standard interface view
                    }
                }
            });

            // Previous (Back) Step Button Click (এই অংশটুকু ঠিক করে নিন)
            $('.prev-step-btn').on('click', function() {
                let currentActiveIdx = $('#productTab .nav-link').index($('#productTab .nav-link.active'));

                if (currentActiveIdx > 0) {
                    // ঠিক আগের ইনডেক্সের ট্যাবে মুভ করবে
                    $('#productTab .nav-link').eq(currentActiveIdx - 1).tab('show');

                    // পেজ স্ক্রল করে একদম উপরে নিয়ে যাবে
                    window.scrollTo(0, 0);
                }
            });

            // Prevent direct header tab clicks skipping validations parameters restrictions
            $('.step-nav-btn').on('click', function(e) {
                // User direct header click korleo jeno validation bypass na korte pare logic tracker:
                let targetIdx = $('#productTab .nav-link').index($(this));
                let activeIdx = $('#productTab .nav-link').index($('#productTab .nav-link.active'));

                if (targetIdx > activeIdx) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Auto run standard forward step next button click checking mapping loop sequence execution:
                    $('#productTabContent .tab-pane.active').find('.next-step-btn').click();
                    return false;
                }
            });

            // ==========================================
            // DYNAMIC CATEGORY FIELD CHECKING (AJAX RUN)
            // ==========================================
            let specIndex = 0;

            $('#category_select_id').on('change', function() {
                let categoryIds = $(this).val();

                if(categoryIds && categoryIds.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.products.getFieldsByCategories') }}",
                        type: "GET",
                        data: { category_ids: categoryIds },
                        success: function(response) {
                            $('#spec-container').html('');

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
                                            <button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="fa-solid fa-trash"></i></button>
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

            // Add manual specs row logic tracker
            $('#add-spec-btn').click(function() {
                if($('#spec-container').find('.text-muted, .text-warning').length > 0) {
                    $('#spec-container').html('');
                }

                let html = `
                <div class="row g-2 mb-2 spec-row">
                    <div class="col-5"><input type="text" name="specs[${specIndex}][name]" class="form-control form-control-sm" placeholder="Specification Name" required></div>
                    <div class="col-5"><input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value" required></div>
                    <div class="col-2"><button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="fa-solid fa-trash"></i></button></div>
                </div>`;
                $('#spec-container').append(html);
                specIndex++;
            });

            // ==========================================
            // JQUERY FORM VALIDATION COMPONENT
            // ==========================================
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
                }
            });

            // Auto Slug structural dynamic trigger generator
            $('#title').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
                $(this).valid();
            });

            // Dynamic FAQs logic setup configuration tracker element matrix row add
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

            // Remove dynamic row actions trigger bindings execution flow
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.spec-row, .faq-row').remove();
            });

            // Summernote text wysiwyg rich initialization check properties standard mapping
            if ($('.summernote').length > 0) {
                $('.summernote').summernote({
                    height: 250,
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

            // Select2 custom category element layout parsing initialization framework
            $('.category-select').select2({
                placeholder: 'Search Categories',
                width: '100%'
            }).on('change', function() {
                $(this).valid();
            });
            $('.brand-select').select2({
                placeholder: 'Search Brands',
                width: '100%'
            }).on('change', function() {
                $(this).valid();
            });

            // Image file upload validation preview block
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
    <script>
        $(document).ready(function() {

            // Helper function to generate slug
            function generateQuickSlug(text) {
                return text.toLowerCase().trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-');
            }

            // Auto slug for Quick Category & Brand
            $('#quick_cat_name').on('keyup', function() {
                $('#quick_cat_slug').val(generateQuickSlug($(this).val()));
            });
            $('#quick_brand_name').on('keyup', function() {
                $('#quick_brand_slug').val(generateQuickSlug($(this).val()));
            });

            // ==========================================
            // 📂 QUICK ADD CATEGORY AJAX
            // ==========================================
            $('#quickCategoryForm').on('submit', function(e) {
                e.preventDefault();
                let btn = $('#saveQuickCatBtn');
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('admin.category.quickStore') }}", // Create this route
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).text('Save Category');

                        if (response.success) {
                            // মেইন ফর্মে নতুন অপশন যুক্ত করা
                            let newOption = new Option(response.data.name, response.data.id, true, true);
                            $('#category_select_id').append(newOption).trigger('change');

                            // মডাল রিসেট ও হাইড
                            $('#quickCategoryForm')[0].reset();
                            $('#quickAddCategory').modal('hide');

                            // সাফল্য বার্তা
                            if(typeof Swal !== 'undefined') {
                                Swal.fire('Success', 'Category created and selected!', 'success');
                            } else {
                                alert('Category created and selected!');
                            }
                        } else {
                            // এক্সিস্ট করলে বা অন্য কোন এরর মেসেজ আসলে
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save Category');
                        if(xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(errors.name ? errors.name[0] : 'Validation error occurred.');
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
            });

            // ==========================================
            // 🏷️ QUICK ADD BRAND AJAX
            // ==========================================
            $('#quickBrandForm').on('submit', function(e) {
                e.preventDefault();
                let btn = $('#saveQuickBrandBtn');
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('admin.brand.quickStore') }}", // Create this route
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).text('Save Brand');

                        if (response.success) {
                            // মেইন ফর্মে নতুন অপশন সেট করা
                            let newOption = new Option(response.data.name, response.data.id, true, true);
                            $('#brand_select_id').append(newOption).trigger('change');

                            // মডাল রিসেট ও হাইড
                            $('#quickBrandForm')[0].reset();
                            $('#quickAddBrand').modal('hide');

                            if(typeof Swal !== 'undefined') {
                                Swal.fire('Success', 'Brand created and selected!', 'success');
                            } else {
                                alert('Brand created and selected!');
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save Brand');
                        if(xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(errors.name ? errors.name[0] : 'Validation error.');
                        } else {
                            alert('Something went wrong.');
                        }
                    }
                });
            });
        });
        // ==========================================
        // ⚡ PRODUCT NAME BASED SKU GENERATOR
        // ==========================================
        $('#generate_sku_btn').on('click', function() {
            // মেইন ফর্মের প্রোডাক্টের নাম (Title) ইনপুট ফিল্ড থেকে ভ্যালু নেওয়া হচ্ছে
            let productName = $('#title').val() || '';

            if (productName.trim() === '') {
                alert('Please enter the Product Title first to generate SKU!');
                return;
            }

            // নাম থেকে স্পেস ও স্পেশাল ক্যারেক্টার বাদ দিয়ে শুধু ইংরেজি অক্ষর ও নাম্বার রাখা হচ্ছে
            let cleanName = productName.toUpperCase().replace(/[^A-Z0-9]/g, '');

            // নামের প্রথম ৪টি ক্যারেক্টার নেওয়া হচ্ছে
            let namePrefix = cleanName.substring(0, 4);

            // ৪ ডিজিটের একটি ইউনিক র‍্যান্ডম নাম্বার তৈরি (১০০০ থেকে ৯৯৯৯ এর মধ্যে)
            let randomNumber = Math.floor(1000 + Math.random() * 9000);

            // ফরম্যাট: NAME-1234
            let generatedSku = namePrefix + '-' + randomNumber;

            // SKU ইনপুট ফিল্ডে ভ্যালু সেট করা
            $('#sku_code').val(generatedSku);

            // ভ্যালিডেশন প্লাগইন অ্যাক্টিভ থাকলে এরর রিমুভ করা
            if (typeof $.fn.valid === 'function') {
                $('#sku_code').valid();
            }
        });
    </script>
@endpush
