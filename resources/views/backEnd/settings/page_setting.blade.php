@extends('backEnd.layout.master')
@section('title','Page Settings')
@push('css')
    <!-- Summernote CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        /* সামারনোটের ব্যাকগ্রাউন্ড সাদা রাখার জন্য কাস্টম ফিক্স */
        .note-editable {
            background-color: #fff !important;
            color: #000 !important;
        }
    </style>
@endpush
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Page Settings</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Page Settings</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- সাকসেস মেসেজ অ্যালার্ট --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom-0 pb-0">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#affiliateLegal" role="tab">
                                Affiliate & Legal Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#generalPages" role="tab">
                                General Website Pages
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('admin.page_settings.update') }}" method="POST">
                        @csrf

                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="affiliateLegal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Affiliate Disclosure</label>
                                        <textarea name="affiliate_disclosure" rows="5" class="form-control summernote" placeholder="Example: As an Amazon Associate I earn from qualifying purchases...">{{ $setting->affiliate_disclosure ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Privacy Policy</label>
                                        <textarea name="privacy_policy" rows="5" class="form-control summernote">{{ $setting->privacy_policy ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Terms & Conditions</label>
                                        <textarea name="terms_conditions" rows="5" class="form-control summernote">{{ $setting->terms_conditions ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">General Disclosure</label>
                                        <textarea name="disclosure" rows="5" class="form-control summernote">{{ $setting->disclosure ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Disclaimer</label>
                                        <textarea name="disclaimer" rows="5" class="form-control summernote">{{ $setting->disclaimer ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="generalPages" role="tabpanel">
                                @php
                                    // ডাটাবেজের JSON ডেটাকে অ্যারেতে কনভার্ট করা (ডাটা না থাকলে ফাকা অ্যারে হবে)
                                    $about = is_array($setting->about_us) ? $setting->about_us : json_decode($setting->about_us, true) ?? [];
                                @endphp

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h5 class="text-primary fw-bold border-bottom pb-2"><i class="ri-slideshow-view"></i> 1. Hero Section</h5>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Eyebrow / Badge Text</label>
                                        <input type="text" name="about_hero_badge" class="form-control" value="{{ $about['hero_badge'] ?? 'Our Mission' }}">
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-semibold">Hero Main Title</label>
                                        <input type="text" name="about_hero_title" class="form-control" value="{{ $about['hero_title'] ?? 'Honest reviews you can actually trust' }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Hero Short Description</label>
                                        <textarea name="about_hero_desc" rows="3" class="form-control" placeholder="Write hero description...">{{ $about['hero_desc'] ?? '' }}</textarea>
                                    </div>

                                    <div class="col-12 mb-4 mt-3">
                                        <h5 class="text-primary fw-bold border-bottom pb-2"><i class="ri-bar-chart-box-line"></i> 2. Statistics Counter</h5>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Stat 1 (Value & Label)</label>
                                        <input type="text" name="about_stat1_val" class="form-control mb-2" placeholder="2.4M+" value="{{ $about['stat1_val'] ?? '' }}">
                                        <input type="text" name="about_stat1_lbl" class="form-control" placeholder="Monthly readers" value="{{ $about['stat1_lbl'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Stat 2 (Value & Label)</label>
                                        <input type="text" name="about_stat2_val" class="form-control mb-2" placeholder="5,000+" value="{{ $about['stat2_val'] ?? '' }}">
                                        <input type="text" name="about_stat2_lbl" class="form-control" placeholder="Products tested" value="{{ $about['stat2_lbl'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Stat 3 (Value & Label)</label>
                                        <input type="text" name="about_stat3_val" class="form-control mb-2" placeholder="30-pt" value="{{ $about['stat3_val'] ?? '' }}">
                                        <input type="text" name="about_stat3_lbl" class="form-control" placeholder="Testing rubric" value="{{ $about['stat3_lbl'] ?? '' }}">
                                    </div>

                                    <div class="col-12 mb-4 mt-3">
                                        <h5 class="text-primary fw-bold border-bottom pb-2"><i class="ri-shield-check-line"></i> 3. Editorial Integrity & Features</h5>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Section Heading</label>
                                        <input type="text" name="about_feat_title" class="form-control" value="{{ $about['feat_title'] ?? 'How We Maintain Editorial Integrity' }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-2 border rounded bg-light">
                                            <label class="form-label fw-bold text-dark">Feature 1</label>
                                            <input type="text" name="about_f1_title" class="form-control mb-2" placeholder="Title" value="{{ $about['f1_title'] ?? '' }}">
                                            <textarea name="about_f1_desc" rows="2" class="form-control" placeholder="Short description...">{{ $about['f1_desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-2 border rounded bg-light">
                                            <label class="form-label fw-bold text-dark">Feature 2</label>
                                            <input type="text" name="about_f2_title" class="form-control mb-2" placeholder="Title" value="{{ $about['f2_title'] ?? '' }}">
                                            <textarea name="about_f2_desc" rows="2" class="form-control" placeholder="Short description...">{{ $about['f2_desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-2 border rounded bg-light">
                                            <label class="form-label fw-bold text-dark">Feature 3</label>
                                            <input type="text" name="about_f3_title" class="form-control mb-2" placeholder="Title" value="{{ $about['f3_title'] ?? '' }}">
                                            <textarea name="about_f3_desc" rows="2" class="form-control" placeholder="Short description...">{{ $about['f3_desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4 mt-3">
                                        <h5 class="text-primary fw-bold border-bottom pb-2"><i class="ri-chat-quote-line"></i> 4. Author Statement / Quote</h5>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Quote Highlight Text</label>
                                        <textarea name="about_quote_text" rows="3" class="form-control" placeholder="Enter quote statement...">{{ $about['quote_text'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Author Name & Designation</label>
                                        <input type="text" name="about_quote_author" class="form-control" placeholder="e.g., Jonathan Doe - Editor-in-Chief" value="{{ $about['quote_author'] ?? '' }}">
                                    </div>

                                    <div class="col-12 mb-4 mt-4">
                                        <h5 class="text-danger fw-bold border-bottom pb-2"><i class="ri-file-list-3-line"></i> 5. Additional Legal Pages</h5>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Contact Information</label>
                                        <textarea name="contact_info" rows="4" class="form-control summernote">{{ $setting->contact_info ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Cookie Policy</label>
                                        <textarea name="cookie_policy" rows="4" class="form-control summernote">{{ $setting->cookie_policy ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save Page Settings
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            if ($('.summernote').length > 0) {
                $('.summernote').summernote({
                    height: 300,                 // এডিটরের উচ্চতা
                    minHeight: null,             // সর্বনিম্ন উচ্চতা
                    maxHeight: null,             // সর্বোচ্চ উচ্চতা
                    focus: false,                // লোড হওয়ার সাথে সাথে ফোকাস হবে কি না
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', ['underline', 'clear']]],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            }
        });
    </script>
@endpush
