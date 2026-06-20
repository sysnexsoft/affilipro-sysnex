@extends('backEnd.layout.master')
@section('title', 'Edit Article')

@section('body')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Affiliate Product: {{ $product->title }}</h5>
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

                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm">
                            @csrf

                            <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
                                <li class="nav-item"><button class="nav-link active text-primary" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">General Info</button></li>
                                <li class="nav-item"><button class="nav-link text-primary" id="affiliate-tab" data-bs-toggle="tab" data-bs-target="#affiliate" type="button">Pricing & Affiliate</button></li>
                                <li class="nav-item"><button class="nav-link text-primary" id="dynamic-tab" data-bs-toggle="tab" data-bs-target="#dynamic" type="button">Specs & FAQs</button></li>
                                <li class="nav-item"><button class="nav-link text-primary" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button">SEO & Flags</button></li>
                            </ul>

                            <div class="tab-content" id="productTabContent">

                                <div class="tab-pane fade show active" id="general">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Product Title *</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Slug (Unique URL) *</label>
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Categories (Dynamic Field Load) *</label>
                                            <select name="category_ids[]" id="category_select_id" class="form-control category-select" multiple required style="height: 100px;">
                                                @php
                                                    $selectedCategories = is_array($product->category_ids) ? $product->category_ids : json_decode($product->category_ids, true) ?? [];
                                                @endphp
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Hold Ctrl to select multiple</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Brand</label>
                                            <select name="brand_id" class="form-control">
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">SKU Code</label>
                                            <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Full Description</label>
                                            <textarea name="description" class="form-control summernote" rows="6">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-success">Pros (Good Points)</label>
                                            <textarea name="pros" class="form-control summernote" rows="4" placeholder="One point per line...">{{ old('pros', $product->pros) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-danger">Cons (Bad Points)</label>
                                            <textarea name="cons" class="form-control summernote" rows="4" placeholder="One point per line...">{{ old('cons', $product->cons) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="affiliate">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Regular Price</label>
                                            <input type="number" step="0.01" name="regular_price" class="form-control" value="{{ old('regular_price', $product->regular_price) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Sale Price</label>
                                            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-primary">Affiliate URL *</label>
                                            <input type="url" name="affiliate_url" class="form-control" value="{{ old('affiliate_url', $product->affiliate_url) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Affiliate Network</label>
                                            <input type="text" name="affiliate_network" class="form-control" value="{{ old('affiliate_network', $product->affiliate_network) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Commission Rate (%)</label>
                                            <input type="number" step="0.01" name="commission_rate" class="form-control" value="{{ old('commission_rate', $product->commission_rate) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Featured Image (Main Thumbnail)</label>
                                            <input type="file" name="featured_image" class="form-control imageInput" accept="image/*">
                                            <div class="mt-2">
                                                <img class="previewImage" src="{{ $product->featured_image ? asset($product->featured_image) : '' }}" style="max-height:120px; {{ $product->featured_image ? '' : 'display:none;' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Gallery Images (Upload New)</label>
                                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>

                                            @if($product->images && $product->images->count() > 0)
                                                <div class="d-flex flex-wrap gap-3 mt-3">
                                                    @foreach($product->images as $img)
                                                        <div class="position-relative gallery-img-container" id="gallery-img-{{ $img->id }}" style="width: 70px; height: 70px;">
                                                            <img src="{{ asset($img->image) }}" class="img-thumbnail w-100 h-100" style="object-fit: cover;">
                                                            <button type="button" class="btn btn-danger btn-xs position-absolute rounded-circle p-0 d-flex align-items-center justify-content-center delete-gallery-img" data-id="{{ $img->id }}" style="top: -8px; right: -8px; width: 20px; height: 20px; font-size: 11px; line-height: 1; z-index: 10;" title="Delete Image">✕</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="dynamic">
                                    <div class="row">
                                        <div class="col-md-6 border-end">
                                            <h5 class="fw-bold mb-3 text-secondary">Product Specifications</h5>
                                            <div id="spec-container">
                                                @forelse($product->specifications as $index => $spec)
                                                    <div class="row g-2 mb-2 spec-row">
                                                        <div class="col-5">
                                                            <input type="text" name="specs[{{ $index }}][name]" class="form-control form-control-sm bg-light" value="{{ $spec->spec_name }}" readonly>
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="text" name="specs[{{ $index }}][value]" class="form-control form-control-sm" value="{{ $spec->spec_value }}" placeholder="Value" required>
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="ri-delete-bin-line"></i></button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    {{-- খালি থাকলে স্ক্রিপ্ট অটোমেটিক রেন্ডার করবে --}}
                                                    <div class="text-muted small p-2" id="no-cat-alert">No specs assigned. Change categories or click below to add manually.</div>
                                                @endforelse
                                            </div>
                                            <button type="button" id="add-spec-btn" class="btn btn-sm btn-outline-primary mt-2">+ Add Custom Specification</button>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="fw-bold mb-3 text-secondary">Product FAQs</h5>
                                            <div id="faq-container">
                                                @forelse($product->faqs as $index => $faq)
                                                    <div class="card card-body bg-light mb-2 p-2 faq-row">
                                                        <input type="text" name="faqs[{{ $index }}][question]" class="form-control form-control-sm mb-1" value="{{ $faq->question }}" placeholder="Question">
                                                        <textarea name="faqs[{{ $index }}][answer]" class="form-control form-control-sm" rows="2" placeholder="Answer">{{ $faq->answer }}</textarea>
                                                        <div class="text-end mt-1"><button type="button" class="btn btn-xs btn-danger remove-row btn-sm">Remove</button></div>
                                                    </div>
                                                @empty
                                                    <div class="card card-body bg-light mb-2 p-2 faq-row">
                                                        <input type="text" name="faqs[0][question]" class="form-control form-control-sm mb-1" placeholder="Question">
                                                        <textarea name="faqs[0][answer]" class="form-control form-control-sm" rows="2" placeholder="Answer"></textarea>
                                                        <div class="text-end mt-1"><button type="button" class="btn btn-xs btn-danger remove-row btn-sm">Remove</button></div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <button type="button" id="add-faq-btn" class="btn btn-sm btn-outline-primary mt-2">+ Add FAQ</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="seo">
                                    <div class="row g-3">
                                        <div class="col-12 bg-light p-3 rounded mb-3">
                                            <h5 class="fw-bold text-muted mb-3">Product Visibility & Badges</h5>
                                            <div class="d-flex flex-wrap gap-4">
                                                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="allow_compare" id="allow_compare" value="1" {{ $product->allow_compare ? 'checked' : '' }}><label for="allow_compare" class="form-check-label">Allow Comparison</label></div>
                                                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ $product->featured ? 'checked' : '' }}><label for="featured" class="form-check-label">Featured Product</label></div>
                                                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="trending" id="trending" value="1" {{ $product->trending ? 'checked' : '' }}><label for="trending" class="form-check-label">Trending</label></div>
                                                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="best_seller" id="best_seller" value="1" {{ $product->best_seller ? 'checked' : '' }}><label for="best_seller" class="form-check-label">Best Seller</label></div>
                                                <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="editors_choice" id="editors_choice" value="1" {{ $product->editors_choice ? 'checked' : '' }}><label for="editors_choice" class="form-check-label">Editors Choice</label></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Canonical URL</label>
                                            <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url', $product->canonical_url) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Meta Keywords</label>
                                            <textarea name="meta_keywords" class="form-control" rows="3" placeholder="keyword1, keyword2...">{{ old('meta_keywords', $product->meta_keywords) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $product->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Active / Published</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr class="my-4">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-5">Update Product</button>
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

            // 🔴 ১. ক্যাটাগরি চেঞ্জ হলে বা প্রথমবার রেন্ডার হলে Ajax দিয়ে ডাইনামিক ফিল্ড পুশ করার লজিক
            let specIndex = {{ $product->specifications->count() > 0 ? $product->specifications->count() : 0 }};

            // আমরা অলরেডি সেভ করা ইনপুটগুলোর নাম ট্র‍্যাক রাখব যেন ডুপ্লিকেট না হয়
            function getExistingSpecNames() {
                let names = [];
                $('#spec-container .spec-row input[name$="[name]"]').each(function() {
                    names.push($(this).val().trim().toLowerCase());
                });
                return names;
            }

            $('#category_select_id').on('change', function() {
                let categoryIds = $(this).val();

                if(categoryIds && categoryIds.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.products.getFieldsByCategories') }}",
                        type: "GET",
                        data: { category_ids: categoryIds },
                        success: function(response) {
                            // নো-অ্যালার্ট মেসেজ থাকলে ক্লিয়ার করব
                            $('#no-cat-alert').remove();
                            let existingNames = getExistingSpecNames();

                            if(response.length > 0) {
                                $.each(response, function(index, field) {
                                    // যদি ফিল্ডের নাম অলরেডি এডিট স্ক্রিনে থাকে, তবে নতুন করে রো তৈরি করব না
                                    if($.inArray(field.name.toLowerCase().trim(), existingNames) == -1) {
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
                                    }
                                });
                            }
                        }
                    });
                }
            });

            // ২. ম্যানুয়ালি কাস্টম স্পেসিফিকেশন অ্যাড করার লজিক
            $('#add-spec-btn').click(function() {
                $('#no-cat-alert').remove();

                let html = `
                <div class="row g-2 mb-2 spec-row">
                    <div class="col-5"><input type="text" name="specs[${specIndex}][name]" class="form-control form-control-sm" placeholder="Specification Name"></div>
                    <div class="col-5"><input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value"></div>
                    <div class="col-2"><button type="button" class="btn btn-sm btn-danger remove-row w-100"><i class="ri-delete-bin-line"></i></button></div>
                </div>`;
                $('#spec-container').append(html);
                specIndex++;
            });

            // ৩. FORM VALIDATION LOGIC
            $("#productEditForm").validate({
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
            let faqIndex = {{ $product->faqs->count() > 0 ? $product->faqs->count() : 1 }};
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

            // ৬. রিমুভ বাটন লজিক (specs & faqs উভয়ের জন্য)
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
                $(this).valid();
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

    <!-- ১০. গ্যালারি ইমেজ ডিলেট করার Ajax লজিক -->
    <script>
        $(document).on('click', '.delete-gallery-img', function() {
            let imageId = $(this).data('id');
            let container = $('#gallery-img-' + imageId);
            let url = "{{ route('admin.product.deleteGalleryImage', ':id') }}".replace(':id', imageId);

            if (confirm('Are you sure you want to delete this gallery image permanently?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            container.fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        alert('Error: Could not delete the image.');
                    }
                });
            }
        });
    </script>
@endpush
