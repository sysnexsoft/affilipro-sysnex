@extends('backEnd.layout.master')

@section('title','Products')

@section('body')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Products</h4>

                <ol class="breadcrumb mb-0">
                    <a href="javascript:void(0)"
                       data-bs-toggle="modal"
                       data-bs-target="#addProduct"
                       class="btn btn-sm btn-primary">
                        Add Product
                    </a>
                </ol>
            </div>
        </div>
    </div>

    {{-- Add Product Modal --}}
    <div class="modal fade" id="addProduct">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <form action="{{ route('admin.product.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">
                        <h5>Add Product</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Product Name *</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Category *</label>
                                <select
                                    name="category_ids[]"
                                    class="form-select category-select"
                                    multiple>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Brand</label>

                                <select name="brand_id"
                                        class="form-select">

                                    <option value="">
                                        Select Brand
                                    </option>

                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Regular Price</label>

                                <input type="number"
                                       step="0.01"
                                       name="regular_price"
                                       class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Sale Price</label>

                                <input type="number"
                                       step="0.01"
                                       name="sale_price"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Affiliate URL *</label>

                                <input type="url"
                                       name="affiliate_url"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Affiliate Network</label>

                                <input type="text"
                                       name="affiliate_network"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Featured Image</label>

                                <input type="file"
                                       name="featured_image"
                                       class="form-control imageInput">
                            </div>

                            <div class="col-md-6 mb-3">
                                <img class="previewImage"
                                     style="max-height:100px;display:none;">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Short Description</label>

                                <textarea name="short_description"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" id="summernote" class="form-control summernote"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Pros</label>
                                <textarea name="pros" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Cons</label>

                                <textarea name="cons"
                                          rows="5"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <hr>
                                <h5>SEO Information</h5>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label>

                                <input type="text"
                                       name="meta_title"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>

                                <textarea name="meta_description"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Keywords</label>

                                <textarea name="meta_keywords"
                                          rows="2"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>
                                    <input type="checkbox"
                                           name="featured"
                                           value="1">
                                    Featured
                                </label>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>
                                    <input type="checkbox"
                                           name="trending"
                                           value="1">
                                    Trending
                                </label>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>
                                    <input type="checkbox"
                                           name="best_seller"
                                           value="1">
                                    Best Seller
                                </label>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Status</label>

                                <select name="status"
                                        class="form-select">

                                    <option value="1">
                                        Active
                                    </option>

                                    <option value="0">
                                        Inactive
                                    </option>

                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Save Product
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Product Table --}}

    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="mytable"
                               class="table table-bordered">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($products as $product)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <img src="{{ asset($product->featured_image) }}"
                                             width="60">
                                    </td>

                                    <td>
                                        {{ $product->title }}
                                    </td>

                                    <td>
                                        {{ $product->category->name ?? '' }}
                                    </td>

                                    <td>
                                        {{ $product->sale_price }}
                                    </td>

                                    <td>

                                        @if($product->status)
                                            <span class="badge bg-success">
                                            Active
                                        </span>
                                        @else
                                            <span class="badge bg-danger">
                                            Inactive
                                        </span>
                                        @endif

                                    </td>

                                    <td>

                                        <button
                                            class="btn btn-soft-primary btn-sm editBtn"
                                            data-id="{{ $product->id }}">
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-soft-danger btn-sm deleteBtn"
                                            data-id="{{ $product->id }}">
                                            Delete
                                        </button>

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

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
        // Snow theme
        var quill = new Quill('#snow-editor', {
            theme: 'snow',
            modules: {
                'toolbar': [[{ 'font': [] }, { 'size': [] }], ['bold', 'italic', 'underline', 'strike'], [{ 'color': [] }, { 'background': [] }], [{ 'script': 'super' }, { 'script': 'sub' }], [{ 'header': [false, 1, 2, 3, 4, 5, 6] }, 'blockquote', 'code-block'], [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }], ['direction', { 'align': [] }], ['link', 'image', 'video'], ['clean']]
            },
        });

        $('.category-select').select2({
            dropdownParent: $('#addProduct'),
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

    <script>

        function deleteProduct(id)
        {
            Swal.fire({

                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true

            }).then((result) => {

                if(result.isConfirmed)
                {
                    $.ajax({
                        url: "{{ route('admin.product.delete') }}",
                        type: "POST",

                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },

                        success:function(response)
                        {
                            location.reload();
                        }

                    });
                }

            });
        }

        $(document).on('click','.deleteBtn',function(){

            deleteProduct($(this).data('id'));

        });

    </script>

@endpush
