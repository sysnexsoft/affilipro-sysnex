@extends('backEnd.layout.master')
@section('title', 'Add Product')
@section('body')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                <h4>Add Product</h4>
                <a href="{{ route('admin.product.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Product Name *</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Category *</label>

                                    <select name="category_ids[]" class="form-select category-select" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Brand</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Regular Price</label>
                                    <input type="number" step="0.01" name="regular_price" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Sale Price</label>
                                    <input type="number" step="0.01" name="sale_price" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Affiliate URL *</label>
                                    <input type="url" name="affiliate_url" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Affiliate Network</label>
                                    <input type="text" name="affiliate_network" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Featured Image</label>
                                    <input type="file" name="featured_image" class="form-control imageInput">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <img class="previewImage" style="max-height:120px;display:none;">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Short Description</label>
                            <textarea name="short_description" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control summernote"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Pros</label>
                            <textarea name="pros" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Cons</label>
                            <textarea name="cons" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="card card-body border">
                            <div class="card-header">
                                <h5>SEO Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="col-md-6 mb-3">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" rows="3" class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Meta Keywords</label>
                                    <textarea name="meta_keywords" rows="2" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="featured" value="1">
                                <label class="form-check-label">
                                    Featured
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="trending" value="1">
                                <label class="form-check-label">Trending</label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="best_seller" value="1">
                                <label class="form-check-label">Best Seller</label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                            class="btn btn-primary">
                        Save Product
                    </button>
                </form>

            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        $('#addProduct').on('shown.bs.modal', function () {

            if (!$('.summernote').next().hasClass('note-editor')) {

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

        });
        $('#editProduct').on('shown.bs.modal', function () {

            if (!$('#edit_description').next().hasClass('note-editor')) {

                $('#edit_description').summernote({
                    height:300
                });

            }

        });
        // Snow theme
        var quill = new Quill('#snow-editor', {
            theme: 'snow',
            modules: {
                'toolbar': [[{ 'font': [] }, { 'size': [] }], ['bold', 'italic', 'underline', 'strike'], [{ 'color': [] }, { 'background': [] }], [{ 'script': 'super' }, { 'script': 'sub' }], [{ 'header': [false, 1, 2, 3, 4, 5, 6] }, 'blockquote', 'code-block'], [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }], ['direction', { 'align': [] }], ['link', 'image', 'video'], ['clean']]
            },
        });

        $('.category-select').select2({
            placeholder: 'Search Categories',
            width: '100%'
        });
    </script>
    <script>
        $('.imageInput').on('change', function () {
            let reader = new FileReader();
            let preview = $('.previewImage');
            reader.onload = function(e)
            {
                preview.attr('src', e.target.result);
                preview.show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>

@endpush
