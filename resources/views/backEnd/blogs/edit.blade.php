@extends('backEnd.layout.master')
@section('title', 'Edit Blog Post')

@section('body')
    <div class="py-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Blog: {{ $blog->title }}</h5>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-light">Back to List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogEditForm">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Blog Title *</label>
                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $blog->title) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Slug *</label>
                            <input type="text" name="slug" id="slug" class="form-control" required value="{{ old('slug', $blog->slug) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category *</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $blog->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control imageInput" accept="image/*">
                            <div class="mt-2">
                                <img class="previewImage" src="{{ $blog->thumbnail ? asset($blog->thumbnail) : '' }}" style="max-height:90px; {{ $blog->thumbnail ? '' : 'display:none;' }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center gap-4 pt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ $blog->featured ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="featured">Featured</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $blog->status ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="status">Active</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description *</label>
                            <textarea name="description" class="form-control summernote" rows="6" required>{{ old('description', $blog->description) }}</textarea>
                        </div>

                        <!-- SEO SECTION -->
                        <div class="col-12"><hr class="my-3"><h5 class="text-secondary fw-bold">SEO Optimization</h5></div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $blog->meta_title) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Canonical URL</label>
                            <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url', $blog->canonical_url) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Meta Keywords</label>
                            <textarea name="meta_keywords" class="form-control" rows="2">{{ old('meta_keywords', $blog->meta_keywords) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">Update Blog</button>
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
            $('#title').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
                $('#slug').val(slug);
            });

            $('.imageInput').on('change', function () {
                let reader = new FileReader();
                reader.onload = function(e) { $('.previewImage').attr('src', e.target.result).show(); }
                reader.readAsDataURL(this.files[0]);
            });

            $('.summernote').summernote({ height: 350 });
            $("#blogEditForm").validate({ errorClass: "is-invalid", validClass: "is-valid" });
        });
    </script>
@endpush
