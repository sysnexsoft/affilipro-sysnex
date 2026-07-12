@extends('backEnd.layout.master')
@section('title', 'Tune Page SEO - ' . $page->page_name)
@section('body')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('admin.seo.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="ri-arrow-left-line"></i> Back to Hub
            </a>
            <h4 class="fw-bold text-dark">Tune SEO: {{ $page->page_name }}</h4>
            <p class="text-muted small">Configure specific meta, scripts, and search engine directives for <code>/{{ $page->page_slug }}</code></p>
        </div>

        <form action="{{ route('admin.seo.update_page', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Title & Canonical -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Page Slug</label>
                            <input type="text" name="page_slug" class="form-control" value="{{ $page->page_slug }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $page->meta_title }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Canonical URL (Optional)</label>
                            <input type="url" name="canonical_url" class="form-control" value="{{ $page->canonical_url }}" placeholder="https://example.com/page">
                        </div>

                        <!-- Keywords & Robots -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ $page->meta_keywords }}" placeholder="service, dynamic, keywords">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Robot Directives</label>
                            <select name="meta_robots" class="form-select">
                                <option value="index, follow" {{ $page->meta_robots == 'index, follow' ? 'selected' : '' }}>Index, Follow (Recommended)</option>
                                <option value="noindex, nofollow" {{ $page->meta_robots == 'noindex, nofollow' ? 'selected' : '' }}>No-Index, No-Follow</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ $page->meta_description }}</textarea>
                        </div>

                        <!-- Image Share -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">OG / Social Image</label>
                            <input type="file" name="meta_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            @if($page->meta_image)
                                <img src="{{ asset($page->meta_image) }}" class="img-thumbnail" style="max-height: 90px;">
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Schema & DataLayer -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-danger">JSON-LD Schema Markup</label>
                            <textarea name="schema_script" class="form-control font-monospace fs-7 text-danger" rows="25" placeholder='<script type="application/ld+json">...</script>'>{{ $page->schema_script }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-primary">GTM DataLayer JSON</label>
                            <textarea name="datalayer_json" class="form-control font-monospace fs-7 text-primary" rows="25" placeholder='{ "pageType": "homepage" }'>{{ $page->datalayer_json }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light p-3 text-end border-top">
                    <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3">Save Page Configurations</button>
                </div>
            </div>
        </form>
    </div>
@endsection
