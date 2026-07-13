@extends('backEnd.layout.master')
@section('title', 'Edit Article')

@section('body')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Affiliate Product: {{ $product->title }}</h5>
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

                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm">
                        @csrf

                        <!-- 💡 Nav-tabs styled as custom steps -->
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
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Slug (Unique URL) *</label>
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
                                        </div>

                                        <!-- ⚡ Categories with Quick Add Button -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Categories (Dynamic Field Load) *</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <select name="category_ids[]" id="category_select_id" class="form-control category-select" multiple required style="width: 100%;">
                                                        @php
                                                            $selectedCategories = is_array($product->category_ids) ? $product->category_ids : json_decode($product->category_ids, true) ?? [];
                                                        @endphp
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickAddCategory" title="Quick Add Category" style="height: 38px;">
                                                    <i class="ri-add-fill"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- ⚡ Brand with Quick Add Button -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Brand</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <select name="brand_id" id="brand_select_id" class="form-control brand-select" style="width: 100%;">
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickAddBrand" title="Quick Add Brand" style="height: 38px;">
                                                    <i class="ri-add-fill"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- ⚡ SKU Code with Auto Generate Button -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">SKU Code</label>
                                            <div class="d-flex gap-1 align-items-center">
                                                <div class="flex-grow-1">
                                                    <input type="text" name="sku" id="sku_code" class="form-control" value="{{ old('sku', $product->sku) }}" placeholder="e.g., PROD-X89F2" autocomplete="off">
                                                </div>
                                                <button type="button" id="generate_sku_btn" class="btn btn-dark" title="Generate SKU" style="height: 38px;">
                                                    <i class="fa-solid fa-rotate me-1"></i> Generate
                                                </button>
                                            </div>
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

                                    <!-- Step 1 Footer -->
                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 2: PRICING & AFFILIATE -->
                                <div class="tab-pane fade" id="affiliate" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Regular Price</label>
                                            <input type="number" step="0.01" name="regular_price" class="form-control" value="{{ old('regular_price', $product->regular_price) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Sale Price</label>
                                            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Coupon</label>
                                            <input type="text" name="coupon" class="form-control" value="{{ old('coupon', $product->coupon) }}" placeholder="coupon code">
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

                                    <!-- Step 2 Footer -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 3: SPECS & FAQS -->
                                <div class="tab-pane fade" id="dynamic" role="tabpanel">
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
                                                            <button type="button" class="btn btn-sm btn-danger remove-row w-100">Remove</button>
                                                        </div>
                                                    </div>
                                                @empty
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

                                    <!-- Step 3 Footer -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="button" class="btn btn-primary next-step-btn px-4 fw-bold">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 4: SEO & FLAGS -->
                                <div class="tab-pane fade" id="seo" role="tabpanel">
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
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Target Countries / Geolocation</label>
                                            <select name="target_countries[]" class="form-control country-select" multiple required>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{-- ডাটাবেজে অ্যারে আছে কিনা এবং এই দেশের আইডিটি সেই অ্যারেতে আছে কিনা চেক করা হচ্ছে --}}
                                                            @if(is_array($product->target_countries) && in_array($country->id, $product->target_countries)) selected @endif>
                                                        {{ $country->name }} ({{ $country->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">এই অ্যাফিলিয়েট অফারটি কোন দেশের ভিজিটরদের জন্য প্রযোজ্য তা সিলেক্ট করুন।</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $product->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Active / Published</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 4 Footer (Final Update Button) -->
                                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-secondary prev-step-btn px-4 fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back</button>
                                        <button type="submit" class="btn btn-success px-5 fw-bold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Update Product</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 border-start border-4 border-primary">
        <h5 class="fw-bold text-slate-800 mb-3 border-bottom pb-2 d-flex align-items-center">
            <i class="ri-search-eye-line text-primary me-2"></i> Advanced SEO Management
        </h5>
        @php
            $seo = $product->seo ?? null;
        @endphp

        <form action="{{ route('admin.seo.update_page', [ 'service' => 'service' , 'id' => $seo->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ $seo->meta_title }}" placeholder="Enter SEO Meta Title">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3" placeholder="Enter SEO Meta Description String...">{{ $seo->meta_description }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Meta Keywords</label>
                    <textarea name="meta_keywords" class="form-control" rows="3" placeholder="Enter SEO Meta Keywords...">{{ $seo->meta_keywords }}</textarea>
                    <small class="text-danger">Comma separated keywords</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Canonical URL</label>
                    <input type="url" name="canonical_url" class="form-control" value="{{ $seo->canonical_url ?? '' }}" placeholder="https://example.com/custom-link">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Meta Robots Directive</label>
                    <select name="meta_robots" class="form-select">
                        <option value="index, follow" {{ ($seo->meta_robots ?? 'index, follow') == 'index, follow' ? 'selected' : '' }}>INDEX, FOLLOW (Default)</option>
                        <option value="noindex, nofollow" {{ ($seo->meta_robots ?? '') == 'noindex, nofollow' ? 'selected' : '' }}>NOINDEX, NOFOLLOW</option>
                        <option value="index, nofollow" {{ ($seo->meta_robots ?? '') == 'index, nofollow' ? 'selected' : '' }}>INDEX, NOFOLLOW</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700">Social Share Image (Meta Image)</label>
                    @if($seo && $seo->meta_image)
                        <div class="mb-2">
                            <img src="{{ asset($seo->meta_image) }}" class="img-thumbnail" style="max-height: 80px;">
                        </div>
                    @endif
                    <input type="file" name="meta_image" class="form-control">
                    <small class="text-muted">Recommended size: 1200x630px (OG Image Ratio)</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700 text-danger d-flex align-items-center">
                        <i class="ri-code-box-line me-1"></i> Structured Schema Script (LD+JSON)
                    </label>
                    <textarea name="schema_script" class="form-control text-monospace small" rows="20" style="font-family: monospace; font-size: 13px;" placeholder="<script type='application/ld+json'>\n...\n</script>">{{ $seo->schema_script ?? '' }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-slate-700 text-info d-flex align-items-center">
                        <i class="ri-braces-line me-1"></i> GTM DataLayer JSON
                    </label>
                    <textarea name="datalayer_json" class="form-control text-monospace small" rows="20" style="font-family: monospace; font-size: 13px;" placeholder="{ 'event': 'service_view', 'category': 'Cleaning' }">{{ $seo->datalayer_json ?? '' }}</textarea>
                </div>
            </div>
            <div class="p-3 text-end">
                <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3">Save Seo Configurations</button>
            </div>
        </form>

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

            // Next Step Button Click Logic
            $('.next-step-btn').on('click', function() {
                let currentTabPane = $(this).closest('.tab-pane');
                let form = $('#productEditForm');

                // শুধুমাত্র বর্তমান অ্যাক্টিভ ট্যাবের ইনপুটগুলোর ভ্যালিডেশন চেক হবে
                let isValid = true;
                currentTabPane.find('input, select, textarea').each(function() {
                    if (!form.validate().element($(this))) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    let currentActiveIdx = $('#productTab .nav-link').index($('#productTab .nav-link.active'));
                    if (currentActiveIdx < $('#productTab .nav-link').length - 1) {
                        $('#productTab .nav-link').eq(currentActiveIdx + 1).tab('show');
                        window.scrollTo(0, 0);
                    }
                }
            });

            // Previous (Back) Step Button Click Logic (Fix)
            $('.prev-step-btn').on('click', function() {
                let currentActiveIdx = $('#productTab .nav-link').index($('#productTab .nav-link.active'));
                if (currentActiveIdx > 0) {
                    $('#productTab .nav-link').eq(currentActiveIdx - 1).tab('show');
                    window.scrollTo(0, 0);
                }
            });

            // Prevent direct header tab clicks from bypassing validations
            $('.step-nav-btn').on('click', function(e) {
                let targetIdx = $('#productTab .nav-link').index($(this));
                let activeIdx = $('#productTab .nav-link').index($('#productTab .nav-link.active'));

                if (targetIdx > activeIdx) {
                    e.preventDefault();
                    e.stopPropagation();
                    // কারেন্ট পেজের নেক্সট বাটন ট্রিগার করে ভ্যালিডেশন রান করানো হবে
                    $('#productTabContent .tab-pane.active').find('.next-step-btn').click();
                    return false;
                }
            });


            // ==========================================
            // 🔴 DYNAMIC CATEGORY SPECIFICATIONS (AJAX)
            // ==========================================
            let specIndex = {{ $product->specifications->count() > 0 ? $product->specifications->count() : 0 }};

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
                            $('#no-cat-alert').remove();
                            let existingNames = getExistingSpecNames();

                            if(response.length > 0) {
                                $.each(response, function(index, field) {
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
                                                <button type="button" class="btn btn-sm btn-danger remove-row w-100">Remove</button>
                                            </div>
                                        </div>`;
                                        $('#spec-container').append(html);
                                        specIndex++;
                                    }
                                });
                            }
                        }
                    });
                } else {
                    $('#spec-container').html('<div class="text-muted small p-2" id="no-cat-alert">No specs assigned. Change categories or click below to add manually.</div>');
                }
            });

            // Manual Specification Addition
            $('#add-spec-btn').click(function() {
                $('#no-cat-alert').remove();

                let html = `
                <div class="row g-2 mb-2 spec-row">
                    <div class="col-5"><input type="text" name="specs[${specIndex}][name]" class="form-control form-control-sm" placeholder="Specification Name" required></div>
                    <div class="col-5"><input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Value" required></div>
                    <div class="col-2"><button type="button" class="btn btn-sm btn-danger remove-row w-100">Remove</button></div>
                </div>`;
                $('#spec-container').append(html);
                specIndex++;
            });


            // ==========================================
            // ⚙️ JQUERY VALIDATION & AUTO-SLUG LOGIC
            // ==========================================
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

            // Slug Generator
            $('#title').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
                $(this).valid();
            });


            // ==========================================
            // 💬 DYNAMIC FAQS & MISC PLUGINS
            // ==========================================
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

            // Row Removal Event Handler
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.spec-row, .faq-row').remove();
            });

            // Summernote Editor
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

            $('.category-select').select2({
                placeholder: 'Search Categories',
                width: '100%'
            }).on('change', function() {
                $(this).valid();
            });

            $('.brand-select').select2({
                placeholder: 'Search Brand',
                width: '100%'
            }).on('change', function() {
                $(this).valid();
            });

            $('.country-select').select2({
                placeholder: 'Search Country',
                width: '100%'
            }).on('change', function() {
                $(this).valid();
            });

            // Image Thumbnail Upload Preview
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

    <!-- 🗑️ GALLERY IMAGE ASYNC DELETION LOGIC -->
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
        $(document).ready(function() {

            // ==========================================
            // ⚡ PRODUCT NAME BASED SKU GENERATOR
            // ==========================================
            $('#generate_sku_btn').on('click', function() {
                let productName = $('#title').val() || '';

                if (productName.trim() === '') {
                    alert('Please enter the Product Title first to generate SKU!');
                    return;
                }

                // নাম থেকে স্পেস ও স্পেশাল ক্যারেক্টার বাদ দেওয়া
                let cleanName = productName.toUpperCase().replace(/[^A-Z0-9]/g, '');

                // নামের প্রথম ৪টি ক্যারেক্টার নেওয়া
                let namePrefix = cleanName.substring(0, 4);

                // ৪ ডিজিটের ইউনিক র‍্যান্ডম নাম্বার তৈরি
                let randomNumber = Math.floor(1000 + Math.random() * 9000);

                // ফাইনাল SKU তৈরি (যেমন: SMAR-4852)
                let generatedSku = namePrefix + '-' + randomNumber;

                // ইনপুটে ভ্যালু বসানো
                $('#sku_code').val(generatedSku);
            });
        });
    </script>
@endpush
