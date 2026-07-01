@extends('backEnd.layout.master')
@section('title', 'SEO Management Hub')
@section('body')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark">SEO Management</h3>
                <p class="text-muted mb-0">Manage Technical SEO, Crawling Controls, Robots.txt, Tracking Pixels and Page Meta Snippets.</p>
            </div>
            <a href="{{ url('sitemap.xml') }}" target="_blank" class="btn btn-outline-primary fw-semibold"><i class="ri-node-tree"></i> Live Sitemap.xml</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-lg mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <!-- ডান পাশ: নতুন পেজ অ্যাড ফর্ম এবং পেজ-ভিত্তিক মেটা ও স্কিমা আর্কিটেকচার -->
            <div class="col-lg-12">
                <!-- ১. নতুন পেজ যুক্ত করার উইজেট (Add New Page Widget) -->
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-header bg-secondary text-white p-3 fw-bold rounded-top-4">
                        <i class="ri-add-circle-line"></i> Register New Custom Static Page
                    </div>
                    <!-- আপনার কন্ট্রোলারের স্টোর মেথডের রাউট নাম অনুযায়ী অ্যাডজাস্ট করে নেবেন -->
                    <form action="{{ route('admin.seo.store_page') }}" method="POST">
                        @csrf
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark mb-1">Page System Name</label>
                                    <input type="text" name="page_name" class="form-control form-control-sm" placeholder="e.g., Privacy Policy, FAQ" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark mb-1">Page Slug / URL</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light">/</span>
                                        <input type="text" name="page_slug" class="form-control font-monospace" placeholder="privacy-policy" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-2 text-end border-top">
                            <button type="submit" class="btn btn-sm btn-dark fw-bold px-3 rounded-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- বাম পাশ: গ্লোবাল সেটিংস এবং ট্র্যাকিং স্ক্রিপ্ট -->
            <div class="col-lg-7">
                <form action="{{ route('admin.seo.global_update') }}" method="POST">
                    @csrf
                    <div class="card border-0 shadow-lg rounded-4 mb-4">
                        <div class="card-header bg-secondary text-white p-3 fw-bold rounded-top-4">
                            <i class="ri-settings-5-line"></i> Global Crawling & Script Setup
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-danger">Robots.txt Content</label>
                                <textarea name="robots_txt" class="form-control font-monospace fs-7" rows="5">{{ $global->robots_txt }}</textarea>
                                <small class="text-muted">গুগল ক্রলারকে কন্ট্রোল করার টেক্সট। উদাহরণ: <code>User-agent: * <br>Disallow: /admin</code></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">Header Injector Scripts (GA4 / FB Pixel)</label>
                                <textarea name="header_scripts" class="form-control font-monospace fs-7" rows="4" placeholder="<script>... Analytics Script Here ...</script>">{{ $global->header_scripts }}</textarea>
                                <small class="text-muted">এখানে বসানো কোড সরাসরি সাইটের <code>&lt;head&gt;</code> ট্যাগে চলে যাবে।</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold text-secondary">Footer Injector Scripts</label>
                                <textarea name="footer_scripts" class="form-control font-monospace fs-7" rows="3" placeholder="Chatbot codes etc.">{{ $global->footer_scripts }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-3 text-end">
                            <button type="submit" class="btn btn-success fw-bold px-4">Update Engines</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="row">
            <!-- ২. আপনার মেইন মেটা আর্কিটেকচার টেবিল -->
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-secondary text-white p-3 fw-bold rounded-top-4">
                    <i class="ri-file-search-line"></i> Page-Specific Meta & Schema Architecture
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-4">Page Target</th>
                                <th>Slug Mapping</th>
                                <th>Index Target</th>
                                <th class="text-center pe-4">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">
                                            {{ $page->page_name }}
                                            @if($page->model_type)
                                                <span class="badge bg-info-subtle text-info sm-badge" style="font-size: 10px;">Dynamic</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary sm-badge" style="font-size: 10px;">Static</span>
                                            @endif
                                        </div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 250px;">
                                            {{ $page->meta_title ?? 'Title not set yet' }}
                                        </small>
                                    </td>
                                    <td>
                                            <span class="badge bg-light text-dark font-monospace">
                                                /{{ $page->page_slug ?? $page->seoable?->slug ?? 'dynamic-route' }}
                                            </span>
                                    </td>
                                    <td>
                                            <span class="badge {{ $page->meta_robots == 'index, follow' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                {{ $page->meta_robots }}
                                            </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('admin.seo.edit_page', $page->id) }}" class="btn btn-sm btn-primary rounded-2 px-3 fw-semibold">
                                            <i class="ri-edit-line"></i> Tune SEO
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{$pages->links('backEnd.layout.paginate')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
